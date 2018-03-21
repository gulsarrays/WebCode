<?php

namespace App\Models;
//eloquent model file
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Users;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


/**
 * class userrole to specifies user_role table
 * @author user
 *
 */
class Vcard extends Model {
   //specify the table name
    protected $table = 'fly_users';
    /**
     * gettting the user details using user-type
     */
    public function user() {
       //return the user details
      return $this->hasMany('App\User','user_type');
    }
    
    /**
     * Relation with UserContact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function users(){
        return $this->hasOne(Users::class,USERNAME,USERNAME);
    }
    /**
     * Query Scope for applying condition based on search
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $sort
     * @param string $search
     * @return \Illuminate\Database\Query\Builder
     */    
    public function scopeSearchUser($query, $sort, $search) {
    	if(isset($sort) && !empty($sort)) {
    		if($sort == 'desc')
    			$query->orderBy('name', 'desc');
    		else
    			$query->orderBy('name', 'asc');
    	}
    	
    	if(isset($search) && !empty($search)) {
    		$query->where('name', 'LIKE', '%'. $search .'%')
    			->orWhere('mobile_number', 'LIKE', '%'. $search .'%');
    	}
    	return $query;
    }
/**
    * findForPassport Model function
    * @return user model 
    */
    public function findForPassport($username){
        return static::where("username",$username)->first();
    }
    /**
     * Relation with Spool
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function decryptEmoji(){
       $statusMessage = $this->status_msg;
       
       try {
         $statusMessage = json_decode('"'.$this->status_msg.'"');          
       } catch (\Exception $e) {
          \Log::info($e->getMessage());
       }
       return $statusMessage;
    }    
    
    /**
     * Relation with Spool
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function decryptnameEmoji(){
       $name = $this->name;
       try {
          $name = json_decode('"'.$this->name.'"');
       } catch (\Exception $e) {
          \Log::info($e->getMessage());
       }
        if($name==""){
           $name='---';
        }
       return $name;
    }
    
    /**
     * Function to get the image
     *
     * @param   $image
     * 
     * @return  string
     */
    public function image(){
       if(isset($this->image)&&($this->image!='')){
           $image=$this->image;
       }else{
          $image=url('assets/img/default_large.png');
       }
       return $image;
    }

}

