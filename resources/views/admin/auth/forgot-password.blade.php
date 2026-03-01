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
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cream: #f8f3ec;
            --ivory: #fdfaf5;
            --rose: #d4847a;
            --rose-light: #e8b5af;
            --rose-deep: #b85c52;
            --sage: #7a9b7a;
            --charcoal: #2c2421;
            --charcoal-m: #4a3f3a;
            --warm-grey: #9e8e84;
            --white: #ffffff;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Jost', system-ui, sans-serif;
            --ease-expo: cubic-bezier(0.19, 1, 0.22, 1);
        }

        html,
        body {
            height: 100%;
            font-family: var(--font-body);
            font-weight: 300;
            background: var(--charcoal);
            color: var(--cream);
            overflow-x: hidden;
        }

        /* Background */
        .fp-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .fp-bg-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.12;
        }

        .fp-bg-grad {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(44, 36, 33, 0.95) 0%,
                    rgba(44, 36, 33, 0.8) 60%,
                    rgba(122, 155, 122, 0.1) 100%);
        }

        .blob-fp {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(90px);
        }

        .blob-fp-1 {
            width: 400px;
            height: 400px;
            background: rgba(122, 155, 122, 0.07);
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
            animation: blobPulse 10s ease-in-out infinite;
        }

        .blob-fp-2 {
            width: 300px;
            height: 300px;
            background: rgba(212, 132, 122, 0.06);
            bottom: -60px;
            right: -60px;
            animation: blobPulse 13s ease-in-out infinite reverse;
        }

        @keyframes blobPulse {

            0%,
            100% {
                transform: scale(1) translateX(-50%);
            }

            50% {
                transform: scale(1.1) translateX(-48%);
            }
        }

        /* Layout */
        .fp-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        /* Brand */
        .fp-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 48px;
            opacity: 0;
            animation: fadeUpIn 0.7s 0.2s var(--ease-expo) forwards;
        }

        @keyframes fadeUpIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fp-brand-mark {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(212, 132, 122, 0.35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 500;
            color: var(--rose-light);
        }

        .fp-brand-name {
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 300;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(248, 243, 236, 0.7);
        }

        /* Card */
        .fp-card {
            width: 100%;
            max-width: 460px;
            background: rgba(248, 243, 236, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(248, 243, 236, 0.1);
            border-radius: 6px;
            padding: clamp(32px, 5vw, 52px);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 0.8s 0.35s var(--ease-expo) forwards;
        }

        /* Icon illustration */
        .fp-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(212, 132, 122, 0.1);
            border: 1px solid rgba(212, 132, 122, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            animation: iconFloat 4s ease-in-out infinite;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .fp-icon-wrap svg {
            width: 30px;
            height: 30px;
            stroke: var(--rose-light);
            fill: none;
        }

        /* Step indicators */
        .fp-steps {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 32px;
        }

        .fp-step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: rgba(248, 243, 236, 0.3);
            transition: color 0.4s ease;
        }

        .fp-step.active {
            color: var(--rose-light);
        }

        .fp-step.done {
            color: var(--sage);
        }

        .fp-step-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 1px solid currentColor;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            flex-shrink: 0;
            transition: background 0.3s ease;
        }

        .fp-step.active .fp-step-num {
            background: rgba(212, 132, 122, 0.15);
        }

        .fp-step-sep {
            width: 20px;
            height: 1px;
            background: rgba(248, 243, 236, 0.1);
        }

        /* Heading */
        .fp-title {
            font-family: var(--font-display);
            font-size: clamp(26px, 3vw, 38px);
            font-weight: 300;
            color: var(--cream);
            text-align: center;
            margin-bottom: 12px;
            line-height: 1.1;
        }

        .fp-title em {
            font-style: italic;
            color: var(--rose-light);
        }

        .fp-subtitle {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.5);
            text-align: center;
            margin-bottom: 36px;
            line-height: 1.7;
        }

        /* Form */
        .fp-form {}

        .fp-field {
            margin-bottom: 20px;
        }

        .fp-lbl {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: rgba(248, 243, 236, 0.6);
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .fp-field:focus-within .fp-lbl {
            color: var(--rose-light);
        }

        .fp-inp {
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

        .fp-inp::placeholder {
            color: rgba(248, 243, 236, 0.25);
        }

        .fp-inp:focus {
            border-color: var(--rose);
            background: rgba(212, 132, 122, 0.06);
            box-shadow: 0 0 0 3px rgba(212, 132, 122, 0.12);
        }

        .fp-inp:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 100px #3a2f2b inset;
            -webkit-text-fill-color: var(--cream);
        }

        /* Info tip */
        .fp-tip {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 16px;
            background: rgba(122, 155, 122, 0.07);
            border-left: 2px solid rgba(122, 155, 122, 0.4);
            border-radius: 2px;
            margin-bottom: 24px;
            font-size: 13px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.55);
            line-height: 1.65;
        }

        .fp-tip svg {
            width: 15px;
            height: 15px;
            stroke: var(--sage);
            fill: none;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Submit button */
        .fp-submit {
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
            margin-bottom: 20px;
        }

        .fp-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--rose-deep);
            transform: translateY(100%);
            transition: transform 0.5s var(--ease-expo);
        }

        .fp-submit:hover::before {
            transform: translateY(0);
        }

        .fp-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(212, 132, 122, 0.3);
        }

        .fp-submit span,
        .fp-submit svg {
            position: relative;
            z-index: 1;
        }

        .fp-submit svg {
            width: 15px;
            height: 15px;
            stroke: white;
            fill: none;
        }

        .fp-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .fp-submit:disabled::before {
            display: none;
        }

        /* Back link */
        .fp-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 400;
            color: rgba(248, 243, 236, 0.45);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .fp-back:hover {
            color: rgba(248, 243, 236, 0.8);
        }

        .fp-back svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        /* ── SUCCESS STATE ─── */
        .fp-success {
            text-align: center;
            display: none;
        }

        .fp-success.show {
            display: block;
        }

        .success-check {
            width: 72px;
            height: 72px;
            background: rgba(122, 155, 122, 0.1);
            border: 1px solid rgba(122, 155, 122, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: checkPulse 0.6s var(--ease-expo);
        }

        @keyframes checkPulse {
            from {
                transform: scale(0.6);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-check svg {
            width: 28px;
            height: 28px;
            stroke: var(--sage);
            fill: none;
        }

        .fp-success-title {
            font-family: var(--font-display);
            font-size: 32px;
            font-weight: 400;
            color: var(--cream);
            margin-bottom: 12px;
        }

        .fp-success-desc {
            font-size: 14px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.55);
            line-height: 1.75;
            margin-bottom: 32px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Alert error */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(184, 92, 82, 0.12);
            border: 1px solid rgba(184, 92, 82, 0.25);
            border-radius: 3px;
            font-size: 13px;
            font-weight: 300;
            color: var(--rose-light);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-error svg {
            width: 15px;
            height: 15px;
            stroke: var(--rose-light);
            fill: none;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Alert success */
        .alert-success {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(122, 155, 122, 0.1);
            border: 1px solid rgba(122, 155, 122, 0.25);
            border-radius: 3px;
            font-size: 13px;
            font-weight: 300;
            color: rgba(168, 196, 160, 0.9);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-success svg {
            width: 15px;
            height: 15px;
            stroke: var(--sage);
            fill: none;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Resend timer */
        .resend-section {
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
            color: rgba(248, 243, 236, 0.4);
        }

        .resend-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            color: var(--rose-light);
            font-family: var(--font-body);
            text-decoration: underline;
            text-underline-offset: 3px;
            transition: color 0.3s ease;
        }

        .resend-btn:hover {
            color: var(--rose);
        }

        .resend-btn:disabled {
            color: rgba(248, 243, 236, 0.25);
            cursor: not-allowed;
            text-decoration: none;
        }

        /* Footer */
        .fp-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: rgba(248, 243, 236, 0.2);
            opacity: 0;
            animation: fadeUpIn 0.6s 0.7s var(--ease-expo) forwards;
        }

        @media (max-width: 520px) {
            .fp-card {
                padding: 28px 24px;
            }

            .fp-steps {
                display: none;
            }
        }
    </style>
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

            {{-- Step indicator --}}
            <div class="fp-steps" aria-label="Langkah reset password">
                <div class="fp-step active" aria-current="step">
                    <span class="fp-step-num">1</span>
                    <span>Email</span>
                </div>
                <div class="fp-step-sep" aria-hidden="true"></div>
                <div class="fp-step">
                    <span class="fp-step-num">2</span>
                    <span>Reset Password</span>
                </div>
            </div>

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
                            placeholder="admin@mawbouquet.id" value="{{ old('email') }}" required
                            autocomplete="email" autofocus aria-required="true" />
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
    const timerEl = document.getElementById(timerId);
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
