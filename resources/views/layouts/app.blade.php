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
    
    {{-- Floating Button Akses Cepat --}}
    @auth
        <div class="fixed bottom-6 right-6 z-50" id="quickNavContainer">
            {{-- Menu Pop-up Berlatar Belakang Putih --}}
            <div id="quickNavMenu" class="hidden mb-3 bg-white text-slate-800 rounded-2xl shadow-xl border border-slate-200 p-2 w-52 space-y-1 transition-all duration-200">
                <div class="px-3 py-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100 mb-1">
                    Navigasi Cepat
                </div>

                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('books.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium transition">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Daftar Buku
                </a>

                <a href="{{ route('members.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-purple-50 hover:text-purple-600 font-medium transition">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Members
                </a>

                <a href="{{ route('borrowings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-amber-50 hover:text-amber-600 font-medium transition">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Peminjaman
                </a>

                <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); toggleQuickNav();" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100 transition border-t border-slate-100 mt-1">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    Ke Atas (Header)
                </button>
            </div>

            {{-- Tombol Utama Floating Berlatar Putih --}}
            <button type="button" id="quickNavBtn" onclick="toggleQuickNav()" aria-label="Buka Akses Cepat"
                class="bg-white text-slate-700 hover:text-blue-600 hover:shadow-2xl shadow-lg rounded-full w-12 h-12 flex items-center justify-center transition-all duration-200 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg id="quickNavOpenIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
                <svg id="quickNavCloseIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endauth

    {{-- Script Kontrol Floating Button --}}
    <script>
        function toggleQuickNav() {
            const menu = document.getElementById('quickNavMenu');
            const openIcon = document.getElementById('quickNavOpenIcon');
            const closeIcon = document.getElementById('quickNavCloseIcon');

            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');

            if (isHidden) {
                menu.classList.remove('hidden');
                if (openIcon) openIcon.classList.add('hidden');
                if (closeIcon) closeIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                if (openIcon) openIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
            }
        }

        // Tutup menu otomatis jika pengguna mengklik area luar menu
        document.addEventListener('click', function (e) {
            const container = document.getElementById('quickNavContainer');
            const menu = document.getElementById('quickNavMenu');
            if (container && menu && !container.contains(e.target) && !menu.classList.contains('hidden')) {
                toggleQuickNav();
            }
        });

        // Tutup menu jika pengguna menekan tombol Escape di keyboard
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('quickNavMenu');
                if (menu && !menu.classList.contains('hidden')) {
                    toggleQuickNav();
                }
            }
        });
    </script>
</body>
</html>