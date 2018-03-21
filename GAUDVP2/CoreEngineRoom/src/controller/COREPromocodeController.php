<?php

/*
  Project                     : Oriole
  Module                      : Promocode
  File name                   : COREPromocodeController.php
  Description                 : Controller class for Promocode related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREPromocodeController
{

    public function __construct()
    {
    }

    /**
     * Function used to get all Promocode details.
     * @return array
     */
    public function list_all_promocodes()
    {
        $PromoModel = new COREPromocodeModel();
        $aResult    = $PromoModel->list_all_promocodes();

        return $aResult;
    }

    /**
     * Function used to  update  promocode data in the  database.
     *
     * @param $Promocodeid
     *
     * @return array|mixed
     */
    public function edit_promocode($Promocodeid)
    {

        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = \Slim\Slim::getInstance()->request();
        $JSONPostData  = $Request->getBody();
        $aPostData     = $Generalmethod->decodeJson($JSONPostData, true);

        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_INVALID_JSON;
        }
        else
        {

            $PromocodeModel = new COREPromocodeModel();

            $aResult = $PromocodeModel->edit_promocode($aPostData, $Promocodeid);
            $app->render($aResult);

            return $aResult;
        }
    }

    /**
     *  Function used   for rendering COREPromocodeList.php'.
     */
    public function viewPromocodes()
    {
        $Request         = \Slim\Slim::getInstance();
        $PromoModel      = new COREPromocodeModel();
        $aResult["Data"] = $PromoModel->list_all_promocodes();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREPromocodeList.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     *  Function used to render promocode add form.
     */
    public function showaddPromocode()
    {

        $Request         = \Slim\Slim::getInstance();
        $promoModel      = new COREPromocodeController();
        $aResult["Data"] = $promoModel->list_all_promocodes();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREPromocodeAdd.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     *  Function used to create new Promocode.
     */
    public function addPromocode()
    {
        $app             = \Slim\Slim::getInstance();
        $PromocodetModel = new COREPromocodeModel();
        $Generalmethod   = new COREGeneralMethods();
        $Request         = $app->request();
        $BodyData        = $Request->getBody();
        $aPromocodeData  = $Generalmethod->decodeJson($BodyData, true);
        $aResult         = $PromocodetModel->createPromocode($aPromocodeData);
        $app->render($aResult);
    }

    /**
     * Function used to delete Promocode.
     *
     * @param $Promoid
     */
    public function deletePromocode($Promoid)
    {
        $app        = \Slim\Slim::getInstance();
        $PromoModel = new COREPromocodeModel();
        $aResult    = $PromoModel->deletePromocode($Promoid);
        $app->render($aResult);
    }
}

?>