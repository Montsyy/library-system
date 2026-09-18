@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <h1>Daftar Buku</h1>
    <ul>
        @foreach($books as $book)
            <li>{{ $book }}</li>
        @endforeach
    </ul>
@endsection