<?php

use Illuminate\Support\Facades\Route;

Route::resource('stock_transfers', App\Http\Controllers\Admin\StockTransfersController::class);
Route::resource('stock_adjustments', App\Http\Controllers\Admin\StockAdjustmentsController::class);
Route::resource('damaged_stocks', App\Http\Controllers\Admin\DamagedStocksController::class);
