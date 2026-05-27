{{-- CREATE: resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk')
@section('subheader', 'Tambahkan produk baru ke katalog')

@section('content')

    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-xl">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-600 flex items-center gap-2">
                        <span class="w-1 h-1 bg-red-400 rounded-full flex-shrink-0"></span>{{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-cream-d p-8">

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-brown tracking-wide uppercase mb-2">Nama Produk <span
                            class="text-rose">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Buket Mawar Merah Premium"
                        class="w-full border border-cream-d rounded-xl px-4 py-3 text-sm text-brown placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose/50 transition @error('name') border-red-300 bg-red-50/50 @enderror">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Variant --}}
                <div class="md:col-span-2">

                    <div class="flex items-center justify-between mb-3">

                        <label class="block text-xs font-semibold text-brown tracking-wide uppercase">
                            Varian Produk
                            <span class="text-rose">*</span>
                        </label>

                        <button type="button" id="add-variant"
                            class="px-3 py-2 text-xs bg-brown text-white rounded-lg hover:opacity-90 transition">
                            + Tambah Varian
                        </button>

                    </div>

                    <div id="variant-wrapper" class="space-y-3">

                        @php
                            $variants = old('variants', $product->variants ?? [['name' => '', 'price' => '']]);
                        @endphp

                        @foreach ($variants as $index => $variant)
                            <div
                                class="variant-item grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 border border-cream-d rounded-xl p-4">

                                {{-- Nama Variant --}}
                                <div>
                                    <label class="text-xs text-muted mb-1 block">
                                        Nama Variant
                                    </label>

                                    <input type="text" name="variants[{{ $index }}][name]"
                                        value="{{ $variant['name'] ?? '' }}" placeholder="Contoh: S / M / L"
                                        class="w-full border border-cream-d rounded-xl px-4 py-3 text-sm">
                                </div>

                                {{-- Harga --}}
                                <div>
                                    <label class="text-xs text-muted mb-1 block">
                                        Harga
                                    </label>

                                    <div class="relative">

                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-muted">
                                            Rp
                                        </span>

                                        <input type="text" name="variants[{{ $index }}][price]"
                                            value="{{ isset($variant['price'])
                                                ? number_format((float) preg_replace('/[^0-9]/', '', $variant['price']), 0, ',', '.')
                                                : '' }}"
                                            placeholder="25.000"
                                            class="variant-price w-full border border-cream-d rounded-xl pl-10 pr-4 py-3 text-sm">
                                    </div>
                                </div>

                                {{-- Remove --}}
                                <div class="flex items-end">
                                    <button type="button"
                                        class="remove-variant px-3 py-3 text-sm rounded-xl border border-red-200 text-red-500 hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    @error('variants')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-brown tracking-wide uppercase mb-2">Kategori <span
                            class="text-rose">*</span></label>
                    <select name="category"
                        class="w-full border border-cream-d rounded-xl px-4 py-3 text-sm text-brown focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose/50 transition bg-white @error('category') border-red-300 @enderror">
                        <option value="">— Pilih Kategori —</option>
                        @foreach (['Buket Segar', 'Buket Kering', 'Pampas', 'Mini Bouquet'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-brown tracking-wide uppercase mb-2">Gambar Produk
                        <span class="text-rose">*</span></label>
                    <label id="drop-zone"
                        class="block border-2 border-dashed border-cream-d rounded-xl p-6 text-center cursor-pointer hover:border-rose/40 hover:bg-rose/[0.02] transition group">
                        <div id="preview-wrap" class="hidden mb-3">
                            <img id="img-preview" class="mx-auto max-h-32 rounded-lg object-cover">
                        </div>
                        <div id="upload-icon">
                            <svg class="mx-auto mb-2 text-muted group-hover:text-rose transition" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <p class="text-xs text-muted">Klik atau seret gambar ke sini</p>
                            <p class="text-[10px] text-muted/70 mt-1">JPG, PNG — maks. 20MB</p>
                        </div>
                        <input type="file" name="image" id="image-input" class="hidden" accept="image/jpeg,image/png"
                            required>
                    </label>
                    @error('image')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Warna --}}
                <div>
                    <label class="block text-xs font-semibold text-brown tracking-wide uppercase mb-2">
                        Warna <span class="text-rose">*</span>
                    </label>

                    <input list="color-list" name="color" value="{{ old('color') }}"
                        placeholder="Contoh: Pink, Dusty Pink, Peach"
                        class="w-full border border-cream-d rounded-xl px-4 py-3 text-sm text-brown placeholder:text-muted
                        focus:outline-none focus:ring-2 focus:ring-rose/30 focus:border-rose/50 transition
                        @error('color') border-red-300 bg-red-50 @enderror">

                    <datalist id="color-list">
                        @foreach ($colors ?? [] as $c)
                            <option value="{{ $c }}">
                        @endforeach
                    </datalist>

                    @error('color')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-brown tracking-wide uppercase mb-2">Deskripsi</label>
                    <div
                        class="border border-cream-d rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-rose/30 focus-within:border-rose/50 transition">
                        <div id="editor" style="height:180px;"></div>
                    </div>
                    <input type="hidden" name="description" id="description">
                    @error('description')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-cream-d">
                <a href="{{ route('admin.products.index') }}"
                    class="px-5 py-2.5 border border-cream-d rounded-xl text-sm text-brown-m hover:bg-cream transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-brown text-white rounded-xl text-sm hover:opacity-90 transition inline-flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <style>
            .ql-toolbar {
                border: none !important;
                border-bottom: 1px solid #EDE6DC !important;
            }

            .ql-container {
                border: none !important;
                font-family: 'DM Sans', sans-serif;
            }

            .ql-editor {
                min-height: 140px;
                font-size: 14px;
            }

            .ql-editor.ql-blank::before {
                color: #9E8E84;
                font-style: normal;
            }
        </style>
        <script>
            function formatRupiah(value) {

                value = value.replace(/\D/g, '');

                return new Intl.NumberFormat('id-ID').format(value);
            }

            document.addEventListener('input', function(e) {

                if (e.target.classList.contains('variant-price')) {

                    e.target.value = formatRupiah(e.target.value);
                }
            });

            let variantIndex =
                document.querySelectorAll('.variant-item').length;

            document.getElementById('add-variant')
                .addEventListener('click', function() {

                    const html = `
                <div class="variant-item grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 border border-cream-d rounded-xl p-4">

                    <div>
                        <label class="text-xs text-muted mb-1 block">
                            Nama Variant
                        </label>

                        <input type="text"
                            name="variants[${variantIndex}][name]"
                            placeholder="Contoh: S / M / L"
                            class="w-full border border-cream-d rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-muted mb-1 block">
                            Harga
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-muted">
                                Rp
                            </span>

                            <input type="text"
                                name="variants[${variantIndex}][price]"
                                placeholder="25.000"
                                class="variant-price w-full border border-cream-d rounded-xl pl-10 pr-4 py-3 text-sm">

                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="button"
                            class="remove-variant px-3 py-3 text-sm rounded-xl border border-red-200 text-red-500 hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>

                </div>
            `;

                    document.getElementById('variant-wrapper')
                        .insertAdjacentHTML('beforeend', html);

                    variantIndex++;
                });

            document.addEventListener('click', function(e) {

                if (e.target.classList.contains('remove-variant')) {

                    e.target.closest('.variant-item').remove();
                }
            });

            document.querySelector('form')
                .addEventListener('submit', function() {

                    document.querySelectorAll('.variant-price')
                        .forEach(function(input) {

                            input.value = input.value.replace(/\./g, '');
                        });
                });
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi produk...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        ['clean']
                    ]
                }
            });
            quill.on('text-change', () => document.getElementById('description').value = quill.root.innerHTML);
            document.querySelector('form').addEventListener('submit', () => document.getElementById('description').value = quill
                .root.innerHTML);

            // Image preview
            document.getElementById('image-input').addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('img-preview').src = e.target.result;
                    document.getElementById('preview-wrap').classList.remove('hidden');
                    document.getElementById('upload-icon').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        </script>
    @endpush

@endsection
