<?php

namespace Alish\LaravelOtp\Tests;

use Orchestra\Testbench\TestCase;
use Alish\LaravelOtp\LaravelOtpServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelOtpServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
