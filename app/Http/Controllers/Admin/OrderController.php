<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
        ]);

        $newStatus = $request->status;

        if (!$order->canChangeTo($newStatus)) {
            return back()->with('error', 'Perubahan status tidak valid.');
        }

        $order->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
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

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
