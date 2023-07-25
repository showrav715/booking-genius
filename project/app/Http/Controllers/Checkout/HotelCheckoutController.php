<?php

namespace App\Http\Controllers\Checkout;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use Illuminate\Http\Request;
use App\Models\HotelRoom;
use App\Models\HotelOrderItem;
use App\Models\Order;
use App\Models\Hotel;
use App\Models\PaymentGateway;
use Auth;
use Carbon\Carbon;
use Session;

class HotelCheckoutController extends Controller
{
    public function booking(Request $request)
    {
        $gs = Generalsetting::findOrFail(1)->only('hotel_service_fee');
    

        $data = array();

        if(Session::has('book')){
            Session::forget('book');
        }

        // room price calculation //

        $rooms = [];
        $room_price = 0;

        if($request->room_id != 'undefined'){
            $room_id = explode(',',$request->room_id);
            $qty = explode(',',$request->room_qty);
            foreach($room_id as $key => $room){
                $room_price += HotelRoom::FindOrFail($room)->per_night_cost * $qty[$key];
                $rooms[] = HotelRoom::findOrFail($room);
            }
        }else{
            return response()->json(['error' => 'please select one room']);
        }

        
        // room qty calculation //

        $room_qty = [];
        $room_count = 0;
        
        if($request->room_qty != 'undefined'){
            $room_quintity = explode(',',$request->room_qty);
            foreach($room_quintity as $key =>  $qty){
                $room_count += $qty;
                $room_qty[$key] = $qty;
            }
        }else{
            return response()->json(['error' => 'please select one room']);
        }
         
        
        // extra price calculation //
        $extra_price_sum = 0;

    
            $fac_price= [];
            $fac_name = [];
            $fac_type = [];
            
        if($request->facilities){
           
            $facilities = explode(',',$request->facilities);
            
            $hotelData  = Hotel::findOrFail($request->hotel_id);
            $h_e_p      = explode(',,,',$hotelData->extra_price);
            $h_e_n      = explode(',,,',$hotelData->extra_price_name);
            $h_e_t      = explode(',,,',$hotelData->extra_price_type);

            
            foreach($h_e_n as $key => $extra_name){

               foreach($facilities as $val){
                    if($key == $val){
                        $fac_name [] = $extra_name;
                        $fac_price[] = $h_e_p[$key];
                        $extra_price_sum += $h_e_p[$key];
                        $fac_type [] = $h_e_t[$key];
                    }
                } 
            }
        }

       
            $total = $room_price * $request->night;
            $total = $total + $extra_price_sum;
           
            $total = $total + $gs['hotel_service_fee'];
      
                
            $hotel = Hotel::findOrFail($request->hotel_id);

            
            // data session store //
            $data['hotel'] = $hotel;
            $data['rooms'] = $rooms;
            $data['room_qty'] = $room_qty;
            $data['fac_price'] = $fac_price;
            $data['fac_name'] = $fac_name;
            $data['fac_type'] = $fac_type;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['adult'] = $request->adult;
            $data['children'] = $request->children;
            $data['room_count'] = $room_count;
            $data['night'] = $request->night;
            $data['service_fee'] = PriceHelper::showPrice($gs['hotel_service_fee']);
            $data['total'] = $total;
            
            Session::put('book',$data);

        // redirect route //

        if(!Auth::user()){

            Session::put('url',route('hotel.checkout'));
            return response()->json(['login' => route('user.login')]);
        }

        return response()->json(['success' => route('hotel.checkout')]);
    }


    public function checkout()
    {
        if(Session::has('book')){
            $data['user'] = Auth::user();
            $data['book'] = Session::get('book');
            $data['gateweys'] = PaymentGateway::where('status',1)->get();
            return view('front.checkout.checkout',$data);
        }else{
            Session::flash('error','Please Book Someone');
            return redirect(route('front.index'));
        }
    }

    public function hotelRoomGet(Request $request)
    {
        // data analaysis //
        $hotel_id   = $request->hotel_id;
        $adult      = $request->adult;
        $children   = $request->children;


        $orders  = Order::where('item_id',$hotel_id)->where('order_type','Hotel')->get();
        $check_id = array();

        foreach(HotelOrderItem::where('hotel_id',$hotel_id)->get() as $chc){
            $check_id[]= $chc->room_id;
        }

        $stock = [];
        $extra_room = [];

        $check = 0;
        if($orders->count() > 0){
            $order_id  = array();
       
       
            foreach($orders as $key => $order){
                $stcs = 0;
                if (is_string($order->start_date)) {
                    $order_start_date = Carbon::parse($order->start_date);
                }
                if (is_string($order->end_date)) {
                    $order_date = Carbon::parse($order->end_date);
                }
                if (is_string($request->start_date)) {
                    $req_date = Carbon::parse($request->start_date);
                }
                if (is_string($request->end_date)) {
                    $req_enddate = Carbon::parse($request->end_date);
                }
               
                if($order_start_date->gt($req_enddate) || $req_date->gt($order_date)){
                    $order_id[] = $order->id;
                }else{
                    $check = 1;
                    $stc = HotelOrderItem::where('order_id',$order->id)->first();
                    $room = HotelRoom::where('id',$stc->room_id)->first();
                    
                    $stcs = HotelOrderItem::where('room_id',$room->id)->sum('room_qty');
                    
                    if($room->stock > $stcs){
                      
                        $order_id[] = $order->id;
                        $stk = $room->stock  - $stcs;
                        if($stk != 0){
                            $stock[] = $room->stock  - $stcs;
                            $extra_room[] = $room->id;
                        }
                        
                       
                    }else{
                      $stock[] = null;
                    }

                   
                }
               
          
                if($req_date->gt($order_date)){
                    $order_id[] = $order->id;
                }
            }
          

      
            $room_id = array();
        
            foreach($order_id as $orid){
            $abc = HotelOrderItem::where('order_id',$orid)->get();
            foreach($abc as $a){
                if(!in_array($a->room_id,$room_id)){
                    $room_id[] = $a->room_id; 
                }
            }
        }


        $notOrder = array();
        foreach(HotelRoom::where('hotel_id',$hotel_id)->where('adult','>=',$adult)->where('children','>=',$children)->get() as $x){
            if(!in_array($x->id , $check_id)){
                $notOrder[] = $x;
            }
        }

        $wiseRoom = array();
        
        foreach($room_id as $roomId){
            if(HotelRoom::where('id',$roomId)->where('hotel_id',$request->hotel_id)->where('adult','>=',$adult)->where('children','>=',$children)->exists()){
                $wiseRoom[] = HotelRoom::where('id',$roomId)->where('hotel_id',$request->hotel_id)->where('adult','>=',$adult)->where('children','>=',$children)->first();
            }
        }

        $data['rooms'] = array_merge($wiseRoom,$notOrder);
    } 

    else{
        $data['rooms'] = HotelRoom::where('hotel_id',$request->hotel_id)->where('adult','>=',$adult)->where('children','>=',$children)->get();
    }
        $data['stock'] = $stock;
        $data['extra_room'] = $extra_room;
        $data['check'] = $check;
        return view('front.load.room',$data);
    }
}
