<?php

use App\Http\Controllers\Admin\DriversController;
use App\Http\Controllers\Admin\VehiclesController;
use Illuminate\Support\Facades\Route;

Route::resource('deliveries', App\Http\Controllers\Admin\DeliveriesController::class);
Route::resource('drivers', DriversController::class);
Route::resource('vehicles', VehiclesController::class);
Route::resource('vehicle_expenses', App\Http\Controllers\Admin\VehicleExpensesController::class);
