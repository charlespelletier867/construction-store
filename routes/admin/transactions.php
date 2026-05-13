<?php

use Illuminate\Support\Facades\Route;

Route::resource('sale_invoices', App\Http\Controllers\Admin\SaleInvoicesController::class);
Route::resource('sale_payments', App\Http\Controllers\Admin\SalePaymentsController::class);
Route::resource('sale_returns', App\Http\Controllers\Admin\SaleReturnsController::class);
Route::resource('quotations', App\Http\Controllers\Admin\QuotationsController::class);

Route::resource('purchase_invoices', App\Http\Controllers\Admin\PurchaseInvoicesController::class);
Route::resource('purchase_payments', App\Http\Controllers\Admin\PurchasePaymentsController::class);
Route::resource('purchase_returns', App\Http\Controllers\Admin\PurchaseReturnsController::class);
