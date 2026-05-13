<?php

use Illuminate\Support\Facades\Route;

Route::resource('stock_balances', App\Http\Controllers\Admin\StockBalancesController::class);
Route::resource('stock_movements', App\Http\Controllers\Admin\StockMovementsController::class);
Route::resource('stock_transfers', App\Http\Controllers\Admin\StockTransfersController::class);
Route::resource('stock_transfer_items', App\Http\Controllers\Admin\StockTransferItemsController::class);
Route::resource('stock_adjustments', App\Http\Controllers\Admin\StockAdjustmentsController::class);
Route::resource('stock_adjustment_items', App\Http\Controllers\Admin\StockAdjustmentItemsController::class);
Route::resource('damaged_stocks', App\Http\Controllers\Admin\DamagedStocksController::class);
