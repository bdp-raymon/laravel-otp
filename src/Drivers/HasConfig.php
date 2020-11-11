<?php


namespace Alish\LaravelOtp\Drivers;


use Illuminate\Support\Arr;

trait HasConfig
{

    protected function tokenType(): string
    {
        return $this->getConfig('type', 'alphanumeric');
    }

    protected function tokenLength(): int
    {
        return $this->getConfig('length', 6);
    }

    protected function timeout(): ?int
    {
        return $this->getConfig('timeout', null);
    }

    protected function customSet(): ?string
    {
        return $this->getConfig('custom', null);
    }

    protected function shouldHash(): bool
    {
        return Arr::get($this->config, 'hash', false);
    }

    protected function sensitiveCase()
    {
        return Arr::get($this->config, 'case-sensitive', true);
    }

    protected function getConfig(string $key, $default)
    {
        return property_exists($this, 'config') ?
            Arr::get($this->config, $key, $default) :
            $default;
    }

}
