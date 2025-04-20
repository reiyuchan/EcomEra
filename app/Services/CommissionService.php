<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Order;
use App\Models\Product;

class CommissionService
{
    protected $defaultCommissionRate = 10.00; // 10%

    public function calculateCommissions(Order $order)
    {
        foreach ($order->products as $product) {
            $this->calculateProductCommission($order, $product);
        }
    }

    protected function calculateProductCommission(Order $order, Product $product)
    {
        // Skip if product has no designer
        if (!$product->user) {
            return;
        }

        $quantity = $product->pivot->quantity;
        $price = $product->pivot->price;
        $commissionRate = $this->getCommissionRate($product);
        $commissionAmount = ($price * $quantity) * ($commissionRate / 100);

        Commission::updateOrCreate(
            [
                'order_id' => $order->id,
                'product_id' => $product->id
            ],
            [
                'designer_id' => $product->designer->id,
                'product_price' => $price,
                'quantity' => $quantity,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'status' => 'pending'
            ]
        );
    }

    protected function getCommissionRate($product)
    {
        // You can customize this to get rate from product, designer, or other logic
        return $product->commission_rate ?? $this->defaultCommissionRate;
    }
}
