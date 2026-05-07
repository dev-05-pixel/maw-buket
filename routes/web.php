<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\AIRecommendationController;
use App\Http\Controllers\TestimonialController;

// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/ai-recommendation', function () {
    return view('ai.recommendation');
})->name('ai.index');

Route::post('/ai-recommendation/process', [AIRecommendationController::class, 'process'])
    ->name('ai.process');

Route::post('/testimonials', [TestimonialController::class, 'store'])
    ->name('testimonials.store');

Route::get('/testimonials', [TestimonialController::class, 'index'])
    ->name('testimonials.index');

// Admin auth
Route::prefix('admin')->name('filament.admin.auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password-request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password-request.post');
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('reset-password.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin panel
Route::prefix('admin')
    ->middleware(['admin.auth'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class);

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
