<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Order;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Generalsetting;
use Auth;

class CarOrderController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }

   
    public function orders(Request $request)
    {
      if(!Helper::carCheck() == true){
         return redirect(route('user-car-index'));
      }
        return view('user.car.orders.index');
    }


    public function datatables($type)
    {
        $user = Auth::user();
        if($type == 'all'){
         $datas = Order::orderBy('id','desc')->where('order_type','Car')->where('author_type','user')->where('author_id',$user->id)->get();
        }else{
         $datas = Order::orderBy('id','desc')->where('order_status',$type)->where('order_type','Car')->where('author_type','user')->where('author_id',$user->id)->get();
        }
        
        return DataTables::of($datas)

        ->editColumn('item_id', function(Order $data) {
           $car = $data->car->title;
           return $car;
        })
        ->editColumn('total', function(Order $data) {
         $total = round($data->total * $data->currency_value,2);
         return $data->currency_sign .'' .$total;
         
      })
        ->editColumn('created_at', function(Order $data) {
           $date =$data->created_at->format('d/m/Y');
           return $date;
        })


        ->editColumn('order_status', function(Order $data) {
         if($data->order_status == 'Pending')
         {$status = 'Pending';$class = 'btn-info';}
         elseif($data->order_status == 'Processing'){
            {$status = 'Processing';$class = 'btn-primary';}
         }elseif($data->order_status == 'Completed'){
            return '<span class="badge badge-success p-2">'.__('Completed').'</span>';
         }else{
            {$status = 'Cancel';$class = 'btn-danger';}
         }
         return '<div class="btn-group">
                     <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         '.$status.'
                     </button>
                     <div class="dropdown-menu">
                         <a class="dropdown-item StatusCheck" data-val="Pending" href="javascript:;" data-href="'.route('user-car-order-status',[ $data->id, 'Pending']).'">'.__('Pending').'</a>
                         <a class="dropdown-item StatusCheck" data-val="Processing" href="javascript:;" data-href="'.route('user-car-order-status',[ $data->id, 'Processing']).'">'.__('Processing').'</a>
                         <a class="dropdown-item complete_check" data-toggle="modal" data-target="#complete_check" data-val="Completed" href="javascript:;" data-href="'.route('user-car-order-status',[$data->id, 'Completed']).'">'.__('Completed').'</a>
                         <a class="dropdown-item StatusCheck" data-val="Cancel" href="javascript:;" data-href="'.route('user-car-order-status',[$data->id, 'Cancel']).'">'.__('Cancel').'</a>
                     </div>
                  </div>';
         })
      

        ->editColumn('user_id', function(Order $data) {
           $user = '
           
           <ul class="list-unstyled">
                <li> <b>'.__('Name:').'</b>'.$data->name.'</li>
                <li><b>'.__('Email:').'</b>'.$data->email.'</li>
                <li><b>'.__('Number:').'</b>'.$data->number.'</li>
                <li><b>'.__('City:').'</b>'.$data->city.'</li>
            </ul>
           
           ';
           return $user;
        })
       
       ->addColumn('action', function(Order $data) {
           return '<div class="action-list">
           <a href="'.route('user.car.order.details',$data->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
               '.__('Details').'
           </a>
       </div>';
       })

       ->rawColumns(['item_id','action','user_id','total','created_at','order_status'])
       ->toJson();
    }


    public function CarOrderStatus($id,$status)
    {
      $data = Order::findOrFail($id);
      $data->update([
         'order_status' => $status,
      ]);

      if($status == 'Completed'){
         if($data->author_type == 'user'){
            $user = User::findOrFail($data->author_id);
            $user->total_earning += $data->total;
            $user->pending_earning -= $data->total;
            $user->update();
         }
         $gs = Generalsetting::findOrFail(1);
            $subject = "Email From Of ".$gs->from_name;
            $to = $data->email;
            $name = $data->name;
            
            $msg = __('Dear'). ' ' . $name .' '. __('Your Order has Completed. Please Login and') . ' <a href="'.route('user.login').'"> '.__('check it').'</a>';

            if($gs->is_smtp)
            {
            $data = [
                  'to' => $to,
                  'subject' => $subject,
                  'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
            }
            else
            {
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                  mail($to,$subject,$msg,$headers);
            }
      }

      
      $mgs = __('Data Update Successfully.');
      return response()->json($mgs);
    }

    public function CarordersDetails($id)
    {
      $data = Order::findOrFail($id);
      return view('user.car.orders.details',compact('data'));
    }

}
