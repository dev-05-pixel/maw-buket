@extends('layouts.app')

@section('title', 'Semua Testimoni')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/testimonials/index.css') }}">
@endpush

@section('content')

    <section class="testimonials-page">

        <div class="testimonials-page-header">

            <span class="section-label" style="justify-content:center;">
                Testimoni Pelanggan
            </span>

            <h1 class="testimonials-page-title">
                Cerita Indah dari<br>
                Setiap <em>Pelanggan</em>
            </h1>

            <p class="testimonials-page-subtitle">
                Kepuasan pelanggan adalah bagian terpenting dari setiap rangkaian
                yang kami buat. Berikut pengalaman mereka bersama Maw Bouquet.
            </p>

        </div>

        <div class="testimonials-page-grid">

            @foreach ($testimonials as $t)
                <article class="testimonial-card">

                    <span class="testimonial-quote">
                        &ldquo;
                    </span>
                    <div class="testimonial-top">
                        <div class="testimonial-avatar-letter">
                            {{ strtoupper(substr($t->name, 0, 1)) }}
                        </div>

                        <div>
                            <h3 class="testimonial-name">
                                {{ $t->name }}
                            </h3>

                            <p class="testimonial-location">
                                {{ $t->location }}
                            </p>
                        </div>
                    </div>
                    <div class="testimonial-stars">
                        @for ($i = 0; $i < $t->rating; $i++)
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5
                                                         4.87 1.18 6.88L12 17.77l-6.18
                                                         3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        @endfor
                    </div>

                    <p class="testimonial-message">
                        {{ $t->message }}
                    </p>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">
            @if ($testimonials->hasPages())
                <div class="custom-pagination">

                    {{-- Prev --}}
                    @if ($testimonials->onFirstPage())
                        <span class="pagination-btn disabled">
                            ❮
                        </span>
                    @else
                        <a href="{{ $testimonials->previousPageUrl() }}" class="pagination-btn">
                            ❮
                        </a>
                    @endif

                    {{-- Numbers --}}
                    @foreach ($testimonials->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
                        @if ($page == $testimonials->currentPage())
                            <span class="pagination-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($testimonials->hasMorePages())
                        <a href="{{ $testimonials->nextPageUrl() }}" class="pagination-btn">
                            ❯
                        </a>
                    @else
                        <span class="pagination-btn disabled">
                            ❯
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
