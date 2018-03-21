<?php 

namespace App\Models;

class ServiceOption extends \Illuminate\Database\Eloquent\Model {
    
    protected $fillable = array('ts_id', 'service_id', 'service_extra_id', 'occupancy_id', 'name', 'is_default', 'status');

    public function prices(){

        return $this->morphMany('App\Models\Price', 'priceable');
        
    }

    public function mealOptions(){

        return $this->hasMany('App\Models\MealOption');
    
    }

    public function occupancy(){

        return $this->belongsTo('App\Models\Occupancy');

    }

    public function serviceExtra(){

        return $this->belongsTo('App\Models\ServiceExtra');
    
    }

    public function service(){

        return $this->belongsTo('App\Models\Service');

    }

}

?>