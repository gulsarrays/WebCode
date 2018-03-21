<?php

/*
  Project                     : Oriole
  Module                      : Version
  File name                   : COREVersionsDB.php
  Description                 : Database class for App Version related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREVersionsDB
{

    public function __construct()
    {
    }

    /**
     * Function used to get latest app version.
     *
     * @param $ConnBean
     * @param $platform
     *
     * @return null
     */
    public function latest_version($ConnBean, $platform)
    {
        $iResult[JSON_TAG_RECORDS] = array();
        try
        {
            $sQuery = "SELECT fldappversion, fldappstoreurl, fldversiondescription, fldbundleversion, fldcreateddate, fldmodifieddate, fldmandatoryupdate FROM tblappversioninfo WHERE fldplatform = :platform ORDER BY fldbundleversion DESC LIMIT 1";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":platform", $platform);
            $result                    = $ConnBean->single();
            $iResult[JSON_TAG_RECORDS] = array(JSON_TAG_TYPE => JSON_TAG_VERSION, JSON_TAG_APP_VERSION => $result[DB_COLUMN_FLD_APPVERSION], JSON_TAG_APP_STORE_URL => $result[DB_COLUMN_FLD_APPSTORE_URL], JSON_TAG_VERSION_DESC => $result[DB_COLUMN_FLD_VERSION_DESCRIPTION], JSON_TAG_BUNDLE_VERSION => $result[DB_COLUMN_FLD_BUNDLE_VERSION], JSON_TAG_CREATED_DATE => $result[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $result[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_MANDATORY_UPDATE => $result[DB_COLUMN_FLD_MANADTORYUPDATE]);
            if(count($iResult) == 0)
            {
                $iResult[JSON_TAG_STATUS] = 3;
                $iResult                  = NULL;
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
     * Function to Create new  version.
     *
     * @param $ConnBean
     * @param $genericversion
     * @param $applicationurl
     * @param $versiondescription
     * @param $bundledversion
     * @param $mandatoryupdate
     * @param $platform
     *
     * @return array
     */
    public function insertVersion($ConnBean, $genericversion, $applicationurl, $versiondescription, $bundledversion, $mandatoryupdate, $platform)
    {
        $aResult = array();
        try
        {
            $sQuery = "INSERT INTO tblappversioninfo (fldappversion,fldappstoreurl,fldversiondescription,fldbundleversion,fldmandatoryupdate,fldplatform,fldcreateddate) VALUES(:genversion,:appurl,:versiondesc,:bundleversion,:mandatoryupdate,:platform,NOW())";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":genversion", $genericversion);
            $ConnBean->bind_param(":appurl", $applicationurl);
            $ConnBean->bind_param(":versiondesc", $versiondescription);
            $ConnBean->bind_param(":bundleversion", $bundledversion);
            $ConnBean->bind_param(":mandatoryupdate", $mandatoryupdate);
            $ConnBean->bind_param(":platform", $platform);
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
     * Function used to edit version.
     *
     * @param $ConnBean
     * @param $genericversion
     * @param $applicationurl
     * @param $versiondescription
     * @param $bundledversion
     * @param $mandatoryupdate
     * @param $versionid
     * @param $platform
     *
     * @return array
     */
    public function edit_version($ConnBean, $genericversion, $applicationurl, $versiondescription, $bundledversion, $mandatoryupdate, $versionid, $platform)
    {

        $aResult = array();
        try
        {
            $sQuery = "UPDATE tblappversioninfo SET fldappversion = :genversion ,fldappstoreurl = :appurl, fldversiondescription = :verdesc, fldbundleversion = :bundleversion, fldmandatoryupdate = :manupdate,fldplatform = :platform WHERE fldid = :versionid ";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":genversion", $genericversion);
            $ConnBean->bind_param(":appurl", $applicationurl);
            $ConnBean->bind_param(":verdesc", $versiondescription);
            $ConnBean->bind_param(":bundleversion", $bundledversion);
            $ConnBean->bind_param(":manupdate", $mandatoryupdate);
            $ConnBean->bind_param(":platform", $platform);
            $ConnBean->bind_param(":versionid", $versionid);
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
     * Function used to delete version.
     *
     * @param $versionid
     * @param $ConnBean
     *
     * @return array
     */
    public function delete_version($versionid, $ConnBean)
    {

        $iResult = array();
        try
        {

            $tQuery = "DELETE FROM tblappversioninfo WHERE fldid  = :versionid ";
            $ConnBean->getPreparedStatement($tQuery);
            $ConnBean->bind_param(":versionid", $versionid);
            $ConnBean->execute();
            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to list all version.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function all_versions($ConnBean)
    {

        $iResult = array();
        try
        {
            $sQuery = "SELECT fldid,fldappversion,fldappstoreurl,fldversiondescription,fldbundleversion,fldmandatoryupdate,fldplatform AS platform FROM tblappversioninfo";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            foreach($result as $version)
            {
                $fldversiondescription       = $version[DB_COLUMN_FLD_VERSION_DESCRIPTION];
                $fldversiondescription       = htmlspecialchars($fldversiondescription, ENT_QUOTES, 'UTF-8');
                $fldversiondescription       = str_replace("\n", '<br />', $fldversiondescription);
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_ID => $version[DB_COLUMN_FLD_ID], JSON_TAG_APP_VERSION => $version[DB_COLUMN_FLD_APPVERSION], JSON_TAG_APP_STORE_URL => $version[DB_COLUMN_FLD_APPSTORE_URL], JSON_TAG_VERSION_DESC => $fldversiondescription, JSON_TAG_BUNDLE_VERSION => $version[DB_COLUMN_FLD_BUNDLE_VERSION], JSON_TAG_MANDATORY_UPDATE => $version[DB_COLUMN_FLD_MANADTORYUPDATE], JSON_TAG_PLATFORM => $version[JSON_TAG_PLATFORM]);
                $iResult[JSON_TAG_STATUS]    = 0;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
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
     * Function used to send bundle version.
     *
     * @param $ConnBean
     * @param $platform
     * @param $version
     *
     * @return null
     */
    public function send_bundle_version($ConnBean, $platform, $version)
    {
        $iResult[JSON_TAG_RECORDS] = array();
        try
        {
            $sQuery = "SELECT fldappversion, fldappstoreurl, fldversiondescription, fldbundleversion, fldcreateddate, fldmodifieddate, fldmandatoryupdate FROM tblappversioninfo WHERE fldbundleversion = :version AND fldplatform = :platform";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":version", $version);
            $ConnBean->bind_param(":platform", $platform);
            $result = $ConnBean->single();

            $iResult[JSON_TAG_RECORDS] = array(JSON_TAG_TYPE => JSON_TAG_VERSION, JSON_TAG_APP_VERSION => $result[DB_COLUMN_FLD_APPVERSION], JSON_TAG_APP_STORE_URL => $result[DB_COLUMN_FLD_APPSTORE_URL], JSON_TAG_VERSION_DESC => $result[JSON_TAG_FLD_VERSION_DESCRIPTION], JSON_TAG_BUNDLE_VERSION => $result[DB_COLUMN_FLD_BUNDLE_VERSION], JSON_TAG_CREATED_DATE => $result[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $result[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_MANDATORY_UPDATE => $result[DB_COLUMN_FLD_MANADTORYUPDATE]);
            if(count($iResult) == 0)
            {
                $iResult[JSON_TAG_STATUS] = 3;
                $iResult                  = NULL;
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
     * Function used to get platform.
     *
     * @param $ConnBean
     * @param $versionid
     *
     * @return mixed
     */
    public function  getPlatform($ConnBean, $versionid)
    {
        $sQuery = "SELECT fldplatform FROM tblappversioninfo WHERE fldid= :versionid";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":versionid", $versionid);
        $result = $ConnBean->single();

        return $result['fldplatform'];
    }
}

?>
