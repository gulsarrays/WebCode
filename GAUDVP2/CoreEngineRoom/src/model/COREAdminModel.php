<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREAdminModel.php
  Description                 : Model class for admin related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREAdminModel
 */
class COREAdminModel
{

    public function __construct()
    {
    }

    /**
     * Function used to check username password for admin.
     *
     * @param $inUserName
     * @param $inPassword
     *
     * @return bool
     */
    public function authenticateAdminUser($inUserName, $inPassword)
    {
        $AdminDB = new COREAdminDB();
        $iResult = $AdminDB->authenticateAdminUser($inUserName, $inPassword);
        if($iResult == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Function used to Authenticate consumer.
     *
     * @param $inUserName
     * @param $inPassword
     *
     * @return bool
     */
    public function authenticateUser($inUserName, $inPassword)
    {
        $AdminDB = new COREAdminDB();
        $iResult = $AdminDB->authenticateUser($inUserName, $inPassword);
        return $iResult;
    }

    /**
     * Function used to get statistics of insights.
     *
     * @return array
     */
    public function getstatistics($clientId)
    {

        $aResult  = array();
        $AdminDB  = new COREAdminDB();
        $ConnBean = new COREDbManager();
        try
        {
            $aList = $AdminDB->getstatistics($ConnBean,$clientId);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $aResult[JSON_TAG_TYPE]  = ERRCODE_SERVER_EXCEPTION_GET_STATUS;
                $aResult[JSON_TAG_ERROR] = SERVER_EXCEPTION_GET_STATUS;
            }
            else
            {
                $aResult                              = array();
                $aResult[JSON_TAG_TYPE]               = JSON_TAG_STATISTICS;
                $aResult[JSON_TAG_EXPERT_COUNT]       = $aList[JSON_TAG_RECORDS][JSON_TAG_EXPERT_COUNT];
                $aResult[JSON_TAG_TOPIC_COUNT]        = $aList[JSON_TAG_RECORDS][JSON_TAG_TOPIC_COUNT];
                $aResult[JSON_TAG_INSIGHT_COUNT]      = $aList[JSON_TAG_RECORDS][JSON_TAG_INSIGHT_COUNT];
               /* $aResult[JSON_TAG_LISTEN_COUNT]       = $aList[JSON_TAG_RECORDS][JSON_TAG_LISTEN_COUNT];
                $aResult[JSON_TAG_LIKE_COUNT]         = $aList[JSON_TAG_RECORDS][JSON_TAG_LIKE_COUNT];
                $aResult[JSON_TAG_FBSHARE_COUNT]      = $aList[JSON_TAG_RECORDS][JSON_TAG_FBSHARE_COUNT];
                $aResult[JSON_TAG_SMSSHARE_COUNT]     = $aList[JSON_TAG_RECORDS][JSON_TAG_SMSSHARE_COUNT];
                $aResult[JSON_TAG_TWITTERSHARE_COUNT] = $aList[JSON_TAG_RECORDS][JSON_TAG_TWITTERSHARE_COUNT];
                $aResult[JSON_TAG_TOTALSHARE_COUNT]   = $aList[JSON_TAG_RECORDS][JSON_TAG_SMSSHARE_COUNT]+ $aList[JSON_TAG_RECORDS][JSON_TAG_FBSHARE_COUNT]+$aList[JSON_TAG_RECORDS][JSON_TAG_TWITTERSHARE_COUNT];*/
                
                $aResult[JSON_TAG_LISTEN_COUNT]       = null;
                $aResult[JSON_TAG_LIKE_COUNT]         = null;
                $aResult[JSON_TAG_FBSHARE_COUNT]      = null;
                $aResult[JSON_TAG_SMSSHARE_COUNT]     = null;
                $aResult[JSON_TAG_TWITTERSHARE_COUNT] = null;
                $aResult[JSON_TAG_TOTALSHARE_COUNT]   = null;

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
     * Function used to Execute APIs in Bulk Manner.
     *
     * @param $aPostData
     *
     * @return array
     */
    public function bulk($aPostData)
    {

        $aResult    = array();
        $AdminDb    = new COREAdminDB();
        $Genmethods = new COREGeneralMethods();
        try
        {
            $i = 0;
            foreach($aPostData['requests'] as $aRequestList)
            {
                $sError = null;

                $sUrl            = $aRequestList['url'];
                $sMethod         = $aRequestList['method'];
                $sRequestBody    = $aRequestList['requestbody'];
                $aRequestBody    = json_encode($sRequestBody);
                $aRequestHeaders = $aRequestList['headers'];
                //TODO: $Genmethods->isJSON is undefined.
                $iValidJson   = ($Genmethods->isJSON($aRequestBody));
                $iValidMethod = $AdminDb->validmethod($sMethod);
                if($iValidJson && $iValidMethod)
                {
                    $sResponse            = $AdminDb->bulk($sUrl, $sMethod, $aRequestBody, $aRequestHeaders);
                    $aResult['url_'.$i++] = array(JSON_TAG_RESPONSE_BODY => json_decode($sResponse['resultbody']), JSON_TAG_RESPONSE_STSTUS => $sResponse['httpstatus']);
                }
                else
                {
                    if($iValidJson)
                    {
                        $aResult['url_'.$i++] = array(JSON_TAG_ERROR => INVALID_METHOD);
                    }
                    else
                    {
                        $aResult['url_'.$i++] = array(JSON_TAG_ERROR => INVALID_JSON);
                    }
                }
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $aResult;
    }

    /**
     * Function used to reset Password of cms.
     *
     * @param $PostData
     *
     * @return array
     */
    public function resetPassword($PostData)
    {
        $AdminDb = new COREAdminDB();

        $iStatus         = 0;
        $sErrDescription = NULL;

        $sUserName    = $PostData[JSON_TAG_USER_ID];
        $sPassword    = $PostData[JSON_TAG_OLD_PASSWORD];
        $sNewPassword = $PostData[JSON_TAG_NEW_PASSWORD];
        $iResult      = $AdminDb->authenticateUser($sUserName, $sPassword);

        if(!empty($iResult))
        {
            $ConnBean = new COREDbManager();
            $aList    = $AdminDb->resetPassword($ConnBean, $sUserName, $sNewPassword);
        }
        else
        {
            $aList[JSON_TAG_STATUS] = 3;
            $iStatus                = ERRCODE_PASSWORD_DOESNT_MATCH;
            $sErrDescription        = JSON_TAG_PASSWORD_DOESNT_MATCH;
        }
        if($aList[JSON_TAG_STATUS] == 3)
        {
            $iStatus         = ERRCODE_PASSWORD_DOESNT_MATCH;
            $sErrDescription = JSON_TAG_PASSWORD_DOESNT_MATCH;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
        }
        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        else
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_SUCCESS,
                JSON_TAG_STATUS => $aList[JSON_TAG_STATUS]

            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function  used  to get details for admindashboard.
     *
     * @return mixed
     */
    public function adminDashBoard($clientId)
    {
        $AdminDb  = new COREAdminDB();
        $ConnBean = new COREDbManager();
        $aList    = $AdminDb->adminDashBoard($ConnBean,$clientId);
        if($aList[JSON_TAG_STATUS] == 1)
        {
            $aList[JSON_TAG_STATUS] = 1;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $aList[JSON_TAG_STATUS] = 2;
            }
        }
        $ConnBean = null;

        return $aList;
    }

    /**
     * Function used to get the data for iframe creation.
     *
     * @param $insightid
     *
     * @return mixed
     */
    public function getiframe($insightid)
    {
        $AdminDB  = new COREAdminDB();
        $ConnBean = new COREDbManager();
        $aResult  = $AdminDB->getiframe($insightid, $ConnBean);
        $ConnBean = null;

        return $aResult;
    }

    /**
     *  Function used to gets General settings of recommendation engine.
     *
     * @return array
     */
    public function getgeneralsettings()
    {
        $aSettings = NULL;
        $AdminDB   = new COREAdminDB();
        $ConnBean  = new COREDbManager();
        $aResult   = $AdminDB->getgeneralsettings($ConnBean);
        if($aResult[JSON_TAG_STATUS] != 0)
        {
            $aSettings = array(JSON_TAG_TYPE => JSON_TAG_ERROR);
        }
        else
        {
            $aSettings = $aResult[JSON_TAG_RECORDS];
        }
        $ConnBean = null;

        return $aSettings;
    }

    /**
     *  Function used to update  General settings of recommendation engine.
     *
     * @param $aSettingsData
     *
     * @return array
     */
    public function update_generalSettings($aSettingsData)
    {
        $aResult  = array();
        $ConnBean = new COREDbManager();
        $AdminDB  = new COREAdminDB();
        try
        {
            $setting_value = $aSettingsData[JSON_TAG_SETTINGS_VALUE];
            $setting_name  = $aSettingsData[JSON_TAG_SETTINGS_KEY];
            $aResult       = $AdminDB->update_generalSettings($ConnBean, $setting_value, $setting_name);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $aResult[JSON_TAG_STATUS] = 2;
        }
        $ConnBean = NULL;

        return $aResult;
    }
}

