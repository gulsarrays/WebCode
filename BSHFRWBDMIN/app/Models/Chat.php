<?php

/**
 * Chat Model
 *
 * This file is used to get the conversation from chat_log
 * 
 * @category  compassites
 * @package   Models
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\LoggingModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Chat extends Model implements LoggingModel{
   
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'chat_log';
    /**
     * Get message information by message id
     * 
     * @param string $messageId
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getMessageInfoByMessageId($messageId) {
        $chatLog = $this->where(COM_MESSAGE_ID_KEYWORD,$messageId)->selectRaw(
            "message_id,type as chat_message_type,body as message_content,time as message_time"
        )->first();

        if(!$chatLog instanceof Chat || !$chatLog->exists){
            throw new ModelNotFoundException(trans(LANG_RESOURCE_NOT_EXIST));
        }

        return $chatLog->toArray();
    }    
    
    /**
     * gettting the user details using user-type
     */
     public function senderDetails() {
       //return the user details
       return $this->hasOne('App\User','username','sender');
    }
    
    /**
     * gettting the user details using user-type
     */
    public function receiverDetails() {
       //return the user details
       return $this->hasOne('App\User','username','receiver');
    }
}
