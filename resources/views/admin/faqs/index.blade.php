@extends('admin.layouts.app')

@section('title', 'FAQ')
@section('header', 'FAQ')
@section('subheader', 'Kelola pertanyaan & jawaban FAQ')

@section('content')

<div class="bg-white rounded-2xl border border-cream-d overflow-hidden">

    {{-- HEADER --}}
    <div class="px-6 py-4 border-b border-cream-d flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-brown">Semua FAQ</h2>
            <span class="bg-sage/10 text-sage text-xs font-semibold px-2 py-0.5 rounded-full">
                {{ $faqs->count() }} data
            </span>
        </div>

        <a href="{{ route('admin.faqs.create') }}"
           class="bg-rose text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-rose-d transition">
            + Tambah FAQ
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead>
                <tr class="border-b border-cream-d bg-cream/50">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-muted">Jawaban</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-muted hidden md:table-cell">
                        Pertanyaan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-muted">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-cream-d">

                @forelse($faqs as $faq)
                    <tr class="hover:bg-cream/50 transition">

                        {{-- ANSWER --}}
                        <td class="px-6 py-4">
                            <p class="text-brown font-medium line-clamp-2 max-w-md">
                                {{ $faq->answer }}
                            </p>
                        </td>

                        {{-- QUESTIONS --}}
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="flex flex-wrap gap-2">
                                @foreach($faq->questions as $q)
                                    <span class="text-xs bg-sand/15 text-brown-m px-2 py-1 rounded-full">
                                        {{ $q->question }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">

                                <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                   class="text-xs font-medium text-brown-m hover:text-rose transition">
                                    Edit
                                </a>

                                <button type="button"
                                    onclick="openDeleteModal({
                                        action: '{{ route('admin.faqs.destroy', $faq->id) }}',
                                        title: 'Hapus FAQ ini?',
                                        desc: 'FAQ akan dihapus permanen beserta semua pertanyaannya.'
                                    })"
                                    class="text-xs text-muted hover:text-red-500 transition">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-cream-d flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                         stroke="#9E8E84" stroke-width="1.5">
                                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-muted">Belum ada FAQ</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection