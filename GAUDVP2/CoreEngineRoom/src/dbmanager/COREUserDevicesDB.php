<?php

/*
  Project                     : Oriole
  Module                      : UserDevice
  File name                   : COREUserDevicesDB.php
  Description                 : Database class for User Devices
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREUserDevicesDB
{

    public function __construct()
    {
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $consumerID
     * @param $sDeviceID
     * @param $sPlatformID
     * @param $sNotificationID
     *
     * @return mixed
     */

    public function AddUserDevice($ConnBean, $consumerID, $sDeviceID, $sPlatformID, $sNotificationID)
    {
        $bResultValue = false;

        $sQuery = "INSERT INTO tbluserdevices (fldconsumerid, flddeviceid, fldnotificationid, fldplatformid, fldcreateddate) VALUES (:consumerID, :deviceID, :notificationID, :platformID, NOW())";

        try
        {
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":consumerID", $consumerID);
            $ConnBean->bind_param(":deviceID", $sDeviceID);
            $ConnBean->bind_param(":notificationID", $sNotificationID);
            $ConnBean->bind_param(":platformID", $sPlatformID);
            $bResultValue = $ConnBean->execute();
            $userDeviceID = $ConnBean->lastInsertId();

            if($sNotificationID)
            {
                $this->RegisterAndSubscribeDeviceForNotification($ConnBean, $sPlatformID, $sDeviceID, $sNotificationID, $userDeviceID);
            }
        }
        catch(Exception $e)
        {
        }

        return $bResultValue;
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sDeviceID
     *
     * @return mixed
     */

    public function DeleteUserDevice($ConnBean, $sDeviceID)
    {
        $bResult = false;

        $this->UnRegisterAndUnSubscribeDeviceForNotification($ConnBean, $sDeviceID);

        $sQuery = "DELETE FROM tbluserdevices WHERE flddeviceid = :deviceID";
        try
        {
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":deviceID", $sDeviceID);
            $bResult = $ConnBean->execute();
        }
        catch(Exception $e)
        {
        }

        return $bResult;
    }

    /**
     * @param $ConnBean
     * @param $sConsumerID
     */
    public function DeleteAllDevicesOfUser($ConnBean, $sConsumerID)
    {
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sConsumerID
     * @param $sDeviceID
     * @param $sPlatformID
     * @param $sNotificationID
     *
     * @return bool
     */
    public function UpdateUserDevice($ConnBean, $sConsumerID, $sDeviceID, $sPlatformID, $sNotificationID)
    {
        $bResult = false;

        if($ConnBean && $sConsumerID && $sDeviceID && $sPlatformID && $sNotificationID)
        {
            $aDeviceAttributes = array();

            $aDeviceAttributes[":platformid"]     = $sPlatformID;
            $aDeviceAttributes[":notificationid"] = $sNotificationID;

            $bResult = $this->PatchUserDevice($ConnBean, $sConsumerID, $sDeviceID, $aDeviceAttributes);
        }

        return $bResult;
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sDeviceID
     * @param $sNewConsumerID
     *
     * @return bool
     */
    public function PatchUserDeviceOwner($ConnBean, $sDeviceID, $sNewConsumerID)
    {
        $bResult = false;

        if($ConnBean && $sNewConsumerID && $sDeviceID)
        {
            $sQuery = "UPDATE tbluserdevices SET fldconsumerid = :newConsumerID WHERE flddeviceid = :deviceID";

            try
            {
                $ConnBean->getPreparedStatement($sQuery);

                $ConnBean->bind_param(":deviceID", $sDeviceID);
                $ConnBean->bind_param(":newConsumerID", $sNewConsumerID);

                $bResult = $ConnBean->execute();
            }
            catch(Exception $e)
            {
            }
        }

        return $bResult;
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sConsumerID
     * @param $sDeviceID
     * @param $aDeviceAttributes
     *
     * @return bool
     */
    public function PatchUserDevice($ConnBean, $sConsumerID, $sDeviceID, $aDeviceAttributes)
    {
        $bResult                   = false;
        $bWillUpdateNotificationID = false;

        $sPlatformID     = empty($aDeviceAttributes[":platformid"]) ? null : $aDeviceAttributes[":platformid"];
        $sNotificationID = empty($aDeviceAttributes[":notificationid"]) ? null : $aDeviceAttributes[":notificationid"];

        //TODO: The current implementation is a compromise to maintain backward compatibility with the old code.
        // Instead have something like: foreach ($aDeviceAttributes as $attributeName => $attributeValue) {}

        if($ConnBean && $sConsumerID && $sDeviceID && ($sPlatformID || $sNotificationID))
        {
            $sQuery = "UPDATE tbluserdevices SET"." ";

            if($sPlatformID)
            {
                $sQuery .= "fldplatformid = :platformID,"; //k Ensure that it always ends with a comma. It needs to be stripped if more attributes are not added.
            }

            if($sNotificationID)
            {
                $sQuery .= "fldnotificationid = :notificationID ";
                $bWillUpdateNotificationID = true;
            }

            $sQuery = rtrim($sQuery, ','); //k remove any extra commas.

            $sQuery .= " WHERE fldconsumerid = :consumerID AND flddeviceid = :deviceID";

            try
            {
                $sUserDeviceID      = null;
                $sOldPlatformID     = null;
                $sOldNotificationID = null;

                if($bWillUpdateNotificationID)
                {
                    //k Backup the old notification ID for un subscription.

                    $getOldNotificationIDQuery = "SELECT `fldid`, `fldplatformid`, `fldnotificationid` FROM `tbluserdevices` WHERE `flddeviceid` = :deviceID";
                    $ConnBean->getPreparedStatement($getOldNotificationIDQuery);
                    $ConnBean->bind_param(":deviceID", $sDeviceID);
                    $getCurrentDeviceInfo = $ConnBean->single();

                    if($getCurrentDeviceInfo)
                    {
                        $sUserDeviceID      = $getCurrentDeviceInfo[DB_COLUMN_FLD_ID];
                        $sOldPlatformID     = $getCurrentDeviceInfo['fldplatformid'];
                        $sOldNotificationID = $getCurrentDeviceInfo['fldnotificationid'];
                    }
                }

                $ConnBean->getPreparedStatement($sQuery);

                $ConnBean->bind_param(":deviceID", $sDeviceID);
                $ConnBean->bind_param(":consumerID", $sConsumerID);

                if($sPlatformID)
                {
                    $ConnBean->bind_param(":platformID", $sPlatformID);
                }

                if($sNotificationID)
                {
                    $ConnBean->bind_param(":notificationID", $sNotificationID);
                }

                $bResult = $ConnBean->execute();

                if($bWillUpdateNotificationID && $bResult)
                {
                    //k Get the old notification ID and un-subscribe it.
                    //k Add and subscribe for new notification ID.
                    if($sNotificationID != $sOldNotificationID)
                    {
                        //k Update AWS to remove all SES subscriptions for the device and remove endpoint ARN.
                        $this->UnRegisterAndUnSubscribeDeviceForNotification($ConnBean, $sDeviceID);

                        //k This will remove all SES subscriptions references in the app DB.
                        $this->DeleteDeviceSubscriptions($ConnBean, $sUserDeviceID);

                        $sPlatformID = empty($sPlatformID) ? $sOldPlatformID : $sPlatformID;
                        //k Update AWS to get a new endpoint ARN and re-subscribe for SES topics.
                        $this->RegisterAndSubscribeDeviceForNotification($ConnBean, $sPlatformID, $sDeviceID, $sNotificationID, $sUserDeviceID);
                    }
                }
            }
            catch(Exception $e)
            {
            }
        }

        return $bResult;
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sPlatformID
     * @param $sDeviceID
     * @param $sNotificationID
     * @param $userDeviceID
     */
    private function RegisterAndSubscribeDeviceForNotification($ConnBean, $sPlatformID, $sDeviceID, $sNotificationID, $userDeviceID)
    {
        try
        {
            $AwsSNSBridge = new COREAwsSNSBridge();
            $platform     = (2 == $sPlatformID) ? COREAwsSNSBridge::ConsumerDevicePlatformAndroid : COREAwsSNSBridge::ConsumerDevicePlatformIOS;
            $deviceARN    = $AwsSNSBridge->registerConsumerDevice($sDeviceID, $sNotificationID, $platform);

            if($deviceARN)
            {
                $sQuery = "UPDATE tbluserdevices SET fldendpointARN = :endpointARN WHERE flddeviceid = :deviceID";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":deviceID", $sDeviceID);
                $ConnBean->bind_param(":endpointARN", $deviceARN);
                $ConnBean->execute();

                //k Auto subscribe for broadcast notification.

                $subscriptionARN = $AwsSNSBridge->subscribeConsumerDeviceForNotification(COREAwsSNSBridge::AudvisorBroadcastNotification, $deviceARN);

                $sQuery = "INSERT INTO tbluserdevicesnotificationsubscriptions (flduserdeviceid, fldsubscriptionARN, fldcreateddate) VALUES (:userDeviceID, :subscriptionARN, NOW())";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":userDeviceID", $userDeviceID);
                $ConnBean->bind_param(":subscriptionARN", $subscriptionARN);
                $ConnBean->execute();
            }
        }
        catch(Exception $e)
        {
            //k At this moment we ignore any error encountered for push notification registration as this is not critical. One common use case it notification ID not being valid.
        }
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sDeviceID
     *
     */
    private function UnRegisterAndUnSubscribeDeviceForNotification($ConnBean, $sDeviceID)
    {
        try
        {
            //k The plan
            // 1. Get endpointARN for the device
            // 2. Get all subscriptionARNs for the device.
            // 3. Un-subscribe for all the subscriptionARNs in SNS.
            // 4. Delete the endpointARN from SNS.

            $sQuery = "SELECT `".DB_UD_COLUMN_FLD_ID."`, `".DB_UD_COLUMN_FLD_ENDPOINT_ARN."` FROM `".DB_TABLE_USER_DEVICES."` WHERE `".DB_UD_COLUMN_FLD_DEVICE_ID."` = :deviceID";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(":deviceID", $sDeviceID);
            $currentDeviceInfo = $ConnBean->single();

            $sUserDeviceID = null;
            $endPointARN   = null;
            if($currentDeviceInfo)
            {
                $sUserDeviceID = $currentDeviceInfo[DB_COLUMN_FLD_ID];
                $endPointARN   = $currentDeviceInfo[DB_UD_COLUMN_FLD_ENDPOINT_ARN];
            }

            if(!is_null($endPointARN))
            {
                $AwsSNSBridge = new COREAwsSNSBridge();

                $deviceSubscriptions = $this->GetDeviceSubscriptions($ConnBean, $sUserDeviceID);
                foreach($deviceSubscriptions as $deviceSubscription)
                {
                    $subscriptionARN = $deviceSubscription[DB_UDNS_COLUMN_FLD_SUBSCRIPTION_ARN];
                    if(!empty($subscriptionARN))
                    {
                        $AwsSNSBridge->unSubscribeConsumerDeviceForNotification($subscriptionARN);
                    }
                }

                $AwsSNSBridge->unRegisterConsumerDevice($endPointARN);
            }
        }
        catch(Exception $e)
        {
            //k At this moment we ignore any error encountered for push notification registration as this is not critical. One common use case it notification ID not being valid.
        }
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sUserDeviceID
     *
     * @return mixed
     */
    private function GetDeviceSubscriptions($ConnBean, $sUserDeviceID)
    {
        $sQuery = "SELECT `".DB_UDNS_COLUMN_FLD_SUBSCRIPTION_ARN."` FROM `".DB_TABLE_USER_DEVICES_NOTIFICATION_SUBSCRIPTIONS."` WHERE `".DB_UDNS_COLUMN_FLD_USER_DEVICE_ID."` = :userDeviceID";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":userDeviceID", $sUserDeviceID);
        $deviceSubscriptions = $ConnBean->resultset();

        return $deviceSubscriptions;
    }

    /**
     * @param $ConnBean COREDbManager
     * @param $sUserDeviceID
     *
     * @return mixed
     */
    private function DeleteDeviceSubscriptions($ConnBean, $sUserDeviceID)
    {
        $sQuery = "DELETE FROM `".DB_TABLE_USER_DEVICES_NOTIFICATION_SUBSCRIPTIONS."` WHERE `".DB_UDNS_COLUMN_FLD_USER_DEVICE_ID."` = :userDeviceID";
        $ConnBean->getPreparedStatement($sQuery);
        $ConnBean->bind_param(":userDeviceID", $sUserDeviceID);

        return $ConnBean->execute();
    }
}

?>