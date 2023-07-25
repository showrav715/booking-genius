<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{

    protected $fillable = ['is_read'];


    public function conversation()
    {
        return $this->belongsTo('App\Models\Conversation');
    }


    public static function countNotification()
    {
        return Notification::where('conversation_id',null)->where('is_read','=',0)->orderBy('id','desc')->get()->count();
    }
   
     public function user()
    {
      return $this->belongsTo('App\Models\User');
    }


    
}
