@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <a href="{{ route('books.create') }}">Tambah Buku</a>
    <ul>
        @foreach($books as $book)
        <h3>
            <li>{{$book->title}}</li>
        </h3>
        <p>Penulis: {{$book->author}} </p>
        <p>Tahun: {{$book->year}}</p>
        <p>Stock: {{$book->stock}}
            @if ($book->stock > 0)
                (<span style="color: green;">Tersedia</span>)
            @else
                (<span style="color: red;">Tidak Tersedia</span>)
            @endif
        </p>
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

        <p></p>
        @endforeach
    </ul>

@endsection