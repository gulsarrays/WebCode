<?php

/*
  Project                     : Oriole
  Module                      : Inbox
  File name                   : COREInboxController.php
  Description                 : Controller class for Inbox related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Compassites .
  History                     :
 */

class COREAppAuthorizationController
{

    public function __construct()
    {
    }

    public function appAuthorization()
    {
        $aResult      = array();
        $rResult      = array();
        $GenMethods   = new COREGeneralMethods();
        $app          = \Slim\Slim::getInstance();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        $userId           = $GenMethods->genarateJwtTokenFromHeader($JSONHeaderData);
        $CORException = new COREException();
        if($userId){
            $group=   $GenMethods->getUserGroup($userId);
            $groupId =$group['fldid'];            
        }else{
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_AUTH_ID,TOKEN_DOESNT_MATCH);;
            $app->render($aResult);
        }
        if (!$clientId ) {  
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        }  else {
            
            $this->check_subscription($userId);
            
            $rResult['userId'] = $userId;
            $rResult['groupId'] = $groupId;
            $rResult['clientId'] = $clientId;
            
            $COREAdminDB = new COREAdminDB();
            $clientUserId = $COREAdminDB->getClientUserId($clientId);
            $rResult['clientUserId'] = $clientUserId;
            
            $rResult['audvisorClientId'] = 'audvisor11012017';
            $audvisorClientUserId = $COREAdminDB->getClientUserId($rResult['audvisorClientId']);
            $rResult['audvisorClientUserId'] = $audvisorClientUserId;
            
        }
            
        return $rResult;
    }
    
    public function check_subscription($userId) {

        $app = \Slim\Slim::getInstance();
        $ConsumerModel = new COREConsumerModel();

        $check_subscription = $ConsumerModel->check_subscription($userId);
        if ($check_subscription['subscription_status'] === 0) {
            $subscription_expiry_date = $check_subscription['subscription_expiry'];

            $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
            $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT, $subscription_expiry_date_formated);

            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult['subscription_expiry'] = $check_subscription['subscription_expiry'];
            $aResult['subscription_error_message'] = SUBSCRIPTION_EXPIRED_ERROR;

            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => SUBSCRIPTION_EXPIRED_ERROR_CODE,
                //"subscription_expiry"=> $subscription_expiry_date,
                "subscription_expiry" => $subscription_expiry_date_formated,
                JSON_TAG_DESC => SUBSCRIPTION_EXPIRED_ERROR,
                JSON_TAG_ERRORS => array()
            );

            $app->render($aResult);
            exit;
        }
    }

}

?>