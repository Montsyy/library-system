@extends('layouts.app')
@section('title', 'Update Buku')

@section('content')
    <a href="{{ route('books.index') }}"><-Kembali ke Daftar Buku</a>
    <h2>Update Buku</h2>
    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Judul:</label>
            <input type="text" name="title" id="title" value="{{ $book->title }}" required>
        </div>
        <div>
            <label for="author">Penulis:</label>
            <input type="text" name="author" id="author" value="{{ $book->author }}" required>
        </div>
        <div>
            <label for="year">Tahun:</label>
            <input type="number" name="year" id="year" value="{{ $book->year }}" required>
        </div>
        <div>
            <label for="stock">Stok:</label>
            <input type="number" name="stock" id="stock" value="{{ $book->stock }}" required>
        </div>
        <button type="submit">Update</button>
    </form>

@endsection