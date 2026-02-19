<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = (int) $request->quantity;

        // Ambil cart dari session
        $cart = session()->get('cart', []);

        $currentQty = $cart[$product->uid]['quantity'] ?? 0;
        $newQty = $currentQty + $quantity;

        // Cek stok
        if ($newQty > $product->stock) {
            return back()->with('error', 'Stock not sufficient.');
        }

        $cart[$product->uid] = [
            "uid"      => $product->uid,
            "slug"     => $product->slug,
            "name"     => $product->name,
            "price"    => $product->price,
            "quantity" => $newQty,
            "image"    => $product->image
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->uid])) {
            return back()->with('error', 'Product not found in cart.');
        }

        $quantity = (int) $request->quantity;

        if ($quantity > $product->stock) {
            return back()->with('error', 'Stock not sufficient.');
        }

        $cart[$product->uid]['quantity'] = $quantity;

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->uid])) {
            unset($cart[$product->uid]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }
}
