<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = User::orderby('id','DESC')->get();
        
         return DataTables::of($datas)
        
            ->addColumn('action', function(User $data) {
               
                return '<div class="action-list"><a class="btn btn-info btn-sm mr-1 text-white details" data-href="' . route('admin-user-show',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i> '.__('Details').'</a><a href="'. route('admin-user-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-user-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
               </div>';
            }) 

            ->editColumn('serial', function(User $data) {
                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                return $check;
             })

            ->rawColumns(['action','serial'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
  	public function index()
    {
        return view('admin.user.index');
    }


    public function edit($id)
    {  
        $data = User::findOrFail($id);  
        return view('admin.user.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:users,email,'.$id
            ];

            $custom = [
                'email.unique' => __('This email has already been taken.')
            ];
    $validator = Validator::make($request->all(), $rules,$custom);
    
    if ($validator->fails()) {
      return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
    }

        //--- Validation Section Ends
        $input = $request->all();  
        $data = User::findOrFail($id);        
            if ($file = $request->file('photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/users/',$name);
                if($data->photo != null)
                {
                    if (file_exists(base_path('../assets/images/users/'.$data->photo))) {
                        unlink(base_path('../assets/images/users/'.$data->photo));
                    }
                }            
            $input['photo'] = $name;
            } 
        $data->update($input);
        $msg = __('Successfully updated your profile');
        return response()->json($msg);
    }
 
    

    //*** GET Request
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.user.show',compact('data'));
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // hotel delete

        if(count($user->hotel) ){
           foreach($user->hotel as $hotel){

            if(count($hotel->rooms) > 0){
                foreach($hotel->rooms as $room){
                    foreach($room->gallery->where('type','hotel_room') as $gal){
                        if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                            unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                        }
                        $gal->delete();
                    }
                }
                $room->delete();
                }
            }
            
         
            if($hotel->image){
                if (file_exists(base_path('../assets/images/hotel-image/'.$hotel->image->image))) {
                    unlink(base_path('../assets/images/hotel-image/'.$hotel->image->image));
                }
            }
            
            if($hotel->banner_image){
                if(file_exists(base_path('../assets/images/hotel-image/banner-image/'.$hotel->banner_image))){
                    unlink(base_path('../assets/images/hotel-image/banner-image/'.$hotel->banner_image));  
                }
            }
    
            if($hotel->gallery->where('type','hotel')->count() > 0){
                foreach($hotel->gallery->where('type','hotel') as $gallery){
                    if(file_exists(base_path('../assets/images/hotel-image/gallery/'.$gallery->image))){
                        unlink(base_path('../assets/images/hotel-image/gallery/'.$gallery->image));  
                    }
                    $gallery->delete();
                }
            }
    
           $hotel->delete();
        }

        // hotel remove end

        // car remove start
        if(count($user->car) > 0){
            foreach($user->car as $car){
                if($car->gallery->where('type','car')->count() > 0){
                    foreach($car->gallery->where('type','car') as $gallery){
                        if(file_exists(base_path('../assets/images/car/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/car/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }
        
                if($car->banner_image){
                    if(file_exists(base_path('../assets/images/car/banner-image/'.$car->banner_image))){
                        unlink(base_path('../assets/images/car/banner-image/'.$car->banner_image));  
                    }
                }
                if($car->image){
                    if(file_exists(base_path('../assets/images/car/feature-image/'.$car->image->image))){
                        unlink(base_path('../assets/images/car/feature-image/'.$car->image->image));  
                    }
                    $car->image->delete();
                }
                $car->delete();
            }

        }
        // car remove end


        // space remove start
        if(count($user->space) > 0){
            foreach($user->space as $space){
                if($space->banner_image){
                    if(file_exists(base_path('../assets/images/space/banner-image/'.$space->banner_image))){
                        unlink(base_path('../assets/images/space/banner-image/'.$space->banner_image));
                    }
                }
                if($space->image->image){
                    if(file_exists(base_path('../assets/images/space/feature-image/'.$space->image->image))){
                        unlink(base_path('../assets/images/space/feature-image/'.$space->image->image));
                    }
                    $space->image->delete();
                }
                $space->delete();
            }
          
        }
        // space remove end

        // tour remove start
        if(count($user->tour) > 0){
            foreach($user->tour as $tour){
                if(file_exists(base_path('../assets/images/tour/feature-image/'.$tour->image->image))){
                    if($tour->image->image){
                        unlink(base_path('../assets/images/tour/feature-image/'.$tour->image->image));
                    }
                }
        
                if(file_exists(base_path('../assets/images/tour/banner-image/'.$tour->banner_image))){
                    if($tour->banner_image){
                        unlink(base_path('../assets/images/tour/banner-image/'.$tour->banner_image));
                    }
                }
                    $invertor_data = $tour->inventorys;
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
        
                    
                if($tour->gallery->where('type','tour')->count() > 0){
                    foreach($tour->gallery->where('type','tour') as $gallery){
                        if(file_exists(base_path('../assets/images/tour/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/tour/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }
                    $tour->delete();
            }
        }

        // tour remove end

        // review remove start
        if(count($user->reviews) > 0){
            foreach($user->reviews as $review){
                $review->delete();
            }
        }
        // review remove end

        // favarite remove start
        if(count($user->favarites) > 0){
            foreach($user->favarites as $favarite){
                $favarite->delete();
            }
        }
        // favarite remove end

        // notification remove start
        if(count($user->notifications) > 0){
            foreach($user->notifications as $notification){
                $notification->delete();
            }
        }
        // notification remove end

        @unlink('assets/images/users/'.$user->photo);
        $user->delete();

        $mgs = __('Data Delete Successfully');

        return response()->json($mgs);






    }





    
}
