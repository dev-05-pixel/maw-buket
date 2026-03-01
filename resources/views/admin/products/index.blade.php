@extends('admin.layouts.app')

@section('title', 'Produk')
@section('header', 'Manajemen Produk')

@section('content')

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h2 class="text-lg font-semibold">
                Daftar Produk
            </h2>

            <a href="{{ route('admin.products.create') }}"
                class="bg-brown text-white px-5 py-2 rounded-lg hover:opacity-90 transition text-sm">
                + Tambah Produk
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="border-b text-muted">
                    <tr>
                        <th class="py-3 text-left">ID</th>
                        <th class="py-3 text-left">Nama</th>
                        <th class="py-3 text-left">Harga</th>
                        <th class="py-3 text-left">Stok</th>
                        <th class="py-3 text-left">Status</th>
                        <th class="py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($products as $product)
                        <tr class="hover:bg-cream transition">

                            <td class="py-4">{{ $product->id }}</td>

                            <td class="py-4 font-medium">
                                {{ $product->name }}
                            </td>

                            <td class="py-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td class="py-4">
                                @if ($product->stock > 0)
                                    <span class="text-green-600 font-medium">
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-red-500 font-medium">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td class="py-4">
                                @if ($product->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 space-x-3 text-sm">
                                <button class="text-softbrown hover:underline">
                                    Edit
                                </button>
                                <button class="text-red-500 hover:underline">
                                    Hapus
                                </button>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>

@endsection
