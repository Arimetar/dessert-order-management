<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DessertController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\OrderController;
use App\Models\Customer;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/customer/check/order/{order_id}/detail', [CustomerController::class, 'orderDetail'])->name('order.detail');
Route::get('/customer/ordering', [CustomerController::class, 'index'])->name('customer-ordering');
Route::get('/customer/checkout/{festival_id}', [CustomerController::class, 'checkOut'])->name('customer.check.out');
Route::get('/', [DessertController::class, 'index'])->name('dessert.home');
Route::get('/customer/check', [CustomerController::class, 'index'])->name('customer.check');
Route::POST('/customer/check/status', [CustomerController::class, 'check'])->name('customer.check.status');
Route::POST('/order', [OrderController::class, 'order'])->name('customer.order');

Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('auth')  // สามารถแก้เป็น middleware ที่อนุญาตให้ผู้ใช้ที่ล็อกอินอยู่ได้
        ->name('register.page');
Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('auth')  // แก้เป็น middleware ที่อนุญาตให้ผู้ใช้ที่ล็อกอินอยู่ได้
        ->name('register');




// admin 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function () {
        //Route::get('/admin/home', [DessertController::class, 'index'])->name('admin.home');
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');

    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
        Route::get('/admin/orders/{status}', [OrderController::class, 'filterStatusOrder'])->name('admin.orders.filter');
        Route::get('/admin/orders/filter', [OrderController::class, 'filterByFestival'])->name('admin.orders.festival');
        Route::get('/admin/order/{order_id}/detail', [OrderController::class, 'orderDetailAdmin'])->name('admin.order.detail');
        Route::get('/admin/order/{order_id}/{status}', [OrderController::class, 'changeStatus'])->name('order.status.change');
        // dessert manage
        Route::post('/desserts/store', [DessertController::class, 'store'])->name('desserts.store');
        Route::get('/desserts', [DessertController::class, 'dessertList'])->name('admin.dessert');
        Route::get('/desserts/filter/festival', [DessertController::class, 'filterDessert'])->name('admin.dessert.filter');
        Route::get('/desserts/on/{dessertID}', [DessertController::class, 'onDessert'])->name('admin.dessert.on');
        Route::get('/desserts/off/{dessertID}', [DessertController::class, 'offDessert'])->name('admin.dessert.off');
        // festival manage
        Route::get('/dashboard/festivals', [FestivalController::class, 'index'])->name('admin.festivals');
        Route::post('/dashboard/festivals/store', [FestivalController::class, 'store'])->name('admin.festivals.store');
        Route::post('/festivals/desserts', [FestivalController::class, 'updateFestivalDesserts'])->name('update.festival.desserts');
        Route::GET('/festivals/on/{festival_id}', [FestivalController::class, 'onFestival'])->name('admin.festival.on');
        Route::GET('/festivals/off/{festival_id}', [FestivalController::class, 'offFestival'])->name('admin.festival.off');
});

// cart
Route::post('/cart/{dessert}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::put('/cart/update/{dessertId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{dessertId}', [CartController::class, 'removeProduct'])->name('cart.remove');
