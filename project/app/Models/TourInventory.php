<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInventory extends Model
{
    protected $fillable = ['tour_id', 'image','title','description','content'];
}
