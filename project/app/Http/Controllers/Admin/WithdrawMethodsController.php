<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use DataTables;

class WithdrawMethodsController extends Controller
{


    //*** JSON Request
    public function datatables()
    {
         $datas = WithdrawMethod::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)

         ->addColumn('status', function(WithdrawMethod $data) {
            $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
            $status = $data->status == 1 ? __('Activated') : __('Deactivated');
            return '<div class="btn-group">
                        <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$status.'
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-withdraw-method-status',[ $data->id, 1]).'">'.__('Active').'</a>
                            <a class="dropdown-item StatusCheck" data-val="0" href="javascript:;" data-href="'.route('admin-withdraw-method-status',[ $data->id, 0]).'">'.__('Deactive').'</a>
                        </div>
                     </div>';
        })


        ->addColumn('action', function(WithdrawMethod $data) {
            return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-withdraw-method-edit',$data->id) . '" class="btn btn-primary btn-sm mr-2 edit" data-toggle="modal" data-target="#modal1" > <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-withdraw-method-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
        })
        ->rawColumns(['action','status'])
        ->toJson(); 
    }

    public function status($id1,$id2)
    {
        $data = WithdrawMethod::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        $mgs = ('Data Update Successfully.');
        return response()->json($mgs);
    }

    public function index()
    {
        return view('admin.withdraw_methods.index');
    }


    public function create()
    {
       return view('admin.withdraw_methods.create');
    }

    public function store(Request $request)
    {
       $request->validate([
         'name' => 'required'
       ]);

       $data = new WithdrawMethod();
       $data->name = $request->name;
       $data->save();
       $mgs = __('Data Added Successfully');
       return response()->json($mgs);
    }


    public function edit($id)
    {
        $data = WithdrawMethod::findOrFail($id);
        return view('admin.withdraw_methods.edit',compact('data'));
    }


    public function update(Request $request , $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = WithdrawMethod::findOrFail($id);
        $data->name = $request->name;
        $data->save();
        $mgs = __('Data Update Successfully');
        return response()->json($mgs);
    }


    public function delete($id)
    {
        $data = WithdrawMethod::findOrFail($id);
        $data->delete();
        $mgs = __('Data Delete Successfully');
        return response()->json($mgs);
    }
}
