@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')
@section('header', 'Tambah FAQ')
@section('subheader', 'Buat FAQ baru untuk sistem bantuan')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- CARD --}}
    <div class="bg-white rounded-2xl border border-cream-d shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-4 border-b border-cream-d bg-cream/40">
            <h2 class="text-sm font-semibold text-brown">
                Form FAQ Baru
            </h2>
            <p class="text-xs text-muted mt-1">
                Tambahkan 1 jawaban dengan banyak variasi pertanyaan
            </p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.faqs.store') }}" class="p-6 space-y-6">
            @csrf

            {{-- ANSWER --}}
            <div>
                <label class="block text-xs font-semibold text-brown-m mb-2">
                    Jawaban
                </label>

                <textarea
                    name="answer"
                    required
                    rows="5"
                    class="w-full rounded-xl border border-cream-d bg-white px-4 py-3 text-sm
                           focus:ring-2 focus:ring-rose/30 focus:border-rose outline-none transition"
                    placeholder="Tulis jawaban lengkap untuk FAQ ini..."></textarea>
            </div>

            {{-- QUESTIONS --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-semibold text-brown-m">
                        Variasi Pertanyaan
                    </label>

                    <button type="button"
                            onclick="addQuestion()"
                            class="text-xs font-medium text-rose hover:text-rose-d transition">
                        + Tambah pertanyaan
                    </button>
                </div>

                <div id="question-box" class="space-y-3">

                    {{-- DEFAULT INPUT --}}
                    <div class="flex items-center gap-2">
                        <input type="text"
                               name="questions[]"
                               class="flex-1 rounded-xl border border-cream-d px-4 py-3 text-sm
                                      focus:ring-2 focus:ring-rose/30 focus:border-rose outline-none"
                               placeholder="Contoh: Apakah bisa custom bouquet?">

                        <button type="button"
                                onclick="removeInput(this)"
                                class="text-muted hover:text-red-500 text-xs">
                            Hapus
                        </button>
                    </div>

                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex items-center justify-between pt-5 border-t border-cream-d">

                <a href="{{ route('admin.faqs.index') }}"
                   class="text-xs text-muted hover:text-brown transition">
                    ← Kembali
                </a>

                <button type="submit"
                        class="px-5 py-2.5 bg-rose text-white text-sm rounded-xl
                               hover:bg-rose-d transition shadow-sm">
                    Simpan FAQ
                </button>

            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function addQuestion() {
    const box = document.getElementById('question-box');

    const wrapper = document.createElement('div');
    wrapper.className = "flex items-center gap-2";

    const input = document.createElement('input');
    input.type = "text";
    input.name = "questions[]";
    input.placeholder = "Pertanyaan tambahan...";
    input.className =
        "flex-1 rounded-xl border border-cream-d px-4 py-3 text-sm focus:ring-2 focus:ring-rose/30 focus:border-rose outline-none";

    const btn = document.createElement('button');
    btn.type = "button";
    btn.innerText = "Hapus";
    btn.className = "text-xs text-muted hover:text-red-500";
    btn.onclick = () => wrapper.remove();

    wrapper.appendChild(input);
    wrapper.appendChild(btn);

    box.appendChild(wrapper);
}

function removeInput(el) {
    el.parentElement.remove();
}
</script>
@endpush