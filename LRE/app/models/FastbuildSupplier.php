<?php

namespace App\Models;

class FastbuildSupplier extends \Eloquent
{
    protected $fillable = array('name', 'description', 'region_id', 'status', 'ts_id');

    public function services() {
        return $this->hasMany('App\Models\FastbuildService');
    }

    public function region() {
//        return $this->belongsTo('App\Models\FastbuildRegion');
        return $this->belongsTo('App\Models\Region');
    }

}
