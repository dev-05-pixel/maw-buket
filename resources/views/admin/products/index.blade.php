@extends('admin.layouts.app')

@section('title', 'Produk')
@section('header', 'Manajemen Produk')
@section('subheader', 'Kelola katalog buket Anda')

@section('content')

    <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">

        <div class="px-6 py-4 border-b border-cream-d flex flex-col sm:flex-row sm:items-center gap-3">
            <h2 class="text-sm font-semibold text-brown flex-1">Daftar Produk</h2>
            <div class="flex items-center gap-3">
                <form method="GET">
                    <select name="per_page" onchange="this.form.submit()"
                        class="border border-cream-d rounded-lg px-3 py-1.5 text-xs text-brown bg-white focus:outline-none focus:ring-2 focus:ring-rose/30">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 / hal</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
                    </select>
                </form>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center gap-2 bg-brown text-white text-xs px-4 py-2 rounded-lg hover:opacity-90 transition">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Produk
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-cream-d bg-cream/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide hidden sm:table-cell">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-d">
                    @foreach ($products as $product)
                        <tr class="hover:bg-cream/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-12 h-12 rounded-xl object-cover border border-cream-d flex-shrink-0">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-xl bg-cream-d flex-shrink-0 flex items-center justify-center">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="#9E8E84" stroke-width="1.5" stroke-linecap="round">
                                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                                <circle cx="8.5" cy="8.5" r="1.5" />
                                                <polyline points="21 15 16 10 5 21" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-brown">{{ $product->name }}</p>
                                        <p class="text-xs text-muted sm:hidden">{{ $product->category }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span
                                    class="bg-sand/15 text-brown-m text-xs px-2.5 py-1 rounded-full">{{ $product->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-brown">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-xs font-medium text-brown-m hover:text-rose transition-colors">Edit</a>
                                    <button type="button"
                                        onclick="openDeleteModal({
                                        action: '/admin/products/{{ $product->id }}',
                                        title: 'Hapus produk ini?',
                                        desc: '\'{{ addslashes($product->name) }}\' akan dihapus permanen beserta gambarnya.'
                                    })"
                                        class="text-xs text-muted hover:text-red-500 transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="px-6 py-4 border-t border-cream-d">
                {{ $products->links() }}
            </div>
        @endif

    </div>

@endsection
