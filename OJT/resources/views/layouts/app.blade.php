<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CCST Internship Portal</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h1>CCST Portal</h1>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </header>

    <main>
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>