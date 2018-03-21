<?php

/**
 * LoggingModel interface
 *
 * 
 * @category  compassites
 * @package   Contracts
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Contracts;    


interface LoggingModel{
    /**
     * Get message information by message id
     * 
     * @param string $messageId
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getMessageInfoByMessageId($messageId);
}
