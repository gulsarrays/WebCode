<?php

namespace App\Http\Controllers\Users;
//use setting model file
use App\Models\Settings;
//use common controller file
use App\Http\Controllers\CommonController;
//use request option
use Illuminate\Http\Request;
//use request function
use App\Http\Requests;
//use controller file
use App\Http\Controllers\Controller;

class SettingsController extends CommonController {
   //constructor function
   public function __construct(Request $request) {
      parent::__construct ( $request->all () );
   }
   /**
    * get settings for web
    */
   public function index() {
      //settings details getting
      $settings = Settings::paginate(10);
      //show it in blade file
      return view ( 'settings.settings' )->withData ( $settings );
   }
   /**
    * To get the settings add and edit page
    */
   public function addSettings($id) {
      // get the client value using id
      $settings = Settings::find ($id);
      if($id!=0){
         $settings->title='Edit Settings';
      }
      // add resource file
      return view ( 'settings.add-settings' )->withData($settings);
   }
   
   /**
    * To get the view settings details
    */
   public function viewSettings($id) {
      // get the client value using id
      $settings = Settings::find ($id);
      // add resource file
      return view ( 'settings.view-settings' )->withData($settings);
   }
   /**
    * Store the about informatino
    * 
    * @param unknown_type $aboutId           
    * @return \Illuminate\Http\RedirectResponse
    */
   public function storeSettings($settingsId) {
      if($settingsId!=0){
         $settings = Settings::where ( 'id', $settingsId )->first ();
         $validateHost = ($this->requestData[XMPP_HOST] != $settings->xmpp_host) ? 'required|unique:settings' : COM_REQUIRED_KEYWORD;
         $msg='Settings updated successfully';
      }
      else{
         $validateHost = 'required|unique:settings';
         $msg='Settings added successfully';
      }
    //validtaion message for settings field
    $messsages = array(
            'xmpp_host.required'=>'Xmpp host name must be unique',
             OAUTH_URL_REQUIRED=>'OAUTH URL should be a valid One',
            'max_upload_size.numeric'=>'Max file upload field must be a number..',
            'max_upload_size.required'=>'Max file upload size field is required.',
             REST_API_URL_REQUIRED=>'REST API URL should be a valid One',
             SIP_URL_REQUIRED=>'SIP URL should be a valid One',
             GCM_SENDER_ID=>'GCM sender Id is required',
             AWS_ACCESS_KEY=>'AWS access key is required',
             AWS_SECRET_KEY=>'AWS secret key is required',
             AWS_BUCKET_NAME=>'AWS bucket name is required',
             BUSINESS_SPECIFIC_SETTINGS=>'Business specific settings is required'
   );
      //validation required fields
      $rules = [ 
            XMPP_HOST   =>$validateHost,
            OAUTH_URL_REQUIRED   =>REQUIRED_URL,
            REST_API_URL_REQUIRED => REQUIRED_URL,
            SIP_URL_REQUIRED => REQUIRED_URL,
            GCM_SENDER_ID=>REQUIRED_NUMERIC,
            AWS_ACCESS_KEY=>COM_REQUIRED_KEYWORD,
            AWS_SECRET_KEY=>COM_REQUIRED_KEYWORD,
            AWS_BUCKET_NAME=>COM_REQUIRED_KEYWORD,
            BUSINESS_SPECIFIC_SETTINGS=>COM_REQUIRED_KEYWORD,
            MAX_UPLOAD_SIZE => REQUIRED_NUMERIC
      ];
      //validation process
      $validator = validator ( $this->requestData, $rules, $messsages );
      if ($validator->passes ()) {
         //success in validation
         $settings = Settings::find ( $settingsId );
         if (! $settings) {
            //save as new settings
            $settings = new Settings ();
         }
         $settings->fill($this->requestData);
         $settings->save ();
         //success return url
         return redirect ()->route ('get:settings')->withSuccess ($msg);
    }else{
       //failure return url
       return redirect()->back()->with('error',$validator->messages()->first())->withInput();
    }
    }
    
   /**
     * To delete the settings details
     * 
     * @param  int   $settings Id
     * 
     */
    public function deleteSettings($settingsId) {
       // get substring count
       if (substr_count ( $settingsId, '~' ) > 0) {
          // multiple id get
          $settings = Settings::whereIn ( 'id', explode ( '~', $settingsId ) )->get ();
       } else {
          // single id get
          $settings = Settings::where ( 'id', $settingsId )->get ();
       }
       foreach ( $settings as $setting ) {
          // check empty condition
          if (! empty ( $setting )) {
             // delete settings
             $setting->delete ();
          } else {
             // failure response
             return redirect ()->route ('get:settings')->withError ( WHOOPS_WRONG );
          }
       }
       //success return url
        return redirect ()->back ()->withSuccess ( "Settings deleted successfully");
    }
    
}
