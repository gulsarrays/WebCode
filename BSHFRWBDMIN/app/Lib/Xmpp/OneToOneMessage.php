<?php

/**
 * Message Repository
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

use Fabiang\Xmpp\Protocol\OneToOneMessage as OneToOneFabiangMessage;
// use Fabiang\Xmpp\Protocol\Message as FabiangMessage;
use Fabiang\Xmpp\Util\XML;

class OneToOneMessage extends OneToOneFabiangMessage
// FabiangMessage
{
    /**
     * Class property to hold the id attribute value.
     *
     * @var string
     */
      protected $id,$type,$message;

    /**
     * Get Id attribute value
     *
     * @return string
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set Type attribute value
     *
     * @return string
     */

    public function setType($type){
            $this->type = $type;
            return $this;
    }
    
       /**
     * Get Type attribute value
     *
     * @return string
     */

    public function getType(){
         return $this->type;
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
     * {@inheritDoc}
     */
    public function toString(){
        return XML::quoteMessage('<message xml:lang="en" type="chat" to="%s" id="%s"><body>%s</body>
</message>',
            $this->getTo(),
            $this->getId(),
            $this->getMessage()
        );

    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = (string) $message;
        return $this;
    }
}
