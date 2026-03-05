@extends('admin.layouts.app')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')

    <div class="max-w-4xl bg-white p-10 rounded-2xl shadow-sm border">

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Nama Produk -->
                <div class="md:col-span-2">

                    <label class="block text-sm mb-2 font-medium">
                        Nama Produk
                    </label>

                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none">

                </div>


                <!-- Harga -->
                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Harga
                    </label>

                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none">

                </div>


                <!-- Kategori -->
                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Kategori
                    </label>

                    <select name="category"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none">

                        <option value="">-- Pilih Kategori --</option>

                        <option value="Buket Segar" {{ $product->category == 'Buket Segar' ? 'selected' : '' }}>
                            Buket Segar
                        </option>

                        <option value="Buket Kering" {{ $product->category == 'Buket Kering' ? 'selected' : '' }}>
                            Buket Kering
                        </option>

                        <option value="Pampas" {{ $product->category == 'Pampas' ? 'selected' : '' }}>
                            Pampas
                        </option>

                        <option value="Mini Bouquet" {{ $product->category == 'Mini Bouquet' ? 'selected' : '' }}>
                            Mini Bouquet
                        </option>

                    </select>

                </div>


                <!-- Upload Gambar -->
                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Gambar Produk
                    </label>

                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-24 mb-3 rounded-lg border">
                    @endif

                    <input type="file" name="image" class="w-full border rounded-lg px-4 py-3">

                </div>


                <!-- DESKRIPSI -->
                <div class="md:col-span-2">

                    <label class="block text-sm mb-2 font-medium">
                        Deskripsi
                    </label>

                    <div class="bg-white border rounded-lg overflow-hidden">
                        <div id="editor" style="height:200px;"></div>
                    </div>

                    <input type="hidden" name="description" id="description">

                    <textarea id="oldDescription" hidden>{!! $product->description !!}</textarea>

                </div>

            </div>


            <div class="flex justify-end gap-4 mt-10">

                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 rounded-lg border hover:bg-gray-100 text-sm">
                    Batal
                </a>

                <button type="submit" class="bg-brown text-white px-8 py-3 rounded-lg hover:opacity-90 transition text-sm">
                    Update Produk
                </button>

            </div>

        </form>

    </div>

    @push('scripts')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi produk...'
            });

            var oldDescription = document.getElementById('oldDescription').value;

            if (oldDescription) {
                quill.root.innerHTML = oldDescription;
                document.getElementById('description').value = oldDescription;
            }

            quill.on('text-change', function() {
                document.getElementById('description').value = quill.root.innerHTML;
            });

            document.querySelector('form').addEventListener('submit', function() {
                document.getElementById('description').value = quill.root.innerHTML;
            });
        </script>
    @endpush

@endsection
