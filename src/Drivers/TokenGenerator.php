<?php


namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Util\Random;

trait TokenGenerator
{
    protected ?Random $randomGenerator = null;

    protected function randomGenerator()
    {
        if (!is_null($this->randomGenerator)) {
            return $this->randomGenerator;
        }

        $this->randomGenerator = new Random([
            'type' => $this->tokenType(),
            'length' => $this->tokenLength()
        ]);

        if (!is_null($this->customSet())) {
            $this->randomGenerator = $this->randomGenerator()->custom($this->customSet());
        }

        return $this->randomGenerator;
    }

    protected function generateToken(): string
    {
        return $this->randomGenerator()
            ->generate();
    }
}
