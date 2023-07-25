<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelAttr extends Model
{
    protected $fillable = ['name',];

    public function terms()
    {
        return $this->hasMany('App\Models\AttrTrem','hotel_attr_id','id');
        
    }
        public function AttrCount()
    {
    
        $trems = Hotel::pluck('attr_term_id');
        $attrs = Hotel::pluck('hotel_attr_id');
       
        
       $rmv_key = [];

       $new_attr = [];
       
       foreach($attrs as $k => $attr){
            foreach(explode(',',$attr) as $nw=>$at){
                if($at == $this->id){
                    $rmv_key[$k][$nw] = $nw; 
                }else{
                    $new_attr[$k][$nw] = $at;
                }
            }
       }

       $new_trem = [];

      
        foreach($trems as $at => $htrem){
            
            foreach(explode(',',$htrem) as $ntem => $newtrem){
               if(array_key_exists($at,$rmv_key)){
                if(!in_array($ntem,$rmv_key[$at])){
                    $new_trem[$at][$ntem] = $newtrem;
                 }
               }
                
            }
        }

   
        foreach(Hotel::all() as $s => $nData){
           if(empty($new_attr)){
            $nData->update([
                'hotel_attr_id' => '',
                'attr_term_id' => ''
            ]);
           }else{
               
            $nData->update([
                'hotel_attr_id' => implode(',',$new_attr[$s]),
                'attr_term_id' => array_key_exists($s,$new_trem) ? implode(',',$new_trem[$s]) : $trems[$s]
            ]);
           }
          
        }

        
       
    return true;


    }
}
