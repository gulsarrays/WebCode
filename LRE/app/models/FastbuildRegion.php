<?php

namespace App\Models;

class FastbuildRegion extends \Eloquent
{    
    protected $fillable = array('name', 'ts_id', 'parent_id');

    public function services() {
        return $this->hasMany('App\Models\FastbuildService');
    }

    public function suppliers() {
        return $this->hasMany('App\Models\FastbuildSupplier');
    }

    public function country() {
        return $this->belongsTo('App\Models\FastbuildRegion', 'parent_id');
    }

    public function regions() {
        return $this->hasMany('App\Models\FastbuildRegion', 'parent_id');
    }
}
