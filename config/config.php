<?php

return [

    // supported: cache, database
    'default' => env('OTP_DRIVER', 'cache'),

    // type of generated token, supported types: alpha, alphanumeric, numeric
    'type' => 'alphanumeric',

    // length of generated token
    'length' => 6,

    // expiry time of token is seconds start from generated time
    'timeout' => 5 * 60,

    // hash stored token
    'hash' => false
];
