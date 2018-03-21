<?php 

namespace App\Models;

class FastbuildService extends \Eloquent
{   
    protected $fillable = array('ts_id', 'short_name', 'name', 'description', 'service_type_id', 'region_id', 'supplier_id', 'currency_id', 'status');

    public function contracts() {
        return $this->hasMany('App\Models\FastbuildContract');
    }

    public function serviceOptions() {
        return $this->hasMany('App\Models\FastbuildServiceOption');
    }

    public function serviceExtras() {
        return $this->hasMany('App\Models\FastbuildServiceExtra');
    }

    public function prices() {
        return $this->hasMany('App\Models\FastbuildPrice');
    }

    public function serviceType() {
        return $this->belongsTo('App\Models\ServiceType');
    }

    public function region() {
//        return $this->belongsTo('App\Models\FastbuildRegion');
        return $this->belongsTo('App\Models\Region');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\FastbuildSupplier');
    }

    public function currency() {
        return $this->belongsTo('App\Models\Currency');
    }

}