<?php

/*
  Project                     : Audvisor
  Module                      : Utils
  File name                   : CORERequest.php
  Owner                       : vipinps13@gmail.com
 */

class CORERequest {

    public function __construct() {
        
    }

    public function getHeaderAuthorizationParam($Request) {
       try {
            return $Request->Authorization;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
    public function getHeaderAcceptParam($Request) {
       try {
            return $Request->Accept;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
