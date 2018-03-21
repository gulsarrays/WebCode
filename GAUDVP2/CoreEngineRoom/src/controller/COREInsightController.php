<?php

/*
  Project                     : Oriole
  Module                      : Insight
  File name                   : COREEInsightController.php
  Description                 : Controller class for insight related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREInsightController
{

    public function __construct()
    {
    }

    /**
     * Function used to get all insight details for cms.
     *
     * @return array
     */
    public function all_insights($clientId)
    {
        $insightModel = new COREInsightModel();
        $aResult      = $insightModel->all_insights($clientId);

        return $aResult;
    }

    /**
     *  Function used to get all insight details along with topic ids experts idetails for renderingeditinsight.php'.
     */
    public function viewInsights()
    {
       try{         
            $Request          = \Slim\Slim::getInstance();
            $clientId = $_SESSION[CLIENT_ID];
            $InsightModel     = new COREInsightController();
            $TopicModel       = new CORETopicController();
            $aResult["Data1"] = $TopicModel->all_topics($clientId);
            $ExpertnModel     = new COREExpertController();
            $aResult["Data2"] = $ExpertnModel->all_Experts($clientId);
            
            $playlistControl     = new COREPlayListController();
            $aResult["playlists"] = $playlistControl->get_all_play_lists();
            
//            echo '<pre>'; print_r($aResult); exit;
            if(isset($_SESSION[APP_SESSION_NAME]))
            {

                $Request->render('COREInsightList.php', $aResult);
            }
            else
            {
                $aResult["Data"][JSON_TAG_ERROR] = "";
                $Request->render('CORECmsLogin.php', $aResult);
            }
       } catch (Exception $e){
            echo $e->getMessage();
       }
    }
    
    /**
     *  Function used to get all insight details along with topic ids experts idetails for renderingeditinsight_new.php'.
     */
    public function viewInsights_new()
    {
       try{         
            $Request          = \Slim\Slim::getInstance();
            $clientId = $_SESSION[CLIENT_ID];
            $InsightModel     = new COREInsightController();
            $TopicModel       = new CORETopicController();
            $aResult["Data1"] = $TopicModel->all_topics($clientId);
            $ExpertnModel     = new COREExpertController();
            $aResult["Data2"] = $ExpertnModel->all_Experts($clientId);
            
            $playlistControl     = new COREPlayListController();
            $aResult["playlists"] = $playlistControl->get_all_play_lists();
            
//            echo '<pre>'; print_r($aResult); exit;
            if(isset($_SESSION[APP_SESSION_NAME]))
            {

                $Request->render('COREInsightList_new.php', $aResult);
            }
            else
            {
                $aResult["Data"][JSON_TAG_ERROR] = "";
                $Request->render('CORECmsLogin.php', $aResult);
            }
       } catch (Exception $e){
            echo $e->getMessage();
       }
    }

    /**
     *  Function used to create new insight.
     */
    public function addInsight()
    {
        $InsightModel   = new COREInsightModel();
        $Generalmethods = new COREGeneralMethods();
        $app            = \Slim\Slim::getInstance();
        $Request        = $app->request();
        $BodyData       = $Request->getBody();
        $aInsightData   = $Generalmethods->decodeJson($BodyData, true);
        $clientId = $_SESSION[CLIENT_ID];
        $aResult        = $InsightModel->createInsight($aInsightData,$clientId);
        $app->render($aResult);
    }

    /**
     * Function used to delete insight data from database.
     *
     * @param $insightid
     */
    public function deleteInsight($insightid)
    {

        $app          = \Slim\Slim::getInstance();
        $insightModel = new COREInsightModel();
        $aResult      = $insightModel->deleteInsight($insightid);
        $app->render($aResult);
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $insightid
     */
    public function edit_insight($insightid)
    {

        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $JSONPostData  = $Request->getBody();
        $aPostData     = $Generalmethod->decodeJson($JSONPostData, true);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {

            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        $InsightModel = new COREInsightModel();
        $aResult      = $InsightModel->edit_insight($aPostData, $insightid);

        $app->render($aResult);
    }

    /**
     * Function used to get all insight details.
     *
     * @return mixed
     */
    public function insights()
    {
        $app          = \Slim\Slim::getInstance();
        $insightModel = new COREInsightModel();

        $GenMethods   = new COREGeneralMethods();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);


        $aResult      = $insightModel->insights($clientId);
        $bResult      = $aResult[JSON_TAG_INSIGHTS];
        $app->render($bResult);

        return $bResult;
    }

    /**
     * Function used to upload insight audio file to server.
     *
     * @param $insightid
     */
    public function upload_insight_audio($insightid)
    {               
        $tmp_insight_id = $insightid;
        $client_id = $_SESSION[CLIENT_ID];
        $app     = \Slim\Slim::getInstance();
        $aResult = array();
        if(isset($_FILES['insight']['name']) && !empty($_FILES['insight']['name']))
        {
            $createddate      = date("YmdHis");
            $sFileinfo        = new SplFileInfo($_FILES['insight']['name']);
            $sFile_Extension  = $sFileinfo->getExtension();
            $sFile_name       = $sFileinfo->getBasename(".".$sFile_Extension);
            $uploadedFileName = trim(preg_replace('#\W+#', "", $sFile_name), '_');

            $insight_id = sprintf("%05d", $insightid);
            $fileName   = $insight_id."_".$createddate."_".$uploadedFileName.".".$sFile_Extension;
//            $fileName   = '02922_20170508051102_1_Building_a_Successful_Network.mp3';
           
            $insightsFolder = dirname(__FILE__).'/../../../workspace/insights';
            if(!file_exists($insightsFolder))
            {
                mkdir($insightsFolder, 0777, true);
            }
            //chmod($insightsFolder, 0777);
            $uploaddir = $insightsFolder.'/'.$fileName;
            move_uploaded_file($_FILES['insight']['tmp_name'], $uploaddir);

            /*get playtime here*/
            $mediaInfo          = new Mhor\MediaInfo\MediaInfo();
            $mediaInfoContainer = $mediaInfo->getInfo($uploaddir);
            $general            = $mediaInfoContainer->getGeneral();
            $duration           = $general->get('duration');
            $insightplaytime    = $duration->getMilliseconds();
            if($insightplaytime > 9000)
            {
                $awsbridge = new COREAwsBridge();

                //k Upload the insight to S3
                $awsbridge->UploadInsightToS3($uploaddir, $fileName,$client_id);

                //k Generate HLS steaming content
                $transcoderJob     = $awsbridge->PrepareInsightForHLS($fileName);
                $s3StreamingPath   = $awsbridge->GetHLSPlaylistURLForJob($transcoderJob,$client_id);
                $s3TranscodedPaths = $awsbridge->GetHLSPlaylistsForJob($transcoderJob);

                $s3TranscodedPaths["legacy"] = $s3StreamingPath;

                $short_code = $this->generate_short_url($tmp_insight_id);

                if(!empty($short_code)) {
                    $streamingUrl_short = $short_code['streamingUrl_short'];
                    $streamingFileNamehlsv4_short = $short_code['streamingFileNamehlsv4_short'];

                    //encrypt the url
                    $encrypt = new Aes();
                    $streamingUrl_short_enc = trim($encrypt->encode($streamingUrl_short));
                    $streamingFileNamehlsv4_short_enc = trim($encrypt->encode($streamingFileNamehlsv4_short));
                } else {
                    $streamingUrl_short = null;
                    $streamingFileNamehlsv4_short = null;
                    $streamingUrl_short_enc = null;
                    $streamingFileNamehlsv4_short_enc = null;
                }

                $s3TranscodedPaths['HLSv3_enc'] = $streamingUrl_short_enc;
                $s3TranscodedPaths['HLSv4_enc'] = $streamingFileNamehlsv4_short_enc;
                $s3TranscodedPaths['HLSv3_short_code'] = $streamingUrl_short;
                $s3TranscodedPaths['HLSv4_short_code'] = $streamingFileNamehlsv4_short;

                //k Get the master playlist file from $transcoderJob and store it in Db.
                $insightModel = new COREInsightModel();
//                $insightModel->update_insight_streamingURL($insightid, $s3TranscodedPaths, $client_id."/".$fileName, $insightplaytime);
                $insightModel->update_insight_streamingURL($insightid, $s3TranscodedPaths, $fileName, $insightplaytime);

                //k Delete the local file.
                unlink($uploaddir);

                $aResult['transcoderJob'] = $transcoderJob;
                $aResult['s3Path']        = $s3TranscodedPaths;
                $aResult['insightid']     = $insightid;
            }
            else
            {
                $aResult = array(JSON_TAG_CODE => ERROR_CODE_INSIGHT_INSERT_FAIL);
            }
        }
        else
        {
            $aResult = array(JSON_TAG_CODE => INSIGHT_UPLOAD_FAIL);
        }
        $app->render($aResult);
    }

    /**
     * Function to get streaming URL.
     *
     * @param $insightid
     */
    public function getStreamingUrl($insightid)
    {   
        $app          = \Slim\Slim::getInstance();
        if(isset($_SESSION[CLIENT_ID])){
            $clientId = $_SESSION[CLIENT_ID];
//            $encodedClientId  = $CORERequest->getHeaderAcceptParam($clientId,$insightid);
            if (!$clientId) {
                $CORException = new COREException();
                $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
                $app->render($aResult);
            }
        }else{
                $CORERequest  = new CORERequest();
                $GenMethods   = new COREGeneralMethods();
                $Request      = $app->request();
                $JSONHeaderData =  $Request->headers;
                $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
                $clientId         = $GenMethods->decodeClientId($encodedClientId);     
                if(!$clientId){
                    $CORException = new COREException();
                    $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
                    $app->render($aResult);            
                }
        }
        $app          = \Slim\Slim::getInstance();
        $insightModel = new COREInsightModel();
        $aResult      = $insightModel->getStreamingUrl($insightid);
        $app->render($aResult);
    }

    /**
     * Function used to  make an insight online.
     *
     * @param $insight_id
     */
    public function onlineInsight($insight_id)
    {
        $InsightModel = new COREInsightModel();
        $app          = \Slim\Slim::getInstance();
        $aResult      = $InsightModel->onlineInsight($insight_id);
        $app->render($aResult);
    }

    /**
     * Function to list individual insight details.
     *
     * @param $insightid
     */
    public function list_insight_by_id($insightid)
    {
        $aResult      = array();
//        $AppAuthorization   = new COREAppAuthorizationController();
//        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
//        if(!empty($AppAuthorizationDetails)) {
            $app          = \Slim\Slim::getInstance();
            $InsightModel = new COREInsightModel();
            $aResult      = $InsightModel->list_insight_by_id($insightid);
        //}
        $app->render($aResult);
    }

    /**
     * Function used to  make an insight liked by user.
     *
     * @param $consumerId
     */
    public function insight_like($consumerId)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateClientID($clientId);
        if (!$clientId || !$validateConsumer) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }        
        $aPostData    = $GenMethods->decodeJson($JSONPostData);

        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = 'Invalid JSON data';
        }
        else
        {
            $insightmodel = new COREInsightModel();
            if(isset($aPostData[JSON_TAG_INSIGHT_ID]) && isset($aPostData[JSON_TAG_INSIGHT_ID]))
            { 
                $aResult = $insightmodel->insight_like($aPostData, $consumerId);
            }
            else
            {
                $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
                $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
                $aResult[JSON_TAG_DESC] = 'Invalid JSON data';
            }
        }

        $app->render($aResult);
    }

    /**
     * Function used to  make an insight unliked by user.
     *
     * @param $consumerid
     * @param $insightid
     */
    public function insight_unlike($consumerid, $insightid)
    {
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $CORERequest = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $GenMethods =  new COREGeneralMethods();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $validateConsumer = $COREConsumerDB->validateClientID($clientId);
        if (!$clientId || !$validateConsumer) {
            $CORException = new COREException();
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }
        $insightmodel = new COREInsightModel();
        $aResult      = $insightmodel->insight_unlike($consumerid, $insightid);

        $app->render($aResult);
    }
        /**
     * Function used to  show liked insight list.
     *
     * @param $consumerId
     */
    public function insight_likes_list($consumerId)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $CORERequest = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $validateConsumer = $COREConsumerDB->validateClientID($clientId);
//        echo $clientId; exit;
        if (!$clientId) {
            $CORException = new COREException();
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }
        $insightmodel = new COREInsightModel();
        $aResult      = $insightmodel->insight_likes_list($consumerId,$clientId);

        $app->render($aResult);
    }

    /*
     * API : /consumers/getinsightlikes
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     * {"page_no": 1, "pegination":true} page no optional
     */
    public function get_insight_likes_list()
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
            
            $insightmodel = new COREInsightModel();
            $userId = $AppAuthorizationDetails['userId'];
            $clientUserId = $AppAuthorizationDetails['clientUserId'];
            $clientId = $AppAuthorizationDetails['clientId'];
            $clientUserId .= ','.$AppAuthorizationDetails['audvisorClientUserId'];
            
            
            $aResult      = $insightmodel->get_insight_likes_list($userId,$clientId,$page_no,$pegination);
            $app->render($aResult);
            
        } 

    }

    /**
     *  Function to list all recommended insights.
     */
     /**
     * Function to list individual insight details.
     *
     * API : /insights/recommendations/
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request : {   "consumer_id": "30833",
                     "expert_ids" :[],
                     "mode" : 1, // No use
                     "topic_ids" :[50],
                     "page_no":1,
                     "pegination":true,
                     "selected_insights_arr":[630,730,2291]
                }
    * 
    */
    public function recommended_insight()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $consumerId   = $aPostData[JSON_TAG_CONSUMER_ID];
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        $CORException = new COREException();
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
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];
            $AppAuthorization   = new COREAppAuthorizationController();
            $AppAuthorization->check_subscription($userId);

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
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
            if(!empty($aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT]) && is_array($aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT]))
            {
                $selected_insights = $aPostData[JSON_TAG_SELECTED_INSIGHTS_TEXT];
            }
            else
            {
                $selected_insights = null;
            }            
                        
            $aResult = $insightModel->recommended_insight($mode, $experts, $topics, $consumer_id,$clientId,$groupId,$page_no,$pegination,$selected_insights);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     *  Function to list all recommended insights.
     */
    //modified code for recommended mode
    public function recommended_insight_newcode()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
            }

            $aResult = $insightModel->recommended_insight_newcode($mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     *  Function to list all recommended insights.
     */
    //consumeranalytics table spilt into 3 tables    
    public function recommended_latestcode()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
            }

            $aResult = $insightModel->recommended_latestcode($mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     *  Function to list all recommended insights using Redis cache.
     */
    //redis cache
    public function recommended_insight_redis()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
            }

            $aResult = $insightModel->recommended_insight_redis($mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     *  Function to list all recommended insights using Redis cache.
     */
    //cached topicIds for insights
    public function recommended_insight_redis_topicIds()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
            }

            $aResult = $insightModel->recommended_insight_redis_topicIds($mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     *  Function to list all recommended insights.
     */
    //excluding streaming url and streaming_url_hlsv4
    public function recommended_insight_withouturls()
    {
        $aResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(!empty($aPostData[JSON_TAG_CONSUMER_ID]))
        {
            $topics       = null;
            $experts      = null;
            $insightModel = new COREInsightModel();
            if(!empty($aPostData[JSON_TAG_MODE]))
            {
                $mode = $aPostData[JSON_TAG_MODE];
            }
            else
            {
                $mode = 1;
            }
            $consumer_id = $aPostData[JSON_TAG_CONSUMER_ID];

            if(!empty($aPostData[JSON_TAG_EXPERT_IDS]))
            {
                $experts = $aPostData[JSON_TAG_EXPERT_IDS];
            }
            elseif(!empty($aPostData[JSON_TAG_TOPIC_IDS]))
            {
                $topics = $aPostData[JSON_TAG_TOPIC_IDS];
            }

            $aResult = $insightModel->recommended_insight_withouturls($mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = SERVER_EXCEPTION_INVALID_CONSUMER;
        }
        $app->render($aResult);
    }

    /**
     * Function used to upload insight voice overaudio file to server.
     *
     * @param $insight_id
     */
    public function upload_insight_voiceover($insight_id)
    {
        $app         = \Slim\Slim::getInstance();
        $clientId = '';
        try
        {
            $ConnBean   = new COREDbManager();
            $sQuery = "SELECT *  FROM tblinsights WHERE fldid = :insight_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':insight_id', $insight_id);
            $result = $ConnBean->single();
            
            if(!empty($result)) {
                $clientId = $result['client_id'];
            }
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
        $createddate = date("YmdHis");
        if(isset($_FILES['insightvoiceover']['name']) && !empty($_FILES['insightvoiceover']['name']))
        {
            $sInsight_VoiceoverFolder = dirname(__FILE__).'/../../../workspace/insight-voiceover';
            if(!file_exists($sInsight_VoiceoverFolder))
            {

                mkdir($sInsight_VoiceoverFolder, 0777, true);
            }

            $fileName  = $insight_id.$createddate.$_FILES['insightvoiceover']['name'];
            $uploaddir = $sInsight_VoiceoverFolder.'/'.$fileName;
            move_uploaded_file($_FILES['insightvoiceover']['tmp_name'], $uploaddir);
        }
        else
        {
            $aResult = array(
                JSON_TAG_CODE => LOGO_UPLOAD_FAIL
            );
        }
        $s3Bridge = new COREAwsBridge();
        $s3Bridge->UploadInsightVoiceOver($uploaddir, $fileName, $clientId);
        //Delete the local file
        @unlink($uploaddir);
        $insightModel           = new COREInsightModel();
        $aResult[JSON_TAG_CODE] = $insightModel->patch_insight_voiceover_url($insight_id, $fileName);

        if($aResult[JSON_TAG_CODE] == SERVER_ERRCODE_EXCEPTION)
        {
            $aResult[JSON_TAG_CODE] = ERRCODE_INSIGHT_VOICEOVER_UPLOAD_FAILED;
        }
        $app->render($aResult);
    }

    /**
     * Function used to render the OG story when sharing an insight.
     *
     * @param $insight_id
     */
    public function opengraphSharePage($insight_id)
    {
        $App          = \Slim\Slim::getInstance();
        $InsightModel = new COREInsightModel();
        $aData        = $InsightModel->get_socialmedia_share_details($insight_id);

        $param_fb_action_ids   = $App->request->get('fb_action_ids');
        $param_fb_action_types = $App->request->get('fb_action_types');

        if(isset($param_fb_action_ids) || isset($param_fb_action_types))
        {
            //FIXME: This is a work-around as the Audvisor team do not want to have a insight specific page.
            $App->redirect('http://www.audvisor.com');
        }
        else
        {
            $aData[JSON_TAG_REQUEST_URL] = $App->request->getUrl().$App->request->getPath();
            $aData[JSON_TAG_DEEPLINK_QUERY_PARAMS] = "?insight_id=".$insight_id;

            if(SERVER_NOERROR != $aData[JSON_TAG_STATUS])
            {
                // Invalid Insight ID. Share something default?
                $App->redirect('http://www.audvisor.com');
            }
            else
            {
                $App->render("COREInsightShare.php", $aData);
            }
        }
    }
    public function update_insight_short_url() {
        $awsbridge = new COREAwsBridge();
        $insightModel = new COREInsightModel();
        $insightModel->update_insight_short_url($awsbridge);
    }

    public function generate_short_url($insight_id = null) {

        $short_code = array();

        $streamingUrl_short_id=rand(time()+10000,time()+99999);
        $streamingUrl_short=base_convert($streamingUrl_short_id,20,36);

        $streamingFileNamehlsv4_short_id=rand(time()+100000,time()+999999);
        $streamingFileNamehlsv4_short=base_convert($streamingFileNamehlsv4_short_id,20,36);

        $streamingUrl_short = substr_replace($streamingUrl_short, $insight_id, 4, 0);
        $streamingFileNamehlsv4_short = substr_replace($streamingFileNamehlsv4_short, $insight_id, 4, 0);

        $ConnBean   = new COREDbManager();
        $sQuery = "SELECT *  FROM tblinsights WHERE (fldstreamingfilename_enc = :streamingUrl_short OR fldstreamingfilenamehlsv4_enc = :streamingFileNamehlsv4_short)";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(':streamingUrl_short', $streamingUrl_short);
        $ConnBean->bind_param(':streamingFileNamehlsv4_short', $streamingFileNamehlsv4_short);
        $result = $ConnBean->single();
        if(!empty($result) || $streamingUrl_short === $streamingFileNamehlsv4_short) {
            $this->generate_short_url();
        } else {
            $short_code = array(
                'streamingUrl_short' => $streamingUrl_short,
                'streamingFileNamehlsv4_short' => $streamingFileNamehlsv4_short
                    );
        }

        return $short_code;
    }

    public function redirect3($short_code=NULL) {
        
        if(!empty($short_code)) {
            $awsbridge = new COREAwsBridge();
            $insightModel = new COREInsightModel();
            $url = $insightModel->getRedirect3Url($short_code,$awsbridge);
            if(!empty($url)) {
                //$url = str_replace("https://", "http://", $url);
//                echo $url;
                header("Location: $url");
                exit;
            } else{
                $aResult['error'] = "Url is incorrect!!";
            }
        }
        
        $app          = \Slim\Slim::getInstance();
        $app->render($aResult);
    }
    public function redirect4($short_code=NULL) {
        
        if(!empty($short_code)) {
            $awsbridge = new COREAwsBridge();
            $insightModel = new COREInsightModel();
            $url = $insightModel->getRedirect4Url($short_code,$awsbridge);
            if(!empty($url)) {
                //$url = str_replace("https://", "http://", $url);
//                echo $url;
                header("Location: $url");
                exit;
            } else{
                $aResult['error'] = "Url is incorrect!!";
            }
        }
        
        $app          = \Slim\Slim::getInstance();
        $app->render($aResult);
    }
    public function disengage_active_user($insight_id) {
        $app          = \Slim\Slim::getInstance();
        $insightModel = new COREInsightModel();
        $aResult = $insightModel->disEngageActiveUser($insight_id);
        $app->render($aResult);
    }
    
    /*
     *    API : /insights/trendingInsight/
     *    Method : POST
     *    Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *     Authorization = 
     */    
    public function getTrendingInsights() {
        
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
        $consumer_id = $userId;
        $CORException = new COREException();
        
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

        $topics       = null;
        $experts      = null;
        $insightModel = new COREInsightModel();
        
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorization->check_subscription($userId);

        if(!empty($aPostData[JSON_PAGE_NO]))
        {
            $page_no = $aPostData[JSON_PAGE_NO];
        }
        else
        {
            $page_no = 1;
        }

        $aResult = $insightModel->getTrendingInsights($clientId,$page_no);        
        
        $app->render($aResult);
    }
    
    
    /**
     * Function used to  make an insight as featured.
     *
     * @param $insight_id
     */
    public function toggleFeaturedInsight($insight_id)
    {
        $InsightModel = new COREInsightModel();
        $app          = \Slim\Slim::getInstance();
        $aResult      = $InsightModel->toggleFeaturedInsight($insight_id);
        $app->render($aResult);
    }
    
    
    /*
     *    API : /insights/featuredInsight/
     *    Method : POST
     *    Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *     Authorization = 
     */    
    public function getFeaturedInsights() {
        
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
        $consumer_id = $userId;
        $CORException = new COREException();
        
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

        $topics       = null;
        $experts      = null;
        $insightModel = new COREInsightModel();
                
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorization->check_subscription($userId);
        
        if(!empty($aPostData[JSON_PAGE_NO]))
        {
            $page_no = $aPostData[JSON_PAGE_NO];
        }
        else
        {
            $page_no = 1;
        }

        $aResult = $insightModel->getFeaturedInsights($clientId,$page_no);        
        
        $app->render($aResult);
    }
    
        /**
     * Function to list individual insight details.
     *
     * API : /insights/listinsightbyids/
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     */
    public function list_insight_by_ids()
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
            if(empty($aPostData[JSON_TAG_INSIGHT_IDS])) {
                $error_string = array("error" => true, "message" => "Error !!! Please select the insights.");
                $app->render($error_string);
            } else {
                $insightids_arr = $aPostData[JSON_TAG_INSIGHT_IDS];
            }            
            
            $InsightModel = new COREInsightModel();
            $aResult      = $InsightModel->list_insight_by_ids($insightids_arr);
        }
        $app->render($aResult);
    }
}

?>
