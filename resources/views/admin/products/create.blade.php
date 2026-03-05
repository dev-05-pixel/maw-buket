@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk')

@section('content')

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-4xl bg-white p-10 rounded-2xl shadow-sm border">

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Nama Produk -->
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 font-medium">
                        Nama Produk
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama produk"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none
@error('name') border-red-500 @enderror"
                        required @error('name') border-red-500 @enderror" required>

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm mb-2 font-medium">
                        Harga (Rp)
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="Masukkan harga produk"
                        step="1000" min="1000"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none
@error('price') border-red-500 @enderror"
                        required @error('price') border-red-500 @enderror" required>

                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm mb-2 font-medium">
                        Kategori
                    </label>
                    <select name="category"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none
    @error('category') border-red-500 @enderror"
                        required>

                        <option value="">-- Pilih Kategori --</option>
                        <option value="Buket Segar" {{ old('category') == 'Buket Segar' ? 'selected' : '' }}>Buket Segar
                        </option>
                        <option value="Buket Kering" {{ old('category') == 'Buket Kering' ? 'selected' : '' }}>Buket Kering
                        </option>
                        <option value="Pampas" {{ old('category') == 'Pampas' ? 'selected' : '' }}>Pampas</option>
                        <option value="Mini Bouquet" {{ old('category') == 'Mini Bouquet' ? 'selected' : '' }}>Mini Bouquet
                        </option>
                    </select>

                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div>
                    <label class="block text-sm mb-2 font-medium">
                        Gambar Produk
                    </label>
                    <p class="text-xs text-gray-500 mb-2">
                        Format: JPG / PNG, maksimal 20MB
                    </p>
                    <input type="file" name="image"
                        class="w-full border rounded-lg px-4 py-3 bg-white
    @error('image') border-red-500 @enderror"
                        required>

                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm mb-2 font-medium">
                        Deskripsi
                    </label>
                    <div class="bg-white border rounded-lg overflow-hidden">
                        <div id="editor" style="height:200px;"></div>
                    </div>
                    <input type="hidden" name="description" id="description">

                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 mt-10">

                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-3 rounded-lg border hover:bg-gray-100 text-sm">
                    Batal
                </a>

                <button type="submit" class="bg-brown text-white px-8 py-3 rounded-lg hover:opacity-90 transition text-sm">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <style>
            .ql-editor {
                height: 160px;
                overflow-y: auto;
            }
        </style>

        <script>
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi produk...'
            });

            quill.on('text-change', function() {
                document.getElementById('description').value = quill.root.innerHTML;
            });

            document.querySelector('form').addEventListener('submit', function() {
                document.getElementById('description').value = quill.root.innerHTML;
            });
        </script>
    @endpush

@endsection
