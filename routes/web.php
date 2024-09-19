<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ContactController;

use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController; 


>>>>>>> ea8c1e1 (Fix route)
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

// Route cho trang chưa đăng nhập
Route::prefix('shop')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Các route không yêu cầu đăng nhập
    Route::get('/products', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('/blog', [PostController::class, 'index'])->name('client.posts.index');
    Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');

    // Route để lấy danh mục cho menu
    Route::get('/menu-categories', [MenuController::class, 'getCategoriesForMenu'])->name('menu.categories');
});

// Route cho trang home không yêu cầu xác thực
Route::get('/', [ClientController::class, 'index'])->name('client.index');


// Route đăng nhập
=======

// Route cho trang chưa đăng nhập
Route::prefix('shop')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Các route không yêu cầu đăng nhập
    Route::get('/products', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('/blog', [PostController::class, 'index'])->name('client.posts.index');
    Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');

    // Route để lấy danh mục cho menu
    Route::get('/menu-categories', [MenuController::class, 'getCategoriesForMenu'])->name('menu.categories');
});

// // Route cho trang home không yêu cầu xác thực
// Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Route đăng nhập admin
>>>>>>> cbe318c (oai-commit-route-full)
=======
});

// Route cho trang home không yêu cầu xác thực
Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Route đăng nhập admin
>>>>>>> a94ac8bdcd9f323d15acd8a274fbb7b2f6285709
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Routes dành cho quản trị viên
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
=======
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
>>>>>>> ea8c1e1 (Fix route)
=======

    //route trang profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
>>>>>>> cbe318c (oai-commit-route-full)

=======
    //route trang profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');

>>>>>>> a94ac8bdcd9f323d15acd8a274fbb7b2f6285709
    // Route Catalogue
    Route::resource('catalogues', CatalogueController::class);
    Route::get('catalogues-trash', [CatalogueController::class, 'trash'])->name('catalogues.trash');
    Route::post('catalogues/{id}/restore', [CatalogueController::class, 'restore'])->name('catalogues.restore');
    Route::delete('catalogues/{id}/force-delete', [CatalogueController::class, 'forceDelete'])->name('catalogues.forceDelete');

    // Route Brand
    Route::resource('brands', BrandController::class);
    Route::get('brands-trash', [BrandController::class, 'trash'])->name('brands.trash');
    Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');

    // Route Order
    Route::resource('orders', OrderController::class);
    Route::get('/orders-trash', [OrderController::class, 'trash'])->name('orders.trash');
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');
    Route::delete('/orders/{id}/force-delete', [OrderController::class, 'forceDelete'])->name('orders.forceDelete');

    // Routes cho Categories và Posts
    Route::resource('categories', CategoryController::class);
<<<<<<< HEAD
    Route::resource('posts', PostController::class);
    Route::get('posts-trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
<<<<<<< HEAD

});
<<<<<<< HEAD
>>>>>>> e840986137bb2adabdab216a1304e4d98cf45182
=======
});
>>>>>>> ea8c1e1 (Fix route)
=======

>>>>>>> cbe318c (oai-commit-route-full)
=======
    Route::resource('posts', AdminPostController::class);
    Route::get('posts-trash', [AdminPostController::class, 'trash'])->name('posts.trash');
    Route::post('posts/{id}/restore', [AdminPostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [AdminPostController::class, 'forceDelete'])->name('posts.forceDelete');
});
>>>>>>> a94ac8bdcd9f323d15acd8a274fbb7b2f6285709
