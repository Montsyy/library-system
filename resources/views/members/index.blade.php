@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Anggota (Member)</h1>
        <a href="{{ route('members.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">No</th>
                <th class="border p-2 text-left">Kode Member</th>
                <th class="border p-2 text-left">Nama</th>
                <th class="border p-2 text-left">Email</th>
                <th class="border p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $member->member_code }}</td>
                <td class="border p-2">{{ $member->name }}</td>
                <td class="border p-2">{{ $member->email }}</td>
                <td class="border p-2">
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('members.show', $member) }}" class="text-green-600 underline">Detail</a>
                        <a href="{{ route('members.edit', $member) }}" class="text-blue-600 underline">Edit</a>
                        <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border p-2 text-center">Belum ada data anggota.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection