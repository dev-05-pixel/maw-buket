@extends('layouts.app')

@section('title', 'Rekomendasi Buket AI — Maw Bouquet')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ai/recommendation.css') }}">
@endpush

@section('content')

    {{-- ================================================================
     PAGE HERO
================================================================ --}}
    <header class="ai-hero" aria-label="AI Recommendation hero">

        {{-- Animated petals --}}
        <div class="ai-hero-deco" aria-hidden="true">
            @for ($p = 0; $p < 12; $p++)
                <div class="ai-petal"
                    style="
                left: {{ rand(5, 95) }}%;
                bottom: -10px;
                animation-duration: {{ rand(8, 16) }}s;
                animation-delay: {{ rand(0, 10) }}s;
                width: {{ rand(4, 8) }}px;
                height: {{ rand(4, 8) }}px;
                opacity: 0;
            ">
                </div>
            @endfor
        </div>

        <div class="ai-hero-grain" aria-hidden="true"></div>
        <div class="ai-hero-overlay" aria-hidden="true"></div>

        <div class="ai-hero-content">
            <p class="ai-hero-eyebrow">Rekomendasi AI</p>
            <h1 class="ai-hero-title">
                <span class="ai-hero-title-inner">
                    <span class="ai-hero-title-line">Temukan</span>
                </span>
                <span class="ai-hero-title-inner">
                    <span class="ai-hero-title-line">Buket <em>Idealmu</em></span>
                </span>
            </h1>
            <p class="ai-hero-sub">
                Sistem kecerdasan buatan kami menganalisis budget, acara, dan preferensi warnamu untuk menemukan buket yang
                paling cocok dari koleksi Maw Bouquet.
            </p>
        </div>
    </header>

    {{-- ================================================================
     MAIN: FORM + INFO PANEL
================================================================ --}}
    <div class="ai-main">

        {{-- ================================================================
         FORM PANEL
    ================================================================ --}}
        <div class="ai-form-panel reveal">

            <div class="form-panel-header">
                <p class="form-panel-title">Kriteria Pencarian</p>
                <div style="font-size: 11px; color: var(--warm-grey); font-weight: 300;">
                    Isi sesuai kebutuhanmu
                </div>
            </div>

            <form method="POST" action="{{ route('ai.process') }}" id="ai-form">
                @csrf

                <div class="form-panel-body">

                    {{-- ---- BUDGET ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label" for="inp-budget">Budget</label>
                            <label class="skip-toggle" for="skip-budget" title="Abaikan kriteria budget">
                                <input type="checkbox" id="skip-budget" name="skip_budget" value="1"
                                    class="skip-checkbox" data-target="inp-budget" data-slider="budget-slider"
                                    {{ old('skip_budget') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="budget-display">
                            <span class="budget-value" id="budget-display">
                                Rp <span
                                    id="budget-val">{{ old('budget', 150000) ? number_format(old('budget', 150000), 0, ',', '.') : '150.000' }}</span>
                            </span>
                            <span class="budget-range-labels">Rp 50rb — Rp 1jt</span>
                        </div>

                        <input type="range" class="budget-slider" id="budget-slider" min="50000" max="1000000"
                            step="10000" value="{{ old('budget', 150000) }}" />

                        <input type="hidden" name="budget" id="inp-budget" value="{{ old('budget', 150000) }}" />

                        <p class="ai-input-hint">Seret slider untuk menyesuaikan budget. Pilih "Skip" untuk mengabaikan
                            filter ini.</p>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- KATEGORI ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label" for="inp-kategori">Kategori</label>
                            <label class="skip-toggle" for="skip-kategori" title="Abaikan kriteria kategori">
                                <input type="checkbox" id="skip-kategori" name="skip_kategori" value="1"
                                    class="skip-checkbox" data-target="inp-kategori"
                                    {{ old('skip_kategori') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="ai-select-wrap">
                            <select name="kategori" id="inp-kategori" class="ai-select"
                                {{ old('skip_kategori') ? 'disabled' : '' }}>
                                <option value="buket_segar" {{ old('kategori') == 'buket_segar' ? 'selected' : '' }}>
                                    Buket Segar
                                </option>
                                <option value="buket_kering" {{ old('kategori') == 'buket_kering' ? 'selected' : '' }}>
                                    Buket Kering
                                </option>
                                <option value="pampas" {{ old('kategori') == 'pampas' ? 'selected' : '' }}>
                                    Pampas
                                </option>
                                <option value="mini_bouquet" {{ old('kategori') == 'mini_bouquet' ? 'selected' : '' }}>
                                    Mini Bouquet
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- WARNA ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label">Preferensi Warna</label>
                            <label class="skip-toggle" for="skip-warna" title="Abaikan kriteria warna">
                                <input type="checkbox" id="skip-warna" name="skip_warna" value="1"
                                    class="skip-checkbox" data-target="color-picker-group"
                                    {{ old('skip_warna') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="color-picker-grid" id="color-picker-group"
                            style="{{ old('skip_warna') ? 'opacity:0.4; pointer-events:none;' : '' }}">
                            @php
                                $colorOptions = [
                                    [
                                        'value' => 'bebas',
                                        'label' => 'Bebas',
                                        'hex' => 'linear-gradient(135deg,#e8a0a0,#d4b8d4,#c2f0c2,#f5deb3)',
                                    ],
                                    ['value' => 'pink', 'label' => 'Pink', 'hex' => '#e8a0a0'],
                                    ['value' => 'putih', 'label' => 'Putih', 'hex' => '#f5f5f0'],
                                    ['value' => 'merah', 'label' => 'Merah', 'hex' => '#dc6060'],
                                    ['value' => 'kuning', 'label' => 'Kuning', 'hex' => '#f5d66a'],
                                    ['value' => 'ungu', 'label' => 'Ungu', 'hex' => '#d4b8d4'],
                                    [
                                        'value' => 'campur',
                                        'label' => 'Mix',
                                        'hex' => 'linear-gradient(135deg,#e8a0a0,#c2f0c2,#b0c4de)',
                                    ],
                                ];
                                $selectedColor = old('warna', 'bebas');
                            @endphp

                            @foreach ($colorOptions as $col)
                                <label class="color-pick-btn {{ $selectedColor === $col['value'] ? 'selected' : '' }}"
                                    data-value="{{ $col['value'] }}">
                                    <input type="radio" name="warna" value="{{ $col['value'] }}"
                                        {{ $selectedColor === $col['value'] ? 'checked' : '' }} />
                                    <span class="color-pick-dot"
                                        style="background: {{ $col['hex'] }}; {{ $col['value'] === 'putih' ? 'border: 1.5px solid rgba(44,36,33,0.2);' : '' }}"></span>
                                    {{ $col['label'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label">Ukuran Buket</label>
                            <label class="skip-toggle" for="skip-ukuran">
                                <input type="checkbox" id="skip-ukuran" name="skip_ukuran" class="skip-checkbox"
                                    data-target="inp-ukuran" />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="ai-select-wrap">
                            <select name="ukuran" id="inp-ukuran" class="ai-select">
                                <option value="kecil">Kecil</option>
                                <option value="sedang">Sedang</option>
                                <option value="besar">Besar</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- SUBMIT ---- --}}
                    <button type="submit" class="ai-submit-btn" id="submit-btn">
                        <span>Temukan Buket Untukku</span>
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>

                </div>
            </form>
        </div>

        {{-- ================================================================
         INFO / TIPS PANEL
    ================================================================ --}}
        <aside class="ai-info-panel" aria-label="Informasi sistem">

            {{-- HOW IT WORKS --}}
            <div class="info-card reveal delay-1">
                <p class="info-card-title">Cara Memilih Buketmu</p>
                <div class="how-step">
                    <div class="how-step-num">1</div>
                    <div class="how-step-text">
                        <strong>Ceritakan Kebutuhanmu: </strong> pilih budget, momen, dan warna yang kamu inginkan. Tidak
                        wajib semua diisi.
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-step-num">2</div>
                    <div class="how-step-text">
                        <strong>Kami Pilihkan Untukmu: </strong> sistem kami akan mencocokkan dengan koleksi buket terbaik
                        yang paling sesuai.
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-step-num">3</div>
                    <div class="how-step-text">
                        <strong>Pilih & Pesan: </strong> lihat rekomendasi buket, lalu pesan dengan mudah melalui WhatsApp.
                    </div>
                </div>
            </div>

            {{-- ALGORITHM TAGS --}}
            <div class="algo-card reveal delay-2">
                <p class="algo-card-title">Kenapa Rekomendasi Ini Cocok?</p>
                <div class="algo-tag-list">
                    <span class="algo-tag accent">Dipersonalisasi</span>
                    <span class="algo-tag accent">Sesuai Budget</span>
                    <span class="algo-tag">Berdasarkan Momen</span>
                    <span class="algo-tag">Preferensi Warna</span>
                    <span class="algo-tag">Pilihan Terbaik</span>
                </div>
            </div>

            {{-- TIPS --}}
            <div class="algo-card reveal delay-3">
                <p class="algo-card-title">Panduan Cepat</p>
                <div class="tip-grid">
                    <div class="tip-card">
                        <span class="tip-title">Eksplor Semua</span>
                        <p>Aktifkan <strong>Skip</strong> untuk melihat semua pilihan tanpa batasan.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Warna Fleksibel</span>
                        <p>Pilih <strong>Bebas</strong> untuk variasi buket yang lebih luas.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Momen Spesial</span>
                        <p>Gunakan <strong>Romantis</strong> untuk anniversary atau ungkapan perasaan.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Hasil Terbaik</span>
                        <p>Kami menampilkan buket paling relevan di urutan teratas.</p>
                    </div>
                </div>
            </div>

        </aside>
    </div>

    {{-- ================================================================
     PREVIOUS RESULTS (if any from session / old submission)
================================================================ --}}
    @if (isset($products) && count($products) > 0)
        <section class="prev-results" aria-label="Hasil rekomendasi sebelumnya">
            <div style="margin-bottom: 40px;">
                <span class="section-label">Hasil Terakhir</span>
                <h2
                    style="font-family: var(--font-display); font-size: clamp(28px,3.5vw,44px); font-weight:300; color:var(--charcoal); margin-top:8px;">
                    Rekomendasi <em style="font-style:italic; color:var(--rose);">Untukmu</em>
                </h2>
            </div>

            <div class="products-listing product-grid"
                style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:28px;">
                @foreach ($products as $i => $product)
                    <article class="product-card reveal delay-{{ min($i + 1, 6) }}">
                        <div class="product-card-img-wrap">
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
                            <p class="product-card-category">{{ $product->category }}</p>
                            <h3 class="product-card-name">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/ai/recommendation.js') }}"></script>
@endpush
