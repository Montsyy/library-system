@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Kategori Buku</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Kategori</a>
        @endif
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">Nama Kategori</th>
                <th class="border p-2 text-left">Jumlah Buku</th>
                @if(auth()->user()->role === 'admin')
                    <th class="border p-2 text-left">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="border p-2">{{ $category->name }}</td>
                <td class="border p-2">{{ $category->books_count }}</td>
                @if(auth()->user()->role === 'admin')
                <td class="border p-2 flex gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 underline">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 underline">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection