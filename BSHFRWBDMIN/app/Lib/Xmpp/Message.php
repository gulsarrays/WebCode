<?php

/**
 * Message Repository
 *
 * In this message repository having the methods to process the message data.
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Lib\Xmpp;

use Fabiang\Xmpp\Protocol\Message as FabiangMessage;
use Fabiang\Xmpp\Util\XML;

class Message extends FabiangMessage{
    /**
     * Class property to hold the id attribute value.
     *
     * @var string
     */
    protected $id; 
    /**
     * Class property to hold the time attribute value.
     *
     * @var string
     */
    protected $time; 
    /**
     * Class property to hold the chatType attribute value.
     *
     * @var string
     */
    protected $chatType;            
    /**
     * Class property to hold the message type attribute value.
     *
     * @var string
     */
    protected $type;            
    /**
     * Get Id attribute value
     *
     * @return string
     */
    public function getId(){
        return $this->id;
    }
    /**
     * Set Id attribute value.
     *
     * @param string $type
     * @return $this
     */
    public function setId($id){
        $this->id = $id;

        return $this;
    }    
    /**
     * Get Time attribute value
     *
     * @return string
     */
    public function getTime(){
        return $this->time;
    }
    /**
     * Set Time attribute value.
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time){
        $this->time = $time;

        return $this;
    }        
    /**
     * Get chatType attribute value
     *
     * @return string
     */
    public function getChatType(){
        return $this->chatType;
    }
    /**
     * Set chatType attribute value.
     *
     * @param string $chatType
     * @return $this
     */
    public function setChatType($chatType){
        $this->chatType = $chatType;

        return $this;
    } 
    /**
     * Get type attribute value
     *
     * @return string
     */
    public function getType(){
        return $this->type;
    }
    /**
     * Set type attribute value.
     *
     * @param string $type
     * @return $this
     */
    public function setType($type){
        $this->type = $type;

        return $this;
    }            
    /**
     * {@inheritDoc}
     */
    public function toString(){
        return XML::quoteMessage(
            '<message xml:lang="en" time="%s" type="%s" chatType="%s" id="%s" to="%s"><received xmlns="urn:xmpp:receipts" /></message>',
            $this->getTime(),
            $this->getType(),
            $this->getChatType(),
            $this->getId(),
            $this->getTo(),
            $this->getMessage()
        );
    }
}
