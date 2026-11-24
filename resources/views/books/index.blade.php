@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Buku</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola katalog koleksi buku dan stok perpustakaan</p>
            </div>
            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah Buku
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Pencarian, Filter, dan Sorting --}}
        <form method="GET" action="{{ route('books.index') }}" class="p-6 border-b border-slate-200 bg-slate-50/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                {{-- Input Pencarian --}}
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Cari Judul / Penulis</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Ketik judul buku atau penulis..."
                        class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Filter Kategori --}}
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Stok --}}
                <div>
                    <label for="stock_status" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status Stok</label>
                    <select name="stock_status" id="stock_status"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="available" @selected(request('stock_status') === 'available')>Stok Tersedia (> 0)</option>
                        <option value="empty" @selected(request('stock_status') === 'empty')>Stok Habis (0)</option>
                    </select>
                </div>

                {{-- Urutkan (Sorting Huruf & Angka) --}}
                <div>
                    <label for="sort_by" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Urutan</label>
                    <select name="sort_by" id="sort_by"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="latest" @selected(request('sort_by') === 'latest')>Terbaru Ditambahkan</option>
                        <option value="title_asc" @selected(request('sort_by') === 'title_asc')>Judul (A ke Z)</option>
                        <option value="title_desc" @selected(request('sort_by') === 'title_desc')>Judul (Z ke A)</option>
                        <option value="year_desc" @selected(request('sort_by') === 'year_desc')>Tahun (Terbaru)</option>
                        <option value="year_asc" @selected(request('sort_by') === 'year_asc')>Tahun (Terlama)</option>
                        <option value="stock_desc" @selected(request('sort_by') === 'stock_desc')>Stok (Terbanyak)</option>
                        <option value="stock_asc" @selected(request('sort_by') === 'stock_asc')>Stok (Tersedikit)</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                @if (request()->hasAny(['search', 'category_id', 'stock_status', 'sort_by', 'year']))
                    <a href="{{ route('books.index') }}" class="px-4 py-2 text-sm text-slate-600 hover:text-slate-900 border border-slate-300 bg-white rounded-lg hover:bg-slate-50 transition">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition">
                    Terapkan
                </button>
            </div>
        </form>

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
                                {{-- Nomor urut yang memperhitungkan halaman pagination --}}
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $book->title }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->author }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->category?->name ?? 'Belum Ada Kategori' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $book->year }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="font-medium text-slate-700">{{ $book->stock }}</span>
                                    @if ($book->stock > 0)
                                        <span class="ml-2 inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">Tersedia</span>
                                    @else
                                        <span class="ml-2 inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">Habis</span>
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
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <p class="text-slate-500 font-medium">Buku tidak ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci atau bersihkan filter pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Navigasi Pagination --}}
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection