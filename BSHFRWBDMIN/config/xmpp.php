<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Domain Based XMPP Address
    |--------------------------------------------------------------------------
    |
    | All the domain based configuration is configured here
    |
    */
    'connections' => [
        // 'time1' => 'tcp://52.53.39.123:5222',
        // 'time2' => 'tcp://52.53.39.123:5222'
        'time1' => env('XMPP_ADDRESS'),
        'time2' => env('XMPP_ADDRESS')
    ],
    /*
    |--------------------------------------------------------------------------
    | Default XMPP Address
    |--------------------------------------------------------------------------
    |
    | All the domain based configuration is configured here
    |
    */
    // 'address' => "tcp://52.53.39.123:5222",
    'address' => env('XMPP_ADDRESS'),
 ];
