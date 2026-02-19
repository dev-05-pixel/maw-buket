@extends('layouts.app')

@section('title', 'Shopping Cart - Maw Bucket')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-16">

    <h1 class="text-3xl font-light mb-10">
        Shopping Cart
    </h1>

    @php
        $cart = session('cart', []);
    @endphp

    @if(count($cart) > 0)

        <div class="space-y-6">

            @foreach ($cart as $uid => $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                @endphp

                <div class="flex items-center space-x-6 border-b pb-6">

                    <!-- CHECKBOX -->
                    <input type="checkbox"
                        class="item-checkbox w-5 h-5"
                        data-price="{{ $subtotal }}"
                        data-name="{{ $item['name'] }}"
                        data-qty="{{ $item['quantity'] }}">

                    <!-- IMAGE -->
                    <img src="{{ asset('storage/' . $item['image']) }}"
                        class="w-24 h-24 object-cover rounded">

                    <div class="flex-1">

                        <h2 class="text-lg font-medium">
                            {{ $item['name'] }}
                        </h2>

                        <!-- UPDATE QTY -->
                        <form action="{{ route('cart.update', $uid) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="number"
                                name="quantity"
                                value="{{ $item['quantity'] }}"
                                min="1"
                                class="w-20 border px-2 py-1">
                            <button class="ml-2 text-sm text-blue-600 hover:underline">
                                Update
                            </button>
                        </form>

                        <!-- REMOVE -->
                        <form action="{{ route('cart.remove', $uid) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-600 hover:underline">
                                Remove
                            </button>
                        </form>

                    </div>

                    <div class="text-right font-semibold">
                        Rp {{ number_format($subtotal) }}
                    </div>

                </div>
            @endforeach

        </div>

        <!-- TOTAL -->
        <div class="mt-12 text-right">
            <h2 class="text-2xl font-semibold">
                Total: Rp <span id="totalPrice">0</span>
            </h2>

            <button type="button"
                onclick="checkoutWhatsApp()"
                class="inline-block mt-6 bg-green-600 text-white px-8 py-3 uppercase tracking-wider hover:bg-green-700 transition duration-300">
                Pesan via WhatsApp
            </button>
        </div>

    @else
        <div class="text-center text-gray-500 py-20">
            Your cart is empty.
        </div>
    @endif

</div>


<script>
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceElement = document.getElementById('totalPrice');

    function updateTotal() {
        let total = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.price);
            }
        });

        totalPriceElement.innerText = total.toLocaleString('id-ID');
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    function checkoutWhatsApp() {

        let selectedItems = [];
        let total = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                let name = cb.dataset.name;
                let qty = cb.dataset.qty;
                let price = parseInt(cb.dataset.price);

                total += price;

                selectedItems.push(
                    "• " + name + "\n" +
                    "  Qty : " + qty + "\n" +
                    "  Subtotal : Rp " + price.toLocaleString('id-ID') + "\n"
                );
            }
        });

        if (selectedItems.length === 0) {
            alert("Pilih minimal 1 produk terlebih dahulu.");
            return;
        }

        let message =
            "Halo Maw Bucket 🌸, saya ingin memesan:\n\n" +
            selectedItems.join("\n") +
            "\nTotal Pembayaran : Rp " + total.toLocaleString('id-ID') +
            "\n\nMohon info ketersediaan dan estimasi pengirimannya ya. Terima kasih 🙏";

        let phone = "6281234567890"; // GANTI NOMOR WA KAMU
        let url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);

        window.open(url, '_blank');
    }
</script>

@endsection
