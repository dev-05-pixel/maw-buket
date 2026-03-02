@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
/* ================================================================
   CSS VARIABLES (ROOT)
================================================================ */
:root {
    --cream: #f8f3ec;
    --cream-dark: #f0e8de;
    --ivory: #fcf9f5;
    --charcoal: #2c2421;
    --charcoal-mid: #4a3f3a;
    --rose: #d4847a;
    --rose-deep: #b86b61;
    --rose-light: #e6b2aa;
    --warm-grey: #8e7e76;
    --sand: #d9c7b9;
    --terracotta: #c9775e;
    --white: #ffffff;

    --font-display: 'Playfair Display', serif;
    --font-body: 'Poppins', sans-serif;

    --section-gap: clamp(80px, 12vw, 140px);
    --ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
}

/* ----------------------------------------------------------------
   BASE RESET / UTILITY CLASSES
---------------------------------------------------------------- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-body);
    background-color: var(--cream);
    color: var(--charcoal);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Buttons */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--rose);
    color: var(--white);
    border: none;
    padding: 16px 36px;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 2px;
    transition: background 0.4s ease, transform 0.3s var(--ease-out-expo);
    cursor: pointer;
}

.btn-primary:hover {
    background: var(--rose-deep);
    transform: translateY(-3px);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    color: var(--charcoal);
    border: 1px solid var(--charcoal);
    padding: 15px 34px;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 2px;
    transition: background 0.4s ease, color 0.4s ease, transform 0.3s var(--ease-out-expo);
    cursor: pointer;
}

.btn-outline:hover {
    background: var(--charcoal);
    color: var(--cream);
    transform: translateY(-3px);
}

/* Section label */
.section-label {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 24px;
}

.section-label::before {
    content: '';
    display: block;
    width: 40px;
    height: 1px;
    background: var(--rose);
}

/* Reveal animation classes */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
}

.reveal.delay-1 { transition-delay: 0.15s; }
.reveal.delay-2 { transition-delay: 0.3s; }
.reveal.delay-3 { transition-delay: 0.45s; }
.reveal.delay-4 { transition-delay: 0.6s; }

.reveal-left {
    opacity: 0;
    transform: translateX(-40px);
    transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
}

.reveal-right {
    opacity: 0;
    transform: translateX(40px);
    transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
}

/* Untuk elemen yang sudah muncul (biasanya ditambahkan via JavaScript) */
.reveal.active,
.reveal-left.active,
.reveal-right.active {
    opacity: 1;
    transform: translate(0);
}

/* ================================================================
   HOME PAGE STYLES
================================================================ */

/* ----------------------------------------------------------------
   HERO SECTION
---------------------------------------------------------------- */
.hero {
    position: relative;
    min-height: 100svh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    background: var(--cream);
}

.hero-left {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: clamp(40px, 6vw, 100px) clamp(30px, 5vw, 80px);
    padding-right: 40px;
    z-index: 2;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 28px;
    overflow: hidden;
}

.hero-eyebrow-line {
    display: block;
    width: 40px;
    height: 1px;
    background: var(--rose);
    transform: scaleX(0);
    transform-origin: left;
    animation: lineGrow 0.8s 1.8s var(--ease-out-expo) forwards;
}

.hero-eyebrow-text {
    opacity: 0;
    transform: translateY(100%);
    animation: textUp 0.7s 2s var(--ease-out-expo) forwards;
}

@keyframes lineGrow {
    to { transform: scaleX(1); }
}

@keyframes textUp {
    to { opacity: 1; transform: translateY(0); }
}

.hero-title {
    font-family: var(--font-display);
    font-size: clamp(52px, 7.5vw, 110px);
    font-weight: 300;
    line-height: 1.1;
    letter-spacing: -0.01em;
    color: var(--charcoal);
    margin-bottom: 32px;
    overflow: hidden;
}

.hero-title-line {
    display: block;
    overflow: hidden;
}

.hero-title-inner {
    display: block;
    transform: translateY(110%);
    animation: titleReveal 1s var(--ease-out-expo) forwards;
}

.hero-title-line:nth-child(1) .hero-title-inner { animation-delay: 1.9s; }
.hero-title-line:nth-child(2) .hero-title-inner { animation-delay: 2.05s; }
.hero-title-line:nth-child(3) .hero-title-inner { animation-delay: 2.2s; }

.hero-title em {
    font-style: italic;
    color: var(--rose);
}

@keyframes titleReveal {
    to { transform: translateY(0); }
}

.hero-desc {
    font-size: clamp(14px, 1.4vw, 16px);
    font-weight: 300;
    color: var(--charcoal-mid);
    max-width: 380px;
    line-height: 1.9;
    margin-bottom: 44px;
    opacity: 0;
    transform: translateY(24px);
    animation: fadeUp 0.9s 2.4s var(--ease-out-expo) forwards;
}

@keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
}

.hero-actions {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(24px);
    animation: fadeUp 0.9s 2.6s var(--ease-out-expo) forwards;
}

.hero-scroll-hint {
    position: absolute;
    bottom: 40px;
    left: clamp(30px, 5vw, 80px);
    display: flex;
    align-items: center;
    gap: 12px;
    opacity: 0;
    animation: fadeUp 0.8s 3s var(--ease-out-expo) forwards;
}

.hero-scroll-hint span {
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    color: var(--warm-grey);
}

.scroll-arrow {
    width: 24px;
    height: 36px;
    border: 1.5px solid var(--warm-grey);
    border-radius: 12px;
    position: relative;
    display: flex;
    justify-content: center;
}

.scroll-arrow::after {
    content: '';
    position: absolute;
    top: 6px;
    width: 5px;
    height: 5px;
    background: var(--warm-grey);
    border-radius: 50%;
    animation: scrollDot 1.8s ease-in-out infinite;
}

@keyframes scrollDot {
    0% { top: 6px; opacity: 1; }
    70% { top: 18px; opacity: 0.3; }
    100% { top: 6px; opacity: 1; }
}

/* Hero right — image mosaic */
.hero-right {
    position: relative;
    overflow: hidden;
}

.hero-img-main {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.08);
    animation: heroImgReveal 1.6s 1.6s var(--ease-out-expo) forwards;
}

@keyframes heroImgReveal {
    to { transform: scale(1); }
}

.hero-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(105deg, var(--cream) 0%, transparent 40%);
    z-index: 1;
}

/* Floating badge */
.hero-badge {
    position: absolute;
    bottom: 60px;
    left: -36px;
    z-index: 3;
    background: var(--charcoal);
    color: var(--cream);
    padding: 20px 28px;
    border-radius: 4px;
    animation: badgeFloat 4s ease-in-out infinite;
    box-shadow: 0 20px 60px rgba(44, 36, 33, 0.25);
}

.hero-badge-num {
    font-family: var(--font-display);
    font-size: 38px;
    font-weight: 300;
    line-height: 1;
    margin-bottom: 4px;
}

.hero-badge-label {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(248,243,236,0.6);
}

@keyframes badgeFloat {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-8px); }
}

/* Decorative elements */
.hero-deco-circle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.hero-deco-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(212, 132, 122, 0.12) 0%, transparent 70%);
    bottom: -150px;
    left: -100px;
    animation: pulseSlow 8s ease-in-out infinite;
}

.hero-deco-2 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(122, 155, 122, 0.1) 0%, transparent 70%);
    top: 100px;
    right: 200px;
    animation: pulseSlow 10s ease-in-out infinite reverse;
}

@keyframes pulseSlow {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.15); }
}

/* ----------------------------------------------------------------
   MARQUEE / TICKER
---------------------------------------------------------------- */
.marquee-section {
    background: var(--charcoal);
    padding: 18px 0;
    overflow: hidden;
    position: relative;
    z-index: 2;
}

.marquee-track {
    display: flex;
    gap: 0;
    animation: marqueeScroll 28s linear infinite;
    white-space: nowrap;
}

.marquee-track:hover {
    animation-play-state: paused;
}

.marquee-item {
    display: inline-flex;
    align-items: center;
    gap: 24px;
    padding-right: 48px;
    flex-shrink: 0;
}

.marquee-text {
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 300;
    letter-spacing: 0.12em;
    color: rgba(248, 243, 236, 0.75);
    text-transform: uppercase;
    font-style: italic;
}

.marquee-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: var(--rose);
    flex-shrink: 0;
}

@keyframes marqueeScroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

/* ----------------------------------------------------------------
   ABOUT / INTRO SECTION
---------------------------------------------------------------- */
.about-section {
    padding: var(--section-gap) clamp(24px, 6vw, 100px);
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: clamp(48px, 7vw, 120px);
    align-items: center;
}

.about-img-wrap {
    position: relative;
}

.about-img-main {
    width: 100%;
    height: clamp(380px, 52vw, 600px);
    object-fit: cover;
    border-radius: 2px;
}

.about-img-accent {
    position: absolute;
    width: 48%;
    height: 52%;
    object-fit: cover;
    border-radius: 2px;
    bottom: -40px;
    right: -36px;
    border: 6px solid var(--cream);
    box-shadow: 0 24px 60px rgba(44, 36, 33, 0.12);
}

.about-img-tag {
    position: absolute;
    top: 40px;
    right: -28px;
    background: var(--rose);
    color: var(--white);
    padding: 10px 18px;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    writing-mode: vertical-rl;
    border-radius: 2px;
}

.about-content {}

.about-title {
    font-family: var(--font-display);
    font-size: clamp(38px, 4.5vw, 62px);
    font-weight: 300;
    line-height: 1.1;
    color: var(--charcoal);
    margin-bottom: 28px;
}

.about-title em {
    font-style: italic;
    color: var(--rose);
}

.about-body {
    font-size: 15px;
    font-weight: 300;
    color: var(--charcoal-mid);
    line-height: 1.95;
    margin-bottom: 20px;
}

.about-divider {
    width: 60px;
    height: 1px;
    background: linear-gradient(90deg, var(--rose), var(--sand));
    margin: 32px 0;
}

.about-stats {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 24px;
    margin-top: 40px;
}

.about-stat-num {
    font-family: var(--font-display);
    font-size: clamp(36px, 4vw, 52px);
    font-weight: 300;
    color: var(--charcoal);
    line-height: 1;
    margin-bottom: 6px;
}

.about-stat-num sup {
    font-size: 0.45em;
    vertical-align: super;
}

.about-stat-label {
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--warm-grey);
}

/* ----------------------------------------------------------------
   PRODUCTS PREVIEW / FEATURED
---------------------------------------------------------------- */
.products-section {
    padding: var(--section-gap) clamp(24px, 6vw, 100px);
    background: var(--ivory);
    position: relative;
}

.products-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--cream-dark), transparent);
}

.products-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 56px;
    flex-wrap: wrap;
    gap: 24px;
}

.products-title {
    font-family: var(--font-display);
    font-size: clamp(40px, 5vw, 72px);
    font-weight: 300;
    line-height: 1.05;
    color: var(--charcoal);
}

.products-title em {
    font-style: italic;
    color: var(--rose);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.product-card {
    position: relative;
    cursor: pointer;
}

.product-card-img-wrap {
    position: relative;
    overflow: hidden;
    border-radius: 2px;
    margin-bottom: 20px;
    background: var(--cream-dark);
}

.product-card-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(44, 36, 33, 0);
    transition: background 0.5s ease;
}

.product-card:hover .product-card-img-wrap::after {
    background: rgba(44, 36, 33, 0.08);
}

.product-card-img {
    width: 100%;
    aspect-ratio: 3/4;
    object-fit: cover;
    transition: transform 0.7s var(--ease-out-expo);
    display: block;
}

.product-card:hover .product-card-img {
    transform: scale(1.06);
}

.product-card-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 1;
    background: var(--rose);
    color: var(--white);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 1px;
}

.product-card-quick {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    z-index: 2;
    display: flex;
    gap: 8px;
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.4s ease, transform 0.4s var(--ease-out-expo);
}

.product-card:hover .product-card-quick {
    opacity: 1;
    transform: translateY(0);
}

.product-quick-btn {
    flex: 1;
    background: var(--charcoal);
    color: var(--cream);
    border: none;
    cursor: pointer;
    font-family: var(--font-body);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 11px 14px;
    border-radius: 2px;
    text-align: center;
    transition: background 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.product-quick-btn:hover {
    background: var(--rose-deep);
}

.product-card-category {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 8px;
}

.product-card-name {
    font-family: var(--font-display);
    font-size: clamp(18px, 1.8vw, 22px);
    font-weight: 400;
    color: var(--charcoal);
    margin-bottom: 8px;
    transition: color 0.3s ease;
}

.product-card:hover .product-card-name {
    color: var(--rose-deep);
}

.product-card-price {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 500;
    color: var(--charcoal);
}

.product-card-price span {
    font-size: 13px;
    font-weight: 300;
    color: var(--warm-grey);
    margin-left: 4px;
}

/* ----------------------------------------------------------------
   CATEGORIES SECTION
---------------------------------------------------------------- */
.categories-section {
    padding: var(--section-gap) clamp(24px, 6vw, 100px);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.category-card {
    position: relative;
    overflow: hidden;
    border-radius: 2px;
    cursor: pointer;
    display: block;
    text-decoration: none;
}

.category-card:first-child {
    grid-row: span 2;
}

.category-img {
    width: 100%;
    height: 100%;
    min-height: 220px;
    object-fit: cover;
    transition: transform 0.8s var(--ease-out-expo);
    display: block;
}

.category-card:first-child .category-img {
    min-height: 480px;
}

.category-card:hover .category-img {
    transform: scale(1.07);
}

.category-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(44, 36, 33, 0.65) 100%);
    transition: background 0.5s ease;
}

.category-card:hover .category-overlay {
    background: linear-gradient(180deg, transparent 20%, rgba(44, 36, 33, 0.75) 100%);
}

.category-content {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 24px;
    color: var(--cream);
}

.category-name {
    font-family: var(--font-display);
    font-size: clamp(18px, 2vw, 26px);
    font-weight: 400;
    margin-bottom: 4px;
}

.category-count {
    font-size: 11px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: rgba(248, 243, 236, 0.65);
}

.category-arrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--rose-light);
    margin-top: 12px;
    opacity: 0;
    transform: translateY(8px);
    transition: opacity 0.3s ease, transform 0.3s var(--ease-out-expo);
}

.category-card:hover .category-arrow {
    opacity: 1;
    transform: translateY(0);
}

/* ----------------------------------------------------------------
   PROCESS / HOW TO ORDER
---------------------------------------------------------------- */
.process-section {
    padding: var(--section-gap) clamp(24px, 6vw, 100px);
    background: var(--charcoal);
    color: var(--cream);
    position: relative;
    overflow: hidden;
}

.process-section::before {
    content: 'ORDER';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: var(--font-display);
    font-size: clamp(80px, 18vw, 240px);
    font-weight: 700;
    color: rgba(255,255,255,0.03);
    pointer-events: none;
    white-space: nowrap;
    letter-spacing: 0.1em;
}

.process-header {
    text-align: center;
    margin-bottom: 72px;
}

.process-label {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--rose-light);
    margin-bottom: 20px;
}

.process-label::before,
.process-label::after {
    content: '';
    display: block;
    width: 32px;
    height: 1px;
    background: var(--rose-light);
    opacity: 0.5;
}

.process-title {
    font-family: var(--font-display);
    font-size: clamp(36px, 4.5vw, 60px);
    font-weight: 300;
    line-height: 1.1;
}

.process-title em {
    font-style: italic;
    color: var(--rose-light);
}

.process-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    position: relative;
}

.process-steps::before {
    content: '';
    position: absolute;
    top: 28px;
    left: calc(12.5% + 20px);
    right: calc(12.5% + 20px);
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--rose) 20%, var(--sand) 80%, transparent);
    opacity: 0.3;
}

.process-step {
    text-align: center;
    position: relative;
}

.process-step-num {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: 1px solid rgba(212, 132, 122, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 28px;
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 300;
    color: var(--rose-light);
    position: relative;
    z-index: 1;
    background: var(--charcoal);
    transition: background 0.4s ease, border-color 0.4s ease;
}

.process-step:hover .process-step-num {
    background: var(--rose);
    border-color: var(--rose);
    color: var(--white);
}

.process-step-icon {
    margin: 0 auto 16px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.process-step-icon svg {
    width: 24px;
    height: 24px;
    stroke: var(--rose-light);
}

.process-step-name {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 400;
    margin-bottom: 12px;
    color: var(--cream);
}

.process-step-desc {
    font-size: 14px;
    font-weight: 300;
    color: rgba(248, 243, 236, 0.55);
    line-height: 1.8;
}

/* ----------------------------------------------------------------
   TESTIMONIALS
---------------------------------------------------------------- */
.testimonials-section {
    padding: var(--section-gap) clamp(24px, 6vw, 100px);
    background: var(--cream-dark);
    position: relative;
    overflow: hidden;
}

.testimonials-bg-word {
    position: absolute;
    font-family: var(--font-display);
    font-size: clamp(80px, 18vw, 220px);
    font-weight: 700;
    color: rgba(212, 132, 122, 0.05);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    white-space: nowrap;
    pointer-events: none;
    letter-spacing: 0.08em;
}

.testimonials-header {
    text-align: center;
    margin-bottom: 64px;
}

.testimonials-title {
    font-family: var(--font-display);
    font-size: clamp(36px, 4.5vw, 60px);
    font-weight: 300;
    line-height: 1.1;
    color: var(--charcoal);
}

.testimonials-title em {
    font-style: italic;
    color: var(--rose);
}

.testimonials-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 24px;
}

.testimonial-card {
    background: var(--ivory);
    padding: 36px;
    border-radius: 2px;
    position: relative;
    transition: transform 0.4s var(--ease-out-expo), box-shadow 0.4s ease;
    border-bottom: 3px solid transparent;
}

.testimonial-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 60px rgba(44, 36, 33, 0.08);
    border-bottom-color: var(--rose);
}

.testimonial-quote-mark {
    font-family: var(--font-display);
    font-size: 80px;
    line-height: 0.8;
    color: var(--rose-light);
    opacity: 0.3;
    margin-bottom: 16px;
    display: block;
}

.testimonial-text {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 400;
    font-style: italic;
    color: var(--charcoal-mid);
    line-height: 1.75;
    margin-bottom: 28px;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 14px;
}

.testimonial-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-author-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--charcoal);
    margin-bottom: 3px;
}

.testimonial-author-loc {
    font-size: 12px;
    color: var(--warm-grey);
}

.testimonial-stars {
    display: flex;
    gap: 3px;
    margin-bottom: 16px;
}

.star-icon {
    width: 13px;
    height: 13px;
    fill: var(--terracotta);
}

/* ----------------------------------------------------------------
   CTA BANNER
---------------------------------------------------------------- */
.cta-section {
    padding: clamp(80px, 10vw, 140px) clamp(24px, 8vw, 120px);
    background: var(--cream);
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 40px;
    position: relative;
    overflow: hidden;
}

.cta-section::after {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(212, 132, 122, 0.1) 0%, transparent 70%);
    right: -100px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

.cta-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.cta-label::before {
    content: '';
    display: block;
    width: 32px;
    height: 1px;
    background: var(--rose);
}

.cta-title {
    font-family: var(--font-display);
    font-size: clamp(38px, 5vw, 68px);
    font-weight: 300;
    line-height: 1.1;
    color: var(--charcoal);
}

.cta-title em {
    font-style: italic;
    color: var(--rose);
}

.cta-actions {
    display: flex;
    flex-direction: column;
    gap: 14px;
    align-items: flex-start;
    flex-shrink: 0;
}

/* ----------------------------------------------------------------
   RESPONSIVE
---------------------------------------------------------------- */
@media (max-width: 1100px) {
    .hero { grid-template-columns: 1fr; min-height: auto; }
    .hero-right { height: 55vw; min-height: 340px; }
    .hero-badge { left: 24px; bottom: -24px; }
    .about-section { grid-template-columns: 1fr; }
    .about-img-wrap { max-width: 520px; }
    .categories-grid { grid-template-columns: repeat(2, 1fr); }
    .category-card:first-child { grid-row: span 1; }
    .category-card:first-child .category-img { min-height: 220px; }
    .process-steps { grid-template-columns: repeat(2, 1fr); }
    .process-steps::before { display: none; }
    .testimonials-grid { grid-template-columns: 1fr 1fr; }
    .cta-section { grid-template-columns: 1fr; }
    .cta-actions { flex-direction: row; }
}

@media (max-width: 720px) {
    .products-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
    .categories-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
    .process-steps { grid-template-columns: 1fr; }
    .testimonials-grid { grid-template-columns: 1fr; }
    .about-stats { grid-template-columns: 1fr 1fr; }
    .cta-actions { flex-direction: column; }
}

@media (max-width: 480px) {
    .products-grid { grid-template-columns: 1fr; }
    .about-stats { grid-template-columns: repeat(3, 1fr); gap: 12px; }
}
</style>
@endpush

@section('content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="hero" aria-label="Hero section">

    <div class="hero-deco-circle hero-deco-1" aria-hidden="true"></div>
    <div class="hero-deco-circle hero-deco-2" aria-hidden="true"></div>

    <div class="hero-left">
        <div class="hero-eyebrow" aria-hidden="true">
            <span class="hero-eyebrow-line"></span>
            <span class="hero-eyebrow-text">Handcrafted Bouquets</span>
        </div>

        <h1 class="hero-title">
            <span class="hero-title-line"><span class="hero-title-inner">Rangkai</span></span>
            <span class="hero-title-line"><span class="hero-title-inner"><em>Cinta</em> dalam</span></span>
            <span class="hero-title-line"><span class="hero-title-inner">Setiap Bunga</span></span>
        </h1>

        <p class="hero-desc">
            Setiap buket adalah cerita yang menunggu untuk disampaikan. Kami merangkai keindahan alam menjadi ekspresi perasaan terdalam Anda — untuk ulang tahun, pernikahan, atau sekadar mengucapkan "aku peduli."
        </p>

        <div class="hero-actions">
            <a href="{{ url('/products') }}" class="btn-primary">
                <span>Lihat Koleksi</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ url('/contact') }}" class="btn-outline">Hubungi Kami</a>
        </div>

        <div class="hero-scroll-hint" aria-hidden="true">
            <div class="scroll-arrow"></div>
            <span>Gulir ke bawah</span>
        </div>
    </div>

    <div class="hero-right">
        <img
            src="https://picsum.photos/seed/bouquet-hero/900/1200"
            alt="Beautiful fresh flower bouquet"
            class="hero-img-main"
            loading="eager"
            fetchpriority="high"
        />
        <div class="hero-img-overlay" aria-hidden="true"></div>
    </div>
</section>

{{-- ================================================================
     MARQUEE TICKER
================================================================ --}}
<div class="marquee-section" aria-hidden="true">
    <div class="marquee-track">
        @for ($i = 0; $i < 2; $i++)
        <span class="marquee-item"><span class="marquee-text">Fresh Flowers</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Dried Bouquet</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Wedding Decor</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Birthday Gifts</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Custom Order</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Same Day Delivery</span><span class="marquee-dot"></span></span>
        <span class="marquee-item"><span class="marquee-text">Handcrafted</span><span class="marquee-dot"></span></span>
        @endfor
    </div>
</div>

{{-- ================================================================
     ABOUT / INTRO
================================================================ --}}
<section class="about-section" aria-label="About Maw Bouquet">
    <div class="about-img-wrap reveal-left">
        <img
            src="https://picsum.photos/seed/maw-about/640/780"
            alt="Florist arranging fresh flowers"
            class="about-img-main"
            loading="lazy"
        />
        <img
            src="https://picsum.photos/seed/maw-about-2/480/520"
            alt="Close up of flower arrangement"
            class="about-img-accent"
            loading="lazy"
        />
        <span class="about-img-tag">Est. 2020</span>
    </div>

    <div class="about-content reveal-right">
        <span class="section-label">Tentang Kami</span>

        <h2 class="about-title">
            Dibuat dengan<br>
            Tangan &amp; <em>Hati</em>
        </h2>

        <p class="about-body">
            Maw Bouquet lahir dari kecintaan mendalam terhadap keindahan alam dan seni merangkai bunga. Kami percaya bahwa setiap bunga memiliki bahasa tersendiri, dan tugas kami adalah membantu Anda mengucapkan kata-kata yang tak tersampaikan.
        </p>
        <p class="about-body">
            Dengan menggunakan bunga-bunga pilihan berkualitas tinggi — baik segar maupun kering — setiap rangkaian kami dirancang untuk bertahan lama dalam kenangan, bahkan jauh setelah kelopaknya layu.
        </p>

        <div class="about-divider"></div>

        <a href="{{ url('/contact') }}" class="btn-outline">
            Ceritakan Kebutuhanmu
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>

        <div class="about-stats">
            <div class="reveal delay-1">
                <p class="about-stat-num">200<sup>+</sup></p>
                <p class="about-stat-label">Pesanan Selesai</p>
            </div>
            <div class="reveal delay-2">
                <p class="about-stat-num">4.9</p>
                <p class="about-stat-label">Rating Rata-rata</p>
            </div>
            <div class="reveal delay-3">
                <p class="about-stat-num">3<sup>thn</sup></p>
                <p class="about-stat-label">Pengalaman</p>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     FEATURED PRODUCTS
================================================================ --}}
<section class="products-section" aria-label="Featured products">
    <div class="products-header">
        <div class="reveal">
            <span class="section-label">Koleksi Pilihan</span>
            <h2 class="products-title">
                Buket yang<br><em>Menceritakan</em><br>Segalanya
            </h2>
        </div>
        <div class="reveal delay-2">
            <a href="{{ url('/products') }}" class="btn-outline">
                Lihat Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="products-grid">
        @php
        $featured = [
            ['seed' => 'bouquet-1', 'name' => 'Blushing Garden',     'category' => 'Buket Segar',  'price' => 'Rp 185.000', 'badge' => 'Terlaris'],
            ['seed' => 'bouquet-2', 'name' => 'Eternal Rose',        'category' => 'Buket Kering', 'price' => 'Rp 220.000', 'badge' => 'Baru'],
            ['seed' => 'bouquet-3', 'name' => 'Soft Pampas Dream',   'category' => 'Buket Pampas', 'price' => 'Rp 195.000', 'badge' => null],
        ];
        @endphp

        @foreach ($featured as $i => $product)
        <article class="product-card reveal delay-{{ $i + 1 }}">
            <a href="{{ url('/products/1') }}" aria-label="Lihat detail {{ $product['name'] }}">
                <div class="product-card-img-wrap">
                    @if ($product['badge'])
                    <span class="product-card-badge">{{ $product['badge'] }}</span>
                    @endif
                    <img
                        src="https://picsum.photos/seed/{{ $product['seed'] }}/600/800"
                        alt="{{ $product['name'] }}"
                        class="product-card-img"
                        loading="lazy"
                    />
                    <div class="product-card-quick">
                        <span class="product-quick-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                            </svg>
                            Pesan via WA
                        </span>
                    </div>
                </div>
                <p class="product-card-category">{{ $product['category'] }}</p>
                <h3 class="product-card-name">{{ $product['name'] }}</h3>
                <p class="product-card-price">{{ $product['price'] }}</p>
            </a>
        </article>
        @endforeach
    </div>
</section>

{{-- ================================================================
     CATEGORIES
================================================================ --}}
<section class="categories-section" aria-label="Product categories">
    <div class="reveal" style="margin-bottom: 48px;">
        <span class="section-label">Jelajahi Kategori</span>
        <h2 class="products-title" style="margin-top: 0;">
            Temukan <em>Buket</em><br>yang Tepat
        </h2>
    </div>

    <div class="categories-grid">
        @php
        $categories = [
            ['seed' => 'cat-fresh',  'name' => 'Buket Segar',   'count' => '12 Produk'],
            ['seed' => 'cat-dried',  'name' => 'Buket Kering',  'count' => '8 Produk'],
            ['seed' => 'cat-pampas', 'name' => 'Pampas & Dried','count' => '10 Produk'],
            ['seed' => 'cat-mini',   'name' => 'Mini Bouquet',  'count' => '6 Produk'],
        ];
        @endphp

        @foreach ($categories as $i => $cat)
        <a href="{{ url('/products?category=' . Str::slug($cat['name'])) }}"
           class="category-card reveal delay-{{ $i + 1 }}"
           aria-label="{{ $cat['name'] }}">
            <img
                src="https://picsum.photos/seed/{{ $cat['seed'] }}/{{ $i === 0 ? '600/900' : '600/400' }}"
                alt="{{ $cat['name'] }}"
                class="category-img"
                loading="lazy"
            />
            <div class="category-overlay" aria-hidden="true"></div>
            <div class="category-content">
                <p class="category-name">{{ $cat['name'] }}</p>
                <p class="category-count">{{ $cat['count'] }}</p>
                <span class="category-arrow">
                    Lihat semua
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </span>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ================================================================
     HOW TO ORDER
================================================================ --}}
<section class="process-section" aria-label="How to order">
    <div class="process-header">
        <div class="reveal">
            <p class="process-label">Cara Pesan</p>
            <h2 class="process-title">
                Mudah &amp; <em>Menyenangkan</em>
            </h2>
        </div>
    </div>

    <div class="process-steps">
        @php
        $steps = [
            ['num' => '01', 'name' => 'Pilih Produk', 'desc' => 'Jelajahi koleksi kami dan temukan buket yang sesuai dengan hati Anda.'],
            ['num' => '02', 'name' => 'Hubungi Kami', 'desc' => 'Kirim pesan via WhatsApp atau email dengan detail pesanan Anda.'],
            ['num' => '03', 'name' => 'Konfirmasi',   'desc' => 'Kami membantu Anda menyesuaikan warna dan gaya sesuai kebutuhan.'],
            ['num' => '04', 'name' => 'Terima Buket', 'desc' => 'Buket Anda dikerjakan dengan penuh cinta dan siap dikirimkan.'],
        ];
        @endphp

        @foreach ($steps as $i => $step)
        <div class="process-step reveal delay-{{ $i + 1 }}">
            <div class="process-step-num">{{ $step['num'] }}</div>
            <h3 class="process-step-name">{{ $step['name'] }}</h3>
            <p class="process-step-desc">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ================================================================
     TESTIMONIALS
================================================================ --}}
<section class="testimonials-section" aria-label="Customer testimonials">
    <div class="testimonials-bg-word" aria-hidden="true">Cerita</div>

    <div class="testimonials-header reveal">
        <span class="section-label" style="justify-content: center;">Kata Mereka</span>
        <h2 class="testimonials-title">
            Cerita di Balik<br>Setiap <em>Buket</em>
        </h2>
    </div>

    <div class="testimonials-grid">
        @php
        $testimonials = [
            ['name' => 'Anisa Rahma',   'location' => 'Jakarta Selatan', 'seed' => 'ava-1', 'text' => 'Buketnya luar biasa indah! Saya memesan untuk ulang tahun ibu, dan beliau sangat terharu. Kualitas bunganya premium dan kemasannya sangat rapi dan elegan.'],
            ['name' => 'Dini Putri',    'location' => 'Tangerang Selatan', 'seed' => 'ava-2', 'text' => 'Pelayanannya ramah banget, langsung direspon dan dikerjakan dengan cepat. Buket keringnya bertahan lama sekali, masih cantik sampai sekarang di meja kerja saya.'],
            ['name' => 'Sari Wulandari','location' => 'Depok',            'seed' => 'ava-3', 'text' => 'Saya sudah pesan berkali-kali dan tidak pernah kecewa. Selalu konsisten kualitasnya dan selalu ada yang baru dari setiap kreasi Maw Bouquet. Recommended banget!'],
        ];
        @endphp

        @foreach ($testimonials as $i => $t)
        <div class="testimonial-card reveal delay-{{ $i + 1 }}">
            <div class="testimonial-stars" aria-label="5 bintang">
                @for ($s = 0; $s < 5; $s++)
                <svg class="star-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                @endfor
            </div>
            <span class="testimonial-quote-mark" aria-hidden="true">&ldquo;</span>
            <p class="testimonial-text">{{ $t['text'] }}</p>
            <div class="testimonial-author">
                <img
                    src="https://picsum.photos/seed/{{ $t['seed'] }}/80/80"
                    alt="{{ $t['name'] }}"
                    class="testimonial-avatar"
                    loading="lazy"
                />
                <div>
                    <p class="testimonial-author-name">{{ $t['name'] }}</p>
                    <p class="testimonial-author-loc">{{ $t['location'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ================================================================
     CTA BANNER
================================================================ --}}
<section class="cta-section" aria-label="Call to action">
    <div class="reveal">
        <p class="cta-label">Siap Memesan?</p>
        <h2 class="cta-title">
            Biarkan Kami<br>Merangkai <em>Momen</em><br>Tak Terlupakan
        </h2>
    </div>
    <div class="cta-actions reveal delay-2">
        <a href="https://wa.me/6285708573756" target="_blank" rel="noopener" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
            </svg>
            <span>Chat via WhatsApp</span>
        </a>
        <a href="{{ url('/contact') }}" class="btn-outline">Kirim Email</a>
    </div>
</section>

@endsection
