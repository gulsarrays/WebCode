<?php

namespace App\Http\Controllers\Users;
//getting storage default url
use Illuminate\Support\Facades\Storage;
//get attachment model file
use App\Models\Attachment;
//get broadcast model file
use App\Models\Broadcast;
//get broadcast members file
use App\Models\BroadcastMembers;
//get users model file
use App\Models\Users;
// Vcard model file
use App\Models\Vcard;
//get request file
use Illuminate\Http\Request;
//get common controller value
use App\Http\Controllers\CommonController;
//get request url
use App\Http\Requests;
//get controller value
use App\Http\Controllers\Controller;
//get date time
use \DateTime;
//get timezone value
use \DateTimeZone;
// use db file
use Illuminate\Support\Facades\DB;

use Fabiang\Xmpp\Options as XmppOptions;
use Fabiang\Xmpp\Client as XmppClient;
use App\Lib\Xmpp\BroadcastMessage;
use App\Models\Broadcastusers;

class BroadcastController extends CommonController {
   //constructor function for request value
	protected $url;
	protected $_broadcastUsers;
	public function __construct(
			Request $request,\Illuminate\Routing\UrlGenerator $url,
			Broadcastusers $broadcastUsers
			) {
		$this->url = $url;
		$this->_broadcastUsers = $broadcastUsers;
      parent::__construct ( $request->all () );
      // broadcast rules
      $this->broacastRules = Broadcast::$rules;
      // image checking rules
      $this->imageCheck = [ 
            'jpg',
            'png' 
      ];
      // audio checking rules
      $this->audioCheck = [ 
            'mp3',
            'aac' 
      ];
      // video checking rules
      $this->videoCheck = [ 
            'mp4',
            'avi' 
      ];
   }
   /**
    * Display the list of clients
    */
   public function index($search = null) {
      // get the broadcast value
      $broadcasts = Broadcast::orderBy ( 'id', 'DESC' );
      // check empty
      if (! empty ( $search )) {
         // search function
         $broadcasts->search ( $search );
      }
      // with pagination
      $broadcasts = $broadcasts->paginate ( 5 );
      // view page for broadcast
      return view ( 'broadcast.broadcasts', [ 
            'broadcasts' => $broadcasts,
            SEARCH => (! empty ( $search )) ? $search : '' 
      ] );
   }
   
   /**
    * Display add Broadcast form
    */
   public function addBroadcast($id) {
      // get the client value using id
      $client = Broadcast::find ( $id );
      $users = Vcard::select(["fly_users.username","fly_users.name","fly_users.image","fly_users.mobile_number"])->join("admin_broadcast_users", 'admin_broadcast_users.users', '=', 'fly_users.username')->where('admin_broadcast_users.broadcast_id', $id )->get();
      
      return view ( 'broadcast.addbroadcast', ['data'=>$client,'contact'=>$users,'url' =>  $this->url->to('/')]  );
   }
   
   /**
    * Store the Broadcast Data
    *
    * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
    */
   public function storeBroadcast($id) {
      // valdiation checking
      $validator = \Validator::make ( $this->requestData, $this->broacastRules );
      if ($validator->passes ()) {
         // success in validation
         if ($id == 0) {
            // add new broadcast
            $broadcasts = new Broadcast ();
            $broadcastUsers = new Broadcastusers();
         } else {
			 
            // edit broadcast
            $broadcasts = Broadcast::find ( $id );
            $broadcastUsers = Broadcastusers::find($broadcasts->id);
         }
         
         $broadcastMobiles = $this->requestData['selected_list_users'];
         $broadcastGroups  = $this->requestData['selected_list_group'];
         
           if(!empty($broadcastMobiles)){
	         $broadcastMobilesExploded = explode(",", $broadcastMobiles);
	         foreach($broadcastMobilesExploded as $broadcastMobilesExplodedValue){
	         	$phoneNumber = explode("_", $broadcastMobilesExplodedValue);
	         	$numbers[] = $phoneNumber[2];
	         }
         } 
         
         if(!empty($broadcastGroups)){
         	$broadcastGroupsExploded = explode(",", $broadcastGroups);         	
         	foreach($broadcastGroupsExploded as $broadcastGroupsExplodedValue){         		
         		$groups[] = $broadcastGroupsExplodedValue;
         	}
         } 
         
         // fill value
         $broadcasts->title = $this->requestData['title'];
         $broadcasts->message = strip_tags($this->requestData['message']);
         $broadcasts->is_active = $this->requestData['is_active']; 
         $thumbimage = '';
         $filesize = '';
         
        
         // get currentdate value
         date_default_timezone_set("GMT");
         $date=date_create(date('Y-m-d H:i:s'));
         
         $scanTime = round(microtime(true) * 1000);
        
         // store broadcast time
         $broadcasts->broadcast_time = $scanTime;
         // get the image value
         if (isset ( $this->requestData [IMAGE] )) {
            $image = $this->requestData [IMAGE];
            // get extension
            $extension = $image->getClientOriginalExtension ();
            // check whether extension present
            if (in_array ( $extension, $this->imageCheck )) {
               // image file
               $broadcasts->type = IMAGE;
               $type = pathinfo($image, PATHINFO_EXTENSION);
      			   $data = file_get_contents($image);
      			   $filesize = filesize($image);
			  
            } else if (in_array ( $extension, $this->videoCheck )) {
               // video file
               $broadcasts->type = 'video';
            } else {
               // failure message with redirection
               return redirect ()->back ()->withErrors ( "File format does not support" )->withInput ();
            }
            
             // image filename
            $imageFileName = time () . '.' . $extension;
            // s3 bucket value
            $s3 = Storage::disk ( 's3' );
            // put image files into s3 bucket
            $s3->put ( $imageFileName, file_get_contents ( $image ), 'public' );
            // get the image file url
            $url = $s3->url ( $imageFileName );
            // save image name
            $broadcasts->media_name = $imageFileName;
            // save image url
            $broadcasts->media_url = $url;
            
            if($broadcasts->type ==  IMAGE){
            $info = getimagesize($url);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($url);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($url);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($url);
			
        $destination =  storage_path()."/tmp_images/".$imageFileName;
        imagejpeg($image, $destination, 1);
		$percent = 0.5;
		
		list($width, $height) = getimagesize($destination);
		$new_width = 20;
		$new_height = 20;

		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// Output
		$thumbimage = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDABALDA4MChAODQ4SERATGCgaGBYWGDEjJR0oOjM9PDkz
ODdASFxOQERXRTc4UG1RV19iZ2hnPk1xeXBkeFxlZ2P/2wBDARESEhgVGC8aGi9jQjhCY2NjY2Nj
Y2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2P/wAARCABRAZoDASIA
AhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQA
AAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3
ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWm
p6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEA
AwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSEx
BhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElK
U1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3
uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDz+iil
VWb7qk0AJRSsjL1UikoAKKKKACinKjN91SfwpCpXqCKAEooooAKKACegowc4xQAUU4xuBkqcfSm0
AFFPETkZCHH0pmMdaACiiigAopSCOopVjdvuqT+FADaKUgg4IxSUAFFFFABRTljdvuqT+FIQQcEE
GgBKKXBHY0lABRRTgjt0Un8KAG0UEEdRRQAUUU5UZvuqT+FADaKUgjqMUlAFi0tHunwowvc1p3ti
q2QEY5Ss1L2ZIwkeFHtU0GpSp8swLIeuaykpt3R6FGeHjBwlu+pQqSGF55AkYyxpJihlYp90niru
iZ/tFPoa2irtI4ba2K9xZT2yhpVwDxVeuj8Rf8eqAf3q5yrqRUZWQSVnYKKKKzJCil2t/dP5UlAB
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';
	}
      
         } else {
            // save text
            $broadcasts->type = 'text';
         }
         
         $broadcasts->save ();
         $boradCastId = $broadcasts->id;
         $roasterusers = array();
        //$dataInsert[] = ['users'=>$broadcastGroups,'chat_type'=>1,'broadcast_id'=>$boradCastId];
        
         if(!empty($groups)){
	         foreach($groups as $groupsValue){         	
	         	$dataInsert[] = ['users'=>$groupsValue,'chat_type'=>1,'broadcast_id'=>$boradCastId];         	
	         }
         }
        
         if(!empty($numbers)){
	         foreach( $numbers as $number){
	         	$dataInsert[] = ['users'=>$number,'chat_type'=>0,'broadcast_id'=>$boradCastId];
	         }         
         }
         if(!empty($dataInsert)){
         	$broadcastUsers->insert($dataInsert);
         }
          
         $messageId = substr ( str_shuffle ( "0123456789abcdefghijklmnopqrstuvwxyz" ), 0, 42);
         $BroadcastUser = BroadcastMembers::where( 'broadcast_id', $boradCastId )->get ();
         for($i = 0; $i < count ( $BroadcastUser ); $i ++) {
		 
			if($BroadcastUser [$i] ['chat_type']==0)
			{
			$roasterusers[] = $BroadcastUser [$i] ['users']."@".getenv ( 'XMPP_IP' );
	       }
	       else
		{
			$host =  $BroadcastUser [$i] ['users'].'@mix';
			
			$groupMembers = DB::select("select state.jid as jid from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   

	//To get roasterusers.
	for($z=0;$z<count($groupMembers);$z++) {
		$roasterusers[] = $groupMembers[$z]->jid;
	}
	}
}
       
		// get the base url
        $baseUrl = parse_url(url('/'), PHP_URL_HOST);
        $records = [];
        $this->prepareXMPPConnection();
       
		for($i = 0; $i < count ( $roasterusers ); $i ++) {
		 $myObj = new \stdClass();
		 $messageBody = new \stdClass();
         $mediacontent = new \stdClass();
			
			$to = $roasterusers [$i];
		    
            if( $broadcasts->type == "text")
            {
            $messageBody->message = $broadcasts->message;
            $messageBody->message_type = $broadcasts->type;
            $message_content = json_encode($messageBody); 
		    } 
		    else
		    {
			$mediacontent->caption = $broadcasts->message;
			$mediacontent->file_size = "$filesize";
			$mediacontent->file_url = $url;
			$mediacontent->thumb_image = $thumbimage;
			$mediacontent->local_path = '';
			$mediacontent->is_uploading = "2";
			$mediacontent->is_downloaded = 0;
			$messageBody->media = $mediacontent;
            $messageBody->message_type = $broadcasts->type;
            $message_content = json_encode($messageBody); 
            if(file_exists($destination)){
            unlink($destination);
			}
			}
            
            
		

        
		
        $key256    = $messageId;
        $iv        = "ddc0f15cc2c90fca";
        $hash = hash('sha256', $key256); 
        $key = mb_substr($hash, 0, 32);
        
        $plaintext_utf8 = urlencode($message_content);
        
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc'); 
        $pad = $size - (strlen($plaintext_utf8) % $size); 
        $plaintext_utf8 = $plaintext_utf8 . str_repeat(chr($pad), $pad); 
        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', $iv);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext_utf8, MCRYPT_MODE_CBC, $iv);
        $enciphertext = base64_encode($ciphertext);
         
        //$deciphertext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext, MCRYPT_MODE_CBC, $iv);
        
		 $sendMessage = (new BroadcastMessage)->setTo($to)
		                  ->setMessageType($broadcasts->type)
		                  ->setType($broadcasts->type)
		                  ->setId($messageId)
		                  ->setFrom(getenv ( 'ADMIN_USER' )."@".getenv ( 'XMPP_IP' ))
                          ->setBody($enciphertext);
                          
                          $this->xmppClient->send($sendMessage);
                          
                      
                           // success redirection
        
}
 
        $this->xmppClient->disconnect();
        
          return redirect ()->route ( BROADCAST_URL )->withSuccess ( "Broadcast successfully added." );
        
      } else {
         // failure redirection with error message
         $errorMessage = $validator->messages ()->toArray ();
         return redirect ()->back ()->withError ( $errorMessage )->withInput ();
      }
   }
   
        
    /**
     * Prepare the xmpp connection
     *
     * @uses package fabiang/xmpp
     * @see https://github.com/fabiang/xmpp
     * @return \App\Repository\MessageRepository
     */
    private function prepareXMPPConnection() {
		$user = Users::where(USERNAME,getenv ( 'ADMIN_USER' ))
                                 ->select([USERNAME,PASSWORD])
                                 ->first();
                                 
        $this->xmppClient = new XmppClient(
            (new XmppOptions(config(XMPP_ADDRESS)))->setUsername($user->username)
                             ->setPassword($user->password)
        );    


        return $this;
    }  
   /**
    *
    * @param unknown_type $broadcastsId           
    */
   public function deleteBroadcast($broadcastsId) {
      // get substring count
      if (substr_count ( $broadcastsId, '~' ) > 0) {
         // multiple id get
         Broadcast::whereIn ( 'id', explode ( '~', $broadcastsId ) )->delete ();
         Broadcastusers::whereIn ( 'broadcast_id', explode ( '~', $broadcastsId ) )->delete ();
      } else {
         // single id get
         Broadcast::where ( 'id', $broadcastsId )->delete ();
         Broadcastusers::where ( 'broadcast_id', $broadcastsId )->delete ();
      }
      
      
      // success response
      return redirect ()->route ( BROADCAST_URL )->withSuccess ( "Selected Broadcast deleted successfully" );
   }
 
  /**
    *
    * @param unknown_type $broadcastsId           
    */
   public function resendBroadcast($broadcastsId) {
   
			 
            // edit broadcast
            $broadcasts = Broadcast::find ( $broadcastsId );
            $BroadcastUser = Broadcastusers::where( 'broadcast_id', $broadcastsId)->get ();
        
         // get currentdate value
         date_default_timezone_set("GMT");
         $date=date_create(date('Y-m-d H:i:s'));
         
         $scanTime = round(microtime(true) * 1000);
        
         // store broadcast time
         $broadcasts->broadcast_time = $scanTime;
         // get the image value
         $ch = curl_init($broadcasts->media_url);

 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 curl_setopt($ch, CURLOPT_HEADER, TRUE);
 curl_setopt($ch, CURLOPT_NOBODY, TRUE);

 $data = curl_exec($ch);
 $filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

 curl_close($ch);
          
       

		// Output
		$thumbimage = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDABALDA4MChAODQ4SERATGCgaGBYWGDEjJR0oOjM9PDkz
ODdASFxOQERXRTc4UG1RV19iZ2hnPk1xeXBkeFxlZ2P/2wBDARESEhgVGC8aGi9jQjhCY2NjY2Nj
Y2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2NjY2P/wAARCABRAZoDASIA
AhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQA
AAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3
ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWm
p6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEA
AwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSEx
BhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElK
U1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3
uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDz+iil
VWb7qk0AJRSsjL1UikoAKKKKACinKjN91SfwpCpXqCKAEooooAKKACegowc4xQAUU4xuBkqcfSm0
AFFPETkZCHH0pmMdaACiiigAopSCOopVjdvuqT+FADaKUgg4IxSUAFFFFABRTljdvuqT+FIQQcEE
GgBKKXBHY0lABRRTgjt0Un8KAG0UEEdRRQAUUU5UZvuqT+FADaKUgjqMUlAFi0tHunwowvc1p3ti
q2QEY5Ss1L2ZIwkeFHtU0GpSp8swLIeuaykpt3R6FGeHjBwlu+pQqSGF55AkYyxpJihlYp90niru
iZ/tFPoa2irtI4ba2K9xZT2yhpVwDxVeuj8Rf8eqAf3q5yrqRUZWQSVnYKKKKzJCil2t/dP5UlAB
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';
	
        
          
         $messageId = substr ( str_shuffle ( "0123456789abcdefghijklmnopqrstuvwxyz" ), 0, 42);
         
         for($i = 0; $i < count ( $BroadcastUser ); $i ++) {
		 
			if($BroadcastUser [$i] ['chat_type']==0)
			{
			$roasterusers[] = $BroadcastUser [$i] ['users']."@".getenv ( 'XMPP_IP' );
	       }
	       else
		{
			$host =  $BroadcastUser [$i] ['users'].'@mix';
			
			$groupMembers = DB::select("select state.jid as jid from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   

	//To get roasterusers.
	for($z=0;$z<count($groupMembers);$z++) {
		$roasterusers[] = $groupMembers[$z]->jid;
	}
	}
}
       
		// get the base url
        $baseUrl = parse_url(url('/'), PHP_URL_HOST);
        $records = [];
        $this->prepareXMPPConnection();
       
		for($i = 0; $i < count ( $roasterusers ); $i ++) {
		 $myObj = new \stdClass();
		 $messageBody = new \stdClass();
         $mediacontent = new \stdClass();
			
			$to = $roasterusers [$i];
		    
            if( $broadcasts->type == "text")
            {
            $messageBody->message = $broadcasts->message;
            $messageBody->message_type = $broadcasts->type;
            $message_content = json_encode($messageBody); 
		    } 
		    else
		    {
			$mediacontent->caption = $broadcasts->message;
			$mediacontent->file_size = "$filesize";
			$mediacontent->file_url = $broadcasts->media_url;
			$mediacontent->thumb_image = $thumbimage;
			$mediacontent->local_path = '';
			$mediacontent->is_uploading = "2";
			$mediacontent->is_downloaded = 0;
			$messageBody->media = $mediacontent;
            $messageBody->message_type = $broadcasts->type;
            $message_content = json_encode($messageBody); 
           
			}
            
            
		

        
		
        $key256    = $messageId;
        $iv        = "ddc0f15cc2c90fca";
        $hash = hash('sha256', $key256); 
        $key = mb_substr($hash, 0, 32);
        
        $plaintext_utf8 = urlencode($message_content);
        
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc'); 
        $pad = $size - (strlen($plaintext_utf8) % $size); 
        $plaintext_utf8 = $plaintext_utf8 . str_repeat(chr($pad), $pad); 
        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', $iv);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext_utf8, MCRYPT_MODE_CBC, $iv);
        $enciphertext = base64_encode($ciphertext);
         
        //$deciphertext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext, MCRYPT_MODE_CBC, $iv);
        
		 $sendMessage = (new BroadcastMessage)->setTo($to)
		                  ->setMessageType($broadcasts->type)
		                  ->setType($broadcasts->type)
		                  ->setId($messageId)
		                  ->setFrom(getenv ( 'ADMIN_USER' )."@".getenv ( 'XMPP_IP' ))
                          ->setBody($enciphertext);
                          
                          $this->xmppClient->send($sendMessage);
                          
                      
                           // success redirection
        
}
 
        $this->xmppClient->disconnect();
        // success response
      return redirect ()->route ( BROADCAST_URL )->withSuccess ( "Broadcast Resend successfully" );
	}
}
