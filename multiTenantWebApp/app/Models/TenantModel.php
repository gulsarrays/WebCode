<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class TenantModel extends Model
{
    protected $connection = 'webAppTenant';
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        
        if(!empty(\Session::get('tenant_connection_db'))) {
            // sets the model's connection from the one stored in session when it is created
            config::set('database.connections.webAppTenant.database', \Session::get('tenant_connection_db'));
        }
    }
}