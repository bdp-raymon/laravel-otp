<?php


namespace Alish\LaravelOtp\Drivers;


use Illuminate\Support\Arr;

trait Hashable
{

    protected function checkToken(string $token, string $originalToken)
    {
        if ($this->shouldHash()) {
            return $this->hash->check($token, $originalToken);
        }

        return $token === $originalToken;
    }

    protected function shouldHash(): bool
    {
        return Arr::get($this->config, 'hash', false);
    }

    protected function hashToken(string $token): string
    {
        if ($this->shouldHash()) {
            return $this->hash->make($token);
        }

        return $token;
    }

}
