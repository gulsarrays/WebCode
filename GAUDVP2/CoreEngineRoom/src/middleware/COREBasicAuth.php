<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREBasicAuth.php
  Description                 : Basic Authentication for apis
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * @param $role
 *
 * @return callable
 */
function authorizeForRoles($role)
{
    return function (\Slim\Route $route) use ($role)
    {
        $isAuthorized     = false;
        $errorCode        = 900;
        $errorDescription = "Authorization failed.";

        $app         = \Slim\Slim::getInstance();
        $username    = $app->request()->headers('PHP_AUTH_USER');
        $password    = $app->request()->headers('PHP_AUTH_PW');
        $requestPath = $app->request()->getPath();
        if(!(in_array("admin", $role) && isset($_SESSION[APP_SESSION_NAME])))
        {
            if(isset($username) && isset($password))
            {
                do
                {
                    if(in_array("admin", $role))
                    {
                        $adminManager = new COREAdminModel();

                        if($adminManager->authenticateAdminUser($username, $password) == 0)
                        {
                            $isAuthorized = true;
                            break;
                        }
                    }

                    if(in_array("consumer", $role))
                    {
                        $ConsumerModel = new COREConsumerModel();

                        $validConsumerCredentials = false;
                        $validAccessRequest       = true;

                        list(, $consumerID) = explode('consumers/', $requestPath);
                        list($consumerID) = explode('/', $consumerID);

                        if($validAccessRequest && $ConsumerModel->authorize($username, $password, $consumerID) > 0)
                        {
                            $validConsumerCredentials = true;
                        }
                        else
                        {
                            $validAccessRequest = false;
                            $errorCode          = 901;
                            $errorDescription   = "Illegal API.";
                        }
                        if($validConsumerCredentials && $validAccessRequest)
                        {
                            $isAuthorized = true;
                        }
                    }
                } while(0);
            }

            if(!$isAuthorized)
            {
                $app->response()->header('WWW-Authenticate', 'Basic realm="API Authorization"');
                $response['Content-Type'] = 'application/json';
                $responseJson             = '{"type":"error","code":'.$errorCode.',"description":"'.$errorDescription.'","error":[]}';
                $app->halt(401, $responseJson);
            }
        }
    };
}

?>