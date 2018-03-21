<?php

/**
 * GroupChat Model
 *
 * This file is used to get the group conversation from group_log
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

class GroupChat extends Model implements LoggingModel{
   
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'group_log';
    /**
     * Get message information by message id
     * 
     * @param string $messageId
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getMessageInfoByMessageId($messageId) {
        $groupLog = $this->where(COM_MESSAGEID_KEYWORD,$messageId)->selectRaw(
            "messageid as message_id,sender as group_from,type as chat_message_type,message as message_content,time as message_time"
        )->first();

        if(!$groupLog instanceof GroupChat || !$groupLog->exists){
            throw new ModelNotFoundException(trans(LANG_RESOURCE_NOT_EXIST));
        }

        return $groupLog->toArray();
    }    
    
    /**
     * gettting the user details using user-type
     */
    public function sendUser() {
       //return the user details
       return $this->hasOne('App\User','username','sender');
    }
    
    /**
     * gettting the user details using user-type
     */
    public function receivedGroup() {
       //return the user details
       return $this->hasOne('App\Models\Groups','id','room');
    }
}
