<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Domain Database Connections
    |--------------------------------------------------------------------------
    |
    | All the domain based configuration is configured here
    |
    */

    'connections' => [
        'time1' => [
            'driver'    => 'mysql',
            'host'      => env('TIME1_DB_HOST', 'localhost'),
            'database'  => env('TIME1_DB_DATABASE', 'time1'),
            'username'  => env('TIME1_DB_USERNAME', 'root'),
            'password'  => env('TIME1_DB_PASSWORD', 'welcome123'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ],
        'time2' => [
            'driver'    => 'mysql',
            'host'      => env('TIME2_DB_HOST', 'localhost'),
            'database'  => env('TIME2_DB_DATABASE', 'time2'),
            'username'  => env('TIME2_DB_USERNAME', 'root'),
            'password'  => env('TIME2_DB_PASSWORD', 'welcome123'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ]        
    ],

];
