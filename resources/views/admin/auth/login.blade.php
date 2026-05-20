<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login | Maw Bouquet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin/auth/login.css') }}" />
</head>

<body>

    <div class="login-bg" aria-hidden="true">
        <img src="https://picsum.photos/seed/admin-bg/1600/1000" alt="" class="login-bg-img" />
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
                    Panel admin Maw Bouquet — tempat Anda mengelola produk, kategori, dan seluruh konten toko bunga Anda
                    dalam satu dasbor yang intuitif.
                </p>
            </div>

            <p class="login-panel-footer">&copy; {{ date('Y') }} Maw Bouquet. Akses terbatas untuk administrator.
            </p>
        </div>

        {{-- Right form panel --}}
        <aside class="login-panel-right" aria-label="Form login administrator">
            <div class="login-form-wrap">

                <h2 class="login-form-title">Selamat Datang</h2>
                <p class="login-form-subtitle">Masuk ke panel admin Anda</p>

                {{-- Error flash --}}
                @if (session('error') || $errors->any())
                    <div class="alert-error" role="alert">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ session('error') ?? 'Email atau password tidak valid. Silakan coba lagi.' }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/admin/login') }}" aria-label="Form login">
                    @csrf

                    <div class="form-field">
                        <label class="form-lbl" for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-inp"
                            placeholder="admin@mawbouquet.id" value="{{ old('email') }}" required autocomplete="email"
                            autofocus aria-required="true"
                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}" />
                        @error('email')
                            <p id="email-error" style="font-size:12px;color:var(--rose-light);margin-top:6px;"
                                role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label class="form-lbl" for="password">Password</label>
                        <div class="pass-wrap">
                            <input type="password" id="password" name="password" class="form-inp"
                                placeholder="Masukkan password Anda" required autocomplete="current-password"
                                aria-required="true" style="padding-right: 46px;" />
                            <button type="button" class="pass-toggle" id="toggle-pass" aria-label="Tampilkan password"
                                aria-pressed="false">
                                <svg id="eye-icon" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" aria-hidden="true">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p style="font-size:12px;color:var(--rose-light);margin-top:6px;" role="alert">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-meta-row">
                        <label class="remember-check" for="remember">
                            <input type="checkbox" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }} />
                            <span class="remember-label">Ingat saya</span>
                        </label>
                        <a href="{{ url('/admin/forgot-password') }}" class="forgot-link">Lupa password?</a>
                    </div>

                    <button type="submit" class="login-submit">
                        <span>Masuk ke Dashboard</span>
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>

                <div class="divider"><span>atau</span></div>

                <a href="{{ url('/') }}" class="back-to-site">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Kembali ke Website Utama
                </a>

                <div class="security-note" aria-label="Koneksi aman">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0110 0v4" />
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
        const eyeIcon = document.getElementById('eye-icon');

        const eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        const eyeClosed =
            `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

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
