@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
    @if (session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    
    <h2>Daftar Buku</h2>
    <div style="margin-bottom: 15px;">
        <button>
            <a href="{{ route('books.create') }}">Masukkan Buku Baru</a>
        </button>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $book->title }}</strong></td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category?->name ?? 'Belum Ada Kategori' }}</td>
                    <td>{{ $book->year }}</td>
                    <td>
                        {{ $book->stock }}
                        @if ($book->stock > 0)
                            (<span style="color: green;">Tersedia</span>)
                        @else
                            (<span style="color: red;">Tidak Tersedia</span>)
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <a href="{{ route('books.show', $book->id) }}">Detail</a>
                            <a href="{{ route('books.edit', $book->id) }}">Edit</a>
                            
                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection