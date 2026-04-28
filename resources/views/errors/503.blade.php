@extends('errors.minimal')

@section('title', '503 — Сервис недоступен')
@section('code', '503')
@section('message', 'Сервис временно недоступен')

@php
    $retryAfter = null;
    if (isset($exception) && method_exists($exception, 'getHeaders')) {
        $headers = $exception->getHeaders() ?: [];
        $raw = $headers['Retry-After'] ?? null;
        if (is_numeric($raw)) {
            $retryAfter = (int) $raw;
        }
    }
@endphp

@section('hint')
    @if($retryAfter)
        Сайт на плановом обслуживании. Возвращаемся примерно через {{ max(1, (int) ceil($retryAfter / 60)) }} мин.
    @else
        Сайт временно на обслуживании. Я уже вернусь — обычно это занимает несколько минут.
    @endif
@endsection

@section('trace')
    <div class="trace-line"><span class="danger">→</span> service <span class="accent">timcode.ru</span> in maintenance mode</div>
    @if($retryAfter)
        <div class="trace-line"><span class="danger">→</span> retry-after: <span class="accent">{{ $retryAfter }}</span> sec</div>
    @endif
    <div class="trace-line">started at {{ now()->format('Y-m-d H:i:s') }}</div>
@endsection
