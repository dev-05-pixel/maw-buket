@extends('layouts.app')

@section('title', 'Rekomendasi Buket AI')

@section('content')

<h1>Rekomendasi Buket</h1>

<form method="POST" action="{{ route('ai.process') }}">
    @csrf

    <label>Budget:</label>
    <input type="number" name="budget">

    <label>Warna:</label>
    <select name="color">
        <option>Pink</option>
        <option>Putih</option>
    </select>

    <label>Jenis Bunga:</label>
    <select name="flower">
        <option>Mawar</option>
        <option>Tulip</option>
    </select>

    <button type="submit">Cari Rekomendasi</button>
</form>

@endsection
