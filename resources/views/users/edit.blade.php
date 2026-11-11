@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>
    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4 bg-white p-6 border rounded">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 rounded" required>
            @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded" required>
            @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Role</label>
            <select name="role" class="w-full border p-2 rounded" required>
                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Password Baru (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
            @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label class="block font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
</div>
@endsection