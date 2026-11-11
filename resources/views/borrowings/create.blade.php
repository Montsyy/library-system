@extends('layouts.app')
@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Form Peminjaman Buku</h2>
            <a href="{{ route('borrowings.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('borrowings.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Anggota (Member)</label>
                <select name="member_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                    <option value="">-- Pilih Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->member_code }} - {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Peminjaman</label>
                <input type="date" name="borrowed_date" value="{{ old('borrowed_date', date('Y-m-d')) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                <p class="mt-1 text-sm text-slate-500">Jatuh tempo (Due Date) otomatis diatur 1 minggu setelah tanggal pinjam.</p>
                @error('borrowed_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Buku yang Dipinjam (Stok Tersedia)</label>
                <div class="border border-slate-200 rounded-xl p-4 max-h-72 overflow-y-auto space-y-3 bg-slate-50">
                    @forelse($books as $book)
                        <label class="flex items-center gap-3 rounded-lg px-2 py-2 hover:bg-white transition">
                            <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="h-4 w-4 text-blue-600 border-slate-300 rounded focus:ring-blue-200">
                            <span class="text-sm text-slate-700">{{ $book->title }} <span class="text-slate-500">(Stok: {{ $book->stock }})</span></span>
                        </label>
                    @empty
                        <p class="text-sm text-red-600">Tidak ada buku dengan stok tersedia.</p>
                    @endforelse
                </div>
                @error('book_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                    Proses Peminjaman
                </button>
            </div>
        </form>
    </div>
@endsection