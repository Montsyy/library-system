<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-slate-900 text-white shadow-lg">
            <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20 gap-4">
                    <div>
                        <a href="/dashboard" class="text-2xl font-bold tracking-tight">Library System</a>
                    </div>

                    <nav class="hidden md:flex items-center gap-2 text-sm font-medium">
                        <a href="/dashboard" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Dashboard</a>
                        <a href="/books" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Books</a>
                        <a href="/categories" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Categories</a>
                        <a href="/members" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Members</a>
                        <a href="{{ route('borrowings.index') }}" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Peminjaman</a>

                        @can('manage-users')
                            <a href="{{ route('users.index') }}" class="px-3 py-2 rounded-md hover:bg-slate-800 transition">Kelola Pengguna</a>
                        @endcan
                    </nav>

                    <div class="flex items-center gap-3">
                        <div class="hidden lg:block text-right text-sm">
                            <div class="font-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-slate-300 text-xs">
                                @if (auth()->user()->role === 'admin')
                                    Administrator
                                @else
                                    Petugas Perpustakaan
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-white text-slate-900 px-4 py-2 rounded-md font-semibold hover:bg-slate-100 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
            @yield('content')
        </main>

        <footer class="mt-auto border-t border-slate-200 bg-slate-100">
            <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-3 text-center text-[11px] text-slate-500">
                © {{ date('Y') }} Dhafi Putra Alfarezi
            </div>
        </footer>
    </div>
</body>
</html>