<?php

/*
  Project                     : Oriole
  Module                      : Consumer
  File name                   : COREConsumerController.php
  Description                 : Controller class for Consumer related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREConsumerController
{

    public function __construct()
    {
    }

    /**
     *  Function used to  update  insight data in the  database.
     */
    public function signup()
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData   = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        $validateclient = $COREConsumerDB->validateClientID($clientId);
        $consumerModel = new COREConsumerModel();
        if (!$clientId || !$validateclient) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);           
        }else{
            
           $userCount =  $consumerModel->validateClientAcceptanceCountExpired($clientId);
           
        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else if(!$userCount)
        {
           
            $aResult = array(
                        JSON_TAG_TYPE   => JSON_TAG_ERROR,
                        JSON_TAG_CODE   => ERRCODE_USER_LIMIT_EXCEEDED,
                        JSON_TAG_DESC   => USER_REGISTRATION_LIMIT,
                        JSON_TAG_ERRORS => array()
                    );
        } else if (!empty($_SERVER['HTTP_REFERER']) && trim(strtolower($_SERVER['HTTP_REFERER'])) !== trim(strtolower(JSON_TAG_WP_URL))) {
            $aResult = array(
                        JSON_TAG_TYPE   => JSON_TAG_ERROR,
                        JSON_TAG_CODE   => ERRCODE_TAG_WP_URL_INCORRECT,
                        JSON_TAG_DESC   => JSON_TAG_WP_URL_INCORRECT,
                        JSON_TAG_INCORRECT_WP_URL   => $_SERVER['HTTP_REFERER'],
                        JSON_TAG_ERRORS => array()
                    );
        }
        else
        {
         
            $aResult       = $consumerModel->signup($aPostData,$clientId);
        }

        $app->render($aResult);
    }

    /**
     * Function used to edit consumer details.
     *
     * @param $consumerId
     */
    public function modify_consumer($consumerId)
    {
        $ConnBean     = new COREDbManager();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if($consumerId != 0)
        {
            if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
            {
                $aResult                = $aPostData;
                $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            }
            else
            {
                $consumerModel = new COREConsumerModel();
                $aResult       = $consumerModel->modify_consumer($consumerId, $aPostData, $ConnBean);
            }
        }
        else
        {
            $iStatus           = ERRCODE_INVALID_CONSUMER;
            $sErrorDescription = SERVER_EXCEPTION_INVALID_CONSUMER;
            $aResult           = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        $app->render($aResult);
    }

    /**
     * Function used to modify specific data.
     *
     * @param $consumerId
     */
    public function patch_consumer($consumerId)
    {
        $ConnBean     = new COREDbManager();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if($consumerId != 0)
        {
            if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
            {
                $aResult                = $aPostData;
                $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            }
            else
            {
                $consumerModel = new COREConsumerModel();
                $aResult       = $consumerModel->patch_consumer($consumerId, $aPostData, $ConnBean);
            }
        }
        else
        {
            $iStatus           = ERRCODE_INVALID_CONSUMER;
            $sErrorDescription = SERVER_EXCEPTION_INVALID_CONSUMER;
            $aResult           = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        $app->render($aResult);
    }

    /**
     *  Function used to device signup for users .
     */
    public function device_signup()
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        if (!$clientId) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
           
        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->device_signup($aPostData);
        }

        $app->render($aResult);
    }

    /**
     *  Function used to  sign in users.
     */
    public function signin()
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest    = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        $validateclient = $COREConsumerDB->validateClientID($clientId);
        if (!$clientId || !$validateclient) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
           $app->render($aResult);

        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        
        /// OTP validation Code Start
        
        //{"device_id":12345, "email_id":"gulmohar.s@compassitesinc.com", "notification_id":1, "password": "password", "platform_id": 1,"request_otp":true, "otp_value": "p7IK"}
        if(array_key_exists(JSON_TAG_REQUEST_OTP, $aPostData) && !isset($aPostData[JSON_TAG_TYPE])) {
            $otp_validated = $this->request_opt($aPostData,$clientId);
            if(isset($otp_validated['client_match']) && $otp_validated['client_match'] === 0) {
                $iStatus         = ERRCODE_EMAIL_NOT_FOUND;
                $sErrDescription = JSON_TAG_EMAIL_ID_DOESNT_EXIST;
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    JSON_TAG_CODE   => $iStatus,
                    JSON_TAG_DESC   => $sErrDescription,
                    JSON_TAG_ERRORS => array()
                );
                $app->render($aResult);
                exit;
            }
            
            if($otp_validated['is_otp_validated'] === true) {
            } else {
                $aResult = $otp_validated;
                $app->render($aResult);
                exit;
            }
        } else if(isset($aPostData[JSON_TAG_TYPE]) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR) {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        /// OTP validation Code End
        
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->signin($aPostData,$clientId);
        }

        $app->render($aResult);
    }

    /**
     * Function used to like insights by users.
     *
     * @param $consumerId
     */
    public function favourites_list($consumerId)
    {
        $GenMethods   = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $consumerModel = new COREConsumerModel();
        $Request      = $app->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }                
        if($consumerId != 0)
        {
            $aResult = $consumerModel->favourites_list($consumerId,$clientId);
        }
        else
        {
            $iStatus           = ERRCODE_INVALID_CONSUMER;
            $sErrorDescription = SERVER_EXCEPTION_INVALID_CONSUMER;
            $aResult           = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        $app->render($aResult);
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $consumerId
     */
    public function reset_password($consumerId)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }        
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->reset_password($consumerId, $aPostData);
        }

        $app->render($aResult);
    }

    /**
     *  Function used to reset user password if lost and requested.
     */
    public function forgot_password_reset()
    {
        $GenMethods = new COREGeneralMethods();
        $app = \Slim\Slim::getInstance();
        $Request = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData = $Request->headers;
        $CORERequest = new CORERequest();
        $GenMethods = new COREGeneralMethods();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
//        if (!$clientId) {
//            $CORException = new COREException();
//            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
//            $app->render($aResult);
//        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->forgot_password_reset($aPostData);
        }

        $app->render($aResult);
    }

    /**
     *  Function used to send mail  reset password link.
     */
    public function forgot_password()
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData = $Request->headers;
        $CORERequest = new CORERequest();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $emailId  = $aPostData[JSON_TAG_EMAIL];
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->forgot_password($emailId ,$clientId);
        }

        $app->render($aResult);
    }

    /**
     * Function used to like insights and inserted to database.
     *
     * @param $consumerid
     */
    public function user_like($consumerid)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerid,$clientId);
        if (!$clientId || !$validateConsumer) {
        $CORException = new COREException();
        $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
        $app->render($aResult);

        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = 'Invalid JSON data';
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->user_like($aPostData, $consumerid);
        }

        $app->render($aResult);
    }

    /**
     * Function used to unlike insights and data will be removed  from database.
     *
     * @param $consumerid
     * @param $favid
     */
    public function user_unlike($consumerid, $favid)
    {
        $app           = \Slim\Slim::getInstance();
        
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $GenMethods   = new COREGeneralMethods();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerid,$clientId);
        if (!$clientId || !$validateConsumer) {
        $CORException = new COREException();
        $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
        $app->render($aResult);

        }
        $consumerModel = new COREConsumerModel();
        $aResult       = $consumerModel->user_unlike($consumerid, $favid);

        $app->render($aResult);
    }

    /**
     * Function used to record consumer analytics like percentage of skipped, shared, played etc stored into the database.
     *
     * @param $consumerid
     */
    public function consumer_analytics($consumerid)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);  
            if($userId){
              $userData=   $GenMethods->getUserGroup($userId);
            }
       
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerid,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->consumer_analytics($aPostData, $consumerid);
        }

        $app->render($aResult);
    }

    /**
     * Function used to display consumer analytics in cms.
     */
    public function get_useractions()
    {
        $Req             = \Slim\Slim::getInstance();
        $aResult["Data"] = array();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Req->render('COREUserActions.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Req->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to display consumer list in cms.
     */
    public function get_consumers_list()
    {
        $Req             = \Slim\Slim::getInstance();
        $aResult["Data"] = array();
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Req->render('COREConsumerList.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Req->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @param $consumerid
     */
    public function userfollow($consumerid)
    {
        $GenMethods    = new COREGeneralMethods();
        $consumerModel = new COREConsumerModel();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $JSONPostData  = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerid,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aPostData     = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = 'Invalid JSON data';
        }
        $aResult = $consumerModel->user_follow($aPostData, $consumerid);
        $app->render($aResult);
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @param $consumerid
     */
    public function user_unfollow($consumerid)
    {
        $GenMethods    = new COREGeneralMethods();
        $consumerModel = new COREConsumerModel();
        $app           = \Slim\Slim::getInstance();
        $Request       = $app->request();
        $JSONPostData  = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);      
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerid,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aPostData     = $GenMethods->decodeJson($JSONPostData);
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
            $aResult[JSON_TAG_DESC] = 'Invalid JSON data';
        }
        else
        {
            $aResult = $consumerModel->user_unfollow($aPostData, $consumerid, $aPostData[JSON_TAG_RECEIVER_ID]);
        }
        $app->render($aResult);
    }

    /**
     * Function used to list favorited experts.
     *
     * @param $iConsumerId
     */
    public function following_experts_list($iConsumerId)
    {
        $app           = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();
        $Request       = $app->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $GenMethods    = new COREGeneralMethods();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($iConsumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aResult       = $ConsumerModel->following_experts_list($iConsumerId,$clientId);
        $app->render($aResult);
    }

    /**
     * Function used to list favorited topics.
     *
     * @param $iConsumerId
     */
    public function following_topics_list($iConsumerId)
    {
        $app           = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();
        $Request       = $app->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $GenMethods    = new COREGeneralMethods();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($iConsumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aResult       = $ConsumerModel->following_topics_list($iConsumerId);
        $app->render($aResult);
    }

    /**
     *  Function used render the reset password page.
     */
    public function view_reset_password()
    {
        $ConsumerModel          = new COREConsumerModel();
        $App                    = \Slim\Slim::getInstance();
        $Request                = \Slim\Slim::getInstance()->request();
        $sToken                 = $Request->get('t');
        $aResult[JSON_TAG_DATA] = $ConsumerModel->view_reset_password($sToken);
        $App->render('COREForgotPassword.php', $aResult);
    }

    /**
     * Function used to create buckets with respect to clientid.
     *
     * @param $clientId
     */
    public function createBuckets($clientId)
    {
        $app           = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();
        $awsbridge = new COREAwsBridge();
        $awsbridge->createBuckets($clientId);
    }
    
    public function update_password() {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONPostData = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);  
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
                
        if(array_key_exists(JSON_TAG_CONSUMER_ID, $aPostData) && !empty($aPostData[JSON_TAG_CONSUMER_ID])) {
            $consumerId = $aPostData[JSON_TAG_CONSUMER_ID];
            $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($consumerId,$clientId);
            if (!$clientId || !$validateConsumer) {
                $CORException = new COREException();
                $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
                //$app->render($aResult);
            }        
        }
        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {
            $consumerModel = new COREConsumerModel();
            $aResult       = $consumerModel->update_password($aPostData);
        }

        $app->render($aResult);
    }
    /*
     * API : /consumers/[consumerId]/renewsubscription
     * Request : {"expiry_timestamp":"1505563966","consumer_emailid":"gcommong@gmail.com"}
     * Type : POST
     */
    public function renew_subscription($consumerId)
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        
        $CORERequest   = new CORERequest();
        $JSONHeaderData   = $Request->headers;
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        
        if (!$clientId ) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }
        
        if(!$consumerId && !array_key_exists('consumer_emailid', $aPostData)) {            
            $aResult[JSON_TAG_CODE] = "Invalid key for email id";
            $app->render($aResult);
        }

        $consumerModel = new COREConsumerModel();
        $aResult       = $consumerModel->renew_subscription($clientId, $consumerId, $aPostData);

        $app->render($aResult);
    }
    /*
     * API : /consumers/[consumerId]/checksubscription
     * Method: GET
     */
    public function check_subscription($iConsumerId) {
        
        $app           = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();
        $Request       = $app->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $GenMethods    = new COREGeneralMethods();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($iConsumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aResult       = $ConsumerModel->check_subscription($iConsumerId);
        $app->render($aResult);
    }
    
        /*
     * API : /consumers/updateWPConsumer
     * Request : {"consumer_firstname":"First Name","consumer_lastname":"Last Name","consumer_emailid":"gcommong@gmail.com","consumer_wpid":"11"}
     * Type : POST
     */
    public function updateWPConsumer()
    {
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData = $Request->getBody();
        
        $CORERequest   = new CORERequest();
        $JSONHeaderData   = $Request->headers;
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        
        if (!$clientId ) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        }
        
        if(!array_key_exists('consumer_wpid', $aPostData)) {            
            $aResult[JSON_TAG_CODE] = "Invalid key for Wordpress id";
            $app->render($aResult);
        }

        $consumerModel = new COREConsumerModel();
        $aResult       = $consumerModel->updateWPConsumer($clientId, $aPostData);

        $app->render($aResult);
    }
    
    /*
     * API : /consumers/[consumerId]/consumerprofile
     * Method: GET
     */
    public function consumer_profile($iConsumerId) {
        
        $app           = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();
        $Request       = $app->request();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $GenMethods    = new COREGeneralMethods();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);        
        $validateConsumer = $COREConsumerDB->validateConsumerWithClientID($iConsumerId,$clientId);
        if (!$clientId || !$validateConsumer) {
           $CORException = new COREException();
           $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
           $app->render($aResult);

        }
        $aResult       = $ConsumerModel->consumer_profile($clientId,$iConsumerId);
        $app->render($aResult);
    }

    /*
     * API : /consumers/[consumerId]/capturetotaltimespentlifetime
     * Method : post
     * Request Header : 
     *      Accept = Yml6am91cm5hbHM=
     *      Authorization = 
     * Request Body : 
     * {"total_time_spent_life_time_in_sec":1000}
     */
    public function capture_total_time_spent_life_time($iConsumerId) {
        $aResult      = array();
        $AppAuthorization   = new COREAppAuthorizationController();
        $AppAuthorizationDetails = $AppAuthorization->appAuthorization();
        if(!empty($AppAuthorizationDetails)) {
            $app          = \Slim\Slim::getInstance();            
            $Request      = $app->request();
            $JSONPostData = $Request->getBody();            
            $GenMethods   = new COREGeneralMethods();
            $aPostData    = $GenMethods->decodeJson($JSONPostData);             
            if(!array_key_exists(JSON_TAG_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC, $aPostData)) {
                $aResult[JSON_TAG_CODE] = INVALID_KEY_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC;
                $app->render($aResult);
            } else {
                $total_time_spent_life_time_in_sec = $aPostData[JSON_TAG_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC];
            }
            $clientId = $AppAuthorizationDetails['clientId'];
            $ConsumerModel = new COREConsumerModel();
            
            $aResult       = $ConsumerModel->capture_total_time_spent_life_time($clientId,$iConsumerId,$total_time_spent_life_time_in_sec);
        }
        
        $app->render($aResult);
    }
    
    private function request_opt($aPostData, $clientId) {

        $consumerModel = new COREConsumerModel();
        $aResult = $consumerModel->request_opt($aPostData, $clientId);

        return $aResult;
    }

}
