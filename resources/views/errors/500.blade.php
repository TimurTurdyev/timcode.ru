@extends('errors.minimal')

@section('title', '500 — Внутренняя ошибка')
@section('code', '500')
@section('message', 'Внутренняя ошибка сервера')
@section('hint', 'Что-то пошло не так на стороне сервера. Это уже зафиксировано в логах — скоро починю. Попробуйте обновить страницу через минуту или вернуться на главную.')

@section('trace')
    <div class="trace-line"><span class="danger">→</span> request <span class="accent">{{ strtoupper(request()->method()) }}</span> /{{ ltrim(request()->path(), '/') }}</div>
    <div class="trace-line"><span class="danger">→</span> handler raised an unhandled exception</div>
    <div class="trace-line"><span class="danger">→</span> response <span class="danger">500 Internal Server Error</span></div>
    <div class="trace-line">at <span class="accent">timcode.ru</span> · {{ now()->format('Y-m-d H:i:s') }}</div>
@endsection
