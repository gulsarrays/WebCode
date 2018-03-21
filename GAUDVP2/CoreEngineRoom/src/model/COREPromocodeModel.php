<?php

/*
  Project                     : Oriole
  Module                      : Promocode
  File name                   : COREPromocodeModel.php
  Description                 : Model class for Promocode related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREPromocodeModel
 */
class COREPromocodeModel
{

    public function __construct()
    {
    }

    /**
     * Function used to get all promocodes details for cms.
     *
     * @return array
     */
    public function list_all_promocodes()
    {
        $ConnBean    = new COREDbManager();
        $aResult     = array();
        $PromocodeDB = new COREPromocodeDB();
        try
        {
            $aList = $PromocodeDB->list_all_promocodes($ConnBean);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus          = ERRCODE_SERVER_EXCEPTION_GET_PROMOCODE;
                $sErrDescription  = SERVER_EXCEPTION_GET_PROMOCODE;
                $aResult['error'] = $sErrDescription;
            }
            else
            {
                $aResult[JSON_TAG_TYPE]        = JSON_TAG_PROMO_CODE;
                $aResult[JSON_TAG_COUNT]       = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_PROMO_CODES] = $aList[JSON_TAG_RECORDS];
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
     * Function used to create new topic.
     *
     * @param $PromocodetData
     *
     * @return array
     */
    public function createPromocode($aPromocodeData)
    {
        $aResult  = array();
        $ConnBean = new COREDbManager();
        $PromoDB  = new COREPromocodeDB();
        try
        {
            $sPromocode = $aPromocodeData[JSON_TAG_PROMO_CODE];
            $Startdate  = $aPromocodeData[JSON_TAG_START_DATE];
            $Enddate    = $aPromocodeData[JSON_TAG_END_DATE];
            $bResult    = $PromoDB->createPromocode($ConnBean, $sPromocode, $Startdate, $Enddate);
        }
        catch(Exception $e)
        {
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to  update  promocode data in the  database.
     *
     * @param $aPromocodeData
     * @param $promocodeid
     *
     * @return array
     */
    public function edit_promocode($aPromocodeData, $promocodeid)
    {
        $PromoDM  = new COREPromocodeDB();
        $ConnBean = new COREDbManager();
        try
        {
            $sPromocode = $aPromocodeData[JSON_TAG_PROMO_CODE];
            $Startdate  = $aPromocodeData[JSON_TAG_START_DATE];
            $Enddate    = $aPromocodeData[JSON_TAG_END_DATE];
            $aResult    = $PromoDM->edit_promocode($ConnBean, $sPromocode, $Startdate, $Enddate, $promocodeid);
            if($aResult[JSON_TAG_STATUS] == 1)
            {
                $bResult = array(JSON_TAG_STATUS => 0, JSON_TAG_PROMO_CODE => $aResult[JSON_TAG_PROMO_CODE]);
            }
            else
            {
                $bResult = array(JSON_TAG_STATUS => 3);
            }
            $ConnBean = NULL;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        return $bResult;
    }

    /**
     * Function used to delete promocode.
     *
     * @param $Promocodeid
     *
     * @return array
     */
    public function deletePromocode($Promocodeid)
    {
        $ConnBean = new COREDbManager();
        $aList    = array();
        $PromoDB  = new COREPromocodeDB();
        try
        {
            $aList = $PromoDB->deletePromocode($Promocodeid, $ConnBean);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aList;
    }
}

?>
