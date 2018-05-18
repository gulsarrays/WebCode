<?php

namespace App\Models\Main;

use App\Models\MainModel;

class WebAppTenants extends MainModel
{
    protected $table = 'web_app_tenant';
    
    protected $fillable = [
        'db_host', 'db_name', 'db_user', 'db_password', 'user_id'
    ];
}
