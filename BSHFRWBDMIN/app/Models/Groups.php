<?php
/**
 * Groups
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model{
    /**
     * Class property to hold the table name associated with the model
     * 
     * @var string
     **/
     protected $table = "groups";
    /**
     * Relation with User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */    
    public function adminInfo() {
        return $this->belongsTo(User::class,COM_ADMIN_KEYWORD,USERNAME);
    }
    /**
     * Relation to choose next admin candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    
    public function nextAdminCandidate() {
        return $this->hasOne(UserGroup::class,GROUP_ID)->where(IS_ACTIVE,1)->select([GROUP_ID,USER])->take(1);
    }
    /**
     * try to change group admin with next candidate
     * if the next admin candidate not exist the group is deleted 
     *
     * @return void
     */
    public function tryChangingAdmin() {
        if($this->nextAdminCandidate instanceof UserGroup && $this->nextAdminCandidate->exists){
            $this->admin = $this->nextAdminCandidate->user;
            $this->save();                                                       
        } else {
            $this->delete();
        }
    }    
}
