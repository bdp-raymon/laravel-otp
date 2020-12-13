<?php

namespace Alish\LaravelOtp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string issue(string $key)
 * @method static bool revoke(string $key)
 * @method static bool check(string $key, string $token)
 * @method static bool use(string $key, string $token)
 */
class Otp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'otp';
    }
}
