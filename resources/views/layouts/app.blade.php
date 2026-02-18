<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maw Bucket</title>

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
</head>
<body class="bg-soft text-primary">

<!-- NAVBAR -->
<nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <a href="{{ route('home') }}"
               class="text-2xl font-semibold tracking-wide">
                Maw Bucket
            </a>

            <div class="hidden md:flex space-x-10 text-sm uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-accent transition">
                    Home
                </a>
                <a href="#" class="hover:text-accent transition">
                    Collections
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
