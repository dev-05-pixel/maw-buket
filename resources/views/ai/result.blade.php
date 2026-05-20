{{-- @extends('layouts.app')

@section('title', 'Hasil Rekomendasi AI — Maw Bouquet')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ai/result.css') }}">
@endpush

@section('content') --}}

    {{-- ================================================================
     RESULT HERO
================================================================ --}}
    {{-- <header class="result-hero" aria-label="Hasil rekomendasi">
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
            </div> --}}

            {{-- Stats --}}
            {{-- <div class="result-stats" aria-label="Statistik hasil">
                <div class="result-stat">
                    <span class="result-stat-val"><em>{{ count($products) }}</em></span>
                    <span class="result-stat-label">Buket Cocok</span>
                </div> --}}
                {{-- @if (request()->has('budget') && !request('skip_budget'))
                    <div class="result-stat">
                        <span class="result-stat-val" style="font-size:16px;">Rp
                            {{ number_format(request('budget'), 0, ',', '.') }}</span>
                        <span class="result-stat-label">Budget</span>
                    </div>
                @endif --}}
                {{-- @if (!empty($topScore))
                    <div class="result-stat">
                        <span class="result-stat-val"><em>{{ number_format($topScore, 1) }}</em></span>
                        <span class="result-stat-label">Skor Tertinggi</span>
                    </div>
                @endif --}}
            {{-- </div>
        </div>
    </header> --}}

    {{-- ================================================================
     CRITERIA BAR
================================================================ --}}
    {{-- <div class="criteria-bar" role="toolbar" aria-label="Kriteria yang digunakan">
        <div class="criteria-chips">
            <span class="criteria-label">Kriteria:</span> --}}

            {{-- Budget --}}
            {{-- @if (request('skip_budget'))
                <span class="criteria-chip skipped">Budget: Diabaikan</span>
            @elseif(request('budget'))
                <span class="criteria-chip active">
                    <span class="criteria-chip-dot"></span>
                    Budget: Rp {{ number_format(request('budget'), 0, ',', '.') }}
                </span>
            @endif --}}

            {{-- Acara --}}
            {{-- @if (request('skip_acara'))
                <span class="criteria-chip skipped">Acara: Diabaikan</span>
            @elseif(request('acara'))
                @php
                    $acaraLabels = [
                        'ulang_tahun' => '🎂 Ulang Tahun',
                        'romantis' => '💑 Romantis',
                        'pernikahan' => '💍 Pernikahan',
                        'simpati' => '🕊️ Simpati',
                        'wisuda' => '🎓 Wisuda',
                        'sederhana' => '🌿 Kasual',
                    ];
                @endphp
                <span class="criteria-chip active">
                    <span class="criteria-chip-dot"></span>
                    {{ $acaraLabels[request('acara')] ?? request('acara') }}
                </span>
            @endif --}}

            {{-- Warna --}}
            {{-- @if (request('skip_warna'))
                <span class="criteria-chip skipped">Warna: Diabaikan</span>
            @elseif(request('warna') && request('warna') !== 'bebas')
                <span class="criteria-chip active">
                    <span class="criteria-chip-dot"></span>
                    Warna: {{ ucfirst(request('warna')) }}
                </span>
            @elseif(request('warna') === 'bebas')
                <span class="criteria-chip">Warna: Bebas</span>
            @endif
        </div> --}}
{{--
        <a href="{{ route('ai.recommendation') }}" class="back-to-form" aria-label="Kembali ke form">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Ubah Kriteria
        </a>
    </div> --}}

    {{-- ================================================================
     MAIN RESULTS
================================================================ --}}
    {{-- <section class="result-main" aria-label="Daftar rekomendasi">

        @if (count($products) > 0) --}}

            {{-- Result info row --}}
            {{-- <div class="result-info-row reveal">
                <p class="result-count-text">
                    Menampilkan <strong>{{ count($products) }} buket</strong> yang cocok
                    @if (!request('skip_budget') && request('budget'))
                        dengan budget <strong>Rp {{ number_format(request('budget'), 0, ',', '.') }}</strong>
                    @endif
                </p>

                <div class="result-controls">
                    <span class="sort-label">Diurutkan: Skor AI ↓</span>
                    <div class="view-toggle" role="group" aria-label="Pilih tampilan">
                        <button class="view-btn active" id="grid-btn" aria-label="Grid view" aria-pressed="true">
                            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                            </svg>
                        </button>
                        <button class="view-btn" id="list-btn" aria-label="List view" aria-pressed="false">
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
            </div> --}}

            {{-- Product Grid --}}
            {{-- <div class="result-grid products-listing" id="result-grid" role="list">
                @foreach ($products as $i => $product)
                    @php
                        $score = $product->fuzzy_score ?? 0;
                        $scoreClass = $score >= 70 ? 'high' : ($score >= 40 ? 'mid' : 'low');
                        $rankNum = $i + 1;
                    @endphp

                    <article class="result-product-card reveal delay-{{ min(($i % 3) + 1, 6) }}" role="listitem">

                        <div class="product-card-img-wrap">
                            <a href="{{ route('products.show', $product->id) }}" aria-label="{{ $product->name }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-card-img" loading="{{ $i < 3 ? 'eager' : 'lazy' }}" />
                            </a> --}}

                            {{-- Fuzzy Score Badge --}}
                            {{-- <div class="score-badge" aria-label="Skor kesesuaian {{ number_format($score, 1) }}">
                                <span class="score-val {{ $scoreClass }}">{{ number_format($score, 1) }}</span>
                                <span class="score-sub">/ 100</span>
                            </div> --}}

                            {{-- Rank Badge (top 3) --}}
                            {{-- @if ($rankNum <= 3)
                                <div class="rank-badge rank-{{ $rankNum }}"
                                    aria-label="Peringkat {{ $rankNum }}">
                                    #{{ $rankNum }}
                                </div>
                            @endif --}}

                            {{-- Quick Action --}}
                            {{-- <div class="product-card-quick">
                                <a href="#" class="product-quick-btn wa-order" data-name="{{ $product->name }}"
                                    data-price="{{ number_format($product->price, 0, ',', '.') }}"
                                    data-url="{{ route('products.show', $product->id) }}">
                                    Pesan via WhatsApp
                                </a>
                            </div>
                        </div> --}}

                        {{-- Meta --}}
                        {{-- <div class="product-card-meta">
                            <p class="product-card-category">{{ $product->category }}</p>
                            <h2 class="product-card-name">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h2>
                            <p class="product-card-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p> --}}

                            {{-- Score bar --}}
                            {{-- <div class="score-bar-wrap" role="progressbar" aria-valuenow="{{ $score }}"
                                aria-valuemin="0" aria-valuemax="100"
                                aria-label="Skor {{ number_format($score, 1) }} dari 100">
                                <div class="score-bar-fill {{ $scoreClass }}" style="width: {{ $score }}%">
                                </div>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>
        @else --}}
            {{-- Empty State --}}
            {{-- <div class="empty-result">
                <div class="empty-result-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        <line x1="8" y1="11" x2="14" y2="11" />
                    </svg>
                </div>
                <h2 class="empty-result-title">Tidak Ada Hasil</h2>
                <p class="empty-result-desc">
                    Tidak ada buket yang cocok dengan kriteria tersebut. Coba perbesar budget atau aktifkan opsi
                    <em>Skip</em> pada beberapa kriteria.
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

    </section> --}}

    {{-- ================================================================
     CTA — TRY AGAIN / BROWSE ALL
================================================================ --}}
    {{-- <div class="result-cta-section" aria-label="Coba lagi atau jelajahi koleksi">
        <div class="result-cta-text">
            <h2 class="result-cta-title">Belum Menemukan yang <em>Tepat?</em></h2>
            <p class="result-cta-sub">Coba ubah kriteria atau jelajahi seluruh koleksi Maw Bouquet.</p>
        </div>
        <div class="result-cta-btns">
            <a href="{{ route('ai.recommendation') }}" class="btn-outline-light"
                aria-label="Coba lagi dengan kriteria berbeda">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    aria-hidden="true">
                    <polyline points="23 4 23 10 17 10" />
                    <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10" />
                </svg>
                Coba Lagi
            </a>
            <a href="{{ route('products.index') }}" class="btn-filled-rose" aria-label="Lihat semua koleksi buket">
                Lihat Semua Koleksi
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

@endsection --}}

{{-- @push('scripts')
    <script src="{{ asset('js/ai/result.js') }}"></script>
@endpush --}}
