<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
// Home
Route::get('/', [AuthController::class, 'home'])->name('home');
// Auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// User Dashboard & Profile
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
// Tampilkan form reset password
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset.form');
// Proses update password
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
// Marketplace Pages
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/product', fn() => view('product'))->name('product');
Route::get('/marketplace', fn() => view('marketplace'))->name('marketplace');
Route::get('/docs', fn() => view('docs'))->name('docs');
// For Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
Route::post('/profile', [ProfileController::class, 'store'])->name('user.profile.store');
// Admin Pages (protected by is_admin middleware)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});
// Views By Category
Route::get('/categories/{id}/products', [ProductController::class, 'productsByCategory'])->name('products.by.category');
Route::get('/categories', [CategoryController::class, 'main'])->name('categories.main');
// For single Product
Route::get('/product/{id}', [ProductController::class, 'show'])->name('single.products');
// Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::put('/update-cart/{id}', [CartController::class, 'update'])->name('update.cart');
    Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('add.to.cart');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('remove.from.cart');
    // 🛒 Checkout routes
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
});
Route::post('/checkout/terima/{id}', [CheckoutController::class, 'terima'])->name('checkout.terima');
Route::post('/checkout/batalkan/{id}', [CheckoutController::class, 'batalkan'])->name('checkout.batalkan');
Route::delete('/checkout/{id}', [CheckoutController::class, 'destroy'])->name('checkout.destroy');
// Route admin
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Tampilkan daftar user
    Route::get('/checkouts', [CheckoutController::class, 'adminUsers'])->name('admin.checkouts.users');
    // Tampilkan checkout milik user tertentu
    Route::get('/admin/checkouts/user/{user}', [CheckoutController::class, 'adminUserCheckouts'])->name('admin.checkouts.user');
    Route::get('/checkouts/user/{user}', [CheckoutController::class, 'adminUserCheckouts'])->name('checkouts.user');
    Route::post('/checkouts/{checkout}/accept', [CheckoutController::class, 'accept'])->name('admin.checkouts.accept');
    Route::post('/checkouts/{checkout}/reject', [CheckoutController::class, 'reject'])->name('admin.checkouts.reject');
});
Route::get('/admin/sales/export-pdf', [DashboardController::class, 'exportPdf'])->name('admin.sales.export.pdf');
// Review
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/settings', function () {
    return view('admin.settings.setting');
});
Route::get('/reviews', function () {
    return redirect()->back();
});

