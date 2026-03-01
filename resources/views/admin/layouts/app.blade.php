<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | MAW BOUQUET Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F6F1EB',
                        brown: '#3E3A36',
                        accent: '#C6A77D',
                        muted: '#8F877F'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            cursor: none;
        }

        /* Cursor Lingkaran */
        .cursor-ring {
            width: 22px;
            height: 22px;
            border: 1.5px solid #C6A77D;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: transform 0.15s ease-out;
            z-index: 9999;
        }

        /* Titik kecil */
        .cursor-dot {
            width: 6px;
            height: 6px;
            background-color: #3E3A36;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>

<body class="bg-cream text-brown">

<!-- Custom Cursor -->
<div class="cursor-ring"></div>
<div class="cursor-dot"></div>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="hidden md:flex md:w-64 bg-white border-r border-gray-200 flex-col">

        <div class="p-6 border-b">
            <h1 class="text-lg tracking-widest font-semibold text-accent">
                MAW BOUQUET
            </h1>
            <p class="text-xs text-muted mt-1">Admin Dashboard</p>
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="/admin/dashboard"
               class="block px-4 py-2 rounded-lg hover:bg-cream transition">
                Dashboard
            </a>

            <a href="/admin/products"
               class="block px-4 py-2 rounded-lg hover:bg-cream transition">
                Produk
            </a>

        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col">

        <!-- Topbar -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">

            <h2 class="text-xl md:text-2xl font-semibold">
                @yield('header')
            </h2>

            <form method="POST" action="/admin/logout">
                @csrf
                <button type="submit"
                        class="bg-brown text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
                    Logout
                </button>
            </form>
        </div>

        <!-- Content -->
        <div class="p-6 md:p-10 flex-1">
            @yield('content')
        </div>

    </main>

</div>

<!-- Cursor Animation Script -->
<script>
    const ring = document.querySelector('.cursor-ring');
    const dot = document.querySelector('.cursor-dot');

    let mouseX = 0;
    let mouseY = 0;
    let posX = 0;
    let posY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        dot.style.left = mouseX + 'px';
        dot.style.top = mouseY + 'px';
    });

    function animate() {
        posX += (mouseX - posX) * 0.15;
        posY += (mouseY - posY) * 0.15;

        ring.style.left = posX + 'px';
        ring.style.top = posY + 'px';

        requestAnimationFrame(animate);
    }

    animate();

    // Hover effect (lebih professional, tidak terlalu besar)
    document.querySelectorAll('a, button, input, select, textarea').forEach(el => {
        el.addEventListener('mouseenter', () => {
            ring.style.transform = 'translate(-50%, -50%) scale(1.6)';
        });

        el.addEventListener('mouseleave', () => {
            ring.style.transform = 'translate(-50%, -50%) scale(1)';
        });
    });
</script>

</body>
</html>
