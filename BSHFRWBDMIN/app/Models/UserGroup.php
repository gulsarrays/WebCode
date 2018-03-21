<?php

namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class usergroup to specify user groups table
 * @author user
 *
 */
class UserGroup extends Model {
   //specifiy the table name
   protected $table = 'user_groups';
   /**
    * getting the group information
    */
   public function groupInfo() {
      // get the group info based on the group id
      return $this->belongsTo ( 'App\Models\Groups', 'group_id' );
   }
}
