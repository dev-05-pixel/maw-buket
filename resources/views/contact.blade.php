@extends('layouts.app')

@section('title', 'Hubungi Kami')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/general/contact.css') }}">
@endpush

@section('content')

    <header class="contact-hero" aria-label="Contact hero">
        <img src="{{ asset('assets/contact banner.svg') }}" alt="Contact hero background"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center right; opacity:1; z-index:0;" />
        <div
            style="position:absolute; inset:0; z-index:0; background: linear-gradient(90deg, rgba(44,36,33,1) 0%, rgba(44,36,33,1) 50%, rgba(44,36,33,0.4) 75%, rgba(44,36,33,0.0) 100%);">
        </div>
        <div style="position:relative;z-index:1;">
            <p class="contact-hero-label">Hubungi Kami</p>
            <h1 class="contact-hero-title">
                <span class="contact-hero-title-overflow"><span class="contact-hero-title-line">Kami Senang</span></span>
                <span class="contact-hero-title-overflow"><span class="contact-hero-title-line">Mendengar</span></span>
                <span class="contact-hero-title-overflow"><span
                        class="contact-hero-title-line"><em>Ceritamu</em></span></span>
            </h1>
        </div>

        <div class="contact-hero-right" style="position:relative;z-index:1;">
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
                        <p class="contact-channel-val">+6282257031231</p>
                    </div>
                    <span class="contact-channel-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></span>
                </a>
                <a href="mailto:mawbouquet@gmail.com" class="contact-channel-link" role="listitem">
                    <span class="contact-channel-icon channel-mail" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </span>
                    <div class="contact-channel-info">
                        <p class="contact-channel-name">Email</p>
                        <p class="contact-channel-val">mawbouquet@gmail.com</p>
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
                        <p class="contact-detail-value">+6282257031231</p>
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
                        <p class="contact-detail-value">mawbouquet@gmail.com</p>
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
    <script src="{{ asset('js/general/contact.js') }}"></script>
@endpush
