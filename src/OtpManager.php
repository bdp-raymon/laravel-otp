<?php

namespace Alish\LaravelOtp;

use Illuminate\Support\Manager;

class OtpManager extends Manager
{

    public function getDefaultDriver()
    {
        return 'cache';
    }

    public function createCacheDriver()
    {

    }

    public function createDatabaseDriver()
    {

    }
}
