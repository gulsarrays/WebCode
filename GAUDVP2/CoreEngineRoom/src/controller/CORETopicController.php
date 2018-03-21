<?php

/*
  Project                     : Oriole
  Module                      : Topic
  File name                   : CORETopicController.php
  Description                 : Controller class for Topic related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class CORETopicController
{

    public function __construct()
    {
    }

    /**
     * Function used to get all topics details.
     * @return array
     */
    public function all_topics($clientId)
    {
        $topicModel = new CORETopicModel();
        $aResult    = $topicModel->all_topics($clientId);
        return $aResult;
    }

    /**
     *   Function used to get all topics details.
     */
    public function list_all_topics()
    {
        $app        = \Slim\Slim::getInstance();
        $topicModel = new CORETopicModel();
        $GenMethods   = new COREGeneralMethods();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        if (!$clientId) {
            $CORException = new COREException();
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        } 
        $aResult    = $topicModel->list_all_topics($clientId);
        $app->render($aResult);
    }

    /**
     * Function used to get all topic details.
     *
     * @param $topicid
     *
     * @return mixed
     */
    public function get_topicdetails($topicid)
    {

        $topicModel = new CORETopicModel();
        $aResult    = $topicModel->get_topicdetails($topicid);

        return $aResult;
    }

    /**
     * Function used to  update  topic data in the  database.
     *
     * @param $topicid
     *
     * @return array|mixed
     */
    public function edit_topic($topicid)
    {

        $Generalmethod = new COREGeneralMethods();
        $app           = \Slim\Slim::getInstance();
        $Request       = \Slim\Slim::getInstance()->request();
        $JSONPostData  = $Request->getBody();
        $aPostData     = $Generalmethod->decodeJson($JSONPostData, true);

        if(array_key_exists(JSON_TAG_TYPE, $aPostData) && $aPostData[JSON_TAG_TYPE] == JSON_TAG_ERROR)
        {
            $aResult                = $aPostData;
            $aResult[JSON_TAG_CODE] = ERRCODE_CONSUMER_INVALID_JSON;
        }
        else
        {

            $TopicModel = new CORETopicModel();

            $aResult = $TopicModel->edit_topic($aPostData, $topicid);
            $app->render($aResult);

            return $aResult;
        }
    }

    /**
     *  Function used to get all topics details  for rendering topics.php'.
     */
    public function viewTopics()
    {
        $Request         = \Slim\Slim::getInstance();
        $topicModel      = new CORETopicModel();
        $clientId = $_SESSION['client_id'];
        $aResult["Data"] = $topicModel->all_topics($clientId);
        if(isset($_SESSION[APP_SESSION_NAME]))
        {   
            $Request->render('CORETopicList.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to  upload topic image.
     *
     * @param $topic_id
     */
    public function upload_topic_images($topic_id)
    {
        $app             = \Slim\Slim::getInstance();
        $createddate     = date("YmdHis");
        $aImagesToUpload = array();
        
        $ConnBean = new COREDbManager();
        $topicDM  = new CORETopicDB();
        $cloudinary = new CORECloudinary();
        
        $clientId = $_SESSION['client_id'];
        $preset_folder = $clientId."/topic-icons/";  
        
        if(isset($_FILES['topicimages']['name']) && !empty($_FILES['topicimages']['name']))
        {
            $imagesFolder = dirname(__FILE__).'/../../../workspace/topic_images';
            if(!file_exists($imagesFolder))
            {
                mkdir($imagesFolder, 0777, true);
            }

            $sFileinfo       = new SplFileInfo($_FILES['topicimages']['name']);
            $sFile_Extension = $sFileinfo->getExtension();
            $sFile_name      = $sFileinfo->getBasename(".".$sFile_Extension);

            $fileName[0] = $topic_id.$createddate.$sFile_name."_ios_2x.".$sFile_Extension;
            $uploaddir   = $imagesFolder.'/'.$fileName[0];
            move_uploaded_file($_FILES['topicimages']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            
            // for cloudinary images implementation -  Start 
            $topicdetails = $topicDM->get_topicdetails($topic_id, $ConnBean);
            if(!empty($topicdetails['record']) && !empty($topicdetails['record']['topic_icon'])) {
                $ext = pathinfo($topicdetails['record']['topic_icon'], PATHINFO_EXTENSION);
                $delete_cloudinary_image_public_id = $preset_folder.basename($topicdetails['record']['topic_icon'],".".$ext);
                $cloudinary->delete_image($delete_cloudinary_image_public_id); // Delete The existing image if exists
            } 
            // for cloudinary images implementation -  End  
            
        }
        else
        {
            $aResult = array(
                JSON_TAG_CODE => LOGO_UPLOAD_FAIL
            );
            $app->render($aResult);
        }
        
        // for cloudinary images implementation -  Start    
        $image_to_be_upload_path = $uploaddir;
        $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
        $fileName = $cloudinary_images_upload_details['image_url'];
        $cloudinary_public_id = $cloudinary_images_upload_details['public_id'];
        $cloudinary_version = $cloudinary_images_upload_details['version'];    
        // for cloudinary images implementation -  End

        /*if(count($aImagesToUpload))
        {
            $s3Bridge = new COREAwsBridge();
            $s3Bridge->UploadTopicIconsToS3($aImagesToUpload);
        }*/
        unlink($uploaddir);
        $topicModel = new CORETopicModel();
        $topicModel->patch_avatar_urls($topic_id, $fileName);
    }

    /**
     *  Function used to render topic registration form.
     */
    public function showaddTopic()
    {

        $Request = \Slim\Slim::getInstance();

        $AdminModel      = new CORETopicController();
        $clientId = $_SESSION['client_id'];
        $aResult["Data"] = $AdminModel->all_topics($clientId);
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('CORETopicAdd.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     *  Function used to create new Topic.
     */
    public function addTopic()
    {
        $app           = \Slim\Slim::getInstance();
        $TopictModel   = new CORETopicModel();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $clientId = $_SESSION[CLIENT_ID];
        $BodyData   = $Request->getBody();
        $aTopicData = $Generalmethod->decodeJson($BodyData, true);
        $aResult    = $TopictModel->createTopic($aTopicData,$clientId);
        $app->render($aResult);
    }

    /**
     * Function used to delete Topic.
     *
     * @param $topicid
     */
    public function deleteTopic($topicid)
    {
        $topicModel = new CORETopicModel();
        $aResult    = $topicModel->deleteTopic($topicid);
        echo $aResult['status'];
    }
    
    
    public function list_all_audvisor_topics()
    {
        $app        = \Slim\Slim::getInstance();
        $topicModel = new CORETopicModel();
        $GenMethods   = new COREGeneralMethods();
        $Request      = $app->request();
        $JSONHeaderData = $Request->headers;
        $JSONPostData = $Request->getBody();
        $aPostData    = $GenMethods->decodeJson($JSONPostData);
        $CORERequest  = new CORERequest();
        $COREConsumerDB = new COREConsumerDB();
        $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
        $clientId = $GenMethods->decodeClientId($encodedClientId);
        if (!$clientId) {
            $CORException = new COREException();
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);;
            $app->render($aResult);
        } 
        $clientId = 'audvisor11012017';
        $aResult    = $topicModel->list_all_topics($clientId);
        $app->render($aResult);
    }
}

?>