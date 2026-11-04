<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title')
    </title>
</head>
<body>
    <header>
        <h1>Library System</h1>
        <nav>
            <a href="/dashboard">Dashboard</a>
            <a href="/books">Books</a>
            <a href="/categories">Categories</a>
            <a href="/members">Members</a>
        {{-- Menu khusus admin menggunakan Gate --}}
            @can('manage-users')
                <a href="{{ route('users.index') }}">Kelola Pengguna</a>
            @endcan

            <div style="margin-left: auto; display: flex; align-items: center; gap: 12px;">
                {{-- Keterangan Pengguna dan Role --}}
                <span>
                    Halo, {{ auth()->user()->name }} |
                    @if (auth()->user()->role === 'admin')
                        <strong>[Administrator]</strong>
                    @else
                        <span>[Petugas Perpustakaan]</span>
                    @endif
                </span>
                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
        </nav>
        <hr>
    </header>
<main>
    @yield('content')
</main>
<footer>
    <hr>
    <p>Library System - Dhafi Putra Alfarezi - 5A</p>
</footer>

</body>
</html>