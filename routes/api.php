<?php

use App\Http\Controllers\Admin\AdminController;
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

Route::post('/shop/products',                  [ProductController::class, 'orderByPriceApi']);
Route::get('/shop/products/filter-by-color',                  [ProductController::class, 'filterByColor']);
Route::get('/shop/products/filter-by-color-catalogies',                  [ProductController::class, 'productByCatalogues']);
Route::post('/shop/products/filter-catalogies-api',                  [ProductController::class, 'productByCataloguesApi']);
Route::get('/shop/products/filter-by-storage',                  [ProductController::class, 'filterByStorage']);
// Route::post('/shop/add-product-favorite', [ProductController::class, 'addProductFavorite']);

Route::get('san-pham-ban-chay',[AdminController::class,'topBanChay']);
Route::get('thong-ke-theo-trang-thai',[AdminController::class,'topStatus']);
Route::get('get-transaction-time',[AdminController::class,'getTransactionTime']);
Route::get('get-data-order-time',[AdminController::class,'getOrderTime']);
Route::get('get-data-period-chart',[AdminController::class,'getperiodChart']);

