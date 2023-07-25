<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourModel extends Model
{

    public function image(){return $this->morphOne('App\Models\ShowImage', 'imageable')->withDefault();}

    protected $fillable = 
    [
        'title', 
        'slug',
        'description',
        'category_id',
        'user_id',
        'author_id',
        'author_type',
        'video',
        'duration',
        'tour_min_people',
        'tour_max_people',
        'faq_title',
        'faq_content',
        'include',
        'exclude',
        'banner_image',
        'country_id',
        'state_id',
        'address',
        'tour_attr_id',
        'attr_term_id',
        'is_feature',
        'main_price',
        'sale_price',
        'discount',
        'is_person',
        'person_type',
        'person_type_min',
        'person_type_max',
        'person_type_price',
        'is_extra_price',
        'extra_price_name',
        'extra_price',
        'extra_price_type',
        'seo_check',
        'meta_title',
        'meta_tag',
        'meta_description',
        'status',
        'average_review',
    ];

    public function category()
	{
	    return $this->hasOne('App\Models\TourCategory','id','category_id');
    }
    
    public function inventorys()
	{
	    return $this->hasMany('App\Models\TourInventory','tour_id','id');
	}
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
    public function reviews()
	{
	    return $this->hasmany('App\Models\Review','review_id','id');
    }

    public function review()
    {
         $count = Review::where('type','tour')->where('review_id',$this->id)->count();
         if($count == 0){
             return 0;
         }
         $review = Review::where('type','tour')->where('review_id',$this->id)->sum('review');
         return ($review / $count); 
    }
    public function review_count()
    {
         $count = Review::where('type','tour')->where('review_id',$this->id)->count();
         return $count; 
    }
}
