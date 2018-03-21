<?php 
namespace App\Models;

class FastbuildContract extends \Eloquent
{
	protected $fillable = array('ts_id', 'name', 'service_id', 'status');

    public function service(){
        return $this->belongsTo('App\Models\FastbuildService');
    }

	public function contractPeriods(){
        return $this->hasMany('App\Models\FastbuildContractPeriod');
    }

}