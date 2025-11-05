<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');


Route::middleware(['auth',])  
    ->prefix('admin')                       
    ->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
Route::put('/product/status/{id}', [ProductController::class, 'status'])->name('product.status');
Route::put('/product/hotproducts/{id}', [ProductController::class, 'hots'])->name('product.hots');
Route::put('/product/topsell/{id}', [ProductController::class, 'tops'])->name('product.tops');
Route::put('/product/feature/{id}', [ProductController::class, 'features'])->name('product.features');



Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{status}', [OrderController::class, 'status'])->name('orders.status');

Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])
    ->name('orders.updateStatus');

Route::post('/orders/update-multiple-status', [OrderController::class, 'updateMultipleStatus'])
    ->name('orders.updateMultipleStatus');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');


Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/delete/{id}', [BrandController::class, 'delete'])->name('brands.delete');

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('/settings/edit/{id}', [SettingController::class, 'edit'])->name('settings.edit');
Route::get('/othersettings/edit/{id}', [SettingController::class, 'osedit'])->name('osinfos.edit');
Route::put('/settings/update/{id}', [SettingController::class, 'update'])->name('settings.update');
Route::put('/othersettings/update/{id}', [SettingController::class, 'osupdate'])->name('osinfos.update');

Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
Route::post('/role/store', [RoleController::class, 'store'])->name('roles.store');
Route::put('/role/update/{$id}', [RoleController::class, 'update'])->name('roles.update');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');



});









Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/product/details/{slug}', [HomeController::class, 'details'])->name('product.details');
Route::get('/categories/details/{id}', [HomeController::class, 'categories'])->name('categories');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/order-now', [CartController::class, 'orderNow'])->name('cart.orderNow');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/checkout/confirm', [CartController::class, 'confirm'])->name('checkout.confirm');
Route::get('/checkout/success/{id}', [CartController::class, 'success'])->name('checkout.success');
