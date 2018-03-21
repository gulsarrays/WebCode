<?php 

namespace App\Models;

class Margins extends \Illuminate\Database\Eloquent\Model {
    
    protected $fillable = array('id', 'service_id', 'season_period_id', 'currency_id', 'margin', 'status');	

}

?>
