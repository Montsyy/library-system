@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <ul>
        @foreach($books as $book)
            <li>{{ $book }}</li>
        @endforeach
    </ul>
    <h2>Stock Buku</h2>
    @if(!empty($stock))
            <ul>
                @foreach($stock as $title => $qty)
                    <li>
                        {{ $title }} - 
                        @if($qty > 0)
                            Tersedia ({{ $qty }})
                        @else
                            Habis
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>Data stok tidak tersedia.</p>
        @endif
@endsection