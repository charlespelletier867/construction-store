<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BranchSwitchController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.login');
});

Route::post('/locale/{locale}', [LocaleController::class, 'switch'])
    ->where('locale', 'en|km')
    ->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Guest (login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.attempt');
});

/*
|--------------------------------------------------------------------------
| Authenticated admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

    Route::post('/branch/switch', [BranchSwitchController::class, 'switch'])->name('branch.switch');

    require __DIR__ . '/admin/master_data.php';
    require __DIR__ . '/admin/transactions.php';
    require __DIR__ . '/admin/inventory.php';
    require __DIR__ . '/admin/delivery.php';
    require __DIR__ . '/admin/finance.php';
    require __DIR__ . '/admin/administration.php';
    require __DIR__ . '/admin/reports.php';
    require __DIR__ . '/admin/pos.php';
});
