<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login | Maw Bouquet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --cream:       #f8f3ec;
            --ivory:       #fdfaf5;
            --rose:        #d4847a;
            --rose-light:  #e8b5af;
            --rose-deep:   #b85c52;
            --sage:        #7a9b7a;
            --charcoal:    #2c2421;
            --charcoal-m:  #4a3f3a;
            --warm-grey:   #9e8e84;
            --white:       #ffffff;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body:    'Jost', system-ui, sans-serif;
            --ease-expo:    cubic-bezier(0.19, 1, 0.22, 1);
        }

        html, body {
            height: 100%;
            font-family: var(--font-body);
            font-weight: 300;
            background: var(--charcoal);
            color: var(--cream);
            overflow-x: hidden;
        }

        /* ── BACKGROUND ─────────────────────────── */
        .login-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .login-bg-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.18;
            transform: scale(1.05);
            animation: bgKen 20s ease-in-out infinite alternate;
        }

        @keyframes bgKen {
            from { transform: scale(1.05); }
            to   { transform: scale(1.12) translateX(-2%); }
        }

        .login-bg-grad {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(44, 36, 33, 0.92) 0%,
                rgba(44, 36, 33, 0.7) 50%,
                rgba(184, 92, 82, 0.15) 100%
            );
        }

        /* Floating blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(80px);
        }

        .blob-1 {
            width: 500px; height: 500px;
            background: rgba(212, 132, 122, 0.1);
            top: -150px; right: -100px;
            animation: blobFloat 12s ease-in-out infinite;
        }

        .blob-2 {
            width: 350px; height: 350px;
            background: rgba(122, 155, 122, 0.07);
            bottom: -80px; left: -80px;
            animation: blobFloat 15s ease-in-out infinite reverse;
        }

        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(20px, -20px) scale(1.05); }
            66%       { transform: translate(-15px, 10px) scale(0.97); }
        }

        /* ── LAYOUT ─────────────────────────────── */
        .login-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 460px;
        }

        /* Left decorative panel */
        .login-panel-left {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(40px, 6vw, 80px);
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .login-brand-mark {
            width: 42px;
            height: 42px;
            border: 1px solid rgba(212, 132, 122, 0.4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 500;
            color: var(--rose-light);
        }

        .login-brand-name {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 300;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--cream);
        }

        .login-panel-hero {
            padding-bottom: 40px;
        }

        .login-panel-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeUp 0.7s 0.5s var(--ease-expo) forwards;
        }

        .login-panel-eyebrow::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--rose-light);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-panel-title {
            font-family: var(--font-display);
            font-size: clamp(48px, 6vw, 84px);
            font-weight: 300;
            line-height: 0.95;
            color: var(--cream);
            overflow: hidden;
        }

        .login-panel-title-line {
            display: block;
            overflow: hidden;
        }

        .login-panel-title-inner {
            display: block;
            transform: translateY(110%);
            animation: lineReveal 0.9s var(--ease-expo) forwards;
        }

        .login-panel-title-line:nth-child(1) .login-panel-title-inner { animation-delay: 0.3s; }
        .login-panel-title-line:nth-child(2) .login-panel-title-inner { animation-delay: 0.45s; }
        .login-panel-title-line:nth-child(3) .login-panel-title-inner { animation-delay: 0.6s; }

        @keyframes lineReveal {
            to { transform: translateY(0); }
        }

        .login-panel-title em {
            font-style: italic;
            color: var(--rose-light);
        }

        .login-panel-desc {
            font-size: 15px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.5);
            max-width: 360px;
            line-height: 1.85;
            margin-top: 24px;
            opacity: 0;
            animation: fadeUp 0.8s 0.8s var(--ease-expo) forwards;
        }

        .login-panel-footer {
            font-size: 12px;
            color: rgba(248, 243, 236, 0.25);
            opacity: 0;
            animation: fadeUp 0.6s 1s var(--ease-expo) forwards;
        }

        /* ── FORM PANEL ─────────────────────────── */
        .login-panel-right {
            background: rgba(253, 250, 245, 0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-left: 1px solid rgba(248, 243, 236, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            opacity: 0;
            transform: translateX(20px);
            animation: panelSlide 0.9s 0.4s var(--ease-expo) forwards;
        }

        @keyframes panelSlide {
            to { opacity: 1; transform: translateX(0); }
        }

        .login-form-wrap {
            width: 100%;
            max-width: 360px;
        }

        .login-form-title {
            font-family: var(--font-display);
            font-size: 32px;
            font-weight: 400;
            color: var(--cream);
            margin-bottom: 8px;
        }

        .login-form-subtitle {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.5);
            margin-bottom: 40px;
        }

        /* Form elements */
        .form-field {
            margin-bottom: 22px;
            position: relative;
        }

        .form-lbl {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(248, 243, 236, 0.6);
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .form-field:focus-within .form-lbl {
            color: var(--rose-light);
        }

        .form-inp {
            width: 100%;
            padding: 14px 18px;
            background: rgba(248, 243, 236, 0.06);
            border: 1px solid rgba(248, 243, 236, 0.12);
            border-radius: 3px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--cream);
            outline: none;
            transition: border-color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
            -webkit-appearance: none;
        }

        .form-inp::placeholder {
            color: rgba(248, 243, 236, 0.25);
        }

        .form-inp:focus {
            border-color: var(--rose);
            background: rgba(212, 132, 122, 0.06);
            box-shadow: 0 0 0 3px rgba(212, 132, 122, 0.12);
        }

        .form-inp:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 100px #3a2f2b inset;
            -webkit-text-fill-color: var(--cream);
        }

        /* Password reveal button */
        .pass-wrap {
            position: relative;
        }

        .pass-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(248, 243, 236, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .pass-toggle:hover { color: var(--rose-light); }

        .pass-toggle svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        /* Remember / forgot row */
        .form-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-check input {
            width: 16px;
            height: 16px;
            appearance: none;
            -webkit-appearance: none;
            border: 1px solid rgba(248, 243, 236, 0.2);
            border-radius: 2px;
            cursor: pointer;
            position: relative;
            background: transparent;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .remember-check input:checked {
            background: var(--rose);
            border-color: var(--rose);
        }

        .remember-check input:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 9px;
            border: 1.5px solid white;
            border-left: none;
            border-top: none;
            transform: rotate(45deg);
        }

        .remember-label {
            font-size: 13px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.55);
        }

        .forgot-link {
            font-size: 12px;
            font-weight: 500;
            color: rgba(212, 132, 122, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            letter-spacing: 0.05em;
        }

        .forgot-link:hover { color: var(--rose-light); }

        /* Submit */
        .login-submit {
            width: 100%;
            padding: 16px 24px;
            background: var(--rose);
            border: none;
            border-radius: 3px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--white);
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--rose-deep);
            transform: translateY(100%);
            transition: transform 0.5s var(--ease-expo);
        }

        .login-submit:hover::before {
            transform: translateY(0);
        }

        .login-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(212, 132, 122, 0.35);
        }

        .login-submit span,
        .login-submit svg {
            position: relative;
            z-index: 1;
        }

        .login-submit svg {
            width: 15px;
            height: 15px;
            stroke: white;
            fill: none;
            transition: transform 0.3s ease;
        }

        .login-submit:hover svg {
            transform: translateX(4px);
        }

        /* Error message */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(184, 92, 82, 0.12);
            border: 1px solid rgba(184, 92, 82, 0.25);
            border-radius: 3px;
            font-size: 13px;
            font-weight: 300;
            color: var(--rose-light);
            margin-bottom: 24px;
        }

        .alert-error svg {
            width: 15px;
            height: 15px;
            stroke: var(--rose-light);
            fill: none;
            flex-shrink: 0;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(248, 243, 236, 0.1);
        }

        .divider span {
            font-size: 11px;
            color: rgba(248, 243, 236, 0.3);
            letter-spacing: 0.1em;
            white-space: nowrap;
        }

        .back-to-site {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.1em;
            color: rgba(248, 243, 236, 0.45);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-to-site:hover { color: var(--cream); }

        .back-to-site svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
        }

        /* Security badge */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 24px;
            font-size: 11px;
            color: rgba(248, 243, 236, 0.3);
        }

        .security-note svg {
            width: 12px;
            height: 12px;
            stroke: rgba(122, 155, 122, 0.6);
            fill: none;
        }

        /* ── RESPONSIVE ─────────────────────────── */
        @media (max-width: 900px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }
            .login-panel-left {
                display: none;
            }
            .login-panel-right {
                border-left: none;
                min-height: 100vh;
                padding: 40px 32px;
            }
        }

        @media (max-width: 480px) {
            .login-panel-right { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="login-bg" aria-hidden="true">
    <img
        src="https://picsum.photos/seed/admin-bg/1600/1000"
        alt=""
        class="login-bg-img"
    />
    <div class="login-bg-grad"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
</div>

<div class="login-wrapper">

    {{-- Left decorative --}}
    <div class="login-panel-left">
        <a href="{{ url('/') }}" class="login-brand" aria-label="Kembali ke beranda Maw Bouquet">
            <span class="login-brand-mark" aria-hidden="true">M</span>
            <span class="login-brand-name">Maw Bouquet</span>
        </a>

        <div class="login-panel-hero">
            <p class="login-panel-eyebrow">Area Admin</p>
            <h1 class="login-panel-title">
                <span class="login-panel-title-line">
                    <span class="login-panel-title-inner">Kelola</span>
                </span>
                <span class="login-panel-title-line">
                    <span class="login-panel-title-inner">Toko <em>dengan</em></span>
                </span>
                <span class="login-panel-title-line">
                    <span class="login-panel-title-inner"><em>Mudah</em></span>
                </span>
            </h1>
            <p class="login-panel-desc">
                Panel admin Maw Bouquet — tempat Anda mengelola produk, kategori, dan seluruh konten toko bunga Anda dalam satu dasbor yang intuitif.
            </p>
        </div>

        <p class="login-panel-footer">&copy; {{ date('Y') }} Maw Bouquet. Akses terbatas untuk administrator.</p>
    </div>

    {{-- Right form panel --}}
    <aside class="login-panel-right" aria-label="Form login administrator">
        <div class="login-form-wrap">

            <h2 class="login-form-title">Selamat Datang</h2>
            <p class="login-form-subtitle">Masuk ke panel admin Anda</p>

            {{-- Error flash --}}
            @if (session('error') || $errors->any())
            <div class="alert-error" role="alert">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') ?? 'Email atau password tidak valid. Silakan coba lagi.' }}
            </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}" aria-label="Form login">
                @csrf

                <div class="form-field">
                    <label class="form-lbl" for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-inp"
                        placeholder="admin@mawbouquet.id"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        aria-required="true"
                        aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                    />
                    @error('email')
                    <p id="email-error" style="font-size:12px;color:var(--rose-light);margin-top:6px;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-lbl" for="password">Password</label>
                    <div class="pass-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-inp"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                            aria-required="true"
                            style="padding-right: 46px;"
                        />
                        <button type="button" class="pass-toggle" id="toggle-pass" aria-label="Tampilkan password" aria-pressed="false">
                            <svg id="eye-icon" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p style="font-size:12px;color:var(--rose-light);margin-top:6px;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-meta-row">
                    <label class="remember-check" for="remember">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
                        <span class="remember-label">Ingat saya</span>
                    </label>
                    <a href="{{ url('/admin/forgot-password') }}" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="login-submit">
                    <span>Masuk ke Dashboard</span>
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="divider"><span>atau</span></div>

            <a href="{{ url('/') }}" class="back-to-site">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali ke Website Utama
            </a>

            <div class="security-note" aria-label="Koneksi aman">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                Koneksi aman &amp; terenkripsi
            </div>
        </div>
    </aside>
</div>

<script>
// Password reveal toggle
const passInput = document.getElementById('password');
const toggleBtn = document.getElementById('toggle-pass');
const eyeIcon   = document.getElementById('eye-icon');

const eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
const eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

let showing = false;
toggleBtn.addEventListener('click', () => {
    showing = !showing;
    passInput.type = showing ? 'text' : 'password';
    eyeIcon.innerHTML = showing ? eyeClosed : eyeOpen;
    toggleBtn.setAttribute('aria-pressed', showing);
    toggleBtn.setAttribute('aria-label', showing ? 'Sembunyikan password' : 'Tampilkan password');
});
</script>

</body>
</html>
