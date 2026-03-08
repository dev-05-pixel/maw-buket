<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'Semua',
            'Buket Segar',
            'Buket Kering',
            'Pampas',
            'Mini Bouquet'
        ];

        $query = Product::query();

        // FILTER KATEGORI
        if ($request->filled('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        // SORTING
        switch ($request->sort) {

            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;

            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;

            default:
                // DEFAULT = TERBARU
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(9)->appends($request->query());

        // HITUNG PRODUK PER KATEGORI
        $categoryCounts = Product::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $totalProducts = Product::count();

        return view('products.index', compact(
            'products',
            'categories',
            'categoryCounts',
            'totalProducts'
        ));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        // AI Recommendation
        $recommendedProducts = $this->getRecommendedProducts($product);

        $cleanDescription = str_replace(
            ['<p><br></p>', '<span class="ql-cursor">﻿</span>'],
            '',
            $product->description
        );

        return view('products.show', compact(
            'product',
            'cleanDescription',
            'relatedProducts',
            'recommendedProducts'
        ));
    }

    private function getRecommendedProducts(Product $product)
    {
        $products = Product::where('id', '!=', $product->id)->get();

        $scoredProducts = $products->map(function ($item) use ($product) {

            $score = 0;

            if ($item->category == $product->category) {
                $score += 5;
            }

            $priceDiff = abs($item->price - $product->price);
            $score += max(0, 5 - ($priceDiff / 20000));

            similar_text(
                strtolower(strip_tags($product->description)),
                strtolower(strip_tags($item->description)),
                $percent
            );

            $score += $percent / 20;

            $item->score = $score;

            return $item;
        });

        return $scoredProducts
            ->sortByDesc('score')
            ->take(4);
    }
}
