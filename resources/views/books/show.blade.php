@extends('layouts.app')
@section('title', 'Book Details')
@section('content')

    <a href="{{ route('books.index') }}"><-Kembali ke Daftar Buku</a>
    <h1>Book Details</h1>
    <p>Book ID: {{ $book->id }}</p>
    <h3>
        <li>{{$book->title}}</li>
    </h3>
    <p>Penulis: {{$book->author}}</p>
    <p>Tahun: {{$book->year}}</p>
    <p>Stock: {{$book->stock}}
        @if ($book->stock > 0)
            (<span style="color: green;">Tersedia</span>)
        @else
            (<span style="color: red;">Tidak Tersedia</span>)
        @endif

    <form 
        action="{{ route('books.edit', $book->id) }}" method="GET">
            <button type="submit">Edit Buku</button>
    </form>
        <p></p>
    <form
            action="{{ route('books.destroy', $book) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus Buku
            </button>
    </form>

@endsection
