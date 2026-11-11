@extends('layouts.app')
@section('title', 'Dashboard Statistik')

@section('content')
    <h2>Selamat Datang di Sistem Perpustakaan</h2>
    <p>Gunakan menu navigasi di atas untuk mengakses daftar buku, kategori, member, dan transaksi peminjaman.</p>

    <h3>Statistik Perpustakaan</h3>

    {{-- Tampilan Card Statistik --}}
    <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 20px;">
        <div style="border: 1px solid #ccc; padding: 15px; min-width: 180px; background-color: #f9f9f9;">
            <strong>Jumlah Judul Buku</strong>
            <h2 style="margin: 8px 0 0 0;">{{ $totalBooks }} Judul</h2>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; min-width: 180px; background-color: #f9f9f9;">
            <strong>Jumlah Stok Buku</strong>
            <h2 style="margin: 8px 0 0 0; color: green;">{{ $totalBookStock }} Eksemplar</h2>
        </div>

        <div style="border: 1px solid #ccc; padding: 15px; min-width: 180px; background-color: #f9f9f9;">
            <strong>Jumlah Member</strong>
            <h2 style="margin: 8px 0 0 0;">{{ $totalMembers }} Orang</h2>
        </div>

        <div style="border: 1px solid #ccc; padding: 15px; min-width: 180px; background-color: #f9f9f9;">
            <strong>Sedang Dipinjam</strong>
            <h2 style="margin: 8px 0 0 0; color: #d97706;">{{ $totalBorrowedBooks }} Buku</h2>
        </div>
    </div>

    {{-- Ringkasan List & Aksi Cepat --}}
    <ul>
        <li>Jumlah Judul Buku: <strong>{{ $totalBooks }}</strong> (<a href="{{ route('books.index') }}">Lihat Buku</a>)</li>
        <li>Jumlah Stok Buku Tersedia: <strong>{{ $totalBookStock }}</strong></li>
        <li>Jumlah Member Terdaftar: <strong>{{ $totalMembers }}</strong> (<a href="{{ route('members.index') }}">Lihat Member</a>)</li>
        <li>Jumlah Buku yang Sedang Dipinjam: <strong>{{ $totalBorrowedBooks }}</strong> (<a href="{{ route('borrowings.index') }}">Lihat Peminjaman</a>)</li>
    </ul>
@endsection