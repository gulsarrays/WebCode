<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREAdminController.php
  Description                 : Controller class for admin related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREAdminController
{

    public function __construct()
    {
    }

    /**
     * Function used to  to render the CMS page.
     *
     * Function used to  to render the CMS page.
     */
    public function getcms()
    {
        $Request          = \Slim\Slim::getInstance();
        $TopicControl     = new CORETopicController();
        $groupControl     = new COREGroupController();
        $playlistControl     = new COREPlayListController();
        $clientId  =$_SESSION[CLIENT_ID];
        $aResult["Data"]  = $TopicControl->all_topics($clientId);
        $ExpertControl    = new COREExpertController();
        $aResult["Data1"] = $ExpertControl->all_Experts($clientId);
        $aResult["groups"] = $groupControl->groups($clientId);
        $aResult["playlists"] = $playlistControl->get_all_play_lists();
       
        if(empty($aResult["groups"]['groups'])) {
            $aResult["groups"] = $groupControl->getDefaultGroup($clientId);
        }

        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREInsightAdd.php', $aResult);
        }
        else
        {
            $aData['please login']         = "INVALID CREDENTIALS";
            $aData['UserName']             = "";
            $aData["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aData);
        }
    }

    /**
     * Function used to Render Expert Registration Page.
     *
     *
     */
    public function expertadd()
    {

        $Request          = \Slim\Slim::getInstance();
        $TopicControl     = new CORETopicController();
        $clientId =  $_SESSION[CLIENT_ID];
        $aResult["Data"]  = $TopicControl->all_topics($clientId);
        $ExpertControl    = new COREExpertController();
        $aResult["Data1"] = $ExpertControl->all_Experts($clientId);

        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREExpertAdd.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to  sign in to CMS.
     *
     */
    public function login()
    {
        $Req           = \Slim\Slim::getInstance();
        $Request       = \Slim\Slim::getInstance()->request();
        $PostData      = $Request->post();
        $AdimModel     = new COREAdminModel();
        $sUserName     = $PostData['txtuserName'];
        $sPassword     = $PostData['txtpassword'];
        $bIsUserExists = $AdimModel->authenticateUser($sUserName, $sPassword);
        $bIsUser = $AdimModel->authenticateUser($sUserName, $sPassword);
        if(!$bIsUser['status'])
        {
            if(isset($_SESSION[APP_SESSION_NAME]))
            {
                unset($_SESSION[APP_SESSION_NAME]);
                unset($_SESSION[CLIENT_ID]);
                unset($_SESSION[COMPANY_NAME]);
            }

            $_SESSION[APP_SESSION_NAME] = $sUserName;
            $_SESSION[CLIENT_ID] = $bIsUser['result']['client_id'];
            $_SESSION[COMPANY_NAME] = $bIsUser['result']['company_name'];
            $_SESSION['client_user_id'] = $bIsUser['result']['client_user_id'];
            $clientId =  $_SESSION[CLIENT_ID];
            $aData['UserName']          = $sUserName;
            $Request                    = \Slim\Slim::getInstance();
            $InsightCtr                 = new COREInsightController();
            $aResult["Data"]            = $InsightCtr->all_insights($clientId);
            $TopicCtr                   = new CORETopicController();
            $aResult["Data1"]           = $TopicCtr->all_topics($clientId);
            $ExpertCtr                  = new COREExpertController();
            $aResult["Data2"]           = $ExpertCtr->all_Experts($clientId);
            $Request->redirect(CMS_BASE_URL_STRING.'dashboard');
        }
        else
        {
            $aData["Data"][JSON_TAG_ERROR] = "INVALID CREDENTIALS";
            $aData['UserName']             = "";
            $Req->render('CORECmsLogin.php', $aData);
        }
    }

    /**
     *  Function used to sign out from CMS.
     */
    public function signout()
    {
        $Request = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            session_destroy();
        }
        $Request->redirect(CMS_BASE_URL_STRING.'signin');
    }

    /**
     *  Function used to render login page.
     */
    public function showsignin()
    {

        $Request = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        { 
            $clientId =  $_SESSION[CLIENT_ID];
            $aResult["Data"]  = $_SESSION[APP_SESSION_NAME];
            $InsightCtr       = new COREInsightController();
            $aResult["Data"]  = $InsightCtr->all_insights($clientId);
            $TopicCtr         = new CORETopicController();
            $aResult["Data1"] = $TopicCtr->all_topics($clientId);
            $ExpertCtr        = new COREExpertController();
            $aResult["Data2"] = $ExpertCtr->all_Experts($clientId);
            $Request->redirect(CMS_BASE_URL_STRING.'dashboard');
        }
        else
        {

            $_SESSION[APP_SESSION_NAME]      = "";
            $aResult["Data"]                 = $_SESSION[APP_SESSION_NAME];
            $aResult["Data"][JSON_TAG_ERROR] = "";
            session_destroy();
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     *  Function used to Get statistics of Experts/Insights/Topics.
     */
    public function getstatistics()
    {

        $Req        = \Slim\Slim::getInstance();
        $AdminModel = new COREAdminModel();
        $aResult    = $AdminModel->getstatistics($_SESSION[CLIENT_ID]);
        $Req->render($aResult);
    }

    /**
     *  Function used to redirect to cms home.
     */
    public function redirect_to_home()
    {
        $app = \Slim\Slim::getInstance();
        $app->redirect(BASE_URL_STRING);
    }

    /**
     *  Function used to Execute APIs in Bulk Manner.
     */
    public function bulk()
    {
        $GenMethods   = new COREGeneralMethods();
        $App          = \Slim\Slim::getInstance();
        $Request      = $App->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $AdminModel = new COREAdminModel();
            $aResult    = $AdminModel->bulk($aPostData);
        }

        $App->render($aResult);
    }

    /**
     *  Function used to  to render the Push notification  page in cms.
     */
    public function push_notification()
    {

        $Request = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $aResult["Data"] = array();
            $Request->render('COREPushnotification.php', $aResult);
        }
        else
        {

            $_SESSION[APP_SESSION_NAME]      = "";
            $aResult["Data"]                 = $_SESSION[APP_SESSION_NAME];
            $aResult["Data"][JSON_TAG_ERROR] = "";
            session_destroy();
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to  to inform the user that the api is unsupported.
     */
    public function unsupported_api()
    {
        $app       = \Slim\Slim::getInstance();
        $aResponse = array(
            JSON_TAG_TYPE => JSON_TAG_ERROR,
            JSON_TAG_CODE => ERRCODE_SERVER_EXCEPTION_UNSUPPORTED_API,
            JSON_TAG_DESC => UNSUPPORTED_API,
        );

        $app->render($aResponse);
    }

    /**
     *  Function used to reset Password of cms.
     */
    public function resetPassword()
    {

        $Genmethods   = new COREGeneralMethods();
        $AdminModel   = new COREAdminModel();
        $App          = \Slim\Slim::getInstance();
        $Request      = $App->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $Genmethods->decodeJson($JSONPostData);

        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {

            $aResult = $AdminModel->resetPassword($aPostData);
        }

        $App->render($aResult);
    }

    /**
     *  Function used to render the page for resetting  Password of cms.
     */
    public function CmsPassword_reset()
    {

        $App = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $aData["Data"]                   = array();
            $aData["Data"][JSON_TAG_USER_ID] = $_SESSION[APP_SESSION_NAME];
            $App->render("CORECmsPassword.php", $aData);
        }
        else
        {

            $aData['UserName'] = "";
            $App->render('CORECmsLogin.php', $aData);
        }
    }

    /**
     * Function used  to get details for admindashboard.
     *
     * @return mixed
     */
    public function adminDashBoard()
    {
        $AdminModel = new COREAdminModel();
        $clientId   = $_SESSION[CLIENT_ID];
        $aResult    = $AdminModel->adminDashBoard($clientId);

        return $aResult;
    }

    /**
     * Function used  render the dash board page.
     */
    public function render_dashBoard()
    {
        $Request = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $aData = $this->adminDashBoard();
//            echo '<pre>'; print_r($aData); exit;
            $Request->render("COREDashBoard.php", $aData);
        }
        else
        {
            $aData["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aData);
        }
    }

    /**
     *  Function used  render the settings  page.
     */
    public function render_settings()
    {
        $Request = \Slim\Slim::getInstance();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $aData[JSON_TAG_DATA] = $this->getgeneralsettings();
            $Request->render("CORESettings.php", $aData);
        }
        else
        {
            $aData["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aData);
        }
    }

    /**
     *  Function used to set General settings value for recommendation engine.
     */
    public function update_generalSettings()
    {
        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $JSONPostData  = $Request->getBody();
        $aPostData     = $Generalmethod->decodeJson($JSONPostData, true);

        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $AdminModel = new COREAdminModel();
            $aResult    = $AdminModel->update_generalSettings($aPostData);
        }

        $app->render($aResult);
    }

    /**
     * Function used to get General settings of recommendation engine.
     *
     * @return array
     */
    public function getgeneralsettings()
    {
        $AdminModel = new COREAdminModel();
        $aResult    = $AdminModel->getgeneralsettings();

        return $aResult;
    }

    /**
     *  Function used to Send push notification messages.
     */
    public function publishBroadcastMessage()
    {
        $App            = \Slim\Slim::getInstance();
        $Request        = $App->request();
        $JSONPostData   = $Request->getBody();
        $GeneralMethods = new COREGeneralMethods();
        $JSONPostData   = $GeneralMethods->decodeJson($JSONPostData);
        try
        {
            $AwsSNSBridge = new COREAwsSNSBridge();
            $AwsSNSBridge->sendPushNotificationToAll(COREAwsSNSBridge::AudvisorBroadcastNotification, $JSONPostData);
        }
        catch(Exception $e)
        {
        }

        $App->render(true);
    }
}

