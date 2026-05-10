@extends('admin.layouts.app')

@section('title', 'Pesanan')
@section('header', 'Pesanan')
@section('subheader', 'Kelola transaksi pelanggan')

@section('content')

    <div class="bg-white border border-cream-d rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-cream-d">
            <h2 class="text-lg font-semibold text-brown">
                Daftar Pesanan
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream">
                    <tr class="text-left text-muted">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cream-d">
                    @forelse($orders as $order)
                        <tr class="hover:bg-cream/50">
                            <td class="px-6 py-4 font-medium text-brown">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->customer_name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->product_name }}
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs bg-cream text-brown">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="px-3 py-2 rounded-xl text-xs bg-cream hover:bg-cream-d">
                                        Detail
                                    </a>
                                    <button
                                        onclick="openDeleteModal({
                                        action: '{{ route('admin.orders.destroy', $order->id) }}',
                                        title: 'Hapus pesanan?',
                                        desc: 'Data transaksi akan dihapus permanen.'
                                    })"
                                        class="px-3 py-2 rounded-xl text-xs bg-red-50
                                    text-red-500 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-muted">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-cream-d">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
