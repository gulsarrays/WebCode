<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREGroupModel.php
  Description                 : Model class for Gruop activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREAdminModel
 */
class COREGroupModel
{

    public function __construct()
    {
    }

    public function getGroupList($clientId=null)
    {
        $aResult    = array();
        $ConsumerDB = new COREGroupDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->getGroupList($ConnBean,$clientId);
        
            if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {                
                $aResult[JSON_TAG_TYPE]   = JSON_TAG_GROUPS;
                if(empty($aList[JSON_TAG_RECORDS])) {
                    $aResult[JSON_TAG_GROUPS] = [];
                } else {
                    $aResult[JSON_TAG_GROUPS] = $aList[JSON_TAG_RECORDS];
                }
                
            }
            if($aList[JSON_TAG_STATUS] != ERRCODE_NO_ERROR)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => $iStatus,
                    JSON_TAG_DESC => $sErrDescription,
                );
            }
                  
        }
        catch(Exception $e)
        {
          
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
    
    public function getgroup($groupId)
    {
       
        $GroupDB = new COREGroupDB();
        $ConnBean   = new COREDbManager();
        $bResult    = array();
        try
        {
            $group = $GroupDB->getgroup($ConnBean, $groupId);
        }catch (Exception $e) {
            return $e->getMessage();
        }
        return $group;
    }
    
    public function getDefaultGroup($clientId=null)
    {
        $aResult    = array();
        $ConsumerDB = new COREGroupDB();
        $ConnBean   = new COREDbManager();
        try
        {
            $aList = $ConsumerDB->getDefaultGroup($ConnBean,$clientId);
        
            if($aList[JSON_TAG_STATUS] == SERVER_EXCEPTION_UNKNOWN_ERROR)
            {
                $iStatus         = SERVER_EXCEPTION_UNKNOWN_ERROR;
                $sErrDescription = UNKNOWN_ERROR;
            }
            else
            {                
                $aResult[JSON_TAG_TYPE]   = JSON_TAG_GROUPS;
                if(empty($aList[JSON_TAG_RECORDS])) {
                    $aResult[JSON_TAG_GROUPS] = [];
                } else {
                    $aResult[JSON_TAG_GROUPS] = $aList[JSON_TAG_RECORDS];
                }
                
            }
            if($aList[JSON_TAG_STATUS] != ERRCODE_NO_ERROR)
            {
                $aResult = array(
                    JSON_TAG_TYPE => JSON_TAG_ERROR,
                    JSON_TAG_CODE => $iStatus,
                    JSON_TAG_DESC => $sErrDescription,
                );
            }
                  
        }
        catch(Exception $e)
        {
          
            echo $e->getMessage();
        }
        $ConnBean = null;

        return $aResult;
    }
}