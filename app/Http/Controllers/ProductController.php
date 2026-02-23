<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->paginate(12);
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('products.index', compact('products', 'settings'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('products.show', compact('product', 'settings'));
    }
}
