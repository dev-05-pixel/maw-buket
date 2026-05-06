@extends('layouts.app')

@section('title', 'Hasil Rekomendasi AI — Maw Bouquet')

@push('styles')
<style>
    /* ================================================================
       AI RESULT PAGE
    ================================================================ */

    /* ----------------------------------------------------------------
       RESULT HERO / SUMMARY BAR
    ---------------------------------------------------------------- */
    .result-hero {
        background: var(--charcoal);
        padding: clamp(32px, 5vw, 64px) clamp(24px, 6vw, 100px);
        position: relative;
        overflow: hidden;
    }

    .result-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(212,132,122,0.08) 0%, transparent 60%);
        pointer-events: none;
    }

    /* Animated line */
    .result-hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 0;
        background: linear-gradient(90deg, var(--rose), transparent);
        animation: lineExpand 1.2s 0.5s var(--ease-out-expo) forwards;
    }

    @keyframes lineExpand { to { width: 100%; } }

    .result-hero-inner {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 32px;
        flex-wrap: wrap;
    }

    .result-hero-left {}

    .result-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        color: var(--rose-light);
        margin-bottom: 16px;
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUpIn 0.7s 0.3s var(--ease-out-expo) forwards;
    }

    @keyframes fadeUpIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .result-title {
        font-family: var(--font-display);
        font-size: clamp(34px, 5vw, 72px);
        font-weight: 300;
        color: var(--cream);
        line-height: 0.95;
        letter-spacing: -0.01em;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .result-title-inner {
        display: block;
        overflow: hidden;
    }

    .result-title-line {
        display: block;
        transform: translateY(110%);
        animation: lineUp 0.85s var(--ease-out-expo) forwards;
    }

    .result-title-inner:nth-child(1) .result-title-line { animation-delay: 0.3s; }
    .result-title-inner:nth-child(2) .result-title-line { animation-delay: 0.45s; }

    @keyframes lineUp { to { transform: translateY(0); } }

    .result-title em {
        font-style: italic;
        color: var(--rose-light);
    }

    .result-sub {
        font-size: clamp(13px, 1.4vw, 15px);
        font-weight: 300;
        color: rgba(248, 243, 236, 0.55);
        max-width: 500px;
        line-height: 1.85;
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUpIn 0.7s 0.7s var(--ease-out-expo) forwards;
    }

    /* Stats row */
    .result-stats {
        display: flex;
        gap: 0;
        border: 1px solid rgba(248, 243, 236, 0.08);
        border-radius: 2px;
        overflow: hidden;
        flex-shrink: 0;
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUpIn 0.7s 0.8s var(--ease-out-expo) forwards;
    }

    .result-stat {
        padding: 18px 28px;
        border-right: 1px solid rgba(248, 243, 236, 0.08);
        text-align: center;
    }

    .result-stat:last-child {
        border-right: none;
    }

    .result-stat-val {
        font-family: var(--font-display);
        font-size: 28px;
        font-weight: 300;
        color: var(--cream);
        line-height: 1;
        margin-bottom: 5px;
        display: block;
    }

    .result-stat-val em {
        font-style: italic;
        color: var(--rose-light);
    }

    .result-stat-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: rgba(248, 243, 236, 0.4);
    }

    /* ----------------------------------------------------------------
       CRITERIA USED BAR
    ---------------------------------------------------------------- */
    .criteria-bar {
        background: var(--ivory);
        border-bottom: 1px solid rgba(44, 36, 33, 0.08);
        padding: 0 clamp(24px, 6vw, 100px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        min-height: 56px;
    }

    .criteria-chips {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 14px 0;
    }

    .criteria-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--warm-grey);
        margin-right: 4px;
    }

    .criteria-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 20px;
        color: var(--charcoal);
        background: var(--cream-dark);
        border: 1px solid rgba(44, 36, 33, 0.08);
    }

    .criteria-chip.active {
        background: rgba(212, 132, 122, 0.12);
        border-color: rgba(212, 132, 122, 0.25);
        color: var(--rose-deep);
    }

    .criteria-chip.skipped {
        opacity: 0.45;
        text-decoration: line-through;
    }

    .criteria-chip-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--rose);
        flex-shrink: 0;
    }

    .back-to-form {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--charcoal-mid);
        transition: color 0.3s ease;
        flex-shrink: 0;
    }

    .back-to-form:hover {
        color: var(--charcoal);
    }

    .back-to-form svg {
        width: 13px;
        height: 13px;
        stroke: currentColor;
        fill: none;
        transition: transform 0.3s var(--ease-out-expo);
    }

    .back-to-form:hover svg {
        transform: translateX(-3px);
    }

    /* ----------------------------------------------------------------
       PRODUCTS MAIN AREA
    ---------------------------------------------------------------- */
    .result-main {
        padding: clamp(40px, 5vw, 72px) clamp(24px, 6vw, 100px);
        background: var(--ivory);
    }

    /* Result info row */
    .result-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 36px;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(44, 36, 33, 0.08);
        flex-wrap: wrap;
        gap: 16px;
    }

    .result-count-text {
        font-size: 15px;
        font-weight: 300;
        color: var(--charcoal-mid);
    }

    .result-count-text strong {
        color: var(--charcoal);
        font-weight: 500;
    }

    /* Sort / view controls */
    .result-controls {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .sort-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--warm-grey);
    }

    .view-toggle {
        display: flex;
        gap: 4px;
    }

    .view-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        cursor: pointer;
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
       PRODUCT GRID
    ---------------------------------------------------------------- */
    .result-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .result-grid.view-list {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    /* Product card — reusing existing styles + score overlay */
    .product-card {
        position: relative;
        cursor: pointer;
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

    /* Score badge overlay */
    .score-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 2;
        background: rgba(44, 36, 33, 0.88);
        backdrop-filter: blur(8px);
        color: var(--cream);
        padding: 6px 12px;
        border-radius: 2px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 54px;
    }

    .score-val {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 400;
        color: var(--cream);
        line-height: 1;
    }

    .score-val.high  { color: #7dd3a8; }
    .score-val.mid   { color: var(--rose-light); }
    .score-val.low   { color: var(--warm-grey); }

    .score-sub {
        font-size: 8px;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(248, 243, 236, 0.5);
        margin-top: 2px;
    }

    /* Rank badge for top 3 */
    .rank-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
        border: 2px solid;
    }

    .rank-badge.rank-1 {
        background: rgba(212, 180, 100, 0.95);
        border-color: rgba(212, 180, 100, 0.5);
        color: #5a3e00;
    }

    .rank-badge.rank-2 {
        background: rgba(180, 190, 200, 0.92);
        border-color: rgba(180, 190, 200, 0.5);
        color: #3a4050;
    }

    .rank-badge.rank-3 {
        background: rgba(192, 130, 90, 0.92);
        border-color: rgba(192, 130, 90, 0.5);
        color: #3a2010;
    }

    /* Score progress bar in card */
    .score-bar-wrap {
        margin-top: 10px;
        height: 2px;
        background: rgba(44, 36, 33, 0.08);
        border-radius: 1px;
        overflow: hidden;
    }

    .score-bar-fill {
        height: 100%;
        border-radius: 1px;
        background: var(--rose);
        transition: width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .score-bar-fill.high { background: #7dd3a8; }
    .score-bar-fill.mid  { background: var(--rose); }
    .score-bar-fill.low  { background: var(--warm-grey); }

    /* Quick action */
    .product-card-quick {
        position: absolute;
        bottom: 16px;
        left: 16px;
        right: 16px;
        z-index: 2;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.35s ease, transform 0.35s var(--ease-out-expo);
        pointer-events: none;
    }

    .product-card:hover .product-card-quick {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .product-quick-btn {
        width: 100%;
        background: var(--charcoal);
        color: var(--cream);
        border: none;
        cursor: pointer;
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
        text-decoration: none;
    }

    .product-quick-btn:hover {
        background: var(--rose-deep);
    }

    /* Card meta */
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

    .product-card-price {
        font-family: var(--font-display);
        font-size: 19px;
        font-weight: 500;
        color: var(--charcoal);
    }

    /* List view */
    .result-grid.view-list .product-card {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 24px;
        align-items: start;
    }

    .result-grid.view-list .product-card-img-wrap {
        margin-bottom: 0;
    }

    .result-grid.view-list .product-card-img {
        aspect-ratio: 1;
    }

    .result-grid.view-list .product-card-quick {
        position: static;
        opacity: 1;
        transform: none;
        pointer-events: auto;
        margin-top: 14px;
    }

    .result-grid.view-list .product-quick-btn {
        width: auto;
        display: inline-flex;
        padding: 10px 20px;
    }

    /* Score in list view */
    .result-grid.view-list .score-badge {
        top: 10px;
        left: 10px;
    }

    /* ----------------------------------------------------------------
       EMPTY STATE
    ---------------------------------------------------------------- */
    .empty-result {
        text-align: center;
        padding: 80px 24px;
        grid-column: 1 / -1;
    }

    .empty-result-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 24px;
        opacity: 0.25;
    }

    .empty-result-icon svg {
        width: 100%;
        height: 100%;
        stroke: var(--charcoal);
        fill: none;
    }

    .empty-result-title {
        font-family: var(--font-display);
        font-size: 32px;
        font-weight: 400;
        color: var(--charcoal);
        margin-bottom: 12px;
    }

    .empty-result-desc {
        font-size: 15px;
        font-weight: 300;
        color: var(--warm-grey);
        max-width: 380px;
        margin: 0 auto 32px;
        line-height: 1.75;
    }

    .empty-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* ----------------------------------------------------------------
       CTA SECTION (try again)
    ---------------------------------------------------------------- */
    .result-cta-section {
        background: var(--charcoal);
        padding: clamp(40px, 5vw, 72px) clamp(24px, 6vw, 100px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        flex-wrap: wrap;
    }

    .result-cta-text {}

    .result-cta-title {
        font-family: var(--font-display);
        font-size: clamp(24px, 3vw, 40px);
        font-weight: 300;
        color: var(--cream);
        margin-bottom: 8px;
    }

    .result-cta-title em {
        font-style: italic;
        color: var(--rose-light);
    }

    .result-cta-sub {
        font-size: 14px;
        font-weight: 300;
        color: rgba(248, 243, 236, 0.55);
    }

    .result-cta-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .btn-outline-light {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--cream);
        border: 1.5px solid rgba(248, 243, 236, 0.25);
        padding: 14px 24px;
        border-radius: 2px;
        background: transparent;
        cursor: pointer;
        transition: border-color 0.3s ease, background 0.3s ease;
        text-decoration: none;
    }

    .btn-outline-light:hover {
        border-color: var(--rose-light);
        background: rgba(212, 132, 122, 0.1);
        color: var(--rose-light);
    }

    .btn-filled-rose {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--white);
        background: var(--rose);
        border: 1.5px solid var(--rose);
        padding: 14px 24px;
        border-radius: 2px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        text-decoration: none;
    }

    .btn-filled-rose:hover {
        background: var(--rose-deep);
        border-color: var(--rose-deep);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(212, 132, 122, 0.3);
    }

    .btn-filled-rose svg,
    .btn-outline-light svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        fill: none;
    }

    /* ----------------------------------------------------------------
       RELATED SECTION
    ---------------------------------------------------------------- */
    .related-section {
        padding: clamp(40px, 5vw, 72px) clamp(24px, 6vw, 100px);
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
        font-size: clamp(28px, 3.5vw, 48px);
        font-weight: 300;
        color: var(--charcoal);
        line-height: 1.1;
    }

    .related-title em {
        font-style: italic;
        color: var(--rose);
    }

    /* ----------------------------------------------------------------
       RESPONSIVE
    ---------------------------------------------------------------- */
    @media (max-width: 1100px) {
        .result-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 760px) {
        .result-stats {
            display: none;
        }

        .result-hero-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        .result-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }

    @media (max-width: 480px) {
        .result-grid {
            grid-template-columns: 1fr;
        }

        .result-cta-section {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')

{{-- ================================================================
     RESULT HERO
================================================================ --}}
<header class="result-hero" aria-label="Hasil rekomendasi">
    <div class="result-hero-inner">
        <div class="result-hero-left">
            <p class="result-eyebrow">AI Rekomendasi</p>
            <h1 class="result-title">
                <span class="result-title-inner">
                    <span class="result-title-line">Buket</span>
                </span>
                <span class="result-title-inner">
                    <span class="result-title-line"><em>Terbaik</em> Untukmu</span>
                </span>
            </h1>
            <p class="result-sub">
                Sistem AI kami telah menganalisis seluruh koleksi Maw Bouquet dan menemukan
                <strong style="color: var(--cream);">{{ count($products) }} buket</strong>
                yang paling sesuai dengan kriteriamu.
            </p>
        </div>

        {{-- Stats --}}
        <div class="result-stats" aria-label="Statistik hasil">
            <div class="result-stat">
                <span class="result-stat-val"><em>{{ count($products) }}</em></span>
                <span class="result-stat-label">Buket Cocok</span>
            </div>
            @if(request()->has('budget') && !request('skip_budget'))
            <div class="result-stat">
                <span class="result-stat-val" style="font-size:16px;">Rp {{ number_format(request('budget'), 0, ',', '.') }}</span>
                <span class="result-stat-label">Budget</span>
            </div>
            @endif
            @if(!empty($topScore))
            <div class="result-stat">
                <span class="result-stat-val"><em>{{ number_format($topScore, 1) }}</em></span>
                <span class="result-stat-label">Skor Tertinggi</span>
            </div>
            @endif
        </div>
    </div>
</header>

{{-- ================================================================
     CRITERIA BAR
================================================================ --}}
<div class="criteria-bar" role="toolbar" aria-label="Kriteria yang digunakan">
    <div class="criteria-chips">
        <span class="criteria-label">Kriteria:</span>

        {{-- Budget --}}
        @if(request('skip_budget'))
            <span class="criteria-chip skipped">Budget: Diabaikan</span>
        @elseif(request('budget'))
            <span class="criteria-chip active">
                <span class="criteria-chip-dot"></span>
                Budget: Rp {{ number_format(request('budget'), 0, ',', '.') }}
            </span>
        @endif

        {{-- Acara --}}
        @if(request('skip_acara'))
            <span class="criteria-chip skipped">Acara: Diabaikan</span>
        @elseif(request('acara'))
            @php
                $acaraLabels = [
                    'ulang_tahun' => '🎂 Ulang Tahun',
                    'romantis'    => '💑 Romantis',
                    'pernikahan'  => '💍 Pernikahan',
                    'simpati'     => '🕊️ Simpati',
                    'wisuda'      => '🎓 Wisuda',
                    'sederhana'   => '🌿 Kasual',
                ];
            @endphp
            <span class="criteria-chip active">
                <span class="criteria-chip-dot"></span>
                {{ $acaraLabels[request('acara')] ?? request('acara') }}
            </span>
        @endif

        {{-- Warna --}}
        @if(request('skip_warna'))
            <span class="criteria-chip skipped">Warna: Diabaikan</span>
        @elseif(request('warna') && request('warna') !== 'bebas')
            <span class="criteria-chip active">
                <span class="criteria-chip-dot"></span>
                Warna: {{ ucfirst(request('warna')) }}
            </span>
        @elseif(request('warna') === 'bebas')
            <span class="criteria-chip">Warna: Bebas</span>
        @endif
    </div>

    <a href="{{ route('ai.recommendation') }}" class="back-to-form" aria-label="Kembali ke form">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Ubah Kriteria
    </a>
</div>

{{-- ================================================================
     MAIN RESULTS
================================================================ --}}
<section class="result-main" aria-label="Daftar rekomendasi">

    @if(count($products) > 0)

        {{-- Result info row --}}
        <div class="result-info-row reveal">
            <p class="result-count-text">
                Menampilkan <strong>{{ count($products) }} buket</strong> yang cocok
                @if(!request('skip_budget') && request('budget'))
                    dengan budget <strong>Rp {{ number_format(request('budget'), 0, ',', '.') }}</strong>
                @endif
            </p>

            <div class="result-controls">
                <span class="sort-label">Diurutkan: Skor AI ↓</span>
                <div class="view-toggle" role="group" aria-label="Pilih tampilan">
                    <button class="view-btn active" id="grid-btn" aria-label="Grid view" aria-pressed="true">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
                        </svg>
                    </button>
                    <button class="view-btn" id="list-btn" aria-label="List view" aria-pressed="false">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                            <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                            <line x1="8" y1="18" x2="21" y2="18"/>
                            <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
                            <line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="result-grid" id="result-grid" role="list">
            @foreach($products as $i => $product)
                @php
                    $score      = $product->fuzzy_score ?? 0;
                    $scoreClass = $score >= 70 ? 'high' : ($score >= 40 ? 'mid' : 'low');
                    $rankNum    = $i + 1;
                @endphp

                <article class="product-card reveal delay-{{ min(($i % 3) + 1, 6) }}" role="listitem">

                    <div class="product-card-img-wrap">
                        <a href="{{ route('products.show', $product->id) }}" aria-label="{{ $product->name }}">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="product-card-img"
                                 loading="{{ $i < 3 ? 'eager' : 'lazy' }}" />
                        </a>

                        {{-- Fuzzy Score Badge --}}
                        <div class="score-badge" aria-label="Skor kesesuaian {{ number_format($score, 1) }}">
                            <span class="score-val {{ $scoreClass }}">{{ number_format($score, 1) }}</span>
                            <span class="score-sub">/ 100</span>
                        </div>

                        {{-- Rank Badge (top 3) --}}
                        @if($rankNum <= 3)
                            <div class="rank-badge rank-{{ $rankNum }}" aria-label="Peringkat {{ $rankNum }}">
                                #{{ $rankNum }}
                            </div>
                        @endif

                        {{-- Quick Action --}}
                        <div class="product-card-quick">
                            <a href="#" class="product-quick-btn wa-order"
                               data-name="{{ $product->name }}"
                               data-price="{{ number_format($product->price, 0, ',', '.') }}"
                               data-url="{{ route('products.show', $product->id) }}">
                                Pesan via WhatsApp
                            </a>
                        </div>
                    </div>

                    {{-- Meta --}}
                    <div class="product-card-meta">
                        <p class="product-card-category">{{ $product->category }}</p>
                        <h2 class="product-card-name">
                            <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                        </h2>
                        <p class="product-card-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        {{-- Score bar --}}
                        <div class="score-bar-wrap" role="progressbar"
                             aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"
                             aria-label="Skor {{ number_format($score, 1) }} dari 100">
                            <div class="score-bar-fill {{ $scoreClass }}"
                                 style="width: {{ $score }}%"></div>
                        </div>
                    </div>

                </article>
            @endforeach
        </div>

    @else
        {{-- Empty State --}}
        <div class="empty-result">
            <div class="empty-result-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    <line x1="8" y1="11" x2="14" y2="11"/>
                </svg>
            </div>
            <h2 class="empty-result-title">Tidak Ada Hasil</h2>
            <p class="empty-result-desc">
                Tidak ada buket yang cocok dengan kriteria tersebut. Coba perbesar budget atau aktifkan opsi <em>Skip</em> pada beberapa kriteria.
            </p>
            <div class="empty-actions">
                <a href="{{ route('ai.recommendation') }}" class="btn-outline" aria-label="Ubah kriteria pencarian">
                    ← Ubah Kriteria
                </a>
                <a href="{{ route('products.index') }}" class="nav-cta" aria-label="Lihat semua koleksi">
                    Lihat Semua Koleksi
                </a>
            </div>
        </div>
    @endif

</section>

{{-- ================================================================
     CTA — TRY AGAIN / BROWSE ALL
================================================================ --}}
<div class="result-cta-section" aria-label="Coba lagi atau jelajahi koleksi">
    <div class="result-cta-text">
        <h2 class="result-cta-title">Belum Menemukan yang <em>Tepat?</em></h2>
        <p class="result-cta-sub">Coba ubah kriteria atau jelajahi seluruh koleksi Maw Bouquet.</p>
    </div>
    <div class="result-cta-btns">
        <a href="{{ route('ai.recommendation') }}" class="btn-outline-light" aria-label="Coba lagi dengan kriteria berbeda">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                <polyline points="23 4 23 10 17 10"/>
                <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>
            </svg>
            Coba Lagi
        </a>
        <a href="{{ route('products.index') }}" class="btn-filled-rose" aria-label="Lihat semua koleksi buket">
            Lihat Semua Koleksi
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ================================================================
    //  WHATSAPP ORDER
    // ================================================================
    document.querySelectorAll('.wa-order').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const name  = this.dataset.name;
            const price = this.dataset.price;
            const link  = this.dataset.url;

            const messages = [
                `Halo Maw Bouquet, saya tertarik dengan produk *${name}* (Rp ${price}) yang direkomendasikan AI. Apakah masih tersedia?\n\nLink produk: ${link}`,
                `Permisi kak! AI Maw Bouquet merekomendasikan *${name}* dengan harga Rp ${price} sesuai kebutuhan saya. Apakah masih bisa dipesan?\n\n${link}`,
                `Halo kak, saya baru menggunakan fitur AI Rekomendasi dan mendapatkan saran produk *${name}* (Rp ${price}). Boleh dibantu untuk pemesanan?\n\nLink: ${link}`,
            ];

            const msg  = messages[Math.floor(Math.random() * messages.length)];
            const url  = 'https://wa.me/6282333000472?text=' + encodeURIComponent(msg);
            window.open(url, '_blank');
        });
    });

    // ================================================================
    //  VIEW TOGGLE (Grid / List)
    // ================================================================
    const gridBtn  = document.getElementById('grid-btn');
    const listBtn  = document.getElementById('list-btn');
    const grid     = document.getElementById('result-grid');

    if (gridBtn && listBtn && grid) {
        gridBtn.addEventListener('click', () => {
            grid.classList.remove('view-list');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            gridBtn.setAttribute('aria-pressed', 'true');
            listBtn.setAttribute('aria-pressed', 'false');
        });

        listBtn.addEventListener('click', () => {
            grid.classList.add('view-list');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            listBtn.setAttribute('aria-pressed', 'true');
            gridBtn.setAttribute('aria-pressed', 'false');
        });
    }

    // ================================================================
    //  ANIMATE SCORE BARS ON LOAD
    // ================================================================
    const scoreBars = document.querySelectorAll('.score-bar-fill');
    scoreBars.forEach(bar => {
        const target = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = target;
        }, 300);
    });

    // ================================================================
    //  SCROLL REVEAL
    // ================================================================
    const revealEls = document.querySelectorAll('.reveal');
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });
    revealEls.forEach(el => obs.observe(el));
</script>
@endpush
