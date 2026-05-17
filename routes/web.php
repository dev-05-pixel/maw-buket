<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AIRecommendationController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\FaqController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::get('/ai-recommendation', function () {
    return view('ai.recommendation');
})->name('ai.index');

Route::post('/ai-recommendation/process', [AIRecommendationController::class, 'process'])
    ->name('ai.process');

Route::get('/testimonials', [TestimonialController::class, 'index'])
    ->name('testimonials.index');

Route::post('/testimonials', [TestimonialController::class, 'store'])
    ->name('testimonials.store');

Route::post('/orders/store', [OrderController::class, 'store'])
    ->name('orders.store');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('filament.admin.auth.')
    ->group(function () {

        Route::get('/login', [AuthController::class, 'showLoginForm'])
            ->name('login');
        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.post');
        Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
            ->name('password-request');
        Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
            ->name('password-request.post');
        Route::get('/reset-password', [AuthController::class, 'showResetForm'])
            ->name('reset-password');
        Route::post('/reset-password', [AuthController::class, 'updatePassword'])
            ->name('reset-password.post');
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['admin.auth'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | PRODUCTS
        */
        Route::resource('products', AdminProductController::class);

        /*
        | CONTACT MESSAGES
        */
        Route::get('/messages', [MessageController::class, 'index'])
            ->name('messages.index');
        Route::get('/messages/{message}', [MessageController::class, 'show'])
            ->name('messages.show');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])
            ->name('messages.destroy');

        /*
        | TESTIMONIALS
        */
        Route::get('/testimonials', [AdminTestimonialController::class, 'index'])
            ->name('testimonials.index');
        Route::patch('/testimonials/{testimonial}/toggle', [AdminTestimonialController::class, 'toggle'])
            ->name('testimonials.toggle');
        Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])
            ->name('testimonials.destroy');

        /*
        | ORDERS
        */
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch(
            '/orders/{order}/status',
            [AdminOrderController::class, 'updateStatus']
        )->name('orders.update-status');

        Route::patch(
            '/orders/{order}/phone',
            [AdminOrderController::class, 'updatePhone']
        )->name('orders.update-phone');

        Route::delete(
            '/orders/{order}',
            [AdminOrderController::class, 'destroy']
        )->name('orders.destroy');

        Route::get(
            '/orders/{order}/whatsapp',
            [AdminOrderController::class, 'whatsappReply']
        )->name('orders.whatsapp');

           /*
        | FAQ
        */
        Route::resource('faqs', FaqController::class);

        /*
        | AI CHATBOT
        */
        Route::post('/ai-chat', [\App\Http\Controllers\Admin\AiChatController::class, 'chat'])
            ->name('ai.chat');
    });

