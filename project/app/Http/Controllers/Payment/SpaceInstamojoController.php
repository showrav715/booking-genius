<?php

namespace App\Http\Controllers\Payment;

use App\{
    Models\Order,
    Classes\Instamojo,
    Models\PaymentGateway
};
use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SpaceInstamojoController extends Controller
{

    public function store(Request $request)
    {

        $user = Auth::user();
        if(Session::has('spaceBook')){
            $book = Session::get('spaceBook');
            
            if($book['space']['author_id'] == $user->id && $book['space']['author_type'] == 'user'){
                return back()->with('error',__('This is your Space'));
            }
        }else{
            return view('errors.404');
        }

        if($request->currency_code != "INR")
        {
            Session::flash('error',__('Please Select INR Currency For This Payment.'));
            return back();
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


        if(!Auth::user()){
          Session::put('url',route('space.checkout'));
            return redirect(route('user.login'));
        }

      
        $data = PaymentGateway::whereKeyword('instamojo')->first();
        $paydata = $data->convertAutoData();
       
        $order['item_name'] = 'Space Order';
        $order['item_amount'] = PriceHelper::showPrice($book['total']);

        $input = $request->all();
   
        if($paydata['sandbox_check'] == 1){
        $api = new Instamojo($paydata['key'], $paydata['token'], 'https://test.instamojo.com/api/1.1/');
        }
        else {
        $api = new Instamojo($paydata['key'], $paydata['token']);
        }

        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => $order['item_name'],
                "amount" => $order['item_amount'],
                "send_email" => false,
                "email" => $request->email,
                "redirect_url" => route('space.instamojo.notify'),
            ));
            // return 'ok';
            
            
            $redirect_url = $response['longurl'];
            
        /** add payment ID to session **/
        Session::put('input_data',$input);
        Session::put('order_data',$order);
        Session::put('order_payment_id', $response['id']);

        return redirect($redirect_url);

        }
        catch (Exception $e) {
            return back()->with('error','Error: ' . $e->getMessage());
        }
    }

    public function notify(Request $request)
    {
        if(Session::has('spaceBook')){
            $book = Session::get('spaceBook'); 
        }
    
        $input = Session::get('input_data');
        $payment_id = Session::get('order_payment_id');
      
        if($request['payment_status'] == 'Failed'){
            Session::flash('error','Payment Failed');
            return redirect()->route('space.checkout');
        }

        if ($request['payment_request_id'] == $payment_id) {
    
        // Space Order data store..............//
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
            
       
            $order['total'] = $book['total'];
            $order['item_id'] = $book['space']['id'];
            $order['method'] = 'Instamojo';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Completed";
            $order['order_status'] = "Pending";
            $curr = Currency::where('name',$input['currency_code'])->first();
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
            $order['txnid'] = $request['payment_id'];
            $order['charge_id'] = '';
            $order['user_id'] = Auth::user()->id;

            $order->save();

            // email and notification 
            BookingMail::Booking($order->id,'Space',$book['total'],$order->order_number,$input['name'],$input['email']);
            OrderHelper::vendorOrder($book,'space');

            Session::forget('spaceBook');
            return redirect(route('front.success'));

        }
   
}


}