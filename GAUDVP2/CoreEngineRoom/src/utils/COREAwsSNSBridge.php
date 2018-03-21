<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREAwsSNSBridge.php
  Description                 : Wrapper methods to access Amazone SNS
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

use Aws\Sns\SnsClient;

/**
 * Class COREAwsSNSBridge
 */
class COREAwsSNSBridge
{
    private $snsClient = null;

    private $key    = 'AKIAJGDMPNCMTTXSALSQ';
    private $secret = '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';

    private $APNSAppARN        = 'arn:aws:sns:us-west-2:726226201286:app/APNS/Audvisor_iOS_App';
    private $APNSAppSandboxARN = 'arn:aws:sns:us-west-2:726226201286:app/APNS_SANDBOX/Audvisor_iOS_App_';
    private $GCMAppARN         = 'arn:aws:sns:us-west-2:726226201286:app/GCM/Audvisor_Droid_App_';

    private $AudvisorBroadcastNotificationARN = 'arn:aws:sns:us-west-2:726226201286:Audvisor_Broadcast';

    /**
     *
     */
    const AudvisorBroadcastNotification = 'AudvisorBroadcastNotification';
    /**
     *
     */
    const ConsumerDevicePlatformIOS = 'iOS';
    /**
     *
     */
    const ConsumerDevicePlatformAndroid = 'Android';

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param $notification
     * @param $AWSDeviceToken
     *
     * @return \Guzzle\Service\Resource\Model|null (SubscriptionArn)
     */
    public function subscribeConsumerDeviceForNotification($notification, $AWSDeviceToken)
    {
        $response = null;

        $topicArn = $this->getTopicARNForNotification($notification);
        if(isset($topicArn) && isset($AWSDeviceToken))
        {
            $response = $this->subscribe($topicArn, $AWSDeviceToken);
        }

        return isset($response['SubscriptionArn']) ? $response['SubscriptionArn'] : null; //SubscriptionArn
    }

    /**
     * @param $AWSSubscriptionID
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function unSubscribeConsumerDeviceForNotification($AWSSubscriptionID)
    {
        return $this->unSubscribe($AWSSubscriptionID);
    }

    /**
     * @param $notification
     * @param $notificationData
     *
     * @return \Guzzle\Service\Resource\Model|null
     */
    public function sendPushNotificationToAll($notification, $notificationData)
    {
        $response = null;
        $topicArn = $this->getTopicARNForNotification($notification);
        if(isset($topicArn))
        {
            $response = $this->publishTopic($topicArn, $notificationData);
        }

        return $response;
    }

    /**
     * @param $notificationData
     * @param $AWSDeviceToken
     */
    public function sendPushNotificationToDevice($notificationData, $AWSDeviceToken)
    {
    }

    /**
     * @param $consumerDeviceID
     * @param $consumerDeviceToken
     * @param $consumerDevicePlatform
     *
     * @return \Guzzle\Service\Resource\Model|null (EndpointArn)
     */
    public function registerConsumerDevice($consumerDeviceID, $consumerDeviceToken, $consumerDevicePlatform)
    {
        $response = null;

        $platformApplicationArn = $this->getAppARNForPlatform($consumerDevicePlatform);
        if(null != $platformApplicationArn)
        {
            $response = $this->createPlatformEndpoint($platformApplicationArn, $consumerDeviceToken, $consumerDeviceID);
        }

        return isset($response['EndpointArn']) ? $response['EndpointArn'] : null; //k EndpointArn
    }

    /**
     * @param $AWSDeviceToken
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function unRegisterConsumerDevice($AWSDeviceToken)
    {
        return $this->deleteEndpoint($AWSDeviceToken);
    }

    /**
     * @param $consumerDevicePlatform
     *
     * @return null|string
     */
    private function getAppARNForPlatform($consumerDevicePlatform)
    {
        $platformApplicationArn = null;

        if(COREAwsSNSBridge::ConsumerDevicePlatformIOS == $consumerDevicePlatform)
        {
            $platformApplicationArn = (ENVIRONMENT === "Production") ? $this->APNSAppARN : $this->APNSAppSandboxARN;
        }
        elseif(COREAwsSNSBridge::ConsumerDevicePlatformAndroid == $consumerDevicePlatform)
        {
            $platformApplicationArn = $this->GCMAppARN;
        }

        return $platformApplicationArn;
    }

    /**
     * @param $pushNotificationTopic
     *
     * @return null|string
     */
    private function getTopicARNForNotification($pushNotificationTopic)
    {
        $topicArn = null;

        if(COREAwsSNSBridge::AudvisorBroadcastNotification == $pushNotificationTopic)
        {
            $topicArn = $this->AudvisorBroadcastNotificationARN;
        }

        return $topicArn;
    }

    /**
     * @param $platformApplicationArn
     * @param $consumerDeviceToken
     * @param $consumerDeviceID
     *
     * @return \Guzzle\Service\Resource\Model
     */
    private function createPlatformEndpoint($platformApplicationArn, $consumerDeviceToken, $consumerDeviceID)
    {
        return $this->getSNSClient()->createPlatformEndpoint(array(
                                                                 'PlatformApplicationArn' => $platformApplicationArn,
                                                                 'Token'                  => $consumerDeviceToken,
                                                                 'CustomUserData'         => $consumerDeviceID,
                                                             ));
    }

    /**
     * @param $AWSDeviceToken
     *
     * @return \Guzzle\Service\Resource\Model
     */
    private function deleteEndpoint($AWSDeviceToken)
    {
        return $this->getSNSClient()->deleteEndpoint(array(
                                                         'EndpointArn' => $AWSDeviceToken,
                                                     ));
    }

    /**
     * @param $topicARN
     * @param $endpointARN
     *
     * @return \Guzzle\Service\Resource\Model
     */
    private function subscribe($topicARN, $endpointARN)
    {
        return $this->getSNSClient()->subscribe(array(
                                                    'TopicArn' => $topicARN,
                                                    'Protocol' => 'application',
                                                    'Endpoint' => $endpointARN,
                                                ));
    }

    /**
     * @param $AWSSubscriptionID
     *
     * @return \Guzzle\Service\Resource\Model
     */
    private function unSubscribe($AWSSubscriptionID)
    {
        return $this->getSNSClient()->unsubscribe(array(
                                                      'SubscriptionArn' => $AWSSubscriptionID,
                                                  ));
    }

    /**
     * @param $topicArn
     * @param $notificationData
     *
     * @return \Guzzle\Service\Resource\Model
     */
    private function publishTopic($topicArn, $notificationData)
    {
        $message = '{
    "default": "ENTER YOUR MESSAGE",
    "%s": "{\"aps\":{\"alert\": \"%s\",\"sound\":\"default\"} }",
    "GCM": "{\"data\":{\"aps\" : {\"alert\" : { \"body\" : \"%s\" } } } }"
}';

//        '{
//    "default": "ENTER YOUR MESSAGE",
//    "APNS": "{\"aps\":{\"alert\": \"%s\",\"sound\":\"default\"} }",
//    "GCM": "{\"data\":{\"aps\" : {\"alert\" : { \"body\" : \"%s\", \"action-loc-key\" : \"LISTEN\", \"loc-key\" : \"EXPERT_ADDED_FOR_TOPIC\", \"loc-args\" : [ \"Tom Peters\", \"Marketing\"] } }, \"custom\" : \"foo\" } }"
//}'
        $APNSGateway = (ENVIRONMENT === "Production") ? "APNS" : "APNS_SANDBOX";
        $message     = sprintf($message, $APNSGateway, $notificationData['message'], $notificationData['message']);

        $publish_params = array(
            'TopicArn'         => $topicArn,
            'Message'          => $message,
            'MessageStructure' => 'json',
        );

        return $this->getSNSClient()->publish($publish_params);
    }

    /**
     * @return SnsClient|null
     */
    private function getSNSClient()
    {
        if(is_null($this->snsClient))
        {
            $this->snsClient = SnsClient::factory(array(
                                                      'key'    => $this->key,
                                                      'secret' => $this->secret,
                                                      'region' => 'us-west-2'
                                                  ));
        }

        return $this->snsClient;
    }
}
