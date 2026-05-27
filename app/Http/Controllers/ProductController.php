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
                    ->orWhere('color', 'like', "%{$search}%");
            });
        }

        $selectedCategories = array_filter(
            (array) $request->category,
            fn($item) => $item !== 'Semua'
        );

        if (!empty($selectedCategories)) {
            $query->whereIn('category', $selectedCategories);
        }

        if ($request->filled('color')) {

            $selectedColors = (array) $request->color;

            $query->where(function ($q) use ($selectedColors) {

                foreach ($selectedColors as $color) {

                    $q->orWhereRaw(
                        "FIND_IN_SET(?, REPLACE(color, ', ', ','))",
                        [$color]
                    );
                }
            });
        }

        $products = $query->get()->map(function ($product) {

            $variants = is_string($product->variants)
                ? json_decode($product->variants, true)
                : ($product->variants ?? []);

            $prices = collect($variants)
                ->pluck('price')
                ->map(function ($price) {

                    $price = preg_replace('/[^0-9]/', '', (string) $price);

                    return (int) $price;
                })
                ->filter(fn($price) => $price > 0)
                ->values();

            $product->min_price = $prices->min() ?? 0;
            $product->max_price = $prices->max() ?? 0;

            return $product;
        });

        if ($request->filled('min_price')) {

            $products = $products->filter(function ($product) use ($request) {

                return $product->min_price >= (int) $request->min_price;
            });
        }

        if ($request->filled('max_price')) {

            $products = $products->filter(function ($product) use ($request) {

                return $product->max_price <= (int) $request->max_price;
            });
        }

        switch ($request->sort) {

            case 'price-asc':
                $products = $products->sortBy('min_price');
                break;

            case 'price-desc':
                $products = $products->sortByDesc('min_price');
                break;

            case 'name-asc':
                $products = $products->sortBy('name');
                break;

            default:
                $products = $products->sortByDesc('created_at');
                break;
        }

        $products = $products->values();

        $perPage = 12;

        $currentPage = request()->get('page', 1);

        $pagedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage($currentPage, $perPage),
            $products->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

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

        return view('products.index', [
            'products'       => $pagedProducts,
            'categories'     => $categories,
            'categoryCounts' => $categoryCounts,
            'totalProducts'  => $totalProducts,
            'colors'         => $colors
        ]);
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
