<?php

namespace App\Http\Controllers\Checkout;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourModel;
use App\Models\Order;
use App\Models\PaymentGateway;
use Carbon\Carbon;
use Session;
use Auth;


class TourCheckoutController extends Controller
{
    public function booking(Request $request)
    {
     
        $data = array();

        if(Session::has('tourBook')){
            Session::forget('tourBook');
        }


        // extra price calculation //
       
        $extra_price_sum = 0;
        $fac_price= [];
        $fac_name = [];
        $fac_type = [];

         
        if($request->facilities != null){
            $facilities = explode(',',$request->facilities);
            $tourData  = TourModel::findOrFail($request->tour_id);
            $h_e_p      = explode(',,,',$tourData->extra_price);
            $h_e_n      = explode(',,,',$tourData->extra_price_name);
            $h_e_t      = explode(',,,',$tourData->extra_price_type);

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

   
        $tour = TourModel::findOrFail($request->tour_id);

        $p_type = [];
        $p_price = [];
        $p_qty = [];
        $per_sum_price = 0;

        
        if($request->person_type){
            $person = explode(',',$request->person_type);
            
            foreach($person as $key => $per){
                $t_p_type = explode(',,,',$tour->person_type);
                $t_p_price = explode(',,,',$tour->person_type_price);

                foreach($t_p_type as $tour_key => $type_tour){
                    if($key == $tour_key && $per != 0){
                    $p_type[] = $t_p_type[$key];
                    $p_price[] = $t_p_price[$key];
                    $p_qty[] = explode(',',$request->person_type)[$key];
                    $per_sum_price +=  $t_p_price[$key] * $per;
                    }
                }
            } 
        }

        
      
            $total = $tour->main_price + $extra_price_sum + $per_sum_price;
            
            // tour information

            // data session store //
            $data['tour'] = $tour;
            
            $data['fac_price'] = $fac_price;
            $data['fac_name'] = $fac_name;
            $data['fac_type'] = $fac_type;
            $data['person_type'] = $p_type;
            $data['person_price'] = $p_price;
            $data['person_qty'] = $p_qty;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            if($request->night == 0){
                $data['night'] = 1;
            }else{
                $data['night'] = $request->night;
            }
            
            $data['total'] = $total;

       
            Session::put('tourBook',$data);

        // redirect route //

        if(!Auth::user()){
            Session::put('url',route('tour.checkout'));
            return response()->json(['login' => route('user.login')]);
        }

        return response()->json(['success' => route('tour.checkout')]);
    }


    public function checkout()
    {
        
        if(Session::has('tourBook')){
            $data['user'] = Auth::user();
            $data['tour'] = Session::get('tourBook');
            $data['gateweys'] = PaymentGateway::where('status',1)->get();
            return view('front.checkout.tour_checkout',$data);
        }else{
            Session::flash('error','Please Book Someone');
            return redirect(route('front.index'));
        }
    }



    public function checkAvailability(Request $request)
    {
        
        $car_id = $request->car_id;
        $start_date =$request->start_date;
        $end_date =$request->end_date;

        $orders  = Order::where('item_id',$car_id)->where('order_type','Tour')->get();
        
        if($orders->count() > 0){
            $order_id  = array();
        
            foreach($orders as $order){
                if (is_string($order->start_date)) {
                    $order_enddate = Carbon::parse($order->end_date);
                    $order_startdate = Carbon::parse($order->start_date);
                }
                if (is_string($start_date)) {
                    $start_date = Carbon::parse($start_date);
                    $end_date = Carbon::parse($end_date);
                }
        
             
                if($order_startdate->gt($end_date) || $start_date->gt($order_enddate)){
                    $order_id[] = $order->id;
                }
            }
        
            
            if(count($order_id) > 0){
                return response()->json(['message' => 'the car available this time', 'status' => 1 ]);
            }else{
                return response()->json(['message' => 'the car this time allready booked.','status' => 0]);
            }


            }else{
                return response()->json(['message' => 'the car available this time', 'status' => 1 ]);
            }
    }
}
