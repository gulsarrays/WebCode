<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelUserDetails extends Model
{
    protected $connection = 'channel';
    protected $table= 'user_details';
    public $timestamps=false;    
    
}
