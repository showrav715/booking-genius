<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelOrderItem extends Model
{
    protected $fillable = [
       
        'user_id',
        'order_id',
        'hotel_id',
        'room_id',
        'room_name',
        'room_qty',
        'square_fit',
        'bed',
        'per_night_cost',
    ];


    public function order()
	{
	    return $this->hasOne('App\Models\Order','id','order_id');
    }
}
