@extends('layouts.app')

@section('title', $product->name ?? 'Detail Produk')

@push('styles')
    <style>
        /* ================================================================
                           PRODUCT DETAIL / SHOW PAGE
                        ================================================================ */

        /* ----------------------------------------------------------------
                           BREADCRUMB STRIP
                        ---------------------------------------------------------------- */
        .product-cta .nav-cta {
            width: 89%;
            justify-content: center;
        }

        .detail-breadcrumb {
            padding: 20px clamp(24px, 6vw, 100px);
            background: var(--ivory);
            border-bottom: 1px solid rgba(44, 36, 33, 0.06);
        }

        .detail-breadcrumb-inner {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-breadcrumb-inner a,
        .detail-breadcrumb-inner span {
            font-size: 12px;
            font-weight: 400;
            color: var(--warm-grey);
            letter-spacing: 0.04em;
            transition: color 0.3s ease;
        }

        .detail-breadcrumb-inner a:hover {
            color: var(--charcoal);
        }

        .detail-breadcrumb-inner span:last-child {
            color: var(--charcoal);
        }

        .detail-breadcrumb-sep {
            font-size: 12px;
            color: rgba(44, 36, 33, 0.25);
        }

        /* ----------------------------------------------------------------
                           PRODUCT LAYOUT
                        ---------------------------------------------------------------- */
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 80vh;
        }

        /* ----------------------------------------------------------------
                           GALLERY SIDE
                        ---------------------------------------------------------------- */
        .gallery-side {
            position: sticky;
            top: var(--nav-height);
            height: calc(100vh - var(--nav-height));
            display: grid;
            grid-template-columns: 88px 1fr;
            gap: 12px;
            padding: clamp(20px, 3vw, 40px) 20px clamp(20px, 3vw, 40px) clamp(24px, 6vw, 100px);
            overflow: hidden;
        }

        .gallery-thumbs {
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
            scrollbar-width: none;
            align-items: center;
        }

        .gallery-thumbs::-webkit-scrollbar {
            display: none;
        }

        .gallery-thumb {
            width: 78px;
            height: 78px;
            object-fit: cover;
            border-radius: 2px;
            cursor: none;
            border: 2px solid transparent;
            transition: border-color 0.3s ease, opacity 0.3s ease;
            opacity: 0.6;
            flex-shrink: 0;
        }

        .gallery-thumb.active,
        .gallery-thumb:hover {
            border-color: var(--rose);
            opacity: 1;
        }

        .gallery-main-wrap {
            position: relative;
            border-radius: 2px;
            overflow: hidden;
            background: var(--cream-dark);
        }

        .gallery-main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease, transform 0.6s var(--ease-out-expo);
            display: block;
        }

        .gallery-main-img.switching {
            opacity: 0;
            transform: scale(1.03);
        }

        .gallery-zoom-hint {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(248, 243, 236, 0.85);
            backdrop-filter: blur(8px);
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            color: var(--charcoal);
            letter-spacing: 0.08em;
            display: flex;
            align-items: center;
            gap: 6px;
            pointer-events: none;
        }

        .gallery-zoom-hint svg {
            width: 13px;
            height: 13px;
            stroke: var(--charcoal);
            fill: none;
        }

        .gallery-badge-overlay {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--rose);
            color: var(--white);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 2px;
        }

        .gallery-nav-btns {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .gallery-nav-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: rgba(44, 36, 33, 0.25);
            border: none;
            cursor: none;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .gallery-nav-dot.active {
            background: var(--rose);
            transform: scale(1.3);
        }

        /* ----------------------------------------------------------------
                           INFO SIDE
                        ---------------------------------------------------------------- */
        .info-side {
            padding: clamp(30px, 4vw, 60px) clamp(24px, 6vw, 100px) clamp(30px, 4vw, 60px) 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
            max-height: calc(100vh - var(--nav-height));
            position: sticky;
            top: var(--nav-height);
        }

        .product-category-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 14px;
        }

        .product-category-tag::before {
            content: '';
            display: block;
            width: 24px;
            height: 1px;
            background: var(--rose);
        }

        .product-name {
            font-family: var(--font-display);
            font-size: clamp(36px, 4vw, 58px);
            font-weight: 300;
            line-height: 1.05;
            color: var(--charcoal);
            letter-spacing: -0.01em;
            margin-bottom: 20px;
        }

        .product-rating-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .rating-stars {
            display: flex;
            gap: 3px;
        }

        .rating-stars svg {
            width: 14px;
            height: 14px;
            fill: var(--terracotta);
        }

        .rating-score {
            font-size: 14px;
            font-weight: 500;
            color: var(--charcoal);
        }

        .rating-count {
            font-size: 13px;
            font-weight: 300;
            color: var(--warm-grey);
        }

        .rating-sep {
            width: 1px;
            height: 16px;
            background: rgba(44, 36, 33, 0.15);
        }

        .product-price-block {
            margin-bottom: 28px;
            padding-bottom: 28px;
            border-bottom: 1px solid rgba(44, 36, 33, 0.08);
        }

        .product-price {
            font-family: var(--font-display);
            font-size: clamp(32px, 3.5vw, 48px);
            font-weight: 300;
            color: var(--charcoal);
            line-height: 1;
            margin-bottom: 8px;
        }

        .product-price-old {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 300;
            color: var(--warm-grey);
            text-decoration: line-through;
            margin-left: 12px;
        }

        .product-price-note {
            font-size: 12px;
            color: var(--warm-grey);
            font-weight: 300;
        }

        /* Description */
        .product-desc {
            font-size: 15px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.9;
            margin-bottom: 28px;
        }

        /* Options */
        .option-group {
            margin-bottom: 24px;
        }

        .option-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .option-label span {
            font-size: 13px;
            font-weight: 300;
            text-transform: none;
            letter-spacing: 0;
            color: var(--warm-grey);
        }

        .size-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-btn {
            padding: 10px 20px;
            border: 1.5px solid rgba(44, 36, 33, 0.15);
            border-radius: 2px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 400;
            color: var(--charcoal-mid);
            background: transparent;
            cursor: none;
            transition: all 0.3s ease;
        }

        .size-btn:hover {
            border-color: var(--charcoal);
            color: var(--charcoal);
        }

        .size-btn.active {
            background: var(--charcoal);
            border-color: var(--charcoal);
            color: var(--cream);
        }

        .size-btn.disabled {
            opacity: 0.35;
            pointer-events: none;
            text-decoration: line-through;
        }

        .color-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .color-opt {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: none;
            transition: all 0.25s ease;
            position: relative;
        }

        .color-opt:hover,
        .color-opt.active {
            border-color: var(--charcoal);
            transform: scale(1.1);
        }

        /* CTA block */
        .product-cta {
            padding-top: 28px;
            border-top: 1px solid rgba(44, 36, 33, 0.08);
        }

        .product-cta-btns {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .cta-wa-btn {
            flex: 1;
            min-width: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--white);
            background: #25D366;
            padding: 16px 24px;
            border-radius: 2px;
            border: none;
            cursor: none;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .cta-wa-btn:hover {
            background: #1EBE5A;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.25);
        }

        .cta-wa-btn svg {
            width: 18px;
            height: 18px;
            fill: white;
        }

        .cta-share-btn {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid rgba(44, 36, 33, 0.15);
            border-radius: 2px;
            cursor: none;
            background: transparent;
            color: var(--charcoal);
            transition: border-color 0.3s ease, background 0.3s ease;
            flex-shrink: 0;
        }

        .cta-share-btn:hover {
            border-color: var(--charcoal);
            background: var(--cream-dark);
        }

        .cta-share-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        .cta-contact-note {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 300;
            color: var(--warm-grey);
        }

        .cta-contact-note svg {
            width: 16px;
            height: 16px;
            stroke: var(--sage);
            fill: none;
            flex-shrink: 0;
        }

        /* Details accordion */
        .details-accordion {
            border-top: 1px solid rgba(44, 36, 33, 0.08);
            margin-top: 28px;
        }

        .accordion-item {
            border-bottom: 1px solid rgba(44, 36, 33, 0.08);
        }

        .accordion-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 0;
            background: none;
            border: none;
            cursor: none;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: var(--charcoal);
            text-align: left;
            transition: color 0.3s ease;
        }

        .accordion-trigger:hover {
            color: var(--rose);
        }

        .accordion-icon {
            width: 20px;
            height: 20px;
            border: 1px solid rgba(44, 36, 33, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .accordion-trigger[aria-expanded="true"] .accordion-icon {
            background: var(--charcoal);
            border-color: var(--charcoal);
        }

        .accordion-icon svg {
            width: 10px;
            height: 10px;
            stroke: var(--charcoal);
            fill: none;
            transition: transform 0.4s var(--ease-out-expo), stroke 0.3s ease;
        }

        .accordion-trigger[aria-expanded="true"] .accordion-icon svg {
            transform: rotate(45deg);
            stroke: var(--cream);
        }

        .accordion-content {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.4s var(--ease-out-expo);
        }

        .accordion-content.open {
            grid-template-rows: 1fr;
        }

        .accordion-inner {
            overflow: hidden;
        }

        .accordion-inner p {
            padding-bottom: 20px;
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.8;
        }

        .accordion-inner ul {
            padding-bottom: 20px;
            padding-left: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .accordion-inner ul li {
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal-mid);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .accordion-inner ul li::before {
            content: '';
            display: block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--rose);
            flex-shrink: 0;
        }

        /* ----------------------------------------------------------------
                           RELATED PRODUCTS
                        ---------------------------------------------------------------- */
        .related-section {
            padding: var(--section-gap) clamp(24px, 6vw, 100px);
            background: var(--ivory);
            border-top: 1px solid rgba(44, 36, 33, 0.06);
        }

        .related-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 48px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .related-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 300;
            color: var(--charcoal);
            line-height: 1.1;
        }

        .related-title em {
            font-style: italic;
            color: var(--rose);
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        /* reuse .product-card from index */
        .product-card {
            cursor: none;
        }

        .product-card-img-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 2px;
            margin-bottom: 16px;
            background: var(--cream-dark);
        }

        .product-card-img {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            transition: transform 0.7s var(--ease-out-expo);
            display: block;
        }

        .product-card:hover .product-card-img {
            transform: scale(1.06);
        }

        .product-card-name {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 6px;
            transition: color 0.3s ease;
        }

        .product-card:hover .product-card-name {
            color: var(--rose-deep);
        }

        .product-card-category {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 6px;
        }

        .product-card-price {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 500;
            color: var(--charcoal);
        }

        /* ----------------------------------------------------------------
                           RESPONSIVE
                        ---------------------------------------------------------------- */
        @media (max-width: 1100px) {
            .product-detail {
                grid-template-columns: 1fr;
            }

            .gallery-side {
                position: static;
                height: 60vw;
                max-height: 480px;
                padding: 20px clamp(24px, 6vw, 100px);
            }

            .info-side {
                position: static;
                max-height: none;
                padding: 32px clamp(24px, 6vw, 100px) 60px;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 720px) {
            .gallery-side {
                grid-template-columns: 1fr;
                height: 80vw;
            }

            .gallery-thumbs {
                display: none;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .product-cta-btns {
                flex-direction: column;
            }

            .cta-wa-btn {
                flex: none;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    $seeds = ['detail-main', 'detail-2', 'detail-3', 'detail-4'];
                @endphp
                @foreach ($seeds as $i => $seed)
                    <img src="https://picsum.photos/seed/{{ $seed }}/160/160"
                        alt="Tampilan buket {{ $i + 1 }}" class="gallery-thumb {{ $i === 0 ? 'active' : '' }}"
                        data-full="https://picsum.photos/seed/{{ $seed }}/900/1200" data-index="{{ $i }}"
                        role="listitem" loading="{{ $i === 0 ? 'eager' : 'lazy' }}" />
                @endforeach
            </div>

            <div class="gallery-main-wrap">
                <span class="gallery-badge-overlay">Terlaris</span>

                <img id="gallery-main" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="gallery-main-img" loading="eager">

                <div class="gallery-zoom-hint" aria-hidden="true">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        <line x1="11" y1="8" x2="11" y2="14" />
                        <line x1="8" y1="11" x2="14" y2="11" />
                    </svg>
                    Perbesar
                </div>

                <div class="gallery-nav-btns" id="gallery-dots" aria-hidden="true">
                    @foreach ($seeds as $i => $seed)
                        <button class="gallery-nav-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"
                            aria-label="Gambar {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="info-side reveal-right">

            <p class="product-category-tag">{{ $product->category ?? 'Buket Segar' }}</p>

            <h1 class="product-name">{{ $product->name ?? 'Blushing Garden' }}</h1>

            <div class="product-price-block">
                <div>
                    <span class="product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
                <p class="product-price-note">Harga belum termasuk ongkos kirim. Pengiriman same-day tersedia.</p>
            </div>

            @if ($product->description)
                <p class="product-desc">
                    {{ $product->description }}
                </p>
            @else
                <p class="product-desc" style="color:#9ca3af;">
                    Tidak ada deskripsi produk.
                </p>
            @endif

            {{-- SIZE OPTIONS --}}
            <div class="option-group">
                <p class="option-label">
                    Ukuran
                    <span>— Standar (M) dipilih</span>
                </p>
                <div class="size-options" role="group" aria-label="Pilih ukuran">
                    @php
                        $sizes = [
                            ['label' => 'Mini (S)', 'price' => '+Rp 0', 'disabled' => false],
                            ['label' => 'Standar (M)', 'price' => '+Rp 30.000', 'disabled' => false],
                            ['label' => 'Besar (L)', 'price' => '+Rp 65.000', 'disabled' => false],
                            ['label' => 'Grand (XL)', 'price' => '+Rp 120.000', 'disabled' => false],
                        ];
                    @endphp
                    @foreach ($sizes as $i => $size)
                        <button class="size-btn {{ $i === 1 ? 'active' : '' }} {{ $size['disabled'] ? 'disabled' : '' }}"
                            data-price="{{ $size['price'] }}" aria-pressed="{{ $i === 1 ? 'true' : 'false' }}"
                            aria-label="{{ $size['label'] }} {{ $size['price'] }}">
                            {{ $size['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- COLOR OPTIONS --}}
            <div class="option-group">
                <p class="option-label">
                    Warna Dominan
                    <span>— Blush Pink dipilih</span>
                </p>
                <div class="color-options" role="group" aria-label="Pilih warna">
                    @php
                        $productColors = [
                            ['hex' => '#e8a0a0', 'name' => 'Blush Pink', 'active' => true],
                            ['hex' => '#d4b8d4', 'name' => 'Lavender', 'active' => false],
                            ['hex' => '#f5deb3', 'name' => 'Cream White', 'active' => false],
                            ['hex' => '#c2f0c2', 'name' => 'Sage Green', 'active' => false],
                            ['hex' => '#f5a06a', 'name' => 'Peach Coral', 'active' => false],
                        ];
                    @endphp
                    @foreach ($productColors as $color)
                        <button class="color-opt {{ $color['active'] ? 'active' : '' }}"
                            style="background: {{ $color['hex'] }};" aria-label="{{ $color['name'] }}"
                            title="{{ $color['name'] }}"
                            aria-pressed="{{ $color['active'] ? 'true' : 'false' }}"></button>
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="product-cta">
                <div class="product-cta-btns">
                    <a href="https://wa.me/6282333000472" target="_blank" rel="noopener" class="nav-cta">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                        </svg>
                        Pesan via WhatsApp
                    </a>

                    <button class="cta-share-btn" aria-label="Bagikan produk" id="share-btn">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                        </svg>
                    </button>
                </div>

                <p class="cta-contact-note">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Custom warna & ukuran tersedia. Hubungi kami untuk konsultasi gratis.
                </p>
            </div>


        </div>
    </div>

    {{-- ================================================================
     RELATED PRODUCTS
================================================================ --}}
    <section class="related-section" aria-label="Produk terkait">
        <div class="related-header reveal">
            <div>
                <span class="section-label">Mungkin Kamu Suka</span>
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
            @php
                $related = [
                    ['seed' => 'rel-1', 'name' => 'Eternal Rose', 'cat' => 'Buket Kering', 'price' => 'Rp 220.000'],
                    [
                        'seed' => 'rel-2',
                        'name' => 'Cotton Candy Cloud',
                        'cat' => 'Mini Bouquet',
                        'price' => 'Rp 115.000',
                    ],
                    ['seed' => 'rel-3', 'name' => 'Lavender Fields', 'cat' => 'Buket Kering', 'price' => 'Rp 205.000'],
                    ['seed' => 'rel-4', 'name' => 'Sunrise Tulip', 'cat' => 'Buket Segar', 'price' => 'Rp 175.000'],
                ];
            @endphp

            @foreach ($related as $i => $p)
                <a href="{{ url('/products/' . ($i + 10)) }}" class="product-card reveal delay-{{ $i + 1 }}"
                    aria-label="{{ $p['name'] }}">
                    <div class="product-card-img-wrap">
                        <img src="https://picsum.photos/seed/{{ $p['seed'] }}/480/640" alt="{{ $p['name'] }}"
                            class="product-card-img" loading="lazy" />
                    </div>
                    <p class="product-card-category">{{ $p['cat'] }}</p>
                    <h3 class="product-card-name">{{ $p['name'] }}</h3>
                    <p class="product-card-price">{{ $p['price'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // ================================================================
        //  GALLERY SWITCHING
        // ================================================================
        const mainImg = document.getElementById('gallery-main');
        const thumbs = document.querySelectorAll('.gallery-thumb');
        const dots = document.querySelectorAll('.gallery-nav-dot');

        function switchImage(index, src) {
            mainImg.classList.add('switching');
            setTimeout(() => {
                mainImg.src = src;
                mainImg.classList.remove('switching');
            }, 350);

            thumbs.forEach((t, i) => {
                t.classList.toggle('active', i === index);
            });
            dots.forEach((d, i) => {
                d.classList.toggle('active', i === index);
            });
        }

        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                switchImage(index, thumb.dataset.full);
            });
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                const correspondingThumb = thumbs[index];
                if (correspondingThumb) {
                    switchImage(index, correspondingThumb.dataset.full);
                }
            });
        });

        // ================================================================
        //  SIZE BUTTONS
        // ================================================================
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-btn').forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
            });
        });

        // ================================================================
        //  COLOR OPTIONS
        // ================================================================
        document.querySelectorAll('.color-opt').forEach(opt => {
            opt.addEventListener('click', function() {
                document.querySelectorAll('.color-opt').forEach(o => {
                    o.classList.remove('active');
                    o.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
            });
        });

        // ================================================================
        //  ACCORDION
        // ================================================================
        document.querySelectorAll('.accordion-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const isOpen = this.getAttribute('aria-expanded') === 'true';
                const contentId = this.getAttribute('aria-controls');
                const content = document.getElementById(contentId);

                // Close all
                document.querySelectorAll('.accordion-trigger').forEach(t => {
                    t.setAttribute('aria-expanded', 'false');
                });
                document.querySelectorAll('.accordion-content').forEach(c => {
                    c.classList.remove('open');
                });

                // Open clicked (if was closed)
                if (!isOpen) {
                    this.setAttribute('aria-expanded', 'true');
                    content.classList.add('open');
                }
            });
        });

        // ================================================================
        //  SHARE BUTTON
        // ================================================================
        document.getElementById('share-btn').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: document.title,
                        url: window.location.href,
                    });
                } catch (e) {}
            } else {
                navigator.clipboard.writeText(window.location.href);
                // Toast
                const toast = document.createElement('div');
                toast.textContent = 'Link disalin!';
                toast.style.cssText = `
            position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%);
            background: var(--charcoal); color: var(--cream); padding: 12px 24px;
            border-radius: 4px; font-size: 13px; z-index: 9999; font-family: var(--font-body);
            animation: fadeUpIn 0.4s ease forwards;
        `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2200);
            }
        });
    </script>
@endpush
