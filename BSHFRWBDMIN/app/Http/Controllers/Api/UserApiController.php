<?php
/**
 * UserApiController
 *
 * In this UserApiController having the methods to process the API response.
 * 
 * @category  compassites
 * @package   compassites_
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Http\Controllers\Api;
//file to get the request
use Request;
//url to get the controller
use App\Http\Controllers\Controller;
//url to get the model
use App\User;
use App\Models\Users;
//url to get the repository
use App\Repository\UserRepository as UserRepository;
use App\Repository\AdUserRepository as AdUserRepository;

//url to get the repository
use App\Repository\CMSMSRepository as CMSMSRepository;
//validator default url
use Illuminate\Support\Facades\Validator;
//response default function
use Response;
//auth default function
use Auth;
// eloquent exception
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Vcard;
use App\Models\UserVcard;
use App\Models\ChannelUserDetails;
use App\Models\UserChannels;
use Redis;
use JWTAuth;

class UserApiController extends Controller {
   /**
    * Intiallize the construct which is using for UserApiController
    *
    * @param mixed $user
    *           UserRepository Methods
    * @param mixed $cms
    *           CMSMSRepository Methods
    *           
    * @return void
    */
   public function __construct(UserRepository $user, CMSMSRepository $cms, AdUserRepository $adUser) {
      //contruct function to specify overall controlelr
      $this->user = $user;
      $this->cms = $cms;
      $this->adUserRepo = $adUser;
   }
   
   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create() {
      // Set the validation for the user input fields for the access token, country code and mobile number
      $validator = Validator::make ( Request::all (), [ 
            COM_ACCESSTOKEN_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_COUNTRY_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_MOBILE_NUMBER_KEYWORD => COM_REQUIRED_KEYWORD 
      ] );
      // If validation passes trigger the method to change the user phone number
      // If validation not passes and then throws the validation error
      if ($validator->passes ()) {
         try {
            // Change the phone number using teh input parameters
            $response = $this->user->changePhoneNumber ( Request::all () );
            return response ()->json ( $response );
         } catch ( Exception $e ) {
            // return the exception error message
            return response ()->json ( array (
                  COM_ERROR_KEY => true,
                  COM_RESPONSE_KEY => array (
                        COM_MESSAGE_KEYWORD => $e->getMessages () 
                  ) 
            ) );
         }
      } else {
         // return the error message, it throws error if it is having the error
         return response ()->json ( array (
               COM_ERROR_KEY => true,
               COM_RESPONSE_KEY => $validator->messages () 
         ) );
      }
   }
   
   /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request           
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request) {
      // Set the validation for the user input fields for the user type, country code and mobile number
      $validator = Validator::make ( Request::all (), [ 
            COM_COUNTRY_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_MOBILE_NUMBER_KEYWORD => COM_REQUIRED_KEYWORD . '|mobile_zeronumber',
            COM_USERTYPE_KEYWORD => COM_REQUIRED_KEYWORD,
            'country_name_code' => COM_REQUIRED_KEYWORD 
      ] );
      $request = Request::all ();
      // If validation passes trigger the method to create or update the user details
      // Before create or update it will verify the phone number is valid or not
      // If validation not passes and then throws the validation error
      if ($validator->passes ()) {
         try {
            
            if ($this->user->verifyValidPhoneOrNot ( $request [COM_COUNTRY_KEYWORD], $request [COM_MOBILE_NUMBER_KEYWORD] ) === false) {
               $response = array (
                     COM_ERROR_KEY => false,
                     COM_RESPONSE_KEY => array (
                           COM_MESSAGE_KEYWORD => "Phone and country code is invalid" 
                     ) 
               );
            }
            // Here is to create or update the user profile
            $response = $this->user->createOrUpdateProfile ( $request );
            return response ()->json ( $response );
         } catch ( Exception $e ) {
            return response ()->json ( array (
                  COM_ERROR_KEY => false,
                  COM_RESPONSE_KEY => array (
                        COM_MESSAGE_KEYWORD => $e->getMessages () 
                  ) 
            ) );
         }
      } else {
         // return the validator error message, it throws error if it is having the error
         return response ()->json ( array (
               COM_ERROR_KEY => true,
               COM_RESPONSE_KEY => $validator->messages () 
         ) );
      }
   }
   
   /**
    * Show the form for editing the specified resource.
    *
    * @param int $id           
    * @return \Illuminate\Http\Response
    */
   public function editProfile($id) {
      // Set the validation for the user input fields for the access token, user type, username, country code and mobile number
      $validator = Validator::make ( Request::all (), [ 
            COM_ACCESSTOKEN_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_USERTYPE_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_COUNTRY_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_MOBILE_NUMBER_KEYWORD => 'unique:users,mobile_number,' . $id,
            COM_USERNAME_KEYWORD => 'unique:users,username,' . $id 
      ] );
      // If validation passes trigger the method to create or update the user details
      // If validation not passes and then throws the validation error
      if ($validator->passes ()) {
         try {
            $response = $this->user->createOrUpdateProfile ( Request::all (), $id );
            return response ()->json ( $response );
         } catch ( Exception $e ) {
            // return the exception error message
            return response ()->json ( array (
                  COM_ERROR_KEY => false,
                  COM_RESPONSE_KEY => array (
                        COM_MESSAGE_KEYWORD => $e->getMessages () 
                  ) 
            ) );
         }
      } else {
         // return the validator error message
         return response ()->json ( array (
               COM_ERROR_KEY => true,
               COM_RESPONSE_KEY => $validator->messages () 
         ) );
      }
   }
   
   /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request           
    * @return \Illuminate\Http\Response
    */
   public function verifyOTP(Request $request) {
      // Set the validation for the user input fields for the access token, verify code
      $validator = Validator::make ( Request::all (), [ 
            COM_ACCESSTOKEN_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_VERIFY_CODE_KEYWORD => COM_REQUIRED_KEYWORD 
      ] );
      // If validation passes trigger the method to send the verification code
      // If validation not passes and then throws the validation error
      if ($validator->passes ()) {
         try {
            $response = $this->user->verifyOTPNumber ( Request::all () );
            
            return response ()->json ( $response );
         } catch ( Exception $e ) {
            // return the exception error message
            return response ()->json ( array (
                  COM_ERROR_KEY => false,
                  COM_RESPONSE_KEY => array (
                        COM_MESSAGE_KEYWORD => $e->getMessages () 
                  ) 
            ) );
         }
      } else {
         // return the validator error message
         return response ()->json ( array (
               COM_ERROR_KEY => true,
               COM_RESPONSE_KEY => $validator->messages () 
         ) );
      }
   }
   
   /**
    * Update the form for editing the specified resource.
    *
    * @param int $id           
    * @return \Illuminate\Http\Response
    */
   public function updateProfile($id) {
      // Set the validation for the user input fields for the access token
      $validator = Validator::make ( Request::all (), [ 
            COM_ACCESSTOKEN_KEYWORD => COM_REQUIRED_KEYWORD 
      ] );
      // Get the input parameters
      $input = \Input::all ();
      // If validation passes trigger the method to build the user data
      // If validation not passes and then throws the validation error
      if ($validator->passes ()) {
         try {
            $user = User::where ( 'access_token', $input ['access_token'] )->first ();
            foreach ( $input as $key => $value ) {
               $user->$key = isset ( $input [$key] ) ? $input [$key] : $user->$key;
            }
            // Save the user datas
            if ($user->save ()) {
               $result = response ()->json ( array (
                     COM_ERROR_KEY => true,
                     COM_RESPONSE_KEY => array (
                           COM_MESSAGE_KEYWORD => "Profile has been updated" 
                     ) 
               ) );
            } else {
               $result = response ()->json ( array (
                     COM_ERROR_KEY => true,
                     COM_RESPONSE_KEY => array (
                           COM_MESSAGE_KEYWORD => "Profile has not been updated" 
                     ) 
               ) );
            }
         } catch ( Exception $e ) {
            // return the exception error message
            $result = response ()->json ( array (
                  COM_ERROR_KEY => true,
                  COM_RESPONSE_KEY => array (
                        COM_MESSAGE_KEYWORD => $e->getMessages () 
                  ) 
            ) );
         }
       } else {
         // return the validator error message
            $result = response ()->json ( array (
                    COM_ERROR_KEY => true,
                    COM_RESPONSE_KEY => $validator->messages ()
            ) );
     }
        // Return the response
         return $result;
    }
   /**
    * Delete user account.
    *
    * @param string $username           
    * @return \Illuminate\Http\Response
    */
    public function destroy() {
        $validator = Validator::make(Request::all(),[USERNAME => COM_REQUIRED_KEYWORD]);      

        if($validator->fails()){
            $response = $this->getValidationFailureResponse($validator);
        } else {
          try{
            $response = $this->user->deleteUserByUserName(Request::get(USERNAME)) 
                            ? $this->getSuccessJsonResponse(trans('common.user.delete_success'))
                            : $this->getErrorJsonResponse(trans('common.user.delete_error'));
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $response = $this->getResponseFromException($e,404);
          } catch (\Exception $e){
            $response = $this->getResponseFromException($e);
          }
        }

        return $response;
    }

  public function handleUserLogin()
  {
        $input = \Input::all ();
        $request = json_decode($input['user']);
        
        $validator = Validator::make([
          'username' => $request->username,
          'password' => $request->password,
          'accountType' => $request->accountType
          ],
        [
          COM_USERNAME_KEYWORD => COM_REQUIRED_KEYWORD.'|email',
          COM_PASSWORD_KEYWORD => COM_REQUIRED_KEYWORD,
          'accountType' => COM_REQUIRED_KEYWORD
        ]);      

        if($validator->passes()) {
          $result = $this->adUserRepo->CheckUserAccount($request);
        }

        if(!isset($result) || !$result){
          $result = [
                'status' => 0,
                'message' => 'Incorrect User'
              ];
        }
        
      
      return json_encode($result);

  }

   
}