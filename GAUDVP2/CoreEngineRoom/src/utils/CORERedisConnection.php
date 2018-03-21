<?php

/*
  Project                     : Oriole
  Module                      : RedisConnection
  File name                   : CORERedisConnection.php
  Description                 : Redis class for connection.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class CORERedisConnection
{

    private static $redisInstance = null;

    /**
     * Function to connect to Redis
     *
     * @return redis instance
     */
    public static function getRedisInstance()
    {
        if(self::$redisInstance == null)
        {
            self::$redisInstance = new Predis\Client(array(
                                                         "scheme" => REDIS_SCHEME,
                                                         "host"   => REDIS_DB_HOST,
                                                         "port"   => REDIS_PORT));
        }

        return self::$redisInstance;
    }
}
