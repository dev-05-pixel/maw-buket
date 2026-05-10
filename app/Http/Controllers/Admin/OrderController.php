<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $orders = Order::when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
