<?php

/*
  Project                     : Oriole
  Module                      : Inbox
  File name                   : COREInboxController.php
  Description                 : Controller class for Inbox related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Compassites .
  History                     :
 */

class COREInboxController
{

    public function __construct()
    {
    }

    /*
     * API : /inbox/
     * Method : get
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     */
    public function list_inbox_data($shared_by_me=false)
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        if($userId){
            $group=   $GenMethods->getUserGroup($userId);
            $groupId =$group['fldid'];
        }else{
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_AUTH_ID,TOKEN_DOESNT_MATCH);;
            $app->render($aResult);
        }
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }  

        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->list_inbox_data($clientId,$groupId,$userId,$shared_by_me);

        $app->render($aResult);
    }
    
    /*
     * API : /inbox/searchMembers
     * Method : post
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : (optional)
     *      {"search_for" : "rsv0"}
     */
    public function search_members($searchString=null)
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        $CORException = new COREException();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_MEMBER_SEARCH_STRING])) {
            $searchString = $aPostData[JSON_TAG_MEMBER_SEARCH_STRING];
        }
                
        if($userId){
            $group=   $GenMethods->getUserGroup($userId);
            $groupId =$group['fldid'];
        }else{
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_AUTH_ID,TOKEN_DOESNT_MATCH);;
            $app->render($aResult);
        }
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }  
                
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->search_members($clientId,$groupId,$searchString);
        
        $app->render($aResult);        
    }
    
    /*
     * API : /inbox/shareInsight
     * Method : post
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : (optional)
     *      {"share_with_consumer_id":[1,3,6,8],"shared_insight":[{"id":"2","message":"Msg 1"},{"id":"3","message":"Msg 2"},{"id":"4","message":"Msg 3"}], "platform_id": 1}
     */
    public function share_insight($params_arr=array())
    {
       
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        $shared_by_consumer_id = $userId;
        $CORException = new COREException();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        
        if(empty($aPostData[JSON_TAG_SHARE_WITH_CONSUMER_ID_STRING]) || empty($aPostData[JSON_TAG_SHARED_INSIGHT_STRING])) {
            $error_string = array("error" => true, "message" => "Error !!! Please provide the correct insight and member name.");
            $app->render($error_string);
        } else {
            $consumer_id_arr = $aPostData[JSON_TAG_SHARE_WITH_CONSUMER_ID_STRING];
            $insight_arr = $aPostData[JSON_TAG_SHARED_INSIGHT_STRING];
            $platform_id = $aPostData[JSON_TAG_PLATFORM_ID];
        }
                
        if($userId){            
            $group=   $GenMethods->getUserGroup($userId);
            $groupId =$group['fldid'];
        }else{
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_AUTH_ID,TOKEN_DOESNT_MATCH);;
            $app->render($aResult);
        }
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }

        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->share_insight($platform_id,$clientId,$groupId,$consumer_id_arr,$insight_arr,$shared_by_consumer_id );
        
        $app->render($aResult);
    }

    /*
     * API : /inbox/markAsRead
     * Method : put
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"inbox_ids":[1,2,3]}
     */
    public function mark_as_read()
    {
        /*
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
             
        if(empty($aPostData[JSON_TAG_INBOX_IDS]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please select the insights to mark as read.");
            $app->render($error_string);
        } else {
            $inbox_id_arr = $aPostData[JSON_TAG_INBOX_IDS];
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->mark_as_read($inbox_id_arr);
        
        $app->render($aResult);
        */
        $aResult      = array();
        $app          = \Slim\Slim::getInstance();
        $read = 1;
        $aResult    = $this->mark_inbox_insights_as($read);
        $app->render($aResult);
        return $aResult; 
        return $aResult;        
    }

    /*
     * API : /inbox/markAsUnRead
     * Method : put
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"inbox_ids":[1,2,3]}
     */
    public function mark_as_unread()
    {
        $aResult      = array();
        $app          = \Slim\Slim::getInstance();

        /*
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
             
        if(empty($aPostData[JSON_TAG_INBOX_IDS]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please select the insights to mark as un-read.");
            $app->render($error_string);
        } else {
            $inbox_id_arr = $aPostData[JSON_TAG_INBOX_IDS];
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->mark_as_unread($inbox_id_arr);
        */
        $read = 0;
        $aResult    = $this->mark_inbox_insights_as($read);
        $app->render($aResult);
        return $aResult; 
    }
    
    public function mark_inbox_insights_as($read=0)
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
             
        if(empty($aPostData[JSON_TAG_INBOX_IDS]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please select the insights to mark as un-read.");
            $app->render($error_string);
        } else {
            $inbox_id_arr = $aPostData[JSON_TAG_INBOX_IDS];
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        if($read===0) {
            $aResult    = $InboxModel->mark_as_unread($inbox_id_arr);

        } else {
            $aResult    = $InboxModel->mark_as_read($inbox_id_arr);

        }
        //$aResult    = $InboxModel->mark_as_unread($inbox_id_arr);
        
        return $aResult; 
    }

    /*
     * API : /inbox/deleteInboxInsight
     * Method : put
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"inbox_ids":[1,2,3]}
     */
    public function delete_inbox_insight($insightId_arr=array())
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
             
        if(empty($aPostData[JSON_TAG_INBOX_IDS]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please select the insights to mark as read.");
            $app->render($error_string);
        } else {
            $inbox_id_arr = $aPostData[JSON_TAG_INBOX_IDS];
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->delete_inbox_insight($inbox_id_arr);
        
        $app->render($aResult);
        return $aResult; 
    }
    /*
     * API : /inbox/sortInboxInsightAsc
     * Method : post
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"sort_by":"insight"}
     */    
    public function sort_inbox_insight_asc()
    {
        $aResult      = array();
        $app          = \Slim\Slim::getInstance();
        $sort_by_ascending_order = 1;
        $aResult    = $this->sort_inbox_insight_as($sort_by_ascending_order);
        $app->render($aResult);
        return $aResult;        
    }
    /*
     * API : /inbox/sortInboxInsightDesc
     * Method : post
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"sort_by":"date"}
     */    
    public function sort_inbox_insight_desc()
    {
        $aResult      = array();
        $app          = \Slim\Slim::getInstance();
        $sort_by_ascending_order = 0;
        $aResult    = $this->sort_inbox_insight_as($sort_by_ascending_order);
        $app->render($aResult);
        return $aResult;        
    }
    
    public function sort_inbox_insight_as($sort_by_ascending_order=0)
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        $shared_by_me = false;

        if(empty($aPostData[JSON_TAG_INBOX_INSIGHT_SORT_BY]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please provide the sort by field and order.");
            $app->render($error_string);
        } else {
            $sort_by_field_name = $aPostData[JSON_TAG_INBOX_INSIGHT_SORT_BY];
        }
        
        if($userId){
            $group=   $GenMethods->getUserGroup($userId);
            $groupId =$group['fldid'];
        }else{
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_AUTH_ID,TOKEN_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->list_inbox_data($clientId,$groupId,$userId,$shared_by_me,$sort_by_field_name,$sort_by_ascending_order);

        return $aResult; 
    }
    
    /*
     * API : /inbox/insightSharedByme
     * Method : get
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     */
    public function insight_shared_by_me() {
        $shared_by_me = true;
        $this->list_inbox_data($shared_by_me);
    }
    /*
     * API : /inbox/removeInsightSharedByme
     * Method : delete
     * Request Header : 
     *      Accept = Y29tcGFzc2l0ZXM=
     *      Authorization = 
     * Request Body : 
     *      {"inbox_ids":[1,2,3]}
     */
    public function remove_insight_shared_by_me() {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
             
        if(empty($aPostData[JSON_TAG_INBOX_IDS]) ) {
            $error_string = array("error" => true, "message" => "Error !!! Please select the insights to delete.");
            $app->render($error_string);
        } else {
            $inbox_id_arr = $aPostData[JSON_TAG_INBOX_IDS];
        }
        
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }
        
        $InboxModel = new COREInboxModel();
        $aResult    = $InboxModel->remove_insight_shared_by_me($inbox_id_arr);
        
        $app->render($aResult);
        return $aResult; 
    }
}

?>