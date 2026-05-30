<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function open(Notification $notification)
    {
        if (!$notification->is_read) {

            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return match ($notification->type) {

            'order'
                => redirect()->route(
                    'admin.orders.show',
                    $notification->reference_id
                ),

            'product'
                => redirect()->route(
                    'admin.products.edit',
                    $notification->reference_id
                ),

            'message'
                => redirect()->route(
                    'admin.messages.show',
                    $notification->reference_id
                ),

            'testimonial'
                => redirect()->route(
                    'admin.testimonials.show',
                    $notification->reference_id
                ),

            default
                => redirect()->route('admin.dashboard'),
        };
    }
}
