<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'confirmation_number',
        'billing_email',
        'billing_name',
        'billing_name_on_card',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_subtotal',
        'billing_total',
        'shipped',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
