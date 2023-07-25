<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TourPaystackController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
        if(Session::has('tourBook')){
            $book = Session::get('tourBook');
            if($book['tour']['author_id'] == $user->id && $book['tour']['author_type'] == 'user'){
                return back()->with('error','This is your Tour');
            }
        }else{
            return view('errors.404');
        }

        // space Order data store..............//
        $order = new Order();
        $order['order_type'] = 'Tour';
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
        
        if(!empty($book['fac_price'])){
            $order['extra_price'] = implode(',', $book['fac_price']) ;
            $order['extra_name'] = implode(',', $book['fac_name']) ;
            $order['extra_type'] = implode(',', $book['fac_type']) ;
        }
        if(!empty($book['person_type'])){
            $order['person_type'] = implode(',', $book['person_type']) ;
            $order['person_price'] = implode(',', $book['person_price']);
        }

        $order['author_id'] = $book['tour']['author_id'];
        $order['author_type'] = $book['tour']['author_type'];

        $curr = Currency::where('name',$request->currency_code)->first();
        $order['currency_code'] = $curr->name;
        $order['currency_value'] = $curr->value;
        $order['currency_sign'] = $curr->sign;
        
        $order['total'] = $book['total'];
        $order['item_id'] = $book['tour']['id'];
        $order['method'] = 'Stripe';
        $order['order_number'] = Str::random(4).time();
        $order['payment_status'] = "Completed";
        $order['order_status'] = "Pending";

        $order['txnid'] = $request->ref_id;
        $order['user_id'] = Auth::user()->id;
         
        $order->save();

        // email and notification 
        BookingMail::Booking($order->id,'Tour',$book['total'],$order->order_number,$request->name,$request->email);
        OrderHelper::vendorOrder($book,'tour');

        // redirect call section //
        Session::forget('tourBook');
     
        return redirect(route('front.success'));
    
        } catch (\Throwable $th) {
            return back()->with('error', __('Payment Failed.'));
        }
    }
}


