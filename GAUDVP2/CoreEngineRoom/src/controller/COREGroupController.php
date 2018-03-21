<?php

/*
  Project                     : Oriole
  Module                      : Topic
  File name                   : COREGroupController.php
  Description                 : Controller class for Topic related activities
  Copyright                   : Copyright © 2017, Audvisor Inc.
  History                     :
 */

class COREGroupController
{

    public function __construct()
    {
    }

    /**
     * 
     * 
     */
    
      public function list_grops(){
       
        $app        = \Slim\Slim::getInstance();
        
        $GenMethods   = new COREGeneralMethods();
        $Request      = \Slim\Slim::getInstance()->request();
        $JSONPostData   = $Request->getBody();
        $JSONHeaderData =  $Request->headers;
        $CORERequest   = new CORERequest();
        $COREConsumerDB   = new COREConsumerDB();
        $encodedClientId  = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId         = $GenMethods->decodeClientId($encodedClientId);
        $validateclient = $COREConsumerDB->validateClientID($clientId);
        if (!$clientId || !$validateclient) {
            $CORException = new COREException();
            $aResult  = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);           
        }
        
        
        $topicModel = new COREGroupModel();
        $aResult    = $topicModel->getGroupList($clientId);       
//        $app = \Slim\Slim::getInstance();
        $app->response()->header('Content-Type', 'application/json');
        $app->response()->body(json_encode($aResult));
        $app->stop();
    }
    
    public function  groups($clientId=null){

        $app        = \Slim\Slim::getInstance();
        $topicModel = new COREGroupModel();
        $aResult    = $topicModel->getGroupList($clientId); 
        
//        if(empty($aResult['groups'])) {
//            $aResult    = $topicModel->getDefaultGroup($clientId); 
//        }
        
        return $aResult;
    }
    public function  getDefaultGroup($clientId=null){

        $app        = \Slim\Slim::getInstance();
        $topicModel = new COREGroupModel();
        $aResult    = $topicModel->getDefaultGroup($clientId); 

        return $aResult;
    }
    
        /**
     *  Function used to get all groups details for renderingeditinsight.php'.
     */
    public function viewGroups()
    {
       try{         
            $Request          = \Slim\Slim::getInstance();
            $clientId = $_SESSION[CLIENT_ID];
            $InsightModel     = new COREInsightController();
            $TopicModel       = new CORETopicController();
            $aResult["Data1"] = $TopicModel->all_topics($clientId);
            $ExpertnModel     = new COREExpertController();
            $aResult["Data2"] = $ExpertnModel->all_Experts($clientId);
//            echo '<pre>'; print_r($aResult); exit;
            if(isset($_SESSION[APP_SESSION_NAME]))
            {

                $Request->render('COREInsightList.php', $aResult);
            }
            else
            {
                $aResult["Data"][JSON_TAG_ERROR] = "";
                $Request->render('CORECmsLogin.php', $aResult);
            }
       } catch (Exception $e){
            echo $e->getMessage();
       }
    }
}