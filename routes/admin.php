<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('cars', CarController::class);
    Route::resource('brands', BrandController::class);

    Route::get('orders',         [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    Route::get('customers',                    [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}',         [CustomerController::class, 'show'])->name('customers.show');
    Route::put('customers/{customer}/toggle',  [CustomerController::class, 'toggleRegular'])->name('customers.toggleRegular');
});