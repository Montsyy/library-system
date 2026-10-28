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
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
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