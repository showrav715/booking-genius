<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Space;
use App\Helpers\Helper;
use App\Helpers\PriceHelper;
use App\Models\GalleryImage;
use App\Models\SpaceAttr;
use App\Models\Country;
use Image;
use DataTables;


class SpaceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('user.space.index');
    }

    public function datatables()
    {
        $datas = Space::orderBy('id','desc')->where('user_id',Helper::User_id())->get();
         return DataTables::of($datas)

         ->editColumn('status', function(Space $data) {
            $status = $data->status == 'publish' ?  '<span class="badge badge-success">'.__('Publish').'</span>' : '<span class="badge badge-info">'.__('Draft').'</span>';
            return $status;
        })
        ->addColumn('action', function(Space $data) {
            return '<div class="action-list">
            <a href="'.route('space.details',$data->slug).'" target="_blank"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'. route('user-space-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('user-space-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })
        ->addColumn('location', function(Space $data) {
            return $data->country->country .',' . $data->state->state . ',' . $data->address;
        })

        ->editColumn('main_price', function(Space $data) {
            $price = $data->main_price;
            return PriceHelper::showAdminCurrencyPrice($price);
        })

        ->rawColumns(['status','action','location','main_price'])
        ->toJson();
    }


    public function create()
    {
        $space_attr = SpaceAttr::all();
        $countries = Country::where('status',1)->get();
        
        return view('user.space.create',compact('space_attr','countries'));
    }

    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'title' =>'required|unique:spaces,title',
            'description' => 'required|min:10',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'term_id' => 'required',
        ];

        $customs = [
            'title.required' => 'Space title field is required',
            'title.unique' => 'Space title has already been taken.',
            'title.regex' => 'Space must not have any special characters.',
            'description.min' => 'Minimun 10 cherecter description required.',
            'country_id.required' => 'Country field is required.',
            'state_id.required' => 'State field is required.',
            'address.required' => 'Address field is required.',
            'term_id.required' => 'Minimun 1 attribute Term is required',
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
 
         $input['space_attr_id'] = implode(',',$attr_id);
         $input['attr_term_id'] = implode(',',$term_id);
        
         if($request->is_extra_price == 1 && $request->extra_price){
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
            $input['extra_price'] = '' ;
            $input['extra_price_type'] = '';
            $input['is_extra_price'] = 0;
        }

      
        if($request->faq_title && $request->faq_content){
            $input['faq_title'] = Helper::Ximplode(array_filter($request->faq_title));
            $input['faq_content'] = Helper::Ximplode(array_filter($request->faq_content));
        }else{
            $input['faq_title'] = '';
            $input['faq_content'] = '';
        }

        
        if($request->hasFile('banner_image')){
            $image = $request->banner_image;
            $image_name = rand().$image->getClientOriginalName();
            $image_loc = base_path('../assets/images/space/banner-image/'.$image_name);
            Image::make($image)->save($image_loc);
            $input['banner_image'] = $image_name;
        }

        $input['slug'] = Helper::slug($request->title);
        $input['user_id'] = Helper::User_id();
        $input['author_id'] = Helper::User_id();
        $input['author_type'] = 'user';

        $data = new Space;
        $id = $data->create($input)->id;

        if($request->gallery){
            if(count($request->gallery) > 0){
                $type = 'space';
                $model = new GalleryImage;
                $imagable_id = $id;
                $location = base_path('../assets/images/space/gallery/');
                $images = $request->gallery;
                Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
            }
        }


        $model = Space::findOrFail($id);

        if($request->hasFile('image')){
            $image = $request->image;
            $location = base_path('../assets/images/space/feature-image/');
            Helper::MakeImage($image,$location,$model);
        }else{
            Helper::NullImage($model);
        }

        $mgs = __('Data Added Succesfully.');
        return response()->json($mgs);

    }


    public function edit($id)
    {
        $spaceAttr = SpaceAttr::all();
        $main = Space::findOrFail($id);
        $countries = Country::where('status',1)->get();

        return view('user.space.edit',compact('spaceAttr','main','countries'));
    }


    public function update(Request $request , $id)
    {
       
        //--- Validation Section
        $rules = [
            'title' =>'required|unique:spaces,title,'.$id,
            'description' => 'required|min:10',
            'state_id' => 'required',
            'address' => 'required',
            'address' => 'required',
            'term_id' => 'required',
        ];

        $customs = [
            'title.required' => 'Space title field is required',
            'title.unique' => 'Space Title has already been taken.',
            'title.regex' => 'Space must not have any special characters.',
            'description.min' => 'Minimun 10 cherecter description required.',
            'country_id.required' => 'Country field is required.',
            'state_id.required' => 'State field is required.',
            'address.required' => 'Address field is required.',
            'term_id.required' => 'Minimun 1 attribute term is required',
        ];
    
            $validator = Validator::make($request->all(), $rules, $customs);
                if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

        $input = $request->all();

        $input['main_price'] = PriceHelper::storePrice($request->price);
        $input['sale_price'] = PriceHelper::storePrice($request->sale_price);
        

        $data = Space::findOrFail($id);
            
        if($request->seo_check == 'yes'){
            
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag);
            $rules = [
                'meta_tag' => 'required',
                'meta_description' => 'required|min:10',
            ];
            $customs = [
                'meta_tag.required' => 'Meta Tag field is required',
                'meta_description.min' => 'Minimun 10 cherecter description required.',
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
 
         $input['space_attr_id'] = implode(',',$attr_id);
         $input['attr_term_id'] = implode(',',$term_id);

         if($request->is_feature){
             $input['is_feature'] = 1;
         }else{
             $input['is_feature'] = 0;
         }

         if($request->is_extra_price == 1 && $request->extra_price){
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
            $input['extra_price'] = '' ;
            $input['extra_price_type'] = '';
            $input['is_extra_price'] = 0;
        }

        if($request->faq_title && $request->faq_content){
            $input['faq_title'] = Helper::Ximplode(array_filter($request->faq_title));
            $input['faq_content'] = Helper::Ximplode(array_filter($request->faq_content));
        }else{
            $input['faq_title'] = '';
            $input['faq_content'] = '';
        }

        $input['author_id'] = Helper::User_id();
        $input['author_type'] = 'user';

        
        if($request->hasFile('banner_image')){

            if(file_exists(base_path('../assets/images/space/banner-image/'.$data->banner_image))){
                if($data->banner_image){
                    unlink(base_path('../assets/images/space/banner-image/'.$data->banner_image));
                } 
            }
            $image = $request->banner_image;
            $image_name = rand().$image->getClientOriginalName();
            $image_loc = base_path('../assets/images/space/banner-image/'.$image_name);
            Image::make($image)->save($image_loc);
            $input['banner_image'] = $image_name;
        }

        $input['slug'] = Helper::slug($request->title);
        $input['user_id'] = Helper::User_id();

        $data->update($input);


        if($request->gallery){
            if(count($request->gallery) > 0){
                $type = 'space';
                $model = new GalleryImage;
                $imagable_id = $id;
                $location = base_path('../assets/images/space/gallery/');
                $images = $request->gallery;
                Helper::GalleryUpload($images,$type,$imagable_id,$model,$location);
            }
        }

        if($request->hasFile('image')){
            $image = $request->image;
            $location = base_path('../assets/images/space/feature-image/');
            Helper::ImageUpdate($image,$location,$data);
        }
       
        $mgs = __('Data Update Successfully.');
        return response()->json($mgs);
    }


    public function destroy($id)
    {
        $data = Space::findOrFail($id);
        
        if($data->banner_image){
            if(file_exists(base_path('../assets/images/space/banner-image/'.$data->banner_image))){
                unlink(base_path('../assets/images/space/banner-image/'.$data->banner_image));
            }
        }
        if($data->image->image){
            if(file_exists(base_path('../assets/images/space/feature-image/'.$data->image->image))){
                unlink(base_path('../assets/images/space/feature-image/'.$data->image->image));
            }
            $data->image->delete();
        }
        
        $data->delete();

        $mgs = __('Data Delete Succssfully.');
        return response()->json($mgs);
    }

    public function GalleryRemove($id)
    {
        $data = GalleryImage::where('id',$id)->where('type','space')->first();
        if($data->image){
            if(file_exists(base_path('../assets/images/space/gallery/'.$data->image))){
                unlink(base_path('../assets/images/space/gallery/'.$data->image));
            }
        }
        $data->delete();
        $mgs = __('Image Remove Successfully.');
        return response()->json(['message' => $mgs]);
    }

}
