<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductOrdersController;
use App\Http\Controllers\ProductShoppingCartController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserAddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Dashboard
Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');

// JWT Authenficiation
Route::get('/auth', 'App\Http\Controllers\UserController@getAuthenticatedUser');
Route::post('/register', 'App\Http\Controllers\UserController@register');
Route::post('/login', [UserController::class, 'login']);

// Address
Route::get('/user/default-address', 'App\Http\Controllers\UserAddressController@show');
Route::post('/user/create-user-address', 'App\Http\Controllers\UserAddressController@createUser');
Route::post('/user/address', 'App\Http\Controllers\UserAddressController@store');

// Brand
Route::get('/brand', [BrandController::class, 'index']);
Route::post('/brand', [BrandController::class, 'store']);
Route::delete('/brand/{id}', [BrandController::class, 'destroy']);
Route::get('/brand/edit/{id}', [BrandController::class, "edit"]);
Route::patch('/brand/{id}', [CategoryController::class, 'update']);
Route::get('status/{id}', [BrandController::class, "status"]);
Route::delete('delete/{id}', [BrandController::class, "delete"]);
Route::delete('destroy/{id}', [BrandController::class, "destroy"]);

// Product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/products/edit/{id}', [ProductController::class, "edit"]);
Route::get("/danh-muc/{slug}", [SanPhamController::class, 'category']);
Route::get("/thuong-hieu/{slug}", [SanPhamController::class, 'brand']);
Route::get('/search', [SanPhamController::class, 'search']);
Route::get('/product-detail/{slug}', [SanPhamController::class, 'product_detail']);

// Protected Routes
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/cart/addcart', [ProductShoppingCartController::class, 'store']);
    Route::get('/cart', [ProductShoppingCartController::class, 'index']);
    Route::post('/cart/update', [ProductShoppingCartController::class, 'update']);
    Route::delete('/cart/delete/{id}', [ProductShoppingCartController::class, 'destroy']);
    Route::get('/cart/count', [ProductShoppingCartController::class, 'cartCount']);
});
Route::post('/cart/guest', [ProductShoppingCartController::class, 'guestCart']);

// Product Shopping Cart
Route::get('/product/cart-list/count', 'App\Http\Controllers\ProductShoppingCartController@cartCount');
Route::get('/product/cart-list/', 'App\Http\Controllers\ProductShoppingCartController@index');
Route::post('/product/cart-list', 'App\Http\Controllers\ProductShoppingCartController@store');
Route::post('/product/cart-list/guest', 'App\Http\Controllers\ProductShoppingCartController@guestCart');
Route::put('/product/cart-list/{id}', 'App\Http\Controllers\ProductShoppingCartController@update');
Route::delete('/product/cart-list/{id}', 'App\Http\Controllers\ProductShoppingCartController@destroy');

// Product Orders
Route::post('/product/orders', [ProductOrdersController::class, 'store']);
Route::middleware('auth:api')->get('/order/history', [OrderController::class, 'history']);

// Category
Route::get('categories', [CategoryController::class, 'index']);
Route::post('product/categories', [CategoryController::class, 'store']);
Route::get('/product/categories/{id}/new', 'App\Http\Controllers\ProductCategoriesController@new');
Route::delete('/product/categories/{id}', 'App\Http\Controllers\ProductCategoriesController@destroy');
Route::patch('/product/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/product/categories/{id}', [CategoryController::class, 'destroy']);
Route::get('/product/categories/{id}', [CategoryController::class, 'show']);

// Post
Route::middleware('auth:api')->get('/news', [NewsController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('edit/{id}', [PostController::class, "edit"]);
Route::put('update/{id}', [PostController::class, "update"]);
Route::get('status/{id}', [PostController::class, "status"]);
Route::delete('delete/{id}', [PostController::class, "delete"]);
Route::delete('destroy/{id}', [PostController::class, "destroy"]);

//Topic
Route::get('/topic', [TopicController::class, "index"]);
Route::get('/topic/create', [TopicController::class, "create"]);
Route::post('store', [TopicController::class, "store"]);
Route::get('edit/{id}', [TopicController::class, "edit"]);
Route::put('update/{id}', [TopicController::class, "update"]);
Route::get('status/{id}', [TopicController::class, "status"]);
Route::delete('delete/{id}', [TopicController::class, "delete"]);
Route::get('restore/{id}', [TopicController::class, "restore"]);
Route::delete('destroy/{id}', [TopicController::class, "destroy"]);

// Menu
Route::get('/menu', [MenuController::class, "index"]);
Route::post('/place-order', [ProductOrdersController::class, 'placeOrder']);

// Product Count by Category
Route::get('/product/count-by-category', [ProductController::class, 'productCountByCategory']);
Route::get('/product/count-by-brand', [ProductController::class, 'productCountByBrand']);

Route::get('/comments/{slug}', [CommentController::class, 'index']);
Route::post('/comments/{slug}', [CommentController::class, 'store']);