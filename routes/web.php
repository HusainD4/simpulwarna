<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ApiController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;

// ─── PUBLIC ROUTES ─────────────────────────────────────────────
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');
Route::get('checkout', [HomepageController::class, 'checkout'])->name('checkout.index');

// ─── CUSTOMER CART ─────────────────────────────────────────────
Route::middleware(['is_customer_login'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::delete('cart/remove/{id}', 'remove')->name('cart.remove');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
    });
});

// ─── CUSTOMER AUTH ─────────────────────────────────────────────
Route::prefix('customer')->controller(CustomerAuthController::class)->group(function () {
    Route::middleware('check_customer_login')->group(function () {
        Route::get('login', 'login')->name('customer.login');
        Route::post('login', 'store_login')->name('customer.store_login');
        Route::get('register', 'register')->name('customer.register');
        Route::post('register', 'store_register')->name('customer.store_register');
    });

    Route::post('logout', 'logout')->name('customer.logout');
});

// ─── CHECKOUT ─────────────────────────────────────────────
Route::middleware('is_customer_login')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

// ─── DASHBOARD (ADMIN SYSTEM DEFAULT) ─────────────────────────────
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD resource dashboard (non-custom UI)
    Route::resource('categories', ProductCategoryController::class)->names('dashboard.categories');
    Route::resource('products', ProductController::class)->names('dashboard.products');
    Route::resource('themes', ThemeController::class);

    // Sinkronisasi Produk & Kategori
    Route::post('products/sync/{id}', [ProductController::class, 'sync'])->name('products.sync');
    Route::post('categories/sync/{id}', [ProductCategoryController::class, 'sync'])->name('categories.sync');
});


// ─── ADMIN PANEL ROUTES (Custom Admin UI) ─────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/sync', [AdminProductController::class, 'sync'])->name('products.sync');

    // Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/{id}/sync', [AdminCategoryController::class, 'sync'])->name('categories.sync');
});

Route::delete('/admin/categories/{category}', [ProductCategoryController::class, 'destroy'])
    ->name('dashboard.categories.destroy');

// ─── REDIRECT ROLE ─────────────────────────────────────────────
Route::get('/redirect-role', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    return redirect('/');
})->middleware('auth');

// ─── SETTINGS (Volt UI) ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// ─── DEFAULT AUTH ─────────────────────────────────────────────
require __DIR__.'/auth.php';
