<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUserMessage extends Model
{
    protected $fillable = ['conversation_id','message','user_id'];

    public function ticket(){
        return $this->belongsTo('App\Models\AdminUserConversation','conversation_id');
    }

    public function user()
	{
	    return $this->hasOne('App\Models\User','id','user_id');
	}
}
