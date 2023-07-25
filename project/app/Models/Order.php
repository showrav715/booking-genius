<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_type',
        'user_id',
        'user_info',
        'author_id',
        'author_type',
        'item_id',
        'name',
        'email',
        'number',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'summery',
        'start_date',
        'end_date',
        'night',
        'adult',
        'children',
        'extra_price',
        'extra_name',
        'extra_type',
        'person_type',
        'person_price',
        'service_charge',
        'total',
        'qty',
        'method',
        'currency_code',
        'order_number',
        'payment_status',
        'order_status',
        'txnid',
        'charge_id',
        'invoice_number',
    ];


    public function hotel()
	{
	    return $this->belongsTo('App\Models\Hotel','item_id')->withDefault();
    }

    public function car()
	{
	    return $this->belongsTo('App\Models\Car','item_id')->withDefault();;
    }

    public function space()
	{
	    return $this->belongsTo('App\Models\Space','item_id')->withDefault();;
    }

    public function tour()
	{
	    return $this->belongsTo('App\Models\TourModel','item_id')->withDefault();;
    }

    public function user()
	{
	    return $this->belongsTo('App\Models\User')->withDefault();;
    }
    
    public function rooms()
	{
	    return $this->hasMany('App\Models\HotelOrderItem');
    }
    
}
