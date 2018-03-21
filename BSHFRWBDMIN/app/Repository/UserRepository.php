<?php
/**
 * UserRepository
 *
 * In this User repository having the methods to process the User data 
 *
 * @category  compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Repository;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\URL;
use App\Lib\Bcrypt;
use DB;
use App\Models\Users;
use App\Models\UsersOtp;
use App\Models\ChannelUserDetails;
use Redis;
use JWTAuth;

class UserRepository {
   
   /**
    * SMS Gateway URL.
    *
    * @var string
    */
    protected $smsGatewayURL = 'https://2factor.in/API/V1/25f01ba0-e4fe-11e5-9a14-00163ef91450/SMS/';
   /**
    * The following function is used to create or update the user
    * It will takes the two parameters
    * data, id
    * data - hold the data such as name and email, etc.
    * id - Is optional parameter, while creating new company id value is null, while
    * updating,it will respective record id
    *
    * @param   $data,$id
    * @return  boolean
    */
   public function createOrUpdateUser($data, $id = null) {
      $result = false;

      if (! empty ( $id )) {
         $user = User::find ( $id );
      } else {
         $user = new User ();
         $user->password = md5 ( $data [PASSWORD] );
      }

      $user->username = $data [NAME];
      $user->mobile_number = $data ['mobile_number'];      
      $user->email = $data [EMAIL];
      $user->user_type = $data [USER_TYPE];
      
      if (isset ( $data [IS_ACTIVE] )) {
         $user->is_active = $data [IS_ACTIVE];
      }

      if (! empty ( $data [IMAGE] )) {
         // Deleted the existing logo of company
         if (! empty ( $id ) && ! empty ( $user->image )) {
            /* Above if condition checks is not empty of id and user's image */
            $this->deleteImage ( $user->image );
         }
         /**
          * image upload start
          * Here, if condition checks whether file directory which is already available or not
          * if its not avaiable, then creates a new directory
          */
         
         // destination path location
         $destinationPath = public_path () . UPLOAD_URL;
         // mode for the file location
         if (! \File::exists ( $destinationPath )) {
            \File::makeDirectory ( $destinationPath, 777, true, true );
         }
         // getting client originalname for image
         $filename = $data [IMAGE]->getClientOriginalName ();
         // getting the path information
         $filename = pathinfo ( $filename, PATHINFO_FILENAME );
         // get the name of the images
         $fullname = str_slug ( str_random ( 8 ) . $filename ) . '.' . $data [IMAGE]->getClientOriginalExtension ();
         // move the image to particular location
         $data [IMAGE]->move ( $destinationPath, $fullname );
         // save the image into the db
         $user->image = $fullname;
      /**
       * Logo upload end
       */
      }
      
      if ($user->save ()) {
        $userObj = User::where ('id', $user->id )->first();
        if (empty ( $id )) {
          // $this->mailSend ( $data );          
        }else{
          if(isset($data['roles'])){
            if($userObj->roles->first()) {
              DB::table('role_user')->where('user_id',$id)->delete();
            }
          }
        }

        if(isset($data['roles'])){
          foreach ($data['roles'] as $key => $value) {
            $userObj->attachRole($value);
          }
        }        

        $result = true;
      }
      
      return $result;
   }

  public function createBusinessAccount($data)
  {

    $user = User::where('mobile_number',$data['mobile_number'] )->first();

      //chk users exists or not
      $businessAcc = Users::where('username',$data['mobile_number'])->first();
      if(!empty($businessAcc)){
          $userMobile = UsersOtp::where ( 'username', '=', $data['mobile_number'] )->first ();
          
          if (empty ( $userMobile )) {
              $userMobile = new UsersOtp ();
              $userMobile->username = $data['mobile_number'];
          }
          $userMobile->mobile_number = $data['mobile_number1'];
          $userMobile->save ();
      
      }
      else{
        $randomString = substr ( str_shuffle ( "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, 10);
        $userModel = new Users();
        $userModel->username =  $data['mobile_number'];
        $userModel->password = $randomString;
        $userModel->status = 1;
        $userModel->save();

        $otp = strval ( mt_rand ( 100000, 999999 ) );
         $userOtp = new UsersOtp ();
         $userOtp->username = $data['mobile_number'];
         $userOtp->otp = $otp;
         $userOtp->save ();
      }

      $tokenRow = ChannelUserDetails::where('user_id',$data['mobile_number'])->first();
      if(!$tokenRow){
        if (! $token = JWTAuth::fromUser($user)) {
          return 'Token not found for user';
        }

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
              'roles' => [],
              'permissions' => [],
              'access' => []
          ]);

        $vcardarray = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'vcard' => $vcardjson,
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
        Redis::set($token, $vcardjson);
        Redis::expire($token, TOKEN_TIME);
      }
   }
   
   /**
    * This function is used to delete the logo of company
    * it will takes the logo as input
    *
    * @param   $image
    *           
    * @return   boolean
    */
   public function deleteImage($image) {
      /* Here $result variable will hold the boolean variable like true or false */
      if (\File::exists ( public_path () . UPLOAD_URL . basename ( $image ) )) {
         /* If the image is already exists then deletes it */
         \File::delete ( public_path () . UPLOAD_URL . basename ( $image ) );
      }
      return true;
   }
   /**
    * This function is used to get the all users information
    *
    * it will takes the data as in put and returns the array as result
    *
    * @param   $data
    *           
    * @return   mixed
    */
   public function getAllUsers($data) {
      return User::where ( 'user_type', 'general' )->where ( function ($query) use ($data) {
         if (isset ( $data ['q'] ) && (! empty ( $data ['q'] ))) {
            /* To fetch all users where user_type not equal to one */
            $query->where ( 'name', 'like', '%' . $data ['q'] . '%' )->orWhere ( 'id', '=', $data ['q'] )->orWhere ( 'email', 'like', '%' . $data ['q'] . '%' )->orWhere ( MOBILE_NUMBER, 'like', '%' . $data ['q'] . '%' );
         }
      } )->where ( function ($query) use ($data) {
         if (isset ( $data [IS_ACTIVE] )) {
            $query->where ( IS_ACTIVE, '=', $data [IS_ACTIVE] );
         }
      } )->where ( 'mobile_number', '!=', 0 )->orderBy ( 'created_at', 'desc' )->paginate ( 10 );
   }
   
   /**
    * This function is used to validate user
    * it will takes the user credentials as input such as
    * personal email and password as input.
    *
    * Returns true on success, false on failure
    *
    * @param   $data
    *
    * @return   boolean
    */
   public function login($data) {
      /* Here $result is a boolean variable, returns true if email and password where is_active equal to one */
      $result = false;
      // get the user details
      $user = User::where ( MOBILE_NUMBER, $data [MOBILE_NUMBER] )->first ();
      // check empty condition
      if (! empty ($user) && count ($user) > 0 && (Auth::loginUsingId($user->id))) {
            // success response
            $result = true;
      } 
      // return result
      return $result;
   }
   
   /**
    * This function is used update the user password
    * it will take user email as input and returns the new password to
    * respective email
    *
    * @param   $data,
    *           
    * @return   boolean
    */
   public function updateUserPassword($data) {
      /* Here $result is a boolean variable, returns true if condition satisfies */
      $result = false;
      // get the specified user details
      $user = User::where ( EMAIL, $data [EMAIL] )->first ();
      // checking usercount
      if (! empty ( $user ) && count ( $user ) > 0) {
         /* If above condition satisfies store the updated password with email,created_at and current date & time */
         $password = str_random ( 8 );
         // hashed password
         $user->password = md5 ( $password ); //. KEY_SECRET
         // save user value
         $user->save ();
         // get emailid
         $data [EMAIL] = $user->email;
         // get usr name
         $data ['name'] = $user->username;
         // get password
         $data [PASSWORD] = $password;
         // queued mail sending process
         if (\Mail::send ( 'email.forgotpassword', $data, function ($message) use ($data) {
            $message->to ( $data [EMAIL], $data ['name'] )->subject ( trans ( 'common.user.forgot_password.mail-subject' ) );
         } )) {
            $result = true;
         }
      }
      
      return $result;
   }
   
   /**
    * Method to check the phone number exists for other users
    *
    * @param integer  $id  User Id
    *           
    * @return   void
    */
   public function checkPhoneNoExists($phone) {
      // get the user details using mobilenumer
      $user = User::where ( COM_MOBILE_NUMBER_KEYWORD, '=', $phone )->first ();
      
      if (! empty ( $user->id )) {
         // success response
         return $user;
      } else {
         // failure return response
         return 0;
      }
   }
   
   /**
    * Method to send mail when a new account is created
    *
    * @param  array  $data           
    *
    * @return   boolean
    */
   public function mailSend($data) {
      // in the closure
      \Mail::send ( 'email.reportpost_admin', $data, function ($message) use ($data) {
         $message->to ( $data [EMAIL], $data ['name'] )->subject ( trans ( 'common.user.password-intimation-mail-subject' ) );
      } );
   }
   
   /**
    * Method to check the username exists for other users
    *
    * @param integer   $id   User Id
    *           
    * @return   void
    */
   public function checkUserNameExists($userName) {
      // get the user details using user name
      $user = User::where ( COM_USERNAME_KEYWORD, '=', $userName )->first ();
      
      if (! empty ( $user->id )) {
         // success return
         return $user;
      } else {
         // failure return
         return 0;
      }
   }
   
   /**
    * Method to save or update the user details
    *
    * @param array $input   Input Parameters
    * @param integer $id   User Id
    *           
    * @return  mixed
    *
    */
   public function createOrUpdateProfile($input, $id = null) {
      if (empty ( $id )) {
         $username = preg_replace('/\s+/', '', $input [COM_COUNTRY_KEYWORD] . $input [COM_MOBILE_NUMBER_KEYWORD]);
         // check the keyword exist
         if (isset ( $input [COM_MOBILE_NUMBER_KEYWORD] )) {
            // get the user details using keywor
            $user = User::where ( COM_USERNAME_KEYWORD, '=', $username )->first ();
         }
         if (empty ( $user )) {
            // new user creation
            $user = new User ();
            \DB::table ( 'user_availability' )->where ( 'user', $username )->delete ();
         }
      } else {
         // edit already available user
         $user = User::find ( $id );
      }
      // random number generation
      $number = $username;
      
      // getting the random string
      $randomString = Bcrypt::hashPassword($number);
      
      // user data functionality
      $user = $this->buildUserData ( $user, $input, $randomString );
      // registration process
      if ($input [COM_USERTYPE_KEYWORD] == COM_GENERAL_TYPE_KEYWORD) {
         if (empty ( $id )) {
            
            $success = $user->save ();
            
            if ($success) {
               if(!isset($input[TYPE])){
                  $this->_sendVerificationCode ( $user );
               }
               $result = array (
                           COM_ERROR_KEY => false,
                           COM_RESPONSE_KEY => array (
                                       COM_ACCESSTOKEN_KEYWORD => $user->access_token,
                                       COM_VERIFY_CODE_KEYWORD => $user->verify_code,
                                       COM_PASSWORD_KEYWORD => $number,
                                       COM_USER_ID_KEYWORD => $user->id,
                                       COM_MESSAGE_KEYWORD => "User successfully registered, we have sent a verification code to your registered mobile number" 
                           ) 
               );
            } else {
               $result = array (
                           COM_ERROR_KEY => true,
                           COM_RESPONSE_KEY => array (
                                       COM_MESSAGE_KEYWORD => "Profile details has not been saved successfully" 
                           ) 
               );
            }
         } else {
            $result = ($user->save ()) ? array (
                        COM_ERROR_KEY => false,
                        COM_RESPONSE_KEY => User::where ( 'id', '=', $user->id )->select ( 'id', COM_USERNAME_KEYWORD, COM_PASSWORD_KEYWORD, 'name', 'status_msg', 'country', COM_COUNTRY_CODE_KEYWORD, COM_MOBILE_NUMBER_KEYWORD, 'image', 'thumbnail', 'gender', 'is_active', COM_CREATED_AT_KEYWORD, 'updated_at', 'user_type', 'access_token', 'verify_code', COM_DEVICE_ID_KEYWORD )->first () 
            ) : array (
                        COM_ERROR_KEY => true,
                        COM_RESPONSE_KEY => array (
                                    COM_MESSAGE_KEYWORD => "Profile has not been updated" 
                        ) 
            );
         }
      } else {
         if ($user->save ()) {
            $result = $randomString;
         } else {
            $result = false;
         }
      }
      
      return $result;
   }
   
   /**
    * This function is used to upload the profile image
    * it will takes the image and resize dimensions of image
    *
    * @param  integer   $userId   User ID
    * @param  array   $image   Image Object
    * @param integer  $width   Image Width
    * @param integer  $height   Image Height
    *           
    * @return  mixed
    */
   public function _uploadImage($userId, $image, $width, $height) {
      // get the id for upload image
      $user = User::find ( $userId );
      // path for upload image
      $imageUploads = public_path () . '/profile/';
      // original image upload path
      $orginalUploads = public_path () . '/uploads/';
      // check directory for exist or create
      if (! \File::exists ( $imageUploads )) {
         \File::makeDirectory ( $imageUploads, 777, true, true );
      }
      if (! (\File::exists ( $orginalUploads ))) {
         \File::makeDirectory ( $orginalUploads, 777, true, true );
      }
      // validation required fields
      if (! empty ( $image )) {
         $imageValidator = \Validator::make ( array (
                     COM_IMAGE_KEYWORD => $image 
         ), array (
                     COM_IMAGE_KEYWORD => 'required|mimes:jpeg,png|image|max:10000' 
         ) );
         if ($imageValidator->passes ()) {
            // success in validation image move process
            $filename = $image->getClientOriginalName ();
            // get image path info
            $filename = pathinfo ( $filename, PATHINFO_FILENAME );
            // get image name
            $fullname = Str::slug ( Str::random ( 8 ) . $filename ) . '.' . $image->getClientOriginalExtension ();
            // resize the image
            \Image::make ( $image )->resize ( $width, $height )->save ( $imageUploads . $fullname );
            \Image::make ( $image )->save ( $orginalUploads . $fullname );
            $user->image = $fullname;
            $user->thumbnail = $fullname;
            $user->save ();
            $res = true;
         } else {
            // validation failure response
            return array (
                        COM_ERROR_KEY => false,
                        COM_RESPONSE_KEY => $imageValidator->messages () 
            );
         }
      } else {
         $res = false;
      }
      // return result
      return $res;
   }
   
   /**
    * Method to send the verfication code to end user
    *
    * @param integer  $verifyCode   Verfication Code
    * @param integer  $countryCode   Country Code
    * @param integer  $mobileNumber   Mobile Number
    *           
    * @return  mixed
    *
    */
   public function _sendVerificationCode($user) {
      //To get the url
      $url=$this->smsGatewayURL."+{$user->username}/{$user->verify_code}/OTP_TIME";
      if (empty ( $url )) {
         return 'Error: invalid Url or Data';
      }
      
      $ch = curl_init ();
      
      curl_setopt ( $ch, CURLOPT_HEADER, 0 );
      // Set curl to return the data instead of printing it to the browser.
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); 
      // timeout after 10 seconds, you can increase it
      curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 ); 
      // set the url and get string together
      curl_setopt ( $ch, CURLOPT_URL, $url ); 
      
      $return = curl_exec ( $ch );
      curl_close ( $ch );
      
      return $return;
   }
   
   /**
    * Method to save or update the user details
    *
    * @param   array   $input  Input   Parameters
    * @param integer  $id   User Id
    *           
    * @return mixed
    *
    */
   public function changePhoneNumber($input) {
      // cheking phone number exist function
      $data = $this->checkPhoneNoExists ( $input [COM_MOBILE_NUMBER_KEYWORD] );
      // get the particular user details
      $user = User::where ( COM_ACCESSTOKEN_KEYWORD, '=', $input [COM_ACCESSTOKEN_KEYWORD] )->first ();
      // check exist or not
      if (count ( $data ) >= 1) {
         if ($data->id != $user->id) {
            return array (
                        COM_ERROR_KEY => true,
                        COM_RESPONSE_KEY => array (
                                    COM_MESSAGE_KEYWORD => "Phone Number already exists" 
                        ) 
            );
         }
         // exist send verification code
         if (count ( $user ) > 0) {
            $user->verify_code = mt_rand ( 100000, 999999 );
            $user->mobile_number = isset ( $input [COM_MOBILE_NUMBER_KEYWORD] ) ? $input [COM_MOBILE_NUMBER_KEYWORD] : $user->mobile_number;
            $user->country_code = isset ( $input [COM_COUNTRY_CODE_KEYWORD] ) ? $input [COM_COUNTRY_CODE_KEYWORD] : $user->country_code;
            return ($user->save ()) ? array (
                        COM_ERROR_KEY => false,
                        COM_RESPONSE_KEY => array (
                                    COM_ACCESSTOKEN_KEYWORD => $user->access_token,
                                    COM_VERIFY_CODE_KEYWORD => $user->verify_code,
                                    COM_MESSAGE_KEYWORD => "User successfully registered, we have sent a verification code to your registered mobile number" 
                        ) 
            ) : array (
                        COM_ERROR_KEY => true,
                        COM_RESPONSE_KEY => array (
                                    COM_MESSAGE_KEYWORD => "Phone Number has not been updated" 
                        ) 
            );
         } else {
            return array (
                        COM_ERROR_KEY => true,
                        COM_RESPONSE_KEY => array (
                                    COM_MESSAGE_KEYWORD => "You are not an authorized user to update the profile" 
                        ) 
            );
         }
      }
   }
   
   /**
    * Method to verify the phone number for current user
    *
    * @param array $input   Input Parameters
    *           
    * @return  mixed
    *
    */
   public function verifyOTPNumber($input) {
      // verify otp process
      $user = User::where ( COM_ACCESSTOKEN_KEYWORD, '=', $input [COM_ACCESSTOKEN_KEYWORD] )->first ();
      if ($user->verify_code == $input [COM_VERIFY_CODE_KEYWORD]) {
         $user->is_active = 1;
         return ($user->save ()) ? array (
                     COM_ERROR_KEY => false,
                     COM_RESPONSE_KEY => array (
                                 COM_ACCESSTOKEN_KEYWORD => $user->access_token,
                                 COM_VERIFY_CODE_KEYWORD => $user->verify_code,
                                 COM_MESSAGE_KEYWORD => "Registration has been successfully completed" 
                     ) 
         ) : array (
                     COM_ERROR_KEY => true,
                     COM_RESPONSE_KEY => array (
                                 COM_MESSAGE_KEYWORD => "Registration has not been successfully completed" 
                     ) 
         );
      } else {
         return array (
                     COM_ERROR_KEY => true,
                     COM_RESPONSE_KEY => array (
                                 COM_MESSAGE_KEYWORD => "Your verification code is wrong. Please try again" 
                     ) 
         );
      }
   }
   
   /**
    * This method is used to validate the country ID & Phone Number
    *
    * @param  integer  $countryId   Country ID
    * @param  integer  $phone   Phone Number
    *           
    * @return   boolean
    */
   public function verifyValidPhoneOrNot($countryCode, $phone) {
      // checking valid phone number or not based on country code
      Country::find ( $countryCode );
      $swissNumberStr = '+' . $countryCode . $phone;
      $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance ();
      $swissNumberProto = $phoneUtil->parse ( $swissNumberStr, \Input::get ( 'country_name_code' ) );
      return $phoneUtil->isValidNumber ( $swissNumberProto );
   }
   
   /**
    * Method to create the password
    *
    * @param   array   $data   Input Parameters
    *           
    * @return   array
    *
    */
   public function createPassword($data) {
      $user = User::where ( function ($query) use ($data) {
         $query->where ( COM_EMAIL_KEYWORD, trim ( $data [COM_EMAIL_KEYWORD] ) );
      } )->first ();
      if (! empty ( $user ) && count ( $user ) == 1) {
         $newPassword = Str::random ( 8 );
         $user->password = Hash::make ( $newPassword );
         $user->save ();
         $forgotPasswordMailTemp = EmailTemplate::where ( 'slug', 'forgot-password' )->first ();
         $emailContent = strtr ( $forgotPasswordMailTemp->body, [ 
                     "##USERNAME##" => $user->name,
                     "##NAME##" => $user->name,
                     "##EMAIL##" => $user->email,
                     "##PASSWORD##" => $newPassword,
                     COM_SITENAME_MAIL_TEMPLATE => COM_SITENAME_KEYWORD 
         ] );
         $subject = strtr ( $forgotPasswordMailTemp->subject, [ 
                     COM_SITENAME_MAIL_TEMPLATE => COM_SITENAME_KEYWORD 
         ] );
         $this->sendMail ( $emailContent, $user->email, $subject, [ 
                     COM_FROM_MAIL_TEMPLATE => 'devi.p@compassitesinc.com',
                     COM_SITENAME_VARIABLE => COM_SITENAME_KEYWORD 
         ] );
         return true;
      } else {
         return false;
      }
   }
   
   /**
    * Method to send the password
    *
    * @param  array  $data   Input Parameters
    *           
    * @return  array
    *
    */
   public function sendPassword($data) {
      $user = User::where ( function ($query) use ($data) {
         $query->where ( COM_EMAIL_KEYWORD, trim ( $data [COM_EMAIL_KEYWORD] ) );
      } )->first ();
      if (! empty ( $user ) && count ( $user ) == 1) {
         $forgotPasswordMailTemp = EmailTemplate::where ( 'slug', 'user-registration-notification' )->first ();
         $emailContent = strtr ( $forgotPasswordMailTemp->body, [ 
                     "##USERNAME##" => $user->name,
                     "##NAME##" => $user->name,
                     "##EMAIL##" => $user->email,
                     "##PASSWORD##" => $data ['password'],
                     COM_SITENAME_MAIL_TEMPLATE => COM_SITENAME_KEYWORD 
         ] );
         $subject = strtr ( $forgotPasswordMailTemp->subject, [ 
                     COM_SITENAME_MAIL_TEMPLATE => COM_SITENAME_KEYWORD 
         ] );
         $this->sendMail ( $emailContent, $user->email, $subject, [ 
                     COM_FROM_MAIL_TEMPLATE => 'devi.p@compassitesinc.com',
                     COM_SITENAME_VARIABLE => COM_SITENAME_KEYWORD 
         ] );
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * This method used to send mail
    *
    * @param  string  $content   Email Template Content
    * @param  string  $user   User mail ID
    * @param  string  $subject   Mail Subject
    * @param  string  $mailConfig   Mail Config
    *           
    * @return  void
    *
    */
   public function sendMail($content, $user, $subject, $mailConfig) {
      // use Mail::send function is used to send the email to users using email template by using the variable $data
      \Mail::send ( 'emails.emailtemplate', [ 
                  'content' => $content 
      ], function ($message) use ($user, $subject, $mailConfig) {
         $message->from ( $mailConfig [COM_FROM_MAIL_TEMPLATE], $mailConfig [COM_SITENAME_VARIABLE] );
         $message->to ( $user )->subject ( $subject );
      } );
   }
   
   /**
    * Method to build the user data for general and admin user
    *
    * @param  array   $user   User   Data
    * @param  array   $input   User   Input Fields
    * @param  string  $randomString   Random string
    *           
    * @return  string
    */
   public function buildUserData($user, $input, $randomString) {
      $user = $this->buildUserObject ( $user, $input );
      $user->verify_code = mt_rand ( 100000, 999999 );
      $user->username = Str::random ( 8 );
      
      if ($input [COM_USERTYPE_KEYWORD] == COM_GENERAL_TYPE_KEYWORD) {
         $user->mobile_number = $input [COM_MOBILE_NUMBER_KEYWORD];
         $user->country_code = $input [COM_COUNTRY_KEYWORD];
         $user->username = preg_replace('/\s+/', '', $input [COM_COUNTRY_KEYWORD] . $input [COM_MOBILE_NUMBER_KEYWORD]);
      }
      if (($input [COM_USERTYPE_KEYWORD] == "general") && empty ( $input ['access_token'] )) {
         $user->password = $randomString;
      }
      if (empty ( $user->id )) {
         $user->access_token = Hash::make ( Str::random ( 8 ) . time () );
      }
      if (\Input::hasfile ( COM_IMAGE_KEYWORD )) {
         $user->image = $user->thumbnail = $this->_uploadProfileImage ( \Input::file ( COM_IMAGE_KEYWORD ) );
      }
      return $user;
   }
   
   /**
    * Method to build the user data with omitting strings
    *
    * @param  array  $user   User Data
    * @param  array  $input  User Input Fields
    *           
    * @return  string
    */
   public function buildUserObject($user, $input) {
      $os = array (
                  "_token",
                  "confirmpassword",
                  "password",
                  "country_name_code" 
      );
      foreach ( $input as $key => $value ) {
         if(!isset($input[TYPE])){
         if (! in_array ( $key, $os )) {
            $user->$key = isset ( $input [$key] ) ? $input [$key] : $user->$key;
         }
         if ($key == COM_PASSWORD_KEYWORD && $input [$key] != '') {
            $user->password = Hash::make ( $input [COM_PASSWORD_KEYWORD] );
         }
      }
      }
      return $user;
   }
   /**
    * Delete user by username
    *
    * @return boolean
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    */
   public function deleteUserByUserName($username) {
      $isDeleted = false;
      $user = User::where ( USERNAME, $username )->select ( [ 
                  ID,
                  USERNAME 
      ] )->first ();
      
      if (! $user instanceof User || ! $user->exists) {
         throw new ModelNotFoundException ( trans ( LANG_RESOURCE_NOT_EXIST ) );
      }
      
      \DB::transaction ( function () use (&$isDeleted, $user) {
         (new GroupRepository ())->changeGroupAdminByUser ( $user );
         
         $user->availability ()->delete ();
         $user->contacts ()->delete ();
         $user->receipts ()->delete ();
         $user->device ()->delete ();
         $user->loginHistory ()->delete ();
         $user->groups ()->delete ();
         $user->groupChatLogs ()->delete ();
         $user->senderLog ()->delete ();
         $user->receiverLog ()->delete ();
         $user->profileImage ()->delete ();
         $user->role ()->delete ();
         $user->spool ()->delete ();
         $isDeleted = $user->delete ();
      } );
      
      return $isDeleted;
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

} 
