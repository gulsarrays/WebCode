<?php

namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class userrole to specifies user_role table
 * @author user
 *
 */
class UserRole extends Model{
   //specify the table name
    protected $table = 'user_roles';
    /**
     * gettting the user details using user-type
     */
    public function user() {
       //return the user details
      return $this->hasMany('App\User','user_type');
    }
}
