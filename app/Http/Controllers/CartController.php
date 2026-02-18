<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock <= 0) {
            return back()->with('error', 'Stock not available.');
        }

        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;

        if ($currentQty >= $product->stock) {
            return back()->with('error', 'Stock limit reached.');
        }

        $cart[$id] = [
            "name" => $product->name,
            "price" => $product->price,
            "quantity" => $currentQty + 1,
            "image" => $product->image
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        return view('cart.index');
    }
}
