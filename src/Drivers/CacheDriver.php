<?php

namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Contracts\Otp;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Hashing\Hasher;


class CacheDriver implements Otp
{
    use HasConfig, TokenGenerator, TokenManipulator;

    protected string $namespace = 'laravel-otp';

    protected CacheManager $cache;

    protected Hasher $hash;

    protected array $config;

    public function __construct(CacheManager $cache, Hasher $hash, array $config)
    {
        $this->cache = $cache;
        $this->hash = $hash;
        $this->config = $config;
    }

    public function issue(string $key): string
    {
        $this->storeToken($key, $token = $this->generateToken());

        return $token;
    }

    protected function storeToken(string $key, string $token): bool
    {
        if (is_null($this->timeout())) {
            return $this->cache->forever(
                $this->key($key),
                $this->storableToken($token)
            );
        }

        return $this->cache->set(
            $this->key($key),
            $this->storableToken($token),
            $this->timeout()
        );
    }

    public function key(string $key): string
    {
        return $this->namespace . '-' . $key;
    }

    public function check(string $key, string $token): bool
    {
        return $this->compareTokens(
            $token,
            $this->cache->get($this->key($key))
        );
    }

    public function use(string $key, string $token): bool
    {
        $result = $this->check($key, $token);

        if ($result){
            $this->forgetToken($key);
        }

        return $result;
    }

    public function forgetToken(string $key): bool
    {
        return $this->cache->forget($this->key($key));
    }

    public function revoke(string $key): bool
    {
        return $this->forgetToken($key);
    }


}
