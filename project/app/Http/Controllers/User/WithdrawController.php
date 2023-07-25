<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Withdrew;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    
    public function datatables()
    {
        $datas = Withdrew::orderBy('id','desc')->where('user_id',Helper::User_id())->get();
         return DataTables::of($datas)

         ->editColumn('status', function(Withdrew $data) {
             if($data->status == 0){
                return '<span class="badge badge-primary">'.__('Pending').'</span>' ;
             }elseif($data->status == 1){
                return '<span class="badge badge-success">'.__('Completed').'</span>' ;
             }else{
                return '<span class="badge badge-danger">'.__('Rejected').'</span>';
             }

        })
     
        ->editColumn('fee', function(Withdrew $data) {
            $price = $data->fee;
            return PriceHelper::showAdminCurrency().$price;
        })

        ->editColumn('amount', function(Withdrew $data) {
            $price = $data->amount;
            return PriceHelper::showAdminCurrency().$price;
           
        })

        ->rawColumns(['status','action','fee','amount'])
        ->toJson();
    }


    public function index()
    {
        return view('user.withdraw.index');
    }


    public function create()
    {
        return view('user.withdraw.create');
    }


    public function store(Request $request)
    {
        $rules = [
            'method' => 'required',
            'details' => 'required',
            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $total_balance = round(Auth::user()->total_earning,2);
        $gs = Generalsetting::first();

        if($request->amount > 0){
            if($request->amount <= $total_balance){
                $fixed_amount = $gs->withdraw_extra_charge;
                $percentage_amount = $request->amount * $gs->withdraw_extra_charge / 100;
                $final_amount = $request->amount - $fixed_amount - $percentage_amount;
                $fee_amount = $fixed_amount + $percentage_amount;
                if($final_amount >= 1){
                    $withdraw = new Withdrew();
                    $withdraw->amount = $final_amount;
                    $withdraw->user_id = Auth::user()->id;
                    $withdraw->fee = $fee_amount;
                    $withdraw->method = $request->method;
                    $withdraw->details = $request->details;
                    $withdraw->status = 0;
                    $withdraw->save();
                    $user = Auth::user();
                    $user->total_earning -= $request->amount;
                    $user->update();
                }else{
                    $mgs = __('Insufficient Balance');
                    return response()->json($mgs); 
                }
                
            }else{

            $mgs = __('Insufficient Balance');
            return response()->json($mgs); 
            }
        }else{
            $mgs = __('Insufficient Balance');
            return response()->json($mgs); 
        }


        $mgs = __('Data Added Successfully');
        return response()->json($mgs);

    }


}
