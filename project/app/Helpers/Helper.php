<?php

namespace App\Helpers;
use Image;
use Illuminate\Support\Str;
use Auth;


 class  Helper {

//------------ Impole data Function------------------//

public static function implode($value)
{
    if($value){
        return implode(',',$value);
    }else{
        return  '';
    }
}
public static function Ximplode($value)
{

    if($value){
        $value = array_filter($value);
        return implode(',,,',$value);
    }else{
        return  '';
    }
}


// -------------------- Make Slug -=------------------------//

public static function slug($slug)
{
    return Str::slug($slug, '-');
}
// -------------------- Make Slug end-=------------------------//

// -------------------- Image Insert----------------------//

public static function MakeImage($image,$location,$modelData)
{
    $name = time() . $image->getClientOriginalName();
    $location = $location . $name;
    Image::make($image)->save($location);
    $modelData->image()->create(['image' => $name]);
}

// -------------------- Image Insert----------------------//

// -------------------- Image Update --------------------//
public static function ImageUpdate($image,$location,$model,$size=null)
{
   
    if($model->image->image != null){
        if(file_exists($location.$model->image->image)){
            unlink($location.$model->image->image);
        }
    }
    $name = time() . $image->getClientOriginalName();
    $location = $location . $name;
    if($size == null){
        Image::make($image)->save($location);
    }else{
        Image::make($image)->resize($size[0],$size[1])->save($location);
    }
    
    
    $model->image()->update(['image' => $name]);
}

// -------------------- Image Update --------------------//


// -------------------- Image Null ----------------------//

public static function NullImage($model)
{
    $model->image()->create(['image' => null]);
}

// -------------------- Image Null ----------------------//



// ------------------------TagFormat--------------------------//
public static function TagFormat($tag)
{
    $common_rep   = ["value", "{", "}", "[","]",":","\""];
    $tag = str_replace($common_rep, '', $tag);

    if (!empty($tag)) 
    {
       return $tag;  
          
    }else {

       return  null;
    }  
}
// ------------------------TagFormat--------------------------//


// ------------------------ Gallery Image Upload ----------------//

public static function GalleryUpload($images,$type,$imagable_id,$model,$location)
{
    foreach($images as $key => $image){
        $name = rand().$image->getClientOriginalName();
        $support = ['jpeg','jpg','png','svg','JPG','PNG'];
        if(in_array($image->getClientOriginalExtension(),$support)){
            $image_loc = $location . $name;
            Image::make($image)->save($image_loc);
            $model->create([
                'type' => $type,
                'imagable_id' => $imagable_id,
                'image' => $name,
            ]);
        }
       
    }
}


// ------------------------ Gallery Image Upload End----------------//

// ------------------------ User ID -------------------------------//
    public static function User_id()
    {
        $user_id = Auth::user()->id;
        return $user_id;
    }
// ------------------------ User ID -------------------------------//


public static function hotelCheck()
{
    $user = Auth::user();
    
    if(count($user->hotel) > 0){
        return true;
    }else{
        return false;
    }
}


public static function tourCheck()
{
    $user = Auth::user();
    
    if(count($user->tour) > 0){
        return true;
    }else{
        return false;
    }
}

public static function spaceCheck()
{
    $user = Auth::user();
    if(count($user->space) > 0){
        return true;
    }else{
        return false;
    }
}
public static function carCheck()
{
    $user = Auth::user();
    if(count($user->car) > 0){
        return true;
    }else{
        return false;
    }
}


}