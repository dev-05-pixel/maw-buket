@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Selamat datang kembali')

@section('content')

    @php
        $totalProducts = \App\Models\Product::count();
        $totalMessages = \App\Models\ContactMessage::count();
        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
        $latestMessages = \App\Models\ContactMessage::latest()->take(5)->get();
        $latestProducts = \App\Models\Product::latest()->take(5)->get();
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

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
                <p class="text-xs text-muted font-medium tracking-wide uppercase">Total Produk</p>
                <p class="text-3xl font-semibold text-brown mt-0.5">{{ $totalProducts }}</p>
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
                <p class="text-xs text-muted font-medium tracking-wide uppercase">Total Pesan</p>
                <p class="text-3xl font-semibold text-brown mt-0.5">{{ $totalMessages }}</p>
            </div>
        </div>

        {{-- Pesan Belum Dibaca --}}
        <div class="bg-white rounded-2xl border border-cream-d p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-sage/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#7A9B7A" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-muted font-medium tracking-wide uppercase">Belum Dibaca</p>
                <p class="text-3xl font-semibold text-brown mt-0.5">{{ $unreadMessages }}</p>
            </div>
        </div>

    </div>

    {{-- Two col --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Pesan Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">Pesan Terbaru</h3>
                <a href="/admin/messages" class="text-xs text-rose hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-cream-d">
                @forelse($latestMessages as $msg)
                    <a href="/admin/messages/{{ $msg->id }}"
                        class="flex items-start gap-4 px-6 py-4 hover:bg-cream transition-colors group">
                        <div
                            class="w-9 h-9 rounded-full bg-rose-l/50 flex items-center justify-center flex-shrink-0 text-rose-d text-sm font-semibold">
                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-medium text-brown truncate">{{ $msg->name }}</p>
                                @if (!$msg->is_read)
                                    <span class="w-1.5 h-1.5 bg-rose rounded-full flex-shrink-0"></span>
                                @endif
                            </div>
                            <p class="text-xs text-muted truncate mt-0.5">{{ $msg->purpose }} —
                                {{ Str::limit($msg->message, 40) }}</p>
                        </div>
                        <p class="text-[10px] text-muted flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-muted">Belum ada pesan masuk</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">
            <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-sm font-semibold text-brown">Produk Terbaru</h3>
                <a href="/admin/products" class="text-xs text-rose hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-cream-d">
                @forelse($latestProducts as $product)
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-cream transition-colors">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-10 h-10 rounded-lg object-cover border border-cream-d flex-shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-cream-d flex-shrink-0"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-brown truncate">{{ $product->name }}</p>
                            <p class="text-xs text-muted">{{ $product->category }}</p>
                        </div>
                        <p class="text-sm font-medium text-brown flex-shrink-0">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-muted">Belum ada produk</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection
