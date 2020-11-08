<?php


namespace Alish\LaravelOtp\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static valid(string $key)
 */
class Otp extends Model
{
    protected $table = 'otps';

    public function scopeValid($query, string $key)
    {
        return $query
            ->where('key', $key)
            ->whereNull('revoke_at')
            ->whereNull('used_at');
    }
}
