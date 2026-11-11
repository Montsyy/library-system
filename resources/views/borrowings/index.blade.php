@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Transaksi Peminjaman Buku</h1>
        <a href="{{ route('borrowings.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Peminjaman</a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <table class="w-full border-collapse border bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">No</th>
                <th class="border p-2 text-left">Member</th>
                <th class="border p-2 text-left">Petugas/Admin</th>
                <th class="border p-2 text-left">Tgl Pinjam</th>
                <th class="border p-2 text-left">Due Date</th>
                <th class="border p-2 text-left">Tgl Kembali</th>
                <th class="border p-2 text-left">Status</th>
                <th class="border p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $borrowing)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $borrowing->member->name ?? '-' }}</td>
                <td class="border p-2">{{ $borrowing->user->name ?? '-' }}</td>
                <td class="border p-2">{{ $borrowing->borrowed_date?->format('Y-m-d') ?? '-' }}</td>
                <td class="border p-2">{{ $borrowing->due_date?->format('Y-m-d') ?? '-' }}</td>
                <td class="border p-2">{{ $borrowing->returned_date?->format('Y-m-d') ?? '-' }}</td>
                <td class="border p-2 font-semibold uppercase">{{ $borrowing->status }}</td>
                <td class="border p-2">
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 underline">Detail</a>
                        @if($borrowing->status === 'borrowed')
                        <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?')" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-green-600 underline">Kembalikan</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border p-2 text-center">Belum ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection