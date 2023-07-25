<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    protected $fillable = ['review_id','review','comment','type','user_id'];

    public function user()
	{
	    return $this->belongsTo('App\Models\User');
    }


   
    
}


