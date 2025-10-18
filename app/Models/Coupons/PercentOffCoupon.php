<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Model;

class PercentOffCoupon extends Model
{
    protected $fillable = [
        'percent_off'
    ];

    protected $casts = [
        'percent_off' => 'decimal:2',
    ];

    public function discount($order)
    {
        return ($this->precent_off / 100) * $order;
    }
}
