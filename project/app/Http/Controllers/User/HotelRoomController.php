<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Helpers\Helper;

use App\Models\HotelRoom;
use App\Models\GalleryImage;


class HotelRoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        return view('user.hotel.room.index',compact('id'));
    }

    public function datatables($id)
    {
        $datas = HotelRoom::orderBy('id','desc')->where('hotel_id',$id)->get();
        return DataTables::of($datas)
            ->addColumn('action', function(HotelRoom $data) {
                return '<div class="action-list"><a href="' . route('user-hotel-room-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('user-hotel-room-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                </div>';
            })
            ->editColumn('per_night_cost', function(HotelRoom $data) {
                $price = $data->per_night_cost;
                return \PriceHelper::showAdminCurrencyPrice($price);
            })
            ->rawColumns(['action','per_night_cost'])
            ->toJson();
    }


    public function create($hotel_id)
    {
        return view('user.hotel.room.create',compact('hotel_id'));
    }

    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'room_name' =>'required',
            'bed' => 'required',
            'square_fit' => 'required',
            'adult' => 'required',
            'children' => 'required',
            'stock' => 'required',
           
        ];
        $customs = [
           'room_name.required' => 'Room title field is required',
           'bed.required' => 'Bed field is required',
           'square_fit.required' => 'Square fit field is required',
           'adult.required' => 'adult field is required',
           'children.required' => 'children field is required.',
            'stock.required' => 'stock field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();
        $input['per_night_cost'] = \PriceHelper::storePrice($request->per_night_cost);
        $data = new HotelRoom;
        $id = $data->create($input)->id;

        if($request->gallery){
            if(count($request->gallery) > 0){
                $type = 'hotel_room';
                $model = new GalleryImage;
                $imagable_id = $id;
                $location = base_path('../assets/images/hotel-image/room/');
                $images = $request->gallery;
                Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
            }
        }

        $mgs = __('New Data Added Successfully.');
        return response()->json($mgs);
        
    }

    public function edit($id)
    {
        $data = HotelRoom::findOrFail($id);
        return view('user.hotel.room.edit',compact('data'));
    }

    public function update(Request $request , $id)
    {
        $roules = [
            'room_name' => 'required',
            'bed' => 'required',
            'square_fit' => 'required',
            'adult' => 'required',
            'children' => 'required',
            'stock' => 'required'
        ];

        $customs = [
            'room_name.required' => 'Room title field is required',
            'bed.required' => 'Bed field is required',
            'square_fit.required' => 'square fit field is required',
            'adult.required' => 'adult field is required',
            'children.required' => 'children field is required',
            'stock.required' => 'stock field is required',
        ];

            $validator = Validator::make($request->all(), $roules,$customs);
            if($validator->fails()){
                return response()->json(array('errors'=> $validator->getMessageBag()));
            }

            $input = $request->all();
            $input['per_night_cost'] = \PriceHelper::storePrice($request->per_night_cost);
            $data = HotelRoom::findOrFail($id);
            $data->update($input);

            if($request->gallery){
                if(count($request->gallery) > 0){
                    $type = 'hotel_room';
                    $model = new GalleryImage;
                    $imagable_id = $id;
                    $location = base_path('../assets/images/hotel-image/room/');
                    $images = $request->gallery;
                    Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
                }
            }

            $mgs = __('Data Updated Successfully.');
            return response()->json($mgs);
    }


    public function GalleryRemove($id)
    {
        $data = GalleryImage::where('id',$id)->where('type','hotel_room')->first();
        if($data->image){
            if(file_exists(base_path('../assets/images/hotel-image/room/'.$data->image))){
                unlink(base_path('../assets/images/hotel-image/room/'.$data->image));
            }
        }
        $data->delete();
        $mgs = __('Image Remove Successfully.');
        return response()->json(['message' => $mgs]);
    }

    public function destroy($id)
    {
        $room = HotelRoom::findOrFail($id);
        if($room->gallery->where('type','hotel_room')){
        foreach($room->gallery->where('type','hotel_room') as $gal){
                if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                    unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                }
                $gal->delete();
            }
        }
        $room->delete();
        $mgs = __('Data Deleted Successfully.');
        return response()->json($mgs);
    }
}
