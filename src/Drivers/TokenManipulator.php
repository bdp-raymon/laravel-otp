<?php


namespace Alish\LaravelOtp\Drivers;


use Illuminate\Support\Arr;

trait TokenManipulator
{

    protected function hashedToken(string $token): string
    {
        if ($this->shouldHash()) {
            return $this->hash->make($token);
        }

        return $token;
    }

    protected function caseManipulatedToken(string $token): string
    {
        return $this->sensitiveCase() ? $token : strtolower($token);
    }

    protected function storableToken(string $token): string
    {
        $token = $this->caseManipulatedToken($token);
        $token = $this->hashedToken($token);

        return $token;
    }

    protected function comparableToken(string $token): string
    {
        $token = $this->caseManipulatedToken($token);

        return $token;
    }

    protected function compareTokens(string $token, ?string $originalToken): bool
    {
        if (!$originalToken) {
            return false;
        }

        $comparableToken = $this->comparableToken($originalToken);

        if ($this->shouldHash()) {
            return $this->hash->check($token, $comparableToken);
        }

        return $token === $comparableToken;
    }

}
