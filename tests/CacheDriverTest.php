<?php


namespace Alish\LaravelOtp\Tests;


//use Alish\LaravelOtp\Util\Random;
use Alish\LaravelOtp\Drivers\CacheDriver;
use Alish\LaravelOtp\OtpServiceProvider;
use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\TestCase;

class CacheDriverTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [OtpServiceProvider::class];
    }

    public function test_cacheDriver_issue_creation()
    {
        $cacheDriver = $this->app->make('otp')->driver('cache');

        $token = $cacheDriver->issue($key = '09367892834');

        $cachedToken = Cache::get('laravel-otp-'.$key);

        $this->assertEquals($token, $cachedToken);
    }

}
