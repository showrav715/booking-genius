<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\TourModel;
use App\Models\Space;
use App\Models\Car;
use App\Models\Hotel;
use Session;
use Auth;


class ReviewController extends Controller
{
    public function reviewstore(Request $request)
    {
        $user = Auth::user();

        if($request->review || $request->comment){
            if(Review::where('user_id',$user->id)->where('type',$request->type)->where('review_id',$request->review_id)->exists()){
                $exists = Review::where('user_id',$user->id)->where('type',$request->type)->where('review_id',$request->review_id)->first();
                if($request->review){
                    $exists->update([
                        'review' => $request->review,
                    ]);
                    $avgreview = Review::where('review_id',$request->review_id)->where('type',$request->type)->avg('review');
                    if($request->type == 'tour'){
                        TourModel::find($request->review_id)->update([
                            'average_review' => $avgreview
                        ]);
                    }elseif($request->type == 'space'){
                        Space::find($request->review_id)->update([
                            'average_review' => $avgreview
                        ]);  
                    }elseif($request->type == 'car'){
                        Car::find($request->review_id)->update([
                            'average_review' => $avgreview
                        ]);   
                    }else{
                        
                        Hotel::find($request->review_id)->update([
                            'average_review' => $avgreview
                        ]);  
                    }

                   
                    
                }if($request->comment){
                    $exists->update([
                        'comment' => $request->comment,
                    ]);
                }
                Session::flash('success','Review update successfully');
                return back();

            }else{
                $input = $request->all();
                $input['user_id'] = $user->id;
                $data = new Review;
                $data->create($input);
                $avgreview = Review::where('review_id',$request->review_id)->where('type',$request->type)->avg('review');
                if($request->type == 'tour'){
                    TourModel::find($request->review_id)->update([
                        'average_review' => $avgreview
                    ]);
                }elseif($request->type == 'space'){
                    Space::find($request->review_id)->update([
                        'average_review' => $avgreview
                    ]);  
                }elseif($request->type == 'car'){
                    Car::find($request->review_id)->update([
                        'average_review' => $avgreview
                    ]);   
                }else{
                    Hotel::find($request->review_id)->update([
                        'average_review' => $avgreview
                    ]);  
                }
               
                Session::flash('success','Review submit successfully');
                return back();
            } 
        }else{
            Session::flash('error', 'Review submit not succesfull');
            return back();
        }
    }
}
