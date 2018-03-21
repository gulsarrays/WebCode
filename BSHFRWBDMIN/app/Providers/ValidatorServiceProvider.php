<?php

/**
 * ValidatorServiceProvider
 *
 * In this file contains the booting and register methods 
 * 
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   0.1
 */
namespace App\Providers;

/**
 * Validator provider.
 * Add this at app\Providers
 *
 * @author Alejandro Mostajo <amostajo@gmail.com>
 */
use App\Services\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Register the extended validator as the new validator
		\Validator::resolver ( function ($translator, $data, $rules, $messages) {
			return new Validator ( $translator, $data, $rules, $messages );
		} );
	}
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
