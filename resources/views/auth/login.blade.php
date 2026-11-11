<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
        <div class="grid md:grid-cols-2">
            <div class="bg-slate-900 text-white p-10 md:p-14 flex flex-col justify-center">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-300 mb-4">Library System</p>
                <h1 class="text-4xl font-bold leading-tight mb-4">Masuk ke Sistem Perpustakaan</h1>
                <p class="text-slate-300 text-base leading-7">
                    Kelola data buku, anggota, peminjaman, dan statistik perpustakaan dengan lebih mudah.
                </p>
            </div>

            <div class="p-8 md:p-12">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-800">Login</h2>
                    <p class="text-sm text-slate-500 mt-2">Silakan masuk untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full border border-slate-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-3 rounded-lg hover:bg-slate-800 transition">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>