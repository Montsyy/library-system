@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Form Peminjaman Buku</h1>

    @if(session('error'))
        <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-4 bg-white p-6 border rounded">
        @csrf
        <div>
            <label class="block font-medium">Pilih Anggota (Member)</label>
            <select name="member_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Member --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->member_code }} - {{ $member->name }}
                    </option>
                @endforeach
            </select>
            @error('member_id') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        <div>
            <label class="block font-medium">Tanggal Peminjaman</label>
            <input type="date" name="borrowed_date" value="{{ old('borrowed_date', date('Y-m-d')) }}" class="w-full border p-2 rounded" required>
            <small class="text-gray-500">Jatuh tempo (Due Date) otomatis diatur 1 minggu setelah tanggal pinjam.</small>
            @error('borrowed_date') <small class="text-red-600 block">{{ $message }}</small> @enderror
        </div>

        <div>
            <label class="block font-medium mb-2">Pilih Buku yang Dipinjam (Stok Tersedia)</label>
            <div class="border p-3 rounded max-h-60 overflow-y-auto space-y-2">
                @forelse($books as $book)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="book_ids[]" value="{{ $book->id }}">
                        <span>{{ $book->title }} (Stok: {{ $book->stock }})</span>
                    </label>
                @empty
                    <p class="text-red-600">Tidak ada buku dengan stok tersedia.</p>
                @endforelse
            </div>
            @error('book_ids') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Proses Peminjaman</button>
    </form>
</div>
@endsection