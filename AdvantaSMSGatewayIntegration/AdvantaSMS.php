<?php

/*
 * -------------------------------------------------------------------------------------------
 * Updated: 21.03.2018
 * This source code can only be used and altered together with Advanta's SMS system.
 *
 * Requirements:
 * You need to have an Advanta SMS account.
 * Register at: http://www.advantasms.com/sign-up.aspx 
 * 
 * -------------------------------------------------------------------------------------------
 */

/*
 * Advanta SMS class provides an easy way of sending SMS messages through the HTTP/XML API.
 * @package AdvantaSMS
 */

/*
 * How to use
 * 1) set/configure the SMS GATEWAY API access
 *  
 * $Username = "your sms gateway api username";
 * $Password = "your sms gateway api password";
 * $MsgSender = "sender name if you configured in sms gatway";
 * 
 * 2) From the page where you want to trigger SMS, 
 *    a) instantiate the class
 *    b) set the receiver phone no and  SMS text
 *    c) call the sendAvantaSMS() function
 *    d) if you want to send bulk sms, then treat $DestinationAddress as array 
 *       and add all mobile no in this array
 *    e) we can check the remaining balance  as well.
 * 
 * ### example code  ###
 * 
 * $DestinationAddress = "Reciever phone number";
 * $Message = "Hello World! -  Your SMS text goes here";
 * 
 * $AdvantaSMS = new AdvantaSMS($Username, $Password, $MsgSender);
 * $Message = $AdvantaSMS->sendAvantaSMS($DestinationAddress, $Message);
 * $Message1 = $AdvantaSMS->avantaSMSavailableBalance();
 * 
 */

namespace App\Classes;

class AdvantaSMS {

    private $Username;
    private $Password;

    /*
     * Constructor with username and password to Advanta gateway.
     * @param string $Username
     * @param string $Password
     */

    public function __construct($Username = null, $Password = null, $MsgSender = null) {
        
        if(empty($Username) || empty($Password)) {
            $Username = ADVANTASMS_API_USERNAME;
            $Password = ADVANTASMS_API_PASSWORD;
            $MsgSender = ADVANTASMS_API_MSG_SENDER;
        }
        
        $this->Username = $Username;
        $this->Password = $Password;
        $this->MsgSender = $MsgSender;
    }

    /*
     * Send SMS message through the Advanta HTTP API.
     * @param string $MsgSender
     * @param string $DestinationAddress
     * @param string $Message
     * @return Result $Result
     */

    public function SendSMS($DestinationAddress, $Message) {

        // Build URL request for sending SMS.               
        $url = "http://messaging.advantasms.com/bulksms/sendsms.jsp?user=%s&password=%s&mobiles=%s&sms=%s&unicode=1";

        $url = sprintf($url, urlencode($this->Username), urlencode($this->Password), urlencode($DestinationAddress), urlencode($Message));

        // Check if MsgSender is numeric or alphanumeric.
        if (!empty($this->MsgSender)) {
            $url .= "&senderid=" . $this->MsgSender;
        }

        // Get response as xml.
        $XMLResponse = $this->GetResponseAsXML($url);

        // Parse XML.
        $Result = $this->ParseXMLResponse($XMLResponse);

        // Return the result object.
        return $Result;
    }

    /*
     * Send SMS message through the Advanta XML API by curl.
     * @param string $MsgSender
     * @param array $DestinationAddressArray
     * @param string $Message
     * @return Result $Result
     */

    public function SendBulkSMS($DestinationAddressArray, $Message) {

        // Build URL request for sending SMS.               
        $url = "http://messaging.advantasms.com/bulksms/sendsms.jsp?";
        // Check if MsgSender is numeric or alphanumeric.
        $str_MsgSender = '';
        if (!empty($this->MsgSender)) {
            $str_MsgSender = "<senderid>" . htmlspecialchars($this->MsgSender, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</senderid>";
        }

        $xml_request_data = "<?xml version='1.0'?> <smslist>";
        foreach ($DestinationAddressArray as $DestinationAddress) {
            $xml_request_data .= "<sms> 
                                <user>" . htmlspecialchars($this->Username, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</user> 
                                <password>" . htmlspecialchars($this->Password, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</password> 
                                <message>" . htmlspecialchars($Message, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</message> 
                                <mobiles>" . htmlspecialchars($DestinationAddress, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</mobiles> 
                                 " . $str_MsgSender . "
                                <unicode>1</unicode> 
                            </sms>";
        }
        $xml_request_data .= "</smslist>";

        $curlResponse = $this->getCurlResponse($url, $xml_request_data);

        // Get response as xml.
        $XMLResponse = simplexml_load_string($curlResponse);

        // Parse XML.
        $Result = $this->ParseXMLResponse($XMLResponse);

        // Return the result object.
        return $Result;
    }

    private function getCurlResponse($url, $xml_request_data) {
        // Curl connection
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_request_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /*
     * Gets the respone from the given URL, and return the response as xml.
     * @param string $url
     * @return object Response as xml
     */

    private function GetResponseAsXML($url) {
        try {
            // Download webpage and return response as xml.
            return simplexml_load_file($url);
        } catch (Exception $e) {
            // Failed to connect to server. Throw an exception with a customized message.
            throw new Exception('Error occured while connecting to server: ' . $e->getMessage());
        }
    }

    /*
     * Parses the XML response
     * @param objec $XMLResponse
     * @return Result $Result
     */

    private function ParseXMLResponse($XMLResponse) {

        // convert Object into an Array
        $XMLResponse = json_decode(json_encode($XMLResponse), true);

        $Result = new Result;
        $Result->ErrorCode = null;
        $Result->ErrorMessage = null;

        if (!empty($XMLResponse['error'])) {
            $Result->Success = 0;
            $Result->ErrorCode = $XMLResponse['error']["error-code"];
            $Result->ErrorMessage = $XMLResponse['error']["error-description"];
        } else {
            $Result->Success = 1;
            $Result->SuccessResponse = $XMLResponse['sms'];
        }

        return $Result;
    }

    public function sendAvantaSMS($DestinationAddress, $Message) {

        try {
            if (is_array($DestinationAddress)) {
                // Send SMS through the HTTP API
                $Result = $this->SendBulkSMS($DestinationAddress, $Message);
            } else {
                // Send SMS through the HTTP API
                $Result = $this->SendSMS($DestinationAddress, $Message);
            }

            // Check result object returned and give response to end user according to success or not.
            if ($Result->Success == true) {
                $Message = array(
                    'success' => 1,
                    'message' => "Message successfully sent!"
                );
            } else {
                $Message = array(
                    'success' => 0,
                    'message' => "Error occured while sending SMS<br />Errorcode: " . $Result->ErrorCode . "<br />Errormessage: " . $Result->ErrorMessage
                );
            }
        } catch (Exception $e) {
            //Error occured while connecting to server.
            $Message = array(
                'success' => 0,
                'message' => $e->getMessage()
            );
        }
        return $Message;
    }

    public function avantaSMSavailableBalance() {

        // Build URL request for account balance.               
        $url = "http://messaging.advantasms.com/bulksms/smscredit.jsp?user=%s&password=%s";

        $url = sprintf($url, urlencode($this->Username), urlencode($this->Password));

        // Get response as xml.
        $XMLResponse = $this->GetResponseAsXML($url);

        // Parse XML.
        $XMLResponse = json_decode(json_encode($XMLResponse), true);

        $Result = new Result;
        $Result->ErrorCode = null;
        $Result->ErrorMessage = null;


        if (!empty($XMLResponse['error'])) {
            $Result->Success = 0;
            $Result->ErrorMessage = $XMLResponse['error'];
        } else {
            $Result->Success = $XMLResponse;
        }
        // Return the result object.
        return $Result;
    }

    // Not working correctly - need soem work in following function
    public function avantaSMSDeliveryStatus($messageID = null) {

        // Build URL request for sending SMS.               
        $url = "http://messaging.advantasms.com/bulksms/getDLR.jsp?userid=%s&password=%s";

        $url = sprintf($url, urlencode($this->Username), urlencode($this->Password));

        // Check if $messageID is availabe or not.
        if (!empty($messageID)) {
            if (array($messageID)) {
                $messageID_str = implode(',', $messageID);
            } else {
                $messageID_str = $messageID;
            }
            $url .= "&messageid=" . $messageID_str;
        }

        // Get response as xml.
        $XMLResponse = $this->GetResponseAsXML($url);

        // Parse XML.
        $XMLResponse = json_decode(json_encode($XMLResponse), true);

        $Result = new Result;
        $Result->ErrorCode = null;
        $Result->ErrorMessage = null;


        if (!empty($XMLResponse['error'])) {
            $Result->Success = 0;
            $Result->ErrorMessage = $XMLResponse['error'];
        } else {
            $Result->Success = $XMLResponse;
        }
        // Return the result object.
        return $Result;
    }

}

/*
 * The result object which is returned by the SendSMS function in the package AdvantaSMS.
 * @package Result
 */

class Result {

    public $Success;
    public $ErrorCode;
    public $ErrorMessage;
    public $SuccessResponse;

}
