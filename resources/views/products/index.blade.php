@extends('layouts.app')

@section('title', 'Koleksi Buket')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endpush

@section('content')

    {{-- ================================================================
     PAGE HERO
================================================================ --}}
    <header class="page-hero" aria-label="Products page hero">
        <img src="{{ asset('assets/collection banner.svg') }}" alt="Collection of beautiful bouquets" class="page-hero-bg"
            loading="eager" fetchpriority="high" style="opacity: 1; object-fit: cover; object-position: center;" />
        <div class="page-hero-overlay" aria-hidden="true"
            style="background: linear-gradient(90deg, rgba(44,36,33,0.97) 0%, rgba(44,36,33,0.97) 38%, rgba(44,36,33,0.3) 58%, rgba(44,36,33,0.0) 100%);">
        </div>

        <div class="page-hero-content">
            <p class="page-hero-label"></p>
            <h1 class="page-hero-title">
                <span class="page-hero-title-inner">
                    <span class="page-hero-title-line">Koleksi</span>
                </span>
                <span class="page-hero-title-inner">
                    <span class="page-hero-title-line"><em>Maw</em> Bouquet</span>
                </span>
            </h1>
            <p class="page-hero-sub">
                Jelajahi rangkaian buket kami — dari yang segar mekar hingga yang dikeringkan dengan penuh perhatian. Setiap
                kreasi dibuat untuk mengungkapkan apa yang tak terucapkan.
            </p>
        </div>
    </header>

    {{-- ================================================================
     FILTER BAR
================================================================ --}}
    <form method="GET" action="{{ route('products.index') }}">
        @foreach ((array) request('category') as $category)
            <input type="hidden" name="category[]" value="{{ $category }}">
        @endforeach
        <div class="filter-bar" role="toolbar" aria-label="Filter produk">
            <div class="filter-tabs" role="tablist" aria-label="Kategori">
                @php
                    $activeCategory = request('category', 'Semua');
                @endphp

                @foreach ($categories as $cat)
                    <a href="{{ $cat == 'Semua'
                        ? route('products.index', request()->except('category'))
                        : route('products.index', array_merge(request()->query(), ['category' => $cat])) }}"
                        data-filter="{{ $cat }}" class="filter-tab {{ $activeCategory === $cat ? 'active' : '' }}"
                        role="tab" aria-selected="{{ $activeCategory === $cat ? 'true' : 'false' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <form method="GET" class="catalog-search">

                {{-- pertahankan category --}}
                @foreach ((array) request('category') as $category)
                    <input type="hidden" name="category[]" value="{{ $category }}">
                @endforeach

                {{-- pertahankan sorting --}}
                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <div class="catalog-search-wrap">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 21l-4.35-4.35" />
                        <circle cx="11" cy="11" r="6" />
                    </svg>
                    <input type="text" name="search" placeholder="Cari bouquet..." value="{{ request('search') }}">
                </div>
            </form>

            <div class="filter-right">
                <div class="sort-select-wrap" aria-label="Urutkan">
                    <span class="sort-label">Urut:</span>
                    <select name="sort" class="sort-select">
                        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>
                            Terbaru</option>
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </div>

                <div class="view-toggle" role="group" aria-label="Tampilan grid">
                    <button class="view-btn active" id="grid-view-btn" aria-label="Grid view" aria-pressed="true">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                    </button>
                    <button class="view-btn" id="list-view-btn" aria-label="List view" aria-pressed="false">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <line x1="8" y1="6" x2="21" y2="6" />
                            <line x1="8" y1="12" x2="21" y2="12" />
                            <line x1="8" y1="18" x2="21" y2="18" />
                            <line x1="3" y1="6" x2="3.01" y2="6" />
                            <line x1="3" y1="12" x2="3.01" y2="12" />
                            <line x1="3" y1="18" x2="3.01" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- ================================================================
     MAIN CONTENT: SIDEBAR + PRODUCTS
================================================================ --}}
    <form method="GET" action="{{ route('products.index') }}">
        <div class="products-main">

            {{-- SIDEBAR --}}
            <aside class="sidebar" id="sidebar" aria-label="Filter panel">

                <div class="sidebar-section reveal">
                    <p class="sidebar-title">Kategori</p>

                    <div class="checkbox-group">
                        @foreach ($categories as $cat)
                            <label class="checkbox-label">

                                <input type="checkbox" name="category[]" value="{{ $cat }}"
                                    {{ empty(request()->input('category')) || in_array($cat, (array) request()->input('category')) ? 'checked' : '' }}>

                                {{ $cat }}

                                <span class="checkbox-count">
                                    @if ($cat == 'Semua')
                                        {{ $totalProducts }}
                                    @else
                                        {{ $categoryCounts[$cat] ?? 0 }}
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-section reveal delay-1">
                    <p class="sidebar-title">Harga</p>
                    <div class="price-inputs">
                        <div class="price-input-wrap">
                            <span class="price-input-prefix">Rp</span>
                            <input id="priceMin" type="number" name="min_price" value="{{ request('min_price') }}"
                                class="price-input" placeholder="Min" step="1000" min="0">
                        </div>

                        <div class="price-input-wrap">
                            <span class="price-input-prefix">Rp</span>
                            <input id="priceMax" type="number" name="max_price" value="{{ request('max_price') }}"
                                class="price-input" placeholder="Max" step="1000" min="0">
                        </div>
                    </div>
                </div>

                <div class="sidebar-section reveal delay-2">
                    <p class="sidebar-title">Warna Dominan</p>
                    <div class="color-tags">
                        @php
                            $visibleColors = $colors->take(12);
                            $hiddenColors = $colors->slice(12);
                        @endphp

                        @foreach ($visibleColors as $color)
                            <label class="color-tag">
                                <input type="checkbox" name="color[]" value="{{ $color['name'] }}" hidden
                                    {{ in_array($color['name'], (array) request('color')) ? 'checked' : '' }}>
                                <span class="color-tag-text">
                                    {{ $color['name'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    {{-- DROPDOWN WARNA TAMBAHAN --}}
                    @if ($hiddenColors->count())
                        <details class="colors-dropdown">
                            <summary>Warna lainnya</summary>
                            <div class="colors-dropdown-list">
                                @foreach ($hiddenColors as $color)
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="color[]" value="{{ $color['name'] }}"
                                            {{ in_array($color['name'], (array) request('color')) ? 'checked' : '' }}>
                                        <span class="inline-block w-3 h-3 rounded-full mr-2"
                                            style="
                                background: {{ $color['hex'] }};
                                {{ strtolower($color['hex']) == '#ffffff' ? 'border:1px solid #ddd' : '' }}
                            "></span>
                                        {{ $color['name'] }}
                                    </label>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>

                <div class="sidebar-section reveal delay-3">
                    <p class="sidebar-title">Ukuran</p>
                    <div class="checkbox-group">
                        @foreach (['Mini (S)', 'Standar (M)', 'Besar (L)', 'Grand (XL)'] as $size)
                            <label class="checkbox-label">
                                <input type="checkbox" name="size[]" value="{{ $size }}"
                                    {{ in_array($size, (array) request('size')) ? 'checked' : '' }}>
                                {{ $size }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-actions">
                    <button type="submit" class="apply-filter-btn">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('products.index') }}" class="reset-filter-btn">
                        Reset
                    </a>
                </div>
            </aside>

            {{-- PRODUCTS LISTING --}}
            <div class="products-area">

                <div class="products-result-info reveal">
                    <p class="result-count">
                        Menampilkan <strong>{{ $products->total() }} produk</strong>
                    </p>
                    <div class="active-filters" id="active-filters" aria-label="Filter aktif">

                        @if (request()->filled('category'))
                            @foreach ((array) request('category') as $category)
                                @if ($category !== 'Semua')
                                    <span class="filter-chip">
                                        {{ $category }}
                                        <a href="{{ route('products.index') }}" class="filter-chip-remove">
                                            ×
                                        </a>
                                    </span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="products-listing" id="products-listing" role="list">
                    @if ($products->count())
                        @foreach ($products as $i => $product)
                            <article class="product-card reveal delay-{{ min(($i % 3) + 1, 6) }}" role="listitem">
                                <div class="product-card-img-wrap">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="product-card-img" loading="lazy" />
                                    </a>

                                    <div class="product-card-quick">
                                        <a href="#" class="product-quick-btn wa-order"
    data-id="{{ $product->id }}"
    data-name="{{ $product->name }}"
    data-price="{{ $product->price }}"
    data-url="{{ route('products.show', $product->id) }}"
    data-store-url="{{ route('orders.store') }}">
                                            Pesan via WhatsApp
                                        </a>
                                    </div>
                                </div>

                                <div class="product-card-meta">
                                    <p class="product-card-category">
                                        {{ $product->category }}
                                    </p>
                                    <h2 class="product-card-name">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h2>
                                    <p class="product-card-price">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    @else
                        @php
                            $isSearching =
                                request()->filled('search') ||
                                request()->filled('category') ||
                                request()->filled('sort');
                        @endphp

                        <div class="empty-products-state reveal">
                            <div class="empty-products-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <path d="M9 10h4"></path>
                                    <path d="M9 14h2"></path>
                                </svg>
                            </div>

                            @if ($isSearching)
                                <h3 class="empty-products-title">
                                    Produk tidak ditemukan
                                </h3>
                                <p class="empty-products-text">
                                    Maaf, kami belum menemukan bouquet yang sesuai
                                    dengan pencarian atau filter yang kamu pilih.
                                </p>
                            @else
                                <h3 class="empty-products-title">
                                    Belum ada produk tersedia
                                </h3>
                                <p class="empty-products-text">
                                    Saat ini produk bouquet belum ditambahkan ke database.
                                    Silakan kembali lagi nanti.
                                </p>
                            @endif

                            @if ($isSearching)
                                <a href="{{ route('products.index') }}" class="empty-products-btn">
                                    Lihat Semua Produk
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- PAGINATION --}}
                @if ($products->hasPages())
                    <nav class="pagination-wrap reveal" aria-label="Navigasi halaman">

                        {{-- Previous --}}
                        @if ($products->onFirstPage())
                            <button class="page-btn prev-next" disabled>
                                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg>
                                Prev
                            </button>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="page-btn prev-next">
                                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg>
                                Prev
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if ($page == $products->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="page-btn prev-next">
                                Next
                                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </a>
                        @else
                            <button class="page-btn prev-next" disabled>
                                Next
                                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </button>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/products/index.js') }}"></script>
@endpush
