<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderHistoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function History($type)
    {
       
        if($type == 'car'){
            return view('user.order-history.car_order');
        }
        if($type == 'hotel'){
            return view('user.order-history.hotel_order');
        }
        if($type == 'tour'){
            return view('user.order-history.tour_order');
        }
        if($type == 'space'){
            return view('user.order-history.space_order');
        }
    }



    public function carDatatables()
    {
      $user = Auth::user();
      $datas = Order::orderBy('id','desc')->where('user_id',$user->id)->where('order_type','Car')->get();
        
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
        $cancel = '';
            if($data->order_status != 'Completed'){
                if(OrderCancel::whereOrderId($data->id)->exists()){
                    if(OrderCancel::whereOrderId($data->id)->first()->status == 0){
                        $cancel = '<span class="p-2 badge badge-primary">'.__('Cancelation Pending').'</span>';
                    }else{
                        $cancel = '<span class="p-2 badge badge-danger">'.__('Order Canceled').'</span>';
                    }
                }else{
                    $cancel = '<a href="javascript:;" data-href="' . $data->id. '" data-toggle="modal" data-target="#confirm-book-cancel" class="btn btn-danger btn-sm">'.__('Cancel').'</a>';
                }
            }

           return '<div class="action-list">
           <a href="'.route('user.car.order.details',$data->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
               '.__('Details').'
           </a>
          '.$cancel.'
       </div>';
       })

       ->rawColumns(['item_id','action','user_id','total','created_at'])
       ->toJson();
    }

    public function tourDatatables()
    {
      $user = Auth::user();
      $datas = Order::orderBy('id','desc')->where('user_id',$user->id)->where('order_type','Tour')->get();
        
        return DataTables::of($datas)

        ->editColumn('item_id', function(Order $data) {
           $tour = $data->tour->title;
           return $tour;
        })
        ->editColumn('total', function(Order $data) {
            $total = round($data->total * $data->currency_value,2);
            return $data->currency_sign .'' .$total;
            
         })
        ->editColumn('created_at', function(Order $data) {
           $date =$data->created_at->format('d/m/Y');
           return $date;
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
            $cancel = '';
                if($data->order_status != 'Completed'){
                    if(OrderCancel::whereOrderId($data->id)->exists()){
                        if(OrderCancel::whereOrderId($data->id)->first()->status == 0){
                            $cancel = '<span class="p-2 badge badge-primary">'.__('Cancelation Pending').'</span>';
                        }else{
                            $cancel = '<span class="p-2 badge badge-danger">'.__('Order Canceled').'</span>';
                        }
                    }else{
                        $cancel = '<a href="javascript:;" data-href="' . $data->id. '" data-toggle="modal" data-target="#confirm-book-cancel" class="btn btn-danger btn-sm">'.__('Cancel').'</a>';
                    }
                }
    
               return '<div class="action-list">
               <a href="'.route('user.tour.order.details',$data->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                   '.__('Details').'
               </a>
              '.$cancel.'
           </div>';
           })

       ->rawColumns(['item_id','action','user_id','total','created_at'])
       ->toJson();
    }

    public function hotelDatatables()
    {
      $user = Auth::user();
      $datas = Order::orderBy('id','desc')->where('user_id',$user->id)->where('order_type','Hotel')->get();
        
        return DataTables::of($datas)

        ->editColumn('item_id', function(Order $data) {
           $hotel = $data->hotel->title;
           return $hotel;
        })
        ->editColumn('total', function(Order $data) {
            $total = round($data->total * $data->currency_value,2);
            return $data->currency_sign .'' .$total;
            
         })
        ->editColumn('created_at', function(Order $data) {
           $date =$data->created_at->format('d/m/Y');
           return $date;
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
            $cancel = '';
                if($data->order_status != 'Completed'){
                    if(OrderCancel::whereOrderId($data->id)->exists()){
                        if(OrderCancel::whereOrderId($data->id)->first()->status == 0){
                            $cancel = '<span class="p-2 badge badge-primary">'.__('Cancelation Pending').'</span>';
                        }else{
                            $cancel = '<span class="p-2 badge badge-danger">'.__('Order Canceled').'</span>';
                        }
                    }else{
                        $cancel = '<a href="javascript:;" data-href="' . $data->id. '" data-toggle="modal" data-target="#confirm-book-cancel" class="btn btn-danger btn-sm">'.__('Cancel').'</a>';
                    }
                }
    
               return '<div class="action-list">
               <a href="'.route('user.hotel.order.details',$data->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                   '.__('Details').'
               </a>
              '.$cancel.'
           </div>';
           })

       ->rawColumns(['item_id','action','user_id','total','created_at'])
       ->toJson();
    }


    public function spaceDatatables()
    {
      $user = Auth::user();
      $datas = Order::orderBy('id','desc')->where('user_id',$user->id)->where('order_type','Space')->get();
        
        return DataTables::of($datas)

        ->editColumn('item_id', function(Order $data) {
           $space = $data->space->title;
           return $space;
        })
        ->editColumn('total', function(Order $data) {
            $total = round($data->total * $data->currency_value,2);
            return $data->currency_sign .'' .$total;
            
         })
        ->editColumn('created_at', function(Order $data) {
           $date =$data->created_at->format('d/m/Y');
           return $date;
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
            $cancel = '';
                if($data->order_status != 'Completed'){
                    if(OrderCancel::whereOrderId($data->id)->exists()){
                        if(OrderCancel::whereOrderId($data->id)->first()->status == 0){
                            $cancel = '<span class="p-2 badge badge-primary">'.__('Cancelation Pending').'</span>';
                        }else{
                            $cancel = '<span class="p-2 badge badge-danger">'.__('Order Canceled').'</span>';
                        }
                    }else{
                        $cancel = '<a href="javascript:;" data-href="' . $data->id. '" data-toggle="modal" data-target="#confirm-book-cancel" class="btn btn-danger btn-sm">'.__('Cancel').'</a>';
                    }
                }
    
               return '<div class="action-list">
               <a href="'.route('user.space.order.details',$data->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                   '.__('Details').'
               </a>
              '.$cancel.'
           </div>';
           })

       ->rawColumns(['item_id','action','user_id','total','created_at'])
       ->toJson();
    }



    public function orderCancel(Request $request)
    {
        
        $request->validate([
            'method' => 'required',
            'details' => 'required',
        ]);

        $data = new OrderCancel();
        $data->user_id = Auth::user()->id;
        $data->order_id = $request->order_id;
        $data->type = $request->type;
        $data->method = $request->method;
        $data->details = $request->details;
        $data->status = 0;
        $data->save();
        return back()->withSuccess(__('Order Cancel Request submit successfully'));
    }

}
