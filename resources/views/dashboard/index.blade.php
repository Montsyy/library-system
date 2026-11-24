@extends('layouts.app')
@section('title', 'Dashboard Statistik Perpustakaan')

@section('content')
    {{-- Muat Chart.js via CDN resmi --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-8">
        {{-- Header Ucapan Selamat Datang --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard Statistik Perpustakaan</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Ringkasan performa koleksi, aktivitas peminjaman buku, dan status anggota secara real-time.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('borrowings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    + Catat Peminjaman
                </a>
            </div>
        </div>

        {{-- Baris Kartu Indikator Utama --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul Buku</span>
                <div class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalBooks) }}</div>
                <div class="mt-1 text-xs text-slate-500">Total judul terdaftar</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Eksemplar</span>
                <div class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalBookStock) }}</div>
                <div class="mt-1 text-xs text-slate-500">Fisik buku di rak</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Dipinjam</span>
                <div class="mt-2 text-3xl font-bold text-blue-600">{{ number_format($totalBorrowedBooks) }}</div>
                <div class="mt-1 text-xs text-slate-500">Buku di tangan anggota</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat Kembali</span>
                <div class="mt-2 text-3xl font-bold {{ $overdueCount > 0 ? 'text-red-600' : 'text-slate-800' }}">
                    {{ number_format($overdueCount) }}
                </div>
                <div class="mt-1 text-xs text-slate-500">Melewati batas due date</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Anggota</span>
                <div class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalMembers) }}</div>
                <div class="mt-1 text-xs text-slate-500">Member perpustakaan</div>
            </div>
        </div>

        {{-- Baris Grafik Statistik Interaktif --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Grafik 1: Tren Peminjaman 7 Hari Terakhir --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:col-span-2">
                <h3 class="text-base font-bold text-slate-800 mb-1">Tren Aktivitas Peminjaman (7 Hari Terakhir)</h3>
                <p class="text-xs text-slate-500 mb-4">Frekuensi transaksi peminjaman buku harian</p>
                <div class="relative h-64 w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            {{-- Grafik 2: Komposisi Koleksi per Kategori --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-800 mb-1">Koleksi per Kategori</h3>
                <p class="text-xs text-slate-500 mb-4">Proporsi jumlah buku terdaftar</p>
                <div class="relative h-64 w-full flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Baris Tabel Ringkasan Tindakan dan Buku Terpopuler --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Peminjaman Mendekati / Melewati Jatuh Tempo --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Perlu Perhatian (Due Date Dekat / Lewat)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Peminjaman aktif yang membutuhkan follow-up</p>
                    </div>
                    <a href="{{ route('borrowings.index', ['status' => 'overdue']) }}" class="text-xs text-blue-600 font-medium hover:underline">
                        Lihat Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Member</th>
                                <th class="px-4 py-3 text-left">Due Date</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($urgentBorrowings as $row)
                                <tr class="hover:bg-slate-50">
                                    {{-- Kolom 1: Member --}}
                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        <div>{{ $row->member?->name ?? 'Member Tidak Diketahui' }}</div>
                                        @if($row->member?->member_code)
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $row->member->member_code }}</div>
                                        @endif
                                    </td>

                                    {{-- Kolom 2: Due Date --}}
                                    <td class="px-4 py-3 text-slate-600 font-medium">
                                        {{ $row->due_date?->format('d M Y') }}
                                    </td>

                                    {{-- Kolom 3: Status (Hanya 1 tag td tunggal) --}}
                                    <td class="px-4 py-3">
                                        @if ($row->due_date)
                                            @if ($row->due_date->isPast() && ! $row->due_date->isToday())
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200">
                                                    Terlambat
                                                </span>
                                            @elseif ($row->due_date->isToday())
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                                    Jatuh Tempo Hari Ini
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                    Segera Kembali
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-400">Tidak ada tanggal</span>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Aksi --}}
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('borrowings.show', $row->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition">
                                            Rincian
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500 text-xs">
                                        Tidak ada peminjaman yang mendesak atau terlambat saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- 5 Buku Paling Sering Dipinjam --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Header Card dengan Link 'Lihat Semua' yang Selaras --}}
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">5 Buku Paling Sering Dipinjam</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Buku dengan tingkat perputaran peminjaman tertinggi</p>
                </div>
                <a href="{{ route('books.index') }}" class="text-xs text-blue-600 font-medium hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Judul Buku</th>
                            <th class="px-4 py-3 text-left">Penulis</th>
                            <th class="px-4 py-3 text-center">Dipinjam</th>
                            <th class="px-4 py-3 text-center">Stok</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($popularBooks as $book)
                            <tr class="hover:bg-slate-50">
                                {{-- Kolom 1: Judul Buku --}}
                                <td class="px-4 py-3 font-semibold text-slate-800">
                                    {{ $book->title }}
                                </td>

                                {{-- Kolom 2: Penulis --}}
                                <td class="px-4 py-3 text-slate-600 font-medium">
                                    {{ $book->author }}
                                </td>

                                {{-- Kolom 3: Frekuensi Peminjaman (Badge Biru) --}}
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                        {{ $book->total_borrowed }}x
                                    </span>
                                </td>

                                {{-- Kolom 4: Status Stok Buku --}}
                                <td class="px-4 py-3 text-center">
                                    @if ($book->stock > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                            Sisa {{ $book->stock }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom 5: Tombol Aksi Detail (Sama dengan tombol Rincian sebelah) --}}
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('books.show', $book->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500 text-xs">
                                    Belum ada riwayat transaksi peminjaman buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Script Inisialisasi Chart.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Grafik Tren Peminjaman
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($borrowTrendLabels),
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: @json($borrowTrendData),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#64748b' },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { color: '#64748b' },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Inisialisasi Grafik Kategori Buku
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryData),
                        backgroundColor: [
                            '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#64748b'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection