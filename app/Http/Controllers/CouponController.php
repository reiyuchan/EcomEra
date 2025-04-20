<?php

namespace App\Http\Controllers;

use App\Models\Coupons\Coupon;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $coupon_code)
    {
        $couponCode = Coupon::findByCode($coupon_code);

        abort_if(!$couponCode, Response::HTTP_NOT_FOUND, "couldn't find the coupon. Please try again!");

        $coupon = $couponCode->couponable;

        $cart = Cart::query()->findOrFail([
            'user_id' => auth('sanctum')->id(),
        ]);

        $subtotal = $cart->calculatedPriceByQuantity();

        $discount = $coupon->discount($subtotal);

        return response()->json([
            'data' => [
                'coupon_code' => $couponCode->code,
                'discount' => $discount,
            ],
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
