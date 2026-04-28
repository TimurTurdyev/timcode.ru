@extends('layouts.app')

@section('title', '404 — Страница не найдена')
@section('description', 'Запрошенная страница не найдена.')

@section('content')
@php
    $path = '/' . ltrim(request()->path(), '/');
    if ($path === '/') { $path = '/?'; }
@endphp
<div class="container error-page">
    @isset($__devPreview)<div class="error-dev-marker">DEV PREVIEW · 404</div>@endisset
    <div class="error-code">404</div>
    <h1 class="error-heading">Страница не найдена</h1>
    <p class="error-text">Такого пути на сайте нет. Возможно, ссылка устарела или адрес набран с опечаткой — посмотрите главную или кейсы.</p>

    <div class="error-curl">
        <div class="error-curl-prompt">curl -I https://timcode.ru<span class="ec-val"><em>{{ $path }}</em></span></div>
        <div class="error-curl-out">
            <div><span class="ec-key">HTTP/2</span><span class="ec-status">404 Not Found</span></div>
            <div><span class="ec-key">content-type:</span> text/html; charset=utf-8</div>
            <div><span class="ec-key">x-resource:</span> <span class="ec-val">отсутствует в маршрутизаторе</span></div>
            <div><span class="ec-key">x-suggestion:</span> <span class="ec-val">проверьте URL или вернитесь на главную</span></div>
        </div>
    </div>

    <div class="error-actions">
        <a href="/" class="btn-cli">cd /</a>
        <a href="/#portfolio" class="btn-cli">ls portfolio/</a>
        <a href="/contact" class="btn-cli">mail</a>
    </div>

    <div class="error-links">
        <div class="error-links-title">или попробуйте:</div>
        <ul>
            <li><a href="/">главная страница</a></li>
            <li><a href="/#cases">кейсы</a></li>
            <li><a href="/#portfolio">портфолио</a></li>
            <li><a href="/contact">контакты</a></li>
        </ul>
    </div>
</div>
@endsection
