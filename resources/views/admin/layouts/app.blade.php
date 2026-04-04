<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Maw Bouquet Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F7F3EE',
                        'cream-d': '#EDE6DC',
                        canvas: '#FDFAF6',
                        brown: '#2C2421',
                        'brown-m': '#4A3F3A',
                        rose: '#D4847A',
                        'rose-l': '#E8B5AF',
                        'rose-d': '#B85C52',
                        sand: '#C9AA86',
                        muted: '#9E8E84',
                        sage: '#7A9B7A',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'system-ui', 'sans-serif'],
                        display: ['DM Serif Display', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            cursor: none;
        }

        /* Cursor */
        .cur-ring {
            width: 28px;
            height: 28px;
            border: 1.5px solid #D4847A;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: width .3s, height .3s, opacity .3s;
            z-index: 9999;
            opacity: .7;
        }

        .cur-dot {
            width: 6px;
            height: 6px;
            background: #D4847A;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 9999;
            mix-blend-mode: multiply;
        }

        body.cur-hover .cur-ring {
            width: 44px;
            height: 44px;
            opacity: .4;
        }

        /* Sidebar nav active */
        .nav-link {
            position: relative;
            transition: all .2s;
        }

        .nav-link.active {
            background: #F7F3EE;
            color: #2C2421;
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: #D4847A;
            border-radius: 0 2px 2px 0;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #C9AA86;
            border-radius: 10px;
        }

        /* ─── Height sync: sidebar brand = topbar (73px) ─── */
        .sidebar-brand,
        .topbar {
            height: 73px;
            flex-shrink: 0;
        }

        /* ─── Modal — fixed, center of viewport ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9000;
            background: rgba(44, 36, 33, .5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: none;
            /* hidden by default */
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(44, 36, 33, .2);
            width: 100%;
            max-width: 420px;
            animation: modalIn .3s cubic-bezier(.19, 1, .22, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.94) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Toast */
        #toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            transform: translateY(80px);
            opacity: 0;
            transition: all .4s cubic-bezier(.19, 1, .22, 1);
            z-index: 9990;
        }

        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Page fade */
        .page-enter {
            animation: pageIn .45s ease forwards;
        }

        @keyframes pageIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile sidebar */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(44, 36, 33, .5);
            z-index: 40;
            backdrop-filter: blur(2px);
        }

        #sidebar-overlay.show {
            display: block;
        }

        #sidebar.open {
            transform: translateX(0) !important;
        }
    </style>
</head>

<body class="bg-cream text-brown">

    <div class="cur-ring" id="cur-ring"></div>
    <div class="cur-dot" id="cur-dot"></div>
    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen">

        {{-- ══════════════════ SIDEBAR ══════════════════ --}}
        <aside id="sidebar"
            class="fixed md:static inset-y-0 left-0 z-50
                  w-64 bg-white border-r border-cream-d
                  flex flex-col
                  -translate-x-full md:translate-x-0
                  transition-transform duration-300">

            {{-- Brand — tinggi = topbar --}}
            <div class="sidebar-brand px-6 border-b border-cream-d flex items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose flex items-center justify-center flex-shrink-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                            <path d="M8 12s1.5-2 4-2 4 2 4 2" />
                            <path d="M12 10v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-wide text-brown leading-none">Maw Bouquet</p>
                        <p class="text-[10px] text-muted mt-0.5 tracking-widest uppercase">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 p-3 space-y-0.5 text-sm overflow-y-auto">

                <p class="text-[10px] font-semibold tracking-widest text-muted uppercase px-3 pt-4 pb-2">Utama</p>
                <a href="/admin/dashboard"
                    class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brown-m hover:bg-cream {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>

                <p class="text-[10px] font-semibold tracking-widest text-muted uppercase px-3 pt-5 pb-2">Katalog</p>
                <a href="/admin/products"
                    class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brown-m hover:bg-cream {{ request()->is('admin/products*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" />
                        <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                    </svg>
                    Produk
                </a>

                <p class="text-[10px] font-semibold tracking-widest text-muted uppercase px-3 pt-5 pb-2">Pesan Masuk</p>
                <a href="/admin/messages"
                    class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brown-m hover:bg-cream {{ request()->is('admin/messages*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Pesan Kontak
                    @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if ($unreadCount > 0)
                        <span
                            class="ml-auto bg-rose text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-full leading-none">{{ $unreadCount }}</span>
                    @endif
                </a>

            </nav>

            {{-- Logout --}}
            <div class="p-4 border-t border-cream-d flex-shrink-0">
                <form method="POST" action="/admin/logout">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-muted hover:bg-red-50 hover:text-red-500 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ══════════════════ MAIN ══════════════════ --}}
        <main class="flex-1 flex flex-col min-w-0">

            {{-- Topbar — tinggi = sidebar brand --}}
            <header
                class="topbar bg-white border-b border-cream-d px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button onclick="openSidebar()" class="md:hidden text-brown-m p-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-base font-semibold text-brown leading-none">@yield('header')</h1>
                        <p class="text-xs text-muted mt-0.5">@yield('subheader', 'Maw Bouquet Admin')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/admin/messages"
                        class="relative p-2 rounded-lg hover:bg-cream transition text-muted hover:text-brown">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" />
                        </svg>
                        @if (isset($unreadCount) && $unreadCount > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose rounded-full"></span>
                        @endif
                    </a>
                    <div class="w-8 h-8 rounded-full bg-rose-l flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B85C52"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                </div>
            </header>

            {{-- Flash toast --}}
            @if (session('success'))
                <div id="toast"
                    class="bg-white border border-sage/30 shadow-lg rounded-xl px-5 py-4 flex items-center gap-3 min-w-[280px]">
                    <div class="w-8 h-8 bg-sage/10 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7A9B7A"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-brown">Berhasil</p>
                        <p class="text-xs text-muted">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('toast').classList.remove('show')"
                        class="text-muted hover:text-brown">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Content --}}
            <div class="p-6 md:p-8 flex-1 page-enter">
                @yield('content')
            </div>

        </main>
    </div>

    {{-- ══════════════════ GLOBAL DELETE MODAL ══════════════════ --}}
    {{-- Overlay fixed ke viewport, modal selalu di tengah layar --}}
    <div id="global-delete-modal" class="modal-overlay" onclick="handleModalOverlayClick(event)">
        <div class="modal-box p-6">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-4 mx-auto">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EF4444"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-brown mb-1" id="modal-title">Hapus item ini?</h3>
            <p class="text-sm text-muted mb-6" id="modal-desc">Tindakan ini tidak dapat dibatalkan.</p>
            <form id="modal-form" method="POST">
                @csrf @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-cream-d rounded-xl text-sm text-brown-m hover:bg-cream transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Cursor ──
        const ring = document.getElementById('cur-ring');
        const dot = document.getElementById('cur-dot');
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
        (function anim() {
            rx += (mx - rx) * .13;
            ry += (my - ry) * .13;
            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';
            requestAnimationFrame(anim);
        })();
        document.querySelectorAll('a,button,input,select,textarea,[role="button"]').forEach(el => {
            el.addEventListener('mouseenter', () => document.body.classList.add('cur-hover'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('cur-hover'));
        });

        // ── Toast ──
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        // ── Mobile sidebar ──
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('show');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('show');
        }

        // ── Global delete modal (dipakai semua halaman) ──
        function openDeleteModal({
            action,
            title,
            desc
        }) {
            document.getElementById('modal-title').textContent = title || 'Hapus item ini?';
            document.getElementById('modal-desc').textContent = desc || 'Tindakan ini tidak dapat dibatalkan.';
            document.getElementById('modal-form').action = action;
            document.getElementById('global-delete-modal').classList.add('open');
        }

        function closeDeleteModal() {
            document.getElementById('global-delete-modal').classList.remove('open');
        }

        function handleModalOverlayClick(e) {
            if (e.target === document.getElementById('global-delete-modal')) closeDeleteModal();
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>

    @stack('scripts')
</body>

</html>
