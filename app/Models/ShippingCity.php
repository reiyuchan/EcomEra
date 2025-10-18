<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCity extends Model
{
    protected $fillabe = [
        'name',
        'shipping_fees',
    ];
}
