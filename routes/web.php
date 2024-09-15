<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    //Route Catalogue
    Route::resource('catalogues', CatalogueController::class);
    Route::get('catalogues-trash', [CatalogueController::class, 'trash'])->name('catalogues.trash');
    Route::post('catalogues/{id}/restore', [CatalogueController::class, 'restore'])->name('catalogues.restore');
    Route::delete('catalogues/{id}/force-delete', [CatalogueController::class, 'forceDelete'])->name('catalogues.forceDelete');

    //Route Brands
    Route::resource('brands', BrandController::class);

    //Route Order
    Route::resource('orders', OrderController::class);
    Route::get('/orders-trash', [OrderController::class, 'trash'])->name('orders.trash');
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');
    Route::delete('/orders/{id}/force-delete', [OrderController::class, 'forceDelete'])->name('orders.forceDelete');
});
