<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable = ['hotel_id','room_name','square_fit','bed','adult','children','per_night_cost','stock'];

    public function gallery()
	{
	    return $this->hasMany('App\Models\GalleryImage','imagable_id','id');
    }

    public function hotel()
	{
	    return $this->belongsTo('App\Models\Hotel','hotel_id');
    }

}
