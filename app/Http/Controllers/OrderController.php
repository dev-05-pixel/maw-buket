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
            'product_id' => 'required|string|exists:products,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'id' => strtoupper(Str::random(12)),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'size' => $request->size,
            'color' => $request->color,
            'status' => 'pending',
        ]);

        $greetings = [
            'Halo kak 👋',
            'Halo Maw Bouquet 🌸',
            'Permisi kak 🙌',
            'Hai kak 😊',
        ];

        $openings = [
            'Saya tertarik dengan produk berikut.',
            'Saya ingin order bouquet ini.',
            'Saya menemukan produk ini dan tertarik.',
            'Saya mau tanya untuk produk berikut.',
            'Saya ingin memesan bouquet berikut 🌷',
        ];

        $closings = [
            'Apakah masih tersedia?',
            'Bisa dibantu untuk proses pemesanannya?',
            'Apakah bisa dipesan hari ini?',
            'Mohon info ketersediaannya ya kak 🙏',
            'Terima kasih sebelumnya 😊',
        ];

        $message =
            $greetings[array_rand($greetings)] . "\n\n" .

            $openings[array_rand($openings)] . "\n\n" .

            "📦 *Detail Produk*\n" .
            "• Produk : {$order->product_name}\n" .
            "• Harga  : Rp " . number_format($order->product_price, 0, ',', '.') . "\n" .
            "• Ukuran : " . ($order->size ?: '-') . "\n" .
            "• Warna  : " . ($order->color ?: '-') . "\n\n" .

            "🆔 *ID Order*\n" .
            "#{$order->id}\n\n" .

            "🔗 Link Produk\n" .
            route('products.show', $product->id) . "\n\n" .

            $closings[array_rand($closings)];

        $wa = 'https://wa.me/6282333000472?text=' . urlencode($message);

        return response()->json([
            'success' => true,
            'wa_url' => $wa,
        ]);
    }
}
