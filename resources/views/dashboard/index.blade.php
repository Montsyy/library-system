@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Perpustakaan</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-white border rounded shadow-sm">
            <p class="text-sm text-gray-500">Jumlah Judul Buku</p>
            <p class="text-3xl font-bold">{{ $totalBooks }}</p>
        </div>
        <div class="p-4 bg-white border rounded shadow-sm">
            <p class="text-sm text-gray-500">Jumlah Stok Buku Tersedia</p>
            <p class="text-3xl font-bold">{{ $totalBookStock }}</p>
        </div>
        <div class="p-4 bg-white border rounded shadow-sm">
            <p class="text-sm text-gray-500">Jumlah Member</p>
            <p class="text-3xl font-bold">{{ $totalMembers }}</p>
        </div>
        <div class="p-4 bg-white border rounded shadow-sm">
            <p class="text-sm text-gray-500">Jumlah Buku Sedang Dipinjam</p>
            <p class="text-3xl font-bold">{{ $totalBorrowedBooks }}</p>
        </div>
    </div>
</div>
@endsection