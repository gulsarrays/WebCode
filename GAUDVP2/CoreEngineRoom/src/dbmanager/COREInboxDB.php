<?php

/*
  Project                     : Oriole
  Module                      : Insight
  File name                   : COREInsightDB.php
  Description                 : Database class for Insight related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREInboxDB
{

    public function __construct()
    {
    }
    

    public function insertInboxInsight($ConnBean,$platformId, $consumerId, $insightId, $insightMessage, $shared_by_consumer_id, $mark_as_read=0)
    {
        $aResult = array();
        try
        {
            $sQuery1 = "select * from tblinboxinsights where fldconsumerid = :consumerid and fldinsightid = :insightid and shared_by_consumer_id = :shared_by_consumer_id and fldisdeleted = 0";
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerid", $consumerId);
            $ConnBean->bind_param(":insightid", $insightId);
            $ConnBean->bind_param(":shared_by_consumer_id", $shared_by_consumer_id);
            $result = $ConnBean->single();
            
            if(empty($result)) {
                $sQuery = "INSERT INTO tblinboxinsights (fldmessage,fldconsumerid,fldinsightid,shared_by_consumer_id,mark_as_read,fldcreateddate) VALUES (:insightmessage,:consumerid,:insightid,:shared_by_consumer_id,:mark_as_read,NOW())";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":insightmessage", $insightMessage);
                $ConnBean->bind_param(":consumerid", $consumerId);
                $ConnBean->bind_param(":insightid", $insightId);
                $ConnBean->bind_param(":shared_by_consumer_id", $shared_by_consumer_id);
                $ConnBean->bind_param(":mark_as_read", 0);
                $ConnBean->execute();
                $inboxid = $ConnBean->lastInsertId();
                $this->sendNotification($ConnBean,$platformId,$inboxid);
            }            

            $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
        }
        catch(Exception $e)
        {
            $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
        }

        return $aResult;
    }
    

    /**
     * Function used to get all insight details for cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function list_inbox_data($ConnBean,$clientId,$groupId,$consumerId,$shared_by_me=false,$sort_by_field_name=null,$sort_by_ascending_order=0)
    {
        $s3Bridge  = new COREAwsBridge();
        $ConnBean1 = new COREDbManager();
        $iResult   = array();
        try
        {
//            $consumerId = 30040;
//            
            if(!empty($shared_by_me) && $shared_by_me===true) {
                $sQuery1 = "select * from tblinboxinsights where shared_by_consumer_id = :consumerid and fldisdeleted= 0 ";
            } else {
                $sQuery1 = "select * from tblinboxinsights where fldconsumerid = :consumerid and fldisdeleted= 0 ";
            }
           
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":consumerid", $consumerId);
            $result = $ConnBean->resultset();
            if(!empty($result)) { 
                
                $str_insightid = '';
                foreach($result as $insight)
                {
                    $str_insightid .= $insight['fldinsightid'].",";
                }
                if(!empty($str_insightid)) {
                    $str_insightid = substr($str_insightid,0,-1);                    
                    $iResult = $this->all_inbox_insights($ConnBean,$clientId,$str_insightid,$sort_by_field_name,$sort_by_ascending_order);
                }
            } else {
                $iResult[JSON_TAG_STATUS] = 3;
                return $iResult;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
        }

        return $iResult;
    }
    
    
    public function all_inbox_insights($ConnBean,$clientId, $str_insightid,$sort_by_field_name=null,$sort_by_ascending_order=0,$inbox_flag=1,$playListId=null, $list_my_favorites_flag=false)
    {
        $s3Bridge  = new COREAwsBridge();
        $ConnBean1 = new COREDbManager();
        $iResult   = array();
        try
        {
            if($inbox_flag ===1) {
//              $order_by = " ORDER BY i.fldcreateddate DESC ";
                $order_by = " ORDER BY ii.mark_as_read ASC ";
                if(!empty($sort_by_field_name)) {
                    $tmp_order_by = ($sort_by_ascending_order===1) ? ' ASC ' : ' DESC ';
                    switch ($sort_by_field_name) {
                        case 'date'://shared_on_dated
                            $order_by = " ORDER BY ii.fldcreateddate $tmp_order_by ";
                            break;
                        case 'insight': // insight_name
                            $order_by = " ORDER BY i.fldname $tmp_order_by ";
                            break;
                        case 'name': //shared_by_name
                            $order_by = " ORDER BY c.fldfirstname $tmp_order_by ";
                            break;
                        case 'email': //shared_by_email
                            $order_by = " ORDER BY c.fldemailid $tmp_order_by ";
                            break;
                        default:
                            $order_by = " ORDER BY ii.mark_as_read ASC ";
                            break;
                    }
                }
            
                $sQuery = "SELECT ii.fldid as inbox_id,ii.fldcreateddate as shared_on_dated, c.fldemailid AS shared_by_email, CONCAT(c.fldfirstname,' ',c.fldlastname) AS shared_by_name ,i.fldid, i.fldname , i.fldinsighturl,i.fldinsightvoiceoverurl, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,tr.fldrating, i.fldexpertid expert_id,i.fldcreateddate,i.fldmodifieddate,i.fldisonline,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,i.fldduration, i.client_id as insight_client_id,e.fldfirstname,e.fldmiddlename,e.fldlastname,e.fldavatarurl,e.fldbioimage,e.fldthumbimage,e.fldpromoimage,e.fldlistviewimage,e.fldfbshareimage,e.fldid AS expert_id,e.fldprefix,CONCAT(e.fldfirstname,' ',e.fldmiddlename, ' ',e.fldlastname) AS expert_name,group_concat(concat_ws(',',top.fldid,top.fldname,top.fldiconurl) SEPARATOR ';') AS topics, e.flddescription as expert_bio, e.fldtitle as expert_subtitle FROM tblinsights i LEFT JOIN tblinsightreputation tr ON i.fldid=tr.fldinsightid LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid JOIN tblinboxinsights as ii on i.fldid = ii.fldinsightid JOIN tblconsumers as c on ii.shared_by_consumer_id = c.fldid WHERE i.fldisdeleted = 0 AND i.client_id = :client_id  and i.fldisonline = 1 and i.fldid in ($str_insightid) GROUP BY i.fldid $order_by";
            } else if(!empty($playListId)) {        
                $order_by = " ORDER BY pi.list_order, i.fldname ASC ";
                $sQuery = "SELECT i.fldid, i.fldname , i.fldinsighturl,i.fldinsightvoiceoverurl, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,tr.fldrating, i.fldexpertid expert_id,i.fldcreateddate,i.fldmodifieddate,i.fldisonline,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,i.fldduration, i.client_id as insight_client_id,e.fldfirstname,e.fldmiddlename,e.fldlastname,e.fldavatarurl,e.fldbioimage,e.fldthumbimage,e.fldpromoimage,e.fldlistviewimage,e.fldfbshareimage,e.fldid AS expert_id,e.fldprefix,CONCAT(e.fldfirstname,' ',e.fldmiddlename, ' ',e.fldlastname) AS expert_name,group_concat(concat_ws(',',top.fldid,top.fldname,top.fldiconurl) SEPARATOR ';') AS topics, pi.list_order, e.flddescription as expert_bio, e.fldtitle as expert_subtitle FROM tblinsights i LEFT JOIN tblinsightreputation tr ON i.fldid=tr.fldinsightid LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid LEFT JOIN tblplaylistinsights as pi on  pi.insight_id = i.fldid WHERE i.fldisdeleted = 0 and i.fldisonline = 1 AND (i.client_id = :client_id OR i.client_id = 'audvisor11012017' ) and i.fldid in ($str_insightid) and pi.playlist_id in ($playListId) GROUP BY i.fldid $order_by"; 
                
        }  else if ($list_my_favorites_flag === true ) {
            
            $order_by = " ORDER BY f.list_order, i.fldname ASC ";
            $sQuery = "SELECT i.fldid, i.fldname , i.fldinsighturl,i.fldinsightvoiceoverurl, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,tr.fldrating, i.fldexpertid expert_id,i.fldcreateddate,i.fldmodifieddate,i.fldisonline,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,i.fldduration, i.client_id as insight_client_id,e.fldfirstname,e.fldmiddlename,e.fldlastname,e.fldavatarurl,e.fldbioimage,e.fldthumbimage,e.fldpromoimage,e.fldlistviewimage,e.fldfbshareimage,e.fldid AS expert_id,e.fldprefix,CONCAT(e.fldfirstname,' ',e.fldmiddlename, ' ',e.fldlastname) AS expert_name,group_concat(concat_ws(',',top.fldid,top.fldname,top.fldiconurl) SEPARATOR ';') AS topics, e.flddescription as expert_bio, e.fldtitle as expert_subtitle FROM tblinsights i LEFT JOIN tblinsightreputation tr ON i.fldid=tr.fldinsightid LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tblfavourites as f ON f.fldinsightid = i.fldid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid WHERE i.fldisdeleted = 0 and i.fldisonline = 1 AND (i.client_id = :client_id OR i.client_id = 'audvisor11012017' ) and i.fldid in ($str_insightid) GROUP BY i.fldid $order_by"; 
        } else {
            $order_by = " ORDER BY i.fldname ASC ";
                $sQuery = "SELECT i.fldid, i.fldname , i.fldinsighturl,i.fldinsightvoiceoverurl, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,tr.fldrating, i.fldexpertid expert_id,i.fldcreateddate,i.fldmodifieddate,i.fldisonline,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,i.fldduration, i.client_id as insight_client_id,e.fldfirstname,e.fldmiddlename,e.fldlastname,e.fldavatarurl,e.fldbioimage,e.fldthumbimage,e.fldpromoimage,e.fldlistviewimage,e.fldfbshareimage,e.fldid AS expert_id,e.fldprefix,CONCAT(e.fldfirstname,' ',e.fldmiddlename, ' ',e.fldlastname) AS expert_name,group_concat(concat_ws(',',top.fldid,top.fldname,top.fldiconurl) SEPARATOR ';') AS topics, e.flddescription as expert_bio, e.fldtitle as expert_subtitle FROM tblinsights i LEFT JOIN tblinsightreputation tr ON i.fldid=tr.fldinsightid LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid WHERE i.fldisdeleted = 0 and i.fldisonline = 1 AND (i.client_id = :client_id OR i.client_id = 'audvisor11012017' ) and i.fldid in ($str_insightid) GROUP BY i.fldid $order_by"; 
        }
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $result = $ConnBean->resultset();
            $i      = 0;
            foreach($result as $insight)
            {
                $sVoiceover                     = $insight[DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL];
                $topicslist                     = $insight[JSON_TAG_TOPICS];
                $topics                         = array();
                $topics                         = explode(";", $topicslist);
                $initialResult[JSON_TAG_TOPICS] = null;
                $clientId = $insight['insight_client_id'];

                $streamingUrl                   = empty($insight[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3Bridge->GetS3InsightURL($insight[DB_COLUMN_FLD_STREAMING_FILENAME],$clientId);
                $streamingFileNamehlsv4         = empty($insight[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3Bridge->GetS3InsightURL($insight[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$clientId);
                foreach($topics as $topic)
                {
                    $temptopic                         = explode(",", $topic);
                    $topicdetails[JSON_TAG_TOPIC_ID]   = intval($temptopic[0]);
                    $topicdetails[JSON_TAG_TOPIC_NAME] = (string)$temptopic[1];
                    $topicdetails[JSON_TAG_FLD_TOPIC_ICON] = (!empty($temptopic[2])) ? $s3Bridge->GetS3TopicIconURL($temptopic[2],$clientId) : NULL;
                    $initialResult[JSON_TAG_TOPICS][]  = $topicdetails;
                }
                $expert[JSON_TAG_ID]          = $insight[JSON_TAG_EXPERT_ID];
                $expert['expert_id']          = $insight[JSON_TAG_EXPERT_ID];
                $expert[JSON_TAG_EXPERT_NAME] = trim($insight[DB_COLUMN_FLD_PREFIX]).' '.trim($insight[JSON_TAG_EXPERT_NAME]);
                $expert['title'] = trim($insight[DB_COLUMN_FLD_PREFIX]).' '.trim($insight[JSON_TAG_EXPERT_NAME]);

                $expert[JSON_TAG_FIRST_NAME] = trim($insight[DB_COLUMN_FLD_FIRST_NAME]);
                $expert[JSON_TAG_MIDDLE_NAME] = trim($insight[DB_COLUMN_FLD_MIDDLE_NAME]);
                $expert[JSON_TAG_LAST_NAME] = trim($insight[DB_COLUMN_FLD_LAST_NAME]);
                
                $expert[JSON_TAG_EXPERT_IMAGE] = empty($insight[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_AVATAR_URL],$clientId);
                $expertBioImage = empty($insight[DB_COLUMN_FLD_BIO_IMAGE]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_BIO_IMAGE],$clientId);
                $expertThumbnailImage = empty($insight[DB_COLUMN_FLD_THUMB_IMAGE]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_THUMB_IMAGE],$clientId);
                $expertPromoImage = empty($insight[DB_COLUMN_FLD_PROMO_IMAGE]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_PROMO_IMAGE],$clientId);
                $expertListImage = empty($insight[DB_COLUMN_FLD_LISTVIEW_IMAGE]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_LISTVIEW_IMAGE],$clientId);
                $expertFBshareImage = empty($insight[DB_COLUMN_FLD_FBSHARE_IMAGE]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_FBSHARE_IMAGE],$clientId);
                

                $expert[JSON_TAG_AVATAR_LINK] = $expert[JSON_TAG_EXPERT_IMAGE];
                
                $expert[JSON_TAG_EXPERT_BIO_IMAGE] = $expertBioImage; 
                $expert[JSON_TAG_EXPERT_THUMBNAIL_IMAGE] = $expertThumbnailImage; 
                $expert[JSON_TAG_EXPERT_PROMO_IMAGE] = $expertPromoImage;
                $expert[JSON_TAG_LISTVIEW_IMAGE] = $expertListImage; 
                $expert[JSON_TAG_FBSHARE_IMAGE] = $expertFBshareImage;
                
                $expert['expert_subtitle'] = trim($insight['expert_subtitle']);
                $expert['subtitle'] = trim($insight['expert_subtitle']);
                $expert["expert_bio"] = $insight['expert_bio'];
                if($sVoiceover != null && $sVoiceover != "")
                {
                    $sVoiceover = $s3Bridge->GetInsightVoiceOverURL($sVoiceover,$clientId);
                }
                
                $streamingUrl_enc = empty($insight['fldstreamingfilename_enc']) ? null : $insight['fldstreamingfilename_enc'];
                $streamingFileNamehlsv4_enc = empty($insight['fldstreamingfilenamehlsv4_enc']) ? null : $insight['fldstreamingfilenamehlsv4_enc'];
                
                if($inbox_flag ===1) {
                    $iResult[JSON_TAG_RECORDS][] = array(
                        JSON_TAG_INBOX_ID => intval($insight['inbox_id']),
                        JSON_TAG_INBOX_INSIGHT_SHARED_ON_DATED => $insight['shared_on_dated'],
                        JSON_TAG_INBOX_INSIGHT_SHARED_BY_NAME => $insight['shared_by_name'],
                        JSON_TAG_INBOX_INSIGHT_SHARED_BY_EMAIL => $insight['shared_by_email'],
                        JSON_TAG_INSIGHT_ID => intval($insight[DB_COLUMN_FLD_ID]), 
                        JSON_TAG_INSIGHT_NAME => (string)$insight[DB_COLUMN_FLD_NAME], 
                        'title' => (string)$insight[DB_COLUMN_FLD_NAME],
                        'duration' => intval($insight['fldduration']), 
                        JSON_TAG_INSIGHT_URL => (string)$insight[DB_COLUMN_FLD_INSIGHT_URL], 
                        JSON_TAG_INSIGHT_VOICE_OVER_URL => (string)$sVoiceover, 
                        JSON_TAG_EXPERT_ID => intval($insight[JSON_TAG_EXPERT_ID]), 
                        JSON_TAG_CREATED_DATE => (string)$insight[DB_COLUMN_FLD_CREATED_DATE], 
                        JSON_TAG_MODIFIED_DATE => (string)$insight[DB_COLUMN_FLD_MODIFIED_DATE], 
                        JSON_TAG_ISONLINE => $insight[DB_COLUMN_FLD_ISONLINE], 
                        JSON_TAG_RATING => $insight[DB_COLUMN_FLD_RATING], 
                        JSON_TAG_EXPERT => $expert, 
                        JSON_TAG_TOPICS => $initialResult[JSON_TAG_TOPICS], 
                        JSON_TAG_STREAMINGURL_ENC =>$streamingUrl_enc, 
                        JSON_TAG_STREAMING_FILENAME_V4_ENC => $streamingFileNamehlsv4_enc);
                } else {
                    $iResult['insights'][] = array(
                        'id' => intval($insight[DB_COLUMN_FLD_ID]),
                        JSON_TAG_INSIGHT_ID => intval($insight[DB_COLUMN_FLD_ID]), 
                        JSON_TAG_INSIGHT_NAME => (string)$insight[DB_COLUMN_FLD_NAME], 
                        'title' => (string)$insight[DB_COLUMN_FLD_NAME],
                        'duration' => intval($insight['fldduration']), 
                        JSON_TAG_INSIGHT_URL => (string)$insight[DB_COLUMN_FLD_INSIGHT_URL], 
                        JSON_TAG_INSIGHT_VOICE_OVER_URL => (string)$sVoiceover, 
                        JSON_TAG_EXPERT_ID => intval($insight[JSON_TAG_EXPERT_ID]), 
                        JSON_TAG_CREATED_DATE => (string)$insight[DB_COLUMN_FLD_CREATED_DATE], 
                        JSON_TAG_MODIFIED_DATE => (string)$insight[DB_COLUMN_FLD_MODIFIED_DATE], 
                        JSON_TAG_ISONLINE => $insight[DB_COLUMN_FLD_ISONLINE], 
                        JSON_TAG_RATING => $insight[DB_COLUMN_FLD_RATING], 
                        JSON_TAG_EXPERT => $expert, 
                        JSON_TAG_TOPICS => $initialResult[JSON_TAG_TOPICS], 
                        JSON_TAG_STREAMINGURL_ENC =>$streamingUrl_enc, 
                        JSON_TAG_STREAMING_FILENAME_V4_ENC => $streamingFileNamehlsv4_enc,
                        'list_order' => (!empty($insight['list_order']) ? $insight['list_order'] : null));
                }
                
                $iResult[JSON_TAG_STATUS] = 0;
                $i++;
            }
        }
        catch(Exception $e)
        {            
            $iResult[JSON_TAG_STATUS] = 2;
            $iResult['message'] =$e->getMessage();
        }

        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_STATUS] = 3;
//            $iResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
//            $iResult['description'] = NO_INSIGHTS_ERROR;            
        }
         
        if ($list_my_favorites_flag === true ) {
            $tmp_arr = explode(',', $str_insightid);
            foreach($tmp_arr as $k => $v) {
                foreach( $iResult['insights'] as $d) {
                    if($d['id'] == $v ){
                        $tmp_arr[$k] = $d;
                    }
                     
                }
            }
            $iResult['insights'] = $tmp_arr;
        }

        return $iResult;
    }
    
    public function mark_as_read($inConnBean,$inbox_id_arr=array()) {
        if(!empty($inbox_id_arr)) {
            try
            {
                foreach($inbox_id_arr as $inbox_id)
                {
                    $sQuery = "UPDATE tblinboxinsights SET mark_as_read = :mark_as_read, fldmodifieddate = NOW() WHERE fldid = :inboxid";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":mark_as_read", 1);
                    $inConnBean->bind_param(":inboxid", $inbox_id);
                    $updateInboxInsight = $inConnBean->execute();
                }
                
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
            } catch(Exception $e)
            {
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
            }
        }
        return $iResult;
    }
    public function mark_as_unread($inConnBean,$inbox_id_arr=array()) {
        if(!empty($inbox_id_arr)) {
            try
            {
                foreach($inbox_id_arr as $inbox_id)
                {
                    $sQuery = "UPDATE tblinboxinsights SET mark_as_read = :mark_as_read, fldmodifieddate = NOW() WHERE fldid = :inboxid";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":mark_as_read", 0);
                    $inConnBean->bind_param(":inboxid", $inbox_id);
                    $updateInboxInsight = $inConnBean->execute();
                }
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
            } catch(Exception $e)
            {
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
            }
        }
        return $iResult;
    }

    public function delete_inbox_insight($inConnBean,$inbox_id_arr=array()) {
        if(!empty($inbox_id_arr)) {
            try
            {
                foreach($inbox_id_arr as $inbox_id)
                {
                    $sQuery = "UPDATE tblinboxinsights SET fldisdeleted = 1, fldmodifieddate = NOW() WHERE fldid = :inboxid";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":inboxid", $inbox_id);
                    $updateInboxInsight = $inConnBean->execute();
                }
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
            } catch(Exception $e)
            {
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
            }
        }
        return $iResult;
    }
    
    public function remove_insight_shared_by_me($inConnBean,$inbox_id_arr=array()) {
        if(!empty($inbox_id_arr)) {
            try
            {
                foreach($inbox_id_arr as $inbox_id)
                {
                    $sQuery = "delete from tblinboxinsights WHERE fldid = :inboxid";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":inboxid", $inbox_id);
                    $updateInboxInsight = $inConnBean->execute();
                }
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
            } catch(Exception $e)
            {
                $iResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_STATUS => 2,
                        JSON_TAG_DESC => $e->getMessage(),
                    );
            }
        }
        return $iResult;
    }
    
    public function sendNotification($ConnBean,$platformId,$inboxid=null) {
        try
        {
           $sQuery1 = "select c.fldemailid as emailId, CONCAT(c.fldfirstname,' ',c.fldlastname) AS consumer_name, u.flddeviceid, ii.fldmessage as shared_insight_msg, i.fldname as insight_name from tblinsights as i, tblinboxinsights as ii, tblconsumers as c LEFT JOIN tbluserdevices u ON c.fldid = u.fldconsumerid where ii.fldconsumerid = c.fldid and ii.fldid = :inboxid and i.fldid = ii.fldinsightid ";
           
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":inboxid", $inboxid);
            $result = $ConnBean->resultset();
            if(!empty($result)) {

                $to     = (string)$result[0]['emailId'];                      
                $shared_insight_msg    = (string)$result[0]['shared_insight_msg'];            
                $insight_name          = (string)$result[0]['insight_name'];            
                $is_email_sent = $this->send_new_insight_shared_notification_mail($insight_name, $shared_insight_msg, $to);
                if(!$is_email_sent)
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
                }
                else
                {
                    $iStatus         = ERRCODE_EMAIL_NOT_SENT;
                    $sErrDescription = JSON_TAG_EMAIL_NOT_SENT;
                }
                
                $pushNotification = new PushNotifications();
                $data['mtitle'] = JSON_TAG_NOTIFICATION_TITLE;
                $data['mbody'] = JSON_TAG_NOTIFICATION_BODY;
                $data['mdesc'] = $shared_insight_msg;               
                
                foreach($result as $resultData) { 
                   if($platformId === 0) {                        
                        $notificationResult = $pushNotification->iOS($data,$resultData['flddeviceid']);
                    } else if($platformId === 1) { 
                        $notificationResult = $pushNotification->android($data,$resultData['flddeviceid']);
                    }
                }
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
                
    }
    
    /**
     * Function used to send email  for shared insight notification
     *
     * @param $token
     * @param $to
     *
     * @return int
     */
    private function send_new_insight_shared_notification_mail($insight_name, $shared_insight_msg, $to)
    {
        $Mail    = new CORESendMail();
        $subject = 'Audvisor - Insight shared with you';
        $message = "Audvisor - Insight shared with you message goes here";
        $headers = 'From: '.NO_REPLY_EMAIL_FROM_ADDRESS."\r\n";

        return $Mail->sendEmail($to, $subject, $message, $headers);
//        return true;
    }

}

?>
