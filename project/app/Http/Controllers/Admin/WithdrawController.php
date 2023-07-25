<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdrew;
use DataTables;
class WithdrawController extends Controller
{
    public function datatables()
    {
        $datas = Withdrew::orderBy('id','desc')->get();
         return DataTables::of($datas)

       
     
        ->editColumn('fee', function(Withdrew $data) {
            $price = $data->fee;
            return PriceHelper::showAdminCurrency().$price;
        })

        ->editColumn('amount', function(Withdrew $data) {
            $price = $data->amount;
            return PriceHelper::showAdminCurrency().$price;
           
        })

        ->addColumn('status', function(Withdrew $data) {
                
            if($data->status == 0){
                $class = $data->status == 1 ? 'btn-success' : 'btn-primary';
                $status = $data->status == 0 ? __('Pending') : __('Rejected');
                return '<div class="btn-group">
                            <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$status.'
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-withdraw-status',[ $data->id, 1]).'">'.__('Accept').'</a>
                                <a class="dropdown-item StatusCheck" data-val="2" href="javascript:;" data-href="'.route('admin-withdraw-status',[ $data->id, 2]).'">'.__('Reject').'</a>
                            </div>
                         </div>';
            }

            if($data->status == 1){
                return '<button class="btn btn-success">'.__('Completed').'</button>';
            }elseif($data->status == 2){
               return '<button class="btn btn-danger">'.__('Rejected').'</button>';
            }
               
        })

        ->rawColumns(['status','action','fee','amount'])
        ->toJson();
    }


    public function status($data,$status)
    {
        $withdraw = Withdrew::findOrFail($data);
        $user = User::findOrFail($withdraw->user_id);

        if($status == 2){
            $refund_amount = $withdraw->amount + $withdraw->fee;
            $user->total_earning += $refund_amount;
            $user->update();
            $withdraw->status = 2;
            $withdraw->update();
        }else{
            $withdraw->status = 1;
            $withdraw->update();
        }

        $mgs = __('Data Update Successfully');
        return response()->json($mgs);
  
    }


    public function index()
    {
        return view('admin.withdraw.index');
    }
}
