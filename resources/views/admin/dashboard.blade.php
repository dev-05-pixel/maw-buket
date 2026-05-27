@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Selamat datang kembali')

@section('content')

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-rose via-rose-d to-brown p-8 mb-8 text-white">

        <div class="absolute top-0 right-0 opacity-10">
            <svg width="300" height="300" viewBox="0 0 200 200" fill="none">
                <circle cx="100" cy="100" r="80" stroke="white" stroke-width="20" />
            </svg>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-white/70 mb-3">
                    Maw Bouquet Admin Panel
                </p>

                <h2 class="text-3xl font-bold leading-tight">
                    Dashboard Penjualan & Aktivitas
                </h2>

                <p class="text-white/80 mt-3 text-sm max-w-2xl">
                    Pantau statistik pesanan, pendapatan, produk terbaru,
                    dan aktivitas customer secara realtime.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur rounded-2xl px-6 py-5 min-w-[250px]">
                <p class="text-sm text-white/70">
                    Revenue Bulan Ini
                </p>

                <h3 class="text-3xl font-bold mt-2">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </h3>

                <p class="text-xs text-white/70 mt-2">
                    {{ now()->translatedFormat('F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-5 mb-8">

        {{-- Produk --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Produk
                    </p>

                    <h3 class="text-3xl font-bold text-brown mt-2">
                        {{ $totalProducts }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-rose/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Orders --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Orders
                    </p>

                    <h3 class="text-3xl font-bold text-brown mt-2">
                        {{ $totalOrders }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V9m-5-4h5m0 0v5m0-5L10 14" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Completed
                    </p>

                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        {{ $completedOrders }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Pending
                    </p>

                    <h3 class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ $pendingOrders }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pesan --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Pesan
                    </p>

                    <h3 class="text-3xl font-bold text-brown mt-2">
                        {{ $totalMessages }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10h8m-8 4h5m-9 5l-1-4V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H7l-4 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Belum Dibaca --}}
        <div class="bg-white rounded-3xl border border-cream-d p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted">
                        Belum Dibaca
                    </p>

                    <h3 class="text-3xl font-bold text-rose mt-2">
                        {{ $unreadMessages }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6" />
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        {{-- Revenue Chart --}}
        <div class="xl:col-span-2 bg-white rounded-3xl border border-cream-d p-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-brown">
                        Revenue Tahunan
                    </h3>

                    <p class="text-sm text-muted mt-1">
                        Pendapatan order completed per bulan
                    </p>
                </div>

                <form method="GET">
                    <select name="year" onchange="this.form.submit()"
                        class="text-xs rounded-xl border border-cream-d bg-white px-3 py-2">

                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach

                    </select>
                </form>
            </div>

            <div style="position:relative; width:100%; height:280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Order Status --}}
        <div class="bg-white rounded-3xl border border-cream-d p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brown">Status Pesanan</h3>
                <p class="text-sm text-muted mt-1">Distribusi status order saat ini</p>
            </div>

            {{-- Custom Legend --}}
            <div class="flex flex-wrap gap-3 mb-4 text-xs text-muted">
                @foreach ($statusLabels as $i => $label)
                    @php $colors = ['#FACC15','#60A5FA','#4ADE80','#F87171']; @endphp
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm inline-block"
                            style="background:{{ $colors[$i] ?? '#ccc' }}"></span>
                        {{ $label }}
                    </span>
                @endforeach
            </div>

            <div style="position:relative; width:100%; height:220px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

    </div>

    {{-- SECOND GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        {{-- Product Category --}}
        <div class="bg-white rounded-3xl border border-cream-d p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brown">Kategori Produk</h3>
                <p class="text-sm text-muted mt-1">Jumlah produk berdasarkan kategori</p>
            </div>

            {{-- Custom Legend --}}
            <div class="flex flex-wrap gap-3 mb-4 text-xs text-muted">
                @foreach ($categoryLabels as $i => $label)
                    @php $colors = ['#D4847A','#C9AA86','#7A9B7A','#4B9CE2','#D6A843','#B85C52']; @endphp
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm inline-block"
                            style="background:{{ $colors[$i] ?? '#ccc' }}"></span>
                        {{ $label }}
                    </span>
                @endforeach
            </div>

            <div style="position:relative; width:100%; height:220px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        {{-- Latest Products --}}
        <div class="xl:col-span-2 bg-white rounded-3xl border border-cream-d overflow-hidden">

            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-brown">
                        Produk Terbaru
                    </h3>

                    <p class="text-sm text-muted mt-1">
                        Produk terbaru yang baru ditambahkan
                    </p>
                </div>

                <a href="/admin/products" class="text-sm text-rose font-medium hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">

                @forelse($latestProducts as $product)
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-cream transition">

                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-16 h-16 rounded-2xl object-cover border border-cream-d">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-cream-d"></div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-brown truncate">
                                {{ $product->name }}
                            </p>

                            <p class="text-xs text-muted mt-1">
                                {{ $product->category }}
                            </p>
                        </div>

                        @php
                            $variants = is_string($product->variants)
                                ? json_decode($product->variants, true)
                                : $product->variants ?? [];

                            $prices = collect($variants)
                                ->pluck('price')
                                ->map(function ($price) {
                                    $price = preg_replace('/[^0-9]/', '', (string) $price);

                                    return (int) $price;
                                })
                                ->filter(fn($price) => $price > 0)
                                ->values();
                        @endphp

                        <div class="text-right">

                            @if ($prices->count())
                                <p class="text-sm font-bold text-brown">
                                    Rp {{ number_format($prices->min(), 0, ',', '.') }}

                                    @if ($prices->min() != $prices->max())
                                        - {{ number_format($prices->max(), 0, ',', '.') }}
                                    @endif
                                </p>
                            @else
                                <p class="text-sm font-bold text-brown">
                                    Harga belum tersedia
                                </p>
                            @endif

                            <p class="text-[11px] text-muted mt-1">
                                {{ $product->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada produk
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Latest Orders --}}
        <div class="bg-white rounded-3xl border border-cream-d overflow-hidden">

            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-lg font-semibold text-brown">
                    Order Terbaru
                </h3>

                <a href="/admin/orders" class="text-sm text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">

                @forelse($latestOrders as $order)
                    <div class="px-6 py-4 hover:bg-cream transition">

                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-brown">
                                {{ $order->product_name }}
                            </p>

                            <span
                                class="text-[11px] px-2 py-1 rounded-full
                                @if ($order->status === 'completed') bg-green-100 text-green-700
                                @elseif($order->status === 'pending')
                                    bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'confirmed')
                                    bg-blue-100 text-blue-700
                                @else
                                    bg-red-100 text-red-700 @endif">

                                {{ ucfirst($order->status) }}

                            </span>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-muted">
                                {{ $order->created_at->diffForHumans() }}
                            </p>

                            <p class="text-sm font-semibold text-brown">
                                Rp {{ number_format($order->product_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada order
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Messages --}}
        <div class="bg-white rounded-3xl border border-cream-d overflow-hidden">

            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-lg font-semibold text-brown">
                    Pesan Terbaru
                </h3>

                <a href="/admin/messages" class="text-sm text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">

                @forelse($latestMessages as $msg)
                    <a href="/admin/messages/{{ $msg->id }}" class="block px-6 py-4 hover:bg-cream transition">

                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-brown">
                                {{ $msg->name }}
                            </p>

                            <p class="text-[11px] text-muted">
                                {{ $msg->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <p class="text-xs text-muted mt-2 line-clamp-2">
                            {{ Str::limit($msg->message, 80) }}
                        </p>
                    </a>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada pesan
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Testimonials --}}
        <div class="bg-white rounded-3xl border border-cream-d overflow-hidden">

            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">
                <h3 class="text-lg font-semibold text-brown">
                    Testimonial
                </h3>

                <a href="/admin/testimonials" class="text-sm text-rose hover:underline">
                    Lihat semua →
                </a>
            </div>

            <div class="divide-y divide-cream-d">

                @forelse($latestTestimonials as $testimonial)
                    <div class="px-6 py-4 hover:bg-cream transition">

                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-brown">
                                {{ $testimonial->name }}
                            </p>

                            <span class="text-xs font-medium text-yellow-600">
                                ★ {{ $testimonial->rating }}/5
                            </span>
                        </div>

                        <p class="text-xs text-muted mt-2 line-clamp-3">
                            {{ Str::limit($testimonial->message, 100) }}
                        </p>
                    </div>

                @empty

                    <div class="px-6 py-10 text-center text-sm text-muted">
                        Belum ada testimonial
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
        <script>
            Chart.defaults.font.family = 'system-ui, sans-serif';
            Chart.defaults.font.size = 11;

            const _gridColor = 'rgba(0,0,0,0.05)';
            const _tickColor = '#999';
            const _tooltipDefaults = {
                backgroundColor: '#fff',
                titleColor: '#222',
                bodyColor: '#666',
                borderColor: 'rgba(0,0,0,0.08)',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 10,
                boxPadding: 5,
            };

            // Revenue Chart
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: @json($revenueLabels),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($monthlyRevenue),
                        borderColor: '#D4847A',
                        backgroundColor: 'rgba(212,132,122,0.10)',
                        tension: 0.45,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#B85C52',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        borderWidth: 2.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1800,
                        easing: 'easeOutQuart'
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        x: {
                            grid: {
                                color: _gridColor
                            },
                            ticks: {
                                color: _tickColor,
                                maxRotation: 0
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: _gridColor
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: _tickColor,
                                callback: v => 'Rp ' + (v >= 1000000 ? (v / 1000000).toFixed(0) + 'jt' : v)
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            ..._tooltipDefaults,
                            callbacks: {
                                label: ctx => ' Rp ' + ctx.raw.toLocaleString('id-ID')
                            }
                        }
                    }
                }
            });

            // Status Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#FACC15', '#60A5FA', '#4ADE80', '#F87171'],
                        hoverOffset: 10,
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    animation: {
                        animateRotate: true,
                        duration: 1800,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            ..._tooltipDefaults,
                            callbacks: {
                                label: ctx => ' ' + ctx.label + ': ' + ctx.raw
                            }
                        }
                    }
                }
            });

            // Category Chart
            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryData),
                        backgroundColor: ['#D4847A', '#C9AA86', '#7A9B7A', '#4B9CE2', '#D6A843', '#B85C52'],
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1800,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: _tickColor
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: _gridColor
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: _tickColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            ..._tooltipDefaults,
                            callbacks: {
                                label: ctx => ' ' + ctx.raw + ' produk'
                            }
                        }
                    }
                }
            });
        </script>
    @endpush

@endsection
