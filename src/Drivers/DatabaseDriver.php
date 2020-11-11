<?php

namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Contracts\Otp;
use Alish\LaravelOtp\Models\Otp as OtpModel;
use Illuminate\Contracts\Hashing\Hasher;

class DatabaseDriver implements Otp
{
    use HasConfig, TokenGenerator, TokenManipulator;

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
        $this->revokeAllTokensIfNeeded($key);
        $this->createOtpModel($key, $token);
        return $token;
    }

    public function createOtpModel(string $key, string $token): OtpModel
    {
        return OtpModel::forceCreate([
            'key' => $key,
            'token' => $this->hashedToken($token),
            'expires_at' => now()->addSeconds($this->timeout())
        ]);
    }

    protected function shouldRevoke(): bool
    {
        return $this->getConfig('unique', false);
    }

    protected function revokeAllTokensIfNeeded(string $key)
    {
        if ($this->shouldRevoke()) {
            return $this->revoke($key);
        }

        return null;
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
        $foundValidOtp = $this->findValidOtp($key, $token);

        if (is_null($foundValidOtp)) {
            return false;
        }

        return $foundValidOtp->useNow();
    }

    public function findValidOtp(string $key, string $token): ?OtpModel
    {
        $otps = OtpModel::valid($key)->get();

        if ($otps->count() === 0) {
            return null;
        }

        foreach ($otps as $otp) {
            $result = $this->compareTokens($token, $otp->token);

            if ($result) {
                return $otp;
            }
        }

        return null;
    }

    public function check(string $key, string $token): bool
    {
        $foundValidOtp = $this->findValidOtp($key, $token);

        if (is_null($foundValidOtp)) {
            return false;
        }

        return true;
    }
}
