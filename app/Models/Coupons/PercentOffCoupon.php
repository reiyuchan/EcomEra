<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Model;

class PercentOffCoupon extends Model
{
    protected $fillable = [
        'percent_off'
    ];

    public function discount($order)
    {
        return $this->precent_off * $order;
    }
}
