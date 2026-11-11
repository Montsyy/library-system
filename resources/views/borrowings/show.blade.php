@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Detail Transaksi Peminjaman #{{ $borrowing->id }}</h2>
            <a href="{{ route('borrowings.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Nama Member</p>
                    <p class="font-semibold text-slate-800">{{ $borrowing->member->name ?? '-' }} ({{ $borrowing->member->member_code ?? '-' }})</p>
                </div>
                <div>
                    <p class="text-slate-500">Dilayani Oleh</p>
                    <p class="font-semibold text-slate-800">{{ $borrowing->user->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Tanggal Pinjam</p>
                    <p class="font-semibold text-slate-800">{{ $borrowing->borrowed_date }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Jatuh Tempo</p>
                    <p class="font-semibold text-slate-800">{{ $borrowing->due_date }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Tanggal Dikembalikan</p>
                    <p class="font-semibold text-slate-800">{{ $borrowing->returned_date ?? 'Belum dikembalikan' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Status</p>
                    @if($borrowing->status === 'borrowed')
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700 uppercase">{{ $borrowing->status }}</span>
                    @elseif($borrowing->status === 'returned')
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 uppercase">{{ $borrowing->status }}</span>
                    @else
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 uppercase">{{ $borrowing->status }}</span>
                    @endif
                </div>
            </div>

            <div class="pt-2">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Daftar Buku yang Dipinjam</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Penulis</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($borrowing->details as $detail)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm font-medium text-slate-700">{{ $detail->book->title ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $detail->book->author ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $detail->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection