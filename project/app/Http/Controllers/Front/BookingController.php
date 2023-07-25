<?php

namespace App\Http\Controllers\Front;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\TourModel;
use App\Models\Hotel;
use App\Models\Space;
use App\Models\Car;
use App\Models\Review;
use App\Models\Country;
use App\Models\Favarite;
use App\Models\Pagesetting;
use Auth;
use Carbon\Carbon;



class BookingController extends Controller
{

    public function tour(Request $request)
    {

        $ps = Pagesetting::findOrFail(1);
        if($ps->tour_menu == 0){
            return back();
        }


        $data['countries'] = Country::where('status',1)->take(5)->get();
        $data['max_price'] = TourModel::where('status','publish')->max('main_price');
        $country = $request->country_id;
        $review = $request->review;
        $view = $request->view ? $request->view : 10;
        $minprice = PriceHelper::storePrice($request->minPrice);
        $maxprice = PriceHelper::storePrice($request->maxPrice);


        if($request->sort){
            $type = $request->sort;
        }else{
            $type = 'latest';
        }

        $data['tours'] =
                    TourModel::when($country, function ($query, $country) {
                        return $query->where('country_id', $country);
                    })
                    ->when($review, function ($query, $review) {
                        return $query->where('average_review', '>=', $review);
                    })
                    ->when($minprice, function ($query, $minprice) {
                        return $query->where('main_price', '>=', $minprice);
                    })
                    ->when($maxprice, function ($query, $maxprice) {
                        return $query->where('main_price', '<=', $maxprice);
                    })
                    ->when($type, function ($query, $type) {
                        if ($type == 'latest') {
                            return $query->orderBy('id', 'DESC');
                        } elseif ($type == 'oldest') {
                            return $query->orderBy('id', 'ASC');
                        } elseif ($type == 'price_up') {
                            return $query->orderBy('main_price', 'DESC');
                        } elseif ($type == 'price_down') {
                            return $query->orderBy('main_price', 'ASC');
                        }
                    })
                    ->where('status','publish')->paginate($view);

                    
        if($request->page_type){
            if($request->page_type == 'false'){
                return view('front.load.index',$data);
            }
        }
        return view('front.tour.index',$data);
    }

    
    public function tourDetails($slug)
    {  
        $ps = Pagesetting::findOrFail(1);
        if($ps->tour_menu == 0){
            return back();
        }
        
        $data['data_type']    = 'tour';
        $data['tour']         = TourModel::where('slug',$slug)->first();
        $data['reviews']      = Review::select('id','review','user_id','comment','created_at')->where('type','tour')->where('review_id',$data['tour']->id)->get();
        $data['related_data'] = TourModel::where('category_id',$data['tour']->category_id)->where('id','!=',$data['tour']->id)->get();
        return view('front.tour.details',$data);
    }


    public function favarite($id_type)
    {
        $data = explode(',,',$id_type);
        $id = $data[0];
        $type = $data[1];

        $check = Favarite::where('data_id',$id)->where('type',$type)->exists();

        if($check == true){
            Favarite::where('data_id',$id)->where('type',$type)->delete();
            return response()->json(['message' => $type . ' remove successfully','status'=>0]);
        }else{
            Favarite::insert([
                'user_id' => Auth::user()->id,
                'data_id' => $id,
                'type' => $type,
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['message' => $type . ' added successfully','status'=>1]);
        }
    }

    public function hotel(Request $request)
    {

        $ps = Pagesetting::findOrFail(1);
        if($ps->hotel_menu == 0){
            return back();
        }

        $data['countries'] = Country::where('status',1)->take(5)->get();
        $data['max_price'] = Hotel::where('status','publish')->max('main_price');
  
        $country = $request->country_id;
        $review = $request->review;
        $view = $request->view ? $request->view : 10;
        $minprice = PriceHelper::storePrice($request->minPrice);
        $maxprice = PriceHelper::storePrice($request->maxPrice);


        if($request->sort){
            $type = $request->sort;
        }else{
            $type = 'latest';
        }

        $data['hotels'] =
                    Hotel::when($country, function ($query, $country) {
                        return $query->where('country_id', $country);
                    })
                    ->when($review, function ($query, $review) {
                        return $query->where('average_review', '>=', $review);
                    })
                    ->when($minprice, function ($query, $minprice) {
                        return $query->where('main_price', '>=', $minprice);
                    })
                    ->when($maxprice, function ($query, $maxprice) {
                        return $query->where('main_price', '<=', $maxprice);
                    })
                    ->when($type, function ($query, $type) {
                        if ($type == 'latest') {
                            return $query->orderBy('id', 'DESC');
                        } elseif ($type == 'oldest') {
                            return $query->orderBy('id', 'ASC');
                        } elseif ($type == 'price_up') {
                            return $query->orderBy('main_price', 'DESC');
                        } elseif ($type == 'price_down') {
                            return $query->orderBy('main_price', 'ASC');
                        }
                    })
                    ->where('status','publish')->paginate($view);

                    if($request->page_type){
                        if($request->page_type == 'false'){
                            return view('front.load.index',$data);
                        }
                    }

               return view('front.hotel.index',$data);
            }
  

    public function hotelDetails($slug){
        
        $ps = Pagesetting::findOrFail(1);
        if($ps->hotel_menu == 0){
            return back();
        }
        $data['data_type'] = 'hotel';
        $data['hotel'] = Hotel::where('slug',$slug)->first();
        $data['related_data'] = Hotel::where('country_id',$data['hotel']->country_id)->where('id','!=',$data['hotel']->id)->get();
        $data['reviews'] = Review::select('id','review','user_id','comment','created_at')->where('type','hotel')->where('review_id',$data['hotel']->id)->get();
        return view('front.hotel.details',$data);
    }

    public function space(Request $request)
    {

        $ps = Pagesetting::findOrFail(1);
        if($ps->space_menu == 0){
            return back();
        }


        $data['countries'] = Country::where('status',1)->take(5)->get();
        $data['max_price'] = Space::where('status','publish')->max('main_price');
        $country = $request->country_id;
        $review = $request->review;
        $view = $request->view ? $request->view : 10;
        $minprice = PriceHelper::storePrice($request->minPrice);
        $maxprice = PriceHelper::storePrice($request->maxPrice);


        if($request->sort){
            $type = $request->sort;
        }else{
            $type = 'latest';
        }

        $data['spaces'] =
        Space::when($country, function ($query, $country) {
                        return $query->where('country_id', $country);
                    })
                    ->when($review, function ($query, $review) {
                        return $query->where('average_review', '>=', $review);
                    })
                    ->when($minprice, function ($query, $minprice) {
                        return $query->where('main_price', '>=', $minprice);
                    })
                    ->when($maxprice, function ($query, $maxprice) {
                        return $query->where('main_price', '<=', $maxprice);
                    })
                    ->when($type, function ($query, $type) {
                        if ($type == 'latest') {
                            return $query->orderBy('id', 'DESC');
                        } elseif ($type == 'oldest') {
                            return $query->orderBy('id', 'ASC');
                        } elseif ($type == 'price_up') {
                            return $query->orderBy('main_price', 'DESC');
                        } elseif ($type == 'price_down') {
                            return $query->orderBy('main_price', 'ASC');
                        }
                    })
                    ->where('status','publish')->paginate($view);

                    if($request->page_type){
                        if($request->page_type == 'false'){
                            return view('front.load.index',$data);
                        }
                    }
    
                return view('front.space.index',$data);
    }

    public function spaceDetails($slug)
    {
        $ps = Pagesetting::findOrFail(1);
        if($ps->space_menu == 0){
            return back();
        }

        $data['data_type'] = 'space';
        $data['space'] = Space::where('slug',$slug)->first();
        $data['related_data'] = Space::where('country_id',$data['space']->country_id)->where('id','!=',$data['space']->id)->get();
        $data['reviews'] = Review::select('id','review','user_id','comment','created_at')->where('type','space')->where('review_id',$data['space']->id)->get();
        return view('front.space.details',$data);
    }

    public function cars(Request $request)
    {

        $ps = Pagesetting::findOrFail(1);
        if($ps->car_menu == 0){
            return back();
        }

        $data['countries'] = Country::where('status',1)->take(5)->get();
        $data['max_price'] = Car::where('status','publish')->max('main_price');
        $country = $request->country_id;
        $review = $request->review;
        $view = $request->view ? $request->view : 10;
        $minprice = PriceHelper::storePrice($request->minPrice);
        $maxprice = PriceHelper::storePrice($request->maxPrice);

        if($request->sort){
            $type = $request->sort;
        }else{
            $type = 'latest';
        }

        $data['cars'] =
                    Car::when($country, function ($query, $country) {
                        return $query->where('country_id', $country);
                    })
                    ->when($review, function ($query, $review) {
                        return $query->where('average_review', '>=', $review);
                    })
                    ->when($minprice, function ($query, $minprice) {
                        return $query->where('main_price', '>=', $minprice);
                    })
                    ->when($maxprice, function ($query, $maxprice) {
                        return $query->where('main_price', '<=', $maxprice);
                    })
                    ->when($type, function ($query, $type) {
                        if ($type == 'latest') {
                            return $query->orderBy('id', 'DESC');
                        } elseif ($type == 'oldest') {
                            return $query->orderBy('id', 'ASC');
                        } elseif ($type == 'price_up') {
                            return $query->orderBy('main_price', 'DESC');
                        } elseif ($type == 'price_down') {
                            return $query->orderBy('main_price', 'ASC');
                        }
                    })
                    ->where('status','publish')->paginate($view);

                    if($request->page_type){
                        if($request->page_type == 'false'){
                            return view('front.load.index',$data);
                        }
                    }

                return view('front.car.index',$data);
    }

    public function cardetails($slug)
    {   
        $ps = Pagesetting::findOrFail(1);
        if($ps->car_menu == 0){
            return back();
        }
        
        $data['data_type'] = 'car';
        $data['car'] = Car::where('slug',$slug)->first();

        $qtyCheck = Order::where('order_type','Car')->where('item_id',$data['car']->id)->sum('qty');
        if($qtyCheck == 0){
            if($data['car']->number){
                $data['qty'] = $data['car']->number;
            }else{
                $data['qty'] = 5; 
            }
            
        }else{
            $data['qty'] = $data['car']->number - $qtyCheck; 
        }
        

        $data['related_data'] = Car::where('country_id',$data['car']->country_id)->where('id','!=',$data['car']->id)->get();
        $data['reviews'] = Review::select('id','review','user_id','comment','created_at')->where('type','car')->where('review_id',$data['car']->id)->get();
        return view('front.car.details',$data);
    }


    


    

}
