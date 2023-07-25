<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    
    public static function countNotification($user_id)
    {
        return UserNotification::where('conversation_id',null)->where('user_id',$user_id)->where('is_read','=',0)->orderBy('id','desc')->get()->count();
    }
}
