<?php

/**
 * User Availability
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAvailability extends Model{
    /**
     * Class property to hold the table name associated with the model
     * 
     * @var string
     **/
    protected $table = 'user_availability';   
}
