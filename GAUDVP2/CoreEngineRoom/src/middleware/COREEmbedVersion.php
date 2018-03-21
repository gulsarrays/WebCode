<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREEmbedVersion.php
  Description                 : Embed version in Api  header
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

/**
 * Class COREEmbedVersion
 */
class COREEmbedVersion extends \Slim\Middleware
{
    /**
     *
     */
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Run inner middleware and application
        $this->next->call();

        $iOSAppVersion       = $this->GetLatestiOSVersion();
        $androidVersionsData = $this->GetLatestAndroidVersion();

        // Update the Response to have version header
        $app->response->headers->set('AUDVISOR-SERVER-API-CURRENT-VERSION', $this->GetLatestServerAPIVersion());
        $app->response->headers->set('AUDVISOR-SERVER-API-MINIMUM-VERSION', '1');

        if($iOSAppVersion)
        {
            $app->response->headers->set('AUDVISOR-IOS-APP-VERSION', $iOSAppVersion);
        }
        if($androidVersionsData)
        {
            $app->response->headers->set('AUDVISOR-ANDROID-APP-VERSION', $androidVersionsData);
        }
    }

    /**
     * @return null
     */
    private function GetLatestiOSVersion()
    {
        return $this->GetLatestPlatformVersion(1);
    }

    /**
     * @return null
     */
    private function GetLatestAndroidVersion()
    {
        return $this->GetLatestPlatformVersion(2);
    }

    /**
     * @return null|string
     */
    private function GetLatestServerAPIVersion()
    {
        $ServerAPIVersion = $this->GetLatestPlatformVersion(3);
        if(!isset($ServerAPIVersion))
        {
            $ServerAPIVersion = '1';
        }

        return $ServerAPIVersion;
    }

    /**
     * @param $platform
     *
     * @return null
     */
    private function GetLatestPlatformVersion($platform)
    {
        $versionsModel = new COREVersionsModel();
        $versionsData  = $versionsModel->latest_version($platform);

        $platformVersion = null;
        if(isset($versionsData[JSON_TAG_BUNDLE_VERSION]))
        {
            $platformVersion = $versionsData[JSON_TAG_BUNDLE_VERSION];
        }

        return $platformVersion;
    }
}

?>