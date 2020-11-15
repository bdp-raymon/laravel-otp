<?php

namespace Alish\LaravelOtp\Facades;

use Illuminate\Support\Facades\Facade;

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