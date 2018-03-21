<?php
namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class broadcast to specify broadcasts table
 * @author user
 *
 */
class Broadcast extends Model {
   /**
    * Table name
    * 
    * @var unknown_type
    */
   protected $table = 'admin_broadcasts';
   /**
    * Auto fillable data
    *
    * @var array
    */
   protected $fillable = [ 
         'title',
         'message',
         'is_active',
         'is_later' 
   ];
   
   /**
    * Rules for validation
    */
   public static $rules = [ 
         'title' => REQUIRED_MAX,
         'is_active' => REQUIRED,
         'image'=>'mimes:jpeg,png,mp3,aac,mp4,avi'
   ]
   ;
   /**
    * get the image
    */
   public function image() {
     return $this->hasOne(Attachment::class, 'foreign_id')->where ( 'class', 'Broadcast' );
   }
   /**
    * search functionality
    * @param unknown $query
    * @param unknown $search
    * @return unknown
    */
   public function scopeSearch($query, $search) {
      if (isset ( $search ) && ! empty ( $search )) {
         $query->where ( MESSAGE, 'LIKE', '%' . $search . '%' );
      }
      return $query;
   }
}
