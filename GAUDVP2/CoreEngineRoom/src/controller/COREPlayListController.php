<?php

/*
  Project                     : Oriole
  Module                      : Playlist
  File name                   : COREPlayListController.php
  Description                 : Controller class for playlist related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Compassites .
  History                     :
 */

class COREPlayListController
{

    public function __construct()
    {
    }

    /*
     * API : /playlists/
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : (optional)
     * {"client_play_list":0/1/2, "page_no": 1, "pegination":true} page no optional
     */
    public function getAllPlayLists($clientPlaylist=null)
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            $clientPlaylist = 0; // 0 -> consumer playlist
            $clientPlaylist = 1; // 1 -> clinet playlist created from backend
            $clientPlaylist = 2; // 2 -> all playlist (0+1)
            
            if(array_key_exists(JSON_TAG_CLIENT_PLAY_LIST,$aPostData)) {
                $clientPlaylist = $aPostData[JSON_TAG_CLIENT_PLAY_LIST];
            } 
            if(!empty($aPostData[JSON_PAGE_NO]))
            {
                $page_no = $aPostData[JSON_PAGE_NO];
            }
            else
            {
                $page_no = 1;
            }
            
            if(isset($aPostData[JSON_TAG_PEGINATION_REQUIREMENT_TEXT]))
            {
                $pegination = boolval($aPostData[JSON_TAG_PEGINATION_REQUIREMENT_TEXT]);
            }
            else
            {
                $pegination = true;
            }

            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientUserId = $AppAuthorizationDetails['clientUserId'];
            $clientUserId .= ','.$AppAuthorizationDetails['audvisorClientUserId'];

            $appCall = true;
            
            $aResult    = $PlayListModel->getAllPlayLists($userId,$clientUserId,$clientPlaylist,$appCall,$page_no,$pegination);
        }
        
        $app->render($aResult);
        return $aResult;
    }
    
    /*
     * API : /playlists/:playlistid/
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     * {"client_play_list":0/1/2, "page_no": 1, "pegination":true} page no optional
     * add "playlistids_arr":[1,4,8] // 13 Nov 2017
     * add "list_my_favorites":true in request if want to get my favorites (by default =  false) // 15 Nov 2017
     * add "selected_insights_arr":[630,730,2291] in request // 22 Nov 2017 -  listed selected insights first
     */
    public function getPlayListInsights($playListId)
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            $clientPlaylist = 0; // 0 -> consumer playlist
//            $clientPlaylist = 1; // 1 -> clinet playlist created from backend
            
            
            if(array_key_exists(JSON_TAG_CLIENT_PLAY_LIST,$aPostData)) {
                $clientPlaylist = $aPostData[JSON_TAG_CLIENT_PLAY_LIST];
            } 
            if(!empty($aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT]) && is_array($aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT]))
            {
                $selected_insights = $aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT];
            }
            else
            {
                $selected_insights = NULL;
            }    
            if(!empty($aPostData[JSON_PAGE_NO]))
            {
                $page_no = $aPostData[JSON_PAGE_NO];
            }
            else
            {
                $page_no = 1;
            }
            
            if(isset($aPostData[JSON_TAG_PEGINATION_REQUIREMENT_TEXT]))
            {
                $pegination = boolval($aPostData[JSON_TAG_PEGINATION_REQUIREMENT_TEXT]);
            }
            else
            {
                $pegination = true;
            }
            
            if(isset($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]))
            {
                $list_my_favorites_flag = boolval($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]);
            }
            else
            {
                $list_my_favorites_flag = false;
            }
           
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientUserId = $AppAuthorizationDetails['clientUserId'];
            $clientId = $AppAuthorizationDetails['clientId'];
            $clientUserId .= ','.$AppAuthorizationDetails['audvisorClientUserId'];
            $playlist_created_by_client = 0;
                    
            if(!empty($aPostData[JSON_TAG_MULTIPLE_PLAYLIST_IDS_ARRAY]) && is_array($aPostData[JSON_TAG_MULTIPLE_PLAYLIST_IDS_ARRAY]))
            {
                if(!empty($playListId)) {
                    $playListIds_arr = array_merge(array($playListId),$aPostData[JSON_TAG_MULTIPLE_PLAYLIST_IDS_ARRAY]);                    
                } else {
                    $playListIds_arr = $aPostData[JSON_TAG_MULTIPLE_PLAYLIST_IDS_ARRAY];
                }
                $playListIds_arr = array_unique($playListIds_arr);
                $playListId = implode(",", $playListIds_arr);
                $clientPlaylist = 2;
            }
            
            $aResult    = $PlayListModel->getPlayListInsights($userId,$clientId,$clientUserId,$clientPlaylist,$playListId,$page_no,$pegination, $list_my_favorites_flag,$selected_insights);
        }        
        $app->render($aResult);        
    }
    
    /*
     * API : /playlists/createPlayList/
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     * {"playlist_name":"myPlayList-1","playlist_insights":[1,3,6,8]}
     */
    public function createPlayList()
    {   
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) { 
            
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData);            
            if(empty($aPostData[JSON_TAG_PLAY_LIST_NAME])) {
                $error_string = array("error" => true, "message" => "Error !!! Please provide the playlist name.");
                $app->render($error_string);
            } else {
                $playListName = $aPostData[JSON_TAG_PLAY_LIST_NAME];
                $playlist_insight_arr = !empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS]) ? $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS] : array();
            }
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $playlist_created_by_client = 0; // play list created from app
            $clientId = $AppAuthorizationDetails['clientId'];
            
            $aResult    = $PlayListModel->createPlayList($userId,$playListName,$playlist_insight_arr,$playlist_created_by_client,$clientId);
            
        }
        
        
        $app->render($aResult);
    }

    /*
     * API : /playlists/updatePlayList
     * Method : put
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_name":"edit_name","playlist_id":3, "playlist_insights":[1,3,6,8]}
     */
    public function updatePlayList()
    {
        $aResult      = array();

        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) { 
            
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(empty($aPostData[JSON_TAG_PLAY_LIST_NAME]) || empty($aPostData[JSON_TAG_PLAY_LIST_ID]) ) {
                $error_string = array("error" => true, "message" => ERROR_SELECT_PLAYLIST_AND_OR_INSIGHT);
                $app->render($error_string);
            } else {
                $playListName = $aPostData[JSON_TAG_PLAY_LIST_NAME];
                $playListIdTo = $aPostData[JSON_TAG_PLAY_LIST_ID];
                $playlist_insight_arr = !empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS]) ? $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS] : array();
            }
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $playlist_created_by_client = 0; // play list created from app
            $playListDM = new COREPlayListDB();
            $ConnBean   = new COREDbManager();
            $max_list_order = $playListDM->getMaxListOrderForPlayList($ConnBean,$userId,$playlist_created_by_client);
            $aResult    = $PlayListModel->updatePlayList($userId,$playListName,$max_list_order,$playListIdTo,$playlist_insight_arr,$playlist_created_by_client);
            
        } 
        
        $app->render($aResult);        
    }

    /*
     * API : /playlists/deletePlayList
     * Method : put
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_ids":[1,2,3]}
     */
    public function deletePlayList()
    {
        $aResult      = array();
        
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData);             
            
            if(empty($aPostData[JSON_TAG_PLAY_LIST_IDS])) {
                $error_string = array("error" => true, "message" => "Error !!! Please select the playlist.");
                $app->render($error_string);
            } else {
                $playListIds = $aPostData[JSON_TAG_PLAY_LIST_IDS];
            }
            
            
            $PlayListModel = new COREPlayListModel();            
            $userId = $AppAuthorizationDetails['userId'];
            $playlist_created_by_client = 0;
            $aResult    = $PlayListModel->deletePlayList($userId,$playListIds,$playlist_created_by_client);
            $app->render($aResult);
        }        
        
        $app->render($aResult);
    }
    
    /*
     * API : /playlists/addToPlayList
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_id":1,"playlist_insights":[1,3,6,8]}
     *  add "add_to_favorites=true" if wanted to add in favorites
     */
    public function addToPlayList()
    {
        $aResult      = array();
        $playlist_insight_duration_arr = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            $add_to_favorites_flag = false;
            if(!isset($aPostData[JSON_TAG_PLAY_LIST_ID])) {
                $error_string = array("error" => true, "message" => ERROR_SELECT_PLAYLIST_AND_OR_INSIGHT);
                $app->render($error_string);
            } else {
                $playListId = $aPostData[JSON_TAG_PLAY_LIST_ID];
                $playlist_insight_arr = $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS];
            }
            
            if(isset($aPostData[JSON_TAG_ADD_AS_FAVORITES_INSIGHT]))
            {
                $add_to_favorites_flag = boolval($aPostData[JSON_TAG_ADD_AS_FAVORITES_INSIGHT]);
            }
            else
            {
                $add_to_favorites_flag = false;
            }
                    
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $recent_playlist=false;
            $aResult    = $PlayListModel->addToPlayList($userId,$playListId,$playlist_insight_arr,$playlist_insight_duration_arr,$recent_playlist,$add_to_favorites_flag);   
            $app->render($aResult);
        }       
        
        $app->render($aResult); 
    }

    /*
     * API : /playlists/removeFromPlayList
     * Method : put
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_id":1,"playlist_insights":[1,3,6,8]}
     * add "list_my_favorites=true" for my favorites  (by default =  false)
     */
    public function removeFromPlayList()
    {
        $aResult      = array();

        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(!isset($aPostData[JSON_TAG_PLAY_LIST_ID]) || empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS])) {
                $error_string = array("error" => true, "message" => ERROR_SELECT_PLAYLIST_AND_OR_INSIGHT);
                $app->render($error_string);
            } else {
                $playListId = $aPostData[JSON_TAG_PLAY_LIST_ID];
                $playlist_insight_arr = $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS];
            }
            if(isset($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]))
            {
                $list_my_favorites_flag = boolval($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]);
            }
            else
            {
                $list_my_favorites_flag = false;
            }
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $aResult    = $PlayListModel->removeFromPlayList($userId,$playListId,$playlist_insight_arr,$userId,$list_my_favorites_flag);
            $app->render($aResult);
        }        
        
        $app->render($aResult); 
    }
    
    /*
     * API : /playlists/reorder
     * Method : put
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_id":1,"playlist_insights":[1,3,6,8],"list_order":[1,2,3,4]} // playlist_insights and list_order works in according to each other
     * add "list_my_favorites=true" for my favorites  (by default =  false)
     */
    public function reorderPlayListInsights() {
        $aResult      = array();

        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) { 
            
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(!isset($aPostData[JSON_TAG_PLAY_LIST_ID]) || empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS]) || empty($aPostData[JSON_TAG_LIST_ORDER]) ) {
                $error_string = array("error" => true, "message" => ERROR_SELECT_PLAYLIST_AND_OR_INSIGHT_LIST_ORDER);
                $app->render($error_string);
            } else {
                $playListId = $aPostData[JSON_TAG_PLAY_LIST_ID];
                $playlist_insight_arr = $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS];
                $playlist_insight_list_order_arr = $aPostData[JSON_TAG_LIST_ORDER];
            }
            
            if(isset($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]))
            {
                $list_my_favorites_flag = boolval($aPostData[JSON_TAG_LIST_MY_FAVORITES_INSIGHTS]);
            }
            else
            {
                $list_my_favorites_flag = false;
            }
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $playlist_created_by_client = 0; // play list created from app
            $aResult    = $PlayListModel->reorderPlayListInsights($userId,$playListId,$playlist_insight_arr,$playlist_insight_list_order_arr,$userId,$list_my_favorites_flag);
            
        } 
        
        $app->render($aResult);      
    }
    
    // Back End start
    
    public function showaddPlayList()
    {

        $Request = \Slim\Slim::getInstance();

        $clientId = $_SESSION['client_id'];
        $aResult["Data"] = $this->get_all_play_lists();
               
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREPlayListAdd.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }
    
    public function get_all_play_lists()
    {        
        $PlayListModel = new COREPlayListModel();
        $clientId = $_SESSION['client_id'];
        $clientUserId = $_SESSION['client_user_id'];
        $clientPlaylist = 1;
        $userId = 0;

        $aResult    = $PlayListModel->getAllPlayLists($userId,$clientUserId,$clientPlaylist);

        return $aResult;
    }
    public function addPlayList() {

        // play list created from backend
        $clientId = $_SESSION['client_id'];
        $playlist_created_by_client = (int)$_SESSION['client_user_id'];
        $userId = 0;
        $playlist_insight_arr = array();
        
        $app           = \Slim\Slim::getInstance();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $BodyData   = $Request->getBody();
        $aPlayListData = $Generalmethod->decodeJson($BodyData, true);        
        $playListName = $aPlayListData['playlist_name'];        
        
        $PlayListModel = new COREPlayListModel();        
        $aResult    = $PlayListModel->createPlayList($userId,$playListName,$playlist_insight_arr,$playlist_created_by_client,$clientId);
        
        $app->render($aResult);
        
    }
    
    public function viewPlayList()
    {
        $Request         = \Slim\Slim::getInstance();
        $aResult["Data"] = $this->get_all_play_lists();
        
        if(isset($_SESSION[APP_SESSION_NAME]))
        {   
            $Request->render('COREPlayListView.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }
    
    public function updatePlayListFromBackend() {        
        
        // play list updated from backend
        $playlist_created_by_client = (int)$_SESSION['client_user_id'];
        $userId = 0;
        $playlist_insight_arr = array();
        
        $app           = \Slim\Slim::getInstance();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $BodyData   = $Request->getBody();
        $aPlayListData = $Generalmethod->decodeJson($BodyData, true);        
        $playListName = $aPlayListData['playlist_name']; 
        $list_order = $aPlayListData['list_order']; 
        $playListIdTo = $aPlayListData['playlist_id'];
      
        $PlayListModel = new COREPlayListModel();
        $aResult    = $PlayListModel->updatePlayList($userId,$playListName,$list_order,$playListIdTo,$playlist_insight_arr,$playlist_created_by_client);
        $app->render($aResult);
        
        return $aResult;
    }
    
    public function deletePlayListFromBackend($playlist_id) {
        // play list deleted from backend
        $playlist_created_by_client = (int)$_SESSION['client_user_id'];
        $userId = 0;
        $playlist_insight_arr = array();
        $playListIds = array($playlist_id);
        
        $app           = \Slim\Slim::getInstance();    
        
        $PlayListModel = new COREPlayListModel();
        $aResult    = $PlayListModel->deletePlayList($userId,$playListIds,$playlist_created_by_client);
        $app->render($aResult);
        
        return $aResult;
    }
    
    public function playlistInsights($playListId) {
        $Request         = \Slim\Slim::getInstance();
        $aResult["Data"] = $this->get_all_play_list_insights($playListId);
        $aResult["playListId"] = $playListId;
        
        if(isset($_SESSION[APP_SESSION_NAME]))
        {   
            $Request->render('COREPlayListInsightsView.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }
    
    public function get_all_play_list_insights($playListId)
    {        
        $PlayListModel = new COREPlayListModel();
        $clientId = $_SESSION['client_id'];
        $clientUserId = $_SESSION['client_user_id'];
        $clientPlaylist = 1;
        $playlist_created_by_client = 1;
        $userId = 0;

        $aResult    = $PlayListModel->getPlayListInsights($userId,$clientId,$clientUserId,$clientPlaylist,$playListId);

        return $aResult;
    }
    public function updatePlayListInsightsListOrder() {
        
        // play list updated from backend
        $playlist_created_by_client = (int)$_SESSION['client_user_id'];
        $userId = 0;
        $playlist_insight_arr = array();
        
        $app           = \Slim\Slim::getInstance();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $BodyData   = $Request->getBody();
        $aPlayListData = $Generalmethod->decodeJson($BodyData, true);        
        $playListId = $aPlayListData['playlist_id'];
        $playlist_insight_arr[] = $aPlayListData['playlist_insight_id'];
        $playlist_insight_list_order_arr[] = $aPlayListData['list_order'];
       
        $PlayListModel = new COREPlayListModel();
        $aResult    = $PlayListModel->reorderPlayListInsights($userId,$playListId,$playlist_insight_arr,$playlist_insight_list_order_arr);
       
        $app->render($aResult);
        
        return $aResult;
    }
    public function deletePlayListInsightsFromBackend() {
        // play list deleted from backend
        $playlist_created_by_client = (int)$_SESSION['client_user_id'];
        $userId = 0;
        $playlist_insight_arr = array();
        
        $app           = \Slim\Slim::getInstance();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $BodyData   = $Request->getBody();
        $aPlayListData = $Generalmethod->decodeJson($BodyData, true);        

        $playListId = $aPlayListData['playlist_id'];
        $playlist_insight_arr[] = $aPlayListData['playlist_insight_id'];
               
        $PlayListModel = new COREPlayListModel();
        $aResult    = $PlayListModel->removeFromPlayList($userId,$playListId,$playlist_insight_arr);
        $app->render($aResult);
        
        return $aResult;
    }
    
    /*
     * API : /playlists/reorderPlayList
     * Method : put
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_ids":[1,2,3,4],"list_order":[11,21,31,41]} // playlist_ids and list_order works in according to each other
     */
    public function reorderPlayLists() {
        
        $aResult      = array();

        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) { 
            
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(empty($aPostData[JSON_TAG_PLAY_LIST_IDS]) || empty($aPostData[JSON_TAG_LIST_ORDER]) ) {
                $error_string = array("error" => true, "message" => "Error !!! Please select the playlist and list orders.");
                $app->render($error_string);
            } else {
                $playlist_id_arr = $aPostData[JSON_TAG_PLAY_LIST_IDS];
                $playlist_id_list_order_arr = $aPostData[JSON_TAG_LIST_ORDER];
            }
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $playlist_created_by_client = 0; // play list created from app

            $aResult    = $PlayListModel->reorderPlayLists($userId,$playlist_id_arr,$playlist_id_list_order_arr,$playlist_created_by_client,$userId);
        }
        $app->render($aResult);
        
        return $aResult;
    }
    
    /*
     * API : /playlists/createRecentPlayList/
     * Method : POST
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     */
    public function createRecentPlayList() {  
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) { 
            
            $app          = \Slim\Slim::getInstance();            
            $Request      = $app->request();

            $playListName = 'JSON_TAG_RECENT_PLAY_LIST_NAME';
            $playlist_insight_arr = array();
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientId = $AppAuthorizationDetails['clientId'];
            $playlist_created_by_client = 0; // play list created from app
            $aResult    = $PlayListModel->createPlayList($userId,$playListName,$playlist_insight_arr,$playlist_created_by_client,$clientId);
            
        }
        
        
        $app->render($aResult);
    }
    
    /*
     * API : /playlists/addToRecentPlayList
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_insights":[1,3,6,8]} oprional : "playlist_insights_duration":[102295,102295,102295,102295]
     */
    public function addToRecentPlayList()
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS])) {
                $error_string = array("error" => true, "message" => ERROR_SELECT_PLAYLIST_AND_OR_INSIGHT);
                $app->render($error_string);
            } else {
                $playListId = 0;// we will get the actual recent playlist id in DB manager page
                $playlist_insight_arr = $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS];
                $playlist_insight_duration_arr = isset($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS_DURATION]) ? $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS_DURATION]: array();
            }
                    
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $recent_playlist = true;
            $aResult    = $PlayListModel->addToPlayList($userId,$playListId,$playlist_insight_arr,$playlist_insight_duration_arr,$recent_playlist);
            $app->render($aResult);
        }       
        
        $app->render($aResult); 
    }
    
        /*
     * API : /playlists/recentPlaylist/
     * Method : get
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     */
    public function getRecentPlaylistInsights()
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            $clientPlaylist = 0; // 0 -> consumer playlist
//            $clientPlaylist = 1; // 1 -> clinet playlist created from backend
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientUserId = $AppAuthorizationDetails['clientUserId'];
            $clientId = $AppAuthorizationDetails['clientId'];
           
            $aResult    = $PlayListModel->getRecentPlayListInsights($userId,$clientId,$clientUserId);
        }        
        $app->render($aResult);        
    }
    
    /*
     * API : /playlists/captureInsightListenTime
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     *      {"playlist_insights":[1,3,6,8],"playlist_insights_duration":[102295,102295,102295,102295]}
     */
    public function captureInsightListenTime()
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            if(empty($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS])) {
                $error_string = array("error" => true, "message" => "Error !!! Please select the insight.");
                $app->render($error_string);
            } else {
                $playListId = 0;// we will get the actual recent playlist id in DB manager page
                $playlist_insight_arr = $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS];
                if(!is_array($playlist_insight_arr)) {
                    $playlist_insight_arr = array($playlist_insight_arr);
                }
                $playlist_insight_duration_arr = isset($aPostData[JSON_TAG_PLAY_LIST_INSIGHTS_DURATION]) ? $aPostData[JSON_TAG_PLAY_LIST_INSIGHTS_DURATION]: array();
                
                if(!is_array($playlist_insight_duration_arr)) {
                    $playlist_insight_duration_arr = array($playlist_insight_duration_arr);
                }                
            }
                    
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $recent_playlist = true;
            $aResult    = $PlayListModel->captureInsightListenTime($userId,$playListId,$playlist_insight_arr,$playlist_insight_duration_arr,$recent_playlist);
            $app->render($aResult);
        }       
        
        $app->render($aResult); 
    }
    
    /*
     * API : /playlists/shuffleExperts/
     * Method : get
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     */
    public function getPlayListInsightsShuffleExperts()
    {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {        
            $app          = \Slim\Slim::getInstance();
            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData); 
            $clientPlaylist = 0; // 0 -> consumer playlist
//            $clientPlaylist = 1; // 1 -> clinet playlist created from backend
            
            $PlayListModel = new COREPlayListModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientUserId = $AppAuthorizationDetails['clientUserId'];
            $clientId = $AppAuthorizationDetails['clientId'];
           
            $aResult    = $PlayListModel->getPlayListInsightsShuffleExperts($userId,$clientId,$clientUserId);
        }        
        $app->render($aResult);        
    }

}

?>