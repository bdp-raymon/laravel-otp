<?php


namespace Alish\LaravelOtp\Drivers;


use Alish\LaravelOtp\Util\Random;
use Illuminate\Support\Arr;

trait TokenGenerator
{

    protected Random $random;

    protected string $type = 'alphanumeric';

    protected int $length = 6;

    protected function random()
    {
        return $this->random ?? $this->random = new Random([
            'type' => $this->tokenType(),
            'length' => $this->tokenLength()
        ]);
    }

    protected function tokenType(): string
    {
        return $this->getConfig('type', 'alphanumeric');
    }

    protected function tokenLength(): int
    {
        return $this->getConfig('length', 6);
    }

    protected function getConfig(string $key, $default)
    {
        return property_exists($this, 'config') ?
            Arr::get($this->config, $key, $default) :
            $default;
    }

    protected function generateToken(): string
    {
        return $this->random()->generate();
    }
}
