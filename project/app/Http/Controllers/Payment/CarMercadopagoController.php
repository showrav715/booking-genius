<?php

namespace App\Http\Controllers\Payment;
use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use MercadoPago;

class CarMercadopagoController extends Controller
{
    public function store(Request $request)
    {
        $data = PaymentGateway::whereKeyword('Mercadopago')->first();
        $paydata = $data->convertAutoData();

        $user = Auth::user();
        if(Session::has('carBook')){
            $book = Session::get('carBook');
            
            if($book['car']['author_id'] == $user->id && $book['car']['author_type'] == 'user'){
                return back()->with('error','This is your Car');
            }
        }else{
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
            'BRL','USD',
        ];

        if(!in_array($request->currency_code,$supported)){
            return redirect()->route('car.checkout')->with('error','This currency not supported paypal checkout');
        }

        if(!$user){
            Session::put('url',route('car.checkout'));
            return redirect(route('user.login'));
        }

        $cancel_url = route('car.checkout');

        MercadoPago\SDK::setAccessToken($paydata['token']);
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = (string)round($book['total'],2);
        $payment->token = $request->token;
        $payment->description = 'Mercadopago Order';
        $payment->installments = 1;
        $payment->payer = array(
          "email" => $request->email,
        );

        $payment->save();

        if ($payment->status == 'approved') {

            try {
            $order = new Order();
            $order['order_type'] = 'Car';
            $order['email'] = $request->email;
            $order['name'] = $request->name;
            $order['number'] = $request->number;
            $order['address'] = $request->address;
            $order['city'] = $request->city;
            $order['state'] = $request->state;
            $order['country'] = $request->country;
            $order['zip_code'] = $request->zip_code;
            $order['summery'] = $request->summery;
            $order['start_date'] = $book['start_date'];
            $order['end_date'] = $book['end_date'];
            $order['night'] = $book['night'];
            $order['qty'] = $book['qty'];

            if(!empty($book['fac_price'])){
                $order['extra_price'] = implode(',', $book['fac_price']) ;
                $order['extra_name'] = implode(',', $book['fac_name']) ;
                $order['extra_type'] = implode(',', $book['fac_type']) ;
            }
            $curr = Currency::where('name',$request->currency_code)->first();
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
            $order['total'] = $book['total'];
            $order['item_id'] = $book['car']['id'];
            $order['author_id'] = $book['car']['author_id'];
            $order['author_type'] = $book['car']['author_type'];
            $order['method'] = 'Mercadopago';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Pending";
            $order['order_status'] = "Pending";
            $order['txnid'] = $request->transaction_id;
            $order['charge_id'] = '';
            $user = Auth::user();
            $order['user_id'] = $user->id;
       
            $order->save();

            // order data insert end //
            OrderHelper::vendorOrder($book,'car');
            // email and notification 
            BookingMail::Booking($order->id,'Car',$book['total'],$order->order_number,$request->name,$request->email);

            // redirect call section //
            Session::forget('carBook');
                 
             return redirect(route('front.success'));

            } catch (\Throwable $th) {
                Session::flash('error','Payment Faield');
                return redirect($cancel_url);
            }
        } 
        Session::flash('error','Payment Faield');
        return redirect($cancel_url);
    }

}