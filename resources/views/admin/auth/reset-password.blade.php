<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | Admin Maw Bouquet</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <style>
        *{margin:0;padding:0;box-sizing:border-box}

        :root{
            --cream:#f8f3ec;
            --rose:#d4847a;
            --rose-light:#e8b5af;
            --rose-deep:#b85c52;
            --sage:#7a9b7a;
            --charcoal:#2c2421;
            --white:#ffffff;
            --font-display:'Cormorant Garamond',serif;
            --font-body:'Jost',sans-serif;
            --ease:cubic-bezier(.19,1,.22,1);
        }

        body{
            font-family:var(--font-body);
            background:var(--charcoal);
            color:var(--cream);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }

        /* Background */
        .bg{
            position:fixed;
            inset:0;
            z-index:0;
        }

        .bg::after{
            content:'';
            position:absolute;
            inset:0;
            background:linear-gradient(135deg,
                rgba(44,36,33,.95) 0%,
                rgba(44,36,33,.85) 60%,
                rgba(122,155,122,.1) 100%);
        }

        .blob{
            position:absolute;
            border-radius:50%;
            filter:blur(90px);
            animation:blob 12s ease-in-out infinite;
        }

        .blob.one{
            width:400px;height:400px;
            background:rgba(122,155,122,.08);
            top:-100px;left:50%;
            transform:translateX(-50%);
        }

        .blob.two{
            width:320px;height:320px;
            background:rgba(212,132,122,.08);
            bottom:-80px;right:-60px;
            animation-direction:reverse;
        }

        @keyframes blob{
            0%,100%{transform:scale(1) translateX(-50%)}
            50%{transform:scale(1.1) translateX(-48%)}
        }

        .wrapper{
            position:relative;
            z-index:1;
            width:100%;
            max-width:460px;
            padding:40px;
            background:rgba(255,255,255,.05);
            backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,.1);
            border-radius:8px;
            animation:fadeUp .8s var(--ease);
        }

        @keyframes fadeUp{
            from{opacity:0;transform:translateY(20px)}
            to{opacity:1;transform:translateY(0)}
        }

        /* Icon floating */
        .icon-wrap{
            width:72px;height:72px;
            border-radius:50%;
            background:rgba(212,132,122,.1);
            border:1px solid rgba(212,132,122,.2);
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 28px;
            animation:float 4s ease-in-out infinite;
        }

        @keyframes float{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-6px)}
        }

        .icon-wrap svg{
            width:30px;height:30px;
            stroke:var(--rose-light);
            fill:none;
        }

        /* Steps */
        .steps{
            display:flex;
            justify-content:center;
            gap:10px;
            font-size:11px;
            letter-spacing:.08em;
            margin-bottom:28px;
        }

        .step{
            display:flex;
            align-items:center;
            gap:6px;
            opacity:.3;
        }

        .step.done{opacity:1;color:var(--sage)}
        .step.active{opacity:1;color:var(--rose-light)}

        .step-num{
            width:22px;height:22px;
            border-radius:50%;
            border:1px solid currentColor;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:10px;
        }

        /* Title */
        .title{
            font-family:var(--font-display);
            font-size:36px;
            text-align:center;
            font-weight:300;
            margin-bottom:10px;
        }

        .title em{
            font-style:italic;
            color:var(--rose-light);
        }

        .subtitle{
            text-align:center;
            font-size:14px;
            opacity:.55;
            margin-bottom:32px;
            line-height:1.7;
        }

        input{
            width:100%;
            padding:14px 16px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.15);
            border-radius:3px;
            margin-bottom:18px;
            color:var(--cream);
        }

        input::placeholder{
            color:rgba(255,255,255,.3);
        }

        input:focus{
            outline:none;
            border-color:var(--rose);
            box-shadow:0 0 0 3px rgba(212,132,122,.15);
        }

        button{
            width:100%;
            padding:15px;
            background:var(--rose);
            border:none;
            border-radius:3px;
            color:white;
            text-transform:uppercase;
            letter-spacing:.2em;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        button:hover{
            background:var(--rose-deep);
            transform:translateY(-1px);
        }

        .error,.success{
            padding:12px 16px;
            margin-bottom:20px;
            border-radius:3px;
            font-size:13px;
        }

        .error{
            background:rgba(184,92,82,.15);
            border:1px solid rgba(184,92,82,.3);
        }

        .success{
            background:rgba(122,155,122,.15);
            border:1px solid rgba(122,155,122,.3);
        }

        .back{
            display:block;
            text-align:center;
            margin-top:20px;
            font-size:13px;
            color:rgba(255,255,255,.5);
            text-decoration:none;
        }

        .back:hover{color:white}
    </style>
</head>

<body>

<div class="bg">
    <div class="blob one"></div>
    <div class="blob two"></div>
</div>

<div class="wrapper">

    <div class="icon-wrap">
        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 15v2m0-8a3 3 0 00-3 3v1h6v-1a3 3 0 00-3-3z"/>
            <rect x="4" y="11" width="16" height="10" rx="2"/>
        </svg>
    </div>

    <h1 class="title">
        Reset <em>Password</em>?
    </h1>

    <p class="subtitle">
        Buat password baru yang kuat dan mudah Anda ingat.
    </p>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/admin/reset-password') }}">
        @csrf
        <input type="hidden" name="oobCode" value="{{ $oobCode }}">

        <input type="password" name="password" placeholder="Masukkan password baru" required minlength="6">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" required minlength="6">

        <button type="submit">Simpan Password</button>
    </form>

    <a href="{{ url('/admin/login') }}" class="back">
        ← Kembali ke login
    </a>

</div>

</body>
</html>
