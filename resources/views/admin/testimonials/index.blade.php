@extends('admin.layouts.app')

@section('title', 'Testimonial')
@section('header', 'Testimonial')
@section('subheader', 'Kelola testimonial pelanggan')

@section('content')

    <div class="bg-white border border-cream-d rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-cream-d">
            <h2 class="text-lg font-semibold text-brown">
                Daftar Testimonial
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-cream">

                    <tr class="text-left text-muted">

                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Pesan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-cream-d">

                    @forelse($testimonials as $item)
                        <tr class="hover:bg-cream/50">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 rounded-full bg-rose-l
                                    flex items-center justify-center
                                    text-rose-d font-semibold">

                                        {{ strtoupper($item->avatar_letter) }}

                                    </div>

                                    <div>
                                        <p class="font-medium text-brown">
                                            {{ $item->name }}
                                        </p>

                                        <p class="text-xs text-muted">
                                            {{ $item->location ?? 'Indonesia' }}
                                        </p>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4">

                                ⭐ {{ $item->rating }}/5

                            </td>

                            <td class="px-6 py-4 max-w-sm">
                                <p class="line-clamp-2 text-muted">
                                    {{ $item->message }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-muted">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        onclick="openDeleteModal({
                                        action: '{{ route('admin.testimonials.destroy', $item->id) }}',
                                        title: 'Hapus testimonial?',
                                        desc: 'Testimonial akan dihapus permanen.'
                                    })"
                                        class="px-3 py-2 rounded-xl text-xs bg-red-50
                                    text-red-500 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-muted">
                                Belum ada testimonial.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-cream-d">
            {{ $testimonials->links() }}
        </div>

    </div>

@endsection
