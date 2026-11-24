@extends('layouts.app')
@section('title', 'Daftar Member')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Daftar Member</h2>
                <p class="text-sm text-slate-500 mt-1">Data anggota perpustakaan yang terdaftar</p>
            </div>
            <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                + Tambah Member
            </a>
        </div>

        @if (session('success'))
            <div class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Pencarian & Sorting Member --}}
        <form method="GET" action="{{ route('members.index') }}" class="p-6 border-b border-slate-200 bg-slate-50/50">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Cari Member</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama, kode member, atau email..."
                        class="w-full bg-white border border-slate-300 rounded-lg px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="sort_by" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Urutan</label>
                    <select name="sort_by" id="sort_by"
                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="latest" @selected(request('sort_by') === 'latest')>Terbaru Terdaftar</option>
                        <option value="name_asc" @selected(request('sort_by') === 'name_asc')>Nama (A ke Z)</option>
                        <option value="name_desc" @selected(request('sort_by') === 'name_desc')>Nama (Z ke A)</option>
                        <option value="member_code_asc" @selected(request('sort_by') === 'member_code_asc')>Kode Member (Terkecil)</option>
                        <option value="member_code_desc" @selected(request('sort_by') === 'member_code_desc')>Kode Member (Terbesar)</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-end gap-2">
                @if (request()->hasAny(['search', 'sort_by']))
                    <a href="{{ route('members.index') }}" class="px-4 py-2 text-sm text-slate-600 hover:text-slate-900 border border-slate-300 bg-white rounded-lg hover:bg-slate-50 transition">
                        Reset
                    </a>
                @endif
                <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition">
                    Cari & Urutkan
                </button>
            </div>
        </form>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kode Member</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($members as $member)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm font-mono font-semibold text-slate-800">{{ $member->member_code }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $member->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $member->email }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('members.show', $member) }}" class="text-blue-600 hover:underline">Detail</a>
                                        <a href="{{ route('members.edit', $member) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-slate-500">Data anggota tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $members->links() }}
            </div>
        </div>
    </div>
@endsection