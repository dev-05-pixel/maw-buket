@extends('layouts.app')

@section('title', 'Hubungi Kami')

@push('styles')
    <style>
        .contact-hero {
            background: var(--charcoal);
            padding: clamp(100px, 14vw, 180px) clamp(24px, 6vw, 100px) clamp(60px, 8vw, 100px);
            position: relative;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: end;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 132, 122, 0.12) 0%, transparent 70%);
            right: -100px;
            top: -100px;
            pointer-events: none;
        }

        .contact-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .4em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn .8s 1.8s var(--ease-out-expo) forwards;
        }

        .contact-hero-label::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--rose-light);
        }

        @keyframes fadeUpIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-hero-title {
            font-family: var(--font-display);
            font-size: clamp(48px, 7vw, 100px);
            font-weight: 300;
            line-height: .95;
            color: var(--cream);
            letter-spacing: -.01em;
        }

        .contact-hero-title em {
            font-style: italic;
            color: var(--rose-light);
        }

        .contact-hero-title-overflow {
            overflow: hidden;
            display: block;
            padding-bottom: 0.15em;
            margin-bottom: -0.15em;
        }

        .contact-hero-title-line {
            display: block;
            transform: translateY(110%);
            animation: lineUp .9s var(--ease-out-expo) forwards;
        }

        .contact-hero-title-overflow:nth-child(1) .contact-hero-title-line {
            animation-delay: 1.9s;
        }

        .contact-hero-title-overflow:nth-child(2) .contact-hero-title-line {
            animation-delay: 2.05s;
        }

        .contact-hero-title-overflow:nth-child(3) .contact-hero-title-line {
            animation-delay: 2.2s;
        }

        @keyframes lineUp {
            to {
                transform: translateY(0);
            }
        }

        .contact-hero-right {
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUpIn .9s 2.4s var(--ease-out-expo) forwards;
        }

        .contact-hero-desc {
            font-size: clamp(14px, 1.4vw, 16px);
            font-weight: 300;
            color: rgba(248, 243, 236, .65);
            line-height: 1.9;
            max-width: 400px;
            margin-bottom: 40px;
        }

        .contact-hero-channels {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .contact-channel-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: rgba(248, 243, 236, .06);
            border: 1px solid rgba(248, 243, 236, .1);
            border-radius: 4px;
            cursor: none;
            transition: background .3s ease, border-color .3s ease, transform .3s var(--ease-out-expo);
        }

        .contact-channel-link:hover {
            background: rgba(212, 132, 122, .12);
            border-color: rgba(212, 132, 122, .3);
            transform: translateX(6px);
        }

        .contact-channel-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .channel-wa {
            background: rgba(37, 211, 102, .15);
        }

        .channel-ig {
            background: rgba(212, 132, 122, .15);
        }

        .channel-mail {
            background: rgba(122, 155, 122, .15);
        }

        .contact-channel-icon svg {
            width: 18px;
            height: 18px;
        }

        .contact-channel-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--cream);
            margin-bottom: 3px;
        }

        .contact-channel-val {
            font-size: 12px;
            font-weight: 300;
            color: rgba(248, 243, 236, .5);
        }

        .contact-channel-arrow {
            opacity: 0;
            transition: opacity .3s ease, transform .3s ease;
            transform: translateX(-6px);
        }

        .contact-channel-link:hover .contact-channel-arrow {
            opacity: .6;
            transform: translateX(0);
        }

        .contact-channel-arrow svg {
            width: 14px;
            height: 14px;
            stroke: var(--cream);
            fill: none;
        }

        /* FORM SECTION */
        .contact-form-section {
            padding: var(--section-gap) clamp(24px, 6vw, 100px) 0;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: clamp(48px, 7vw, 100px);
            align-items: start;
        }

        .contact-info-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 300;
            line-height: 1.1;
            color: var(--charcoal);
            margin-bottom: 20px;
        }

        .contact-info-title em {
            font-style: italic;
            color: var(--rose);
        }

        .contact-info-desc {
            font-size: 15px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.9;
            margin-bottom: 48px;
        }

        .contact-detail-list {
            display: flex;
            flex-direction: column;
            gap: 28px;
            margin-bottom: 48px;
        }

        .contact-detail-item {
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }

        .contact-detail-icon-wrap {
            width: 48px;
            height: 48px;
            background: var(--cream-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .3s ease;
        }

        .contact-detail-item:hover .contact-detail-icon-wrap {
            background: rgba(212, 132, 122, .15);
        }

        .contact-detail-icon-wrap svg {
            width: 18px;
            height: 18px;
            stroke: var(--rose);
            fill: none;
        }

        .contact-detail-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--warm-grey);
            margin-bottom: 6px;
        }

        .contact-detail-value {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1.4;
        }

        .contact-detail-sub {
            font-size: 13px;
            font-weight: 300;
            color: var(--warm-grey);
            margin-top: 3px;
        }

        .hours-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            padding: 24px;
            background: var(--cream-dark);
            border-radius: 4px;
            border-left: 3px solid var(--rose);
        }

        .hours-day {
            font-size: 12px;
            font-weight: 500;
            color: var(--charcoal-mid);
        }

        .hours-time {
            font-size: 12px;
            font-weight: 400;
            color: var(--charcoal);
            text-align: right;
        }

        .hours-note {
            grid-column: 1/-1;
            margin-top: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(44, 36, 33, .1);
            font-size: 12px;
            font-weight: 300;
            color: var(--warm-grey);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .hours-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--sage);
            flex-shrink: 0;
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .3
            }
        }

        /* CONTACT FORM */
        .contact-form-col {
            background: var(--ivory);
            padding: clamp(32px, 4vw, 56px);
            border-radius: 4px;
            box-shadow: 0 4px 60px rgba(44, 36, 33, .06);
            border: 1px solid rgba(44, 36, 33, .06);
        }

        .form-title {
            font-family: var(--font-display);
            font-size: clamp(24px, 2.5vw, 36px);
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            font-weight: 300;
            color: var(--warm-grey);
            margin-bottom: 36px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: 10px;
        }

        .form-label .required {
            color: var(--rose);
            margin-left: 3px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid rgba(44, 36, 33, .12);
            border-radius: 2px;
            background: var(--cream);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal);
            transition: border-color .3s ease, box-shadow .3s ease;
            outline: none;
            cursor: none;
            -webkit-appearance: none;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--warm-grey);
            font-weight: 300;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(212, 132, 122, .12);
        }

        .form-textarea {
            min-height: 130px;
            resize: vertical;
            line-height: 1.7;
        }

        .form-select {
            cursor: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239e8e84' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 44px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: none;
            margin-bottom: 12px;
        }

        .form-check input[type="radio"] {
            width: 18px;
            height: 18px;
            appearance: none;
            -webkit-appearance: none;
            border: 1.5px solid rgba(44, 36, 33, .25);
            border-radius: 50%;
            cursor: none;
            margin-top: 2px;
            flex-shrink: 0;
            transition: border-color .3s ease;
            background: var(--ivory);
            position: relative;
        }

        .form-check input[type="radio"]:checked {
            border-color: var(--rose);
        }

        .form-check input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--rose);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-check-label {
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.5;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 6px;
        }

        .char-count {
            font-size: 11px;
            color: var(--warm-grey);
        }

        .form-notice {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 16px;
            background: rgba(122, 155, 122, .08);
            border-left: 3px solid var(--sage);
            border-radius: 2px;
            margin-bottom: 24px;
            font-size: 13px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.6;
        }

        .form-notice svg {
            width: 16px;
            height: 16px;
            stroke: var(--sage);
            fill: none;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .form-submit-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--white);
            background: var(--charcoal);
            padding: 18px 32px;
            border-radius: 2px;
            border: none;
            cursor: none;
            transition: background .3s ease, transform .2s ease, box-shadow .3s ease;
            position: relative;
            overflow: hidden;
        }

        .form-submit-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--rose-deep);
            transform: translateX(-100%);
            transition: transform .5s var(--ease-out-expo);
        }

        .form-submit-btn:hover::before {
            transform: translateX(0);
        }

        .form-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(44, 36, 33, .2);
        }

        .form-submit-btn span,
        .form-submit-btn svg {
            position: relative;
            z-index: 1;
        }

        .form-submit-btn svg {
            width: 16px;
            height: 16px;
            stroke: white;
            fill: none;
            transition: transform .3s ease;
        }

        .form-submit-btn:hover svg {
            transform: translateX(4px);
        }

        .form-success {
            display: none;
            text-align: center;
            padding: 40px 20px;
        }

        .form-success.visible {
            display: block;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background: rgba(122, 155, 122, .1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon svg {
            width: 28px;
            height: 28px;
            stroke: var(--sage);
            fill: none;
        }

        .success-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 10px;
        }

        .success-desc {
            font-size: 14px;
            font-weight: 300;
            color: var(--warm-grey);
            line-height: 1.7;
        }

        /* FAQ */
        .faq-section {
            padding: 24px clamp(24px, 6vw, 100px) var(--section-gap);
        }

        .faq-section-inner {
            max-width: 840px;
            margin: 0;
        }

        .faq-header {
            max-width: 560px;
            margin-bottom: 56px;
        }

        .faq-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 300;
            color: var(--charcoal);
            line-height: 1.1;
        }

        .faq-title em {
            font-style: italic;
            color: var(--rose);
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .faq-item {
            border-bottom: 1px solid rgba(44, 36, 33, .08);
        }

        .faq-question {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 0;
            background: none;
            border: none;
            cursor: none;
            font-family: var(--font-display);
            font-size: clamp(17px, 1.8vw, 21px);
            font-weight: 400;
            color: var(--charcoal);
            text-align: left;
            transition: color .3s ease;
        }

        .faq-question:hover {
            color: var(--rose);
        }

        .faq-icon {
            width: 36px;
            height: 36px;
            border: 1px solid rgba(44, 36, 33, .15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .3s ease, border-color .3s ease;
        }

        .faq-question[aria-expanded="true"] .faq-icon {
            background: var(--rose);
            border-color: var(--rose);
        }

        .faq-icon svg {
            width: 14px;
            height: 14px;
            stroke: var(--charcoal-mid);
            fill: none;
            transition: transform .4s var(--ease-out-expo), stroke .3s ease;
        }

        .faq-question[aria-expanded="true"] .faq-icon svg {
            transform: rotate(45deg);
            stroke: white;
        }

        .faq-answer {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows .4s var(--ease-out-expo);
        }

        .faq-answer.open {
            grid-template-rows: 1fr;
        }

        .faq-answer-inner {
            overflow: hidden;
        }

        .faq-answer-inner p {
            padding-bottom: 24px;
            font-size: 15px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.85;
        }

        @media(max-width:1000px) {

            .contact-hero,
            .contact-form-section {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    <header class="contact-hero" aria-label="Contact hero">
        <div style="position:relative;z-index:1;">
            <p class="contact-hero-label">Hubungi Kami</p>
            <h1 class="contact-hero-title">
                <span class="contact-hero-title-overflow"><span class="contact-hero-title-line">Kami Senang</span></span>
                <span class="contact-hero-title-overflow"><span class="contact-hero-title-line">Mendengar</span></span>
                <span class="contact-hero-title-overflow"><span
                        class="contact-hero-title-line"><em>Ceritamu</em></span></span>
            </h1>
        </div>

        <div class="contact-hero-right">
            <p class="contact-hero-desc">Punya pertanyaan, ingin memesan, atau sekadar ingin tahu lebih banyak? Kami selalu
                siap membantu Anda menemukan buket yang sempurna.</p>
            <div class="contact-hero-channels" role="list">
                <a href="https://wa.me/6285708573756" target="_blank" rel="noopener" class="contact-channel-link"
                    role="listitem">
                    <span class="contact-channel-icon channel-wa" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="#25D366" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                        </svg>
                    </span>
                    <div class="contact-channel-info">
                        <p class="contact-channel-name">WhatsApp</p>
                        <p class="contact-channel-val">+62 8xx-xxxx-xxxx</p>
                    </div>
                    <span class="contact-channel-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></span>
                </a>
                <a href="mailto:hello@mawbouquet.id" class="contact-channel-link" role="listitem">
                    <span class="contact-channel-icon channel-mail" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </span>
                    <div class="contact-channel-info">
                        <p class="contact-channel-name">Email</p>
                        <p class="contact-channel-val">hello@mawbouquet.id</p>
                    </div>
                    <span class="contact-channel-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></span>
                </a>
            </div>
        </div>
    </header>

    <section class="contact-form-section" aria-label="Formulir kontak">
        <div class="reveal-left">
            <span class="section-label">Informasi Kontak</span>
            <h2 class="contact-info-title">Temukan<br>Kami <em>di Sini</em></h2>
            <p class="contact-info-desc">Setiap pertanyaan Anda kami sambut dengan hangat. Dari konsultasi sederhana hingga
                pesanan custom yang kompleks — kami siap membantu.</p>
            <div class="contact-detail-list">
                <div class="contact-detail-item">
                    <div class="contact-detail-icon-wrap" aria-hidden="true">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.7 12.4 19.79 19.79 0 01.67 3.82 2 2 0 012.64 1.64h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.09 9a16 16 0 006 6l.92-.91a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                        </svg>
                    </div>
                    <div>
                        <p class="contact-detail-label">WhatsApp</p>
                        <p class="contact-detail-value">+62 8xx-xxxx-xxxx</p>
                        <p class="contact-detail-sub">Respons tercepat via WhatsApp</p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <div class="contact-detail-icon-wrap" aria-hidden="true">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div>
                        <p class="contact-detail-label">Email</p>
                        <p class="contact-detail-value">hello@mawbouquet.id</p>
                        <p class="contact-detail-sub">Dibalas dalam 24 jam kerja</p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <div class="contact-detail-icon-wrap" aria-hidden="true">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <p class="contact-detail-label">Lokasi</p>
                        <p class="contact-detail-value">Jakarta Selatan</p>
                        <p class="contact-detail-sub">DKI Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="hours-grid">
                <span class="hours-day">Senin - Jumat</span><span class="hours-time">08:00 - 20:00</span>
                <span class="hours-day">Sabtu</span><span class="hours-time">09:00 - 18:00</span>
                <span class="hours-day">Minggu</span><span class="hours-time">10:00 - 16:00</span>
                <p class="hours-note"><span class="hours-dot" aria-hidden="true"></span>Menerima pesanan 24 jam via
                    WhatsApp</p>
            </div>
        </div>

        <div class="contact-form-col reveal-right">
            <h2 class="form-title">Kirim Pesan</h2>
            <p class="form-subtitle">Ceritakan kebutuhan Anda dan kami akan membantu menemukan buket yang tepat.</p>
            <div class="form-notice" role="note">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    aria-hidden="true">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                Website ini tidak memproses pembayaran. Setelah mengisi formulir, kami akan menghubungi Anda untuk
                konfirmasi pesanan.
            </div>
            <form id="contact-form" action="{{ url('/contact') }}" method="POST" novalidate
                aria-label="Formulir kontak">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama <span class="required"
                                aria-label="wajib">*</span></label>
                        <input type="text" id="name" name="name" class="form-input"
                            placeholder="Nama lengkap Anda" required autocomplete="name" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">No. WhatsApp <span class="required"
                                aria-label="wajib">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-input"
                            placeholder="08xx-xxxx-xxxx" required autocomplete="tel" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="contoh@email.com" autocomplete="email" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="purpose">Keperluan <span class="required"
                            aria-label="wajib">*</span></label>
                    <select id="purpose" name="purpose" class="form-select" required>
                        <option value="" disabled selected>Pilih keperluan buket</option>
                        <option>Ulang Tahun</option>
                        <option>Pernikahan / Lamaran</option>
                        <option>Wisuda</option>
                        <option>Anniversary</option>
                        <option>Hadiah / Apresiasi</option>
                        <option>Belasungkawa</option>
                        <option>Custom / Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <p class="form-label">Pilihan Warna</p>
                    @foreach (['Pastel & Lembut', 'Merah & Romantis', 'Putih & Elegan', 'Colorful & Ceria', 'Sesuai Saran Kami'] as $c)
                        <div class="form-check">
                            <input type="radio" name="color_pref" id="c{{ $loop->index }}"
                                value="{{ $c }}" {{ $loop->first ? 'checked' : '' }} />
                            <label class="form-check-label" for="c{{ $loop->index }}">{{ $c }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label class="form-label" for="message">Pesan <span class="required"
                            aria-label="wajib">*</span></label>
                    <textarea id="message" name="message" class="form-textarea"
                        placeholder="Ceritakan momen spesial Anda, ukuran buket, budget, tanggal acara, atau detail lainnya..." required
                        maxlength="600" aria-describedby="msg-count"></textarea>
                    <div class="form-footer"><span></span><span class="char-count" id="msg-count" aria-live="polite">0 /
                            600</span></div>
                </div>
                <button type="submit" class="form-submit-btn">
                    <span>Kirim Pesan</span>
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        aria-hidden="true">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                </button>
            </form>
            <div class="form-success" id="form-success" role="status" aria-live="polite">
                <div class="success-icon" aria-hidden="true"><svg viewBox="0 0 24 24" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg></div>
                <h3 class="success-title">Pesan Terkirim!</h3>
                <p class="success-desc">Terima kasih! Kami akan membalas pesan Anda dalam 1-3 jam kerja.</p>
            </div>
        </div>
    </section>

    <section class="faq-section" aria-label="FAQ">
        <div class="faq-section-inner">
            <div class="faq-header reveal">
                <span class="section-label">Pertanyaan Umum</span>
                <h2 class="faq-title">Hal yang Sering<br>Ditanyakan <em>Pelanggan</em></h2>
            </div>
            <div class="faq-list">
                @php $faqs = [
                        [
                            'q' => 'Bagaimana cara memesan buket dari Maw Bouquet?',
                            'a' =>
                                'Anda bisa memesan dengan mengirimkan pesan WhatsApp ke nomor kami atau mengisi formulir kontak di halaman ini. Ceritakan kebutuhan Anda — jenis buket, warna, ukuran, dan tanggal pengiriman. Tim kami akan merespons dan membantu proses selanjutnya.',
                        ],
                        [
                            'q' => 'Berapa lama waktu yang dibutuhkan untuk membuat satu buket?',
                            'a' =>
                                'Untuk buket standar dari katalog, kami membutuhkan 1-2 hari kerja. Untuk pesanan custom, bisa 3-5 hari kerja. Kami sangat merekomendasikan memesan lebih awal untuk momen spesial.',
                        ],
                        [
                            'q' => 'Apakah tersedia pengiriman same-day?',
                            'a' =>
                                'Ya, untuk area Jakarta Selatan dan sekitarnya dengan konfirmasi sebelum pukul 13.00 WIB. Untuk area Jabodetabek lain tersedia H-1, dan luar kota 2-3 hari kerja.',
                        ],
                        [
                            'q' => 'Bisakah saya request desain atau warna khusus?',
                            'a' =>
                                'Tentu! Anda bisa menentukan warna dominan, jenis bunga, gaya pembungkusan, atau menyertakan referensi foto. Tim kami akan mewujudkan visi Anda sebaik mungkin.',
                        ],
                        [
                            'q' => 'Apakah tersedia buket untuk event atau pernikahan?',
                            'a' =>
                                'Ya, kami melayani pesanan dalam jumlah besar untuk pernikahan, wisuda, dan berbagai event. Hubungi kami minimal 2 minggu sebelum acara untuk hasil terbaik.',
                        ],
                ]; @endphp
                @foreach ($faqs as $i => $faq)
                    <div class="faq-item reveal">
                        <button class="faq-question" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                            aria-controls="fa-{{ $i }}" id="fq-{{ $i }}">
                            {{ $faq['q'] }}
                            <span class="faq-icon" aria-hidden="true"><svg viewBox="0 0 24 24" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg></span>
                        </button>
                        <div class="faq-answer {{ $i === 0 ? 'open' : '' }}" id="fa-{{ $i }}" role="region"
                            aria-labelledby="fq-{{ $i }}">
                            <div class="faq-answer-inner">
                                <p>{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        const textarea = document.getElementById('message');
        const charCount = document.getElementById('msg-count');
        const form = document.getElementById('contact-form');
        const successBox = document.getElementById('form-success');
        if (textarea) {
            textarea.addEventListener('input', () => {
                const l = textarea.value.length;
                charCount.textContent = l + ' / 600';
                charCount.style.color = l > 550 ? 'var(--rose)' : 'var(--warm-grey)';
            });
        }
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const req = form.querySelectorAll('[required]');
                let ok = true;
                req.forEach(el => {
                    if (!el.value.trim()) {
                        ok = false;
                        el.style.borderColor = 'var(--rose)';
                    } else {
                        el.style.borderColor = '';
                    }
                });
                if (!ok) return;

                const btn = form.querySelector('.form-submit-btn');
                btn.disabled = true;
                btn.innerHTML = '<span>Mengirim...</span>';

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ??
                                formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            form.style.display = 'none';
                            successBox.classList.add('visible');
                        }
                    })
                    .catch(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<span>Kirim Pesan</span>';
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    });
            });
        }
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', function() {
                const open = this.getAttribute('aria-expanded') === 'true';
                const a = document.getElementById(this.getAttribute('aria-controls'));
                document.querySelectorAll('.faq-question').forEach(b => b.setAttribute('aria-expanded',
                    'false'));
                document.querySelectorAll('.faq-answer').forEach(x => x.classList.remove('open'));
                if (!open) {
                    this.setAttribute('aria-expanded', 'true');
                    a.classList.add('open');
                }
            });
        });
    </script>
@endpush
