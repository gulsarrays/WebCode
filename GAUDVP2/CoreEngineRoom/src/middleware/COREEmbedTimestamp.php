<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREEmbedTimeStamp.php
  Description                 : Embed timestamp in Api response header
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREEmbedTimestamp
 */
class COREEmbedTimestamp extends \Slim\Middleware
{
    /**
     *
     */
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        $startTime = microtime(true);

        // Run inner middleware and application
        $this->next->call();

        $endTime    = microtime(true);
        $time_taken = $endTime - $startTime;
        $app->response->headers->set('AUDVISOR-SERVER-API-COST', $time_taken);
    }
}

?>