<?php

namespace App\Http\Controllers\Content;

use Illuminate\Routing\Controller;
use App\Repository\ContentRepository as ContentRepo;
use Illuminate\Http\Request;
use App\Models\Role;
use App\User;
use GuzzleHttp\Client;

class ContentRepoController extends Controller {
    /*
      To get reports of channel content via api call
     */

    public function __construct(ContentRepo $content) {
        $this->contentRepo = $content;
    }

    public function index(Request $request) {        
        
        $pjLists = User::where('user_type', pjRoleId)->orderBy('created_at', 'desc')->get();
        
        $pjstringerContents = $this->getPjStringerContents();
        
        // return view('content-repo.contentList', compact('pjLists','pjstringerContents','search_text_arr','search_text'));
        return view('content-repo.contentList', compact('pjLists','pjstringerContents'));
    }

    public function create() {
        
    }

    public function userMyChannel() {
        return view('content-repo.user-my-channel');
    }

    public function store(Request $request) {
        
    }

    public function show() {
        
    }

    public function edit($id) {
        
    }

    public function update(Request $request, $id) {
        
    }

    public function destroy($id) {
        
    }
    
    private function getPjStringerContents($search_text=null) {
        $url= GET_PJSTRINGER_CONTENTS;
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
    
    public function getContentRepoData($id) {
        $data = array();
        if($id==='allcontentList') {
            $pjstringerContents = $this->getPjStringerContents();
            $data = json_encode($pjstringerContents);
        } else if($id==='viewpjList') {
            $pjLists = User::where('user_type', pjRoleId)->orderBy('created_at', 'desc')->get();
            $data = json_encode($pjLists);
        }        
        return $data;
    }

}
