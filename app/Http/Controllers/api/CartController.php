<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Binafy\LaravelCart\Models\Cart;
use Binafy\LaravelCart\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{

    public function index()
    {
        $cart = Cart::findOrFail(auth('sanctum')->id());

        $cartItems = $cart->items()->with('itemable')->get();

        return response()->json([
            'data' => $cartItems,
            'meta' => [
                'subtotal' => $cart->calculatedPriceByQuantity(),
                'discounted_price' => $cart->calculatedDiscountByQuantity(),
            ]

        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->id);

        $cart = Cart::firstOrCreate([
            'user_id' => auth('sanctum')->id(),
        ]);

        abort_if($cart->getTotalQuantity() + $request->quantity  > 50, Response::HTTP_FORBIDDEN, 'quantity provided exceeds max limit 50');

        abort_if($cart->items()->find($product->getKey()), Response::HTTP_FORBIDDEN, 'product already exist in cart');

        $cart->storeItem($product);

        return response()->json([
            'message' => 'product added to cart'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $cart = Cart::findOrFail(auth('sanctum')->id());

        $cart->increaseQuantity($cartItem, $request->quantity);

        return response()->json([
            'message' => "item {$cartItem->id} quantity updated"
        ]);
    }

    public function destroy(CartItem $cartItem)
    {
        $cart = Cart::findOrFail(auth('sanctum')->id());

        $cart->removeItem($cartItem->id);

        return response()->json([
            'message' => "item {$cartItem->id} deleted"
        ], Response::HTTP_OK);
    }

    public function destroyAll()
    {
        $cart = Cart::findOrFail(auth('sanctum')->id());

        $cart->emptyCart();

        return response()->json([
            'message' => 'cart has been emptied'
        ]);
    }
}
