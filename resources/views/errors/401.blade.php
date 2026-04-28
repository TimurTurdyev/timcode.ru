@extends('layouts.app')

@section('title', '401 — Требуется авторизация')
@section('description', 'Для просмотра этого раздела нужно войти.')

@section('content')
<div class="container error-page">
    @isset($__devPreview)<div class="error-dev-marker">DEV PREVIEW · 401</div>@endisset
    <div class="error-code is-warn">401</div>
    <h1 class="error-heading">Требуется авторизация</h1>
    <p class="error-text">Этот раздел доступен только авторизованным пользователям. Войдите в систему или вернитесь на главную.</p>

    <div class="error-curl is-warn">
        <div class="error-curl-prompt">curl -I https://timcode.ru<span class="ec-val"><em>/{{ ltrim(request()->path(), '/') }}</em></span></div>
        <div class="error-curl-out is-warn">
            <div><span class="ec-key">HTTP/2</span><span class="ec-status">401 Unauthorized</span></div>
            <div><span class="ec-key">www-authenticate:</span> <span class="ec-val">login required</span></div>
            <div><span class="ec-key">x-hint:</span> <span class="ec-val">войдите в систему и повторите запрос</span></div>
        </div>
    </div>

    <div class="error-actions">
        <a href="/" class="btn-cli">cd /</a>
    </div>
</div>
@endsection
