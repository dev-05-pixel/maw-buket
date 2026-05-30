<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {

            $notifications = Notification::latest()
                ->take(10)
                ->get();

            $unreadNotifications = Notification::where(
                'is_read',
                false
            )->count();

            $view->with([
                'notifications' => $notifications,
                'unreadNotifications' => $unreadNotifications,
            ]);
        });
    }
}
