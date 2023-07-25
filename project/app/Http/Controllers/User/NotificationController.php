<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }


    public function notf_clear()
    { 
        $datas = UserNotification::where('conversation_id','=',null)->get();
        foreach($datas as $data){
            $data->delete();  
        }
        
    } 

    public function notf_show()
    {
        
        $datas = UserNotification::orderby('id','desc')->where('conversation_id',null)->get();
        if($datas){
          foreach($datas as $data){
              if(!$data->conversation_id){
                $data->is_read = 1;
                $data->update();
              }
          }
        }       
        return view('user.notification.notification',compact('datas'));           
    } 



}
