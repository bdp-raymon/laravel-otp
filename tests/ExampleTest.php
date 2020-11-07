<?php

namespace Alish\LaravelOtp\Tests;

use Orchestra\Testbench\TestCase;
use Alish\LaravelOtp\OtpServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [OtpServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
