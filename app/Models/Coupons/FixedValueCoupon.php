<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Model;

class FixedValueCoupon extends Model
{
    protected $fillable = [
        'value'
    ];

    public function discount($order)
    {
        return $this->value;
    }
}
