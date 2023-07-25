<?php

namespace App\Models;
use App\Models\Car;
use Illuminate\Database\Eloquent\Model;

class CarAttr extends Model
{
    protected $fillable = ['name','slug'];

    public function terms()
    {
    	return $this->hasMany('App\Models\CarTerm','car_attr_id','id');
    }

    public function AttrCount()
    {
    
        $trems = Car::pluck('attr_term_id');
        $attrs = Car::pluck('car_attr_id');
       
        
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

       $new_trem = array();
     
        foreach($trems as $at => $htrem){
            foreach(explode(',',$htrem) as $ntem => $newtrem){
                if(array_key_exists($at,$rmv_key)){
                    if(!in_array($ntem,$rmv_key[$at])){
                        $new_trem[$at][$ntem] = $newtrem;
                     }
                }
            }
        }
        
        
        foreach(Car::all() as $s => $nData){
           if(empty($new_attr)){
            $nData->update([
                'car_attr_id' => '',
                'attr_term_id' => ''
            ]);
           }else{
            $nData->update([
                'car_attr_id' => implode(',',$new_attr[$s]),
                'attr_term_id' => array_key_exists($s,$new_trem) ? implode(',',$new_trem[$s]) : $trems[$s]
            ]);
           }
          
        }

        
       
    return true;


    }
}
