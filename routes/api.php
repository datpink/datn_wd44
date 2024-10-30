<?php

use App\Http\Controllers\Client\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('shop/products/filter-by-price', [ProductController::class, 'filterByPrice']);

Route::get('/shop/products',                  [ProductController::class, 'orderByPriceApi']);
Route::get('/shop/products/filter-by-color',                  [ProductController::class, 'filterByColor']);
Route::get('/shop/products/filter-by-storage',                  [ProductController::class, 'filterByStorage']);
