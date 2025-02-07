<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return csrf_token();
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/cart', [CartController::class, 'showCart']);

Route::post('cart/add', [CartController::class, 'addToCart']);

Route::post('cart/checkout', [CartController::class, 'checkout']);
