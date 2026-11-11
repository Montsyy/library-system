@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Tambah Anggota</h1>
    <form action="{{ route('members.store') }}" method="POST" class="space-y-4 bg-white p-6 border rounded">
        @csrf
        <div>
            <label class="block font-medium">Kode Anggota</label>
            <input type="text" name="member_code" value="{{ old('member_code', 'MBR-' . rand(1000, 9999)) }}" class="w-full border p-2 rounded" required>
            @error('member_code') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
            @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
    </form>
</div>
@endsection