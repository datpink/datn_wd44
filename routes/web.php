<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentReplyController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\DiscountController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductCommentController;
use App\Http\Controllers\Admin\ProductCommentReplyController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ReviewResponseController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginFacebookController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\NotificationController as ClientNotificationController;
use App\Http\Controllers\FavoriteController;
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

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

   // Route hiển thị danh sách thông báo
   Route::get('/notifications', [ClientNotificationController::class, 'index'])->name('notifications.index');
   Route::get('/notifications/{id}/read', [ClientNotificationController::class, 'markAsReadAndRedirect'])->name('notifications.read');
   // Các route không yêu cầu đăng nhập
    Route::get('products', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('products/chi-tiet/{slug}', [ProductController::class, 'show'])->name('client.products.product-detail');
    Route::get('product-by-catalogues/{parentSlug}/{childSlug?}', [ProductController::class, 'productByCatalogues'])->name('client.productByCatalogues');
    Route::get('/products/chi-tiet/{slug}', [ProductController::class, 'show'])->name('client.products.product-detail');
    Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
    Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::post('product/{product}/comment', [ProductController::class, 'storeComment'])->name('client.storeComment');
    Route::post('comment/{comment}/reply', [ProductController::class, 'storeReply'])->name('client.storeReply');

    Route::get('list-product-favorite', [ProductController::class, 'productFavorite'])->name('client.listProductFavorites');
    Route::post('add-product-favorite', [ProductController::class, 'addProductFavorite']);
    Route::post('remove-product-favorite', [ProductController::class, 'removeProductFavorite']);



    // Route sửa và xóa bình luận
    Route::put('product/{product}/comment/{comment}/edit', [ProductController::class, 'updateComment'])->name('client.updateComment');
    Route::delete('product/{product}/comment/{comment}/delete', [ProductController::class, 'deleteComment'])->name('client.deleteComment');

    // Route sửa và xóa phản hồi
    Route::put('comment/{comment}/reply/{reply}/edit', [ProductController::class, 'updateReply'])->name('client.updateReply');
    Route::delete('comment/{comment}/reply/{reply}/delete', [ProductController::class, 'deleteReply'])->name('client.deleteReply');
    // route review , review respone
    Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])->name('client.storeReview');
    Route::post('/reviews/{review}/responses', [ProductController::class, 'storeResponse'])->name('client.storeReviewResponse');

    // Route::get('product-by-catalogues/{slug}', [ProductController::class, 'productByCatalogues'])->name('client.productByCatalogues');
    // Route::get('product-by-child/{parentSlug}/{childSlug}', [ProductController::class, 'productByChildCatalogues'])->name('client.productByChildCatalogues');



    Route::get('/blog', [PostController::class, 'index'])->name('client.posts.index');
    Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
    Route::get('/search', [PostController::class, 'search'])->name('search');
    Route::get('/posts/latest', [PostController::class, 'latest'])->name('posts.latest'); // Chỉ cần nếu bạn tạo phương thức này
    Route::post('/post/{id}/comments', [PostController::class, 'storeComment'])->name('post.comments.store');
    Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');


    // Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::get('/privacy-policy', function () {
        return view('client.privacy_policy.privacy_policy'); // Cập nhật đường dẫn tới view
    })->name('privacy.policy');


    Route::get('/contact', [App\Http\Controllers\Client\ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [App\Http\Controllers\Client\ContactController::class, 'store'])->name('contact.store');

    // Route để lấy danh mục cho menu
    Route::get('/menu-categories', [MenuController::class, 'getCategoriesForMenu'])->name('menu.categories');

    // Route cho trang profile
    Route::get('/profile', [UserController::class, 'viewProfile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update/{id}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit-password', [UserController::class, 'editPassword'])->name('profile.edit-password');
    Route::post('profile/update-password/{id}', [UserController::class, 'updatePassword'])->name('profile.update-password');

    //route cho trang lịch sử đơn hàng
    Route::get('/order-history/{userId}', [OrderController::class, 'showOrderHistory'])->name('order.history');
    Route::get('/order/{order}', [OrderController::class, 'detailOrderHistory'])->name('order.detail');

    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund');


    //route cho trang nhập mã giảm giá
    Route::post('/add-promotion', [DiscountController::class, 'addPromotion'])->name('promotion.add');
    Route::get('/promotions', [DiscountController::class, 'showPromotions'])->name('promotion.index');

    Route::get('/discount-codes', [DiscountController::class, 'showDiscountCodes'])->name('discountCodes');
    Route::post('/apply-discount', [DiscountController::class, 'applyDiscount'])->name('applyDiscount');

});

Route::get('/about', [AboutController::class, 'index'])->name('client.about.index');

// GIỏ hàng
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/temporary', [CartController::class, 'temporary'])->name('cart.temporary');
Route::get('cart/view', [CartController::class, 'view'])->name('cart.view');
Route::post('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');




// thanh toán
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('showCheckout');
Route::post('/checkout', [CheckoutController::class, 'showCheckout'])->name('showCheckout');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('applyCoupon');

// Route để xử lý AJAX lấy danh sách huyện
Route::get('/get-districts/{provinceId}', [CheckoutController::class, 'getDistricts'])->name('getDistricts');
Route::get('/get-wards/{districtId}', [CheckoutController::class, 'getWards'])->name('getWards');
Route::post('/get-shipping-fee', [CheckoutController::class, 'getShippingFee'])->name('getShippingFee');
Route::post('/vnpay',[PaymentController::class,'vnpay'])->name('vnpay');
Route::get('/vnpay_return', [PaymentController::class, 'vnpayReturn'])->name('vnpayReturn');
Route::get('/order-failed', [PaymentController::class, 'orderFailed'])->name('order.failed');




// Đăng xuất ở admin
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

//
Route::prefix('admin')->middleware(['admin', 'permission:full|editor'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Promotions
    Route::resource('promotions', PromotionController::class);

    Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contact.index');
    Route::delete('/contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::post('/contacts/{id}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('admin.contact.reply');

    // Route cho vai trò
    Route::resource('roles', RoleController::class);
    Route::get('roles-trash', [RoleController::class, 'trash'])->name('roles.trash');
    Route::post('roles/{id}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('roles/{id}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');

    //route trang profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    // Danh sách thông báo
    Route::get('/notification', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');

    // Thêm thông báo
    Route::get('/notification/create', [AdminNotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/notification', [AdminNotificationController::class, 'store'])->name('admin.notifications.store');

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
    Route::resource('product-comments', ProductCommentController::class);

    // Phản hồi bình luận sản phẩm (trả lời cho bình luận sản phẩm)
    Route::post('product-comments/respond/{id}', [ProductCommentController::class, 'respond'])->name('product-comments.respond');
    Route::get('product-comments-trash', [ProductCommentController::class, 'trash'])->name('product-comments.trash');
    Route::patch('product-comments/{id}/restore', [ProductCommentController::class, 'restore'])->name('product-comments.restore');
    Route::delete('product-comments/{id}/delete-permanently', [ProductCommentController::class, 'deletePermanently'])->name('product-comments.delete-permanently');

    // Quản lý trả lời bình luận sản phẩm
    Route::get('product-comments/{comment}/reply/{reply}/edit', [ProductCommentReplyController::class, 'editReply'])->name('product-comments.reply.edit');
    Route::put('product-comments/{comment}/reply/{reply}', [ProductCommentReplyController::class, 'updateReply'])->name('product-comments.reply.update');
    // Đánh giá
    Route::resource('product-reviews', ProductReviewController::class);

    // Quản lý đánh giá sản phẩm
    Route::post('product-reviews/respond/{id}', [ProductReviewController::class, 'respond'])->name('product-reviews.respond');
    Route::get('product-reviews-trash', [ProductReviewController::class, 'trash'])->name('product-reviews.trash');
    Route::patch('product-reviews/{id}/restore', [ProductReviewController::class, 'restore'])->name('product-reviews.restore');
    Route::delete('product-reviews/{id}/delete-permanently', [ProductReviewController::class, 'deletePermanently'])->name('product-reviews.delete-permanently');

    // Quản lý phản hồi đánh giá sản phẩm
    Route::get('product-reviews/{review}/response/{response}/edit', [ReviewResponseController::class, 'editResponse'])->name('product-reviews.response.edit');
    Route::put('product-reviews/{review}/response/{response}', [ReviewResponseController::class, 'updateResponse'])->name('product-reviews.response.update');


    // Route Order
    Route::resource('orders', OrderController::class);

    Route::get('/posts-trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

    // Route xuất hóa đơn PDF
    Route::get('/orders/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('orders.invoice');

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

    // Route resource cho quảng cáo
    Route::resource('admin/advertisements', AdvertisementController::class);

    // //Route product variant
    // Route::resource('product-variants', ProductVariantController::class);

    // // Route cho chức năng kích hoạt lại trạng thái
    Route::post('product-variants/{id}/activate', [ProductVariantController::class, 'activate'])->name('product-variants.activate');
    Route::resource('attributes', AttributeController::class);
    Route::resource('attributes.attribute_values', AttributeValueController::class);


    Route::get('admin/products/{product}/variants', [ProductVariantController::class, 'index'])->name('products.variants.index');
    Route::get('admin/products/{product}/variants/create', [ProductVariantController::class, 'create'])->name('products.variants.create');
    Route::post('admin/products/{product}/variants', [ProductVariantController::class, 'store'])->name('variants.store');
    Route::patch('admin/variants/{variant}/status', [ProductVariantController::class, 'updateStatus'])->name('variants.updateStatus');

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
    Route::middleware('auth')->group(function () {
        Route::post('/favorite/{productId}', [FavoriteController::class, 'addFavorite'])->name('favorite.add');
        Route::delete('/favorite/{productId}', [FavoriteController::class, 'removeFavorite'])->name('favorite.remove');
    });
});
