<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OperationsController as AdminOperationsController;
use App\Http\Controllers\Shop\HomeController as ShopHomeController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\CartController as ShopCartController;
use App\Http\Controllers\Shop\CheckoutController as ShopCheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('/admin')->group(function () {
    Route::middleware(['auth', 'verified', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('admin.dashboard.export');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/export', [AdminCategoryController::class, 'export'])->name('admin.categories.export');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');

        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/export', [AdminProductController::class, 'export'])->name('admin.products.export');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/export', [AdminCustomerController::class, 'export'])->name('admin.customers.export');
        Route::get('/customers/create', [AdminCustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('/customers', [AdminCustomerController::class, 'store'])->name('admin.customers.store');

        Route::get('/inventory', [AdminOperationsController::class, 'inventory'])->name('admin.inventory.index');
        Route::get('/inventory/export', [AdminOperationsController::class, 'exportInventory'])->name('admin.inventory.export');
        Route::get('/payments', [AdminOperationsController::class, 'payments'])->name('admin.payments.index');
        Route::get('/payments/export', [AdminOperationsController::class, 'exportPayments'])->name('admin.payments.export');
        Route::get('/shipping', [AdminOperationsController::class, 'shipping'])->name('admin.shipping.index');
        Route::get('/shipping/export', [AdminOperationsController::class, 'exportShipping'])->name('admin.shipping.export');
        Route::get('/store', [AdminOperationsController::class, 'store'])->name('admin.store.index');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [ShopCartController::class, 'index'])->name('cart.index');
    Route::post('/cart/items', [ShopCartController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{item}', [ShopCartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{item}', [ShopCartController::class, 'destroy'])->name('cart.items.destroy');

    Route::get('/checkout', [ShopCheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [ShopCheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}/success', [ShopCheckoutController::class, 'success'])->name('orders.success');

   

});

Route::get('/shop', [ShopHomeController::class, 'index'])->name('shop');
Route::get('/shop/products/{product:slug}', [ShopProductController::class, 'show'])->name('shop.products.show');




require __DIR__ . '/auth.php';
