@extends('admin.layouts.app')

@section('title', 'Produk')
@section('header', 'Manajemen Produk')

@section('content')

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

            <h2 class="text-lg font-semibold">
                Daftar Produk
            </h2>

            <div class="flex items-center gap-4">

                <form method="GET
                    <select name="per_page" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 text-sm">

                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>

                    </select>
                </form>

                <a href="{{ route('admin.products.create') }}"
                    class="bg-brown text-white px-5 py-2 rounded-lg hover:opacity-90 transition text-sm">
                    + Tambah Produk
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="border-b text-muted">
                    <tr>
                        <th class="py-3 text-left">Gambar</th>
                        <th class="py-3 text-left">Nama</th>
                        <th class="py-3 text-left">Kategori</th>
                        <th class="py-3 text-left">Harga</th>
                        <th class="py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($products as $product)
                        <tr class="hover:bg-cream transition">

                            <td class="py-4">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-16 h-16 object-cover rounded-lg border">
                                @else
                                    <span class="text-gray-400 text-xs">No Image</span>
                                @endif
                            </td>
                            <td class="py-4 font-medium">
                                {{ $product->name }}
                            </td>

                            <td class="py-4">
                                {{ $product->category }}
                            </td>

                            <td class="py-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td class="py-4 space-x-3 text-sm">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="text-softbrown hover:underline">
                                    Edit
                                </a>
                                <button onclick="openDeleteModal('{{ $product->id }}','{{ $product->name }}')"
                                    class="text-red-500 hover:underline">
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

    <!-- DELETE MODAL -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">

        <div class="bg-white rounded-2xl shadow-xl w-[420px] p-6 relative">

            <h3 class="text-lg font-semibold mb-2">
                Hapus Produk
            </h3>

            <p class="text-sm text-gray-600 mb-6">
                Apakah kamu yakin ingin menghapus produk
                <span id="productName" class="font-semibold"></span> ?
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">

                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </button>

                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Konfirmasi Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openDeleteModal(id, name) {

                document.getElementById('deleteModal').classList.remove('hidden')

                document.getElementById('productName').innerText = name

                document.getElementById('deleteForm').action =
                    "/admin/products/" + id

            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden')
            }

            document.getElementById('deleteModal').addEventListener('click', function(e) {

                if (e.target.id === 'deleteModal') {
                    closeDeleteModal()
                }

            })
        </script>
    @endpush
@endsection
