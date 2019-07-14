<?php

/**
 * laravel-helper plugin configuration File
 * About Package Setting
 */
return [
    // about package setting
    'package' => [
        /*Response Package Structure*/
        'structure' => [
            'code'    => 'code',
            'message' => 'message',
            'data'    => 'data',
        ],

        /*Package encrypt Setting*/
        'crypt'     => [
            'instance' => \AlicFeng\Helper\Crypt\HelperCryptService::class,
            'method'   => 'aes-128-ecb',
            'password' => '1234qwer',
        ],
    ],

    // debug model setting
    'debug'   => true,
];
