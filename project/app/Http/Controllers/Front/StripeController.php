<?php

namespace App\Http\Controllers\Front;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Config;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Models\Order;
use App\Models\HotelOrderItem;
use App\Models\Generalsetting;
use Illuminate\Support\Str;
use Session;
use Auth;
class StripeController extends Controller
{
  public function __construct()
    {
        //Set Spripe Keys
        $stripe = Generalsetting::findOrFail(1);
        Config::set('services.stripe.key', $stripe->stripe_key);
        Config::set('services.stripe.secret', $stripe->stripe_secret);
    }


    public function store(Request $request){

        $user = Auth::user();
        if(Session::has('book')){
            $book = Session::get('book');
            if($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user'){
                return back()->with('error','This is your Hotel');
            }
        }else{
            return view('errors.404');
        }

        $title = 'Hotel Booking';
            $request->validate([
                'cardNumber' => 'required',
                'cardCVC' => 'required',
                'month' => 'required',
                'year' => 'required',
                'country'  => 'required',
                'state' => 'required',
                'city'  => 'required',
                'address'  => 'required',
                'number'  => 'required',
                'email'  => 'required',
                'name'  => 'required',
            ]);
      
           
            $stripe = Stripe::make(Config::get('services.stripe.secret'));
            try{
                $token = $stripe->tokens()->create([
                    'card' =>[
                            'number' => $request->cardNumber,
                            'exp_month' => $request->month,
                            'exp_year' => $request->year,
                            'cvc' => $request->cardCVC,
                        ],
                    ]);

                if (!isset($token['id'])) {
                    return back()->with('error','Token Problem With Your Token.');
                }

                

                if(!Auth::user()){
                    Session::put('url',route('hotel.checkout'));
                    return redirect(route('user.login'));
                }

          
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' =>  $request->currency_code,
                    'amount' => PriceHelper::showPrice($book['total']),
                    'description' => $title,
                ]);

                if ($charge['status'] == 'succeeded') {
            // Hotel Order data store..............//
                $order = new Order;

                if ($charge['status'] == 'succeeded') {
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
                    

                    $order['service_charge'] = 100;
                    $order['total'] = $book['total'];
                    $order['item_id'] = $book['hotel']['id'];
                    $order['author_id'] = $book['hotel']['author_id'];
                    $order['author_type'] = $book['hotel']['author_type'];
                    $order['method'] = 'Stripe';
                    $order['order_number'] = Str::random(4).time();
                    $order['payment_status'] = "Completed";
                    $order['order_status'] = "Pending";
                    $order['txnid'] = $charge['balance_transaction'];
                    $order['charge_id'] = $charge['id'];
                    $order['user_id'] = Auth::user()->id;
                     
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

                    OrderHelper::vendorOrder($book,'hotel');

                    // email and notification 
                    BookingMail::Booking($order->id,'Hotel',$book['total'],$order->order_number,$request->name,$request->email);
                    // redirect call section //

                    Session::forget('book');
                 
                 return view('front.success');;

                }

                }
                
            }catch (Exception $e){
                return back()->with('unsuccess', $e->getMessage());
            }catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
                return back()->with('unsuccess', $e->getMessage());
            }catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
                return back()->with('unsuccess', $e->getMessage());
            }
       
    }

}
