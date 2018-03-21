<?php 

namespace App\Models;

class FastbuildPriceBand extends \Eloquent
{
	protected $fillable = array('ts_id', 'name', 'min', 'max');   
}