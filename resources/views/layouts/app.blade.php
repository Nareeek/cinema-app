<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema App - @yield('title', 'Home')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/storage/posters/logo.jpg') }}" alt="Cinema App Logo", height="40", width="50">
                </a>
            </div>
        </nav>
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="language-selector">
                <button onclick="changeLanguage('en')">EN</button>
                <button onclick="changeLanguage('ru')">RU</button>
                <button onclick="changeLanguage('am')">AM</button>
                <a href="{{ route('admin.movies.page') }}">Admin Panel</a>
            </div>
            @auth
            @if(auth()->user()->is_admin) <!-- Assuming is_admin is a boolean field -->
                <li><a href="{{ route('movies.management') }}">Movie Management</a></li>
            @endif
        @endauth
        </div>
    </header>
    
    <main>
        @yield('content')
    </main>
    
    <footer>
        <div class="rights"><p>&copy; {{ date('Y') }} Cinema App. All rights reserved.</p></div>
    </footer>
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
