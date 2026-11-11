@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Tambah User</h1>
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-white p-6 border rounded">
        @csrf
        <div>
            <label class="block font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
            @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Role</label>
            <select name="role" class="w-full border p-2 rounded" required>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
            @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
    </form>
</div>
@endsection