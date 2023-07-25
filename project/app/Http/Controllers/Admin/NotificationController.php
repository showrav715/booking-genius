<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use DB;
use App;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }




    public function notf_clear()
    { 
        $datas = Notification::where('conversation_id','=',null)->get();
        foreach($datas as $data){
            $data->delete();  
        }
        
    } 

    public function notf_show()
    {
        $datas = Notification::orderby('id','desc')->where('conversation_id',null)->get();
        if($datas){
          foreach($datas as $data){
              if(!$data->conversation_id){
                $data->is_read = 1;
                $data->update();
              }
          }
        }       
        return view('admin.notification.notification',compact('datas'));           
    } 


    public function conv_notf_count()
    {
        $data = Notification::where('conversation_id','!=',null)->get()->count();
        return response()->json($data);            
    } 

    public function conv_notf_clear()
    {
        $data = Notification::where('conversation_id','!=',null);
        $data->delete();        
    } 

    public function conv_notf_show()
    {
        $datas = Notification::where('conversation_id','!=',null)->get();
        if($datas->count() > 0){
            foreach ($datas as $key => $data) {
                if($data->conversation_id){
                    $data->is_read = 1;
                    $data->update();
                  }
            }
            
        }       
        return view('admin.notification.message',compact('datas'));           
    } 





}
