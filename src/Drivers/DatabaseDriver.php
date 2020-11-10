<?php

namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Contracts\Otp;
use Alish\LaravelOtp\Models\Otp as OtpModel;
use Illuminate\Contracts\Hashing\Hasher;

class DatabaseDriver implements Otp
{
    use TokenGenerator, Hashable;

    protected array $config;

    protected Hasher $hash;

    public function __construct(Hasher $hash, array $config)
    {
        $this->hash = $hash;
        $this->config = $config;
    }

    public function issue(string $key): string
    {
        $token = $this->generateToken();
        $this->createOtpModel($key, $token);
        return $token;
    }

    public function createOtpModel(string $key, string $token): OtpModel
    {
        return OtpModel::forceCreate([
            'key' => $key,
            'token' => $this->hashToken($token)
        ]);
    }

    public function revoke(string $key): bool
    {
        return OtpModel::valid($key)
            ->update([
                'revoked_at' => now()
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
