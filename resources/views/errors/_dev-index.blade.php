@extends('layouts.app')

@section('title', 'Dev: error pages preview')
@section('description', 'Локальный просмотр страниц ошибок.')

@section('content')
<div class="container error-page">
    <div class="error-dev-marker">DEV PREVIEW · только для local окружения</div>
    <h1 class="error-heading">Превью страниц ошибок</h1>
    <p class="error-text">Каждая ссылка отдаёт реальный HTTP-статус — удобно проверять как страницу, так и заголовок ответа в DevTools / curl.</p>

    <div class="error-curl">
        <div class="error-curl-prompt">curl -I http://timcode.test<span class="ec-val"><em>/__dev/errors/&lt;code&gt;</em></span></div>
        <div class="error-curl-out">
            <div><span class="ec-key">x-env:</span> <span class="ec-val">{{ app()->environment() }}</span></div>
            <div><span class="ec-key">x-codes:</span>
                @foreach($links as $link)<a href="{{ $link['url'] }}" style="color: var(--accent); margin-right: 0.6rem;">{{ $link['code'] }}</a>@endforeach
            </div>
        </div>
    </div>

    <div class="error-links">
        <div class="error-links-title">страницы:</div>
        <ul>
            @foreach($links as $link)
                <li><a href="{{ $link['url'] }}">/__dev/errors/{{ $link['code'] }}</a> — HTTP {{ $link['code'] }}</li>
            @endforeach
        </ul>
    </div>

    <div class="error-actions">
        <a href="/" class="btn-cli">cd /</a>
    </div>
</div>
@endsection
