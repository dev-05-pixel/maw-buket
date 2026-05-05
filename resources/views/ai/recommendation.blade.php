@extends('layouts.app')

@section('title', 'Rekomendasi Buket AI')

@section('content')

<h1>Rekomendasi Buket</h1>

<form method="POST" action="{{ route('ai.process') }}">
    @csrf

    <label>Budget:</label>
    <input type="number" name="budget" required>

    <label>Warna:</label>
    <select name="color">
        <option value="Pink">Pink</option>
        <option value="Putih">Putih</option>
    </select>

    <label>Jenis Bunga:</label>
    <select name="flower">
        <option value="Mawar">Mawar</option>
        <option value="Tulip">Tulip</option>
    </select>

    <button type="submit">Cari Rekomendasi</button>
</form>

<hr>

@if(isset($products) && count($products) > 0)
    <h2>Hasil Rekomendasi</h2>

    <div class="grid">
        @foreach($products as $product)
            <div class="card">
                <h3>{{ $product->name }}</h3>
                <p>Harga: {{ $product->price }}</p>
                <p>Warna: {{ $product->color }}</p>
            </div>
        @endforeach
    </div>
@else
    <p>Tidak ada rekomendasi yang cocok.</p>
@endif

@endsection
