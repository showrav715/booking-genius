<?php 

namespace App\Helpers;

use App\Models\User;
use Auth;
use Session;
class OrderHelper
{
 

    public static function vendorOrder($book,$type)
    {
       try {

        if($book[$type]['author_type'] == 'user'){
            $user = User::findOrFail($book[$type]['author_id']);
            $user->pending_earning += $book['total'];
            $user->update();
        }
       } catch (\Throwable $th) {
           
       }
    }

}