<?php

/*
  Project                     : Oriole
  Module                      : Playlist
  File name                   : COREPlayListModel.php
  Description                 : Model class for Playlist related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Compassites.
  History                     :
 */


/**
 * Class COREPlayListModel
 */
class COREPlayListModel
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
     * 
     *    $clientPlaylist = 0; // 0 -> consumer play list
     *    $clientPlaylist = 1; // 1 -> client play list created from backend
     *    $clientPlaylist = 2; // 2 -> all play list (0+1)
     */
    public function getAllPlayLists($consumerId,$clientUserId,$clientPlaylist,$appCall=false,$page_no=1,$pegination=true)
    {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->getAllPlayLists($ConnBean,$consumerId,$clientUserId,$clientPlaylist,$appCall,$page_no,$pegination);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function getPlayListInsights($consumerId,$clientId,$clientUserId,$clientPlaylist,$playListId,$page_no=1,$pegination=true,$list_my_favorites_flag=false,$selected_insights=NULL)
    {    
        $aResult    = array();
        $ConnBean   = new COREDbManager();
        $playListDM = new COREPlayListDB();
        try
        {
            $aResult = $playListDM->getPlayListInsights($ConnBean,$consumerId,$clientId,$clientUserId,$clientPlaylist,$playListId,$page_no,$pegination,$list_my_favorites_flag,$selected_insights);
            
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function createPlayList($consumerId,$playListName,$playlist_insight_arr,$playlist_created_by_client,$clientId)
    {        

        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->createPlayList($ConnBean,$consumerId,$playListName,$playlist_insight_arr,$playlist_created_by_client,$clientId);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
        
    }
    
    public function updatePlayList($consumerId,$playListName,$list_order,$playListIdTo,$playlist_insight_arr,$playlist_created_by_client) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->updatePlayList($ConnBean,$consumerId,$playListName,$list_order,$playListIdTo,$playlist_insight_arr,$playlist_created_by_client);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function deletePlayList($consumerId,$playListIds,$playlist_created_by_client) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->deletePlayList($ConnBean,$consumerId,$playListIds,$playlist_created_by_client);
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
    public function addToPlayList($consumerId,$playListId,$playlist_insight_arr, $playlist_insight_duration_arr=array(),$recent_playlist=false,$add_to_favorites_flag=false) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $playListName = null;
            $playlist_created_by_client = 0;
            if($recent_playlist === true) {
                $aResult = $playListDM->addInsightsInRecentPlayList($ConnBean,$consumerId,$playlist_insight_arr, $playlist_insight_duration_arr);
            } else {
                $updatePlayListName_flag = false;
                $max_list_order = $playListDM->getMaxListOrderForPlayList($ConnBean,$consumerId,$playlist_created_by_client);
                $aResult = $playListDM->updatePlayList($ConnBean,$consumerId,$playListName,$max_list_order,$playListId,$playlist_insight_arr,$playlist_created_by_client,$updatePlayListName_flag,$add_to_favorites_flag);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    public function removeFromPlayList($consumerId,$playListId,$playlist_insight_arr,$consumerId,$list_my_favorites_flag=false) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->removeFromPlayList($ConnBean,$playListId,$playlist_insight_arr,$consumerId,$list_my_favorites_flag);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }  
    
    public function reorderPlayListInsights($consumerId,$playListId,$playlist_insight_arr,$playlist_insight_list_order_arr,$consumerId,$list_my_favorites_flag=false) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->reorderPlayListInsights($ConnBean,$playListId,$playlist_insight_arr,$playlist_insight_list_order_arr,$consumerId,$list_my_favorites_flag);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
        public function reorderPlayLists($consumerId,$playlist_id_arr,$playlist_id_list_order_arr, $playlist_created_by_client,$consumerId) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aResult = $playListDM->reorderPlayLists($ConnBean,$playlist_id_arr,$playlist_id_list_order_arr, $playlist_created_by_client,$consumerId);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function getRecentPlayListInsights($consumerId,$clientId,$clientUserId)
    {    
        $aResult    = array();
        $ConnBean   = new COREDbManager();
        $playListDM = new COREPlayListDB();
        try
        {
            $aResult = $playListDM->getRecentPlayListInsights($ConnBean,$consumerId,$clientId,$clientUserId);
            
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    
    public function captureInsightListenTime($consumerId,$playListId,$playlist_insight_arr, $playlist_insight_duration_arr=array(),$recent_playlist=false,$add_to_favorites_flag=false) {
        $aResult    = array();
        $playListDM = new COREPlayListDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $playListName = null;
            $playlist_created_by_client = 0;
            
            $aResult = $playListDM->captureInsightListenTime($ConnBean,$consumerId,$playlist_insight_arr, $playlist_insight_duration_arr);
            
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function getPlayListInsightsShuffleExperts($consumerId,$clientId,$clientUserId)
    {    
        $aResult    = array();
        $ConnBean   = new COREDbManager();
        $playListDM = new COREPlayListDB();
        try
        {
            $aResult = $playListDM->getPlayListInsightsShuffleExperts($ConnBean,$consumerId,$clientId,$clientUserId);
            
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
