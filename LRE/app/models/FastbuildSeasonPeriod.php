<?php

namespace App\Models;

class FastbuildSeasonPeriod extends \Eloquent
{
	protected $fillable = array('season_id', 'name', 'start', 'end', 'status');
    
    public function season(){
        return $this->belongsTo('App\Models\FastbuildSeason');
    }

	public function price(){
        return $this->hasOne('App\Models\FastbuildPrice');
    }
    
}