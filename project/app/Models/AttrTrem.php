<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;

class AttrTrem extends Model
{
    protected $fillable = ['name', 'hotel_attr_id'];
    public function image(){return $this->morphOne('App\Models\ShowImage', 'imageable');}


    public function AttrTremCount()
    {
    
        $trems = Hotel::pluck('attr_term_id');
        $attrs = Hotel::pluck('hotel_attr_id');
       
        
       $rmv_key = [];
       $new_trem = [];
       
       foreach($trems as $k => $trm){
            foreach(explode(',',$trm) as $nw=>$htrm){
                if($htrm == $this->id){
                    $rmv_key[$k][$nw] = $nw; 
                }else{
                    $new_trem[$k][$nw] = $htrm;
                }
                
            }
       }
    
       $new_attr = [];

        foreach($attrs as $at => $hattr){
            foreach(explode(',',$hattr) as $nattr => $newattr){
                if(array_key_exists($at,$rmv_key)){
                   
                  
                 if(!in_array($nattr,$rmv_key[$at])){
                        $new_attr[$at][$nattr] = $newattr;
                    }
                }
            }
        }

       
        foreach(Hotel::all() as $s => $nData){
           if(empty($new_trem)){
            $nData->update([
                'hotel_attr_id' => '',
                'attr_term_id' => ''
            ]);
           }else{
            $nData->update([
                'hotel_attr_id' => array_key_exists($s,$new_attr) ? implode(',',$new_attr[$s]) : $attrs[$s],
                'attr_term_id' => implode(',',$new_trem[$s])
            ]);
           }
          
        }

       
 return true;

}


}




