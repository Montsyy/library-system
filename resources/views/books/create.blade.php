@extends('layouts.app')
@section('title', 'Masukkan Buku Baru')

@section('content')
    <a href="{{ route('books.index') }}"><-Kembali ke Daftar Buku</a>
    <h2>Masukkan Buku Baru</h2>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div>
        <label>Judul Buku:</label>
        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
        >
            @error('title')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
        <label>Penulis:</label>
        <input
            type="text"
            name="author"
            value="{{ old('author') }}"
        >
            @error('author')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
        <label>Kategori:</label>
        <select name="category_id">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
            @error('category_id')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
        <label>Tahun:</label>
        <input
            type="text"
            name="year"
            value="{{ old('year') }}"
        >
            @error('year')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
        <label>Stok:</label>
        <input
            type="text"
            name="stock"
            value="{{ old('stock') }}"
        >
            @error('stock')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <button type="submit">Simpan</button>
    </form>

@endsection