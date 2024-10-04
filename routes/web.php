<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentReplyController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\LoginFacebookController;
use App\Http\Controllers\Auth\LoginGoogleController;
// use App\Http\Controllers\CategoryController;
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

// Route cho trang home không yêu cầu xác thực
Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Route cho trang chưa đăng nhập
Route::prefix('shop')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/login/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);
    Route::get('/login/facebook', [LoginFacebookController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [LoginFacebookController::class, 'handleFacebookCallback']);

    // Các route không yêu cầu đăng nhập
    Route::get('/products', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('product-by-catalogues/{slug}', [ProductController::class, 'productByCatalogues'])->name('client.productByCatalogues');

    Route::get('/blog', [PostController::class, 'index'])->name('client.posts.index');


    Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');

    // Route để lấy danh mục cho menu
    Route::get('/menu-categories', [MenuController::class, 'getCategoriesForMenu'])->name('menu.categories');
});

// Đăng xuất ở admin
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

//
Route::prefix('admin')->middleware(['admin', 'permission:full|editor'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');




    // Route cho vai trò
    Route::resource('roles', RoleController::class);
    Route::get('roles-trash', [RoleController::class, 'trash'])->name('roles.trash');
    Route::post('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');

    //route trang profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');

    // Route Catalogue
    Route::resource('catalogues', CatalogueController::class);
    Route::get('catalogues-trash', [CatalogueController::class, 'trash'])->name('catalogues.trash');
    Route::post('catalogues/{id}/restore', [CatalogueController::class, 'restore'])->name('catalogues.restore');
    Route::delete('catalogues/{id}/force-delete', [CatalogueController::class, 'forceDelete'])->name('catalogues.forceDelete');

    // Route Brand
    Route::resource('brands', BrandController::class);
    Route::get('brands-trash', [BrandController::class, 'trash'])->name('brands.trash');
    Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/{id}/delete-permanently', [BrandController::class, 'deletePermanently'])->name('brands.delete-permanently');

    // routes/web.php
    Route::post('comments/respond/{id}', [PostCommentController::class, 'respond'])->name('comments.respond');
    Route::get('comments-trash', [PostCommentController::class, 'trash'])->name('comments.trash');
    Route::patch('comments/{id}/restore', [PostCommentController::class, 'restore'])->name('comments.restore');
    Route::delete('comments/{id}/delete-permanently', [PostCommentController::class, 'deletePermanently'])->name('comments.delete-permanently');
    Route::resource('comments', PostCommentController::class);
    //  route reply comment post
    Route::get('comments/{comment}/reply/{reply}/edit', [CommentReplyController::class, 'editReply'])->name('comments.reply.edit');
    Route::put('comments/{comment}/reply/{reply}', [CommentReplyController::class, 'updateReply'])->name('comments.reply.update');



    // Route Order
    Route::resource('orders', OrderController::class);
    Route::get('/posts-trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

    // route payment
    Route::resource('/payment-methods', PaymentMethodController::class);
    Route::get('payment-methods-trash', [PaymentMethodController::class, 'trash'])->name('payment-methods.trash');
    Route::post('payment-methods/{id}/restore', [PaymentMethodController::class, 'restore'])->name('payment-methods.restore');
    Route::delete('payment-methods/{id}/force-delete', [PaymentMethodController::class, 'forceDelete'])->name('payment-methods.forceDelete');

    // Routes cho Categories và Posts
    Route::resource('categories', CategoryController::class);
    Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    Route::resource('posts', AdminPostController::class);
    Route::get('posts-trash', [AdminPostController::class, 'trash'])->name('posts.trash');
    Route::post('posts/{id}/restore', [AdminPostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [AdminPostController::class, 'forceDelete'])->name('posts.forceDelete');


    // Routes Cho Product
    Route::resource('products', AdminProductController::class);

    //route banner
    Route::resource('banners', BannerController::class);
    // Banners soft delete routes
    Route::get('banners-trash', [BannerController::class, 'trash'])->name('banners.trash');
    Route::post('banners/{id}/restore', [BannerController::class, 'restore'])->name('banners.restore');
    Route::delete('banners/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('banners.forceDelete');



    //Route product variant
    Route::resource('product-variants', ProductVariantController::class);

    // Route cho chức năng kích hoạt lại trạng thái
    Route::post('product-variants/{id}/activate', [ProductVariantController::class, 'activate'])->name('product-variants.activate');


    // Permission

    Route::resource('permissions', PermissionController::class);

    Route::group(['prefix' => 'permissions:users|full'], function () {

        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('permission:full|user_index|editor');
        Route::get('create', [UserController::class, 'create'])->name('users.create')->middleware('permission:full|user_edit');
        Route::post('create', [UserController::class, 'store'])->name('users.store')->middleware('permission:full|user_edit');
        Route::get('{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:full|user_edit');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:full|user_edit');
        Route::put('{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:full|user_edit');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:full|user_edit');
        Route::get('users-trash', [UserController::class, 'trash'])->name('users.trash')->middleware('permission:full|user_edit');
        Route::post('/{id}/restore', [UserController::class, 'restore'])->name('users.restore')->middleware('permission:full|user_edit');
        Route::delete('/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete')->middleware('permission:full|user_edit');
    });
});
