<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CarPaystackController extends Controller
{
    public function store(Request $request)
    {
    
        try {
            $user = Auth::user();
        if(Session::has('carBook')){
            $book = Session::get('carBook');
            if($book['car']['author_id'] == $user->id && $book['car']['author_type'] == 'user'){
                return back()->with('error','This is your Car');
            }
        }else{
            return view('errors.404');
        }

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
            $order['author_id'] = $book['car']['author_id'];
            $order['author_type'] = $book['car']['author_type'];
      

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
            $order['method'] = 'Paystack';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Completed";
            $order['order_status'] = "Pending";

            $order['txnid'] = $request->ref_id;
            $order['user_id'] = Auth::user()->id;
             
            $order->save();
         
     
        OrderHelper::vendorOrder($book,'car');

        // email and notification 
        BookingMail::Booking($order->id,'Car',$book['total'],$order->order_number,$request->name,$request->email);

        Session::forget('carBook');    
        return redirect(route('front.success'));
    
        } catch (\Throwable $th) {
            return back()->with('error', __('Payment Failed.'));
        }
    }
}


