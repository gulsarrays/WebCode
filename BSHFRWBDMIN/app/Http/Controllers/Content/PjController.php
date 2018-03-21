<?php

namespace App\Http\Controllers\Content;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Users;
use App\Models\ChannelUserDetails;
use Redis;
use JWTAuth;
use Carbon\Carbon;
use App\Models\Role;
use GuzzleHttp\Client;
use App\Repository\UserRepository as UserRepository;

use App\Models\Permission;
use App\Models\PjStringerMapping;

class PjController extends Controller {

    public function __construct(UserRepository $user) {
        // constructor function for user
        $this->user = $user;
    }

    public function index(Request $request) {

        $search_text_allcontent = '';
        $search_text_liststringer = '';
        $search_text_myupload = '';
        $search_text_usermy = '';
        $search_text = '';
        $search_text_arr = array(
            'search_in_allcontent' => '',
            'search_in_liststringer' => '',
            'search_in_myupload' => '',
            'search_in_usermy' => ''
        );
        
        if (!empty($request['search_in_allcontent'])) {
            $search_text_allcontent = $request['search_in_allcontent'];
            $search_text_arr['search_in_allcontent'] = $search_text_allcontent;
            $search_text = $search_text_allcontent;
        } else if (!empty($request['search_in_liststringer'])) {
            $search_text_liststringer = $request['search_in_liststringer'];
            $search_text_arr['search_in_liststringer'] = $search_text_liststringer;
            $search_text = $search_text_liststringer;
        } else if (!empty($request['search_in_myupload'])) {
            $search_text_myupload = $request['search_in_myupload'];
            $search_text_arr['search_in_myupload'] = $search_text_myupload;
            $search_text = $search_text_myupload;
        } else if (!empty($request['search_in_usermy'])) {
            $search_text_usermy = $request['search_in_usermy'];
            $search_text_arr['search_in_usermy'] = $search_text_usermy;
            $search_text = $search_text_usermy;
        }
        
         $pjIdLists = PjStringerMapping::where('pj_id', auth()->user()->id)->pluck('stringer_id')->toArray();  
        if (!empty($search_text_liststringer)) {
            $stringerLists = User::where('user_type', stringerRoleId)->where('username','like','%'.$search_text_liststringer.'%')->whereIn('id', $pjIdLists)->orderBy('created_at', 'desc')->get();
        } else{
            $stringerLists = User::where('user_type', stringerRoleId)->whereIn('id', $pjIdLists)->orderBy('created_at', 'desc')->get();  
        }

        $pjContents = $this->getPjContents($search_text_myupload);
        $stringerContents = $this->getStringerContents($search_text_allcontent);
        $allUserContents = $this->getAllUserMyChannelContents($search_text_usermy);

        return view('content-repo.pjLanding', compact('stringerLists', 'allUserContents', 'pjContents', 'stringerContents','search_text_arr','search_text' ));
    }

    public function create() {
        $roles = Role::where('id', pjRoleId)->pluck('display_name', 'id');
        return view('content-repo.createPj', compact('roles'));
    }

    public function store(Request $request) {
        $input = $request->all(); 
        $request [USER_TYPE] = pjRoleId;
        $request [IS_ACTIVE] = 1;
        $request [PASSWORD] = 'welcome123';
        $request['mobile_number'] = $request['country_code'] . $request['mobile_number1'];

        $existsInApp = Users::where('username',$request->input(COM_MOBILE_NUMBER_KEYWORD))->first();
        $alreadyexists = User::whereRaw("(mobile_number =" . $request->input(COM_MOBILE_NUMBER_KEYWORD) . " or email= '" . $request->input(EMAIL) . "') ")
                ->where('user_type', $request [USER_TYPE])
                ->first();

        if ($alreadyexists || $existsInApp) {
            return redirect()->back()->with(ERROR, 'The Mobile number or email already exist');
        }

        try {
            $this->user->createOrUpdateUser($request->all());
            $this->storePjAccess($request->all());
            $this->createTokenForPj($request->all());
            $this->createChannelForPj($request->all());

            return redirect('content-repo#viewpjList')->withSuccess('PJ created successfully');
        } catch (\Exception $e) {
           // echo $e->getMessage();exit;
            return redirect()->back()->with(ERROR, 'Could not process! Please try later.');
        }
    }

    public function show() {
        
    }

    public function edit($id) {
        $pjData = User::where('id', '=', $id)->first();
        $access = \DB::table('pjaccess')->where('user_id', '=', $id)->get()->toArray();

        return view('content-repo.editPj', compact('pjData', 'access'));
    }

    public function update(Request $request, $id) {
        try {
            $request [USER_TYPE] = pjRoleId;
            $this->user->createOrUpdateUser($request->all(), $id);
            $this->updatePjAccess($request->all());
            $this->updateTokenForPj($request->all());
            $this->updateChannelForPj($request->all());

            return redirect('content-repo#viewpjList')->withSuccess('PJ updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, 'Could not process! Please try later.');
        }
    }

    public function destroy($id) {
        User::where('id',$id)->delete();
        return redirect('content-repo#viewpjList')->withSuccess('PJ deleted successfully');
    }

    public function storePjAccess($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();

        foreach ($data['access'] as $key => $val) {
            $row = [
                'user_id' => $user->id,
                'name' => $key,
                'value' => $val,
                'created_at' => Carbon::now()
            ];
            \DB::table('pjaccess')->insert($row);
        }
    }

    public function createTokenForPj($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();

        if (!$token = JWTAuth::fromUser($user)) {
            return 'Token not found for user';
        }

        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                // $roles[] = '"'.strtoupper($v->display_name).'"';
                $roles[] = str_replace(' ', '', strtoupper($v->display_name));
            }
        }

        $access_bits = "";
        foreach ($data['access'] as $access_key => $val) {
            $access_bits .= $val;
        }

        $vcardjson = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'nickName' => $user->username,
            'token' => $token,
            'status' => null,
            'email' => $user->email,
            'mobileNumber' => $user->mobile_number,
            'gender' => null,
            'dob' => null,
            'image_url' => public_path().UPLOAD_URL.$user->image,
            'created_date' => date("Y-m-d H:i:s"),
            'roles' => $roles,
            'permissions' => [],
            'access' => $access_bits
        ];

        $vcardarray = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'vcard' => json_encode($vcardjson),
            'token' => $token,
            'mobileNumber' => $user->mobile_number,
            'nickname' => $user->username,
            'status' => null,
            'email' => $user->email,
            'gender' => null,
            'dob' => null,
            'image_url' => public_path().UPLOAD_URL.$user->image,
            'created_date' => date("Y-m-d H:i:s")
        ];

        ChannelUserDetails::insert($vcardarray);
        Redis::set($token, json_encode($vcardjson));
        Redis::expire($token, TOKEN_TIME);
    }

    public function updatePjAccess($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();

        \DB::table('pjaccess')->where('user_id', $user->id)->delete();

        foreach ($data['access'] as $key => $val) {
            $row = [
                'user_id' => $user->id,
                'name' => $key,
                'value' => $val,
                'created_at' => Carbon::now()
            ];
            \DB::table('pjaccess')->insert($row);
        }
    }

    public function updateTokenForPj($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();
        $row = ChannelUserDetails::where('user_id', $user->mobile_number)->first();
        $token = $row->token;
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = str_replace(' ', '', strtoupper($v->display_name));
            }
        }

        $access_bits = "";
        foreach ($data['access'] as $access_key => $val) {
            $access_bits .= $val;
        }

        $vcardjson = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'nickName' => $user->username,
            'token' => $token,
            'status' => null,
            'email' => $user->email,
            'mobileNumber' => $user->mobile_number,
            'gender' => null,
            'dob' => null,
            'image_url' => public_path().UPLOAD_URL.$user->image,
            'created_date' => date("Y-m-d H:i:s"),
            'roles' => $roles,
            'permissions' => [],
            'access' => $access_bits
        ];

        $vcardarray = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'vcard' => json_encode($vcardjson),
            'token' => $token,
            'mobileNumber' => $user->mobile_number,
            'nickname' => $user->username,
            'status' => null,
            'email' => $user->email,
            'gender' => null,
            'dob' => null,
            'image_url' => public_path().UPLOAD_URL.$user->image,
            'created_date' => date("Y-m-d H:i:s")
        ];

        ChannelUserDetails::where('user_id', $user->mobile_number)->delete();
        ChannelUserDetails::insert($vcardarray);
        Redis::del($token);
        Redis::set($token, json_encode($vcardjson));
        Redis::expire($token, TOKEN_TIME);
    }

    public function createChannelForPj($input) {
        $data = [
            "channelDescription" => "This is a channel for PJ",
            "channelTitle" => $input['name'],
            "userId" => $input['mobile_number'],
            "channelType" => "PJ",
            "isWebLogin" => true,
            "isPJCreation" => true
        ];

        $user = User::where('email',$input['email'])->first();
        $image_url = public_path().UPLOAD_URL.$user->image;
        $image_name = $user->image;

        $imageString = [
                            [
                                'name' => 'files',
                                'contents' => file_get_contents($image_url),
                                'filename' => $image_name,                 
                            ],
                            [
                                'name' => 'files',
                                'contents' => file_get_contents($image_url),
                            ]
                        ];

        try {
            $jwt_token = session('jwt_token');
            $client = new Client();
            $response = $client->request('POST', API_BASE_URL . CREATE_CHANNEL, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                        ],
                        'query' => [ 'channels' => json_encode($data)],
                        'multipart' => $imageString
                    ])->getBody();

            $response = json_decode($response, true);

            $result = [];
            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return redirect()->back()->withError('Could not create channel for PJ')->withInput();
            }

        } catch (\Exception $e) 
        {
            // echo $e->getMessage();exit;
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not process! Please try later.');
        }
    }

    public function updateChannelForPj($input) {

        $pjChannelId = $this->getPjChannelId($input['mobile_number']);

        $data = [
            "channelDescription" => "This is a channel for PJ",
            "channelTitle" => $input['name'],
            "userId" => $input['mobile_number'],
            "channelType" => "PJ",
            "isWebLogin" => true,
            "isPJCreation" => true
        ];

        $user = User::where('email',$input['email'])->first();
        $image_url = public_path().UPLOAD_URL.$user->image;
        $image_name = $user->image;

        $imageString = [
                            [
                                'name' => 'files',
                                'contents' => file_get_contents($image_url),
                                'filename' => $image_name,                 
                            ],
                            [
                                'name' => 'files',
                                'contents' => file_get_contents($image_url),
                            ]
                        ];

        try {
            $jwt_token = session('jwt_token');
            $client = new Client();
            $response = $client->request('PUT', API_BASE_URL . UPATE_CHANNEL, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                        ],
                        'query' => [ 'channelModel' => json_encode($data),
                                     'channelId' => $pjChannelId
                        ],
                        'multipart' => $imageString
                    ])->getBody();

            $response = json_decode($response, true);

            $result = [];
            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return redirect()->back()->withError('Could not create channel for PJ')->withInput();
            }
        } catch (\Exception $e) {
            // echo $e->getMessage();exit;
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not process! Please try later.');
        }
    }

    public function getPjChannelId($userId) {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get(GET_PJ_CHANNEL_ID.$userId, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();

        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['channelId'];
        } else {
            return false;
        }
    }

    public function getPjContents($search_text=null) {
        $url= GET_PJ_CONTENTS;
        if(!empty($search_text)) {
            $url .= "?searchText=".$search_text;
        }
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();

        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['data']['item'];
        } else {
            return false;
        }
    }

    public function getStringerContents($search_text=null) {
        $url= GET_STRINGER_CONTENTS;
        if(!empty($search_text)) {
            $url .= "?searchText=".$search_text;
        }
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();

        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['data']['item'];
        } else {
            return false;
        }
    }

    public function getAllUserMyChannelContents($search_text=null) {
        $url= GET_ALL_USERMYCHANNEL_CONTENTS;
        if(!empty($search_text)) {
            $url .= "&searchText=".$search_text;
        }
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();

        $response = json_decode($response, true);
        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {

            return $response['data']['item'];
        } else {
            return false;
        }
    }
    
    public function publishContent($content_id) {

        $url = PJ_PUBLISH_CONTENT . $content_id;
        $jwt_token = session('jwt_token');
        
        try {
            $client = new Client();
            $response = $client->request('POST', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                ]])->getBody();
            $response = json_decode($response, true);
            
            if (isset($response['status']) && ($response['status'] === 1)) {
                echo true;
            } else {
                echo false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                echo $exception->errorMsg;
            } else {
                echo 'could not able to Publish content';
            }
        }  
    }
    public function unpublishContent($content_id) {

        $url = PJ_UNPUBLISH_CONTENT . $content_id;
        $jwt_token = session('jwt_token');
        
        try {
            $client = new Client();
            $response = $client->request('POST', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                ]])->getBody();
            $response = json_decode($response, true);
            if (isset($response['status']) && ($response['status'] === 1)) {
                echo true;
            } else {
                echo false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                echo $exception->errorMsg;
            } else {
                echo 'could not able to Unpublish content';
            }
        }
        
    }

}
