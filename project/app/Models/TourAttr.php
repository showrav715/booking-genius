<?php

namespace App\Models;
use App\Models\TourModel;

use Illuminate\Database\Eloquent\Model;

class TourAttr extends Model
{
    protected $fillable = ['name',];

    public function terms()
    {
    	return $this->hasMany('App\Models\TourTerm','tour_attr_id','id');
    }

    public function AttrCount()
    {
    
        $trems = TourModel::pluck('attr_term_id');
        $attrs = TourModel::pluck('tour_attr_id');
       
        
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
        
 
        foreach(TourModel::all() as $s => $nData){
           if(empty($new_attr)){
            $nData->update([
                'tour_attr_id' => '',
                'attr_term_id' => ''
            ]);
           }else{
            $nData->update([
                'tour_attr_id' => implode(',',$new_attr[$s]),
                'attr_term_id' => array_key_exists($s,$new_trem) ? implode(',',$new_trem[$s]) : $trems[$s]
            ]);
           }
          
        }

        
       
    return true;


    }
}
