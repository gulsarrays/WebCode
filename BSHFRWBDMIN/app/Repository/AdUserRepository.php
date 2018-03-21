<?php

namespace App\Repository;

use App\Repository\UserRepository as UserRepository;
use Request;
use App\Models\AdUsers;
use App\User;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use App\Models\Vcard;
use App\Models\UserVcard;
use App\Models\ChannelUserDetails;
use App\Models\UserChannels;
use Redis;
use JWTAuth;
use App\Models\UserRole;
use App\Models\Permission;
use DB;
use GuzzleHttp\Client;

class AdUserRepository {

	public function __construct(UserRepository $user) {
		// constructor function for user
		$this->user = $user;
	}

	public function createOrUpdateUser($data, $id = null) {
      
      $result = false;
      if (! empty ( $id )) {

        $user = User::find ( $id );
      } else {
         $user = new User();
         $user->password = md5 ( 'welcome123' );
      }
      
      $user->username = $data [NAME];      
      $user->mobile_number = $data ['mobile_number'];
      $user->email = $data [EMAIL];
      $user->user_type = $data [USER_TYPE];
      if (isset ( $data [IS_ACTIVE] )) {
         $user->is_active = $data [IS_ACTIVE];
      }
      
      if ($user->save ()) {
        $userObj = User::where ('id', $user->id )->first();
         if (empty ( $id )) {
            $this->user->mailSend ( $data );
         }
         else{
          if($userObj->roles->first()) {
            DB::table('role_user')->where('user_id',$id)->delete();
          }
        }         
            foreach ($data['roles'] as $key => $value) {
              $userObj->attachRole($value);
            }
         $result = true;
      }       
      
      return $result;
   }

   public function CheckUserAccount($request){

      if($request->accountType == CHANNEL_ACCOUNT)
      {
          $user = User::where ( 'email', $request->username )
                 ->where ( PASSWORD, md5 ( $request->password ) )
                 ->where ( 'user_type', 2 )
                 ->where ( 'is_active', '1' )
                 ->first ();
          // $permissions = UserRole::where('slug', 'admin')->pluck('permission');
          if($user){            
            $app_user = Users::where ( USERNAME, $user->mobile_number )->first ();
            if(empty($app_user)){
              return false;
            }
          }

      }else
      {
        $user = User::where ( 'email', $request->username )
                 ->where ( PASSWORD, md5 ( $request->password ) )
                 ->where ( 'user_type', 6 )
                 ->where ( 'is_active', '1' )
                 ->first ();
      }

      if (! empty ( $user ) ) {
        $permissions = [];
        $userRoles = $user->roles;
        foreach($user->roles as $role){
          $roleid = $role->id;
          $permission_arr = Permission::join('permission_role','permissions.id','permission_role.permission_id')
                  ->where('permission_role.role_id',$roleid)
                  ->pluck('permissions.name')->toArray();
        }
        $permissions = implode(',', $permission_arr);

        return $result = $this->checkUserAccountWithToken($user, $request, $permissions);
      }

   }

   public function checkUserAccountWithToken($adminuser, $request, $permissions)
   {
         if($request->accountType == CHANNEL_ACCOUNT)
         {
            $user = Users::where ( USERNAME, $adminuser->mobile_number )->first ();
            $token = JWTAuth::fromUser($user);
            $username = $user->username;
            
         }else
         {
            $user = $adminuser;
            $token = JWTAuth::fromUser($adminuser);
            $username = $adminuser->mobile_number;
         }
         if(!$user || !$token){
            return false;
         }

         $vcard = UserVcard::where(COM_USERNAME_KEYWORD, '=', $username)->pluck ('vcard')->toArray();

      if(!empty($vcard)){
         $userXmlObj = @simplexml_load_string($vcard[0]);
         $userArr = json_decode(json_encode((array)$userXmlObj), TRUE);         

         $vcardjson = json_encode([
              'user_id' => $username,
              'user_name' => (!empty($userArr['name']))?$userArr['name']:' ',
              'nickname' => (!empty($userArr['nickName']))?$userArr['nickName']:null,
              'token' => $token,
              'status' => null,
              'email' => (!empty($userArr['email']))?$userArr['email']:null,
              'mobileNumber' => (!empty($userArr['mobileNumber']))?$userArr['mobileNumber']:$user->username,
              'gender' => (!empty($userArr['gender']))?$userArr['gender']:null,
              'dob' => (!empty($userArr['dob']))?$userArr['dob']:null,
              'image_url' => (!empty($userArr['image']))?$userArr['image']:null,
              'created_date' => date("Y-m-d H:i:s"),
              'roles' => [],
              'permissions' => [],
              'access' => [],
              'webAdmin' => 1
           ]);

         $vcardarray = [
           'user_id' => $username,
           'user_name' => (!empty($userArr['name']))?$userArr['name']:' ',
           'vcard' => $vcardjson,
           'token' => $token,
           'mobileNumber' => (!empty($userArr['mobileNumber']))?$userArr['mobileNumber']:$user->username,
           'nickname' => (!empty($userArr['nickName']))?$userArr['nickName']:null,
           'status' => (!empty($userArr['status']))?$userArr['status']:null,
           'email' => (!empty($userArr['email']))?$userArr['email']:null,
           'gender' => (!empty($userArr['gender']))?$userArr['gender']:null,
           'dob' => (!empty($userArr['dob']))?$userArr['dob']:null,
           'image_url' => (!empty($userArr['image']))?$userArr['image']:null,
           'created_date' => date("Y-m-d H:i:s"),
         ];
      }else{
         $vcardjson = json_encode([
              'user_id' => $username,
              'user_name' => $adminuser->username,
              'nickName' => $adminuser->username,
              'token' => $token,
              'status' => null,
              'email' => $adminuser->email,
              'mobileNumber' => $username,
              'gender' => null,
              'dob' => null,
              'image_url' => null,
              'created_date' => date("Y-m-d H:i:s"),
              'roles' => [],
              'permissions' => [],
              'access' => [],
              'webAdmin' => 1
           ]);
         $vcardarray = [
           'user_id' => $username,
           'user_name' => $adminuser->username,
           'vcard' => $vcardjson,
           'token' => $token,
           'mobileNumber' => $username,
           'nickname' => $adminuser->username,
           'status' => null,
           'email' => $adminuser->email,
           'gender' => null,
           'dob' => null,
           'image_url' => null,
           'created_date' => date("Y-m-d H:i:s")
         ];
      }

      $tokenRow = ChannelUserDetails::where('user_id',$username)->first();
      if($tokenRow){
         $token = $tokenRow->token;
         ChannelUserDetails::where('user_id',$username)->delete();
         Redis::del($token);
      }

      ChannelUserDetails::insert($vcardarray);
      Redis::set($token, $vcardjson);
      Redis::expire($token, TOKEN_TIME);

      return $result = [
               'data' => [
                  'user' => $adminuser,
                  'accountType' => $request->accountType,
                  'token' => $token,
                  'permissions' => $permissions
               ],
               'status' => 1
            ];

   }

  public function getAdUserList($url)
  {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('GET', $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ]
            ])->getBody();
        $response = json_decode($response, true);
        
        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }
        else if(isset($response['status']) && ($response['status'] == 200)){
            return $response['content'];
        }
        else{
            return false;
        }
  }

  public function approveAd($adId, $status)
  {
        $url = AD_API_BASE.GET_AD.$adId;
        $jwt_token = session('jwt_token');
        $data = [
          "adId" => strval($adId),
          "status" => $status,
          "rejectReason" => ($status == APPROVED)?'':REJECT_MSG
        ];        

        $url = AD_API_BASE.APPROVE_AD;
        $client = new Client();
        $response = $client->request('POST', $url,
            [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'body' => json_encode($data)
            ])->getBody();
        $response = json_decode($response, true);

        $result = [];
        try{
          if(isset($response['status']) && ($response['status'] == 200)){            
              return 1;
          }
          else{
              return 0;
          }
        }
        catch(\Exception $e){
          return 0;
        }
  }

}

?>