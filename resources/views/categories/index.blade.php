@extends('layouts.app')
@section('title', 'Daftar Kategori')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Kategori Buku</h2>
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                    + Tambah Kategori
                </a>
            @endif
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
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jumlah Buku</th>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $category->books_count }}</td>
                                @if(auth()->user()->role === 'admin')
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:underline">Edit</a>

                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" class="px-4 py-10 text-center text-slate-500">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection