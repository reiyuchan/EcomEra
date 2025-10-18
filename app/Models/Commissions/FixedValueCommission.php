<?php

namespace App\Models\Commissions;

use Illuminate\Database\Eloquent\Model;

class FixedValueCommission extends Model
{
    protected $fillable = [
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function commission($order)
    {
        return $this->value;
    }
}
