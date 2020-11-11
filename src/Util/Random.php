<?php

namespace Alish\LaravelOtp\Util;

use Illuminate\Support\Arr;

class Random
{

    /**
     * supported types: alpha, alphanumeric, numeric
     * @var string
     */
    protected string $type = 'alphanumeric';

    protected int $length = 6;

    protected string $numerics = '0123456789';

    protected string $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected string $specials = "!\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";

    protected ?string $custom = null;

    public function __construct(array $config = [])
    {
        $this->type = Arr::get($config, 'type', $this->type);
        $this->length = Arr::get($config, 'length', $this->length);
    }

    public function custom(string $custom): self
    {
        $this->custom = $custom;
        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function length(int $length): self
    {
        $this->length = $length;
        return $this;
    }

    public function generate(): string
    {
        $random = '';

        for ($i = 0; $i < $this->length; $i++) {
            $random .= $this->getRandomCharacter();
        }

        return $random;
    }

    public function characters(): array
    {
        if (!is_null($this->custom)) {
            return str_split($this->custom);
        }

        switch ($this->type) {
            case 'numeric':
                $characters = $this->numerics;
                break;
            case 'alpha':
                $characters = $this->alpha;
                break;
            case 'strong':
                $characters = $this->numerics . $this->alpha . $this->specials;
                break;
            case 'alphanumeric':
            default:
                $characters = $this->numerics . $this->alpha;
                break;
        }

        return str_split($characters);
    }

    public function getRandomCharacter(): string
    {
        $characters = $this->characters();
        return $characters[array_rand($characters)];
    }

}
