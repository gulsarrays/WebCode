<?php

namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class usercontact to specify usercontacts table
 * @author user
 *
 */
class Users extends Model
{
    //table name
    protected $table = "users";
    /**
     * getting the user value
     */
    public function userValue(){
       //return user details
        return $this->belongsTo('App\User','username','username');
    }
    /**
     * Search the user
     * @param unknown_type $query
     * @param unknown_type $sort
     * @param unknown_type $search
     * @return unknown
     */
    public function scopeSearchUser($query, $sort, $search) {
       //checking sort order
        if(isset($sort) && !empty($sort)) {
            if($sort == 'desc'){
                $query->orderBy('name', 'desc');
            }else{
                $query->orderBy('name', 'asc');
            }
        }
        //checking search function 
        if(isset($search) && !empty($search)) {
            $query->where('name', 'LIKE', '%'. $search .'%')
            ->orWhere('mobile_number', 'LIKE', '%'. $search .'%');
        }
        //return query
        return $query;
    }    
    
}
