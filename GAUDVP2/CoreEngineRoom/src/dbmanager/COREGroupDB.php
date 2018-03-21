<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREAdminManagerDB.php
  Description                 : Database class for admin related activities
  Copyright                   : Copyright © 2014, Audvisor Inc.
  History                     :
 */

class COREGroupDB {

    public function __construct() {
        
    }

    public function getGroupList($ConnBean,$clientId=null) {
        $iResult = array();
        try {
            if(!empty($clientId)) {
                $sQuery = "SELECT g.fldid, g.fldname ,g.created_at FROM tblgroups g where   g.client_id = '".$clientId."'  and g.is_primary != '1'  GROUP BY g.fldid ORDER BY g.created_at,g.is_primary DESC ";          
            } else {
            $sQuery = "SELECT g.fldid, g.fldname ,g.created_at FROM tblgroups g  GROUP BY g.fldid ORDER BY g.created_at DESC ";
            }
                   
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();          
            foreach($result as $group)
            {
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_ID => intval($group[DB_COLUMN_FLD_ID]), JSON_TAG_TITLE => $group[DB_COLUMN_FLD_NAME]);
            }
            $iResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
        } catch (Exception $e) {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }

        return $iResult;
    }

    
    public function getgroup($ConnBean,$groupId)
    {
        try
        {
            $sQuery = "SELECT *  FROM tblgroups WHERE fldid = :group_id";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':group_id', $groupId);
            $result = $ConnBean->single();
        }
        catch(Exception $e)
        {
             return $e->getMessage();
        }
       
         return $result;
    }
    
    public function getDefaultGroup($ConnBean,$clientId)
    {       
        $iResult = array();
        try {
            $sQuery = "SELECT g.fldid, g.fldname ,g.created_at FROM tblgroups g where g.client_id = '".$clientId."'  and g.is_primary = '1' ";
                   
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();          
            foreach($result as $group)
            {
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_ID => intval($group[DB_COLUMN_FLD_ID]), JSON_TAG_TITLE => $group[DB_COLUMN_FLD_NAME], 'is_primary' => 'yes');
            }
            $iResult[JSON_TAG_STATUS] = ERRCODE_NO_ERROR;
        } catch (Exception $e) {
            $iResult[JSON_TAG_STATUS] = SERVER_EXCEPTION_UNKNOWN_ERROR;
        }
        return $iResult;
    }
}
