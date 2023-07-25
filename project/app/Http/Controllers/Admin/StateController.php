<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;


class StateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }


    public function index()
    {
        return view('admin.location.state.index');
    }

    public function datatables()
    {
         $datas = State::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
        ->editColumn('country_id', function(State $data) {
            return $data->country->country;
        })
        
        ->addColumn('action', function(State $data) {
            return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin.state.edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin.state.delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })

        ->editColumn('serial', function(State $data) {
            $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
            return $check;
         })


        ->rawColumns(['action','serial'])
        ->toJson(); 
    }


    public function create()
    {
        $countrys = Country::where('status',1)->select('id','country')->get();
        return view('admin.location.state.create',compact('countrys'));
    }

    public function store(Request $request)
    {
            //--- Validation Section
            $rules = [
                'state' => 'required|unique:states',
                'country_id' => 'required',
                
            ];
            $customs = [
                'state.required' => __('the state field is required'),
                'country_id.required' => __('the country field is required'),
                ];
    
            $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
              return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

           $input = $request->all();
           $input['slug'] = $request->state;
           $data = new State;
           $data->create($input);
           $mgs = __('Data Added Successfully.');
           return response()->json($mgs);
    }

    public function edit($id)
    {
        $countrys = Country::where('status',1)->select('id','country')->get();
        $data = State::findOrFail($id);
        return view('admin.location.state.edit',compact('countrys','data'));
    }

    public function update(Request $request , $id)
    {
         //--- Validation Section
         $rules = [
            'state' => 'required|unique:states,state,'.$id,
            'country_id' => 'required',
            
        ];
        $customs = [
            'state.required' => __('the state field is required'),
            'country_id.required' => __('the country field is required'),
            ];

        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

       $input = $request->all();
       $input['slug'] = $request->state;
       $data = State::findOrFail($id);
       $data->update($input);
       $mgs = __('Data Update Successfully.');
       return response()->json($mgs);
    }

    public function destroy($id)
    {
       $data = State::findOrFail($id);

       if($data->tour->count() > 0){
           return response()->json(__('Remove the tour first'));
       }
       if($data->hotel->count() > 0){
           return response()->json(__('Remove the hotel first'));
       }
       if($data->car->count() > 0){
           return response()->json(__('Remove the car first'));
       }
       if($data->space->count() > 0){
           return response()->json(__('Remove the space first'));
       }

       $data->delete();
       $mgs = __('Data Delete Successfully');
       return response()->json($mgs);
    }
}
