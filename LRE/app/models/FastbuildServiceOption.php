<?php

namespace App\Models;

class FastbuildServiceOption extends \Eloquent
{
    
    protected $fillable = array('ts_id', 'service_id', 'service_extra_id', 'occupancy_id', 'name', 'status', 'is_default');

    public function prices() {
        return $this->morphMany('App\Models\FastbuildPrice', 'priceable');
    }

    public function serviceExtra() {
        return $this->belongsTo('App\Models\FastbuildServiceExtra');
    }

    public function meals() {
        return $this->belongsToMany('App\Models\Meal', 'meal_options');
    }

    public function mealOptions() {
        return $this->hasMany('App\Models\FastbuildMealOption');
    }

    public function occupancy() {
        return $this->belongsTo('App\Models\Occupancy');
    }

    public function service() {
        return $this->belongsTo('App\Models\FastbuildService');
    }

}
