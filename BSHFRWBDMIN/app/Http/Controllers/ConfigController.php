<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Models\Users;
use DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = $this->listSettings(AD_API_BASE.FETCH_SETTINGS_API);
        $rateCardSettings = $this->listSettings(AD_API_BASE.LIST_RATECARDS);
        $totalHashtags = $this->listHashtags(API_BASE_URL.LIST_HASHTAGS);

        if(isset($request['q'])){

            $hashtags = $this->listHashtags(API_BASE_URL.LIST_HASHTAGS.'?hashtag='.$request['q']);
        }else{
            $hashtags = $this->listHashtags(API_BASE_URL.LIST_HASHTAGS);
        }
        $trendings = $this->listTrendingTags(TRENDING_HASHTAGS);

        return view ( 'config.listConfig',compact('settings','rateCardSettings',
            'trendings','hashtags','totalHashtags'));
    }

    public function getHashTag($name)
    {
        $hashtags = $this->getHashtags(KEYWORD_DEARCH.$name);

        if(count($hashtags) > 0){
            $html = "";
            foreach ($hashtags as $tag) {
                $html .= '<li><p>'.$tag['contentTitle'].'</p>';
                $html .= '<p class="tagonhash">'.$tag['channelTitle'].'</p></li>';
            }
            return $html;
        }
        return $hashtags;
    }

    public function deleteHashTag($name)
    {
        $hashtags = $this->deleteHashTags(API_BASE_URL.DELETE_HASHTAGS.$name.'&isActive=0');
        
        if($hashtags)
        {
            return redirect ('/settings#hashtag')->withSuccess ( 'HashTag deleted!' );
        }else
        {
            return redirect ('/settings#hashtag')->withError ( 'Something went wrong!' );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = $this->getSettings(AD_API_BASE.EDIT_SETTINGS_API.'?name='.$id);        
        return view('config.editConfig',['settings' => $settings]);

        // editConfig
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $input = $request->all ();            
            $result = $this->updateSettings(AD_API_BASE.UPDATE_SETTINGS_API, $input);
        if($result){
                return redirect ('/settings')->withSuccess ( 'Settings updated!' );
            }else{
                return redirect ('/settings')->withError ( 'Something went wrong' );
            }
        }catch(\Exception $e){
            return $e->getMessage();
            return redirect ('/settings')->withError ( 'Something went wrong' );
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function listSettings($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('GET', $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ]
            ])->getBody();
        $response = json_decode($response, true);
        
        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }
        else{
            return false;
        }
        
    }

    function getSettings($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('GET', $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ]
            ])->getBody();
        $response = json_decode($response, true);
        
        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }
        else{
            return false;
        }
        
    }

    function updateSettings($url, $input){
        $jwt_token = session('jwt_token');
        $client = new Client();
        $data = [
            'name' => $input['settingName'],
            'settingId' => $input['settingId'],
            'value' => $input['settingValue']
        ];
        
        $response = $client->request('PUT', $url,
            [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'body' => json_encode($data) 
            ])->getBody();
        $response = json_decode($response, true);        
        
        if(isset($response['status']) && ($response['status'] == 1)){            
            return true;
        }
        else{
            return false;
        }
    }

    public function dashboard()
    {
        $appUsers = Users::leftjoin('vcard','users.username','vcard.username')
                    ->select('users.*','vcard.vcard')
                    ->where('users.username','!=',null)->get();        
        $businessUsers = User::where ( USER_TYPE, '=', 2 )->get();
        $adUsers = User::where ( 'user_type', '=', 6 )->get();
        $categories = $this->getApiResponse(GET_ALL_CATEGORIES);
        $regUsers = Users::select(DB::raw("count(username) as usercount, DATE_FORMAT(created_at,'%d %M %Y') date"))
        ->where(DB::raw('YEAR(created_at)'),'=','2017')
        ->groupBy('date')
        ->orderBy(DB::raw('MONTH(created_at)'),'asc')
        ->orderBy('date','asc')
        ->get()->toArray();

        $usercount = [];
        $dates = [];
        foreach($regUsers as $users){
            $usercount[] = $users['usercount'];
            $dates[] = $users['date'];
        }

        $usercount = implode(',', $usercount);
        $dates = "'".implode("','", $dates)."'";

        return view('bushfire.dashboard', compact('appUsers','businessUsers',
            'adUsers','categories', 'usercount','dates'));
    }

    public function getApiResponse($url)
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

    public function listHashtags($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get( $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }
        else{
            return false;
        }

    }
    
    public function listTrendingTags($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get( $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);
        
        return $response;
        // $result = [];
        // if(isset($response['status']) && ($response['status'] == 1)){
        //     $result = $response['data']['item'];
        //     return $result;
        // }
        // else{
        //     return false;
        // }
       
    }
    
    public function getHashtags($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get( $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }
        else{
            return 0;
        }

    }

    public function deleteHashTags($url)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('DELETE', $url,
            [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return true;
        }
        else{
            return false;
        }
    }
}
