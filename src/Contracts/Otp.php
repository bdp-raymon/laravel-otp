<?php

namespace Alish\LaravelOtp\Contracts;

interface Otp
{

    /**
     * issue new token for provided key
     * @param string $key
     * @return string
     */
    public function issue(string $key): string;

    /**
     * revoke token for provided key
     * @param string $key
     * @return bool
     */
    public function revoke(string $key): bool;

    /**
     * check if provided pair of (key, token) match any previous stored token with correspond key
     * @param string $key
     * @param string $token
     * @return bool
     */
    public function check(string $key, string $token): bool;

    /**
     * use token for provided key, if provided key exist, and usable return true, otherwise return false
     * @param string $key
     * @param string $token
     * @return bool
     */
    public function use(string $key, string $token): bool;

}
