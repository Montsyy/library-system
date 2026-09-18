@extends('layouts.app')
@section('title', 'Library System')
@section('content')
    <h2>Selamat Datang di Sistem Perpustakaan</h2>
    <p>Gunakan menu navigasi di atas untuk mengakses daftar buku, kategori, dan member.</p>
    <h3>Informasi Perpustakaan</h3>
    <ul>
        <li>Jumlah Buku: {{ $bookCount }}</li>
        <li>Jumlah Kategori: {{ $categoryCount }}</li>
        <li>Jumlah Member: {{ $memberCount }}</li>
    </ul>
@endsection