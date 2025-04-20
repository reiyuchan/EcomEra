<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = cache()->rememberForever('products', function () {
            return Product::paginate();
        });

        abort_if(!$products, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $products,
        ], Response::HTTP_OK);;
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => $product,
        ], Response::HTTP_OK);;
    }

    public function showByUser(User $user)
    {
        $products = $user->products()->get();

        return response()->json([
            'data' => $products,
        ], Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $products = Product::where('name', 'like', "%{$query}%")->get();

        abort_if(!$products, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $products,
        ], Response::HTTP_OK);;
    }

    public function bestSelling(Request $request)
    {
        $limit = $request->query('limit');

        $bestSelling =  cache()->remember('best_selling', now()->addDays(1), function () use ($limit) {
            return  Product::sortByBestSelling($limit);
        });

        abort_if(!$bestSelling, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $bestSelling,
        ], Response::HTTP_OK);;
    }
}
