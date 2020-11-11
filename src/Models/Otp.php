<?php


namespace Alish\LaravelOtp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static valid(string $key)
 * @property string token
 * @property Carbon revoked_at
 * @property Carbon used_at
 * @property Carbon expires_at
 */
class Otp extends Model
{
    protected $table = 'otps';

    protected $casts = [
        'revoked_at' => 'datetime',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function scopeValid($query, string $key)
    {
        return $query
            ->where('key', $key)
            ->whereNull('revoked_at')
            ->whereNull('used_at')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function useNow(): bool
    {
        $this->used_at = now();
        return $this->save();
    }
}
