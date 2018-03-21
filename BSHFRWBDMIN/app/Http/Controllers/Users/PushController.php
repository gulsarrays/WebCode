<?php
/**
 * PushController Controller
 *
 * This controller is used to send broadcast notification,SIP call and text notification
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */
namespace App\Http\Controllers\Users;
//trigger model file
use App\Models\ARTrigger;
//prereadview model file
use App\Models\PreReadView;
//agenta model file
use App\Models\Agendas;
//points model file
use App\Models\Points;
//quiz model file
use App\Models\Quiz;
//survey model fiel
use App\Models\Surveys;
//user model file
use App\User;
//prereadconsume model fiel
use App\Models\PreReadConsume;
//getting request url
use Illuminate\Http\Request;
//getting controller function
use App\Http\Controllers\Controller;
//getting url
use URL;
//getting broadcast model
use App\Models\Broadcast;
//getting user device
use App\Models\UserDevice;
use App\Repository\CommonRepository;

class PushController extends CommonController {
   //get defult constructor value
   public function __construct(Request $request,CommonRepository $common) {
      //To access the repository function
      $this->common=$common;
      //request values in constructor file
      parent::__construct ( $request->all () );
   }
   
   /**
    * Push the notification to ios and Android devices
    * 
    * @param unknown_type $id           
    * @param unknown_type $class           
    */
   public function push($id, $class) {
      //get the data value
      $data = [ ];
      $data ['id'] = $id;
      $data [CLASS_VAL] = $class;
      //get points value based on user id
      $point = Points::where ( FOREIGN_ID, $id )->where ( CLASS_VAL, $class )->get ( [ 
            'user_id' 
      ] );
      //switch process to sending notification
      switch ($class) {
         case 'PreReadConsume' :
            //case for media process
            $preReadConsume = PreReadConsume::find ( $id );
            $data [TITLE] = $preReadConsume->title;
            $data [TYPE] = $preReadConsume->type;
            $data [MESSAGE] = 'Media has been received';
            break;
         case 'Surveys' :
            //case for survey process
            $survey = Surveys::find ( $id );
            $data [TITLE] = $survey->name;
            $data [MESSAGE] = 'Surveys has been received';
            break;
         case 'Quiz' :
            //case for quiz process
            $quiz = Quiz::find ( $id );
            $data [TITLE] = $quiz->question;
            $data [MESSAGE] = 'Quiz has been received';
            break;
         case 'Agenda' :
            //case for agendas process
            $agenda = Agendas::find ( $id );
            $data [TITLE] = $agenda->title;
            $data [MESSAGE] = 'Agenda has been received';
            $point = [ ];
            break;
         case 'PreReadView' :
            //case for video process
            $preReadView = PreReadView::find ( $id );
            $data [TITLE] = $preReadView->title;
            $data [TYPE] = $preReadView->type;
            $data [MESSAGE] = 'Media has been received';
            $point = [ ];
            break;
         case 'ARTrigger' :
            $arTrigger = ARTrigger::find ( $id );
            $data [TITLE] = $arTrigger->name;
            $data [MESSAGE] = 'ARTrigger has been received';
            $point = [ ];
            break;  
         default:
            break;
      }
      //getting android user token
      $androidUser = User::where ( 'user_role_id', 2 )->where ( 'type', 'android' )->whereNotIn ( 'id', $point )->lists ( 'token' );
      //getting ios user token
      $iosUser = User::where ( 'user_role_id', 2 )->where ( 'type', 'iphone' )->whereNotIn ( 'id', $point )->lists ( 'token' );
      $i = 0;
      //looping the user token
      while ( $androidUser->count () > $i ) {
         $slice = $androidUser->slice ( $i, 500 );
         $this->common->android ( $data, $slice->toArray () );
         $i = $i + 500;
      }
      //looping the ios user token
      if (! empty ( $iosUser )) {
         $this->common->iOS ( $data, $iosUser );
      }
      //success response for send notification
      return redirect ()->back ()->withSuccess ( "Notification successfully sent" );
   }
   
   /**
    * this function is used to send push notification to all users
    */
   public function sendBroadcastToAll($id) {
      $type='multiple';
      //get the message based on id
      $message = Broadcast::find ( $id );
      
      if (! empty ( $message ) && count ( $message ) > 0) {
         //get title
         $data ['title'] = $message->title;
         //get message
         $data ['message'] = $message->message;
         //get message type
         $data ['message_type'] = $message->type;
         //get media url
         $data ['media_url'] = $message->media_url;
         //get type
         $data ['type'] = 'broadcast';
         //getting android device token for broadcast
         $androidUsers = UserDevice::where ( 'device', 'android' )->select ( DEVICE_TOKEN )->groupBy ( 'user' )->orderBy ( 'date', 'desc' )->lists ( DEVICE_TOKEN );
         //getting ios device token for broadcast
         $iosUsers = UserDevice::where ( 'device', 'ios' )->select ( DEVICE_TOKEN )->groupBy ( 'user' )->orderBy ( 'date', 'desc' )->lists ( DEVICE_TOKEN );
         $i = 0;
         while ( $androidUsers->count() > $i ) {
            $slice = $androidUsers->slice ( $i, 500 );
             //android push notification function call
            $this->common->android( $data, $slice->toArray(),$type);
            $i = $i+500;
          }
          $j = 0;
          while ( $iosUsers->count() > $j ) {
             $deviceToken = $iosUsers->slice ( $j, 500 );
             //ios push notification function
             $this->common->iOS ( $data, $deviceToken->toArray(),$type);
             $j = $j+500;
          }

          //success response
          return redirect ()->back ()->withSuccess( "Message sent successfully");
      }
      else{
         //failure response
        return redirect ()->back ()->withError( "Sorry! something went wrong while sending the broadcast message");
      } 
    }
    
}
 
