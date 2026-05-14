<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()
            ->take(3)
            ->get();

        $categoryCounts = Product::select(
            'category',
            DB::raw('count(*) as total')
        )
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $testimonials = Testimonial::latest()
            ->take(3)
            ->get();

        $completedOrders = Order::where(
            'status',
            'completed'
        )->count();

        $averageRating = round(
            Testimonial::avg('rating') ?? 0,
            1
        );

        $formattedCompletedOrders = $this->formatNumber(
            $completedOrders
        );

        return view('home', compact(
            'featuredProducts',
            'categoryCounts',
            'testimonials',
            'completedOrders',
            'averageRating',
            'formattedCompletedOrders'
        ));
    }

    private function formatNumber($number)
    {
        if ($number >= 1000000000000) {
            return round($number / 1000000000000, 1) . 'T';
        }

        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'M';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'JT';
        }

        if ($number >= 1000) {
            return round($number / 1000, 1) . 'RB';
        }

        return (string) $number;
    }
}
