@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Hero --}}
    <section id="hero" class="hero">
        <h1 class="hero-title">timcode.ru</h1>
        <p class="hero-bio">
            Привет, меня зовут Тимур.<br>
            Разрабатываю backend и full-stack приложения: веб-сервисы, API, IoT-платформы, CRM-системы.
            Работаю с Laravel, Vue, PostgreSQL, Docker. Делаю так, чтобы код был понятным, а системы — надёжными.
        </p>
        <div class="social-links">
            <a href="https://t.me/borodatimur" target="_blank" rel="noopener">Telegram</a>
            <a href="https://github.com/TimurTurdyev" target="_blank" rel="noopener">GitHub</a>
            <a href="mailto:d2e8ec@gmail.com">Email</a>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="section">
        <p class="section-title">обо мне</p>
        <p>
            Пишу серверный код более 8 лет. Начинал с PHP, дорос до распределённых систем.
            Сейчас основной стек — Laravel + Vue + PostgreSQL, деплой через Docker на VPS или облако.
        </p>
        <br>
        <p>
            Люблю задачи, где нужно разобраться в предметной области и спроектировать решение с нуля,
            а не только закрыть тикет. Работаю с командами и самостоятельно — умею держать контекст
            проекта и двигать его вперёд без микроменеджмента.
        </p>
        <br>
        <p>
            В разное время работал с: промышленной автоматизацией (SCADA, IoT), логистикой (маршрутизация,
            WMS), ритейлом (ecommerce-платформы, интеграции с 1С), телекомом (биллинг, порталы самообслуживания).
        </p>
    </section>

    {{-- Portfolio --}}
    <section id="portfolio" class="section">
        <p class="section-title">портфолио</p>
        <div class="portfolio-grid">
            @foreach($portfolio as $project)
            <div class="portfolio-item">
                <div class="portfolio-name">
                    @if(!empty($project['url']))
                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener">{{ $project['name'] }}</a>
                    @else
                        {{ $project['name'] }}
                    @endif
                </div>
                <p class="portfolio-desc">{{ $project['desc'] }}</p>
                <div class="portfolio-stack">
                    @foreach($project['stack'] as $tech)
                        <span>{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Cases --}}
    <section id="cases" class="section">
        <p class="section-title">кейсы</p>
        @if(count($cases) > 0)
        <div class="cases-grid">
            @foreach($cases as $case)
            <div class="case-card">
                <div>
                    <div class="case-title">{{ $case['title'] }}</div>
                    <div class="case-summary">{{ $case['summary'] ?? '' }}</div>
                </div>
                <div class="case-meta">
                    <span class="case-year">{{ $case['year'] ?? '' }}</span>
                    <a class="case-link" href="/cases/{{ $case['slug'] }}">читать →</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="section-note">Кейсы в процессе написания.</p>
        @endif
    </section>

    {{-- Prices --}}
    <section id="prices" class="section">
        <p class="section-title">цены</p>
        <div class="prices-grid">
            <div class="price-card">
                <div class="price-name">Консультация</div>
                <div class="price-amount">от 3 000 ₽</div>
                <div class="price-unit">за час</div>
                <ul class="price-features">
                    <li>аудит архитектуры</li>
                    <li>code review</li>
                    <li>разбор задачи</li>
                </ul>
            </div>
            <div class="price-card">
                <div class="price-name">Проект</div>
                <div class="price-amount">от 50 000 ₽</div>
                <div class="price-unit">фиксированная цена</div>
                <ul class="price-features">
                    <li>ТЗ + декомпозиция</li>
                    <li>разработка и тесты</li>
                    <li>деплой и документация</li>
                </ul>
            </div>
            <div class="price-card">
                <div class="price-name">Поддержка</div>
                <div class="price-amount">от 30 000 ₽</div>
                <div class="price-unit">в месяц</div>
                <ul class="price-features">
                    <li>20 часов в месяц</li>
                    <li>приоритетный ответ</li>
                    <li>мониторинг и правки</li>
                </ul>
            </div>
        </div>
        <p class="section-note">
            Конкретная цена зависит от задачи. Напишите — обсудим.
        </p>
    </section>

    {{-- Contacts --}}
    <section id="contacts" class="section">
        <p class="section-title">контакты</p>
        <div class="contacts-list">
            <div class="contact-item">
                <span class="contact-label">Telegram</span>
                <a href="https://t.me/borodatimur" target="_blank" rel="noopener">@borodatimur</a>
            </div>
            <div class="contact-item">
                <span class="contact-label">Email</span>
                <a href="mailto:d2e8ec@gmail.com">d2e8ec@gmail.com</a>
            </div>
            <div class="contact-item">
                <span class="contact-label">GitHub</span>
                <a href="https://github.com/TimurTurdyev" target="_blank" rel="noopener">TimurTurdyev</a>
            </div>
        </div>
    </section>

</div>
@endsection
