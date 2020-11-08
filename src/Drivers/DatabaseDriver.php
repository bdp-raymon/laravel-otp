<?php

namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Contracts\Otp;
use Alish\LaravelOtp\Models\Otp as OtpModel;

class DatabaseDriver implements Otp
{
    use TokenGenerator, Hashable;

    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function issue(string $key): string
    {
        $token = $this->generateToken();
        $this->createOtpModel($token);
        return $token;
    }

    public function createOtpModel(string $token): OtpModel
    {
        return OtpModel::forceCreate([
            'token' => $this->hashToken($token)
        ]);
    }

    public function revoke(string $key): bool
    {
        return OtpModel::valid($key)
            ->update([
                'revoke_at' => now()
            ]) > 0;
    }

    public function use(string $key, string $token): bool
    {
        return OtpModel::valid($key)
            ->update([
                'used_at' => now()
            ]) > 0;
    }
}
