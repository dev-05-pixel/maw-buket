@extends('admin.layouts.app')

@section('title', 'Detail Transaksi')
@section('header', 'Detail Transaksi')
@section('subheader', 'Informasi lengkap pesanan customer')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-brown">
                        Detail Pesanan
                    </h2>

                    <p class="text-sm text-muted mt-1">
                        ID: {{ $order->id }}
                    </p>
                </div>

                <span
                    class="px-3 py-1 rounded-full text-xs font-medium
                @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                @elseif($order->status === 'confirmed')
                    bg-blue-100 text-blue-700
                @elseif($order->status === 'completed')
                    bg-green-100 text-green-700
                @else
                    bg-red-100 text-red-700 @endif
            ">
                    {{ ucfirst($order->status) }}
                </span>

            </div>

            {{-- Content --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Produk
                    </p>

                    <p class="text-sm font-medium text-brown">
                        {{ $order->product_name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Harga
                    </p>

                    <p class="text-sm font-medium text-brown">
                        Rp {{ number_format($order->product_price, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Ukuran
                    </p>

                    <p class="text-sm font-medium text-brown">
                        {{ $order->size ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Warna
                    </p>

                    <p class="text-sm font-medium text-brown">
                        {{ $order->color ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Nomor WhatsApp
                    </p>

                    <p class="text-sm font-medium text-brown">
                        {{ $order->customer_phone ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-muted mb-1">
                        Dibuat
                    </p>

                    <p class="text-sm font-medium text-brown">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="px-6 pb-6">

                <div class="border border-cream-d rounded-2xl p-5">

                    <h3 class="text-sm font-semibold text-brown mb-4">
                        Ubah Status
                    </h3>

                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                        class="flex flex-col md:flex-row gap-3">

                        @csrf
                        @method('PATCH')

                        <select name="status" class="flex-1 px-4 py-3 rounded-xl border border-cream-d bg-white text-sm">

                            <option value="pending" @selected($order->status === 'pending')>
                                Pending
                            </option>

                            <option value="confirmed" @selected($order->status === 'confirmed')>
                                Confirmed
                            </option>

                            <option value="completed" @selected($order->status === 'completed')>
                                Completed
                            </option>

                            <option value="cancelled" @selected($order->status === 'cancelled')>
                                Cancelled
                            </option>

                        </select>

                        <button type="submit"
                            class="px-5 py-3 rounded-xl bg-rose text-white text-sm hover:bg-rose-d transition">

                            Simpan Status

                        </button>
                    </form>
                </div>
            </div>

            {{-- Update WhatsApp --}}
            <div class="px-6 pb-6">

                <div class="border border-cream-d rounded-2xl p-5">

                    <h3 class="text-sm font-semibold text-brown mb-4">
                        Ubah Nomor WhatsApp
                    </h3>

                    <form action="{{ route('admin.orders.update-phone', $order->id) }}" method="POST"
                        class="flex flex-col md:flex-row gap-3">

                        @csrf
                        @method('PATCH')

                        <input type="text" name="customer_phone" value="{{ $order->customer_phone }}"
                            placeholder="08xxxxxxxxxx" class="flex-1 px-4 py-3 rounded-xl border border-cream-d text-sm">

                        <button type="submit"
                            class="px-5 py-3 rounded-xl bg-rose text-white text-sm hover:bg-rose-d transition">

                            Simpan Nomor

                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-cream-d flex items-center justify-between flex-wrap gap-3">

                <div class="flex items-center gap-3">

                    <a href="/admin/orders"
                        class="px-4 py-2 rounded-xl border border-cream-d text-sm text-brown hover:bg-cream transition">
                        ← Kembali
                    </a>
                </div>

                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Hapus transaksi ini?')"
                        class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm hover:bg-red-600 transition">
                        Hapus Transaksi
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
