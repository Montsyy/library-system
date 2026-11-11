@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4 bg-white p-6 border rounded">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border p-2 rounded" required>
            @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
</div>
@endsection