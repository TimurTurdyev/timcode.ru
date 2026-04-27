<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Тимур Турдыев — разработчик')</title>
    <meta name="description" content="@yield('description', 'Разработчик backend и full-stack приложений. Laravel, Vue, PostgreSQL. Кейсы, портфолио, цены.')">
    <meta property="og:title" content="@yield('title', 'Тимур Турдыев — разработчик')">
    <meta property="og:description" content="@yield('description', 'Разработчик backend и full-stack приложений.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css'])
    @yield('head')
</head>
<body>
    <header class="site-nav">
        <div class="container">
            <nav class="nav-links">
                <a href="/#hero">timcode.ru</a>
                <a href="/#about">обо мне</a>
                <a href="/#portfolio">портфолио</a>
                <a href="/#cases">кейсы</a>
                <a href="/#prices">цены</a>
            </nav>
            <div class="nav-contact">
                <a href="/#contacts">контакты</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            © {{ date('Y') }} Тимур Турдыев
        </div>
    </footer>
</body>
</html>
