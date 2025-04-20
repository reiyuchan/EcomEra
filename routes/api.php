<?php

use App\Http\Controllers\api;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('', [api\UserController::class, 'store'])->middleware('throttle:5,1');
    Route::get('', [api\UserController::class, 'show'])->middleware('auth:sanctum');
    Route::delete('/{user}', [api\UserController::class, 'destroy'])->middleware('auth:sanctum');
    Route::put('/update', [api\UserController::class, 'update'])->middleware('throttle:5,1');
    Route::post('/login', [api\UserController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/forget-password', [api\UserController::class, 'forgetPassword'])->middleware(['guest', 'throttle:5,1'])->name('password.email');
    Route::post('/reset-password', [api\UserController::class, 'resetPassword'])->middleware('guest')->name('password.update');
    Route::post('/logout', [api\UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/designer', [api\UserController::class, 'updateRoleToDesigner'])->middleware(['auth:sanctum', 'throttle:5,1']);
    Route::post('/picture-upload', [api\UserController::class, 'uploadPicture'])->middleware(['auth:sanctum', 'throttle:5,1']);
});

Route::prefix('product')->group(function () {
    Route::post('');
    Route::get('', [api\ProductController::class, 'index']);
    Route::get('/{product:slug}', [api\ProductController::class, 'show']);
    Route::get('/user/{user}', [api\ProductController::class, 'showByUser'])->middleware('auth:sanctum');
    Route::get('/search', [api\ProductController::class, 'search']);
    Route::get('/bestselling', [api\ProductController::class, 'bestSelling']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('', [api\CartController::class, 'index']);
        Route::post('', [api\CartController::class, 'store']);
        Route::put('/item/{cartItem}', [api\CartController::class, 'update']);
        Route::delete('/item/{cartItem}', [api\CartController::class, 'destroy']);
        Route::delete('/all', [api\CartController::class, 'destroyAll']);
    });

    Route::prefix('product/pending')->group(function () {
        Route::get('', [api\PendingProductController::class, 'index']);
        // Route::get('/{pendingProduct}', [api\PendingProductController::class, 'show']);
        Route::post('', [api\PendingProductController::class, 'store']);
        Route::delete('/{pendingProduct}', [api\PendingProductController::class, 'destroy']);
    });

    Route::prefix('order')->group(function () {
        Route::post('', [api\OrderController::class, 'store']);
        Route::put('/{order}', [api\OrderController::class, 'update']);
    });
});

Route::prefix('mail')->group(function () {
    // Route::prefix('verify')->group(function () {
    //     Route::get('/{id}/{hash}', [MailController::class, 'verify'])->middleware('signed')->name('verification.verify');
    //     Route::post('/resend', [MailController::class, 'verifyResend'])->middleware(['auth:sanctum', 'throttle:5,1'])->name('verification.send');
    // });

    Route::get('/unsubscribe/{id}/{hash}', [MailController::class, 'unsubscribe']);
    Route::get('/subscribe/{id}/{hash}', [MailController::class, 'subscribe']);
});
