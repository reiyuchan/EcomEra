<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $fillable = [
        'user_id',
        'referral_code',
        'total_referred_users'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
