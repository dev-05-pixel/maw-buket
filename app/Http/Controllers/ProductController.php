<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhere('size', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {

            $selectedCategories = (array) $request->category;

            if (!in_array('Semua', $selectedCategories)) {
                $query->whereIn('category', $selectedCategories);
            }
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        if ($request->filled('size')) {

            $sizes = (array) $request->size;

            $query->where(function ($q) use ($sizes) {

                foreach ($sizes as $size) {
                    $q->orWhere('size', 'like', "%{$size}%");
                }
            });
        }

        if ($request->filled('color')) {

            $colors = (array) $request->color;

            $query->where(function ($q) use ($colors) {

                foreach ($colors as $color) {
                    $q->orWhere('color', 'like', "%{$color}%");
                }
            });
        }

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
                $query->latest();
                break;
        }

        $products = $query
            ->paginate(9)
            ->appends($request->query());

        $categoryCounts = Product::select(
            'category',
            DB::raw('count(*) as total')
        )
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $totalProducts = Product::count();

        $rawColors = Product::whereNotNull('color')
            ->pluck('color')
            ->toArray();

        $colors = collect($rawColors)
            ->flatMap(fn($item) => explode(',', $item))
            ->map(fn($item) => trim($item))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $colorMap = [
            'Pink'        => '#E8A0A0',
            'Dusty Pink'  => '#D8A7B1',
            'Blush Pink'  => '#F4C2C2',
            'Rose Pink'   => '#E7A1B0',
            'Peach'       => '#F5B38A',
            'Orange'      => '#F59E0B',
            'Yellow'      => '#FACC15',
            'Cream'       => '#F5DEB3',
            'White'       => '#FFFFFF',
            'Ivory'       => '#FFF8E7',
            'Purple'      => '#B799FF',
            'Lavender'    => '#D8B4FE',
            'Lilac'       => '#C8A2C8',
            'Blue'        => '#93C5FD',
            'Sage'        => '#A3B18A',
            'Green'       => '#86EFAC',
            'Red'         => '#EF4444',
            'Maroon'      => '#7F1D1D',
            'Brown'       => '#8B5E3C',
            'Black'       => '#2C2421',
            'Gold'        => '#D4AF37',
            'Silver'      => '#C0C0C0',
        ];

        $colors = $colors->map(fn($color) => [
            'name' => $color,
            'hex'  => $colorMap[$color] ?? '#D6CFC7',
        ]);

        $rawSizes = Product::whereNotNull('size')
            ->pluck('size')
            ->toArray();

        $sizes = collect($rawSizes)
            ->flatMap(fn($item) => explode(',', $item))
            ->map(fn($item) => trim($item))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('products.index', compact(
            'products',
            'categories',
            'categoryCounts',
            'totalProducts',
            'colors',
            'sizes'
        ));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        $cleanDescription = str_replace(
            [
                '<p><br></p>',
                '<span class="ql-cursor">﻿</span>'
            ],
            '',
            $product->description
        );

        $productColors = [];

        if ($product->color) {

            $productColors = collect(explode(',', $product->color))
                ->map(fn($color) => trim($color))
                ->filter()
                ->values();
        }

        $productSizes = [];

        if ($product->size) {

            $productSizes = collect(explode(',', $product->size))
                ->map(fn($size) => trim($size))
                ->filter()
                ->values();
        }

        return view('products.show', compact(
            'product',
            'cleanDescription',
            'relatedProducts',
            'productColors',
            'productSizes'
        ));
    }
}
