<?php

namespace App\Services;

use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\Request;

class OrderService
{
    public function getOrder(Request $request, string $confirmation_number, Cart $cart)
    {
        $subtotal = $cart->calculatedPriceByQuantity();
        $newSubtotal = $subtotal - $request->discount ?? 0;

        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }

        $total = $request->shipping_fees + $newSubtotal;

        return [
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billint_name_on_card' => $request->name_on_card,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_state' => $request->state,
            'billing_zip_code' => $request->zip_code,
            'billing_discount_code' => $request->discount_code,
            'billing_discount' => $request->discount,
            'billing_subtotal' => $newSubtotal,
            'billing_total' => $total,
            'shipped' => false,
            'confirmation_number' => $confirmation_number,
        ];
    }
}
