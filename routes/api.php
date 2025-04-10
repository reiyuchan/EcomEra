<?php

use App\Http\Controllers\api\DesignerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/new', [UserController::class, 'store']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('designer')->group(function () {
    Route::post('/new', [DesignerController::class, 'update'])->middleware('auth:sanctum');
    Route::get('/{id}/products');
});

Route::prefix('product')->group(function () {
    Route::get('/index');
    Route::get('/{id}');
});

Route::prefix('order')->group(function () {
    Route::post('/new', []);
    Route::delete('/{id}', []);
});
