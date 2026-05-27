<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant' => 'nullable|string',
            'price' => 'required|integer',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        $orderId = 'MWB-' . strtoupper(Str::random(8));

        $order = Order::create([
            'id' => $orderId,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $request->price,
            'variant' => $request->variant,
            'color' => $request->color,
            'status' => 'pending',
        ]);

        $greetings = [
            'Halo kak',
            'Halo Maw Bouquet',
            'Permisi kak',
            'Hai kak',
        ];

        $openings = [
            'Saya tertarik dengan produk berikut.',
            'Saya ingin memesan bouquet berikut.',
            'Saya menemukan produk ini dan tertarik untuk order.',
            'Saya ingin bertanya untuk produk berikut.',
        ];

        $closings = [
            'Apakah produk ini masih tersedia?',
            'Bisa dibantu untuk proses pemesanannya?',
            'Apakah bisa dipesan hari ini?',
            'Mohon info ketersediaannya.',
            'Terima kasih.',
        ];

        $message =
            $greetings[array_rand($greetings)] . "\n\n" .

            $openings[array_rand($openings)] . "\n\n" .

            "*DETAIL PRODUK*\n" .
            "• Produk : {$order->product_name}\n" .
            "• Harga  : Rp " . number_format($order->product_price, 0, ',', '.') . "\n" .
            "• Varian : " . ($order->variant ?: '-') . "\n" .
            "• Warna  : " . ($order->color ?: '-') . "\n\n" .

            "*ID ORDER*\n" .
            "{$order->id}\n\n" .

            "*LINK PRODUK*\n" .
            route('products.show', $product->id) . "\n\n" .

            $closings[array_rand($closings)];

        $wa = 'https://wa.me/6282333000472?text=' . urlencode($message);

        return response()->json([
            'success' => true,
            'wa_url' => $wa,
        ]);
    }
}
