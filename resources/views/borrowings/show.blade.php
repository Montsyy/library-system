@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Transaksi Peminjaman #{{ $borrowing->id }}</h1>

    <div class="bg-white p-4 border rounded mb-6 space-y-1">
        <p><strong>Nama Member:</strong> {{ $borrowing->member->name ?? '-' }} ({{ $borrowing->member->member_code ?? '-' }})</p>
        <p><strong>Dilayani Oleh (Admin/Petugas):</strong> {{ $borrowing->user->name ?? '-' }}</p>
        <p><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrowed_date }}</p>
        <p><strong>Jatuh Tempo (Due Date):</strong> {{ $borrowing->due_date }}</p>
        <p><strong>Tanggal Dikembalikan:</strong> {{ $borrowing->returned_date ?? 'Belum dikembalikan' }}</p>
        <p><strong>Status:</strong> <span class="uppercase font-bold">{{ $borrowing->status }}</span></p>
    </div>

    <h2 class="text-xl font-bold mb-2">Daftar Buku yang Dipinjam</h2>
    <table class="w-full border-collapse border bg-white mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">Judul Buku</th>
                <th class="border p-2 text-left">Penulis</th>
                <th class="border p-2 text-left">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowing->details as $detail)
            <tr>
                <td class="border p-2">{{ $detail->book->title ?? '-' }}</td>
                <td class="border p-2">{{ $detail->book->author ?? '-' }}</td>
                <td class="border p-2">{{ $detail->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Kembali</a>
</div>
@endsection