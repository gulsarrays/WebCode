<?php

/*
  Project                     : Oriole
  Module                      : Expert
  File name                   : COREExpertModel.php
  Description                 : Model class for Expert related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREExpertModel
 */
class COREExpertModel
{

    public function __construct()
    {
    }

    /**
     * Function used to create new Expert.
     *
     * @param $ExpertData
     *
     * @return array
     */
    public function createExpert($ExpertData,$clientId)
    {
        $aResult  = array();
        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();

        try
        {
            $expert_name        = $ExpertData[JSON_TAG_NAME];
            $expert_middlename  = $ExpertData[JSON_TAG_MIDDLE_NAME];
            $expert_lastname    = $ExpertData[JSON_TAG_LAST_NAME];
            $expert_title       = $ExpertData[JSON_TAG_TITLE];
            $sPromotitle        = $ExpertData[JSON_TAG_PROMO_TITLE];
            $expert_description = $ExpertData[JSON_TAG_DESC];
            $iExpert_rating     = $ExpertData[JSON_TAG_RATING];
            $sExpert_prefix     = $ExpertData[JSON_TAG_PREFIX];
            $sTwitter_handle    = $ExpertData[JSON_TAG_TWITTER_HANDLE];
            $bResult            = $expertDM->insertExpert($ConnBean, $expert_name, $expert_title, $expert_middlename, $expert_lastname, $expert_description, $sPromotitle, $iExpert_rating, $sExpert_prefix, $sTwitter_handle,$clientId);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        $ConnBean = NULL;

        return $bResult;
    }

    /**
     * Function used to  fetch all experts details for cms.
     *
     * @return array
     */
    public function all_experts($clientId)
    {
        $aResult    = array();
        $ConsumerDB = new COREExpertDB();
        $ConnBean   = new COREDbManager();;
        try
        {
            $aList = $ConsumerDB->all_experts($ConnBean,$clientId);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_EXPERT;
                $sErrDescription = SERVER_EXCEPTION_GET_EXPERT;
                $aList['error']  = $sErrDescription;
            }
            else
            {
                $aResult                   = array();
                $aResult[JSON_TAG_TYPE]    = JSON_TAG_EXPERTS;
                $aResult[JSON_TAG_COUNT]   = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_EXPERTS] = $aList[JSON_TAG_RECORDS];
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
     * Function used to  fetch all experts details.
     *
     * @return array
     */
    public function list_all_experts($clientId)
    {
        $aResult    = array();
        $ConsumerDB = new COREExpertDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->list_all_experts($ConnBean,$clientId);
            if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                $aResult                   = array();
                $aResult[JSON_TAG_TYPE]    = JSON_TAG_EXPERTS;
                $aResult[JSON_TAG_EXPERTS] = $aList[JSON_TAG_RECORDS];
            }
            if($aList[JSON_TAG_STATUS] != ERRCODE_NO_ERROR)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => $iStatus,
                    JSON_TAG_DESC => $sErrDescription,
                );
            }
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function to list individual expert details.
     *
     * @param $expertid
     *
     * @return array
     */
    public function get_expertdetails($expertid,$clientId)
    {
        
        $ConsumerDB = new COREExpertDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->get_expertdetails($expertid, $ConnBean,$clientId);

            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
                $aList['error']  = $sErrDescription;
            }
            else
            {
                if($aList[JSON_TAG_STATUS] == SERVER_ERRORCODE_INVALID_EXPERT)
                {
                    $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_EXPERT;
                    $sErrDescription = SERVER_EXCEPTION_GET_EXPERT;
                    $aList['error']  = $sErrDescription;
                }
                else
                {
                    $aResult = $aList['record'];
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
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     *  Function used to delete Experts data from database.
     *
     * @param $expertid
     *
     * @return array
     */
    public function deleteExpert($expertid)
    {
        $aList    = array();
        $ConnBean = new COREDbManager();
        $ExpertDB = new COREExpertDB();
        try
        {
            $aList = $ExpertDB->deleteExpert($expertid, $ConnBean);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aList;
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $expertData
     * @param $expertid
     *
     * @return mixed
     */
    public function edit_expert($expertData, $expertid)
    {

        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();

        try
        {
            $expert_name        = $expertData[JSON_TAG_NAME];
            $expert_middlename  = $expertData[JSON_TAG_MIDDLE_NAME];
            $expert_lastname    = $expertData[JSON_TAG_LAST_NAME];
            $expert_title       = $expertData[JSON_TAG_TITLE];
            $expert_description = $expertData[JSON_TAG_DESC];
            $sPromotitle        = $expertData[JSON_TAG_PROMO_TITLE];
            $expert_rating      = $expertData[JSON_TAG_RATING];
            $expert_prefix      = $expertData[JSON_TAG_PREFIX];
            $sTwitter_handle    = $expertData[JSON_TAG_TWITTER_HANDLE];
            $bResult            = $expertDM->edit_expert($ConnBean, $expert_name, $expert_middlename, $expert_lastname, $expertid, $expert_title, $expert_description, $sPromotitle, $expert_rating, $expert_prefix, $sTwitter_handle);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        $ConnBean = NULL;

        return $bResult;
    }

    /**
     * Function used to  update  Expert image URL in the  database.
     *
     * @param $expert_id
     * @param $fileName
     * @param $sExpertAvatar
     *
     * @return bool
     */
    public function patch_avatar_url($expert_id, $fileName, $sExpertAvatar)
    {
        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();

        try
        {
            $bResult = $expertDM->patch_avatar_url($ConnBean, $expert_id, $fileName, $sExpertAvatar);
        }
        catch(Exception $e)
        {
        }

        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to  update  Expert voice-over URL in the  database.
     *
     * @param $expert_id
     * @param $fileName
     *
     * @return mixed
     */
    public function patch_expert_voiceover_url($expert_id, $fileName)
    {
        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();
        try
        {
            $bResult['data'] = $expertDM->patch_expert_voiceover_url($ConnBean, $expert_id, $fileName);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = NULL;

        return $bResult;
    }

    /**
     * Function used to  update  Expert image URL in the  database.
     *
     * @param $expert_id
     * @param $fileName
     * @param $expertAvatar
     * @param $sQuery
     *
     * @return bool
     */
    public function patch_avatar_urls($expert_id, $fileName, $expertAvatar, $sQuery)
    {

        $bResult  = false;
        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();

        try
        {
            $bResult = $expertDM->patch_avatar_urls($ConnBean, $expert_id, $fileName, $expertAvatar, $sQuery);
        }
        catch(Exception $e)
        {
        }

        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function to list individual deleted expert details.
     *
     * @param $expertid
     *
     * @return array
     */
    public function get_deleted_expertdetails($expertid)
    {

        $ConsumerDB = new COREExpertDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->get_deleted_expertdetails($expertid, $ConnBean);

            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
                $aList['error']  = $sErrDescription;
            }
            else
            {
                if($aList[JSON_TAG_STATUS] == 3)
                {
                    $iStatus         = ERRCODE_SERVER_EXCEPTION_GET_EXPERT;
                    $sErrDescription = SERVER_EXCEPTION_GET_EXPERT;
                    $aList['error']  = $sErrDescription;
                }
                else
                {
                    $aResult = $aList['record'];
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
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to create new Expert.
     *
     * @param $ExpertData
     *
     * @return array
     */
    public function reg_new_expert($ExpertData)
    {
        $aResult  = array();
        $ConnBean = new COREDbManager();
        $expertDM = new COREExpertDB();

        try
        {
            $expert_name        = $ExpertData[JSON_TAG_NAME];
            $expert_middlename    = $ExpertData[JSON_TAG_MIDDLE_NAME];
            $expert_lastname    = $ExpertData[JSON_TAG_LAST_NAME];
            $expert_title       = $ExpertData[JSON_TAG_TITLE];
            $sPromotitle        = $ExpertData[JSON_TAG_PROMO_TITLE];
            $expert_description = $ExpertData[JSON_TAG_DESC];
            $bResult            = $expertDM->reg_new_expert($ConnBean, $expert_name, $expert_title,$expert_middlename, $expert_lastname, $expert_description, $sPromotitle);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $bResult[JSON_TAG_STATUS] = 2;
        }

        $ConnBean = NULL;

        return $bResult;
    }

    /**
     *  Function used to Re-enable the deleted expert.
     *
     * @param $iExpertid
     *
     * @return mixed
     */
    public function re_enable_expert($iExpertid)
    {
        $ConnBean = new COREDbManager();
        $ExpertDB = new COREExpertDB();
        try
        {
            $bresult = $ExpertDB->re_enable_expert($ConnBean, $iExpertid);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $bresult;
    }
}

?>
