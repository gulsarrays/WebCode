<?php

namespace App\Models;

class FastbuildPrice extends \Eloquent
{
    
    protected $fillable = array('priceable_id', 'priceable_type', 'season_period_id', 'service_id', 'currency_id','meal_plan_id', 'buy_price', 'sell_price', 'has_details', 'status','margin', 'season_period_start', 'season_period_end');

    public function priceable(){
        return $this->morphTo();
    }

    public function servicePolicy() {
        return $this->hasOne('App\Models\FastbuildServicePolicy');
    }

    public function seasonPeriod(){
        return $this->belongsTo('App\Models\FastbuildSeasonPeriod');
    }

    public function service(){
        return $this->belongsTo('App\Models\FastbuildService');
    }

    public function weekPrices() {
        return $this->hasMany('App\Models\FastbuildWeekPrice');
    }
}
