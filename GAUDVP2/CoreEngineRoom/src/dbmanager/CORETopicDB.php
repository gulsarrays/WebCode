<?php

/*
Project                     : Oriole
Module                      : Topic
File name                   : CORETopicDB.php
Description                 : Database class for Topic related activities
Copyright                   : Copyright © 2014, Audvisor Inc.
Written under contract by Robosoft Technologies Pvt. Ltd.
History                     :
*/

class CORETopicDB
{

    public function __construct()
    {
    }

    /**
     * Function used to get all topics details for cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function all_topics($ConnBean,$clientId)
    {
      
        $iResult     = array();
        $topicimages = array_fill(0, 4, NULL);

        try
        {
            $sQuery = "SELECT t.fldid, t.fldname,t.fldiconurl,t.fldcreateddate,t.fldmodifieddate, count(i.fldtopicid) AS count FROM tbltopics AS t LEFT JOIN tbltopicinsight AS i ON t.fldid=i.fldtopicid WHERE t.fldisdeleted = 0 AND t.client_id = :client_id GROUP BY t.fldname ORDER BY count DESC";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $result   = $ConnBean->resultset();
            $s3bridge = new COREAwsBridge();
            foreach($result as $topicDetails)
            {
                $topic_icon                  = (!empty($topicDetails[DB_COLUMN_FLD_TOPIC_ICON])) ? $s3bridge->GetS3TopicIconURL($topicDetails[DB_COLUMN_FLD_TOPIC_ICON],$clientId) : NULL;
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_TOPIC_ID => $topicDetails[DB_COLUMN_FLD_ID], JSON_TAG_TOPIC_NAME => $topicDetails[DB_COLUMN_FLD_NAME], JSON_TAG_TOPIC_ICON => $topic_icon, JSON_TAG_CREATED_DATE => $topicDetails[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $topicDetails[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_COUNT => $topicDetails[JSON_TAG_COUNT]);
            }
            if(count($iResult[JSON_TAG_RECORDS]) == 0)
            {
                $iResult[JSON_TAG_STATUS]  = 3;
                $iResult[JSON_TAG_RECORDS] = NULL;
            }
            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to get all topics details.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function list_all_topics($ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $s3bridge = new COREAwsBridge();
            
            //$sQuery   = "SELECT DISTINCT top.fldid, top.fldname,top.fldiconurl,top.fldcreateddate, top.fldmodifieddate,  (SELECT count(*) from tbltopicinsight where fldinsightid =top.fldid) as topiccount FROM tblinsights AS i LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid  WHERE  i.fldisdeleted = 0 AND top.fldisdeleted = 0 AND i.fldisonline = 1 AND top.client_id = :client_id ORDER BY top.fldname";
            
            $sQuery   = "SELECT DISTINCT top.fldid, top.fldname,top.fldiconurl,top.fldcreateddate, top.fldmodifieddate,top.client_id FROM tblinsights AS i LEFT JOIN tbltopicinsight AS t ON i.fldid = t.fldinsightid LEFT JOIN tbltopics AS top ON t.fldtopicid = top.fldid  WHERE  i.fldisdeleted = 0 AND top.fldisdeleted = 0 AND i.fldisonline = 1 AND (top.client_id = :client_id OR top.client_id = 'audvisor11012017') ORDER BY top.fldname";

            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $topics = $ConnBean->resultset();  
            if(!empty($topics)) {
                foreach($topics as $topic)
                {
                    $tmp_client_id = $topic['client_id'];
                    $sQuery_count   = "select count(*) as topiccount from tblinsights, tbltopicinsight where tbltopicinsight.fldinsightid = tblinsights.fldid and tblinsights.fldisdeleted  = 0 and tblinsights.fldisonline = 1 and tblinsights.client_id = :client_id and tbltopicinsight.fldtopicid = :topic_id ";                
                    $ConnBean->getPreparedStatement($sQuery_count);
                    $ConnBean->bind_param(":client_id", $tmp_client_id);
                    $ConnBean->bind_param(":topic_id", $topic[DB_COLUMN_FLD_ID]);
                    $topics_count = $ConnBean->resultset();
                    if(!empty($topics_count)) {
                        $topic[DB_COLUMN_FLD_TOPIC_COUNT] = $topics_count[0][DB_COLUMN_FLD_TOPIC_COUNT];
                    } else {
                        $topic[DB_COLUMN_FLD_TOPIC_COUNT] = 0;
                        continue;
                    }

                    $topic_icon                  = (!empty($topic[DB_COLUMN_FLD_TOPIC_ICON])) ? $s3bridge->GetS3TopicIconURL($topic[DB_COLUMN_FLD_TOPIC_ICON],$tmp_client_id): NULL;
                    $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_ID => intval($topic[DB_COLUMN_FLD_ID]), JSON_TAG_TITLE => $topic[DB_COLUMN_FLD_NAME], JSON_TAG_AVATAR_LINK => $topic_icon, JSON_TAG_CREATED_DATE => $topic[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $topic[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_TOPIC_COUNT => $topic[DB_COLUMN_FLD_TOPIC_COUNT],'client_id' => $tmp_client_id);
                }
            }
            if(!empty($iResult) && count($iResult[JSON_TAG_RECORDS]) == ERRCODE_NO_ERROR)
            {
                $iResult[JSON_TAG_STATUS]  = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $iResult[JSON_TAG_RECORDS] = NULL;
            }

            $iResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
  
        return $iResult;
    }

    /**
     * Function used to get all topic details.
     *
     * @param $topicid
     * @param $ConnBean
     *
     * @return array
     */
    public function get_topicdetails($topicid, $ConnBean)
    {
        $iResult = array();
        try
        {
            $s3bridge = new COREAwsBridge();
            $sQuery   = "SELECT fldid, fldname,fldiconurl,fldcreateddate,fldmodifieddate,client_id FROM tbltopics WHERE fldisdeleted = 0 AND fldid= :topicid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":topicid", $topicid);
            $aResult                  = $ConnBean->single();
            $client_id                = $aResult['client_id'];
            $topic_icon               = (!empty($aResult[DB_COLUMN_FLD_TOPIC_ICON])) ? $s3bridge->GetS3TopicIconURL($aResult[DB_COLUMN_FLD_TOPIC_ICON],$client_id) : null;
            $link                     = API_BASE_URL_STRING.API_VERSION.'/topics/'.$topicid;
            $iResult[JSON_TAG_RECORD] = array(
                JSON_TAG_TYPE => JSON_TAG_TOPIC, 
                JSON_TAG_CREATED_DATE => $aResult[DB_COLUMN_FLD_CREATED_DATE], 
                JSON_TAG_MODIFIED_DATE => $aResult[DB_COLUMN_FLD_MODIFIED_DATE], 
                JSON_TAG_ID => $aResult[DB_COLUMN_FLD_ID], 
                JSON_TAG_TOPIC_ICON => $topic_icon, 
                JSON_TAG_LINK => $link, 
                JSON_TAG_TITLE => $aResult[DB_COLUMN_FLD_NAME]);
            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $iResult[JSON_TAG_STATUS] = 2;
        }

        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_STATUS]  = 3;
            $iResult[JSON_TAG_RECORDS] = NULL;
        }

        return $iResult;
    }

    /**
     * Function used to create new Topic.
     *
     * @param $ConnBean
     * @param $topic_name
     *
     * @return array
     */
    public function insertTopic($ConnBean, $topic_name,$clientId)
    {
        $bResult = array();
        try
        {
            $cQuery = "SELECT COUNT(*) topiccount, fldisdeleted,fldid FROM tbltopics WHERE trim(fldname) LIKE :topicname ";
            $ConnBean->getPreparedStatement($cQuery);
            $ConnBean->bind_param(":topicname", $topic_name);
            $result        = $ConnBean->single();
            $topiccount    = $result[JSON_TAG_TOPIC_COUNT];
            $ifldisdeleted = $result[DB_COLUMN_FLD_ISDELETED];
            $ifldtopicid   = $result[DB_COLUMN_FLD_ID];
            if($ConnBean->rowCount() && $topiccount > 0 && $ifldisdeleted == 0)
            {
                $bResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                $redis = CORERedisConnection::getRedisInstance();
                if($ifldisdeleted)
                {
                    $topicid = $ifldtopicid;
                    $cQuery  = "UPDATE tbltopics SET fldisdeleted = 0   WHERE fldid = :topicid  ";
                    $ConnBean->getPreparedStatement($cQuery);
                    $ConnBean->bind_param(":topicid", $ifldtopicid);
                    $updatedTopicInfo = $ConnBean->execute();
                    if($redis && $updatedTopicInfo)
                    {
                        $cacheKey = "all_Topics";
                        $redis->del($cacheKey);
                    }
                }
                else
                {
                    $sQuery = "INSERT INTO tbltopics (fldname,fldcreateddate,client_id) VALUES (:topicname,NOW(),:client_id)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":topicname", $topic_name);
                    $ConnBean->bind_param(":client_id", $clientId);
                    $ConnBean->execute();
                    $topicid = $ConnBean->lastInsertId();
                    if($redis && $topicid)
                    {
                        $cacheKey = "all_Topics";
                        $redis->del($cacheKey);
                    }
                }

                $bResult[JSON_TAG_STATUS]  = 0;
                $link                      = API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_TOPICS.'/'.$topicid;
                $bResult[JSON_TAG_RECORDS] = array(JSON_TAG_TOPIC_ID => $topicid, JSON_TAG_TOPIC_NAME => $topic_name);
            }
        }
        catch(Exception $e)
        {
            $bResult[JSON_TAG_STATUS] = 2;
        }

        return $bResult;
    }

    /**
     * Function used to  update  topic data in the  database.
     *
     * @param $ConnBean
     * @param $TopicName
     * @param $TopicId
     *
     * @return mixed
     */
    public function edit_topic($ConnBean, $TopicName, $TopicId)
    {

        try
        {
            $redis  = CORERedisConnection::getRedisInstance();
            $sQuery = "UPDATE tbltopics SET fldname = :topicname   WHERE fldid = :topicid  ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":topicname", $TopicName);
            $ConnBean->bind_param(":topicid", $TopicId);
            $iexec_result = $ConnBean->execute();
            if($iexec_result)
            {
                $iResult[JSON_TAG_STATUS] = 1;
                if($redis)
                {
                    $cacheKey = "all_Topics";
                    $redis->del($cacheKey);
                }
            }
            else
            {
                $iResult[JSON_TAG_STATUS] = 2;
                $iResult['topicname']     = $TopicName;
            }

            $sQuery = "SELECT fldid, fldname,fldcreateddate,fldmodifieddate FROM tbltopics WHERE fldisdeleted = 0 AND fldid= :topicid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":topicid", $TopicId);
            $aResult = $ConnBean->single();

            $link                     = API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_TOPICS.'/'.$TopicId;
            $iResult[JSON_TAG_RECORD] = array(JSON_TAG_TYPE => JSON_TAG_TOPIC, JSON_TAG_CREATED_DATE => $aResult[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $aResult[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_ID => $aResult[DB_COLUMN_FLD_ID], JSON_TAG_LINK => $link, JSON_TAG_TITLE => $aResult[DB_COLUMN_FLD_NAME]);
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 3;
        }

        return $iResult;
    }

    /**
     * Function used to delete Topic.
     *
     * @param $topicid
     * @param $ConnBean
     *
     * @return array
     */
    public function deleteTopic($topicid, $ConnBean)
    {

        $iResult = array();
        try
        {
            $sQuery1 = "SELECT COUNT(*) topiccount FROM tbltopicinsight WHERE fldtopicid = :topicid";
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":topicid", $topicid);
            $result     = $ConnBean->single();
            $topiccount = $result[JSON_TAG_TOPIC_COUNT];
            if($topiccount > 0)
            {
                $iResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                $redis  = CORERedisConnection::getRedisInstance();
                $sQuery = "UPDATE tbltopics SET fldisdeleted = 1 WHERE fldid= :topicid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":topicid", $topicid);
                $deleteTopic = $ConnBean->execute();
                if($redis && $deleteTopic)
                {
                    $cacheKey = "all_Topics";
                    $redis->del($cacheKey);
                }

                $iResult[JSON_TAG_STATUS] = 0;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to  update  Topic image URL in the  database.
     *
     * @param $ConnBean
     * @param $topic_id
     * @param $fileName
     *
     * @return bool
     */
    public function patch_avatar_url($ConnBean, $topic_id, $fileName)
    {
        $bStatus = false;
        try
        {
            $sQuery = "UPDATE tbltopics SET fldiconurl= :filename WHERE fldid = :topicid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":filename", $fileName);
            $ConnBean->bind_param(":topicid", $topic_id);
            $ConnBean->execute();
            $bStatus = true;
        }
        catch(Exception $e)
        {
        }

        return $bStatus;
    }

    /**
     * Function used to  update  Topic image URLs in the  database.
     *
     * @param $ConnBean
     * @param $topic_id
     * @param $fileName
     *
     * @return bool
     */
    public function patch_avatar_urls($ConnBean, $topic_id, $fileName)
    {
        $bStatus = false;
        /*
        for($i = 0; $i < count($fileName); $i++)
        {
            if(strchr($fileName[$i], "ios_2x_thumbnail."))
            {
                $sfilename_2x_thumb = $fileName[$i];
            }
            else
            {
                if(strchr($fileName[$i], "ios_3x_thumbnail."))
                {
                    $sfilename_3x_thumb = $fileName[$i];
                }
                else
                {
                    if(strchr($fileName[$i], "ios_3x."))
                    {
                        $sfilename_3x = $fileName[$i];
                    }
                    else
                    {
                        if(strchr($fileName[$i], "ios_2x."))
                        {
                            $sfilename_2x = $fileName[$i];
                        }
                    }
                }
            }
        }*/
        $sfilename_2x = $fileName; // for cloudinary images implementation
        try
        {
            $sQuery = "UPDATE tbltopics SET fldiconurl= :filename  WHERE fldid = :topicid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":filename", $sfilename_2x);
            $ConnBean->bind_param(":topicid", $topic_id);
            $ConnBean->execute();
            $bStatus = true;
        }
        catch(Exception $e)
        {
        }

        return $bStatus;
    }
    
    public function getTotalTopicsCount($ConnBean,$clientId) {
        
        $aResult['total_audvisor_topics'] = 0;
        $aResult['total_client_topics'] = 0;
        $aResult['total_topics'] = 0;
        
        $sQuery_audvisor_topics = "SELECT t.fldid, t.fldname,t.fldiconurl,t.fldcreateddate,t.fldmodifieddate, count(i.fldtopicid) AS count FROM tbltopics AS t LEFT JOIN tbltopicinsight AS i ON t.fldid=i.fldtopicid WHERE t.fldisdeleted = 0 AND t.client_id = :client_id GROUP BY t.fldname ORDER BY count DESC";
        $ConnBean->getPreparedStatement($sQuery_audvisor_topics);
        $ConnBean->bind_param(":client_id", 'audvisor11012017');
        $result_audvisor_topics   = $ConnBean->resultset();
        $total_audvisor_topics    = $ConnBean->rowCount();
        
        $sQuery_client_topics = "SELECT t.fldid, t.fldname,t.fldiconurl,t.fldcreateddate,t.fldmodifieddate, count(i.fldtopicid) AS count FROM tbltopics AS t LEFT JOIN tbltopicinsight AS i ON t.fldid=i.fldtopicid WHERE t.fldisdeleted = 0 AND t.client_id = :client_id GROUP BY t.fldname ORDER BY count DESC";
        $ConnBean->getPreparedStatement($sQuery_client_topics);
        $ConnBean->bind_param(":client_id", $clientId);
        $result_client_topics   = $ConnBean->resultset();
        $total_client_topics    = $ConnBean->rowCount();
        
        $aResult['total_audvisor_topics'] = $total_audvisor_topics;
        $aResult['total_client_topics'] = $total_client_topics;
        $aResult['total_topics'] = $total_audvisor_topics + $total_client_topics;
        
        return $aResult;
    }
}

?>
