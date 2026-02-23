<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->take(6)->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('home', compact('products', 'settings'));
    }
}
