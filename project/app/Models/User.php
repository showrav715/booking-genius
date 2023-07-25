<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','photo','verification_link','email_verified','birthday','phone','gander','address','country','city','state','zip_code','pending_earning','total_earning'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function review()
    {
        return $this->hasOne('App\Models\Review');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function favarite()
    {
        return $this->hasOne('App\Models\Favarite');
    }
    public function favarites()
    {
        return $this->hasMany('App\Models\Favarite');
    }

    public function hotel()
    {
        return $this->hasMany('App\Models\Hotel','author_id','id');
    }
    public function tour()
    {
        return $this->hasMany('App\Models\TourModel','author_id','id');
    }
    public function space()
    {
        return $this->hasMany('App\Models\Space','author_id','id');
    }
    public function car()
    {
        return $this->hasMany('App\Models\Car','author_id','id');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order','user_id','id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification','user_id','id');
    }



    
    
}
