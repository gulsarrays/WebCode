<?php

/*
  Project                     : Oriole
  Module                      : Version
  File name                   : COREVersionsModel.php
  Description                 : Model class for App Version related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREVersionsModel
 */
class COREVersionsModel
{
    const MAX_PLATFORM = 3;

    public function __construct()
    {
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $platform
     *
     * @return array|mixed
     */
    public function latest_version($platform)
    {
        $iStatus         = 0;
        $sErrDescription = NULL;
        $aResult         = null;

        $redis = CORERedisConnection::getRedisInstance();
        if($redis)
        {
            $cacheKey = $this->getCacheKey($platform);
            $aResult  = $this->getCachedData($redis, $cacheKey);
        }

        if($aResult == null)
        {
            $ConnBean   = new COREDbManager();
            $versionsDB = new COREVersionsDB();

            if($platform > 0 && $platform <= self::MAX_PLATFORM)
            {
                $aList = $versionsDB->latest_version($ConnBean, $platform);
                if($aList[JSON_TAG_STATUS] == 1)
                {
                    $iStatus         = ERRCODE_SERVER_EXCEPTION_STATION_TYPE;
                    $sErrDescription = SERVER_EXCEPTION_WRONG_STATION;
                }
                else
                {
                    if($aList[JSON_TAG_STATUS] == 2)
                    {
                        $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                        $sErrDescription = UNKNOWN_ERROR;
                    }
                    else
                    {
                        if($aList[JSON_TAG_STATUS] == 3 || $aList[JSON_TAG_STATUS] == 4)
                        {
                            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                            $sErrDescription = UNKNOWN_ERROR;
                        }
                    }
                }

                if($aList[JSON_TAG_STATUS] != 0)
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_ERROR,
                        JSON_TAG_CODE => $iStatus,
                        JSON_TAG_DESC => $sErrDescription,
                    );
                }
                else
                {
                    $aResult = $aList[JSON_TAG_RECORDS];
                    if($redis)
                    {
                        $redis->set($cacheKey, json_encode($aResult));
                    }
                }
            }
            else
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => ERRCODE_INVALID_PLATFORM,
                    JSON_TAG_DESC => INVALID_PLATFORM_ID,
                );
            }
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used  to add version.
     *
     * @param $aVersionData
     *
     * @return array
     */
    public function createVersion($aVersionData)
    {
        $bResult    = array();
        $ConnBean   = new COREDbManager();
        $versionsDB = new COREVersionsDB();
        $redis      = CORERedisConnection::getRedisInstance();
        try
        {
            $genericversion     = $aVersionData[JSON_TAG_APP_VERSION];
            $applicationurl     = $aVersionData[JSON_TAG_APP_STORE_URL];
            $versiondescription = $aVersionData[JSON_TAG_VERSION_DESC];
            $bundledversion     = $aVersionData[JSON_TAG_BUNDLE_VERSION];
            $mandatoryupdate    = $aVersionData[JSON_TAG_MANDATORY_UPDATE];
            $platform           = $aVersionData[JSON_TAG_PLATFORM];
            $bResult            = $versionsDB->insertVersion($ConnBean, $genericversion, $applicationurl, $versiondescription, $bundledversion, $mandatoryupdate, $platform);

            if($redis && $bResult[JSON_TAG_STATUS] == 0)
            {
                $this->deleteCache($redis, $platform);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used  to edit version.
     *
     * @param $aVersionData
     * @param $versionid
     *
     * @return array
     */
    public function edit_version($aVersionData, $versionid)
    {
        $bResult    = array();
        $ConnBean   = new COREDbManager();
        $versionsDB = new COREVersionsDB();
        $redis      = CORERedisConnection::getRedisInstance();

        try
        {
            $genericversion     = $aVersionData[JSON_TAG_APP_VERSION];
            $applicationurl     = $aVersionData[JSON_TAG_APP_STORE_URL];
            $versiondescription = $aVersionData[JSON_TAG_VERSION_DESC];
            $bundledversion     = $aVersionData[JSON_TAG_BUNDLE_VERSION];
            $mandatoryupdate    = $aVersionData[JSON_TAG_MANDATORY_UPDATE];
            $platform           = $aVersionData[JSON_TAG_PLATFORM];
            $bResult            = $versionsDB->edit_version($ConnBean, $genericversion, $applicationurl, $versiondescription, $bundledversion, $mandatoryupdate, $versionid, $platform);

            if($redis && $bResult[JSON_TAG_STATUS] == 0)
            {
                $this->deleteCache($redis, $platform);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to delete version.
     *
     * @param $versionid
     *
     * @return array
     */
    public function delete_version($versionid)
    {
        $ConnBean   = new COREDbManager();
        $aList      = array();
        $versionsDB = new COREVersionsDB();
        $redis      = CORERedisConnection::getRedisInstance();

        try
        {
            $platform = $versionsDB->getPlatform($ConnBean, $versionid);
            $aList    = $versionsDB->delete_version($versionid, $ConnBean);

            if($redis && $aList[JSON_TAG_STATUS] == 0)
            {
                $this->deleteCache($redis, $platform);
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aList;
    }

    /**
     *  Function used  to list all version for cms.
     *
     * @return array
     */
    public function all_versions()
    {
        $aResult    = array();
        $ConnBean   = new COREDbManager();
        $versionsDB = new COREVersionsDB();
        try
        {
            $aList = $versionsDB->all_versions($ConnBean);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                //TODO: Review  this code: $iStatus, $aList appears unused.
                $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_VERSION;
                $sErrDescription = SERVER_EXCEPTION_GET_VERSION;
                $aList['error']  = $sErrDescription;
            }
            else
            {
                $aResult                   = array();
                $aResult[JSON_TAG_TYPE]    = JSON_TAG_VERSION;
                $aResult[JSON_TAG_COUNT]   = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_VERSION] = $aList[JSON_TAG_RECORDS];
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = NULL;

        return $aResult;
    }

    /**
     * Function to send bundle version.
     *
     * @param $platform
     * @param $version
     *
     * @return array
     */
    public function send_bundle_version($platform, $version)
    {
        $aResult         = NULL;
        $iStatus         = 0;
        $sErrDescription = NULL;

        $ConnBean   = new COREDbManager();
        $versionsDB = new COREVersionsDB();
        $aList      = $versionsDB->send_bundle_version($ConnBean, $platform, $version);
        if($aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = ERRCODE_SERVER_EXCEPTION_STATION_TYPE;
            $sErrDescription = SERVER_EXCEPTION_WRONG_STATION;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                if($aList[JSON_TAG_STATUS] == 3 || $aList[JSON_TAG_STATUS] == 4)
                {
                    $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                    $sErrDescription = UNKNOWN_ERROR;
                }
            }
        }

        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => $iStatus,
                JSON_TAG_DESC => $sErrDescription,
            );
        }
        else
        {
            $aResult = $aList[JSON_TAG_RECORDS];
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * @param $platform
     *
     * @return null|string
     */
    private function getCacheKey($platform)
    {
        $cacheKey = null;
        switch($platform)
        {
            case 1:
                $cacheKey = "latest_iOS_Version";
                break;

            case 2:
                $cacheKey = "latest_Android_Version";
                break;

            case 3:
                $cacheKey = "latest_Server_APIVersion";
                break;
        }

        return $cacheKey;
    }

    /**
     * @param $redis Predis\Client
     * @param $cacheKey
     *
     * @return array|mixed
     */
    private function getCachedData($redis, $cacheKey)
    {
        $aResult = array();
        if($redis)
        {
            $aResult = $redis->get($cacheKey);
            $aResult = json_decode($aResult, true);
        }

        return $aResult;
    }

    /**
     * @param $redis Predis\Client
     * @param $platform
     */
    private function deleteCache($redis, $platform)
    {
        $cacheKey = $this->getCacheKey($platform);
        if($redis)
        {
            $redis->del($cacheKey);
        }
    }
}
