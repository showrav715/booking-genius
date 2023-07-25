<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;

class RoleController extends Controller
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
         $datas = Role::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
        ->addColumn('section', function(Role $data) {
            $section = '';
            foreach(explode(',',$data->section) as $val){
                $section .= '<span class="mr-1 badge badge-primary p-2 mb-2" style="font-size:14px">'.$val.'</span>';
            }

            return $section;
        })
        ->addColumn('action', function(Role $data) {
            return '<div class="action-list"><a href="' . route('admin-role-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 > <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-role-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })
        ->rawColumns(['section','action'])
        ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.role.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.role.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
    //--- Validation Section
        
        $rules = ['name' => 'unique:roles,name|required'];
         $validator = Validator::make($request->all(), $rules);
         
         if ($validator->fails()) {
           return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
         }
         //--- Validation Section Ends
        //--- Logic Section
        $data = new Role();
        $input = $request->all();
        if(!empty($request->section))
        {
            $input['section'] = implode(",",$request->section);
        }
        else{
            $input['section'] = '';
        }

        $data->create($input);
        //--- Logic Section Ends
      
        //--- Redirect Section
        $msg = __('New Data Added Successfully!.');
        return response()->json($msg);
        //--- Redirect Section Ends    

    }

    //*** GET Request
    public function edit($id)
    {
        $data = Role::findOrFail($id);
        return view('admin.role.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
                    'name' => 'required|unique:roles,name,'.$id,
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends../

        //--- Logic Section
        $data = Role::findOrFail($id);
        $input = $request->all();
        if(!empty($request->section))
        {
            $input['section'] = implode(",",$request->section);
        }
        else{
            $input['section'] = '';
        }
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully!.');
        return response()->json($msg);
        //--- Redirect Section Ends    

    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
