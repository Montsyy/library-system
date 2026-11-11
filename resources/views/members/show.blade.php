@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Anggota: {{ $member->name }}</h1>
    <div class="bg-white p-4 border rounded mb-6">
        <p><strong>Kode Anggota:</strong> {{ $member->member_code }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>
    </div>

    <h2 class="text-xl font-bold mb-2">Riwayat Peminjaman</h2>
    <table class="w-full border-collapse border bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">Tanggal Pinjam</th>
                <th class="border p-2 text-left">Jatuh Tempo</th>
                <th class="border p-2 text-left">Tanggal Kembali</th>
                <th class="border p-2 text-left">Status</th>
                <th class="border p-2 text-left">Buku</th>
            </tr>
        </thead>
        <tbody>
            @forelse($member->borrowings as $borrowing)
            <tr>
                <td class="border p-2">{{ $borrowing->borrowed_date }}</td>
                <td class="border p-2">{{ $borrowing->due_date }}</td>
                <td class="border p-2">{{ $borrowing->returned_date ?? '-' }}</td>
                <td class="border p-2 uppercase">{{ $borrowing->status }}</td>
                <td class="border p-2">
                    <ul class="list-disc ml-4">
                        @foreach($borrowing->details as $detail)
                            <li>{{ $detail->book->title ?? '-' }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border p-2 text-center">Belum ada riwayat peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection