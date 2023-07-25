<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\Helpers\Helper;
use App\Helpers\PriceHelper;
use App\Models\Hotel;
use App\Models\Country;
use App\Models\GalleryImage;
use App\Models\User;
use App\Models\HotelAttr;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Image;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }
    public function index()
    {
        return view('admin.hotel.index');
    }

    public function datatables()
    {
        $datas = Hotel::orderBy('id','desc')->get();
         return DataTables::of($datas)

         ->editColumn('status', function(Hotel $data) {
            $status = $data->status == 'publish' ?  '<span class="badge badge-success">'.__('Publish').'</span>' : '<span class="badge badge-info">'.__('Draft').'</span>';
            return $status;
        })
        ->addColumn('location', function(Hotel $data) {
            return  $data->state->state;
        })
        ->addColumn('action', function(Hotel $data) {
            return '<div class="action-list">
            <a href="'.route('hotel.details',$data->slug).'" target="_blank"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'. route('admin-hotel-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-hotel-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
            <a href="' . route('admin-hotel-room',$data->id).'" class="btn btn-primary btn-sm"><i class="fas fa-cogs"></i> '. __('Manage Rooms') .'</a>
            </div>';
        })

        ->editColumn('main_price', function(Hotel $data) {
            $price = $data->main_price;
            return PriceHelper::showAdminCurrencyPrice($price);
        })

        ->editColumn('serial', function(Hotel $data) {
            $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
            return $check;
         })

        ->rawColumns(['status','action','location','main_price','serial'])
        ->toJson();
    }


    public function create()
    {
        $data['hotalAttr'] = HotelAttr::all();
        $data['users'] = User::select('id','name')->get();
        $data['countries'] = Country::where('status',1)->get();

        return view('admin.hotel.create',compact('data'));
    }

    public function store(Request $request)
    {

        if($request->user_id){
            $input['author'] = $request->user_id;
            $input['author_type'] = 'user';
        }else{
            $input['author'] = Auth::guard('admin')->user()->id;
            $input['author_type'] = 'Admin';
        }

        //--- Validation Section
        $rules = [
            'hotel_title' =>'required|unique:hotels,title|regex:/^[a-zA-Z0-9\s-]+$/',
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'term_id' => 'required',
            'banner_image' => 'required|mimes:jpeg,jpg,png,svg',
            'image' => 'required|mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'hotel_title.required' => 'Hotel Title field is required',
           'hotel_title.unique' => 'Hotel Title has already been taken',
           'hotel_title.regex' => 'Hotel Must Not Have Any Special Characters',
           'description.min' => 'Minimun 10 Cherecter description required',
           'country_id.required' => 'Country field is required',
           'state_id.required' => 'State field is required',
           'address.required' => 'Address field is required',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'banner_image.required' => 'Banner image is required',
           'banner_image.mimes' => 'Banner image format is not supported',
           'image' => 'Image field is required',
           'image.mimes' => 'Image format is not supported',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();
        if(!$request->rating){
            $input['rating'] = 0;
        }
        $input['main_price'] = PriceHelper::storePrice($request->main_price);
        $input['sale_price'] = PriceHelper::storePrice($request->sale_price);



        if($request->seo_check == 'yes'){

            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $rules = [
                'meta_tag' => 'required',
                'meta_description' => 'required',
            ];
            $customs = [
                'meta_tag.required' => 'Meta Tag field is required',
                'meta_description.required' => 'Description field is required.',
             ];

             $validator = Validator::make($request->all(), $rules, $customs);
                if ($validator->fails()) {
                    return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            }


        $input['title'] = $request->hotel_title;


        // logic------------------------
        $term_id = [];
        $attr_id = [];
        foreach($request->term_id as $termX){
            $X = explode(',',$termX);
            $term_id[] = $X[0];
            $attr_id[] = $X[1];
        }


        $input['hotel_attr_id'] = implode(',',$attr_id);
        $input['attr_term_id'] = implode(',',$term_id);


        $input['hotel_attr_id'] = implode(',',$attr_id);
        $input['attr_term_id'] = implode(',',$term_id);

        if($request->title && $request->content){
            $input['policy_title'] = implode(',,,',$request->title);
            $input['policy_content'] = implode(',,,',$request->content);
        }

        if($request->is_extra_price == 1 && $request->extra_price_name){
            $eextra_price = [];
            foreach($request->extra_price as $tt_price){
                $eextra_price[] = PriceHelper::storePrice($tt_price);
            }

            $input['extra_price_name'] = implode(',,,',$request->extra_price_name);
            $input['extra_price'] = implode(',,,',$eextra_price);
            $input['extra_price_type'] = implode(',,,',$request->extra_price_type);
        }else{
            $input['extra_price_name'] = null;
            $input['extra_price'] =null ;
            $input['extra_price_type'] = null;
            $input['is_extra_price'] = 0;
        }


        $input['slug'] = Helper::slug($input['title']);

        if($request->hasFile('banner_image')){
            $image = $request->banner_image;
            $image_name = rand().$image->getClientOriginalName();
            $image_loc = base_path('../assets/images/hotel-image/banner-image/'.$image_name);
            Image::make($image)->save($image_loc);
            $input['banner_image'] = $image_name;
        }
        if($request->user_id){
            $input['author_id'] = $request->user_id;
            $input['author_type'] = 'user';
        }else{
            $input['author_id'] = Auth::guard('admin')->user()->id;
            $input['author_type'] = 'Admin';
        }


        $data = new Hotel;
        $id = $data->create($input)->id;

        if($request->gallery){
            if(count($request->gallery) > 0){
                $type = 'hotel';
                $model = new GalleryImage;
                $imagable_id = $id;
                $location = base_path('../assets/images/hotel-image/gallery/');
                $images = $request->gallery;
                Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
            }
        }

        $model = Hotel::findOrFail($id);
        if($request->hasFile('image')){
            $file = $request->image;
            $location = base_path('../assets/images/hotel-image/');
            Helper::MakeImage($file,$location,$model);
        }else{
           Helper::NullImage($model);
        }
        $mgs = __('Data Added Successfully.');
        return response()->json($mgs);
    }

    public function edit($id)
    {
        $data['hotalAttr'] = HotelAttr::all();
        $data['users'] = User::select('id','name')->get();
        $data['countries'] = Country::where('status',1)->get();
        $main  = Hotel::findOrFail($id);
        return view('admin.hotel.edit',compact('data','main'));
    }

    public function update(Request $request , $id)
    {
        //--- Validation Section
        $rules = [
            'hotel_title' =>'required|unique:hotels,title,'.$id.'|regex:/^[a-zA-Z0-9\s-]+$/',
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'term_id' => 'required',
            'banner_image' => 'mimes:jpeg,jpg,png,svg',
            'image' => 'mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'hotel_title.required' => 'Hotel Title field is required',
           'hotel_title.unique' => 'Hotel Title has already been taken.',
           'hotel_title.regex' => 'Hotel Must Not Have Any Special Characters.',
           'description.min' => 'Minimun 10 Cherecter description required.',
           'country_id.required' => 'country field is required.',
           'state_id.required' => 'state field is required.',
           'address.required' => 'address field is required.',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'banner_image.mimes' => 'banner image format is not supported',
           'image.mimes' => 'Image format is not supported',
        ];


        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();

        if(!$request->rating){
            $input['rating'] = 0;
        }

        $input['main_price'] = PriceHelper::storePrice($request->main_price);
        $input['sale_price'] = PriceHelper::storePrice($request->sale_price);

        if($request->seo_check == 'yes'){

            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $rules = [
                'meta_tag' => 'required',
                'meta_description' => 'required',
            ];
            $customs = [
                'meta_tag.required' => 'Meta Tag field is required',
                'meta_description.required' => 'Description field is required.',
             ];

             $validator = Validator::make($request->all(), $rules, $customs);
                if ($validator->fails()) {
                    return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            }


            $input['title'] = $request->hotel_title;

            if($request->user_id){
                $input['author_id'] = $request->user_id;
                $input['author_type'] = 'user';
            }else{
                $input['author_id'] = Auth::guard('admin')->user()->id;
                $input['author_type'] = 'Admin';
            }

        // logic------------------------
        $term_id = [];
        $attr_id = [];
        foreach($request->term_id as $termX){
            $X = explode(',',$termX);
            $term_id[] = $X[0];
            $attr_id[] = $X[1];
        }


        $input['hotel_attr_id'] = implode(',',$attr_id);
        $input['attr_term_id'] = implode(',',$term_id);


        if($request->title && $request->content){
            $input['policy_title'] = implode(',,,',$request->title);
            $input['policy_content'] = implode(',,,',$request->content);
        }else{
            $input['policy_title'] = '';
            $input['policy_content'] = '';
        }

        if($request->is_extra_price == 1 && $request->extra_price_name){
            $eextra_price = [];
            foreach($request->extra_price as $tt_price){
                $eextra_price[] = PriceHelper::storePrice($tt_price);
            }

            $input['extra_price_name'] = implode(',,,',$request->extra_price_name);
            $input['extra_price'] = implode(',,,',$eextra_price);
            $input['extra_price_type'] = implode(',,,',$request->extra_price_type);
        }else{
            $input['extra_price_name'] = null;
            $input['extra_price'] =null ;
            $input['extra_price_type'] = null;
            $input['is_extra_price'] = 0;
        }
        
        $data = Hotel::findOrFail($id);
        if($request->hasFile('banner_image')){
            $image = $request->banner_image;
            
            if($data->banner_image){
                     if(file_exists(base_path('../assets/images/hotel-image/banner-image/'.$data->banner_image))){
                        unlink(base_path('../assets/images/hotel-image/banner-image/'.$data->banner_image));
            }   
            
            }
            
            $image_name = rand().$image->getClientOriginalName();
            $image_loc = base_path('../assets/images/hotel-image/banner-image/'.$image_name);
            Image::make($image)->save($image_loc);
            $input['banner_image'] = $image_name;
        }

        $input['price'] = $request->price;
        $input['slug'] = Helper::slug($input['title']);


        
        $data->update($input);

        if($request->hasFile('image')){
            $image = $request->image;
            $location = base_path('../assets/images/hotel-image/');
            Helper::ImageUpdate($image,$location,$data);
        }

        if($request->gallery){
            if(count($request->gallery) > 0){
                $type = 'hotel';
                $model = new GalleryImage;
                $imagable_id = $id;
                $location = base_path('../assets/images/hotel-image/gallery/');
                $images = $request->gallery;
                Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
            }
        }


        // logic------------------------
        $mgs = __('Data Update Successfully.');
        return response()->json($mgs);
    }


    public function destroy($id)
    {
       $data = Hotel::findOrFail($id);
        if($data->image){
            if (file_exists(base_path('../assets/images/hotel-image/'.$data->image->image))) {
                unlink(base_path('../assets/images/hotel-image/'.$data->image->image));
            }
        }

        if($data->banner_image){
            if(file_exists(base_path('../assets/images/hotel-image/banner-image/'.$data->banner_image))){
                unlink(base_path('../assets/images/hotel-image/banner-image/'.$data->banner_image));
            }
        }

        if($data->gallery->where('type','hotel')->count() > 0){
            foreach($data->gallery->where('type','hotel') as $gallery){
                if(file_exists(base_path('../assets/images/hotel-image/gallery/'.$gallery->image))){
                    unlink(base_path('../assets/images/hotel-image/gallery/'.$gallery->image));
                }
                $gallery->delete();
            }
        }

        if($data->rooms->count() > 0){
            foreach($data->rooms as $room){
                foreach($room->gallery->where('type','hotel_room') as $gal){
                    if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                        unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                    }
                    $gal->delete();
                }
            }
            $room->delete();
        }

        if(count($data->reviews) > 0){
            foreach($data->reviews->where('type','hotel') as $review){
                $review->delete();
            }
        }

       $data->delete();
       $mgs = __('Data Delete Successfully.');
       return response()->json($mgs);
    }

    public function GalleryRemove($id)
    {
        $data = GalleryImage::where('id',$id)->where('type','hotel')->first();
        if($data->image){
            if(file_exists(base_path('../assets/images/hotel-image/gallery/'.$data->image))){
                unlink(base_path('../assets/images/hotel-image/gallery/'.$data->image));
            }
        }
        $data->delete();
        $mgs = __('Image Remove Successfully.');
        return response()->json(['message' => $mgs]);
    }
   
}
