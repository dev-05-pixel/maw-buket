@extends('layouts.app')

@section('title', $product->name ?? 'Detail Produk')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/show.css') }}">
@endpush

@section('content')

    {{-- ================================================================
     BREADCRUMB
================================================================ --}}
    <div class="detail-breadcrumb">
        <nav class="detail-breadcrumb-inner" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="detail-breadcrumb-sep" aria-hidden="true">/</span>
            <a href="{{ url('/products') }}">Koleksi</a>
            <span class="detail-breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">{{ $product->name ?? 'Blushing Garden' }}</span>
        </nav>
    </div>

    {{-- ================================================================
     PRODUCT DETAIL
================================================================ --}}
    <div class="product-detail">

        {{-- GALLERY --}}
        <div class="gallery-side reveal-left">
            <div class="gallery-thumbs" id="gallery-thumbs" role="list" aria-label="Thumbnail gambar">
                @php
                    $images = [$product->image];
                @endphp
                @foreach ($images as $i => $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="Tampilan buket {{ $i + 1 }}"
                        class="gallery-thumb {{ $i === 0 ? 'active' : '' }}" data-full="{{ asset('storage/' . $img) }}"
                        data-index="{{ $i }}" role="listitem" loading="lazy" />
                @endforeach
            </div>

            <div class="gallery-main-wrap">

                <img id="gallery-main" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="gallery-main-img" loading="eager">

                <div class="gallery-nav-btns" id="gallery-dots" aria-hidden="true">
                    @foreach ($images as $i => $img)
                        <button class="gallery-nav-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"
                            aria-label="Gambar {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="info-side reveal-right">

            @php
                $variants = is_string($product->variants)
                    ? json_decode($product->variants, true)
                    : $product->variants ?? [];

                $prices = collect($variants)
                    ->pluck('price')
                    ->map(function ($price) {
                        return (int) preg_replace('/[^0-9]/', '', $price);
                    })
                    ->filter(fn($price) => $price > 0);

                $minPrice = $prices->min();
                $defaultVariant = $variants[0] ?? null;
            @endphp

            <p class="product-category-tag">
                {{ $product->category ?? 'Buket Segar' }}
            </p>

            <h1 class="product-name">
                {{ $product->name ?? 'Blushing Garden' }}
            </h1>

            <div class="product-price-block">
                <div>
                    <span class="product-price" id="product-price">
                        @if ($minPrice)
                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                        @else
                            Harga belum tersedia
                        @endif
                    </span>
                </div>

                <p class="product-price-note">
                    Harga belum termasuk ongkos kirim.
                    Pengiriman same-day tersedia.
                </p>
            </div>

            @if ($product->description)
                @php
                    $cleanDescription = $product->description;
                    $plain = trim(strip_tags($cleanDescription));
                    $showToggle = strlen($plain) > 200;
                @endphp

                <div class="product-desc {{ $showToggle ? 'collapsed' : '' }}" id="product-desc">
                    {!! $cleanDescription !!}
                </div>

                @if ($showToggle)
                    <div class="desc-fade"></div>
                    <button id="desc-toggle" class="desc-toggle">
                        Lihat Selengkapnya
                    </button>
                @endif
            @else
                <p class="product-desc" style="color:#9ca3af;">
                    Tidak ada deskripsi produk.
                </p>
            @endif

            {{-- SIZE OPTIONS --}}
            @if (!empty($variants))
                <div class="option-group">

                    <p class="option-label">
                        Varian —
                        <span id="selected-size">
                            {{ $defaultVariant['name'] ?? 'Default' }}
                        </span>
                    </p>

                    <div class="size-options" role="group" aria-label="Pilihan varian">

                        @foreach ($variants as $i => $variant)
                            @php
                                $variantSize = $variant['name'] ?? 'Default';

                                $variantPrice = isset($variant['price'])
                                    ? (int) preg_replace('/[^0-9]/', '', $variant['price'])
                                    : 0;
                            @endphp

                            <button type="button" class="size-btn {{ $i === 0 ? 'active' : '' }}"
                                aria-pressed="{{ $i === 0 ? 'true' : 'false' }}" data-variant="{{ $variantSize }}"
                                data-price="{{ $variantPrice }}">
                                {{ $variantSize }}
                            </button>
                        @endforeach

                    </div>
                </div>
            @endif

            {{-- COLOR OPTIONS --}}
            @if ($product->color)
                @php
                    $colors = array_map('trim', explode(',', $product->color));
                @endphp

                <div class="option-group">

                    <p class="option-label">
                        Warna Dominan —
                        <span id="selected-color">
                            {{ $colors[0] }}
                        </span>
                    </p>

                    <div class="color-tags">

                        @foreach ($colors as $i => $color)
                            <button type="button" class="color-tag-detail {{ $i === 0 ? 'active' : '' }}"
                                data-color="{{ $color }}">
                                {{ $color }}
                            </button>
                        @endforeach

                    </div>
                </div>
            @endif

            {{-- CTA --}}
            <div class="product-cta">

                <div class="product-cta-btns">

                    <a id="wa-order" href="#" class="nav-cta wa-order" data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" data-price="{{ $minPrice ?? 0 }}"
                        data-variant="{{ $defaultVariant['name'] ?? '' }}" data-color="{{ $colors[0] ?? '' }}"
                        data-url="{{ route('products.show', $product->id) }}"
                        data-store-url="{{ route('orders.store') }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                        </svg>

                        Pesan via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
     RELATED PRODUCTS
================================================================ --}}
    <section class="related-section" aria-label="Produk terkait">
        @if ($relatedProducts->count())
            <section class="related-section" aria-label="Produk terkait">
                <div class="related-header reveal">
                    <div>
                        <span class="section-label">
                            Mungkin Kamu Suka
                        </span>

                        <h2 class="related-title">
                            Koleksi <em>Serupa</em>
                        </h2>
                    </div>

                    <a href="{{ url('/products') }}" class="btn-outline">
                        Lihat Semua

                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="related-grid">
                    @foreach ($relatedProducts as $item)
                        <a href="{{ route('products.show', $item->id) }}" class="product-card">

                            <div class="product-card-img-wrap">
                                <img src="{{ asset('storage/' . $item->image) }}" class="product-card-img"
                                    alt="{{ $item->name }}">
                            </div>

                            <p class="product-card-category">
                                {{ $item->category }}
                            </p>

                            <h3 class="product-card-name">
                                {{ $item->name }}
                            </h3>

                            @php
                                $relatedVariants = is_string($item->variants)
                                    ? json_decode($item->variants, true)
                                    : $item->variants ?? [];

                                $relatedPrices = collect($relatedVariants)
                                    ->pluck('price')
                                    ->map(fn($p) => (int) preg_replace('/[^0-9]/', '', $p))
                                    ->filter(fn($p) => $p > 0);

                                $relatedMin = $relatedPrices->min();
                                $relatedMax = $relatedPrices->max();
                            @endphp

                            <p class="product-card-price">
                                @if ($relatedPrices->count())
                                    Rp {{ number_format($relatedMin, 0, ',', '.') }}

                                    @if ($relatedMin != $relatedMax)
                                        - {{ number_format($relatedMax, 0, ',', '.') }}
                                    @endif
                                @else
                                    Harga belum tersedia
                                @endif
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @else
            <section class="related-empty-state">
                <div class="related-empty-decoration decoration-1"></div>
                <div class="related-empty-decoration decoration-2"></div>
                <div class="related-empty-box">
                    <svg width="72" height="72" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M5 8.5C5 6.567 6.567 5 8.5 5H15.5C17.433 5 19 6.567 19 8.5V15.5C19 17.433 17.433 19 15.5 19H8.5C6.567 19 5 17.433 5 15.5V8.5Z"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />

                        <path d="M5 10C5 10 7.2 14 12 14C16.8 14 19 10 19 10" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" />

                    </svg>
                    <h2>
                        Belum Ada Koleksi Serupa
                    </h2>

                    <p>
                        Produk lain dengan kategori yang sama
                        belum tersedia saat ini.
                    </p>

                    <a href="{{ url('/products') }}" class="btn-outline">

                        Lihat Koleksi Lain

                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                            <path d="M5 12h14M12 5l7 7-7 7" />

                        </svg>
                    </a>
                </div>
            </section>
        @endif
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/products/show.js') }}"></script>
@endpush
