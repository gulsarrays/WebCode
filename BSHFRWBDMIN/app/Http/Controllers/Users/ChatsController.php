<?php
namespace App\Http\Controllers\Users;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Vcard;
use App\Models\UserVcard;
use App\Models\ChannelUserDetails;
use App\Models\UserChannels;
use Redis;
use JWTAuth;

class ChatsController extends Controller {

	public function getchats()
	{
		$channels = $this->getApiResponse(GET_MYCHANNELS);		
		return view('sections.chats',['allchannels' => $channels]);
	}

	public function getChannelUsers($channelId)
	{		
		$users = $this->getApiResponse(GET_CHANNEL_USERS.$channelId);

		if(!empty($users)){
			$usersHtml = '';
			foreach ($users as $user) {
				if(isset($user['user_name'])){
					$user_name = $user['user_name'];
				}else{
					$user_name = $user['userId'];
				}
				$usersHtml .= '<p id="'.$user['userId'].'" onClick="openpopup(this);"><i class="fa fa-user" aria-hidden="true"></i> '.$user_name.'</p>';
			}
		
			return $usersHtml;

		}else{
			return 0;
		}

	}

	public function getchannels(){
		$channels = $this->getApiResponse(GET_MYCHANNELS);
		return view('sections.channels',['allchannels' => $channels]);
	}

	public function getcreate()
	{
		$categories = $this->getApiResponse(GET_ALL_CATEGORIES);
		$ageGroups = $this->getApiResponse(GET_ALL_AGEGROUP);
		return view('sections.createchannel',[ 'categories' => $categories ,'ageGroups' => $ageGroups ]);
	}

	public function postcreate(Request $request)
	{
		try {
			$rules = [ 
				'files' => 'required',
				'channelTitle' => 'required',
				'channelDescription' => 'required' ,
				'ageGroupId' => 'required',
				'categoryId' => 'required'
				];
			$validator = validator ( $request->all (), $rules );
			
			if ($validator->passes ()) {
				if($this->createchannel($request->all ())){
					return redirect ()->to ( 'channels' )->with ( 'success', 'channel details added successfully' );
				}
			} else {
				return redirect ()->back ()->with ( ERROR, $validator->messages ()->first () )->withInput ();
			}

		} catch ( \Exception $e ) {
			
			return redirect ()->back ()->with ( ERROR, 'Please check your account Deatils to create more channels' );
		}
		
	}

	function createchannel($input)
	{
		$channeldata = [
			'channelTitle' => $input['channelTitle'],
			'channelDescription' => $input['channelDescription'],
			'ageGroupId' => $input['ageGroupId'],
			'categoryId' => $input['categoryId']
			];
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('POST', API_BASE_URL.CREATE_CHANNEL,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'query' => [
            	'files' => json_encode($input['files']), 
            	'channels' => json_encode($channeldata)
            ]            
            ])->getBody();
		$response = json_decode($response, true);

		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else{
			return false;
		}
	}

	function getApiResponse($url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->get( API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
		$response = json_decode($response, true);

		$result = [];
		foreach ($response as $items) {
			$result[] = $items['item'];
		}
		
		return $result[0];
	}

	public function getChannelByUser(Request $request)
	{		

		$jwt_token = $this->getToken($request);
		if(!$jwt_token){
			return '1';
		}
		$client = new Client();
		$response = $client->get( API_BASE_URL.GET_MYCHANNELS,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
		$response = json_decode($response, true);

		$result = [];
		foreach ($response as $items) {
			$result[] = $items['item'];
		}

		if(!empty($result[0])){
			$channelHtml = '';
			foreach ($result[0] as $channel) {
				$ch_name = $channel['channelTitle'];
				$ch_id = $channel['channelId'];
				$channelHtml .= '<option value="'.$ch_id.'">'.$ch_name.'</option>';				
			}		
			return $channelHtml;

		}else{
			return '2';
		}

		
		return $result[0];
	}

	function getToken($request)
	{
		
		$user = Users::where ( USERNAME, $request->mobile_number )->first ();
		if ($user && $token = JWTAuth::fromUser($user)) {
          
          $vcard = UserVcard::where(COM_USERNAME_KEYWORD, '=', $user->username)->pluck ('vcard')->toArray();
          if(!empty($vcard)){
              $userXmlObj = @simplexml_load_string($vcard[0]);
              $userArr = json_decode(json_encode((array)$userXmlObj), TRUE);
              $vcardjson = json_encode($userArr);
              $vcardarray = [
                  'user_id' => $user->username,
                  'user_name' => (!empty($userArr['name']))?$userArr['name']:' ',
                  'vcard' => $vcardjson,
                  'token' => $token,
                  'mobileNumber' => (!empty($userArr['mobileNumber']))?$userArr['mobileNumber']:$user->username,
                  'nickname' => (!empty($userArr['nickName']))?$userArr['nickName']:null,
                  'status' => (!empty($userArr['status']))?$userArr['status']:null,
                  'email' => (!empty($userArr['email']))?$userArr['email']:null,
                  'gender' => (!empty($userArr['gender']))?$userArr['gender']:null,
                  'dob' => (!empty($userArr['dob']))?$userArr['dob']:null,
                  'created_date' => date("Y-m-d H:i:s")
              ];
          }else{
              $vcardjson = json_encode([
                      'nickName' => null,
                      'status' => null,
                      'email' => null,
                      'mobileNumber' => $user->username,
                      'gender' => null,
                      'dob' => null
                  ]);
              $vcardarray = [
                  'user_id' => $user->username,
                  'user_name' => ' ',
                  'vcard' => $vcardjson,
                  'token' => $token,
                  'mobileNumber' => $user->username,
                  'nickname' => null,
                  'status' => null,
                  'email' => null,
                  'gender' => null,
                  'dob' => null,
                  'created_date' => date("Y-m-d H:i:s")
              ];
          }
          
          $tokenRow = ChannelUserDetails::where('user_id',$user->username)->first();
	          if($tokenRow){
	            $token = $tokenRow->token;
	          
	          }else{
	            ChannelUserDetails::insert($vcardarray);
	            Redis::set($token, json_encode($vcardarray));
	            Redis::expire($token, 60480);
	          }
	          return $token;
		}
		return false;
	}

}
?>