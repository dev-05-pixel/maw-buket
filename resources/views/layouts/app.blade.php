<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="{{ $meta_description ?? 'Maw Bouquet — Rangkaian bunga segar & kering penuh cerita, dikirim langsung ke tangan Anda.' }}" />
    <title>{{ $title ?? 'Maw Bouquet' }} | Maw Bouquet</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Jost:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet" />

    <style>
        /* ============================================================
           CSS RESET & CUSTOM PROPERTIES
        ============================================================ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cream: #f8f3ec;
            --cream-dark: #f0e8da;
            --ivory: #fdfaf5;
            --rose: #d4847a;
            --rose-light: #e8b5af;
            --rose-deep: #b85c52;
            --sage: #7a9b7a;
            --sage-light: #a8c4a0;
            --sage-dark: #4d6b4d;
            --terracotta: #c2784a;
            --sand: #c9aa86;
            --charcoal: #2c2421;
            --charcoal-mid: #4a3f3a;
            --warm-grey: #9e8e84;
            --white: #ffffff;

            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-body: 'Jost', system-ui, sans-serif;

            --ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
            --ease-in-out: cubic-bezier(0.76, 0, 0.24, 1);

            --nav-height: 80px;
            --section-gap: clamp(80px, 10vw, 140px);
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            background-color: var(--cream);
            color: var(--charcoal);
            font-family: var(--font-body);
            font-weight: 300;
            line-height: 1.7;
            overflow-x: hidden;
            cursor: none;
            max-width: 100%;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--rose-light);
            color: var(--charcoal);
        }

        img {
            display: block;
            max-width: 100%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ============================================================
           CUSTOM CURSOR
        ============================================================ */
        #cursor-dot {
            position: fixed;
            top: 0;
            left: 0;
            width: 8px;
            height: 8px;
            background: var(--rose);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s var(--ease-out-expo), opacity 0.3s ease;
            transform: translate(-50%, -50%);
            mix-blend-mode: multiply;
        }

        #cursor-ring {
            position: fixed;
            top: 0;
            left: 0;
            width: 36px;
            height: 36px;
            border: 1.5px solid var(--rose);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: transform 0.35s var(--ease-out-expo),
                width 0.35s var(--ease-out-expo),
                height 0.35s var(--ease-out-expo),
                opacity 0.3s ease;
            opacity: 0.7;
        }

        body.hovering #cursor-ring {
            width: 56px;
            height: 56px;
            opacity: 0.4;
        }

        body.hovering #cursor-dot {
            transform: translate(-50%, -50%) scale(1.6);
        }

        /* ============================================================
           PAGE LOADER
        ============================================================ */
        #page-loader {
            position: fixed;
            inset: 0;
            background: var(--charcoal);
            z-index: 9990;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 24px;
            transition: opacity 0.8s var(--ease-out-expo), transform 1s var(--ease-out-expo);
        }

        #page-loader.hidden {
            opacity: 0;
            pointer-events: none;
            transform: translateY(-4px);
        }

        .loader-wordmark {
            font-family: var(--font-display);
            font-size: clamp(28px, 5vw, 48px);
            font-weight: 300;
            color: var(--cream);
            letter-spacing: 0.25em;
            text-transform: uppercase;
            opacity: 0;
            animation: loaderFadeIn 0.6s 0.2s forwards;
        }

        .loader-bar-wrap {
            width: 120px;
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
            overflow: hidden;
        }

        .loader-bar {
            height: 100%;
            background: var(--rose-light);
            width: 0%;
            animation: loaderBar 1.2s 0.4s var(--ease-out-expo) forwards;
        }

        @keyframes loaderFadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes loaderBar {
            to {
                width: 100%;
            }
        }

        /* ============================================================
           NAVIGATION
        ============================================================ */
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--nav-height);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 clamp(24px, 5vw, 80px);
            justify-content: space-between;
            transition: background 0.5s ease, box-shadow 0.5s ease, backdrop-filter 0.5s ease;
        }

        #navbar.scrolled {
            background: rgba(248, 243, 236, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 rgba(44, 36, 33, 0.08);
        }

        .nav-logo {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--charcoal);
            transition: color 0.3s ease;
        }

        .nav-logo span {
            color: var(--rose);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: clamp(24px, 3vw, 48px);
            list-style: none;
        }

        .nav-links a {
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--charcoal-mid);
            position: relative;
            padding-bottom: 4px;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 1px;
            background: var(--rose);
            transition: width 0.4s var(--ease-out-expo);
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--charcoal);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-cta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--white) !important;
            background: var(--charcoal);
            padding: 10px 22px;
            border-radius: 2px;
            transition: background 0.3s ease, transform 0.2s ease !important;
        }

        .nav-cta::after {
            display: none !important;
        }

        .nav-cta:hover {
            background: var(--rose-deep) !important;
            transform: translateY(-1px);
        }

        .nav-inner {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Hamburger */
        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: none;
            padding: 4px;
            background: none;
            border: none;
        }

        .nav-hamburger span {
            display: block;
            width: 26px;
            height: 1.5px;
            background: var(--charcoal);
            transition: transform 0.4s var(--ease-out-expo), opacity 0.3s ease, width 0.3s ease;
            transform-origin: center;
        }

        .nav-hamburger.open span:nth-child(1) {
            transform: translateY(7.5px) rotate(45deg);
        }

        .nav-hamburger.open span:nth-child(2) {
            opacity: 0;
            width: 0;
        }

        .nav-hamburger.open span:nth-child(3) {
            transform: translateY(-7.5px) rotate(-45deg);
        }

        /* Mobile nav overlay */
        #mobile-nav {
            position: fixed;
            inset: 0;
            background: var(--charcoal);
            z-index: 990;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 40px;
            opacity: 0;
            transform: translateY(-40px);
            pointer-events: none;
            transition:
                opacity 0.5s cubic-bezier(0.19, 1, 0.22, 1),
                transform 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }

        #mobile-nav.open {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0)scale(1);
        }

        #mobile-nav a {
            font-family: var(--font-display);
            font-size: clamp(32px, 7vw, 56px);
            font-weight: 300;
            letter-spacing: 0.08em;
            color: var(--cream);

            opacity: 0;
            transform: translateY(20px);

            transition:
                transform 0.6s cubic-bezier(0.19, 1, 0.22, 1),
                opacity 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }

        #mobile-nav.open a {
            opacity: 1;
            transform: translateY(0);
        }

        #mobile-nav a:hover {
            color: var(--rose-light);
        }

        /* animasi keluar mobile menu saat kembali ke desktop */
        #mobile-nav.closing {
            animation: mobileMenuClose 0.45s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }

        @keyframes mobileMenuClose {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-60px) scale(0.96);
            }
        }

        #mobile-nav.open a:nth-child(1) {
            transition-delay: .1s;
        }

        #mobile-nav.open a:nth-child(2) {
            transition-delay: .18s;
        }

        #mobile-nav.open a:nth-child(3) {
            transition-delay: .26s;
        }

        #mobile-nav.open a:nth-child(4) {
            transition-delay: .34s;
        }

        /* ============================================================
           MAIN CONTENT AREA
        ============================================================ */
        main {
            padding-top: var(--nav-height);
        }

        /* ============================================================
           FOOTER
        ============================================================ */
        footer {
            background: var(--charcoal);
            color: var(--cream);
            padding: clamp(60px, 8vw, 100px) 0 40px;
            /* clamp(24px, 6vw, 100px) 40px; */
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--rose) 30%, var(--sand) 70%, transparent);
        }

        .footer-bg-text {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-family: var(--font-display);
            font-size: clamp(60px, 14vw, 180px);
            font-weight: 700;
            color: rgba(255, 255, 255, 0.03);
            white-space: nowrap;
            pointer-events: none;
            letter-spacing: 0.06em;
            user-select: none;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-brand-name {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 300;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .footer-brand-name span {
            color: var(--rose-light);
        }

        .footer-tagline {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.6);
            max-width: 260px;
            line-height: 1.8;
            margin-bottom: 32px;
        }

        .footer-socials {
            display: flex;
            gap: 16px;
        }

        .footer-social-icon {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(248, 243, 236, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .footer-social-icon:hover {
            border-color: var(--rose-light);
            background: rgba(212, 132, 122, 0.1);
        }

        .footer-social-icon svg {
            width: 15px;
            height: 15px;
            fill: var(--cream);
            opacity: 0.7;
        }

        .footer-col-title {
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.65);
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-links a:hover {
            color: var(--cream);
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .footer-contact-icon {
            width: 16px;
            height: 16px;
            opacity: 0.5;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .footer-contact-text {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.65);
            line-height: 1.6;
        }

        .footer-bottom {
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 12px;
            color: rgba(248, 243, 236, 0.35);
            letter-spacing: 0.05em;
        }

        .footer-made {
            font-size: 12px;
            color: rgba(248, 243, 236, 0.3);
        }

        .footer-made span {
            color: var(--rose);
        }

        /* ============================================================
           SCROLL REVEAL UTILITY
        ============================================================ */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
        }

        .reveal.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
        }

        .reveal-left.in-view {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
        }

        .reveal-right.in-view {
            opacity: 1;
            transform: translateX(0);
        }

        .delay-1 {
            transition-delay: 0.1s;
        }

        .delay-2 {
            transition-delay: 0.2s;
        }

        .delay-3 {
            transition-delay: 0.3s;
        }

        .delay-4 {
            transition-delay: 0.4s;
        }

        .delay-5 {
            transition-delay: 0.5s;
        }

        .delay-6 {
            transition-delay: 0.6s;
        }

        /* ============================================================
           SHARED BUTTON STYLES
        ============================================================ */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--white);
            background: var(--charcoal);
            padding: 15px 36px;
            border-radius: 2px;
            border: none;
            cursor: none;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--rose-deep);
            transform: translateX(-100%);
            transition: transform 0.5s var(--ease-out-expo);
        }

        .btn-primary:hover::before {
            transform: translateX(0);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(44, 36, 33, 0.2);
        }

        .btn-primary span,
        .btn-primary svg {
            position: relative;
            z-index: 1;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--charcoal);
            background: transparent;
            padding: 14px 36px;
            border-radius: 2px;
            border: 1.5px solid var(--charcoal);
            cursor: none;
            transition: background 0.3s ease, color 0.3s ease, transform 0.2s ease;
        }

        .btn-outline:hover {
            background: var(--charcoal);
            color: var(--cream);
            transform: translateY(-2px);
        }

        /* ============================================================
           NOISE TEXTURE OVERLAY
        ============================================================ */
        .noise-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9997;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            background-size: 180px;
        }


        /* ============================================================
           SECTION LABEL UTILITY
        ============================================================ */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 20px;
        }

        .section-label::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--rose);
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding-left: clamp(20px, 5vw, 80px);
            padding-right: clamp(20px, 5vw, 80px);
        }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: flex;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }
        }

        /* @media (min-width: 901px) {
            #mobile-nav {
                display: none !important;
            }
        } */

        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;

                /*matiin cursor*/
                body {
                    cursor: auto;
                }

                #cursor-dot,
                #cursor-ring {
                    display: none;
                }
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            body {
                cursor: auto;
            }

            #cursor-dot,
            #cursor-ring {
                display: none;
            }
        }

        @media (hover: none) {
            body {
                cursor: auto;
            }

            #cursor-dot,
            #cursor-ring {
                display: none;
            }

            body {
                overflow-x: hidden;
            }
        }
    </style>

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
            <div class="footer-grid">
                <div class="reveal">
                    <p class="footer-brand-name">Maw <span>Bouquet</span></p>
                    <p class="footer-tagline">
                        Setiap rangkaian adalah karya seni yang tumbuh dari hati — untuk momen yang tak terlupakan dalam
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
                        <a href="#" class="footer-social-icon" aria-label="TikTok" target="_blank" rel="noopener">
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
            </div>

            <div class="footer-bottom">
                <p class="footer-copy">&copy; {{ date('Y') }} Maw Bouquet. Seluruh hak dilindungi undang-undang.
                </p>
                <p class="footer-made">Dibuat dengan <span>&#9825;</span> untuk setiap momen spesial</p>
            </div>
        </div>
    </footer>

    <script>
        // ================================================================
        //  PAGE LOADER
        // ================================================================
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('page-loader').classList.add('hidden');
            }, 1600);
        });

        // ================================================================
        //  CUSTOM CURSOR
        // ================================================================
        const dot = document.getElementById('cursor-dot');
        const ring = document.getElementById('cursor-ring');
        let mx = 0,
            my = 0,
            rx = 0,
            ry = 0;

        document.addEventListener('mousemove', e => {
            mx = e.clientX;
            my = e.clientY;
            dot.style.left = mx + 'px';
            dot.style.top = my + 'px';
        });

        function animRing() {
            rx += (mx - rx) * 0.12;
            ry += (my - ry) * 0.12;
            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';
            requestAnimationFrame(animRing);
        }
        animRing();

        const hoverTargets = document.querySelectorAll('a, button, [role="button"]');
        hoverTargets.forEach(el => {
            el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
        });

        // ================================================================
        //  NAVBAR SCROLL EFFECT
        // ================================================================
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        }, {
            passive: true
        });

        // ================================================================
        //  HAMBURGER / MOBILE NAV
        // ================================================================
        const hamburger = document.getElementById('hamburger-btn');
        const mobileNav = document.getElementById('mobile-nav');
        const mobileLinks = mobileNav.querySelectorAll('.mobile-nav-link');
        let menuOpen = false;

        function toggleMenu(state) {
            menuOpen = state ?? !menuOpen;
            hamburger.classList.toggle('open', menuOpen);
            mobileNav.classList.toggle('open', menuOpen);
            mobileNav.setAttribute('aria-hidden', !menuOpen);
            hamburger.setAttribute('aria-expanded', menuOpen);
            document.body.style.overflow = menuOpen ? 'hidden' : '';
        }

        hamburger.addEventListener('click', () => toggleMenu());
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => toggleMenu(false));
        });

        // RESET MOBILE MENU JIKA LAYAR BESAR
        window.addEventListener('resize', () => {

            if (window.innerWidth > 900 && menuOpen) {

                mobileNav.classList.add('closing');

                setTimeout(() => {

                    mobileNav.classList.remove('open');
                    mobileNav.classList.remove('closing');

                    hamburger.classList.remove('open');

                    menuOpen = false;
                    document.body.style.overflow = '';

                }, 450);

            }

        });
        window.addEventListener('orientationchange', () => {
            toggleMenu(false);
        });

        // ================================================================
        //  SCROLL REVEAL (IntersectionObserver)
        // ================================================================
        const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealEls.forEach(el => observer.observe(el));

        // Re-observe footer elements specifically
        const footerReveals = document.querySelectorAll('footer .reveal');
        const footerObs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    footerObs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08
        });
        footerReveals.forEach(el => footerObs.observe(el));
    </script>

    @stack('scripts')
</body>

</html>
