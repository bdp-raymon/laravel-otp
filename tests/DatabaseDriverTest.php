<?php


namespace Alish\LaravelOtp\Tests;


use Alish\LaravelOtp\Drivers\DatabaseDriver;
use Alish\LaravelOtp\Models\Otp;
use Alish\LaravelOtp\OtpServiceProvider;
use Illuminate\Support\Facades\Hash;
use Orchestra\Testbench\TestCase;

class DatabaseDriverTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh')->run();
    }

    protected function getPackageProviders($app)
    {
        return [OtpServiceProvider::class];
    }

    protected function databaseDriver() : DatabaseDriver
    {
        return $this->app->make('otp')->driver('database');
    }

    public function test_database_driver_could_issue_token()
    {
        $token = $this->databaseDriver()->issue($key = 'test-key');

        $this->assertNotNull($token);

        $this->assertDatabaseHas('otps', ['key' => $key, 'token' => $token]);
    }

    public function test_database_driver_could_revoke_token()
    {
        $this->databaseDriver()->issue($key = 'test-key');
        $revoked = $this->databaseDriver()->revoke($key);

        $this->assertTrue($revoked);

        $this->assertDatabaseCount('otps', 1);
        $otp = Otp::where('key', $key)->first();

        $this->assertNotNull($otp->revoked_at);
    }

    public function test_database_driver_could_use_token_once()
    {
        $token = $this->databaseDriver()->issue($key = 'test-key');

        $result = $this->databaseDriver()->use($key, $token);

        $this->assertTrue($result);

        $result = $this->databaseDriver()->use($key, $token);

        $this->assertFalse($result);
    }

    public function test_database_driver_could_hash_token()
    {
        $this->app->config->set('otp.hash', true);
        $token = $this->databaseDriver()->issue($key = 'test-key');

        $this->assertDatabaseCount('otps', 1);
        $otp = Otp::where('key', $key)->first();

        $this->assertTrue(Hash::check($token, $otp->token));
    }

}
