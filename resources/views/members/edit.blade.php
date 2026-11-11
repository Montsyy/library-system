@extends('layouts.app')
@section('title', 'Edit Member')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Edit Member</h2>
            <a href="{{ route('members.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('members.update', $member) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kode Member</label>
                <input type="text" name="member_code" value="{{ old('member_code', $member->member_code) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-slate-50 text-slate-700 cursor-not-allowed" readonly required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition">
                    Update Anggota
                </button>
            </div>
        </form>
    </div>
@endsection