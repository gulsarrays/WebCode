<?php

/*
  Project                     : Oriole
  Module                      : Insight
  File name                   : COREInsightModel.php
  Description                 : Model class for Insight related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREInsightModel
 */
class COREInsightModel
{

    /**
     *
     */
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
        $aResult    = array();
        $ConsumerDB = new COREInsightDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->all_insights($ConnBean,$clientId);
            if(isset($aList[JSON_TAG_RECORDS]))
            {
                $aResult[JSON_TAG_TYPE]     = JSON_TAG_INSIGHTS;
                $aResult[JSON_TAG_COUNT]    = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_INSIGHTS] = $aList[JSON_TAG_RECORDS];
            }
            else
            {
                $iStatus          = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
                $sErrDescription  = SERVER_EXCEPTION_GET_INSIGHTS;
                $aResult['error'] = $sErrDescription;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to get all insight details.
     *
     * @return array
     */
    public function insights($clientId=null)
    {
        $aResult    = array();
        $ConsumerDB = new COREInsightDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->insights($ConnBean,$clientId);
            if(isset($aList[JSON_TAG_RECORDS]))
            {
                $aResult[JSON_TAG_TYPE]     = JSON_TAG_INSIGHTS;
                $aResult[JSON_TAG_COUNT]    = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_INSIGHTS] = $aList[JSON_TAG_RECORDS];
            }
            else
            {
                $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
                $sErrDescription = SERVER_EXCEPTION_GET_INSIGHTS;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to create new insight.
     *
     * @param $insightData
     *
     * @return array
     */
    public function createInsight($insightData,$clientId)
    {
        $ConnBean  = new COREDbManager();
        $insightDM = new COREInsightDB();
        try
        {
            $insight_name = $insightData["title"];
            $topic_id     = $insightData["topic_ids"];
            $expert_id    = $insightData["expert_id"];
            $group_id     = $insightData["group_id"];
            $playlist_id  = $insightData["playlist_id"];
            $rating       = $insightData[JSON_TAG_RATING];
            $sFbDesc      = $insightData[JSON_TAG_FBSHARE_DESC];
            $bResult = $insightDM->insertInsight($ConnBean, $insight_name, $topic_id, $expert_id, $rating,$sFbDesc,$clientId,$group_id,$playlist_id);
        }
        catch(Exception $e)
        {
            $bResult[JSON_TAG_STATUS] = 1;
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to delete insight.
     *
     * @param $insightid
     *
     * @return int
     */
    public function deleteInsight($insightid)
    {

        $InsightDB = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $aList = $InsightDB->deleteInsight($insightid, $ConnBean);
            if($aList == 0)
            {
                $iStatus         = ERRCODE_SERVER_EXCEPTION_DEL_TOPIC;
                $sErrDescription = SERVER_EXCEPTION_DEL_TOPIC;
                $aResult         = 0;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = 1;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $insightData
     * @param $insightid
     *
     * @return array
     */
    public function edit_insight($insightData, $insightid)
    {
        $ConnBean  = new COREDbManager();
        $insightDM = new COREInsightDB();
        try
        {
            $insight_name = $insightData["title"];
            $topic_id     = $insightData["topic_ids"];
            $expert_id    = $insightData["expert_id"];
            $playlist_id  = $insightData["playlist_id"];
            $insight_id   = $insightData["id"];
            $sFbsharedesc = $insightData[JSON_TAG_FBSHARE_DESC];
            $rating       = $insightData[JSON_TAG_RATING];
            $bResult      = $insightDM->edit_insight($ConnBean, $insight_name, $topic_id, $expert_id, $insightid, $rating,$sFbsharedesc,$playlist_id);
            $ConnBean     = NULL;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $bResult;
    }

    /**
     * Function used to  update  insight's streaming url  data in the  database.
     *
     * @param $insightid
     * @param $streamingURL
     * @param $uploaddir
     * @param $insightplaytime
     *
     * @return bool
     */
    public function update_insight_streamingURL($insightid, $streamingURL, $uploaddir, $insightplaytime)
    {
        $bResult   = false;
        $insightDM = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $insightDM->patchStreamingURL($ConnBean, $insightid, $streamingURL, $uploaddir, $insightplaytime);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function to list individual insight details.
     *
     * @param $insightid
     *
     * @return array
     */
    public function list_insight_by_id($insightid)
    {
        $iStatus   = 0;
        $ConnBean  = new COREDbManager();
        $insightDB = new COREInsightDB();
        $aList     = $insightDB->list_insight_by_id($ConnBean, $insightid);
        if($aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
            $sErrDescription = GET_INSIGHT_ERROR;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
                $sErrDescription = GET_INSIGHT_ERROR;
            }
        }

        if($aList[JSON_TAG_STATUS] == 0)
        {

            foreach($aList[JSON_TAG_RECORDS] as $value)
            {
                $aResult[] = $value;
            }
        }

        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => $iStatus,
                JSON_TAG_DESC => $sErrDescription,
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to  get  insight's streaming url  from  database.
     *
     * @param $insightid
     *
     * @return array
     */
    public function getStreamingUrl($insightid)
    {

        $aResult   = array();
        $insightDB = new COREInsightDB();
        try
        {
            $aList = $insightDB->getStreamingUrl($insightid);
            if($aList[JSON_TAG_STATUS] == 2 || $aList[JSON_TAG_STATUS] == SERVER_ERRORCODE_INVALID_INSIGHT || $aList[JSON_TAG_STATUS] == 1)
            {
                $iStatus         = ERROR_CODE_INVALID_INSIGHT_ID;
                $sErrDescription = INVALID_INSIGHT_ID;;
            }
            else
            {

                foreach($aList[JSON_TAG_RECORDS] as $value)
                {
                    $aResult[] = $value;
                }
            }

            if($aList[JSON_TAG_STATUS] != 0)
            {
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    JSON_TAG_CODE   => $iStatus,
                    JSON_TAG_DESC   => $sErrDescription,
                    JSON_TAG_ERRORS => array()
                );
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $aResult;
    }

    /**
     * Function used to  makes the insight online.
     *
     * @param $insight_id
     *
     * @return array
     */
    public function onlineInsight($insight_id)
    {

        $ConnBean  = new COREDbManager();
        $insightDM = new COREInsightDB();
        $bResult   = $insightDM->onlineInsight($ConnBean, $insight_id);
        $ConnBean  = null;

        return $bResult;
    }

    /**
     *  Function used to  make an insight liked by user.
     *
     * @param $aPostData
     * @param $consumerId
     *
     * @return array
     */
    public function insight_like($aPostData, $consumerId)
    {
        $ConnBean  = new COREDbManager();
        $aResult   = array();
        $GenMethods   = new COREGeneralMethods();
        $insightId = $aPostData[JSON_TAG_INSIGHT_ID];
        $insightDB = new COREInsightDB();
        try
        {
            $ConnBean->beginTransaction();
            $iResult = $insightDB->insight_like($ConnBean, $insightId, $consumerId);
            if($iResult[JSON_TAG_STATUS] == 0)
            {
                $ConnBean->commit();
            }
            else
            {
                $ConnBean->rollback();
            }
        }
        catch(Exception $ex)
        {
            $ConnBean->rollback();
        }

        if($iResult[JSON_TAG_STATUS] == ERROR_CODE_INSIGHT_NOT_AVAILABLE)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => ERROR_CODE_INSIGHT_NOT_AVAILABLE,
                JSON_TAG_DESC => JSON_TAG_INSIGHT_NOT_AVAILABLE,
            );
        }
        else
        {
            if($iResult[JSON_TAG_STATUS] == ERRCODE_INVALID_CONSUMER)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => ERRCODE_INVALID_CONSUMER,
                    JSON_TAG_DESC => INVALID_CONSUMER_ID,
                );
            }
            else if($iResult[JSON_TAG_STATUS] == ERRCODE_INVALID_CLIENT_ID)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => ERRCODE_INVALID_CLIENT_ID,
                    JSON_TAG_DESC => CLIENT_ID_DOESNT_MATCH,
                );
            }
            else
            {
                if($iResult[JSON_TAG_STATUS] == ERROR_CODE_INSIGHT_INSERT_FAIL)
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_CODE => ERROR_CODE_INSIGHT_INSERT_FAIL,
                        JSON_TAG_DESC => JSON_TAG_INSIGHT_INSERT_FAIL,
                    );
                }
                else
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
                }
            }
        }

        return $aResult;
    }

    /**
     * Function used to  make an insight unliked by user.
     *
     * @param $consumerId
     * @param $insightId
     *
     * @return array
     */
    public function insight_unlike($consumerId, $insightId)
    {
        $ConnBean  = new COREDbManager();
        $insightDB = new COREInsightDB();
        $iResult   = $insightDB->insight_unlike($consumerId, $insightId, $ConnBean);
        if($iResult[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($iResult[JSON_TAG_STATUS] == ERROR_CODE_INSIGHT_NOT_DELETED)
            {
                $iStatus         = ERROR_CODE_INSIGHT_NOT_DELETED;
                $sErrDescription = JSON_TAG_INSIGHT_DELETE_FAIL;
            }
        }
        if($iResult[JSON_TAG_STATUS] == ERRCODE_NO_ERROR)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS,
            );
        }
        if($iResult[JSON_TAG_STATUS] !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }
        /**
     * Function used to  get liked insights of a particular  user.
     *
     * @param $consumerId
     *
     * @return array
     */
    public function insight_likes_list($consumerId, $clientId)
    {
        $ConnBean  = new COREDbManager();
        $insightDB = new COREInsightDB();
        $consumerDB = new COREConsumerDB();
        
        $iResult =array();
        
        $iResult   = $insightDB->insight_likes_list($consumerId,$clientId, $ConnBean);
        if($iResult[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($iResult[JSON_TAG_STATUS] == ERROR_CODE_INSIGHT_NOT_AVAILABLE)
            {
                $iStatus         = ERROR_CODE_INSIGHT_NOT_AVAILABLE;
                $sErrDescription = JSON_TAG_INSIGHT_NOT_AVAILABLE;
            }
            else
            {
                $aResult[JSON_TAG_TYPE]        = JSON_TAG_LIKES;
                $aResult[JSON_TAG_CONSUMER_ID] = intval($iResult[JSON_TAG_CONSUMER_ID]);
                foreach($iResult[JSON_TAG_RECORDS] as $insight)
                {
                    $aResult[JSON_TAG_INSIGHT_IDS][] = intval($insight);
                }
            }
        }
       
         if($iResult[JSON_TAG_STATUS] !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        return $aResult;
    }

    /**
     * Function used to  get liked insights of a particular  user.
     *
     * @param $consumerId
     *
     * @return array
     */
    public function get_insight_likes_list($consumerId, $clientId, $page_no=1,$pegination=true)
    {
        $ConnBean  = new COREDbManager();
        $insightDB = new COREInsightDB();
        $consumerDB = new COREConsumerDB();

        $aResult =array();
        $iResult =array();
        
        $iResult   = $insightDB->get_insight_likes_list($consumerId,$clientId, $ConnBean,$page_no,$pegination);
        if($iResult[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($iResult[JSON_TAG_STATUS] == ERROR_CODE_INSIGHT_NOT_AVAILABLE)
            {
                $iStatus         = ERROR_CODE_INSIGHT_NOT_AVAILABLE;
                $sErrDescription = JSON_TAG_INSIGHT_NOT_AVAILABLE;
            }
            else
            {
                $aResult1[JSON_TAG_TYPE]        = JSON_TAG_LIKES;
                $aResult1[JSON_TAG_CONSUMER_ID] = intval($consumerId);
                $aResult        = array_merge($aResult1,$iResult);
            }
        }
       
         if($iResult[JSON_TAG_STATUS] !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        return $aResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    public function recommended_insight($mode, $experts, $topics, $consumer_id,$clientId,$groupId,$page_no,$pegination,$selected_insights)
    {

        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_insight_newcode($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$groupId,$page_no,$pegination,$selected_insights);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$groupId,$page_no);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$groupId,$page_no);
        }
       

        return $aRecommendations;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //modified code for recommended mode
    public function recommended_insight_newcode($mode, $experts, $topics, $consumer_id)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_insight_newcode_time($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }

        return $aRecommendations;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //consumeranalytics table split into 3 tables
    public function recommended_latestcode($mode, $experts, $topics, $consumer_id)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_mode($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }

        return $aRecommendations;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //excluding streaming url and streaming_url_hlsv4
    public function recommended_insight_withouturls($mode, $experts, $topics, $consumer_id)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_insight($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis_withouturls($ConnBean, $mode, $experts, $topics, $consumer_id);
        }

        return $aRecommendations;
    }

    /**
     * Function to list all recommended insights using redis caching.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    // Redis implementation
    public function recommended_insight_redis($mode, $experts, $topics, $consumer_id)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_insight_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id);
        }

        return $aRecommendations;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    // cached topicIds for insights
    public function recommended_insight_redis_topicIds($mode, $experts, $topics, $consumer_id)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        if($mode == 1)
        {
            $aRecommendations = $insightsDB->recommended_insight_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        elseif($mode == 2)
        {
            $aRecommendations = $insightsDB->newest_mode_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id);
        }
        else
        {
            $aRecommendations = $insightsDB->popular_mode_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id);
        }

        return $aRecommendations;
    }

    /**
     * Function to update voiceover url.
     *
     * @param $insight_id
     * @param $fileName
     */
    public function patch_insight_voiceover_url($insight_id, $fileName)
    {
        $ConnBean  = new COREDbManager();
        $insightDM = new COREInsightDB();
        try
        {
            $bResult = $insightDM->patch_insight_voiceover_url($ConnBean, $insight_id, $fileName);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;
    }

    /**
     * Function to Get the details of an insight to share in Social media .
     *
     * @param $insight_id
     */
    public function get_socialmedia_share_details($iInsight_id)
    {
        $InsightDB = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $aData = $InsightDB->get_socialmedia_share_details($ConnBean, $iInsight_id);
            if($aData[JSON_TAG_STATUS] == SERVER_ERRCODE_EXCEPTION)
            {
                $aData[JSON_TAG_TYPE]  = JSON_TAG_ERROR;
                $aData[JSON_TAG_ERROR] = SERVER_EXCEPTION_GET_INSIGHT;
            }
            else
            {
                $aData[JSON_TAG_SECURE_STREAMING_URL] = preg_replace("/^http:/i", "https:", $aData[JSON_TAG_STREAMINGURL]);

                $aData[JSON_TAG_FBSHARE_TITLE]  =  $aData[JSON_TAG_TITLE] . ' by '. $aData[JSON_TAG_EXPERT_NAME];
                
                //FIXME: This is a momentory patch as requested by Audvisor team to avoid putting description to every insight.
                $aData[JSON_TAG_FBSHARE_DESC] = "Download Audvisor for free to hear more from ". $aData[JSON_TAG_EXPERT_NAME]. ".";                
            }
        }
        catch(Exception $e)
        {
            $aData[JSON_TAG_TYPE]  = JSON_TAG_ERROR;
            $aData[JSON_TAG_ERROR] = SERVER_EXCEPTION_GET_INSIGHT;
        }
        $ConnBean = null;

        return $aData;
    }

    public function update_insight_short_url($awsbridge)
    {
        $bResult   = false;
        $insightDM = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $insightDM->updateInsightShortUrl($ConnBean,$awsbridge);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }
    public function getRedirect3Url($short_code,$awsbridge) {
        $bResult   = false;
        $insightDM = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $bResult = $insightDM->getRedirect3Url($ConnBean,$short_code,$awsbridge);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }
    public function getRedirect4Url($short_code,$awsbridge) {
        $bResult   = false;
        $insightDM = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $bResult = $insightDM->getRedirect4Url($ConnBean,$short_code,$awsbridge);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }
    public function disEngageActiveUser($insightId) {
        $bResult   = false;
        $insightDM = new COREInsightDB();
        $ConnBean  = new COREDbManager();
        try
        {
            $bResult = $insightDM->disEngageActiveUser($ConnBean,$insightId);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }
    
    public function getTrendingInsights($clientId,$page_no)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        $aRecommendations = $insightsDB->getTrendingInsights($ConnBean,$clientId,$page_no);
        return $aRecommendations;
    }
    
        /**
     * Function used to  makes the insight as featured.
     *
     * @param $insight_id
     *
     * @return array
     */
    public function toggleFeaturedInsight($insight_id)
    {

        $ConnBean  = new COREDbManager();
        $insightDM = new COREInsightDB();
        $bResult   = $insightDM->toggleFeaturedInsight($ConnBean, $insight_id);
        $ConnBean  = null;

        return $bResult;
    }
    
    
    public function getFeaturedInsights($clientId,$page_no)
    {
        $ConnBean   = new COREDbManager();
        $insightsDB = new COREInsightDB();
        $aRecommendations = $insightsDB->getFeaturedInsights($ConnBean,$clientId,$page_no);
        return $aRecommendations;
    }
    
    public function list_insight_by_ids($insightids_arr=array())
    {
        $iStatus   = 0;
        $ConnBean  = new COREDbManager();
        $insightDB = new COREInsightDB();
        $aList     = $insightDB->list_insight_by_ids($ConnBean, $insightids_arr);
        if($aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
            $sErrDescription = GET_INSIGHT_ERROR;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_INSIGHT;
                $sErrDescription = GET_INSIGHT_ERROR;
            }
        }

        if($aList[JSON_TAG_STATUS] == 0)
        {

            foreach($aList[JSON_TAG_RECORDS] as $value)
            {
                $aResult[] = $value;
            }
        }

        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => $iStatus,
                JSON_TAG_DESC => $sErrDescription,
            );
        }
        $ConnBean = null;

        return $aResult;
    }
    
}


?>
