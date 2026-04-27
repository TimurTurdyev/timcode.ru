@extends('layouts.app')

@section('title', ($meta['title'] ?? 'Кейс') . ' — Тимур Турдыев')
@section('description', $meta['summary'] ?? '')

@section('content')
<div class="container case-page-container">

    <a class="back-link" href="/#cases">← к кейсам</a>

    <div class="case-header">
        <h1 class="case-page-title">{{ $meta['title'] ?? $slug }}</h1>

        <div class="terminal-box case-meta-box">
            @if(!empty($meta['year']))
                <span class="case-page-year">{{ $meta['year'] }}</span>
            @endif
            @if(!empty($meta['stack']))
                <div class="case-stack-tags case-stack-inline">
                    @foreach((array)$meta['stack'] as $tech)
                        <span class="case-stack-tag">{{ trim($tech) }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <article class="article">
        {!! $html !!}
    </article>

</div>
@endsection
