<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title','category_id','slug', 'description', 'source', 'views','updated_at', 'status','meta_tag','meta_description','tags'];

    public function image()
    {
        return $this->morphOne('App\Models\ShowImage', 'imageable');
    }

    public function category()
    {
    	return $this->belongsTo('App\Models\BlogCategory');
    }    

}
