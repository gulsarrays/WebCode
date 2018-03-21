<?php

/*
  Project                     : Oriole
  Module                      : Expert
  File name                   : COREExpertController.php
  Description                 : Controller class for Expert related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREExpertController
{

    public function __construct()
    {
    }

    /**
     * Function used to get Experts details for cms.
     * @return array
     */
    public function all_Experts($clientId)
    {
        $ExpertModel = new COREExpertModel();
        $aResult     = $ExpertModel->all_Experts($clientId);

        return $aResult;
    }

    /**
     * Function used to get Experts details.
     *
     */
    public function list_all_experts()
    {
        $app          = \Slim\Slim::getInstance();
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
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        } 
        $ExpertModel = new COREExpertModel();
        $aResult     = $ExpertModel->list_all_experts($clientId);
        $app->render($aResult);
    }

    
    public function list_all_audvisor_experts()
    {
        $app          = \Slim\Slim::getInstance();
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
            $aResult = $CORException->customClientIdError(ERRCODE_INVALID_CLIENT_ID,CLIENT_ID_DOESNT_MATCH);
            $app->render($aResult);
        } 
        $clientId = 'audvisor11012017';
        $ExpertModel = new COREExpertModel();
        $aResult     = $ExpertModel->list_all_experts($clientId);
        $app->render($aResult);
    }
    /**
     * Function used to list individual expert details.
     *
     * @param $expertid
     */
    public function get_expertdetails($expertid)
    {
         $app         = \Slim\Slim::getInstance();
         $ExpertModel = new COREExpertModel();
        if(isset($_SESSION[CLIENT_ID])){
           $clientId = $_SESSION[CLIENT_ID];
        }else{
            $Request      = $app->request();
            $JSONHeaderData = $Request->headers;        
            $COREConsumerDB = new COREConsumerDB();
            $GenMethods   = new COREGeneralMethods();
            $CORERequest  = new CORERequest();
            $encodedClientId = $CORERequest->getHeaderAcceptParam($JSONHeaderData);
            $clientId = $GenMethods->decodeClientId($encodedClientId);
        }
        $aResult     = $ExpertModel->get_expertdetails($expertid,$clientId);
        $app->render($aResult);
    }

    /**
     * Function to list individual deleted expert details.
     *
     * @param $iExpertid
     */
    public function get_deleted_expertdetails($iExpertid)
    {
        $app         = \Slim\Slim::getInstance();
        $ExpertModel = new COREExpertModel();
        $aResult     = $ExpertModel->get_deleted_expertdetails($iExpertid);
        $app->render($aResult);
    }

    /**
     * Function used to delete Experts data from database.
     *
     * @param $expertid
     */
    public function deleteExpert($expertid)
    {
        $expertModel = new COREExpertModel();
        $aResult     = $expertModel->deleteExpert($expertid);
        echo $aResult['status'];
    }

    /**
     *  Function used to get all s experts details for rendering editexpert.php'.
     */
    public function viewExperts()
    {
        $Request         = \Slim\Slim::getInstance();
        $AdminModel      = new COREExpertController();
        $clientId        = $_SESSION[CLIENT_ID];
        $aResult["Data"] = $AdminModel->all_Experts($clientId);
        if(isset($_SESSION[APP_SESSION_NAME]))
        {
            $Request->render('COREExpertList.php', $aResult);
        }
        else
        {
            $aResult["Data"][JSON_TAG_ERROR] = "";
            $Request->render('CORECmsLogin.php', $aResult);
        }
    }

    /**
     * Function used to  upload expert images.
     *
     * @param $expert_id
     *
     * @return null
     */
    public function dnd_upload_expert_images($expert_id)
    {
        $app        = \Slim\Slim::getInstance();
        $ExpertDb   = new COREExpertDB();
        $imgnames   = $ExpertDb->get_Expert_images($expert_id);
        
        // for cloudinary images implementation -  Start
        $clientId = $_SESSION['client_id'];
        $preset_folder = $clientId."/expert-avatars/";
        $cloudinary = new CORECloudinary();  
        // for cloudinary images implementation -  End
        
        $sFilenames = null;
        foreach($imgnames as $imagenames)
        {
             // for cloudinary images implementation -  Start
            $ext = pathinfo($imagenames, PATHINFO_EXTENSION);
            $delete_cloudinary_image_public_id = $preset_folder.basename($imagenames,".".$ext);
            $cloudinary->delete_image($delete_cloudinary_image_public_id); // Delete The existing image if exists
            // for cloudinary images implementation -  End
            
            /*
            $sFileinfo       = new SplFileInfo($imagenames);
            $sFile_Extension = $sFileinfo->getExtension();
            $sFile_name      = $sFileinfo->getBasename(".".$sFile_Extension);
            $trimlength      = strlen((string)$expert_id) + 1;
            $name            = substr($sFile_name, $trimlength);
            if(empty($name))
            {
                $sFile_name = "*0";
            }
            else
            {
                $star = isset($name[0]) ? $name[0] : null;
                if($star == "*")
                {
                    $temp = substr($name, 1);
                    $name = empty($temp) ? 0 : $temp;
                }
                $sFile_name = intval($name) + 1;
                $sFile_name = "*".$sFile_name;
            }
            $sFilenames[] = ($sFile_name);
            */
        }
        
        $aImagesToUpload = array();
        $sSeparator      = " ,";
        $iflag           = 0;
        $iFilecount      = 1;
        $sQuery          = null;
        $imagesFolder    = dirname(__FILE__).'/../../../workspace/images';
        if(!file_exists($imagesFolder))
        {
            mkdir($imagesFolder, 0777, true);
        }
        if(isset($_FILES['images']['name']) && !empty($_FILES['images']['name']))
        {
            /*$sFileinfo                      = new SplFileInfo($_FILES['images']['name']);
            $sFile_Extension                = $sFileinfo->getExtension();
            $sFile_name                     = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[JSON_TAG_AVATAR_LINK] = $expert_id."M".$sFilenames[0].".".$sFile_Extension;
            $fileName[0]                    = $expert_id."M".$sFilenames[0].".".$sFile_Extension;
            */
            $fileName[JSON_TAG_AVATAR_LINK] = $_FILES['images']['name'];
            $fileName[0]                    = $_FILES['images']['name'];
            $uploaddir                      = $imagesFolder.'/'.$fileName[0];
            move_uploaded_file($_FILES['images']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldavatarurl= ?";
            $iflag             = 1;

            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[0] = $cloudinary_images_upload_details['image_url'];
            $expertAvatar[0] = $fileName[0];
            // for cloudinary images implementation -  End
        }

        if(isset($_FILES['bioimage']['name']) && !empty($_FILES['bioimage']['name']))
        {
            /*$sFileinfo             = new SplFileInfo($_FILES['bioimage']['name']);
            $sFile_Extension       = $sFileinfo->getExtension();
            $sFile_name            = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[$iFilecount] = $expert_id."B".$sFilenames[1].".".$sFile_Extension;;
            */
            $fileName[$iFilecount] = $_FILES['bioimage']['name'];
            $uploaddir = $imagesFolder.'/'.$fileName[$iFilecount];
            move_uploaded_file($_FILES['bioimage']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldbioimage=?";
            $iflag             = 1;
            
            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[$iFilecount] = $cloudinary_images_upload_details['image_url'];
            $iFilecount++;
            // for cloudinary images implementation -  End
        }

        if(isset($_FILES['thumbnailimage']['name']) && !empty($_FILES['thumbnailimage']['name']))
        {
            /*
            $sFileinfo             = new SplFileInfo($_FILES['thumbnailimage']['name']);
            $sFile_Extension       = $sFileinfo->getExtension();
            $sFile_name            = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[$iFilecount] = $expert_id."T".$sFilenames[2].".".$sFile_Extension;
            */
            $fileName[$iFilecount] = $_FILES['thumbnailimage']['name'];
            $uploaddir             = $imagesFolder.'/'.$fileName[$iFilecount];
            move_uploaded_file($_FILES['thumbnailimage']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldthumbimage=?";
            $iflag             = 1;
            
            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[$iFilecount] = $cloudinary_images_upload_details['image_url'];
            $iFilecount++;
            // for cloudinary images implementation -  End
        }
        if(isset($_FILES['promoimage']['name']) && !empty($_FILES['promoimage']['name']))
        {
            /*
            $sFileinfo             = new SplFileInfo($_FILES['promoimage']['name']);
            $sFile_Extension       = $sFileinfo->getExtension();
            $sFile_name            = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[$iFilecount] = $expert_id."P".$sFilenames[3].".".$sFile_Extension;
            */
            $fileName[$iFilecount] = $_FILES['promoimage']['name'];
            $uploaddir             = $imagesFolder.'/'.$fileName[$iFilecount];
            move_uploaded_file($_FILES['promoimage']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldpromoimage=?";
            $iflag             = 1;
            
            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[$iFilecount] = $cloudinary_images_upload_details['image_url'];
            $iFilecount++;
            // for cloudinary images implementation -  End
        }
        if(isset($_FILES['listviewimage']['name']) && !empty($_FILES['listviewimage']['name']))
        {
            /*$sFileinfo             = new SplFileInfo($_FILES['listviewimage']['name']);
            $sFile_Extension       = $sFileinfo->getExtension();
            $sFile_name            = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[$iFilecount] = $expert_id."L".$sFilenames[4].".".$sFile_Extension;*/
            $fileName[$iFilecount] = $_FILES['listviewimage']['name'];
            $uploaddir             = $imagesFolder.'/'.$fileName[$iFilecount];
            move_uploaded_file($_FILES['listviewimage']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldlistviewimage=?";
            $iflag             = 1;
            
            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[$iFilecount] = $cloudinary_images_upload_details['image_url'];
            $iFilecount++;
            // for cloudinary images implementation -  End
        }
        if(isset($_FILES['fbshareimage']['name']) && !empty($_FILES['fbshareimage']['name']))
        {
            /*$sFileinfo             = new SplFileInfo($_FILES['fbshareimage']['name']);
            $sFile_Extension       = $sFileinfo->getExtension();
            $sFile_name            = $sFileinfo->getBasename(".".$sFile_Extension);
            $fileName[$iFilecount] = $expert_id."F".$sFilenames[5].".".$sFile_Extension;*/
            $fileName[$iFilecount] = $_FILES['fbshareimage']['name'];
            $uploaddir             = $imagesFolder.'/'.$fileName[$iFilecount];
            move_uploaded_file($_FILES['fbshareimage']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
            $sQuery            = $sQuery.$sSeparator[$iflag]." fldfbshareimage=?";
            $iflag             = 1;
            
            // for cloudinary images implementation -  Start
            $image_to_be_upload_path = $uploaddir;
            $cloudinary_images_upload_details = $cloudinary->do_uploads($image_to_be_upload_path,$preset_folder);
            $fileName[$iFilecount] = $cloudinary_images_upload_details['image_url'];
            $iFilecount++;
            // for cloudinary images implementation -  End
        }
        if(!isset($fileName[JSON_TAG_AVATAR_LINK]))
        {
            array_unshift($fileName, null);
        }
        /*if(count($aImagesToUpload))
        {
            $s3Bridge = new COREAwsBridge();
            $s3Bridge->UploadAvatarsToS3($aImagesToUpload);
            $expertAvatar[0] = $s3Bridge->GetS3ExpertAvatarURL($fileName[0]);
        }*/        
        foreach($aImagesToUpload as $image)
        {
            @unlink($image);
        }
        if(!isset($fileName[JSON_TAG_AVATAR_LINK]))
        {
            $expertAvatar[0] = null;
        }
        if(count($aImagesToUpload))
        {
            $expertModel = new COREExpertModel();
            $aResult     = $expertModel->patch_avatar_urls($expert_id, $fileName, $expertAvatar[0], $sQuery);
            $app->render($aResult);
        }
        else
        {
            return null;
        }
    }

    /**
     * Function used to  update  expert data in the  database.
     *
     * @param $expert_id
     */
    public function update_expert_image($expert_id)
    {
        $app             = \Slim\Slim::getInstance();
        $Genmethods      = new COREGeneralMethods();
        $aImagesToUpload = array();
        if(isset($_FILES['images']['name']) && !empty($_FILES['images']['name']))
        {
            $imagesFolder = dirname(__FILE__).'/../../workspace/images';
            if(!file_exists($imagesFolder))
            {
                mkdir($imagesFolder, 0777, true);
            }
            $sFileinfo       = new SplFileInfo($_FILES['images']['name']);
            $sFile_Extension = $sFileinfo->getExtension();
            $sRandomFileName = $Genmethods->random_filename(JSON_TAG_RANDOM_STRING_LENGTH);
            $fileName        = $sRandomFileName."_exp_2x.".$sFile_Extension;

            $uploaddir = $imagesFolder.'/'.$fileName;
            move_uploaded_file($_FILES['images']['tmp_name'], $uploaddir);
            $aImagesToUpload[] = $uploaddir;
        }
        else
        {
            $aResult = array(
                JSON_TAG_CODE => LOGO_UPLOAD_FAIL
            );
        }
        if(count($aImagesToUpload))
        {
            $s3Bridge = new COREAwsBridge();
            $s3Bridge->UploadAvatarsToS3($aImagesToUpload);
            $expertAvatar = $s3Bridge->get_s3_expert_avatar_url($fileName);
        }
        $expertModel = new COREExpertModel();
        $aResult     = $expertModel->patch_avatar_url($expert_id, $fileName, $expertAvatar);
        $app->render($aResult);
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $expertid
     */
    public function edit_expert($expertid)
    {
        $app           = \Slim\Slim::getInstance();
        $Generalmethod = new COREGeneralMethods();
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
            $ExpertModel = new COREExpertModel();
            $aResult     = $ExpertModel->edit_expert($aPostData, $expertid);
        }

        $app->render($aResult);
    }

    /**
     * Function used to create new Expert.
     *
     *
     */
    public function addExpert()
    {
        $app           = \Slim\Slim::getInstance();
        $ExpertModel   = new COREExpertModel();
        $Generalmethod = new COREGeneralMethods();
        $Request       = $app->request();
        $BodyData      = $Request->getBody();
        $clientId = $_SESSION[CLIENT_ID];
        $aExpertData   = $Generalmethod->decodeJson($BodyData, true);
        $aResult       = $ExpertModel->createExpert($aExpertData,$clientId);
        $app->render($aResult);
    }

    /**
     * Function used to  Upload Expert voice over to server.
     *
     * @param $expert_id
     */
    public function upload_expert_voiceover($expert_id)
    {
        $app         = \Slim\Slim::getInstance();
        $createddate = date("YmdHis");
        if(isset($_FILES['expertvoiceover']['name']) && !empty($_FILES['expertvoiceover']['name']))
        {
            $sExpert_VoiceoverFolder = dirname(__FILE__).'/../../../workspace/expert-voiceover';
            if(!file_exists($sExpert_VoiceoverFolder))
            {
                mkdir($sExpert_VoiceoverFolder, 0777, true);
            }

            $fileName  = $expert_id.$createddate.$_FILES['expertvoiceover']['name'];
            $uploaddir = $sExpert_VoiceoverFolder.'/'.$fileName;
            move_uploaded_file($_FILES['expertvoiceover']['tmp_name'], $uploaddir);
        }
        else
        {
            $aResult = array(
                JSON_TAG_CODE => LOGO_UPLOAD_FAIL
            );
        }
        $s3Bridge = new COREAwsBridge();
        $s3Bridge->UploadExpertVoiceOver($uploaddir, $fileName);
        //Delete local file
        unlink($uploaddir);
        $expertModel = new COREExpertModel();
        $aResult     = $expertModel->patch_expert_voiceover_url($expert_id, $fileName);
        $app->render($aResult);
    }

    /**
     * Function used to Re-enable the deleted expert.
     *
     * @param $iExpertid
     */
    public function re_enable_expert($iExpertid)
    {
        $app         = \Slim\Slim::getInstance();
        $ExpertModel = new COREExpertModel();
        $aResult     = $ExpertModel->re_enable_expert($iExpertid);
        $app->render($aResult);
    }

    /**
     * Function used to create new Expert.
     */
    public function reg_new_expert()
    {
        $GenMethods   = new COREGeneralMethods();
        $ExpertModel  = new COREExpertModel();
        $App          = \Slim\Slim::getInstance();
        $Request      = $App->request();
        $JSONPostData = $Request->getBody();
        $aExpertData  = $GenMethods->decodeJson($JSONPostData, true);
        $aResult      = $ExpertModel->reg_new_expert($aExpertData);
        $App->render($aResult);
    }
}

?>
