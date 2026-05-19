@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/general/home.css') }}">
@endpush

@section('content')

    {{-- ================================================================
     HERO
================================================================ --}}
    <section class="hero" aria-label="Hero section">

        <div class="hero-deco-circle hero-deco-1" aria-hidden="true"></div>
        <div class="hero-deco-circle hero-deco-2" aria-hidden="true"></div>

        <div class="hero-left">
            <div class="hero-eyebrow" aria-hidden="true">
                <span class="hero-eyebrow-line"></span>
                <span class="hero-eyebrow-text">Handcrafted Bouquets</span>
            </div>

            <h1 class="hero-title">
                <span class="hero-title-line"><span class="hero-title-inner">Rangkai</span></span>
                <span class="hero-title-line"><span class="hero-title-inner"><em>Cinta</em> dalam</span></span>
                <span class="hero-title-line"><span class="hero-title-inner">Setiap Bunga</span></span>
            </h1>

            <p class="hero-desc">
                Setiap buket adalah cerita yang menunggu untuk disampaikan. Kami merangkai keindahan alam menjadi ekspresi
                perasaan terdalam Anda — untuk ulang tahun, pernikahan, atau sekadar mengucapkan "aku peduli."
            </p>

            <div class="hero-actions">
                <a href="{{ url('/products') }}" class="btn-primary">
                    <span>Lihat Koleksi</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ url('/contact') }}" class="btn-outline">Hubungi Kami</a>
            </div>
        </div>

        <div class="hero-right">
            <img src="{{ asset('assets/main banner.svg') }}" alt="Beautiful fresh flower bouquet" class="hero-img-main"
                loading="eager" fetchpriority="high" />
            <div class="hero-img-overlay" aria-hidden="true"></div>
        </div>

    </section>

    {{-- ================================================================
     MARQUEE TICKER
================================================================ --}}
    <div class="marquee-section" aria-hidden="true">
        <div class="marquee-track">
            @for ($i = 0; $i < 2; $i++)
                <span class="marquee-item"><span class="marquee-text">Fresh Flowers</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Dried Bouquet</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Wedding Decor</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Birthday Gifts</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Custom Order</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Same Day Delivery</span><span
                        class="marquee-dot"></span></span>
                <span class="marquee-item"><span class="marquee-text">Handcrafted</span><span
                        class="marquee-dot"></span></span>
            @endfor
        </div>
    </div>

    {{-- ================================================================
     ABOUT / INTRO
================================================================ --}}
    <section class="about-section" aria-label="About Maw Bouquet">
        <div class="about-img-wrap reveal-left">
            <img src="{{ asset('assets/about1.png') }}" alt="Florist arranging fresh flowers" class="about-img-main"
                loading="lazy" />
            <img src="{{ asset('assets/about2.png') }}" alt="Close up of flower arrangement" class="about-img-accent"
                loading="lazy" />
            <span class="about-img-tag">Est. 2020</span>
        </div>

        <div class="about-content reveal-right">
            <span class="section-label">Tentang Kami</span>

            <h2 class="about-title">
                Dibuat dengan<br>
                Tangan &amp; <em>Hati</em>
            </h2>

            <p class="about-body">
                Maw Bouquet lahir dari kecintaan mendalam terhadap keindahan alam dan seni merangkai bunga. Kami percaya
                bahwa setiap bunga memiliki bahasa tersendiri, dan tugas kami adalah membantu Anda mengucapkan kata-kata
                yang tak tersampaikan.
            </p>
            <p class="about-body">
                Dengan menggunakan bunga-bunga pilihan berkualitas tinggi — baik segar maupun kering — setiap rangkaian kami
                dirancang untuk bertahan lama dalam kenangan, bahkan jauh setelah kelopaknya layu.
            </p>

            <div class="about-divider"></div>

            <a href="{{ url('/contact') }}" class="btn-outline">
                Ceritakan Kebutuhanmu
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>

            <div class="about-stats">

                {{-- Orders --}}
                <div class="about-stat-card reveal delay-1">

                    <div class="about-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
                        </svg>
                    </div>

                    <div class="about-stat-content">
                        <p class="about-stat-num">
                            {{ number_format($completedOrders) }}<span>+</span>
                        </p>

                        <p class="about-stat-label">
                            Pesanan Selesai
                        </p>

                        <div class="about-stat-line"></div>

                        <p class="about-stat-desc">
                            Buket telah dikirim untuk berbagai momen spesial pelanggan kami.
                        </p>
                    </div>

                </div>

                {{-- Rating --}}
                <div class="about-stat-card reveal delay-2">

                    <div class="about-stat-icon rating">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <div class="about-stat-content">

                        <div class="about-rating-row">
                            <p class="about-stat-num">
                                {{ $averageRating }}
                            </p>
                            <div class="about-rating-stars">
                                ★★★★★
                            </div>
                        </div>
                        <p class="about-stat-label">
                            Rating Rata-rata
                        </p>
                        <div class="about-stat-line"></div>
                        <p class="about-stat-desc">
                            Berdasarkan ulasan pelanggan yang telah mempercayai Maw Bouquet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     FEATURED PRODUCTS
================================================================ --}}
    <section class="products-section" aria-label="Featured products">
        <div class="products-header">
            <div class="reveal">
                <span class="section-label">Koleksi Pilihan</span>
                <h2 class="products-title">
                    Buket yang<br><em>Menceritakan</em><br>Segalanya
                </h2>
            </div>
            <div class="reveal delay-2">
                <a href="{{ url('/products') }}" class="btn-outline">
                    Lihat Semua
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="products-grid">

            @forelse ($featuredProducts as $i => $product)
                <article class="product-card reveal delay-{{ ($i % 4) + 1 }}">
                    <a href="{{ url('/products/' . $product->id) }}">
                        <div class="product-card-img-wrap">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-card-img" loading="lazy" />
                        </div>
                        <p class="product-card-category">
                            {{ $product->category }}
                        </p>
                        <h3 class="product-card-name">
                            {{ $product->name }}
                        </h3>
                        <p class="product-card-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </a>
                </article>

            @empty

                <div class="empty-state">
                    <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 14V11M4 7l8 4" />
                    </svg>

                    <h3 class="empty-state-title">
                        Koleksi sedang disiapkan
                    </h3>
                    <p class="empty-state-text">
                        Produk pilihan akan segera hadir untuk Anda jelajahi.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ================================================================
     CATEGORIES
================================================================ --}}
    <section class="categories-section" aria-label="Product categories">
        <div class="reveal" style="margin-bottom: 48px;">
            <span class="section-label">Jelajahi Kategori</span>
            <h2 class="products-title" style="margin-top: 0;">
                Temukan <em>Buket</em><br>yang Tepat
            </h2>
        </div>

        <div class="categories-grid">
            @php
                $exploreImages = [
                    asset('assets/explore1.png'),
                    asset('assets/explore2.png'),
                    asset('assets/explore3.png'),
                    asset('assets/explore4.png'),
                ];
                $exploreCategories = array_keys($categoryCounts);
            @endphp

            @forelse ($exploreCategories as $i => $catName)
                @if ($i >= 4)
                    @break
                @endif

                <a href="{{ route('products.index', ['category' => $catName]) }}"
                    class="category-card reveal delay-{{ ($i % 4) + 1 }}" aria-label="{{ $catName }}">
                    <img src="{{ $exploreImages[$i] }}" alt="{{ $catName }}" class="category-img"
                        loading="lazy" />
                    <div class="category-overlay" aria-hidden="true"></div>
                    <div class="category-content">
                        <p class="category-name">
                            {{ $catName }}
                        </p>
                        <p class="category-count">
                            {{ $categoryCounts[$catName] }} Produk
                        </p>

                        <span class="category-arrow">
                            Lihat semua
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>
            @empty

                <div class="empty-state">
                    <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M3 7l9-4 9 4-9 4-9-4zm0 5l9 4 9-4m-18 5l9 4 9-4" />
                    </svg>
                    <h3 class="empty-state-title">
                        Kategori belum tersedia
                    </h3>
                    <p class="empty-state-text">
                        Pilihan kategori akan segera ditampilkan di halaman ini.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ================================================================
     HOW TO ORDER
================================================================ --}}
    <section class="process-section" aria-label="How to order">
        <div class="process-header">
            <div class="reveal">
                <p class="process-label">Cara Pesan</p>
                <h2 class="process-title">
                    Mudah &amp; <em>Menyenangkan</em>
                </h2>
            </div>
        </div>

        <div class="process-steps">
            @php
                $steps = [
                    [
                        'num' => '01',
                        'name' => 'Pilih Produk',
                        'desc' => 'Jelajahi koleksi kami dan temukan buket yang sesuai dengan hati Anda.',
                    ],
                    [
                        'num' => '02',
                        'name' => 'Hubungi Kami',
                        'desc' => 'Kirim pesan via WhatsApp atau email dengan detail pesanan Anda.',
                    ],
                    [
                        'num' => '03',
                        'name' => 'Konfirmasi',
                        'desc' => 'Kami membantu Anda menyesuaikan warna dan gaya sesuai kebutuhan.',
                    ],
                    [
                        'num' => '04',
                        'name' => 'Terima Buket',
                        'desc' => 'Buket Anda dikerjakan dengan penuh cinta dan siap dikirimkan.',
                    ],
                ];
            @endphp

            @foreach ($steps as $i => $step)
                <div class="process-step reveal delay-{{ ($i % 4) + 1 }}">
                    <div class="process-step-num">{{ $step['num'] }}</div>
                    <h3 class="process-step-name">{{ $step['name'] }}</h3>
                    <p class="process-step-desc">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================================================================
 TESTIMONIALS
================================================================ --}}
    <section id="testimonials" class="testimonials-section" aria-label="Customer testimonials">
        <div class="testimonials-bg-word" aria-hidden="true">Cerita</div>

        <div class="testimonials-header reveal">
            <span class="section-label" style="justify-content: center;">Kata Mereka</span>

            <h2 class="testimonials-title">
                Cerita di Balik<br>Setiap <em>Buket</em>
            </h2>
        </div>

        <div class="testimonials-grid">

            @forelse ($testimonials as $i => $t)
                <div class="testimonial-card reveal delay-{{ ($i % 4) + 1 }}">
                    <div class="testimonial-stars">
                        @for ($s = 0; $s < $t->rating; $s++)
                            <svg class="star-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="testimonial-quote-mark">
                        &ldquo;
                    </span>
                    <p class="testimonial-text">
                        {{ $t->message }}
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar-letter">
                            {{ strtoupper(substr($t->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="testimonial-author-name">
                                {{ $t->name }}
                            </p>
                            <p class="testimonial-author-loc">
                                {{ $t->location }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty

                <div class="empty-state testimonial-empty-state">
                    <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M8 10h8M8 14h5M7 3h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                    <h3 class="empty-state-title">
                        Belum ada cerita yang dibagikan
                    </h3>
                    <p class="empty-state-text">
                        Jadilah yang pertama membagikan pengalaman bersama Maw Bouquet.
                    </p>
                </div>
            @endforelse
        </div>

        <div style="margin-top:40px; text-align:center;">
            <a href="{{ route('testimonials.index') }}" class="btn-outline">
                Lihat Semua
            </a>
        </div>

        {{-- FORM TESTIMONI --}}
        <div class="testimonial-form-container reveal">
            <div class="testimonial-form-wrap">
                <div class="testimonial-form-header">
                    <h3 class="testimonial-form-title">
                        Bagikan Pengalaman Anda
                    </h3>
                    <p class="testimonial-form-subtitle">
                        Ceritakan pengalaman Anda bersama Maw Bouquet.
                        Ulasan Anda membantu kami terus menghadirkan rangkaian bunga terbaik.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="testimonial-errors">
                        @foreach ($errors->all() as $error)
                            <p class="testimonial-error-text">
                                {{ $error }}
                            </p>
                        @endforeach
                    </div>
                @endif

                <form id="testimonialForm" action="{{ route('testimonials.store') }}" method="POST" novalidate>
                    @csrf
                    {{-- STAR RATING --}}
                    <div class="rating-block">

                        <span class="rating-label">
                            Berikan Penilaian
                        </span>

                        <div class="rating-row">
                            <div class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star-{{ $i }}" name="rating"
                                        value="{{ $i }}">
                                    <label for="star-{{ $i }}">
                                        <svg class="star-icon-input" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <span class="rating-warning" id="ratingWarning">
                            Pilih rating terlebih dahulu
                        </span>

                    </div>

                    <div class="testimonial-field">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda"
                            required class="testimonial-input">
                    </div>
                    <div class="testimonial-field">
                        <textarea name="message" id="testimonialMessage"
                            placeholder="Tulis pengalaman Anda mengenai produk atau layanan kami..." required maxlength="1000"
                            class="testimonial-textarea">{{ old('message') }}</textarea>

                        <div class="text-xs text-muted mt-2">
                            <span id="charCount">0</span>/1000 karakter
                        </div>
                    </div>
                    <button type="submit" class="btn-primary testimonial-submit">
                        Kirim Testimoni
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- ================================================================
     CTA BANNER
    ================================================================ --}}
    <section class="cta-section" aria-label="Call to action">
        <div class="reveal">
            <p class="cta-label">Siap Memesan?</p>
            <h2 class="cta-title">
                Biarkan Kami<br>Merangkai <em>Momen</em><br>Tak Terlupakan
            </h2>
        </div>
        <div class="cta-actions reveal delay-2">
            <a href="https://wa.me/6285708573756" target="_blank" rel="noopener" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <span>Chat via WhatsApp</span>
            </a>
            <a href="{{ url('/contact') }}" class="btn-outline">Kirim Email</a>
        </div>
    </section>

    @if (session('testimonial_success'))
        <div class="snackbar" id="snackbar">
            Testimoni berhasil dikirim
        </div>
    @endif

    @push('scripts')
        <script src="{{ asset('js/general/home.js') }}"></script>
    @endpush

@endsection

