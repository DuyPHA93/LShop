<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'search'])->name('products');
Route::get('/detail/{id}', [ProductController::class, 'showDetail'])->name('detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/addToCart', [CartController::class, 'add'])->name('addToCart');
Route::post('/updateCart', [CartController::class, 'update'])->name('updateCart');

Route::get('/order', [UserController::class, 'showMyOrder'])->name('myOrderList');
Route::get('/order-detail/{id?}', [UserController::class, 'showOrderDetail'])->name('myOrderDetail');

Route::get('/register', [RegisterController::class, 'showRegisterForm']);
Route::post('/performRegister', [RegisterController::class, 'perform']);

Route::get('/master/login', [LoginController::class, 'showAdminLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showUserLoginForm'])->name('showUserLoginForm');
Route::post('/master/login', [LoginController::class, 'authenticateAdmin']);
Route::post('/login', [LoginController::class, 'authenticateUser']);
Route::get('/checkAuth', [LoginController::class, 'checkAuth'])->name('checkAuth');

Route::get('/master/logout', [LoginController::class, 'logoutAdmin'])->name('logoutAdmin');
Route::get('/logout', [LoginController::class, 'logoutUser'])->name('logoutUser');

Route::middleware('auth')->group(function() {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkoutForm');
    Route::post('/checkout', [CheckoutController::class, 'perform'])->name('performCheckout');
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/master/dashboard',                  [DashboardController::class, 'index'])              ->name('dashboard');
    Route::get('/master/productTypes',               [ProductTypeController::class, 'masterList'])       ->name('productTypeMasterList');
    Route::get('/master/brands',                     [BrandController::class, 'masterList'])             ->name('brandMasterList');
    Route::get('/master/products',                   [ProductController::class, 'masterList'])           ->name('productMasterList');
    Route::get('/master/featuredProducts',           [FeaturedProductController::class, 'masterList'])   ->name('featuredProductMasterList');
    Route::get('/master/users',                      [UserController::class, 'masterList'])              ->name('userMasterList');
    Route::get('/master/orders',                     [OrderController::class, 'masterList'])             ->name('orderMasterList');
    
    Route::get('/master/productType/{id?}',          [ProductTypeController::class, 'masterDetail'])     ->name('productTypeDetail');
    Route::get('/master/brand/{id?}',                [BrandController::class, 'masterDetail'])           ->name('brandDetail');
    Route::get('/master/product/{id?}',              [ProductController::class, 'masterDetail'])         ->name('productDetail');
    Route::get('/master/featuredProduct/{id?}',      [FeaturedProductController::class, 'masterDetail']) ->name('featuredProductDetail');
    Route::get('/master/user/{id?}',                 [UserController::class, 'masterDetail'])            ->name('userDetail');
    Route::get('/master/order/{id?}',                [OrderController::class, 'masterDetail'])           ->name('orderDetail');
    
    Route::post('/master/productType/{id?}',         [ProductTypeController::class, 'save'])             ->name('saveProductType');
    Route::post('/master/brand/{id?}',               [BrandController::class, 'save'])                   ->name('saveBrand');
    Route::post('/master/product/{id?}',             [ProductController::class, 'save'])                 ->name('saveProduct');
    Route::post('/master/featuredProduct/{id?}',     [FeaturedProductController::class, 'save'])         ->name('saveFeaturedProduct');
    Route::post('/master/user/{id?}',                [UserController::class, 'save'])                    ->name('saveUser');
    Route::post('/master/order/{id?}',               [OrderController::class, 'save'])                   ->name('saveOrder');

    Route::post('/master/productTypes/delete',       [ProductTypeController::class, 'delete'])           ->name('deleteProductType');
    Route::post('/master/brands/delete',             [BrandController::class, 'delete'])                 ->name('deleteBrand');
    Route::post('/master/products/delete',           [ProductController::class, 'delete'])               ->name('deleteProduct');
    Route::post('/master/featuredProducts/delete',   [FeaturedProductController::class, 'delete'])       ->name('deleteFeaturedProduct');
    Route::post('/master/users/delete',              [UserController::class, 'delete'])                  ->name('deleteUser');

    Route::post('/master/productTypes/disable',      [ProductTypeController::class, 'disable'])          ->name('disableProductType');
    Route::post('/master/brands/disable',            [BrandController::class, 'disable'])                ->name('disableBrand');
    Route::post('/master/products/disable',          [ProductController::class, 'disable'])              ->name('disableProduct');
    Route::post('/master/featuredProducts/disable',  [FeaturedProductController::class, 'disable'])      ->name('disableFeaturedProduct');
    Route::post('/master/users/disable',             [UserController::class, 'disable'])                 ->name('disableUser');

    Route::get('/master/getBrandHtml',               [BrandController::class, 'getBrandHtml'])           ->name('getBrandHtml');
});