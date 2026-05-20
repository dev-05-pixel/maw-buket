<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | Admin Maw Bouquet</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,400&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/admin/auth/reset-password.css') }}" />
</head>

<body>

    <div class="bg">
        <div class="blob one"></div>
        <div class="blob two"></div>
    </div>

    <div class="wrapper">

        <div class="icon-wrap">
            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15v2m0-8a3 3 0 00-3 3v1h6v-1a3 3 0 00-3-3z" />
                <rect x="4" y="11" width="16" height="10" rx="2" />
            </svg>
        </div>

        <h1 class="title">
            Reset <em>Password</em>?
        </h1>

        <p class="subtitle">
            Buat password baru yang kuat dan mudah Anda ingat.
        </p>

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/admin/reset-password') }}">
            @csrf
            <input type="hidden" name="oobCode" value="{{ $oobCode }}">

            <input type="password" name="password" placeholder="Masukkan password baru" required minlength="6">

            <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" required
                minlength="6">

            <button type="submit">Simpan Password</button>
        </form>

        <a href="{{ url('/admin/login') }}" class="back">
            ← Kembali ke login
        </a>
    </div>
</body>
</html>
