@extends('layouts.app')

@section('title', '403 — Доступ запрещён')
@section('description', 'Доступ к этому разделу закрыт.')

@section('content')
<div class="container error-page">
    @isset($__devPreview)<div class="error-dev-marker">DEV PREVIEW · 403</div>@endisset
    <div class="error-code">403</div>
    <h1 class="error-heading">Доступ запрещён</h1>
    <p class="error-text">У вас нет прав на просмотр этого раздела. Если считаете, что это ошибка — напишите мне.</p>

    <div class="error-curl">
        <div class="error-curl-prompt">curl -I https://timcode.ru<span class="ec-val"><em>/{{ ltrim(request()->path(), '/') }}</em></span></div>
        <div class="error-curl-out">
            <div><span class="ec-key">HTTP/2</span><span class="ec-status">403 Forbidden</span></div>
            <div><span class="ec-key">content-type:</span> text/html; charset=utf-8</div>
            <div><span class="ec-key">x-reason:</span> <span class="ec-val">недостаточно прав</span></div>
            <div><span class="ec-key">x-policy:</span> <span class="ec-val">authenticated, but unauthorized</span></div>
        </div>
    </div>

    <div class="error-actions">
        <a href="/" class="btn-cli">cd /</a>
        <a href="/contact" class="btn-cli">mail admin</a>
    </div>
</div>
@endsection
