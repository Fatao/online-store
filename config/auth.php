<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'customers',
    ],

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],
    ],

    /*
     * We use the customers table for all authentication.
     * Both admin and regular users are stored here with a 'role' field.
     */
    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Customer::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];