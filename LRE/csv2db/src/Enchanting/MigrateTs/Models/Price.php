<?php 

namespace App\Models;

class Price extends \Illuminate\Database\Eloquent\Model {
    
    protected $fillable = array('service_id', 'season_period_id', 'currency_id','meal_plan_id', 'buy_price', 'sell_price','margin', 'has_details', 'status', 'season_period_start', 'season_period_end');

    public function priceable(){

        return $this->morphTo();
    }
    
    public function servicePolicy() {
        return $this->hasOne('App\Models\ServicePolicy');
    }

    public function weekPrices() {
        return $this->hasMany('App\Models\WeekPrice');
    }

    public function policyPriceBand() {
        return $this->hasOne('App\Models\PolicyPriceBand');
    }

    public function seasonPeriod(){
        return $this->belongsTo('App\Models\SeasonPeriod');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service');
    }

}

?>