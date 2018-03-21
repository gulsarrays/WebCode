<?php
/**
 * CommonRepository
 *
 * In this CommonRepository having the methods to create & edit the notification, category and audio etc
 * 
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Repository;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Location;
use Request;
use Illuminate\Support\Str;

class CommonRepository {
   
   /**
    * Method to save the Location details
    *
    * @param array $input
    *           Input Parameters
    * @param integer $id
    *           Location Id
    *           
    * @return mixed
    *
    */
   public function createLocationDetail($input) {
      // Update after validation
      $user = User::where ( 'username', '=', $input [COM_USERNAME_KEYWORD] )->first ();
      if (isset ( $user->id )) {
         if (Location::where ( 'user_id', '=', $user->username )->count () <= 0) {
            $location = new Location ();
            $location->status = 1;
         } else {
            $location = Location::where ( 'user_id', $user->username )->first ();
         }
         
         $location->user_id = $user->username;
         $location->latitude = $input [COM_LATITUDE_KEYWORD];
         $location->longitude = $input [COM_LONGITUDE_KEYWORD];
         $location->radius = $input [COM_RADIUS_KEYWORD];
         $location->save ();
         return array (
                     COM_MESSAGE_KEYWORD => "Location has been added successfully",
                     'location' => $location 
         );
      } else {
         return array (
                     COM_MESSAGE_KEYWORD => "Unknown error occurred, please check the username." 
         );
      }
   }
   
   /**
    * Push the notification to android
    *
    * @param unknown_type $data           
    * @param unknown_type $reg_id           
    * @return mixed
    */
   public function android($data, $reg_id, $type) {
      $url = 'https://android.googleapis.com/gcm/send';
      if ($type != 'multiple') {
         $message = $data;
      } else {
         $message = $data;
         // Compose the message
         $message = array (
                     TITLE => $data [TITLE],
                     MESSAGE => $data [MESSAGE],
                     TYPE => $data [TYPE],
                     'broadcasttype' => $data ['message_type'],
                     MEDIA_URL => $data [MEDIA_URL],
                     'subtitle' => '',
                     'tickerText' => '',
                     'msgcnt' => 1,
                     'vibrate' => 1 
         );
      }
      // Add the headers
      $headers = array (
                  'Authorization: key=' . API_KEY,
                  'Content-Type: application/json' 
      );
      // Combine the Id and message
      $fields = array (
                  'registration_ids' => $reg_id,
                  'data' => $message 
      );
      // use curl for android device notificatio
      return $this->useCurl ( $url, $headers, json_encode ( $fields ) );
   }
   
   /**
    * Curl to run the notification
    *
    * @param unknown_type $url           
    * @param unknown_type $headers           
    * @param unknown_type $fields           
    */
   private function useCurl($url, $headers, $fields = null) {
      // Open connection
      $ch = curl_init ();
      if ($url) {
         // Set the url, number of POST vars, POST data
         curl_setopt ( $ch, CURLOPT_URL, $url );
         curl_setopt ( $ch, CURLOPT_POST, true );
         curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
         curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
         // Disabling SSL Certificate support temporarly
         curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
         if ($fields) {
            // post fields
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
         }
         // Execute post
         $result = curl_exec ( $ch );
         if ($result === FALSE) {
            // curl fail response
            die ( 'Curl failed: ' . curl_error ( $ch ) );
         }
         // Close connection
         curl_close ( $ch );
         // return result value
         return $result;
      }
   }
   
   /**
    * Sends Push notification for iOS users
    *
    * @param unknown_type $data           
    * @param unknown_type $devicetoken           
    */
   public function iOS($data, $devicetoken, $type) {
      $result = false;
      $production = true;
      foreach ( $devicetoken as $rId ) {
         $ctx = stream_context_create ();
         // Open a connection to the APNS server
         // production pem file
         $pem = public_path () . '/assets/pem/pushcert.pem';
         stream_context_set_option ( $ctx, 'ssl', 'local_cert', $pem );
         stream_context_set_option ( $ctx, 'ssl', 'passphrase', "" );
         if ($production) {
            // get client socket
            $fp = stream_socket_client ( 'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx );
         } else {
            // get client socket
            $fp = stream_socket_client ( 'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx );
         }
         if (! $fp) {
            // error response for push notification
            exit ( "Failed to connect: $err $errstr" . PHP_EOL );
         }
         // content for notification
         if ($type != 'multiple') {
            $body ['aps'] = array (
                        'alert' => $data [TITLE],
                        'eventName' => isset ( $data [EVENTNAME] ) ? $data [EVENTNAME] : '',
                        'eventAction' => isset ( $data [EVENTACTION] ) ? $data [EVENTACTION] : '',
                        'key' => isset ( $data ['key'] ) ? $data ['key'] : '',
                        'senderUsername' => isset ( $data [SENDERUSERNAME] ) ? $data [SENDERUSERNAME] : '',
                        TITLE => isset ( $data [TITLE] ) ? $data [TITLE] : '',
                        'memberId' => isset ( $data [MEMBERID] ) ? $data [MEMBERID] : '',
                        'sound' => 'notes_of_the_optimistic.caf' 
            );
         } else {
            
            // content for notification
            $body ['aps'] = array (
                        'alert' => $data [TITLE],
                        'message' => $data ['message'],
                        TYPE => isset ( $data [TYPE] ) ? $data [TYPE] : '',
                        'broadcasttype' => $data ['message_type'],
                        MEDIA_URL => $data [MEDIA_URL] 
            );
         }
         
         // Encode the payload as JSON
         $payload = json_encode ( $body );
         
         // Build the binary notification
         $msg = chr ( 0 ) . pack ( 'n', 32 ) . pack ( 'H*', $rId ) . pack ( 'n', strlen ( $payload ) ) . $payload;
         // write that content into message format
         $result = fwrite ( $fp, $msg, strlen ( $msg ) );
         
         fclose ( $fp );
      }
      if ($result) {
         // success response
         $result=true;
      }
      return $result;
  }
}
