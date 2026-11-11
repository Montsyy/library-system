@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Tambah Kategori</h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
@endsection