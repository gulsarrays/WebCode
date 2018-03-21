<?php
/**
 * BroadcastApiController Controller
 *
 * This controller is used handle the broadcast related activities
 *
 */
namespace App\Http\Controllers\Api;

// get the settings model
use App\Models\Settings;
// eloquent exception
use Illuminate\Database\Eloquent\ModelNotFoundException;
// url for user mdoel
use App\User;
// url for broadcast model
use App\Models\Broadcast;
// url for common controller
use App\Http\Controllers\CommonController;
// url for request
use Illuminate\Http\Request;
// url for controller
use App\Http\Controllers\Controller;
// url to get the repository
use App\Repository\UserRepository as UserRepository;
// get date time
use \DateTime;
// get timezone value
use \DateTimeZone;

class BroadcastApiController extends CommonController {
   // constructor
   public function __construct(UserRepository $user, Request $request) {
      // getting user repositoryvalue
      $this->user = $user;
      // construct function to get all request
      parent::__construct ( $request->all () );
   }
   
   /**
    * Get the broadcast list
    */
   public function getBroadcast() {
      // validation for user id
      $this->rules [COM_USER_ID_KEYWORD] = REQUIRED;
      // set error as default
      $error = true;
      // get the response code
      $responseCode = 101;
      // set initial response value
      $response = '';
      // To calculate data & time for lesser than 5 mins
      $date = new \DateTime ( "now", new DateTimeZone ( 'Asia/Kolkata' ) );
      // Formatted date
      $formatDate = $date->format ( 'y-m-d H:i:s' );
      // validation process
      $validator = \Validator::make ( $this->requestData, $this->rules );
      if ($validator->passes ()) {
         // success in validation
         $broadcast = Broadcast::where ( 'broadcast_time', '<=', $formatDate )->where ( 'is_active', 1 )->orderBy ( COM_CREATED_AT_KEYWORD, 'desc' )->get ();
         $data = $broadcast->toArray ();
         $error = false;
         $responseCode = 100;
      } else {
         // failure in validation
         $response = $this->_formatValidationMessages ( $validator->messages ()->toArray () );
      }
      // return response value in json format
      return \Response::json ( [ 
                  ERROR => $error,
                  RESPONSE_CODE => $responseCode,
                  RESPONSE => $response,
                  DATA => $data 
      ] );
   }
   
   /**
    * Set the pin number for backend login
    */
   public function setPin() {
      // validation for user name
      $this->rules [USERNAME] = REQUIRED;
      // validation for pin number
      $this->rules [PIN] = REQUIRED;
      // error code assign
      $error = true;
      // response code value
      $responseCode = 101;
      // initial response value
      $response = '';
      // validation process
      $validator = \Validator::make ( $this->requestData, $this->rules );
      if ($validator->passes ()) {
         // sucess in validation
         $userName = $this->requestData [USERNAME];
         $password = $this->requestData [PIN];
         try {
            // get the user value
            $user = User::where ( USERNAME, $userName )->firstOrFail ();
            // update pin value
            $user->web_password = $password;
            // save user value
            $user->save ();
            // change the error response
            $error = false;
            // success response code
            $responseCode = 100;
            // success response
            $response = 'Pin Successfully updated';
         } catch ( ModelNotFoundException $ex ) {
            // failure response
            $response = USERNOTFOUND;
         }
      } else {
         // failure response
         $response = $this->_formatValidationMessages ( $validator->messages ()->toArray () );
      }
      // return response in json format
      return \Response::json ( [ 
                  ERROR => $error,
                  RESPONSE_CODE => $responseCode,
                  RESPONSE => $response 
      ] );
   }
   /**
    * setting function api process
    */
   public function getSettings($id) {
      $error = true;
      $responseCode = 101;
      // get setting value
      $settings = Settings::find ($id);
      if (! empty ( $settings )) {
         // success response
         $error = false;
         $responseCode = 100;
      }
      // return json format response message
      return \Response::json ( [ 
                  ERROR => $error,
                  RESPONSE_CODE => $responseCode,
                  RESPONSE => $settings 
      ] );
   }
   
   /**
    * setting function api process
    */
   public function getDomains() {
      $error = true;
      $responseCode = 101;
      // get setting value
      $settings = Settings::select('id','xmpp_host as domain')->get();
      if (! empty ( $settings )) {
         // success response
         $error = false;
         $responseCode = 100;
      }
      // return json format response message
      return \Response::json ( [
                  ERROR => $error,
                  RESPONSE_CODE => $responseCode,
                  RESPONSE => $settings
      ] );
   }
   /**
    * To check the pin number for the username
    *
    * return JSON
    */
   public function getVerificationDetails() {
      // get username validation
      $this->rules [USERNAME] = REQUIRED;
      // pin number validation
      $this->rules [PIN] = REQUIRED;
      $error = true;
      $responseCode = 101;
      $response = '';
      // validation process
      $validator = \Validator::make ( $this->requestData, $this->rules );
      
      if ($validator->passes ()) {
         // validation succcess
         $userName = $this->requestData [USERNAME];
         $pinNumber = $this->requestData [PIN];
         
         try {
            $user = User::where ( USERNAME, $userName )->where ( WEBPASSWORD, $pinNumber )->firstOrFail ();
            // set the country code
            $request ['country'] = $user ['country_code'];
            // set the country name
            $request ['country_name_code'] = $user ['country'];
            // set the mobile number
            $request ['mobile_number'] = $user ['mobile_number'];
            // set the user type
            $request ['user_type'] = "general";
            $request['type']='login';
            // Here is to create or update the user profile
            $responsepassword = array ();
            // create or update profile infor to get the password
            $responsepassword = $this->user->createOrUpdateProfile ( $request );
            // error message
            $error = false;
            // response code
            $responseCode = 100;
            // success message
            $message = "success";
            // status value
            $status = 1;
            // get the password value
            $password = $responsepassword ['response'] ['password'];
            //To get the user id
            $userId=$user ['id'];
            // success response
            $response = 'Pin Number Verified.';
         } catch ( ModelNotFoundException $ex ) {
            // failure response
            $message = "failure";
            $status = 0;
            $response = "Invalid username or pin number";
         }
      } else {
         // failure response
         $message = "failure";
         $status = 0;
         $response = $this->_formatValidationMessages ( $validator->messages ()->toArray () );
      }
      // return values in json format
      return \Response::json ( [ 
                  ERROR => $error,
                  RESPONSE_CODE => $responseCode,
                  'message' => $message,
                  'status' => $status,
                  'password' => isset ( $password ) ? $password : '',
                  'user_id'=> isset ( $userId ) ? $userId : '',
                   RESPONSE => $response 
      ] );
   }
   /**
    * get api pin number function
    */
   public function getPin() {
      // validation for user naem
      $this->rules [COM_USER_ID_KEYWORD] = REQUIRED;
      // error code assign
      $error = true;
      // response code value
      $responseCode = 101;
      // initial response value
      $response = '';
      // validation process
      $validator = \Validator::make ( $this->requestData, $this->rules );
      if ($validator->passes ()) {
         // sucess in validation
         $userID = $this->requestData [COM_USER_ID_KEYWORD];
         try {
            // get the user value
            $user = User::select ( WEBPASSWORD )->where ( 'id', $userID )->first ();
            if (empty ( $user->web_password )) {
               // genearating random number value
               $randomno = rand ( 1000, 9999 );
               // updating the web password for particular user
               $user = User::where ( 'id', $userID )->update ( array (
                           WEBPASSWORD => $randomno 
               ) );
               // error value as false
               $error = false;
               // success response code
               $responseCode = 100;
               // success response
               $response = $randomno;
            } else {
               // change the error response
               $error = false;
               // success response code
               $responseCode = 100;
               // success response
               $response = $user->web_password;
              }
            } catch ( ModelNotFoundException $ex){
            //failure response
            $response = USERNOTFOUND;
          }
    
       }else{
            //failure response
            $response = $this->_formatValidationMessages($validator->messages()->toArray());
         }
            $pin_number['pin_number'] = $response;
           //return response in json format
            return \Response::json([
                ERROR => $error,
                RESPONSE_CODE => $responseCode,
                RESPONSE => $pin_number,
          ]);
    }
    
    
}
