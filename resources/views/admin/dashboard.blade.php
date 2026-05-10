@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Selamat datang kembali')

@section('content')

    @php
        $totalProducts = \App\Models\Product::count();
        $totalMessages = \App\Models\ContactMessage::count();
        $totalTestimonials = \App\Models\Testimonial::count();
        $totalOrders = \App\Models\Order::count();

        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();

        $latestMessages = \App\Models\ContactMessage::latest()->take(5)->get();
        $latestProducts = \App\Models\Product::latest()->take(5)->get();
        $latestTestimonials = \App\Models\Testimonial::latest()->take(5)->get();
        $latestOrders = \App\Models\Order::latest()->take(5)->get();
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-sand/15 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C9AA86" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" />
                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-muted uppercase tracking-wide">
                    Total Produk
                </p>

                <p class="text-3xl font-semibold text-brown mt-1">
                    {{ $totalProducts }}
                </p>
            </div>
        </div>

        {{-- Total Pesan --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-rose/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D4847A" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-muted uppercase tracking-wide">
                    Total Pesan
                </p>

                <p class="text-3xl font-semibold text-brown mt-1">
                    {{ $totalMessages }}
                </p>
            </div>
        </div>

        {{-- Total Testimonial --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D6A843" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M12 17.75L5.827 21l1.179-6.873L2 9.24l6.913-1.004L12 2l3.087 6.236L22 9.24l-5.006 4.887L18.173 21z" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-muted uppercase tracking-wide">
                    Testimonial
                </p>

                <p class="text-3xl font-semibold text-brown mt-1">
                    {{ $totalTestimonials }}
                </p>
            </div>
        </div>

        {{-- Total Order --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-sky-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4B9CE2" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-muted uppercase tracking-wide">
                    Total Order
                </p>

                <p class="text-3xl font-semibold text-brown mt-1">
                    {{ $totalOrders }}
                </p>
            </div>
        </div>

        {{-- Belum Dibaca --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-sage/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#7A9B7A" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-muted uppercase tracking-wide">
                    Belum Dibaca
                </p>

                <p class="text-3xl font-semibold text-brown mt-1">
                    {{ $unreadMessages }}
                </p>
            </div>
        </div>

    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Pesan Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">
                    Pesan Terbaru
                </h3>

                <a href="/admin/messages" class="text-xs text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">
                @forelse($latestMessages as $msg)
                    <a href="/admin/messages/{{ $msg->id }}"
                        class="flex items-start gap-4 px-6 py-4 hover:bg-cream transition-colors">

                        <div class="w-10 h-10 rounded-full bg-rose-l/40 flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B85C52"
                                stroke-width="2">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-brown truncate">
                                {{ $msg->name }}
                            </p>

                            <p class="text-xs text-muted truncate mt-1">
                                {{ Str::limit($msg->message, 45) }}
                            </p>
                        </div>

                        <p class="text-[10px] text-muted">
                            {{ $msg->created_at->diffForHumans() }}
                        </p>
                    </a>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada pesan
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">
                    Produk Terbaru
                </h3>
                <a href="/admin/products" class="text-xs text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">
                @forelse($latestProducts as $product)
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-cream transition-colors">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-11 h-11 rounded-xl object-cover border border-cream-d">
                        @else
                            <div class="w-11 h-11 rounded-xl bg-cream-d"></div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-brown truncate">
                                {{ $product->name }}
                            </p>

                            <p class="text-xs text-muted mt-1">
                                {{ $product->category }}
                            </p>
                        </div>

                        <p class="text-sm font-semibold text-brown">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada produk
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Order Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">
                    Order Terbaru
                </h3>

                <a href="/admin/orders" class="text-xs text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">
                @forelse($latestOrders as $order)
                    <div class="px-6 py-4 hover:bg-cream transition-colors">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-brown">
                                {{ $order->customer_name }}
                            </p>
                            <p class="text-xs text-muted">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <p class="text-xs text-muted mt-1">
                            {{ $order->product_name }}
                        </p>
                    </div>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada order
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Testimonial Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">
                    Testimonial Terbaru
                </h3>

                <a href="/admin/testimonials" class="text-xs text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">
                @forelse($latestTestimonials as $testimonial)
                    <div class="px-6 py-4 hover:bg-cream transition-colors">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-brown">
                                {{ $testimonial->name }}
                            </p>
                            <p class="text-xs text-muted">
                                {{ $testimonial->rating }}/5
                            </p>
                        </div>

                        <p class="text-xs text-muted mt-1 line-clamp-2">
                            {{ Str::limit($testimonial->message, 60) }}
                        </p>
                    </div>
                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada testimonial
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
