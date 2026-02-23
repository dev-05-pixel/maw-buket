<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;

// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Admin auth routes - gunakan nama route yang sesuai dengan yang diharapkan Filament
Route::prefix('admin')->name('filament.admin.auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password-request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password-request.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
