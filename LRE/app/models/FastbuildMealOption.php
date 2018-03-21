<?php 

namespace App\Models;

class FastbuildMealOption extends \Eloquent
{ 
    protected $fillable = array('service_option_id', 'meal_id', 'season_period_id', 'status');

    public function meal(){
        return $this->belongsTo('App\Models\Meal');
    }
}
