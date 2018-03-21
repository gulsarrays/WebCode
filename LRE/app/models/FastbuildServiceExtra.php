<?php

namespace App\Models;

class FastbuildServiceExtra extends \Eloquent
{
    
    protected $fillable = array('name', 'service_id', 'mandatory', 'status', 'ts_id');

    public function prices() {
        return $this->morphMany('App\Models\FastbuildPrice', 'priceable');
    }

    public function service() {
        return $this->belongsTo('App\Models\FastbuildService');
    }

    public function serviceOptions() {
        return $this->hasMany('App\Models\FastbuildServiceOption');
    }

}
