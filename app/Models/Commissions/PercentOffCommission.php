<?php

namespace App\Models\Commissions;

use Illuminate\Database\Eloquent\Model;

class PercentOffCommission extends Model
{
    protected $fillable = [
        'percent_off',
    ];

    protected $casts = [
        'percent_off' => 'decimal:2',
    ];

    public function commission($order)
    {
        return ($this->percent_off / 100) * $order;
    }
}
