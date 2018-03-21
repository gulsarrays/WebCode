<?php
namespace App\Models;
use Zizaco\Entrust\EntrustPermission;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
// use App\User;

class Permission extends EntrustPermission implements AuditableContract
{
	use Auditable;
	// public function users() {
 //    	return $this->belongsToMany(User::class);
	// }
}