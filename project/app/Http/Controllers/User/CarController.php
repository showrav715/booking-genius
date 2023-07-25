<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarAttr;
use App\Models\GalleryImage;
use App\Models\Country;
use Validator;
use Image;
use DataTables;
use App\Helpers\Helper;
use App\Helpers\PriceHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Session;

class CarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        if (Session::has('language')) 
        {
            $this->language = DB::table('languages')->find(Session::get('language'));
        }
        else
        {
            $this->language = DB::table('languages')->where('is_default','=',1)->first();
        }  
      
        App::setlocale($this->language->name);
    }

    public function index()
    {
        return view('user.car.index');
    }


    public function datatables()
    {
        $datas = Car::orderBy('id','desc')->where('user_id',Helper::User_id())->get();
         return DataTables::of($datas)

         ->editColumn('status', function(Car $data) {
            $status = $data->status == 'publish' ?  '<span class="badge badge-success">'.__('Publish').'</span>' : '<span class="badge badge-info">'.__('Draft').'</span>';
            return $status;
        })
        ->addColumn('action', function(Car $data) {
            return '<div class="action-list">
            <a href="'.route('car.details',$data->slug).'" target="_blank"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'. route('user-car-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('user-car-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })

        ->addColumn('location', function(Car $data) {
            return $data->country->country .',' . $data->state->state . ',' . $data->address;
        })

        ->editColumn('main_price', function(Car $data) {
            $price = $data->main_price;
            return PriceHelper::showAdminCurrencyPrice($price);
        })

        ->rawColumns(['status','action','location','main_price'])
        ->toJson();
    }


    public function create()
    {
        $car_attrs = CarAttr::all();
        $countries = Country::where('status',1)->get();
        return view('user.car.create',compact('car_attrs','countries'));
    }

    public function store(Request $request)
    {
         //--- Validation Section
         $rules = [
            'title' =>'required|unique:cars,title',
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'term_id' => 'required',
            'number' => 'required',
            'banner_image'   => 'required|mimes:jpeg,jpg,png,svg',
            'image'      => 'required|mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'title.required' => 'Car Title field is required',
           'title.unique' => 'Car Title has already been taken.',
           'description.min' => 'Minimun 10 Cherecter description required.',
           'country_id.required' => 'country field is required.',
            'state_id.required' => 'state field is required.',
           'address.required' => 'Address field is required.',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'number.required' => 'car number field is required',
           'banner_image.mimes' => 'Image file format not supported',
           'image.mimes' => 'Image file format not supported',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();

        $input['main_price'] = PriceHelper::storePrice($request->price);
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

            // logic------------------------
                    $term_id = [];
                    $attr_id = [];
                    foreach($request->term_id as $termX){
                        $X = explode(',',$termX);
                        $term_id[] = $X[0];
                        $attr_id[] = $X[1];
                    }
            
                    $input['car_attr_id'] = implode(',',$attr_id);
                    $input['attr_term_id'] = implode(',',$term_id);
                    

             if($request->faq_title && $request->faq_content){
                $input['faq_title'] = Helper::Ximplode(array_filter($request->faq_title));
                $input['faq_content'] = Helper::Ximplode(array_filter($request->faq_content));
            }else{
                $input['faq_title'] = '';
                $input['faq_content'] = '';
            }

            if($request->is_extra_price == 1 && $request->extra_price_name){
                $eextra_price = [];
                foreach($request->extra_price as $tt_price){
                    $eextra_price[] = PriceHelper::storePrice($tt_price);
                }
               
                $input['extra_price_name'] = implode(',,,',array_filter($request->extra_price_name));
                $input['extra_price'] = implode(',,,',$eextra_price);
                $input['extra_price_type'] = implode(',,,',array_filter($request->extra_price_type));
                $input['is_extra_price'] = 1;
            }else{
                $input['extra_price_name'] = '';
                $input['extra_price'] ='' ;
                $input['extra_price_type'] = '';
                $input['is_extra_price'] = 0;
            }

            if($request->hasFile('banner_image')){
                $image = $request->banner_image;
                $image_name = rand().$image->getClientOriginalName();
                $image_loc = base_path('../assets/images/car/banner-image/'.$image_name);
                Image::make($image)->save($image_loc);
                $input['banner_image'] = $image_name;
            }

            
            $input['slug'] = Helper::slug($request->title);
            $input['user_id'] = Helper::User_id();
            $input['user_id'] = Helper::User_id();
            $input['author_id'] = Helper::User_id();
            $input['author_type'] = 'user';
            
     

            $data = new Car;
            $id = $data->create($input)->id;


            if($request->gallery){
                if(count($request->gallery) > 0){
                    $type = 'car';
                    $model = new GalleryImage;
                    $imagable_id = $id;
                    $location = base_path('../assets/images/car/gallery/');
                    $images = $request->gallery;
                    Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
                }
            }

            $model = Car::findOrFail($id);

            if($request->hasFile('image')){
                $file = $request->image;
                $location = base_path('../assets/images/car/feature-image/');
                Helper::MakeImage($file,$location,$model);
            }else{
               Helper::NullImage($model);
            }

            $mgs = __('Data Added Successfully.');
            return response()->json($mgs);
    }

    public function edit($id)
    {
        $car_attrs = CarAttr::all();
        $countries = Country::where('status',1)->get();
        $main = Car::findOrFail($id);
        return view('user.car.edit',compact('car_attrs','main','countries'));
    }

    public function update(Request $request , $id)
    {
        //--- Validation Section
        $rules = [
            'title' =>'required|unique:cars,title,'.$id,
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'term_id' => 'required',
            'number' => 'required',
            'banner_image'   => 'mimes:jpeg,jpg,png,svg',
            'image'      => 'mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'title.required' => 'Car title field is required',
           'title.unique' => 'Car title has already been taken.',
           'description.min' => 'Minimun 10 cherecter description required.',
           'country_id.required' => 'country field is required.',
            'state_id.required' => 'state field is required.',
           'address.required' => 'Address field is required.',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'number.required' => 'car number field is required',
           'banner_image.mimes' => 'Image file format not supported',
           'image.mimes' => 'Image file format not supported',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();

        $input['main_price'] = PriceHelper::storePrice($request->price);
        $input['sale_price'] = PriceHelper::storePrice($request->sale_price);
        
        $data  = Car::findOrFail($id);
        
        if($request->seo_check == 'yes'){
            
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $rules = [
                'meta_tag' => 'required',
                'meta_description' => 'required|min:10',
            ];
            $customs = [
                'meta_tag.required' => 'Meta Tag field is required',
                'meta_description.min' => 'Minimun 10 Cherecter description required.',
             ];

             $validator = Validator::make($request->all(), $rules, $customs);
                if ($validator->fails()) {
                    return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            }else{
               
                $input['seo_check'] = 'no';
                $input['meta_title'] = '';
                $input['meta_tag'] = '';
                $input['meta_description'] = '';
            }

            
            // logic------------------------
                    $term_id = [];
                    $attr_id = [];
                    foreach($request->term_id as $termX){
                        $X = explode(',',$termX);
                        $term_id[] = $X[0];
                        $attr_id[] = $X[1];
                    }
            
                    $input['car_attr_id'] = implode(',',$attr_id);
                    $input['attr_term_id'] = implode(',',$term_id);
                    
                    if($request->faq_title && $request->faq_content){
                        $input['faq_title'] = Helper::Ximplode(array_filter($request->faq_title));
                        $input['faq_content'] = Helper::Ximplode(array_filter($request->faq_content));
                    }else{
                        $input['faq_title'] = '';
                        $input['faq_content'] = '';
                    }

            if($request->is_extra_price == 1 && $request->extra_price_name){
                $eextra_price = [];
                foreach($request->extra_price as $tt_price){
                    $eextra_price[] = PriceHelper::storePrice($tt_price);
                }
               
                $input['extra_price_name'] = implode(',,,',array_filter($request->extra_price_name));
                $input['extra_price'] = implode(',,,',$eextra_price);
                $input['extra_price_type'] = implode(',,,',array_filter($request->extra_price_type));
                $input['is_extra_price'] = 1;
            }else{
                $input['extra_price_name'] = '';
                $input['extra_price'] ='' ;
                $input['extra_price_type'] = '';
                $input['is_extra_price'] = 0;
            }


            if($request->hasFile('banner_image')){
                if(file_exists(base_path('../assets/images/car/banner-image/'.$data->banner_image))){
                    unlink(base_path('../assets/images/car/banner-image/'.$data->banner_image));
                }
                $image = $request->banner_image;
                $image_name = rand().$image->getClientOriginalName();
                $image_loc = base_path('../assets/images/car/banner-image/'.$image_name);
                Image::make($image)->save($image_loc);
                $input['banner_image'] = $image_name;
            }

     
            
            $input['slug'] = Helper::slug($request->title);
            $input['user_id'] = Helper::User_id();
            $input['author_id'] = Helper::User_id();
            $input['author_type'] = 'user';
            
            $data->update($input);

            if($request->hasFile('image')){
                $file = $request->image;
                $location = base_path('../assets/images/car/feature-image/');
                Helper::ImageUpdate($file,$location,$data);
            }

            if($request->gallery){
                if(count($request->gallery) > 0){
                    $type = 'car';
                    $model = new GalleryImage;
                    $imagable_id = $id;
                    $location = base_path('../assets/images/car/gallery/');
                    $images = $request->gallery;
                    Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
                }
            }

            $mgs = __('Data Update Successfully.');
            return response()->json($mgs);
    }


    public function destroy($id)
    {
        $data = Car::findOrFail($id);

        if($data->gallery->where('type','car')->count() > 0){
            foreach($data->gallery->where('type','car') as $gallery){
                if(file_exists(base_path('../assets/images/car/gallery/'.$gallery->image))){
                    unlink(base_path('../assets/images/car/gallery/'.$gallery->image));  
                }
                $gallery->delete();
            }
        }

        if($data->banner_image){
            if(file_exists(base_path('../assets/images/car/banner-image/'.$data->banner_image))){
                unlink(base_path('../assets/images/car/banner-image/'.$data->banner_image));  
            }
        }
        if($data->image){
            if(file_exists(base_path('../assets/images/car/feature-image/'.$data->image->image))){
                unlink(base_path('../assets/images/car/feature-image/'.$data->image->image));  
            }
            $data->image->delete();
        }

        $data->delete();
        $mgs = __('Data Delete Successfully.');
        return response()->json($mgs);
    }

    public function GalleryRemove($id)
    {
        $data = GalleryImage::where('id',$id)->where('type','car')->first();
        if($data->image){
            if(file_exists(base_path('../assets/images/car/gallery/'.$data->image))){
                unlink(base_path('../assets/images/car/gallery/'.$data->image));
            }
        }
        $data->delete();
        $mgs = __('Image Remove Successfully.');
        return response()->json(['message' => $mgs]);
    }

}
