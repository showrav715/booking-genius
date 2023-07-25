<?php

namespace App\Http\Controllers\Payment;

use App\{
    Models\Order,
    Models\PaymentGateway,
};
use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class SpaceRezorpayController extends Controller
{
    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('Razorpay')->first();
        $paydata = $data->convertAutoData();
        $this->keyId = $paydata['key'];
        $this->keySecret = $paydata['secret'];
        $this->displayCurrency = 'INR';
        $this->api = new Api($this->keyId, $this->keySecret);
    }

    public function store(Request $request)
    {
       
        $user = Auth::user();
        if(Session::has('spaceBook')){
            $book = Session::get('spaceBook');
            
            if($book['space']['author_id'] == $user->id && $book['space']['author_type'] == 'user'){
                return back()->with('error','This is your Space');
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

        $title = 'Space Order';

        $supported = [
            'INR',
        ];


        if(!in_array($request->currency_code,$supported)){
            return redirect()->route('space.checkout')->with('error','This currency not supported Rezorpay checkout');
        }

   
        if(!$user){
            Session::put('url',route('space.checkout'));
            return redirect(route('user.login'));
        }

        $gs = Generalsetting::first();
        $order['item_name'] = $gs->website_title. " Order";
        $order['item_number'] = Str::random(4).time();
        
        $cancel_url = route('space.checkout');
        $notify_url = route('space.rezorpay.notify');

        $orderData = [
            'receipt'         => $order['item_number'],
            'amount'          => PriceHelper::showPrice($book['total']) * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
       
        Session::put('order_data',$order);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'];
                    
        if ($this->displayCurrency !== 'INR')
        {
            $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
            $exchange = json_decode(file_get_contents($url), true);
        
            $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
        }
        
        $checkout = 'automatic';
        
        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
        {
            $checkout = $_GET['checkout'];
        }
        
        $data = [
            "key"               => $this->keyId,
            "amount"            => $amount,
            "name"              => $order['item_name'],
            "description"       => $order['item_name'],
            "prefill"           => [
                "name"              => $request->name,
                "email"             => $request->email,
                "contact"           => $request->number,
            ],
            "notes"             => [
                "address"           => $request->address,
                "merchant_order_id" => $order['item_number'],
            ],
            "theme"             => [
                "color"             => ""
            ],
            "order_id"          => $razorpayOrder['id'],
        ];
        
        if ($this->displayCurrency !== 'INR')
        {
            $data['display_currency']  = $this->displayCurrency;
            $data['display_amount']    = $displayAmount;
        }
        
        $json = json_encode($data);
        $displayCurrency = $this->displayCurrency;
        Session::put('input_data',$request->all());
        return view( 'front.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
    }

    public function notify(Request $request)
    {
        $book = Session::get('spaceBook');
        $cancel_url = route('space.checkout');
        $input_data = $request->all();
        $input = Session::get('input_data');
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        $success = true;

        if (empty($input_data['razorpay_payment_id']) === false)
        {
            try
            {
                $attributes = array(
                    'razorpay_order_id' => $payment_id,
                    'razorpay_payment_id' => $input_data['razorpay_payment_id'],
                    'razorpay_signature' => $input_data['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
            }
        }

        if ($success === true){
            $order = new Order; 
            $order['order_type'] = 'Space';
            $order['email'] = $input['email'];
            $order['name'] = $input['name'];
            $order['number'] = $input['number'];
            $order['address'] = $input['address'];
            $order['city'] = $input['city'];
            $order['state'] = $input['state'];
            $order['country'] = $input['country'];
            $order['zip_code'] = $input['zip_code'];
            $order['summery'] = $input['summery'];
            $order['start_date'] = $book['start_date'];
            $order['end_date'] = $book['end_date'];
            $order['night'] = $book['night'];
          
            if(!empty($book['fac_price'])){
                $order['extra_price'] = implode(',', $book['fac_price']) ;
                $order['extra_name'] = implode(',', $book['fac_name']) ;
                $order['extra_type'] = implode(',', $book['fac_type']) ;
            }

            $order['author_id'] = $book['space']['author_id'];
            $order['author_type'] = $book['space']['author_type'];
            
            $curr = Currency::where('name',$input['currency_code'])->first();
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
            $order['total'] = $book['total'];
            $order['item_id'] = $book['space']['id'];
            $order['method'] = 'Paypal';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Completed";
            $order['order_status'] = "Pending";
            $order['txnid'] =  $input_data['razorpay_payment_id'];
            $order['charge_id'] = '';
            $order['user_id'] = Auth::user()->id;


            $order->save();

           // email and notification 
           BookingMail::Booking($order->id,'Space',$book['total'],$order->order_number,$input['name'],$input['email']);
           OrderHelper::vendorOrder($book,'space');

            Session::forget('spaceBook');
            return redirect(route('front.success'));
           
        }
        return redirect($cancel_url);
    }

}