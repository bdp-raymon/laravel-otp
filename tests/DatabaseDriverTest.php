<?php


namespace Alish\LaravelOtp\Tests;


use Alish\LaravelOtp\Drivers\DatabaseDriver;
use Alish\LaravelOtp\OtpServiceProvider;
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

    public function test()
    {
        $token = $this->databaseDriver()->issue($key = 'test-key');

        $this->assertNotNull($token);

        $this->assertDatabaseHas('otps', ['key' => $key, 'token' => $token]);
    }

}
