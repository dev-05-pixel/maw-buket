@extends('layouts.app')

@section('title', 'Rekomendasi Buket AI — Maw Bouquet')

@push('styles')
    <style>
        /* ================================================================
                                                       AI RECOMMENDATION PAGE
                                                    ================================================================ */

        /* PAGE HERO */
        .ai-hero {
            height: 420px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 0 clamp(24px, 6vw, 100px);
            background: var(--charcoal);
        }

        .ai-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(44, 36, 33, 0.98) 0%, rgba(44, 36, 33, 0.85) 50%, rgba(44, 36, 33, 0.65) 100%);
        }

        /* Animated grain texture */
        .ai-hero-grain {
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
            background-size: 200px;
        }

        /* Floating decorative petals */
        .ai-hero-deco {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .ai-petal {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--rose-light);
            border-radius: 50% 0 50% 0;
            opacity: 0;
            animation: petalFloat linear infinite;
        }

        @keyframes petalFloat {
            0% {
                opacity: 0;
                transform: translateY(0) rotate(0deg);
            }

            10% {
                opacity: 0.4;
            }

            90% {
                opacity: 0.15;
            }

            100% {
                opacity: 0;
                transform: translateY(-80vh) rotate(360deg);
            }
        }

        .ai-hero-content {
            position: relative;
            z-index: 2;
            max-width: 680px;
        }

        .ai-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 0.8s 0.3s var(--ease-out-expo) forwards;
        }

        .ai-hero-eyebrow::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--rose-light);
        }

        /* AI badge pulse */
        .ai-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(212, 132, 122, 0.18);
            border: 1px solid rgba(2, 1, 1, 0.4);
            color: var(--rose-light);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 28px;
            opacity: 0;
            animation: fadeUpIn 0.8s 0.5s var(--ease-out-expo) forwards;
        }

        .ai-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rose);
            animation: pulseDot 1.6s ease-in-out infinite;
        }

        @keyframes pulseDot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.7);
            }
        }

        .ai-hero-title {
            font-family: var(--font-display);
            font-size: clamp(38px, 6.5vw, 88px);
            font-weight: 300;
            line-height: 0.95;
            color: var(--cream);
            letter-spacing: -0.01em;
            margin-bottom: 20px;
        }

        .ai-hero-title-inner {
            display: block;
            overflow: hidden;
        }

        .ai-hero-title-line {
            display: block;
            transform: translateY(110%);
            animation: lineUp 0.9s var(--ease-out-expo) forwards;
        }

        .ai-hero-title-inner:nth-child(1) .ai-hero-title-line {
            animation-delay: 0.5s;
        }

        .ai-hero-title-inner:nth-child(2) .ai-hero-title-line {
            animation-delay: 0.65s;
        }

        @keyframes lineUp {
            to {
                transform: translateY(0);
            }
        }

        .ai-hero-title em {
            font-style: italic;
            color: var(--rose-light);
        }

        .ai-hero-sub {
            font-size: clamp(13px, 1.4vw, 15px);
            font-weight: 300;
            color: rgba(248, 243, 236, 0.6);
            max-width: 460px;
            line-height: 1.9;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUpIn 0.8s 0.9s var(--ease-out-expo) forwards;
        }

        @keyframes fadeUpIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================================================================
                                                       MAIN FORM SECTION
                                                    ================================================================ */
        .ai-main {
            padding: clamp(40px, 5vw, 72px) clamp(24px, 6vw, 100px);
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: clamp(32px, 4vw, 64px);
            align-items: start;
            background: var(--ivory);
        }

        /* ================================================================
                                                       FORM PANEL
                                                    ================================================================ */
        .ai-form-panel {
            background: var(--white, #fff);
            border: 1px solid rgba(44, 36, 33, 0.08);
            border-radius: 2px;
        }

        .form-panel-header {
            padding: 28px 32px 22px;
            border-bottom: 1px solid rgba(44, 36, 33, 0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .form-panel-title {
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--charcoal);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-panel-title::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--rose);
        }

        .form-panel-body {
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        /* ----------------------------------------------------------------
                                                       FORM FIELD
                                                    ---------------------------------------------------------------- */
        .ai-field {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ai-field-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ai-field-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        /* Skip toggle */
        .skip-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .skip-toggle-track {
            position: relative;
            width: 34px;
            height: 18px;
            border: 1.5px solid rgba(44, 36, 33, 0.2);
            border-radius: 20px;
            background: var(--ivory);
            transition: background 0.25s ease, border-color 0.25s ease;
            flex-shrink: 0;
        }

        .skip-toggle input:checked~.skip-toggle-track {
            background: var(--charcoal);
            border-color: var(--charcoal);
        }

        .skip-toggle-knob {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(44, 36, 33, 0.4);
            transition: transform 0.25s var(--ease-out-expo), background 0.25s ease;
        }

        .skip-toggle input:checked~.skip-toggle-track .skip-toggle-knob {
            transform: translateX(16px);
            background: var(--cream);
        }

        .skip-toggle input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        .skip-label-text {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--warm-grey);
        }

        /* Input styles */
        .ai-input,
        .ai-select {
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--charcoal);
            background: var(--ivory);
            border: 1px solid rgba(44, 36, 33, 0.15);
            border-radius: 2px;
            padding: 13px 16px;
            width: 100%;
            transition: border-color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
            outline: none;
            -moz-appearance: textfield;
            appearance: none;
        }

        .ai-input:focus,
        .ai-select:focus {
            border-color: var(--rose);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(212, 132, 122, 0.1);
        }

        .ai-input:disabled,
        .ai-select:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: var(--cream-dark);
        }

        .ai-input-wrap {
            position: relative;
        }

        .ai-input-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            font-weight: 500;
            color: var(--warm-grey);
            pointer-events: none;
        }

        .ai-input.has-prefix {
            padding-left: 42px;
        }

        .ai-input-hint {
            font-size: 12px;
            font-weight: 300;
            color: var(--warm-grey);
            line-height: 1.5;
        }

        /* Select wrapper */
        .ai-select-wrap {
            position: relative;
        }

        .ai-select-wrap::after {
            content: '';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid var(--warm-grey);
            pointer-events: none;
        }

        .ai-select {
            cursor: pointer;
            padding-right: 36px;
        }

        /* Color picker grid */
        .color-picker-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .color-pick-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border: 1.5px solid rgba(44, 36, 33, 0.12);
            border-radius: 2px;
            background: var(--ivory);
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 400;
            color: var(--charcoal-mid);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .color-pick-btn input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .color-pick-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 1px solid rgba(44, 36, 33, 0.15);
            flex-shrink: 0;
        }

        .color-pick-btn:hover {
            border-color: var(--rose);
            color: var(--charcoal);
        }

        .color-pick-btn.selected {
            border-color: var(--charcoal);
            background: var(--charcoal);
            color: var(--cream);
        }

        .color-pick-btn.selected .color-pick-dot {
            border-color: rgba(248, 243, 236, 0.3);
        }

        /* Budget range slider */
        .budget-slider {
            width: 100%;
            height: 3px;
            -webkit-appearance: none;
            appearance: none;
            background: var(--cream-dark);
            border-radius: 0;
            outline: none;
            border: none;
            cursor: pointer;
            margin-top: 8px;
        }

        .budget-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--charcoal);
            border: 2px solid var(--cream);
            box-shadow: 0 2px 8px rgba(44, 36, 33, 0.3);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .budget-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .budget-display {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-top: 8px;
        }

        .budget-value {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 400;
            color: var(--charcoal);
            letter-spacing: -0.01em;
        }

        .budget-range-labels {
            font-size: 11px;
            color: var(--warm-grey);
        }

        /* Divider */
        .form-divider {
            height: 1px;
            background: rgba(44, 36, 33, 0.07);
            margin: 0 -32px;
        }

        /* Submit button */
        .ai-submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 18px 32px;
            background: var(--charcoal);
            color: var(--cream);
            border: none;
            border-radius: 2px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ai-submit-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--rose-deep), var(--rose));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .ai-submit-btn:hover::before {
            opacity: 1;
        }

        .ai-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(44, 36, 33, 0.25);
        }

        .ai-submit-btn span,
        .ai-submit-btn svg {
            position: relative;
            z-index: 1;
        }

        .ai-submit-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            transition: transform 0.3s var(--ease-out-expo);
        }

        .ai-submit-btn:hover svg {
            transform: translateX(4px);
        }

        /* ================================================================
                                                       RIGHT PANEL — HOW IT WORKS
                                                    ================================================================ */
        .ai-info-panel {
            display: flex;
            flex-direction: column;
            gap: 24px;
            position: sticky;
            top: calc(var(--nav-height) + 32px);
        }

        .info-card {
            background: var(--charcoal);
            color: var(--cream);
            padding: 28px;
            border-radius: 2px;
        }

        .info-card-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--rose-light);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card-title::before {
            content: '';
            display: block;
            width: 16px;
            height: 1px;
            background: var(--rose-light);
        }

        .how-step {
            display: flex;
            gap: 14px;
            margin-bottom: 18px;
        }

        .how-step:last-child {
            margin-bottom: 0;
        }

        .how-step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1px solid rgba(248, 243, 236, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: var(--rose-light);
            flex-shrink: 0;
        }

        .how-step-text {
            font-size: 13px;
            font-weight: 300;
            color: rgba(248, 243, 236, 0.75);
            line-height: 1.7;
        }

        .how-step-text strong {
            color: var(--cream);
            font-weight: 500;
        }

        .algo-card {
            background: var(--white, #fff);
            border: 1px solid rgba(44, 36, 33, 0.08);
            padding: 24px 28px;
            border-radius: 2px;
        }

        .algo-card-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: 16px;
        }

        .algo-tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .algo-tag {
            font-size: 11px;
            font-weight: 500;
            color: var(--charcoal-mid);
            background: var(--cream-dark);
            border: 1px solid rgba(44, 36, 33, 0.08);
            padding: 5px 12px;
            border-radius: 20px;
            letter-spacing: 0.04em;
        }

        .algo-tag.accent {
            background: rgba(212, 132, 122, 0.12);
            border-color: rgba(212, 132, 122, 0.25);
            color: var(--rose-deep);
        }

        /* Tips card */
        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
            font-size: 13px;
            font-weight: 300;
            color: var(--charcoal-mid);
            line-height: 1.7;
        }

        .tip-item:last-child {
            margin-bottom: 0;
        }

        .tip-item::before {
            content: '';
            display: block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--rose);
            flex-shrink: 0;
            margin-top: 8px;
        }

        /* Tips Revamp */
        .tip-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .tip-card {
            padding: 14px 16px;
            border: 1px solid rgba(44, 36, 33, 0.08);
            background: var(--cream-dark);
            border-radius: 2px;
            transition: all 0.25s ease;
        }

        .tip-card:hover {
            border-color: var(--rose);
            transform: translateY(-2px);
        }

        .tip-title {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: 4px;
        }

        .tip-card p {
            font-size: 12.5px;
            color: var(--charcoal-mid);
            line-height: 1.6;
            margin: 0;
        }

        /* ================================================================
                                                       PREVIOUS RESULTS SECTION
                                                    ================================================================ */
        @if (isset($products) && count($products) > 0)
            .prev-results {
                padding: clamp(40px, 5vw, 72px) clamp(24px, 6vw, 100px);
                border-top: 1px solid rgba(44, 36, 33, 0.08);
                background: var(--ivory);
            }
        @endif

        /* ================================================================
                                                       RESPONSIVE
                                                    ================================================================ */
        @media (max-width: 1024px) {
            .ai-main {
                grid-template-columns: 1fr;
            }

            .ai-info-panel {
                position: static;
                display: grid;
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .ai-info-panel {
                grid-template-columns: 1fr;
            }

            .form-panel-body {
                padding: 24px;
            }

            .form-panel-header {
                padding: 20px 24px 16px;
            }

            .color-picker-grid {
                gap: 7px;
            }

            .color-pick-btn {
                padding: 7px 11px;
                font-size: 11px;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ================================================================
     PAGE HERO
================================================================ --}}
    <header class="ai-hero" aria-label="AI Recommendation hero">

        {{-- Animated petals --}}
        <div class="ai-hero-deco" aria-hidden="true">
            @for ($p = 0; $p < 12; $p++)
                <div class="ai-petal"
                    style="
                left: {{ rand(5, 95) }}%;
                bottom: -10px;
                animation-duration: {{ rand(8, 16) }}s;
                animation-delay: {{ rand(0, 10) }}s;
                width: {{ rand(4, 8) }}px;
                height: {{ rand(4, 8) }}px;
                opacity: 0;
            ">
                </div>
            @endfor
        </div>

        <div class="ai-hero-grain" aria-hidden="true"></div>
        <div class="ai-hero-overlay" aria-hidden="true"></div>

        <div class="ai-hero-content">
            <p class="ai-hero-eyebrow">Rekomendasi AI</p>
            <h1 class="ai-hero-title">
                <span class="ai-hero-title-inner">
                    <span class="ai-hero-title-line">Temukan</span>
                </span>
                <span class="ai-hero-title-inner">
                    <span class="ai-hero-title-line">Buket <em>Idealmu</em></span>
                </span>
            </h1>
            <p class="ai-hero-sub">
                Sistem kecerdasan buatan kami menganalisis budget, acara, dan preferensi warnamu untuk menemukan buket yang
                paling cocok dari koleksi Maw Bouquet.
            </p>
        </div>
    </header>

    {{-- ================================================================
     MAIN: FORM + INFO PANEL
================================================================ --}}
    <div class="ai-main">

        {{-- ================================================================
         FORM PANEL
    ================================================================ --}}
        <div class="ai-form-panel reveal">

            <div class="form-panel-header">
                <p class="form-panel-title">Kriteria Pencarian</p>
                <div style="font-size: 11px; color: var(--warm-grey); font-weight: 300;">
                    Isi sesuai kebutuhanmu
                </div>
            </div>

            <form method="POST" action="{{ route('ai.process') }}" id="ai-form">
                @csrf

                <div class="form-panel-body">

                    {{-- ---- BUDGET ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label" for="inp-budget">Budget</label>
                            <label class="skip-toggle" for="skip-budget" title="Abaikan kriteria budget">
                                <input type="checkbox" id="skip-budget" name="skip_budget" value="1"
                                    class="skip-checkbox" data-target="inp-budget" data-slider="budget-slider"
                                    {{ old('skip_budget') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="budget-display">
                            <span class="budget-value" id="budget-display">
                                Rp <span
                                    id="budget-val">{{ old('budget', 150000) ? number_format(old('budget', 150000), 0, ',', '.') : '150.000' }}</span>
                            </span>
                            <span class="budget-range-labels">Rp 50rb — Rp 1jt</span>
                        </div>

                        <input type="range" class="budget-slider" id="budget-slider" min="50000" max="1000000"
                            step="10000" value="{{ old('budget', 150000) }}" />

                        <input type="hidden" name="budget" id="inp-budget" value="{{ old('budget', 150000) }}" />

                        <p class="ai-input-hint">Seret slider untuk menyesuaikan budget. Pilih "Skip" untuk mengabaikan
                            filter ini.</p>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- KATEGORI ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label" for="inp-kategori">Kategori</label>
                            <label class="skip-toggle" for="skip-kategori" title="Abaikan kriteria kategori">
                                <input type="checkbox" id="skip-kategori" name="skip_kategori" value="1"
                                    class="skip-checkbox" data-target="inp-kategori"
                                    {{ old('skip_kategori') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="ai-select-wrap">
                            <select name="kategori" id="inp-kategori" class="ai-select"
                                {{ old('skip_kategori') ? 'disabled' : '' }}>
                                <option value="buket_segar" {{ old('kategori') == 'buket_segar' ? 'selected' : '' }}>
                                    Buket Segar
                                </option>
                                <option value="buket_kering" {{ old('kategori') == 'buket_kering' ? 'selected' : '' }}>
                                    Buket Kering
                                </option>
                                <option value="pampas" {{ old('kategori') == 'pampas' ? 'selected' : '' }}>
                                    Pampas
                                </option>
                                <option value="mini_bouquet" {{ old('kategori') == 'mini_bouquet' ? 'selected' : '' }}>
                                    Mini Bouquet
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- WARNA ---- --}}
                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label">Preferensi Warna</label>
                            <label class="skip-toggle" for="skip-warna" title="Abaikan kriteria warna">
                                <input type="checkbox" id="skip-warna" name="skip_warna" value="1"
                                    class="skip-checkbox" data-target="color-picker-group"
                                    {{ old('skip_warna') ? 'checked' : '' }} />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="color-picker-grid" id="color-picker-group"
                            style="{{ old('skip_warna') ? 'opacity:0.4; pointer-events:none;' : '' }}">
                            @php
                                $colorOptions = [
                                    [
                                        'value' => 'bebas',
                                        'label' => 'Bebas',
                                        'hex' => 'linear-gradient(135deg,#e8a0a0,#d4b8d4,#c2f0c2,#f5deb3)',
                                    ],
                                    ['value' => 'pink', 'label' => 'Pink', 'hex' => '#e8a0a0'],
                                    ['value' => 'putih', 'label' => 'Putih', 'hex' => '#f5f5f0'],
                                    ['value' => 'merah', 'label' => 'Merah', 'hex' => '#dc6060'],
                                    ['value' => 'kuning', 'label' => 'Kuning', 'hex' => '#f5d66a'],
                                    ['value' => 'ungu', 'label' => 'Ungu', 'hex' => '#d4b8d4'],
                                    [
                                        'value' => 'campur',
                                        'label' => 'Mix',
                                        'hex' => 'linear-gradient(135deg,#e8a0a0,#c2f0c2,#b0c4de)',
                                    ],
                                ];
                                $selectedColor = old('warna', 'bebas');
                            @endphp

                            @foreach ($colorOptions as $col)
                                <label class="color-pick-btn {{ $selectedColor === $col['value'] ? 'selected' : '' }}"
                                    data-value="{{ $col['value'] }}">
                                    <input type="radio" name="warna" value="{{ $col['value'] }}"
                                        {{ $selectedColor === $col['value'] ? 'checked' : '' }} />
                                    <span class="color-pick-dot"
                                        style="background: {{ $col['hex'] }}; {{ $col['value'] === 'putih' ? 'border: 1.5px solid rgba(44,36,33,0.2);' : '' }}"></span>
                                    {{ $col['label'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="ai-field">
                        <div class="ai-field-header">
                            <label class="ai-field-label">Ukuran Buket</label>
                            <label class="skip-toggle" for="skip-ukuran">
                                <input type="checkbox" id="skip-ukuran" name="skip_ukuran" class="skip-checkbox"
                                    data-target="inp-ukuran" />
                                <div class="skip-toggle-track">
                                    <div class="skip-toggle-knob"></div>
                                </div>
                                <span class="skip-label-text">Skip</span>
                            </label>
                        </div>

                        <div class="ai-select-wrap">
                            <select name="ukuran" id="inp-ukuran" class="ai-select">
                                <option value="kecil">Kecil</option>
                                <option value="sedang">Sedang</option>
                                <option value="besar">Besar</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- ---- SUBMIT ---- --}}
                    <button type="submit" class="ai-submit-btn" id="submit-btn">
                        <span>Temukan Buket Untukku</span>
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>

                </div>
            </form>
        </div>

        {{-- ================================================================
         INFO / TIPS PANEL
    ================================================================ --}}
        <aside class="ai-info-panel" aria-label="Informasi sistem">

            {{-- HOW IT WORKS --}}
            <div class="info-card reveal delay-1">
                <p class="info-card-title">Cara Memilih Buketmu</p>
                <div class="how-step">
                    <div class="how-step-num">1</div>
                    <div class="how-step-text">
                        <strong>Ceritakan Kebutuhanmu: </strong> pilih budget, momen, dan warna yang kamu inginkan. Tidak
                        wajib semua diisi.
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-step-num">2</div>
                    <div class="how-step-text">
                        <strong>Kami Pilihkan Untukmu: </strong> sistem kami akan mencocokkan dengan koleksi buket terbaik
                        yang paling sesuai.
                    </div>
                </div>

                <div class="how-step">
                    <div class="how-step-num">3</div>
                    <div class="how-step-text">
                        <strong>Pilih & Pesan: </strong> lihat rekomendasi buket, lalu pesan dengan mudah melalui WhatsApp.
                    </div>
                </div>
            </div>

            {{-- ALGORITHM TAGS --}}
            <div class="algo-card reveal delay-2">
                <p class="algo-card-title">Kenapa Rekomendasi Ini Cocok?</p>
                <div class="algo-tag-list">
                    <span class="algo-tag accent">Dipersonalisasi</span>
                    <span class="algo-tag accent">Sesuai Budget</span>
                    <span class="algo-tag">Berdasarkan Momen</span>
                    <span class="algo-tag">Preferensi Warna</span>
                    <span class="algo-tag">Pilihan Terbaik</span>
                </div>
            </div>

            {{-- TIPS --}}
            <div class="algo-card reveal delay-3">
                <p class="algo-card-title">Panduan Cepat</p>
                <div class="tip-grid">
                    <div class="tip-card">
                        <span class="tip-title">Eksplor Semua</span>
                        <p>Aktifkan <strong>Skip</strong> untuk melihat semua pilihan tanpa batasan.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Warna Fleksibel</span>
                        <p>Pilih <strong>Bebas</strong> untuk variasi buket yang lebih luas.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Momen Spesial</span>
                        <p>Gunakan <strong>Romantis</strong> untuk anniversary atau ungkapan perasaan.</p>
                    </div>
                    <div class="tip-card">
                        <span class="tip-title">Hasil Terbaik</span>
                        <p>Kami menampilkan buket paling relevan di urutan teratas.</p>
                    </div>
                </div>
            </div>

        </aside>
    </div>

    {{-- ================================================================
     PREVIOUS RESULTS (if any from session / old submission)
================================================================ --}}
    @if (isset($products) && count($products) > 0)
        <section class="prev-results" aria-label="Hasil rekomendasi sebelumnya">
            <div style="margin-bottom: 40px;">
                <span class="section-label">Hasil Terakhir</span>
                <h2
                    style="font-family: var(--font-display); font-size: clamp(28px,3.5vw,44px); font-weight:300; color:var(--charcoal); margin-top:8px;">
                    Rekomendasi <em style="font-style:italic; color:var(--rose);">Untukmu</em>
                </h2>
            </div>

            <div class="products-listing product-grid"
                style="display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:28px;">
                @foreach ($products as $i => $product)
                    <article class="product-card reveal delay-{{ min($i + 1, 6) }}">
                        <div class="product-card-img-wrap">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="product-card-img" loading="lazy" />
                            </a>
                            <div class="product-card-quick">
                                <a href="#" class="product-quick-btn wa-order" data-name="{{ $product->name }}"
                                    data-price="{{ number_format($product->price, 0, ',', '.') }}"
                                    data-url="{{ route('products.show', $product->id) }}">
                                    Pesan via WhatsApp
                                </a>
                            </div>
                        </div>
                        <div class="product-card-meta">
                            <p class="product-card-category">{{ $product->category }}</p>
                            <h3 class="product-card-name">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        // ================================================================
        //  INIT
        // ================================================================
        document.addEventListener('DOMContentLoaded', () => {

            const inpBudget = document.getElementById('inp-budget');
            const budgetSlider = document.getElementById('budget-slider');

            // ================================================================
            //  HELPER: UPDATE BUDGET DISPLAY
            // ================================================================
            const updateBudgetDisplay = (value) => {
                const el = document.getElementById('budget-val');
                if (!el) return;
                el.textContent = new Intl.NumberFormat('id-ID').format(value);
            };

            // ================================================================
            //  BUDGET SLIDER
            // ================================================================
            if (budgetSlider) {
                updateBudgetDisplay(budgetSlider.value);

                budgetSlider.addEventListener('input', () => {
                    updateBudgetDisplay(budgetSlider.value);
                    if (inpBudget && !budgetSlider.disabled) {
                        inpBudget.value = budgetSlider.value;
                    }
                });
            }

            // ================================================================
            //  HANDLE SKIP TOGGLE (UNIFIED)
            // ================================================================
            const handleSkipToggle = (checkbox) => {
                const targetId = checkbox.dataset.target;
                const sliderId = checkbox.dataset.slider;

                const target = document.getElementById(targetId);
                const slider = sliderId ? document.getElementById(sliderId) : null;

                // Disable input/select
                if (target && targetId !== 'color-picker-group') {
                    target.disabled = checkbox.checked;
                }

                // Special: color picker group
                if (targetId === 'color-picker-group') {
                    const group = document.getElementById('color-picker-group');
                    if (group) {
                        group.style.opacity = checkbox.checked ? '0.4' : '1';
                        group.style.pointerEvents = checkbox.checked ? 'none' : '';
                        group.querySelectorAll('input').forEach(input => {
                            input.disabled = checkbox.checked;
                        });
                    }
                }

                // Handle slider
                if (slider) {
                    slider.disabled = checkbox.checked;
                }

                // Special: budget value
                if (targetId === 'inp-budget' && inpBudget && budgetSlider) {
                    inpBudget.value = checkbox.checked ? '' : budgetSlider.value;
                }
            };

            // Attach event listener
            document.querySelectorAll('.skip-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    handleSkipToggle(this);
                });

                // INIT state (important for old() Laravel)
                handleSkipToggle(cb);
            });

            // ================================================================
            //  COLOR PICK BUTTONS
            // ================================================================
            document.querySelectorAll('.color-pick-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.color-pick-btn')
                        .forEach(b => b.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // ================================================================
            //  WHATSAPP ORDER
            // ================================================================
            document.querySelectorAll('.wa-order').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const name = this.dataset.name;
                    const price = this.dataset.price;
                    const link = this.dataset.url;

                    const messages = [
                        `Halo Maw Bouquet, saya tertarik dengan produk ${name} dengan harga Rp ${price}. Apakah masih tersedia? Link: ${link}`,
                        `Permisi kak, saya menemukan ${name} (Rp ${price}) di website Maw Bouquet dan ingin memesan. Masih ada stok? ${link}`,
                    ];

                    const msg = messages[Math.floor(Math.random() * messages.length)];
                    window.open(
                        'https://wa.me/6282333000472?text=' + encodeURIComponent(msg),
                        '_blank'
                    );
                });
            });

            // ================================================================
            //  SUBMIT LOADING STATE
            // ================================================================
            const form = document.getElementById('ai-form');
            const submitBtn = document.getElementById('submit-btn');

            if (form && submitBtn) {
                form.addEventListener('submit', () => {
                    submitBtn.innerHTML = `
                <svg style="width:18px;height:18px;stroke:currentColor;fill:none;animation:spin 1s linear infinite" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="40" stroke-dashoffset="10"/>
                </svg>
                <span>Sedang Menganalisis...</span>
            `;
                    submitBtn.disabled = true;
                });
            }

            // ================================================================
            //  SCROLL REVEAL
            // ================================================================
            const revealEls = document.querySelectorAll('.reveal');

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -20px 0px'
            });

            revealEls.forEach(el => observer.observe(el));

        });

        // ================================================================
        //  GLOBAL CSS ANIMATION (SPINNER)
        // ================================================================
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }`;
        document.head.appendChild(style);
    </script>
@endpush
