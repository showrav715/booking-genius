<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    public $timestamps = false;

    public function order()
	{
	    return $this->belongsTo('App\Models\Order')->withDefault();;
    }
    public function user()
	{
	    return $this->belongsTo('App\Models\User')->withDefault();;
    }
}
