<?php

use App\Http\Controllers\api;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('/new', [api\UserController::class, 'store']);
    Route::get('', [api\UserController::class, 'show'])->middleware('auth:sanctum');
    Route::delete('/{id}', [api\UserController::class, 'destroy']);
    Route::patch('/{id}', [api\UserController::class, 'update']);
    Route::post('/login', [api\UserController::class, 'login']);
    Route::post('/logout', [api\UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/designer', [api\UserController::class, 'updateRoleToDesigner'])->middleware('auth:sanctum');
});

Route::prefix('product')->group(function () {
    Route::post('/new');
    Route::get('/index');
    Route::get('/{id}');
    Route::get('/user/{id}');
    Route::get('/search', [api\ProductController::class, 'search']);
});

Route::prefix('order')->group(function () {
    Route::post('/new', []);
    Route::delete('/{id}', []);
});
