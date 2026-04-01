@extends('admin.layouts.app')

@section('title', 'Pesan Kontak')
@section('header', 'Pesan Kontak')
@section('subheader', 'Pesan masuk dari formulir kontak')

@section('content')

    <div class="bg-white rounded-2xl border border-cream-d overflow-hidden">

        <div class="px-6 py-4 border-b border-cream-d flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <h2 class="text-sm font-semibold text-brown">Semua Pesan</h2>
                @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if ($unread > 0)
                    <span class="bg-rose/10 text-rose text-xs font-semibold px-2 py-0.5 rounded-full">{{ $unread }}
                        belum dibaca</span>
                @endif
            </div>
            <form method="GET" class="flex gap-2">
                <select name="per_page" onchange="this.form.submit()"
                    class="border border-cream-d rounded-lg px-3 py-1.5 text-xs text-brown bg-white focus:outline-none focus:ring-2 focus:ring-rose/30">
                    <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50 / hal</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-cream-d bg-cream/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide hidden md:table-cell">
                            Pesan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide hidden lg:table-cell">
                            Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-muted tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-d">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-cream/50 transition-colors {{ !$msg->is_read ? 'bg-rose/[0.02]' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-rose-l/50 flex items-center justify-center text-rose-d text-xs font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-brown flex items-center gap-1.5">
                                            {{ $msg->name }}
                                            @if (!$msg->is_read)
                                                <span class="w-1.5 h-1.5 bg-rose rounded-full inline-block"></span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-muted">{{ $msg->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-sand/15 text-brown-m text-xs px-2.5 py-1 rounded-full">{{ $msg->purpose }}</span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="text-muted text-xs max-w-xs truncate">{{ $msg->message }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <p class="text-xs text-muted">{{ $msg->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-muted/60">{{ $msg->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="/admin/messages/{{ $msg->id }}"
                                        class="text-xs text-brown-m hover:text-rose transition-colors font-medium">Detail</a>
                                    <button type="button"
                                        onclick="openDeleteModal({
                                        action: '/admin/messages/{{ $msg->id }}',
                                        title: 'Hapus pesan dari {{ addslashes($msg->name) }}?',
                                        desc: 'Pesan ini akan dihapus permanen dan tidak bisa dikembalikan.'
                                    })"
                                        class="text-xs text-muted hover:text-red-500 transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-cream-d flex items-center justify-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="#9E8E84" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-muted">Belum ada pesan masuk</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($messages->hasPages())
            <div class="px-6 py-4 border-t border-cream-d">
                {{ $messages->links() }}
            </div>
        @endif

    </div>

@endsection
