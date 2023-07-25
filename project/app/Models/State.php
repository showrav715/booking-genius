<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['country_id','state','slug'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function tour()
	{
	    return $this->hasMany('App\Models\TourModel');
    }
    public function car()
	{
	    return $this->hasMany('App\Models\Car');
    }
    public function space()
	{
	    return $this->hasMany('App\Models\Space');
    }
    public function hotel()
	{
	    return $this->hasMany('App\Models\Hotel');
    }
}
