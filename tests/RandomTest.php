<?php


namespace Alish\LaravelOtp\Tests;


use Alish\LaravelOtp\Util\Random;
use Orchestra\Testbench\TestCase;

class RandomTest extends TestCase
{

    public function test_random_class_generate_correct_random()
    {
        $random = new Random();

        $this->assertNotNull($random->generate());

        $random->length(10);

        $this->assertEquals(10, strlen($random->generate()));

        $random->type('numeric');

        $this->assertTrue(is_numeric($random->generate()));
    }

    public function test_random_class_custom_set_generation()
    {
        $random = new Random();

        $token = $random->custom($custom = "123456789")->generate();

        $this->assertMatchesRegularExpression('/[1-9]/', $token);

        $token = $random->custom($custom = "abcdefghijklmnopqrstuvwxyz")->generate();

        $this->assertMatchesRegularExpression('/[a-z]/', $token);
    }

}
