@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', $product->name . ' - Maw Bucket')
@section('meta_description', Str::limit($product->description, 150))

@section('content')

<div class="max-w-6xl mx-auto px-6 py-16">

    <div class="grid md:grid-cols-2 gap-12">

        <div>
            <img src="{{ asset('storage/' . $product->image) }}"
                 class="w-full rounded-lg shadow-lg">
        </div>

        <div>
            <h1 class="text-3xl md:text-4xl font-light">
                {{ $product->name }}
            </h1>

            <p class="mt-4 text-2xl text-amber-700 font-semibold">
                Rp {{ number_format($product->price) }}
            </p>

            <p class="mt-6 text-gray-600 leading-relaxed">
                {{ $product->description }}
            </p>

            @if ($product->stock > 0)
                <span class="text-green-600 text-sm">
                    In Stock ({{ $product->stock }})
                </span>
            @else
                <span class="text-red-600 text-sm font-semibold">
                    Out of Stock
                </span>
            @endif

            @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button class="text-sm border px-6 py-3 hover:bg-black hover:text-white transition">
                        Add to Cart
                    </button>
                </form>
            @else
                <button disabled
                        class="mt-6 text-sm border px-6 py-3 bg-gray-200 text-gray-400 cursor-not-allowed">
                    Out of Stock
                </button>
            @endif

        </div>
    </div>

</div>

@endsection
