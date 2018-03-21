<?php
/**
 * contactSyncController
 *
 * In this contactSyncController having the methods to save the Sync data which is send from mobile response
 * 
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Http\Controllers;
//file to get the controller
use App\Http\Controllers\Controller;
//url to get the model
use App\User;
//url to get the model user contact
use App\UserContact;
//validator url
use Illuminate\Support\Facades\Validator;
//function for request
use Request;
//function for response
use Response;

class ContactSyncController extends Controller {
   
   /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request           
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request) {
      // Get the Input parameters
      $input = \Input::all ();
      
      // Select the user id for the given input users
      $fromUserDetails = User::where ( 'id', $input [COM_USER_ID_KEYWORD] )->select ( COM_USERNAME_KEYWORD )->first ();
      // Split the mobile numbers using the comma separators
      $mobileNumbers = explode ( ',', $input [COM_MOBILE_NUMBER_KEYWORD] );
      // If it has only one number given the result for that number
      if (count ( $mobileNumbers ) > 1) {
         $syncContactUser = User::whereIn ( COM_USERNAME_KEYWORD, $mobileNumbers )->select ( 'id', COM_USERNAME_KEYWORD, 'name', 'image', COM_COUNTRY_CODE_KEYWORD, COM_MOBILE_NUMBER_KEYWORD )->get ();
      } else {
         $syncContactUser = User::where ( COM_USERNAME_KEYWORD, $input [COM_MOBILE_NUMBER_KEYWORD] )->select ( 'id', COM_USERNAME_KEYWORD, 'name', 'image', COM_COUNTRY_CODE_KEYWORD, COM_MOBILE_NUMBER_KEYWORD )->get ()->toArray ();
      }
      // Looping the sync contact users
      for($i = 0; $i < count ( $syncContactUser ); $i ++) {
         // Check the username and then update the profile name
         $syncContactCheck = UserContact::where ( COM_CONTACT_USER_ID_KEYWORD, $syncContactUser [$i] ['id'] )->Where ( COM_USER_ID_KEYWORD, $input [COM_USER_ID_KEYWORD] )->first ();
         
         if (($fromUserDetails->username != $syncContactUser [$i] [COM_USERNAME_KEYWORD]) && (count ( $syncContactCheck ) <= 0)) {
            // Store the user contact information with user id and contact ID
            $contactUser = new UserContact ();
            $contactUser->user = $fromUserDetails->username;
            $contactUser->contact = $syncContactUser [$i] [COM_USERNAME_KEYWORD];
            $contactUser->user_id = $input [COM_USER_ID_KEYWORD];
            $contactUser->contact_user_id = $syncContactUser [$i] ['id'];
            $contactUser->is_accepted = 1;
            $contactUser->save ();
            // Reverse the preivous operation and store the user contact information with contact ID and user ID
            $contactUserreverse = new UserContact ();
            $contactUserreverse->contact = $fromUserDetails->username;
            $contactUserreverse->user = $syncContactUser [$i] [COM_USERNAME_KEYWORD];
            $contactUserreverse->contact_user_id = $input [COM_USER_ID_KEYWORD];
            $contactUserreverse->user_id = $syncContactUser [$i] ['id'];
            $contactUserreverse->is_accepted = 1;
            $contactUserreverse->save ();
         }
      }
       //success json response
       return Response::json (  array (
                COM_ERROR_KEY => false,
                COM_RESPONSE_KEY => array(COM_MESSAGE_KEYWORD =>'Sync Succesfully')
) );
}
}
 
