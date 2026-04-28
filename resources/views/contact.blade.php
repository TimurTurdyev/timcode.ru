@extends('layouts.app')

@section('title', 'Написать — Тимур Турдыев')
@section('description', 'Напишите о задаче — отвечу и обсудим детали.')

@section('content')
<div class="container">
    <div class="contact-page">

        <a href="/" class="back-link">← на главную</a>

        <p class="section-title"><span class="st-hash">##</span> написать</p>

        <p style="color: var(--muted); font-size: 0.875rem; margin-bottom: 0.5rem;">
            Опишите задачу — отвечу в Telegram в течение дня.
        </p>
        <p style="color: var(--muted); font-size: 0.875rem; margin-bottom: 2rem;">
            Если удобнее напрямую: <a href="https://t.me/borodatimur" target="_blank" rel="noopener">t.me/borodatimur</a>
        </p>

        @if(session('success'))
        <div class="alert-success">
            > {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="/contact" class="contact-form" novalidate>
            @csrf

            <div class="form-field">
                <label class="form-label" for="name"><span>$</span> name</label>
                <input
                    class="form-input @error('name') is-error @enderror"
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Как к вам обращаться"
                    autocomplete="name"
                >
                @error('name')
                <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-field">
                <label class="form-label" for="contact"><span>$</span> contact</label>
                <input
                    class="form-input @error('contact') is-error @enderror"
                    type="text"
                    id="contact"
                    name="contact"
                    value="{{ old('contact') }}"
                    placeholder="Telegram, email или телефон"
                    autocomplete="off"
                >
                @error('contact')
                <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-field">
                <label class="form-label" for="message"><span>$</span> message</label>
                <textarea
                    class="form-textarea @error('message') is-error @enderror"
                    id="message"
                    name="message"
                    placeholder="Опишите задачу: что нужно сделать, какой стек, дедлайн — всё, что поможет быстро понять контекст"
                >{{ old('message') }}</textarea>
                @error('message')
                <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-submit">
                <button type="submit" class="btn-cli">[ отправить ]</button>
                <p class="form-note">Ответ приходит в Telegram — обычно в тот же день.</p>
            </div>
        </form>

    </div>
</div>
@endsection
