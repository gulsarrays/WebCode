<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREInsightUrl.php
  Description                 : Getting insight urls
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREInsightUrl
{
    
    /**
     * Function to get all insight urls.         
     */
    public function getInsightUrls()
    {

        $GenMethods = new COREGeneralMethods();
        $ConnBean   = new COREDbManager();
        $sQuery     = "SELECT fldid,fldinsighturl,fldduration FROM tblinsights";
        $ConnBean->getPreparedStatement($sQuery);
        $result       = $ConnBean->resultset();
        $insight_urls = array();
        foreach($result as $insight)
        {
            $url      = $insight['fldinsighturl'];
            $baseName = basename($url);

            $insight_url['fldid']            = $insight['fldid'];
            $insight_url['fldinsighturl']    = $baseName;
            $insight_url['current_url']      = $url;
            $insight_url['current_duration'] = $insight['fldduration'];
            array_push($insight_urls, $insight_url);
        }
        $GenMethods->generateResult($insight_urls);
    }
}
