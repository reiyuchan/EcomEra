<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'couponable_id',
        'couponable_type',
    ];

    public function couponable(): MorphTo
    {
        return $this->morphTo();
    }

    public function findByCode(string $code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($order)
    {
        return $this->couponable()->discount($order);
    }
}
