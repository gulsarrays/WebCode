<?php

namespace App\Http\Controllers\Users;
// use db file
use Illuminate\Support\Facades\DB;
// use usercontact model file
use App\Models\UserContact;
// use group models file
use App\Models\Groups;
// use user model file
use App\User;
use App\Models\Users;
// use route collector
use Illuminate\Routing\Controller;
// use request file
use Illuminate\Http\Request;
// use request rul
use App\Http\Requests;
// default auth url
use Illuminate\Support\Facades\Auth;
// userrole model url
use App\Models\UserRole;
// cassandra db url
use evseevnn\Cassandra\Database;
// repositroy file
use App\Repository\UserRepository as UserRepository;
// usergroup model file
use App\Models\UserGroup;
// Vcard model file
use App\Models\Vcard;

use App\Models\UserVcard;
use App\Models\ChannelUserDetails;
use App\Models\UserChannels;
use Redis;
use JWTAuth;
use App\Models\Role;
use Hash;
use GuzzleHttp\Client;
use App\Repository\HelpRepository;
//use Excel;

class UserController extends Controller {
   /**
    */
   private $arr_exclude_user_types =  array();
   
   public function __construct(UserRepository $user, HelpRepository $helpRepo) {
      // constructor function for user
      $this->user = $user;
      $this->helpRepo = $helpRepo;
      $this->arr_exclude_user_types = array('super-admin','stringer');
   }
   
   /**
    * Show the form for login.
    *
    * @return \Illuminate\View\View
    */
   public function getLogin() {
      // get login blade
      return view ( 'users.login' );
   }
   
   /**
    * This method is used to login user with email, password
    *
    * @return \Illuminate\Http\Response
    */
   public function postLogin(Request $request) {
      // validation for login function
      $validator = validator ( $request->all (), User::$rules );
      if ($validator->passes ()) {
         $user = User::where ( 'email', $request->username )
                  ->where ( PASSWORD, md5 ( $request->password ) )
                  ->whereRaw ( '( user_type = 1 or user_type = '.pjRoleId.' or user_type = '.stringerRoleId.' )')
                  ->where ( 'is_active', 1 )
                  ->first ();
         
         print('$user : <xmp>');
         print_r($user);
         print('</xmp>');
die('1233');
         if (! empty ( $user ) && $user->user_type == $request->roleName ) {
            return $response = $this->checkUserWithToken($user, $request);

         } else {
            $redirectreturn = redirect ()->route ( ROUTE_GET_LOGIN )->withError ( 'Invalid username or password.' )->withInput ();
         }
      } else {
         // validation error message
         $errorMessage = $validator->messages ()->toArray ();
         // back redirection
         $redirectreturn = redirect ()->back ()->withError ( $errorMessage )->withInput ();
      }
      
      return $redirectreturn;
   }

    public function checkUserWithToken($user, $request)
    {      
      if($user->user_type == 1){

      if ($token = JWTAuth::fromUser($user))
      {
          $tokenRow = ChannelUserDetails::where('user_id',$user->mobile_number)->first();
                    
          if($tokenRow)
          {
            $token = $tokenRow->token;
            (Redis::exists($token))?Redis::del($token):'';
            ChannelUserDetails::where('user_id', $user->mobile_number)->delete();
          }

          $vcardjson = [
              'user_id' => $user->mobile_number,
              'user_name' => $user->username,
              'nickName' => $user->username,
              'token' => $token,
              'status' => null,
              'email' => $user->email,
              'mobileNumber' => $user->mobile_number,
              'gender' => null,
              'dob' => null,
              'created_date' => date("Y-m-d H:i:s")
          ];
          if($user->user_type == 1){$vcardjson['webAdmin'] = 1;}

          $vcardarray = [
              'user_id' => $user->mobile_number,
              'user_name' => $user->username,
              'vcard' => json_encode($vcardjson),
              'token' => $token,
              'mobileNumber' => $user->mobile_number,
              'nickname' => $user->username,
              'status' => null,
              'email' => $user->email,
              'gender' => null,
              'dob' => null,
              'image_url' => null,
              'created_date' => date("Y-m-d H:i:s")
          ];          
          
            ChannelUserDetails::insert($vcardarray);
            Redis::set($token, json_encode($vcardjson));
            Redis::expire($token, TOKEN_TIME);
          
          session(['jwt_token' => $token]);
          session(['userId' => $user->mobile_number]);

      }else{
        return redirect ()->route ( ROUTE_GET_LOGIN )->withError ( 'Auth token error' )->withInput ();
      }
    }else{
      $tokenRow = ChannelUserDetails::where('user_id',$user->mobile_number)->first();
      $token = $tokenRow->token;
      session(['jwt_token' => $token]);
      session(['userId' => $user->mobile_number]);
    }

      return $this->checkLogin ( $request );
    }
   
   /**
    * Method used to logout the session
    *
    * @return \Illuminate\Http\Response
    */
   public function getLogout() {
       
      $token = session('jwt_token');
      Redis::del($token);
      
      session()->flush();
      Auth::logout();
      // logout redirection
      return redirect ()->route (ROUTE_GET_LOGIN )->withSuccess ( 'Logged out successfully.' );
   }
   
   /**
    * Method used to change password
    *
    * @return \Illuminate\View\View
    */
   public function getForgotPassword() {
      // get forgot password page
      return view ( 'users.forgot_password' );
   }
   
   /**
    * Method used to change password
    *
    * @return \Illuminate\Http\Response
    */
   public function postChangePassword() {
      // validation for change password blade file
      $validator = \Validator::make ( $this->requestData, $this->rulesChangePassword );
      if ($validator->passes ()) {
         // success in validation
         if (isset ( $this->authUser ['id'] )) {
            // get the password list for particular auth user id
            $user = User::where ( 'id', $this->authUser ['id'] )->first ();
            // checking old password value
            if (Hash::check ( $this->requestData ['old_password'], $user->password )) {
               $user->password = \Hash::make ( $this->requestData ['password'] );
               $user->save ();
               // success redirection for password update
               $returnfunc = redirect ()->route ( 'get:changepassword' )->withSuccess ( "Password successfully updated." );
            } else {
               // old password failure redirection
               $returnfunc = redirect ()->route ( 'get:changepassword' )->withError ( "Old password is incorrect. Please enter correct password." );
            }
         } else {
            // error in auth user details
            $returnfunc = redirect ()->back ()->withError ( "You are not authenticated User" );
         }
      } else {
         // validation error message process
         $errorMessage = $validator->messages ()->toArray ();
         // redirection for validation
         $returnfunc = redirect ()->back ()->withError ( $errorMessage )->withInput ();
      }
      return $returnfunc;
   }
  
   
   /**
    * Method used to get the user details
    *
    * @return \Illuminate\View\View
    */
   public function getUsers(Request $request) {
       
      if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type == 1)) {
         
         if(isset($request ['userId'])){
            
            $user = Users::where('username','=',$request ['userId'])->first();
            $makeUser = ($user->status == 1)?0:1;
            Users::where('username','=',$request ['userId'])->update(['status' => $makeUser]);
                       
          }

         $allusers = Users::leftjoin('vcard','users.username','vcard.username')
                    ->select('users.*','vcard.vcard')
                    ->where('users.username','!=',null)->get();

         $users = Users::leftjoin('vcard','users.username','vcard.username')
                    ->select('users.*','vcard.vcard')
                    ->where('users.username','!=',null)
                    // ->where ( function ($query) use($request) {
                    //   if (isset ( $request ['q'] ) && (! empty ( $request ['q'] ))) {               
                    //      $query->where ( 'vcard.vcard', 'like', '%' . $request ['q'] . '%' )
                    //      ->orWhere ( 'users.username', 'like', '%' . $request ['q'] . '%' );
                    //   }
                    // } )
                    ->orderBy ( 'created_at', 'desc' )->get( );

         return view ( 'users.users', compact('users','allusers' ));
      } else {
         return redirect ( '/' );
      }
   }

   /**
    * Method to get the group count
    * 
    * @param integer $code           
    * @return integer
    */
   public function getGroupCount($code) {
      // get group count information
      return UserGroup::where ( 'user', $code )->count ();
   }
   
   /**
    * Method used to delete user
    *
    * @return \Illuminate\Http\Response
    */
   public function getDelete($user_id) {
      // delete user details
      $user = User::where ( 'id', $user_id )->first ();
      if (! empty ( $user )) {
         // delete attachment
         $this->__attachmentDelete ( Attachment::where ( 'class', 'User' )->where ( 'foreign_id', $user->id )->first (), 'User' );
         $user->delete ();
      } else {
         // failure message
         return redirect ()->route ( ROUTE_GET_USERS, 'asc' )->withError ( 'Whoops, Something went wrong.' );
      }
      // success message
      return redirect ()->route ( ROUTE_GET_USERS, 'asc' )->withSuccess ( 'User Successfully deleted.' );
   }
   
   /**
    * Method to get the page for adding new staff
    *
    * @return \Illuminate\View\View
    */
   public function addStaff() {
      
      if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type == 1)) {
         
         if(substr_count ($_SERVER['REQUEST_URI'], '/admin')){
            $roles = Role::where('id',3)->pluck('display_name','id');
         }
         else if(substr_count ($_SERVER['REQUEST_URI'], '/adUser')){
            $roles = Role::where('id',4)->pluck('display_name','id');
         }
         else{
            $roles = Role::whereNotIn('id',[3,4])->pluck('display_name','id');
         }

         
         $user_type = UserRole::where ( IS_ACTIVE, 1 )->where ( 'id', '=', 2 )         
                    ->pluck('name', 'id'); 
        
         
         // return view ( 'users.addstaff' )->with ( USER_TYPE, $userType );
          return view ( 'users.addstaff' )->with ( compact('user_type','roles') );
      } else {
         return redirect ( '/' );
      }
   }
   /**
    * Method to store the staff details
    *
    * @param varchar $request           
    *
    * @return \Illuminate\View\View
    *
    */
   public function storeStaff(Request $request) {
      try {        
         // Declare the variable
         $path = '';
         // validation rules for store staff
         $rules = [ 
                     'name' => 'required',
                     EMAIL => 'required|email',
                     // 'channel_id' => 'required',
                     'country_code' => 'required',
                     'mobile_number1' => 'required',
                     'roles' => 'required',
                     'is_active' => 'required'
         ];
         
         $roles = $request->input('roles');
         // if(in_array(3, $roles) && $request->input('channel_id') == ''){
         //    return redirect ()->back ()->with ( ERROR, "Business account need channel info" )->withInput ();
         // }

         $validator = validator ( $request->all (), $rules );
         if ($validator->passes ()) {

            $request [PASSWORD] = 'welcome123';
            if(in_array(3, $roles)){
              $request [USER_TYPE] = 2;
              $redirect = 'sadmin';
            }
            elseif(in_array(4, $roles)){
              $request [USER_TYPE] = 6;
              $redirect = 'adUser';
            }
            else{
              $request [USER_TYPE] = 1;
              $redirect = 'other/users';
            }

            $request['mobile_number'] = $request['country_code'].$request['mobile_number1'];
            
            $alreadyexists = User::whereRaw("(mobile_number =".$request->input(COM_MOBILE_NUMBER_KEYWORD)." or email= '".$request->input(EMAIL)."') ")
                            // where(COM_MOBILE_NUMBER_KEYWORD, $request->input(COM_MOBILE_NUMBER_KEYWORD))
                            // ->Orwhere('email',$request->input(EMAIL) )
                            ->where('user_type', $request [USER_TYPE])
                            ->first();

            if($alreadyexists){
              return redirect ()->back ()->with ( ERROR, 'The Mobile number or email already exist' );
            }
            
            if ($this->user->createOrUpdateUser ( $request->all () )) {

                if(in_array(3, $roles)){
                  // $this->channelUpdate($request->all ());
                  $this->user->createBusinessAccount($request->all ());
                }

               // success redirection
               $path = redirect ()->to ( $redirect )->with ( 'success', 'User added successfully' );
                
            } else {
               // failure redirection
               $path = redirect ()->back ()->with ( ERROR, 'Error while Creating the User details. Please try later' );
            }
            
            return $path;
         } else {
            // validation failure redirection
            return redirect ()->back ()->with ( ERROR, $validator->messages ()->first () )->withInput ();
         }
      } catch ( \Exception $e ) {
        // echo $e->getMessage();exit;
         return redirect ()->back ()->with ( ERROR, 'Could not process! Please try later.' );
      }
   }

   function channelUpdate($data){
      
      $channeldata = UserChannels::where('user_id',$data['mobile_number'])
      ->where('channel_id',$data['channel_id'])
      ->first();
      if($channeldata){
        UserChannels::where('channel_id',$data['channel_id'])
        ->update(['type' => 'B']);
      }
   }

   /**
    * Get the staff data
    *
    * @param Request $request           
    * @return Ambigous <\Illuminate\View\$this, \Illuminate\View\\Illuminate\View\View>
    */
   public function getStaff(Request $request) {
      if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type == 1)) {
        
        // $bushUsers[0] = [];
        $bushUsers = $this->helpRepo->fetchDashboardApiResponse(CHANNEL_SUBS_COUNT_API);
        $allBusinessUsers = User::where ( USER_TYPE, '=', 2 )->where ( IS_ACTIVE, '!=', null)->get();

         $data = User::with ( [ 
                     'role' 
         ] )->where ( USER_TYPE, '=', 2 )
           /*->where ( function ($query) use($request) {         
              if (isset ( $request ['q'] ) && (! empty ( $request ['q'] ))) {               
                 $query->where ( 'username', 'like', '%' . $request ['q'] . '%' )
                 ->orWhere ( EMAIL, 'like', '%' . $request ['q'] . '%' );
              }
           } )*/
         ->orderBy ( 'created_at', 'desc' )->get (  );
        
        foreach($data as $account){
          $key = $this->searchForId($account->mobile_number, $bushUsers[0]);
          if($key === null){
              continue;
          }
          $account['totalNOOfBusinessChannels'] = $bushUsers[0][$key]['totalNOOfBusinessChannels'];
          $account['businesschannels'] = $bushUsers[0][$key]['businesschannels'];
        }

        // get all categories
        $categories = $this->helpRepo->getApiResponse(GET_CATEGORIES);

        // get all age-groups
        $ageGroups = $this->helpRepo->getApiResponse(GET_AGEGROUPS);

        //get paid channels
        $paidChannels = $this->helpRepo->getApiResponse(GET_PAID_CHANNELS);

        //get sponsered channels
        $sponsoredChannels = $this->helpRepo->getApiResponse(GET_SPONSORED_CHANNELS);

        $settings = $this->helpRepo->getEmailSetting(AD_API_BASE.EMAIL_SETTING.'?name=MailReminder');

         return view ( 'users.list' )->with (compact( 'data', 'allBusinessUsers','categories','ageGroups',
          'paidChannels', 'sponsoredChannels','settings'));
      } else {
         return redirect ( '/' );
      }
   }
   
  function searchForId($id, $array) {
     foreach ($array as $key => $val) {
         if ($val['userId'] === $id) {
             return $key;
         }
     }
     return null;
  }

   /**
    * Edit the staff information
    *
    * @param unknown_type $id           
    *
    * @return \Illuminate\View\View
    */
   public function editStaff($id) {
      if (isset ( auth ()->user ()->id )) {
         
         $staff = User::where ( 'id', $id )->first ();
         // $roles = Role::pluck('display_name','id');
         $roles = Role::where('id',3)->pluck('display_name','id');
         $userRole = $staff->roles->pluck('id','username','email')->toArray();

//         if (count ( $staff ) > 0) {
         if (!empty($staff)) {
            // get the details
            $userType = UserRole::whereIn('id', [2])
            ->pluck('name', 'id');
           
            // show it in blade file
            return view ( 'users.editstaff' )->with ( [
                        USER_TYPE => $userType,
                        'user' => $staff,
                        'userRole' => $userRole,
                        'roles' => $roles
            ] );
         } else {
            return redirect ()->back ()->with ( ERROR, trans ( 'common.user.error' ) );
         }
      } else {
         return redirect ( '/' );
      }
   }
   
   /**
    * Update the staff information
    *
    * @param Request $request           
    * @param unknown_type $id           
    *
    * @return \Illuminate\View\View
    */
   public function updateStaff(Request $request, $id) {
      // validation for update staff function
      $rules = [ 
                  EMAIL => 'required|email',
                  'name' => 'required|regex:/^[a-zA-Z0-9\s-]+$/',
                  'mobile_number' => 'required',
                  'is_active' => 'required',
                  'roles' => 'required'
      ];
      
      $roles = $request->input('roles');
      $validator = validator ( $request->all (), $rules );

      if ($validator->passes ()) {
         if(in_array(3, $roles)){
            $request [USER_TYPE] = 2;
            $redirect = 'sadmin';
          }
          elseif(in_array(4, $roles)){
            $request [USER_TYPE] = 6;
            $redirect = 'adUser';
          }
          else{
            $request [USER_TYPE] = 1;
            $redirect = 'other/users';
          }
         if ($this->user->createOrUpdateUser ( $request->all (), $id )) {
            // success redirection
            return redirect ()->back ()->with ( 'success', 'User details updated successfully' );
         } else {
            // failure redirection
            return redirect ()->back ()->with ( ERROR, 'Error while updating the the User details. Please try later' );
         }
      } else {
         // validation failure redirection
         return redirect ()->back ()->with ( ERROR, $validator->messages ()->first () )->withInput ();
      }
   }
   /**
    * This function specifies the delete staff details
    *
    * @return \Illuminate\View\View
    */
   public function deleteStaff($id) {
      // get the id
      if (substr_count ( $id, '~' ) > 0) {
         // multiple id delete
         $user = User::whereIn ( ID, explode ( '~', $id ) );
      } else {
         // single id delete
         $user = User::find ( $id );
      }
      if (! empty ( $user ) && count ( $user ) > 0) {
         $user->delete ();
         // success redirection
         return redirect ()->back ()->withSuccess ( trans ( 'common.user.delete-success' ) );
      } else {
         // failure redirection
         return redirect ()->back ()->withError ( 'No user present with provided id' );
      }
   }
   /**
    * This function is used to update the password and send the new password to the user
    *
    * @return \Illuminate\View\View
    */
   public function postForgotPassword(Request $request) {
      
      /* $errorMessage is variable which is used to store error messages as in array format */
      $errorMessage = array ();
      try {
         
         $messsages = array (
                     'email.exists' => 'The Entered email is invalid.' 
         );
         // validation fields
         $rules [EMAIL] = 'required|email';
         // validation process
         $validator = validator ( $request->all (), $rules, $messsages );
         /* $validator is an object which accepts all predefined validation rules */
         if ($validator->passes ()) {
            // * if $validator returns true then calls updateUserPassword function which is already defined
            // * i.e its user defined function
            // update password process
            if ($this->user->updateUserPassword ( $request->all () )) {
               // success redirection for password changes
               return redirect ()->back ()->withSuccess ( trans ( 'common.user.forgot_password.success' ) );
            } else {
               // failure redirection for password
               $errorMessage = trans ( 'common.user.forgot_password.error' );
            }
         } else {
            // validation redirection for password filds
            $errorMessage = $validator->messages ()->toArray ();
         }
      } catch ( Exception $e ) {
         // exception message
         $errorMessage = $e->getMessage ();
      }
      // error message redirection
      return redirect ()->back ()->withError ( $errorMessage );
   }
   
   /**
    * Get the particular user information
    *
    * @param unknown_type $id           
    * @param unknown_type $sort           
    * @param unknown_type $search           
    *
    * @return \Illuminate\View\View
    */
   public function getUser($id, $sort = 'asc', $search = null) {
      
      $user = User::find ( $id );      
      $userName = $user->username;      
      $users = User::where([['USER_TYPE', '=', '0'],['USERNAME', '!=', $userName],['NAME', '!=', '']])->searchuser ( $sort, $search )->paginate ( 20 );
      
      return view ( 'users.usercontact', [ 
                  USERS => $users,
                  'userid' => $id,
                  'sort' => (! empty ( $sort )) ? $sort : '',
                  'search' => (! empty ( $search )) ? $search : '' 
      ] );
   }
   
   /**
    * This function is used to change the password of user
    * it will takes the old,new,confirm password as input
    *
    * if the user is exists and change the password with old and confirm password
    *
    * @param Request $request,           
    *
    * @return mixed
    */
   public function changePassword(Request $request) {
      /* $errorMessage is variable is which is used to store error messages as in array format */
      $errorMessage = '';
      $messsages = array (
                  'password.required' => 'The password field is required.',
                  'newpassword.required' => 'The new password field is required.',
                  'newpassword.min' => 'The new password field must contains atleast 8 charecters.',
                  'confirmpassword.required' => 'The confirm password field is required.',
                  'confirmpassword.same' => 'The new password and confirm password must be same.' 
      );
      $rules = [ 
                  PASSWORD => 'required',
                  NEWPASSWORD => 'required|min:8|max:35',
                  CONFIRMPASSWORD => 'required|same:newpassword' 
      ];
      $validator = \Validator::make ( $request->all (), $rules, $messsages );
      /*
       * $rules will contains neccessary fields values such as password, newpassword and confirmpasswords $validator is an object
       * which accepts all predefined validation rules
       */
      if ($validator->passes ()) {
         /*
          * Here the password checks with hashed password and if its does match then redirects to change password page
          * with success message unless it's returns error message
          */
         if (md5 ( $request [PASSWORD] ) == \Auth::user ()->password) { 

            if ($request [PASSWORD] != $request [NEWPASSWORD]) {
               $user = User::find ( \Auth::user ()->id );
               $user->password = md5 ( $request [NEWPASSWORD] );
               $user->save ();
               /* If an authenticated user has found and then hashed passwords will be saved in database */
               return redirect ()->back ()->withSuccess ( trans ( 'common.change-password.success' ) );
            } else {
               $errorMessage = trans ( 'common.change-password.same-password-error' );
            }
         } else {
            $errorMessage = trans ( 'common.change-password.invalid-password' );
         }
      } else {
         $errorMessage = $validator->messages ()->toArray ();
      }
      
      return redirect ()->back ()->withError ( $errorMessage );
   }
   
   /**
    * This function is to check the login credentials
    *
    *
    * @param Request $request,           
    *
    * @return mixed
    */
   public function checkLogin($request) {
      // success in validation
      $user = User::where ( 'email', $request->username )
      ->where ( PASSWORD, md5 ( $request->password ) )->where ( 'is_active', '1' )->first ();
      // checking the user count

      if (! empty ( $user )) {
         // authendicated user id
         Auth::loginUsingId ( $user->id );
         // print_r(auth ()->user ()->roles);exit;
         // 
         $this->setRedisKeyForuserIfNotExists($user->id);
         
         // staff login function
         if (auth ()->user ()->hasRole('super-admin') || auth ()->user ()->hasRole('support-admin')) {
            $redirectreturn = redirect ()->to ( 'dashboard' )->withSuccess ( LOGIN_SUCCESS );
         
         }elseif(auth ()->user ()->hasRole('pj')) {
            $redirectreturn = redirect ()->to ( 'pj' )->withSuccess ( LOGIN_SUCCESS );

         }elseif(auth ()->user ()->hasRole('stringer')) {
            $redirectreturn = redirect ()->to ( 'stringer' )->withSuccess ( LOGIN_SUCCESS );

         } else {
            // check the user role for app web
            $userRole = UserRole::find ( auth ()->user ()->user_type );
            // get the permission value
            $permission = explode ( ',', $userRole->permission );
            
            if (strtolower ( $permission [0] ) == 'settings') {
               // success in login
               $redirectreturn = redirect ()->route ( ROUTE_GET_SETTINGS )->withSuccess ( LOGIN_SUCCESS );
            } elseif (strtolower ( $permission [0] ) == 'broadcast') {
               // success in broadcast
               $redirectreturn = redirect ()->route ( ROUTE_GET_BROADCASTS )->withSuccess ( LOGIN_SUCCESS );
            } else {
               // user login
               $redirectreturn = redirect ()->route ( ROUTE_GET_CHANNELS )->withSuccess ( LOGIN_SUCCESS );
            }
         }
      } else {
         // failure redirectiontrans 
         $redirectreturn = redirect ()->route ( ROUTE_GET_LOGIN )->withError (  trans ( 'common.user.login.error_message' ))->withInput ();
      }
      return $redirectreturn;
   }

   public function getOtherUsers(Request $request)
   {
      $data = User::orderBy('id','DESC')
              ->where('user_type','!=',2)->where('user_type','!=',6)
              ->get();

      $users = User::orderBy('id','DESC')
              ->where('user_type','!=',2)->where('user_type','!=',6)->get();

      return view('bushfire.index',compact('data','users'));
//      return view('bushfire.index',compact('data','users'))->with('i', ($request->input('page', 1) - 1) * 2);;
   }
    public function create()
    {
        $roles = Role::pluck('display_name','id');
        return view('bushfire.create',compact('roles'));
    }
    /*
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = md5($input['password']);
        $input['user_type'] = 1;
        $input['is_active'] = 1;

        $user = User::create($input);
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }*/
    public function show($id)
    {
        $user = User::find($id);
        return view('bushfire.show',compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        // $roles = Role::pluck('display_name','id');
        $roles = Role::whereNotIn('id',[3,4])->pluck('display_name','id');        

        $userRole = $user->roles->pluck('id','username','email')->toArray();

        return view('bushfire.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $validate = validator($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            // 'password' => 'same:confirm-password',
            'mobile_number' => 'required',
            'is_active' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();

        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();

        
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function getOtherUsersAjax(Request $request) {

        $columns = array(
            0 => 'id',
            1 => 'username',
            2 => 'email',
            3 => 'mobile_number',
            4 => 'user_type',
            5 => 'is_active',
            6 => 'id',
        );

        $roles_exclude_arr = Role::whereIn('name', $this->arr_exclude_user_types)->orderBy('id', 'asc')->pluck('id')->toArray();

        $roles_exclude_arr = array_merge($roles_exclude_arr, array(6));
        $dataInitial = User::orderBy('id', 'DESC')
//                        ->whereNotIn('user_type', $roles_exclude_arr)
                        ->where('user_type', '!=', 2)->where('user_type', '!=', 6)
                        ->get()->toArray();

        $totalData = count($dataInitial);
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $userData = User::where('user_type', '!=', 2)->where('user_type', '!=', 6)->where('user_type', '!=', 9)
//                    whereNotIn('user_type', $roles_exclude_arr)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $userData = User::where(function ($query) {
                        $query->where('user_type', '!=', 2)->where('user_type', '!=', 6)->where('user_type', '!=', 9);
                    })->Where(function($query) use ($search) {
                        $query->orWhere('username', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('mobile_number', 'LIKE', "%{$search}%");
                    })->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = User::where(function ($query) {
                        $query->where('user_type', '!=', 2)->where('user_type', '!=', 6)->where('user_type', '!=', 9);
                    })->Where(function($query) use ($search) {
                        $query->orWhere('username', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('mobile_number', 'LIKE', "%{$search}%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($userData)) {
            $srno = $start;
            if ($order === 'id' && $dir === 'desc') {
                $srno = ($totalData + 1) - $start;
            }
            foreach ($userData as $tmpUserData) {
                if ($order === 'id' && $dir === 'desc') {
                    $srno--;
                } else {
                    $srno++;
                }
                $edit = route('users.edit', $tmpUserData->id);
                $delete = url('other/user/delete', $tmpUserData->id);

                $nestedData['id'] = $srno;
                $nestedData['username'] = $tmpUserData->username;
                $nestedData['email'] = $tmpUserData->email;
                $nestedData['mobile_number'] = $tmpUserData->mobile_number;

                $nestedData['user_type'] = null;
                if (!empty($tmpUserData->roles)) {
                    foreach ($tmpUserData->roles as $role) {
                        $nestedData['user_type'] .= '<label class="label label-success">' . $role->display_name . '</label>';
                    }
                }

                if ($tmpUserData->is_active === 1) {
                    $nestedData['is_active'] = '<span class="label label-success">Active</span>';
                } else {
                    $nestedData['is_active'] = '<span class="label label-error">Inactive</span>';
                }

                $option_str = null;
                if ($tmpUserData->can('user-edit')) {
                    $option_str .= "&emsp;<a href='{$edit}' title='Edit' class='btn btn-primary'>Edit</a>";
                }
                if ($tmpUserData->ability('super-admin', 'user-delete')) {
                    $option_str .= "&emsp;<a class='btn btn-danger' data-href='{$delete}' data-toggle='modal' data-target='#confirm-delete'>Delete</a>";
                }

                $nestedData['options'] = $option_str;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "limit" => $limit,
            "start" => $start,
            "order" => $order,
            "dir" => $dir,
            "search" => (!empty($search) ? $search : null)
        );

        echo json_encode($json_data);
    }

    public function downloadOtherUsersCsvExcel($type) {
//        $data = User::orderBy('id', 'DESC')
//                        ->where('user_type','!=',2)->where('user_type','!=',6)
//                        ->get()->toArray();
//        return Excel::create('laravelcode', function($excel) use ($data) {
//            $excel->sheet('mySheet', function($sheet) use ($data)
//            {
//                $sheet->fromArray($data);
//            });
//        })->download($type);


        $data[] = array("Id", "Name", "Email", "Mobile Number", "Role", "Status");
        $userdata = User::orderBy('id', 'DESC')
                ->where('user_type', '!=', 2)->where('user_type', '!=', 6)
                ->get();
        $srno = 0;
        foreach ($userdata as $tmpUserData) {
            $srno++;
            if (!empty($tmpUserData->roles)) {
                $str_display_name = null;
                foreach ($tmpUserData->roles as $role) {
                    $str_display_name .= $role->display_name . ",";
                }
                $str_display_name = substr($str_display_name, 0, -1);
            }

            $str_status = null;
            if ($tmpUserData->is_active === 1) {
                $str_status = 'Active';
            } else {
                $str_status = 'Inactive';
            }
            $data[] = array("$srno", "$tmpUserData->username", "$tmpUserData->email", "$tmpUserData->mobile_number", "$str_display_name", "$str_status");
        }

        Excel::create('Filename', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {

                    // call cell manipulation methods
                    $row->setBackground('#d3d3d3');
                });
            });
        })->download($type);
    }

    public function getUsersAjax(Request $request) {

        $columns = array(
            0 => 'created_at',
            1 => 'username',
            2 => 'status',
            3 => 'vcard',
        );

        $dataInitial = Users::leftjoin('vcard', 'users.username', 'vcard.username')
                        ->select('users.*', 'vcard.vcard')
                        ->where('users.username', '!=', null)
                        ->orderBy('created_at', 'desc')
                        ->get()->toArray();

        $totalData = count($dataInitial);
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $userData = Users::leftjoin('vcard', 'users.username', 'vcard.username')
                    ->select('users.*', 'vcard.vcard')
                    ->where('users.username', '!=', null)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $userData = Users::leftjoin('vcard', 'users.username', 'vcard.username')
                    ->select('users.*', 'vcard.vcard')
                    ->where('users.username', '!=', null)
                    ->Where(function($query) use ($search) {
                        $query->orWhere('users.username', 'LIKE', "%{$search}%")
                        ->orWhere('vcard.vcard', 'LIKE', "%<nickName>%{$search}%<nickName>%")
                        ->orWhere('vcard.vcard', 'LIKE', "%<name>%{$search}%</name>%");
                    })->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = Users::leftjoin('vcard', 'users.username', 'vcard.username')
                    ->select('users.*', 'vcard.vcard')
                    ->where('users.username', '!=', null)
                    ->Where(function($query) use ($search) {
                        $query->orWhere('users.username', 'LIKE', "%{$search}%")
                        ->orWhere('vcard.vcard', 'LIKE', "%<nickName>%{$search}%<nickName>%")
                        ->orWhere('vcard.vcard', 'LIKE', "%<name>%{$search}%</name>%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($userData)) {
            $srno = $start;
            if ($order === 'created_at' && $dir === 'asc') {
                $srno = ($totalData + 1) - $start;
            }
            foreach ($userData as $tmpUserData) {

                if ($order === 'created_at' && $dir === 'asc') {
                    $srno--;
                } else {
                    $srno++;
                }
                $nestedData['id'] = $srno;
                $nestedData['username'] = $tmpUserData->username;
                $nestedData['mobile_number'] = $tmpUserData->username;

                if ($tmpUserData->status === 1) {
                    $nestedData['is_active'] = '<span class="label label-success">Active</span>';
                } else {
                    $nestedData['is_active'] = '<span class="label label-error">Inactive</span>';
                }

                try {
                    $vcardObj = @simplexml_load_string($tmpUserData->vcard);
                    $vcardArr = json_decode(json_encode((array) $vcardObj), TRUE);

                    if ($vcardArr && isset($vcardArr['name'])) {
//                                    echo (is_array( $vcardArr['name'])?'N/A': $vcardArr['name']);
                        if (is_array($vcardArr['name'])) {
                            $nestedData['username'] = 'N/A';
                        } else {
                            $nestedData['username'] = $vcardArr['name'];
                        }
                    } elseif ($vcardArr && isset($vcardArr['nickName'])) {
//                                    echo (is_array( $vcardArr['nickName'])?'N/A': $vcardArr['nickName']);
                        if (is_array($vcardArr['nickName'])) {
                            $nestedData['username'] = 'N/A';
                        } else {
                            $nestedData['username'] = $vcardArr['nickName'];
                        }
                    } else {
                        $nestedData['username'] = 'N/A';
                    }
                } catch (\Exception $e) {
                    $nestedData['username'] = 'N/A';
                }

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "limit" => $limit,
            "start" => $start,
            "order" => $order,
            "dir" => $dir,
            "search" => (!empty($search) ? $search : null)
        );

        echo json_encode($json_data);
    }

    public function downloadAppUserCsvExcel($type) {

        $data[] = array("Sr No", "Name", "Mobile Number", "Status");
        $userData = Users::leftjoin('vcard', 'users.username', 'vcard.username')
                ->select('users.*', 'vcard.vcard')
                ->where('users.username', '!=', null)
                ->orderBy('created_at', 'desc')
                ->get();
        $srno = 0;
        foreach ($userData as $tmpUserData) {

            $srno++;

            if ($tmpUserData->status === 1) {
                $str_status = 'Active';
            } else {
                $str_status = 'Inactive';
            }

            try {
                $vcardObj = @simplexml_load_string($tmpUserData->vcard);
                $vcardArr = json_decode(json_encode((array) $vcardObj), TRUE);

                if ($vcardArr && isset($vcardArr['name'])) {
                    if (is_array($vcardArr['name'])) {
                        $str_display_name = 'N/A';
                    } else {
                        $str_display_name = $vcardArr['name'];
                    }
                } elseif ($vcardArr && isset($vcardArr['nickName'])) {
                    if (is_array($vcardArr['nickName'])) {
                        $str_display_name = 'N/A';
                    } else {
                        $str_display_name = $vcardArr['nickName'];
                    }
                } else {
                    $str_display_name = 'N/A';
                }
            } catch (\Exception $e) {
                $str_display_name = 'N/A';
            }

            $data[] = array("$srno", "$str_display_name", "$tmpUserData->username", "$str_status");
        }

        Excel::create('Filename', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {

                    // call cell manipulation methods
                    $row->setBackground('#d3d3d3');
                });
            });
        })->download($type);
    }
    function setRedisKeyForuserIfNotExists($userId) {
        $user = User::where('id', $userId)->first();
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = str_replace(' ', '', strtoupper($v->display_name));
            }
        }
        $token = session('jwt_token');
        
        $vcardjson = json_encode([
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'nickName' => $user->username,
            'token' => $token,
            'status' => null,
            'email' => $user->email,
            'mobileNumber' => $user->mobile_number,
            'gender' => null,
            'dob' => null,
            'image_url' => null,
            'created_date' => date("Y-m-d H:i:s"),
            'roles' => $roles,
            'permissions' => []
        ]);
        
        if(!Redis::exists($token)) {
            Redis::set($token, $vcardjson);
            Redis::expire($token, TOKEN_TIME);  
        } 
    }
    
}
