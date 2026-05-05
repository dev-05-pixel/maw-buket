@extends('layouts.app')

@section('title', 'Hasil Rekomendasi')

@section('content')

<h1>Hasil Rekomendasi</h1>

@if(count($products) > 0)
    @foreach($products as $product)
        <div>
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }}</p>
        </div>
    @endforeach
@else
    <p>Tidak ada rekomendasi.</p>
@endif

@endsection
