@extends('admin.layouts.app')

@section('title', 'Edit FAQ')
@section('header', 'Edit FAQ')
@section('subheader', 'Perbarui jawaban dan variasi pertanyaan')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white border border-cream-d rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-4 border-b border-cream-d bg-cream/40">
            <h2 class="text-sm font-semibold text-brown">Edit FAQ</h2>
            <p class="text-xs text-muted mt-1">Ubah jawaban atau tambahkan variasi pertanyaan</p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.faqs.update', $faq->id) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- ANSWER --}}
            <div>
                <label class="text-xs font-semibold text-brown-m">Jawaban</label>

                <textarea
                    name="answer"
                    rows="5"
                    required
                    class="w-full mt-2 px-4 py-3 text-sm border border-cream-d rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose transition"
                >{{ $faq->answer }}</textarea>
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

                    @foreach($faq->questions as $q)
                        <div class="flex items-center gap-2 group">

                            <input type="text"
                                name="questions[]"
                                value="{{ $q->question }}"
                                class="flex-1 px-4 py-3 text-sm border border-cream-d rounded-xl
                                       focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose transition">

                            <button type="button"
                                onclick="this.parentElement.remove()"
                                class="text-xs text-muted hover:text-red-500 px-2">
                                Hapus
                            </button>

                        </div>
                    @endforeach

                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex items-center justify-between pt-5 border-t border-cream-d">

                <a href="{{ route('admin.faqs.index') }}"
                   class="text-xs text-muted hover:text-brown transition">
                    ← Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 bg-rose text-white text-sm font-semibold rounded-xl
                           hover:bg-rose-d transition shadow-sm">
                    Simpan Perubahan
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

    const row = document.createElement('div');
    row.className = "flex items-center gap-2";

    row.innerHTML = `
        <input type="text"
            name="questions[]"
            class="flex-1 px-4 py-3 text-sm border border-cream-d rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose transition"
            placeholder="Pertanyaan baru">

        <button type="button"
            onclick="this.parentElement.remove()"
            class="text-xs text-muted hover:text-red-500 px-2">
            Hapus
        </button>
    `;

    box.appendChild(row);
}
</script>
@endpush