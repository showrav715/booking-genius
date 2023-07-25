<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Space;
use App\Models\TourModel;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.review.index');
    }

    public function datatables()
    {

        $datas = Review::orderBy('id','desc')->get();

         return DataTables::of($datas)
    
        ->addColumn('author', function(Review $data) {
            $author = User::findOrFail($data->user_id);
            $user = '
            <ul>
                 <li>'.$author->name.'</li>
                 <li>'.$author->email.'</li>
             </ul>
            ';
            return $user;
        })

        ->editColumn('review', function(Review $data) {

           $return = '
           <p class="text-mute">'.$data->comment.'</p>
           <div class="stars">
                <div class="ratings">
                    <div class="empty-stars"></div>
                    <div class="full-stars" style="width:'.($data->review * 20).'%"></div>
                    </div>
            </div>';

            return $return;
        })
        ->editColumn('status', function(Review $data) {
            $class = $data->status == 'Pending' ? 'badge badge-info' : 'badge badge-success';
            $return = '<p class="'.$class.'">'.$data->status.'</p>';
            return $return;
        })


        ->editColumn('review_id', function(Review $data) {
            $review ='<p class="badge badge-dark"> '.strtoupper($data->type).'</p>';
            return $review;
        })


        ->editColumn('serial', function(Review $data) {
           $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
           return $check;
        })


        ->addColumn('res', function(Review $data) {
            
            if($data->type == 'car'){
                $item = Car::findOrFail($data->review_id);
            }
            if($data->type == 'hotel'){
                $item = Hotel::findOrFail($data->review_id);
            }
            if($data->type == 'space'){
                $item = Space::findOrFail($data->review_id);
            }
            if($data->type == 'tour'){
                $item = TourModel::findOrFail($data->review_id);
            }

            $res =
           $item->title.'
            <p>
            <a target="_blank" href="'.route($data->type.'.details',$item->slug).'">
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i> View '.ucfirst($data->type).'
            </a>
            </p>';

            return $res;
        })

        ->rawColumns(['author','review','status','res','review_id','serial'])
        ->toJson();
     }


     

}
