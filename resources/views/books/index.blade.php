@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Buku</h2>
            </div>
            <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah Buku
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Penulis</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tahun</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Stok</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($books as $book)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $book->title }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->author }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->category?->name ?? 'Belum Ada Kategori' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->year }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="font-medium text-slate-700">{{ $book->stock }}</span>
                                    @if ($book->stock > 0)
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Tersedia</span>
                                    @else
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail</a>
                                        <a href="{{ route('books.edit', $book->id) }}" class="text-indigo-600 hover:underline">Edit</a>

                                        @can('delete', $book)
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-500">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection