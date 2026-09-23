@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <ul>
        @foreach($books as $book)
        <h3>
            <li>{{$book->title}}</li>
        </h3>
        <p>Penulis: {{$book->author}} </p>
        <p>Tahun: {{$book->year}}</p>
        <p>Stock: {{$book->stock}}</p>
        <p></p>
        @endforeach
    </ul>

@endsection