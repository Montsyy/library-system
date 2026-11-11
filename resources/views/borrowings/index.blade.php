@extends('layouts.app')
@section('title', 'Transaksi Peminjaman')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Transaksi Peminjaman Buku</h2>
            </div>
            <a href="{{ route('borrowings.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah Peminjaman
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Petugas/Admin</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Due Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-slate-700">{{ $borrowing->member->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->borrowed_date?->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->due_date?->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->returned_date?->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($borrowing->status === 'borrowed')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700 uppercase">{{ $borrowing->status }}</span>
                                    @elseif($borrowing->status === 'returned')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 uppercase">{{ $borrowing->status }}</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 uppercase">{{ $borrowing->status }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 hover:underline">Detail</a>

                                        @if($borrowing->status === 'borrowed')
                                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-emerald-600 hover:underline">Kembalikan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-slate-500">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection