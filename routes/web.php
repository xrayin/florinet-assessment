<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/shop', [\App\Http\Controllers\ProductController::class, 'index'])->name('shop');

Route::get('/shopping-cart', [\App\Http\Controllers\ShoppingCartController::class, 'index'])->name('shopping-cart');

Route::get('/payment-success', [\App\Http\Controllers\ShoppingCartController::class, 'paymentSuccess'])->name('payment-success');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
