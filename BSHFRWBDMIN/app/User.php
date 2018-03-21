<?php
/**
 * User Model
 *
 * This model contains function to validate the user details, get profile details, fill the user details etc..
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Auth\Authenticatable;
// use Illuminate\Auth\Passwords\CanResetPassword;
// use Illuminate\Foundation\Auth\Access\Authorizable;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Attachment;
use App\Models\UserAvailability;
use App\Models\UserContact;
use App\Models\UserDevice;
use App\Models\UserGroup;
use App\Models\UserLoginHistory;
use App\Models\Groups;
use App\Models\GroupChat;
use App\Models\Chat;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\Spool;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;

use Auth;


class User extends Authenticatable implements AuditableContract, UserResolver
    // extends Model 
// implements AuthenticatableContract,
//                                     AuthorizableContract,
//                                     CanResetPasswordContract
{
    // use Authenticatable, Authorizable, CanResetPassword,HasApiTokens, Notifiable;
    use EntrustUserTrait;
    use Auditable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mobile_number', 'email', 'password','user_type','is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The default validation rule.
     *
     * @var array
     */
    public static $rules = [
	    'username'	=>'required',
	    'password'	=>'required',
    ];
    
    /**
     * Change password validation rule.
     *
     * @var array
     */
    public static $rulesChangePassword = [
	    'old_password'			=>	'required',
	    'password'				=>	'required|confirmed',
	    'password_confirmation' =>	'required',
    ];
    
    /**
     * profile update validation rule.
     *
     * @var array
     */
    public static $rulesProfile = [
	    'first_name'	=>	'required',
	    'last_name'		=>	'required',
	    'mobile' 		=>	'required|numeric',
	    'gender' 		=>	'required',
    ];
    
    /**
     * Forgot password validation rule.
     *
     * @var array
     */
    public static $rulesForgotPassword = [
	    'email'	=>	'required|email',
    ];
    
    /**
     * Registration validation rule.
     *
     * @var array
     */
    public static $rulesRegister = [
	    'first_name'			=>	'required',
	    'last_name'				=>	'required',
    	'email'					=>	'required|email|unique:users',
    	'password'				=>	'required|confirmed',
    	'password_confirmation' =>	'required',
    	'gender' 				=>	'required',
    	'mobile' 				=>	'required|numeric',
    ];

    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }


    /**
     * Relation with UserAvailability
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function availability() {
        return $this->hasOne(UserAvailability::class,USER,USERNAME);
    }    
    /**
     * Relation with UserContact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function contacts(){
        return $this->hasMany(UserContact::class,USER,USERNAME);
    }
    /**
     * Relation with UserContact(receipts being in contact list)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function receipts(){
        return $this->hasMany(UserContact::class,CONTACT,USERNAME);
    } 
    /**
     * Relation with UserDevice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */    
    public function device(){
        return $this->hasOne(UserDevice::class,USER,USERNAME);
    }   
    /**
     * Relation with UserGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function groups(){
       return $this->hasMany(UserGroup::class,USER,USERNAME);
    }          
    /**
     * Relation with UserLogin History
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function loginHistory(){
       return $this->hasMany(UserLoginHistory::class,USER,USERNAME);
    } 
    /**
     * Relation with Chat Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function chatGroups(){
       return $this->hasMany(Groups::class,COM_ADMIN_KEYWORD,USERNAME);
    }  
    /**
     * Relation with Chat Group Logs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function groupChatLogs(){
       return $this->hasMany(GroupChat::class,SENDER,USERNAME);
    }
    /**
     * Relation with Chat Logs(Single chat send by the user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function senderLog(){
       return $this->hasMany(Chat::class,SENDER,USERNAME);
    }
    /**
     * Relation with Chat Logs(Single chat received by the user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function receiverLog(){
       return $this->hasMany(Chat::class,RECEIVER,USERNAME);
    } 
    /**
     * Relation with Chat Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */    
    public function profileImage() {
    	return $this->hasOne(Attachment::class, FOREIGN_ID)->where(CLASS_VAL, 'User');
    }
    /**
     * Relation with UserRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */    
    public function role(){
      return $this->belongsTo(UserRole::class,USER_TYPE);
    }
    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    /**
     * Relation with Spool
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function spool(){
       return $this->hasMany(Spool::class,USERNAME,USERNAME);
    }   
       /**
   * Get Image url
   * @return string
   **/

    public function imageUrl(){
        if(isset($image)&&($image!="")){
         if(((basename($image)=='dummypic.jpg') || (basename($image)=='generic-profile.png'))&&($image=="")){
           $image= URL::asset('assets/img/default_large.png');
         }
         else{
            $image = $this->image;
         }
      }
      else{
         $image=URL::asset('assets/img/default_large.png');
      }
      return $image;
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
