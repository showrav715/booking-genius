<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\{
    Models\Order,
    Models\PaymentGateway
};
use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Models\Currency;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Helpers\PriceHelper;
use App\Models\HotelOrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class HotelPaypalController extends Controller
{
    public $gateway;
    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('paypal')->first();
        $paydata = $data->convertAutoData();
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId($paydata['client_id']);
        $this->gateway->setSecret($paydata['client_secret']);
        $this->gateway->setTestMode(true);
    }


    public function store(Request $request)
    {

        $user = Auth::user();
        if (Session::has('book')) {
            $book = Session::get('book');

            if ($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user') {
                return back()->with('error', 'This is your Hotel');
            }
        } else {
            return view('errors.404');
        }

        $request->validate([
            'country'  => 'required',
            'state' => 'required',
            'city'  => 'required',
            'address'  => 'required',
            'number'  => 'required',
            'email'  => 'required',
            'name'  => 'required',
        ]);


        $supported = [
            'AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF',
            'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK',
            'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD',
        ];


        if (!in_array($request->currency_code, $supported)) {
            return redirect()->route('hotel.checkout')->with('error', 'This currency not supported paypal checkout');
        }


        if (!$user) {
            Session::put('url', route('hotel.checkout'));
            return redirect(route('user.login'));
        }

        $notify_url = route('hotel.paypal.notify');
        $cancel_url = route('hotel.checkout');

        try {
            $response = $this->gateway->purchase(array(
                'amount' => (string)round($book['total'], 2),
                'currency' => $request->currency_code,
                'returnUrl' => $notify_url,
                'cancelUrl' => $cancel_url,
            ))->send();

            if ($response->isRedirect()) {

                Session::put('input_data', $request->all());
                if ($response->redirect()) {
                    return redirect($response->redirect());
                }
            } else {
                return redirect()->back()->with('unsuccess', $response->getMessage());
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('unsuccess', $response->getMessage());
        }
    }

    public function notify(Request $request)
    {

        $responseData = $request->all();

        if (empty($responseData['PayerID']) || empty($responseData['token'])) {
            return [
                'status' => false,
                'message' => __('Unknown error occurred'),
            ];
        }
        $transaction = $this->gateway->completePurchase(array(
            'payer_id' => $responseData['PayerID'],
            'transactionReference' => $responseData['paymentId'],
        ));

        $response = $transaction->send();

        if ($response->isSuccessful()) {

            if (Session::has('book')) {
                $book = Session::get('book');
            }

            $input = Session::get('input_data');

                $order = new Order;
                $order['order_type'] = 'Hotel';
                $order['email'] = $input['email'];
                $order['name'] = $input['name'];;
                $order['number'] = $input['number'];;
                $order['address'] = $input['address'];;
                $order['city'] = $input['city'];;
                $order['state'] = $input['state'];;
                $order['country'] = $input['country'];;
                $order['zip_code'] = $input['zip_code'];;
                $order['summery'] = $input['summery'];;
                $order['start_date'] = $book['start_date'];
                $order['end_date'] = $book['end_date'];
                $order['night'] = $book['night'];
                $order['adult'] = $book['adult'];
                $order['children'] = $book['children'];


                if (!empty($book['fac_price'])) {
                    $order['extra_price'] = implode(',', $book['fac_price']);
                    $order['extra_name'] = implode(',', $book['fac_name']);
                    $order['extra_type'] = implode(',', $book['fac_type']);
                }


                $curr = Currency::where('name', $input['currency_code'])->first();
                $order['currency_code'] = $curr->name;
                $order['currency_value'] = $curr->value;
                $order['currency_sign'] = $curr->sign;

                $order['service_charge'] = PriceHelper::storePrice($book['service_fee']);
                $order['total'] = $book['total'];
                $order['item_id'] = $book['hotel']['id'];
                $order['method'] = 'Paypal';
                $order['order_number'] = Str::random(4) . time();
                $order['payment_status'] = "Complete";
                $order['order_status'] = "Pending";
                $order['currency_code'] = $curr->name;
                $order['currency_value'] = $curr->value;
                $order['currency_sign'] = $curr->sign;
                $order['txnid'] = $response->getData()['transactions'][0]['related_resources'][0]['sale']['id'];
                $order['charge_id'] = '';
                $order['user_id'] = Auth::user()->id;
                $order['author_id'] = $book['hotel']['author_id'];
                $order['author_type'] = $book['hotel']['author_type'];

                $order->save();


                // order item data insert

                $id = $order->id;
                foreach ($book['rooms'] as $key => $room) {
                    $in['user_id'] = Auth::user()->id;
                    $in['order_id'] = $id;
                    $in['hotel_id'] = $book['hotel']['id'];
                    $in['room_id'] = $room->id;
                    $in['room_name'] = $room->room_name;
                    $in['room_qty'] = $book['room_qty'][$key];
                    $in['square_fit'] = $room->square_fit;
                    $in['bed'] = $room->bed;
                    $in['per_night_cost'] = $room->per_night_cost;

                    $item = new HotelOrderItem();
                    $item->create($in);
                }


                // email and notification 
                BookingMail::Booking($order->id, 'Hotel', $book['total'], $order->order_number, $input['name'], $input['email']);
                OrderHelper::vendorOrder($book, 'hotel');

                Session::forget('book');
                return redirect(route('front.success'));
        
        }

        Session::flash('error', 'Payment Faield');
        return redirect(route('hotel.checkout'));
    }
}
