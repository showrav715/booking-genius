<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
    protected $fillable = ['name', 'slug','status'];
    public function setSlugAttribute($value)
    {
    	$this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function tours()
	{
	    return $this->hasMany('App\Models\TourModel','category_id');
    }
}
