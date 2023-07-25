<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\Helper;
use DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;



class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    public function index()
    {
        return view('admin.location.country.index');
    }

    public function datatables()
    {

        $datas = Country::orderBy('id','desc')->get();

         return DataTables::of($datas)
        ->addColumn('status', function(Country $data) {
            $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
            $status = $data->status == 1 ? __('Activated') : __('Deactivated');
            return '<div class="btn-group">
                        <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$status.'
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin.country.status',['id1' => $data->id, 'id2' => 1]).'">'.__('Active').'</a>
                            <a class="dropdown-item StatusCheck" data-val="0" href="javascript:;" data-href="'.route('admin.country.status',['id1' => $data->id, 'id2' => 0]).'">'.__('Deactive').'</a>
                        </div>
                        </div>';
        })

        ->addColumn('image', function(Country $data) { 
            $image = $data->image->image != null? url('assets/images/location/country/'.$data->image->image):url('assets/images/noimage.png');
            return '<img src="' . $image . '" alt="Image" width="100"> ';
        })

        ->editColumn('serial', function(Country $data) {
            $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
            return $check;
         })
        
        ->addColumn('action', function(Country $data) {
            return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin.country.edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin.country.delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })

        ->rawColumns(['status','action','image','serial'])
        ->toJson();
     }


     public function create()
     {
         return view('admin.location.country.create');
     }

     public function store(Request $request)
     {
            //--- Validation Section
            $rules = [
                'title' => 'unique:countries|required',
                'country' => 'unique:countries|required',
                'image' => 'required|mimes:jpeg,jpg,png',
            ];
            $customs = [
                'title.required' => __('This title field is required'),
                'country.unique' => __('This country has already been taken.'),
                'image.required' => __('The image field is required'),
                'image.mimes' => __('The image format must be a file of type: jpeg,jpg,png'),
                
                ];
    
            $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
              return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

            $input = $request->all();
            $input['slug'] = Helper::slug($request->title);

            $data = new Country;

            $id = $data->create($input)->id;

            $model =Country::findOrFail($id);

            //--- Validation Section Ends
            if($request->hasFile('image')){
                $image = $request->image;
                $location = base_path('../assets/images/location/country/');
                Helper::makeImage($image,$location,$model);
            }else{
                Helper::NullImage($model);
            }

            $mgs = __('Data Added Successfully.');
            return response()->json($mgs);
     }


     public function edit($id)
     {
         $data = Country::findOrFail($id);
         return view('admin.location.country.edit',compact('data'));
     }


     public function update(Request $request , $id)
     {
        //--- Validation Section
        $rules = [
            'title' => 'required|unique:countries,title,'.$id,
            'country' => 'required|unique:countries,country,'.$id,
            'image' => 'mimes:jpeg,jpg,png',
        ];
        $customs = [
            'title.required' => __('This title field is required'),
            'country.unique' => __('This country has already been taken.'),
            'image.mimes' => __('The image format must be a file of type: jpeg,jpg,png'),
            
            ];

        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Country::findOrFail($id);

        $input = $request->all();
        $input['slug'] = Helper::slug($request->title);
        $data->update($input);

        $model = Country::findOrFail($id);

        if($request->hasFile('image')){
            $image = $request->image;
            $location = base_path('../assets/images/location/country/');
            Helper::ImageUpdate($image,$location,$model); 
        }

        $mgs = __('Data Upadate Successfully.');
        return response()->json($mgs);

     }


     public function destroy($id)
     {
        $data = Country::findOrFail($id);

        if($data->state->count() > 0){
            return response()->json(__('Remove the state first'));
        }
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

        if($data->image->image){
            if(file_exists(base_path('../assets/images/location/country/'.$data->image->image))){
                unlink(base_path('../assets/images/location/country/'.$data->image->image));
            }
        }
        $data->image->delete();
        $data->delete();
            $mgs = __('Data Delete Successfully.');
            return response()->json($mgs);
     }


     public function status($id1,$id2)
     {
         $data = Country::findOrFail($id1);

         $data->status = $id2;
         $data->update();
         $mgs = ('Data Update Successfully.');
         return response()->json($mgs);
     }
}
