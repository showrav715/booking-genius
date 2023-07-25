<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App;


class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    //*** JSON Request
    //*** JSON Request
    public function datatables()
    {
          //--- Returning Json Data To Client Side
    $datas = BlogCategory::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            ->addColumn('status', function(BlogCategory $data) {
                                $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
                                $status = $data->status == 1 ? __('Activated') : __('Deactivated');
                                return '<div class="btn-group">
                                            <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                '.$status.'
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-bcat-status',['id1' => $data->id, 'id2' => 1]).'">'.__('Active').'</a>
                                                <a class="dropdown-item StatusCheck" data-val="0" href="javascript:;" data-href="'.route('admin-bcat-status',['id1' => $data->id, 'id2' => 0]).'">'.__('Deactive').'</a>
                                            </div>
                                         </div>';
                            })
                            ->addColumn('action', function(BlogCategory $data) {
                                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-cblog-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-cblog-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
                            })

                            ->editColumn('serial', function(BlogCategory $data) {
                                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                                return $check;
                             })

                           
                            ->rawColumns(['status','action','serial'])
                            ->toJson();

    //*** GET Request

     }
    //*** GET Request
    public function index()
    {
        return view('admin.cblog.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.cblog.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'name' => 'required',
               'slug' => 'required|unique:blog_categories'
                ];
        $customs = [
               'name.required' => __('This Name field is required'),
               'slug.unique' => __('This slug has already been taken.')
                   ];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new BlogCategory;
        $input = $request->all();
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
        $data = BlogCategory::findOrFail($id);
        return view('admin.cblog.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
               'name' => 'required',
               'slug' => 'required|unique:blog_categories,slug,'.$id
                ];
        $customs = [
            'name.required' => __('This Name field is required'),
            'slug.unique' => __('This slug has already been taken.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = BlogCategory::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section          
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);    
        //--- Redirect Section Ends  

    }


    public function status($id1,$id2)
    {
        $data = BlogCategory::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        $mgs = ('Data Update Successfully.');
        return response()->json($mgs);
    }

    //*** GET Request
    public function destroy($id)
    {
        $data = BlogCategory::findOrFail($id);
     
        if($data->blogs->count() > 0)
        {
        $msg = __('Remove The Blog First');
        return response()->json($msg);
        }
        $data->delete();
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      

    }
}
