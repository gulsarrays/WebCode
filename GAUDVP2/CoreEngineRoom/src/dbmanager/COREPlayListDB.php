<?php

/*
  Project                     : Oriole
  Module                      : Playlist
  File name                   : COREPlayListDB.php
  Description                 : Database class for Playlist related activities
  Copyright                   : Copyright Â© 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREPlayListDB {
    
    var $system_playlist_name = array();

    public function __construct() {
        $this->system_playlist_name[] = strtolower(JSON_TAG_MY_FAVORITE_INSIGHT_PLAYLIST_NAME);
        $this->system_playlist_name[] = strtolower(JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS);
        $this->system_playlist_name[] = strtolower(JSON_TAG_RECENT_PLAY_LIST_NAME);
    }

    public function getAllPlayLists($ConnBean, $consumerId, $clientUserId, $clientPlaylist, $appCall = false, $page_no = 1,$pegination=true) {
        
        if($pegination === true) {            
            $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_LIMIT;            
        } else {
            $limit_start = 0;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_UNLIMITED;
        }
        
        $iResult = array();
        $favourite_insights_data_arr = array();
        $recently_played_insights_data_arr = array();
        $fetched_recently_played_insights = false;
        try {
            
            $favourite_insights_data_arr = $this->getFavouriteInsights($ConnBean,$consumerId);
                      
            if ($clientPlaylist === 1) {
                
                if ($appCall === true) {

                    $sQuery1 = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order,l.status from tblplaylists p,tbluserwiseallplaylistsorder l where p.playlist_created_by_client in( $clientUserId) and p.consumer_id = 0 and l.status = :status and l.consumer_id = :consumerId and l.playlist_id = p.fldid order by l.list_order , p.playlist_name asc limit $limit_start, " . $limit_end;

                    $sQuery_total_count = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order,l.status from tblplaylists p,tbluserwiseallplaylistsorder l where p.playlist_created_by_client in( $clientUserId) and p.consumer_id = 0 and l.status = :status and l.consumer_id = :consumerId and l.playlist_id = p.fldid order by l.list_order , p.playlist_name asc ";
                    
                } else {
                    $consumerId = 0;
                    $sQuery1 = "select * from tblplaylists where playlist_created_by_client in( $clientUserId) and consumer_id = :consumerId   and status = :status order by list_order, playlist_name asc limit $limit_start, " . $limit_end;

                    $sQuery_total_count = "select * from tblplaylists where playlist_created_by_client in( $clientUserId) and consumer_id = :consumerId   and status = :status order by list_order, playlist_name asc ";
            
                }
            } else if ($clientPlaylist === 0) {

                $sQuery1 = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order,l.status, pl.playlist_id, pl.insight_id, i.fldexpertid as expert_id from tblplaylists p, tblplaylistinsights as pl, tblinsights as i,tbluserwiseallplaylistsorder l where l.status = 1 and l.consumer_id = :consumerId and l.playlist_id = p.fldid and pl.insight_id = i.fldid and pl.playlist_id = p.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 and pl.playlist_id in (select fldid from tblplaylists where playlist_created_by_client = 0 and consumer_id = :consumerId and status = :status ) group by pl.playlist_id  order by l.list_order, p.playlist_name asc limit  $limit_start, " . $limit_end;
                
                $sQuery_total_count = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order,l.status, pl.playlist_id, pl.insight_id, i.fldexpertid as expert_id from tblplaylists p, tblplaylistinsights as pl, tblinsights as i, tbluserwiseallplaylistsorder l where l.status = 1 and l.consumer_id = :consumerId and l.playlist_id = p.fldid and pl.insight_id = i.fldid and pl.playlist_id = p.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 and pl.playlist_id in (select fldid from tblplaylists where playlist_created_by_client = 0 and consumer_id = :consumerId and status = :status ) group by pl.playlist_id  order by l.list_order, p.playlist_name asc ";
            } else {

                $sQuery1 = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order, l.status, pl.playlist_id, pl.insight_id, i.fldexpertid as expert_id from tblplaylists p, tblplaylistinsights as pl, tblinsights as i, tbluserwiseallplaylistsorder l where l.status = 1 and l.consumer_id = :consumerId and l.playlist_id = p.fldid and pl.insight_id = i.fldid and pl.playlist_id = p.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 and pl.playlist_id in (select fldid from tblplaylists where (playlist_created_by_client in ($clientUserId) OR consumer_id = :consumerId)  and status = :status ) group by pl.playlist_id  order by  l.list_order, p.playlist_name asc limit  $limit_start, " . $limit_end;
                
                $sQuery_total_count = "select p.fldid, l.custom_playlist_name as playlist_name, p.playlist_created_by_client, l.list_order, l.status, pl.playlist_id, pl.insight_id, i.fldexpertid as expert_id from tblplaylists p, tblplaylistinsights as pl, tblinsights as i, tbluserwiseallplaylistsorder l where l.status = 1 and l.consumer_id = :consumerId and l.playlist_id = p.fldid and pl.insight_id = i.fldid and pl.playlist_id = p.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 and pl.playlist_id in (select fldid from tblplaylists where (playlist_created_by_client in ($clientUserId) OR consumer_id = :consumerId)  and status = :status ) group by pl.playlist_id  order by  l.list_order, p.playlist_name asc ";
            }

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":status", 1);
            $result = $ConnBean->resultset();           
            if (!empty($result)) {
                $count = 0;
                foreach ($result as $playList) {
                    //$sQuery2 = "select count(*) as total_insights from tblplaylistinsights where playlist_id = :playlist_id and status = :status";
                    $sQuery2 = "select pl.insight_id, i.fldexpertid as expert_id from tblplaylistinsights as pl, tblinsights as i where pl.playlist_id = :playlist_id and pl.status = :status and pl.insight_id = i.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 ";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":playlist_id", $playList['fldid']);
                    $ConnBean->bind_param(":status", 1);
                    $result2 = $ConnBean->resultset();
                    $total_insights = 0;
                    $playList_insights_str = '';
                    $playList_insights_arr = array();
                    $playList_insights_experts_arr = array();
                    foreach ($result2 as $playList_insights) {
                        $playList_insights_str .= $playList_insights['insight_id'] . ',';
                        $playList_insights_arr[] = (int) $playList_insights['insight_id'];
                        $playList_insights_experts_arr[] = (int) $playList_insights['expert_id'];
                        $total_insights++;
                    }

                    $flag = true;
                    $playlist_recently_played_flag = false;
                    if ($total_insights == 0 && $appCall == true) {
                        //echo $playList['fldid'] . '<br>';
                        $flag = false;
                    }

                    if ($flag) {                  
                        if ($playList_insights_str != '' && $total_insights > 0) {
                            $playList_insights_str = substr($playList_insights_str, 0, -1);
                        }
                        
                        $customized_system_playlist_name_arr = array_diff($this->system_playlist_name, array(strtolower(JSON_TAG_RECENT_PLAY_LIST_NAME)));
//                        if(in_array(strtolower($playList['playlist_name']),$this->system_playlist_name)) {
                        if(in_array(strtolower($playList['playlist_name']),$customized_system_playlist_name_arr)) {
                            continue;
                        } else if ((strtolower($playList['playlist_name']) === strtolower(JSON_TAG_RECENT_PLAY_LIST_NAME)) || (strtolower($playList['playlist_name']) === strtolower('JSON_TAG_RECENT_PLAY_LIST_NAME'))) {
                            $fetched_recently_played_insights = true;
                            $playlist_recently_played_flag = true;
                        }
                            
                                                
                        $playListName = $playList['playlist_name'];
                        $listOrder = $playList['list_order'];
                        
                        if(defined($playListName)) {
                            $playListName = constant($playListName);
                        }
                        
                        if( $playlist_recently_played_flag ===  true) {
                            $recently_played_insights_data_arr[] = array(
                                'playList_id' => $playList['fldid'], 
                                'playList_name' => $playListName, 
                                'list_order' => $listOrder, 
                                'playlist_created_by_client' => ( ($playList['playlist_created_by_client'] == 0) ? 0 : 1), 
    //                            'consumerId' => $consumerId, 
                                "playlist_my_favorites" => false,
                                "playlist_recently_played" => true,
                                'playList_insights' => $playList_insights_arr, 
                                'playList_insights_experts' => $playList_insights_experts_arr, 
                                'total_insights' => $total_insights
                                    );
                        } else {
                        
                            $iResult['playlist'][] = array(
                                'playList_id' => $playList['fldid'], 
                                'playList_name' => $playListName, 
                                'list_order' => $listOrder, 
                                'playlist_created_by_client' => ( ($playList['playlist_created_by_client'] == 0) ? 0 : 1), 
    //                            'consumerId' => $consumerId, 
                                "playlist_my_favorites" => false,
                                "playlist_recently_played" => false,
                                'playList_insights' => $playList_insights_arr, 
                                'playList_insights_experts' => $playList_insights_experts_arr, 
                                'total_insights' => $total_insights
                                    );
                        }
                        $count++;
                    }
                }
                if ($page_no < 2 && !empty($favourite_insights_data_arr) && is_array($favourite_insights_data_arr) && $clientPlaylist !== 1) {
                    if($fetched_recently_played_insights === false) {
                        
                        $recently_played_insights_data_arr[] = array(
                            "playList_id" => "0",
                            "playList_name" => JSON_TAG_RECENT_PLAY_LIST_NAME,
                            "list_order" => "0",
                            "playlist_created_by_client" => 0,
                            "playlist_my_favorites" => false,
                            "playlist_recently_played" => true,
                            "playList_insights" => array(), 
                            "playList_insights_experts" => array(), 
                            "total_insights" => 0
                        );
                        
                        
                        $favourite_insights_data_arr = array_merge($favourite_insights_data_arr,$recently_played_insights_data_arr);
                    } else if(!empty($recently_played_insights_data_arr)) {
                        $favourite_insights_data_arr = array_merge($favourite_insights_data_arr,$recently_played_insights_data_arr);
                    }

                    if(!empty($iResult['playlist'])) {
                        $tmp_arr = array_merge($favourite_insights_data_arr,$iResult['playlist']);
                    } else {
                        $tmp_arr = $favourite_insights_data_arr;
                    }
                    $iResult['playlist'] = $tmp_arr;
//                    $count++;
                }
                
                $iResult[JSON_TAG_COUNT] = $count;

                $ConnBean->getPreparedStatement($sQuery_total_count);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":status", 1);
                $ConnBean->execute();
                $sQuery_total_count = $ConnBean->rowCount();
                $total_page_nos = $sQuery_total_count / (int) $limit_end;
                $total_page_nos = ceil($total_page_nos);
//                    $iResult['sQuery_total_count'] = $sQuery_total_count;
//                    $iResult['total_page_nos'] = $total_page_nos;
                if ($page_no < $total_page_nos) {
                    $iResult['page_no'] = $page_no;
                }          
            } else {
                
                if(!empty($favourite_insights_data_arr)) {
                    $recently_played_insights_data_arr[] = array(
                            "playList_id" => "0",
                            "playList_name" => JSON_TAG_RECENT_PLAY_LIST_NAME,
                            "list_order" => "0",
                            "playlist_created_by_client" => 0,
                            "playlist_my_favorites" => false,
                            "playlist_recently_played" => true,
                            "playList_insights" => array(), 
                            "playList_insights_experts" => array(), 
                            "total_insights" => 0
                        );
                        
                        
                    $favourite_insights_data_arr = array_merge($favourite_insights_data_arr,$recently_played_insights_data_arr);
                    $iResult['playlist'] = $favourite_insights_data_arr;
                } else {
                    $iResult = array('error' => 'No Playlist Available!!!');
                }
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 1 !!!",
                'message' => $e->getMessage()
            );
        }

        return $iResult;
    }

    public function getPlayListInsights($ConnBean, $consumerId, $clientId, $clientUserId, $clientPlaylist, $playListId, $page_no=1,$pegination=true,$list_my_favorites_flag=false,$selected_insights=NULL) {

        $iResult = array();
        $str_insightid = '';
        $inbox_flag = 0;
        $sort_by_ascending_order = 0;
        $sort_by_field_name = null;
        $inboxDB = new COREInboxDB();

        $tmp_count = 0;
        $selected_insights_response = array();
        $where_exclude_selected_insights = '';
        $where_exclude_selected_insights_fav = '';
        if(!empty($selected_insights)) {
            $tmp_count = count($selected_insights);
            $selected_insight_ids = implode(",",$selected_insights);
            $where_exclude_selected_insights = " AND pi.insight_id NOT IN (".$selected_insight_ids.") ";
            $where_exclude_selected_insights_fav = " AND f.fldinsightid NOT IN (".$selected_insight_ids.") ";
        }

        if($page_no === 1 && !empty($selected_insights)) {
            $playListId_tmp = NULL;
            $selected_insights_response = $inboxDB->all_inbox_insights($ConnBean, $clientId, $selected_insight_ids, $sort_by_field_name, $sort_by_ascending_order, $inbox_flag, $playListId_tmp, $list_my_favorites_flag);
        }

        if($pegination === true) {
            $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_LIMIT;            
        } else {
            $limit_start = 0;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_UNLIMITED;
        }

        try {
            if($list_my_favorites_flag === true) {
                $playListId = null;
                $sQuery1 = "select f.fldinsightid as insight_id, i.fldexpertid as expert_id from tblfavourites as f, tblinsights as i where f.fldinsightid = i.fldid and i.fldisdeleted = 0 and i.fldisonline = 1 and f.fldconsumerid = :consumerId $where_exclude_selected_insights_fav ORDER BY f.list_order limit  $limit_start, " . $limit_end;
                $sQuery_total_count = "select f.fldinsightid as insight_id, i.fldexpertid as expert_id from tblfavourites as f, tblinsights as i where f.fldinsightid = i.fldid and i.fldisdeleted = 0 and i.fldisonline = 1 and f.fldconsumerid = :consumerId $where_exclude_selected_insights_fav ORDER BY f.list_order";

            } else if ($clientPlaylist === 1) {
                $consumerId = 0;
                $sQuery1 = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client in ($clientUserId) and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc limit  $limit_start, " . $limit_end;

                $sQuery_total_count = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client in ($clientUserId) and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc";
            } else if ($clientPlaylist === 0) {
                $sQuery1 = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client = 0 and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc limit  $limit_start, " . $limit_end;

                $sQuery_total_count = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client = 0 and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc";
            } else {

                /************* To select multiple playlist insights - Starts ***************/
                $clientUserId .= ",0";
                $sQuery1 = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client in ($clientUserId) and (p.consumer_id = :consumerId OR p.consumer_id = 0) and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc limit  $limit_start, " . $limit_end;

                $sQuery_total_count = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client in ($clientUserId) and (p.consumer_id = :consumerId OR p.consumer_id = 0) and p.fldid = pi.playlist_id and p.fldid in ($playListId) and pi.status = :status $where_exclude_selected_insights order by pi.list_order asc";
                /************* To select multiple playlist insights - End ***************/

            }

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            if($list_my_favorites_flag === false) {
                $ConnBean->bind_param(":status", 1);
            }
            $result = $ConnBean->resultset();
            if (!empty($result)) {
                foreach ($result as $playList) {
                    $str_insightid .= $playList['insight_id'] . ',';
                }
                if (!empty($str_insightid)) {
                    $str_insightid = substr($str_insightid, 0, -1);
//                    $str_insightid = '2825,2811,2815';
                    $iResult = $inboxDB->all_inbox_insights($ConnBean, $clientId, $str_insightid, $sort_by_field_name, $sort_by_ascending_order, $inbox_flag, $playListId, $list_my_favorites_flag);
                }
                $selected_insights_response_count = 0;
                if(!empty($selected_insights_response)) {
                    $selected_insights_response_count = count($selected_insights_response);
                    $t1 = array_merge_recursive($selected_insights_response,$iResult);
                    $t1['status'] = 0;
                    $iResult = array();
                    $iResult = $t1;
                }

                $ConnBean->getPreparedStatement($sQuery_total_count);
                $ConnBean->bind_param(":consumerId", $consumerId);
                if($list_my_favorites_flag === false) {
                    $ConnBean->bind_param(":status", 1);
                }
                $ConnBean->execute();
                $sQuery_total_count = $ConnBean->rowCount();
                $sQuery_total_count += $selected_insights_response_count;
                $total_page_nos = $sQuery_total_count / (int) $limit_end;
                $total_page_nos = ceil($total_page_nos);
//                       $iResult['sQuery_total_count'] = $sQuery_total_count;
//                       $iResult['total_page_nos'] = $total_page_nos;
                if ($page_no < $total_page_nos) {
                    $iResult['page_no'] = $page_no;
                }
            } else if(!empty($selected_insights_response) && empty($iResult)) {
                    $iResult = $selected_insights_response;
            } else {
                
                $iResult = array(                    
                    'error' => NO_INSIGHTS_ERROR
                );
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 2 !!!",
                'message' => $e->getMessage()
            );
        }

        return $iResult;
    }

    public function createPlayList($ConnBean, $consumerId, $playListName, $playlist_insight_arr, $playlist_created_by_client,$clientId) {

        $aResult = array();
        try {
            if ($playlist_created_by_client === 0) { // play list created from app
                $sQuery1 = "select * from tblplaylists where consumer_id = :consumerId and playlist_name = :playListName and status = :status and playlist_created_by_client = :playlist_created_by_client";
            } else { // play list created from backend
                $consumerId = 0;
                $sQuery1 = "select * from tblplaylists where consumer_id = :consumerId and playlist_name = :playListName and status = :status and playlist_created_by_client = :playlist_created_by_client";
            }

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playListName", $playListName);
            $ConnBean->bind_param(":status", 1);
            $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
            $result = $ConnBean->single();

            if (empty($result) && !in_array(strtolower($playListName),$this->system_playlist_name)) {

                $sQuery5 = "select count(*) as is_playlist_available,fldid from tblplaylists where playlist_name = :playListName AND consumer_id = :consumerId";
                $ConnBean->getPreparedStatement($sQuery5);
                $ConnBean->bind_param(":playListName", $playListName);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $result5 = $ConnBean->single();

                if ($result5['is_playlist_available'] == 0) {

                    $sQuery3 = "select max(list_order) as  max_list_order from tblplaylists where consumer_id = :consumerId  and status = :status and playlist_created_by_client = :playlist_created_by_client";
                    $ConnBean->getPreparedStatement($sQuery3);
                    $ConnBean->bind_param(":consumerId", $consumerId);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
                    $result3 = $ConnBean->single();
                    $max_list_order = 1;
                    if (!empty($result3)) {
                        $max_list_order = $result3['max_list_order'] + 1;
                    }

                    $sQuery = "INSERT INTO tblplaylists (consumer_id,playlist_name,playlist_created_by_client,status,list_order) VALUES (:consumerId,:playListName,:playlist_created_by_client,:status, :list_order)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":consumerId", $consumerId);
                    $ConnBean->bind_param(":playListName", $playListName);
                    $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->bind_param(":list_order", $max_list_order);
                    $ConnBean->execute();
                    $playListIdTo = $ConnBean->lastInsertId();

                    $this->populateUserwiseNewPlaylistsOrderTable_Admin($ConnBean,$consumerId,$playListIdTo,$playListName, $playlist_created_by_client,$clientId);
                    
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                        'playList_id' => $playListIdTo,
                        'message' => JSON_TAG_PLAYLIST_CREATED_SUCCESSFULLY
                    );
                } else {
                    $playListIdTo = $result5['fldid'];
                    $aResult = array(
                        'status' => 0,
                        'playList_id' => $playListIdTo,
                        'message' => JSON_TAG_PLAYLIST_ALREADY_EXISTS
                    );
                    return $aResult;
                }
                        
                if(defined($playListName)) {
                    $playListName = constant($playListName);
                }
                        
                $aResult['records'] = array(
                            'playlist_id' => $playListIdTo, 
                            'playlist_name' => $playListName
                            );
            } else {
                $playListIdTo = $result['fldid'];
                $aResult = array(
                    'status' => 0,
                    'playList_id' => $playListIdTo,
                    'message' => JSON_TAG_PLAYLIST_ALREADY_EXISTS
                );
                return $aResult;
            }

            if (!empty($playlist_insight_arr)) {
                $updatePlayListName_flag = false;
                $updatePlayList = $this->updatePlayList($ConnBean, $consumerId, $playListName, $max_list_order, $playListIdTo, $playlist_insight_arr, $playlist_created_by_client, $updatePlayListName_flag);
                if (array_key_exists('error', $updatePlayList)) {
                    $aResult = $updatePlayList;
                } else {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                        'playList_id' => $playListIdTo,
                        'message' => JSON_TAG_PLAYLIST_CREATED_SUCCESSFULLY
                    );
                }
            }
        } catch (Exception $e) {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 3 !!!",
                'message' => $e->getMessage()
            );
        }

        return $aResult;
    }

    public function updatePlayList($ConnBean, $consumerId, $playListName, $list_order, $playListIdTo, $playlist_insight_arr, $playlist_created_by_client, $updatePlayListName_flag = true,$add_to_favorites_flag=false) {
        $aResult = array();
        $iResult = array();
        try {
            if($add_to_favorites_flag === true) {
                foreach ($playlist_insight_arr as $insightId) {
                    $sQuery = "SELECT COUNT(*) AS fav_count FROM tblfavourites WHERE fldconsumerid = ? AND fldinsightid = ?";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param('1', $consumerId);
                    $ConnBean->bind_param('2', $insightId);
                    $result = $ConnBean->single();
                    $count  = $result[JSON_TAG_FAVOURITE_COUNT];
                    if($count == 0)
                    {
                        $sQuery = "INSERT INTO tblfavourites (fldconsumerid, fldinsightid,fldcreateddate, fldmodifieddate) VALUES (?, ?,NOW(),NOW())";
                        $ConnBean->getPreparedStatement($sQuery);
                        $ConnBean->bind_param('1', $consumerId);
                        $ConnBean->bind_param('2', $insightId);
                        $ConnBean->execute();
                    }
                }
                $aResult = array(JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                            'message' => JSON_TAG_INSIGHT_ADDED_IN_MYFAVORITES_SUCCESSFULLY);
                
            } else {
                $sQuery1 = "select * from tblplaylists where fldid = :playListIdTo and playlist_created_by_client = :playlist_created_by_client and status = :status";
                $ConnBean->getPreparedStatement($sQuery1);
                $ConnBean->bind_param(":playListIdTo", $playListIdTo);
                $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
                $ConnBean->bind_param(":status", 1);
                $result = $ConnBean->single();

                if (!empty($result)) {

                    if (!empty($playListName) && $updatePlayListName_flag === true) {
                        $iResult = $this->updatePlayListName($ConnBean, $playListName, $list_order, $playListIdTo, $consumerId);
                        if (!empty($iResult)) {
                            return $iResult;
                        }
                        $aResult = array(
                            JSON_TAG_TYPE => JSON_TAG_SUCCESS
                        );
                    }

                    if (!empty($playlist_insight_arr)) {
                        $iResult = $this->addInsightsInPlayList($ConnBean, $playListIdTo, $playlist_insight_arr);
                        if (!empty($iResult)) {
                            return $iResult;
                        }
                        $aResult = array(JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                            'message' => JSON_TAG_INSIGHT_ADDED_IN_PLAYLIST_SUCCESSFULLY);
                    }
                } else {
                    $aResult = array('error' => JSON_TAG_CANNOT_ADD_INSIGHTS_IN_PLAYLIST);
                }
            }
        } catch (Exception $e) {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 4 !!!",
                'message' => $e->getMessage()
            );
        }
        return $aResult;
    }

    public function deletePlayList($ConnBean, $consumerId, $playListIds, $playlist_created_by_client) {
        $aResult = array();
        if (!empty($playListIds)) {
            try {
                foreach ($playListIds as $playListId) {
                    $sQuery = "DELETE FROM tblplaylists WHERE fldid = :playListId and consumer_id = :consumerId and playlist_created_by_client = :playlist_created_by_client";

                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":consumerId", $consumerId);
                    $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
                    $ConnBean->execute();

                    $sQuery1 = "DELETE FROM tblplaylistinsights WHERE playlist_id = :playListId ";
                    $ConnBean->getPreparedStatement($sQuery1);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->execute();
                    
                    $sQuery2 = "UPDATE tbluserwiseallplaylistsorder SET status = 0 WHERE playlist_id = :playListId and consumer_id = :consumerId";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":consumerId", $consumerId);
                    $ConnBean->execute();
                    
                }
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_SUCCESS
                );
            } catch (Exception $e) {
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    'error' => "Error Occured - 5 !!!",
                    "message" => $e->getMessage(),
                );
            }
        }
        return $aResult;
    }

    public function removeFromPlayList($ConnBean, $playListId, $playlist_insight_arr,$consumerId,$list_my_favorites_flag=false) {
        $aResult = array();
        if (isset($playListId)) {
            try {
                foreach ($playlist_insight_arr as $insight_id) {

                    if($list_my_favorites_flag === true ) {
                        $sQuery1 = "DELETE FROM tblfavourites WHERE fldinsightid = :insight_id AND fldconsumerid = :consumerId";
                        $ConnBean->getPreparedStatement($sQuery1);
                        $ConnBean->bind_param(':consumerId', $consumerId);
                        $ConnBean->bind_param(":insight_id", $insight_id);
                        $ConnBean->execute();
                        
                    } else if (!empty($playListId)) {
                    
                        $sQuery1 = "DELETE FROM tblplaylistinsights WHERE playlist_id = :playListId and insight_id = :insight_id";
                        $ConnBean->getPreparedStatement($sQuery1);
                        $ConnBean->bind_param(":playListId", $playListId);
                        $ConnBean->bind_param(":insight_id", $insight_id);
                        $ConnBean->execute();


                        $sQuery2 = "select count(*) as total_insights from tblplaylistinsights WHERE playlist_id = :playListId";
                        $ConnBean->getPreparedStatement($sQuery2);
                        $ConnBean->bind_param(":playListId", $playListId);
                        $result2 = $ConnBean->single();
                        if ($result2['total_insights'] == 0) {
                            $sQuery3 = "DELETE FROM tblplaylists WHERE fldid = :playListId ";
                            $ConnBean->getPreparedStatement($sQuery3);
                            $ConnBean->bind_param(":playListId", $playListId);
                            $ConnBean->execute();
                        }
                    }
                }
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_SUCCESS
                );
            } catch (Exception $e) {
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    'error' => "Error Occured - 6 !!!",
                    "message" => $e->getMessage(),
                );
            }
        }

        return $aResult;
    }

    private function updatePlayListName($ConnBean, $playListName, $list_order, $playListId, $consumerId) {
        $iResult = array();
        try {

            $sQuery1 = "select count(*) as is_playlist_available from tblplaylists where playlist_name = :playListName AND consumer_id = :consumerId and fldid != :playListId";
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":playListName", $playListName);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playListId", $playListId);
            $result = $ConnBean->single();

            if ($result['is_playlist_available'] == 0 && !in_array(strtolower($playListName),$this->system_playlist_name) ) {
                if ($list_order != '') {
                    $sQuery2 = "UPDATE tblplaylists SET playlist_name = :playListName, list_order = :list_order WHERE fldid = :playListId";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":playListName", $playListName);
                    $ConnBean->bind_param(":list_order", $list_order);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $updateInboxInsight = $ConnBean->execute();
                } else {
                    $sQuery2 = "UPDATE tblplaylists SET playlist_name = :playListName WHERE fldid = :playListId";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":playListName", $playListName);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $updateInboxInsight = $ConnBean->execute();    
                }
                $this->updateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,NULL,$playListName);
                
            } else {
                $iResult = array(
                    'error' => "Error Occured - 7 !!!",
                    "message" => JSON_TAG_PLAYLIST_ALREADY_EXISTS,
                );
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 8 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }

    private function addInsightsInPlayList($ConnBean, $playListId, $playlist_insight_arr) {
        $iResult = array();
        try {
            foreach ($playlist_insight_arr as $insight_id) {
                $sQuery2 = "select * from tblplaylistinsights where playlist_id = :playListId and insight_id = :insight_id and status = :status";
                $ConnBean->getPreparedStatement($sQuery2);
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->bind_param(":insight_id", $insight_id);
                $ConnBean->bind_param(":status", 1);
                $result = $ConnBean->single();



                if (empty($result)) {

                    $sQuery3 = "select max(list_order) as  max_list_order from tblplaylistinsights where playlist_id = :playListId and status = :status";
                    $ConnBean->getPreparedStatement($sQuery3);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":status", 1);
                    $result3 = $ConnBean->single();
                    $max_list_order = 1;
                    if (!empty($result3)) {
                        $max_list_order = $result3['max_list_order'] + 1;
                    }

                    $sQuery = "INSERT INTO tblplaylistinsights (playlist_id,insight_id,status,list_order) VALUES (:playListId,:insight_id,:status,:list_order)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":insight_id", $insight_id);
                    $ConnBean->bind_param(":list_order", $max_list_order);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->execute();
                }
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 9 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }

    public function reorderPlayListInsights($ConnBean, $playListId, $playlist_insight_arr, $playlist_insight_list_order_arr,$consumerId,$list_my_favorites_flag=false) {
        $iResult = array();
        try {
            foreach ($playlist_insight_arr as $k => $insight_id) {

                $listorder = 0;
                if (!empty($playlist_insight_list_order_arr[$k])) {
                    $listorder = $playlist_insight_list_order_arr[$k];
                }

                if($list_my_favorites_flag === true ) {
                    $sQuery2 = "UPDATE tblfavourites SET list_order = :listorder WHERE fldconsumerid = :consumerId and fldinsightid = :insight_id";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":listorder", $listorder);
                    $ConnBean->bind_param(':consumerId', $consumerId);
                    $ConnBean->bind_param(":insight_id", $insight_id);
                    $updateInboxInsight = $ConnBean->execute();
                } else {
                    $sQuery2 = "UPDATE tblplaylistinsights SET list_order = :listorder WHERE playlist_id = :playListId and insight_id = :insight_id";
                    $ConnBean->getPreparedStatement($sQuery2);
                    $ConnBean->bind_param(":listorder", $listorder);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":insight_id", $insight_id);
                    $updateInboxInsight = $ConnBean->execute();
                }
                
                
            }
            $iResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS
            );
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 10 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }

    public function reorderPlayLists($ConnBean, $playlist_id_arr, $playlist_id_list_order_arr, $playlist_created_by_client = 0, $consumerId) {
        $iResult = array();
        try {
            foreach ($playlist_id_arr as $k => $playlist_id) {

                $listorder = 0;
                if (!empty($playlist_id_list_order_arr[$k])) {
                    $listorder = $playlist_id_list_order_arr[$k];
                }

                $sQuery1 = "UPDATE tblplaylists SET list_order = :listorder WHERE fldid = :playListId and playlist_created_by_client = :playlist_created_by_client ";
                $ConnBean->getPreparedStatement($sQuery1);
                $ConnBean->bind_param(":listorder", $listorder);
                $ConnBean->bind_param(":playListId", $playlist_id);
                $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
                $ConnBean->execute();
                
                $this->updateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playlist_id,$listorder,NULL);
                
            }
            $iResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS
            );
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 11 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }

    public function getMaxListOrderForPlayList($ConnBean, $consumerId, $playlist_created_by_client) {
        $sQuery3 = "select max(list_order) as  max_list_order from tblplaylists where consumer_id = :consumerId  and status = :status and playlist_created_by_client = :playlist_created_by_client";
        $ConnBean->getPreparedStatement($sQuery3);
        $ConnBean->bind_param(":consumerId", $consumerId);
        $ConnBean->bind_param(":status", 1);
        $ConnBean->bind_param(":playlist_created_by_client", $playlist_created_by_client);
        $result3 = $ConnBean->single();
        $max_list_order = 1;
        if (!empty($result3)) {
            $max_list_order = $result3['max_list_order'] + 1;
        }
        return $max_list_order;
    }
    
    public function addInsightsInRecentPlayList($ConnBean, $consumerId, $playlist_insight_arr, $playlist_insight_duration_arr) {
        $iResult = array();
        try {
            
            $playListName = 'JSON_TAG_RECENT_PLAY_LIST_NAME';
            $sQuery = "select fldid from tblplaylists where playlist_name = :playListName AND consumer_id = :consumerId";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":playListName", $playListName);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $result = $ConnBean->single();
            
            if (empty($result)) { // Create a Recent playlist
                $sQuery = "INSERT INTO tblplaylists (consumer_id,playlist_name,playlist_created_by_client,status,list_order) VALUES (:consumerId,:playListName,:playlist_created_by_client,:status, :list_order)";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":playListName", $playListName);
                $ConnBean->bind_param(":playlist_created_by_client", 0);
                $ConnBean->bind_param(":status", 1);
                $ConnBean->bind_param(":list_order", 0);
                $ConnBean->execute();
                $playListId = $ConnBean->lastInsertId();
                
                $AppAuthorization   = new COREAppAuthorizationController();
                $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
                $clientId = $AppAuthorizationDetails['clientId'];
                
                $playlist_created_by_client = 0;
                $this->populateUserwiseNewPlaylistsOrderTable_Admin($ConnBean,$consumerId,$playListId,$playListName, $playlist_created_by_client,$clientId);
                
            } else { // get the recent play list id
                $playListId = $result['fldid'];                
            }            
                
            foreach ($playlist_insight_arr as $key => $insight_id) {
                
                /// Need to log this insight is listen so next time in recommendation API, we need to list NOT-LISTENED insight as first in list -  Start
                //if(!empty($playlist_insight_duration_arr) && is_array($playlist_insight_duration_arr) && count($playlist_insight_duration_arr) > 0) {
//                    $time_spent_in_mili_sec = $playlist_insight_duration_arr[$key];
                    $time_spent_in_mili_sec = 1000; // so atleast he listen this insight for 1 sec
                    $this->updateInsightListenCount($ConnBean, $consumerId, $insight_id, $time_spent_in_mili_sec);
                //}
                /// Need to log this insight is listen so next time in recommendation API, we need to list NOT-LISTENED insight as first in list -  End
                            
                /////////////// Update Insight Listen Count - Start /////////////////
                $sQuery = "UPDATE tblinsights SET listened_count = listened_count+1 WHERE fldid= :insightid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":insightid", $insight_id);
                $updateInsight = $ConnBean->execute();
                /////////////// Update Insight Listen Count - End /////////////////
                
                $sQuery2 = "select * from tblplaylistinsights where playlist_id = :playListId and insight_id = :insight_id and status = :status";
                $ConnBean->getPreparedStatement($sQuery2);
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->bind_param(":insight_id", $insight_id);
                $ConnBean->bind_param(":status", 1);
                $result = $ConnBean->single();
                if (empty($result)) {
                    $this->manageRecentPlayList($ConnBean, $playListId);

                    $sQuery = "INSERT INTO tblplaylistinsights (playlist_id,insight_id,status,list_order) VALUES (:playListId,:insight_id,:status,:list_order)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":insight_id", $insight_id);
                    $ConnBean->bind_param(":list_order", 0);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->execute();  
                }
                
            }
            $total_recent_playlist_insights_counts = $this->getTotalRecentPlaylistInsightsCount($ConnBean,$consumerId);
            
            
            $iResult = array(JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                        'message' => JSON_TAG_INSIGHT_ADDED_IN_PLAYLIST_SUCCESSFULLY,
                        'total_insights' => $total_recent_playlist_insights_counts
                );
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 12 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }
    private function manageRecentPlayList($ConnBean, $playListId) {
        $sQuery1 = "select * from tblplaylistinsights where playlist_id = :playListId order by list_order DESC";
        $ConnBean->getPreparedStatement($sQuery1);
        $ConnBean->bind_param(":playListId", $playListId);
        $result = $ConnBean->resultset();
        if (!empty($result)) {
            
            if(count($result) >= (int)JSON_TAG_RECENT_PLAY_LIST_INSIGHTS_COUNT ) {
                $playListInsightsTableId = $result[0]['fldid'];
                $sQuery2 = "DELETE FROM tblplaylistinsights WHERE list_order >= :list_order and playlist_id = :playListId ";
                $ConnBean->getPreparedStatement($sQuery2);
                $ConnBean->bind_param(":list_order", (JSON_TAG_RECENT_PLAY_LIST_INSIGHTS_COUNT-1));
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->execute();
                $playListInsightsTableId = null;
            }
            foreach ($result as $playListInsights) {
                $playListInsightsTableId = $playListInsights['fldid'];
                $sQuery3 = "UPDATE tblplaylistinsights SET list_order = list_order+1 WHERE fldid = :fldid and playlist_id = :playListId ";
                $ConnBean->getPreparedStatement($sQuery3);
                $ConnBean->bind_param(":fldid", $playListInsightsTableId);
                $ConnBean->bind_param(":playListId", $playListId);
                $updateInboxInsight = $ConnBean->execute();  
            }
        }
    }
    
    public function getRecentPlayListInsights($ConnBean, $consumerId, $clientId, $clientUserId) {


        $iResult = array();
        $str_insightid = '';
        $inbox_flag = 0;
        $sort_by_ascending_order = 0;
        $sort_by_field_name = null;

        try {

            $sQuery1 = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client = 0 and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.playlist_name = :playlist_name and pi.status = :status order by pi.list_order asc";

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playlist_name", 'JSON_TAG_RECENT_PLAY_LIST_NAME');
            $ConnBean->bind_param(":status", 1);
            $result = $ConnBean->resultset();
            $sQuery_total_count = $ConnBean->rowCount();
            if (!empty($result)) {
                foreach ($result as $playList) {
                    $playListId = $playList['playlist_id'];
                    $iResult[] = array('id' => $playList['fldid'], 'insight_id' => $playList['insight_id']);
                    $str_insightid .= $playList['insight_id'] . ',';
                }
                if (!empty($str_insightid)) {
                    $inboxDB = new COREInboxDB();
                    $str_insightid = substr($str_insightid, 0, -1);
//                    $str_insightid = '2825,2811,2815';
                    $iResult = $inboxDB->all_inbox_insights($ConnBean, $clientId, $str_insightid, $sort_by_field_name, $sort_by_ascending_order, $inbox_flag, $playListId);
                }

            } else {
                
                $iResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    'description' => NO_INSIGHTS_ERROR
                );
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 13 !!!",
                'message' => $e->getMessage()
            );
        }

        return $iResult;
    }
    
    public function getTotalRecentPlaylistInsightsCount($ConnBean,$consumerId) {
        
        $aResult['total_recent_playlist_insights'] = 0;
        
        
        try{
            $sQuery1 = "select pi.fldid from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client = 0 and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.playlist_name = :playlist_name and pi.status = :status order by pi.list_order asc";

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playlist_name", 'JSON_TAG_RECENT_PLAY_LIST_NAME');
            $ConnBean->bind_param(":status", 1);
            $result = $ConnBean->resultset();
            $sQuery_total_count = $ConnBean->rowCount();

            $aResult = $sQuery_total_count;

            return $aResult;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    protected function getFavouriteInsights($ConnBean,$consumerId) {

        $total_favourite_insights = 0;
        $favourite_insights_arr = array();
        $favourite_insights_experts_arr = array(); 
        $favourite_insights_data_arr= array();
        
        $sQuery0 = "select f.fldinsightid as insight_id, i.fldexpertid as expert_id from tblfavourites as f, tblinsights as i where f.fldinsightid = i.fldid and i.fldisdeleted = 0 and i.fldisonline = 1 and f.fldconsumerid = :consumerId order by f.list_order ";
        $ConnBean->getPreparedStatement($sQuery0);
        $ConnBean->bind_param(':consumerId', $consumerId);
        $result0 = $ConnBean->resultset();

        if (!empty($result0)) {

            foreach ($result0 as $favourite_insight_data) {                    
                $favourite_insights_arr[] = (int) $favourite_insight_data['insight_id'];
                $favourite_insights_experts_arr[] = (int) $favourite_insight_data['expert_id'];
                $total_favourite_insights++;                    
            }
            $favourite_insights_data_arr[] = array(
                "playList_id" => "0",
                "playList_name" => JSON_TAG_MY_FAVORITE_INSIGHT_PLAYLIST_NAME,
                "list_order" => "0",
                "playlist_created_by_client" => 0,
                "playlist_my_favorites" => true,
                "playlist_recently_played" => false,
                "playList_insights" => $favourite_insights_arr, 
                "playList_insights_experts" => $favourite_insights_experts_arr, 
                "total_insights" => $total_favourite_insights
            );
            
        } else {
            $favourite_insights_data_arr[] = array(
                "playList_id" => "0",
                "playList_name" => JSON_TAG_MY_FAVORITE_INSIGHT_PLAYLIST_NAME,
                "list_order" => "0",
                "playlist_created_by_client" => 0,
                "playlist_my_favorites" => true,
                "playlist_recently_played" => false,
                "playList_insights" => $favourite_insights_arr, 
                "playList_insights_experts" => $favourite_insights_experts_arr, 
                "total_insights" => $total_favourite_insights
            );
        }
        return $favourite_insights_data_arr;
    }
    
    protected function updateInsightListenCount($ConnBean, $consumerId, $insight_id, $time_spent_in_mili_sec) {

        $time_spent_in_sec = $time_spent_in_mili_sec/1000;
        try {
            $sQuery = "select fldid,listencount,time_spent_in_sec from tbllistenedinsights where fldconsumerid = :consumerId AND fldinsightid = :insight_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":insight_id", $insight_id);
            $result = $ConnBean->single();

            if (empty($result)) { // Create a new playlist
                $sQuery = "INSERT INTO tbllistenedinsights (fldconsumerid,fldinsightid,listencount,time_spent_in_sec) VALUES (:consumerId,:insight_id,:listencount,:micro_sec_time)";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":insight_id", $insight_id);
                $ConnBean->bind_param(":listencount", 1);
                $ConnBean->bind_param(":micro_sec_time", $time_spent_in_sec);
                $ConnBean->execute();            
            } else { // update teh count

                $fldid = $result['fldid'];
                $listencount = (int)$result['listencount']+1;
                $time_spent_in_sec_new = $result['time_spent_in_sec']+$time_spent_in_sec;

                $sQuery = "UPDATE tbllistenedinsights SET listencount = :listencount, time_spent_in_sec = :time_in_sec WHERE fldid = :fldid "; 
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":listencount", $listencount);
                $ConnBean->bind_param(":time_in_sec", $time_spent_in_sec_new);
                $ConnBean->bind_param(":fldid", $fldid);
                $ConnBean->execute();     
            }   
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
        
        
    }
    
        public function captureInsightListenTime($ConnBean, $consumerId, $playlist_insight_arr, $playlist_insight_duration_arr) {
        $iResult = array();
        try {
            
            foreach ($playlist_insight_arr as $key => $insight_id) {
                
                if(!empty($playlist_insight_duration_arr) && is_array($playlist_insight_duration_arr) && count($playlist_insight_duration_arr) > 0) {
                    $time_spent_in_mili_sec = $playlist_insight_duration_arr[$key];
                    $this->updateInsightListenCount($ConnBean, $consumerId, $insight_id, $time_spent_in_mili_sec);
                }
            }
            $iResult = array(JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                        'message' => JSON_TAG_PLAY_LIST_INSIGHTS_DURATION_CAPTURE_SUCCESS);
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 12 !!!",
                "message" => $e->getMessage(),
            );
        }
        return $iResult;
    }
    
    public function getPlayListInsightsShuffleExperts($ConnBean, $consumerId, $clientId, $clientUserId) {

        $this->updateShuffleExpertsPlayListInsights($ConnBean, $consumerId, $clientId, $clientUserId);
        
        $iResult = array();
        $str_insightid = '';
        $inbox_flag = 0;
        $sort_by_ascending_order = 0;
        $sort_by_field_name = null;

        try {

            $sQuery1 = "select pi.* from tblplaylistinsights pi, tblplaylists p where p.playlist_created_by_client = 0 and p.consumer_id = :consumerId and p.fldid = pi.playlist_id and p.playlist_name = :playlist_name and pi.status = :status order by pi.list_order asc";

            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playlist_name", JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS);
            $ConnBean->bind_param(":status", 1);
            $result = $ConnBean->resultset();
            $sQuery_total_count = $ConnBean->rowCount();
            if (!empty($result)) {
                foreach ($result as $playList) {
                    $playListId = $playList['playlist_id'];
                    $iResult[] = array('id' => $playList['fldid'], 'insight_id' => $playList['insight_id']);
                    $str_insightid .= $playList['insight_id'] . ',';
                }
                if (!empty($str_insightid)) {
                    $inboxDB = new COREInboxDB();
                    $str_insightid = substr($str_insightid, 0, -1);
//                    $str_insightid = '2825,2811,2815';
                    $iResult = $inboxDB->all_inbox_insights($ConnBean, $clientId, $str_insightid, $sort_by_field_name, $sort_by_ascending_order, $inbox_flag, $playListId);
                }

            } else {
                
                $iResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    'description' => NO_INSIGHTS_ERROR
                );
            }
        } catch (Exception $e) {
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'error' => "Error Occured - 13 !!!",
                'message' => $e->getMessage()
            );
        }

        return $iResult;
    }

    public function updateShuffleExpertsPlayListInsights($ConnBean, $consumerId, $clientId, $clientUserId) {
        $iResult = array();
        try {
            
            $playListName = JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS;
            $sQuery = "select fldid from tblplaylists where playlist_name = :playListName AND consumer_id = :consumerId";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":playListName", $playListName);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $result = $ConnBean->single();
            
            if (empty($result)) { // Create a Recent playlist
                $sQuery = "INSERT INTO tblplaylists (consumer_id,playlist_name,playlist_created_by_client,status,list_order) VALUES (:consumerId,:playListName,:playlist_created_by_client,:status, :list_order)";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":playListName", $playListName);
                $ConnBean->bind_param(":playlist_created_by_client", 0);
                $ConnBean->bind_param(":status", 1);
                $ConnBean->bind_param(":list_order", 0);
                $ConnBean->execute();
                $playListId = $ConnBean->lastInsertId();
            } else { // get the recent play list id
                $playListId = $result['fldid'];  
                
                $sQuery1 = "DELETE FROM tblplaylistinsights WHERE playlist_id = :playListId ";
                $ConnBean->getPreparedStatement($sQuery1);
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->execute();                        
            }  

            $sQuery2 = "SELECT fldid as insight_id FROM tblinsights  WHERE fldisdeleted = 0 and fldisonline = 1 and (client_id = '$clientId' OR client_id = 'audvisor11012017') ORDER BY RAND() LIMIT  ".JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS_LIMIT;
            $ConnBean->getPreparedStatement($sQuery2);
            $result = $ConnBean->resultset();
            
            if(!empty($result)) {
                foreach ($result as $insightData) {
                    $insight_id = $insightData['insight_id'];
                    $sQuery = "INSERT INTO tblplaylistinsights (playlist_id,insight_id,status,list_order) VALUES (:playListId,:insight_id,:status,:list_order)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":insight_id", $insight_id);
                    $ConnBean->bind_param(":list_order", 0);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->execute();  
                }
            }
        } catch (Exception $e) {
            echo "Error Occured - 1031 !!! <br>";
            echo  $e->getMessage();
            exit;
        }
        
    }
    
    public function populateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$playListName,$list_order) {
        try {

            $customized_system_playlist_name_arr = array_diff($this->system_playlist_name, array(strtolower(JSON_TAG_RECENT_PLAY_LIST_NAME)));

//            if(!in_array(strtolower($playListName),$this->system_playlist_name)) {
            if(!in_array(strtolower($playListName),$customized_system_playlist_name_arr)) {
                $sQuery = "select fldid from tbluserwiseallplaylistsorder where consumer_id = :consumerId AND playlist_id = :playListId ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":playListId", $playListId);
                $result = $ConnBean->single();

                if (empty($result)) { // add record
                    $sQuery = "INSERT INTO tbluserwiseallplaylistsorder (consumer_id,playlist_id,custom_playlist_name,list_order,status) VALUES (:consumerId,:playListId,:playListName,:list_order,:status)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":consumerId", $consumerId);
                    $ConnBean->bind_param(":playListId", $playListId);
                    $ConnBean->bind_param(":playListName", $playListName);
                    $ConnBean->bind_param(":list_order", $list_order);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->execute();  
                }
            }
        } catch (Exception $ex) {
            echo "Error Occured - 1052 !!! <br>";
            echo  $ex->getMessage();
            exit;
        }
    }
    
    public function updateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$list_order=NULL,$customPlayListName=NULL) {
        try {
            if(!empty($customPlayListName)) {
                $sQuery = "UPDATE tbluserwiseallplaylistsorder SET custom_playlist_name = :playListName WHERE consumer_id = :consumerId and playlist_id = :playListId "; 
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->bind_param(":playListName", $customPlayListName);
                $ConnBean->execute();
            } else if($list_order !== NULL) {
                $sQuery = "UPDATE tbluserwiseallplaylistsorder SET list_order = :list_order WHERE consumer_id = :consumerId and playlist_id = :playListId "; 
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerId", $consumerId);
                $ConnBean->bind_param(":playListId", $playListId);
                $ConnBean->bind_param(":list_order", $list_order);
                $ConnBean->execute();
            }          
        } catch (Exception $ex) {
            echo "Error Occured - 1066 !!! <br>";
            echo  $ex->getMessage();
            exit;
        }
    }
    
    public function deleteFromUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId) {
        try {
            $sQuery = "UPDATE tbluserwiseallplaylistsorder SET status = :status WHERE consumer_id = :consumerId and playlist_id = :playListId "; 
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":playListId", $playListId);
            $ConnBean->bind_param(":status", 0);
            $ConnBean->execute();
        } catch (Exception $ex) {
            echo "Error Occured - 1082 !!! <br>";
            echo  $ex->getMessage();
            exit;
        }
    }
    
    private function populateUserwiseNewPlaylistsOrderTable_Admin($ConnBean,$consumerId,$playListId,$playListName,$playlist_created_by_client, $clientId) {
        
        $list_order = 0;
        
        if($consumerId === 0) {
            if($clientId === 'audvisor11012017') {
                $sQuery = "select distinct(consumer_id) as consumerId from tbluserwiseallplaylistsorder where 1 ";
            } else {
                $sQuery = "select distinct(l.consumer_id) as consumerId from tbluserwiseallplaylistsorder l, tblconsumers c where l.consumer_id = c.fldid and c.client_id = '$clientId' ";
            }            
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            
            if (!empty($result)) {
                foreach ($result as $data) {                    
                    $consumerId = $data['consumerId'];                   
                    $this->populateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$playListName,$list_order);
                }
            }
        } else {
            $this->populateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$playListName,$list_order);
        }
    }
}
