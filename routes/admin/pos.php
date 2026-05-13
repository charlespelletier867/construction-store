<?php

use App\Http\Controllers\Admin\POSController;
use Illuminate\Support\Facades\Route;

Route::prefix('pos')->name('pos.')->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('index');
    Route::get('search-products', [POSController::class, 'searchProducts'])->name('search_products');
    Route::post('checkout', [POSController::class, 'checkout'])->name('checkout');
});
