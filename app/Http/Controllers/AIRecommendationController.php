<?php

namespace App\Http\Controllers;

// use App\Models\Product;
// use Illuminate\Http\Request;
// use Illuminate\Pagination\LengthAwarePaginator;

class AIRecommendationController extends Controller
{
    // public function process(Request $request)
    // {
    //     $query = Product::query();

    //     $budget = (int) $request->budget;

    //     $categoryMap = [
    //         'buket_segar' => 'Buket Segar',
    //         'buket_kering' => 'Buket Kering',
    //         'pampas' => 'Pampas',
    //         'mini_bouquet' => 'Mini Bouquet',
    //     ];

    //     if (
    //         !$request->boolean('skip_budget') &&
    //         $request->filled('budget')
    //     ) {
    //         $query->where(
    //             'price',
    //             '<=',
    //             $budget
    //         );
    //     }

    //     if (
    //         !$request->boolean('skip_kategori') &&
    //         $request->filled('kategori')
    //     ) {
    //         $selectedCategory =
    //             $categoryMap[$request->kategori]
    //             ?? $request->kategori;

    //         $query->where(
    //             'category',
    //             $selectedCategory
    //         );
    //     }

    //     if (
    //         !$request->boolean('skip_warna') &&
    //         $request->filled('warna') &&
    //         $request->warna !== 'bebas'
    //     ) {
    //         if ($request->warna === 'mix') {

    //             $query->where(
    //                 'color',
    //                 'LIKE',
    //                 '%,%'
    //             );

    //         } else {

    //             $query->where(
    //                 'color',
    //                 'LIKE',
    //                 '%' . strtolower($request->warna) . '%'
    //             );
    //         }
    //     }

    //     if (
    //         !$request->boolean('skip_ukuran') &&
    //         $request->filled('ukuran') &&
    //         is_array($request->ukuran)
    //     ) {
    //         $selectedSizes = collect($request->ukuran)
    //             ->map(fn($size) => strtolower(trim($size)))
    //             ->toArray();

    //         $query->where(function ($q) use ($selectedSizes) {

    //             foreach ($selectedSizes as $size) {

    //                 $q->orWhere(
    //                     'size',
    //                     'LIKE',
    //                     '%' . $size . '%'
    //                 );
    //             }
    //         });
    //     }

    //     $products = $query
    //         ->get()
    //         ->map(function ($product) use (
    //             $request,
    //             $budget,
    //             $categoryMap
    //         ) {

    //             $score = 0;

    //             if (
    //                 !$request->boolean('skip_budget') &&
    //                 $request->filled('budget')
    //             ) {

    //                 $difference = abs(
    //                     $budget - (int) $product->price
    //                 );

    //                 $score += max(
    //                     0,
    //                     30 - floor($difference / 10000)
    //                 );
    //             }

    //             if (
    //                 !$request->boolean('skip_kategori') &&
    //                 $request->filled('kategori')
    //             ) {

    //                 $selectedCategory =
    //                     $categoryMap[$request->kategori]
    //                     ?? $request->kategori;

    //                 if (
    //                     strtolower(trim($product->category))
    //                     === strtolower(trim($selectedCategory))
    //                 ) {

    //                     $score += 30;
    //                 }
    //             }

    //             if (
    //                 !$request->boolean('skip_ukuran') &&
    //                 $request->filled('ukuran') &&
    //                 is_array($request->ukuran)
    //             ) {

    //                 $productSizes = collect(
    //                     explode(',', strtolower($product->size))
    //                 )
    //                     ->map(fn($size) => trim($size))
    //                     ->filter()
    //                     ->toArray();

    //                 $selectedSizes = collect($request->ukuran)
    //                     ->map(fn($size) => strtolower(trim($size)))
    //                     ->toArray();

    //                 if (
    //                     count(
    //                         array_intersect(
    //                             $productSizes,
    //                             $selectedSizes
    //                         )
    //                     ) > 0
    //                 ) {

    //                     $score += 20;
    //                 }
    //             }

    //             if (
    //                 !$request->boolean('skip_warna') &&
    //                 $request->filled('warna') &&
    //                 $request->warna !== 'bebas'
    //             ) {

    //                 $productColors = collect(
    //                     explode(',', strtolower($product->color))
    //                 )
    //                     ->map(fn($color) => trim($color))
    //                     ->filter()
    //                     ->toArray();

    //                 if (
    //                     $request->warna === 'mix' &&
    //                     count($productColors) > 1
    //                 ) {

    //                     $score += 20;

    //                 } elseif (
    //                     in_array(
    //                         strtolower($request->warna),
    //                         $productColors
    //                     )
    //                 ) {

    //                     $score += 20;
    //                 }
    //             }

    //             $product->fuzzy_score = $score;

    //             return $product;
    //         });

    //     $products = $products
    //         ->sortByDesc('fuzzy_score')
    //         ->values();

    //     $page = LengthAwarePaginator::resolveCurrentPage();

    //     $perPage = 10;

    //     $currentItems = $products
    //         ->slice(
    //             ($page - 1) * $perPage,
    //             $perPage
    //         )
    //         ->values();

    //     $products = new LengthAwarePaginator(
    //         $currentItems,
    //         $products->count(),
    //         $perPage,
    //         $page,
    //         [
    //             'path' => request()->url(),
    //             'query' => request()->query(),
    //         ]
    //     );

    //     return view('ai.recommendation', [
    //         'products' => $products
    //     ]);
    // }
}
