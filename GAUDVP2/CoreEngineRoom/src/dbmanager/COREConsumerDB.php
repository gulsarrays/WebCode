<?php

/*
  Project                     : Oriole
  Module                      : Consumer
  File name                   : COREConsumerDB.php
  Description                 : DataBase class for Consumer related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREConsumerDB
{

    public function __construct()
    {
    }

    /**
     * Function used to  signup consumer.
     *
     * @param $ConnBean
     * @param $email
     * @param $hashedPassword
     * @param $sDeviceId
     * @param $sPlatformId
     * @param $sNotificationId
     *
     * @return array
     */
    public function signup($ConnBean, $email, $hashedPassword, $sDeviceId, $sPlatformId, $sNotificationId, $sPromo_code,$clientId,$groupId,$FirstName,$LastName,$is_password_reset=1,$expiry_timestamp=0,$wp_user_id=0,$wp_site_name=null,$chargebee_customer_id=null)
    {    
        $createddate = date("Y-m-d H:i:s");
        $subscription_expiry_date = date("Y-m-d H:i:s",$expiry_timestamp);
        $aResult     = array();
        try
        {
            $sQuery = "SELECT u.fldconsumerid FROM tbluserdevices u LEFT JOIN tblconsumers c ON u.fldconsumerid = c.fldid WHERE u.flddeviceid = :deviceid AND c.flddevicesignup = 1 AND c.client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":deviceid", $sDeviceId);
            $ConnBean->bind_param(":client_id", $clientId);
            $result                        = $ConnBean->single();
            $aResult[JSON_TAG_CONSUMER_ID] = $result[DB_COLUMN_FLD_CONSUMER_ID];
            if($result[DB_COLUMN_FLD_CONSUMER_ID] != null) //k Upgrade existing device sign up to consumer sign up
            {
                $sQuery = "UPDATE tblconsumers SET flddevicesignup = 0 , fldemailid = :emailid, fldhashedpassword = :password,fldpromocodeid = :promocode WHERE fldid = :id";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":emailid", $email);
                $ConnBean->bind_param(":password", $hashedPassword);
                $ConnBean->bind_param(":promocode", $sPromo_code);
                $ConnBean->bind_param(":client_id", $clientId);
                $ConnBean->bind_param(":id", $result[DB_COLUMN_FLD_CONSUMER_ID]);
                $bResult                  = $ConnBean->execute();
                $aResult[JSON_TAG_STATUS] = !$bResult;
                $consumerid               = $result[DB_COLUMN_FLD_CONSUMER_ID];
            }
            else
            {
                  
                //k Create a new consumer
                $sQuery = "INSERT INTO tblconsumers (fldemailid, fldhashedpassword, fldcreateddate,fldmodifieddate,fldpromocodeid,client_id,group_id,fldfirstname,fldlastname,is_password_reset,subscription_expiry_date,wp_user_id,wp_site_name,chargebee_customer_id) VALUES (:emailid, :password, NOW() ,NOW(),:promocode,:client_id,:group_id,:first_name,:last_name,:is_password_reset,:subscription_expiry_date,:wp_user_id,:wp_site_name,:chargebee_customer_id)";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":first_name", $FirstName);
                $ConnBean->bind_param(":last_name", $LastName);
                $ConnBean->bind_param(":emailid", $email);
                $ConnBean->bind_param(":password", $hashedPassword);
                $ConnBean->bind_param(":promocode", $sPromo_code);
                $ConnBean->bind_param(":client_id", $clientId);
                $ConnBean->bind_param(":group_id", $groupId);
                $ConnBean->bind_param(":is_password_reset", $is_password_reset);
                $ConnBean->bind_param(":subscription_expiry_date", $subscription_expiry_date);
                $ConnBean->bind_param(":wp_user_id", $wp_user_id);
                $ConnBean->bind_param(":wp_site_name", $wp_site_name);
                $ConnBean->bind_param(":chargebee_customer_id", $chargebee_customer_id);

                $bResult                       = $ConnBean->execute();
                $aResult[JSON_TAG_CONSUMER_ID] = $ConnBean->lastInsertId();
                $consumerid                    = $aResult[JSON_TAG_CONSUMER_ID];
                $aResult[JSON_TAG_STATUS]      = !$bResult;
                $userDevicesDB                 = new COREUserDevicesDB();
                //k Remove the device from previous owner(if any)
                $userDevicesDB->DeleteUserDevice($ConnBean, $sDeviceId);
                $bResult                  = $userDevicesDB->AddUserDevice($ConnBean, $consumerid, $sDeviceId, $sPlatformId, $sNotificationId);
                $ConnBean                 = null;
                $aResult[JSON_TAG_STATUS] = !$bResult;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
        return $aResult;
    }

    /**
     * Function used to edit consumer details.
     *
     * @param $ConnBean
     * @param $sDeviceId
     * @param $sPlatformId
     * @param $sNotificationId
     * @param $consumerId
     *
     * @return array
     */
    public function modify_consumer($ConnBean, $sDeviceId, $sPlatformId, $sNotificationId, $consumerId)
    {
        $aResult = array();
        try
        {
            $UserDevicesDB = new COREUserDevicesDB();
            $bResult       = $UserDevicesDB->UpdateUserDevice($ConnBean, $consumerId, $sDeviceId, $sPlatformId, $sNotificationId);
            if($bResult)
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $aResult;
    }

    /**
     * Function used to edit consumer details.
     *
     * @param $ConnBean
     * @param $queryFields
     * @param $updateParams
     * @param $columns
     * @param $consumerId
     * @param $sConsumerDeviceID
     *
     * @return array
     */
    public function patch_consumer($ConnBean, $queryFields, $updateParams, $columns, $consumerId, $sConsumerDeviceID)
    {
        $aResult = array();
        try
        {
            $UserDevicesDB     = new COREUserDevicesDB();
            $aDeviceAttributes = array_combine($columns, $updateParams);
            $bResult           = $UserDevicesDB->PatchUserDevice($ConnBean, $consumerId, $sConsumerDeviceID, $aDeviceAttributes);

            if($bResult)
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $aResult;
    }

    /**
     * Function used to insert users into database.
     *
     * @param $ConnBean
     * @param $email
     * @param $password
     * @param $deviceId
     * @param $platformId
     * @param $notificationId
     *
     * @return array
     */
    public function device_signup($ConnBean, $email, $password, $deviceId, $platformId, $notificationId)
    {
        $createddate = date("Y-m-d H:i:s");
        $aResult     = array();
        try
        {
            $sQuery = "SELECT c.fldid,u.fldconsumerid, c.flddevicesignup,c.client_id FROM tbluserdevices u LEFT JOIN tblconsumers c ON u.fldconsumerid = c.fldid WHERE u.flddeviceid = :deviceid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":deviceid", $deviceId);
            $userDetails = $ConnBean->resultset();
            $userDevicesDB = new COREUserDevicesDB();
            foreach($userDetails as $users)
            {

                $userDevicesDB->DeleteUserDevice($ConnBean, $deviceId);

                if($users[DB_COLUMN_FLD_DEVICE_SIGNUP]) //k There is a consumer associated with the current device and that consumer represents device sign up. Hence clear that records for previous consumer.
                {

                    $sQuery = "DELETE FROM tblconsumers WHERE fldid = :fldid";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":fldid", $users['fldconsumerid']);
                    $userId = $users['fldconsumerid'];
                    if($users['client_id']){
                        $clientId = $users['client_id'];
                    }
                    $bResult = $ConnBean->execute();
                }
            }
            $sQuery = "INSERT INTO tblconsumers (fldid,fldemailid, fldhashedpassword, fldcreateddate,flddevicesignup,client_id) VALUES (:fldid,:emailid, :hashedpassword, NOW(), 1,:client_id)";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $ConnBean->bind_param(":fldid", $userId);
            $ConnBean->bind_param(":emailid", $email);
            $ConnBean->bind_param(":hashedpassword", $password);
            $bResult    = $ConnBean->execute();
            $consumerId = $ConnBean->lastInsertId();

            $bResultValue = $userDevicesDB->AddUserDevice($ConnBean, $consumerId, $deviceId, $platformId, $notificationId);

            $sQuery = "SELECT  fldid, fldcreateddate, fldmodifieddate, fldemailid FROM tblconsumers WHERE fldid = :fldid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":fldid", $consumerId);
            $userDetailsJson = $ConnBean->resultset();
            foreach($userDetailsJson as $userDetails)
            {
                $aResult = array(JSON_TAG_CONSUMER_ID => intval($userDetails['fldid']), JSON_TAG_CREATED_DATE => $userDetails['fldcreateddate'], JSON_TAG_MODIFIED_DATE => $userDetails['fldmodifieddate'], JSON_TAG_EMAIL => $userDetails['fldemailid'], JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_CONSUMERS.'/'.$userDetails['fldid'].'');
            }

            $aResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            print_r($e); exit;
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $aResult;
    }

    /**
     * Function used to check whether email is registered or not.
     *
     * @param $inConnBean
     * @param $insEmailID
     *
     * @return mixed
     */
    public function emailIDExists($inConnBean, $insEmailID ,$clientId)
    {
        try
        {
            $iUserCount = 0;
            $sQuery     = "SELECT count(*) user_count FROM tblconsumers WHERE fldemailid = :emailid and client_id = :clientId";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":emailid", $insEmailID);
            $inConnBean->bind_param(":clientId", $clientId);
            $inConnBean->execute();
            $iUserCount = $inConnBean->single();
            if($iUserCount[DB_COLUMN_FLD_USER_COUNT] >= 1)
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_FIELD_EMPTY;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
            }
            $inConnBean = null;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $aResult;
    }

    /**
     * Function used to check whether email is registered or not.
     *
     * @param $inConnBean
     * @param $insEmailID
     *
     * @return mixed
     */
    public function forgot_password($inConnBean, $insEmailID,$clientId)
    {
        try
        {
                 
            $iUserCount = 0;
            $sQuery     = "SELECT fldid FROM tblconsumers WHERE fldemailid = ? AND client_id = ?";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param("1", $insEmailID);
            $inConnBean->bind_param("2", $clientId);
            $bResult    = $inConnBean->single();
            $consumerID = $bResult[DB_COLUMN_FLD_ID];
            if($consumerID)
            {
                $sQuery = "SELECT fldtoken FROM tblpasswordreset WHERE fldconsumerid = ?";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param("1", $consumerID);
                $bResult = $inConnBean->single();
                $tresult = $bResult[DB_COLUMN_FLD_TOKEN];
                if($tresult)
                {
                    $sQuery = "UPDATE tblpasswordreset SET fldtoken =?, fldtstamp =? WHERE fldconsumerid = ? ";
                }
                else
                {
                    $sQuery = "INSERT INTO tblpasswordreset (fldtoken, fldtstamp , fldconsumerid ) VALUES (?, ?, ?)";
                }
                $time  = time();
                $token = sha1(uniqid($consumerID, true));
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param("1", $token);
                $inConnBean->bind_param("2", $time);
                $inConnBean->bind_param("3", $consumerID);
                $bResult                  = $inConnBean->execute();
                $aResult[JSON_TAG_TOKEN]  = $token;
                $aResult[JSON_TAG_STATUS] = 0;
            }
            else
            {
                $sQuery     = "SELECT fldid FROM tblconsumers WHERE fldemailid = ?";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param("1", $insEmailID);
                $cResult    = $inConnBean->single();
                if($cResult){
                    $aResult[JSON_TAG_STATUS] = 3;
                }else{
                    $aResult[JSON_TAG_STATUS] = 1;
                }
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used to check whether Device is registered or not.
     *
     * @param $inConnBean
     * @param $deviceId
     *
     * @return mixed
     */
    public function deviceExists($inConnBean, $deviceId)
    {
        try
        {
            $iUserCount = 0;
            $sQuery     = "SELECT count(*) device_count FROM tbluserdevices WHERE flddeviceid = ?";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param("1", $deviceId);
            $bResult      = $inConnBean->execute();
            $device_count = $bResult[JSON_TAG_DEVICE_COUNT];
            if($device_count >= 1)
            {
                $aResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = 0;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     *  Function used to get user informations.
     *
     * @param $inConnBean
     * @param $insEmailID
     * @param $consumerid
     *
     * @return array|null
     */
    public function checkSignIn($inConnBean, $insEmailID, $consumerid)
    {
        try
        {
            $iUserCount = 0;
            $sQuery     = "SELECT  fldid, fldcreateddate, fldmodifieddate, fldemailid, fldhashedpassword,subscription_expiry_date FROM tblconsumers WHERE fldid = :id ";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":id", $consumerid);
            $bResult = $inConnBean->execute();
            $aResult = array();
            if(count($inConnBean->resultset()))
            {
                foreach($inConnBean->resultset() as $result)
                {
                    $aResult = array(JSON_TAG_CONSUMER_ID => intval($result[DB_COLUMN_FLD_ID]), JSON_TAG_CREATED_DATE => $result[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $result[DB_COLUMN_FLD_MODIFIED_DATE],'subscription_expiry_date' => $result['subscription_expiry_date'], JSON_TAG_EMAIL => $result[DB_COLUMN_FLD_EMAIL_ID], JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_CONSUMERS.'/'.$result[DB_COLUMN_FLD_ID].'');
                }
            }
            else
            {
                $aResult = null;
            }
            if($bResult)
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = ERRCODE_FIELD_EMPTY;
            }
            $inConnBean = null;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $aResult;
    }

    /**
     * Function used to check whether user is already signedin or not.
     *
     * @param $inConnBean
     * @param $insEmailID
     * @param $deviceID
     *
     * @return array|null
     */
    public function IsUserSignedIn($inConnBean, $insEmailID, $deviceID,$clientId)
    {
        try
        {
            $sQuery = "SELECT  fldid, fldcreateddate, fldmodifieddate, fldemailid, fldhashedpassword,client_id, is_password_reset,subscription_expiry_date,fldfirstname,fldlastname  FROM tblconsumers WHERE fldemailid = ? and client_id = ?";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param("1", $insEmailID);
            $inConnBean->bind_param("2", $clientId);
            $result            = $inConnBean->single();
            $fldconsumerid     = $result[DB_COLUMN_FLD_ID];
            $fldcreateddate    = $result[DB_COLUMN_FLD_CREATED_DATE];
            $fldmodifieddate   = $result[DB_COLUMN_FLD_MODIFIED_DATE];
            $fldemailid        = $result[DB_COLUMN_FLD_EMAIL_ID];
            $fldhashedpassword = $result[DB_COLUMN_FLD_HASHED_PASSWORD];
            $clientId          = $result[DB_COLUMN_FLD_CLIENT_ID];
            $is_password_reset = $result[DB_COLUMN_IS_PASSWORD_RESET];
            $subscription_expiry_date       = $result['subscription_expiry_date'];
            $first_name         = $result['fldfirstname'];
            $last_name          = $result['fldlastname'];
            $iResult           = array();
            if($fldconsumerid != NULL)
            {

                {
                    $sQuery = "SELECT u.fldconsumerid, c.flddevicesignup FROM tbluserdevices u LEFT JOIN tblconsumers c ON u.fldconsumerid = c.fldid WHERE u.flddeviceid = :deviceid";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":deviceid", $deviceID);
                    $result               = $inConnBean->single();
                    $currentDeviceOwnerID = $result[DB_COLUMN_FLD_CONSUMER_ID];
                    $isDeviceSignUp       = $result[DB_COLUMN_FLD_DEVICE_SIGNUP];
                    if(!empty($currentDeviceOwnerID))
                    {
                        if($currentDeviceOwnerID != $fldconsumerid)
                        {
                            //k Device belonged to some other consumer. So we need to patch the device owner.
                            // In addition, if the device was used for device Sign up, delete the device sign up User along with device.

                            $userDevicesDB = new COREUserDevicesDB();
                            $userDevicesDB->PatchUserDeviceOwner($inConnBean, $deviceID, $fldconsumerid);

                            if($isDeviceSignUp)
                            {
                                $sQuery = "DELETE FROM tblconsumers WHERE fldid = :fldid";
                                $inConnBean->getPreparedStatement($sQuery);
                                $inConnBean->bind_param(":fldid", $currentDeviceOwnerID);
                                $inConnBean->execute();
                            }
                        }
                    }
                }
                
                $iResult = array(
                    JSON_TAG_CONSUMER_ID => $fldconsumerid, 
                    JSON_TAG_CREATED_DATE => $fldcreateddate, 
                    JSON_TAG_MODIFIED_DATE => $fldmodifieddate, 
                    JSON_TAG_EMAIL => $fldemailid, 
                    JSON_TAG_HASHED_PASSWORD => $fldhashedpassword, 
                    JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_CONSUMERS.'/'.$fldconsumerid.'',
                    JSON_TAG_CLIENT_ID=>$clientId,
                    JSON_TAG_IS_PASSWORD_RESET=>$is_password_reset,
                    'subscription_expiry_date' => $subscription_expiry_date,
                    JSON_TAG_FIR_NAME         => $first_name,
                    JSON_TAG_LA_NAME         => $last_name);
            }
            else
            {
                $iResult = null;
            }
        }
        catch(Exception $e)
        {
        }

        return $iResult;
    }

    /**
     * Function used to like insights by users.
     *
     * @param $consumerid
     * @param $ConnBean
     *
     * @return mixed
     */
    public function favourites_list($consumerid, $ConnBean)
    {
//        print_r($consumerid); exit;
        $expertImages                  = array();
        $finalResult[JSON_TAG_RECORDS] = array();
        $initialResult                 = array();
        try
        {
            $sQuery = " SELECT i.client_id,f.fldid, f.fldcreateddate,i.fldduration, f.fldmodifieddate,i.fldcreateddate AS insightcreateddate,i.fldmodifieddate insightmodifieddate, i.fldid insightid,i.fldinsightvoiceoverurl, i.fldname insightname,i.fldstreamingfilename,i.fldstreamingfilenamehlsv4 , GROUP_CONCAT(t.fldid SEPARATOR ',') topicid, GROUP_CONCAT(t.fldname SEPARATOR ',') topicname, e.fldid expertid,e.fldvoiceoverurl, e.fldfirstname, e.fldlastname, e.fldtitle experttitle, e.fldcreateddate expertcreated, e.fldmodifieddate expertmodified, e.fldavatarurl FROM `tblfavourites` f JOIN tblinsights i ON f.`fldconsumerid` = :consumerid  AND f.`fldinsightid`=i.`fldid` JOIN tbltopicinsight t_i ON i.fldid = t_i.fldinsightid JOIN tbltopics t ON t.fldid = t_i.fldtopicid LEFT JOIN tblexperts e ON e.fldid = i.fldexpertid WHERE i.fldisonline = 1 AND i.fldisdeleted = 0 GROUP BY i.fldname ORDER BY i.fldid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerid);
            $bResult  = $ConnBean->resultset();
          
            $s3bridge = new COREAwsBridge();
            foreach($bResult as $dbColumn)
            {
                if($dbColumn[DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL] == null || $dbColumn[DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL] == "")
                {
                    $sInsightVoiceover = null;
                }
                else
                {
                    $sInsightVoiceover = $s3bridge->GetInsightVoiceOverURL($dbColumn[DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL],$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                }
                $streamingUrl                     = empty($dbColumn[DB_COLUMN_FLD_STREAMING_FILENAME]) ? null : $s3bridge->GetS3InsightURL($dbColumn[DB_COLUMN_FLD_STREAMING_FILENAME],$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                $streamingFileNamehlsv4           = empty($dbColumn[DB_COLUMN_FLD_STREAMING_FILENAME_V4]) ? null : $s3bridge->GetS3InsightURL($dbColumn[DB_COLUMN_FLD_STREAMING_FILENAME_V4],$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                $expertImages                     = null;
                $initialResult                    = array(JSON_TAG_TYPE => JSON_TAG_FAVORITE_INSIGHT, JSON_TAG_CREATED_DATE => $dbColumn[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $dbColumn[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_ID => intval($dbColumn[DB_COLUMN_FLD_ID]), JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_FAVOURITES.'/'.$dbColumn[DB_COLUMN_FLD_ID].'');
                $initialResult[JSON_TAG_INSIGHTS] = array(JSON_TAG_ID => intval($dbColumn[DB_COLUMN_FLD_INSIGHT_ID]), JSON_TAG_INSIGHT_DURATION => $dbColumn[DB_COLUMN_FLD_INSIGHT_DURATION], JSON_TAG_CREATED_DATE => $dbColumn[JSON_TAG_INSIGHT_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $dbColumn[JSON_TAG_INSIGHT_MODIFIED_DATE], JSON_TAG_STREAMINGURL => $streamingUrl, JSON_TAG_STREAMING_FILENAME_V4 => $streamingFileNamehlsv4, JSON_TAG_INSIGHT_VOICE_OVER_URL => $sInsightVoiceover, JSON_TAG_EXPERT_ID => intval($dbColumn[DB_COLUMN_FLD_EXPERTID]), JSON_TAG_TITLE => $dbColumn[DB_COLUMN_FLD_INSIGHT_NAME]);

                $expertName          = $dbColumn[DB_COLUMN_FLD_FIRST_NAME].' '.$dbColumn[DB_COLUMN_FLD_LAST_NAME];
                $expertImages[]      = $dbColumn[DB_COLUMN_FLD_AVATAR_URL];
                $expertAvatar        = $s3bridge->GetS3ExpertAvatarURL($dbColumn[DB_COLUMN_FLD_AVATAR_URL],$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                $sAvatarUrls         = $s3bridge->GetS3ExpertAvatarURLs($expertImages,$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                $sExpertVoiceoverUrl = $dbColumn[DB_COLUMN_FLD_VOICEOVER_URL];
                if($dbColumn[DB_COLUMN_FLD_AVATAR_URL] == "" || $dbColumn[DB_COLUMN_FLD_AVATAR_URL] == null)
                {
                    $expertAvatar = $sAvatarUrls[$dbColumn[DB_COLUMN_FLD_AVATAR_URL]];
                }

                if($dbColumn[DB_COLUMN_FLD_VOICEOVER_URL] == null || $dbColumn[DB_COLUMN_FLD_VOICEOVER_URL] == "")
                {
                    $sExpertVoiceoverUrl = null;
                }
                else
                {
                    $sExpertVoiceoverUrl = $s3bridge->GetExpertVoiceOverURL($dbColumn[DB_COLUMN_FLD_VOICEOVER_URL],$dbColumn[DB_COLUMN_FLD_CLIENT_ID]);
                }
                $initialResult[JSON_TAG_INSIGHTS][JSON_TAG_EXPERT] = array(JSON_TAG_ID => intval($dbColumn[DB_COLUMN_FLD_EXPERTID]), JSON_TAG_EXPERT_VOICE_OVER_URL => $sExpertVoiceoverUrl, JSON_TAG_TITLE => $expertName, JSON_TAG_SUBTITLE => $dbColumn[DB_COLUMN_FLD_EXPERT_SUBTITLE], JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_EXPERTS.'/'.$dbColumn[DB_COLUMN_FLD_EXPERTID].'', JSON_TAG_AVATAR_LINK => $expertAvatar, JSON_TAG_AVATAR_LINK_2X => $sAvatarUrls[$dbColumn[DB_COLUMN_FLD_AVATAR_URL]]);
                $inResult                                          = array();
                $inResult[JSON_TAG_INSIGHTS][JSON_TAG_TOPICS][]    = array(JSON_TAG_ID => $dbColumn[DB_COLUMN_FLD_TOPIC_ID], JSON_TAG_TITLE => $dbColumn[DB_COLUMN_FLD_TOPIC_NAME]);
                $idArray                                           = array_map("intval", array_values(array_unique(explode(',', $inResult[JSON_TAG_INSIGHTS][JSON_TAG_TOPICS][0][JSON_TAG_ID]))));
                $titleArray                                        = array_values(array_unique(explode(',', $inResult[JSON_TAG_INSIGHTS][JSON_TAG_TOPICS][0][JSON_TAG_TITLE])));
                $i                                                 = 0;
                while($i < count($idArray))
                {
                    $initialResult[JSON_TAG_INSIGHTS][JSON_TAG_TOPICS][] = array(JSON_TAG_ID => $idArray[$i], JSON_TAG_TITLE => $titleArray[$i]);
                    $i++;
                }
                $finalResult[JSON_TAG_RECORDS][] = $initialResult;
            }
            $finalResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
        }
        catch(Exception $e)
        {  print_r($e); exit;
            $finalResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
        $ConnBean = null;
        if(count($finalResult[JSON_TAG_RECORDS]) == 0)
        {
            $finalResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_NO_FAVOURITES;
        }

        return $finalResult;
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $inConnBean
     * @param $consumerId
     * @param $newPassword
     *
     * @return int
     */
    public function update_password($inConnBean, $consumerId, $newPassword,$raw_password=null)
    {
        try
        {
            $sQuery = "UPDATE tblconsumers SET fldhashedpassword = :hashedpassword, is_password_reset=1 WHERE fldid = :fldid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":hashedpassword", $newPassword);
            $inConnBean->bind_param(":fldid", $consumerId);
            $inConnBean->execute();

//            if($inConnBean->rowCount == 1)
//            {
                $status = 0;
                
                /*****************************************************************/               
                if($raw_password != null) {                    
                    
                    $sQuery = "SELECT c.fldid,c.client_id,c.fldemailid FROM tblconsumers AS c where c.fldid = :fldid ";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":fldid", $consumerId);
                    $result = $inConnBean->single();
                    $sEmailid    = $result[DB_COLUMN_FLD_EMAIL_ID];
            
                    // Wordpress Password updation
                    $endpoint = '/update-password';
                    $url = JSON_TAG_WP_URL;
                    $url .= $endpoint;                

                    $data = array(
                        'username' => $sEmailid,
                        'password'=> $raw_password
                        );
                    $json_data = $data;

                    $wp_user_id = null;
                    $wp_authenticated= true;
                    $wp_auth = $this->l_curl($url,$json_data);
                }
                /*****************************************************************/
//            }
//            else
//            {
//                                        die('63333333333');
//                $status = 1;
//            }
            $consumerId = null;
        }
        catch(Exception $e)
        {
//            $status = 2;
            $status = $e->getMessage();
        }
        return $status;
    }

    /**
     * Function used to to retrive the hashed password.
     *
     * @param $inConnBean
     * @param $consumerId
     *
     * @return array
     */
    public function get_password($inConnBean, $consumerId)
    {
        $iResult = array();
        try
        {
            $iUserCount = 0;
            $sQuery     = "SELECT fldhashedpassword FROM tblconsumers WHERE fldid = :fldid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":fldid", $consumerId);
            $getPassword                = $inConnBean->single();
            $iResult[JSON_TAG_PASSWORD] = $getPassword['fldhashedpassword'];
            $inConnBean                 = null;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 3;
        }

        return $iResult;
    }

    /**
     * Function used to like insights and inserted to database.
     *
     * @param $ConnBean
     * @param $insightId
     * @param $consumerId
     *
     * @return array
     */
    public function update_favourites($ConnBean, $insightId, $consumerId)
    {
        $finalResult[JSON_TAG_RECORDS] = array();
        $insightDB                     = new COREInsightDB();
        try
        {
            $validConsumer = $this->valid_consumer($consumerId);
            
            if($validConsumer && $insightDB->valid_insight($insightId) )
            {
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

                    if($ConnBean->rowCount() == 1)
                    {
                        $sQuery = "SELECT fldid, fldinsightid, fldcreateddate, fldmodifieddate FROM tblfavourites WHERE fldconsumerid = ?";
                        $ConnBean->getPreparedStatement($sQuery);
                        $ConnBean->bind_param("1", $consumerId);
                        $result = $ConnBean->resultset();
                        foreach($result as $favourite)

                        {
                            $iResult = array(JSON_TAG_TYPE => JSON_TAG_FAVORITE_INSIGHT, JSON_TAG_CREATED_DATE => $favourite[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $favourite[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_ID => $favourite[DB_COLUMN_FLD_ID], JSON_TAG_LINK => API_BASE_URL_STRING.API_VERSION.'/'.JSON_TAG_FAVOURITES.'/'.$favourite[DB_COLUMN_FLD_ID].'', JSON_TAG_STATUS => 0);
                        }
                    }
                    else
                    {
                        $iResult[JSON_TAG_STATUS] = 3;
                    }
                }
                else
                {
                    $iResult[JSON_TAG_STATUS] = 4;
                }
            }
            else
            {
                $iResult[JSON_TAG_STATUS] = SERVER_ERRORCODE_INVALID_CONSUMER;
                if($validConsumer)
                {
                    $iResult[JSON_TAG_STATUS] = SERVER_ERRORCODE_INVALID_INSIGHT;
                   
                }
            }
        }
        catch(Exception $e)
        {
            print($e);
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to unlike insights and data will be removed  from database.
     *
     * @param $consumerid
     * @param $favid
     * @param $ConnBean
     *
     * @return int
     */
    public function update_user_unlike($consumerid, $favid, $ConnBean)
    {

        try
        {
            $sQuery = "DELETE FROM tblfavourites WHERE fldid = ? AND fldconsumerid = ?";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param('1', $favid);
            $ConnBean->bind_param('2', $consumerid);
            $bResult = $ConnBean->execute();
            if($ConnBean->rowCount() == 1)
            {
                $status = 0;
            }
            else
            {
                $status = 1;
            }
        }
        catch(Exception $e)
        {
            $status = 2;
        }

        return $status;
    }

    /**
     * Function used to record consumer analytics like percentage of skipped, shared, played etc stored into the database.
     *
     * @param $ConnBean
     * @param $receiverId
     * @param $actionId
     * @param $actionData
     * @param $consumerId
     * @param $receiverType
     *
     * @return array
     */
    public function consumer_analytics($ConnBean, $receiverId, $actionId, $actionData, $consumerId, $receiverType)
    {
        $aResult = array();
        try
        {
            $sQuery = "INSERT INTO tblconsumeranalytics (fldreceiverid, fldactionid, fldactiondata, fldconsumerid, fldreceivertype,fldcreateddate) VALUES (:receiverid, :actionid, :actiondata,:consumerid, :receivertype,NOW())";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":receiverid", $receiverId);
            $ConnBean->bind_param(":actionid", $actionId);
            $ConnBean->bind_param(":actiondata", $actionData);
            $ConnBean->bind_param(":consumerid", $consumerId);
            $ConnBean->bind_param(":receivertype", $receiverType);
            $bResult = $ConnBean->execute();
            if($bResult)
            {
                if((($actionId == 2 && $actionData >= 50) || $actionId == 5))
                {
                    $this->storeInsightsCount($ConnBean, $consumerId, $receiverId);
                    $this->storeTopicsCount($ConnBean, $consumerId, $receiverId);
                    $this->storeExpertsCount($ConnBean, $consumerId, $receiverId);
                }
                $aResult[JSON_TAG_STATUS] = 0;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = 1;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function to store insights count for consumers.
     *
     * @param $ConnBean
     * @param $consumerid
     * @param $insightid
     */
    public function storeInsightsCount($ConnBean, $consumerid, $insightid)
    {
        $sQuery = "select  fldcount as insightcount  from tblcainsights where fldconsumerid=$consumerid and fldinsightid= $insightid";
        $ConnBean->getPreparedStatement($sQuery);
        $row   = $ConnBean->single();
        $count = 1;

        if(!empty($row))
        {
            $count  = $row['insightcount'] + 1;
            $sQuery = "update tblcainsights set fldcount=$count where fldconsumerid=$consumerid and fldinsightid=$insightid";
        }
        else
        {
            $sQuery = "insert into tblcainsights (`fldconsumerid`,`fldinsightid`,`fldcount`) values($consumerid,$insightid,$count)";
        }
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->execute();
    }

    /**
     * Function to store topics count for consumers depending on insights played.
     *
     * @param $ConnBean
     * @param $consumerid
     * @param $insightid
     */
    public function storeTopicsCount($ConnBean, $consumerid, $insightid)
    {
        $cnt    = 1;
        $sQuery = "select fldtopicid, fldcount as topiccount  from tblcatopics where fldconsumerid=$consumerid";
        $ConnBean->getPreparedStatement($sQuery);
        $rows = $ConnBean->resultset();
        $size = sizeof($rows);

        $sQuery = "select fldtopicid from tbltopicinsight where fldinsightid= $insightid";
        $ConnBean->getPreparedStatement($sQuery);
        $rows = $ConnBean->resultset();

        if($size > 0)
        {
            if(!empty($rows))
            {
                foreach($rows as $row)
                {
                    $topicid = $row['fldtopicid'];
                    $sQuery  = "select fldcount from tblcatopics where fldtopicid=$topicid and fldconsumerid=$consumerid";
                    $ConnBean->getPreparedStatement($sQuery);
                    $result = $ConnBean->single();
                    if(empty($result))
                    {
                        $sQuery = "insert into tblcatopics(`fldconsumerid`,`fldtopicid`,`fldcount`) values($consumerid,$topicid,$cnt)";
                    }
                    else
                    {
                        $cnt    = $result['fldcount'] + 1;
                        $sQuery = "update tblcatopics set fldcount=$cnt where fldconsumerid=$consumerid and fldtopicid=$topicid";
                    }
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->execute();
                }
            }
        }
        else
        {
            if(!empty($rows))
            {
                foreach($rows as $row)
                {
                    $topicid = $row['fldtopicid'];
                    $sQuery  = "insert into tblcatopics(`fldconsumerid`,`fldtopicid`,`fldcount`) values($consumerid,$topicid,$cnt)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->execute();
                }
            }
        }
    }

    /**
     * Function to store experts count for  consumers depending on insights played.
     *
     * @param $ConnBean
     * @param $consumerid
     * @param $insightid
     */
    public function storeExpertsCount($ConnBean, $consumerid, $insightid)
    {
        $count  = 1;
        $sQuery = "select fldcount as expertcount,fldexpertid  from tblcaexperts where fldconsumerid=$consumerid ";
        $ConnBean->getPreparedStatement($sQuery);
        $rows = $ConnBean->resultset();
        $size = sizeof($rows);

        $sQuery = "select fldexpertid from tblinsights where fldid=$insightid";
        $ConnBean->getPreparedStatement($sQuery);
        $row = $ConnBean->single();

        if($size > 0)
        {
            if(!empty($row))
            {
                $expertid = $row['fldexpertid'];
                $sQuery   = "select fldcount from tblcaexperts where fldexpertid=$expertid and fldconsumerid=$consumerid";
                $ConnBean->getPreparedStatement($sQuery);
                $result = $ConnBean->single();

                if(empty($result))
                {
                    $sQuery = "insert into tblcaexperts(`fldconsumerid`,`fldexpertid`,`fldcount`) values($consumerid,$expertid,$count)";
                }
                else
                {
                    $cnt    = $result['fldcount'] + 1;
                    $sQuery = "update tblcaexperts set fldcount=$cnt where fldconsumerid=$consumerid and fldexpertid=$expertid";
                }
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->execute();
            }
        }
        else
        {
            if(!empty($row))
            {
                $expertid = $row['fldexpertid'];
                $sQuery   = "insert into tblcaexperts(`fldconsumerid`,`fldexpertid`,`fldcount`) values($consumerid,$expertid,$count)";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->execute();
            }
        }
    }

    /**
     * Function used to retrive Consumer credentials along with hashed password.
     *
     * @param $inConnBean
     * @param $insConsumerUUID
     * @param $consumerId
     *
     * @return array
     */
    public function getConsumerCredentials($inConnBean, $insConsumerUUID, $consumerId)
    {
        $aCredentials = array();
        try
        {
            $sQuery = "SELECT fldhashedpassword FROM tblconsumers WHERE fldemailid = :email AND fldid = :fldid";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(':email', $insConsumerUUID);
            $inConnBean->bind_param(':fldid', $consumerId);
            $result    = $inConnBean->single();
            $sPassword = $result[DB_COLUMN_FLD_HASHED_PASSWORD];
            if($inConnBean->rowCount())
            {
                $aCredentials[JSON_TAG_PASSWORD] = $sPassword;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $aCredentials;
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function get_useractions($ConnBean)
    {
        $aResult = array();
        try
        {
            $sQuery = "SELECT c.fldid,c.fldconsumerid,c.fldreceiverid,c.fldactionid,c.fldactiondata,c.fldreceivertype, (CASE WHEN c.fldreceivertype = 1 THEN (SELECT fldname FROM tblinsights WHERE fldid=c.fldreceiverid) WHEN c.fldreceivertype= 2 THEN (SELECT fldname FROM tbltopics WHERE fldid=c.fldreceiverid ) WHEN c.fldreceivertype = 3 THEN (SELECT CONCAT(fldfirstname,' ',fldlastname) AS fldname FROM tblexperts WHERE fldid=c.fldreceiverid ) END) AS receivername FROM tblconsumeranalytics AS c";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            foreach($result as $aUseractions)
            {
                $aResult[JSON_TAG_RECORDS][] = array(JSON_TAG_ID => $aUseractions[DB_COLUMN_FLD_ID], JSON_TAG_CONSUMER_UID => $aUseractions[DB_COLUMN_FLD_CONSUMER_ID], JSON_TAG_RECEIVER_ID => $aUseractions[DB_COLUMN_FLD_RECEIVER_ID], JSON_TAG_ACTION_ID => $aUseractions[DB_COLUMN_FLD_ACTION_ID], JSON_TAG_ACTION_DATA => $aUseractions[DB_COLUMN_FLD_ACTION_DATA], JSON_TAG_RECEIVER_TYPE => $aUseractions[DB_COLUMN_FLD_RECEIVER_TYPE], JSON_TAG_NAME => $aUseractions[JSON_TAG_RECEIVER_NAME]);
            }
            if(count($aResult[JSON_TAG_RECORDS]) == 0)
            {
                $aResult[JSON_TAG_STATUS]  = 3;
                $aResult[JSON_TAG_RECORDS] = NULL;
            }

            $aResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @param $ConnBean
     * @param $iConsumerid
     * @param $iType
     * @param $iReceiverid
     *
     * @return array
     */
    public function user_follow($ConnBean, $iConsumerid, $iType, $iReceiverid)
    {
        $count                    = 0;
        $count2                   = 0;
        $table                    = "tbltopics";
        $aResult[JSON_TAG_STATUS] = -1;
        $aResult                  = array();
        try
        {

            if($iType == 1 || $iType == 2)
            {
                $sQuery = "SELECT COUNT(*) AS consumer_count FROM TBLCONSUMERS WHERE FLDID= :fldid";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":fldid", $iConsumerid);
                $result = $ConnBean->single();
                $count  = $result[JSON_TAG_CONSUMER_COUNT];
                if($iType == 1)
                {
                    $table = "tblexperts";
                }
                $sQuery = "SELECT COUNT(*) AS device_count FROM ".$table." WHERE FLDID=? AND fldisdeleted=0";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param("i", $iReceiverid);
                $ConnBean->single();
                $count2 = $result[JSON_TAG_DEVICE_COUNT];
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = 4;
            }
            if($count > 0 && $count2 > 0)
            {
                $sQuery = "INSERT INTO tblfollowtopicsexperts (fldconsumerid,fldreceiverid,fldtype,fldcreateddate) VALUES(:consumerid,:receiverid,:type,now())";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":consumerid", $iConsumerid);
                $ConnBean->bind_param(":receiverid", $iReceiverid);
                $ConnBean->bind_param(":type", $iType);
                $ConnBean->execute();
                $aResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                if($count == 0)
                {
                    $aResult[JSON_TAG_STATUS] = 5;
                }
                else
                {
                    if($count2 == 0)
                    {
                        $aResult[JSON_TAG_STATUS] = 6;
                    }
                }
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used to folllow topics or experts.
     *
     * @param $ConnBean
     * @param $iConsumerid
     * @param $iType
     * @param $iReceiverid
     *
     * @return array
     */
    public function user_unfollow($ConnBean, $iConsumerid, $iType, $iReceiverid)
    {

        $aResult = array();
        try
        {

            $sQuery = "DELETE FROM tblfollowtopicsexperts WHERE fldconsumerid = :consumerid AND fldreceiverid = :receiverid AND fldtype = :type";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerid", $iConsumerid);
            $ConnBean->bind_param(":receiverid ", $iReceiverid);
            $ConnBean->bind_param(":type", $iType);
            $ConnBean->execute();
            if($ConnBean->rowCount >= 1)
            {
                $aResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                $aResult[JSON_TAG_STATUS] = 0;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used to To list favorited experts
     *
     * @param $ConnBean
     * @param $iConsumerid
     *
     * @return array
     */
    public function following_experts_list($ConnBean, $iConsumerid,$clientId)
    {
        $s3bridge = new COREAwsBridge();
        $count    = 0;
        $aResult  = array();
        try
        {
            $sQuery = "  SELECT  e.fldid,e.fldfirstname,e.fldlastname,e.fldtitle,e.fldavatarurl,e.fldcreateddate,e.fldmodifieddate FROM tblexperts AS e LEFT JOIN tblfollowtopicsexperts AS f ON e.fldid=f.fldreceiverid WHERE f.fldconsumerid = :consumerid AND f.fldtype=1 AND e.fldisdeleted=0 ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerid", $iConsumerid);
            $bResult = $ConnBean->resultset();
            foreach($bResult as $expert)
            {
                $count++;
                $expertName                 = $expert[DB_COLUMN_FLD_FIRST_NAME].' '.$expert[DB_COLUMN_FLD_LAST_NAME];
                $expertAvatar               = $s3bridge->GetS3ExpertAvatarURL($avatarurl,$clientId);
                $aResult[JSON_TAG_EXPERT][] = array(JSON_TAG_EXPERT_ID => $expert[DB_COLUMN_FLD_ID], JSON_TAG_FIRST_NAME => $expert[DB_COLUMN_FLD_FIRST_NAME], JSON_TAG_LAST_NAME => $expert[DB_COLUMN_FLD_LAST_NAME], JSON_TAG_NAME => $expertName, JSON_TAG_AVATAR_LINK => $expert[DB_COLUMN_FLD_AVATAR_URL], JSON_TAG_TITLE => $expert[DB_COLUMN_FLD_TITLE], JSON_TAG_CREATED_DATE => $expert[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $expert[DB_COLUMN_FLD_MODIFIED_DATE]); //array(JSON_TAG_FIRST_NAME => $firstname, JSON_TAG_LAST_NAME => $lastname,JSON_TAG_NAME => $expertName,JSON_TAG_AVATAR_LINK => $expertAvatar, JSON_TAG_TITLE => $fldtitle,JSON_TAG_CREATED_DATE=> $createddate,JSON_TAG_MODIFIED_DATE=> $modifieddate);
            }
            $aResult[JSON_TAG_STATUS] = 0;
            $aResult[JSON_TAG_TYPE]   = JSON_TAG_EXPERTS;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        if($count == 0)
        {
            $aResult[JSON_TAG_STATUS] = 1;
        }

        return $aResult;
    }

    /**
     * Function used to list favorited topics.
     *
     * @param $ConnBean
     * @param $iConsumerid
     *
     * @return array
     */
    public function following_topics_list($ConnBean, $iConsumerid)
    {
        $count   = 0;
        $aResult = array();
        try
        {
            $sQuery = "  SELECT t.fldid,t.fldname,t.fldcreateddate,t.fldmodifieddate FROM tbltopics AS t LEFT JOIN tblfollowtopicsexperts AS f ON t.fldid=f.fldreceiverid WHERE f.fldconsumerid = :consumerid AND f.fldtype=2 AND t.fldisdeleted=0 ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerid", $iConsumerid);
            $bResult = $ConnBean->resultset();
            foreach($bResultas as $topic)
            {
                $count++;
                $aResult[JSON_TAG_TOPIC][] = array(JSON_TAG_ID => $topic[DB_COLUMN_FLD_ID], JSON_TAG_TITLE => $topic[DB_COLUMN_FLD_NAME], JSON_TAG_CREATED_DATE => $topic[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $topic[DB_COLUMN_FLD_MODIFIED_DATE]); //array(JSON_TAG_FIRST_NAME => $firstname, JSON_TAG_LAST_NAME => $lastname,JSON_TAG_NAME => $expertName,JSON_TAG_AVATAR_LINK => $expertAvatar, JSON_TAG_TITLE => $fldtitle,JSON_TAG_CREATED_DATE=> $createddate,JSON_TAG_MODIFIED_DATE=> $modifieddate);
            }
            $aResult[JSON_TAG_STATUS] = 0;
            $aResult[JSON_TAG_TYPE]   = JSON_TAG_TOPICS;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        if($count == 0)
        {
            $aResult[JSON_TAG_STATUS] = 1;
        }

        return $aResult;
    }

    /**
     * Function used to list favorited topics.
     *
     * @param $ConnBean
     * @param $iConsumerid
     *
     * @return array
     */
    public function favourite_topics($ConnBean, $iConsumerid)
    {
        $aResult       = array();
        $fldreceiverid = NULL;

        $sQuery = "SELECT DISTINCT `fldreceiverid` FROM `tblconsumeranalytics` WHERE `fldactionid`=7 AND `fldreceivertype`=2 AND `fldconsumerid` = :consumerid ORDER BY `fldcreateddate` DESC";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":consumerid", $iConsumerid);
        $result = $ConnBean->resultset();
        foreach($result as $topicid)
        {
            $aResult[] = $topicid[DB_COLUMN_FLD_RECEIVER_ID];
        }

        return $aResult;
    }

    /**
     * Function used to list favorited experts.
     *
     * @param $ConnBean
     * @param $iConsumerid
     *
     * @return array
     */
    public function favourite_experts($ConnBean, $iConsumerid)
    {
        $aResult       = array();
        $fldreceiverid = NULL;

        $sQuery = "SELECT DISTINCT `fldreceiverid` FROM `tblconsumeranalytics` WHERE `fldactionid`=8 AND `fldreceivertype`=3 AND `fldconsumerid`= :consumerid ORDER BY `fldcreateddate` DESC";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":consumerid", $iConsumerid);
        $ConnBean->resultset();
        foreach($result as $expertid)
        {
            $aResult[] = $expertid[DB_COLUMN_FLD_RECEIVER_ID];
        }

        return $aResult;
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $inConnBean
     * @param $sToken
     * @param $sNewPassword
     *
     * @return array
     */
    public function forgot_password_reset($inConnBean, $sToken, $sNewPassword,$raw_password=null)
    {
        $aResult = array();
        try
        {
            $Mail   = new CORESendMail();
            $sQuery = "SELECT c.fldid,c.client_id,c.fldemailid,r.fldtstamp FROM tblpasswordreset AS r LEFT JOIN tblconsumers AS c ON r.fldconsumerid = c.fldid WHERE fldtoken= :token  ";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":token", $sToken);
            $result = $inConnBean->single();
            $sConsumerid = $result[DB_COLUMN_FLD_ID];
            $sEmailid    = $result[DB_COLUMN_FLD_EMAIL_ID];
            $Timestamp   = $result[DB_COLUMN_FLD_TIME_STAMP];
            if($inConnBean->rowCount())
            {
                $aResult[JSON_TAG_EMAILID] = $sEmailid;
                
                /*****************************************************************/
                if($raw_password != null) {
                    // Wordpress Password updation
                    $endpoint = '/update-password';
                    $url = JSON_TAG_WP_URL;
                    $url .= $endpoint;                

                    $data = array(
                        'username' => $sEmailid,
                        'password'=> $raw_password
                        );
                    $json_data = $data;

                    $wp_user_id = null;
                    $wp_authenticated= true;
                    $wp_auth = $this->l_curl($url,$json_data);  
                }
                /*****************************************************************/

            
                $sQuery                    = "UPDATE tblconsumers SET fldhashedpassword = :newpassword WHERE fldid = :consumerid";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":newpassword", $sNewPassword);
                $inConnBean->bind_param(":consumerid", $sConsumerid);
                $inConnBean->execute();
                if($inConnBean->rowCount() == 1)
                {
                    $aResult[JSON_TAG_STATUS] = 0;
                    $sQuery                   = "DELETE FROM  tblpasswordreset WHERE fldtoken= :token";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":token", $sToken);
                    $inConnBean->execute();
                }
                else
                {                    
                    $aResult[JSON_TAG_STATUS] = 1;
                }
            }
            else
            {$aResult[JSON_TAG_STATUS] = 1; 
                $sQuery = "SELECT c.fldid,c.client_id,c.fldemailid,r.fldtstamp FROM tblpasswordreset AS r LEFT JOIN tblconsumers AS c ON r.fldconsumerid = c.fldid WHERE fldtoken= :token";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":token", $sToken);
                    $result = $inConnBean->single();
                    if($result){
                          $aResult[JSON_TAG_STATUS] = 3;
                    }else{
                         $aResult[JSON_TAG_STATUS] = 1;
                    }
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $inConnBean
     * @param $sToken
     *
     * @return array
     */
    public function view_reset_password($inConnBean, $sToken)
    {
        $Expiarytime = 60 * 60 * 24;
        $aResult     = array();
        $iTime2      = time();
        try
        {
            $sQuery = "SELECT c.fldemailid,r.fldtstamp FROM tblpasswordreset AS r LEFT JOIN tblconsumers AS c ON r.fldconsumerid=c.fldid WHERE fldtoken = :token";
            $inConnBean->getPreparedStatement($sQuery);
            $inConnBean->bind_param(":token", $sToken);
            $result     = $inConnBean->single();
            $sEmailid   = $result[DB_COLUMN_FLD_EMAIL_ID];
            $sTimestamp = $result[DB_COLUMN_FLD_TIME_STAMP];
            if($result)
            {
                $iTimeDiff = ($iTime2 - $sTimestamp) / $Expiarytime;
                if($iTimeDiff > 1)
                {
                    $iStatus = 3;
                }
                else
                {
                    $iStatus = 0;
                    $aResult = array(
                        JSON_TAG_EMAILID => $sEmailid
                    );
                }
            }
            else
            {
                $iStatus = 1;
            }
        }
        catch(Exception $e)
        {
            $iStatus = 2;
        }

        $aResult[JSON_TAG_STATUS] = $iStatus;

        return $aResult;
    }

    /**
     * Function used to check whether the user is valid or not.
     *
     * @param $consumerId
     *
     * @return int
     */
    public function valid_consumer($consumerId)
    {   
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT COUNT(*) AS consumer_count FROM tblconsumers WHERE fldid = :consumerid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $result = $ConnBean->single();
            $count  = $result[JSON_TAG_CONSUMER_COUNT];
        }
        catch(Exception $e)
        {
            $count = 0;
        }

        return $count;
    }
    
    
    /**
     * Function used to check whether the user is valid or not.
     *
     * @param $consumerId
     *
     * @return int
     */
    public function validConsumerWithClientID($consumerId,$clientId)
    {   
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT COUNT(*) AS consumer_count FROM tblconsumers WHERE fldid = :consumerid AND client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $ConnBean->bind_param(":client_id", $clientId);
            $result = $ConnBean->single();
            $count  = $result[JSON_TAG_CONSUMER_COUNT];
        }
        catch(Exception $e)
        {
            $count = 0;
        }

        return $count;
    }
    public function validateConsumerWithClientID($consumerId,$clientId)
    {   
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT COUNT(*) AS consumer_count FROM tblconsumers WHERE fldid = :consumerid AND client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $consumerId);
            $ConnBean->bind_param(":client_id", $clientId);
            $result = $ConnBean->single();
            $count  = $result[JSON_TAG_CONSUMER_COUNT];
        }
        catch(Exception $e)
        {
            $count = 0;
        }

        return $count;
    }
    
    public function validateClientID($clientId)
    {
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT COUNT(*) AS user_count FROM tbluser WHERE client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":client_id", $clientId);
            $result = $ConnBean->single();
            $count  = $result[JSON_TAG_USER_COUNT];
        }
        catch(Exception $e)
        {
            $count = 0;
        }

        return $count;
    }

        public function getConsumer($ConnBean, $userId)
    {
        try
        {
            $sQuery = "SELECT *  FROM tblconsumers WHERE fldid = :consumerid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $userId);
            $result = $ConnBean->single();
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
         return $result;
    }
    
    public function getPrimaryGroupId($ConnBean, $clientId) {
        try
        {
             $sQuery = "SELECT g.fldid FROM tblgroups g where g.is_primary = 1 and g.client_id = :clientid LIMIT 1 ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':clientid', $clientId);
            $result = $ConnBean->single();
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
        return $result['fldid'];
    }
    
    public function get_member_list($ConnBean, $clientId, $groupId, $search_criteria=null) {
        
        if(!empty($search_criteria)) {
            $search_criteria_string = " AND ( fldfirstname  LIKE '%$search_criteria%' OR fldlastname  LIKE '%$search_criteria%' OR fldemailid  LIKE '%$search_criteria%' )";
        } else {
            $search_criteria_string = '';
        }
        
        try
        {
            $sQuery = "SELECT fldid, fldfirstname, fldlastname, fldemailid FROM tblconsumers WHERE client_id = :clientid and group_id = :groupid ".$search_criteria_string;
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':clientid', $clientId);
            $ConnBean->bind_param(':groupid', $groupId);
            $result = $ConnBean->resultset();
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
        return $result;
    }
    
    public function renew_subscription($inConnBean, $clientId, $expiry_timestamp, $consumerId, $consumer_emailid=null) {        
        $aResult = array();
        $expiry_date = date("Y-m-d H:i:s",$expiry_timestamp); 
        $inConnBean->beginTransaction();
        try
        {
            
            if(!empty($consumer_emailid)) {
                $sQuery = "UPDATE tblconsumers SET subscription_expiry_date = :expiry_date WHERE fldemailid = :consumerEmail and client_id = :clientId";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":expiry_date", $expiry_date);
                $inConnBean->bind_param(":consumerEmail", $consumer_emailid);
                $inConnBean->bind_param(":clientId", $clientId);
                $inConnBean->execute();
            } else {
                $sQuery = "UPDATE tblconsumers SET subscription_expiry_date = :expiry_date WHERE fldid = :consumerid and client_id = :clientId";
                $inConnBean->getPreparedStatement($sQuery);
                $inConnBean->bind_param(":expiry_date", $expiry_date);
                $inConnBean->bind_param(":consumerid", $consumerId);
                $inConnBean->bind_param(":clientId", $clientId);
                $inConnBean->execute();
            }
            
            $inConnBean->commit();
            $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_SUCCESS
                );
        }
        catch(Exception $e)
        {     
            $inConnBean->rollback();
            $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,                    
                    JSON_TAG_DESC   => $e->getMessage()
                );
        }
        
        return $aResult;
    }
    
    public function check_subscription($ConnBean, $iConsumerid)
    {
        $s3bridge = new COREAwsBridge();
        $count    = 0;
        $aResult  = array();
        try
        {            
            $sQuery = "SELECT subscription_expiry_date FROM tblconsumers WHERE fldid = :consumerid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerid", $iConsumerid);
            $result = $ConnBean->single();            
            $subscription_expiry_date       = $result['subscription_expiry_date'];   
            
            $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
            $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT,$subscription_expiry_date_formated);
            
            $expirytime = strtotime($subscription_expiry_date);
            $currenttime = strtotime(date("Y-m-d H:i:s"));
            
            if ($expirytime < $currenttime) { // subscription expired
                $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
                $aResult['subscription_status'] = 0;
//                $aResult['subscription_expiry'] = $subscription_expiry_date;
                $aResult['subscription_expiry'] = $subscription_expiry_date_formated;
                $aResult['subscription_error_message'] = SUBSCRIPTION_EXPIRED_ERROR;
            } else if ($expirytime > $currenttime) {
                $aResult[JSON_TAG_TYPE] = JSON_TAG_SUCCESS;
                $aResult['subscription_status'] = 1;
//                $aResult['subscription_expiry'] = $subscription_expiry_date;
                $aResult['subscription_expiry'] = $subscription_expiry_date_formated;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult['subscription_error_message'] = $e->getMessage();
        }

        return $aResult;
    }
    
    public function l_curl($url,$json_data) {
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, trim($url));
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: $accept_variable"));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);//Setting post data as xml
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;

    }
          
    public function updateWPConsumer($inConnBean, $clientId, $consumer_wpid, $consumer_firstname=null, $consumer_lastname=null, $consumer_emailid=null) {        
        $aResult = array();
        $inConnBean->beginTransaction();
        try
        {
            
            if(!empty($consumer_wpid) && (int)$consumer_wpid > 0) {

                $update_sql = "";
                
                if(!empty($consumer_firstname)) {
                    if(empty($update_sql)) {
                        $update_sql .= " SET fldfirstname = '$consumer_firstname' " ;
                    } else {
                        $update_sql .= ", fldfirstname = '$consumer_firstname' " ;
                    }
                }
                if(!empty($consumer_lastname)) {
                     if(empty($update_sql)) {
                         $update_sql .= " SET fldlastname = '$consumer_lastname' " ;
                     } else {
                         $update_sql .= ", fldlastname = '$consumer_lastname' " ;
                     }                    
                }
                if(!empty($consumer_emailid)) {
                    if(empty($update_sql)) {
                        $update_sql .= " SET fldemailid = '$consumer_emailid' " ;
                    } else {
                        $update_sql .= ", fldemailid = '$consumer_emailid' " ;
                    }                    
                }
                
                if(!empty($update_sql)) {
                    $sQuery = "UPDATE tblconsumers $update_sql WHERE wp_user_id = :consumer_wpid and client_id = :clientId";
                    $inConnBean->getPreparedStatement($sQuery);
                    $inConnBean->bind_param(":consumer_wpid", $consumer_wpid);
                    $inConnBean->bind_param(":clientId", $clientId);
                    $inConnBean->execute();
                }
                $inConnBean->commit();
                $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS
                    );
            } else {
                $aResult[JSON_TAG_CODE] = "Invalid value for Wordpress id";
            }                      
            
        }
        catch(Exception $e)
        {     
            $inConnBean->rollback();
            $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,                    
                    JSON_TAG_DESC   => $e->getMessage()
                );
        }
        
        return $aResult;
    }
    
    public function consumer_profile($ConnBean, $clientId, $iConsumerid) 
    {
        $s3bridge = new COREAwsBridge();
        $count    = 0;
        $aResult  = array();
        try
        {            
            $sQuery = "SELECT * FROM tblconsumers WHERE fldid = :consumerid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerid", $iConsumerid);
            $result = $ConnBean->single();   
            
            $customer_first_name            = $result['fldfirstname'];   
            $customer_last_name             = $result['fldlastname'];   
            $customer_email_id              = $result['fldemailid'];   
            $subscription_expiry_date       = $result['subscription_expiry_date'];   
            $total_time_spent_life_time_in_sec       = $result['total_time_spent_life_time_in_sec'];   
            
            $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
            $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT,$subscription_expiry_date_formated);
            
            $expirytime = strtotime($subscription_expiry_date);
            $currenttime = strtotime(date("Y-m-d H:i:s"));
            
            if ($expirytime < $currenttime) { // subscription expired
                $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
                $aResult['subscription_status'] = 0;
//                $aResult['subscription_expiry'] = $subscription_expiry_date;
                $aResult['subscription_expiry_date'] = $subscription_expiry_date_formated;
                $aResult['subscription_error_message'] = SUBSCRIPTION_EXPIRED_ERROR;
            } else if ($expirytime > $currenttime) {
                $aResult[JSON_TAG_TYPE] = JSON_TAG_SUCCESS;
                $aResult['subscription_status'] = 1;
//                $aResult['subscription_expiry'] = $subscription_expiry_date;
                $aResult['subscription_expiry_date'] = $subscription_expiry_date_formated;
            }
            
            $aResult[JSON_TAG_FIR_NAME] = $customer_first_name;
            $aResult[JSON_TAG_LA_NAME]  = $customer_last_name;
            $aResult[JSON_TAG_EMAIL]   = $customer_email_id;
            
            $expertDM = new COREExpertDB();
            $total_experts_counts = $expertDM->getTotalExpertsCount($ConnBean,$clientId);
            $aResult['total_experts_counts'] = $total_experts_counts;
            
            $topicDM = new CORETopicDB();
            $total_topics_counts = $topicDM->getTotalTopicsCount($ConnBean,$clientId);
//            $aResult['total_topics_counts'] = $total_topics_counts;
            
            $insightDM = new COREInsightDB();
            $total_insights_counts = $insightDM->getTotalInsightsCount($ConnBean,$clientId);
            $aResult['total_insights_counts'] = $total_insights_counts;
                
            $PlayListDM = new COREPlayListDB();
            $total_recent_playlist_insights_counts = $PlayListDM->getTotalRecentPlaylistInsightsCount($ConnBean,$iConsumerid);
            $aResult['total_recent_playlist_insights_counts'] = $total_recent_playlist_insights_counts;
            
            $total_favorites_insights_counts = $this->getTotalFavotitesInsightCount($ConnBean, $iConsumerid);
            $aResult['total_favorites_counts'] = $total_favorites_insights_counts;
           
            // total time spent in listening the insight
//            $total_time_spent_data = $this->getTotalTimeSpentForInsightListening($ConnBean, $iConsumerid); 
//            $aResult['total_time_spent'] = $total_time_spent_data['total_time_spent'];
//            $aResult['total_time_spent_milisec'] = $total_time_spent_data['total_time_spent_in_milisec'];//            
            // total time spent in LIFE TIME on app
//            $duration_in_milisec =  $total_time_spent_life_time_in_sec * 1000;                
//            $total_time_spent = $this->convertMilisecIntoHrs($total_time_spent_life_time_in_sec);
//            $aResult['total_time_spent'] = $total_time_spent;
//            $aResult['total_time_spent_milisec'] = $duration_in_milisec;
            $aResult[JSON_TAG_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC] = $total_time_spent_life_time_in_sec;
            
            /////////////////////

        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult['error_message'] = $e->getMessage();
        }

        return $aResult;
    }
    
    protected function getTotalTimeSpentForInsightListening($ConnBean, $iConsumerid) {
         
        $sQuery = "SELECT SUM(time_spent_in_sec) as total_time_in_sec FROM tbllistenedinsights WHERE fldconsumerid = :consumerid ";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":consumerid", $iConsumerid);
        $result = $ConnBean->single();  
   
        $duration_in_sec = $result['total_time_in_sec'];
        $duration_in_milisec =  $duration_in_sec * 1000;
                
        $total_time_spent = $this->convertMilisecIntoHrs($duration_in_sec);
        
        
        $result['total_time_spent_in_milisec'] = $duration_in_milisec;
        $result['total_time_spent'] = $total_time_spent;
        
        //return $total_time_spent;
        return $result;
    
    }
    
    protected function getTotalFavotitesInsightCount($ConnBean, $consumerId) {
        //$sQuery = "SELECT COUNT(*) AS fav_count FROM tblfavourites WHERE fldconsumerid = ? ";
        $sQuery = "select f.fldinsightid as insight_id, i.fldexpertid as expert_id from tblfavourites as f, tblinsights as i where f.fldinsightid = i.fldid and i.fldisdeleted = 0 and i.fldisonline = 1 and f.fldconsumerid = :consumerId order by f.list_order";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param('consumerId', $consumerId);
        $ConnBean->execute();
        $count  = $ConnBean->rowCount();
        return $count;
    }
    
    public function populateUserwiseAllPlaylistsOrderTable($ConnBean, $consumerId, $clientUserId) {
        
        $playListDM = new COREPlayListDB();
        
        // add System playlist data -  Start
        $sQuery1 = "select * from tblplaylists where playlist_created_by_client in( $clientUserId) and consumer_id = :consumerId and status = :status order by list_order, playlist_name asc ";
        $ConnBean->getPreparedStatement($sQuery1);
        $ConnBean->bind_param(":consumerId", 0);
        $ConnBean->bind_param(":status", 1);
        $result1 = $ConnBean->resultset();
        if (!empty($result1)) {
            $count = 0;
            foreach ($result1 as $playList) {
                $playListId = $playList['fldid'];
                $playListName = $playList['playlist_name'];
                $list_order = $playList['list_order'];
                $playListDM->populateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$playListName,$list_order);
            }
        }
        // add System playlist data -  Start
        
        // add My playlist data -  Start
        $sQuery2 = "select p.fldid, p.playlist_name, p.playlist_created_by_client, p.list_order, pl.playlist_id, pl.insight_id, i.fldexpertid as expert_id from tblplaylists p, tblplaylistinsights as pl, tblinsights as i where pl.status = 1 and pl.insight_id = i.fldid and pl.playlist_id = p.fldid  and i.fldisdeleted = 0 and i.fldisonline = 1 and pl.playlist_id in (select fldid from tblplaylists where playlist_created_by_client = 0 and consumer_id = :consumerId and status = :status ) group by pl.playlist_id  order by  p.list_order, p.playlist_name asc";
        $ConnBean->getPreparedStatement($sQuery2);
        $ConnBean->bind_param(":consumerId", $consumerId);
        $ConnBean->bind_param(":status", 1);
        $result2 = $ConnBean->resultset();
        if (!empty($result2)) {
            $count = 0;
            foreach ($result2 as $playList) {
                $playListId = $playList['fldid'];
                $playListName = $playList['playlist_name'];
                $list_order = $playList['list_order'];
                $playListDM->populateUserwiseAllPlaylistsOrderTable($ConnBean,$consumerId,$playListId,$playListName,$list_order);
            }
        }
        // add My playlist data -  Start
        
    }
    
    public function capture_total_time_spent_life_time($ConnBean, $clientId, $consumerId,$total_time_spent_life_time_in_sec) {
        $iResult = array();
        
        try {
            // update the time send in request rom mobile app
            $sQuery = "UPDATE tblconsumers SET total_time_spent_life_time_in_sec = :total_time_spent_life_time_in_sec WHERE fldid = :consumerId and client_id = :clientId";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":total_time_spent_life_time_in_sec", $total_time_spent_life_time_in_sec);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":clientId", $clientId);
            $ConnBean->execute();
            
            // fetch the time from DB and send it in response
            $sQuery = "SELECT total_time_spent_life_time_in_sec FROM tblconsumers WHERE fldid = :consumerId and client_id = :clientId";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerId", $consumerId);
            $ConnBean->bind_param(":clientId", $clientId);
            $result = $ConnBean->single();    

            $iResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                JSON_TAG_CONSUMER_ID => $consumerId,
                JSON_TAG_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC => $result['total_time_spent_life_time_in_sec']
            );            
            
        } catch (Exception $exc) {
            
            $iResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                'message' => "Error Occured - 1908 !!!",
                JSON_TAG_DESC => $exc->getMessage()
            );            
        }
         
        return $iResult;
    }
    
    private function convertMilisecIntoHrs($duration_in_milisec) {
        //return sprintf("%d:%02d", $duration/60, $duration%60);
        $hours = floor($duration_in_milisec / 3600);
        $minutes = floor( ($duration_in_milisec - ($hours * 3600)) / 60);
        $seconds = $duration_in_milisec - ($hours * 3600) - ($minutes * 60);
        
       return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds); 
    }
    
    public function is_otp_validated($ConnBean, $clientId, $sEmail) {
        // update the time send in request rom mobile app
        $sQuery = "select otp_value,is_otp_validated FROM tblconsumers WHERE fldemailid = :emailId and client_id = :clientId";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":emailId", $sEmail);
        $ConnBean->bind_param(":clientId", $clientId);
        $result = $ConnBean->single();
        
        if(empty($result)) {
            $iResult = array(
                'client_match' =>  0,
                JSON_TAG_OTP_VALUE => $result['otp_value'],
                JSON_TAG_IS_OTP_VALIDATED => $result['is_otp_validated']
            );
            
        } else {
            $iResult = array(
                'client_match' =>  1,
                JSON_TAG_OTP_VALUE => $result['otp_value'],
                JSON_TAG_IS_OTP_VALIDATED => $result['is_otp_validated']
            );
        }
        return $iResult;
    }

    public function update_otp_value($ConnBean, $clientId, $sEmail, $otp_value, $is_otp_validated) {
        // update the time send in request rom mobile app
        $sQuery = "UPDATE tblconsumers SET otp_value = :otpValue, is_otp_validated = :isOtpValidated WHERE fldemailid = :emailId and client_id = :clientId";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":otpValue", $otp_value);
        $ConnBean->bind_param(":isOtpValidated", $is_otp_validated);
        $ConnBean->bind_param(":emailId", $sEmail);
        $ConnBean->bind_param(":clientId", $clientId);
        $ConnBean->execute();
    }

}
