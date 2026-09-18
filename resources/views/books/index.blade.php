@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <ul>
        @foreach($books as $book)
            <li>
                <p>Judul: <strong>{{ $book['title'] }}</strong></p>
                <p>Penulis: {{ $book['author'] }}</p>
                <p>Tahun terbit: {{ $book['tahun'] }}</p>
                <p>Stock: {{ $stock[$book['id'] - 1]['stock'] ?? 0 }}
                    @if ($stock[$book['id'] - 1]['stock'] > 0)
                        (Tersedia)
                    @else
                        (Habis)
                    @endif
                </p>
            </li>
        @endforeach
    </ul>

@endsection