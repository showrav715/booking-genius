<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Config;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Models\Order;
use App\Models\Generalsetting;
use Illuminate\Support\Str;
use Session;
use Auth;


class SpaceStripeController extends Controller
{
    public function __construct()
    {
        //Set Spripe Keys
        $stripe = Generalsetting::findOrFail(1);
        Config::set('services.stripe.key', $stripe->stripe_key);
        Config::set('services.stripe.secret', $stripe->stripe_secret);
    }


    public function store(Request $request){
        
         $supported = [
            'USD','EUR'
        ];


        if(!in_array($request->currency_code,$supported)){
            return redirect()->route('space.checkout')->with('error','This currency not supported stripe checkout');
        }


        $user = Auth::user();
        if(Session::has('spaceBook')){
            $book = Session::get('spaceBook');
            
            if($book['space']['author_id'] == $user->id && $book['space']['author_type'] == 'user'){
                return back()->with('error','This is your Space');
            }
        }else{
            return view('errors.404');
        }
       
        $title = 'Space Booking';

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
                    Session::put('url',route('space.checkout'));
                    return redirect(route('user.login'));
                }

                
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' =>  $request->currency_code,
                    'amount' => PriceHelper::showPrice($book['total']),
                    'description' => $title,
                ]);


            // Space Order data store..............//
                $order = new Order;

                if ($charge['status'] == 'succeeded') {
                    $order['order_type'] = 'Space';
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

                    $order['author_id'] = $book['space']['author_id'];
                    $order['author_type'] = $book['space']['author_type'];
                    
                    $curr = Currency::where('name',$request->currency_code)->first();
                    $order['currency_code'] = $curr->name;
                    $order['currency_value'] = $curr->value;
                    $order['currency_sign'] = $curr->sign;
                    $order['total'] = $book['total'];
                    $order['item_id'] = $book['space']['id'];
                    $order['method'] = 'Stripe';
                    $order['order_number'] = Str::random(4).time();
                    $order['payment_status'] = "Completed";
                    $order['order_status'] = "Pending";
                    $order['txnid'] = $charge['balance_transaction'];
                    $order['charge_id'] = $charge['id'];
                    $order['user_id'] = Auth::user()->id;
                     
                    $order->save();

                    // order data insert end //

                    // email and notification 
                    BookingMail::Booking($order->id,'Space',$book['total'],$order->order_number,$request->name,$request->email);
                    OrderHelper::vendorOrder($book,'space');

                    // redirect call section //

                    Session::forget('spaceBook');
                 
                       
                    return redirect(route('front.success'));

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
