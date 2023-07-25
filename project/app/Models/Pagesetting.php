<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagesetting extends Model
{
    protected $fillable = [
        'success_message',
        'contact_email',
        'contact_title',
        'contact_subtitle',
        'day',
        'time',
        'street_address',
        'contact_number',
        'fax',
        'hotel_section',
        'destinations_section',
        'car_section',
        'space_section',
        'tour_section',
        'feature_section',
        'member_section',
        'blog_title',
        'blog_text',
        'car_title',
        'hotel_title',
        'space_title',
        'tour_title',
        'destination_title',
        'member_title',
        'member_text',
        'hotel_menu',
        'car_menu',
        'space_menu',
        'tour_menu',
        'pages_menu',
        'blog_menu',
        'contact_menu',
        'member_background'
    ];

    public $timestamps = false;

    public function upload($name,$file,$oldname)
    {
                $file->move('assets/images/page-setting',$name);
                if($oldname != null)
                {
                    if (file_exists(public_path().'/assets/images/page-setting/'.$oldname)) {
                        unlink(public_path().'/assets/images/page-setting/'.$oldname);
                    }
                }  
    }

}
