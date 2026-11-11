@extends('layouts.app')
@section('title', 'Detail Member')

@section('content')
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Detail Member: {{ $member->name }}</h2>
            <a href="{{ route('members.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Kode Member</p>
                    <p class="font-semibold text-slate-800">{{ $member->member_code }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Nama</p>
                    <p class="font-semibold text-slate-800">{{ $member->name }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-slate-500">Email</p>
                    <p class="font-semibold text-slate-800">{{ $member->email }}</p>
                </div>
            </div>

            <div class="pt-2">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Riwayat Peminjaman</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Buku</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($member->borrowings as $borrowing)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->borrowed_date }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->due_date }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->returned_date ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 uppercase">{{ $borrowing->status }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($borrowing->details as $detail)
                                                <li>{{ $detail->book->title ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection