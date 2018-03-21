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

class COREInsightDB
{

    public function __construct()
    {
    }

    /**
     * Function used to get all insight details for cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function all_insights($ConnBean,$clientId)
    {

        $s3Bridge  = new COREAwsBridge();
        $ConnBean1 = new COREDbManager();
        $iResult   = array();
        try
        {
            $sQuery = "SELECT i.fldid, i.fldname , i.fldinsighturl,i.fldinsightvoiceoverurl, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,tr.fldrating, i.fldexpertid expert_id,i.fldcreateddate,i.fldmodifieddate,i.fldisonline,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldavatarurl,e.fldid AS expert_id,e.fldprefix,CONCAT(e.fldfirstname,' ',e.fldlastname) AS expert_name,group_concat(concat_ws(',',top.fldid,top.fldname) SEPARATOR ';') AS topics FROM tblinsights i LEFT JOIN tblinsightreputation tr ON i.fldid=tr.fldinsightid LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid WHERE i.fldisdeleted = 0 AND i.client_id = :client_id GROUP BY i.fldid ORDER BY i.fldcreateddate DESC ";
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
                $streamingUrl                   = empty($insight[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insight[DB_COLUMN_FLD_STREAMING_FILENAME],$clientId);
                $streamingFileNamehlsv4         = empty($insight[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insight[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$clientId);
                foreach($topics as $topic)
                {
                    $temptopic                         = explode(",", $topic);
                    $topicdetails[JSON_TAG_TOPIC_ID]   = intval($temptopic[0]);
                    $topicdetails[JSON_TAG_TOPIC_NAME] = (string)$temptopic[1];
                    $initialResult[JSON_TAG_TOPICS][]  = $topicdetails;
                }
                $expert[JSON_TAG_ID]          = $insight[JSON_TAG_EXPERT_ID];
                $expert[JSON_TAG_EXPERT_NAME] = $insight[DB_COLUMN_FLD_PREFIX].' '.$insight[JSON_TAG_EXPERT_NAME];

                $expert[JSON_TAG_EXPERT_IMAGE] = empty($insight[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3Bridge->GetS3ExpertAvatarURL($insight[DB_COLUMN_FLD_AVATAR_URL],$clientId);

                $expert[JSON_TAG_AVATAR_LINK] = $expert[JSON_TAG_EXPERT_IMAGE];
                if($sVoiceover != null && $sVoiceover != "")
                {
                    $sVoiceover = $s3Bridge->GetInsightVoiceOverURL($sVoiceover,$clientId);
                }
                
                $streamingUrl_enc = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $streamingFileNamehlsv4_enc = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_INSIGHT_ID => intval($insight[DB_COLUMN_FLD_ID]), JSON_TAG_INSIGHT_NAME => (string)$insight[DB_COLUMN_FLD_NAME], JSON_TAG_INSIGHT_URL => (string)$insight[DB_COLUMN_FLD_INSIGHT_URL], JSON_TAG_INSIGHT_VOICE_OVER_URL => (string)$sVoiceover, JSON_TAG_EXPERT_ID => intval($insight[JSON_TAG_EXPERT_ID]), JSON_TAG_CREATED_DATE => (string)$insight[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => (string)$insight[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_ISONLINE => $insight[DB_COLUMN_FLD_ISONLINE], JSON_TAG_RATING => $insight[DB_COLUMN_FLD_RATING], JSON_TAG_EXPERT => $expert, JSON_TAG_TOPICS => $initialResult[JSON_TAG_TOPICS], JSON_TAG_STREAMINGURL_ENC =>$streamingUrl_enc, JSON_TAG_STREAMING_FILENAME_V4_ENC => $streamingFileNamehlsv4_enc);
                
                $iResult[JSON_TAG_STATUS] = 0;
                $i++;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_STATUS] = 3;
        }

        return $iResult;
    }

    /**
     * Function used to get all insight details.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function insights($ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $s3bridge = new COREAwsBridge();
            $sQuery   = "SELECT fldid, fldname , fldinsighturl, fldstreamingfilename,fldstreamingfilenamehlsv4,fldduration, fldexpertid,fldcreateddate,fldmodifieddate,fldstreamingfilename_enc, fldstreamingfilenamehlsv4_enc   FROM tblinsights WHERE fldisdeleted = 0 and fldisonline = 1 and (client_id = '$clientId' OR client_id = 'audvisor11012017')";

            $ConnBean->getPreparedStatement($sQuery);
            $aResult = $ConnBean->resultset();
            $i       = 0;
            foreach($aResult as $insight)
            {
                /* here getting the topic names list */
                $streamingUrl_enc = empty($insight['fldstreamingfilename_enc']) ? null : $insight['fldstreamingfilename_enc'];
                $streamingFileNamehlsv4_enc = empty($insight['fldstreamingfilenamehlsv4_enc']) ? null : $insight['fldstreamingfilenamehlsv4_enc'];

                $link                                              = API_BASE_URL_STRING.API_VERSION.'/insights/'.$insight[DB_COLUMN_FLD_ID];
                $iResult[JSON_TAG_RECORDS][]                       = array(JSON_TAG_LINK => $link, JSON_TAG_TYPE => JSON_TAG_INSIGHT, JSON_TAG_ID => $insight[DB_COLUMN_FLD_ID], JSON_TAG_TITLE => $insight[DB_COLUMN_FLD_NAME], JSON_TAG_INSIGHT_URL => $insight[DB_COLUMN_FLD_INSIGHT_URL], JSON_TAG_INSIGHT_DURATION => $insight[DB_COLUMN_FLD_INSIGHT_DURATION], JSON_TAG_EXPERT_ID => $insight[DB_COLUMN_FLD_EXPERT_ID], JSON_TAG_CREATED_DATE => $insight[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $insight[DB_COLUMN_FLD_MODIFIED_DATE],'client_id' => $clientId,JSON_TAG_STREAMINGURL_ENC => $streamingUrl_enc,JSON_TAG_STREAMING_FILENAME_V4_ENC => $streamingFileNamehlsv4_enc);
                $iResult[JSON_TAG_STATUS]                          = 0;
                $topicdetails                                      = array();
                $topicdetails                                      = null;
                $iResult[JSON_TAG_RECORDS][$i][JSON_TAG_TOPIC_IDS] = $topicdetails;
                $tQuery                                            = 'SELECT t.fldid, t.fldname FROM tbltopicinsight AS m INNER JOIN tbltopics AS t ON t.fldid = m.fldtopicid INNER JOIN tblinsights AS i ON i.fldid = m.fldinsightid WHERE i.fldid = :insightid ';
                $ConnBean->getPreparedStatement($tQuery);
                $ConnBean->bind_param(':insightid', $insight[DB_COLUMN_FLD_ID]);
                $topics       = $ConnBean->resultset();
                $topicdetails = array();
                foreach($topics as $topic)
                {
                    array_push($topicdetails, $topic[DB_COLUMN_FLD_ID]);
                }
                $iResult[JSON_TAG_RECORDS][$i][JSON_TAG_TOPIC_IDS] = $topicdetails;
                $i++;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }
        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_STATUS] = 3;
        }

        return $iResult;
    }

    /**
     * Function used to create new insight.
     *
     * @param $ConnBean
     * @param $insight_name
     * @param $sTopicId
     * @param $expert_id
     * @param $rating
     *
     * @return array
     */
    public function insertInsight($ConnBean, $insight_name, $sTopicId, $expert_id, $rating,$sFbDesc,$clientId,$group_id,$sPlayListIds)
    {
        $aResult = array();
        try
        {

            $sQuery = "INSERT INTO tblinsights (fldname,fldexpertid,fldfbsharedescription,fldcreateddate,client_id,group_id) VALUES (:insightname,:expertid,:fbdesc,NOW(),:client_id,:group_id)";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":insightname", $insight_name);
            $ConnBean->bind_param(":expertid", $expert_id);
            $ConnBean->bind_param(":fbdesc", $sFbDesc);
            $ConnBean->bind_param(":client_id", $clientId);
            $ConnBean->bind_param(":group_id", $group_id);
            $ConnBean->execute();
            $insightid = $ConnBean->lastInsertId();
            $sQuery    = "INSERT INTO tblinsightreputation (fldinsightid,fldrating) VALUES (:insightid,:rating)";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":insightid", $insightid);
            $ConnBean->bind_param(":rating", $rating);
            $ConnBean->execute();
            $aResult[JSON_TAG_ID] = $insightid;
            $tsize                = sizeof($sTopicId);
            for($i = 0; $i < $tsize; $i++)
            {
                $TQuery = "INSERT INTO tbltopicinsight (fldinsightid,fldtopicid) VALUES (:insightid,:topicid)";
                $ConnBean->getPreparedStatement($TQuery);
                $ConnBean->bind_param(":insightid", $insightid);
                $ConnBean->bind_param(":topicid", $sTopicId[$i][0]);
                $ConnBean->execute();
            }
            $playlistidsize                = sizeof($sPlayListIds);
            if($playlistidsize > 0) {
                for($i = 0; $i < $playlistidsize; $i++)
                {
                    $TQuery = "INSERT INTO tblplaylistinsights (playlist_id,insight_id,status) VALUES (:playlist_id,:insight_id,:status)";
                    $ConnBean->getPreparedStatement($TQuery);
                    $ConnBean->bind_param(":playlist_id", $sPlayListIds[$i][0]);
                    $ConnBean->bind_param(":insight_id", $insightid);
                    $ConnBean->bind_param(":status", 1);
                    $ConnBean->execute();
                }
            }

            $aResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 1;
        }

        return $aResult;
    }

    /**
     * Function used to delete insight.
     *
     * @param $insightid
     * @param $ConnBean
     *
     * @return int
     */
    public function deleteInsight($insightid, $ConnBean)
    {
        $iResult = 1;
        try
        {
            $redis  = CORERedisConnection::getRedisInstance();
            $sQuery = "UPDATE tblinsights SET fldisdeleted = 1 WHERE fldid= :insightid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":insightid", $insightid);
            $updateInsight = $ConnBean->execute();

            if($redis && $updateInsight)
            {
                $this->invalidateCache($redis);
            }
        
            $DQuery = "DELETE FROM tbltopicinsight WHERE fldinsightid= :insightid";
            $ConnBean->getPreparedStatement($DQuery);
            $ConnBean->bind_param(":insightid", $insightid);
            $ConnBean->execute();

            $fQuery = "DELETE FROM tblfavourites WHERE fldinsightid= :insightid";
            $ConnBean->getPreparedStatement($fQuery);
            $ConnBean->bind_param(":insightid", $insightid);
            $ConnBean->execute();
            
            $DQuery1 = "DELETE FROM tblplaylistinsights WHERE insight_id= :insightid";
            $ConnBean->getPreparedStatement($DQuery1);
            $ConnBean->bind_param(":insightid", $insightid);
            $ConnBean->execute();

        }
        catch(Exception $e)
        {
            $iResult = 0;
        }

        return $iResult;
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $inConnBean
     * @param $sInsightName
     * @param $sTopicId
     * @param $sExpertId
     * @param $sInsightId
     * @param $rating
     *
     * @return array
     */
    public function edit_insight($inConnBean, $sInsightName, $sTopicId, $sExpertId, $sInsightId, $rating,$sFbsharedesc,$sPlayListIds)
    {
        try
        {
        
            $aResult = array();
            $redis   = CORERedisConnection::getRedisInstance();

            $sQuery = "UPDATE tblinsights SET fldname = :insightname, fldexpertid = :expertid , fldfbsharedescription = :fbsharedesc WHERE fldid = :insightid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":insightname", $sInsightName);
            $inConnBean->bind_param(":expertid", $sExpertId);
            $inConnBean->bind_param(":fbsharedesc", $sFbsharedesc);
            $inConnBean->bind_param(":insightid", $sInsightId);
            $updateInsight = $inConnBean->execute();

            $sQuery = "UPDATE tblinsightreputation SET fldrating= :rating WHERE fldinsightid = :insightid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":rating", $rating);
            $inConnBean->bind_param(":insightid", $sInsightId);
            $updateStaticReputation = $inConnBean->execute();

            if($redis && ($updateInsight || $updateStaticReputation))
            {
                $this->invalidateCache($redis);
            }

            $DQuery = "DELETE FROM tbltopicinsight WHERE fldinsightid= :insightid";
            $inConnBean->getPreparedStatement($DQuery);
            $inConnBean->bind_param(":insightid", $sInsightId);
            $inConnBean->execute();
            for($i = 0; $i < sizeof($sTopicId); $i++)
            {
                $TQuery = "INSERT INTO tbltopicinsight (fldtopicid,fldinsightid) VALUES (:topicid,:insightid)";
                $inConnBean->getPreparedStatement($TQuery);
                $inConnBean->bind_param(":topicid", $sTopicId[$i][0]);
                $inConnBean->bind_param(":insightid", $sInsightId);
                $inConnBean->execute();
            }
            
            $DQuery1 = "DELETE FROM tblplaylistinsights WHERE insight_id= :insightid";
            $inConnBean->getPreparedStatement($DQuery1);
            $inConnBean->bind_param(":insightid", $sInsightId);
            $inConnBean->execute();
            
            $playlistidsize                = sizeof($sPlayListIds);  

            if($playlistidsize > 0) {
                for($i = 0; $i < $playlistidsize; $i++)
                {
                    $TQuery = "INSERT INTO tblplaylistinsights (playlist_id,insight_id,status) VALUES (:playlist_id,:insight_id,:status)";
                    $inConnBean->getPreparedStatement($TQuery);
                    $inConnBean->bind_param(":playlist_id", $sPlayListIds[$i][0]);
                    $inConnBean->bind_param(":insight_id", $sInsightId);
                    $inConnBean->bind_param(":status", 1);
                    $inConnBean->execute();
                }
            }
            
            
            $aResult[JSON_TAG_DATA] = array(JSON_TAG_INSIGHT_ID => $sInsightId, JSON_TAG_INSIGHT_NAME => $sInsightName, JSON_TAG_TOPIC_IDS => $sTopicId, JSON_TAG_EXPERT_ID => $sExpertId, JSON_TAG_RATING => $rating);

            $status = 0;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $status = 2;
        }
        $aResult[JSON_TAG_STATUS] = $status;

        return $aResult;
    }

    /**
     * Function used to  update  Streaming url of an insight.
     *
     * @param $inConnBean
     * @param $insightid
     * @param $streamingurl
     * @param $uploaddir
     * @param $insightplaytime
     *
     * @return bool
     */
    public function patchStreamingURL($inConnBean, $insightid, $streamingfile, $uploaddir, $insightplaytime)
    {       
        
        
        if(empty($streamingfile['HLSv3_enc'])) {
            $streamingfile['HLSv3_enc'] = '';
        }
        if(empty($streamingfile['HLSv4_enc'])) {
            $streamingfile['HLSv4_enc'] = '';
        }
        if(empty($streamingfile['HLSv3_short_code'])) {
            $streamingfile['HLSv3_short_code'] = '';
        }
        if(empty($streamingfile['HLSv4_short_code'])) {
            $streamingfile['HLSv4_short_code'] = '';
        }
        $bResult = false;
        try
        {
            $sQuery = "UPDATE tblinsights SET fldstreamingurl= :streamingurl, fldstreamingfilename = :streamingfile,fldstreamingfilenamehlsv4 = :streamingfilenamehlsv4, fldstreamingfilename_enc = :streamingfile_enc,fldstreamingfilenamehlsv4_enc = :streamingfilenamehlsv4_enc,fldinsighturl = :insighturl ,fldduration = :duration, fldstreamingfilename_short_code = :streamingfile_short_code,fldstreamingfilenamehlsv4_short_code = :streamingfilenamehlsv4_short_code WHERE fldid = :insightid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":streamingurl", $streamingfile['legacy']);
            $inConnBean->bind_param(":streamingfile", $streamingfile['HLSv3']);
            $inConnBean->bind_param(":streamingfilenamehlsv4", $streamingfile['HLSv4']);
            $inConnBean->bind_param(":streamingfile_enc", $streamingfile['HLSv3_enc']);
            $inConnBean->bind_param(":streamingfilenamehlsv4_enc", $streamingfile['HLSv4_enc']);
            $inConnBean->bind_param(":streamingfile_short_code", $streamingfile['HLSv3_short_code']);
            $inConnBean->bind_param(":streamingfilenamehlsv4_short_code", $streamingfile['HLSv4_short_code']);
            $inConnBean->bind_param(":insighturl", $uploaddir);
            $inConnBean->bind_param(":duration", $insightplaytime);
            $inConnBean->bind_param(":insightid", $insightid);
            $bResult = $inConnBean->execute();
        }
        catch(Exception $e)
        {
        }

        return $bResult;
    }

    /**
     * Function to list individual insight details.
     *
     * @param $ConnBean
     * @param $insightid
     *
     * @return mixed
     */
    public function list_insight_by_id($ConnBean, $insightid)
    {
        $s3bridge                      = new COREAwsBridge();
        $finalResult[JSON_TAG_RECORDS] = array();
        $initialResult                 = array();

        $ifldID         = "";
        $ifldName       = "";
        $fldDescription = "";
        $sS3AvatarUrl   = "";
        
                           $insightsList = array();
        $topics       = array();
        $experts      = array();
        $iResult      = array(JSON_TAG_TYPE => JSON_TAG_INSIGHT);
        $allExperts   = array();
        $allTopics    = array();

        try
        {
            $sQuery = "SELECT i.client_id, i.fldid AS insight_id, i.fldname insight_name,i.fldinsightvoiceoverurl,e.fldvoiceoverurl, i.fldcreateddate,i.fldduration, i.fldinsighturl,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,  e.fldid AS expertid, e.fldfirstname, e.fldlastname, e.fldtitle,e.flddescription, e.fldavatarurl, e.fldbioimage, e.fldthumbimage, e.fldpromoimage, e.fldpromotitle,e.fldtwitterhandle, group_concat(concat_ws(',',top.fldid,top.fldname,top.fldiconurl) SEPARATOR ';') AS topics FROM tblinsights AS i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid  WHERE i.fldid = ? AND i.fldisdeleted = 0 AND top.fldisdeleted = 0 AND i.fldisonline = 1";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param('1', $insightid);
            $bResult           = $ConnBean->single();
            $s3bridge          = new COREAwsBridge();
            $sInsightVoiceover = $bResult[DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL];
            $sInsightVoiceoverClientId = $bResult['client_id'];
            if($sInsightVoiceover == null || $sInsightVoiceover == "")
            {
                $sInsightVoiceOverUrl = null;
            }
            else
            {                
                $sInsightVoiceOverUrl = $s3bridge->GetInsightVoiceOverURL($sInsightVoiceover,$sInsightVoiceoverClientId);
            }
            $sExpertVoiceover = empty($bResult[DB_COLUMN_FLD_VOICEOVER_URL]) ? null : $s3bridge->GetExpertVoiceOverURL($bResult[DB_COLUMN_FLD_VOICEOVER_URL],$sInsightVoiceoverClientId);

            $sS3AvatarUrl = empty($bResult[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($bResult[DB_COLUMN_FLD_AVATAR_URL],$sInsightVoiceoverClientId);

            $initialResult[JSON_TAG_TYPE]                   = JSON_TAG_INSIGHT;
            $initialResult[JSON_TAG_ID]                     = $bResult[JSON_TAG_INSIGHT_ID];
            $initialResult[JSON_TAG_TITLE]                  = $bResult[JSON_TAG_INSIGHT_NAME];
            $initialResult[JSON_TAG_INSIGHT_DURATION]       = $bResult[DB_COLUMN_FLD_INSIGHT_DURATION];
            $initialResult[JSON_TAG_INSIGHT_VOICE_OVER_URL] = $sInsightVoiceOverUrl;
            $initialResult[JSON_TAG_INSIGHT_URL]            = isset($bResult[DB_COLUMN_FLD_INSIGHT_URL])?$s3bridge->GetS3MasterInsightURL($bResult[DB_COLUMN_FLD_INSIGHT_URL]):"";
            $initialResult[JSON_TAG_STREAMINGURL_ENC]       = empty($bResult['fldstreamingfilename_enc']) ? null : $bResult['fldstreamingfilename_enc'];
            $initialResult[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($bResult['fldstreamingfilenamehlsv4_enc']) ? null : $bResult['fldstreamingfilenamehlsv4_enc'];
            
            $expertName                                     = $bResult[DB_COLUMN_FLD_FIRST_NAME].' '.$bResult[DB_COLUMN_FLD_LAST_NAME];
            $images[]                                       = $bResult[DB_COLUMN_FLD_AVATAR_URL];
            $images[]                                       = $bResult[DB_COLUMN_FLD_BIO_IMAGE];
            $images[]                                       = $bResult[DB_COLUMN_FLD_THUMB_IMAGE];
            $images[]                                       = $bResult[DB_COLUMN_FLD_PROMO_IMAGE];
            $images                                         = array_values(array_filter($images));
            $sAvatarUrls                                    = $s3bridge->GetS3ExpertAvatarURLs($images,$sInsightVoiceoverClientId);

            $initialResult[JSON_TAG_EXPERT] = array(JSON_TAG_ID                     => $bResult[DB_COLUMN_FLD_EXPERTID],
                                                    JSON_TAG_TITLE                  => $expertName,
                                                    JSON_TAG_SUBTITLE               => $bResult[DB_COLUMN_FLD_TITLE],
                                                    JSON_TAG_LINK                   => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$bResult[DB_COLUMN_FLD_EXPERTID].'',
                                                    JSON_TAG_EXPERT_VOICE_OVER_URL  => $sExpertVoiceover,
                                                    JSON_TAG_AVATAR_LINK            => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_AVATAR_URL]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_AVATAR_URL]] : null,
                                                    JSON_TAG_EXPERT_BIO_IMAGE       => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_BIO_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_BIO_IMAGE]] : null,
                                                    JSON_TAG_EXPERT_THUMBNAIL_IMAGE => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_THUMB_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_THUMB_IMAGE]] : null,
                                                    JSON_TAG_EXPERT_PROMO_IMAGE     => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_PROMO_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_PROMO_IMAGE]] : null,
                                                    JSON_TAG_EXPERT_BIO             => $bResult[DB_COLUMN_FLD_DESCRIPTION],
                                                    JSON_TAG_EXPERT_PROMO_TITLE     => $bResult[DB_COLUMN_FLD_PROMO_TITLE],
                                                    JSON_TAG_TWITTER_HANDLE         => isset($bResult[DB_COLUMN_FLD_TWITTER_HANDLE]) ? $bResult[DB_COLUMN_FLD_TWITTER_HANDLE] : "");

            $topicslist = $bResult[JSON_TAG_TOPICS];
            $topics     = array();
            $topics     = explode(";", $topicslist);
            $tmp_topics_ids = '';
            foreach($topics as $topic)
            {

                $temp = explode(",", $topic);

                $topicdetails[JSON_TAG_ID]        = $temp[0];
                $topicdetails[JSON_TAG_TITLE]     = $temp[1];
                $initialResult[JSON_TAG_TOPICS][] = $topicdetails;
                
                /*********************/
                // Set Response like Recommendation API -  Start
                /*********************/
                $tmp_topics_ids .= $temp[0].",";
                $topicsInfo[$temp[0]] = array(
                    JSON_TAG_ID => intval($temp[0]), 
                    JSON_TAG_TITLE => $temp[1],
                    JSON_TAG_FLD_TOPIC_ICON => (!empty($temp[2])) ? $s3bridge->GetS3TopicIconURL($temp[2],$sInsightVoiceoverClientId) : NULL
                    );
                /*********************/
                // Set Response like Recommendation API -  End
                /*********************/
                
            }
            $finalResult[JSON_TAG_RECORDS][] = $initialResult; // comment this line for response format like recommendation api
            if($bResult)
            {
                $finalResult[JSON_TAG_STATUS] = 0;
            }
            else
            {
                $finalResult[JSON_TAG_STATUS] = 1;
            }
            
            /*********************/
            // Set Response like Recommendation API -  Start
            /*********************/
            /*
            $allinsights = array(
                    JSON_TAG_ID => $bResult[JSON_TAG_INSIGHT_ID], 
                    JSON_TAG_TITLE => $bResult[JSON_TAG_INSIGHT_NAME], 
                    JSON_TAG_CREATED_DATE => $bResult[DB_COLUMN_FLD_CREATED_DATE], 
                    JSON_TAG_INSIGHT_DURATION => $bResult[DB_COLUMN_FLD_INSIGHT_DURATION],
                    JSON_TAG_INSIGHT_URL => isset($bResult[DB_COLUMN_FLD_INSIGHT_URL])?$s3bridge->GetS3MasterInsightURL($bResult[DB_COLUMN_FLD_INSIGHT_URL]):"",
                    JSON_TAG_STREAMINGURL_ENC => empty($bResult['fldstreamingfilename_enc']) ? null : $bResult['fldstreamingfilename_enc'],
                    JSON_TAG_STREAMING_FILENAME_V4_ENC => empty($bResult['fldstreamingfilenamehlsv4_enc']) ? null : $bResult['fldstreamingfilenamehlsv4_enc'],
                    JSON_TAG_TOPIC_IDS => !empty($tmp_topics_ids) ? substr($tmp_topics_ids,0,-1) : ''
                );                    
                    
            array_push($insightsList, $allinsights);
                
            $expertsInfo[$bResult[DB_COLUMN_FLD_EXPERTID]] = array(
                    JSON_TAG_ID                     => intval($bResult[DB_COLUMN_FLD_EXPERTID]), 
                    JSON_TAG_TITLE                  => $expertName, 
                    JSON_TAG_SUBTITLE               => $bResult[DB_COLUMN_FLD_TITLE], 
                    JSON_TAG_LINK                   => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$bResult[DB_COLUMN_FLD_EXPERTID].'',
                    JSON_TAG_AVATAR_LINK            => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_AVATAR_URL]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_AVATAR_URL]] : null,
                    JSON_TAG_EXPERT_BIO_IMAGE       => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_BIO_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_BIO_IMAGE]] : null,
                    JSON_TAG_EXPERT_THUMBNAIL_IMAGE => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_THUMB_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_THUMB_IMAGE]] : null,
                    JSON_TAG_EXPERT_PROMO_IMAGE     => isset($sAvatarUrls[$bResult[DB_COLUMN_FLD_PROMO_IMAGE]]) ? $sAvatarUrls[$bResult[DB_COLUMN_FLD_PROMO_IMAGE]] : null,
                    JSON_TAG_EXPERT_BIO             => $bResult[DB_COLUMN_FLD_DESCRIPTION],
                    JSON_TAG_EXPERT_PROMO_TITLE     => $bResult[DB_COLUMN_FLD_PROMO_TITLE],
                    JSON_TAG_TWITTER_HANDLE         => isset($bResult[DB_COLUMN_FLD_TWITTER_HANDLE]) ? $bResult[DB_COLUMN_FLD_TWITTER_HANDLE] : "",
                    JSON_TAG_EXPERT_VOICE_OVER_URL  => $sExpertVoiceover
                    );
            
                
            $iResult[JSON_TAG_INSIGHTS] = $insightsList;
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
            
            $finalResult[JSON_TAG_RECORDS][] = $iResult;
            */
            /*********************/
            // Set Response like Recommendation API -  End
            /*********************/
        }
        catch(Exception $ex)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $finalResult;
    }

    /**
     * Function to get streaming URL.
     *
     * @param $insightID
     *
     * @return array
     */
    public function getStreamingUrl($insightID)
    {
        $ConnBean = new COREDbManager();
        $iResult  = array();
        try
        {
            $sQuery = "SELECT client_id,fldname, fldstreamingfilename,fldstreamingfilenamehlsv4,fldstreamingfilename_enc, fldstreamingfilenamehlsv4_enc, fldstreamingurl_enc FROM tblinsights WHERE fldisdeleted = 0 AND fldid = :fldid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldid', $insightID);
            $aInsight                    = $ConnBean->single();
            $s3bridge                    = new COREAwsBridge();
            $streamingUrl                = empty($aInsight[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($aInsight[DB_COLUMN_FLD_STREAMING_FILENAME],$aInsight[DB_COLUMN_FLD_CLIENT_ID]);
            $streamingFileNamehlsv4      = empty($aInsight[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($aInsight[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$aInsight[DB_COLUMN_FLD_CLIENT_ID]);
            
            
            $streamingUrl_enc = empty($aInsight['fldstreamingfilename_enc']) ? null : $aInsight['fldstreamingfilename_enc'];
            $streamingFileNamehlsv4_enc = empty($aInsight['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
            $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_STREAMINGURL_ENC => $streamingUrl_enc, JSON_TAG_STREAMING_FILENAME_V4_ENC => $streamingFileNamehlsv4_enc, JSON_TAG_TITLE => $aInsight[DB_COLUMN_FLD_NAME]);
            $iResult[JSON_TAG_STATUS]    = 0;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }
        $ConnBean = null;
        if($aInsight[DB_COLUMN_FLD_NAME] == null)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_ERRORCODE_INVALID_INSIGHT;
        }

        return $iResult;
    }

    /**
     * Function used to update the online status of insight.
     *
     * @param $ConnBean
     * @param $insight_id
     *
     * @return array
     */
    public function onlineInsight($ConnBean, $insight_id)
    {
        $aResult = array();

        try
        {
            $sQuery = "SELECT fldisonline,fldstreamingfilename,fldinsighturl FROM tblinsights WHERE fldid= :insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':insightid', $insight_id);
            $bResult      = $ConnBean->single();
            $s3bridge     = new COREAwsBridge();
            $streamingUrl = empty($bResult[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($bResult[DB_COLUMN_FLD_STREAMING_FILENAME]);
            if($streamingUrl == null || $streamingUrl == "")
            {
                $aResult['result'] = ERRCODE_INVALID_STREAMING_URL;
            }
            else
            {
                $iResult = !(intval($bResult[DB_COLUMN_FLD_ISONLINE]));
                $redis   = CORERedisConnection::getRedisInstance();
                $sQuery  = "UPDATE tblinsights SET fldisonline = :online WHERE fldid = :insightid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(':online', $iResult);
                $ConnBean->bind_param(':insightid', $insight_id);
                $bResult = $ConnBean->execute();
                if($bResult)
                {
                    if($redis)
                    {
                        $this->invalidateCache($redis);
                    }
                    $aResult['result']        = $iResult;
                    $aResult[JSON_TAG_STATUS] = 0;

                    return $aResult;
                }
            }

            $aResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 1;
        }

        return $aResult;
    }

    /**
     * Function used to  make an insight liked by user.
     *
     * @param $ConnBean
     * @param $insightId
     * @param $consumerId
     *
     * @return mixed
     */
    public function insight_like($ConnBean, $insightId, $consumerId)
    {
        $finalResult[JSON_TAG_RECORDS] = array();
        $consumerDB = new COREConsumerDB();
        try
        {
            $iCount = 0;
            $sQuery = "SELECT COUNT(*) AS count FROM tblconsumers WHERE fldid = :fldid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldid', $consumerId);
            $consumerCount = $ConnBean->single();
            $sQuery        = "SELECT COUNT(*) AS count FROM tblinsights WHERE fldid = :fldid AND fldisonline = 1 AND fldisdeleted = 0";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldid', $insightId);
            $ConnBean->execute();
            $iCount = $ConnBean->single();
            if($iCount['count'] && $consumerCount[JSON_TAG_COUNT])
            {
                $sQuery = "INSERT INTO tblinsightlikes (fldconsumerid, fldinsightid, fldcreateddate) VALUES (:consumerid, :insightid,  NOW())";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(':consumerid', $consumerId);
                $ConnBean->bind_param(':insightid', $insightId);
                $ConnBean->execute();
                $insightInserted = $ConnBean->rowCount();

                /*$consumerAnalyticsQuery = "INSERT INTO tblconsumeranalytics (fldreceiverid, fldactionid, fldactiondata, fldconsumerid, fldreceivertype, fldcreateddate) values (:receiverid, :actionid, :actiondata, :consumerid, :receivertype, NOW())";
                $ConnBean->getPreparedStatement($consumerAnalyticsQuery);
                $ConnBean->bind_param(':receiverid', $insightId);
                $ConnBean->bind_param(':actionid', 6);
                $ConnBean->bind_param(':actiondata', 0);
                $ConnBean->bind_param(':consumerid', $consumerId);
                $ConnBean->bind_param(':receivertype', 1);
                $ConnBean->execute();
                $consumerAnalyticsRowInserted = $ConnBean->rowCount();*/

                if($insightInserted)//&& $consumerAnalyticsRowInserted)
                {
                    $iResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
                }
                else
                {
                    $iResult[JSON_TAG_STATUS] = ERROR_CODE_INSIGHT_INSERT_FAIL;
                }
                $ConnBean = null;
            }
            else
            {
                $iResult[JSON_TAG_STATUS] = ERROR_CODE_INSIGHT_NOT_AVAILABLE;
                if($iCount[JSON_TAG_COUNT])
                {
                    $iResult[JSON_TAG_STATUS] = ERRCODE_INVALID_CONSUMER;
                }
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
        
        return $iResult;
    }

    /**
     * Function used to  make an insight unliked by user.
     *
     * @param $consumerId
     * @param $insightId
     * @param $ConnBean
     *
     * @return array
     */
    public function insight_unlike($consumerId, $insightId, $ConnBean)
    {
        
        $iResult = array();
        try
        {
            $sQuery = "DELETE FROM tblinsightlikes WHERE fldinsightid = :insightid AND fldconsumerid = :consumerid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':insightid', $insightId);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $likedInsightDeleted = $ConnBean->execute();

            $deleteConsumerAnaltyicsQuery = "DELETE FROM tblconsumeranalytics WHERE fldreceiverid = :insightid AND fldconsumerid = :consumerid AND fldactionid = 6";
            $ConnBean->getPreparedStatement($deleteConsumerAnaltyicsQuery);
            $ConnBean->bind_param(':insightid', $insightId);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $consumerAnalyticsRowDeleted = $ConnBean->execute();

            if($likedInsightDeleted && $consumerAnalyticsRowDeleted)
            {
                $iResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
            }
            else
            {
                $iResult[JSON_TAG_STATUS] = ERROR_CODE_INSIGHT_NOT_DELETED;
            }
            $ConnBean = null;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $iResult;
    }
    
        /**
     * Function to list all liked insights.
     *
     * @param $consumerId
     * @param $ConnBean
     *
     * @return array
     */
    public function insight_likes_list($consumerId,$clientId,$ConnBean)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT fldinsightid insightid FROM tblinsightlikes WHERE fldconsumerid = :consumerid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $insights = $ConnBean->resultset();
            if(count($insights))
            {
                $iResult[JSON_TAG_STATUS]      = ERRCODE_NO_ERROR;
                $iResult[JSON_TAG_CONSUMER_ID] = $consumerId;
                foreach($insights as $insight)
                {
                    $iResult[JSON_TAG_RECORDS][] = $insight[DB_COLUMN_FLD_INSIGHT_ID];
                }
            }
            else
            {
                $iResult[JSON_TAG_STATUS]      = ERRCODE_NO_ERROR;
                $iResult[JSON_TAG_CONSUMER_ID] = $consumerId;
                $iResult[JSON_TAG_RECORDS][]  = "";
//                $iResult[JSON_TAG_STATUS] = ERROR_CODE_INSIGHT_NOT_AVAILABLE;
            }
            $ConnBean = null;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $iResult;
    }

    /**
     * Function to list all liked insights.
     *
     * @param $consumerId
     * @param $ConnBean
     *
     * @return array
     */
    public function get_insight_likes_list($consumerId,$clientId,$ConnBean, $page_no=1,$pegination=true)
    {
        $iResult = array();
        
        if($pegination === true) {            
            $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_LIMIT;            
        } else {
            $limit_start = 0;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_UNLIMITED;
        }
        
        try
        {
            $sQuery = "SELECT fldinsightid insightid FROM tblinsightlikes WHERE fldconsumerid = :consumerid   limit  $limit_start, " . $limit_end;
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $insights = $ConnBean->resultset();
            if(count($insights))
            {
                $iResult[JSON_TAG_STATUS]      = ERRCODE_NO_ERROR;
                $iResult[JSON_TAG_CONSUMER_ID] = $consumerId;
                
                $str_insightid = '';
                $inbox_flag = 0;
                $sort_by_ascending_order = 0;
                $playListId = null;
                $sort_by_field_name = null;
                
                foreach($insights as $insight)
                {
                    $iResult[JSON_TAG_RECORDS][] = $insight[DB_COLUMN_FLD_INSIGHT_ID];
                    $str_insightid .= $insight[DB_COLUMN_FLD_INSIGHT_ID] . ',';
                }

                if (!empty($str_insightid)) {
                    $inboxDB = new COREInboxDB();
                    $str_insightid = substr($str_insightid, 0, -1);
//                    $str_insightid = '2825,2811,2815';
                    
                    $iResult = array();
                    $iResult = $inboxDB->all_inbox_insights($ConnBean, $clientId, $str_insightid, $sort_by_field_name, $sort_by_ascending_order, $inbox_flag, $playListId);
                    
                }
            }
            else
            {
                $iStatus         = ERROR_CODE_INSIGHT_NOT_AVAILABLE;
                $sErrDescription = JSON_TAG_INSIGHT_NOT_AVAILABLE;
                
                $iResult[JSON_TAG_STATUS]      = ERRCODE_NO_ERROR;
                $iResult[JSON_TAG_STATUS]      = $iStatus;
                $iResult[JSON_TAG_CONSUMER_ID] = $consumerId;
                $iResult['insights'] = array();
                $iResult[JSON_TAG_DESC]  = JSON_TAG_INSIGHT_NOT_AVAILABLE;
            }
            
                $sQuery_total_count = "SELECT fldinsightid insightid FROM tblinsightlikes WHERE fldconsumerid = :consumerid ";
                $ConnBean->getPreparedStatement($sQuery_total_count);
                $ConnBean->bind_param(":consumerid", $consumerId);
                $ConnBean->execute();
                $sQuery_total_count = $ConnBean->rowCount();
                $total_page_nos = $sQuery_total_count / (int) $limit_end;
                $total_page_nos = ceil($total_page_nos);
//                       $iResult['sQuery_total_count'] = $sQuery_total_count;
//                       $iResult['total_page_nos'] = $total_page_nos;
                if ($page_no < $total_page_nos) {
                    $iResult['page_no'] = $page_no;
                }
            
              
                
            $ConnBean = null;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();exit;
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $iResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    public function recommended_insight($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge           = new COREAwsBridge();
        try
        {
            $expert_ids = null;
            $topics_ids = null;
            if($experts)
            {
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating ,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldexpertid IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            elseif($topics)
            {
                $topics_ids = implode(',', $topics);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle,  e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid  WHERE ti.fldtopicid IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            else
            {
                $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";   
            }
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();
            $iResult         = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts      = array();
            $allTopics       = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'];
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'];
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'];
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'];
            $sQuery                   = "SELECT  i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingurl, i.fldexpertid,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5)  AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $insightsWithConsumer = $ConnBean->resultset();
            $number_listened      = sizeof($insightsWithConsumer);

            foreach($insightsWithConsumer as $insight)
            {
                $expert = $insight['fldexpertid'];
                array_push($allExperts, $expert);
                $iTopics   = $this->get_topicids($ConnBean, $insight['fldid']);
                $allTopics = array_merge($allTopics, $iTopics);
            }

            $topExperts = $this->getTopExpertCount($allExperts);
            $topTopics  = $this->getTopTopicCount($allTopics);
            $count      = 0;
            $insights_count = 0;
            $str_topics_ids = '';
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);

                if($insights['fldid'])
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                }

                if($number_listened > $minimum_listened)
                {
                    foreach($topExperts as $key => $value)
                    {
                        $count = $count + 1;
                        if($count == 1 && $key == $insights['fldexpertid'])
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 2 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 3 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            elseif(strpos($position, '1') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($thirdMostListenedWeight / 100);
                            break;
                        }
                        else
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($fourthMostListenedWeight / 100);
                            break;
                        }
                    }
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    array_push($insightsList, $allinsights);
                    $insights_count++;
                }
                else
                {
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                    $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    array_push($insightsList, $allinsights);
                    $insights_count++;
                }
            }

            // sorting based on new static reputation value obtained using top listed expert or top listed topic
            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }

            $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList          = $this->process_advisor_rule($newInsightList);
            $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

            $expert_ids = implode(",", $experts);
            $sQuery     = "SELECT  fldid,fldprefix, fldfirstname, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

            $ConnBean->getPreparedStatement($sQuery);
            $allExpertsList = $ConnBean->resultset();
            $expertsInfo    = array();
            $experts_count = 0;
            foreach($allExpertsList as $experts)
            {
                $title = $experts['fldfirstname']." ".$experts['fldlastname'];
                if(!empty($experts[DB_COLUMN_FLD_PREFIX]))
                {
                    $title = $experts[DB_COLUMN_FLD_PREFIX]." ".$title;
                }
                $expertAvatar                   = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL]);
                $expertsInfo[$experts['fldid']] = array(JSON_TAG_ID => intval($experts['fldid']), JSON_TAG_TITLE => $title, JSON_TAG_SUBTITLE => $experts['fldtitle'], JSON_TAG_AVATAR_LINK => $expertAvatar);
                $experts_count++;
            }
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

            $topics_ids = implode(",", $topics);
            $sQuery     = "SELECT fldid, fldname from `tbltopics` WHERE `fldid` IN ($topics_ids)";
            $sQuery     = "SELECT fldid, fldname FROM `tbltopics`";

            $ConnBean->getPreparedStatement($sQuery);
            $allTopicsList = $ConnBean->resultset();
            $topicsInfo    = array();
            $topics_count = 0;
            foreach($allTopicsList as $topic)
            {
                $topicsInfo[$topic['fldid']] = array(JSON_TAG_ID => intval($topic['fldid']), JSON_TAG_TITLE => $topic['fldname']);
                $topics_count = 0;
            }
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
            $iResult['insights_count'] = $insights_count;
            $iResult['experts_count'] = $experts_count;
            $iResult['topics_count'] = $topics_count;
        }
        catch(Exception $e)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    public function recommended_insight_newcode($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$group_id=1,$page_no=1,$pegination=true,$selected_insights=array())
    {
        $tmp_count = 0;
        $selected_insights_response = array();
//        $selected_insight_ids = '630,730,2291';
        if(!empty($selected_insights)) {
            $tmp_count = count($selected_insights);
            $selected_insight_ids = implode(",",$selected_insights);
        }
        
        if($page_no === 1 && !empty($selected_insights)) { 
            $raw_response = true;
            $selected_insights_response = $this->list_insight_by_ids($ConnBean, $selected_insight_ids);        
        }

                
        if($pegination === true) {            
            $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            if(JSON_TAG_DISPLAY_INSIGHT_LIMIT > $tmp_count && $page_no == 1) {
                $limit_end -= $tmp_count;
            }            
                        
            if(!empty($selected_insights) && $page_no > 1 ) {                
                $limit_start -= $tmp_count;
            }
            
        } else {
            $limit_start = 0;
            $limit_end = JSON_TAG_DISPLAY_INSIGHT_UNLIMITED;
        }
        
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge           = new COREAwsBridge();
        $flag_shuffle       = true;
        try
        {
            $expert_ids = null;
            $topics_ids = null;
            
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$group_id."') OR (i.client_id='audvisor11012017'))";

            if(!empty($selected_insights) && is_array($selected_insights) ) {
                $where .= "AND i.fldid NOT IN (".$selected_insight_ids.")";
            }
            
            if($experts)
            {   
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + ( e.fldrating * $expertWeight )) AS static_rating, group_concat( ti.fldtopicid SEPARATOR ',' ) AS topics,i.client_id, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate, i.fldstreamingfilename, i.fldstreamingfilenamehlsv4, i.fldexpertid, i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights AS i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON ti.fldinsightid = i.fldid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid WHERE i.fldexpertid IN ($expert_ids ) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY  insight_listen_count ASC, static_rating DESC , i.fldid limit $limit_start, ".$limit_end;
                 
                 $sQuery_total_count     = "SELECT ((ir.fldrating * $insightWeight) + ( e.fldrating * $expertWeight )) AS static_rating, group_concat( ti.fldtopicid SEPARATOR ',' ) AS topics,i.client_id, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate, i.fldstreamingfilename, i.fldstreamingfilenamehlsv4, i.fldexpertid, i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights AS i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON ti.fldinsightid = i.fldid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid WHERE i.fldexpertid IN ($expert_ids ) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY  insight_listen_count ASC, static_rating DESC , i.fldid ";
            }
            elseif($topics)
            {  
                $topics_ids = implode(',', $topics);
                $sQuery     = "select * from (SELECT ((ir.fldrating*$insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, ti.fldtopicid as topics,i.client_id, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights AS i LEFT JOIN tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where."  ORDER BY  insight_listen_count ASC, static_rating DESC,i.fldid )as abcd where topics IN ($topics_ids)  limit $limit_start, ".$limit_end;
                
                $sQuery_total_count     = "select * from (SELECT ((ir.fldrating*$insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, ti.fldtopicid as topics,i.client_id, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights AS i LEFT JOIN tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where." ORDER BY  insight_listen_count ASC, static_rating DESC,i.fldid )as abcd where topics IN ($topics_ids) ";

            }
            else
            {   
                $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid  WHERE  i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY  insight_listen_count ASC, static_rating DESC,i.fldid  limit $limit_start,".$limit_end; 
                             
                $sQuery_total_count = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,(CASE WHEN lc.fldconsumerid = 30846 THEN lc.listencount ELSE 0 END) AS insight_listen_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid LEFT JOIN tbllistenedinsights AS lc ON i.fldid = lc.fldinsightid  WHERE  i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY  insight_listen_count ASC, static_rating DESC,i.fldid ";  
            }

            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            
            ///////////////
            $allInsightsList_count = $ConnBean->rowCount();  
//            if((int)$allInsightsList_count === 0) {
//                $iResult['type'] = "error";
//                $iResult['description'] = "111No Recommended insights available";
//                return $iResult;
//            }        
            ///////////////
            
            $insightsList = array();
            $topics       = array();
            $experts      = array();
            $iResult      = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts   = array();
            $allTopics    = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'] / 100;
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'] / 100;
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'] / 100;
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'] / 100;

            $sQuery = "SELECT  i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingurl, i.fldexpertid,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname,e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5)  AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $insightsWithConsumer = $ConnBean->resultset();

            $number_listened = sizeof($insightsWithConsumer);

            $insightIds = array();

            if($insightsWithConsumer)
            {
                foreach($insightsWithConsumer as $insight)
                {
                    $expert = $insight['fldexpertid'];
                    array_push($allExperts, $expert);
                    array_push($insightIds, $insight['fldid']);
                }

                $ids     = implode(",", $insightIds);
                $sQuery1 = "select fldtopicid from tbltopicinsight where fldinsightid in ($ids) group by fldtopicid order by count(fldtopicid) desc";
                $ConnBean->getPreparedStatement($sQuery1);
                $topTopicss = $ConnBean->resultset();

                $getIDs = function ($topics)
                {
                    return $topics['fldtopicid'];
                };

                $topTopics = array_map($getIDs, $topTopicss);
                $topTopics = array_slice($topTopics, 0, 3);

                $topExpertCount = array_count_values($allExperts);
                arsort($topExpertCount);
                $topExperts = array_keys($topExpertCount);
                $topExperts = array_slice($topExperts, 0, 3);
            }
            
            $displayed_insights_arr = array();
            $repeated_insight_arr = array();
            $repeated_insight_count = 0;
            
            $count = 0;
            $insights_count = 0;
            $str_topics_ids = '';
            if(!empty($allInsightsList)) {
                foreach($allInsightsList as $insights)
                {
                    if(!in_array($insights['fldid'],$displayed_insights_arr)) {
                        $displayed_insights_arr[]=$insights['fldid'];
                        $insights_count++;
                    } else {
                        $repeated_insight_arr[] = $insights['fldid'];
                        $repeated_insight_count++;
                        continue;
                    }

                    $expertid = $insights['fldexpertid'];
                    array_push($experts, $expertid);
                    $iTopics = explode(",", ($insights['topics']));
                    $str_topics_ids .= $insights['topics'].",";

                    if($number_listened > $minimum_listened)
                    {
                        $count          = $count + 1;
                        $exp_position   = array_search($expertid, $topExperts);
                        $topic_position = false;
                        foreach($iTopics as $topic)
                        {
                            $pos = array_search($topic, $topTopics);
                            if(FALSE !== $pos)
                            {
                                $topic_position = $pos;
                                break;
                            }
                        }

                        $multiplier_index = 3;
                        if(!($exp_position === false) && !($topic_position === false))
                        {
                            if($exp_position < $topic_position)
                            {
                                $multiplier_index = $exp_position;
                            }
                            else
                            {
                                $multiplier_index = $topic_position;
                            }
                        }
                        else
                        {
                            if(($exp_position === false) && ($topic_position === false))
                            {
                                $multiplier_index = 3;
                            }
                            elseif($exp_position === false)
                            {
                                $multiplier_index = $topic_position;
                            }
                            else
                            {
                                $multiplier_index = $exp_position;
                            }
                        }

                        if($multiplier_index < 3)
                        {
                            $weight = $multiplier_index ? (($multiplier_index == 1) ? ($secondMostListenedWeight) : ($thirdMostListenedWeight)) : ($firstMostListenedWeight);
                        }
                        else
                        {
                            $weight = $fourthMostListenedWeight;
                        }

                        $insights['static_rating'] = $insights['static_rating'] * $weight;
                    }
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME],$insights[DB_COLUMN_FLD_CLIENT_ID]); 
                    $streamingFileNamehlsv4 =empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$insights[DB_COLUMN_FLD_CLIENT_ID]);
                    $allinsights            = array(
                        JSON_TAG_ID => $insights['fldid'], 
                        JSON_TAG_TITLE => $insights['fldname'], 
                        JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], 
                        JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], 
                        JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], 
                        JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), 
                        JSON_TAG_TOPIC_IDS => $iTopics);

    //                if(!in_array($insights['fldid'],$displayed_insights_arr)) {
    //                    $displayed_insights_arr[]=$insights['fldid'];
    //                } else {
    //                    $repeated_insight_arr[] = $insights['fldid'];
    //                    $repeated_insight_count++;
    //                }


                    $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    $allinsights['insight_listen_count'] = intval($insights['insight_listen_count']);

                    array_push($insightsList, $allinsights);
    //                $insights_count++;
                }
            }
            
            if($page_no === 1 && !empty($selected_insights_response)) {                 
                foreach($selected_insights_response['experts'] as $tmp_expert_id => $tmp_expert_data) {
                    array_push($experts, $tmp_expert_id);
                }
                foreach($selected_insights_response['topics'] as $tmp_topic_id => $tmp_topic_data) {
                    $str_topics_ids .= $tmp_topic_id.",";
                }                
            }

            // sorting based on new static reputation value obtained using top listed expert or top listed topic

            
            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }

//            $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
//            $swapedInsightList          = $this->process_advisor_rule($newInsightList);
//            $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            
            // as anyways we need to shuffle the insights so above 3 lines for sorting the results are not needed anymore  - added on 22-Nov-2017
            $LimitedInsights = $insightsList;
            
            if($flag_shuffle === true) {
                // to shuffle the insights everytime -  added on 24-Oct-2017
                //  uksort($LimitedInsights, function() { return rand() > rand(); }); // by mainiting keys
                shuffle($LimitedInsights); // changing keys

                usort($LimitedInsights, function($a, $b) { //-  added on 22-Nov-2017
                    return $a['insight_listen_count'] - $b['insight_listen_count'];
                });
            }
            // Remove insight_listen_count from response - start
            foreach ($LimitedInsights as $key1 => $values) {
                foreach ($values as $key2 => $value) {
                    if($key2 === 'insight_listen_count') {
                        unset($LimitedInsights[$key1][$key2]);
                    }
                }
            }
            // Remove insight_listen_count from response - end

            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;
                  
            $expertsInfo = $this->getExpertDetails($ConnBean,$experts,$clientId);
            $topicsInfo = $this->getTopicsDetails($ConnBean,$topics,$str_topics_ids,$clientId);
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo['expertsInfo'];
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo['topicsInfo'];

            $iResult['insights_count'] = $insights_count;
            $iResult['experts_count'] = $expertsInfo['experts_count'];
            $iResult['topics_count'] = $topicsInfo['topics_count'];

            $ConnBean->getPreparedStatement($sQuery_total_count);
            $ConnBean->execute();
            $sQuery_total_count = $ConnBean->rowCount();  
            $total_page_nos = $sQuery_total_count / (int)$limit_end;
            $total_page_nos = ceil($total_page_nos);            
//            $iResult['sQuery_total_count'] = $sQuery_total_count;
//            $iResult['total_page_nos'] = $total_page_nos;
            if($page_no < $total_page_nos && $pegination === true) {
                $iResult['page_no'] = $page_no;
            }
            
            if(!empty($selected_insights_response)) {
               
                $iResult['insights_count'] += $selected_insights_response['insights_count'];
                //$iResult['experts_count'] += $selected_insights_response['experts_count'];
                //$iResult['topics_count'] += $selected_insights_response['topics_count'];;

                unset($selected_insights_response['insights_count']);
                unset($selected_insights_response['experts_count']);
                unset($selected_insights_response['topics_count']);

                $t2['experts'] = $selected_insights_response['experts'] + $iResult['experts'];
                $t2['topics'] = $selected_insights_response['topics'] + $iResult['topics'];
                $t1 = array_merge_recursive($selected_insights_response,$iResult);
//                $t1 = $selected_insights_response + $iResult;
                
                unset($t1['experts']);
                unset($t1['topics']);
                $t1['experts'] = $t2['experts'];
                $t1['topics'] = $t2['topics'];
                $iResult = array();
                $iResult = $t1;
            } 
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        if(!empty($iResult['insights_count'])) {
            $iResult['insights_count'] += $repeated_insight_count;
            $iResult['repeated_insight_count'] = $repeated_insight_count;
            $iResult['actual_insight_displayed_count'] = count($displayed_insights_arr);
        }
        
//        
//        print(' $displayed_insights_arr : <xmp>');
//        print_r($displayed_insights_arr);
//        print('<xmp>');
//        
//        print(' $repeated_insight_arr : <xmp>');
//        print_r($repeated_insight_arr);
//        print('<xmp>');
//        
//        print(' $repeated_insight_count : <xmp>');
//        print_r($repeated_insight_count);
//        print('<xmp>');
//        
//        die('1354');
        return $iResult;
    }

    /**
     * Function to get N number of insights for recommendation Engine.
     *
     * @param $ConnBean
     * @param $insightList
     *
     * @return array
     */
    function getLimitedInsights($ConnBean, $insightList)
    {
        $insightLimit            = $this->getGeneralSettings($ConnBean);
        $recommendedInsightLimit = $insightLimit['fldrecommendedinsightlimit'];
        $firstNInsights          = array_slice($insightList, 0, $recommendedInsightLimit);

        return $firstNInsights;
    }

    /**
     * Function to sort  recommended insights according to user actions.
     *
     * @param $ConnBean
     * @param $insightList
     * @param $consumer_id
     *
     * @return array
     */
    function sortInsightsBasedOnActionData($ConnBean, $insightList, $consumer_id)
    {

        $sQuery = "SELECT i.fldid FROM tblinsights i LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5 ) AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
        $ConnBean->getPreparedStatement($sQuery);
        $insightsWithConsumer = $ConnBean->resultset();

        $getIDs = function ($insights)
        {
            return $insights['fldid'];
        };

        $insightsWithConsumer = array_map($getIDs, $insightsWithConsumer);

        $appendInsight = array();
        foreach($insightList as $key => $insight)
        {
            unset($insightList[$key]['staticreputation']);

            if(in_array($insight['id'], $insightsWithConsumer, true))
            {
                $searchpos = array_search($insight['id'], $insightsWithConsumer);
                unset($insightsWithConsumer[$searchpos]);
                array_push($appendInsight, $insight);
                unset($insightList[$key]);
            }
        }
        $sortedList = array_merge($insightList, $appendInsight);

        return $sortedList;
    }

    /**
     * @param $topTopics
     * @param $insightTopics
     *
     * @return string
     */
    function compareTopicWithTopTopics($topTopics, $insightTopics)
    {
        foreach($insightTopics as $topic)
        {
            $pos [] = array_search($topic, array_keys($topTopics));
        }
        $position = implode(",", $pos);

        return $position;
    }

    /**
     * @param $experts
     *
     * @return array
     */
    function getTopExpertCount($experts)
    {
        $topExpertCount = array_count_values($experts);
        arsort($topExpertCount);

        return $topExpertCount;
    }

    /**
     * @param $alltopics
     *
     * @return array
     */
    function getTopTopicCount($alltopics)
    {
        $topTopicCount = array_count_values($alltopics);
        arsort($topTopicCount);

        return $topTopicCount;
    }

    /**
     * @param $ConnBean
     *
     * @return mixed
     */
    function getGeneralSettings($ConnBean)
    {
        $sQuery = "SELECT fldsettingsname, fldsettingsvalue FROM `tblgeneralsettings` WHERE fldsettingsname IN ('fldinsightweighting','fldexpertweighting','fldminimumlistenedcount','fldfirstmostlistenedweight','fldsecondmostlistenedweight','fldthirdmostlistenedweight','fldfourthmostlistenedweight','fldrecommendedinsightlimit' )";
        $ConnBean->getPreparedStatement($sQuery);
        $mostListenedWeights = $ConnBean->resultset();
        $listOfWeights       = array();
        foreach($mostListenedWeights as $mostListenedWeight)
        {
            $listenedWeight[$mostListenedWeight['fldsettingsname']] = $mostListenedWeight['fldsettingsvalue'];
        }

        return $listenedWeight;
    }

    /**
     * @param $ConnBean
     * @param $insightid
     *
     * @return array
     */
    public function get_topicids($ConnBean, $insightid)
    {
        $sQuery = "select fldtopicid from tbltopicinsight where fldinsightid =$insightid";
        $ConnBean->getPreparedStatement($sQuery);
        $allTopics = $ConnBean->resultset();
        $topics    = [];
        foreach($allTopics as $topic)
        {
            $topics [] = intval($topic['fldtopicid']);
        }

        return $topics;
    }

    /**
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    public function newest_mode($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby     = "";
        $sQuery      = null;
        $allinsights = array();
        $s3bridge    = new COREAwsBridge();
        $orderby     = "order by i.fldcreateddate desc";

        $expert_ids = null;
        $topics_ids = null;
        if($experts)
        {
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by ti.fldinsightid $orderby";
        }
        elseif($topics)
        {
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 group by ti.fldinsightid $orderby";
        }
        else
        {
            $sQuery = "SELECT  i.fldid, i.fldname, i.fldcreateddate, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl, ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY ti.fldinsightid $orderby";
        }
        $ConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $ConnBean->resultset();
        $insightsList    = array();
        $topics          = array();
        $experts         = array();
        $iResult         = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
        foreach($allInsightsList as $insights)
        {
            $expertid = $insights['fldexpertid'];
            array_push($experts, $expertid);
            if($insights['fldid'])
            {
                $iTopics = $this->get_topicids($ConnBean, $insights['fldinsightid']);
                $topicid = implode(",", $iTopics);
                array_push($topics, $topicid);
            }
            $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
            $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
            $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
            $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
$allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];

            array_push($insightsList, $allinsights);
        }
        $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
        $swapedInsightList          = $this->process_advisor_rule($newInsightList);
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expert_ids = implode(",", $experts);
        $sQuery     = "SELECT  fldid,fldprefix, fldfirstname, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

        $ConnBean->getPreparedStatement($sQuery);
        $allExpertsList = $ConnBean->resultset();
        $expertsInfo    = array();
        foreach($allExpertsList as $experts)
        {
            $title = $experts['fldfirstname']." ".$experts['fldlastname'];
            if(!empty($experts[DB_COLUMN_FLD_PREFIX]))
            {
                $title = $experts[DB_COLUMN_FLD_PREFIX]." ".$title;
            }
            $expertAvatar                   = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL]);
            $expertsInfo[$experts['fldid']] = array(JSON_TAG_ID => intval($experts['fldid']), JSON_TAG_TITLE => $title, JSON_TAG_SUBTITLE => $experts['fldtitle'], JSON_TAG_AVATAR_LINK => $expertAvatar);
        }
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topics_ids = implode(",", $topics);
        $sQuery     = "SELECT fldid, fldname from `tbltopics` WHERE `fldid` IN ($topics_ids)";
        $sQuery     = "SELECT fldid, fldname FROM `tbltopics`";

        $ConnBean->getPreparedStatement($sQuery);
        $allTopicsList = $ConnBean->resultset();
        $topicsInfo    = array();
        foreach($allTopicsList as $topic)
        {
            $topicsInfo[$topic['fldid']] = array(JSON_TAG_ID => intval($topic['fldid']), JSON_TAG_TITLE => $topic['fldname']);
        }
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        return $iResult;
    }

    /**
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    public function popular_mode($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $sQuery      = null;
        $iResult     = array();
        $allinsights = array();
        $finalResult = array();
        $expert_ids  = null;
        $topics_ids  = null;
        $s3bridge    = new COREAwsBridge();

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;

        if($experts)
        {
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT  ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        elseif($topics)
        {
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        else
        {
            $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl, ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY ti.fldinsightid ORDER BY static_rating DESC,i.fldid ";
        }
        $ConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $ConnBean->resultset();
        $insightsList    = array();
        $topics          = array();
        $experts         = array();
        $iResult         = array(JSON_TAG_TYPE => 'recommended insights');
        foreach($allInsightsList as $insights)
        {
            $expertid = $insights['fldexpertid'];
            array_push($experts, $expertid);
            if($insights['fldinsightid'])
            {
                $iTopics = $this->get_topicids($ConnBean, $insights['fldinsightid']);
                $topicid = implode(",", $iTopics);
                array_push($topics, $topicid);
            }
            $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
            $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
            $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
            
            $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
$allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];

            array_push($insightsList, $allinsights);
        }

        $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
        $swapedInsightList          = $this->process_advisor_rule($newInsightList);
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expert_ids = implode(",", $experts);
        $sQuery     = "SELECT  fldid,fldprefix, fldfirstname, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

        $ConnBean->getPreparedStatement($sQuery);
        $allExpertsList = $ConnBean->resultset();
        $expertsInfo    = array();
        foreach($allExpertsList as $experts)
        {
            $title = $experts['fldfirstname']." ".$experts['fldlastname'];
            if(!empty($experts[DB_COLUMN_FLD_PREFIX]))
            {
                $title = $experts[DB_COLUMN_FLD_PREFIX]." ".$title;
            }

            $expertAvatar                   = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL]);
            $expertsInfo[$experts['fldid']] = array(JSON_TAG_ID => intval($experts['fldid']), JSON_TAG_TITLE => $title, JSON_TAG_SUBTITLE => $experts['fldtitle'], JSON_TAG_AVATAR_LINK => $expertAvatar);
        }
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topics_ids = implode(",", $topics);
        $sQuery     = "SELECT fldid, fldname from `tbltopics` WHERE `fldid` IN ($topics_ids)";
        $sQuery     = "SELECT fldid, fldname FROM `tbltopics`";

        $ConnBean->getPreparedStatement($sQuery);
        $allTopicsList = $ConnBean->resultset();
        $topicsInfo    = array();
        foreach($allTopicsList as $topic)
        {
            $topicsInfo[$topic['fldid']] = array(JSON_TAG_ID => intval($topic['fldid']), JSON_TAG_TITLE => $topic['fldname']);
        }
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        return $iResult;
    }

    /**
     * Function to swap insights so that no two insights from same expert appear imediate to each other.
     *
     * @param $insights
     *
     * @return mixed
     */
    public function process_advisor_rule($insights)
    {
        $totalInsights = sizeof($insights);
        $currentIndex  = 0;
        $lookupIndex   = 0;

        $previousItemCount  = 4;
        $previousItemBucket = new CORERestrictedQueue($previousItemCount);

        for($currentIndex = 0; $currentIndex < $totalInsights; ++$currentIndex)
        {
            $expert = $insights[$currentIndex];
            if($previousItemBucket->hasItem($expert))
            {
                for($lookupIndex = $currentIndex + 1; $lookupIndex < $totalInsights; ++$lookupIndex)
                {
                    if(!$previousItemBucket->hasItem($insights[$lookupIndex]))
                    {
                        break;
                    }
                }

                if($lookupIndex < $totalInsights)
                {
                    $insights[$currentIndex] = $insights[$lookupIndex];
                    $insights[$lookupIndex]  = $expert;
                }
            }
            $previousItemBucket->enqueue($insights[$currentIndex]);
        }

        return $insights;
    }

    /**
     * Function to update insight voice-over url.
     *
     * @param $ConnBean
     * @param $insight_id
     * @param $fileName
     *
     * @return int
     */
    public function patch_insight_voiceover_url($ConnBean, $insight_id, $fileName)
    {
        $sQuery = "UPDATE tblinsights SET fldinsightvoiceoverurl=? WHERE fldid=?";
        try
        {

            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(1, $fileName);
            $ConnBean->bind_param(2, $insight_id);
            $ConnBean->execute();

            $iStatus = 1;
        }
        catch(EXception $e)
        {
            $iStatus = 2;
        }

        return $iStatus;
    }

    /**
     * @param $insightId
     *
     * @return int
     */
    public function valid_insight($insightId)
    {
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT COUNT(*) AS insightcount FROM tblinsights WHERE fldid =  :insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':insightid', $insightId);
            $result = $ConnBean->single();
            $count  = $result[JSON_TAG_INSIGHT_COUNT];
        }
        catch(Exception $e)
        {
            $count = 0;
        }

        return $count;
    }

    /**
     * Function to list all recommended insights using Redis caching.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    //Redis Caching
    //cached insights, experts and topics
    public function newest_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$groupId=1,$page_no=1)
    { 
//        print_r(func_get_args()); exit;
        $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $orderby      = "";
        $sQuery       = null;
        $s3bridge     = new COREAwsBridge();
        $redis        = CORERedisConnection::getRedisInstance();
        $orderby      = "order by i.fldcreateddate desc";
        $insightsList = null;

        $toBeCached = false;
        $expert_ids = null;
        $topics_ids = null;
        $cacheyKey  = null;
        if($experts)
        {
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid $orderby  limit $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid $orderby  ";
        }
        elseif($topics)
        {
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid $orderby  limit  $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid $orderby ";
        }
        else
        {                      
            $cacheyKey = "newest_without_topic_expert";
             $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $sQuery     = "SELECT  i.fldid, i.fldname, i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid $orderby  limit  $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT  i.fldid, i.fldname, i.fldcreateddate,i.client_id,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid $orderby "; 
            
            $toBeCached = true;            
        }
        $insightsList = array();
        $insights_count = 0;
        if($redis)
        {
            $insightsList = $redis->get($cacheyKey);
            if($insightsList)
            {
                $insightsList = json_decode($insightsList, true);
                if(is_array($insightsList)) {
                    $insights_count = count($insightsList);
                } else {
                    $insights_count = 0;
                }
            }
        }

        if(empty($insightsList))
        {
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insight         = array();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                if($insights['fldid'])
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                    $topicid = implode(",", $iTopics);
                    array_push($topics, $topicid);
                }
                $streamingUrl           = $streamingFileNamehlsv4 = "";
                if(!empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) && !empty($insights[DB_COLUMN_FLD_CLIENT_ID])){
                    $streamingUrl           = $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME],$insights[DB_COLUMN_FLD_CLIENT_ID]);
                }
                if(!empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) && !empty($insights[DB_COLUMN_FLD_CLIENT_ID])){
                    $streamingFileNamehlsv4           = $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$insights[DB_COLUMN_FLD_CLIENT_ID]);
                }
                $insight                = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $insight[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $insight[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                
                array_push($insightsList, $insight);
                $insights_count++;
            }

            if($redis && $toBeCached)
            {
                $redis->set($cacheyKey, json_encode($insightsList));
            }
        }
        
        $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
        $swapedInsightList          = $this->process_advisor_rule($newInsightList);
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult                    = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis,$clientId);
        if(is_array($expertsInfo)) {
            $experts_count = count($expertsInfo);
        } else {
            $experts_count = 0;
        }
        
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis,$clientId);
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
        if(is_array($topicsInfo)) {
            $topics_count = count($topicsInfo);
        } else {
            $topics_count = 0;
        }
        
        
        $iResult['insights_count'] = $insights_count;
        $iResult['experts_count'] = $experts_count;
        $iResult['topics_count'] = $topics_count;
        
        $ConnBean->getPreparedStatement($sQuery_total_count);
        $ConnBean->execute();
        $sQuery_total_count = $ConnBean->rowCount();  
        $total_page_nos = $sQuery_total_count / (int)JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $total_page_nos = ceil($total_page_nos);            
//            $iResult['sQuery_total_count'] = $sQuery_total_count;
//            $iResult['total_page_nos'] = $total_page_nos;
        if($page_no < $total_page_nos) {
            $iResult['page_no'] = $page_no;
        }

        return $iResult;
    }

    /**
     * Function to list all recommended insights using Redis caching.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    //Redis Caching
    //cached insights,experts and topics
    public function popular_mode_redis($ConnBean, $mode, $experts, $topics, $consumer_id,$clientId,$groupId=1,$page_no=1)
    {
        $limit_start = ($page_no-1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $sQuery     = null;
        $iResult    = array();
        $expert_ids = null;
        $topics_ids = null;
        $s3bridge   = new COREAwsBridge();
        $redis      = CORERedisConnection::getRedisInstance();
        $toBeCached = false;
        $cacheyKey  = "";

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $insightsList       = null;

        if($experts)
        {  
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT  ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.client_id, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid limit  $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT  ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.client_id, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid ";
            
        }
        elseif($topics)
        {
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.client_id,i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid  limit  $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.client_id,i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 ".$where." group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid ";
        }
        else
        {   
            $where = "AND ((i.client_id='".$clientId."' AND i.group_id='".$groupId."') OR (i.client_id='audvisor11012017'))";
            $cacheyKey  = "popular_without_topic_expert";
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,i.client_id,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid  limit  $limit_start, ".JSON_TAG_DISPLAY_INSIGHT_LIMIT;
            
            $sQuery_total_count     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,i.client_id,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldisdeleted =0 AND i.fldisonline =1 ".$where." GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            
            $toBeCached = true;
        }

        $insights_count = 0;
        if($redis)
        {
            $insightsList = $redis->get($cacheyKey);
            if($insightsList)
            {
                $insightsList = json_decode($insightsList, true);
                
                if(is_array($insightsList)) {
                    $insights_count = count($insightsList);
                } else {
                    $insights_count = 0;
                }
        
            }
        }

        if(empty($insightsList))
        {
            $insight = array();
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();
            
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                if($insights['fldid'])
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                    $topicid = implode(",", $iTopics);
                    array_push($topics, $topicid);
                }
                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]&&$insights[DB_COLUMN_FLD_CLIENT_ID]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME],$insights[DB_COLUMN_FLD_CLIENT_ID]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]&&$insights[DB_COLUMN_FLD_CLIENT_ID]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$insights[DB_COLUMN_FLD_CLIENT_ID]);
                $insight                = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $insight[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $insight[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];

                array_push($insightsList, $insight);
                $insights_count++;
            }

            if($redis && $toBeCached)
            {
                $redis->set($cacheyKey, json_encode($insightsList));
            }
        }

        $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
        $swapedInsightList          = $this->process_advisor_rule($newInsightList);
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult                    = array(JSON_TAG_TYPE => 'recommended insights');
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis,$clientId);
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;
        if(is_array($expertsInfo)) {
            $experts_count = count($expertsInfo);
        } else {
            $experts_count = 0;
        }

        $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
        if(is_array($topicsInfo)) {
            $topics_count = count($topicsInfo);
        } else {
            $topics_count = 0;
        }
        
        $iResult['insights_count'] = $insights_count;
        $iResult['experts_count'] = $experts_count;
        $iResult['topics_count'] = $topics_count;
        
        $ConnBean->getPreparedStatement($sQuery_total_count);
        $ConnBean->execute();
        $sQuery_total_count = $ConnBean->rowCount();  
        $total_page_nos = $sQuery_total_count / (int)JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $total_page_nos = ceil($total_page_nos);            
//            $iResult['sQuery_total_count'] = $sQuery_total_count;
//            $iResult['total_page_nos'] = $total_page_nos;
        if($page_no < $total_page_nos) {
            $iResult['page_no'] = $page_no;
        }

        return $iResult;
    }

    /**
     * Function to retrieve all experts from Redis cache.
     *
     * @param $ConnBean
     * @param $redis
     *
     * @return array
     */

    public function getExpertsFromCache($ConnBean, $redis,$client_id="")
    {
        $s3bridge = new COREAwsBridge();
        $cacheKey = "all_experts";

        if($redis)
        {
            $expertsInfo = $redis->get($cacheKey);
            if($expertsInfo)
            {
                $expertsInfo = json_decode($expertsInfo, true);
            }
        }

        if(empty($expertsInfo))
        {
            $sQuery = "SELECT  fldid,fldprefix, fldfirstname, fldlastname, fldtitle, fldavatarurl,client_id FROM `tblexperts` WHERE fldisdeleted=0";
            $ConnBean->getPreparedStatement($sQuery);
            $allExpertsList = $ConnBean->resultset();

            $expertsInfo = array();
            foreach($allExpertsList as $experts)
            {
                $title = $experts['fldfirstname']." ".$experts['fldlastname'];
                $experts_client_id = $experts['client_id'];
                if(!empty($experts[DB_COLUMN_FLD_PREFIX]))
                {
                    $title = $experts[DB_COLUMN_FLD_PREFIX]." ".$title;
                }
                $expertAvatar                   = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL],$experts_client_id);
                $expertsInfo[$experts['fldid']] = array(JSON_TAG_ID => intval($experts['fldid']), JSON_TAG_TITLE => $title, JSON_TAG_SUBTITLE => $experts['fldtitle'], JSON_TAG_AVATAR_LINK => $expertAvatar);
            }
            if($redis)
            {
                $redis->set($cacheKey, json_encode($expertsInfo));
            }
        }

        return $expertsInfo;
    }

    /**
     * Function to retrieve all topics from Redis cache.
     *
     * @param $ConnBean
     * @param $redis
     *
     * @return array
     */

    public function getTopicsFromCache($ConnBean, $redis,$clientId="")
    {

        $cacheKey = "all_Topics";

        if($redis)
        {
            $topicsInfo = $redis->get($cacheKey);
            if($topicsInfo)
            {
                $topicsInfo = json_decode($topicsInfo, true);
            }
        }
        if(empty($topicsInfo))
        {
            $sQuery = "SELECT fldid, fldname FROM `tbltopics` WHERE fldisdeleted=0";
            $ConnBean->getPreparedStatement($sQuery);
            $allTopicsList = $ConnBean->resultset();

            $topicsInfo = array();
            foreach($allTopicsList as $topic)
            {
                $topicsInfo[$topic['fldid']] = array(JSON_TAG_ID => intval($topic['fldid']), JSON_TAG_TITLE => $topic['fldname']);
            }
            if($redis)
            {
                $redis->set($cacheKey, json_encode($topicsInfo));
            }
        }

        return $topicsInfo;
    }

    /**
     * Function to list all recommended insights using Redis caching.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    //redis caching for recommended mode
    public function recommended_insight_redis($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge           = new COREAwsBridge();
        $redis              = CORERedisConnection::getRedisInstance();
        $toBeCached         = false;
        $cacheKey           = "";
        try
        {
            $expert_ids = null;
            $topics_ids = null;
            if($experts)
            {
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating ,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldexpertid IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            elseif($topics)
            {
                $topics_ids = implode(',', $topics);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle,  e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid  WHERE ti.fldtopicid IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            else
            {
                $cacheKey   = "recommended_without_topic_expert";
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate, i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
                $toBeCached = true;
            }

            if($redis->exists($cacheKey))
            {
                $allInsightsList = $redis->get($cacheKey);
                $allInsightsList = json_decode($allInsightsList, true);
            }
            else
            {
                $ConnBean->getPreparedStatement($sQuery);
                $allInsightsList = $ConnBean->resultset();

                if($toBeCached)
                {
                    $redis->set($cacheKey, json_encode($allInsightsList));
                }
            }
            $insightsList = array();
            $topics       = array();
            $experts      = array();
            $iResult      = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts   = array();
            $allTopics    = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'];
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'];
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'];
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'];
            $sQuery                   = "SELECT  i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingurl, i.fldexpertid, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5)  AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $insightsWithConsumer = $ConnBean->resultset();
            $number_listened      = sizeof($insightsWithConsumer);

            foreach($insightsWithConsumer as $insight)
            {
                $expert = $insight['fldexpertid'];
                array_push($allExperts, $expert);
                $iTopics   = $this->get_topicids($ConnBean, $insight['fldid']);
                $allTopics = array_merge($allTopics, $iTopics);
            }

            $topExperts = $this->getTopExpertCount($allExperts);
            $topTopics  = $this->getTopTopicCount($allTopics);
            $count      = 0;
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);

                if($insights['fldid'])
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                }

                if($number_listened > $minimum_listened)
                {
                    foreach($topExperts as $key => $value)
                    {
                        $count = $count + 1;
                        if($count == 1 && $key == $insights['fldexpertid'])
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 2 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 3 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            elseif(strpos($position, '1') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($thirdMostListenedWeight / 100);
                            break;
                        }
                        else
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($fourthMostListenedWeight / 100);
                            break;
                        }
                    }
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                    $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    array_push($insightsList, $allinsights);
                }
                else
                {
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                     $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    array_push($insightsList, $allinsights);
                }
            }

            // sorting based on new static reputation value obtained using top listed expert or top listed topic
            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }

            $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList          = $this->process_advisor_rule($newInsightList);
            $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

            $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

            $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
            
            $iResult['insights_count'] = $insights_count;
            $iResult['experts_count'] = $experts_count;
            $iResult['topics_count'] = $topics_count;
        }
        catch(Exception $e)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function to get all topics_ids from Redis caching.
     *
     * @param $cacheKey
     *
     * @return list of ids
     */

    public function  getTopicIdsFromCache($cacheKey)
    {
        $redis = CORERedisConnection::getRedisInstance();
        if($redis->exists($cacheKey))
        {
            $topicIds = $redis->get($cacheKey);
            $topicIds = json_decode($topicIds);
            $topicIds = explode(",", $topicIds);
        }

        return $topicIds;
    }


    /**
     * Function to list all recommended insights .
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //cached all topicids for insights
    public function recommended_insight_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge           = new COREAwsBridge();
        $redis              = CORERedisConnection::getRedisInstance();
        $toBeCached         = false;
        $cacheKey           = "";
        try
        {
            $expert_ids = null;
            $topics_ids = null;
            if($experts)
            {
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating ,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldexpertid IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            elseif($topics)
            {
                $topics_ids = implode(',', $topics);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle,  e.fldavatarurl FROM tblinsights AS i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid  WHERE ti.fldtopicid IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by i.fldid ORDER BY static_rating DESC,i.fldid ";
            }
            else
            {
                $cacheKey   = "recommended_without_topic_expert";
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
                $toBeCached = true;
            }

            if($redis->exists($cacheKey))
            {
                $allInsightsList = $redis->get($cacheKey);
                $allInsightsList = json_decode($allInsightsList, true);
            }
            else
            {
                $ConnBean->getPreparedStatement($sQuery);
                $allInsightsList = $ConnBean->resultset();

                if($toBeCached)
                {
                    $redis->set($cacheKey, json_encode($allInsightsList));
                }
            }

            $insightsList = array();
            $topics       = array();
            $experts      = array();
            $iResult      = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts   = array();
            $allTopics    = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'];
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'];
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'];
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'];
            $sQuery                   = "SELECT  i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingurl, i.fldexpertid,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5)  AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $insightsWithConsumer = $ConnBean->resultset();
            $number_listened      = sizeof($insightsWithConsumer);

            foreach($insightsWithConsumer as $insight)
            {
                $expert = $insight['fldexpertid'];
                array_push($allExperts, $expert);

                $cacheKey = "insight".$insight['fldid'];
                if($redis->exists($cacheKey))
                {
                    $iTopics = $this->getTopicIdsFromCache($cacheKey);
                }
                else
                {
                    $iTopics = $this->get_topicids($ConnBean, $insight['fldid']);
                }

                $allTopics = array_merge($allTopics, $iTopics);
            }

            $topExperts = $this->getTopExpertCount($allExperts);
            $topTopics  = $this->getTopTopicCount($allTopics);
            $count      = 0;
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                $cacheKey = "insight".$insights['fldid'];
                if($redis->exists($cacheKey))
                {
                    $iTopics = $this->getTopicIdsFromCache($cacheKey);
                }
                else
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                }

                if($number_listened > $minimum_listened)
                {
                    foreach($topExperts as $key => $value)
                    {
                        $count = $count + 1;
                        if($count == 1 && $key == $insights['fldexpertid'])
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 2 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                            break;
                        }
                        elseif($count == 3 && $key == $insights['fldexpertid'])
                        {
                            $position = $this->compareTopicWithTopTopics($topTopics, $iTopics);
                            if(strpos($position, '0') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($firstMostListenedWeight / 100);
                                break;
                            }
                            elseif(strpos($position, '1') !== false)
                            {
                                $insights['static_rating'] = $insights['static_rating'] * ($secondMostListenedWeight / 100);
                                break;
                            }
                            $insights['static_rating'] = $insights['static_rating'] * ($thirdMostListenedWeight / 100);
                            break;
                        }
                        else
                        {
                            $insights['static_rating'] = $insights['static_rating'] * ($fourthMostListenedWeight / 100);
                            break;
                        }
                    }
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                    $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    
                    array_push($insightsList, $allinsights);
                }
                else
                {
                    $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                    $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                    $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                    
                    $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    array_push($insightsList, $allinsights);
                }
            }

            // sorting based on new static reputation value obtained using top listed expert or top listed topic
            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }

            $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList          = $this->process_advisor_rule($newInsightList);
            $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

            $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

            $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
        }
        catch(Exception $e)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //cached topicIds for insights
    public function popular_mode_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $sQuery     = null;
        $iResult    = array();
        $expert_ids = null;
        $topics_ids = null;
        $s3bridge   = new COREAwsBridge();
        $redis      = CORERedisConnection::getRedisInstance();
        $toBeCached = false;
        $cacheyKey  = "";

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;

        if($experts)
        {
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT  ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        elseif($topics)
        {
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        else
        {
            $cacheyKey  = "popular_without_topic_expert";
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl, ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY ti.fldinsightid ORDER BY static_rating DESC,i.fldid ";
            $toBeCached = true;
        }

        if($redis->exists($cacheyKey))
        {
            $swapedInsightList = $redis->get($cacheyKey);
            $swapedInsightList = json_decode($swapedInsightList, true);
        }
        else
        {
            $insight = array();
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();

            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                $insightCacheKey = "insight".$insights['fldid'];
                if($redis->exists($insightCacheKey))
                {
                    $iTopics = $this->getTopicIdsFromCache($insightCacheKey);
                }
                else
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldinsightid']);
                }

                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                $insight                = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $insight[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $insight[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    
                array_push($insightsList, $insight);
            }

            $newInsightList    = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList = $this->process_advisor_rule($newInsightList);

            if($toBeCached)
            {
                $redis->set($cacheyKey, json_encode($swapedInsightList));
            }
        }
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult                    = array(JSON_TAG_TYPE => 'recommended insights');
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        return $iResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //cached topicIds for insights
    public function newest_mode_redis_topicIds($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby  = "";
        $sQuery   = null;
        $s3bridge = new COREAwsBridge();
        $redis    = CORERedisConnection::getRedisInstance();
        $orderby  = "order by i.fldcreateddate desc";

        $toBeCached = false;
        $expert_ids = null;
        $topics_ids = null;
        $cacheyKey  = null;
        if($experts)
        {
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by ti.fldinsightid $orderby";
        }
        elseif($topics)
        {
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT i.fldid,i.fldname,i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 group by ti.fldinsightid $orderby";
        }
        else
        {
            $cacheyKey = "newest_without_topic_expert";

            $sQuery     = "SELECT  i.fldid, i.fldname, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl, ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY ti.fldinsightid $orderby";
            $toBeCached = true;
        }
        if($redis->exists($cacheyKey))
        {
            $swapedInsightList = $redis->get($cacheyKey);
            $swapedInsightList = json_decode($swapedInsightList, true);
        }
        else
        {
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insight         = array();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();

            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                $insightCacheKey = "insight".$insights['fldid'];
                if($redis->exists($insightCacheKey))
                {
                    $iTopics = $this->getTopicIdsFromCache($insightCacheKey);
                }
                else
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldinsightid']);
                }

                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                $insight                = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $insight[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $insight[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                array_push($insightsList, $insight);
            }

            $newInsightList    = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList = $this->process_advisor_rule($newInsightList);

            if($toBeCached)
            {
                $redis->set($cacheyKey, json_encode($swapedInsightList));
            }
        }

        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult                    = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        return $iResult;
    }

    /**
     * Function to invalidate Redis cached data.
     *
     * @param $redis
     *
     */

    public function invalidateCache($redis)
    {
        if($redis)
        {
            $cacheKey1 = "newest_without_topic_expert";
            $cacheKey2 = "popular_without_topic_expert";

            $redis->del($cacheKey1, $cacheKey2);
        }
    }


    /**
     * Function to list all recommended insights using Redis caching.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */
    //excluding streaming url and streaming_url_hlsv4
    public function popular_mode_redis_withouturls($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $sQuery     = null;
        $iResult    = array();
        $expert_ids = null;
        $topics_ids = null;
        $s3bridge   = new COREAwsBridge();
        $redis      = CORERedisConnection::getRedisInstance();
        $toBeCached = false;
        $cacheyKey  = "";

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $insightsList       = null;

        if($experts)
        {
            $expert_ids = implode(',', $experts);
            $sQuery     = "SELECT  ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldexpertid,i.fldduration,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldexpertid` IN ($expert_ids) AND i.fldisdeleted =0 AND i.fldisonline =1  group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        elseif($topics)
        {
            $topics_ids = implode(',', $topics);
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, i.fldid,i.fldname,i.fldmodifieddate,i.fldcreateddate,i.fldexpertid,i.fldduration,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,ti.fldinsightid FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE `fldtopicid` IN ($topics_ids) AND i.fldisdeleted =0 AND i.fldisonline =1 group by ti.fldinsightid ORDER BY static_rating DESC,i.fldid";
        }
        else
        {
            $cacheyKey  = "popular_withouturls";
            $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,i.fldid, i.fldname, i.fldmodifieddate,i.fldcreateddate,i.fldexpertid,i.fldduration,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid  WHERE i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            $toBeCached = true;
        }

        if($redis)
        {
            $insightsList = $redis->get($cacheyKey);
            if($insightsList)
            {
                $insightsList = json_decode($insightsList, true);
            }
        }

        if(empty($insightsList))
        {
            $insight = array();
            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();
            $insightsList    = array();
            $topics          = array();
            $experts         = array();

            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                if($insights['fldid'])
                {
                    $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                    $topicid = implode(",", $iTopics);
                    array_push($topics, $topicid);
                }
                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                $insight                = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                array_push($insightsList, $insight);
            }

            if($redis && $toBeCached)
            {
                $redis->set($cacheyKey, json_encode($insightsList));
            }
        }

        $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
        $swapedInsightList          = $this->process_advisor_rule($newInsightList);
        $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
        $iResult                    = array(JSON_TAG_TYPE => 'recommended insights');
        $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

        $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        return $iResult;
    }



    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    //time for recommended mode code
    public function recommended_insight_newcode_time($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $start11            = microtime(true);
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $redis              = CORERedisConnection::getRedisInstance();
        $s3bridge           = new COREAwsBridge();
        try
        {

            $expert_ids = null;
            $topics_ids = null;
            if($experts)
            {
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + ( e.fldrating * $expertWeight )) AS static_rating, group_concat( ti.fldtopicid SEPARATOR ',' ) AS topics, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate, i.fldstreamingfilename, i.fldstreamingfilenamehlsv4, i.fldexpertid, i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON ti.fldinsightid = i.fldid WHERE i.fldexpertid IN ($expert_ids ) AND i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC , i.fldid";
            }
            elseif($topics)
            {
                $topics_ids = implode(',', $topics);
                $sQuery     = "select* from (SELECT ((ir.fldrating*$insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,group_concat(ti.fldtopicid SEPARATOR ',') as topics, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 group by i.fldid ORDER BY static_rating DESC,i.fldid )as abcd where topics IN ($topics_ids)";
            }
            else
            {
                $cacheKey   = "recommended_mode_with time";
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
                $toBeCached = true;
            }

            $start = microtime(true);
            if($redis)
            {
                $allInsightsList = $redis->get($cacheKey);
                if($allInsightsList)
                {
                    $allInsightsList = json_decode($allInsightsList, true);
                }
            }
            $redisTime = microtime(true) - $start;

            $start = microtime(true);
            if(empty($allInsightsList))
            {
                $ConnBean->getPreparedStatement($sQuery);
                $allInsightsList = $ConnBean->resultset();

                if($redis && $toBeCached)
                {
                    $redis->set($cacheKey, json_encode($allInsightsList));
                }
            }

            $end1 = microtime(true) - $start;

            $insightsList = array();
            $topics       = array();
            $experts      = array();
            $iResult      = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts   = array();
            $allTopics    = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'] / 100;
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'] / 100;
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'] / 100;
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'] / 100;

            $start  = microtime(true);
            $sQuery = "SELECT  i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingurl, i.fldexpertid,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN  tblconsumeranalytics AS ca ON i.fldid = ca.fldreceiverid  WHERE  (( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR ca.fldactionid =5)  AND ca.fldreceivertype =1 AND i.fldisdeleted =0 AND i.fldisonline =1 AND ca.fldconsumerid =$consumer_id GROUP BY i.fldid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $insightsWithConsumer = $ConnBean->resultset();
            $end2                 = microtime(true) - $start;

            $number_listened = sizeof($insightsWithConsumer);

            $insightIds = array();

            $start = microtime(true);
            if($insightsWithConsumer)
            {
                foreach($insightsWithConsumer as $insight)
                {
                    $expert = $insight['fldexpertid'];
                    array_push($allExperts, $expert);
                    array_push($insightIds, $insight['fldid']);
                }

                $ids     = implode(",", $insightIds);
                $sQuery1 = "select fldtopicid from tbltopicinsight where fldinsightid in ($ids) group by fldtopicid order by count(fldtopicid) desc";
                $ConnBean->getPreparedStatement($sQuery1);
                $topTopicss = $ConnBean->resultset();

                $getIDs = function ($topics)
                {
                    return $topics['fldtopicid'];
                };

                $topTopics = array_map($getIDs, $topTopicss);
                $topTopics = array_slice($topTopics, 0, 3);

                $topExpertCount = array_count_values($allExperts);
                arsort($topExpertCount);
                $topExperts = array_keys($topExpertCount);
                $topExperts = array_slice($topExperts, 0, 3);
            }
            $end3 = microtime(true) - $start;

            $start = microtime(true);
            $count = 0;
            $insights_count = 0;
            $str_topics_ids = '';
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                $iTopics = explode(",", ($insights['topics']));
                $str_topics_ids .= $insights['topics'].",";

                if($number_listened > $minimum_listened)
                {
                    $count          = $count + 1;
                    $exp_position   = array_search($expertid, $topExperts);
                    $topic_position = false;
                    foreach($iTopics as $topic)
                    {
                        $pos = array_search($topic, $topTopics);
                        if(FALSE !== $pos)
                        {
                            $topic_position = $pos;
                            break;
                        }
                    }

                    $multiplier_index = 3;
                    if(!($exp_position === false) && !($topic_position === false))
                    {
                        if($exp_position < $topic_position)
                        {
                            $multiplier_index = $exp_position;
                        }
                        else
                        {
                            $multiplier_index = $topic_position;
                        }
                    }
                    else
                    {
                        if(($exp_position === false) && ($topic_position === false))
                        {
                            $multiplier_index = 3;
                        }
                        elseif($exp_position === false)
                        {
                            $multiplier_index = $topic_position;
                        }
                        else
                        {
                            $multiplier_index = $exp_position;
                        }
                    }

                    if($multiplier_index < 3)
                    {
                        $weight = $multiplier_index ? (($multiplier_index == 1) ? ($secondMostListenedWeight) : ($thirdMostListenedWeight)) : ($firstMostListenedWeight);
                    }
                    else
                    {
                        $weight = $fourthMostListenedWeight;
                    }

                    $insights['static_rating'] = $insights['static_rating'] * $weight;
                }

                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                    $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                    
                array_push($insightsList, $allinsights);
                $insights_count++;
            }
            $end4 = microtime(true) - $start;

            // sorting based on new static reputation value obtained using top listed expert or top listed topic

            $start = microtime(true);
            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }
            $end5 = microtime(true) - $start;

            $start          = microtime(true);
            $newInsightList = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $end6           = microtime(true) - $start;

            $start             = microtime(true);
            $swapedInsightList = $this->process_advisor_rule($newInsightList);
            $end7              = microtime(true) - $start;

            $start           = microtime(true);
            $LimitedInsights = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            $end8            = microtime(true) - $start;

            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

            $start                         = microtime(true);
            $expertsInfo                   = $this->getExpertsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;
            $end9                          = microtime(true) - $start;

            $start                        = microtime(true);
            $topicsInfo                   = $this->getTopicsFromCache($ConnBean, $redis);
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
            $end10                        = microtime(true) - $start;

            $time = microtime(true) - $start11;

            $executionTime = array(
                "insights from cache"                                                            => $redisTime,
                "query to get insights"                                                          => $end1,
                "query to get count of insights "                                                => $end2,
                "code block to get top topics & experts"                                         => $end3,
                "code block for calculating static reputation if insight count is more than 25 " => $end4,
                "Sorting insights based on static reputation if insight count is more than 25"   => $end5,
                "sort insights based on action data "                                            => $end6,
                "shuffling insights if from same experts "                                       => $end7,
                "getting limited insights"                                                       => $end8,
                "getting experts"                                                                => $end9,
                "getting topics "                                                                => $end10,
                "total time"                                                                     => $time
            );

            $iResult["execution time"] = $executionTime;
        }
        catch(Exception $e)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function to list all recommended insights.
     *
     * @param $ConnBean
     * @param $mode
     * @param $experts
     * @param $topics
     * @param $consumer_id
     *
     * @return array
     */

    //consumer analytics table split into 3 different tables
    public function recommended_mode($ConnBean, $mode, $experts, $topics, $consumer_id)
    {
        $orderby            = "";
        $sQuery             = null;
        $allinsights        = array();
        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge           = new COREAwsBridge();
        try
        {
            $expert_ids = null;
            $topics_ids = null;
            if($experts)
            {
                $expert_ids = implode(',', $experts);
                $sQuery     = "SELECT ((ir.fldrating * $insightWeight) + ( e.fldrating * $expertWeight )) AS static_rating, group_concat( ti.fldtopicid SEPARATOR ',' ) AS topics, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate, i.fldstreamingfilename, i.fldstreamingfilenamehlsv4, i.fldexpertid, i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON ti.fldinsightid = i.fldid WHERE i.fldexpertid IN ($expert_ids ) AND i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC , i.fldid";
            }
            elseif($topics)
            {
                $topics_ids = implode(',', $topics);
                $sQuery     = "select* from (SELECT ((ir.fldrating*$insightWeight) + (e.fldrating * $expertWeight)) AS static_rating,group_concat(ti.fldtopicid SEPARATOR ',') as topics, i.fldid, i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights AS i LEFT JOIN tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid WHERE i.fldisdeleted =0 AND i.fldisonline =1 group by i.fldid ORDER BY static_rating DESC,i.fldid )as abcd where topics IN ($topics_ids)";
            }
            else
            {
                $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc,e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            }

            $ConnBean->getPreparedStatement($sQuery);
            $allInsightsList = $ConnBean->resultset();

            $insightsList = array();
            $topics       = array();
            $experts      = array();
            $iResult      = array(JSON_TAG_TYPE => JSON_TAG_REC_INSIGHTS);
            $allExperts   = array();
            $allTopics    = array();

            $minimum_listened         = $mostListenedWeight['fldminimumlistenedcount'];
            $firstMostListenedWeight  = $mostListenedWeight['fldfirstmostlistenedweight'] / 100;
            $secondMostListenedWeight = $mostListenedWeight['fldsecondmostlistenedweight'] / 100;
            $thirdMostListenedWeight  = $mostListenedWeight['fldthirdmostlistenedweight'] / 100;
            $fourthMostListenedWeight = $mostListenedWeight['fldfourthmostlistenedweight'] / 100;

            $sQuery = "SELECT count(*) count FROM `tblcainsights` WHERE fldconsumerid=$consumer_id";
            $ConnBean->getPreparedStatement($sQuery);
            $countOfInsights = $ConnBean->single();
            $number_listened = $countOfInsights['count'];

            $sQuery = "SELECT fldexpertid FROM `tblcaexperts` WHERE fldconsumerid=$consumer_id order by fldcount desc";
            $ConnBean->getPreparedStatement($sQuery);
            $experts = $ConnBean->resultset();

            $getIDs = function ($experts)
            {
                return $experts['fldexpertid'];
            };

            $topExperts = array_map($getIDs, $experts);
            $topExperts = array_slice($topExperts, 0, 3);

            $sQuery = "select fldtopicid from tblcatopics where fldconsumerid=$consumer_id order by fldcount desc";
            $ConnBean->getPreparedStatement($sQuery);
            $topics = $ConnBean->resultset();

            $getIDs = function ($topics)
            {
                return $topics['fldtopicid'];
            };

            $topTopics = array_map($getIDs, $topics);
            $topTopics = array_slice($topTopics, 0, 3);

            $count = 0;
            foreach($allInsightsList as $insights)
            {
                $expertid = $insights['fldexpertid'];
                array_push($experts, $expertid);
                $iTopics = explode(",", ($insights['topics']));

                if($number_listened > $minimum_listened)
                {
                    $count          = $count + 1;
                    $exp_position   = array_search($expertid, $topExperts);
                    $topic_position = false;
                    foreach($iTopics as $topic)
                    {
                        $pos = array_search($topic, $topTopics);
                        if(FALSE !== $pos)
                        {
                            $topic_position = $pos;
                            break;
                        }
                    }

                    $multiplier_index = 3;
                    if(!($exp_position === false) && !($topic_position === false))
                    {
                        if($exp_position < $topic_position)
                        {
                            $multiplier_index = $exp_position;
                        }
                        else
                        {
                            $multiplier_index = $topic_position;
                        }
                    }
                    else
                    {
                        if(($exp_position === false) && ($topic_position === false))
                        {
                            $multiplier_index = 3;
                        }
                        elseif($exp_position === false)
                        {
                            $multiplier_index = $topic_position;
                        }
                        else
                        {
                            $multiplier_index = $exp_position;
                        }
                    }

                    if($multiplier_index < 3)
                    {
                        $weight = $multiplier_index ? (($multiplier_index == 1) ? ($secondMostListenedWeight) : ($thirdMostListenedWeight)) : ($firstMostListenedWeight);
                    }
                    else
                    {
                        $weight = $fourthMostListenedWeight;
                    }

                    $insights['static_rating'] = $insights['static_rating'] * $weight;
                }

                $streamingUrl           = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]);
                $allinsights            = array(JSON_TAG_ID => $insights['fldid'], JSON_TAG_TITLE => $insights['fldname'], JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), JSON_TAG_TOPIC_IDS => $iTopics);
                
                $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
                $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];
                    
                array_push($insightsList, $allinsights);
            }

            // sorting based on new static reputation value obtained using top listed expert or top listed topic

            if($count > 0)
            {
                usort($insightsList, function ($a, $b)
                {
                    if($a['staticreputation'] == $b['staticreputation'])
                    {
                        return 0;
                    }

                    return ($a['staticreputation'] > $b['staticreputation']) ? -1 : 1;
                });
            }

            $newInsightList             = $this->sortInsightsBasedOnActionData($ConnBean, $insightsList, $consumer_id);
            $swapedInsightList          = $this->process_advisor_rule($newInsightList);
            $LimitedInsights            = $this->getLimitedInsights($ConnBean, $swapedInsightList);
            $iResult[JSON_TAG_INSIGHTS] = $LimitedInsights;

            $expert_ids = implode(",", $experts);
            $sQuery     = "SELECT  fldid,fldprefix, fldfirstname, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

            $ConnBean->getPreparedStatement($sQuery);
            $allExpertsList = $ConnBean->resultset();
            $expertsInfo    = array();
            foreach($allExpertsList as $experts)
            {
                $title = $experts['fldfirstname']." ".$experts['fldlastname'];
                if(!empty($experts[DB_COLUMN_FLD_PREFIX]))
                {
                    $title = $experts[DB_COLUMN_FLD_PREFIX]." ".$title;
                }
                $expertAvatar                   = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL]);
                $expertsInfo[$experts['fldid']] = array(JSON_TAG_ID => intval($experts['fldid']), JSON_TAG_TITLE => $title, JSON_TAG_SUBTITLE => $experts['fldtitle'], JSON_TAG_AVATAR_LINK => $expertAvatar);
            }
            $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

            $topics_ids = implode(",", $topics);
            $sQuery     = "SELECT fldid, fldname from `tbltopics` WHERE `fldid` IN ($topics_ids)";
            $sQuery     = "SELECT fldid, fldname FROM `tbltopics`";

            $ConnBean->getPreparedStatement($sQuery);
            $allTopicsList = $ConnBean->resultset();
            $topicsInfo    = array();
            foreach($allTopicsList as $topic)
            {
                $topicsInfo[$topic['fldid']] = array(JSON_TAG_ID => intval($topic['fldid']), JSON_TAG_TITLE => $topic['fldname']);
            }
            $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;
        }
        catch(Exception $e)
        {
            $finalResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function to Get the details of an insight to share in Social media .
     *
     * @param $insight_id
     */
    public function get_socialmedia_share_details($ConnBean, $iInsight_id)
    {
        try
        {

            $s3bridge = new COREAwsBridge();
            $sQuery   = "SELECT i.fldname,CONCAT(COALESCE(e.fldprefix,''),' ',COALESCE(e.fldfirstname,''),' ',COALESCE(e.fldlastname,'')) AS expert_name ,e.fldfbshareimage,i.fldfbsharedescription, i.fldinsighturl,i.fldstreamingfilename,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldtwitterhandle FROM tblinsights i LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid WHERE i.fldisdeleted =0 AND i.fldisonline=1 AND i.fldid = :insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":insightid", $iInsight_id);
            $insight = $ConnBean->single();
            if(!empty($insight))
            {
                $sImageName                      = $insight[DB_COLUMN_FLD_FBSHARE_IMAGE];
                $sImageURL                       = isset($insight[DB_COLUMN_FLD_FBSHARE_IMAGE]) ? $s3bridge->GetS3ExpertAvatarURL($sImageName) : "";
                $sStreamingURL                   = empty($insight[DB_COLUMN_FLD_STREAMING_FILENAME]) ? "" : $s3bridge->GetS3InsightURL($insight[DB_COLUMN_FLD_STREAMING_FILENAME]);
                $bResult[JSON_TAG_TITLE]         = $insight[DB_COLUMN_FLD_NAME];
                $bResult[JSON_TAG_EXPERT_NAME]   = trim($insight[JSON_TAG_EXPERT_NAME]);
                $bResult[JSON_TAG_FBSHARE_IMAGE] = $sImageURL;
                $bResult[JSON_TAG_INSIGHT_URL]   = isset($insight[DB_COLUMN_FLD_INSIGHT_URL])?$s3bridge->GetS3MasterInsightURL($insight[DB_COLUMN_FLD_INSIGHT_URL]):"";
                //$bResult[JSON_TAG_STREAMINGURL]  = $sStreamingURL;
                $bResult[JSON_TAG_STREAMINGURL_ENC]  = empty($insight['fldstreamingfilename_enc']) ? null : $insight['fldstreamingfilename_enc'];;
                $bResult[JSON_TAG_FBSHARE_DESC]  = isset($insight[DB_COLUMN_FLD_FBSHARE_DESC]) ? $insight[DB_COLUMN_FLD_FBSHARE_DESC] : "";
                $bResult[JSON_TAG_TWITTER_HANDLE]= isset($insight[DB_COLUMN_FLD_TWITTER_HANDLE]) ? $insight[DB_COLUMN_FLD_TWITTER_HANDLE] : "";
                $iStatus                         = SERVER_NOERROR;
            }
            else
            {
                $iStatus = SERVER_ERRCODE_EXCEPTION;
            }
        }
        catch(Exception $e)
        {
            $iStatus = SERVER_ERRCODE_EXCEPTION;
        }

        $bResult[JSON_TAG_STATUS] = $iStatus;

        return $bResult;
    }

    public function updateInsightShortUrl($inConnBean,$awsbridge)
    {
        $this->test_encode_decode($inConnBean,$awsbridge);
        exit;
//        
        $encrypt = new Aes();
         
        $sQuery = "select fldid,fldstreamingfilename, fldstreamingfilenamehlsv4, fldstreamingurl,client_id from tblinsights where 1";
        $inConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $inConnBean->resultset();

        foreach($allInsightsList as $insightsData)
        {

            try
            {
                $insightid = $insightsData['fldid'];
                $client_id = $insightsData['client_id'];

                $streamingFile = $insightsData['fldstreamingfilename'];
                $streamingFileNamehlsv4 = $insightsData['fldstreamingfilenamehlsv4'];
                $streamingUrl = $insightsData['fldstreamingurl'];
                                
                $short_code = $this->generate_short_url();
                if(!empty($short_code)) {
                    $streamingFile_short = $short_code['streamingUrl_short'];
                    $streamingFileNamehlsv4_short = $short_code['streamingFileNamehlsv4_short'];

                    //encrypt the url
                    $streamingFile_short_enc = trim($encrypt->encode($streamingFile_short));
                    $streamingFileNamehlsv4_short_enc = trim($encrypt->encode($streamingFileNamehlsv4_short));
                } else {
                    $streamingUrl_short = null;
                    $streamingFileNamehlsv4_short = null;
                    $streamingUrl_short_enc = null;
                    $streamingFileNamehlsv4_short_enc = null;
                }
                
                $sQuery = "UPDATE tblinsights SET fldstreamingfilename_enc = :streamingfile_enc,fldstreamingfilenamehlsv4_enc = :streamingfilenamehlsv4_enc,fldstreamingfilename_short_code = :streamingfile_short_code,fldstreamingfilenamehlsv4_short_code = :streamingfilenamehlsv4_short_code WHERE fldid = :insightid";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":streamingfile_enc", $streamingFile_short_enc);
                $inConnBean->bind_param(":streamingfilenamehlsv4_enc", $streamingFileNamehlsv4_short_enc);
                $inConnBean->bind_param(":streamingfile_short_code", $streamingFile_short);
                $inConnBean->bind_param(":streamingfilenamehlsv4_short_code", $streamingFileNamehlsv4_short);
                $inConnBean->bind_param(":insightid", $insightid);
                $bResult = $inConnBean->execute();
                
                //fldstreamingfilenamehlsv4_short_code
                               
//                die('3217');
                
            } catch(Exception $e)
            {
                echo "insightid : ".$insightid.'<br>';
                echo $e->getMessage();
                die('<br> Error !!');
            }
        }
        echo " <br>Success";  
                
        die('3170');

//        $googer = new GoogleURLAPI(GOOGLE_URL_SHORTNER_API_KEY);
        $encrypt = new Aes();
        $bitly = new BitLy();

        $sQuery = "select fldid,fldstreamingfilename, fldstreamingfilenamehlsv4, fldstreamingurl,client_id from tblinsights where 1";
        $inConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $inConnBean->resultset();

        foreach($allInsightsList as $insightsData)
        {

            try
            {
                $insightid = $insightsData['fldid'];
                $client_id = $insightsData['client_id'];

                $streamingFile = $insightsData['fldstreamingfilename'];
                $streamingFileNamehlsv4 = $insightsData['fldstreamingfilenamehlsv4'];
                $streamingUrl = $insightsData['fldstreamingurl'];

                if(!empty($streamingFile)) {
                   $streamingFile_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingFile,$client_id));
                   $streamingFile_short_enc = trim($encrypt->encode($streamingFile_short));
                } else {
                    $streamingFile_short_enc = '';
                }
                if(!empty($streamingFileNamehlsv4)) {
                    $streamingFileNamehlsv4_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingFileNamehlsv4,$client_id));
                    $streamingFileNamehlsv4_short_enc = trim($encrypt->encode($streamingFileNamehlsv4_short));
                } else {
                    $streamingFileNamehlsv4_short_enc = '';
                }
                if(!empty($streamingUrl)) {
                    $streamingUrl_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingUrl,$client_id));
                    $streamingUrl_short_enc = trim($encrypt->encode($streamingUrl_short));
                } else {
                    $streamingUrl_short_enc = '';
                }

//
//                echo  '$streamingFile_short_enc : '.$streamingFile_short_enc.'<br>';
//                echo  '$streamingFileNamehlsv4_short_enc : '.$streamingFileNamehlsv4_short_enc.'<br>';
//                echo  '$streamingUrl_short_enc : '.$streamingUrl_short_enc.'<br>';

                $sQuery = "UPDATE tblinsights SET fldstreamingfilename_enc = :streamingfile_enc,fldstreamingfilenamehlsv4_enc = :streamingfilenamehlsv4_enc, fldstreamingurl_enc = :streamingurl_enc WHERE fldid = :insightid";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":streamingfile_enc", $streamingFile_short_enc);
                $inConnBean->bind_param(":streamingfilenamehlsv4_enc", $streamingFileNamehlsv4_short_enc);
                $inConnBean->bind_param(":streamingurl_enc", $streamingUrl_short_enc);
                $inConnBean->bind_param(":insightid", $insightid);
                $bResult = $inConnBean->execute();

//                echo "insightid : ".$insightid.'<br>';
//
//                echo "<br>streamingFile : ".$awsbridge->GetS3InsightURL($streamingFile,$client_id).'<br>';
//                echo "streamingFileNamehlsv4 : ".$awsbridge->GetS3InsightURL($streamingFileNamehlsv4,$client_id).'<br>';
//                echo "streamingUrl : ".$awsbridge->GetS3InsightURL($streamingUrl,$client_id).'<br>';
//
//                echo "<br>streamingFile short : ".$streamingFile_short.'<br>';
//                echo "streamingFileNamehlsv4 short : ".$streamingFileNamehlsv4_short.'<br>';
//                echo "streamingUrl short : ".$streamingUrl_short.'<br>';
//
//                echo "<br> DEC streamingFile : ".$encrypt->decode($streamingFile_short_enc).'<br>';
//                echo "DEC streamingFileNamehlsv4 : ".$encrypt->decode($streamingFileNamehlsv4_short_enc).'<br>';
//                echo " DEC streamingUrl : ".$encrypt->decode($streamingUrl_short_enc).'<br>';
//
            }
            catch(Exception $e)
            {
                echo "insightid : ".$insightid.'<br>';
                echo $e->getMessage();
                die('<br> Error !!');
            }
        }
        echo " <br>Success";
    }

    function test_encode_decode($inConnBean,$awsbridge) {
        $encrypt = new Aes();
//        $bitly = new BitLy();

        //$sQuery = "select * from tblinsights where fldid=2246";
        //$sQuery = "select * from tblinsights where fldid=2897";
        $sQuery = "select * from tblinsights where fldid=2891";
        $sQuery = "select * from tblinsights where fldid=19";
//        $sQuery = "select * from tblinsights where fldid=2911";
        $sQuery = "select * from tblinsights where fldid=2913";
        $sQuery = "select * from tblinsights where fldid=1";
        $inConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $inConnBean->resultset();

        foreach($allInsightsList as $insightsData)
        {
            $insightid = $insightsData['fldid'];
            $client_id = $insightsData['client_id'];

            $streamingFile = trim($insightsData['fldstreamingfilename_short_code']);
//          $streamingFileNamehlsv4 = trim($insightsData['fldstreamingfilenamehlsv4']);
//          $streamingUrl = trim($insightsData['fldstreamingurl']);
//
            $streamingFile_short_enc = $insightsData['fldstreamingfilename_enc'];
//          $streamingFileNamehlsv4_short_enc = $insightsData['fldstreamingfilenamehlsv4_enc'];
//          $streamingUrl_short_enc = $insightsData['fldstreamingurl_enc'];
//
//          $streamingFile_short = $googer->shorten($awsbridge->GetS3InsightURL($streamingFile,$client_id));
//          $streamingFileNamehlsv4_short = $googer->shorten($awsbridge->GetS3InsightURL($streamingFileNamehlsv4,$client_id));
//          $streamingUrl_short = $googer->shorten($awsbridge->GetS3InsightURL($streamingUrl,$client_id));
//
            echo "<br>streamingFile : ".$streamingFile.'<br>';
//            echo "<br>streamingFile : ".$awsbridge->GetS3InsightURL($streamingFile,$client_id).'<br>';
//          echo "streamingFileNamehlsv4 : ".$awsbridge->GetS3InsightURL($streamingFileNamehlsv4,$client_id).'<br>';
//          echo "streamingUrl : ".$awsbridge->GetS3InsightURL($streamingUrl,$client_id).'<br>';
//
//            $streamingFile_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingFile,$client_id));
//          $streamingFileNamehlsv4_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingFileNamehlsv4,$client_id));
//          $streamingUrl_short = $bitly->shortenUrl($awsbridge->GetS3InsightURL($streamingUrl,$client_id));
//
//            echo "<br><br>streamingFile short : ".$streamingFile_short.'<br>';
//          echo "streamingFileNamehlsv4 short : ".$streamingFileNamehlsv4_short.'<br>';
//          echo "streamingUrl short : ".$streamingUrl_short.'<br>';
//
            echo "<br><br>streamingFile_short_enc : ".$streamingFile_short_enc.'<br>';
//          echo "streamingFileNamehlsv4_short_enc : ".$streamingFileNamehlsv4_short_enc.'<br>';
//          echo "streamingUrl_short_enc : ".$streamingUrl_short_enc.'<br>';
//
            echo "<br><br>streamingFile_short_dec : ".$encrypt->decode(trim($streamingFile_short_enc)).'<br>';
//          echo "DEC streamingFileNamehlsv4 : ".$encrypt->decode($streamingFileNamehlsv4_short_enc).'<br>';
//          echo " DEC streamingUrl : ".$encrypt->decode($streamingUrl_short_enc).'<br>';
//
//            $streamingFile_bitly_expand = $bitly->expandUrlByUrl($encrypt->decode($streamingFile_short_enc));
//          $streamingFileNamehlsv4_bitly_expand = $bitly->expandUrlByUrl($encrypt->decode($streamingFileNamehlsv4_short_enc));
//          $streamingUrl_bitly_expand = $bitly->expandUrlByUrl($encrypt->decode($streamingUrl_short_enc));

//            echo "<br><br>streamingFile : ".$streamingFile_bitly_expand.'<br>';
//          echo "streamingFileNamehlsv4 : ".$streamingFileNamehlsv4_bitly_expand.'<br>';
//          echo " streamingUrl : ".$streamingUrl_bitly_expand.'<br>';

        }
    }
    
    public function generate_short_url() {

        $short_code = array();

        $streamingUrl_short_id=rand(time()+10000,time()+99999);
        $streamingUrl_short=base_convert($streamingUrl_short_id,20,36);

        $streamingFileNamehlsv4_short_id=rand(time()+100000,time()+999999);
        $streamingFileNamehlsv4_short=base_convert($streamingFileNamehlsv4_short_id,20,36);

        $ConnBean   = new COREDbManager();
        $sQuery = "SELECT *  FROM tblinsights WHERE (fldstreamingfilename_enc = :streamingUrl_short OR fldstreamingfilenamehlsv4_enc = :streamingFileNamehlsv4_short)";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(':streamingUrl_short', $streamingUrl_short);
        $ConnBean->bind_param(':streamingFileNamehlsv4_short', $streamingFileNamehlsv4_short);
        $result = $ConnBean->single();
        if(!empty($result) || $streamingUrl_short === $streamingFileNamehlsv4_short) {
            $this->redirect();
        } else {
            $short_code = array(
                'streamingUrl_short' => $streamingUrl_short,
                'streamingFileNamehlsv4_short' => $streamingFileNamehlsv4_short
                    );
        }

        return $short_code;
    }
    
    public function getRedirect3Url($ConnBean, $short_code, $awsbridge) {
        $url = false;
        try {
            $sQuery = "SELECT fldid,client_id,fldstreamingfilename FROM tblinsights WHERE fldstreamingfilename_short_code = :fldstreamingfilename_short_code";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldstreamingfilename_short_code', $short_code);
            $result = $ConnBean->single();

            if (!empty($result)) {
                if(!empty($result['fldstreamingfilename'])) {
                    $insightId = $result['fldid'];
                    $sQuery = "UPDATE `tblinsights` SET `active_users_count`= `active_users_count` + 1 WHERE `fldid` = ?";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(1, $insightId);
                    $ConnBean->execute();


                    $clientId = $result['client_id'];
                    $awsbridge = new COREAwsBridge();
                    $url = $awsbridge->GetS3InsightURL($result['fldstreamingfilename'], $clientId);
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die('<br> Error !!');
        }
         return $url;
    }

    public function getRedirect4Url($ConnBean, $short_code, $awsbridge) {
        $url = false;
        try {
            $sQuery = "SELECT fldid,client_id,fldstreamingfilenamehlsv4 FROM tblinsights WHERE fldstreamingfilenamehlsv4_short_code = :fldstreamingfilenamehlsv4_short_code ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldstreamingfilenamehlsv4_short_code', $short_code);
            $result = $ConnBean->single();

            if (!empty($result)) {
                if(!empty($result['fldstreamingfilenamehlsv4'])) {
                    $insightId = $result['fldid'];
                    $sQuery = "UPDATE `tblinsights` SET `active_users_count`= `active_users_count` + 1 WHERE `fldid` = ?";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(1, $insightId);
                    $ConnBean->execute();
                
                    $clientId = $result['client_id'];
                    $awsbridge = new COREAwsBridge();                        
                    $url = $awsbridge->GetS3InsightURL($result['fldstreamingfilenamehlsv4'], $clientId);
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die('<br> Error !!');
        }

         return $url;
    }
    
    public function disEngageActiveUser($ConnBean, $insightId) {

        try {

            $sQuery = "SELECT active_users_count FROM tblinsights WHERE fldid = :fldid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':fldid', $insightId);
            $result = $ConnBean->single();
            if (!empty($result)) {
                if (!empty($result['active_users_count']) && $result['active_users_count'] > 0) {
                    $sQuery = "UPDATE `tblinsights` SET `active_users_count`= `active_users_count` - 1 WHERE `fldid` = ?";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(1, $insightId);
                    $ConnBean->execute();
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die('<br> Error !!');
        }

        return "success";
    }

    public function getTrendingInsights($ConnBean, $clientId, $page_no) {
        $limit_start = ($page_no - 1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;

        $sQuery = null;
        $iResult = array();
        $allinsights = array();
        $finalResult = array();
        $expert_ids = null;
        $topics_ids = null;
        $s3bridge = new COREAwsBridge();

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight = $mostListenedWeight['fldexpertweighting'] / 100;

        $where = "AND (i.client_id='audvisor11012017')";

        $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname,e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,i.listened_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 and i.listened_count > 0 " . $where . " GROUP BY i.fldid ORDER BY i.listened_count DESC ,i.fldname ASC  limit $limit_start," . JSON_TAG_DISPLAY_INSIGHT_LIMIT;

        $sQuery_total_count = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,i.listened_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 and i.listened_count > 0 " . $where . " GROUP BY i.fldid ORDER BY i.listened_count DESC ,i.fldname ASC ";


        $ConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $ConnBean->resultset();
        $insightsList = array();
        $topics = array();
        $experts = array();
        $iResult = array(JSON_TAG_TYPE => 'trending insights');
        $insights_count = 0;
        foreach ($allInsightsList as $insights) {
            $expertid = $insights['fldexpertid'];
            array_push($experts, $expertid);
            if ($insights['fldid']) {
                $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                $topicid = implode(",", $iTopics);
                array_push($topics, $topicid);
            }
            $streamingUrl = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME], $clientId);
            $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4], $clientId);
            $allinsights = array(
                JSON_TAG_ID => $insights['fldid'], 
                JSON_TAG_TITLE => $insights['fldname'], 
                JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], 
                JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], 
                JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], 
                JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), 
                JSON_TAG_TOPIC_IDS => $iTopics);

            $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
            $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];

            $allinsights['listened_count'] = intval($insights['listened_count']);

            array_push($insightsList, $allinsights);
            $insights_count++;
        }

        // to shuffle the insights everytime -  added on 24-Oct-2017
        //  uksort($insightsList, function() { return rand() > rand(); }); // by mainiting keys
        shuffle($insightsList); // changing keys
        
        $iResult[JSON_TAG_INSIGHTS] = $insightsList;

        $expert_ids = implode(",", $experts);
        $sQuery = "SELECT  fldid,fldprefix, fldfirstname, fldmiddlename, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

        $ConnBean->getPreparedStatement($sQuery);
        $allExpertsList = $ConnBean->resultset();
        $expertsInfo = array();
        $experts_count = 0;
        foreach ($allExpertsList as $experts) {
            $title = trim($experts['fldfirstname']) ." ". trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]). " " . trim($experts['fldlastname']);
            if (!empty($experts[DB_COLUMN_FLD_PREFIX])) {
                $title = trim($experts[DB_COLUMN_FLD_PREFIX]) . " " . trim($title);
            }

            $expertAvatar = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL], $clientId);
            $expertsInfo[$experts['fldid']] = array(
                    JSON_TAG_ID => intval($experts['fldid']), 
                    JSON_TAG_TITLE => trim($title), 
                    JSON_TAG_FIRST_NAME => trim($experts[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($experts[DB_COLUMN_FLD_LAST_NAME]),
                    JSON_TAG_SUBTITLE => trim($experts['fldtitle']), 
                    JSON_TAG_AVATAR_LINK => $expertAvatar
                );
            $experts_count++;
        }
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topics_ids = implode(",", $topics);
        $sQuery = "SELECT fldid, fldname,fldiconurl from `tbltopics` WHERE `fldid` IN ($topics_ids)";
//        $sQuery = "SELECT fldid, fldname FROM `tbltopics`";

        $ConnBean->getPreparedStatement($sQuery);
        $allTopicsList = $ConnBean->resultset();
        $topicsInfo = array();
        $topics_count = 0;
        foreach ($allTopicsList as $topic) {
            $topicsInfo[$topic['fldid']] = array(
                JSON_TAG_ID => intval($topic['fldid']), 
                JSON_TAG_TITLE => $topic['fldname'],
                JSON_TAG_FLD_TOPIC_ICON => (!empty($topic['fldiconurl'])) ? $s3bridge->GetS3TopicIconURL($topic['fldiconurl'], $clientId) : NULL
                    );
            $topics_count++;
        }
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        $iResult['insights_count'] = $insights_count;
        $iResult['experts_count'] = $experts_count;
        $iResult['topics_count'] = $topics_count;

        $ConnBean->getPreparedStatement($sQuery_total_count);
        $ConnBean->execute();
        $sQuery_total_count = $ConnBean->rowCount();
        $total_page_nos = $sQuery_total_count / (int) JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $total_page_nos = ceil($total_page_nos);
//            $iResult['sQuery_total_count'] = $sQuery_total_count;
//            $iResult['total_page_nos'] = $total_page_nos;
        if ($page_no < $total_page_nos) {
            $iResult['page_no'] = $page_no;
        }

        return $iResult;
    }

    /**
     * Function used to update the featured status of insight.
     *
     * @param $ConnBean
     * @param $insight_id
     *
     * @return array
     */
    public function toggleFeaturedInsight($ConnBean, $insight_id) {
        $aResult = array();

        try {
            $sQuery = "SELECT fldisonline,fldstreamingfilename,fldinsighturl,isfeatured FROM tblinsights WHERE fldid= :insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':insightid', $insight_id);
            $bResult = $ConnBean->single();
            $s3bridge = new COREAwsBridge();
            $streamingUrl = empty($bResult[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($bResult[DB_COLUMN_FLD_STREAMING_FILENAME]);
            if ($streamingUrl == null || $streamingUrl == "") {
                $aResult['result'] = ERRCODE_INVALID_STREAMING_URL;
            } else {
                $iResult = !(intval($bResult['isfeatured']));

                //////////////////////

                if ($iResult === true) {

                    $sQuery_0 = "SELECT count(*) as total_featured_insights FROM tblinsights WHERE isfeatured = :isfeatured and fldisonline = :isonline and fldisdeleted = :isdeleted ";
                    $ConnBean->getPreparedStatement($sQuery_0);
                    $ConnBean->bind_param(':isfeatured', 1);
                    $ConnBean->bind_param(':isonline', 1);
                    $ConnBean->bind_param(':isdeleted', 0);
                    $bResult_0 = $ConnBean->single();

                    if (!empty($bResult_0['total_featured_insights']) && $bResult_0['total_featured_insights'] >= JSON_TAG_FEATURED_INSIGHT_COUNT) {
                        $aResult['featured_insight_count'] = JSON_TAG_FEATURED_INSIGHT_COUNT;
                        $aResult['result'] = ERRCODE_INVALID_FEATURED_INSIGHT_COUNT_ERROR;
                        return $aResult;
                    }
                }

                //////////////////////

                $redis = CORERedisConnection::getRedisInstance();
                $sQuery = "UPDATE tblinsights SET isfeatured = :featured WHERE fldid = :insightid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(':featured', $iResult);
                $ConnBean->bind_param(':insightid', $insight_id);
                $bResult = $ConnBean->execute();
                if ($bResult) {
                    if ($redis) {
                        $this->invalidateCache($redis);
                    }
                    $aResult['result'] = $iResult;
                    $aResult[JSON_TAG_STATUS] = 0;

                    return $aResult;
                }
            }

            $aResult[JSON_TAG_STATUS] = 0;
        } catch (Exception $e) {
            $aResult[JSON_TAG_STATUS] = 1;
        }

        return $aResult;
    }

    public function getFeaturedInsights($ConnBean, $clientId, $page_no) {
        $limit_start = ($page_no - 1) * JSON_TAG_DISPLAY_INSIGHT_LIMIT;

        $sQuery = null;
        $iResult = array();
        $allinsights = array();
        $finalResult = array();
        $expert_ids = null;
        $topics_ids = null;
        $s3bridge = new COREAwsBridge();

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight = $mostListenedWeight['fldexpertweighting'] / 100;

        $where = "AND ((i.client_id='" . $clientId . "') OR (i.client_id='audvisor11012017'))";

        $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,i.listened_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 and i.isfeatured = 1 " . $where . " GROUP BY i.fldid ORDER BY i.fldid DESC ,i.fldname ASC  limit $limit_start," . JSON_TAG_DISPLAY_INSIGHT_LIMIT;


        $sQuery_total_count = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname,e.fldmiddlename, e.fldlastname, e.fldtitle, e.fldavatarurl,i.listened_count FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE  i.fldisdeleted =0 AND i.fldisonline =1 and i.isfeatured = 1 " . $where . " GROUP BY i.fldid ORDER BY i.fldid DESC ,i.fldname ASC ";


        $ConnBean->getPreparedStatement($sQuery);
        $allInsightsList = $ConnBean->resultset();
        $insightsList = array();
        $topics = array();
        $experts = array();
        $iResult = array(JSON_TAG_TYPE => 'featured insights');

        ///////////////
        $allInsightsList_count = $ConnBean->rowCount();
        if ((int) $allInsightsList_count === 0) {
            $iResult['type'] = "error";
            $iResult['description'] = NO_INSIGHTS_ERROR;
            return $iResult;
        }
        ///////////////

        $insights_count = 0;
        foreach ($allInsightsList as $insights) {
            $expertid = $insights['fldexpertid'];
            array_push($experts, $expertid);
            if ($insights['fldid']) {
                $iTopics = $this->get_topicids($ConnBean, $insights['fldid']);
                $topicid = implode(",", $iTopics);
                array_push($topics, $topicid);
            }
            $streamingUrl = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME], $clientId);
            $streamingFileNamehlsv4 = empty($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($insights[DB_COLUMN_FLD_STREAMING_FILENAME_V4], $clientId);
            $allinsights = array(
                    JSON_TAG_ID => $insights['fldid'], 
                    JSON_TAG_TITLE => $insights['fldname'], 
                    JSON_TAG_CREATED_DATE => $insights[DB_COLUMN_FLD_CREATED_DATE], 
                    JSON_TAG_STATIC_REPUTATION => $insights['static_rating'], 
                    JSON_TAG_INSIGHT_DURATION => $insights['fldduration'], 
                    JSON_TAG_EXPERT_ID => intval($insights['fldexpertid']), 
                    JSON_TAG_TOPIC_IDS => $iTopics
                );

            $allinsights[JSON_TAG_STREAMINGURL_ENC] = empty($insights['fldstreamingfilename_enc']) ? null : $insights['fldstreamingfilename_enc'];
            $allinsights[JSON_TAG_STREAMING_FILENAME_V4_ENC] = empty($insights['fldstreamingfilenamehlsv4_enc']) ? null : $insights['fldstreamingfilenamehlsv4_enc'];

            $allinsights['listened_count'] = intval($insights['listened_count']);

            array_push($insightsList, $allinsights);
            $insights_count++;
        }

        // to shuffle the insights everytime -  added on 24-Oct-2017
        //  uksort($insightsList, function() { return rand() > rand(); }); // by mainiting keys
        shuffle($insightsList); // changing keys
        
        $iResult[JSON_TAG_INSIGHTS] = $insightsList;

        $expert_ids = implode(",", $experts);
        $sQuery = "SELECT  fldid,fldprefix, fldfirstname, fldmiddlename, fldlastname, fldtitle, fldavatarurl from `tblexperts` WHERE `fldid` IN ($expert_ids)";

        $ConnBean->getPreparedStatement($sQuery);
        $allExpertsList = $ConnBean->resultset();
        $expertsInfo = array();
        $experts_count = 0;
        foreach ($allExpertsList as $experts) {
            $title = trim($experts['fldfirstname']) ." ".trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]). " " . trim($experts['fldlastname']);
            if (!empty($experts[DB_COLUMN_FLD_PREFIX])) {
                $title = trim($experts[DB_COLUMN_FLD_PREFIX]) . " " . trim($title);
            }

            $expertAvatar = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL], $clientId);
            $expertsInfo[$experts['fldid']] = array(
                    JSON_TAG_ID => intval($experts['fldid']), 
                    JSON_TAG_TITLE => trim($title), 
                    JSON_TAG_FIRST_NAME => trim($experts[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($experts[DB_COLUMN_FLD_LAST_NAME]),
                    JSON_TAG_SUBTITLE => trim($experts['fldtitle']), 
                    JSON_TAG_AVATAR_LINK => $expertAvatar
                );
            $experts_count++;
        }
        $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo;

        $topics_ids = implode(",", $topics);
        $sQuery = "SELECT fldid, fldname,fldiconurl from `tbltopics` WHERE `fldid` IN ($topics_ids)";
//        $sQuery     = "SELECT fldid, fldname FROM `tbltopics`";

        $ConnBean->getPreparedStatement($sQuery);
        $allTopicsList = $ConnBean->resultset();
        $topicsInfo = array();
        $topics_count = 0;
        foreach ($allTopicsList as $topic) {
            $topicsInfo[$topic['fldid']] = array(
                JSON_TAG_ID => intval($topic['fldid']), 
                JSON_TAG_TITLE => $topic['fldname'],
                JSON_TAG_FLD_TOPIC_ICON => (!empty($topic['fldiconurl'])) ? $s3bridge->GetS3TopicIconURL($topic['fldiconurl'], $clientId) : NULL
                    );
            $topics_count++;
        }
        $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo;

        $iResult['insights_count'] = $insights_count;
        $iResult['experts_count'] = $experts_count;
        $iResult['topics_count'] = $topics_count;

        $ConnBean->getPreparedStatement($sQuery_total_count);
        $ConnBean->execute();
        $sQuery_total_count = $ConnBean->rowCount();
        $total_page_nos = $sQuery_total_count / (int) JSON_TAG_DISPLAY_INSIGHT_LIMIT;
        $total_page_nos = ceil($total_page_nos);
//            $iResult['sQuery_total_count'] = $sQuery_total_count;
//            $iResult['total_page_nos'] = $total_page_nos;
        if ($page_no < $total_page_nos) {
            $iResult['page_no'] = $page_no;
        }

        return $iResult;
    }

    public function getTotalInsightsCount($ConnBean, $clientId) {

        $aResult['total_audvisor_insights'] = 0;
        $aResult['total_client_insights'] = 0;
        $aResult['total_insights'] = 0;

        $sQuery_a = "SELECT count(*) as total_audvisor_insights FROM tblinsights WHERE client_id = :clientId and fldisonline = :isonline and fldisdeleted = :isdeleted ";
        $ConnBean->getPreparedStatement($sQuery_a);
        $ConnBean->bind_param(':clientId', 'audvisor11012017');
        $ConnBean->bind_param(':isonline', 1);
        $ConnBean->bind_param(':isdeleted', 0);
        $bResult_a = $ConnBean->single();

        if (!empty($bResult_a['total_audvisor_insights'])) {
            $aResult['total_audvisor_insights'] = $bResult_a['total_audvisor_insights'];
        }

        $sQuery_b = "SELECT count(*) as total_client_insights FROM tblinsights WHERE client_id = :clientId and fldisonline = :isonline and fldisdeleted = :isdeleted ";
        $ConnBean->getPreparedStatement($sQuery_b);
        $ConnBean->bind_param(':clientId', $clientId);
        $ConnBean->bind_param(':isonline', 1);
        $ConnBean->bind_param(':isdeleted', 0);
        $bResult_b = $ConnBean->single();

        if (!empty($bResult_b['total_client_insights'])) {
            $aResult['total_client_insights'] = $bResult_b['total_client_insights'];
        }

        $aResult['total_insights'] = $aResult['total_audvisor_insights'] + $aResult['total_client_insights'];

        return $aResult;
    }

    public function list_insight_by_ids($ConnBean, $insightid) {
        $insightsList = array();
        $topics = array();
        $experts = array();
        $iResult = array();

        $mostListenedWeight = $this->getGeneralSettings($ConnBean);
        $insightWeight = $mostListenedWeight['fldinsightweighting'] / 100;
        $expertWeight = $mostListenedWeight['fldexpertweighting'] / 100;
        $s3bridge = new COREAwsBridge();
        $iTopics = array();
        $expertsInfo = array();
        $topicsInfo = array();
        $str_topics_ids = '';

        try {

            $where = '';
            $sQuery = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating * $expertWeight)) AS static_rating, group_concat(ti.fldtopicid SEPARATOR ',') as topics ,i.client_id,i.fldid , i.fldname, i.fldmodifieddate, i.fldcreateddate,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4,i.fldexpertid,i.fldduration,i.fldstreamingfilename_enc, i.fldstreamingfilenamehlsv4_enc, i.fldstreamingurl_enc, e.fldfirstname, e.fldlastname, e.fldtitle, e.fldavatarurl FROM tblinsights i LEFT JOIN  tblinsightreputation as ir on i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid left join tbltopicinsight as ti on ti.fldinsightid=i.fldid   WHERE i.fldid IN ($insightid) AND i.fldisdeleted =0 AND i.fldisonline =1 " . $where . " GROUP BY i.fldid ORDER BY static_rating DESC,i.fldid ";
            $ConnBean->getPreparedStatement($sQuery);
            $aResult = $ConnBean->resultset();
            $insights_count = 0;
            if (!empty($aResult)) {
                foreach ($aResult as $data) {
                    $clientId = $data['client_id'];
                    $expertid = $data['fldexpertid'];
                    array_push($experts, $expertid);
                    $iTopics = explode(",", ($data['topics']));
                    $str_topics_ids .= $data['topics'] . ",";
                    $allinsights = array(
                        JSON_TAG_ID => $data['fldid'],
                        JSON_TAG_TITLE => $data['fldname'],
                        JSON_TAG_CREATED_DATE => $data[DB_COLUMN_FLD_CREATED_DATE],
                        JSON_TAG_STATIC_REPUTATION => $data['static_rating'],
                        JSON_TAG_INSIGHT_DURATION => $data['fldduration'],
                        JSON_TAG_EXPERT_ID => intval($data['fldexpertid']),
                        JSON_TAG_TOPIC_IDS => $iTopics,
                        JSON_TAG_STREAMINGURL_ENC => empty($data['fldstreamingfilename_enc']) ? null : $data['fldstreamingfilename_enc'],
                        JSON_TAG_STREAMING_FILENAME_V4_ENC => empty($data['fldstreamingfilenamehlsv4_enc']) ? null : $data['fldstreamingfilenamehlsv4_enc']
                    );
                    array_push($insightsList, $allinsights);
                    $insights_count++;
                }

                $expertsInfo = $this->getExpertDetails($ConnBean, $experts, $clientId);
                $topicsInfo = $this->getTopicsDetails($ConnBean, $topics, $str_topics_ids, $clientId);

                $iResult[JSON_TAG_INSIGHTS] = $insightsList;
                $iResult[JSON_TAG_ALL_EXPERTS] = $expertsInfo['expertsInfo'];
                $iResult[JSON_TAG_ALL_TOPICS] = $topicsInfo['topicsInfo'];


                $iResult['insights_count'] = $insights_count;
                $iResult['experts_count'] = $expertsInfo['experts_count'];
                $iResult['topics_count'] = $topicsInfo['topics_count'];
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            $iResult[JSON_TAG_STATUS] = 2;
        }
        return $iResult;
    }

    private function getExpertDetails($ConnBean, $experts=array(), $clientId) {
        $s3bridge = new COREAwsBridge();
        $expertData = array();
        $expert_ids = 0;
        if(!empty($experts)) {
            $expert_ids = implode(",", $experts);
        }
        
        try {
            
        
            $sQuery = "SELECT  fldid,client_id,fldprefix, fldfirstname, fldmiddlename, fldlastname, fldtitle, fldavatarurl,fldbioimage,fldthumbimage,fldpromoimage,fldlistviewimage,fldfbshareimage from `tblexperts` WHERE `fldid` IN ($expert_ids)";

            $ConnBean->getPreparedStatement($sQuery);
            $allExpertsList = $ConnBean->resultset();
            $expertsInfo = array();
            $experts_count = 0;
            foreach ($allExpertsList as $experts) {
                $title = trim($experts['fldfirstname']) ." ".trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]). " " . trim($experts['fldlastname']);
                $experts_client_id = $experts['client_id'];
                if (!empty($experts[DB_COLUMN_FLD_PREFIX])) {
                    $title = trim($experts[DB_COLUMN_FLD_PREFIX]) . " " . trim($title);
                }

                $expertAvatar = empty($experts[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_AVATAR_URL], $experts_client_id);

                $expertBioImage = empty($experts[DB_COLUMN_FLD_BIO_IMAGE]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_BIO_IMAGE], $experts_client_id);
                $expertThumbnailImage = empty($experts[DB_COLUMN_FLD_THUMB_IMAGE]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_THUMB_IMAGE], $experts_client_id);
                $expertPromoImage = empty($experts[DB_COLUMN_FLD_PROMO_IMAGE]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_PROMO_IMAGE], $experts_client_id);
                $expertListImage = empty($experts[DB_COLUMN_FLD_LISTVIEW_IMAGE]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_LISTVIEW_IMAGE], $experts_client_id);
                $expertFBshareImage = empty($experts[DB_COLUMN_FLD_FBSHARE_IMAGE]) ? null : $s3bridge->GetS3ExpertAvatarURL($experts[DB_COLUMN_FLD_FBSHARE_IMAGE], $experts_client_id);

                $expertsInfo[$experts['fldid']] = array(
                    JSON_TAG_ID => intval($experts['fldid']),
                    JSON_TAG_TITLE => trim($title),
                    JSON_TAG_FIRST_NAME => trim($experts[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($experts[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($experts[DB_COLUMN_FLD_LAST_NAME]),
                    JSON_TAG_SUBTITLE => trim($experts['fldtitle']),
                    JSON_TAG_AVATAR_LINK => $expertAvatar,
                    JSON_TAG_EXPERT_BIO_IMAGE => $expertBioImage,
                    JSON_TAG_EXPERT_THUMBNAIL_IMAGE => $expertThumbnailImage,
                    JSON_TAG_EXPERT_PROMO_IMAGE => $expertPromoImage,
                    JSON_TAG_LISTVIEW_IMAGE => $expertListImage,
                    JSON_TAG_FBSHARE_IMAGE => $expertFBshareImage
                );
                $experts_count++;
            }
            $expertData = array(
                'expertsInfo' => $expertsInfo,
                'experts_count' => $experts_count
            );
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
        
        return $expertData;
    }

    private function getTopicsDetails($ConnBean, $topics, $str_topics_ids, $clientId) {
        $s3bridge = new COREAwsBridge();
        $topicsData = array();
        
        try {

            if (!empty($str_topics_ids)) {
                $str_topics_ids = substr($str_topics_ids, 0, -1);
                $topics_ids_arr = explode(",", $str_topics_ids);
                $unique_topics_ids_arr = array_unique($topics_ids_arr);
                $topics_ids = implode(",", $unique_topics_ids_arr);
                $sQuery = "SELECT fldid, fldname, fldiconurl from `tbltopics` WHERE `fldid` IN ($topics_ids) group by fldid";
            } else {
                $sQuery = "SELECT fldid, fldname, fldiconurl FROM `tbltopics`";
            }

            $ConnBean->getPreparedStatement($sQuery);
            $allTopicsList = $ConnBean->resultset();
            $topicsInfo = array();
            $topics_count = 0;
            foreach ($allTopicsList as $topic) {
                $topicsInfo[$topic['fldid']] = array(
                    JSON_TAG_ID => intval($topic['fldid']),
                    JSON_TAG_TITLE => $topic['fldname'],
                    JSON_TAG_FLD_TOPIC_ICON => (!empty($topic['fldiconurl'])) ? $s3bridge->GetS3TopicIconURL($topic['fldiconurl'], $clientId) : NULL
                );
                $topics_count++;
            }
            $topicsData = array(
                'topicsInfo' => $topicsInfo,
                'topics_count' => $topics_count
            );
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
        return $topicsData;
    }

}

?>
