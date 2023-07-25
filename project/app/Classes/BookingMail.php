<?php
namespace App\Classes;

use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Pagesetting;
use App\Models\UserNotification;
use Auth;

class BookingMail {
    
    public static function Booking($order_id,$order_type,$total,$order_number,$cname,$email)
    {

        // Notification And Email Section //
        $gs = Generalsetting::findOrFail(1);
        $ps = Pagesetting::findOrFail(1);
        $user = Auth::user();

            //Sending Email To Buyer
            $data = [
                'to' => $email,
                'type' => "new_order",
                'cname' => $cname,
                'oamount' => $total,
                'aname' => $gs->from_name,
                'aemail' => $gs->from_email,
                'wtitle' => $gs->website_title,
                'onumber' => $order_number,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendAutoOrderMail($data,$order_id);            

            //Sending Email To Admin
            $data = [
                'to' => $ps->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!</br>Your store has received a new order.</br>Order Number is ".$order_number.".Please login to your panel to check. <br>Thank you.",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);   


            $notification = new Notification();
            $notification->order_id = $order_id;
            $notification->order_type = $order_type;
            $notification->user_id = $user->id;
            $notification->save();

            // user notification 
            $user_order = Order::findOrFail($order_id)->first();

            if($user_order->author_type == 'user'){
                $user_notification = new UserNotification();
                $user_notification->order_id = $order_id;
                $user_notification->order_type = $order_type;
                $user_notification->user_id = $user_order->author_id;
                $user_notification->save();
            }


        // Notification And Email Section //
    }



    public function FunctionName(Type $var = null)
    {
        # code...
    }
}