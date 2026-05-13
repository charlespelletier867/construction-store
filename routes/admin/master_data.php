<?php

use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Admin\UnitsController;
use Illuminate\Support\Facades\Route;

Route::resource('products', ProductsController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('brands', BrandsController::class);
Route::resource('units', UnitsController::class);
Route::resource('customers', CustomersController::class);
Route::resource('suppliers', SuppliersController::class);
