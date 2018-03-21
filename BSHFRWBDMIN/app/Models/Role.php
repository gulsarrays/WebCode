<?php
namespace App\Models;
use Zizaco\Entrust\EntrustRole;

use App\Models\Permission;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole implements AuditableContract
{
	use Auditable, SoftDeletes;

	protected $fillable = ['display_name', 'description', 'name'];

	public function permissions() 
	{
    	return $this->belongsToMany(Permission::class, 'permission_role');
	}
}