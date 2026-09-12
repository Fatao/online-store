<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\CarController;
use App\Http\Controllers\Shop\BrandController;
use App\Http\Controllers\Shop\FinanceController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Shop\ReviewController;

// ── Public shop routes ────────────────────────────────────────────────────────
Route::get('/', [CarController::class, 'home'])->name('home');
Route::get('/inventory', [CarController::class, 'index'])->name('inventory.index');
Route::get('/inventory/{car}', [CarController::class, 'show'])->name('inventory.show');

// ── Brands ─────────────────────────────────────────────────────────────────────
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

// ── Financing calculator ──────────────────────────────────────────────────────
Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
Route::post('/finance', [FinanceController::class, 'index'])->name('finance.calculate');

// ── Cart (session-based, no login needed) ─────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',      [CartController::class, 'index'])->name('index');
    Route::post('/add',  [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear',  [CartController::class, 'clear'])->name('clear');
});

// ── Checkout + Orders (login required) ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout',    [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout',   [CheckoutController::class, 'store'])->name('checkout.store');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',        [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});