<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['title','country','slug','status'];

    public function image(){return $this->morphOne('App\Models\ShowImage', 'imageable');}

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
    public function state()
	{
	    return $this->hasMany('App\Models\State');
    }
}


