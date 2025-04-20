<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = cache()->rememberForever('orders', function () {
            return Order::all();
        });

        return response()->json([
            'data' => $orders,
        ], Response::HTTP_OK);
    }

    public function store(OrderService $orderService, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'name_on_card' => 'sometimes|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'discount_code' => 'sometimes|string|max:255',
            'discount' => 'sometimes|numeric|gt:0',
            'shipping_fees' => 'required|numeric|gt:0',
            'subtotal' => 'required|numeric|gt:0',
            'total' => 'required|numeric|gt:0',
        ]);

        $confirmation_number = Str::uuid();

        $user =  $request->user();

        $order = $user->orders()->create($orderService->getOrder($request, $confirmation_number));

        $cart = Cart::firstOrCreate([
            'user_id' => auth('sanctum')->id(),
        ]);

        $cartItems = $cart->items()->with('itemable')->get();

        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item->itemable->id);
            $order->products()->attach($product, ['quantity' => $item->quantity]);
        }

        return response()->json([
            'data' => [
                'confirmation_number' => $order->confirmation_number,
                'billing_subtotal' => $order->billing_subtotal,
                'billing_discount_code' => $order->billing_discount_code,
                'billing_discount' => $order->billing_discount,
                'billing_total' => $order->billing_total,
                'items' => $order->products,
            ],
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        // TODO: get specific order
    }

    public function update(Request $request, Order $order)
    {

        $request->validate([
            'cancelled' => 'required|boolean',
        ]);

        abort_if($order->shipped, Response::HTTP_FORBIDDEN, 'order has been already shipped');

        $order->cancelled = $request->cancelled;

        $order->save();

        return response()->json([
            'data' => $order,
            'message' => "order {$order->id} cancelled",
        ], Response::HTTP_OK);
    }

    public function destroy(Order $order)
    {
        //
    }
}
