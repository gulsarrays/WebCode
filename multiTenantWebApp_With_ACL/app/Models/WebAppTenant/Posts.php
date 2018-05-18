<?php

namespace App\Models\WebAppTenant;

use App\Models\TenantModel;

class Posts extends TenantModel
{
    protected $table = 'posts';
    
    protected $fillable = [
        'title', 'body'
    ];
}
