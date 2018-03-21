<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Models\Users;
use DB;

class RateCardConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
        $settings = $this->getSettings(AD_API_BASE.GET_RATECARDS.$id);
        return view('config.editrateConfig', compact('settings'));

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
        //
        try{
            $input = $request->all ();
            $result = $this->updateSettings(AD_API_BASE.UPDATE_RATECARDS, $input);
        if($result){
                return redirect ('/settings#ratecard')->withSuccess ( 'Rate card updated!' );
            }else{
                return redirect ('/settings#ratecard')->withError ( 'Something went wrong' );
            }
        }catch(\Exception $e){
            return $e->getMessage();
            return redirect ('/settings#ratecard')->withError ( 'Something went wrong' );
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

    function updateSettings($url, $input)
    {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $data = [
            'amount' => 0,
            'amtPerNoOfView' => $input['amtPerNoOfView'],
            'contentType' => $input['contentType'],
            'noOfViews' => $input['noOfViews'],
            'rateCardId' => $input['rateCardId']
            // 'createdDate': "string",
            // 'modifiedDate': "string",
            // 'modifyBy': "string",
        ];
        
        $response = $client->request('POST', $url,
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

}
