<?php

return [

    // supported: cache, database
    'default' => env('OTP_DRIVER', 'cache'),

    // type of generated token, supported types: alpha, alphanumeric, numeric
    'type' => 'alphanumeric',

    // length of generated token
    'length' => 6,

    // case sensitive token
    'case-sensitive' => true,

    // if you want to generate random from your own set of characters just pass your desired characters as a string, eg: "1234"
    'custom' => null,

    // expiry time of token is seconds start from generated time, for permanent token set timeout to null
    'timeout' => 5 * 60,

    // hash stored token
    'hash' => false,

    // revoke all generated tokens after creating new one for specific key
    // only for database driver
    // setting this to true, revoke all valid tokens when you issuing new token for provided key
    'unique' => false
];
