@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Hero --}}
    <section id="hero" class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <h1 class="hero-title">timcode.ru</h1>
                <p class="hero-bio">
                    Привет, меня зовут Тимур.<br>
                    Пишу серверный код с 2014-го — сам, без курсов, по документации и чужим ошибкам.
                    Сейчас веду несколько боевых систем в Waviot (IoT, биллинг, Go-сервисы) и берусь за
                    интересные проекты по рекомендации.
                </p>
                <div class="social-links">
                    <a href="https://t.me/borodatimur" target="_blank" rel="noopener">Telegram</a>
                    <a href="https://github.com/TimurTurdyev" target="_blank" rel="noopener">GitHub</a>
                    <a href="mailto:d2e8ec@gmail.com">Email</a>
                </div>
            </div>
            <div class="hero-avatar-wrap">
                <img class="hero-avatar" src="/avatar.svg" alt="Тимур Турдыев" width="150" height="150">
            </div>
        </div>

        <div class="curl-box">
            <div class="curl-prompt">$ curl timcode.ru</div>
            <div class="curl-output">
                <div><span class="co-key">name</span>      Тимур Турдыев</div>
                <div><span class="co-key">role</span>      Backend / Full-stack разработчик</div>
                <div><span class="co-key">location</span>  Москва, Россия</div>
                <div><span class="co-key">since</span>     2014</div>
                <div><span class="co-key">stack</span>     Laravel · Go · Vue · PostgreSQL · Docker</div>
                <div><span class="co-key">contact</span>   <a href="https://t.me/borodatimur" target="_blank" rel="noopener">t.me/borodatimur</a></div>
            </div>
            <div class="curl-legend">
                <div><span class="co-cmd">$ curl timcode.ru</span><span class="co-note">эта страница (terminal view)</span></div>
                <div><span class="co-cmd">$ curl timcode.ru/json</span><span class="co-note">данные в JSON</span></div>
            </div>
            <div class="curl-cursor">█</div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="section">
        <p class="section-title">## обо мне</p>
        <p>
            В разработке с 2014-го. Профильного образования нет — всё самостоятельно: по документации,
            чужому коду и собственным факапам. Этот путь дольше, чем университет, но он приучил не запоминать
            «как правильно», а разбираться, <em>почему</em> именно так.
        </p>
        <br>
        <p>
            До Waviot несколько лет фрилансил — начинал с форума OpenCart, постепенно перешёл на рекомендации.
            Это научило двум вещам: код должен работать у клиента без меня, а лучший KPI — когда тебя советуют друзьям.
        </p>
        <br>
        <p>
            Сейчас основное время — в продуктовой команде Waviot (IoT-платформа NB-Fi): TypeScript + Vue + Laravel + Go.
            Фриланс — только интересные задачи: связать системы, разобраться в чужом легаси, принять инженерное решение.
        </p>
    </section>

    {{-- Stack --}}
    <section id="stack" class="section">
        <p class="section-title">## стек</p>
        <div class="stack-table-wrap">
            <table class="stack-table">
                <thead>
                    <tr>
                        <th>Слой</th>
                        <th>Стек</th>
                        <th>Почему так</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stack as $row)
                    <tr>
                        <td class="st-layer">{{ $row['layer'] }}</td>
                        <td class="st-tech">{{ $row['tech'] }}</td>
                        <td class="st-why">{{ $row['why'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Portfolio --}}
    <section id="portfolio" class="section">
        <p class="section-title">## портфолио</p>
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
        <p class="section-title">## кейсы</p>
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
        <p class="section-title">## цены</p>
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
        <p class="section-title">## контакты</p>
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
