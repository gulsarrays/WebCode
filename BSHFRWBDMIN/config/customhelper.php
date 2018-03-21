<?php 

use GuzzleHttp\json_decode;

use App\Models\UserRole;
class CustomHelper {
	
    public static function convertJson($jsonData){
        $jsonString = urldecode($jsonData);
        $jsonObject = json_decode($jsonString);
        return $jsonObject;
    }
    public static function checkUser($user,$srcUser){
        if($user!=$srcUser)
            return "receiver";
        return "";
    }
	public static function profileImageCheck($user) {
		$imageURL = URL('/').'/assets/img/default.png';
		if(!empty($user->profileImage->image)) {
			if (@getimagesize($user->profileImage->image)) {
				$imageURL = $user->profileImage->image;
			}
		}
		return $imageURL;
	}
	
	public static function artriggerImageCheck($data) {

	    $imageURL = '';
	    if(!empty($data->artriggerImage->image)) {
	        if (@getimagesize($data->artriggerImage->image)) {
	            $imageURL = $data->artriggerImage->image;
	        }
	    }
	    return $imageURL;
	}
	
	public static function agendaImageCheck($data) {
		
		$imageURL = URL::asset('assets/img/default.png') ;
		if(!empty($data->agendaImage->image)) {
			if (@getimagesize($data->agendaImage->image)) {
				$imageURL = $data->agendaImage->image;
			}
		}
		return $imageURL;
	}
	
	public static function visualImageCheck($data) {

		$imageURL = URL::asset('assets/img/default.png') ;
		if(!empty($data->visualImage->image)) {
			if (@getimagesize($data->visualImage->image)) {
				$imageURL = $data->visualImage->image;
			}
		}
		return $imageURL;
	}
	
	
	public static function attendeesImageCheck($data) {
		$imageURL = '';
		if(!empty($data->attendeeImage->image)) {
			if (@getimagesize($data->attendeeImage->image)) {
				$imageURL = $data->attendeeImage->image;
			}
		}
		return $imageURL;
	}
	public static function imageCheck($data) {
		$imageURL = 'fa fa-file' ;
		if(!empty($data->image->image)) {
			$file = $data->image;
			if($file->mime=='image/jpeg'){
				$imageURL =  'fa fa-picture-o';
			}
		}
		return $imageURL;
	}
	
	public static function imageAbout($data) {
		$imageURL = URL::asset('assets/img/default.png') ;
		if(!empty($data->image)) {
			if (@getimagesize($data->image)) {
				$imageURL = $data->image;
			}
		}
		return $imageURL;
	}
	
	public static function checkRoute($url,$data) {
	  $userType=auth()->user()->user_type;
	  $userRole=UserRole::find($userType);
	  $permissions=explode(',',$userRole->permission);
     if(in_array($data, $permissions)){
       return true;
     }
     else{
       return false;
     }
        
	}
	public static $modules=[
							// 'user'=>'View Users',
	      //                   'groups'=>'View Groups',
	      //                   'broadcast'=>'Broadcast',
	      //                   'settings'=>'Settings',
	      //                   'chat-history'=>'Chat'

	                        'create-channel' =>'Create Channel',
	                        'upload-content' =>'Upload Content',
	                        'sub-user' =>'Subscribed users',
	                        'chat' => 'Chat',
	                        'create-ad' => 'Create Ad'
	];
	public static $list_permissions=[
							// 'user',
	      //                   'groups',
	      //                   'broadcast',
	      //                   'settings',
	      //                   'chat-history'
								'create-channel',
								'upload-content',
								'sub-user',
								'chat',
								'create-ad'

	];
}
?>