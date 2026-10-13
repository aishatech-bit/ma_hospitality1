<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CateringBookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CateringRequestController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public storefront — customers shop and request catering bookings here,
| no login required.
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('storefront.home');

Route::get('/shop', [ShopController::class, 'index'])->name('storefront.shop');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('storefront.shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('storefront.cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('storefront.cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('storefront.cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('storefront.cart.remove');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('storefront.checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('storefront.checkout.store');
Route::get('/order/{sale}/confirmation', [CheckoutController::class, 'confirmation'])->name('storefront.order.confirmation');

Route::get('/book-catering', [CateringRequestController::class, 'create'])->name('storefront.booking.create');
Route::get('/book-catering/check-availability', [CateringRequestController::class, 'checkAvailability'])->name('storefront.booking.check');
Route::post('/book-catering', [CateringRequestController::class, 'store'])->name('storefront.booking.store');
Route::get('/book-catering/{booking}/confirmation', [CateringRequestController::class, 'confirmation'])->name('storefront.booking.confirmation');

/*
|--------------------------------------------------------------------------
| Staff admin panel — inventory, sales, customers, booking management,
| reports. Requires login.
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('customers', CustomerController::class)->except(['show']);

    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::post('sales/{sale}/fulfil', [SaleController::class, 'fulfil'])->name('sales.fulfil');

    Route::get('bookings', [CateringBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [CateringBookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [CateringBookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}/edit', [CateringBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{booking}', [CateringBookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [CateringBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('bookings/check-availability', [CateringBookingController::class, 'checkAvailability'])->name('bookings.check');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});
