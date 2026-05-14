<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',

            'pickup_date' => [
                'nullable',
                'date',
                'required_if:status,completed',
                'after_or_equal:now',
            ],
        ]);

        $newStatus = $request->status;

        $sameStatus =
            $order->status === $newStatus;

        $samePickupDate =
            $order->pickup_date?->format('Y-m-d') === $request->pickup_date;

        if ($sameStatus && $samePickupDate) {
            return back()->with(
                'error',
                'Tidak ada perubahan data.'
            );
        }

        $order->update([
            'status' => $newStatus,

            'pickup_date' =>
            $newStatus === 'completed'
                ? $request->pickup_date
                : null,
        ]);

        return back()->with(
            'success',
            'Status transaksi berhasil diperbarui.'
        );
    }

    public function updatePhone(Request $request, Order $order)
    {
        $request->validate([
            'customer_phone' => 'required|string|max:20',
        ]);

        $order->update([
            'customer_phone' => $request->customer_phone,
        ]);

        return back()->with(
            'success',
            'Nomor WhatsApp berhasil diperbarui.'
        );
    }

    public function whatsappReply(Order $order)
    {
        if (!$order->customer_phone) {
            return back()->with(
                'error',
                'Nomor WhatsApp customer belum tersedia.'
            );
        }

        if ($order->status !== 'completed') {
            return back()->with(
                'error',
                'Pesanan belum selesai dan belum bisa dikirim.'
            );
        }

        $pickupDate = $order->pickup_date
            ? Carbon::parse($order->pickup_date)
            ->translatedFormat('d F Y')
            : '-';

        $greetings = [
            'Halo kak',
            'Hai kak',
            'Permisi kak',
        ];

        $openings = [
            'Pesanan bouquet kakak sudah selesai dan siap diambil.',
            'Pesanan kakak sudah kami selesaikan dan sudah bisa diambil.',
            'Bouquet yang kakak pesan sudah selesai diproses.',
            'Pesanan kakak sudah siap untuk diambil.',
        ];

        $closings = [
            'Silakan datang sesuai jadwal pengambilan yang sudah ditentukan.',
            'Kami tunggu kedatangannya untuk pengambilan pesanan.',
            'Terima kasih sudah mempercayakan pesanan di Maw Bouquet.',
            'Sampai jumpa saat pengambilan pesanan ya kak.',
        ];

        $message =
            $greetings[array_rand($greetings)] . "\n\n" .

            $openings[array_rand($openings)] . "\n\n" .

            "*DETAIL PESANAN*\n" .
            "• ID Order : {$order->id}\n" .
            "• Produk   : {$order->product_name}\n" .
            "• Harga    : Rp " .
            number_format($order->product_price, 0, ',', '.') . "\n" .
            "• Ukuran   : " . ($order->size ?: '-') . "\n" .
            "• Warna    : " . ($order->color ?: '-') . "\n\n" .

            "*TANGGAL PENGAMBILAN*\n" .
            "{$pickupDate}\n\n" .

            $closings[array_rand($closings)];

        $phone = trim($order->customer_phone);

        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if (str_starts_with($phone, '08')) {
            $phone = '62' . substr($phone, 1);
        }

        $phone = ltrim($phone, '+');

        $waUrl =
            'https://wa.me/' .
            $phone .
            '?text=' .
            urlencode($message);

        return redirect()->away($waUrl);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }
}
