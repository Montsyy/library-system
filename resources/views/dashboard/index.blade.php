@extends('layouts.app')
@section('title', 'Dashboard Statistik')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang di Sistem Perpustakaan</h2>
            <p class="mt-2 text-slate-600">
                Gunakan menu navigasi di atas untuk mengakses daftar buku, kategori, member, dan transaksi peminjaman.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">Jumlah Judul Buku</p>
                <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ $totalBooks }}</h3>
                <p class="mt-2 text-sm text-slate-500">Judul</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">Jumlah Stok Buku</p>
                <h3 class="mt-3 text-3xl font-bold text-emerald-600">{{ $totalBookStock }}</h3>
                <p class="mt-2 text-sm text-slate-500">Eksemplar</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">Jumlah Member</p>
                <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ $totalMembers }}</h3>
                <p class="mt-2 text-sm text-slate-500">Orang</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">Sedang Dipinjam</p>
                <h3 class="mt-3 text-3xl font-bold text-amber-600">{{ $totalBorrowedBooks }}</h3>
                <p class="mt-2 text-sm text-slate-500">Buku</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Ringkasan Cepat</h3>
            <ul class="space-y-3 text-slate-700">
                <li class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span>Jumlah Judul Buku</span>
                    <strong>{{ $totalBooks }}</strong>
                </li>
                <li class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span>Jumlah Stok Buku Tersedia</span>
                    <strong>{{ $totalBookStock }}</strong>
                </li>
                <li class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span>Jumlah Member Terdaftar</span>
                    <strong>{{ $totalMembers }}</strong>
                </li>
                <li class="flex items-center justify-between">
                    <span>Jumlah Buku yang Sedang Dipinjam</span>
                    <strong>{{ $totalBorrowedBooks }}</strong>
                </li>
            </ul>
        </div>
    </div>
@endsection