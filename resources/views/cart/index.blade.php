@extends('layouts.app')

@section('title', 'Shopping Cart - Maw Bucket')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-16">

    <h1 class="text-3xl font-light mb-10">
        Shopping Cart
    </h1>

    @php
        $cart = session('cart', []);
        $total = 0;
    @endphp

    @if(count($cart) > 0)

        <div class="space-y-6">

            @foreach($cart as $id => $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp

                <div class="flex flex-col md:flex-row items-center justify-between border-b pb-6">

                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             class="w-24 h-24 object-cover rounded">

                        <div>
                            <h2 class="text-lg font-medium">
                                {{ $item['name'] }}
                            </h2>

                            <p class="text-gray-500 text-sm">
                                Quantity: {{ $item['quantity'] }}
                            </p>

                            <p class="text-amber-700 font-semibold mt-2">
                                Rp {{ number_format($subtotal) }}
                            </p>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>

        <!-- TOTAL -->
        <div class="mt-12 text-right">
            <h2 class="text-2xl font-semibold">
                Total: Rp {{ number_format($total) }}
            </h2>

            <form action="{{ route('checkout') }}" method="POST" class="mt-6">
                @csrf
                <button class="bg-black text-white px-8 py-3 uppercase tracking-wider hover:bg-gray-800 transition">
                    Checkout
                </button>
            </form>
        </div>

    @else

        <div class="text-center text-gray-500 py-20">
            Your cart is empty.
        </div>

    @endif

</div>

@endsection
