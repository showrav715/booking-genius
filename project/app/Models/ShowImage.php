<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowImage extends Model
{
    protected $guarded = [];
    public function imageable(){return $this->morphTo();}
}
