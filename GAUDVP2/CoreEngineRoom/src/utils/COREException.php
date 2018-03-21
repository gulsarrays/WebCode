<?php

/*
  Project                     : Audvisor
  Module                      : Utils
  File name                   : COREException.php
  Owner                       : vipinps13@gmail.com
 */

class COREException {
    
    public function __construct() {
        
    }

    public function customClientIdError($errorId,$errorMessage) {
       
        $aResult           = array(
                JSON_TAG_TYPE   => JSON_TAG_ERROR,
                JSON_TAG_CODE   => $errorId,
                JSON_TAG_DESC   => $errorMessage,
                JSON_TAG_ERRORS => array()
            );
        
        return $aResult;
        
    }
    
}
