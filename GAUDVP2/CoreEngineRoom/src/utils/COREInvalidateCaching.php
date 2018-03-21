<?php

/*
  Project                     : Oriole
  Module                      : InvalidateCaching
  File name                   : COREInvalidateCaching.php
  Description                 : Invalidate Redis Caching.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREInvalidateCaching
{

    /**
     * Function to invalidate Redis cache.
     *
     * @param $cacheKey
     *
     */
    public function invalidateCache($cacheKey)
    {
        $redis = CORERedisConnection::getRedisInstance();

        if($redis)
        {
            $redis->del($cacheKey);
        }
    }

    /**
     * Function to generate test data for consumer analytics.
     */
    public function loadTestData()
    {
        $db = new COREDbManager();
        if($db)
        {
            for($i = 2000; $i < 12000; $i++)
            {
                $consumerid = $i;
                $sQuery     = "INSERT INTO tblconsumers (fldid,fldemailid, fldhashedpassword, fldcreateddate,fldmodifieddate) values ($consumerid,'abc@abc.com', 'abc123', NOW() ,NOW())";
                $db->getPreparedStatement($sQuery);
                $db->execute();

                for($j = 0; $j < 21000; $j++)
                {
                    $insightid = mt_rand(1, 1000);

                    $toss = mt_rand(1, 3);

                    switch($toss)
                    {
                        case 1:
                            $stmt = "INSERT INTO `tblconsumeranalytics` ( `fldconsumerid`, `fldreceiverid`, `fldactionid`, `fldactiondata`, `fldreceivertype`, `fldcreateddate`) VALUES( $consumerid,$insightid , 5, '1', 1, NOW() -INTERVAL 1 DAY)";
                            break;

                        case 2:
                            $stmt = "INSERT INTO `tblconsumeranalytics` ( `fldconsumerid`, `fldreceiverid`, `fldactionid`, `fldactiondata`, `fldreceivertype`, `fldcreateddate`) VALUES( $consumerid,$insightid , 2, '0.6', 1, NOW()-INTERVAL 1 DAY)";
                            break;

                        default:
                            $stmt = "INSERT INTO `tblconsumeranalytics` ( `fldconsumerid`, `fldreceiverid`, `fldactionid`, `fldactiondata`, `fldreceivertype`, `fldcreateddate`) VALUES( $consumerid,$insightid , 2, '0.3', 1, NOW()-INTERVAL 1 DAY)";
                            break;
                    }

                    $db->getPreparedStatement($stmt);
                    $db->execute();
                }
            }
        }
    }

    /**
     * Function to purge consumer analytics test data.
     */
    public function purgeTestData()
    {
        $db = new COREDbManager();
        if($db)
        {
            for($i = 2000; $i < 12000; $i++)
            {
                $stmt = "DELETE FROM `tblconsumers` where `fldid`= $i";
                $db->getPreparedStatement($stmt);
                $db->execute();
            }
        }
    }

    /**
     * Function to get all keys from Redis cache.
     * @return array
     */
    public function getCachedKeys()
    {
        $app   = \Slim\Slim::getInstance();
        $redis = CORERedisConnection::getRedisInstance();
        if($redis)
        {
            $keys = $redis->keys('*');
            $app->render($keys);
        }
    }

    /**
     * Function to get data from Redis cache.
     *
     * @param $cacheKey
     *
     * @return array
     */
    public function getCachedData($cacheKey)
    {
        $app   = \Slim\Slim::getInstance();
        $redis = CORERedisConnection::getRedisInstance();
        if($redis)
        {
            $cachedData = $redis->get($cacheKey);
            if($cachedData)
            {
                $cachedData = json_decode($cachedData, true);
                $app->render($cachedData);
            }
        }
    }

    /**
     * Function to cache topic ids for all insights.
     */
    public function cacheTopicIdsForInsights()
    {

        $redis  = CORERedisConnection::getRedisInstance();
        $db     = new COREDbManager();
        $sQuery = "SELECT  i.fldid,group_concat(t.fldtopicid) AS topics FROM tblinsights AS i  LEFT JOIN tbltopicinsight AS t ON t.fldinsightid=i.fldid GROUP BY i.fldid ";
        $db->getPreparedStatement($sQuery);
        $result = $db->resultset();
        foreach($result as $insight)
        {
            $cacheKey = "insight".$insight['fldid'];
            if($redis)
            {
                $redis->set($cacheKey, json_encode($insight['topics']));
            }
        }
    }

    /**
     * Function to invalidate topic ids from Redis cache.
     */
    public function invalidateCacheForTopicIds()
    {
        $redis  = CORERedisConnection::getRedisInstance();
        $db     = new COREDbManager();
        $sQuery = "SELECT  fldid FROM tblinsights";
        $db->getPreparedStatement($sQuery);
        $result = $db->resultset();
        foreach($result as $insight)
        {
            $cacheKey = "insight".$insight['fldid'];
            if($redis)
            {
                $redis->del($cacheKey);
            }
        }
    }
}
