<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);


Route::put('/product/stock/{product:id}', [HomeController::class, 'update_stock']);