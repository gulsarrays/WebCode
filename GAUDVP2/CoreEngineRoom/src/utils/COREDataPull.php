<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREDataPull.php
  Description                 : Pulling data from consumeranalytics table
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREDataPull
{
    /**
     * Function to get insights count for a consumer from consumer analytics and store in tblcainsights.
     */
    public function getInsightsData()
    {
        $ConnBean = new COREDbManager();
        if($ConnBean)
        {
            $sQuery = "SELECT fldconsumerid, fldreceiverid,fldactiondata FROM `tblconsumeranalytics` WHERE (( fldactionid =2 AND fldactiondata >= 50) OR fldactionid =5)";
            $ConnBean->getPreparedStatement($sQuery);
            $ca_result = $ConnBean->resultset();

            foreach($ca_result as $row)
            {
                $fldconsumerid = $row['fldconsumerid'];
                $fldinsightid  = $row['fldreceiverid'];
                $count         = 1;
                $sQuery        = "select fldcount from tblcainsights where fldconsumerid=$fldconsumerid and fldinsightid=$fldinsightid";
                $ConnBean->getPreparedStatement($sQuery);

                $result = $ConnBean->single();
                if(!empty($result))
                {
                    $count  = $result['fldcount'] + 1;
                    $sQuery = "update tblcainsights set fldcount=$count where fldconsumerid=$fldconsumerid and fldinsightid=$fldinsightid";
                    $ConnBean->getPreparedStatement($sQuery);
                    $iexec_result = $ConnBean->execute();
                }
                else
                {
                    $sQuery = "insert into tblcainsights (fldconsumerid, fldinsightid,fldcount) values ($fldconsumerid,$fldinsightid, $count)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $iexec_result = $ConnBean->execute();
                }

                if($iexec_result)
                {
                    $this->getExpertsData($row);
                    $this->getTopicsData($row);
                }
            }
        }
    }

    /**
     * Function to get experts count for a consumer from consumer analytics and store in tblcaexperts.
     */
    public function getExpertsData($result)
    {
        $ConnBean = new COREDbManager();
        if($ConnBean)
        {
            $consumerid = $result['fldconsumerid'];
            $insightid  = $result['fldreceiverid'];
            $sQuery     = "select fldexpertid from tblinsights where fldid=$insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->single();
            if(is_array($result))
            {

                $expertid = $result['fldexpertid'];
                $sQuery   = "select fldcount from tblcaexperts where fldconsumerid=$consumerid and fldexpertid=$expertid";
                $ConnBean->getPreparedStatement($sQuery);
                $row = $ConnBean->single();
                if(!empty($row))
                {
                    $count  = $row['fldcount'] + 1;
                    $sQuery = "update tblcaexperts set fldcount=$count where fldconsumerid=$consumerid and fldexpertid= $expertid";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->execute();
                }
                else
                {
                    $count  = 1;
                    $sQuery = "insert into tblcaexperts (fldconsumerid, fldexpertid,fldcount) values ($consumerid,$expertid, $count)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->execute();
                }
            }
        }
    }

    /**
     * Function to get topics count for a consumer from consumer analytics and store in tblcatopics.
     */
    public function getTopicsData($result)
    {
        $ConnBean = new COREDbManager();
        if($ConnBean)
        {
            $consumerid = $result['fldconsumerid'];
            $insightid  = $result['fldreceiverid'];
            $sQuery     = "select fldtopicid from tbltopicinsight where fldinsightid=$insightid";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            if(is_array($result))
            {
                foreach($result as $row)
                {
                    $topicid = $row['fldtopicid'];
                    $sQuery  = "select fldcount from tblcatopics where fldconsumerid=$consumerid and fldtopicid=$topicid";
                    $ConnBean->getPreparedStatement($sQuery);
                    $row = $ConnBean->single();

                    if(!empty($row))
                    {
                        $count  = $row['fldcount'] + 1;
                        $sQuery = "update tblcatopics set fldcount=$count where fldconsumerid=$consumerid and fldtopicid= $topicid";
                        $ConnBean->getPreparedStatement($sQuery);
                        $ConnBean->execute();
                    }
                    else
                    {
                        $count  = 1;
                        $sQuery = "insert into tblcatopics (fldconsumerid, fldtopicid,fldcount) values ($consumerid,$topicid, $count)";
                        $ConnBean->getPreparedStatement($sQuery);
                        $ConnBean->execute();
                    }
                }
            }
        }
    }
}
