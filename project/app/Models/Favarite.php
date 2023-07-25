<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favarite extends Model
{
    protected $fillable = ['user_id', 'data_id','type'];
}
