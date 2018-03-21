<?php

namespace App\Http\Controllers\Content;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\User;
use App\Models\Users;
use App\Models\ChannelUserDetails;
use Redis;
use JWTAuth;
use Carbon\Carbon;
use App\Repository\UserRepository as UserRepository;
use GuzzleHttp\Client;

class StringerController extends Controller {

    public function __construct(UserRepository $user) {
        // constructor function for user
        $this->user = $user;
    }

    public function index(Request $request) {

        $stringerContents = array();
        $search_text = '';
        if (!empty($request ['q'])) {
            $search_text = $request ['q'];
        }
        $stringerContents = $this->getStringerIDList($search_text);
        return view('content-repo.listStringerContent', compact('stringerContents'));
    }

    public function create() {
        $roles = Role::where('id', stringerRoleId)->pluck('display_name', 'id');
        return view('content-repo.createStringer', compact('roles'));
    }

    public function store(Request $request) {
        $input = $request->all();
        $request [USER_TYPE] = stringerRoleId;
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
            $this->pjStringerMapping($request->all());
            $this->createTokenForStringer($request->all());
            $this->pjMapping($request->all());

            return redirect('pj#liststringer')->withSuccess('stringer created successfully');
        } catch (\Exception $e) {
//             echo $e->getMessage();exit;
            return redirect()->back()->with(ERROR, $e->getMessage() .' Could not process! Please try later.');
        }
    }

    public function show() {
        
    }

    public function edit($id) {
        $stringerData = User::where('id', '=', $id)->first();
        return view('content-repo.editStringer', compact('stringerData'));
    }

    public function update(Request $request, $id) {
        try {
            $request [USER_TYPE] = stringerRoleId;
            $this->user->createOrUpdateUser($request->all(), $id);
            $this->updateTokenForStringer($request->all());

            return redirect('pj#liststringer')->withSuccess('Stringer updated successfully');
        } catch (\Exception $e) {
            // echo $e->getMessage();exit;
            return redirect()->back()->with(ERROR, 'Could not process! Please try later.');
        }
    }

    public function destroy($id) {
        User::where('id',$id)->delete();
        return redirect('pj#liststringer')->withSuccess('Stringer deleted successfully');
    }

    public function createTokenForStringer($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();

        if (!$token = JWTAuth::fromUser($user)) {
            return 'Token not found for user';
        }

        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                // $roles[] = '"'.$v->display_name.'"';
                $roles[] = str_replace(' ', '', strtoupper($v->display_name));
            }
        }

        $vcardjson = json_encode([
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'nickName' => $user->username,
            'token' => $token,
            'status' => null,
            'email' => $user->email,
            'mobileNumber' => $user->mobile_number,
            'gender' => null,
            'dob' => null,
            'image_url' => null,
            'created_date' => date("Y-m-d H:i:s"),
            'roles' => $roles,
            'permissions' => []
        ]);

        $vcardarray = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'vcard' => $vcardjson,
            'token' => $token,
            'mobileNumber' => $user->mobile_number,
            'nickname' => $user->username,
            'status' => null,
            'email' => $user->email,
            'gender' => null,
            'dob' => null,
            'image_url' => null,
            'created_date' => date("Y-m-d H:i:s")
        ];

        ChannelUserDetails::insert($vcardarray);
        Redis::set($token, $vcardjson);
        Redis::expire($token, TOKEN_TIME);
    }

    public function updateTokenForStringer($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();
        $row = ChannelUserDetails::where('user_id', $user->mobile_number)->first();
        $token = $row->token;
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                // $roles[] = '"'.$v->display_name.'"';
                $roles[] = str_replace(' ', '', strtoupper($v->display_name));
            }
        }

        $vcardjson = json_encode([
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'nickName' => $user->username,
            'token' => $token,
            'status' => null,
            'email' => $user->email,
            'mobileNumber' => $user->mobile_number,
            'gender' => null,
            'dob' => null,
            'image_url' => null,
            'created_date' => date("Y-m-d H:i:s"),
            'roles' => $roles,
            'permissions' => []
        ]);

        $vcardarray = [
            'user_id' => $user->mobile_number,
            'user_name' => $user->username,
            'vcard' => $vcardjson,
            'token' => $token,
            'mobileNumber' => $user->mobile_number,
            'nickname' => $user->username,
            'status' => null,
            'email' => $user->email,
            'gender' => null,
            'dob' => null,
            'image_url' => null,
            'created_date' => date("Y-m-d H:i:s")
        ];

        ChannelUserDetails::where('user_id', $user->mobile_number)->delete();
        ChannelUserDetails::insert($vcardarray);
        Redis::del($token);
        Redis::set($token, $vcardjson);
        Redis::expire($token, TOKEN_TIME);
    }

    public function pjMapping($data) {
        $url = MAP_STRINGER . session('userId') . '&stunnerId=' . $data['mobile_number'];
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->post(API_BASE_URL . $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return true;
        } else {
            return redirect()->back()->with(ERROR, 'Could not map the stringer.');
        }
    }

    public function getStringerIDList($search_text=null) {
        $url= GET_STRINGER_ID_LIST;
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

    public function deleteContent($content_id) {
        $url = DELETE_CONTENT_DETAILS . $content_id;
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('DELETE', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return redirect('stringer')->withSuccess("Deleted successfully");
        } else {
            return false;
        }
    }
    
    private function pjStringerMapping($data) {
        $user = User::where('mobile_number', $data['mobile_number'])->first();
        $row = [
            'pj_id' => auth()->user()->id,
            'stringer_id' => $user->id
        ];
        \DB::table('pj_stringer_mapping')->insert($row); 
    }
}
