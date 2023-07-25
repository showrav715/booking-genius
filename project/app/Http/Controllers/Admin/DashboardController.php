<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    public function index()
    {
        $hotels = Order::orderBy('id','desc')->where('order_type','Hotel')->take(10)->get();
        $cars = Order::orderBy('id','desc')->where('order_type','Car')->take(10)->get();
        $spaces = Order::orderBy('id','desc')->where('order_type','Space')->take(10)->get();
        $tours = Order::orderBy('id','desc')->where('order_type','Tour')->take(10)->get();
        return view('admin.dashboard',compact('hotels','cars','spaces','tours'));
    }


    

    public function profile()
    {
        $data = Auth::guard('admin')->user();  
        return view('admin.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ];


        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();  
        $data = Auth::guard('admin')->user();        
            if ( $request->hasFile('photo')) 
            {      
                $file = $request->photo;
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/admins/',$name);
                if($data->photo != null)
                {
                    if (file_exists(base_path('../assets/images/admins/'.$data->photo))) {
                        unlink(base_path('../assets/images/admins/'.$data->photo));
                    }
                }            
            $input['photo'] = $name;
            } 
        $data->update($input);
        $msg = __('Successfully updated your profile');
        return response()->json($msg); 
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();  
        return view('admin.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => __('Confirm password does not match.') ]));     
                }
            }else{
                return response()->json(array('errors' => [ 0 => __('Current password Does not match.') ]));   
            }
        }
        $admin->update($input);
        $msg = __('Successfully change your password');
        return response()->json($msg);
    }


    public function cancelIndex()
    {
       return view('admin.cancel_orders.index');
    }
     //*** JSON Request
     public function cancelDatatables()
     {
          $datas = OrderCancel::orderBy('id','desc')->get();
          //--- Integrating This Collection Into Datatables
          return DataTables::of($datas)
 
          ->editColumn('user_id', function(OrderCancel $data) {
            return $data->user->email;
         })
          ->editColumn('order_id', function(OrderCancel $data) {

            $details = '<a href="'.route('admin.car.order.details',$data->order->id).'"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
            '.$data->order->order_number.'</a>';
            return $details;
         })
         
 
         ->addColumn('status', function(OrderCancel $data) {
                
            if($data->status != 1){
                $class = $data->status == 1 ? 'btn-success' : 'btn-danger';
                $status = $data->status == 0 ? __('Pending') : __('Rejected');
                return '<div class="btn-group">
                            <button class="btn '.$class.' btn-sm dropdown-toggle statuscheck-parent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$status.'
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item StatusCheck" data-val="1" href="javascript:;" data-href="'.route('admin-order-cancel-status',[ $data->id, 1]).'">'.__('Accept').'</a>
                                
                            </div>
                         </div>';
            }

            if($data->status == 1){
                return '<button class="btn btn-success">'.__('Completed').'</button>';
            }elseif($data->status == 2){
               return '<button class="btn btn-danger">'.__('Rejected').'</button>';
            }
               
        })
         ->rawColumns(['user_id','order_id','status'])
         ->toJson(); 
     }


    public function status($data,$status)
    {
        $order = OrderCancel::findOrFail($data);
        if($status == 1){
            if($order->order->author_type == 'user'){
                $user = User::findOrFail($order->order->author_id);
                $user -= $order->order->total;
                $user->update();
            }
            $order->status = $status;
            $order->update();
        }else{
            $order->status = $status;
            $order->update();
        }

        $mgs = __('Data Update Successfully');
        return response()->json($mgs);
  
    }
	
	
	    public function generate_bkup()
    {
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            $bkuplink = url($chk);
        }
        return view('admin.movetoserver',compact('bkuplink','chk'));
    }


    public function clear_bkup()
    {
        $destination  = public_path().'/install';
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        $handle = fopen('backup.txt','w+');
        fwrite($handle,"");
        fclose($handle);
        //return "No Backup File Generated.";
        return redirect()->back()->with('success','Backup file Deleted Successfully!');
    }


    public function activation()
    {
        $activation_data = "";
        if (file_exists(public_path().'/project/license.txt')){
            $license = file_get_contents(public_path().'/project/license.txt');
            if ($license != ""){
                $activation_data = "<i style='color:darkgreen;' class='icofont-check-circled icofont-4x'></i><br><h3 style='color:darkgreen;'>Your System is Activated!</h3><br> Your License Key:  <b>".$license."</b>";
            }
        }
        return view('admin.activation',compact('activation_data'));
    }


    public function activation_submit(Request $request)
    {
        //return config('services.genius.ocean');
        $purchase_code =  $request->pcode;
        $my_script =  'BookingGenius';
        $my_domain = url('/');

        $varUrl = str_replace (' ', '%20', config('services.genius.ocean').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

        if( ini_get('allow_url_fopen') ) {
            $contents = file_get_contents($varUrl);
        }else{
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $varUrl);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
        }

        $chk = json_decode($contents,true);

        if($chk['status'] != "success")
        {

            $msg = $chk['message'];
            return response()->json($msg);
            //return redirect()->back()->with('unsuccess',$chk['message']);

        }else{
            $this->setUp($chk['p2'],$chk['lData']);

            if (file_exists(public_path().'/rooted.txt')){
                unlink(public_path().'/rooted.txt');
            }

            $fpbt = fopen(public_path().'/project/license.txt', 'w');
            fwrite($fpbt, $purchase_code);
            fclose($fpbt);

            $msg = 'Congratulation!! Your System is successfully Activated.';
            return response()->json($msg);
            //return redirect('admin/dashboard')->with('success','Congratulation!! Your System is successfully Activated.');
        }
        //return config('services.genius.ocean');
    }

    function setUp($mtFile,$goFileData){
        $fpa = fopen(public_path().$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }



    public function movescript(){
        ini_set('max_execution_time', 3000);

        $destination  = public_path().'/install';
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }

        $src = base_path().'/vendor/update';
        $this->recurse_copy($src,$destination);
        $files = public_path();
        $bkupname = 'GeniusCart-By-GeniusOcean-'.date('Y-m-d').'.zip';

        $zipper = new \Chumper\Zipper\Zipper;

        $zipper->make($bkupname)->add($files);

        $zipper->remove($bkupname);

        $zipper->close();

        $handle = fopen('backup.txt','w+');
        fwrite($handle,$bkupname);
        fclose($handle);

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        return response()->json(['status' => 'success','backupfile' => url($bkupname),'filename' => $bkupname],200);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}