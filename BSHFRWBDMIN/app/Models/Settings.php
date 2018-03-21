<?php

namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class settings to specify settings table
 * @author user
 *
 */
class Settings extends Model {
   /**
    * Table setting
    * 
    * @var unknown_type
    */
   protected $table = 'settings';
   
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['xmpp_host', 'oauth_url', 'rest_api_url', 'sip_url','gcm_sender_id','aws_access_key','aws_secret_key','aws_bucket_name','business_specific_settings','max_upload_size','auto_delete_days'];
}
