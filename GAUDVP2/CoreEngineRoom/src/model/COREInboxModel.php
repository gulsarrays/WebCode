<?php

/*
  Project                     : Oriole
  Module                      : Insight
  File name                   : COREInboxModel.php
  Description                 : Model class for Inbox related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Compassites.
  History                     :
 */

/**
 * Class COREInboxModel
 */
class COREInboxModel
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
    public function search_members($clientId,$groupId,$searchString=null)
    {
        $aResult    = array();
        $ConsumerDB = new COREConsumerDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $ConsumerDB->get_member_list($ConnBean,$clientId,$groupId,$searchString);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function share_insight($platformId,$clientId,$groupId,$consumerIdArr,$insightArr,$shared_by_consumer_id)
    {    
        $aResult    = array();
        $ConsumerDB = new COREConsumerDB();
        $ConnBean   = new COREDbManager();
        $inboxDM = new COREInboxDB();
        try
        {
            foreach($consumerIdArr as $consumerId) {
                $userData = $ConsumerDB->getConsumer($ConnBean,$consumerId);            
                if($userData['client_id'] === $clientId && $userData['group_id'] === $groupId) {
                    foreach($insightArr as $insightData) {
                        $insightId = $insightData['id'];
                        $insightMessage = $insightData['message'];
                        $aResult = $inboxDM->insertInboxInsight($ConnBean, $platformId, $consumerId, $insightId, $insightMessage, $shared_by_consumer_id, 0);
                    }
                }
            }
            
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function list_inbox_data($clientId,$groupId,$consumerId,$shared_by_me=false,$sort_by_field_name=null,$sort_by_ascending_order=0)
    {        

        $aResult    = array();
        $inboxDM = new COREInboxDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $inboxDM->list_inbox_data($ConnBean,$clientId,$groupId,$consumerId,$shared_by_me,$sort_by_field_name,$sort_by_ascending_order);

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
    
    public function mark_as_read($inbox_id_arr) {
         $aResult    = array();
        $inboxDM = new COREInboxDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $inboxDM->mark_as_read($ConnBean,$inbox_id_arr);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function mark_as_unread($inbox_id_arr) {
        $aResult    = array();
        $inboxDM = new COREInboxDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $inboxDM->mark_as_unread($ConnBean,$inbox_id_arr);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    /**
     * Function used to delete insight.
     *
     * @param $insightid
     *
     * @return int
     */
    public function delete_inbox_insight($inbox_id_arr) {
        $aResult    = array();
        $inboxDM = new COREInboxDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $inboxDM->delete_inbox_insight($ConnBean,$inbox_id_arr);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    public function remove_insight_shared_by_me($inbox_id_arr) {
        $aResult    = array();
        $inboxDM = new COREInboxDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $inboxDM->remove_insight_shared_by_me($ConnBean,$inbox_id_arr);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }

    
}

?>
