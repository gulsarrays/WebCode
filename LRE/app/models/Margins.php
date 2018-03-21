<?php 

namespace App\Models;

class Margins extends \Eloquent
{ 
    protected $fillable = array('id', 'service_id', 'season_period_id', 'currency_id', 'margin', 'premium', 'status');
    
}
