<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CarMollieController extends Controller
{
    public $curr;

    public function __construct()
    {
        if (Session::has('currency')) 
        {
        $this->curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $this->curr = Currency::where('is_default','=',1)->first();
        }
    }

public function store(Request $request){

   
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
        'AUD','BRL','CAD','CNY','CZK','DKK','EUR','HKD','HUF',
        'ILS','JPY','MYR','MXN','TWD','NZD','NOK',
        'PHP','PLN','GBP','RUB','SGD','SEK','CHF','THB','USD',
    ];

    if(!in_array($request->currency_code,$supported)){
        return redirect()->route('car.checkout')->with('error','This currency not supported paypal checkout');
    }

    if(!$user){
        Session::put('url',route('car.checkout'));
        return redirect(route('user.login'));
    }

    $notify_url = route('car.mollie.notify');
    $cancel_url = route('car.checkout');

    $input = $request->all();
 
    $settings = Generalsetting::findOrFail(1);
    $order['item_name'] = $settings->title." Order";
    $order['item_number'] = Str::random(4).time();
    $order['item_amount'] = $book['total'];
    $data['return_url'] = $notify_url;
    $data['cancel_url'] = $cancel_url;

    $payment = Mollie::api()->payments()->create([
        'amount' => [
            'currency' => $request->currency_code,
            'value' => ''.sprintf('%0.2f', $book['total']).'',
        ],
        'description' => $order['item_name'] ,
        'redirectUrl' => route('car.mollie.notify'),
        ]);

    Session::put('mollie_input',$input);
    Session::put('mollie_orders',$data);
    Session::put('order_payment_id', $payment->id);
    $payment = Mollie::api()->payments()->get($payment->id);

    return redirect($payment->getCheckoutUrl(), 303);
 }



public function notify(Request $request){

    $payment = Mollie::api()->payments()->get(Session::get('order_payment_id'));
    $input = Session::get('mollie_input');
   
    if($payment->status == 'paid'){

        if(Session::has('carBook')){
            $book = Session::get('carBook'); 
        }

        $order = new Order;
     
        $order['order_type'] = 'Car';
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
             $order['qty'] = $book['qty'];
             
 
             if(!empty($book['fac_price'])){
              
                 $order['extra_price'] = implode(',', $book['fac_price']) ;
                 $order['extra_name'] = implode(',', $book['fac_name']) ;
                 $order['extra_type'] = implode(',', $book['fac_type']) ;
             }
 
          
             if(!empty($book['person_type'])){
 
                 $order['person_type'] = implode(',', $book['person_type']) ;
                 $order['person_price'] = implode(',', $book['person_price']);
             }
 
             $order['author_id'] = $book['car']['author_id'];
             $order['author_type'] = $book['car']['author_type'];
             $curr = Currency::where('name',$input['currency_code'])->first();
             $order['currency_code'] = $curr->name;
             $order['currency_value'] = $curr->value;
             $order['currency_sign'] = $curr->sign;
         
             $order['total'] = $book['total'];
             $order['item_id'] = $book['car']['id'];
             $order['method'] = 'Paypal';
             $order['order_number'] = Str::random(4).time();
             $order['payment_status'] = "Complete";
             $order['order_status'] = "Pending";
      
             $order['txnid'] = $payment->id;
             $order['charge_id'] = '';
             $order['user_id'] = Auth::user()->id;
             $order->save();

            OrderHelper::vendorOrder($book,'car');

            // email and notification 
            BookingMail::Booking($order->id,'Car',$book['total'],$order->order_number,$input['name'],$input['email']);



             Session::forget('carBook');
             return redirect(route('front.success'));
                            
            }else{
                Session::flash('error','Payment Faield');
                return redirect(route('car.checkout'));
            }
        }



}
