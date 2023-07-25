<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Session;
use Illuminate\Support\Str;
use Auth;

class CarAuthorizeController extends Controller
{
    public function store(Request $request)
    {
        $data = PaymentGateway::whereKeyword('Authorize')->first();

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

      
            $item_name = 'Car Order';
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
                
                    if ($tresponse != null && $tresponse->getMessages() != null) {

                       // Car Order data store..............//
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
            $order['method'] = 'Authorize.net';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Pending";
            $order['order_status'] = "Pending";
    
            $order['txnid'] = $tresponse->getTransId();
            $order['charge_id'] = '';
            $order['user_id'] = Auth::user()->id;
             
            $order->save();

            OrderHelper::vendorOrder($book,'car');

            // email and notification 
            BookingMail::Booking($order->id,'Car',$book['total'],$order->order_number,$request->name,$request->email);

            Session::forget('carBook');    
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