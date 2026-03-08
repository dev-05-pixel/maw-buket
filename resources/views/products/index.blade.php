@extends('layouts.app')

@section('title', 'Koleksi Buket')

@push('styles')
    <style>
        /* ================================================================
                                                                                                                           PRODUCTS INDEX PAGE
                                                                                                                        ================================================================ */

        /* ----------------------------------------------------------------
                                                                                                                           PAGE HERO / BANNER
                                                                                                                        ---------------------------------------------------------------- */
        .page-hero {
            min-height: 52vh;
            display: flex;
            align-items: flex-end;
            position: relative;
            overflow: hidden;
            padding: 0 clamp(24px, 6vw, 100px) clamp(48px, 7vw, 90px);
            background: var(--charcoal);
        }

        .page-hero-bg {
            position: absolute;
            inset: 0;
            object-fit: cover;
            width: 100%;
            height: 100%;
            opacity: 0.35;
            transform: scale(1.06);
            animation: heroScale 1.4s 1.7s var(--ease-out-expo) forwards;
        }

        @keyframes heroScale {
            to {
                transform: scale(1);
            }
        }

        .page-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(44, 36, 33, 0.85) 0%, rgba(44, 36, 33, 0.4) 60%, transparent 100%);
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
        }

        .page-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 0.8s 1.9s var(--ease-out-expo) forwards;
        }

        .page-hero-label::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--rose-light);
        }

        @keyframes fadeUpIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-hero-title {
            font-family: var(--font-display);
            font-size: clamp(42px, 7vw, 96px);
            font-weight: 300;
            line-height: 0.95;
            color: var(--cream);
            letter-spacing: -0.01em;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .page-hero-title-inner {
            display: block;
            overflow: hidden;
        }

        .page-hero-title-line {
            display: block;
            transform: translateY(110%);
            animation: lineUp 0.9s var(--ease-out-expo) forwards;
        }

        .page-hero-title-inner:nth-child(1) .page-hero-title-line {
            animation-delay: 2.0s;
        }

        .page-hero-title-inner:nth-child(2) .page-hero-title-line {
            animation-delay: 2.12s;
        }

        @keyframes lineUp {
            to {
                transform: translateY(0);
            }
        }

        .page-hero-title em {
            font-style: italic;
            color: var(--rose-light);
        }

        .page-hero-sub {
            font-size: clamp(14px, 1.5vw, 16px);
            font-weight: 300;
            color: rgba(248, 243, 236, 0.65);
            max-width: 480px;
            line-height: 1.85;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 0.8s 2.35s var(--ease-out-expo) forwards;
        }

        /* Breadcrumb */
        .breadcrumb {
            position: absolute;
            top: calc(var(--nav-height) + 20px);
            left: clamp(24px, 6vw, 100px);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 2;
            opacity: 0;
            animation: fadeUpIn 0.6s 2.5s var(--ease-out-expo) forwards;
        }

        .breadcrumb a,
        .breadcrumb span {
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.05em;
            color: rgba(248, 243, 236, 0.5);
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--cream);
        }

        .breadcrumb-sep {
            font-size: 12px;
            color: rgba(248, 243, 236, 0.3);
        }

        .breadcrumb span:last-child {
            color: rgba(248, 243, 236, 0.85);
        }

        /* ----------------------------------------------------------------
                                                                                                                           FILTER & SORT BAR
                                                                                                                        ---------------------------------------------------------------- */
        .filter-bar {
            background: var(--ivory);
            border-bottom: 1px solid rgba(44, 36, 33, 0.08);
            padding: 0 clamp(24px, 6vw, 100px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            position: sticky;
            top: var(--nav-height);
            z-index: 100;
            flex-wrap: wrap;
        }

        .filter-tabs {
            display: flex;
            gap: 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            flex-shrink: 0;
        }

        .filter-tabs::-webkit-scrollbar {
            display: none;
        }

        .filter-tab {
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--warm-grey);
            padding: 20px 20px;
            border: none;
            background: none;
            cursor: none;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: color 0.3s ease, border-color 0.3s ease;
            margin-bottom: -1px;
        }

        .filter-tab:hover {
            color: var(--charcoal);
        }

        .filter-tab.active {
            color: var(--charcoal);
            border-bottom-color: var(--rose);
        }

        .filter-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }

        .sort-select-wrap {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sort-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--warm-grey);
            white-space: nowrap;
        }

        .sort-select {
            font-family: var(--font-body);
            font-size: 12px;
            color: var(--charcoal);
            background: transparent;
            border: none;
            cursor: none;
            padding-right: 20px;
            appearance: none;
            -webkit-appearance: none;
            font-weight: 500;
        }

        .sort-select-wrap::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid var(--warm-grey);
            pointer-events: none;
        }

        .view-toggle {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .view-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: none;
            cursor: none;
            border-radius: 4px;
            color: var(--warm-grey);
            transition: color 0.3s ease, background 0.3s ease;
        }

        .view-btn.active,
        .view-btn:hover {
            color: var(--charcoal);
            background: var(--cream-dark);
        }

        .view-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        /* ----------------------------------------------------------------
                                                                                                                           PRODUCTS MAIN LAYOUT
                                                                                                                        ---------------------------------------------------------------- */
        .products-main {
            padding: clamp(40px, 5vw, 80px) clamp(24px, 6vw, 100px);
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: clamp(32px, 4vw, 64px);
            align-items: start;
        }

        /* ----------------------------------------------------------------
                                                                                                                           SIDEBAR FILTERS
                                                                                                                        ---------------------------------------------------------------- */
        .sidebar {
            position: sticky;
            top: calc(var(--nav-height) + 64px);
        }

        .sidebar-section {
            margin-bottom: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(44, 36, 33, 0.08);
        }

        .sidebar-section:last-child {
            border-bottom: none;
        }

        .sidebar-title {
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: 20px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: none;
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal-mid);
            transition: color 0.3s ease;
        }

        .checkbox-label:hover {
            color: var(--charcoal);
        }

        .checkbox-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1.5px solid rgba(44, 36, 33, 0.25);
            border-radius: 2px;
            appearance: none;
            -webkit-appearance: none;
            cursor: none;
            position: relative;
            flex-shrink: 0;
            background: var(--ivory);
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .checkbox-label input[type="checkbox"]:checked {
            background: var(--charcoal);
            border-color: var(--charcoal);
        }

        .checkbox-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1.5px;
            width: 5px;
            height: 9px;
            border: 1.5px solid white;
            border-left: none;
            border-top: none;
            transform: rotate(45deg);
        }

        .checkbox-count {
            margin-left: auto;
            font-size: 11px;
            color: var(--warm-grey);
            background: var(--cream-dark);
            padding: 2px 8px;
            border-radius: 20px;
        }

        /* Price range */
        .price-range {
            width: 100%;
        }

        .price-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
        }

        .price-input-wrap {
            position: relative;
        }

        .price-input-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            font-weight: 500;
            color: var(--warm-grey);
        }

        .price-input {
            width: 100%;
            padding: 10px 10px 10px 36px;
            border: 1px solid rgba(44, 36, 33, 0.15);
            border-radius: 2px;
            background: var(--ivory);
            font-family: var(--font-body);
            font-size: 13px;
            color: var(--charcoal);
            cursor: none;
            transition: border-color 0.3s ease;
        }

        .price-input:focus {
            outline: none;
            border-color: var(--rose);
        }

        /* Color swatches */
        .color-swatches {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .color-swatch {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: none;
            border: 2px solid transparent;
            transition: transform 0.2s ease, border-color 0.2s ease;
            position: relative;
        }

        .color-swatch:hover {
            transform: scale(1.15);
        }

        .color-swatch.active {
            border-color: var(--charcoal);
            transform: scale(1.15);
        }

        /* ----------------------------------------------------------------
                                                                                                                           PRODUCTS GRID AREA
                                                                                                                        ---------------------------------------------------------------- */
        .products-area {}

        .products-result-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(44, 36, 33, 0.08);
            flex-wrap: wrap;
            gap: 12px;
        }

        .result-count {
            font-size: 14px;
            color: var(--charcoal-mid);
            font-weight: 300;
        }

        .result-count strong {
            color: var(--charcoal);
            font-weight: 500;
        }

        .active-filters {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .active-filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 500;
            color: var(--charcoal);
            background: var(--cream-dark);
            padding: 5px 12px;
            border-radius: 20px;
            cursor: none;
            transition: background 0.3s ease;
        }

        .active-filter-tag:hover {
            background: rgba(212, 132, 122, 0.2);
        }

        .active-filter-tag svg {
            width: 10px;
            height: 10px;
        }

        /* Product Grid (3 columns) */
        .products-listing {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .products-listing.view-list {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        /* Product card — general (shared w/ home) */
        .product-card {
            position: relative;
            cursor: none;
            transition: transform 0.4s var(--ease-out-expo);
        }

        .product-card-img-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 2px;
            margin-bottom: 18px;
            background: var(--cream-dark);
        }

        .product-card-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(44, 36, 33, 0);
            transition: background 0.5s ease;
            pointer-events: none;
        }

        .product-card:hover .product-card-img-wrap::after {
            background: rgba(44, 36, 33, 0.06);
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

        .product-card-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 1px;
        }

        .badge-hot {
            background: var(--rose);
            color: var(--white);
        }

        .badge-new {
            background: var(--sage);
            color: var(--white);
        }

        .badge-sale {
            background: var(--terracotta);
            color: var(--white);
        }

        .product-card-wish {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 1;
            width: 34px;
            height: 34px;
            background: rgba(248, 243, 236, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: none;
            opacity: 0;
            transform: translateY(-6px);
            transition: opacity 0.3s ease, transform 0.3s var(--ease-out-expo), background 0.3s ease;
            backdrop-filter: blur(6px);
        }

        .product-card:hover .product-card-wish {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card-wish:hover {
            background: rgba(212, 132, 122, 0.15);
        }

        .product-card-wish svg {
            width: 15px;
            height: 15px;
            stroke: var(--charcoal);
            fill: none;
            stroke-width: 1.5;
            transition: fill 0.3s ease, stroke 0.3s ease;
        }

        .product-card-wish.wished svg {
            fill: var(--rose);
            stroke: var(--rose);
        }

        .product-card-quick {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
            z-index: 2;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.35s ease, transform 0.35s var(--ease-out-expo);
        }

        .product-card:hover .product-card-quick {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card-quick {
            pointer-events: none;
        }

        .product-card-quick a {
            pointer-events: auto;
        }

        .product-quick-btn {
            width: 100%;
            background: var(--charcoal);
            color: var(--cream);
            border: none;
            cursor: none;
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 12px 16px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.3s ease;
        }

        .product-quick-btn:hover {
            background: var(--rose-deep);
        }

        .product-card-meta {
            padding: 0 4px;
        }

        .product-card-category {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 6px;
        }

        .product-card-name {
            font-family: var(--font-display);
            font-size: clamp(17px, 1.6vw, 21px);
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 8px;
            transition: color 0.3s ease;
            line-height: 1.2;
        }

        .product-card:hover .product-card-name {
            color: var(--rose-deep);
        }

        .product-card-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-card-price {
            font-family: var(--font-display);
            font-size: 19px;
            font-weight: 500;
            color: var(--charcoal);
        }

        .product-card-price .old-price {
            font-size: 13px;
            font-weight: 300;
            color: var(--warm-grey);
            text-decoration: line-through;
            margin-left: 6px;
        }

        /* List view variant */
        .products-listing.view-list .product-card {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 24px;
            align-items: center;
        }

        .products-listing.view-list .product-card-img-wrap {
            margin-bottom: 0;
        }

        .products-listing.view-list .product-card-img {
            aspect-ratio: 1;
        }

        .products-listing.view-list .product-card-quick {
            position: static;
            opacity: 1;
            transform: none;
            margin-top: 16px;
        }

        .products-listing.view-list .product-quick-btn {
            width: auto;
            display: inline-flex;
            padding: 10px 20px;
        }

        /* ----------------------------------------------------------------
                                                                                                                           PAGINATION
                                                                                                                        ---------------------------------------------------------------- */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 64px;
            padding-top: 40px;
            border-top: 1px solid rgba(44, 36, 33, 0.08);
        }

        .page-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(44, 36, 33, 0.15);
            border-radius: 2px;
            font-size: 13px;
            font-weight: 500;
            color: var(--charcoal-mid);
            cursor: none;
            transition: all 0.3s ease;
            background: transparent;
        }

        .page-btn:hover {
            border-color: var(--charcoal);
            color: var(--charcoal);
        }

        .page-btn.active {
            background: var(--charcoal);
            border-color: var(--charcoal);
            color: var(--cream);
        }

        .page-btn.prev-next {
            width: auto;
            padding: 0 16px;
            gap: 6px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .page-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        /* ----------------------------------------------------------------
                                                                                                                           EMPTY STATE
                                                                                                                        ---------------------------------------------------------------- */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 24px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            opacity: 0.3;
        }

        .empty-icon svg {
            width: 100%;
            height: 100%;
            stroke: var(--charcoal);
            fill: none;
        }

        .empty-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 12px;
        }

        .empty-desc {
            font-size: 15px;
            font-weight: 300;
            color: var(--warm-grey);
            max-width: 360px;
            margin: 0 auto 32px;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;

            background: #f3eee8;
            color: #2f2724;

            border: 2px solid #3b332f;
            border-radius: 999px;

            line-height: 1;
        }

        /* ICON X */
        .filter-chip-remove {
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #2f2724;
        }

        /* CHIP HOVER TIDAK BERUBAH */
        .filter-chip:hover {
            background: #f3eee8;
            border-color: #3b332f;
            color: #2f2724;
        }

        /* HOVER HANYA X */
        .filter-chip-remove:hover {
            opacity: 0.6;
        }

        /* ----------------------------------------------------------------
                                                                                                                           RESPONSIVE
                                                                                                                        ---------------------------------------------------------------- */
        @media (max-width: 1100px) {
            .products-main {
                grid-template-columns: 200px 1fr;
                gap: 32px;
            }

            .products-listing {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 860px) {
            .products-main {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                display: none;
            }

            .sidebar.mobile-open {
                display: block;
            }

            .filter-bar {
                padding: 0 24px;
            }
        }

        @media (max-width: 600px) {
            .products-listing {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .filter-tabs {
                gap: 0;
            }

            .filter-tab {
                padding: 16px 14px;
                font-size: 11px;
            }
        }

        @media (max-width: 420px) {
            .products-listing {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ================================================================
     PAGE HERO
================================================================ --}}
    <header class="page-hero" aria-label="Products page hero">
        <img src="https://picsum.photos/seed/products-hero/1600/800" alt="Collection of beautiful bouquets"
            class="page-hero-bg" loading="eager" fetchpriority="high" />
        <div class="page-hero-overlay" aria-hidden="true"></div>

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
        <input type="hidden" name="category" value="{{ request('category') }}">
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

            <div class="filter-right">
                <div class="sort-select-wrap" aria-label="Urutkan">
                    <span class="sort-label">Urut:</span>
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
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
    <div class="products-main">

        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar" aria-label="Filter panel">

            <div class="sidebar-section reveal">
                <p class="sidebar-title">Kategori</p>

                <div class="checkbox-group">
                    @foreach ($categories as $cat)
                        <label class="checkbox-label">

                            <input type="checkbox" name="category[]" value="{{ $cat }}"
                                onchange="this.form.submit()"
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
                        <input id="priceMin" type="number" class="price-input" placeholder="Min" step="1000"
                            min="0">
                    </div>

                    <div class="price-input-wrap">
                        <span class="price-input-prefix">Rp</span>
                        <input id="priceMax" type="number" class="price-input" placeholder="Max" step="1000"
                            min="0">
                    </div>

                </div>
            </div>

            <div class="sidebar-section reveal delay-2">
                <p class="sidebar-title">Warna Dominan</p>
                <div class="color-swatches">
                    @php
                        $colors = [
                            ['hex' => '#e8a0a0', 'name' => 'Pink'],
                            ['hex' => '#d4b8d4', 'name' => 'Lavender'],
                            ['hex' => '#c2f0c2', 'name' => 'Hijau'],
                            ['hex' => '#f5deb3', 'name' => 'Krem'],
                            ['hex' => '#f5a06a', 'name' => 'Oranye'],
                            ['hex' => '#b0c4de', 'name' => 'Biru'],
                            ['hex' => '#ffffff', 'name' => 'Putih'],
                            ['hex' => '#2c2421', 'name' => 'Gelap'],
                        ];
                    @endphp
                    @foreach ($colors as $color)
                        <button class="color-swatch"
                            style="background: {{ $color['hex'] }}; {{ $color['hex'] === '#ffffff' ? 'border: 1px solid rgba(44,36,33,0.15);' : '' }}"
                            aria-label="{{ $color['name'] }}" title="{{ $color['name'] }}"></button>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-section reveal delay-3">
                <p class="sidebar-title">Ukuran</p>
                <div class="checkbox-group">
                    @foreach (['Mini (S)', 'Standar (M)', 'Besar (L)', 'Grand (XL)'] as $size)
                        <label class="checkbox-label">
                            <input type="checkbox" name="size[]" value="{{ $size }}" />
                            {{ $size }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-section reveal delay-4">
                <p class="sidebar-title">Jenis Bunga</p>
                <div class="checkbox-group">
                    @foreach (['Mawar', 'Lily', 'Tulip', 'Sunflower', 'Baby Breath', 'Pampas'] as $flower)
                        <label class="checkbox-label">
                            <input type="checkbox" name="flower[]" value="{{ $flower }}" />
                            {{ $flower }}
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- PRODUCTS LISTING --}}
        <div class="products-area">

            <div class="products-result-info reveal">
                <p class="result-count">
                    Menampilkan <strong>{{ $products->total() }} produk</strong>
                </p>
                <div class="active-filters" id="active-filters" aria-label="Filter aktif">

                    @if (request()->has('category') && request('category') !== 'Semua')
                        <span class="filter-chip">

                            {{ request('category') }}

                            <a href="{{ route('products.index') }}" class="filter-chip-remove">
                                ×
                            </a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="products-listing" id="products-listing" role="list">


                @foreach ($products as $i => $product)
                    <article class="product-card reveal delay-{{ min(($i % 3) + 1, 6) }}" role="listitem">

                        <div class="product-card-img-wrap">

                            <button class="product-card-wish"
                                onclick="event.stopPropagation(); this.classList.toggle('wished')">

                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>

                            </button>

                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-card-img" loading="lazy" />
                            </a>

                            <div class="product-card-quick">
                                <a href="#" class="product-quick-btn wa-order" data-name="{{ $product->name }}"
                                    data-price="{{ number_format($product->price, 0, ',', '.') }}"
                                    data-url="{{ route('products.show', $product->id) }}">
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
            </div>

            {{-- PAGINATION --}}
            @if ($products->hasPages())
                <nav class="pagination-wrap reveal" aria-label="Navigasi halaman">

                    {{-- Previous --}}
                    @if ($products->onFirstPage())
                        <button class="page-btn prev-next" disabled>
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                            Prev
                        </button>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="page-btn prev-next">
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
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
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @else
                        <button class="page-btn prev-next" disabled>
                            Next
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </button>
                    @endif
                </nav>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ================================================================
        // WHATSAPP ORDER MESSAGE (VARIATIVE)
        // ================================================================

        document.querySelectorAll(".wa-order").forEach(btn => {

            btn.addEventListener("click", function(e) {

                e.preventDefault();

                let name = this.dataset.name;
                let price = this.dataset.price;
                let link = this.dataset.url;

                const messages = [

                    `Halo Maw Bouquet, saya tertarik dengan produk ${name} dengan harga Rp ${price} ini. Apakah produk ini masih tersedia untuk dipesan? Berikut link produknya: ${link}`,

                    `Halo kak, saya menemukan produk ${name} di website Maw Bouquet dengan harga Rp ${price} dan tertarik untuk memesannya. Apakah produk ini masih tersedia? Berikut link produk yang saya lihat: ${link}`,

                    `Permisi kak, saya tertarik dengan ${name} dengan harga Rp ${price} yang ada di website. Apakah buket ini masih bisa dipesan? Berikut link produknya: ${link}`,

                    `Halo Maw Bouquet, saya melihat produk ${name} dengan harga Rp ${price} di website dan tertarik untuk memesannya. Boleh dibantu informasi apakah produk ini masih tersedia? Link produk: ${link}`,
                ];

                let message = messages[Math.floor(Math.random() * messages.length)];

                let phone = "6282333000472";

                let url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);

                window.open(url, "_blank");

            });

        });

        // ================================================================
        //  FILTER TABS (client-side demo)
        // ================================================================
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab').forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                const filter = this.dataset.filter;
                if (filter !== 'Semua') {
                    const tag = document.createElement('button');
                    tag.className = 'active-filter-tag';
                    tag.innerHTML =
                        `${filter} <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
                    document.getElementById('active-filters').innerHTML = '';
                    document.getElementById('active-filters').appendChild(tag);
                    tag.addEventListener('click', () => {
                        document.getElementById('active-filters').innerHTML = '';
                        document.querySelector('[data-filter="Semua"]').click();
                    });
                } else {
                    document.getElementById('active-filters').innerHTML = '';
                }
            });
        });

        // ================================================================
        //  VIEW TOGGLE
        // ================================================================
        const gridBtn = document.getElementById('grid-view-btn');
        const listBtn = document.getElementById('list-view-btn');
        const listing = document.getElementById('products-listing');

        gridBtn.addEventListener('click', () => {
            listing.classList.remove('view-list');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            gridBtn.setAttribute('aria-pressed', 'true');
            listBtn.setAttribute('aria-pressed', 'false');
        });

        listBtn.addEventListener('click', () => {
            listing.classList.add('view-list');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            listBtn.setAttribute('aria-pressed', 'true');
            gridBtn.setAttribute('aria-pressed', 'false');
        });

        // ================================================================
        //  SCROLL REVEAL (re-trigger for new elements)
        // ================================================================
        const newReveals = document.querySelectorAll('.products-area .reveal');
        const revealObs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    revealObs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -20px 0px'
        });
        newReveals.forEach(el => revealObs.observe(el));

        // ================================================================
        //  COLOR SWATCHES
        // ================================================================
        document.querySelectorAll('.color-swatch').forEach(swatch => {
            swatch.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });

        const minInput = document.getElementById("priceMin");
        const maxInput = document.getElementById("priceMax");

        minInput.addEventListener("input", () => {

            let min = parseInt(minInput.value) || 0;
            let max = parseInt(maxInput.value) || 0;

            if (min > max) {
                maxInput.value = min;
            }

        });

        maxInput.addEventListener("input", () => {

            let min = parseInt(minInput.value) || 0;
            let max = parseInt(maxInput.value) || 0;

            if (max < min) {
                minInput.value = max;
            }

        });
    </script>
@endpush
