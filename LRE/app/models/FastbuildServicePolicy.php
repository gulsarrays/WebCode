<?php 

namespace App\Models;

class FastbuildServicePolicy extends \Eloquent
{
	protected $fillable = array('price_id', 'charging_policy_id', 'status');
  
  	public function price() {
        return $this->belongsTo('App\Models\FastbuildPrice');
    }
    
    public function policyPriceBands() {
        return $this->hasMany('App\Models\FastbuildPolicyPriceBand');
    }
}