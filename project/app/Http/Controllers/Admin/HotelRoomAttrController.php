<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\Models\HotelRoomAttr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HotelRoomAttrController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    public function index()
    {
        return view('admin.hotel.roomattr.index');
    }

     //*** JSON Request
     public function datatables()
     {
        $datas = HotelRoomAttr::orderBy('id','desc')->get();
        return DataTables::of($datas)
            ->addColumn('action', function(HotelRoomAttr $data) {
                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-roomattr-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-roomattr-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.hotel.roomattr.create');
    }

    public function store(Request $request)
    {
     //--- Validation Section
        $rules = [
            'name' => 'unique:hotel_room_attrs|required|regex:/^[a-zA-Z0-9\s-]+$/',
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
        $hotelAttr = new HotelRoomAttr;
        $hotelAttr->create($input);
        $mgs = __('New Data Added Successfully.');
        return response()->json($mgs);
    }

    public function edit($id)
    {
       $data = HotelRoomAttr::findOrFail($id);
       return view('admin.hotel.roomattr.edit',compact('data'));
    }

    public function update(Request $request , $id)
    {
        //--- Validation Section
        $rules = [
            'name' => 'unique:hotel_room_attrs,name,'.$id.'|required|regex:/^[a-zA-Z0-9\s-]+$/',
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
        $data = HotelRoomAttr::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        $mgs = __('Data Updated Successfully.');
        return response()->json($mgs);
    }

    public function destroy($id)
    {
        HotelRoomAttr::findOrFail($id)->delete();
        $mgs = __('Data Deleted Successfully.');
        return response()->json($mgs);
    }
}
