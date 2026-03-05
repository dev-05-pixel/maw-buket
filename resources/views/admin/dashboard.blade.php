@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <p class="text-sm text-muted">Total Produk</p>
        <h2 class="text-3xl font-semibold mt-2">
            {{ \App\Models\Product::count() }}
        </h2>
    </div>
</div>

<div class="mt-10 bg-white p-8 rounded-xl shadow-sm border">
    <h3 class="text-lg font-semibold mb-2">Informasi Login</h3>
    <p class="text-muted text-sm">
        Anda login sebagai: <span class="font-medium text-brown">{{ $email }}</span>
    </p>
</div>

@endsection
