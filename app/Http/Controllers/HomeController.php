<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(3)->get();
        return view('home', compact('featuredProducts'));
    }
}
