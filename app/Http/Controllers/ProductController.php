<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(8);
        $products->appends($request->query());

        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('product.detail', compact('product'));
    }

    public function checkout()
    {
        $cart = session('cart');

        if (!$cart) {
            return back()->with('error', 'Cart is empty.');
        }

        foreach ($cart as $id => $item) {

            $product = Product::find($id);

            if ($product->stock < $item['quantity']) {
                return back()->with('error', 'Stock not sufficient.');
            }

            $product->decrement('stock', $item['quantity']);
            $product->increment('sold_count', $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('home')
            ->with('success', 'Order successful!');
    }
}
