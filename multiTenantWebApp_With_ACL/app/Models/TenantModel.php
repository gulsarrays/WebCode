<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Auth;
use App\User;
use Spatie\Permission\Models\Role;

class TenantModel extends Model
{
    protected $connection = 'webAppTenant';
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        
        if(!empty(\Session::get('tenant_connection_db')) && !empty(\Session::get('web_app_tenant_user')) && \Session::get('web_app_tenant_user') === true) {
            // sets the model's connection from the one stored in session when it is created
            config::set('database.connections.webAppTenant.database', \Session::get('tenant_connection_db'));
        } else {          
            config::set('database.connections.webAppTenant.database', env('DB_DATABASE'));
        }
    }
}