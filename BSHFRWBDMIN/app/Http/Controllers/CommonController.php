<?php
/**
 * CommonController Controller
 *
 * This controller is used for common validation, user authentication ..
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Attachment;

class CommonController extends \Illuminate\Routing\Controller {
   //constructor function
   public function __construct($request) {
      //object for request data
      $this->requestData = $request;
      //checking the auth user
      if (Auth::check ()) {
         //get the auth user details
         $this->authUser = Auth::user ();
         //view blade for auth user
         View::share ( 'authUser', $this->authUser );
      }
   }
   
   /**
    * Method is used to format the error messages
    *
    * Error as array and returns the first error as string
    *
    * @param
    *           $errors
    *           
    * @return string
    */
   public function _formatValidationMessages($errors) {
      // validation message format
      $formattedErrors = '';
      // getting the error values
      foreach ( $errors as $error ) {
         $formattedErrors [] = $error [0];
         break;
      }
      // error implode function
      return implode ( " ", array_values ( $formattedErrors ) );
   }
   /**
    * image upload process
    *
    * @param unknown $image           
    * @param unknown $class           
    * @param unknown $foreign_id           
    * @param string $desc           
    */
   public function __imageUpload($image, $class, $foreign_id, $desc = null) {
      // checking image exist or not
      if (isset ( $image [IMAGE] ) && ! empty ( $image [IMAGE] )) {
         // delete the attachment from attachment table
         $this->__attachmentDelete ( Attachment::where ( CLASS_VAL, $class )->where ( FOREIGN_ID, $foreign_id )->first (), $class );
         // image upload functionality for new images
         $this->imageUpload ( $image [IMAGE], $class, $foreign_id, $desc );
      }
   }
   /**
    * Image Loading
    *
    * @param unknown_type $image           
    * @param unknown_type $class           
    * @param unknown_type $foreign_id           
    */
   public function imageUpload($image, $class, $foreign_id, $desc = null) {
      // destination path
      $destinationPath = public_path () . ASSET_UPLOAD . strtolower ( $class ) . '/' . $foreign_id;
      // making directory
      if (! is_dir ( $destinationPath )) {
         mkdir ( $destinationPath, 0777, true );
      }
      // get the filename
      $fileName = time () . "_" . strtolower ( str_replace ( " ", "_", urldecode ( $image->getClientOriginalName () ) ) );
      // move image file
      if ($image->move ( $destinationPath, $fileName )) {
         // find new attachment
         $attachment = new Attachment ();
         $attachment->class = $class;
         $attachment->foreign_id = $foreign_id;
         $attachment->size = $image->getClientSize ();
         $attachment->mime = $image->getClientMimeType ();
         $attachment->description = isset ( $desc ) ? $desc : "";
         $attachment->image = url ( ASSET_UPLOAD . strtolower ( $class ) . '/' ) . '/' . $foreign_id . '/' . $fileName;
         $attachment->image_name = $fileName;
         // save attachment details
         $attachment->save ();
      }
   }
   
   /**
    * Method used to delete image in public/assets/uploads/user
    *
    * @return \Illuminate\Http\Response
    */
   public function __attachmentDelete($attachment, $class) {
      // delete attachment
      if (count ( $attachment ) > 0) {
         // unlink attachment
         @unlink ( public_path () . ASSET_UPLOAD . strtolower ( $class ) . "/" . $attachment->image_name );
         // delete attachment
         $attachment->delete ();
      }
      // return value
      return true;
   }
}
