<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ShippingCity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShippingCityController extends Controller
{

    public function index()
    {
        $cities = cache()->rememberForever('categories', function () {
            return ShippingCity::all();
        });

        abort_if(!$cities, Response::HTTP_NOT_FOUND);

        return response()->json([
            'data' => $cities,
        ], Response::HTTP_OK);;
    }
}
