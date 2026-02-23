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
    to { transform: scale(1); }
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
    to { opacity: 1; transform: translateY(0); }
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

.page-hero-title-inner:nth-child(1) .page-hero-title-line { animation-delay: 2.0s; }
.page-hero-title-inner:nth-child(2) .page-hero-title-line { animation-delay: 2.12s; }

@keyframes lineUp {
    to { transform: translateY(0); }
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

.breadcrumb a:hover { color: var(--cream); }

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

.filter-tabs::-webkit-scrollbar { display: none; }

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

.badge-hot    { background: var(--rose);       color: var(--white); }
.badge-new    { background: var(--sage);        color: var(--white); }
.badge-sale   { background: var(--terracotta);  color: var(--white); }

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
    <img
        src="https://picsum.photos/seed/products-hero/1600/800"
        alt="Collection of beautiful bouquets"
        class="page-hero-bg"
        loading="eager"
        fetchpriority="high"
    />
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
            Jelajahi rangkaian buket kami — dari yang segar mekar hingga yang dikeringkan dengan penuh perhatian. Setiap kreasi dibuat untuk mengungkapkan apa yang tak terucapkan.
        </p>
    </div>
</header>

{{-- ================================================================
     FILTER BAR
================================================================ --}}
<div class="filter-bar" role="toolbar" aria-label="Filter produk">
    <div class="filter-tabs" role="tablist" aria-label="Kategori">
        @php
        $categories = ['Semua', 'Buket Segar', 'Buket Kering', 'Pampas', 'Mini Bouquet'];
        $activeCategory = request('category', 'Semua');
        @endphp
        @foreach ($categories as $cat)
        <button
            class="filter-tab {{ ($activeCategory === $cat || ($cat === 'Semua' && !request('category'))) ? 'active' : '' }}"
            role="tab"
            aria-selected="{{ ($activeCategory === $cat) ? 'true' : 'false' }}"
            data-filter="{{ $cat }}"
        >
            {{ $cat }}
        </button>
        @endforeach
    </div>

    <div class="filter-right">
        <div class="sort-select-wrap" aria-label="Urutkan">
            <span class="sort-label">Urut:</span>
            <select class="sort-select" aria-label="Pilih urutan">
                <option value="popular">Terpopuler</option>
                <option value="newest">Terbaru</option>
                <option value="price-asc">Harga Terendah</option>
                <option value="price-desc">Harga Tertinggi</option>
            </select>
        </div>

        <div class="view-toggle" role="group" aria-label="Tampilan grid">
            <button class="view-btn active" id="grid-view-btn" aria-label="Grid view" aria-pressed="true">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
                </svg>
            </button>
            <button class="view-btn" id="list-view-btn" aria-label="List view" aria-pressed="false">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
            </button>
        </div>
    </div>
</div>

{{-- ================================================================
     MAIN CONTENT: SIDEBAR + PRODUCTS
================================================================ --}}
<div class="products-main">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar" aria-label="Filter panel">

        <div class="sidebar-section reveal">
            <p class="sidebar-title">Kategori</p>
            <div class="checkbox-group">
                @php
                $sidebarCats = [
                    ['name' => 'Buket Segar',   'count' => 12],
                    ['name' => 'Buket Kering',  'count' => 8],
                    ['name' => 'Pampas',        'count' => 10],
                    ['name' => 'Mini Bouquet',  'count' => 6],
                ];
                @endphp
                @foreach ($sidebarCats as $cat)
                <label class="checkbox-label">
                    <input type="checkbox" name="category[]" value="{{ $cat['name'] }}" />
                    {{ $cat['name'] }}
                    <span class="checkbox-count">{{ $cat['count'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="sidebar-section reveal delay-1">
            <p class="sidebar-title">Harga</p>
            <div class="price-inputs">
                <div class="price-input-wrap">
                    <span class="price-input-prefix">Rp</span>
                    <input type="number" class="price-input" placeholder="Min" aria-label="Harga minimum" />
                </div>
                <div class="price-input-wrap">
                    <span class="price-input-prefix">Rp</span>
                    <input type="number" class="price-input" placeholder="Max" aria-label="Harga maksimum" />
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
                <button
                    class="color-swatch"
                    style="background: {{ $color['hex'] }}; {{ $color['hex'] === '#ffffff' ? 'border: 1px solid rgba(44,36,33,0.15);' : '' }}"
                    aria-label="{{ $color['name'] }}"
                    title="{{ $color['name'] }}"
                ></button>
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
            <p class="result-count">Menampilkan <strong>36 produk</strong></p>
            <div class="active-filters" id="active-filters" aria-label="Filter aktif"></div>
        </div>

        <div class="products-listing" id="products-listing" role="list">
            @php
            $products = [
                ['seed' => 'p01', 'name' => 'Blushing Garden',     'cat' => 'Buket Segar',  'price' => 'Rp 185.000', 'old_price' => null,           'badge' => 'hot',  'badge_text' => 'Terlaris'],
                ['seed' => 'p02', 'name' => 'Eternal Rose',        'cat' => 'Buket Kering', 'price' => 'Rp 220.000', 'old_price' => null,           'badge' => 'new',  'badge_text' => 'Baru'],
                ['seed' => 'p03', 'name' => 'Soft Pampas Dream',   'cat' => 'Pampas',       'price' => 'Rp 195.000', 'old_price' => null,           'badge' => null,   'badge_text' => null],
                ['seed' => 'p04', 'name' => 'Golden Hour',         'cat' => 'Buket Segar',  'price' => 'Rp 165.000', 'old_price' => 'Rp 200.000',   'badge' => 'sale', 'badge_text' => 'Sale'],
                ['seed' => 'p05', 'name' => 'Cotton Candy Cloud',  'cat' => 'Mini Bouquet', 'price' => 'Rp 115.000', 'old_price' => null,           'badge' => null,   'badge_text' => null],
                ['seed' => 'p06', 'name' => 'Lavender Fields',     'cat' => 'Buket Kering', 'price' => 'Rp 205.000', 'old_price' => null,           'badge' => 'new',  'badge_text' => 'Baru'],
                ['seed' => 'p07', 'name' => 'Sunrise Tulip',       'cat' => 'Buket Segar',  'price' => 'Rp 175.000', 'old_price' => null,           'badge' => 'hot',  'badge_text' => 'Terlaris'],
                ['seed' => 'p08', 'name' => 'Dusty Rose Charm',    'cat' => 'Buket Segar',  'price' => 'Rp 190.000', 'old_price' => null,           'badge' => null,   'badge_text' => null],
                ['seed' => 'p09', 'name' => 'Wild Garden Mix',     'cat' => 'Pampas',       'price' => 'Rp 230.000', 'old_price' => null,           'badge' => null,   'badge_text' => null],
            ];
            @endphp

            @foreach ($products as $i => $product)
            <article class="product-card reveal delay-{{ min($i % 3 + 1, 6) }}" role="listitem">
                <a href="{{ url('/products/' . ($i + 1)) }}" aria-label="Lihat {{ $product['name'] }}">
                    <div class="product-card-img-wrap">
                        @if ($product['badge'])
                        <span class="product-card-badge badge-{{ $product['badge'] }}">{{ $product['badge_text'] }}</span>
                        @endif

                        <button class="product-card-wish" aria-label="Simpan ke favorit" onclick="event.preventDefault(); this.classList.toggle('wished')">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>

                        <img
                            src="https://picsum.photos/seed/{{ $product['seed'] }}/540/720"
                            alt="{{ $product['name'] }}"
                            class="product-card-img"
                            loading="lazy"
                        />

                        <div class="product-card-quick">
                            <a href="https://wa.me/628xxxxxxxxxx?text=Halo, saya ingin memesan {{ urlencode($product['name']) }}" target="_blank" rel="noopener" class="product-quick-btn">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                </svg>
                                Pesan via WA
                            </a>
                        </div>
                    </div>

                    <div class="product-card-meta">
                        <p class="product-card-category">{{ $product['cat'] }}</p>
                        <h2 class="product-card-name">{{ $product['name'] }}</h2>
                        <div class="product-card-bottom">
                            <p class="product-card-price">
                                {{ $product['price'] }}
                                @if ($product['old_price'])
                                <span class="old-price">{{ $product['old_price'] }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <nav class="pagination-wrap reveal" aria-label="Navigasi halaman">
            <button class="page-btn prev-next" aria-label="Halaman sebelumnya">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Prev
            </button>
            <button class="page-btn active" aria-current="page" aria-label="Halaman 1">1</button>
            <button class="page-btn" aria-label="Halaman 2">2</button>
            <button class="page-btn" aria-label="Halaman 3">3</button>
            <span style="padding: 0 4px; color: var(--warm-grey); font-size: 14px;">...</span>
            <button class="page-btn" aria-label="Halaman 6">6</button>
            <button class="page-btn prev-next" aria-label="Halaman berikutnya">
                Next
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </nav>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
            tag.innerHTML = `${filter} <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
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
const gridBtn    = document.getElementById('grid-view-btn');
const listBtn    = document.getElementById('list-view-btn');
const listing    = document.getElementById('products-listing');

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
const revealObs  = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            revealObs.unobserve(entry.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });
newReveals.forEach(el => revealObs.observe(el));

// ================================================================
//  COLOR SWATCHES
// ================================================================
document.querySelectorAll('.color-swatch').forEach(swatch => {
    swatch.addEventListener('click', function() {
        this.classList.toggle('active');
    });
});
</script>
@endpush
