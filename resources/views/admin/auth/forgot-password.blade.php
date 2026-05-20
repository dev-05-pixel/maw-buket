<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password | Admin Maw Bouquet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin/auth/forgot-password.css') }}" />
</head>

<body>

    <div class="fp-bg" aria-hidden="true">
        <img src="https://picsum.photos/seed/fp-bg/1400/900" alt="" class="fp-bg-img" />
        <div class="fp-bg-grad"></div>
        <div class="blob-fp blob-fp-1"></div>
        <div class="blob-fp blob-fp-2"></div>
    </div>

    <div class="fp-wrapper">

        <a href="{{ url('/admin/login') }}" class="fp-brand" aria-label="Kembali ke login">
            <span class="fp-brand-mark" aria-hidden="true">M</span>
            <span class="fp-brand-name">Maw Bouquet</span>
        </a>

        <div class="fp-card" role="main">

            {{-- Icon --}}
            <div class="fp-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    aria-hidden="true">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
            </div>

            {{-- FORM STATE --}}
            <div id="fp-form-state">
                <h1 class="fp-title">
                    Lupa <em>Password</em>?
                </h1>
                <p class="fp-subtitle">
                    Tidak perlu khawatir. Masukkan alamat email administrator Anda dan kami akan mengirimkan tautan
                    untuk mereset password.
                </p>

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="alert-success" role="alert">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div class="alert-error" role="alert">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ session('error') ?? 'Email tidak ditemukan dalam sistem kami.' }}
                    </div>
                @endif

                <div class="fp-tip" role="note">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    Tautan reset akan dikirim ke email yang terdaftar. Periksa juga folder spam jika email tidak muncul
                    dalam 5 menit.
                </div>

                <form method="POST" action="{{ url('/admin/forgot-password') }}" id="fp-form"
                    aria-label="Form reset password">
                    @csrf

                    <div class="fp-field">
                        <label class="fp-lbl" for="fp-email">Alamat Email</label>
                        <input type="email" id="fp-email" name="email" class="fp-inp"
                            placeholder="admin@mawbouquet.id" value="{{ old('email') }}" required autocomplete="email"
                            autofocus aria-required="true" />
                        @error('email')
                            <p style="font-size:12px;color:var(--rose-light);margin-top:6px;" role="alert">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="fp-submit" id="fp-submit-btn">
                        <span>Kirim Tautan Reset</span>
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            aria-hidden="true">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </button>
                </form>

                <div class="resend-section" id="resend-section" style="display:none;" aria-live="polite">
                    Belum menerima email?
                    <button class="resend-btn" id="resend-btn" disabled>
                        Kirim ulang (<span id="resend-timer">60</span>s)
                    </button>
                </div>

                <a href="{{ url('/admin/login') }}" class="fp-back">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        aria-hidden="true">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Kembali ke halaman login
                </a>
            </div>

            {{-- SUCCESS STATE (shown via JS after form submit) --}}
            <div class="fp-success" id="fp-success-state" aria-live="polite" role="status">
                <div class="success-check" aria-hidden="true">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>

                <p class="fp-success-title">Email Terkirim!</p>
                <p class="fp-success-desc">
                    Kami telah mengirimkan tautan reset password ke <strong id="sent-email"
                        style="color:var(--cream);">—</strong>. Tautan berlaku selama 60 menit.
                </p>

                <div class="resend-section" style="display:block; margin-bottom: 24px;" aria-live="polite">
                    Tidak menerima email?
                    <button class="resend-btn" id="resend-btn-2" disabled>
                        Kirim ulang (<span id="resend-timer-2">60</span>s)
                    </button>
                </div>

                <a href="{{ url('/admin/login') }}" class="fp-back" style="justify-content:center;">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        aria-hidden="true">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Kembali ke login
                </a>
            </div>

        </div>

        <p class="fp-footer">
            &copy; {{ date('Y') }} Maw Bouquet &mdash; Panel Administrator
        </p>
    </div>

    <script>
        // ================================================================
        //  FORM SUBMIT (demo behavior — replace with real backend)
        // ================================================================
        const fpForm = document.getElementById('fp-form');
        const fpSubmit = document.getElementById('fp-submit-btn');
        const fpEmail = document.getElementById('fp-email');
        const formState = document.getElementById('fp-form-state');
        const successState = document.getElementById('fp-success-state');
        const sentEmailEl = document.getElementById('sent-email');

        // Check if Filament already handled a success (session based)
        @if (session('success'))
            <
            script >
                showSuccess('{{ session('email') }}');
    </script>
    @endif

    if (fpForm) {
    fpForm.addEventListener('submit', function(e) {
    const emailVal = fpEmail.value.trim();
    if (!emailVal || !emailVal.includes('@')) return;

    fpSubmit.disabled = true;
    fpSubmit.innerHTML = '<span>Mengirim...</span>';

    // Show resend section after form submits
    // (for demo only — real behavior handled server-side)
    document.getElementById('resend-section').style.display = 'block';
    startTimer('resend-timer', 'resend-btn');
    });
    }

    function showSuccess(email) {
    if (formState) formState.style.display = 'none';
    successState.classList.add('show');
    if (sentEmailEl && email) sentEmailEl.textContent = email;
    startTimer('resend-timer-2', 'resend-btn-2');
    }

    function startTimer(timerId, btnId) {
    let secs = 60;
    const timerEl = document.getElementById(timerId)
    const btnEl = document.getElementById(btnId);
    if (!timerEl || !btnEl) return;

    const interval = setInterval(() => {
    secs--;
    timerEl.textContent = secs;
    if (secs <= 0) { clearInterval(interval); btnEl.textContent = 'Kirim ulang email'; btnEl.disabled=false; } },
        1000); btnEl.addEventListener('click', function() { this.disabled=true; secs=60; timerEl.textContent=secs; //
        Re-trigger form submission or AJAX if (fpForm) fpForm.submit(); }, { once: true }); } </script>

</body>

</html>
