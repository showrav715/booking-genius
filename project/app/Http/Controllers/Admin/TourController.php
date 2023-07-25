<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Models\TourModel;
use App\Models\Country;
use App\Models\TourInventory;
use App\Models\TourAttr;
use App\Models\User;
use App\Models\GalleryImage;
use App\Helpers\Helper;
use App\Models\TourCategory;
use Image;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }



    public function index()
    {
        return view('admin.tour.index');
    }

    public function datatables()
    {
        $datas = TourModel::orderBy('id','desc')->get();
         return DataTables::of($datas)

         ->editColumn('status', function(TourModel $data) {
            $status = $data->status == 'publish' ?  '<span class="badge badge-success">'.__('Publish').'</span>' : '<span class="badge badge-info">'.__('Draft').'</span>';
            return $status;
        })
       
        ->addColumn('location', function(TourModel $data) {
            return  $data->state->state;
        })
        ->addColumn('action', function(TourModel $data) {
            return '<div class="action-list">
            <a href="'.route('tour.details',$data->slug).'" target="_blank"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'. route('admin-tour-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-tour-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
            </div>';
        })

        ->editColumn('serial', function(TourModel $data) {
            $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
            return $check;
         })

        ->editColumn('main_price', function(TourModel $data) {
            $price = $data->main_price;
            return PriceHelper::showAdminCurrencyPrice($price);
        })

        ->rawColumns(['status','action','location','main_price','serial'])
        ->toJson();
    }


    public function create()
    {
        $data['users'] = User::select('id','name')->get();
        $data['tourAttr'] = TourAttr::all();
        $data['tourCat'] = TourCategory::where('status',1)->get();
        $data['countries'] = Country::where('status',1)->get();
        return view('admin.tour.create',compact('data'));
    }


    public function store(Request $request)
    {
        
        //--- Validation Section
        $rules = [
            'tour_title' =>'required|unique:tour_models,title',
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'category_id' => 'required',
            'main_price' => 'required',
            'min_people' => 'required',
            'max_people' => 'required',
            'term_id' => 'required',
            'banner_image'   => 'required|mimes:jpeg,jpg,png,svg',
            'image'      => 'required|mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'tour_title.required' => 'Tour title field is required',
           'tour_title.unique' => 'Tour title has already been taken.',
           'main_price.required' => 'Price field is required.',
           'description.min' => 'Minimun 10 cherecter description required.',
           'category_id.required' => 'Category field is required.',
           'country_id.required' => 'Country field is required.',
           'state_id.required' => 'State field is required.',
           'address.required' => 'Address field is required.',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'banner_image.mimes' => 'Image file format not supported',
           'image.mimes' => 'Image file format not supported',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();

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

            if($request->user_id){
                $input['author_id'] = $request->user_id;
                $input['author_type'] = 'user';
            }else{
                $input['author_id'] = Auth::guard('admin')->user()->id;
                $input['author_type'] = 'Admin';
            }

            
            $input['title'] = $request->tour_title;
            
            $term_id = [];
            $attr_id = [];
            foreach($request->term_id as $termX){
                $X = explode(',',$termX);
                $term_id[] = $X[0];
                $attr_id[] = $X[1];
            }

            $input['tour_attr_id'] = implode(',',$attr_id);
            $input['attr_term_id'] = implode(',',$term_id);
   

            if($request->faq_title && $request->faq_content){
                $input['faq_title'] = Helper::Ximplode($request->faq_title);
                $input['faq_content'] = Helper::Ximplode($request->faq_content);
            }

            if($request->include){
                $input['include'] = Helper::Ximplode($request->include);
            }
            if($request->exclude){
                $input['exclude'] = Helper::Ximplode($request->exclude);
            }

            
            if($request->is_person == 1 && $request->person_type){
                
                $pperson_price = [];
                
                foreach($request->person_type_price as $pp_price){
                    $pperson_price[] = PriceHelper::storePrice($pp_price);
                }

                $input['person_type'] = implode(',,,',array_filter($request->person_type));
                $input['person_type_min'] = implode(',,,',array_filter($request->person_type_min));
                $input['person_type_max'] = implode(',,,',array_filter($request->person_type_max));
                $input['person_type_price'] = implode(',,,',$pperson_price);
                $input['is_person'] = 1;
            }else{
                $input['person_type'] = '';
                $input['person_type_min'] = '';
                $input['person_type_max'] = '';
                $input['person_type_price'] = '';
                $input['is_person'] = 0;
            }




           
            if($request->is_extra_price == 1 && $request->extra_price_name){
                $eextra_price = [];
                foreach($request->extra_price as $tt_price){
                    $eextra_price[] = PriceHelper::storePrice($tt_price);
                }
               
                $input['extra_price_name'] = implode(',,,',array_filter($request->extra_price_name));
                $input['extra_price'] = implode(',,,',array_filter($eextra_price));
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
                $image_loc = base_path('../assets/images/tour/banner-image/'.$image_name);
                Image::make($image)->save($image_loc);
                $input['banner_image'] = $image_name;
            }

            $input['tour_min_people'] = $request->min_people;
            $input['tour_max_people'] = $request->max_people;
           
            $input['slug'] = Helper::slug($request->tour_title);

            $data = new TourModel;
            $id = $data->create($input)->id;

            if($request->gallery){
                if(count($request->gallery) > 0){
                    $type = 'tour';
                    $model = new GalleryImage;
                    $imagable_id = $id;
                    $location = base_path('../assets/images/tour/gallery/');
                    $images = $request->gallery;
                    Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
                }
            }
   

            if($request->inventory_title && $request->inventory_desc && $request->inventory_content && $request->inventory_image){
                foreach($request->inventory_title as $key => $inventory_title){
                    if($request->hasFile('inventory_image')){
                       
                        $name = rand(). $request->inventory_image[$key]->getClientOriginalName();
                        $loc = base_path('../assets/images/tour/inventory-image/'.$name);
                        
                        Image::make($request->inventory_image[$key])->save($loc);
                        TourInventory::insert([
                            'tour_id' => $id,
                            'title' => $inventory_title,
                            'description' =>  $request->inventory_desc[$key],
                            'content' => $request->inventory_content[$key],
                            'image' => $name
                        ]);
                    } 
                }  
            }

           $model = TourModel::findOrFail($id);

            if($request->hasFile('image')){
                $file = $request->image;
                $location = base_path('../assets/images/tour/feature-image/');
                Helper::MakeImage($file,$location,$model);
            }else{
               Helper::NullImage($model);
            }

            $mgs = __('Data Added Successfully.');
            return response()->json($mgs);
    }


    public function edit($id)
    {
        $data['users'] = User::select('id','name')->get();
        $data['tourAttr'] = TourAttr::all();
        $data['tourCat'] = TourCategory::where('status',1)->get();
        $data['countries'] = Country::where('status',1)->get();
        $main = TourModel::findOrFail($id);
        return view('admin.tour.edit',compact('data','main'));
    }


    public function update(Request $request , $id)
    {
 
        $data = TourModel::findOrFail($id);
        //--- Validation Section
        $rules = [
            'tour_title' =>'required|unique:tour_models,title,'.$id,
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'category_id' => 'required',
            'main_price' => 'required',
            'min_people' => 'required',
            'max_people' => 'required',
            'term_id' => 'required',
            'banner_image'   => 'mimes:jpeg,jpg,png,svg',
            'image'      => 'mimes:jpeg,jpg,png,svg',
        ];
        $customs = [
           'tour_title.required' => 'Tour Title field is required',
           'tour_title.unique' => 'Tour Title has already been taken.',
           'main_price.required' => 'Price field is required.',
           'description.min' => 'Minimun 10 Cherecter description required.',
           'category_id.required' => 'Category field is required.',
           'country_id.required' => 'country field is required.',
           'state_id.required' => 'state field is required.',
           'address.required' => 'address field is required.',
           'term_id.required' => 'Minimun 1 Attribute Term is required',
           'banner_image.mimes' => 'Image file format not supported',
           'image.mimes' => 'Image file format not supported',
        ];

        $validator = Validator::make($request->all(), $rules, $customs);
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        
        $input = $request->all();

        $input['main_price'] = PriceHelper::storePrice($request->main_price);
        $input['sale_price'] = PriceHelper::storePrice($request->sale_price);
        
       
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
            }
        
            $input['title'] = $request->tour_title;
            
            $term_id = [];
            $attr_id = [];
            foreach($request->term_id as $termX){
                $X = explode(',',$termX);
                $term_id[] = $X[0];
                $attr_id[] = $X[1];
            }

            $input['tour_attr_id'] = implode(',',$attr_id);
            $input['attr_term_id'] = implode(',',$term_id);
   

            if($request->faq_title && $request->faq_content){
                $input['faq_title'] = Helper::Ximplode($request->faq_title);
                $input['faq_content'] = Helper::Ximplode($request->faq_content);
            }

            if($request->user_id){
                $input['author_id'] = $request->user_id;
                $input['author_type'] = 'user';
            }else{
                $input['author_id'] = Auth::guard('admin')->user()->id;
                $input['author_type'] = 'Admin';
            }

      
            if($request->include){
                $input['include'] = Helper::Ximplode($request->include);
            }
            if($request->exclude){
                $input['exclude'] = Helper::Ximplode($request->exclude);
            }

               
            if($request->is_person == 1 && $request->person_type){
                
                $pperson_price = [];
                
                foreach($request->person_type_price as $pp_price){
                    $pperson_price[] = PriceHelper::storePrice($pp_price);
                }

                $input['person_type'] = implode(',,,',array_filter($request->person_type));
                $input['person_type_min'] = implode(',,,',array_filter($request->person_type_min));
                $input['person_type_max'] = implode(',,,',array_filter($request->person_type_max));
                $input['person_type_price'] = implode(',,,',$pperson_price);
                $input['is_person'] = 1;
            }else{
                $input['person_type'] = '';
                $input['person_type_min'] = '';
                $input['person_type_max'] = '';
                $input['person_type_price'] = '';
                $input['is_person'] = 0;
            }




           
            if($request->is_extra_price == 1 && $request->extra_price_name){
                $eextra_price = [];
                foreach($request->extra_price as $tt_price){
                    $eextra_price[] = PriceHelper::storePrice($tt_price);
                }
               
                $input['extra_price_name'] = implode(',,,',array_filter($request->extra_price_name));
                $input['extra_price'] = implode(',,,',array_filter($eextra_price));
                $input['extra_price_type'] = implode(',,,',array_filter($request->extra_price_type));
                $input['is_extra_price'] = 1;
            }else{

                $input['extra_price_name'] = '';
                $input['extra_price'] ='' ;
                $input['extra_price_type'] = '';
                $input['is_extra_price'] = 0;
               
            }

            if($request->hasFile('banner_image')){
                if($data->banner_image){
                    if(file_exists(base_path('../assets/images/tour/banner-image/'.$data->banner_image))){
                        unlink(base_path('../assets/images/tour/banner-image/'.$data->banner_image));
                    }
                }
                $image = $request->banner_image;
                $image_name = rand().$image->getClientOriginalName();
                $image_loc = base_path('../assets/images/tour/banner-image/'.$image_name);
                Image::make($image)->save($image_loc);
                $input['banner_image'] = $image_name;
            }

            if($request->gallery){
                if(count($request->gallery) > 0){
                    $type = 'tour';
                    $model = new GalleryImage;
                    $imagable_id = $id;
                    $location = base_path('../assets/images/tour/gallery/');
                    $images = $request->gallery;
                    Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
                }
            }

            $input['tour_min_people'] = $request->min_people;
            $input['tour_max_people'] = $request->max_people;
            $input['slug'] = Helper::slug($request->tour_title);
            $data->update($input);

          
                if($request->inventory_title && $request->inventory_desc && $request->inventory_content){
                $invertoryDatas = TourInventory::where('tour_id',$id)->get();
                if(count($invertoryDatas) > 0){
                foreach($invertoryDatas as $key => $inv){
                        $inv->update([
                            'tour_id' => $id,
                            'title' => $request->inventory_title[$key],
                            'description' =>  $request->inventory_desc[$key],
                            'content' => $request->inventory_content[$key],
                        ]);
                    }   
                } 
            }

            if($request->hasFile('image')){
                $file = $request->image;
                $location = base_path('../assets/images/tour/feature-image/');
                Helper::ImageUpdate($file,$location,$data);
            }

            $mgs = __('Data Update Successfully.');
            return response()->json($mgs);
    }


    public function inventoryUpdate(Request $request , $id){

        $rules = [
            'image'      => 'mimes:jpeg,jpg,png,svg',
        ];
        

        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
            return response()->json(['message'=>'Image file format not supported']);
        }



        $image = $request->image;
        $data = TourInventory::findOrFail($id);
        if(file_exists(base_path('../assets/images/tour/inventory-image/'.$data->image))){
            if($data->image){
                unlink(base_path('../assets/images/tour/inventory-image/'.$data->image));
            }   
        }
        $name = rand(). $image->getClientOriginalName();
        $loc = base_path('../assets/images/tour/inventory-image/'.$name);
        Image::make($image)->save($loc);

        $data->update([
            'image' => $name
        ]);

        $mgs = __('Image Upload Successfully.');
        return response()->json(['message'=>$mgs]);
        
    }


    public function inventoryNewUpload(Request $request , $id)
    {
        $rules = [
            'image'      => 'mimes:jpeg,jpg,png,svg',
        ];
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
            return response()->json(['message'=>'Image file format not supported','status'=>0]);
        }


        $image = $request->image;
        $name = rand(). $image->getClientOriginalName();
        $loc = base_path('../assets/images/tour/inventory-image/'.$name);
        Image::make($image)->save($loc);

        TourInventory::insert([
            'image' => $name,
            'tour_id' => $id
        ]);

        $mgs = __('Image Upload Successfully.');
        return response()->json(['message'=>$mgs,'status'=>1]);
    }

    public function inventoryRemove($id)
    {
        $data = TourInventory::findOrFail($id);

        if(file_exists(base_path('../assets/images/tour/inventory-image/'.$data->image))){
            if($data->image){
                unlink(base_path('../assets/images/tour/inventory-image/'.$data->image));
            }
        }
        $data->delete();

        $mgs = __('Data Delete Successfully.');
        return response()->json(['message'=>$mgs]);
    }


    public function destroy($id)
    {
        $data = TourModel::findOrFail($id);
        if(file_exists(base_path('../assets/images/tour/feature-image/'.$data->image->image))){
            if($data->image->image){
                unlink(base_path('../assets/images/tour/feature-image/'.$data->image->image));
            }
        }

        if(file_exists(base_path('../assets/images/tour/banner-image/'.$data->banner_image))){
            if($data->banner_image){
                unlink(base_path('../assets/images/tour/banner-image/'.$data->banner_image));
            }
        }
            $invertor_data = $data->inventorys;
            if($invertor_data->count() > 0){

                foreach($invertor_data as $invData){
                    if(file_exists(base_path('../assets/images/tour/inventory-image/'.$invData->image))){
                        if($invData->image){
                            unlink(base_path('../assets/images/tour/inventory-image/'.$invData->image));
                        }
                    }
                }
                foreach($invertor_data as $invD){
                    $invD->delete();
                }
            }

            
        if($data->gallery->where('type','tour')->count() > 0){
            foreach($data->gallery->where('type','tour') as $gallery){
                if(file_exists(base_path('../assets/images/tour/gallery/'.$gallery->image))){
                    unlink(base_path('../assets/images/tour/gallery/'.$gallery->image));  
                }
                $gallery->delete();
            }
        }

        if(count($data->reviews) > 0){
            foreach($data->reviews->where('type','tour') as $review){
                $review->delete();
            }
        }
            
            $data->delete();

            $mgs = __('Data Delete Successfully.');
            return response()->json($mgs);
    }


    public function GalleryRemove($id)
    {
        $data = GalleryImage::where('id',$id)->where('type','tour')->first();
        if($data->image){
            if(file_exists(base_path('../assets/images/tour/gallery/'.$data->image))){
                unlink(base_path('../assets/images/tour/gallery/'.$data->image));
            }
        }
        $data->delete();
        $mgs = __('Image Remove Successfully.');
        return response()->json(['message' => $mgs]);
    }


}
