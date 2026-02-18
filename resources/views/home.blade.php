@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-6xl font-light leading-tight">
            Modern Flower Bouquet
        </h1>

        <p class="mt-6 text-gray-500 text-lg">
            Crafted for meaningful moments. Elegant, timeless, and beautifully arranged.
        </p>
    </div>
</section>

<!-- PRODUCTS -->
<section class="max-w-7xl mx-auto px-6 pb-20">

    <div class="grid
        grid-cols-1
        sm:grid-cols-2
        md:grid-cols-3
        lg:grid-cols-4
        gap-10">

        @foreach($products as $product)
        <div class="group">

            <div class="overflow-hidden rounded-lg">
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-72 object-cover transform group-hover:scale-105 transition duration-500">
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-medium">
                    {{ $product->name }}
                </h2>

                <p class="mt-2 text-accent font-semibold">
                    Rp {{ number_format($product->price) }}
                </p>

                <a href="{{ route('product.show',$product->slug) }}"
                   class="inline-block mt-3 text-sm uppercase tracking-wider border-b border-primary hover:text-accent hover:border-accent transition">
                    View Details
                </a>
            </div>

        </div>
        @endforeach

    </div>

</section>

@endsection
