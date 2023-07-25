<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourCategory;
use DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;


class TourCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }


    public function index()
    {
        return view('admin.tour.category.index');
    }


    //*** JSON Request
    public function datatables()
    {
        //--- Returning Json Data To Client Side
        $datas = TourCategory::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            ->addColumn('status', function(TourCategory $data) {
                                $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
                                $status = $data->status == 1 ? __('Activated') : __('Deactivated');
                                return '<div class="btn-group">
                                            <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                '.$status.'
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-tour-cat-status',['id1' => $data->id, 'id2' => 1]).'">'.__('Active').'</a>
                                                <a class="dropdown-item StatusCheck" data-val="0" href="javascript:;" data-href="'.route('admin-tour-cat-status',['id1' => $data->id, 'id2' => 0]).'">'.__('Deactive').'</a>
                                            </div>
                                         </div>';
                            })
                            ->addColumn('action', function(TourCategory $data) {
                                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-tour-cat-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-tour-cat-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
                            })

                            ->editColumn('serial', function(TourCategory $data) {
                                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                                return $check;
                             })

                           
                            ->rawColumns(['status','action','serial'])
                            ->toJson();

    //*** GET Request

     }
    
    //*** GET Request
    public function create()
    {
        return view('admin.tour.category.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'name' => 'required',
               'slug' => 'required|unique:tour_categories'
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
        $data = new TourCategory;
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
        $data = TourCategory::findOrFail($id);
        return view('admin.tour.category.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
               'name' => 'required',
               'slug' => 'required|unique:tour_categories,slug,'.$id
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
        $data = TourCategory::findOrFail($id);
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
        $data = TourCategory::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        $mgs = ('Data Update Successfully.');
        return response()->json($mgs);
    }

    //*** GET Request
    public function destroy($id)
    {
        $data = TourCategory::findOrFail($id);

        //--- Check If there any blogs available, If Available Then Delete it 
        if($data->tours->count() > 0)
        {
        //--- Redirect Section
        $msg = __('Remove the  Tour first!');
        return response()->json($msg);
        //--- Redirect Section Ends
        }
        $data->delete();
        //--- Redirect Section     
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }
}
