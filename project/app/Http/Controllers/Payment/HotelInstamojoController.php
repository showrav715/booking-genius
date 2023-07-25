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
use App\Models\HotelOrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HotelInstamojoController extends Controller
{

    public function store(Request $request)
    {
    
        $user = Auth::user();
        if(Session::has('book')){
            $book = Session::get('book');
            
            if($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user'){
                return back()->with('error',__('This is your Hotel'));
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
          Session::put('url',route('hotel.checkout'));
            return redirect(route('user.login'));
        }

      
        $data = PaymentGateway::whereKeyword('instamojo')->first();
        $paydata = $data->convertAutoData();

     
        $order['item_name'] = 'Hotel Order';
        $order['item_amount'] = PriceHelper::showPrice($book['total']);;

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
                "redirect_url" => route('hotel.instamojo.notify'),
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

        
        if($request['payment_status'] == 'Failed'){
            Session::flash('error','Payment Failed');
            return redirect()->route('hotel.checkout');
        }

        if(Session::has('book')){
            $book = Session::get('book'); 
        }
    
        $input = Session::get('input_data');
    
        $order = new  Order();
            $order['order_type'] = 'Hotel';
            $order['email'] = $input['email'];
            $order['name'] = $input['name'];;
            $order['number'] = $input['number'];;
            $order['address'] = $input['address'];;
            $order['city'] = $input['city'];;
            $order['state'] = $input['state'];;
            $order['country'] = $input['country'];;
            $order['zip_code'] = $input['zip_code'];;
            $order['summery'] = $input['summery'];;
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


            $curr = Currency::where('name',$input['currency_code'])->first();
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
         
            $order['service_charge'] = PriceHelper::storePrice($book['service_fee']);
            $order['total'] = $book['total'];
            $order['item_id'] = $book['hotel']['id'];
            $order['method'] = 'Instamojo';
            $order['order_number'] = Str::random(4).time();
            $order['payment_status'] = "Complete";
            $order['order_status'] = "Pending";
            $order['currency_code'] = $curr->name;
            $order['currency_value'] = $curr->value;
            $order['currency_sign'] = $curr->sign;
            $order['txnid'] = $request['payment_id'];
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

                $item = new HotelOrderItem();
                $item->create($in);
            }

            OrderHelper::vendorOrder($book,'hotel');

            // email and notification 
            BookingMail::Booking($order->id,'Hotel',$book['total'],$order->order_number,$input['name'],$input['email']);



            Session::forget('book');
                 
                
            return redirect(route('front.success'));
    }
}