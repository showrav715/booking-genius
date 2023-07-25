<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\{
    Http\Request,
};
use Validator;
use DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
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
        $datas = PaymentGateway::orderby('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            ->editColumn('title', function(PaymentGateway $data) {
                                if($data->type == 'automatic'){
                                    return  $data->name;
                                }else{
                                    return  $data->title;
                                }
                            })
                            ->editColumn('details', function(PaymentGateway $data) {
                                if($data->type == 'automatic'){
                                    return $data->getAutoDataText();
                                }else {
                                    if($data->keyword == 'cod'){
                                        return $data->subtitle;
                                    }else{
                                        $details = mb_strlen(strip_tags($data->details),'utf-8') > 250 ? mb_substr(strip_tags($data->details),0,250,'utf-8').'...' : strip_tags($data->details);
                                        return  $details;
                                    }

                                }
                            })
                            
                            ->edItColumn('status', function(PaymentGateway $data) {
                                $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
                                $status = $data->status == 1 ? __('Activated') : __('Deactivated');
                                return '<div class="btn-group">
                                            <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                '.$status.'
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-payment-status',['id1' => $data->id, 'id2' => 1]).'">'.__('Active').'</a>
                                                <a class="dropdown-item StatusCheck" data-val="0" href="javascript:;" data-href="'.route('admin-payment-status',['id1' => $data->id, 'id2' => 0]).'">'.__('Deactive').'</a>
                                            </div>
                                         </div>';
                            })

                          
                            ->addColumn('action', function(PaymentGateway $data) {
                                $editLink = route('admin-payment-edit',$data->id);
                                $deleteLink = route('admin-payment-delete',$data->id);

                                $delete = $data->type == 'automatic' || $data->keyword != null ? "" : "<a href='javascript:;' data-href='{$deleteLink}' data-toggle='modal' data-target='#confirm-delete' class='delete btn btn-danger btn-sm'>
                                <i class='fas fa-trash-alt'></i>
                                </a>";
                                $editText = __('Edit');
                                return "<div class='action-list'>

                                <a data-href='{$editLink}' href='javascript:;' class='edit btn btn-primary btn-sm mr-2 edit' data-toggle='modal' data-target='#modal1'> 
                                <i class='fas fa-edit'></i>{$editText}
                                </a>
                                {$delete}
                            </div>";
                                }) 
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }


    public function index(){
        
        return view('admin.payment.index');
    }

    public function create(){
        return view('admin.payment.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['title' => 'unique:payment_gateways'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new PaymentGateway();
        $input = $request->all();
        $input['type'] = "manual";
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    //*** GET Request
    public function edit($id)
    {
        $data = PaymentGateway::findOrFail($id);
        return view('admin.payment.edit',compact('data'));
    }

    private function setEnv($key, $value,$prev)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . $prev,
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        $data = PaymentGateway::findOrFail($id);
        $prev = '';
        if($data->type == "automatic"){

            //--- Validation Section
            $rules = ['name' => 'unique:payment_gateways,name,'.$id];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }        
            //--- Validation Section Ends

            //--- Logic Section

            $input = $request->all();  

            $info_data = $input['pkey'];

            if($data->keyword == 'mollie'){
                $paydata = $data->convertAutoData(); 
                $prev = $paydata['key'];
            }   

            if (array_key_exists("sandbox_check",$info_data)){
                $info_data['sandbox_check'] = 1;
            }else{
                if (strpos($data->information, 'sandbox_check') !== false) {
                    $info_data['sandbox_check'] = 0;
                    $text =  $info_data['text'];
                    unset($info_data['text']);
                    $info_data['text'] = $text;
                }
            }
            $input['information'] = json_encode($info_data);
            $data->update($input);


            if($data->keyword == 'mollie'){
                $paydata = $data->convertAutoData(); 
                $this->setEnv('MOLLIE_KEY',$paydata['key'],$prev);

            }     
            //--- Logic Section Ends
        }
        else{
            //--- Validation Section
            $rules = ['title' => 'unique:payment_gateways,title,'.$id];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }        
            //--- Validation Section Ends

            //--- Logic Section

            $input = $request->all();  
            $data->update($input);

  
            //--- Logic Section Ends

        }
        //--- Redirect Section     
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);    
        //--- Redirect Section Ends    
    }
    
    public function status($id1,$id2)
    {
        $data = PaymentGateway::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        $mgs = ('Data Update Successfully.');
        return response()->json($mgs);
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = PaymentGateway::findOrFail($id);
        if($data->type == 'manual' || $data->keyword != null){
            $data->delete();
        }
        //--- Redirect Section     
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }
}
