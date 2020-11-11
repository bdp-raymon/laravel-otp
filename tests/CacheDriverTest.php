<?php


namespace Alish\LaravelOtp\Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;


class CacheDriverTest extends DriverTestCase
{

    protected string $driver = 'cache';

    public function test_cache_driver_could_issue_token()
    {
        $token = $this->issueToken($key = 'test-1');
        $this->assertNotNull($token);
        $this->assertTrue($this->checkToken($key, $token));
        $this->assertNotNull($this->issueToken('test-2'));
        $this->assertNotNull($this->issueToken('test-3'));
        $this->assertNotNull($this->issueToken('test-1'));
    }

    public function test_cache_driver_could_revoke_token()
    {
        $token = $this->issueToken($key = 'test-key');
        $status = $this->revokeToken($key);

        $this->assertTrue($status);
        $this->assertFalse($this->checkToken($key, $token));
    }

    public function test_generated_token_is_usable_once()
    {
        $token = $this->issueToken($key = 'test');

        $result = $this->useToken($key, $token);

        $this->assertTrue($result);

        $result = $this->useToken($key, $token);

        $this->assertFalse($result);
    }

    public function test_token_could_be_hash()
    {
        $this->app->config->set('otp.hash', true);

        $token = $this->issueToken($key = 'test');

        $hashedToken = Cache::get($this->driver()->key($key));

        $this->assertTrue(Hash::check($token, $hashedToken));
    }

    public function test_token_will_expire_after_timeout()
    {
        $this->app->config->set('otp.timeout', $timeout = 60);

        $token = $this->issueToken($key = 'test');

        $this->travel($timeout + 1)->seconds();

        $this->assertFalse($this->checkToken($key, $token));
    }

}
