<?php

/*
  Project                     : Oriole
  Module                      : Consumer
  File name                   : COREConsumerModel.php
  Description                 : Model class for Consumer related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREConsumerModel
 */
class COREConsumerModel
{

    public function __construct()
    {
    }

    /**
     * Function used to  update  insight data in the  database.
     *
     * @param $inaPostData
     *
     * @return array
     */
    public function signup($inaPostData,$clientId)
    {  
        
        $iStatus = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_EMAIL])) && (!empty($clientId)) &&  (!empty($inaPostData[JSON_TAG_PASSWORD])) && (!empty($inaPostData[JSON_TAG_DEVICE_ID])) && $inaPostData[JSON_TAG_PLATFORM_ID] !== '')
        {
            $ConsumerDB                           = new COREConsumerDB();
            $PromocodeDB                          = new COREPromocodeDB();
            $ConnBean                             = new COREDbManager();
            $GenMethods                           = new COREGeneralMethods();
            $sEmail                               = $inaPostData[JSON_TAG_EMAIL];
            $FirstName                            = $inaPostData[JSON_TAG_FIR_NAME];
            $LastName                             = $inaPostData[JSON_TAG_LA_NAME];
            $sPassword                            = $inaPostData[JSON_TAG_PASSWORD];
            $is_password_reset                    = array_key_exists(JSON_TAG_IS_PASSWORD_RESET, $inaPostData) ? $inaPostData[JSON_TAG_IS_PASSWORD_RESET] : 0;
            $sPromo_code                          = array_key_exists(JSON_TAG_PROMO_CODE, $inaPostData) ? $inaPostData[JSON_TAG_PROMO_CODE] : null;
            $sPromo_code_id                       = null;
            
            $expiry_timestamp = 0;
            $wp_user_id = 0;
            $wp_site_name = null;

//            if(array_key_exists('expiry_timestamp', $inaPostData) && !empty($inaPostData['expiry_timestamp']) ) {
//                $expiry_timestamp = $inaPostData['expiry_timestamp'] ;
//            } else {
//                $current_timestamp = date('Y-m-d',time());
//                $expiry_timestamp = strtotime ( '+1 month' , strtotime ( $current_timestamp ) ) ;
//            }

            $expiry_timestamp = (array_key_exists('expiry_timestamp', $inaPostData) && !empty($inaPostData['expiry_timestamp'])) ? $inaPostData['expiry_timestamp'] : 0 ;
            $wp_user_id = (array_key_exists('wp_user_id', $inaPostData) && !empty($inaPostData['wp_user_id'])) ? $inaPostData['wp_user_id'] : 0 ;
            $wp_site_name = (array_key_exists('wp_site_name', $inaPostData) && !empty($inaPostData['wp_site_name'])) ? $inaPostData['wp_site_name'] : null ;
            $chargebee_customer_id = (array_key_exists('chargebee_customer_id', $inaPostData) && !empty($inaPostData['chargebee_customer_id'])) ? $inaPostData['chargebee_customer_id'] : null ;

            $isinvalid_Promo_code[JSON_TAG_ERROR] = ERRCODE_NO_ERROR;
            if(strlen($sPassword) > 5)
            {
                $sDeviceId   = $inaPostData[JSON_TAG_DEVICE_ID];
                $sPlatformId = $inaPostData[JSON_TAG_PLATFORM_ID];
                $sGroupId    = isset($isinvalid_Promo_code[JSON_TAG_GROUP_ID]) ? $isinvalid_Promo_code[JSON_TAG_GROUP_ID] : null;
                if(empty($sGroupId)) {
                    $groupDB = new COREGroupDB();
                    $sGroupId_arr = $groupDB->getdefaultgroup($ConnBean,$clientId);
                    $sGroupId = $sGroupId_arr['records'][0]['id'];                    
                }
                if($inaPostData[JSON_TAG_NOTIFICATION_ID] != '')
                {
                    $sNotificationId = $inaPostData[JSON_TAG_NOTIFICATION_ID];
                }
                else
                {
                    $sNotificationId = '';
                }
                $hashedPassword = password_hash($sPassword, PASSWORD_DEFAULT);
                $userExists     = $ConsumerDB->emailIDExists($ConnBean, $sEmail, $clientId);
                if($sPromo_code != null)
                {
                    $isinvalid_Promo_code = $PromocodeDB->valid_promo_code($sPromo_code);
                    $sPromo_code_id       = isset($isinvalid_Promo_code[JSON_TAG_ID]) ? $isinvalid_Promo_code[JSON_TAG_ID] : null;
                }
                if($userExists[JSON_TAG_STATUS] == ERRCODE_NO_ERROR && $isinvalid_Promo_code[JSON_TAG_ERROR] == ERRCODE_NO_ERROR)
                {
                    $ConsumerDB = new COREConsumerDB();
                    try
                    {

                        $ConnBean->beginTransaction();
                        $result = $ConsumerDB->signup($ConnBean, $sEmail, $hashedPassword, $sDeviceId, $sPlatformId, $sNotificationId, $sPromo_code_id,$clientId,$sGroupId,$FirstName,$LastName,$is_password_reset,$expiry_timestamp,$wp_user_id,$wp_site_name,$chargebee_customer_id);
                    }
                    catch(Exception $ex)
                    {
                    }
                    if($result[JSON_TAG_STATUS] == 0)
                    {
                        $ConnBean->commit();
                    }
                    else
                    {
                        $ConnBean->rollback();
                    }
                    $consumerid = $result[JSON_TAG_CONSUMER_ID];
                    try
                    {
                        $userDetails = $ConsumerDB->checkSignIn($ConnBean, $sEmail, $consumerid);
                         
                    }
                    catch(Exception $ex)
                    {
                    }
                    if($userDetails[JSON_TAG_STATUS] == ERRCODE_NO_ERROR)
                    {
                        try
                        {
                            $ConnBean->commit();
                        }
                        catch(Exception $ex)
                        {
                        }
                    }
                    else
                    {
                        try
                        {
                            $ConnBean->rollback();
                        }
                        catch(Exception $ex)
                        {
                        }
                    }
                   
                    if($userDetails[JSON_TAG_STATUS] == ERRCODE_NO_ERROR && $userDetails[JSON_TAG_EMAIL] != '')
                    {
                        $createdDate  = $userDetails[JSON_TAG_CREATED_DATE];
                        $modifiedDate = $userDetails[JSON_TAG_MODIFIED_DATE];
                        $subscription_expiry_date = $userDetails['subscription_expiry_date'];
                        
                        $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
                        $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT,$subscription_expiry_date_formated);
                
                        $userEmail    = $userDetails[JSON_TAG_EMAIL];
                        $userID       = $userDetails[JSON_TAG_CONSUMER_ID];
                        $link         = $userDetails[JSON_TAG_LINK];
                        $token        = $GenMethods->genarateJwtToken($userDetails[JSON_TAG_CONSUMER_ID]);
                        
                        $encrypt = new Aes();
                        $aes_input_key = strtolower(substr($token,0,16));
                        $aeskey = trim($encrypt->encode(AES_ENCRYPTION_KEY,$aes_input_key));
        //                $d = $encrypt->decode($aeskey,$aes_input_key);
        //                echo 'AES_ENCRYPTION_KEY : '.AES_ENCRYPTION_KEY.'<br>';
        //                echo 'enc : '.$aeskey.'<br>';                
        //                echo 'dec : '.$d.'<br>';
                
                        $aResult      = array(
                            JSON_TAG_CREATED_DATE  => $createdDate,
                            JSON_TAG_MODIFIED_DATE => $modifiedDate,
//                            'subscription_expiry_date' => $subscription_expiry_date,
                            'subscription_expiry_date' => $subscription_expiry_date_formated,
                            JSON_TAG_EMAIL         => $userEmail,
                            JSON_TAG_ID            => $userID,
                            JSON_TAG_LINK          => $link,
                            JSON_TAG_TOKEN          => $token,
                            JSON_TAG_TYPE          => JSON_TAG_CONSUMER,
                            JSON_AES_KEY           => $aeskey,
                        );
                    }
                    else
                    {
                        $sErrorDescription = ERRCODE_FIELD_EMPTY;
                        $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
                    }
                }
                else
                {
                    if($userExists[JSON_TAG_STATUS] == ERRCODE_FIELD_EMPTY)
                    {
                        $sErrorDescription = USER_EXISTS;
                        $iStatus           = ERRCODE_FIELD_EMPTY;
                    }
                    else
                    {
                        if($userExists[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
                        {
                            $sErrorDescription = UNKNOWN_ERROR;
                            $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
                        }
                        elseif($isinvalid_Promo_code[JSON_TAG_ERROR] == ERROR_CODE_INVALID_PROMO_CODE)
                        {
                            $sErrorDescription = INVALID_PROMO_CODE;
                            $iStatus           = ERROR_CODE_INVALID_PROMO_CODE;
                        }
                        elseif($isinvalid_Promo_code[JSON_TAG_ERROR] == ERROR_CODE_PROMO_CODE_EXPIRED)
                        {
                            $sErrorDescription = PROMO_CODE_EXPIRED;
                            $iStatus           = ERROR_CODE_PROMO_CODE_EXPIRED;
                        }
                        else
                        {
                            $sErrorDescription = UNKNOWN_ERROR;
                            $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
                            $sEmail            = null;
                        }
                    }
                }
                if($iStatus != 0)
                {
                    $aResult = array(
                        JSON_TAG_TYPE   => JSON_TAG_ERROR,
                        JSON_TAG_CODE   => $iStatus,
                        JSON_TAG_DESC   => $sErrorDescription,
                        JSON_TAG_ERRORS => array()
                    );
                }
            }
            else
            {
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    JSON_TAG_CODE   => ERROR_CODE_INVALID_PASSWORD,
                    JSON_TAG_DESC   => INVALID_PASSWORD,
                    JSON_TAG_ERRORS => array()
                );
            }

            return $aResult;
        }
    }

    /**
     * Function used to  edit consumer details.
     *
     * @param $consumerId
     * @param $inaPostData
     * @param $ConnBean
     *
     * @return array
     */
    public function modify_consumer($consumerId, $inaPostData, $ConnBean)
    {
        $iStatus = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_DEVICE_ID])) && $inaPostData[JSON_TAG_PLATFORM_ID] !=='')
        {
            $ConsumerDB  = new COREConsumerDB();
            $sEmail      = $inaPostData[JSON_TAG_EMAIL];
            $sPassword   = $inaPostData[JSON_TAG_PASSWORD];
            $sDeviceId   = $inaPostData[JSON_TAG_DEVICE_ID];
            $sPlatformId = $inaPostData[JSON_TAG_PLATFORM_ID];
            if($inaPostData[JSON_TAG_NOTIFICATION_ID] != '')
            {
                $sNotificationId = $inaPostData[JSON_TAG_NOTIFICATION_ID];
            }
            else
            {
                $sNotificationId = '';
            }
            try
            {
                $ConnBean->beginTransaction();
                $status = $ConsumerDB->modify_consumer($ConnBean, $sDeviceId, $sPlatformId, $sNotificationId, $consumerId);
                $ConnBean->commit();
            }
            catch(Exception $ex)
            {
                $ConnBean->rollback();
            }

            if($status[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
            {
                $sErrorDescription = UNKNOWN_ERROR;
                $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
            }

            if($iStatus != 0)
            {
                $aResult = array(
                    JSON_TAG_TYPE   => JSON_TAG_ERROR,
                    JSON_TAG_CODE   => $iStatus,
                    JSON_TAG_DESC   => $sErrorDescription,
                    JSON_TAG_ERRORS => array()
                );
            }
            else
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_SUCCESS
                );
            }

            return $aResult;
        }
    }

    /**
     * Function used to patch  consumer details.
     *
     * @param $consumerId
     * @param $inaPostData
     * @param $ConnBean
     *
     * @return array
     */
    public function patch_consumer($consumerId, $inaPostData, $ConnBean)
    {
        //k Currently we only let the client patch notificationID provided he has given deviceID.
        //k Review the code to support other consumer attributes like fName or lastName.

        $iStatus    = ERRCODE_CONSUMER_API_INSUFFICIENT_PARAM;
        $aResult    = array();
        $ConsumerDB = new COREConsumerDB();

        if(array_key_exists(JSON_TAG_NOTIFICATION_ID, $inaPostData))
        {
            $sConsumerDeviceID = empty($inaPostData[JSON_TAG_DEVICE_ID]) ? null : $inaPostData[JSON_TAG_DEVICE_ID];
            if(!empty($inaPostData[JSON_TAG_NOTIFICATION_ID]) && !empty($sConsumerDeviceID))
            {
                $sConsumerNotificationId = $inaPostData[JSON_TAG_NOTIFICATION_ID];
                $aUpdateQuery[]          = " fldnotificationid = :notificationid";
                $aUpdateParams[]         = $sConsumerNotificationId;
                $colums[]                = ":notificationid";

                try
                {
                    $ConnBean->beginTransaction();
                    $status = $ConsumerDB->patch_consumer($ConnBean, $aUpdateQuery, $aUpdateParams, $colums, $consumerId, $sConsumerDeviceID);
                    if($status[JSON_TAG_STATUS] == 0)
                    {
                        $ConnBean->commit();
                        $iStatus = ERRCODE_NO_ERROR;
                    }
                    else
                    {
                        echo "rollback $sConsumerDeviceID :: $sConsumerNotificationId";
                        $ConnBean->rollback();
                        $iStatus = SERVER_EXCEPTION_UNKNOWN_ERROR;
                    }
                }
                catch(Exception $ex)
                {
                    $ConnBean->rollback();
                    $iStatus = SERVER_EXCEPTION_UNKNOWN_ERROR;
                }
            }
            else
            {
                $iStatus = ERRCODE_CONSUMER_API_INSUFFICIENT_PARAM;
            }
        }

        if(ERRCODE_NO_ERROR == $iStatus)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS
            );
        }
        else
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => CONSUMER_PATCH_ERROR,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }

    /**
     * Function used to do device signup.
     *
     * @param $inaPostData
     *
     * @return array
     */
    public function device_signup($inaPostData)
    {
        $iStatus = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_EMAIL])) && (!empty($inaPostData[JSON_TAG_PASSWORD])) && (($inaPostData[JSON_TAG_DEVICE_ID])) && $inaPostData[JSON_TAG_PLATFORM_ID] !== '')
        {
            $GenMethods = new COREGeneralMethods();
            $ConsumerDB = new COREConsumerDB();
            $ConnBean   = new COREDbManager();

            $email          = $inaPostData[JSON_TAG_EMAIL];
            $password       = $inaPostData[JSON_TAG_PASSWORD];
            $deviceId       = $inaPostData[JSON_TAG_DEVICE_ID];
            $platformId     = $inaPostData[JSON_TAG_PLATFORM_ID];
            $notificationId = $inaPostData[JSON_TAG_NOTIFICATION_ID];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try
            {
                $ConnBean->beginTransaction();
                $result = $ConsumerDB->device_signup($ConnBean, $email, $hashedPassword, $deviceId, $platformId, $notificationId);
                if($result[JSON_TAG_STATUS] == 0)
                {
                    $ConnBean->commit();
                }
                else
                {
                    $ConnBean->rollback();
                }
            }
            catch(Exception $ex)
            {
            }

            if($result[JSON_TAG_STATUS] == ERRCODE_NO_ERROR && $result[JSON_TAG_EMAIL] != '')
            {
                $createdDate  = $result[JSON_TAG_CREATED_DATE];
                $modifiedDate = $result[JSON_TAG_MODIFIED_DATE];
                $userEmail    = $result[JSON_TAG_EMAIL];
                $userID       = $result[JSON_TAG_CONSUMER_ID];
                $link         = $result[JSON_TAG_LINK];
                $aResult      = array(
                    JSON_TAG_CREATED_DATE  => $createdDate,
                    JSON_TAG_MODIFIED_DATE => $modifiedDate,
                    JSON_TAG_EMAIL         => $userEmail,
                    JSON_TAG_ID            => $userID,
                    JSON_TAG_LINK          => $link,
                    JSON_TAG_TYPE          => JSON_TAG_CONSUMER,
                );
            }
            else
            {
                $sErrorDescription = UNKNOWN_ERROR;
                $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
            }
        }
        else
        {
            $sErrorDescription = ERRCODE_FIELD_EMPTY;
            $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sEmail            = null;
        }
        if($iStatus != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }

    /**
     * Function used to  sign in users.
     *
     * @param $inaPostData
     *
     * @return array
     */
    public function signin($inaPostData,$clientId)
    {

        $iStatus = 0;
        $subscription_expiry_date = "0000-00-00 00:00:00";
        $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
        $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT,$subscription_expiry_date_formated);
                
        $password_match = 0;
        $client_match = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_EMAIL])) && (!empty($inaPostData[JSON_TAG_PASSWORD]))&& (!empty($clientId)) && (!empty($inaPostData[JSON_TAG_DEVICE_ID])) && $inaPostData[JSON_TAG_PLATFORM_ID] !== '')
        {

            $GenMethods = new COREGeneralMethods();
            $ConsumerDB = new COREConsumerDB();
            $ConnBean   = new COREDbManager();
            $GenMethods = new COREGeneralMethods();
            $sEmail          = $inaPostData[JSON_TAG_EMAIL];
            $sPassword       = $inaPostData[JSON_TAG_PASSWORD];
            $sNotificationId = '';
            if(isset($inaPostData[JSON_TAG_NOTIFICATION_ID]))
            {
                $sNotificationId = $inaPostData[JSON_TAG_NOTIFICATION_ID];
            }

            $deviceID          = $inaPostData[JSON_TAG_DEVICE_ID];
            $credentialMatches = $ConsumerDB->IsUserSignedIn($ConnBean, $sEmail, $deviceID,$clientId);
               
  
            /*****************************************************************/
                    // Wordpress Authentication start
            /*****************************************************************/             
/*
                // WP API CALL FOR SIGN_IN 
                $endpoint = '/user-validate';
                $url = JSON_TAG_WP_URL;
                $url .= $endpoint;                  

                $data = array(
                    'username' => $sEmail,
                    'password'=> $sPassword
                    );
                $json_data = $data;

                $wp_user_id = null;
                $wp_authenticated= false;
                $wp_auth = $ConsumerDB->l_curl($url,$json_data);       
                       
                if(!empty($wp_auth)) {
                    $wp_auth = json_decode($wp_auth,true);
                }
                                   
                if(!empty($wp_auth) && !empty($wp_auth['user_id'])) {
                    //$wp_auth = json_decode($wp_auth,true);
                    $wp_user_id = $wp_auth['user_id'];
                    $wp_authenticated= true;
                } else {
                    $wp_authenticated= false;
                    
                    if($wp_auth['error_code'] === "EMAILERR")
                    {
                        $sErrorDescription = EMAIL_NOT_FOUND_ERROR.' (WP)';
                        $iStatus           = ERRCODE_EMAIL_NOT_FOUND;
                    } else {

                        $sErrorDescription = PASSWORD_DOESNT_MATCH.' (WP)';
                        $iStatus           = ERRCODE_PASSWORD_DOESNT_MATCH;
                    }

                    $aResult = array(
                        JSON_TAG_TYPE   => JSON_TAG_ERROR,
                        JSON_TAG_CODE   => $iStatus,
                        JSON_TAG_DESC   => $sErrorDescription,
                        JSON_TAG_ERRORS => array()
                    );
                    return $aResult;
                }

                */
            
            // commented above code as we use OPT validation now
            // and added this line
            $wp_authenticated= true;
            /*****************************************************************/
                    // Wordpress Authentication ended
            /*****************************************************************/

            
            
            if(count($credentialMatches) !== 0)
            {
                $createdDate  = $credentialMatches[JSON_TAG_CREATED_DATE];
                $modifiedDate = $credentialMatches[JSON_TAG_MODIFIED_DATE];
                $userEmail    = $credentialMatches[JSON_TAG_EMAIL];
                $userID       = $credentialMatches[JSON_TAG_CONSUMER_ID];
                $link         = $credentialMatches[JSON_TAG_LINK];
                $hash         = $credentialMatches[JSON_TAG_HASHED_PASSWORD];
                $client       = $credentialMatches[JSON_TAG_CLIENT_ID];
                $is_password_reset       = $credentialMatches[JSON_TAG_IS_PASSWORD_RESET];
                $subscription_expiry_date  = $credentialMatches['subscription_expiry_date'];
                $first_name  = $credentialMatches[JSON_TAG_FIR_NAME];
                $last_name  = $credentialMatches[JSON_TAG_LA_NAME];
                
                $subscription_expiry_date_formated = strtotime($subscription_expiry_date);
                $subscription_expiry_date_formated = date(JSON_TAG_DISPLAY_DATE_FORMAT,$subscription_expiry_date_formated);
                
                
                $token        = $GenMethods->genarateJwtToken($credentialMatches[JSON_TAG_CONSUMER_ID]);

                $fbkey        = $GenMethods->genarateJwtToken(AES_ENCRYPTION_KEY);

                $encrypt = new Aes();
                $aes_input_key = strtolower(substr($token,0,16));
                $aeskey = trim($encrypt->encode(AES_ENCRYPTION_KEY,$aes_input_key));
//                $d = $encrypt->decode($aeskey,$aes_input_key);
//                echo 'AES_ENCRYPTION_KEY : '.AES_ENCRYPTION_KEY.'<br>';
//                echo 'enc : '.$aeskey.'<br>';                
//                echo 'dec : '.$d.'<br>';

                
                /// OLD LOGIN - DO NOT DLEETE below LINE
//                if(password_verify($sPassword, $hash)) /// OLD LOGIN - DO NOT DLEETE THIS LINE
                if($wp_authenticated === true)
                {
                    $password_match = 1;
                }
                else
                {
                    $password_match = 0;
                }
                
                if($clientId === $client)
                {
                    $client_match = 1;
                }
                else
                {
                    $client_match = 0;
                }
               
                if($password_match === 1 && $client_match===1)
                {
                    //TODO: Update table tbluserdevices to include the new device details.
                    $aResult = array(
                        JSON_TAG_CREATED_DATE  => $createdDate,
                        JSON_TAG_MODIFIED_DATE => $modifiedDate,
//                        'subscription_expiry_date' => $subscription_expiry_date,
                        'subscription_expiry_date' => $subscription_expiry_date_formated,
                        JSON_TAG_FIR_NAME         => $first_name,
                        JSON_TAG_LA_NAME         => $last_name,
                        JSON_TAG_EMAIL         => $userEmail,
                        JSON_TAG_ID            => $userID,
                        JSON_TAG_LINK          => $link,
                        JSON_TAG_TOKEN          => $token,
                        JSON_TAG_TYPE          => JSON_TAG_CONSUMER,
//                        JSON_FB_KEY            => $fbkey,
                        JSON_AES_KEY           => $aeskey,
                        JSON_TAG_IS_PASSWORD_RESET           => $is_password_reset,
                    );
                }
                else
                { 
                    if($password_match === 1)
                    {
                        $sErrorDescription = CLIENT_ID_DOESNT_MATCH.' (APP)';
                        $iStatus           = ERRCODE_INVALID_CLIENT_ID;
                    }else{

                        $sErrorDescription = PASSWORD_DOESNT_MATCH.' (APP)';
                        $iStatus           = ERRCODE_PASSWORD_DOESNT_MATCH;
                    }
                }
            }
            else
            {
                $sErrorDescription = EMAIL_NOT_FOUND_ERROR;
                $iStatus           = ERRCODE_EMAIL_NOT_FOUND;
            }
        }
        else
        {
            $sErrorDescription = UNKNOWN_ERROR;
            $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
        
        $expirytime = strtotime($subscription_expiry_date);
        $currenttime = strtotime(date("Y-m-d H:i:s"));
        //echo '$currenttime : '.$currenttime.'<br>';
        if($expirytime < $currenttime) {
            if($password_match === 1 && $client_match===1) {
                $sErrorDescription = SUBSCRIPTION_EXPIRED_ERROR;
                $iStatus           = SUBSCRIPTION_EXPIRED_ERROR_CODE;
            }
        }
                

        if($iStatus !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
//                "subscription_expiry"=> $subscription_expiry_date,
                "subscription_expiry"=> $subscription_expiry_date_formated,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        } else {
            // populate Userwise All Playlists Order Table
            $COREAdminDB = new COREAdminDB();
            $clientUserId = $COREAdminDB->getClientUserId($client);

            $rResult['audvisorClientId'] = 'audvisor11012017';
            $audvisorClientUserId = $COREAdminDB->getClientUserId($rResult['audvisorClientId']);
            if(!empty($audvisorClientUserId)) {
                $clientUserId .= ",".$audvisorClientUserId;
            }
            
            $ConsumerDB->populateUserwiseAllPlaylistsOrderTable($ConnBean, $userID, $clientUserId);
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     *  Function used to like insights by users.
     *
     * @param $consumerid
     *
     * @return array
     */
    public function favourites_list($consumerId,$clientId)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();
//        $GenMethods   = new COREGeneralMethods();
        
        $aList      = $ConsumerDB->favourites_list($consumerId, $ConnBean);
        if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_NO_FAVOURITES)
        {
            $iStatus         = SERVER_EXCEPTION_NO_FAVOURITES;
            $sErrDescription = JSON_TAG_NO_FAVOURITES;
        }
        if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        if($aList[JSON_TAG_STATUS] == ERRCODE_NO_ERROR)
        {

            foreach($aList[JSON_TAG_RECORDS] as $value)
            {
                $aResult[] = $value;
            }
        }
        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $consumerId
     * @param $inaPostData
     *
     * @return array
     */
    public function reset_password($consumerId, $inaPostData)
    {
         $iStatus = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_NEW_PASSWORD])) && (!empty($inaPostData[JSON_TAG_OLD_PASSWORD])))
        {
            $GenMethods = new COREGeneralMethods();
            $ConsumerDB = new COREConsumerDB();
            $ConnBean   = new COREDbManager();

            $newPassword = $inaPostData[JSON_TAG_NEW_PASSWORD];
            $raw_password = $newPassword;
            $oldPassword = $inaPostData[JSON_TAG_OLD_PASSWORD];
             $consumerDB = new COREConsumerDB();
            $newPassword    = password_hash($newPassword, PASSWORD_DEFAULT);
            $getPassword    = $ConsumerDB->get_password($ConnBean, $consumerId);
            $hashedPassword = $getPassword[JSON_TAG_PASSWORD];
//            if($hashedPassword !== NULL)
//            {
//                if(password_verify($oldPassword, $hashedPassword))
//                {
                    try
                    {
                        $status = $ConsumerDB->update_password($ConnBean, $consumerId, $newPassword, $raw_password);              
                    }
                    catch(Exception $ex)
                    {
                        echo $ex->getMessage();
                    }
//                    if($status === 0)
//                    {
//                        //$ConnBean->endTransaction();
//                    }
//                    else
//                    {
//                        //$ConnBean->cancelTransaction();
//                    }
                    if($status === 0) {
                        $aResult = array(
                            JSON_TAG_TYPE   => JSON_TAG_SUCCESS,
                            JSON_TAG_CODE   => $status,
                            JSON_TAG_ERRORS => array()
                        );
                    } else {
                        $aResult = array(
                            JSON_TAG_TYPE   => JSON_TAG_ERROR,
                            JSON_TAG_CODE   => 2,
                            JSON_TAG_ERRORS => $status
                        );
                    }
                        
                    
//                }
//                else
//                {
//                    $sErrorDescription = JSON_TAG_PASSWORD_DOESNT_MATCH;
//                    $iStatus           = ERRCODE_PASSWORD_DOESNT_MATCH;
//                }
//            }
//            else
//            {
//                $sErrorDescription = JSON_TAG_HASHED_PASSWORD_NULL;
//                $iStatus           = ERRCODE_HASHED_PASSWORD_NULL;
//            }
        }
        else
        {
            $sErrorDescription = JSON_TAG_POSTDATA_ERROR;
            $iStatus           = ERRCODE_FIELD_EMPTY;
        }
        if($iStatus !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }

    /**
     * Function used to check whether email is registered or not.
     *
     * @param $insEmailID
     *
     * @return array
     */
    public function forgot_password($insEmailID,$clientId)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();
        $aList      = $ConsumerDB->forgot_password($ConnBean, $insEmailID,$clientId);
        if($aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = ERRCODE_EMAIL_NOT_FOUND;
            $sErrDescription = JSON_TAG_EMAIL_ID_DOESNT_EXIST;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else if($aList[JSON_TAG_STATUS] == 3)
            {
                $iStatus         = ERRCODE_INVALID_CLIENT_ID;
                $sErrDescription = CLIENT_ID_DOESNT_MATCH;
            }
            else
            {
                if($aList[JSON_TAG_STATUS] == 0)
                {
                    $to     = (string)$insEmailID;
                    $token  = $aList[JSON_TAG_TOKEN];
                    $result = $this->send_password_reset_requestMail($token, $to);
                    if(!$result)
                    {
                        $aResult = array(
                            JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                            'token' => $token
                        );
                    }
                    else
                    {
                        $iStatus         = ERRCODE_EMAIL_NOT_SENT;
                        $sErrDescription = JSON_TAG_EMAIL_NOT_SENT;
                    }
                }
            }
        }
        if($aList[JSON_TAG_STATUS] != 0 || ($aList[JSON_TAG_STATUS] == 0 && $result != 0))
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to like insights and inserted to database.
     *
     * @param $aPostData
     * @param $consumerid
     *
     * @return array
     */
    public function user_like($aPostData, $consumerid)
    {
        $aList      = array();
        $aResult    = array();
        $ConnBean   = new COREDbManager();
        $GenMethods   = new COREGeneralMethods();
        $insightid  = $aPostData[JSON_TAG_INSIGHT_ID];
        $ConsumerDB = new COREConsumerDB();
        $aList      = $ConsumerDB->update_favourites($ConnBean, $insightid, $consumerid);
        if($aList[JSON_TAG_STATUS] == 4)
        {
            $iStatus         = ERROR_CODE_FAVOURITE_EXISTS;
            $sErrDescription = SERVER_EXCEPTION_FAVOURITE_EXISTS;
        }
        else
        {
            if($aList[JSON_TAG_STATUS] == 2 || $aList[JSON_TAG_STATUS] == 3)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                if($aList[JSON_TAG_STATUS] == SERVER_ERRORCODE_INVALID_CONSUMER)
                {
                    $iStatus         = ERRCODE_INVALID_CONSUMER;
                    $sErrDescription = INVALID_CONSUMER_ID;
                }
                else
                {
                    if($aList[JSON_TAG_STATUS] == SERVER_ERRORCODE_INVALID_INSIGHT)
                    {
                        $iStatus         = ERROR_CODE_INVALID_INSIGHT_ID;
                        $sErrDescription = INVALID_INSIGHT_ID;
                    }
                }
            }
        }

        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aList = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aList;
    }

    /**
     * Function used to record consumer analytics like percentage of skipped, shared, played etc stored into the database.
     *
     * @param $consumerid
     * @param $favid
     *
     * @return array
     */
    public function user_unlike($consumerid, $favid)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $status     = $ConsumerDB->update_user_unlike($consumerid, $favid, $ConnBean);
        if($status == 2)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($status == 1)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
        }
        if($status == 0)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS,
            );
        }
        if($status !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to authorize API access by consumer app.
     *
     * @param $aAnalyticsData
     * @param $consumerId
     *
     * @return array
     */
    public function consumer_analytics($aAnalyticsData, $consumerId)
    {
        $aList      = array();
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();
        foreach($aAnalyticsData as $i => $data)
        {
            $receiverId   = $data[JSON_TAG_RECEIVER_ID];
            $receiverType = $data[JSON_TAG_RECEIVER_TYPE];
            $actionId     = $data[JSON_TAG_ACTION_ID];
            $actionData   = $data[JSON_TAG_ACTION_DATA];
            if((!empty($receiverId)) && (!empty($actionId)) && ($actionId > 0 && $actionId < 10) && (!empty($receiverType)) && ($receiverType <= 3 && ($receiverType !== 0)))
            {
                $aList = $ConsumerDB->consumer_analytics($ConnBean, $receiverId, $actionId, $actionData, $consumerId, $receiverType);
            }
            else
            {
                $aList[JSON_TAG_STATUS] = 5;
                $iStatus                = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription        = UNKNOWN_ERROR;
            }
        }
        if($aList[JSON_TAG_STATUS] == 2 || $aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        if($aList[JSON_TAG_STATUS] == 0)
        {
            $aResult = array(
                JSON_TAG_TYPE => JSON_TAG_SUCCESS,
            );
        }
        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @param $insConsumerUUID
     * @param $insPassword
     * @param $consumerId
     *
     * @return int
     */
    public function authorize($insConsumerUUID, $insPassword, $consumerId)
    {
        $nStatus = -1;

        $ConnBean = new COREDbManager();
        try
        {
            $ConsumerDB       = new COREConsumerDB();
            $aUserCredentials = $ConsumerDB->getConsumerCredentials($ConnBean, $insConsumerUUID, $consumerId);

            $GenMethods = new COREGeneralMethods();

            if(password_verify($insPassword, $aUserCredentials['password']))
            {
                $nStatus = 1;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        $ConnBean = null;

        return $nStatus;
    }

    /**
     * Function used to display consumer analytics in cms.
     *
     * @return array
     */
    public function get_useractions()
    {
        $ConnBean   = new COREDbManager();
        $aResult    = array();
        $ConsumerDB = new COREConsumerDB();
        try
        {
            $aList = $ConsumerDB->get_useractions($ConnBean);
            if($aList[JSON_TAG_STATUS] == 2)
            {
                $iStatus                 = ERRCODE_SERVER_EXCEPTION_GET_USER_ACTIONS;
                $sErrDescription         = SERVER_EXCEPTION_GET_USERACTIONS;
                $aResult[JSON_TAG_COUNT] = 0;
                $aResult['error']        = $sErrDescription;
            }
            else
            {
                $aResult[JSON_TAG_TYPE]         = JSON_TAG_USER_ACTIONS;
                $aResult[JSON_TAG_COUNT]        = count($aList[JSON_TAG_RECORDS]);
                $aResult[JSON_TAG_USER_ACTIONS] = $aList[JSON_TAG_RECORDS];
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
     * Function used to follow topics/experts for consumers.
     *
     * @param $aPostData
     * @param $consumerid
     *
     * @return array
     */
    public function user_follow($aPostData, $consumerid)
    {
        $ConnBean    = new COREDbManager();
        $iType       = $aPostData[JSON_TAG_RECEIVER_TYPE];
        $iReceiverid = $aPostData[JSON_TAG_RECEIVER_ID];
       
        $ConsumerDB = new COREConsumerDB();

        $Result = $ConsumerDB->user_follow($ConnBean, $consumerid, $iType, $iReceiverid);

        if($Result[JSON_TAG_STATUS] == 2)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($Result[JSON_TAG_STATUS] == 0)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                if($Result[JSON_TAG_STATUS] === 1)
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                    );
                }
                else
                {
                    if($Result[JSON_TAG_STATUS] === 4)
                    {
                        $iStatus         = ERROR_CODE_INVALID_RECEIVER_TYPE;
                        $sErrDescription = INVALID_RECEIVER_TYPE;
                    }
                    else
                    {
                        if($Result[JSON_TAG_STATUS] === 5)
                        {
                            $iStatus         = ERRCODE_INVALID_CONSUMER;
                            $sErrDescription = INVALID_CONSUMER_ID;
                        }
                        else
                        {
                            if($Result[JSON_TAG_STATUS] === 6)
                            {
                                $iStatus         = ERROR_CODE_INVALID_RECEIVER_ID;
                                $sErrDescription = INVALID_RECEIVER_ID;
                            }
                        }
                    }
                }
            }
        }
        if($Result[JSON_TAG_STATUS] !== 1)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to unfollow topics/experts for consumers.
     *
     * @param $aPostData
     * @param $consumerid
     * @param $iReceiverid
     *
     * @return array
     */
    public function user_unfollow($aPostData, $consumerid, $iReceiverid)
    {

        $ConnBean   = new COREDbManager();
        $iType      = $aPostData[JSON_TAG_RECEIVER_TYPE];
        $ConsumerDB = new COREConsumerDB();
        $Result     = $ConsumerDB->user_unfollow($ConnBean, $consumerid, $iType, $iReceiverid);
        if($Result[JSON_TAG_STATUS] == 2)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        else
        {
            if($Result[JSON_TAG_STATUS] == 0)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {
                if($Result[JSON_TAG_STATUS] === 1)
                {
                    $aResult = array(
                        JSON_TAG_TYPE => JSON_TAG_SUCCESS,
                    );
                }
            }
        }
        if($Result[JSON_TAG_STATUS] !== 1)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to list favorited experts.
     *
     * @param $iConsumerid
     *
     * @return array
     */
    public function following_experts_list($iConsumerid,$clientId)
    {

        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();

        $aList = $ConsumerDB->following_experts_list($ConnBean, $iConsumerid,$clientId);
        if($aList[JSON_TAG_STATUS] == 2 || $aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        if($aList[JSON_TAG_STATUS] == 0)
        {

            $aResult                   = array();
            $aResult[JSON_TAG_TYPE]    = JSON_TAG_EXPERTS;
            $aResult[JSON_TAG_COUNT]   = count($aList[JSON_TAG_EXPERT]);
            $aResult[JSON_TAG_EXPERTS] = $aList[JSON_TAG_EXPERT];
        }
        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to list favorited topics.
     *
     * @param $iConsumerid
     *
     * @return array
     */
    public function following_topics_list($iConsumerid)
    {

        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();

        $aList = $ConsumerDB->following_topics_list($ConnBean, $iConsumerid);
        if($aList[JSON_TAG_STATUS] == 2 || $aList[JSON_TAG_STATUS] == 1)
        {
            $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
            $sErrDescription = UNKNOWN_ERROR;
        }
        if($aList[JSON_TAG_STATUS] == 0)
        {

            $aResult                  = array();
            $aResult[JSON_TAG_TYPE]   = JSON_TAG_TOPIC;
            $aResult[JSON_TAG_COUNT]  = count($aList[JSON_TAG_TOPIC]);
            $aResult[JSON_TAG_TOPICS] = $aList[JSON_TAG_TOPIC];
        }
        if($aList[JSON_TAG_STATUS] != 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrDescription,
                JSON_TAG_ERRORS => array()
            );
        }
        $ConnBean = null;

        return $aResult;
    }

    /**
     * Function used to add favorited topics.
     *
     * @param $iConsumerid
     *
     * @return array
     */
    public function favourite_topics($iConsumerid)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = $ConsumerDB->favourite_topics($ConnBean, $iConsumerid);
        $ConnBean   = null;

        return $aResult;
    }

    /**
     * Function used to reset user password if lost and requested.
     *
     * @param $iConsumerid
     *
     * @return array
     */
    public function favourite_experts($iConsumerid)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = $ConsumerDB->favourite_experts($ConnBean, $iConsumerid);
        $ConnBean   = null;

        return $aResult;
    }

    /**
     * Function used to render the reset password page
     *
     * @param $inaPostData
     *
     * @return array
     */
    public function forgot_password_reset($inaPostData)
    {
        $iStatus                  = 0;
        $aResult                  = array();
        $aResult[JSON_TAG_STATUS] = 1;
        if((!empty($inaPostData[JSON_TAG_NEW_PASSWORD])) && (!empty($inaPostData[JSON_TAG_CODE])))
        {
            $GenMethods   = new COREGeneralMethods();
            $ConsumerDB   = new COREConsumerDB();
            $ConnBean     = new COREDbManager();
            $sToken       = $inaPostData[JSON_TAG_CODE];
            $sNewPassword = $inaPostData[JSON_TAG_NEW_PASSWORD];
            $raw_password = $sNewPassword;
            $sNewPassword = password_hash($sNewPassword, PASSWORD_DEFAULT);
            try
            {  
                $aResult = $ConsumerDB->forgot_password_reset($ConnBean, $sToken, $sNewPassword,$raw_password);   
            }
            catch(Exception $ex)
            {
                echo $ex->getMessage();
            }
            if($aResult[JSON_TAG_STATUS] === 0)
            {
                $sEmailid = $aResult[JSON_TAG_EMAILID];
                $this->send_password_reset_confirmMail($sEmailid);
                $aReponse = array(
                    JSON_TAG_TYPE   => JSON_TAG_SUCCESS,
                    JSON_TAG_CODE   => $iStatus,
                    JSON_TAG_ERRORS => array()
                );
            }
            else
            {
                if($aResult[JSON_TAG_STATUS] === 3)
                {
                      $iStatus         = ERRCODE_INVALID_CLIENT_ID;
                      $sErrorDescription = CLIENT_ID_DOESNT_MATCH;
                }else 
                {
                    $iStatus           = ERRCODE_INVALID_CONSUMER;
                    $sErrorDescription = JSON_TAG_EMAIL_NOT_FOUND;
                }
              
            }
        }
        else
        {
            $sErrorDescription = JSON_TAG_EMAIL_NOT_FOUND;
            $iStatus           = ERRCODE_FIELD_EMPTY;
        }
        if($aResult[JSON_TAG_STATUS] !== 0)
        {
            $aReponse = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aReponse;
    }

    /**
     * @param $sToken
     *
     * @return array
     */
    public function view_reset_password($sToken)
    {
        $ConsumerDB = new COREConsumerDB();
        $ConnBean   = new COREDbManager();
        $bResult    = array();
        try
        {
            $aResult = $ConsumerDB->view_reset_password($ConnBean, $sToken);
            if($aResult[JSON_TAG_STATUS] == 0)
            {
                $bResult = array(
                    JSON_TAG_TYPE  => JSON_TAG_SUCCESS,
                    JSON_TAG_EMAIL => $aResult[JSON_TAG_EMAILID],
                    JSON_TAG_CODE  => $sToken
                );
            }
            else
            {
                if($aResult[JSON_TAG_STATUS] == 1)
                {
                    $sErrorDescription = JSON_TAG_EMAIL_NOT_FOUND;
                    $iStatus           = ERRCODE_FIELD_EMPTY;
                }
                else
                {
                    if($aResult[JSON_TAG_STATUS] == 2)
                    {
                        $iStatus           = SERVER_EXCEPTION_UNKNOWN_ERROR;
                        $sErrorDescription = UNKNOWN_ERROR;
                    }
                    else
                    {
                        if($aResult[JSON_TAG_STATUS] == 3)
                        {
                            $sErrorDescription = JSON_TAG_LINK_EXPIRED;
                            $iStatus           = ERROR_CODE_LINK_EXPIRED;
                        }
                    }
                }
            }

            if($aResult[JSON_TAG_STATUS] != 0)
            {
                $bResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => $iStatus,
                    JSON_TAG_DESC => $sErrorDescription
                );
            }
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
        $ConnBean = null;

        return $bResult;
    }

    /**
     * Function used to send email  for reseting password
     *
     * @param $token
     * @param $to
     *
     * @return int
     */
    private function send_password_reset_requestMail($token, $to)
    {
        $Mail    = new CORESendMail();
        $subject = 'THE BUSINESS JOURNALS - Account recovery instructions';
        $message = "You are receiving this email because your address was entered in the forgotten password form when signing in to The Business Journals.\n\n".
                   "To recover your account and reset your password, please click here:\n".BASE_URL_STRING."resetpassword?t=$token\n\nIf you believe you have received this email in error, please ignore it.\n\n".
                   "Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of THE BUSINESS JOURNALS App.";
        $headers = 'From: no-reply@thebusinessjournalsedge.com'."\r\n";

        return $Mail->sendEmail($to, $subject, $message, $headers);
    }

    /**
     * Function used to send  confirm email  successfull resetting of password.
     *
     * @param $sEmailid
     *
     * @return int
     */
    public function send_password_reset_confirmMail($sEmailid)
    {
        $Mail            = new CORESendMail();
        $sToEmailAddress = $sEmailid;
        $subject         = 'Your password has been changed successfully';
        $headers         = 'From: no-reply@thebusinessjournalsedge.com'."\r\n";
        $sMessage        = "The password for your THE BUSINESS JOURNALS app account - ".$sEmailid."- has been successfully changed.\n\n".
                           "Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of THE BUSINESS JOURNALS App.";

        return $Mail->sendEmail($sToEmailAddress, $subject, $sMessage, $headers);
    }
    
    public function getConsumerProfile($userId)
    {
        
        $ConsumerDB = new COREConsumerDB();
        $ConnBean   = new COREDbManager();
        $bResult    = array();
        try
        {
            $consumer = $ConsumerDB->getConsumer($ConnBean, $userId);
        }catch (Exception $e) {
            return $e->getMessage();
        }
        return $consumer;
    }
    
    public function getConsumer($ConnBean, $userId)
    {
        try
        {
            $sQuery = "SELECT *  FROM tblconsumers WHERE fldid = :consumerid";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':consumerid', $userId);
            $result = $ConnBean->single();
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
         return $result;
    }
    
    public function validateClientAcceptanceCountExpired($clientid){
        try
        {
            $ConnBean = new COREDbManager();
            $sQuery = "SELECT *  FROM tbluser WHERE client_id = :client_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':client_id', $clientid);
            $result = $ConnBean->single();
            $userLimit = $result['consumer_limit']; 
            
            $cQuery = "SELECT count(*) as count FROM tblconsumers WHERE client_id = :client_id";
            $ConnBean->getPreparedStatement($cQuery);
            $ConnBean->bind_param(':client_id', $clientid);
            $count = $ConnBean->single();
            if($userLimit>$count['count']){
                return 1;
            }else{
                return 0;
}
            
        }
        catch(Exception $e)
        {            print_r($e);exit;
             return $e->getMessage();
        }
        return $result;
    }
    
    public function update_password($inaPostData)
    {
        $iStatus = 0;
        $aResult = array();
        if((!empty($inaPostData[JSON_TAG_NEW_PASSWORD])))
        {
            $GenMethods = new COREGeneralMethods();
            $ConsumerDB = new COREConsumerDB();
            $ConnBean   = new COREDbManager();

            $newPassword = $inaPostData[JSON_TAG_NEW_PASSWORD];
            $raw_password = $newPassword;
            
            $is_password_verified = 1;
            //$consumerId = $inaPostData[JSON_TAG_CONSUMER_ID];
            
            if(array_key_exists(JSON_TAG_CONSUMER_ID, $inaPostData) && !empty($inaPostData[JSON_TAG_CONSUMER_ID])) {
                $consumerId     = $inaPostData[JSON_TAG_CONSUMER_ID]; 
                $getPassword    = $ConsumerDB->get_password($ConnBean, $consumerId);
                $hashedPassword = $getPassword[JSON_TAG_PASSWORD];
            }
            /*
            if(array_key_exists(JSON_TAG_OLD_PASSWORD, $inaPostData) && !empty($inaPostData[JSON_TAG_OLD_PASSWORD])) {
                $email          = $inaPostData[JSON_TAG_EMAIL];
                $oldPassword    = $inaPostData[JSON_TAG_OLD_PASSWORD]; 

                $sQuery = "SELECT  fldid, fldcreateddate, fldmodifieddate, fldemailid, fldhashedpassword,client_id, is_password_reset FROM tblconsumers WHERE fldemailid = ? ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param("1", $email);
                $result         = $ConnBean->single();
                $consumerId     = $result[DB_COLUMN_FLD_ID];    
                
                $getPassword    = $ConsumerDB->get_password($ConnBean, $consumerId);
                $hashedPassword = $getPassword[JSON_TAG_PASSWORD];
                $is_password_verified = password_verify($oldPassword, $hashedPassword);
            }     
            */
            
            
            $consumerDB = new COREConsumerDB();
            $newPassword    = password_hash($newPassword, PASSWORD_DEFAULT);
            
            
//            if($hashedPassword !== NULL)
//            {
//                if($is_password_verified === 1)
//                {
                    try
                    {
                        $status = $ConsumerDB->update_password($ConnBean, $consumerId, $newPassword,$raw_password);
                    }
                    catch(Exception $ex)
                    {
                        echo $ex->getMessage();
                    }
                    if($status === 0)
                    {
                        //$ConnBean->endTransaction();
                    }
                    else
                    {
                        //$ConnBean->cancelTransaction();
                    }
                    $aResult = array(
                        JSON_TAG_TYPE   => JSON_TAG_SUCCESS,
                        JSON_TAG_CODE   => $iStatus,
                        JSON_TAG_ERRORS => array()
                    );
                /*}
                else
                {
                    $sErrorDescription = JSON_TAG_PASSWORD_DOESNT_MATCH;
                    $iStatus           = ERRCODE_PASSWORD_DOESNT_MATCH;
                }
            }
            else
            {
                $sErrorDescription = JSON_TAG_HASHED_PASSWORD_NULL;
                $iStatus           = ERRCODE_HASHED_PASSWORD_NULL;
            }*/
        }
        else
        {
            $sErrorDescription = JSON_TAG_POSTDATA_ERROR;
            $iStatus           = ERRCODE_FIELD_EMPTY;
        }
        if($iStatus !== 0)
        {
            $aResult = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $iStatus,
                JSON_TAG_DESC   => $sErrorDescription,
                JSON_TAG_ERRORS => array()
            );
        }

        return $aResult;
    }
    public function renew_subscription($clientId, $consumerId, $inaPostData)
    {
        $ConnBean     = new COREDbManager();
        $aResult = array();
        $consumer_emailid = null;
        $ConsumerDB  = new COREConsumerDB();
        $expiry_timestamp      = $inaPostData['expiry_timestamp'];
        if(array_key_exists('consumer_emailid', $inaPostData)) {
            $consumer_emailid = $inaPostData['consumer_emailid'];
        }

        $aResult = $ConsumerDB->renew_subscription($ConnBean, $clientId, $expiry_timestamp, $consumerId, $consumer_emailid);                
        return $aResult;        
    }
    
    public function check_subscription($consumerId)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();
        $aResult = $ConsumerDB->check_subscription($ConnBean, $consumerId);
        $ConnBean = null;

        return $aResult;
    }
    
    public function updateWPConsumer($clientId, $inaPostData)
    {
        $ConnBean     = new COREDbManager();
        $aResult = array();
        $consumer_firstname = null;
        $consumer_lastname = null;
        $consumer_emailid = null;
        $consumer_wpid = null;
        $ConsumerDB  = new COREConsumerDB();
        if(array_key_exists('consumer_firstname', $inaPostData)) {
            $consumer_firstname = $inaPostData['consumer_firstname'];
        }
        if(array_key_exists('consumer_lastname', $inaPostData)) {
            $consumer_lastname = $inaPostData['consumer_lastname'];
        }
        if(array_key_exists('consumer_emailid', $inaPostData)) {
            $consumer_emailid = $inaPostData['consumer_emailid'];
        }
        if(array_key_exists('consumer_wpid', $inaPostData)) {
            $consumer_wpid = $inaPostData['consumer_wpid'];
        }

        $aResult = $ConsumerDB->updateWPConsumer($ConnBean, $clientId, $consumer_wpid, $consumer_firstname, $consumer_lastname, $consumer_emailid);                
        return $aResult;        
    }
    
    public function consumer_profile($clientId,$consumerId)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();
        $aResult = $ConsumerDB->consumer_profile($ConnBean, $clientId, $consumerId);
        $ConnBean = null;

        return $aResult;
    }
    
    public function capture_total_time_spent_life_time($clientId,$consumerId,$total_time_spent_life_time_in_sec)
    {
        $ConnBean   = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult    = array();

        $aResult = $ConsumerDB->capture_total_time_spent_life_time($ConnBean, $clientId, $consumerId,$total_time_spent_life_time_in_sec);
        $ConnBean = null;

        return $aResult;
    }
    
    public function request_opt($aPostData, $clientId) {
        $sEmail = $aPostData[JSON_TAG_EMAIL];
        $sOtpValue = isset($aPostData[JSON_TAG_OTP_VALUE]) ? $aPostData[JSON_TAG_OTP_VALUE] : null;
        $sRequestOtp = $aPostData[JSON_TAG_REQUEST_OTP];

        $ConnBean = new COREDbManager();
        $ConsumerDB = new COREConsumerDB();
        $aResult = array();
        $aResult[JSON_TAG_IS_OTP_VALIDATED] = true;
        $aResult[JSON_TAG_TYPE] = JSON_TAG_SUCCESS;
        $aResult[JSON_TAG_OTP_NEEDED] = 0;

        $otp_data = $ConsumerDB->is_otp_validated($ConnBean, $clientId, $sEmail);
        if($otp_data['client_match'] === 0) {
            $aResult['client_match'] = $otp_data['client_match'];
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_DESC] = EMAIL_NOT_FOUND_ERROR;
            $aResult[JSON_TAG_IS_OTP_VALIDATED] = false;
            $aResult[JSON_TAG_OTP_NEEDED] = 1;
            return $aResult;
        }
        if ($sRequestOtp === false && !empty($sOtpValue) && $sOtpValue == $otp_data[JSON_TAG_OTP_VALUE]) {

            $ConsumerDB->update_otp_value($ConnBean, $clientId, $sEmail, $sOtpValue, 1);
            $sErrorDescription = "Success";
            $aResult[JSON_TAG_TYPE] = JSON_TAG_SUCCESS;
            $aResult[JSON_TAG_IS_OTP_VALIDATED] = true;
            $aResult[JSON_TAG_DESC] = $sErrorDescription;
            $aResult[JSON_TAG_OTP_NEEDED] = 0;
        } else if ($sRequestOtp === false && !empty($sOtpValue) && $sOtpValue != $otp_data[JSON_TAG_OTP_VALUE]) {

            $sErrorDescription = "OPT is incorrect";
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_DESC] = $sErrorDescription;
            $aResult[JSON_TAG_IS_OTP_VALIDATED] = false;
            $aResult[JSON_TAG_OTP_NEEDED] = 1;
        } else if ($sRequestOtp === true && empty($sOtpValue) && $otp_data[JSON_TAG_IS_OTP_VALIDATED] == 0) {

            if (empty($otp_data[JSON_TAG_OTP_VALUE])) {
                $otp_value = $this->generateRandomString(JSON_TAG_IS_OTP_LENGTH); // generate random 4 digit OTP            
                if (!$this->send_OTP_Mail($otp_value, $sEmail)) {// send mail  
                    $ConsumerDB->update_otp_value($ConnBean, $clientId, $sEmail, $otp_value, 0);
                }
                $sErrorDescription = "OTP is sent to your email";
                $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
                $aResult[JSON_TAG_DESC] = $sErrorDescription;
                $aResult[JSON_TAG_OTP_NEEDED] = 1;

                $aResult[JSON_TAG_OTP_VALUE] = $otp_value;
                $aResult[JSON_TAG_IS_OTP_VALIDATED] = false;
            } else if (!empty($otp_data[JSON_TAG_OTP_VALUE]) && $otp_data[JSON_TAG_IS_OTP_VALIDATED] == 0) {
                $otp_value = $otp_data[JSON_TAG_OTP_VALUE];
                $this->send_OTP_Mail($otp_value, $sEmail);

                $sErrorDescription = "OTP is sent to your email";
                $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
                $aResult[JSON_TAG_DESC] = $sErrorDescription;
                $aResult[JSON_TAG_OTP_NEEDED] = 1;


                $aResult[JSON_TAG_OTP_VALUE] = $otp_value;
                $aResult[JSON_TAG_IS_OTP_VALIDATED] = false;
            }
        } else if ($otp_data[JSON_TAG_IS_OTP_VALIDATED] == 0) {
            $sErrorDescription = "Needs otp to validate your account, Please check your email for OTP";
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_DESC] = $sErrorDescription;
            $aResult[JSON_TAG_OTP_NEEDED] = 1;

            $aResult[JSON_TAG_IS_OTP_VALIDATED] = false;
        }

        $ConnBean = null;

        return $aResult;
    }

    private function generateRandomString($length = 8) {
        // chars
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-+';
        $chars = '0123456789';

        // convert to array
        $arr = str_split($chars, 1);

        // shuffle the array
        shuffle($arr);
        $randomString = substr(implode('', $arr), 0, $length);

        return $randomString;
    }

    private function send_OTP_Mail($token, $to) {
        $Mail = new CORESendMail();
        $subject = 'THE BUSINESS JOURNALS - Login OTP';
        $message = "You are receiving this email because your address was entered in the forgotten password form when signing in to The Business Journals.\n\n" .
                "To recover your account and reset your password, please click here:\n" . BASE_URL_STRING . "resetpassword?t=$token\n\nIf you believe you have received this email in error, please ignore it.\n\n" .
                "Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of THE BUSINESS JOURNALS App.";
        $message = "OTP : $token";
        $headers = 'From: ' . NO_REPLY_EMAIL_FROM_ADDRESS . "\r\n";
        return $Mail->sendEmail($to, $subject, $message, $headers);
    }

}
