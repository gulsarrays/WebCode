<?php

/**
 * Member Repository
 *
 * In this message repository having the methods to process the message data.
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Lib\Xmpp;

use Fabiang\Xmpp\Protocol\BroadcastMessage as FabiangBroadcastMessage;
use Fabiang\Xmpp\Util\XML;

/**
 * Protocol setting for Xmpp.
 *
 * @package Xmpp\Protocol
 */
class BroadcastMessage extends FabiangBroadcastMessage
{
    /**
     * Send Message from admin broadcast.
     */


    /**
     * IQ type.
     *
     * @var string
     */
    protected $type;

    /**
     * Set message id.
     *
     * @var string
     */
    protected $id;
    
     /**
     * Set message sender.
     *
     * @var string
     */
    protected $from;
    
     /**
     * Set message type.
     *
     * @var string
     */
    protected $messageType;
    
     /**
     * Set message receiver.
     *
     * @var string
     */
    protected $to;
    
     /**
     * Set message body.
     *
     * @var string
     */
    protected $body;

    

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $to
     * @param string $type
     */
    public function __construct( $to = '', $messageType = '',$type = '', $id ='' , $from ='', $body='')
    {
		
        $this->setTo($to)->setType($type)->setMessageType($messageType)->setId($id)->setFrom($from)->setBody($body);
        
    }

    /**
     * {@inheritDoc}
     */
    public function toString()
    {

     
		 $iq ='<message type="chat"'; 
		 
		  if (null !== $this->getTo()) {
            $iq .= ' to="' . XML::quote($this->getTo()) . '"';
            $iq .= ' id="' . XML::quote($this->getId()) . '"';
        }
         $iq .= '><body>' . $this->getBody(). '</body>
<active xmlns="http://jabber.org/protocol/chatstates"/>
<request xmlns="urn:xmpp:receipts"/>
</message>';
 

return XML::quoteMessage('<message xml:lang="en" type="chat" to="%s" id="%s"><body>%s</body>
</message>',
            $this->getTo(),
            $this->getId(),
            $this->getBody()
        );
    
	 

      
    }

    /**
     * Get IQ type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set IQ type.
     *
     * See {@link self::TYPE}
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get receiver.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set receiver.
     *
     * @param string $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = (string) $to;
        return $this;
    }
    
    /**
     * Get message type.
     *
     * @return string
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * Set messsage type.
     *
     * @param string $messageType
     * @return $this
     */
    public function setMessageType($messageType)
    {
        $this->messageType = (string) $messageType;
        return $this;
    }
    
    /**
     * Get message body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set message body.
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = (string) $body;
        return $this;
    }
    
    /**
     * Get receiver.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set sender.
     *
     * @param string $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = (string) $from;
        return $this;
    }
    
    /**
     * Get message Id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rmessage Id.
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (string) $id;
        return $this;
    }

    
}

