<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use DB;
use App;
use App\Helpers\Helper;

class PageController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Page::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            ->editColumn('details', function(Page $data) {
                                $details = strlen(strip_tags($data->details)) > 250 ? substr(strip_tags($data->details),0,250).'...' : strip_tags($data->details);
                                return  $details;
                            })
                            
                            ->addColumn('action', function(Page $data) {
                                return '<div class="action-list"><a href="' . route('admin-page-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2" > <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-page-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
                            })

                            ->editColumn('serial', function(Page $data) {
                                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                                return $check;
                             })


                            ->rawColumns(['header','footer','action','serial'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.page.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.page.create');
    }

    //*** POST Request
    public function store(Request $request)
    {

        //--- Validation Section
        $slug = $request->slug;
        $main = array('home','faq','contact','blog','checkout');
        if (in_array($slug, $main)) {
        return response()->json(array('errors' => [ 0 => 'This slug has already been taken.' ]));          
        }

        $rules = ['slug' => 'unique:pages','details' => 'required|min:10'];

        $customs = [
            'slug.unique' => 'This slug has already been taken.', 'details.min' => __('Minimun 10 cherecter details required.')
        ];

        

        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Page();
        $input = $request->all();
        if($request->seocheck == 'on'){
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $input['meta_description'] = $request->meta_description;
            $input['seocheck'] = 1;
        }else{
            $input['meta_tag'] = '';
            $input['meta_description'] = '';
            $input['seocheck'] = 0;
        
        }
        
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Page::findOrFail($id);
        return view('admin.page.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        
        //--- Validation Section
        $slug = $request->slug;
        $main = array('home','faq','contact','blog','checkout');
        if (in_array($slug, $main)) {
        return response()->json(array('errors' => [ 0 => 'This slug has already been taken.' ]));          
        }
        $rules = ['slug' => 'unique:pages,slug,'.$id,'details' => 'required|min:10'];
        $customs = [
            'slug.unique' => 'This slug has already been taken.', 'details.min' => __('Minimun 10 cherecter details required.')];
        $validator = Validator::make($request->all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }        
        //--- Logic Section
        $data = Page::findOrFail($id);
        $input = $request->all();
        if($request->seocheck == 'on'){
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $input['meta_description'] = $request->meta_description;
            $input['seocheck'] = 1;
        }else{
            $input['meta_tag'] = '';
            $input['meta_description'] = '';
            $input['seocheck'] = 0;
        
        }
 
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);    
        //--- Redirect Section Ends           
    }
      //*** GET Request Header
      public function header($id1,$id2)
        {
            $data = Page::findOrFail($id1);
            $data->header = $id2;
            $data->update();
        }
      //*** GET Request Footer
      public function footer($id1,$id2)
        {
            $data = Page::findOrFail($id1);
            $data->footer = $id2;
            $data->update();
        }


    //*** GET Request Delete
    public function destroy($id)
    {

        $data = Page::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }
}