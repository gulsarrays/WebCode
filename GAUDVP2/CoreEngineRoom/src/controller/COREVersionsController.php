<?php

/*
  Project                     : Oriole
  Module                      : Version
  File name                   : COREVersionsController.php
  Description                 : Controller class for App Version related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREVersionsController
{

    public function __construct()
    {
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $platform
     */
    public function latest_version($platform)
    {
        $app           = \Slim\Slim::getInstance();
        $VersionsModel = new COREVersionsModel();
        $aResult       = $VersionsModel->latest_version($platform);
        $app->render($aResult);
    }

    /**
     *  Function to add version.
     */
    public function show_addversion()
    {
        $Request         = \Slim\Slim::getInstance();
        $aResult["Data"] = null;
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREVersionAdd.php', $aResult);
        }
        else
        {
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     *  Function to add version.
     */
    public function add_new_version()
    {
        $aResult       = array();
        $VersionsModel = new COREVersionsModel();
        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $BodyData      = $Request->getBody();
        $aVersionData  = $Generalmethod->decodeJson($BodyData, true);
        $aResult       = $VersionsModel->createVersion($aVersionData);
        $app->render($aResult);
    }

    /**
     *  Function to edit version.
     *
     * @param $versionid
     */
    public function edit_version($versionid)
    {
        $aResult       = array();
        $VersionsModel = new COREVersionsModel();
        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $BodyData      = $Request->getBody();
        $aVersionData  = $Generalmethod->decodeJson($BodyData, true);
        $aResult       = $VersionsModel->edit_version($aVersionData, $versionid);
        $app->render($aResult);
    }

    /**
     *  Function to delete version.
     *
     * @param $versionid
     */
    public function delete_version($versionid)
    {
        $app           = \Slim\Slim::getInstance();
        $VersionsModel = new COREVersionsModel();
        $aResult       = $VersionsModel->delete_version($versionid);
        $app->render($aResult);
    }

    /**
     * Function to list all version.
     *
     * @return mixed
     */
    public function all_versions()
    {
        $Request         = \Slim\Slim::getInstance();
        $VersionsModel   = new COREVersionsModel();
        $aResult["Data"] = $VersionsModel->all_versions();

        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREVersionList.php', $aResult);
        }
        else
        {
            $Request->render('CORECmsLogin.php', $aResult);
        }

        return $aResult;
    }

    /**
     * Function to send bundle version.
     *
     * @param $platform
     * @param $version
     */
    public function send_bundle_version($platform, $version)
    {
        $app           = \Slim\Slim::getInstance();
        $VersionsModel = new COREVersionsModel();
        $aResult       = $VersionsModel->send_bundle_version($platform, $version);
        $app->render($aResult);
    }
}
