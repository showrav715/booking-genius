<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AttrTrem;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Car;
use App\Models\CarAttr;
use App\Models\CarTerm;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Hotel;
use App\Models\HotelAttr;
use App\Models\HotelRoom;
use App\Models\Member;
use App\Models\Order;
use App\Models\Page;
use App\Models\Review;
use App\Models\Space;
use App\Models\SpaceAttr;
use App\Models\SpaceTerm;
use App\Models\State;
use App\Models\TourAttr;
use App\Models\TourCategory;
use App\Models\TourModel;
use App\Models\TourTerm;
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

     
        // blog category delete
        if($table == 'blog_categories'){
            foreach($ids as $id){
                $bcategory = BlogCategory::findOrFail($id);
                if($bcategory->blogs->count() > 0) {
                    foreach($bcategory->blogs as $cblog){
                        if($cblog->image->image){
                            if (file_exists(base_path('../assets/images/blogs/'.$cblog->image->image))) {
                                unlink(base_path('../assets/images/blogs/'.$cblog->image->image));
                            }
                            $cblog->image->delete();
                        }else{
                            $cblog->image->delete(); 
                        }
                        
                        $cblog->delete();
                    }
                }
                $bcategory->delete();
            }
        }



        // blog delete 

        if($table == 'blogs'){
            foreach($ids as $id){
                $blog = Blog::findOrFail($id);
                if($blog->image->image){
                    if (file_exists(base_path('../assets/images/blogs/'.$blog->image->image))) {
                        unlink(base_path('../assets/images/blogs/'.$blog->image->image));
                    }
                    $blog->image->delete();
                }else{
                    $blog->image->delete();
                }
                $blog->delete();
            }
        }



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



        // hotel attribute delete

        if($table == 'hotel_attrs'){
            foreach($ids as $id){
                $hotel_attr = HotelAttr::findOrFail($id);
                $check = $hotel_attr->AttrCount();
                if($check == true){
                    if(count($hotel_attr->terms) > 0){
                        foreach($hotel_attr->terms as $trem){
                            if($trem->image->image){
                                if (file_exists(base_path('../assets/images/attr-term-image/'.$trem->image->image))) {
                                    unlink(base_path('../assets/images/attr-term-image/'.$trem->image->image));
                                }
                                $trem->image->delete();
                            }else{
                                $trem->image->delete();
                            }
                            $trem->delete();
                        }
                    }
                    $hotel_attr->delete();
                }
                
            }
        }


        // hotel attribute term delete

        if($table == 'attr_trems'){
            foreach($ids as $id){
                $hotel_term = AttrTrem::findOrFail($id);
                $hotel_term_check = $hotel_term->AttrTremCount();
                if($hotel_term_check == true){
                    if($hotel_term->image->image){
                        if (file_exists(base_path('../assets/images/attr-term-image/'.$hotel_term->image->image))) {
                            unlink(base_path('../assets/images/attr-term-image/'.$hotel_term->image->image));
                        }
                        $hotel_term->image->delete();
                    }else{
                        $hotel_term->image->delete();
                    }
                }
                $hotel_term->delete();
            }

        }



        // hotel room delete

        if($table == 'hotel_rooms'){
            foreach($ids as $id){
                $hotel_room = HotelRoom::findOrFail($id);
                if($hotel_room->gallery->where('type','hotel_room')){
                    foreach($hotel_room->gallery->where('type','hotel_room') as $gal){
                            if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                                unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                            }
                            $gal->delete();
                        }
                    }
                $hotel_room->delete();
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



        // tour category delet

        if($table == 'tour_categories'){
            foreach($ids as $id){
                $tour_category = TourCategory::findOrFail($id);
                if(count($tour_category->tours) > 0){
                    foreach($tour_category->tours as $tour){
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
                            
                        $tour->delete();
                    }
                }
                $tour_category->delete();
            }
        }




        // tour attribute delete

        if($table == 'tour_attrs'){
        foreach($ids as $id){
            $tour_attr = TourAttr::findOrFail($id);
            $tour_attr_check = $tour_attr->AttrCount();
                if($tour_attr_check == true){
                    if(count($tour_attr->terms) > 0){
                        foreach($tour_attr->terms as $tourtrem){
                            if($tourtrem->image->image){
                                if (file_exists(base_path('../assets/images/attr-term-image/'.$tourtrem->image->image))) {
                                    unlink(base_path('../assets/images/attr-term-image/'.$tourtrem->image->image));
                                    $tourtrem->image->delete();
                                }else{
                                    $tourtrem->image->delete();
                                }
                            }
                            $tourtrem->delete();
                        }
                    }
                    $tour_attr->delete();
                }
            }
        }
        

        // tour attribute term delete

        if($table == 'tour_terms'){
            foreach($ids as $id){
                $tour_term = TourTerm::findOrFail($id);
                $tour_term_check = $tour_term->AttrTremCount();
                if($tour_term_check == true){
                    if($tour_term->image->image){
                        if (file_exists(base_path('../assets/images/attr-term-image/'.$tour_term->image->image))) {
                            unlink(base_path('../assets/images/attr-term-image/'.$tour_term->image->image));
                        }
                        $tour_term->image->delete();
                    }else{
                        $tour_term->image->delete();
                    }
                }
                $tour_term->delete();
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



        // space attribute delete 

        if($table == 'space_attrs'){
            foreach($ids as $id){
                $space_attr = SpaceAttr::findOrFail($id);
                $spac_attr_check = $space_attr->AttrCount();
                if($spac_attr_check == true){
                    if(count($space_attr->terms) > 0){
                        foreach($space_attr->terms as $trem){
                            if($trem->image->image){
                                if (file_exists(base_path('../assets/images/attr-term-image/'.$trem->image->image))) {
                                   unlink(base_path('../assets/images/attr-term-image/'.$trem->image->image));
                                }
                        }else{
                            $trem->image->delete();
                        }
                        $trem->delete();
                    }
                }
                    $space_attr->delete();
                }
            }
        }

        

        // space attribute term delete

        if($table == 'space_terms'){
            foreach($ids as $id){
                $space_term = SpaceTerm::findOrFail($id);
                $space_term_check = $space_term->AttrTremCount();

                if($space_term_check == true){
                    if($space_term->image->image){
                        if (file_exists(base_path('../assets/images/attr-term-image/'.$space_term->image->image))) {
                            unlink(base_path('../assets/images/attr-term-image/'.$space_term->image->image));
                            $space_term->image->delete();
                        }
                    }else{
                        $space_term->image->delete();
                    }
                    $space_term->delete();
                }
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


        // car attribute delete

        if($table == 'car_attrs'){
            foreach($ids as $id){
                $car_attribute = CarAttr::findOrFail($id);
                $car_attribute_check = $car_attribute->AttrCount();

                if($car_attribute_check == true){
                        if(count($car_attribute->terms) > 0){
                            foreach($car_attribute->terms as $trem){
                            if($trem->image && $trem->image->image){
                                if (file_exists(base_path('../assets/images/attr-term-image/'.$trem->image->image))) {
                                    unlink(base_path('../assets/images/attr-term-image/'.$trem->image->image));
                                } 
                            }
                            $trem->image->delete();
                            $trem->delete();
                        }
                    }
                    $car_attribute->delete();
                }

            }
        }


        // car attribute term delete 

        if($table == 'car_terms'){
            foreach($ids as $id){
                $car_term = CarTerm::findOrFail($id);
                $car_term_check = $car_term->AttrTremCount();

                if($car_term_check == true){
                    if($car_term->image && $car_term->image->image){
                        if (file_exists(base_path('../assets/images/attr-term-image/'.$car_term->image->image))) {
                            unlink(base_path('../assets/images/attr-term-image/'.$car_term->image->image));
                            
                        }
                    }
                $car_term->image->delete();
                $car_term->delete();
                }
            }
        }



        // car order delete

        if($table == 'orders' && $request->order_type == 'car'){
            foreach($ids as $id){
                $car_order = Order::findOrFail($id);
                $car_order->delete();
            }
        }


        // feature delete

        if($table == 'features'){
            foreach($ids as $id){
                $feature = Feature::findOrFail($id);
                if($feature->photo){
                    if (file_exists(public_path().'/assets/images/feature/'.$feature->photo)) {
                        unlink(public_path().'/assets/images/feature/'.$feature->photo);
                    }
                }
                $feature->delete();
            }
        }


        // member delete 

        if($table == 'members'){
            foreach($ids as $id){
                $member = Member::findOrFail($id);
                if($member->photo){
                    if(file_exists(base_path('../assets/images/member/'.$member->photo))){
                        unlink(base_path('../assets/images/member/'.$member->photo));
                    }
                }
                $member->delete();  
            }
        }


        // faq delete 

        if($table == 'faqs'){
            foreach($ids as $id){
                $faq = Faq::findOrFail($id);
                $faq->delete();
            }
        }

        
        
        // other page delete 
    
        if($table == 'pages'){
            foreach($ids as $id){
                $page = Page::findOrFail($id);
                $page->delete();
            }
        }


        // country delete

        if($table == 'countries'){
            foreach($ids as $id){
                $country = Country::findOrFail($id);
                // tour delete
                if($country->tour->count() > 0){
                    foreach($country->tour as $country_tour){
                        if($country_tour->image->image){
                            if(file_exists(base_path('../assets/images/tour/feature-image/'.$country_tour->image->image))){
                                if($country_tour->image->image){
                                    unlink(base_path('../assets/images/tour/feature-image/'.$country_tour->image->image));
                                }
                            }
                            $country_tour->image->delete();
                        }else{
                            $country_tour->image->delete();
                        }

                        if($country_tour->banner_image){
                            if(file_exists(base_path('../assets/images/tour/banner-image/'.$country_tour->banner_image))){
                                if($country_tour->banner_image){
                                    unlink(base_path('../assets/images/tour/banner-image/'.$country_tour->banner_image));
                                }
                            }
                        }

                        $invertor_country_tour = $country_tour->inventorys;

                        if($invertor_country_tour->count() > 0){

                            foreach($invertor_country_tour as $invData){
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

                            
                        if($country_tour->gallery->where('type','tour')->count() > 0){
                            foreach($country_tour->gallery->where('type','tour') as $gallery){
                                if($gallery->image){
                                    if(file_exists(base_path('../assets/images/tour/gallery/'.$gallery->image))){
                                        unlink(base_path('../assets/images/tour/gallery/'.$gallery->image));  
                                    }
                                }
                                $gallery->delete();
                            }
                        }

                        if(count($country_tour->reviews) > 0){
                            foreach($country_tour->reviews->where('type','tour') as $review){
                                $review->delete();
                            }
                        }
                    
                        $country_tour->delete();
                    }
                }
                // country tour delete end

                // country hotel delete

                if($country->hotel->count() > 0){
                    foreach($country->hotel as $country_hotel){
                       
                        if($country_hotel->image->image){
                            if (file_exists(base_path('../assets/images/hotel-image/'.$country_hotel->image->image))) {
                                unlink(base_path('../assets/images/hotel-image/'.$country_hotel->image->image));
                            }
                            $country_hotel->image->delete();
                        }else{
                            $country_hotel->image->delete();
                        }
                        
                        if($country_hotel->banner_image){
                            if(file_exists(base_path('../assets/images/hotel-image/banner-image/'.$country_hotel->banner_image))){
                                unlink(base_path('../assets/images/hotel-image/banner-image/'.$country_hotel->banner_image));  
                            }
                        }
                
                        if($country_hotel->gallery->where('type','hotel')->count() > 0){
                            foreach($country_hotel->gallery->where('type','hotel') as $gallery){
                                if(file_exists(base_path('../assets/images/hotel-image/gallery/'.$gallery->image))){
                                    unlink(base_path('../assets/images/hotel-image/gallery/'.$gallery->image));  
                                }
                                $gallery->delete();
                            }
                        }

                        if($country_hotel->rooms->count() > 0){
                            foreach($country_hotel->rooms as $room){
                                foreach($room->gallery->where('type','hotel_room') as $gal){
                                    if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                                        unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                                    }
                                    $gal->delete();
                                }
                                $room->delete();
                            }
                            
                        }

                        if(count($country_hotel->reviews) > 0){
                            foreach($country_hotel->reviews->where('type','hotel') as $review){
                                $review->delete();
                            }
                        }

                        $country_hotel->delete();
                    }
                }
                // country hotel delete

                // country car delete

                if($country->car->count() > 0){
                    foreach($country->car as $country_car){
                        if($country_car->gallery->where('type','car')->count() > 0){
                            foreach($country_car->gallery->where('type','car') as $gallery){
                                if(file_exists(base_path('../assets/images/car/gallery/'.$gallery->image))){
                                    unlink(base_path('../assets/images/car/gallery/'.$gallery->image));  
                                }
                                $gallery->delete();
                            }
                        }
                
                        if($country_car->banner_image){
                            if(file_exists(base_path('../assets/images/car/banner-image/'.$country_car->banner_image))){
                                unlink(base_path('../assets/images/car/banner-image/'.$country_car->banner_image));  
                            }
                        }
                        if($country_car->image){
                            if(file_exists(base_path('../assets/images/car/feature-image/'.$country_car->image->image))){
                                unlink(base_path('../assets/images/car/feature-image/'.$country_car->image->image));  
                            }
                            $country_car->image->delete();
                        }
                
                        if(count($country_car->reviews) > 0){
                            foreach($country_car->reviews->where('type','car') as $review){
                                $review->delete();
                            }
                        }
                        $country_car->delete();
                    }
                }
                // country car delete end
                // country space delete

                if($country->space->count() > 0){
                    foreach($country->space as $country_space){
                        if($country_space->banner_image){
                            if(file_exists(base_path('../assets/images/space/banner-image/'.$country_space->banner_image))){
                                unlink(base_path('../assets/images/space/banner-image/'.$country_space->banner_image));
                            }
                        }
        
                        if($country_space->image->image){
                            if(file_exists(base_path('../assets/images/space/feature-image/'.$country_space->image->image))){
                                unlink(base_path('../assets/images/space/feature-image/'.$country_space->image->image));
                            }
                            $country_space->image->delete();
                        }else{
                            $country_space->image->delete();
                        }
        
                        if($country_space->gallery->where('type','space')->count() > 0){
                            foreach($country_space->gallery->where('type','space') as $gallery){
                                if(file_exists(base_path('../assets/images/space/gallery/'.$gallery->image))){
                                    unlink(base_path('../assets/images/space/gallery/'.$gallery->image));  
                                }
                                $gallery->delete();
                            }
                        }

                        if(count($country_space->reviews) > 0){
                            foreach($country_space->reviews->where('type','space') as $review){
                                $review->delete();
                            }
                        }
                        
                        $country_space->delete();
                    }
                }
                // country space delete end

                // country state delete
                if($country->state->count() > 0){
                    foreach($country->state as $country_state){
                        $country_state->delete();
                    }
                }
                if($country->image->image){
                    if(file_exists(base_path('../assets/images/location/country/'.$country->image->image))){
                        unlink(base_path('../assets/images/location/country/'.$country->image->image));
                    }
                }
                $country->image->delete();
                $country->delete();
            }

        }



        // state delete


        if($table == 'states'){
            foreach($ids as $id){
                $state = State::findOrFail($id);
                // tour delete
                if($state->tour->count() > 0){
                    foreach($state->tour as $state_tour){
                        if($state_tour->image->image){
                            if(file_exists(base_path('../assets/images/tour/feature-image/'.$state_tour->image->image))){
                                if($state_tour->image->image){
                                    unlink(base_path('../assets/images/tour/feature-image/'.$state_tour->image->image));
                                }
                            }
                            $state_tour->image->delete();
                        }else{
                            $state_tour->image->delete();
                        }

                        if($state_tour->banner_image){
                            if(file_exists(base_path('../assets/images/tour/banner-image/'.$state_tour->banner_image))){
                                if($state_tour->banner_image){
                                    unlink(base_path('../assets/images/tour/banner-image/'.$state_tour->banner_image));
                                }
                            }
                        }

                        $invertor_state_tour = $state_tour->inventorys;

                        if($invertor_state_tour->count() > 0){

                            foreach($invertor_state_tour as $invData){
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

                            
                        if($state_tour->gallery->where('type','tour')->count() > 0){
                            foreach($state_tour->gallery->where('type','tour') as $gallery){
                                if($gallery->image){
                                    if(file_exists(base_path('../assets/images/tour/gallery/'.$gallery->image))){
                                        unlink(base_path('../assets/images/tour/gallery/'.$gallery->image));  
                                    }
                                }
                                $gallery->delete();
                            }
                        }
                    
                        if(count($state_tour->reviews) > 0){
                            foreach($state_tour->reviews->where('type','tour') as $review){
                                $review->delete();
                            }
                        }
                        $state_tour->delete();
                    }
                }
                // state tour delete end

        // state hotel delete

        if($state->hotel->count() > 0){
            foreach($state->hotel as $state_hotel){
                
                if($state_hotel->image->image){
                    if (file_exists(base_path('../assets/images/hotel-image/'.$state_hotel->image->image))) {
                        unlink(base_path('../assets/images/hotel-image/'.$state_hotel->image->image));
                    }
                    $state_hotel->image->delete();
                }else{
                    $state_hotel->image->delete();
                }
                
                if($state_hotel->banner_image){
                    if(file_exists(base_path('../assets/images/hotel-image/banner-image/'.$state_hotel->banner_image))){
                        unlink(base_path('../assets/images/hotel-image/banner-image/'.$state_hotel->banner_image));  
                    }
                }
        
                if($state_hotel->gallery->where('type','hotel')->count() > 0){
                    foreach($state_hotel->gallery->where('type','hotel') as $gallery){
                        if(file_exists(base_path('../assets/images/hotel-image/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/hotel-image/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }

                if($state_hotel->rooms->count() > 0){
                    foreach($state_hotel->rooms as $room){
                        foreach($room->gallery->where('type','hotel_room') as $gal){
                            if(file_exists(base_path('../assets/images/hotel-image/room/'.$gal->image))){
                                unlink(base_path('../assets/images/hotel-image/room/'.$gal->image));
                            }
                            $gal->delete();
                        }
                        $room->delete();
                    }
                    
                }
                if(count($state_hotel->reviews) > 0){
                    foreach($state_hotel->reviews->where('type','hotel') as $review){
                        $review->delete();
                    }
                }
                $state_hotel->delete();
            }
        }
        // state hotel delete

        // state car delete

        if($state->car->count() > 0){
            foreach($state->car as $state_car){
                if($state_car->gallery->where('type','car')->count() > 0){
                    foreach($state_car->gallery->where('type','car') as $gallery){
                        if(file_exists(base_path('../assets/images/car/gallery/'.$gallery->image))){
                            unlink(base_path('../assets/images/car/gallery/'.$gallery->image));  
                        }
                        $gallery->delete();
                    }
                }
        
                if($state_car->banner_image){
                    if(file_exists(base_path('../assets/images/car/banner-image/'.$state_car->banner_image))){
                        unlink(base_path('../assets/images/car/banner-image/'.$state_car->banner_image));  
                    }
                }
                if($state_car->image){
                    if(file_exists(base_path('../assets/images/car/feature-image/'.$state_car->image->image))){
                        unlink(base_path('../assets/images/car/feature-image/'.$state_car->image->image));  
                    }
                    $state_car->image->delete();
                }

                if(count($state_car->reviews) > 0){
                    foreach($state_car->reviews->where('type','car') as $review){
                        $review->delete();
                    }
                }
        
                $state_car->delete();
            }
        }
        // state car delete end
        // state space delete

            if($state->space->count() > 0){
                foreach($state->space as $state_space){
                    if($state_space->banner_image){
                        if(file_exists(base_path('../assets/images/space/banner-image/'.$state_space->banner_image))){
                            unlink(base_path('../assets/images/space/banner-image/'.$state_space->banner_image));
                        }
                    }

                        if($state_space->image->image){
                            if(file_exists(base_path('../assets/images/space/feature-image/'.$state_space->image->image))){
                                unlink(base_path('../assets/images/space/feature-image/'.$state_space->image->image));
                            }
                            $state_space->image->delete();
                        }else{
                            $state_space->image->delete();
                        }

                        if($state_space->gallery->where('type','space')->count() > 0){
                            foreach($state_space->gallery->where('type','space') as $gallery){
                                if(file_exists(base_path('../assets/images/space/gallery/'.$gallery->image))){
                                    unlink(base_path('../assets/images/space/gallery/'.$gallery->image));  
                                }
                                $gallery->delete();
                            }
                        }

                        if(count($state_space->reviews) > 0){
                            foreach($state_space->reviews->where('type','space') as $review){
                                $review->delete();
                            }
                        }
                        
                        $state_space->delete();
                    }
                }
                $state->delete();
            }

        }


        // review bulk option

        if($table == 'reviews' && $type == 'delete'){
            foreach($ids as $id){
                $review_delete = Review::findOrFail($id);
                $review_delete->delete();
            } 
        
        }

        if($table == 'reviews' && $type == 'approved'){
            foreach($ids as $id){
                $review_approved = Review::findOrFail($id);
                $review_approved->status = 'Publish';
                $review_approved->update();
            }
        }

        if($table == 'reviews' && $type == 'pending'){
            foreach($ids as $id){
                $review_pending = Review::findOrFail($id);
                $review_pending->status = 'Pending';
                $review_pending->update();

            }
        }


        // staff delete 
        if($table == 'admins'){
            foreach($ids as $id){
                if($id != 1){
                    $staff = Admin::findOrFail($id);
                    if($staff->photo){
                        if (file_exists(base_path('../assets/images/admins/'.$staff->photo))) {
                            unlink(base_path('../assets/images/admins/'.$staff->photo));
                        }
                    }
                    $staff->delete();
                }
            }
        }






















        return response()->json(['status' => 1,'message' => __('Bulk '.$request->type.' Successfully')]);
        
    }
    



}
