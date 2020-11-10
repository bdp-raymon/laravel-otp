<?php


namespace Alish\LaravelOtp\Tests;

use Alish\LaravelOtp\Drivers\CacheDriver;
use Alish\LaravelOtp\OtpServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Orchestra\Testbench\TestCase;

class CacheDriverTest extends TestCase
{

    protected CacheDriver $cacheDriver;


    protected function cacheDriver()
    {
        return $this->app->make('otp')->driver('cache');
    }

    protected function getPackageProviders($app)
    {
        return [OtpServiceProvider::class];
    }

    public function test_cache_driver_could_issue_token()
    {
        $token = $this->cacheDriver()->issue('test-key');

        $this->assertNotNull($token);
    }

    public function test_cache_driver_could_revoke_token()
    {
        $this->cacheDriver->issue($key = 'test-key');

        $status = $this->cacheDriver()->revoke($key);

        $this->assertTrue($status);
    }

    public function test_revoked_token_cant_revoke_anymore()
    {
        $this->cacheDriver()->issue($key = 'test-key');

        $this->cacheDriver()->revoke($key);
        $status = $this->cacheDriver()->revoke($key);

        $this->assertFalse($status);
    }

    public function test_generated_token_is_useable_once()
    {
        $token = $this->cacheDriver()->issue($key = 'test-key');

        $result = $this->cacheDriver()->use($key, $token);

        $this->assertTrue($result);

        $result = $this->cacheDriver()->use($key, $token);

        $this->assertFalse($result);
    }

    public function test_token_could_be_hash()
    {
        $this->app->config->set('otp.hash', true);

        $token = $this->cacheDriver()->issue($key = 'test-key');

        $hashedToken = Cache::get('laravel-otp-'.$key);

        $this->assertTrue(Hash::check($token, $hashedToken));
    }

}
