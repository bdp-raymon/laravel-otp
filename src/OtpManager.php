<?php

namespace Alish\LaravelOtp;

use Alish\LaravelOtp\Drivers\CacheDriver;
use Alish\LaravelOtp\Drivers\DatabaseDriver;
use Illuminate\Support\Manager;

class OtpManager extends Manager
{

    public function getDefaultDriver()
    {
        return 'cache';
    }

    public function createCacheDriver()
    {
        return new CacheDriver(
            $this->container->make('cache'),
            $this->container->make('hash'),
            $this->config->get('otp'));
    }

    public function createDatabaseDriver()
    {
        return new DatabaseDriver(
            $this->container->make('hash'),
            $this->config->get('otp')
        );
    }
}
