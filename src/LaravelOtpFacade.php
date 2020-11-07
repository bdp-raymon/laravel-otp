<?php

namespace Alish\LaravelOtp;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alish\LaravelOtp\Skeleton\SkeletonClass
 */
class LaravelOtpFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-otp';
    }
}
