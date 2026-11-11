@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen User</h2>
            </div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah User
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-violet-100 text-violet-700 uppercase">{{ $user->role }}</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-sky-100 text-sky-700 uppercase">{{ $user->role }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline">Edit</a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection