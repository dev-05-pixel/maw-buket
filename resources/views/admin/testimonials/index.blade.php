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
                                        class="w-10 h-10 aspect-square shrink-0
                                    rounded-full bg-rose-l
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

                                <div class="flex items-center gap-1 text-yellow-500">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-4 h-4">

                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006
                                                5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527
                                                1.258 5.273c.271 1.136-.964 2.033-1.96 1.425L12
                                                18.354l-4.632 2.826c-.996.608-2.231-.29-1.96-1.425
                                                l1.258-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305
                                                l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>

                                    <span class="font-medium text-brown">
                                        {{ $item->rating }}/5
                                    </span>

                                </div>

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

                                    <a href="{{ route('admin.testimonials.show', $item->id) }}"
                                        class="px-3 py-2 rounded-xl text-xs
        bg-blue-50 text-blue-600
        hover:bg-blue-100 transition">

                                        Detail
                                    </a>

                                    <button
                                        onclick="openDeleteModal({
            action: '{{ route('admin.testimonials.destroy', $item->id) }}',
            title: 'Hapus testimonial?',
            desc: 'Testimonial akan dihapus permanen.'
        })"
                                        class="px-3 py-2 rounded-xl text-xs
        bg-red-50 text-red-500
        hover:bg-red-100 transition">

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
