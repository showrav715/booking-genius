<?php 

namespace App\Helpers;

use App\{
    Models\Currency,
    Models\Generalsetting
};
use Session;

class PriceHelper
{
 
    public static function showCurrencyPrice($price) {
        $gs = Generalsetting::find(1);
   
        
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

        $price = round($price * $curr->value,2);

        if($gs->currency_format == 0){
            
            return $curr->sign.$price;
        }
        else{
           
            return $price.$curr->sign;
        }
    }

    public static function showPrice($price) {
        $gs = Generalsetting::find(1);
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

        $price = round($price * $curr->value,2);

        return $price;
    }




    public static function showAdminCurrencyPrice($price) {
        $gs = Generalsetting::find(1);

        $curr = Currency::where('is_default','=',1)->first();
        $price = round($price * $curr->value,2);
        
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
       
    }


      public static function storePrice($price) {
        $curr = Currency::where('is_default','=',1)->first();
        $price = ($price / $curr->value);
        return $price;
    }


    public static function showCurrency()
    {
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
        
        return $curr->sign;
    }


    public static function showAdminCurrency()
    {
        $curr = Currency::where('is_default','=',1)->first();
        return $curr->sign;
    }

    public static function showCurrencyCode()
    {
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }
       
        return $curr->name;
    }


    public static function showAdminPrice($price) {
        $curr = Currency::where('is_default','=',1)->first();
        $price = round($price * $curr->value,2);
        return $price;
    }


    public static function showOrderCurrencyPrice($price,$currency) {
        $gs = Generalsetting::find(1);
        $new_price = 0;
        if(is_numeric( $price ) && floor( $price ) != $price){
            $new_price = number_format($price, 2, $gs->decimal_separator, $gs->thousand_separator);
        }else{
            $new_price = number_format($price, 0, $gs->decimal_separator, $gs->thousand_separator);
        }
 
        if($gs->currency_format == 0){
            return $currency.$new_price;
        }
        else{
            return $new_price.$currency;
        }
    }

}