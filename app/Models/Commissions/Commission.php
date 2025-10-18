<?php

namespace App\Models\Commissions;

use Illuminate\Database\Eloquent\Model;
use App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Commission extends Model
{
    protected $fillable = [
        'commissionable_id',
        'commissionable_type',
        'paid',
        'amount',
        'user_id',
        'order_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    public function commissionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function commission($order)
    {
        return $this->commissionable()->commission($order);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Models\User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Models\Order::class);
    }
}
