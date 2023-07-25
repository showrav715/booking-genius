<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'banner_image',
        'hotel_attr_id',
        'attr_term_id',
        'user_id',
        'author_id',
        'author_type',
        'user_id',
        'is_feature',
        'description',
        'video',
        'country_id',
        'state_id',
        'address',
        'is_extra_price',
        'extra_price_type',
        'extra_price',
        'extra_price_name',
        'main_price',
        'sale_price',
        'discount',
        'status',
        'policy_title',
        'policy_content',
        'seo_check',
        'meta_title',
        'meta_tag',
        'meta_description',
        'rating',
        'average_review'

    ];


    public function image(){return $this->morphOne('App\Models\ShowImage', 'imageable')->withDefault();}


    public function gallery()
	{
	    return $this->hasMany('App\Models\GalleryImage','imagable_id','id');
    }
    public function country()
	{
	    return $this->belongsTo('App\Models\Country');
    }
    public function state()
	{
	    return $this->belongsTo('App\Models\State');
    }

    public function rooms()
	{
	    return $this->hasMany('App\Models\HotelRoom');
    }

    public function reviews()
	{
	    return $this->hasmany('App\Models\Review','review_id','id');
    }

    public function review()
    {
         $count = Review::where('type','hotel')->where('review_id',$this->id)->count();
         if($count == 0){
            return 0;
        }
         $review = Review::where('type','hotel')->where('review_id',$this->id)->sum('review');
         return $review / $count; 
    }
    public function review_count()
    {
         $count = Review::where('type','hotel')->where('review_id',$this->id)->count();
         return $count; 
    }
    
}
