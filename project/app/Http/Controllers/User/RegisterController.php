<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use Auth;
use Validator;
use DB;



class RegisterController extends Controller
{
    public function __construct()
    {   
        $this->gs = DB::table('generalsettings')->find(1);
    }


    public function registerForm()
    {
 
       return view('user.register');
    }

    public function register(Request $request)
    {

        $value = session('captcha_string');
        
        if ($request->codes != $value){
            return response()->json(array('errors' => [ 0 =>  __('Please enter Correct Capcha Code.') ]));    
        }

        //--- Validation Section

        $rules = [
                'name' => 'required|max:255',
                'phone' => 'required|max:255',
                'email'   => 'required|email|unique:users',
                'password' => 'required'
                ];

                $custom = [
                    'email.unique' => __('This email has already been taken.')
                ];


        $validator = Validator::make($request->all(), $rules,$custom);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

            $gs = Generalsetting::findOrFail(1);
            $user = new User;
            $input = $request->all();        
            $input['password'] = bcrypt($request['password']);
            $token = md5(time().$request->name.$request->email);
            $input['verification_link'] = $token;
            $user->fill($input)->save();

            if($gs->is_verification == 1)
            {
            $to = $request->email;
            $subject = 'Verify your email address.';
            $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
            //Sending Email To Customer
            if($gs->is_smtp == 1)
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
            return response()->json(__('We need to verify your email address. We have sent an email to'). ' '.$to. ' '  .__('to verify your email address. Please click link in that email to continue.'));
            }
            else {
            $user->email_verified = 'Yes';
            $user->update();
         
            Auth::guard('web')->login($user);   
            $data['stauts'] = 1;
      
            return response()->json(['status'=>1 ]);
            }

    }

    public function token($token)
    {
        
        
       $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1)
        {      
            $user = User::where('verification_link',$token)->first();
            if(isset($user))
            { 
                $user->email_verified = 'Yes';
                $user->update();


            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->order_type = 'User';
            $notification->save();


            Auth::guard('web')->login($user); 
            return redirect()->route('user-dashboard')->with('success',__('Email Verified Successfully'));
        }
            }
            else {
            return redirect()->back();  
            }
    }


    // Capcha Code Image
    private function  code_image()
    {
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);
        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = base_path('../assets/front/fonts/NotoSans-Bold.ttf');
     
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, base_path('../assets/images/capcha_code.png'));
}
}
