<?php

use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\WarehousesController;
use Illuminate\Support\Facades\Route;

Route::resource('companies', CompaniesController::class);
Route::resource('branches', BranchesController::class);
Route::resource('warehouses', WarehousesController::class);

Route::resource('users', App\Http\Controllers\Admin\UsersController::class);
Route::resource('roles', App\Http\Controllers\Admin\RolesController::class);
Route::resource('permissions', App\Http\Controllers\Admin\PermissionsController::class);

Route::resource('system_settings', App\Http\Controllers\Admin\SystemSettingsController::class)->only(['index', 'edit', 'update']);
Route::resource('number_sequences', App\Http\Controllers\Admin\NumberSequencesController::class)->except(['show']);
Route::resource('document_templates', App\Http\Controllers\Admin\DocumentTemplatesController::class)->except(['show']);
Route::get('audit_logs', [App\Http\Controllers\Admin\AuditLogsController::class, 'index'])->name('audit_logs.index');
Route::get('login_histories', [App\Http\Controllers\Admin\LoginHistoriesController::class, 'index'])->name('login_histories.index');
