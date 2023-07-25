<?php

namespace App\Http\Controllers\Admin;
use App\Models\Generalsetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;



class GeneralSettingController extends Controller
{

    protected $rules =
    [
        'header_logo'       => 'mimes:jpeg,jpg,png,svg',
        'footer_logo'       => 'mimes:jpeg,jpg,png,svg',
        'favicon'    => 'mimes:jpeg,jpg,png,svg',
        'website_loader'     => 'mimes:gif',
        'admin_loader'     => 'mimes:gif',
        'service_image'    => 'mimes:jpeg,jpg,png,svg',
        'error_photo'    => 'mimes:jpeg,jpg,png,svg',
        'breadcumb_banner'    => 'mimes:jpeg,jpg,png,svg',
        'admin_loader'    => 'mimes:gif'
    ];

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }



    private function setEnv($key, $value,$prev)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . $prev,
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    // Genereal Settings All post requests will be done in this method
    public function generalupdate(Request $request)
    {
        //--- Validation Section
        $validator = Validator::make($request->all(), $this->rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        else {

        $input = $request->all(); 
        $data = Generalsetting::findOrFail(1);  
            
            if ($file = $request->file('header_logo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->header_logo);
                $input['header_logo'] = $name;
            } 
            if ($file = $request->file('footer_logo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->footer_logo);
                $input['footer_logo'] = $name;
            } 
              
            if ($file = $request->file('favicon')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->favicon);
                $input['favicon'] = $name;
            }   
            if ($file = $request->file('admin_loader')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->admin_loader);
                $input['admin_loader'] = $name;
            }  

            if ($file = $request->file('website_loader')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->website_loader);
                $input['website_loader'] = $name;
            } 

            if ($file = $request->file('breadcumb_banner')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->breadcumb_banner);
                $input['breadcumb_banner'] = $name;
            } 

            if ($file = $request->file('error_photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $data->upload($name,$file,$data->error_photo);
                $input['error_photo'] = $name;
            }   
            
        $data->update($input);
        //--- Logic Section Ends
        //--- Redirect Section        
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends               
        }
    }

    public function paymentsinfo()
    {
       return view('admin.generalsetting.p_information');
    }


    public function menuupdate(Request $request)
    {
        $data = Generalsetting::findOrFail(1);
        $input = $request->all();
        
        if ($request->is_contact == ""){
            $input['is_contact'] = 0;
        }
        if ($request->is_faq == ""){
            $input['is_faq'] = 0;
        }
        if ($request->is_home == ""){
            $input['is_home'] = 0;
        }
        if ($request->is_services == ""){
            $input['is_services'] = 0;
        }
        
        if ($request->is_projects == ""){
            $input['is_projects'] = 0;
        }
        if ($request->is_teams == ""){
            $input['is_teams'] = 0;
        }
        if ($request->is_blog == ""){
            $input['is_blog'] = 0;
        }
        if ($request->is_pages == ""){
            $input['is_pages'] = 0;
        }
        
        $data->update($input);
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);      
    }


    public function logo()
    {
        return view('admin.generalsetting.logo');
    }

    public function fav()
    {
        return view('admin.generalsetting.favicon');
    }

    public function error()
    {
        return view('admin.generalsetting.error');
    }
     public function breadcumb()
    {
        return view('admin.generalsetting.breadcumb');
    }

     public function load()
    {
        return view('admin.generalsetting.loader');
    }

     public function contents()
    {
        return view('admin.generalsetting.websitecontent');
    }

     public function success()
    {
        return view('admin.generalsetting.success');
    }

     public function footer()
    {
        return view('admin.generalsetting.footer');
    }


    public function customize()
    {
        return view('admin.pagesetting.menu_customize');
    }
    
    public function StatusUpdate($value)
    {
        $value = explode(',',$value);
        $status = $value[0];
        $field = $value[1];
        $data = Generalsetting::findOrFail(1);
        $data->$field = $status;
        $data->update();

        if($status == 1){
            return response()->json(['status'=>1,'success' => __('Data Updated Successfully.')]);
        }else{
            return response()->json(['status'=>0,'success' => __('Data Updated Successfully.')]);
        }
       
    }


       // Status Change Method -> GET Request
       public function status($field,$value)
       {
           $prev = '';
           $data = Generalsetting::findOrFail(1);
     
           $data[$field] = $value;
           //--- Redirect Section
           $msg = __('Status Updated Successfully.');
           return response()->json($msg);
           //--- Redirect Section Ends
   
       }
   
}
