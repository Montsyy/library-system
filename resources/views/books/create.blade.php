@extends('layouts.app')
@section('title', 'Masukkan Buku Baru')

@section('content')
    <a href="{{ route('books.index') }}"><-Kembali ke Daftar Buku</a>
    <h2>Masukkan Buku Baru</h2>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Judul:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="author">Penulis:</label>
            <input type="text" name="author" id="author" required>
        </div>
        <div>
            <label for="year">Tahun:</label>
            <input type="number" name="year" id="year" required>
        </div>
        <div>
            <label for="stock">Stok:</label>
            <input type="number" name="stock" id="stock" required>
        </div>
        <button type="submit">Simpan</button>
    </form>

@endsection