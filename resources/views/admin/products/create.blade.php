@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk')

@section('content')

<div class="max-w-4xl bg-white p-10 rounded-2xl shadow-sm border">

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Nama Produk -->
            <div class="md:col-span-2">
                <label class="block text-sm mb-2 font-medium">
                    Nama Produk
                </label>
                <input type="text" name="name"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none"
                       required>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm mb-2 font-medium">
                    Harga (Rp)
                </label>
                <input type="number" step="0.01" name="price"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none"
                       required>
            </div>

            <!-- Stok -->
            <div>
                <label class="block text-sm mb-2 font-medium">
                    Stok
                </label>
                <input type="number" name="stock"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm mb-2 font-medium">
                    Status Produk
                </label>
                <select name="is_active"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm mb-2 font-medium">
                    Gambar Produk
                </label>
                <input type="file" name="image"
                       class="w-full border rounded-lg px-4 py-3 bg-white">
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label class="block text-sm mb-2 font-medium">
                    Deskripsi
                </label>
                <textarea name="description"
                          rows="5"
                          class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent outline-none"></textarea>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4 mt-10">

            <a href="{{ route('admin.products.index') }}"
               class="px-6 py-3 rounded-lg border hover:bg-gray-100 text-sm">
                Batal
            </a>

            <button type="submit"
                    class="bg-brown text-white px-8 py-3 rounded-lg hover:opacity-90 transition text-sm">
                Simpan Produk
            </button>

        </div>

    </form>

</div>

@endsection
