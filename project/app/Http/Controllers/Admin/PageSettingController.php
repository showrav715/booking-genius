<?php

namespace App\Http\Controllers\Admin;
use App\Models\Pagesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use DB;
use App;
use Illuminate\Support\Facades\Validator;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    protected $rules =
    [
        'video_image' => 'mimes:jpeg,jpg,png,svg',
    ];

    public function homepage()
    {
       return view('admin.pagesetting.homepage');
    }

    public function pageCustomize()
    {
       return view('admin.pagesetting.home_page_customize');
    }


    // Page Settings All post requests will be done in this method
    public function Update(Request $request)
    {
        $data = Pagesetting::where('id',1)->first();
        $input = $request->all();

        if ($request->tour_section == 1){
            $input['tour_section'] = 1;
        }else{
            $input['tour_section'] = 0;
        }


        if ($request->car_section == 1){
            $input['car_section'] = 1;
        }else{
            $input['car_section'] = 0;
        }


        if ($request->hotel_section == 1){
            $input['hotel_section'] = 1;
        }else{
            $input['hotel_section'] = 0;
        }


        if ($request->space_section == 1){
            $input['space_section'] = 1;
        }else{
            $input['space_section'] = 0;
        }


        if ($request->destinations_section == 1 ){
            $input['destinations_section'] = 1;
        }else{
            $input['destinations_section'] = 0;
        }
    
        if ($request->blog_section == 1){
            $input['blog_section'] = 1;
        }else{
            $input['blog_section'] = 0; 
        }


        if ($request->member_section == 1){
            $input['member_section'] = 1;
        }else{
            $input['member_section'] = 0;
        }


        if ($request->feature_section == 1){
            $input['feature_section'] = 1;
        }else{
            $input['feature_section'] = 0;
        }

        $data->update($input);
      
          
        $msg = __('Data Update Successfully');
        return response()->json($msg);      
    }


    public function HeadingUpdate(Request $request)
    {
        $data = Pagesetting::findOrFail(1);
        $input = $request->all();
        $data->update($input);

        $msg = __('Data Update Successfully');
        return response()->json($msg);    
    }


    public function headingCustomize()
    {
        $data = Pagesetting::findOrFail(1);
        return view('admin.pagesetting.heading',compact('data'));
    }
    public function menuUpdate(Request $request)
    {
       $input = $request->all();
         if ($request->hotel_menu == 1){
            $input['hotel_menu'] = 1;
        }else{
            $input['hotel_menu'] = 0;
        }


        if ($request->car_menu == 1){
            $input['car_menu'] = 1;
        }else{
            $input['car_menu'] = 0;
        }
       
        if ($request->space_menu == 1){
            $input['space_menu'] = 1;
        }else{
            $input['space_menu'] = 0;
        }


        if ($request->tour_menu == 1){
            $input['tour_menu'] = 1;
        }else{
            $input['tour_menu'] = 0;
        }


        if ($request->pages_menu == 1){
            $input['pages_menu'] = 1;
        }else{
            $input['pages_menu'] = 0;
        }


        if ($request->blog_menu == 1){
            $input['blog_menu'] = 1;
        }else{
            $input['blog_menu'] = 0;
        }


        if ($request->contact_menu == 1){
            $input['contact_menu'] = 1;
        }else{
            $input['contact_menu'] = 0;
        }

        $data = Pagesetting::first();
        $data->Update($input);

        $msg = __('Data Update Successfully');
        return response()->json($msg);    
    }

    public function menuCustomize()
    {
        $data = Pagesetting::findOrFail(1);
        return view('admin.pagesetting.menu_customize',compact('data'));
    }


    public function contactupdate(Request $request)
    {
        $ps = Pagesetting::findOrFail(1);
        $ps->contact_title = $request->contact_title;
        $ps->contact_subtitle = $request->contact_subtitle;
        $ps->contact_email = $request->contact_email;
        $ps->day = $request->day;
        $ps->time = $request->time;
        $ps->street_address = $request->street_address;
        $ps->contact_number = $request->contact_number;
        $ps->fax = $request->fax;
        $ps->update();
        $msg = __('Data Update Successfully');
        return response()->json($msg);    
    }



    public function homeupdate(Request $request)
    {
       
        $data = Pagesetting::findOrFail(1);
        $input = $request->all();
        

        $data->update($input);
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);      
    }


    public function contact()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.contact',compact('data'));
    }

    public function video()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.video',compact('data'));
    }

    

    public function homecontact()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.homecontact',compact('data'));
    }

    public function donate()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.donate',compact('data'));
    }

    public function blog()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.blog',compact('data'));
    }

    public function customize()
    {
        $data = Pagesetting::find(1);   
        return view('admin.pagesetting.customize',compact('data'));
    }

    //Upadte About Page Section Settings


    public function memberBackgroundUpdate()
    {  
        return view('admin.pagesetting.member_background');
    }

    public function memberBackgroundstore(Request $request)
    {
        
         $rules =
        [
            'member_background'       => 'mimes:jpeg,jpg,png,svg',
        ];

        $message = [
            'member_background.mimes' => 'The background image must be a file of type: jpeg, jpg, png, svg.'
        ];
          //--- Validation Section
          $validator = Validator::make($request->all(), $rules,$message);
        
          if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }
          //--- Validation Section Ends
  
        $data = Pagesetting::find(1);  

        if ($file = $request->file('member_background')) 
        {    
            $name = time().$file->getClientOriginalName();
            $data->upload($name,$file,$data->member_background);
            $input['member_background'] = $name;
            $data->update($input);
        }

        
        $mgs = __('Data Update Successfully');

        return response()->json($mgs);

    }

}
