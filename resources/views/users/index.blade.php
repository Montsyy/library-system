@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah User</a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <table class="w-full border-collapse border bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">No</th>
                <th class="border p-2 text-left">Nama</th>
                <th class="border p-2 text-left">Email</th>
                <th class="border p-2 text-left">Role</th>
                <th class="border p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $user->name }}</td>
                <td class="border p-2">{{ $user->email }}</td>
                <td class="border p-2 uppercase font-semibold">{{ $user->role }}</td>
                <td class="border p-2">
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 underline">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 underline">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border p-2 text-center">Belum ada data user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection