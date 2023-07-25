<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Space;
use App\Models\TourModel;
use Illuminate\Http\Request;

class BulkDeleteController extends Controller
{
    public function bulkdelete(Request $request)
    {
    
        if(!$request->type){
            return response()->json(['status' => 0,'message' => __('Please select bulk action type')]);
        }

        if(!$request->ids){
            return response()->json(['status' => 0,'message' => __('Bulk item not found')]);
        }

        $ids = explode(',',$request->ids);
        $table = $request->table;
        $type = $request->type;


            // hotel delete

        if($table == 'hotels'){
            foreach($ids as $id){
                $hotel = Hotel::findOrFail($id);

                if($hotel->image->image){
                    if (file_exists(base_path('../assets/images/hotel-image/'.$hotel->image->image))) {
                        unlink(base_path('../assets/images/hotel-image/'.$hotel->image->image));
                    }
                    $hotel->image->delete();
                }else{
                    $hotel->image->delete();
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

                if($hotel->rooms->count() > 0){
                    foreach($hotel->rooms as $room){
                        foreach($room->gallery->where('type','hotel_room') as $gal){
                            if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                                unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                            }
                            $gal->delete();
                        }
                        $room->delete();
                    }
                    
                }

                if(count($hotel->reviews) > 0){
                    foreach($hotel->reviews->where('type','hotel') as $review){
                        $review->delete();
                    }
                }
                $hotel->delete();
            }
        }



       

        // hotel order delete 

        if($table == 'orders' && $request->order_type == 'hotel'){
            foreach($ids as $id){
                $hotel_order = Order::findOrFail($id);
                foreach($hotel_order->rooms as $order_room){
                    $order_room->delete();
                }
                $hotel_order->delete();
            }
        }





        // tour delete

        if($table == 'tour_models'){
            foreach($ids as $id){
                $tour = TourModel::findOrFail($id);

                if($tour->image->image){
                    if(file_exists(base_path('../assets/images/tour/feature-image/'.$tour->image->image))){
                        if($tour->image->image){
                            unlink(base_path('../assets/images/tour/feature-image/'.$tour->image->image));
                        }
                    }
                    $tour->image->delete();
                }else{
                    $tour->image->delete();
                }

                if($tour->banner_image){
                    if(file_exists(base_path('../assets/images/tour/banner-image/'.$tour->banner_image))){
                        if($tour->banner_image){
                            unlink(base_path('../assets/images/tour/banner-image/'.$tour->banner_image));
                        }
                    }
                }

                $invertor_tour = $tour->inventorys;

                if($invertor_tour->count() > 0){

                    foreach($invertor_tour as $invData){
                        if($invData->image){
                            if(file_exists(base_path('../assets/images/tour/inventory-image/'.$invData->image))){
                                if($invData->image){
                                    unlink(base_path('../assets/images/tour/inventory-image/'.$invData->image));
                                }
                            }
                        }
                        $invData->delete();
                    }
                  
                }

                    
                if($tour->gallery->where('type','tour')->count() > 0){
                    foreach($tour->gallery->where('type','tour') as $gallery){
                        if($gallery->image){
                            if(file_exists(base_path('../assets/images/tour/gallery/'.$gallery->image))){
                                unlink(base_path('../assets/images/tour/gallery/'.$gallery->image));  
                            }
                        }
                        $gallery->delete();
                    }
                }

                if(count($tour->reviews) > 0){
                    foreach($tour->reviews->where('type','tour') as $review){
                        $review->delete();
                    }
                }
                    
                $tour->delete();
            }
        }



        // tour orders delete

        if($table == 'orders' && $request->order_type == 'tour'){
            foreach($ids as $id){
                $order = Order::findOrFail($id);
                $order->delete();
            }
        }

        

        // spaces delete

        if($table == 'spaces'){
            foreach($ids as $id){
                $space = Space::findOrFail($id);

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
                }else{
                    $space->image->delete();
                }

                if($space->gallery->where('type','space')->count() > 0){
                    foreach($space->gallery->where('type','space') as $gallery){
                        if(file_exists(base_path('../assets/images/space/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/space/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }
                
                if(count($space->reviews) > 0){
                    foreach($space->reviews->where('type','space') as $review){
                        $review->delete();
                    }
                }
                $space->delete();
            }
        
        }



        // space order delete 

        if($table == 'orders' && $request->order_type == 'space'){
            foreach($ids as $id){
                $space_order = Order::findOrFail($id);
                $space_order->delete();
            }
        }


        // car delete 

        if($table == 'cars'){
            foreach($ids as $id){
                $cars = Car::findOrFail($id);

                if($cars->gallery->where('type','car')->count() > 0){
                    foreach($cars->gallery->where('type','car') as $gallery){
                        if(file_exists(base_path('../assets/images/car/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/car/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }
        
                if($cars->banner_image){
                    if(file_exists(base_path('../assets/images/car/banner-image/'.$cars->banner_image))){
                        unlink(base_path('../assets/images/car/banner-image/'.$cars->banner_image));  
                    }
                }
                if($cars->image){
                    if(file_exists(base_path('../assets/images/car/feature-image/'.$cars->image->image))){
                        unlink(base_path('../assets/images/car/feature-image/'.$cars->image->image));  
                    }
                    $cars->image->delete();
                }

                if(count($cars->reviews) > 0){
                    foreach($cars->reviews->where('type','car') as $review){
                        $review->delete();
                    }
                }
        
                $cars->delete();
            }
        }


        


        // car order delete

        if($table == 'orders' && $request->order_type == 'car'){
            foreach($ids as $id){
                $car_order = Order::findOrFail($id);
                $car_order->delete();
            }
        }





        
    }

}