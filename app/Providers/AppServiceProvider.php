<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Order;
use App\Models\Product;
use App\Models\ContactMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {

            $notifications = collect();

            /*
            |--------------------------------------------------------------------------
            | Pesanan terbaru
            |--------------------------------------------------------------------------
            */

            Order::latest()
                ->take(5)
                ->get()
                ->each(function ($order) use ($notifications) {

                    $notifications->push([
                        'type' => 'order',
                        'title' => 'Pesanan Baru',
                        'message' => $order->product_name,
                        'time' => $order->created_at,
                        'url' => '/admin/orders',
                    ]);
                });

            /*
            |--------------------------------------------------------------------------
            | Pesan kontak
            |--------------------------------------------------------------------------
            */

            ContactMessage::latest()
                ->take(5)
                ->get()
                ->each(function ($msg) use ($notifications) {

                    $notifications->push([
                        'type' => 'message',
                        'title' => 'Pesan Masuk',
                        'message' => $msg->name,
                        'time' => $msg->created_at,
                        'url' => '/admin/messages/' . $msg->id,
                    ]);
                });

            /*
            |--------------------------------------------------------------------------
            | Produk baru
            |--------------------------------------------------------------------------
            */

            Product::latest()
                ->take(5)
                ->get()
                ->each(function ($product) use ($notifications) {

                    $notifications->push([
                        'type' => 'product',
                        'title' => 'Produk Baru',
                        'message' => $product->name,
                        'time' => $product->created_at,
                        'url' => '/admin/products',
                    ]);
                });

            $notifications = $notifications
                ->sortByDesc('time')
                ->take(10)
                ->values();

            $view->with('notifications', $notifications);
        });
    }
}
