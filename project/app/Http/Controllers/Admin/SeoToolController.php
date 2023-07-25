<?php

namespace App\Http\Controllers\Admin;


use App\Models\Seotool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App;
use App\Helpers\Helper;

class SeoToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    public function analytics()
    {
        $tool = Seotool::find(1);
        return view('admin.seotool.googleanalytics',compact('tool'));
    }

    public function analyticsupdate(Request $request)
    {
        $tool = Seotool::findOrFail(1);
        $input = $request->all();
        $input['meta_keys'] = Helper::TagFormat($request->meta_keys);
        $tool->update($input);
        $msg = __('Data Update Successfully...!');
        return response()->json($msg);  
    }  

     
}
