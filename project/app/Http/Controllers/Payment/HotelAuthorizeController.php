<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\HotelOrderItem;
use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Session;
use Illuminate\Support\Str;
use Auth;

class HotelAuthorizeController extends Controller
{
    public function store(Request $request)
    {
        
         $supported = [
            'USD'
        ];
        if(!in_array($request->currency_code,$supported)){
            return redirect()->back()->with('error','This currency not supported authorize.net checkout');
        }
        
        $data = PaymentGateway::whereKeyword('Authorize')->first();
        
        $user = Auth::user();
        if(Session::has('book')){
            $book = Session::get('book');
            
            if($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user'){
                return back()->with('error','This is your Hotel');
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

      
            $item_name = 'Hotel Order';
            $item_number = Str::random(4).time();


        // Validate Card Data

        $validator = \Validator::make($request->all(),[
            'cardNumber' => 'required',
            'cardCVC' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);
        
        
     
        if ($validator->passes()) {
         
            $paydata = $data->convertAutoData();

            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($paydata['login_id']);
            $merchantAuthentication->setTransactionKey($paydata['txn_key']);

            // Set the transaction's refId
            $refId = 'ref' . time();
       
            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($request->cardNumber);
            $year = $request->year;
            $month = $request->month;
            $creditCard->setExpirationDate($year.'-'.$month);
            $creditCard->setCardCode($request->cardCVC);

            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);
        
            // Create order information
            $orderr = new AnetAPI\OrderType();
            $orderr->setInvoiceNumber($item_number);
            $orderr->setDescription($item_name);

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction"); 
            $transactionRequestType->setAmount($book['total']);
            $transactionRequestType->setOrder($orderr);
            $transactionRequestType->setPayment($paymentOne);
            // Assemble the complete transaction request
            $requestt = new AnetAPI\CreateTransactionRequest();
            $requestt->setMerchantAuthentication($merchantAuthentication);
            $requestt->setRefId($refId);
            $requestt->setTransactionRequest($transactionRequestType);
              
            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController($requestt);
            if($paydata['sandbox_check'] == 1){
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }
            else {
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);                
            }

              
            if ($response != null) {
        
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();
                 
         if ($tresponse != null && $tresponse->getMessages()) {
               
            // Hotel Order data store..............//
            $order = new Order();

        
            $order['order_type'] = 'Hotel';
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
            $order['adult'] = $book['adult'];
            $order['children'] = $book['children'];

          
            if(!empty($book['fac_price'])){
                $order['extra_price'] = implode(',', $book['fac_price']) ;
                $order['extra_name'] = implode(',', $book['fac_name']) ;
                $order['extra_type'] = implode(',', $book['fac_type']) ;
            }


            $curr = Currency::where('name',$request->currency_code)->first();
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
         
            $order['service_charge'] = PriceHelper::storePrice($book['service_fee']);
            $order['total'] = $book['total'];
            $order['item_id'] = $book['hotel']['id'];
            $order['method'] = 'Authorize.net';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Complete";
            $order['order_status'] = "Pending";
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
            $order['txnid'] = $tresponse->getTransId();
            $order['charge_id'] = '';
            $order['user_id'] = Auth::user()->id;
            $order['author_id'] = $book['hotel']['author_id'];
            $order['author_type'] = $book['hotel']['author_type'];
             
            $order->save();

            $id = $order->id;
            foreach($book['rooms'] as $key => $room){
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
            BookingMail::Booking($order->id,'Hotel',$book['total'],$order->order_number,$request->name,$request->email);
            OrderHelper::vendorOrder($book,'hotel');


            Session::forget('book');    
            return redirect(route('front.success'));


            
        
            } else {
                return back()->with('error', __('Payment Failed.'));
            }
        // Or, print errors if the API request wasn't successful
        } else {
            return back()->with('error', __('Payment Failed.'));
        }      
    } else {
        return back()->with('error', __('Payment Failed.'));
    }

}
        return back()->with('error', __('Invalid Payment Details.'));
    }
}