<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PendingProductController extends Controller
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
}
