<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\HotelAttr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;

class HotelAttrController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    public function index()
    {
        return view('admin.hotel.attr.index');
    }

     //*** JSON Request
     public function datatables()
     {
        $datas = HotelAttr::orderBy('id','desc')->get();
        return DataTables::of($datas)
            ->addColumn('action', function(HotelAttr $data) {
                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-hotelattr-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-hotelattr-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                <a href="'.route('admin-attrtrem-index',$data->id) . '" class="btn btn-primary btn-sm">'.__('Manage').'</a>
                </div>';
            })

            ->editColumn('serial', function(HotelAttr $data) {
                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                return $check;
             })

             
            ->rawColumns(['action','serial'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.hotel.attr.create');
    }

    public function store(Request $request)
    {
     //--- Validation Section
        $rules = [
            'name' => 'required|unique:hotel_attrs|required|regex:/^[a-zA-Z0-9\s-]+$/',
        ];
        $customs = [
            'name.required' => __('This Attribute field is required'),
            'name.unique' => __('This Attribute has already been taken.'),
            'name.regex' => __('Attribute Must Not Have Any Special Characters.'),
        ];
                 
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();
        $hotelAttr = new HotelAttr;
        $hotelAttr->create($input);
        $mgs = __('New Data Added Successfully.');
        return response()->json($mgs);
    }

    public function edit($id)
    {
       $data = HotelAttr::findOrFail($id);
       return view('admin.hotel.attr.edit',compact('data'));
    }

    public function update(Request $request , $id)
    {
        //--- Validation Section
        $rules = [
            'name' => 'unique:hotel_attrs,name,'.$id.'|required|regex:/^[a-zA-Z0-9\s-]+$/',
        ];
        $customs = [
            'name.required' => __('This Attribute field is required'),
            'name.unique' => __('This Attribute has already been taken.'),
            'name.regex' => __('Attribute Must Not Have Any Special Characters.'),
        ];     
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $data = HotelAttr::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        $mgs = __('Data Updated Successfully.');
        return response()->json($mgs);
    }

    public function destroy($id)
    {
        $data = HotelAttr::findOrFail($id);
        $delete = $data->AttrCount();
        if($delete == true){
            
            if(count($data->terms) > 0){
                foreach($data->terms as $trem){
                    if($trem->image->image){
                        if (file_exists(base_path('../assets/images/attr-term-image/'.$trem->image->image))) {
                            unlink(base_path('../assets/images/attr-term-image/'.$trem->image->image));
                        }
                        }
                    $trem->delete();
                }
            }
            $data->delete();
        }
        $mgs = __('Data Deleted Successfully.');
        return response()->json($mgs);
    }
}
