<?php

use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\SearchController;
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
<<<<<<< HEAD
Route::get('/shop/products/filter-by-color',                  [ProductController::class, 'filterByColor']);
Route::get('/shop/products/filter-by-storage',                  [ProductController::class, 'filterByStorage']);
=======
Route::get('/shop/products/filter-by-color', [ProductController::class, 'filterByColor']);
Route::get('/search/suggestions', [SearchController::class, 'getSuggestions'])->name('search.suggestions');
>>>>>>> 64988c4b24a0df24b25649e93dfc0dd28fed1927
