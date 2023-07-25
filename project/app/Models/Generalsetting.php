<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Generalsetting extends Model
{
    protected $fillable = [
                    'header_logo',
                    'footer_logo',
                    'favicon',
                    'website_loader',
                    'admin_loader',
                    'breadcumb_banner',
                    'website_title',
                    'theme_color',
                    'secendary_color',
                    'tawk_id',
                    'disqus',
                    'contact_email',
                    'is_tawk',
                    'is_disqus',
                    'is_verification',
                    'is_admin_loader',
                    'is_website_loader',
                    'footer_text',
                    'copy_right_text',
                    'error_text',
                    'error_title',
                    'error_photo',
                    'stripe_check',
                    'stripe_key',
                    'stripe_secret',
                    'paypal_check',
                    'paypal_sendbox_check',
                    'paypal_client_id',
                    'paypal_client_secret',
                    'is_smtp',
                    'smtp_host',
                    'smtp_port',
                    'smtp_user',
                    'smtp_pass',
                    'from_email',
                    'from_name',
                    'withdraw_percentage_fee',
                    'withdraw_extra_charge'

                ];

    public $timestamps = false;


    public function upload($name,$file,$oldname)
    {
               
                $file->move('assets/images/genarel-settings',$name);
                if($oldname != null)
                {
                    if (file_exists(public_path().'/assets/images/genarel-settings'.$oldname)) {
                        unlink(public_path().'/assets/images/genarel-settings'.$oldname);
                    }
                }  
    }
}
