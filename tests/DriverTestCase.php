<?php


namespace Alish\LaravelOtp\Tests;


use Alish\LaravelOtp\Drivers\CacheDriver;
use Alish\LaravelOtp\OtpServiceProvider;
use Orchestra\Testbench\TestCase;

class DriverTestCase extends TestCase
{

    protected string $driver;

    protected function driver()
    {
        return $this->app->make('otp')->driver($this->driver);
    }

    protected function getPackageProviders($app)
    {
        return [OtpServiceProvider::class];
    }

    protected function issueToken(string $key = 'test'): string
    {
        return $this->driver()->issue($key);
    }

    protected function useToken(string $key, string $token): bool
    {
        return $this->driver()->use($key, $token);
    }

    protected function checkToken(string $key, string $token): bool
    {
        return $this->driver()->check($key, $token);
    }

    protected function revokeToken(string $key): bool
    {
        return $this->driver()->revoke($key);
    }

}
