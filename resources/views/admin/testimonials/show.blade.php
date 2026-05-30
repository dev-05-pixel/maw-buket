@extends('admin.layouts.app')

@section('title', 'Detail Testimonial')
@section('header', 'Detail Testimonial')
@section('subheader', 'Informasi lengkap testimonial pelanggan')

@section('content')

    <div class="w-full">

        <div class="bg-white border border-cream-d rounded-2xl overflow-hidden">

            {{-- Content --}}
            <div class="p-6 md:p-8">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center gap-5 mb-8">

                    <div
                        class="w-16 h-16 rounded-full
                               bg-rose-l text-rose-d
                               flex items-center justify-center
                               text-xl font-semibold flex-shrink-0">

                        {{ strtoupper($testimonial->avatar_letter ?? substr($testimonial->name, 0, 1)) }}

                    </div>

                    <div class="min-w-0">

                        <h2 class="text-2xl font-semibold text-brown break-words">
                            {{ $testimonial->name }}
                        </h2>

                        <p class="text-muted">
                            {{ $testimonial->location ?? 'Indonesia' }}
                        </p>

                    </div>

                </div>

                {{-- Rating --}}
                <div class="mb-8">

                    <p class="text-sm font-medium text-muted mb-3">
                        Rating Pelanggan
                    </p>

                    <div class="flex items-center gap-2 flex-wrap">

                        <div class="flex items-center gap-1">

                            @for ($i = 1; $i <= 5; $i++)
                                <svg
                                    class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-500' : 'text-gray-300' }}"
                                    fill="currentColor"
                                    viewBox="0 0 24 24">

                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87
                                             1.18 6.88L12 17.77l-6.18 3.25L7 14.14
                                             2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor

                        </div>

                        <span class="text-lg font-semibold text-brown">
                            {{ $testimonial->rating }}/5
                        </span>

                    </div>

                </div>

                {{-- Testimonial --}}
                <div class="mb-8">

                    <p class="text-sm font-medium text-muted mb-3">
                        Isi Testimonial
                    </p>

                    <div
                        class="bg-cream rounded-2xl p-6
                               text-brown leading-8
                               whitespace-pre-wrap
                               break-words
                               [overflow-wrap:anywhere]
                               overflow-hidden">

                        {{ $testimonial->message }}

                    </div>

                </div>

                {{-- Metadata --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="bg-cream rounded-xl p-5">

                        <p class="text-xs uppercase tracking-wide text-muted mb-2">
                            Tanggal Dibuat
                        </p>

                        <p class="font-semibold text-brown">
                            {{ $testimonial->created_at->format('d F Y') }}
                        </p>

                        <p class="text-sm text-muted mt-1">
                            {{ $testimonial->created_at->format('H:i') }}
                        </p>

                    </div>

                    <div class="bg-cream rounded-xl p-5">

                        <p class="text-xs uppercase tracking-wide text-muted mb-2">
                            IP Address
                        </p>

                        <p class="font-semibold text-brown break-all">
                            {{ $testimonial->ip_address ?? '-' }}
                        </p>

                    </div>

                    <div class="bg-cream rounded-xl p-5">

                        <p class="text-xs uppercase tracking-wide text-muted mb-2">
                            ID Testimonial
                        </p>

                        <p class="font-semibold text-brown break-all">
                            {{ $testimonial->id }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="border-t border-cream-d p-6">

                <a href="{{ route('admin.testimonials.index') }}"
                    class="inline-flex items-center gap-2
                           px-4 py-2.5
                           rounded-xl
                           border border-cream-d
                           text-brown
                           hover:bg-cream
                           transition">

                    <svg width="16" height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M19 12H5" />
                        <path d="M12 19l-7-7 7-7" />

                    </svg>

                    Kembali

                </a>

            </div>

        </div>

    </div>

@endsection
