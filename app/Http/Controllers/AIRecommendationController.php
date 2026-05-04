<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AIRecommendationController extends Controller
{
    public function process(Request $request)
    {
        $products = Product::all();

        // contoh logika AI sederhana (rule-based / scoring)
        $filtered = $products->filter(function ($p) use ($request) {

            $score = 0;

            if ($p->price <= $request->budget) $score += 1;
            if ($p->color == $request->color) $score += 1;
            if ($p->flower == $request->flower) $score += 1;

            return $score >= 2; // threshold
        });

        return view('ai.result', [
            'products' => $filtered
        ]);
    }
}
