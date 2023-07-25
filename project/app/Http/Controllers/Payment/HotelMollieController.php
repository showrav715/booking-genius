<?php

namespace App\Http\Controllers\Payment;

use App\Classes\BookingMail;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\HotelOrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HotelMollieController extends Controller
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
    if(Session::has('book')){
        $book = Session::get('book');
        
    if($book['hotel']['author_id'] == $user->id && $book['hotel']['author_type'] == 'user'){
        return back()->with('error','This is your Hotel');
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
        return redirect()->route('hotel.checkout')->with('error','This currency not supported paypal checkout');
    }


    if(!$user){
        Session::put('url',route('hotel.checkout'));
        return redirect(route('user.login'));
    }

    $notify_url = route('hotel.mollie.notify');
    $cancel_url = route('hotel.checkout');

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
        'redirectUrl' => route('hotel.mollie.notify'),
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

        if(Session::has('book')){
            $book = Session::get('book'); 
        }

        $order = new Order;
     
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
        $order['method'] = 'Mollie';
        $order['order_number'] = Str::random(4).time();
        $order['payment_status'] = "Complete";
        $order['order_status'] = "Pending";
        $order['currency_code'] = $curr->name;
        $order['currency_value'] = $curr->value;
        $order['currency_sign'] = $curr->sign;
        $order['txnid'] = $payment->id;
        $order['charge_id'] = '';
        $order['user_id'] = Auth::user()->id;
        $order['author_id'] = $book['hotel']['author_id'];
        $order['author_type'] = $book['hotel']['author_type'];

        $order->save();


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
                
    }else{
        Session::flash('error','Payment Faield');
        return redirect(route('hotel.checkout'));
    }
}



}
