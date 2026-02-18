@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-12">

    <div class="grid md:grid-cols-2 gap-10">

        <div>
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="w-full rounded-xl shadow-lg">
        </div>

        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">
                {{ $product->name }}
            </h1>

            <p class="text-primary text-xl sm:text-2xl font-semibold mt-4">
                Rp {{ number_format($product->price) }}
            </p>

            <p class="mt-6 text-gray-600 leading-relaxed">
                {{ $product->description }}
            </p>

            @php
                $waNumber = "628123456789";
                $message = urlencode("Halo, saya tertarik dengan produk {$product->name} seharga Rp ".number_format($product->price));
                $link = "https://wa.me/$waNumber?text=$message";
            @endphp

            <a href="{{ $link }}"
               target="_blank"
               class="inline-block mt-8 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow transition">
                Pesan via WhatsApp
            </a>

        </div>

    </div>

</div>

@endsection
