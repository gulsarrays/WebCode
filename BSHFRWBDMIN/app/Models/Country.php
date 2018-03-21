<?php

/**
 * Country Model
 *
 * In this file contains the relationship which is used for Country model
 * 
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   1.0
 */
namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class country to specify country table
 * @author user
 *
 */
class Country extends Model {
   
   /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'countries';
}
