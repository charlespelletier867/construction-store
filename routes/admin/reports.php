<?php

use App\Http\Controllers\Admin\ReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('sales', [ReportsController::class, 'sales'])->name('sales');
    Route::get('stock', [ReportsController::class, 'stock'])->name('stock');
    Route::get('profit', [ReportsController::class, 'profit'])->name('profit');
    Route::get('payable', [ReportsController::class, 'payable'])->name('payable');
    Route::get('receivable', [ReportsController::class, 'receivable'])->name('receivable');
    Route::get('branch-performance', [ReportsController::class, 'branchPerformance'])->name('branch_performance');
});
