@extends('layouts.app')

@section('title', 'Maw Bucket - Premium Flower Bouquet')
@section('meta_description', 'Discover elegant handcrafted flower bouquets for your special moments.')

@section('content')

<!-- HERO -->
<section class="relative h-[75vh] flex items-center justify-center overflow-hidden">

    <img src="https://images.unsplash.com/photo-1525310072745-f49212b5ac6d"
         class="absolute inset-0 w-full h-full object-cover scale-105">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative text-center text-white px-6 animate-fadeIn">
        <h1 class="text-4xl md:text-6xl font-light tracking-wide leading-tight">
            Elegance in Every Bouquet
        </h1>

        <p class="mt-6 text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
            Handcrafted arrangements for meaningful moments.
        </p>

        <a href="#products"
           class="inline-block mt-8 px-8 py-3 border border-white uppercase tracking-widest text-sm hover:bg-white hover:text-black transition duration-500">
            Explore Collection
        </a>
    </div>

</section>

<!-- PRODUCTS -->
<section id="products" class="max-w-7xl mx-auto px-6 py-16">

    <!-- FILTER -->
    <form method="GET" class="mb-12 grid md:grid-cols-5 gap-4">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search product..."
               class="border px-4 py-2 w-full">

        <select name="category" class="border px-4 py-2 w-full">
            <option value="">All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->slug }}"
                    {{ request('category') == $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="border px-4 py-2 w-full">
            <option value="">Newest</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                Price: Low to High
            </option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                Price: High to Low
            </option>
            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                Best Seller
            </option>
        </select>

        <button class="bg-black text-white px-4 py-2">
            Apply
        </button>

    </form>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

        @foreach ($products as $product)
            <div class="group">

                <div class="overflow-hidden rounded-lg">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700 ease-out">
                </div>

                <div class="mt-4">
                    <h2 class="text-lg font-medium">
                        {{ $product->name }}
                    </h2>

                    <p class="mt-2 text-amber-700 font-semibold">
                        Rp {{ number_format($product->price) }}
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

                    <a href="{{ route('product.show', $product->slug) }}"
                       class="block mt-3 text-sm uppercase tracking-wider border-b border-black hover:text-amber-700 hover:border-amber-700 transition">
                        View Details
                    </a>
                </div>

            </div>
        @endforeach

    </div>

    <!-- PAGINATION -->
    <div class="mt-16">
        {{ $products->links() }}
    </div>

</section>

@endsection
