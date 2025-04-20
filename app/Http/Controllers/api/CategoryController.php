<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
// use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = cache()->rememberForever('categories', function () {
            return Category::all();
        });

        abort_if(!$categories, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $categories,
        ], Response::HTTP_OK);;
    }

    // public function show(Category $category)
    // {
    //     return $category;
    // }
}
