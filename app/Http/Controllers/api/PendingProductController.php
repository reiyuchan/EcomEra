<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PendingProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PendingProductController extends Controller
{
    public function index()
    {
        $pendingProducts = PendingProduct::paginate();

        abort_if(!$pendingProducts, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $pendingProducts
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        abort_if(!$user->hasRole('designer'), Response::HTTP_UNAUTHORIZED, 'user is not a designer');

        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|json',
            'category_code' => 'required|string|max:255',
        ]);

        $product_code = Str::upper(Str::random(4)) . $request->category_code;

        $pendingProduct = $user->pendingProducts()->create([
            'name' => $request->name,
            'details' => $request->details,
            'description' => $request->description,
            'product_code' => $product_code,
            'images' => $request->images,
        ]);

        $value = $pendingProduct->name . " " . Str::random(4) . $pendingProduct->id;

        $slug = Str::slug($value);

        $pendingProduct->slug = $slug;
        $pendingProduct->save();

        return response()->json([
            'data' => $pendingProduct
        ], Response::HTTP_CREATED);;
    }

    public function show($id)
    {
        // TODO: show specifc product
    }

    public function update(Request $request,  $id)
    {
        // TODO: not sure but maybe product??
    }

    public function destroy(PendingProduct $pendingProduct)
    {
        abort_if($pendingProduct->approved, Response::HTTP_FORBIDDEN, 'product already approved');

        $pendingProduct->delete();

        return response()->json([
            'message' => "pending product {$pendingProduct->id} deleted"
        ]);
    }
}
