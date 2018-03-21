<?php
/**
 * PushApiController Controller
 *
 * This controller is used to send broadcast notification,SIP call and text notification
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Http\Controllers\Api;
//common controller file
use App\Http\Controllers\CommonController;
//getting request url
use Illuminate\Http\Request;
//getting controller function
use App\Http\Controllers\Controller;
//getting user device
use App\Models\UserDevice;
//getting common repository
use App\Repository\CommonRepository;


class PushApiController extends CommonController {
   //get defult constructor value
   public function __construct(Request $request,CommonRepository $common) {
      //To access the repository function
      $this->common=$common;
      //request values in constructor file
      parent::__construct ( $request->all());
   }
   
  
   /**
     * this function is used to send push notification to all users
     */
    public function sendBroadcastToUser(Request $request) {
       try {
          //Required parameters for one to one call
          $this->rules[SENDERUSERNAME]=REQUIRED;
          $this->rules[RECEIVERUSERNAME]=REQUIRED;
          $this->rules[TITLE]=REQUIRED;
          $this->rules[MESSAGE]=REQUIRED;
          //To get the message
          $message =  array(MESSAGE=>$request[MESSAGE],SENDERUSERNAME=>$request[SENDERUSERNAME],TITLE=>$request[TITLE],TYPE=>BROADCAST);
          $user[]=$request[RECEIVERUSERNAME];
          $type='single';
          //validation process
          $validator = \Validator::make($request->all(),$this->rules);
          if($validator->passes()){
          //To get the device token based on the username
          $androidDeviceToken = UserDevice::where ( DEVICE, 'android' )->whereIn('user',$user)->select ( DEVICE_TOKEN )->groupBy ( 'user' )->orderBy ( 'date', 'desc' )->lists ( DEVICE_TOKEN );
          //getting ios device token
          $iosDeviceToken = UserDevice::where ( DEVICE, 'ios' )->whereIn('user',$user)->select ( DEVICE_TOKEN )->groupBy ( 'user' )->orderBy ( 'date', 'desc' )->lists ( DEVICE_TOKEN );
          //pushnotifiction for android
          $this->common->android( $message, $androidDeviceToken,$type);
          //push notifiction for ios
          $this->common->iOS ( $message,$iosDeviceToken,$type);
          $error =false;
          //success response code
          $responseCode='200';
          //response message
          $response='Notification has been sent successfully';
          }
          else{
             $error=true;
             $responseCode='101';
             //failure response
             $response = $this->_formatValidationMessages($validator->messages()->toArray());
          }
          } catch ( Exception $e ) {
                      $error =false;
                      $responseCode='401';
                      $response=$e->getMessages ();
                      
            
          }
          //To return the json response
          return \Response::json([
                      ERROR => $error,
                      RESPONSE_CODE => $responseCode,
                      RESPONSE => $response,
          ]);
    
       }
       
       /**
        * this function is used to send push notification to all users
        */
       public function sendNotificationToUser($type,Request $request) {
          try {
             // Response
             $errorResponse =false;
             $responseCode='101';
             $status=NOT_REACHED;
             
            //To get the rules based on the call type
             $this->rules($type);
             
             //To get the parameters message, eventname and event action.
             $message =  array(TITLE=>INCOMINGCALL,
                         EVENTNAME=>$request[EVENTNAME],
                         EVENTACTION=>$request[EVENTACTION],
                         KEY=>$request[KEY],
                         MEMBERID=>isset ( $request[MEMBERID] ) ? $request[MEMBERID] : '',
                         TYPE=>BROADCAST
                         );
             //To get the device number
             $user=$request[USERNAME];
             //validation process
             $validator = \Validator::make($request->all(),$this->rules);
             if($validator->passes()){
             //To get the device Id for android and ios devices based on the username.
             $getDeviceToken = UserDevice::where('user',$user)->where(DEVICE_TOKEN,'!=','')->first();
             $deviceType=$getDeviceToken[DEVICE];
             $deviceToken=array($getDeviceToken[DEVICE_TOKEN]);
             
             //To send notification to android device
             if($deviceType=='android'){
                $result=$this->common->android( $message, $deviceToken,$type);
                $status=$this->getResponse($result);
             }
              
             //To send notification to ios device
             else if($deviceType=='ios'){
               $result= $this->common->iOS ( $message,$deviceToken,$type);
               if($result){
                  $status=REACHED;
               }else{
                  $status=NOT_REACHED;
               }
             }
             
             }
             else{
                //failure response
                $errorResponse=true;
                $responseCode='101';
                $message = $this->_formatValidationMessages($validator->messages()->toArray());
             }
          } catch ( Exception $e ) {
             //failure response
             $errorResponse =false;
             $responseCode='401';
             $message=$e->getMessages ();
          }
          //To return the response
          return \Response::json([
                      ERROR => $errorResponse,
                      RESPONSE_CODE => $responseCode,
                      RESPONSE => $status,
                      
          ]);
       
       }
       
       /**
        * this function is used to get the rules
        */
       public function rules($type){
          switch ($type) {
             case ($type=='one-one' || 'conference-register') :
                $this->common();
                break;
             case 'conference':
                 //Required parametrs for conference left,joined and unable to leave a conference call
                $this->rules[USERNAME]=REQUIRED;
                $this->rules[EVENTNAME]=REQUIRED;
                $this->rules[EVENTACTION]=REQUIRED;
                $this->rules[KEY]=REQUIRED;
                $this->rules['memberId']=REQUIRED;
                break;
             
             default:
                $this->common();
                break;
          }
       }
       
       /**
        * this function is used to get the common rules
        */
       
       public function common(){
          //Required parameters for default case
          $this->rules[USERNAME]=REQUIRED;
          //get the event name
          $this->rules[EVENTNAME]=REQUIRED;
          //ge the even action
          $this->rules[EVENTACTION]=REQUIRED;
          //get the event key
          $this->rules[KEY]=REQUIRED;
          //to return the rules
          return $this->rules;
       }
      
       /*
        * This function is used to get the response for the notification reached to server 
        * 
        * @param  mixed   $result
        * 
        * return   varchar
        */
       
       public function getResponse($result){
             $result=json_decode($result);
             if(isset($result->success)&&(($result->success)>0)){
                $status=REACHED;
             }
             else{
                $status=NOT_REACHED;
             }
          return $status;
       }
}
 
