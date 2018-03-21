<?php

/*
  Project                     : Oriole
  Module                      : Expert
  File name                   : COREExpertDB.php
  Description                 : Database class for Expert related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREExpertDB
{

    public function __construct()
    {
    }

    /**
     * Function used to get all experts details For cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function all_experts($ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT e.fldid,e.fldprefix, e.fldfirstname,e.fldmiddlename,e.fldlastname,e.fldvoiceoverurl,e.fldpromotitle,e.fldrating,e.fldavatarurl,e.fldbioimage,e.fldthumbimage,e.fldpromoimage,e.fldlistviewimage,e.fldtitle,e.flddescription,e.fldcreateddate,e.fldmodifieddate ,e.fldtwitterhandle,e.fldfbshareimage, count(i.fldexpertid) AS count FROM tblexperts AS e LEFT JOIN (SELECT * FROM tblinsights WHERE fldisdeleted=0) AS i ON e.fldid=i.fldexpertid WHERE e.fldisdeleted = 0 AND e.client_id = :client_id GROUP BY e.fldid ORDER BY count DESC";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $result   = $ConnBean->resultset();
            $s3bridge = new COREAwsBridge();
            foreach($result as $expert_details)
            {
                $sExpertVoiceover = $expert_details[DB_COLUMN_FLD_VOICEOVER_URL];
                if($sExpertVoiceover != null)
                {
                    $sExpertVoiceover = $s3bridge->GetExpertVoiceOverURL($sExpertVoiceover,$clientId);
                }

                $flddescription = $expert_details[DB_COLUMN_FLD_DESCRIPTION];
                $flddescription = htmlspecialchars($flddescription, ENT_QUOTES, 'UTF-8');
                $flddescription = str_replace("\n", '<br />', $flddescription);
                $fldtitle       = htmlspecialchars($expert_details[DB_COLUMN_FLD_TITLE], ENT_QUOTES, 'UTF-8');
                $name           = trim($expert_details[DB_COLUMN_FLD_FIRST_NAME])." ".trim($expert_details[DB_COLUMN_FLD_MIDDLE_NAME])." ".trim($expert_details[DB_COLUMN_FLD_LAST_NAME]);
                if($expert_details[DB_COLUMN_FLD_PREFIX] != null && $expert_details[DB_COLUMN_FLD_PREFIX] != "")
                {
                    $name = trim($expert_details[DB_COLUMN_FLD_PREFIX])." ".trim($name);
                }
                $images   = NULL;
                $images[] = $expert_details[DB_COLUMN_FLD_AVATAR_URL];
                $images[] = $expert_details[DB_COLUMN_FLD_PROMO_IMAGE];
                $images[] = $expert_details[DB_COLUMN_FLD_THUMB_IMAGE];
                $images[] = $expert_details[DB_COLUMN_FLD_BIO_IMAGE];
                $images[] = $expert_details[DB_COLUMN_FLD_LISTVIEW_IMAGE];
                $images[] = $expert_details[DB_COLUMN_FLD_FBSHARE_IMAGE];

                $sAvatarUrls                 = $s3bridge->GetS3ExpertAvatarURLs($images,$clientId);
                $expertAvatar                = isset($expert_details[DB_COLUMN_FLD_AVATAR_URL]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_AVATAR_URL]] : null;
                $iResult[JSON_TAG_RECORDS][] = array(
                    JSON_TAG_EXPERT_ID => $expert_details[DB_COLUMN_FLD_ID], 
                    JSON_TAG_PREFIX => $expert_details[DB_COLUMN_FLD_PREFIX], 
                    JSON_TAG_FIRST_NAME => trim($expert_details[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($expert_details[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($expert_details[DB_COLUMN_FLD_LAST_NAME]), 
                    JSON_TAG_EXPERT_IMAGE => $expertAvatar, 
                    JSON_TAG_EXPERT_TITLE => trim($fldtitle), 
                    JSON_TAG_DESC => $flddescription, 
                    JSON_TAG_CREATED_DATE => $expert_details[DB_COLUMN_FLD_CREATED_DATE], 
                    JSON_TAG_MODIFIED_DATE => $expert_details[DB_COLUMN_FLD_MODIFIED_DATE], 
                    JSON_TAG_COUNT => $expert_details[JSON_TAG_COUNT], 
                    JSON_TAG_EXPERT_NAME => $name, 
                    JSON_TAG_AVATAR_LINK => isset($expert_details[DB_COLUMN_FLD_AVATAR_URL]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_AVATAR_URL]] : NULL, 
                    JSON_TAG_PROMO_IMAGE => isset($expert_details[DB_COLUMN_FLD_PROMO_IMAGE]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_PROMO_IMAGE]] : NULL, 
                    JSON_TAG_THUMBNAIL_IMAGE => isset($expert_details[DB_COLUMN_FLD_THUMB_IMAGE]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_THUMB_IMAGE]] : NULL, 
                    JSON_TAG_BIO_IMAGE => isset($expert_details[DB_COLUMN_FLD_BIO_IMAGE]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_BIO_IMAGE]] : NULL, 
                    JSON_TAG_FBSHARE_IMAGE => isset($expert_details[DB_COLUMN_FLD_FBSHARE_IMAGE]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_FBSHARE_IMAGE]] : null, 
                    JSON_TAG_LISTVIEW_IMAGE => isset($expert_details[DB_COLUMN_FLD_LISTVIEW_IMAGE]) ? $sAvatarUrls[$expert_details[DB_COLUMN_FLD_LISTVIEW_IMAGE]] : NULL, 
                    JSON_TAG_PROMO_TITLE => $expert_details[DB_COLUMN_FLD_PROMO_TITLE], 
                    JSON_TAG_RATING => $expert_details[DB_COLUMN_FLD_RATING], 
                    JSON_TAG_EXPERT_VOICE_OVER_URL => $sExpertVoiceover, 
                    JSON_TAG_TWITTER_HANDLE => isset($expert_details[DB_COLUMN_FLD_TWITTER_HANDLE]) ? htmlspecialchars($expert_details[DB_COLUMN_FLD_TWITTER_HANDLE], ENT_QUOTES, 'UTF-8') : ""
                    );
                $iResult[JSON_TAG_STATUS]    = 0;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_RECORDS] = NULL;
            $iResult[JSON_TAG_STATUS]  = 3;
        }
        return $iResult;
    }

    /**
     * Function used to get all experts details.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function list_all_experts($ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT e.fldid,e.fldprefix, e.fldfirstname, e.fldmiddlename, e.fldlastname, e.flddescription, e.fldpromotitle, e.fldavatarurl, e.fldavatarurl, e.fldbioimage, e.fldthumbimage, e.fldpromoimage,e.fldlistviewimage, e.fldtitle, e.fldcreateddate, e.fldmodifieddate,e.fldtwitterhandle,e.client_id  FROM tblexperts AS e LEFT JOIN (SELECT * FROM tblinsights WHERE fldisdeleted = 0 AND fldisonline = 1 AND (client_id = '".$clientId."' OR client_id='audvisor11012017')) AS i ON e.fldid=i.fldexpertid WHERE e.fldisdeleted = 0 AND i.fldisonline = 1 AND (e.client_id = :client_id OR e.client_id='audvisor11012017') GROUP BY e.fldid ORDER BY e.fldfirstname,e.fldlastname ASC";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $experts  = $ConnBean->resultset();
            $s3bridge = new COREAwsBridge(); 
            foreach($experts as $expert)
            {
                $images   = NULL;
                $images[] = $expert[DB_COLUMN_FLD_AVATAR_URL];
                $images[] = $expert[DB_COLUMN_FLD_BIO_IMAGE];
                $images[] = $expert[DB_COLUMN_FLD_PROMO_IMAGE];
                $images[] = $expert[DB_COLUMN_FLD_THUMB_IMAGE];
                $images[] = $expert[DB_COLUMN_FLD_LISTVIEW_IMAGE];
                $images   = array_values(array_filter($images));
                $name     = trim($expert[DB_COLUMN_FLD_FIRST_NAME])." ".trim($expert[DB_COLUMN_FLD_MIDDLE_NAME])." ".trim($expert[DB_COLUMN_FLD_LAST_NAME]);
                $tmp_client_id     = $expert['client_id'];
                if(!empty($expert[DB_COLUMN_FLD_PREFIX]))
                {
                    $name = trim($expert[DB_COLUMN_FLD_PREFIX])." ".trim($name);
                }
                $expertAvatar                = $s3bridge->GetS3ExpertAvatarURL($expert[DB_COLUMN_FLD_AVATAR_URL],$tmp_client_id)?$s3bridge->GetS3ExpertAvatarURL($expert[DB_COLUMN_FLD_AVATAR_URL],$tmp_client_id):null;
                $sAvatarUrls                 = $s3bridge->GetS3ExpertAvatarURLs($images,$tmp_client_id);
                $expertAvatar                = isset($sAvatarUrls[$expert[DB_COLUMN_FLD_AVATAR_URL]]) ? $sAvatarUrls[$expert[DB_COLUMN_FLD_AVATAR_URL]] : null;
                $iResult[JSON_TAG_RECORDS][] = array(
                    JSON_TAG_ID => intval($expert[DB_COLUMN_FLD_ID]), 
                    JSON_TAG_TITLE => trim($name), 
                    JSON_TAG_FIRST_NAME => trim($expert[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($expert[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($expert[DB_COLUMN_FLD_LAST_NAME]),
                    JSON_TAG_SUBTITLE => trim($expert[DB_COLUMN_FLD_TITLE]), 
                    JSON_TAG_CREATED_DATE => $expert[DB_COLUMN_FLD_CREATED_DATE], 
                    JSON_TAG_MODIFIED_DATE => $expert[DB_COLUMN_FLD_MODIFIED_DATE], 
                    JSON_TAG_AVATAR_LINK => $expertAvatar, 
                    JSON_TAG_EXPERT_BIO_IMAGE => isset($sAvatarUrls[$expert[DB_COLUMN_FLD_BIO_IMAGE]]) ? $sAvatarUrls[$expert[DB_COLUMN_FLD_BIO_IMAGE]] : NULL, 
                    JSON_TAG_EXPERT_PROMO_IMAGE => isset($sAvatarUrls[$expert[DB_COLUMN_FLD_PROMO_IMAGE]]) ? $sAvatarUrls[$expert[DB_COLUMN_FLD_PROMO_IMAGE]] : null, 
                    JSON_TAG_EXPERT_THUMBNAIL_IMAGE => isset($sAvatarUrls[$expert[DB_COLUMN_FLD_THUMB_IMAGE]]) ? $sAvatarUrls[$expert[DB_COLUMN_FLD_THUMB_IMAGE]] : null, 
                    JSON_TAG_LISTVIEW_IMAGE => isset($sAvatarUrls[$expert[DB_COLUMN_FLD_LISTVIEW_IMAGE]]) ? $sAvatarUrls[$expert[DB_COLUMN_FLD_LISTVIEW_IMAGE]] : NULL, 
                    JSON_TAG_EXPERT_BIO => $expert[DB_COLUMN_FLD_DESCRIPTION], 
                    JSON_TAG_TWITTER_HANDLE => isset($expert[DB_COLUMN_FLD_TWITTER_HANDLE]) ? $expert[DB_COLUMN_FLD_TWITTER_HANDLE] : "",
                    'client_id' => $tmp_client_id
                    );
                $iResult[JSON_TAG_STATUS]    = ERRCODE_NO_ERROR;
            }
        }
        catch(Exception $e)
        {          
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        if(count($iResult) == 0)
        {
            $iResult[JSON_TAG_RECORDS] = NULL;
            $iResult[JSON_TAG_STATUS]  = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $iResult;
    }

    /**
     * Function to list individual expert details.
     *
     * @param $expertid
     * @param $ConnBean
     *
     * @return array
     */
    public function get_expertdetails($expertid, $ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT fldid,fldprefix,fldvoiceoverurl, fldfirstname,fldmiddlename,fldlastname,fldpromotitle, flddescription,fldavatarurl,fldavatarurl,fldbioimage,fldthumbimage,fldpromoimage,fldlistviewimage,fldfbshareimage,fldtitle,fldcreateddate,fldmodifieddate,fldtwitterhandle,client_id  FROM tblexperts WHERE fldisdeleted = 0 AND fldid = :expertid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":expertid", $expertid);
            $aResult         = $ConnBean->single();
            $s3bridge        = new COREAwsBridge();
            $fldexpert_image = $aResult[DB_COLUMN_FLD_AVATAR_URL];
            $sVoieover       = $aResult[DB_COLUMN_FLD_VOICEOVER_URL];
            $images[]        = $aResult[DB_COLUMN_FLD_AVATAR_URL];
            $images[]        = $aResult[DB_COLUMN_FLD_BIO_IMAGE];
            $images[]        = $aResult[DB_COLUMN_FLD_THUMB_IMAGE];
            $images[]        = $aResult[DB_COLUMN_FLD_PROMO_IMAGE];
            $images[]        = $aResult[DB_COLUMN_FLD_LISTVIEW_IMAGE];
            $images[]        = $aResult[DB_COLUMN_FLD_FBSHARE_IMAGE];
            $images          = array_values(array_filter($images));
            $expertname      = trim($aResult[DB_COLUMN_FLD_FIRST_NAME]).' '.trim($aResult[DB_COLUMN_FLD_MIDDLE_NAME]).' '.trim($aResult[DB_COLUMN_FLD_LAST_NAME]);
            $clientId = $aResult['client_id'];
            
            if(!empty($aResult[DB_COLUMN_FLD_PREFIX]))
            {
                $expertname = trim($aResult[DB_COLUMN_FLD_PREFIX])." ".trim($expertname);
            }
            $expertAvatar = empty($aResult[DB_COLUMN_FLD_AVATAR_URL]) ? null : $s3bridge->GetS3ExpertAvatarURL($aResult[DB_COLUMN_FLD_AVATAR_URL],$clientId);

            if($sVoieover == null || $sVoieover == "")
            {
                $sExpert_VoiceOver = null;
            }
            else
            {
                $sExpert_VoiceOver = $s3bridge->GetExpertVoiceOverURL($sVoieover,$clientId);
            }

            $sAvatarUrls = $s3bridge->GetS3ExpertAvatarURLs($images,$clientId);

            if(($fldexpert_image == "" || $fldexpert_image == null))
            {
                $expertAvatar = !empty($sAvatarUrls[$aResult[DB_COLUMN_FLD_AVATAR_URL]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_AVATAR_URL]] : null;
            }
            $link                     = API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$expertid;
            $iResult[JSON_TAG_RECORD] = array(
                JSON_TAG_TYPE => JSON_TAG_EXPERT, 
                JSON_TAG_EXPERT_VOICE_OVER_URL => $sExpert_VoiceOver, 
                JSON_TAG_CREATED_DATE => $aResult[DB_COLUMN_FLD_CREATED_DATE], 
                JSON_TAG_MODIFIED_DATE => $aResult[DB_COLUMN_FLD_MODIFIED_DATE], 
                JSON_TAG_ID => $expertid, 
                JSON_TAG_LINK => $link, 
                JSON_TAG_TITLE => trim($expertname), 
                JSON_TAG_FIRST_NAME => trim($aResult[DB_COLUMN_FLD_FIRST_NAME]), 
                JSON_TAG_MIDDLE_NAME => trim($aResult[DB_COLUMN_FLD_MIDDLE_NAME]), 
                JSON_TAG_LAST_NAME => trim($aResult[DB_COLUMN_FLD_LAST_NAME]),
                JSON_TAG_AVATAR_LINK => $expertAvatar, 
                JSON_TAG_SUBTITLE => trim($aResult[DB_COLUMN_FLD_TITLE]), 
                JSON_TAG_EXPERT_BIO_IMAGE => isset($sAvatarUrls[$aResult[DB_COLUMN_FLD_BIO_IMAGE]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_BIO_IMAGE]] : NULL, 
                JSON_TAG_EXPERT_THUMBNAIL_IMAGE => isset($sAvatarUrls[$aResult[DB_COLUMN_FLD_THUMB_IMAGE]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_THUMB_IMAGE]] : null, 
                JSON_TAG_EXPERT_PROMO_IMAGE => isset($sAvatarUrls[$aResult[DB_COLUMN_FLD_PROMO_IMAGE]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_PROMO_IMAGE]] : null, 
                JSON_TAG_LISTVIEW_IMAGE => isset($sAvatarUrls[$aResult[DB_COLUMN_FLD_LISTVIEW_IMAGE]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_LISTVIEW_IMAGE]] : null, 
                JSON_TAG_FBSHARE_IMAGE => isset($sAvatarUrls[$aResult[DB_COLUMN_FLD_FBSHARE_IMAGE]]) ? $sAvatarUrls[$aResult[DB_COLUMN_FLD_FBSHARE_IMAGE]] : null, 
                JSON_TAG_EXPERT_BIO => $aResult[DB_COLUMN_FLD_DESCRIPTION], 
                JSON_TAG_TWITTER_HANDLE => isset($aResult[DB_COLUMN_FLD_TWITTER_HANDLE]) ? $aResult[DB_COLUMN_FLD_TWITTER_HANDLE] : "");
            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $iResult[JSON_TAG_STATUS] = 2;
        }

        if($aResult[DB_COLUMN_FLD_ID] == null)
        {
            $iResult[JSON_TAG_STATUS] = SERVER_ERRORCODE_INVALID_EXPERT;
        }

        return $iResult;
    }

    /**
     * Function used to create new Expert.
     *
     * @param $ConnBean
     * @param $expert_name
     * @param $expert_title
     * @param $expert_middlename
     * @param $expert_lastname
     * @param $expert_description
     * @param $sPromotitle
     * @param $iExpert_rating
     * @param $sExpert_prefix
     *
     * @return array
     */
    public function insertExpert($ConnBean, $expert_name, $expert_title, $expert_middlename, $expert_lastname, $expert_description, $sPromotitle, $iExpert_rating, $sExpert_prefix, $sTwitter_handle,$clientId)
    {
        $bResult = array();

        try
        {
            define('UPLOAD_DIR', 'images/');
            $expname = $sExpert_prefix." ".$expert_name." ".$expert_middlename." ".$expert_lastname;
            if(substr($sTwitter_handle, 0, 1) !== '@' && trim($sTwitter_handle) !== '')
            {
                $sTwitter_handle = '@'.$sTwitter_handle;
            }
            $tQuery = "SELECT count(*) topiccount,fldisdeleted,fldid FROM tblexperts WHERE fldfirstname LIKE :firstname AND  fldmiddlename LIKE :middlename AND  fldlastname LIKE :lastname and client_id = :client_id";
            $ConnBean->getPreparedStatement($tQuery);
            $ConnBean->bind_param(":firstname", $expert_name);
            $ConnBean->bind_param(":middlename", $expert_middlename);
            $ConnBean->bind_param(":lastname", $expert_lastname);
            $ConnBean->bind_param(":client_id", $clientId);
            $result = $ConnBean->single();
            if($ConnBean->rowCount() && $result[JSON_TAG_TOPIC_COUNT] > 0 && $result[DB_COLUMN_FLD_ISDELETED] == 0)
            {
                $bResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                if($ConnBean->rowCount() && $result[JSON_TAG_TOPIC_COUNT] > 0 && $result[DB_COLUMN_FLD_ISDELETED] == 1)
                {
                    $bResult[JSON_TAG_STATUS] = 4;
                    $bResult[JSON_TAG_ID]     = $result[DB_COLUMN_FLD_ID];
                }
                else
                {
                    $redis  = CORERedisConnection::getRedisInstance();
                    $sQuery = "INSERT INTO tblexperts (fldprefix,fldfirstname,fldmiddlename, fldlastname,fldtitle,flddescription,fldpromotitle,fldrating,fldtwitterhandle,fldcreateddate,client_id) VALUES (:prefix,:firstname,:middlename,:lastname,:title,:description,:promotitle,:rating,:twitterhandle,NOW(),:client_id)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":firstname", $expert_name);
                    $ConnBean->bind_param(":middlename", $expert_middlename);
                    $ConnBean->bind_param(":lastname", $expert_lastname);
                    $ConnBean->bind_param(":title", $expert_title);
                    $ConnBean->bind_param(":description", $expert_description);
                    $ConnBean->bind_param(":promotitle", $sPromotitle);
                    $ConnBean->bind_param(":rating", $iExpert_rating);
                    $ConnBean->bind_param(":twitterhandle", $sTwitter_handle);
                    $ConnBean->bind_param(":prefix", $sExpert_prefix);
                    $ConnBean->bind_param(":client_id", $clientId);

                    $ConnBean->execute();
                    $expertid = $ConnBean->lastInsertId();
                    if($redis && $expertid)
                    {
                        $cacheKey = "all_experts";
                        $redis->del($cacheKey);
                    }

                    $expname                   = $expert_name." ".$expert_middlename." ".$expert_lastname;
                    $bResult[JSON_TAG_RECORDS] = array(
                        JSON_TAG_EXPERT_ID => $expertid, 
                        JSON_TAG_EXPERT_NAME => $expname,
                        JSON_TAG_FIRST_NAME => $expert_name, 
                        JSON_TAG_MIDDLE_NAME => $expert_middlename, 
                        JSON_TAG_LAST_NAME => $expert_lastname
                    );
                    $bResult[JSON_TAG_STATUS]  = 0;
                }
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $bResult[JSON_TAG_STATUS] = 2;
        }

        return $bResult;
    }

    /**
     * Function used to delete Experts data from database.
     *
     * @param $expertid
     * @param $ConnBean
     *
     * @return array
     */
    public function deleteExpert($expertid, $ConnBean)
    {

        $iResult = array();
        try
        {

            $sQuery1 = "SELECT COUNT(*) AS  expertcount FROM tblinsights WHERE fldexpertid = :expertid AND fldisdeleted = 0 ";
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":expertid", $expertid);
            $aResult     = $ConnBean->single();
            $expertcount = $aResult[JSON_TAG_EXPERT_COUNT];
            if($expertcount > 0)
            {
                $iResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                $redis  = CORERedisConnection::getRedisInstance();
                $sQuery = "UPDATE tblexperts SET fldisdeleted = 1 WHERE fldid = :expertid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":expertid", $expertid);
                $deleteExpert = $ConnBean->execute();
                if($redis && $deleteExpert)
                {
                    $cacheKey = "all_experts";
                    $redis->del($cacheKey);
                }
                $iResult[JSON_TAG_STATUS] = 0;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $inConnBean
     * @param $expertName
     * @param $expertmiddlename
     * @param $expertlastname
     * @param $expertId
     * @param $expert_title
     * @param $expert_description
     * @param $sPromotitle
     * @param $expert_rating
     * @param $expert_prefix
     *
     * @return mixed
     */
    public function edit_expert($inConnBean, $expertName, $expertmiddlename, $expertlastname, $expertId, $expert_title, $expert_description, $sPromotitle, $expert_rating, $expert_prefix, $sTwitter_handle)
    {
        try
        {
            $tQuery = "SELECT count(*) AS topiccount,fldid AS fldid,fldisdeleted FROM tblexperts WHERE fldfirstname LIKE :firstname AND  fldmiddlename LIKE :middlename AND  fldlastname LIKE :lastname AND fldisdeleted=0 ";
            $inConnBean->getPreparedStatement($tQuery);
            $inConnBean->bind_param(":firstname", $expertName);
            $inConnBean->bind_param(":middlename", $expertmiddlename);
            $inConnBean->bind_param(":lastname", $expertlastname);
            $aResult      = $inConnBean->single();
            $topiccount   = $aResult[JSON_TAG_TOPIC_COUNT];
            $fldid        = $aResult[DB_COLUMN_FLD_ID];
            $fldisdeleted = $aResult[DB_COLUMN_FLD_ISDELETED];
            if(($inConnBean->rowCount() && $topiccount > 0) && $fldid != $expertId && $fldisdeleted == 0)
            {
                $iResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                if(substr($sTwitter_handle, 0, 1) !== '@' && trim($sTwitter_handle) !== '')
                {
                    $sTwitter_handle = '@'.$sTwitter_handle;
                }
                $redis  = CORERedisConnection::getRedisInstance();
                $sQuery = "UPDATE tblexperts SET fldprefix = :prefix, fldfirstname = :firstname, fldmiddlename = :middlename,fldlastname = :lastname,fldtitle= :title , flddescription= :description ,fldpromotitle= :promotitle ,fldrating = :rating ,fldtwitterhandle = :twitterhandle  WHERE fldid = :expertid";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":firstname", $expertName);
                $inConnBean->bind_param(":middlename", $expertmiddlename);
                $inConnBean->bind_param(":lastname", $expertlastname);
                $inConnBean->bind_param(":title", $expert_title);
                $inConnBean->bind_param(":description", $expert_description);
                $inConnBean->bind_param(":promotitle", $sPromotitle);
                $inConnBean->bind_param(":rating", $expert_rating);
                $inConnBean->bind_param(":expertid", $expertId);
                $inConnBean->bind_param(":twitterhandle", $sTwitter_handle);
                $inConnBean->bind_param(":prefix", $expert_prefix);
                $updatedExpertInfo = $inConnBean->execute();

                if($redis && $updatedExpertInfo)
                {
                    $cacheKey = "all_experts";
                    $redis->del($cacheKey);
                }

                $iResult[JSON_TAG_STATUS] = 0;
                if($inConnBean->rowCount() == 1)
                {
                    $iResult[JSON_TAG_STATUS] = 0;
                }
                else
                {
                    $iResult[JSON_TAG_STATUS] = 2;
                }
                $sQuery = "SELECT fldid, fldfirstname,fldmiddlename,fldlastname,fldavatarurl,fldtitle,fldcreateddate,fldmodifieddate FROM tblexperts WHERE fldisdeleted = 0 AND fldid= ?";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(1, $expertId);
                $aResult                  = $inConnBean->single();
                $s3bridge                 = new COREAwsBridge();
                $fldexpert_name           = trim($aResult[DB_COLUMN_FLD_FIRST_NAME]);
                $fldexpertmiddlename      = trim($aResult[DB_COLUMN_FLD_MIDDLE_NAME]);
                $fldexpertlastname        = trim($aResult[DB_COLUMN_FLD_LAST_NAME]);
                $expertname               = trim($fldexpert_name).' '.trim($fldexpertmiddlename).' '.trim($fldexpertlastname);
                $expertAvatar             = $s3bridge->GetS3ExpertAvatarURL($aResult[DB_COLUMN_FLD_AVATAR_URL]);
                $link                     = API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$expertId;
                $iResult[JSON_TAG_RECORD] = array(
                        JSON_TAG_TYPE => JSON_TAG_EXPERT, 
                        JSON_TAG_CREATED_DATE => $aResult[DB_COLUMN_FLD_CREATED_DATE], 
                        JSON_TAG_MODIFIED_DATE => $aResult[DB_COLUMN_FLD_MODIFIED_DATE], 
                        JSON_TAG_ID => $expertId, 
                        JSON_TAG_LINK => $link, 
                        JSON_TAG_NAME => $expertname, 
                        JSON_TAG_FIRST_NAME => $fldexpert_name, 
                        JSON_TAG_MIDDLE_NAME => $fldexpertmiddlename, 
                        JSON_TAG_LAST_NAME => $fldexpertlastname, 
                        JSON_TAG_AVATAR_LINK => $expertAvatar, 
                        JSON_TAG_TITLE => trim($aResult[DB_COLUMN_FLD_TITLE])
                    );
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $iResult[JSON_TAG_STATUS] = 3;
        }

        return $iResult;
    }

    /**
     * Function used to  update  Expert image URL in the  database.
     *
     * @param $ConnBean
     * @param $expert_id
     * @param $fileName
     * @param $sExpertAvatar
     *
     * @return bool
     */
    public function patch_avatar_url($ConnBean, $expert_id, $fileName, $sExpertAvatar)
    {
        $bStatus = false;
        try
        {
            $sQuery = "UPDATE tblexperts SET fldavatarurl= :avatarurl  WHERE fldid = :expertid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":avatarurl", $fileName);
            $ConnBean->bind_param(":s3url", $sExpertAvatar);
            $ConnBean->bind_param(":expertid", $expert_id);
            $ConnBean->execute();
            $bStatus = true;
        }
        catch(Exception $e)
        {
        }

        return $bStatus;
    }

    /**
     * Function used to  update  Expert image URLs in the  database.
     *
     * @param $ConnBean
     * @param $expert_id
     * @param $fileName
     * @param $expertAvatar
     * @param $sQuery
     *
     * @return bool
     */
    public function patch_avatar_urls($ConnBean, $expert_id, $fileName, $expertAvatar, $sQuery)
    {
        $flag = 0;
        array_shift($fileName);
        $bStatus = false;
        try
        {
            $sQuery = "UPDATE tblexperts SET".$sQuery." WHERE fldid = ?";
            $ConnBean->getPreparedStatement($sQuery);
            for($i = 0; $i < count($fileName); $i++)
            {
                $ConnBean->bind_param(($i + 1), $fileName[$i]);
            }
            if($flag)
            {
                $ConnBean->bind_param(++$i, $expertAvatar);
            }
            $ConnBean->bind_param($i + 1, $expert_id);
            $ConnBean->execute();
            $bStatus = true;
        }
        catch(Exception $e)
        {
        }

        return $bStatus;
    }

    /**
     * Function used to  update  Expert Voice-over URLs in the  database.
     *
     * @param $ConnBean
     * @param $expert_id
     * @param $fileName
     *
     * @return int
     */
    public function patch_expert_voiceover_url($ConnBean, $expert_id, $fileName)
    {
        $sQuery = "UPDATE tblexperts SET fldvoiceoverurl = :voiceoverurl  WHERE fldid = :expertid";
        try
        {
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":voiceoverurl", $fileName);
            $ConnBean->bind_param(":expertid", $expert_id);
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
     * Function to list individual deleted expert details.
     *
     * @param $expertid
     * @param $ConnBean
     *
     * @return array
     */
    public function get_deleted_expertdetails($expertid, $ConnBean)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT fldid, fldfirstname,fldmiddlename,fldlastname,fldpromotitle, flddescription,fldavatarurl,fldavatarurl,fldbioimage,fldthumbimage,fldpromoimage,fldtitle,fldcreateddate,fldmodifieddate  FROM tblexperts WHERE  fldid = :expertid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":expertid", $expertid);
            $aResult         = $ConnBean->single();
            $fldpromotitle   = $aResult[DB_COLUMN_FLD_PROMO_TITLE];
            $flddescription  = $aResult[DB_COLUMN_FLD_DESCRIPTION];
            $fldexpert_image = $aResult[DB_COLUMN_FLD_AVATAR_URL];
            $images[0]       = $aResult[DB_COLUMN_FLD_AVATAR_URL];
            $images[1]       = $aResult[DB_COLUMN_FLD_BIO_IMAGE];
            $images[2]       = $aResult[DB_COLUMN_FLD_THUMB_IMAGE];
            $images[3]       = $aResult[DB_COLUMN_FLD_PROMO_IMAGE];
            $fldtitle        = $aResult[DB_COLUMN_FLD_TITLE];
            $s3bridge        = new COREAwsBridge();

            $expertname   = trim($aResult[DB_COLUMN_FLD_FIRST_NAME]).' '.trim($aResult[DB_COLUMN_FLD_MIDDLE_NAME]).' '.trim($aResult[DB_COLUMN_FLD_LAST_NAME]);
            $expertAvatar = $s3bridge->GetS3ExpertAvatarURL($fldexpert_image);
            $sAvatarUrls  = $s3bridge->GetS3ExpertAvatarURLs($images);
            if($fldexpert_image == "" || $fldexpert_image == null)
            {
                $expertAvatar = $sAvatarUrls[$aResult[DB_COLUMN_FLD_AVATAR_URL]];
            }
            $link                     = API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$expertid;
            $iResult[JSON_TAG_RECORD] = array(
                    JSON_TAG_TYPE => JSON_TAG_EXPERT, 
                    JSON_TAG_FIRST_NAME => $aResult[DB_COLUMN_FLD_FIRST_NAME], 
                    JSON_TAG_LAST_NAME => $aResult[DB_COLUMN_FLD_LAST_NAME], 
                    JSON_TAG_CREATED_DATE => $aResult[DB_COLUMN_FLD_CREATED_DATE], 
                    JSON_TAG_MODIFIED_DATE => $aResult[DB_COLUMN_FLD_MODIFIED_DATE], 
                    JSON_TAG_ID => $expertid, 
                    JSON_TAG_LINK => $link, 
                    JSON_TAG_NAME => trim($expertname), 
                    JSON_TAG_FIRST_NAME => trim($aResult[DB_COLUMN_FLD_FIRST_NAME]), 
                    JSON_TAG_MIDDLE_NAME => trim($aResult[DB_COLUMN_FLD_MIDDLE_NAME]), 
                    JSON_TAG_LAST_NAME => trim($aResult[DB_COLUMN_FLD_LAST_NAME]),
                    JSON_TAG_AVATAR_LINK => $expertAvatar, 
                    JSON_TAG_TITLE => trim($fldtitle), 
                    JSON_TAG_AVATAR_LINK_2X => $fldexpert_image, 
                    JSON_TAG_EXPERT_BIO_IMAGE => $sAvatarUrls[$aResult[DB_COLUMN_FLD_BIO_IMAGE]], 
                    JSON_TAG_EXPERT_THUMBNAIL_IMAGE => $sAvatarUrls[$aResult[DB_COLUMN_FLD_THUMB_IMAGE]], 
                    JSON_TAG_EXPERT_PROMO_IMAGE => $sAvatarUrls[$aResult[DB_COLUMN_FLD_PROMO_IMAGE]], 
                    JSON_TAG_EXPERT_BIO => $flddescription, 
                    JSON_TAG_EXPERT_PROMO_TITLE => trim($fldpromotitle)
                );
            $iResult[JSON_TAG_STATUS] = 0;
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
     * Function used to create new Expert.
     *
     * @param $ConnBean
     * @param $expert_name
     * @param $expert_title
     * @param $expert_middlename
     * @param $expert_lastname
     * @param $expert_description
     * @param $sPromotitle
     *
     * @return array
     */
    public function reg_new_expert($ConnBean, $expert_name, $expert_title, $expert_middlename, $expert_lastname, $expert_description, $sPromotitle)
    {
        $bResult = array();

        try
        {
            $expname = $expert_name." ".$expert_middlename." ".$expert_lastname;
            $sQuery  = "INSERT INTO tblexperts (fldfirstname,fldmiddlename,fldlastname,fldtitle,flddescription,fldpromotitle,fldcreateddate) VALUES (:firstname,:middlename,:lastname,:title,:description,:promotitle,NOW())";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":firstname", $expert_name);
            $ConnBean->bind_param(":middlename", $expert_middlename);
            $ConnBean->bind_param(":lastname", $expert_lastname);
            $ConnBean->bind_param(":title", $expert_title);
            $ConnBean->bind_param(":description", $expert_description);
            $ConnBean->bind_param(":promotitle", $sPromotitle);
            $ConnBean->execute();
            $expertid                  = $ConnBean->lastInsertId();
            $bResult[JSON_TAG_RECORDS] = array(
                    JSON_TAG_EXPERT_ID => $expertid, 
                    JSON_TAG_EXPERT_NAME => $expname,
                    JSON_TAG_FIRST_NAME => $expert_name, 
                    JSON_TAG_MIDDLE_NAME => $expert_middlename, 
                    JSON_TAG_LAST_NAME => $expert_lastname
                );
            $bResult[JSON_TAG_STATUS]  = 0;
        }
        catch(Exception $e)
        {
            $bResult[JSON_TAG_STATUS] = 2;
        }

        return $bResult;
    }

    /**
     * Function used to Re-enable the deleted expert.
     *
     * @param $ConnBean
     * @param $iExpertid
     *
     * @return mixed
     */
    public function re_enable_expert($ConnBean, $iExpertid)
    {
        try
        {
            $sQuery = "UPDATE tblexperts SET fldisdeleted=0 WHERE fldid= :expertid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":expertid", $iExpertid);
            $ConnBean->execute();
            $bResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {

            $bResult[JSON_TAG_STATUS] = 2;
        }

        return $bResult;
    }

    /**
     * Function used to Get expert images file names.
     *
     * @param $expert_id
     *
     * @return array
     */
    public function get_Expert_images($expert_id)
    {
        $ConnBean  = new COREDbManager();
        $aImages[] = null;
        try
        {
            $i      = 0;
            $sQuery = "SELECT fldavatarurl,fldbioimage,fldthumbimage,fldpromoimage,fldlistviewimage,fldfbshareimage FROM tblexperts WHERE fldid = :expertid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":expertid", $expert_id);
            $result        = $ConnBean->single();
            $aImages[$i++] = $result[DB_COLUMN_FLD_AVATAR_URL];
            $aImages[$i++] = $result[DB_COLUMN_FLD_BIO_IMAGE];
            $aImages[$i++] = $result[DB_COLUMN_FLD_THUMB_IMAGE];
            $aImages[$i++] = $result[DB_COLUMN_FLD_PROMO_IMAGE];
            $aImages[$i++] = $result[DB_COLUMN_FLD_LISTVIEW_IMAGE];
            $aImages[$i++] = $result[DB_COLUMN_FLD_FBSHARE_IMAGE];
        }
        catch(Exception $e)
        {
        }

        return $aImages;
    }
    
    public function getTotalExpertsCount($ConnBean,$clientId) {
        
        $aResult['total_audvisor_experts'] = 0;
        $aResult['total_client_experts'] = 0;
        $aResult['total_experts'] = 0;
        
        ////////////////
        
        $sQuery_audvisor_experts = "SELECT e.fldid, count(i.fldexpertid) AS count FROM tblexperts AS e LEFT JOIN (SELECT * FROM tblinsights WHERE fldisdeleted=0) AS i ON e.fldid=i.fldexpertid WHERE e.fldisdeleted = 0 AND e.client_id = :client_id GROUP BY e.fldid ORDER BY count DESC";
        $ConnBean->getPreparedStatement($sQuery_audvisor_experts);
        $ConnBean->bind_param(":client_id", 'audvisor11012017');
        $result_audvisor_experts   = $ConnBean->resultset();
        $total_audvisor_experts = $ConnBean->rowCount();
        
        $sQuery_client_experts = "SELECT e.fldid, count(i.fldexpertid) AS count FROM tblexperts AS e LEFT JOIN (SELECT * FROM tblinsights WHERE fldisdeleted=0) AS i ON e.fldid=i.fldexpertid WHERE e.fldisdeleted = 0 AND e.client_id = :client_id GROUP BY e.fldid ORDER BY count DESC";
        $ConnBean->getPreparedStatement($sQuery_client_experts);
        $ConnBean->bind_param(":client_id", $clientId);
        $result_client_experts   = $ConnBean->resultset();
        $total_client_experts = $ConnBean->rowCount();       
        
        $aResult['total_audvisor_experts'] = $total_audvisor_experts;
        $aResult['total_client_experts'] = $total_client_experts;
        $aResult['total_experts'] = $total_audvisor_experts + $total_client_experts;
        
        return $aResult;
    }
    
}

?>