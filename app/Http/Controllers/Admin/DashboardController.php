<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Product;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->year ?? now()->year;

        /*
    |--------------------------------------------------------------------------
    | Statistik
    |--------------------------------------------------------------------------
    */

        $totalProducts = Product::count();

        $totalMessages = ContactMessage::count();

        $totalTestimonials = Testimonial::count();

        $totalOrders = Order::count();

        $unreadMessages = ContactMessage::where(
            'is_read',
            false
        )->count();

        $completedOrders = Order::where(
            'status',
            'completed'
        )->count();

        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();

        /*
    |--------------------------------------------------------------------------
    | Revenue
    |--------------------------------------------------------------------------
    */

        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {

            $monthlyRevenue[] = Order::where(
                'status',
                'completed'
            )
                ->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $month)
                ->sum('product_price');
        }

        $totalRevenue = array_sum($monthlyRevenue);

        $revenueLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];

        /*
    |--------------------------------------------------------------------------
    | Year Filter
    |--------------------------------------------------------------------------
    */

        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        /*
    |--------------------------------------------------------------------------
    | Product Category Chart
    |--------------------------------------------------------------------------
    */

        $categoryLabels = Product::select('category')
            ->groupBy('category')
            ->pluck('category');

        $categoryData = [];

        foreach ($categoryLabels as $category) {
            $categoryData[] = Product::where(
                'category',
                $category
            )->count();
        }

        /*
    |--------------------------------------------------------------------------
    | Order Status Chart
    |--------------------------------------------------------------------------
    */

        $statusLabels = [
            'Pending',
            'Confirmed',
            'Completed',
            'Cancelled'
        ];

        $statusData = [
            Order::where('status', 'pending')->count(),
            Order::where('status', 'confirmed')->count(),
            Order::where('status', 'completed')->count(),
            Order::where('status', 'cancelled')->count(),
        ];

        /*
    |--------------------------------------------------------------------------
    | Latest Data
    |--------------------------------------------------------------------------
    */

        $latestMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        $latestProducts = Product::latest()
            ->take(5)
            ->get();

        $latestTestimonials = Testimonial::latest()
            ->take(5)
            ->get();

        $latestOrders = Order::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'selectedYear',
            'availableYears',

            'totalProducts',
            'totalMessages',
            'totalTestimonials',
            'totalOrders',

            'unreadMessages',

            'completedOrders',
            'pendingOrders',
            'cancelledOrders',

            'totalRevenue',

            'monthlyRevenue',
            'revenueLabels',

            'categoryLabels',
            'categoryData',

            'statusLabels',
            'statusData',

            'latestMessages',
            'latestProducts',
            'latestTestimonials',
            'latestOrders'
        ));
    }
}
