<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			//'database'  => 'enChanting_jitin',
			//'database'  => 'enChanting_etrates',
			//'database'  => 'enChanting_etrates_final_india_ASIA_testing_16dec2015',
			//'database'  => 'enChanting_etrates_final_india_ASIA_testing_16dec2015_DEFAULT',
			//'database'  => 'etrates-testing_withDefaultSeasonLevelCurrenyMargin_MealSeasonID',
			//'database'  => 'etrates-testing-final-01feb2016',
			'database'  => 'etrates-16sep2016',
			//'database'  => 'etrates',
			//'database'  => 'dev-rates',
			//'database'  => 'etrates-testing',
			'username'  => 'etrates',
			'password'  => 'enChantingP',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'database' => 'homestead',
			'username' => 'homestead',
			'password' => 'secret',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

	),

);
