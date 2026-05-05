<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AIRecommendationController extends Controller
{
    public function process(Request $request)
    {
        $products = Product::query();

        $products->where(function ($query) use ($request) {
            $query->where('price', '<=', $request->budget)
                ->orWhere('color', $request->color)
                ->orWhere('size', $request->size);
        });

        $filtered = $products->get()->filter(function ($p) use ($request) {

            $score = 0;

            if ($p->price <= $request->budget) $score++;
            if ($p->color == $request->color) $score++;
            if ($p->size == $request->size) $score++;

            return $score >= 2;
        });

        return view('ai.recommendation', [
            'products' => $filtered
        ]);
    }
}
