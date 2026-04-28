@extends('layouts.app')

@section('title', '419 — Сессия устарела')
@section('description', 'Токен безопасности формы истёк.')

@section('content')
<div class="container error-page">
    @isset($__devPreview)<div class="error-dev-marker">DEV PREVIEW · 419</div>@endisset
    <div class="error-code is-warn">419</div>
    <h1 class="error-heading">Сессия устарела</h1>
    <p class="error-text">CSRF-токен формы истёк, пока вы заполняли её. Это нормально — защита от подделки запросов сработала. Вернитесь назад и отправьте форму ещё раз.</p>

    <div class="error-curl is-warn">
        <div class="error-curl-prompt">curl -X POST https://timcode.ru<span class="ec-val"><em>/{{ ltrim(request()->path(), '/') }}</em></span></div>
        <div class="error-curl-out is-warn">
            <div><span class="ec-key">HTTP/2</span><span class="ec-status">419 Page Expired</span></div>
            <div><span class="ec-key">x-reason:</span> <span class="ec-val">csrf token mismatch</span></div>
            <div><span class="ec-key">x-fix:</span> <span class="ec-val">обновите страницу и повторите отправку</span></div>
        </div>
    </div>

    <div class="error-actions">
        <button type="button" class="btn-cli" onclick="if(window.history.length>1){history.back()}else{location.href='/'}">← назад</button>
        <a href="/" class="btn-cli">cd /</a>
    </div>
</div>
@endsection
