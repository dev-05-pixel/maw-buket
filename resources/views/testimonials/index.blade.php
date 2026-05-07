@extends('layouts.app')

@section('title', 'Semua Testimoni')

@push('styles')
    <style>
        .testimonials-page {
            padding:
                clamp(90px, 10vw, 140px) clamp(24px, 6vw, 100px);

            background: var(--cream-dark);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .testimonials-page::before {
            content: 'REVIEWS';
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);

            font-family: var(--font-display);
            font-size: clamp(70px, 15vw, 220px);
            font-weight: 700;

            color: rgba(212, 132, 122, 0.04);

            letter-spacing: .08em;
            pointer-events: none;
            white-space: nowrap;
        }

        .testimonials-page-header {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
            z-index: 2;
        }

        .testimonials-page-title {
            font-family: var(--font-display);
            font-size: clamp(42px, 5vw, 72px);
            font-weight: 300;
            line-height: 1.1;
            color: var(--charcoal);
            margin-bottom: 18px;
        }

        .testimonials-page-title em {
            color: var(--rose);
            font-style: italic;
        }

        .testimonials-page-subtitle {
            max-width: 720px;
            margin-inline: auto;

            font-size: 15px;
            line-height: 1.9;
            color: var(--charcoal-mid);
            font-weight: 300;
        }

        .testimonials-page-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            position: relative;
            z-index: 2;
        }

        .testimonial-card {
            background: var(--ivory);
            padding: 34px;
            border-radius: 8px;

            border: 1px solid rgba(0, 0, 0, .04);

            transition:
                transform .45s var(--ease-out-expo),
                box-shadow .45s ease,
                border-color .45s ease;

            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;

            width: 100%;
            height: 3px;

            background: linear-gradient(90deg,
                    var(--rose),
                    transparent);

            opacity: 0;
            transition: opacity .4s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 30px 60px rgba(44, 36, 33, .08);

            border-color: rgba(212, 132, 122, .2);
        }

        .testimonial-card:hover::before {
            opacity: 1;
        }

        .testimonial-top {
            display: flex;
            align-items: center;
            gap: 16px;

            margin-bottom: 22px;
        }

        .testimonial-avatar-letter {
            width: 54px;
            height: 54px;

            border-radius: 50%;

            background:
                linear-gradient(135deg,
                    var(--rose),
                    var(--rose-deep));

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            font-weight: 600;

            flex-shrink: 0;
        }

        .testimonial-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--charcoal);
            margin-bottom: 3px;
        }

        .testimonial-location {
            font-size: 13px;
            color: var(--warm-grey);
        }

        .testimonial-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 18px;
        }

        .testimonial-stars svg {
            width: 18px;
            height: 18px;
            fill: var(--terracotta);
        }

        .testimonial-message {
            font-family: var(--font-display);
            font-size: 18px;
            line-height: 1.9;
            font-style: italic;
            color: var(--charcoal-mid);
        }

        .testimonial-quote {
            position: absolute;
            top: 22px;
            right: 24px;

            font-family: var(--font-display);
            font-size: 70px;
            line-height: 1;

            color: rgba(212, 132, 122, .12);
        }

        .pagination-wrap {
            margin-top: 70px;

            display: flex;
            justify-content: center;
        }

        .pagination-wrap nav {
            background: var(--ivory);
            padding: 12px 18px;
            border-radius: 8px;

            box-shadow:
                0 10px 30px rgba(44, 36, 33, .05);
        }

        .pagination-wrap .pagination {
            display: flex;
            align-items: center;
            gap: 10px;

            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-wrap .page-item {
            list-style: none;
        }

        .pagination-wrap .page-link {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            text-decoration: none;

            font-size: 14px;
            font-weight: 500;

            color: var(--charcoal);
            background: transparent;

            transition:
                background .3s ease,
                color .3s ease,
                transform .3s ease;
        }

        .pagination-wrap .page-link:hover {
            background: rgba(212, 132, 122, .12);
            color: var(--rose);

            transform: translateY(-2px);
        }

        .pagination-wrap .active .page-link {
            background: var(--rose);
            color: white;

            box-shadow:
                0 10px 25px rgba(212, 132, 122, .25);
        }

        .pagination-wrap .disabled .page-link {
            opacity: .35;
            pointer-events: none;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .pagination-btn {
            width: 52px;
            height: 52px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            font-size: 17px;
            font-weight: 500;

            color: var(--charcoal);

            background: transparent;

            transition:
                all .35s ease;
        }

        /* khusus tombol panah */
        .pagination-btn:first-child,
        .pagination-btn:last-child {
            font-size: 30px;
            font-weight: 300;
            line-height: 1;
        }

        .pagination-btn:hover {
            background: rgba(212, 132, 122, .12);
            color: var(--rose);

            transform: translateY(-2px);
        }

        .pagination-btn.active {
            background: var(--rose);
            color: white;

            box-shadow:
                0 12px 30px rgba(212, 132, 122, .28);
        }

        .pagination-btn.disabled {
            opacity: .3;
            pointer-events: none;
        }

        @media (max-width: 1024px) {

            .testimonials-page-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 680px) {

            .testimonials-page-grid {
                grid-template-columns: 1fr;
            }

            .testimonial-card {
                padding: 28px;
            }

        }
    </style>
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
