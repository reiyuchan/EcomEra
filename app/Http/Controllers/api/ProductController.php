<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // TODO: best seller
    }

    public function store(Request $request)
    {
        // TODO: store new product by user
    }

    public function show(string $id)
    {
        // TODO: show specifc product
    }

    public function update(Request $request, string $id)
    {
        // TODO: not sure but maybe product??
    }

    public function destroy(string $id)
    {
        // TODO: delete product by user
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $products = Product::where('name', 'like', "%{$query}%")->get();

        return $products;
    }
}
