<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREAwsBridge.php
  Description                 : Generic functions
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */ 

class COREGeneralMethods{


    public function __construct()
    {
    }

    /*
      Function            : encodeJson($inaRes)
      Brief               : Function used to display the result in json format.
      Details             : Function used to display the result in json format.
      Input param         : res - result in array
      Input/output param  : Nil
      Return              : Outputs Json data
     */

    public function encodeJson($inaRes)
    {
        $Req = \Slim\Slim::getInstance();
        $Req->contentType('application/json');
        echo json_encode($inaRes);
    }

    /*
      Function            : decodeJson($injData)
      Brief               : Function used to decode input json.
      Details             : Function used to decode input json.
      Input param         : Json data
      Input/output param  : Nil
      Return              : Outputs array
     */

    public function decodeJson($injData)
    {

        $bvalid = true;
        if($injData == "" || !$injData)
        {
            $bvalid = false;
        }
        else
        {
            $aDecoded = json_decode($injData, true);
            if(!is_array($aDecoded))
            {
                $bvalid = false;
            }
        }

        if($bvalid)
        {
            return $aDecoded;
        }
        else
        {
            return array(
                JSON_TAG_TYPE => JSON_TAG_ERROR,
                JSON_TAG_CODE => NULL,
                JSON_TAG_DESC => INVALID_JSON);
        }
    }

    public function generateResult($inaRes)
    {
        //if (count($inaRes) == 0 || !$inaRes) {
        //$sMsg = "No Records Found";
        //echo $sMsg;
        //}
        $Req = \Slim\Slim::getInstance();
        $Req->contentType('application/json');
        echo json_encode($inaRes);
    }

    /*
      Function            : generateUUID()
      Brief               : Function used to generate UUID.
      Details             : Function used to generate UUID.
      Input param         : Nil
      Input/output param  : Nil
      Return              : Outputs UUID v4.
     */

    public function generateUUID()
    {

        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
                       mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
                       mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
                       mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function createHashedPassword($sPassword)
    {

        $aData        = array();
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';

        $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $Chars_Len     = 63;

        // 18 would be secure as well.
        $Salt_Length = 21;

        //$mysql_date = date('Y-m-d');
        $salt = "";

        for($i = 0; $i < $Salt_Length; $i++)
        {
            $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
        }
        $bcrypt_salt = $Blowfish_Pre.$salt.$Blowfish_End;

        $hashed_password     = crypt($sPassword, $bcrypt_salt);
        $aData['hashedPass'] = $hashed_password;
        $aData['salt']       = $salt;

        return $aData;
    }

    public function bCrypt($insPassword, $sSalt)
    {

        //This string tells crypt to use blowfish for 5 rounds.
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';
        $bcrypt_salt  = ($Blowfish_Pre.$sSalt.$Blowfish_End);

        $hashed_password = crypt($insPassword, $bcrypt_salt);

        return $hashed_password;
    }

    function random_filename($length)
    {
        $key  = '';
        $keys = array_merge(range('0', '9'), range('a', 'z'));

        for($i = 0; $i < $length; $i++)
        {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    function isJSON($string)
    {
        return is_string($string) && is_object(json_decode($string)) ? true : false;
    }
    
    public function encodeClientId($clientId)
    {
       return ($clientId) ? base64_encode($clientId) : NULL;
    }
    public function decodeClientId($clientId)
    {
       return ($clientId) ? base64_decode($clientId) : NULL;
    }
    
    public function genarateJwtToken($userId) {
        $key = "test";
        $data = [
            'id' => $userId,
        ];
        $jwt = \Firebase\JWT\JWT::encode($data, $key, 'HS256');
        return $jwt;
    }

    public function genarateJwtTokenFromHeader($Request) {
        try {
            $key = "test";
            if($Request->Authorization){
                $decoded = \Firebase\JWT\JWT::decode($Request->Authorization, $key, array('HS256'));
                return $decoded->id;
            }else{
                return NULL;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getUserGroup($userId)
    {
         try {
             $consumerModel = new COREConsumerModel();
             $groupModel = new COREGroupModel();
             $consumer = $consumerModel->getConsumerProfile($userId);
             $group =  $groupModel->getgroup($consumer['group_id']);
             return $group;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
