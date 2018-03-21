<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREJsonApiView.php
  Description                 : Renders input as json
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREJsonApiView extends \Slim\View
{
    public function render($data, $arg = null)
    {
        $app = \Slim\Slim::getInstance();
        $app->response()->header('Content-Type', 'application/json');
        $app->response()->body(json_encode($data));
        $app->stop();
    }
}
