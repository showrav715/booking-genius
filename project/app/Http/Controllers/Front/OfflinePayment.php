<?php

namespace App\Http\Controllers\Front;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\HotelOrderItem;
use Session;
use Auth;

class OfflinePayment extends Controller
{
    public function store(Request $request)
    {

            $request->validate([
                'country'  => 'required',
                'state' => 'required',
                'city'  => 'required',
                'address'  => 'required',
                'number'  => 'required',
                'email'  => 'required',
                'name'  => 'required',
            ]);


        $user = Auth::user();
        if(Session::has('book')){
            $book = Session::get('book');
            if($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user'){
                return back()->with('error','This is your Hotel');
            }
        }else{
            return view('errors.404');
        }

        OrderHelper::vendorOrder($book,'hotel');

        if(!$request->transaction_id){
            return back()->with('error','Please enter your payment transaction id');
        }

        if(!Auth::user()){
            Session::put('url',route('hotel.checkout'));
            return redirect(route('user.login'));
        }

      
    // Hotel Order data store..............//
        $order = new Order;

        
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
            $order['method'] = $request->method;
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Pending";
            $order['order_status'] = "Pending";
            $order['txnid'] = $request->transaction_id;
            $order['charge_id'] = '';
            $order['user_id'] = Auth::user()->id;
            $order['author_id'] = $book['hotel']['author_id'];
            $order['author_type'] = $book['hotel']['author_type'];
             
            $order->save();

            // order data insert end //

            // order item data insert

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

                $item = new HotelOrderItem;
                $item->create($in);
            }

            // order item data insert end //
            
        
            // email and notification 
            BookingMail::Booking($order->id,'Hotel',$book['total'],$order->order_number,$request->name,$request->email);

             // redirect call section //

             Session::forget('book');
                 
             return view('front.success');
    }

    

}
