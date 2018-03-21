<?php
/**
 * Group Repository
 *
 * @category  compassites
 * @package   compassites Fly
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Repository;

use App\User;

class GroupRepository {
    /**
     * Change Group Admin of the arugment user owner groups
     * choose the next member added in the group
     *
     * @param \App\User $user
     * @return void
     */
    public function changeGroupAdminByUser(User $user) {
        $user->chatGroups()->with(['nextAdminCandidate' => function($query) use ($user){
            $query->where(USER,NOT_EQUAL,$user->username);
        }])->select([ID])->get()->each(function($group){
            $group->tryChangingAdmin();
        });
    }       
}
