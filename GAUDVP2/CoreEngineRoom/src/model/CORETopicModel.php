<?php

/*
  Project                     : Oriole
  Module                      : Topic
  File name                   : CORETopicModel.php
  Description                 : Model class for Topic related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class CORETopicModel
 */
class CORETopicModel
{

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * Function used to get all topics details for cms.
     *
     * @return array
     */
    public function all_topics($clientId)
    {
        $ConnBean   = new COREDbManager();
        $aResult    = array();
        $ConsumerDB = new CORETopicDB();
        try
        {
            $aList = $ConsumerDB->all_topics($ConnBean,$clientId);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus          = ERRCODE_SERVER_EXCEPTION_GET_TOPIC;
                $sErrDescription  = SERVER_EXCEPTION_GET_TOPIC;
                $aResult['error'] = $sErrDescription;
            }
            else
            {
                $aResult[JSON_TAG_TYPE]   = JSON_TAG_TOPICS;
                $aResult[JSON_TAG_COUNT]  = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_TOPICS] = $aList[JSON_TAG_RECORDS];
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
     * Function used to get all topics details.
     *
     * @return array
     */
    public function list_all_topics($clientId)
    {
        
        $ConnBean   = new COREDbManager();
        $aResult    = array();
        $ConsumerDB = new CORETopicDB();
        try
        {
            $aList = $ConsumerDB->list_all_topics($ConnBean,$clientId);
            if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                $aResult[JSON_TAG_TYPE]   = JSON_TAG_TOPICS;
                $aResult[JSON_TAG_TOPICS] = $aList[JSON_TAG_RECORDS];
            }
            if($aList[JSON_TAG_STATUS] != ERRCODE_NO_ERROR)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => $iStatus,
                    JSON_TAG_DESC => $sErrDescription,
                );
            }
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to get details of a particulat topic .
     *
     * @param $topicid
     *
     * @return mixed
     */
    public function get_topicdetails($topicid)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new CORETopicDB();
        try
        {
            $aList = $ConsumerDB->get_topicdetails($topicid, $ConnBean);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus          = ERRCODE_SERVER_EXCEPTION_GET_TOPIC;
                $sErrDescription  = SERVER_EXCEPTION_GET_TOPIC;
                $aResult['error'] = $sErrDescription;
            }
            else
            {
                $aResult = $aList[JSON_TAG_RECORD];
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
     * Function used to create new topic.
     *
     * @param $TopictData
     *
     * @return array
     */
    public function createTopic($TopictData,$clientId)
    {
        $aResult  = array();
        $ConnBean = new COREDbManager();
        $topicDM  = new CORETopicDB();
        try
        {
            $topic_name = $TopictData["topic_name"];
            $bResult    = $topicDM->insertTopic($ConnBean, $topic_name,$clientId);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to  update  topic data in the  database.
     *
     * @param $topicData
     * @param $topicid
     *
     * @return array
     */
    public function edit_topic($topicData, $topicid)
    {
        $topicDM  = new CORETopicDB();
        $ConnBean = new COREDbManager();
        try
        {
            $topic_name = $topicData["topic_name"];
            $bResult    = $topicDM->edit_topic($ConnBean, $topic_name, $topicid);
            if($bResult[JSON_TAG_STATUS] == 1)
            {
                $bResult = array(JSON_TAG_STATUS => 0, JSON_TAG_TOPIC => $bResult['record']);
            }
            else
            {
                if($bResult[JSON_TAG_STATUS] == 2)
                {
                    $bResult = array(JSON_TAG_CODE => 320, JSON_TAG_STATUS => 2, JSON_TAG_TOPIC_NAME => $bResult['topicname']);
                }
                else
                {
                    if($bResult[JSON_TAG_STATUS] == 3)
                    {
                        $bResult = array(JSON_TAG_STATUS => 3);
                    }
                }
            }
            $ConnBean = NULL;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $bResult;
    }

    /**
     * Function used to delete Topic.
     *
     * @param $topicid
     *
     * @return array
     */
    public function deleteTopic($topicid)
    {
        $ConnBean = new COREDbManager();
        $aList    = array();
        $TopicDB  = new CORETopicDB();
        try
        {
            $aList = $TopicDB->deleteTopic($topicid, $ConnBean);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aList;
    }

    /**
     * Function used to  update  Topic image URL in the  database.
     *
     * @param $topic_id
     * @param $fileName
     *
     * @return bool
     */
    public function patch_avatar_url($topic_id, $fileName)
    {
        $ConnBean = new COREDbManager();
        $topicDM  = new CORETopicDB();
        try
        {
            $bResult = $topicDM->patch_avatar_url($ConnBean, $topic_id, $fileName);
        }
        catch(Exception $e)
        {
        }

        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to  update  Topic image URLs in the  database.
     *
     * @param $topic_id
     * @param $fileName
     *
     * @return bool
     */
    public function patch_avatar_urls($topic_id, $fileName)
    {
        $ConnBean = new COREDbManager();
        $topicDM  = new CORETopicDB();

        try
        {
            $bResult = $topicDM->patch_avatar_urls($ConnBean, $topic_id, $fileName);
        }
        catch(Exception $e)
        {
        }

        $ConnBean = null;

        return $bResult;
    }
}

?>