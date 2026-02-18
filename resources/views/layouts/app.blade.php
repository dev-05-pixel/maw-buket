<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Maw Bucket - Modern Flower Bouquet')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/icons8-flower-96.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/icons8-flower-96.png') }}">
    <meta name="description" content="@yield('meta_description', 'Premium handcrafted flower bouquet for special moments.')">
    <meta name="keywords" content="buket bunga, flower bouquet, hadiah wisuda, anniversary, bouquet modern">
    <meta name="author" content="Maw Bucket">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#111827',
                        accent: '#b45309',
                        soft: '#f5f5f4'
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1.2s ease forwards;
        }
    </style>
</head>

<body class="bg-soft text-primary">

    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-wide">
                    Maw Bucket
                </a>

                <div class="hidden md:flex space-x-10 text-sm uppercase tracking-wider">
                    <a href="{{ route('home') }}" class="hover:text-accent transition">
                        Home
                    </a>
                    <a href="{{ route('cart.index') }}" class="hover:text-accent transition">
                        Cart
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-24">
        <div class="max-w-7xl mx-auto px-6 py-10 text-sm text-gray-500">
            © {{ date('Y') }} Maw Bucket. All rights reserved.
        </div>
    </footer>

</body>

</html>
