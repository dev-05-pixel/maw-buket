<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(3)->get();

        $categoryCounts = Product::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $testimonials = Testimonial::latest()->take(3)->get();

        return view('home', compact(
            'featuredProducts',
            'categoryCounts',
            'testimonials'
        ));
    }
}
