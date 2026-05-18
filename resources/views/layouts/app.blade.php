<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="{{ $meta_description ?? 'Maw Bouquet — Rangkaian bunga segar & kering penuh cerita, dikirim langsung ke tangan Anda.' }}" />
    <title>{{ $title ?? 'Maw Bouquet' }} | Maw Bouquet</title>
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="Maw Bouquet">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="{{ isset($product) ? $product->name : 'Maw Bouquet' }}">
    <meta property="og:description"
        content="{{ isset($product) ? Str::limit(strip_tags($product->description), 120) : 'Buket bunga elegan untuk berbagai momen spesial.' }}">
    <meta property="og:image"
        content="{{ isset($product) && $product->image ? asset('storage/' . $product->image) : asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Jost:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
  

    @stack('styles')
</head>

<body>
  

    {{-- Noise texture --}}
    <div class="noise-overlay" aria-hidden="true"></div>

    {{-- Custom cursor --}}
    <div id="cursor-dot" aria-hidden="true"></div>
    <div id="cursor-ring" aria-hidden="true"></div>

    {{-- Page loader --}}
    <div id="page-loader" aria-hidden="true">
        <p class="loader-wordmark">Maw Bouquet</p>
        <div class="loader-bar-wrap">
            <div class="loader-bar"></div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav id="navbar" role="navigation" aria-label="Main navigation">
        <div class="container nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">Maw <span>·</span> Bouquet</a>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ url('/products') }}"
                        class="{{ request()->is('products*') ? 'active' : '' }}">Koleksi</a></li>
                <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Kontak</a>
                </li>
                <li>
                    {{-- <a href="{{ url('/ai-recommendation') }}"
                        class="{{ request()->is('ai-recommendation') ? 'active' : '' }}">
                        Rekomendasi AI
                    </a> --}}
                </li>
                <li>
                    <a href="https://wa.me/6282333000472" target="_blank" rel="noopener" class="nav-cta">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                        </svg>
                        <span>Pesan Sekarang</span>
                    </a>
                </li>
            </ul>

            <button class="nav-hamburger" id="hamburger-btn" aria-label="Toggle menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    {{-- Mobile nav --}}
    <div id="mobile-nav" role="dialog" aria-label="Mobile navigation" aria-hidden="true">
        <a href="{{ url('/') }}" class="mobile-nav-link">Beranda</a>
        <a href="{{ url('/products') }}" class="mobile-nav-link">Koleksi</a>
        <a href="{{ url('/contact') }}" class="mobile-nav-link">Kontak</a>
        {{-- <a href="{{ url('/ai-recommendation') }}" class="mobile-nav-link">
            Rekomendasi AI
        </a> --}}
        <a href="https://wa.me/6285708573756" target="_blank" rel="noopener" class="mobile-nav-link">WhatsApp</a>
    </div>

    {{-- Main content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer id="footer">
        <div class="container">
            <div class="footer-bg-text" aria-hidden="true">Bouquet</div>
            <div class="footer-grid footer-grid-4">
                <div class="reveal">
                    <p class="footer-brand-name">Maw <span>Bouquet</span></p>
                    <p class="footer-tagline">
                        Setiap rangkaian adalah karya seni yang tumbuh dari hati untuk momen yang tak terlupakan dalam
                        hidup Anda.
                    </p>
                    <div class="footer-socials">
                        {{-- Instagram --}}
                        <a href="#" class="footer-social-icon" aria-label="Instagram" target="_blank"
                            rel="noopener">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        {{-- TikTok --}}
                        <a href="#" class="footer-social-icon" aria-label="TikTok" target="_blank"
                            rel="noopener">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                            </svg>
                        </a>
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/6285708573756" class="footer-social-icon" aria-label="WhatsApp"
                            target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="reveal delay-2">
                    <p class="footer-col-title">Navigasi</p>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ url('/products') }}">Koleksi Buket</a></li>
                        <li><a href="{{ url('/contact') }}">Hubungi Kami</a></li>
                        <li><a href="https://wa.me/6282333000472" target="_blank" rel="noopener">Pesan via WA</a>
                        </li>
                    </ul>
                </div>

                

                <div class="reveal delay-3">
                    <p class="footer-col-title">Hubungi Kami</p>
                    <div class="footer-contact-item">
                        <svg class="footer-contact-icon" viewBox="0 0 24 24" fill="none"
                            stroke="rgba(248,243,236,0.5)" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.7 12.4 19.79 19.79 0 01.67 3.82 2 2 0 012.64 1.64h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.09 9a16 16 0 006 6l.92-.91a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                        </svg>
                        <p class="footer-contact-text">+62 888-888-8888</p>
                    </div>
                    <div class="footer-contact-item">
                        <svg class="footer-contact-icon" viewBox="0 0 24 24" fill="none"
                            stroke="rgba(248,243,236,0.5)" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        <p class="footer-contact-text">hello@mawbouquet.id</p>
                    </div>
                    <div class="footer-contact-item">
                        <svg class="footer-contact-icon" viewBox="0 0 24 24" fill="none"
                            stroke="rgba(248,243,236,0.5)" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <p class="footer-contact-text">Jakarta Selatan, Indonesia</p>
                    </div>
                </div>
                <div class="reveal delay-4">
                    <p class="footer-col-title">
                        Lokasi Kami
                    </p>

                    <div class="footer-map-wrap">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.7654966187083!2d113.49449157462853!3d-7.708294292309393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd70578fbd1ce1d%3A0xf274e90330fce8f5!2sNay%20Flower%20%7C%7C%20florist%20paiton!5e0!3m2!1sid!2sid!4v1778167923174!5m2!1sid!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-copy">&copy; {{ date('Y') }} Maw Bouquet. Seluruh hak dilindungi undang-undang.
                </p>
                <p class="footer-made">Developed by DFX Union</p>
            </div>
        </div>
    </footer>
    @include('components.ai-chat-widget')
    <script src="{{ asset('js/layouts/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
