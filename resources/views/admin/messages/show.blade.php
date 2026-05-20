@extends('admin.layouts.app')

@section('title', 'Detail Pesan')
@section('header', 'Detail Pesan')
@section('subheader', 'Informasi lengkap pesan kontak')

@section('content')

    <div class="space-y-5">

        <a href="/admin/messages"
            class="inline-flex items-center gap-2 text-sm text-muted hover:text-brown transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Kembali ke daftar pesan
        </a>

        <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">

            <div class="px-6 py-5 border-b border-cream-d flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-11 h-11 rounded-full bg-rose-l/50 flex items-center justify-center text-rose-d text-base font-semibold">
                        {{ strtoupper(substr($message->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-brown">{{ $message->name }}</p>
                        <p class="text-xs text-muted">{{ $message->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
                @if (!$message->is_read)
                    <span class="bg-rose/10 text-rose text-xs font-semibold px-2.5 py-1 rounded-full">Belum dibaca</span>
                @else
                    <span class="bg-sage/10 text-sage text-xs font-semibold px-2.5 py-1 rounded-full">Sudah dibaca</span>
                @endif
            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 gap-0 divide-y sm:divide-y-0 sm:divide-x divide-cream-d border-b border-cream-d">
                <div class="px-6 py-4">
                    <p class="text-xs text-muted font-medium tracking-wide uppercase mb-1">No. WhatsApp</p>
                    <p class="text-sm font-medium text-brown">{{ $message->phone }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-muted font-medium tracking-wide uppercase mb-1">Email</p>
                    <p class="text-sm font-medium text-brown">{{ $message->email ?: '—' }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-muted font-medium tracking-wide uppercase mb-1">Keperluan</p>
                    <span class="bg-sand/15 text-brown-m text-xs px-2.5 py-1 rounded-full">{{ $message->purpose }}</span>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-muted font-medium tracking-wide uppercase mb-1">Pilihan Warna</p>
                    <p class="text-sm font-medium text-brown">{{ $message->color_pref ?: '—' }}</p>
                </div>
            </div>

            <div class="px-6 py-5">
                <p class="text-xs text-muted font-medium tracking-wide uppercase mb-3">Pesan</p>
                <p class="text-sm text-brown-m leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>
            </div>

            <div class="px-6 py-4 bg-cream/40 border-t border-cream-d flex flex-wrap items-center gap-3">
                @php
                    $messages = [
                        'Halo, saya admin Maw Bouquet, terima kasih telah menghubungi kami.',
                        'Halo, terima kasih sudah menghubungi Maw Bouquet. Ada yang ingin kami bantu terkait pesanan Anda?',
                        'Halo, saya dari tim Maw Bouquet. Kami telah menerima pesan Anda.',
                        'Halo, terima kasih telah menghubungi Maw Bouquet. Kami siap membantu kebutuhan bouquet Anda.',
                        'Halo, saya admin Maw Bouquet. Kami sedang menindaklanjuti pesan Anda.',
                    ];

                    $text = urlencode($messages[array_rand($messages)]);
                @endphp

                <a href="{{ $message->whatsapp_link }}?text={{ $text }}" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 bg-brown text-white text-sm px-5 py-2.5 rounded-xl hover:opacity-90 transition">

                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.054 23.704a.5.5 0 00.609.637l5.99-1.514A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.193-1.458l-.37-.22-3.833.968.985-3.77-.242-.389A9.966 9.966 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>

                    Balas via WhatsApp
                </a>

                @if ($message->email)
                    <a href="mailto:{{ $message->email }}"
                        class="inline-flex items-center gap-2 border border-cream-d text-brown-m text-sm px-5 py-2.5 rounded-xl hover:bg-cream transition">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        Kirim Email
                    </a>
                @endif

                {{-- Hapus via global modal --}}
                <button type="button"
                    onclick="openDeleteModal({
                        action: '/admin/messages/{{ $message->id }}',
                        title: 'Hapus pesan ini?',
                        desc: 'Pesan dari {{ addslashes($message->name) }} akan dihapus permanen.'
                    })"
                    class="ml-auto inline-flex items-center gap-2 text-sm text-muted hover:text-red-500 transition-colors px-3 py-2.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                    </svg>
                    Hapus Pesan
                </button>
            </div>

        </div>
    </div>

@endsection
