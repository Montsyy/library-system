@extends('layouts.app')
@section('title', 'Transaksi Peminjaman')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Transaksi Peminjaman Buku</h2>
                <p class="text-sm text-slate-500 mt-1">Pantau transaksi peminjaman aktif, batas jatuh tempo, dan pengembalian</p>
            </div>
            <a href="{{ route('borrowings.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah Peminjaman
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form Pencarian & Filter Peminjaman --}}
        <form method="GET" action="{{ route('borrowings.index') }}" class="p-6 border-b border-slate-200 bg-slate-50/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Cari Member / Buku</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Nama member, kode, atau judul buku..."
                        class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status</label>
                    <select name="status" id="status" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="overdue" @selected(request('status') === 'overdue')>Terlambat</option>
                        <option value="due_today" @selected(request('status') === 'due_today')>Jatuh Tempo Hari Ini</option>
                        <option value="borrowed" @selected(request('status') === 'borrowed')>Sedang Dipinjam (Aktif)</option>
                        <option value="returned" @selected(request('status') === 'returned')>Sudah Dikembalikan</option>
                    </select>
                </div>
                <div>
                    <label for="sort_by" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Urutan</label>
                    <select name="sort_by" id="sort_by" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="urgent" @selected(request('sort_by', 'urgent') === 'urgent')>Prioritas Terlambat</option>
                        <option value="borrowed_desc" @selected(request('sort_by') === 'borrowed_desc')>Pinjam Terbaru</option>
                        <option value="borrowed_asc" @selected(request('sort_by') === 'borrowed_asc')>Pinjam Terlama</option>
                        <option value="due_asc" @selected(request('sort_by') === 'due_asc')>Due Date Terdekat</option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mt-4 flex items-center justify-end gap-2">
                @if (request()->hasAny(['search', 'status', 'start_date', 'end_date', 'sort_by']))
                    <a href="{{ route('borrowings.index') }}" class="px-4 py-2 text-sm text-slate-600 hover:text-slate-900 border border-slate-300 bg-white rounded-lg hover:bg-slate-50 transition">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition">
                    Terapkan Filter
                </button>
            </div>
        </form>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Petugas</th>
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
                                {{-- Nomor urut memperhitungkan pagination --}}
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                    <div>{{ $borrowing->member->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $borrowing->member->member_code ?? '' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->borrowed_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 font-medium">{{ $borrowing->due_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $borrowing->returned_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full border {{ $borrowing->status_badge['class'] }}">
                                        {{ $borrowing->status_badge['label'] }}
                                    </span>
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
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <p class="text-slate-500 font-medium">Tidak ada data peminjaman ditemukan.</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci atau bersihkan filter pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Navigasi Pagination --}}
            <div class="mt-6">
                {{ $borrowings->links() }}
            </div>
        </div>
    </div>
@endsection