<?php

/**
 * CMSMSRepository
 *
 * In this CMSMS CMSMSRepository is used to send the verification code to mobile
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 20164 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Repository;

class CMSMSRepository {
   
   /**
    * This function is used to build the message in XML format
    *
    * @param integer $recipient
    *           Phone or Mobile Number
    * @param string $message
    *           Message
    *           
    * @return xml
    *
    */
   static public function buildMessageXml($recipient, $message) {
      $xml = new \SimpleXMLElement ( '<MESSAGES/>' );
      
      $authentication = $xml->addChild ( 'AUTHENTICATION' );
      $authentication->addChild ( 'PRODUCTTOKEN', '2B846D42-577C-46A3-B336-7A35F9F926FE' );
      
      $msg = $xml->addChild ( 'MSG' );
      $msg->addChild ( 'FROM', 'PooAp' );
      $msg->addChild ( 'TO', $recipient );
      $msg->addChild ( 'BODY', $message );
      
      return $xml->asXML ();
   }
   /**
    * This function is used to send the message using the phone number & message
    *
    * @return array
    *
    */
   static public function sendMessage($recipient, $message) {
      $xml = static::buildMessageXml ( $recipient, $message );
      
      $ch = curl_init ();
      // cURL v7.18.1+ and OpenSSL 0.9.8j+ are required
      curl_setopt_array ( $ch, array (
            CURLOPT_URL => 'https://sgw01.cm.nl/gateway.ashx',
            CURLOPT_HTTPHEADER => array (
                  'Content-Type: application/xml' 
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false 
      ) );
      
      $response = curl_exec ( $ch );
      
      curl_close ( $ch );
      
      return $response;
   }
}
