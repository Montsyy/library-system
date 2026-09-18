@extends('layouts.app')
@section('title', 'Daftar Member')

@section('content')
    <h2>Daftar Member</h2>
    <ul>
        @foreach($members as $member)
            <li>{{ $member }}</li>
        @endforeach
    </ul>
@endsection