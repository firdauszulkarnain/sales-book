<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::resource('/sales', SalesController::class);
Route::put('/product/stock/{product:id}', [HomeController::class, 'update_stock']);
Route::get('/dashboard', [HomeController::class, 'dashboard']);