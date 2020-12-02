<?php


namespace Alish\LaravelOtp\Tests;


class DatabaseDriverTest extends DriverTestCase
{

    protected string $driver = 'database';

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh')->run();
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    public function test_database_driver_could_issue_token()
    {
        $token = $this->issueToken($key = 'test');

        $this->assertNotNull($token);
        $this->assertTrue($this->checkToken($key, $token));

        $this->assertDatabaseHas('otps', ['key' => $key, 'token' => $token]);
    }

    public function test_database_driver_could_revoke_token()
    {
        $token = $this->issueToken($key = 'test');
        $revoked = $this->revokeToken($key);

        $this->assertTrue($revoked);
        $this->assertFalse($this->checkToken($key, $token));
    }

    public function test_database_driver_could_use_token_once()
    {
        $token = $this->issueToken($key = 'test-key');

        $result = $this->useToken($key, $token);

        $this->assertTrue($result);

        $result = $this->useToken($key, $token);

        $this->assertFalse($result);
    }

    public function test_token_will_expire_after_timeout()
    {
        $this->app->config->set('otp.timeout', $timeout = 60);

        $token = $this->issueToken($key = 'test');

        $this->travel($timeout + 1)->seconds();

        $this->assertFalse($this->checkToken($key, $token));
    }

    public function test_multiple_active_concurrent_token_possible()
    {
        $token1 = $this->issueToken($key = 'test');
        $token2 = $this->issueToken($key);

        $this->assertTrue($this->checkToken($key, $token1));
        $this->assertTrue($this->checkToken($key, $token2));
    }

    public function test_all_previous_valid_token_could_revoke()
    {
        $this->app->config->set('otp.unique', true);

        $token1 = $this->issueToken($key = 'test');
        $token2 = $this->issueToken($key);

        $this->assertFalse($this->checkToken($key, $token1));
        $this->assertTrue($this->checkToken($key, $token2));
    }

    public function test_wrong_input_couldnt_revoke_token()
    {
        $token = $this->issueToken($key = 'test-key');

        $wrong_token = 'aaa';

        $this->assertFalse($this->useToken($key, $wrong_token));

        $this->assertTrue($this->checkToken($key, $token));
    }

}
