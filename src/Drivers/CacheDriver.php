<?php

namespace Alish\LaravelOtp\Drivers;

use Alish\LaravelOtp\Contracts\Otp;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Arr;


class CacheDriver implements Otp
{
    use TokenGenerator, Hashable;

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
        $token = $this->generateToken();

        $this->cache->set(
            $this->key($key),
            $this->hashToken($token),
            $this->timeout()
        );

        return $token;
    }



    public function revoke(string $key): bool
    {
        return $this->cache->forget($this->key($key));
    }

    public function use(string $key, string $token): bool
    {
        return $this->checkToken(
            $token,
            $this->cache->get($this->key($key))
        );
    }

    protected function timeout(): int
    {
        return Arr::get($this->config, 'timeout', 5 * 60);
    }

    protected function key(string $key): string
    {
        return $this->namespace . '-' . $key;
    }
}
