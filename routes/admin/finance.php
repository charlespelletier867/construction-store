<?php

use App\Http\Controllers\Admin\ExpenseCategoriesController;
use Illuminate\Support\Facades\Route;

Route::resource('expenses', App\Http\Controllers\Admin\ExpensesController::class);
Route::resource('expense_categories', ExpenseCategoriesController::class);

Route::get('customer_ledger', [App\Http\Controllers\Admin\CustomerLedgerController::class, 'index'])->name('customer_ledger.index');
Route::get('customer_ledger/{customer}', [App\Http\Controllers\Admin\CustomerLedgerController::class, 'show'])->name('customer_ledger.show');

Route::get('supplier_ledger', [App\Http\Controllers\Admin\SupplierLedgerController::class, 'index'])->name('supplier_ledger.index');
Route::get('supplier_ledger/{supplier}', [App\Http\Controllers\Admin\SupplierLedgerController::class, 'show'])->name('supplier_ledger.show');
