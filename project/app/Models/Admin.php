<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','photo','phone','role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Isrole()
    {
    	return $this->hasOne('App\Models\Role','id','role');
    }

    public function IsSuper(){
        if ($this->id == 1) {
           return true;
        }
        return false;
    }

    public function sectionCheck($value){
       
        $sections = explode(",", $this->Isrole->section);
        if($sections){
            if (in_array($value, $sections)){
                return true;
            }else{
                return false;
            }
        }
        
    }
}
