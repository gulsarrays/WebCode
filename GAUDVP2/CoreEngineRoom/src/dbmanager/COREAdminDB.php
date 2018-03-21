<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREAdminManagerDB.php
  Description                 : Database class for admin related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREAdminDB
{

    public function __construct()
    {
    }

    /**
     * Function used to Authenticate Admin user.
     *
     * @param $insUserName
     * @param $insPassword
     *
     * @return int
     */
    public function authenticateAdminUser($insUserName, $insPassword)
    {
        $ConnBean = new COREDbManager();
        $iResult  = 0;

        try
        {

            $sQuery = "SELECT count(*) AS usercount FROM tbluser WHERE fldusername LIKE :username AND fldpassword LIKE :pass ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":username", $insUserName);
            $ConnBean->bind_param(":pass", $insPassword);
            $ConnBean->execute();
            $iUserCount = $ConnBean->rowCount();
            if($iUserCount > 0)
            {
                $iResult = 0;
            }
            else
            {
                $iResult = 1;
            }
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $iUserCount;
    }

    /**
     * Function used to Authenticate consumer.
     *
     * @param $insUserName
     * @param $insPassword
     *
     * @return int
     */
    public function authenticateUser($insUserName, $insPassword)
    {

        $ConnBean = new COREDbManager();
        $iResult['status'] = 1;
        try
        {
            //$sQuery = "SELECT fldid as client_user_id,client_id,company_name,fldpassword FROM tbluser WHERE  fldusername LIKE :username AND BINARY  fldpassword LIKE :password ";
            $sQuery = "SELECT fldid as client_user_id,client_id,company_name,fldpassword FROM tbluser WHERE  fldusername LIKE :username ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":username", $insUserName);
//            $ConnBean->bind_param(":password", $insPassword);
            $ConnBean->execute();
            $iUser = $ConnBean->single();
            if($iUser)
            {
                $hash         = $iUser['fldpassword'];                
//                $hashedPassword = password_hash($insPassword, PASSWORD_DEFAULT);
//                echo "encrypted : ".$hashedPassword."<br>";
//                $hash = $hashedPassword;
                
                if(password_verify($insPassword, $hash)) {
                    unset($iUser['fldpassword']);
                    $iResult['result'] = $iUser;
                    $iResult['status'] = 0;
                } 
//                $iResult['result'] = $iUser;
//                $iResult['status'] = 0;
            }
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $iResult;
    }

    /**
     * Function used to get statistics of insights.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function getstatistics($ConnBean,$clientId)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT count(DISTINCT i.fldid) AS insightcount,  count( DISTINCT i.fldexpertid) AS expertcount,count(DISTINCT t.fldtopicid) AS topiccount FROM tblinsights AS i LEFT JOIN tbltopicinsight AS t ON t.fldinsightid=i.fldid WHERE i.fldisonline=1 AND i.fldisdeleted=0  AND i.client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param("client_id", $clientId);
//             i.client_id = :client_id
            $aResult                   = $ConnBean->single();
            /*
            $sQuery = "SELECT  count(ca.fldreceiverid) as listen_count from tblconsumeranalytics ca JOIN tblconsumers c ON  ca.fldconsumerid = c.fldid where ( ( ca.fldactionid =2 AND ca.fldactiondata >= 50 ) OR fldactionid =5) and ca.fldreceivertype=1 AND c.client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param("client_id", $clientId);
            $bResult                   = $ConnBean->single();
            $sQuery = "SELECT (SELECT COUNT(fldactionid) FROM tblconsumeranalytics ca JOIN tblconsumers c ON  ca.fldconsumerid = c.fldid WHERE fldactionid=6 AND c.client_id = :client_id) AS like_count,(SELECT COUNT(fldactionid) FROM tblconsumeranalytics ca  JOIN tblconsumers c ON  ca.fldconsumerid = c.fldid  WHERE fldactionid=1 and fldactiondata=0 AND fldactiondata != '' AND fldactiondata IS NOT NULL  AND c.client_id = :client_id) AS twittershare_count,(SELECT COUNT(fldactionid) FROM tblconsumeranalytics ca  JOIN tblconsumers c ON  ca.fldconsumerid = c.fldid WHERE fldactionid=1 and fldactiondata=1  AND c.client_id = :client_id) AS smsshare_count,(SELECT COUNT(fldactionid) FROM tblconsumeranalytics  ca  JOIN tblconsumers c ON  ca.fldconsumerid = c.fldid WHERE fldactionid=1 and fldactiondata=2 AND c.client_id = :client_id) AS fbshare_count";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param("client_id", $clientId);
            $aCountResult              = $ConnBean->single();
            */
            $iResult[JSON_TAG_RECORDS] = array(
                JSON_TAG_INSIGHT_COUNT => $aResult[JSON_TAG_INSIGHT_COUNT], 
                JSON_TAG_TOPIC_COUNT => $aResult[JSON_TAG_TOPIC_COUNT], 
                JSON_TAG_EXPERT_COUNT => $aResult[JSON_TAG_EXPERT_COUNT]/*,
                JSON_TAG_LISTEN_COUNT=>$bResult[JSON_TAG_LISTEN_COUNT],
                JSON_TAG_LIKE_COUNT=>$aCountResult[JSON_TAG_LIKE_COUNT],
                JSON_TAG_FBSHARE_COUNT=>$aCountResult[JSON_TAG_FBSHARE_COUNT],
                JSON_TAG_SMSSHARE_COUNT=>$aCountResult[JSON_TAG_SMSSHARE_COUNT],
                JSON_TAG_TWITTERSHARE_COUNT=>$aCountResult[JSON_TAG_TWITTERSHARE_COUNT]*/
                    );
            $iResult[JSON_TAG_STATUS]  = 0;
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
     * Function used to Execute APIs in Bulk Manner.
     *
     * @param $sUrl
     * @param $sMethod
     * @param $aRequestBody
     * @param $aRequestHeaders
     *
     * @return array
     */
    public function bulk($sUrl, $sMethod, $aRequestBody, $aRequestHeaders)
    {
        $iResult = array();
        $result  = array();
        $result  = null;
        try
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            if(strcasecmp($sMethod, "POST") == 0)
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $aRequestBody);
                curl_setopt($ch, CURLOPT_POST, 1);
            }
            elseif(strcasecmp($sMethod, "PUT") == 0 || strcasecmp($sMethod, "DELETE") == 0)
            {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $sMethod);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $aRequestBody);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result       = curl_exec($ch);
            $ihttp_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $iResult[JSON_TAG_STATUS]      = 0;
            $iResult[JSON_TAG_RESULT_BODY] = $result;
            $iResult[JSON_TAG_HTTP_STATUS] = $ihttp_status;
        }
        catch(Exception $e)
        {

            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to Check whether the API calling Method is Valid or Not
     *
     * @param $sMethod
     *
     * @return bool
     */
    public function validmethod($sMethod)
    {
        if(strcasecmp($sMethod, "POST") == 0 || strcasecmp($sMethod, "GET") == 0 || strcasecmp($sMethod, "PUT") == 0 || strcasecmp($sMethod, "DELETE") == 0 || strcasecmp($sMethod, "PATCH") == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     *  Function used to reset Password of cms.
     *
     * @param $ConnBean
     * @param $sUserName
     * @param $sNewPassword
     *
     * @return array
     */
    public function resetPassword($ConnBean, $sUserName, $sNewPassword)
    {
        $aResult = array();
        try
        {
            $hashedPassword = password_hash($sNewPassword, PASSWORD_DEFAULT);
            $sQuery = "UPDATE  tbluser SET fldpassword = :passwd WHERE fldusername = :uname";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":passwd", $hashedPassword);
            $ConnBean->bind_param(":uname", $sUserName);
            $ConnBean->execute();
            $aResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }

    /**
     * Function used  to get details for admindashboard.
     *
     * @param $ConnBean
     *
     * @return mixed
     */
    public function adminDashBoard($ConnBean,$clientId)
    {
        try
        {
            $insightDb     = new COREInsightDB();
            $sQueryinsight = "SELECT count(*) insightcount,fldreceiverid insight_id,i.fldname FROM tblinsights i LEFT JOIN tblconsumeranalytics ON i.fldid=fldreceiverid WHERE  i.client_id = :client_id GROUP BY fldreceiverid ORDER BY insightcount DESC  LIMIT 10"; //fldactionid=5 AND fldreceivertype = 1 AND
            $sQueryExpert  = "SELECT sum(insightcount) icount,expert_id,expert_name FROM  (SELECT count(*) insightcount,fldreceiverid insightid,i.fldexpertid AS expert_id, CONCAT(e.fldfirstname,' ',e.fldlastname) AS expert_name FROM tblconsumeranalytics LEFT JOIN tblinsights i ON i.fldid=fldreceiverid LEFT JOIN tblexperts e ON e.fldid=i.fldexpertid WHERE fldactionid=5 AND fldreceivertype = 1 AND e.client_id = :client_id GROUP BY fldreceiverid ORDER BY insightcount DESC   )AS intable  GROUP BY expert_id ORDER BY icount DESC LIMIT 10";
            $getinsightids = "SELECT fldreceiverid insightid FROM tblconsumeranalytics LEFT JOIN tblinsights i ON i.fldid=fldreceiverid WHERE fldactionid=5 AND fldreceivertype = 1 AND i.client_id = :client_id GROUP BY fldreceiverid";
            $ConnBean->getPreparedStatement($getinsightids);
            $ConnBean->bind_param("client_id", $clientId);            
            $insightlist        = $ConnBean->resultset();
            $insightids         = function ($insightdlist)
            {
                return $insightdlist['insightid'];
            };
            $insightid_list     = array_map($insightids, $insightlist);
            $insightsIds        = implode(",", $insightid_list);
            $sQueryTopic        = "select count(*) tcount,t.fldid as topic_id, t.fldname as topic_name from tbltopicinsight ti left join tbltopics t on ti.fldtopicid=t.fldid where ti.fldinsightid in ($insightsIds) AND t.client_id = :client_id group by t.fldid order by tcount desc limit 10";
            $mostListenedWeight = $insightDb->getGeneralSettings($ConnBean);
            $insightWeight      = $mostListenedWeight['fldinsightweighting'] / 100;
            $expertWeight       = $mostListenedWeight['fldexpertweighting'] / 100;
            $ConnBean->getPreparedStatement($sQueryinsight);
            $ConnBean->bind_param("client_id", $clientId);
            $Insights         = $ConnBean->resultset();
            $sQueryTopInsight = "SELECT ((ir.fldrating * $insightWeight) + (e.fldrating *  $expertWeight)) AS static_rating,i.fldid as insight_id, i.fldname insight_name,group_concat(top.fldname ) as topics from `tblinsights` i LEFT JOIN tblinsightreputation AS ir ON i.fldid = ir.fldinsightid LEFT JOIN tblexperts AS e ON i.fldexpertid = e.fldid LEFT JOIN tbltopicinsight AS ti ON i.fldid = ti.fldinsightid left join tbltopics top on top.fldid=ti.fldtopicid WHERE i.fldisdeleted =0 AND i.fldisonline =1 AND i.client_id = :client_id  GROUP BY i.fldid ORDER BY static_rating DESC ";
            $ConnBean->getPreparedStatement($sQueryExpert);
            $ConnBean->bind_param("client_id", $clientId);
            $Experts = $ConnBean->resultset();
            $ConnBean->getPreparedStatement($sQueryTopic);
            $ConnBean->bind_param("client_id", $clientId);
            $Topics = $ConnBean->resultset();
            $ConnBean->getPreparedStatement($sQueryTopInsight);
            $ConnBean->bind_param("client_id", $clientId);
            $Topinsights = $ConnBean->resultset();

            $Alltopicslist = array();

            foreach($Insights as $insight_details)
            {
                $iResult[JSON_TAG_INSIGHTS][] = array(JSON_TAG_INSIGHT_ID => $insight_details[JSON_TAG_INSIGHT_ID], JSON_TAG_INSIGHT_NAME => $insight_details[DB_COLUMN_FLD_NAME]);
            }
            foreach($Experts as $expert_details)
            {
                $iResult[JSON_TAG_EXPERTS][] = array(JSON_TAG_EXPERT_ID => $expert_details[JSON_TAG_EXPERT_ID], JSON_TAG_EXPERT_NAME => $expert_details[JSON_TAG_EXPERT_NAME]);
            }

            foreach($Topics as $topic_details)
            {

                $iResult[JSON_TAG_TOPICS][] = array(JSON_TAG_TOPIC_ID => $topic_details[JSON_TAG_TOPIC_ID], JSON_TAG_TOPIC_NAME => $topic_details[JSON_TAG_TOPIC_NAME]);
            }
            foreach($Topinsights as $topinsightdetails)
            {
                $topicslist = explode(',', $topinsightdetails[JSON_TAG_TOPICS]);
                foreach($topicslist as $topic)
                {

                    if(!in_array($topic, $Alltopicslist))
                    {
                        $Alltopicslist[] = $topic;
                    }
                }
                $iResult[JSON_TAG_TOP_INSIGHTS][] = array(JSON_TAG_INSIGHT_ID => $topinsightdetails[JSON_TAG_INSIGHT_ID], JSON_TAG_INSIGHT_NAME => $topinsightdetails[JSON_TAG_INSIGHT_NAME], JSON_TAG_TOPICS => $topicslist);
            }
            $iResult[JSON_TAG_TOPIC] = $Alltopicslist;

            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            
            $iResult[JSON_TAG_STATUS] = 2;
        }
        $iResult[JSON_TAG_COUNT] = $this->getdashboraddetails($clientId,$insightsIds);
        return $iResult;
    }

    /**
     * Function used  to get details for admindashboard.
     *
     * @return array
     */
    public function getdashboraddetails($clientId,$insightIds)
    {
        $ConnBean = new COREDbManager();
        $sQuery   = "SELECT (SELECT COUNT(fldid) FROM tblinsights WHERE fldisdeleted=0 AND tblinsights.client_id ='".$clientId."') AS insightcount, (SELECT COUNT(fldid) FROM tblexperts WHERE fldisdeleted=0 AND tblexperts.client_id ='".$clientId."') AS expertcount, (SELECT COUNT(fldid) FROM tbltopics WHERE fldisdeleted=0 AND tbltopics.client_id ='".$clientId." ') AS topiccount , (SELECT COUNT(fldid) FROM tblconsumers WHERE tblconsumers.client_id ='".$clientId."') AS user_count, (SELECT COUNT(fldid) FROM tblinsights WHERE fldisdeleted=0 AND fldisonline=1 AND tblinsights.client_id ='".$clientId."') AS live_insightCount, 
       (SELECT COUNT(DISTINCT e.fldid) FROM tblexperts e LEFT JOIN tblinsights i ON i.fldid=e.fldid WHERE i.fldisdeleted=0 AND e.fldisdeleted=0 AND e.client_id ='".$clientId."') AS live_expertCount,(SELECT COUNT(DISTINCT t.fldtopicid)  FROM tblinsights i JOIN tbltopicinsight  t  ON i.fldid=t.fldinsightid JOIN tbltopics tt ON tt.fldid=t.fldtopicid  where  tt.client_id ='".$clientId."') AS live_topicCount, (SELECT COUNT(fldid) FROM tblconsumers WHERE flddevicesignup=1 AND tblconsumers.client_id ='".$clientId."' ) AS device_signup_count ";
        $ConnBean->getPreparedStatement($sQuery);
        $iResult = $ConnBean->single();

        $aResult  = array(JSON_TAG_INSIGHT_COUNT => $iResult[JSON_TAG_INSIGHT_COUNT], JSON_TAG_EXPERT_COUNT => $iResult[JSON_TAG_EXPERT_COUNT], JSON_TAG_TOPIC_COUNT => $iResult[JSON_TAG_TOPIC_COUNT], JSON_TAG_LIVE_INSIGHT_COUNT => $iResult[JSON_TAG_LIVE_INSIGHT_COUNT], JSON_TAG_LIVE_EXPERT_COUNT => $iResult[JSON_TAG_LIVE_EXPERT_COUNT], JSON_TAG_LIVE_TOPIC_COUNT => $iResult[JSON_TAG_LIVE_TOPIC_COUNT], JSON_TAG_USER_COUNT => $iResult[JSON_TAG_USER_COUNT], JSON_TAG_USER_COUNT_DEVICE => $iResult[JSON_TAG_USER_COUNT_DEVICE]);
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to get the details for creating iframe.
     *
     * @param $insightid
     * @param $ConnBean
     *
     * @return mixed
     */
    public function getiframe($insightid, $ConnBean)
    {
        $sQuery = "SELECT i.fldstreamingurl AS streaming_url,e.fldid,concat(e.fldfirstname,' ',e.fldlastname) AS expert_name,e.flds3avatarurl,i.fldname FROM tblinsights i LEFT JOIN tblexperts e ON i.fldexpertid=e.fldid WHERE i.fldid = :insightid";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":insightid", $insightid);
        $result[JSON_TAG_RECORD] = $ConnBean->single();

        return $result;
    }

    /**
     * Function used to gets General settings of recommendation engine.
     *
     * @param $ConnBean
     *
     * @return mixed
     */
    public function getgeneralsettings($ConnBean)
    {
        try
        {
            $sQuery = "SELECT fldsettingsname,fldsettingsvalue FROM tblgeneralsettings";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            foreach($result as $setting)
            {
                $tempresult[$setting[DB_COLUMN_FLD_SETTINGS_NAME]] = $setting[DB_COLUMN_FLD_SETTINGS_VALUE];
            }
            $finalresult[JSON_TAG_STATUS]  = 0;
            $finalresult[JSON_TAG_RECORDS] = $tempresult;
        }
        catch(Exception $e)
        {
            $finalresult[JSON_TAG_STATUS] = 2;
        }

        return $finalresult;
    }

    /**
     * Function  used to set General settings of recommendation engine.
     *
     * @param $ConnBean
     * @param $setting_value
     * @param $setting_name
     *
     * @return array
     */
    public function update_generalSettings($ConnBean, $setting_value, $setting_name)
    {
        $aResult = array();

        try
        {
            $sQuery = "UPDATE tblgeneralsettings SET fldsettingsvalue = :settingsvalue WHERE fldsettingsname = :settingsname";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":settingsvalue", $setting_value);
            $ConnBean->bind_param(":settingsname", $setting_name);
            $aResult[JSON_TAG_STATUS] = $ConnBean->execute();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $aResult[JSON_TAG_STATUS] = 2;
        }

        return $aResult;
    }
    
    public function getClientUserId($clientId)
    {

        $ConnBean = new COREDbManager();
        $tempresult = array();
        try
        {
            $sQuery = "SELECT * FROM tbluser WHERE client_id = :clientId ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":clientId", $clientId);
            $ConnBean->execute();
            $result = $ConnBean->resultset();
            foreach($result as $data)
            {
                $tempresult[] = $data['fldid'];
            }
            $tempresult = implode(',', $tempresult);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $tempresult;
    }
}
