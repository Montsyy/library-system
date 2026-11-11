@extends('layouts.app')
@section('title', 'Detail Buku')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Detail Buku</h2>
            <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Judul</p>
                    <p class="font-semibold text-slate-800">{{ $book->title }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Penulis</p>
                    <p class="font-semibold text-slate-800">{{ $book->author }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Kategori</p>
                    <p class="font-semibold text-slate-800">{{ $book->category?->name ?? 'Belum Ada Kategori' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Tahun</p>
                    <p class="font-semibold text-slate-800">{{ $book->year }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-slate-500">Stok</p>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="font-semibold text-slate-800">{{ $book->stock }}</span>
                        @if ($book->stock > 0)
                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Tersedia</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Tidak Tersedia</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-4">
                <a href="{{ route('books.edit', $book->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                    Edit Buku
                </a>

                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                        Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
