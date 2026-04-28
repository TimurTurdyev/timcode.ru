@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Hero --}}
    <section id="hero" class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <h1 class="hero-title" data-typewriter="timcode.ru">timcode.ru</h1>
                <p class="hero-bio">
                    Привет, меня зовут Тимур.<br>
                    Пишу серверный код с 2014-го — сам, без курсов, по документации и чужим ошибкам.
                    Сейчас веду несколько боевых систем в Waviot (IoT, биллинг, Go-сервисы) и берусь за
                    интересные проекты по рекомендации.
                </p>
                <div class="social-links">
                    <a href="https://t.me/borodatimur" target="_blank" rel="noopener">Telegram</a>
                    <a href="https://github.com/TimurTurdyev" target="_blank" rel="noopener">GitHub</a>
                    <a href="mailto:borodatimur@gmail.com">Email</a>
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
                <div><span class="co-key">languages</span> PHP (8+) · JavaScript / TypeScript · Go · Python · Java · Bash</div>
                <div><span class="co-key">backend</span>   Laravel · Yii2 · Laminas · OpenCart · Go · FastAPI · aiohttp</div>
                <div><span class="co-key">frontend</span>  Vue · Alpine.js · Tailwind · Bootstrap · Blade · jQuery · Vite · Wails</div>
                <div><span class="co-key">db</span>        MySQL · PostgreSQL · MongoDB · Redis · SphinxSearch · Meilisearch</div>
                <div><span class="co-key">queues</span>    RabbitMQ · AMQP</div>
                <div><span class="co-key">infra</span>     Docker · Linux · Nginx · Git · systemd</div>
                <div><span class="co-key">integr</span>    Mango Office · Megaplan · Dadata · СДЭК · ВКонтакте API</div>
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
        <p class="section-title"><span class="st-hash">##</span> обо мне</p>
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
        <p class="section-title"><span class="st-hash">##</span> стек</p>
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
        <p class="section-title"><span class="st-hash">##</span> портфолио</p>
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
        <p class="section-title"><span class="st-hash">##</span> кейсы</p>
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

    {{-- Work / CTA --}}
    <section id="work" class="section">
        <p class="section-title"><span class="st-hash">##</span> сотрудничество</p>
        <div class="work-text">
            <p>
                Берусь за задачи, где нужно разобраться в чужом коде, связать системы
                или принять инженерное решение. Работаю по рекомендациям и с теми,
                кто понимает, что именно нужно сделать.
            </p>
            <br>
            <p>
                Интересно: интеграции между сервисами, сложная бизнес-логика, легаси без документации,
                высоконагруженные задачи, архитектурные решения. Неинтересно: вёрстка по готовому макету,
                работа «сделай как у конкурентов», проекты без конкретного ТЗ.
            </p>
            <br>
            <p>Стоимость зависит от задачи — обсуждаем после того, как услышу, что нужно сделать.</p>
        </div>
        <div class="work-cta">
            <div class="cta-prompt">$ ./contact.sh</div>
            <div class="cta-actions">
                <a href="/contact" class="btn-cli">[ написать ]</a>
                <a href="https://t.me/borodatimur" target="_blank" rel="noopener" class="btn-cli">[ Telegram ]</a>
            </div>
        </div>
    </section>

    {{-- Contacts --}}
    <section id="contacts" class="section">
        <p class="section-title"><span class="st-hash">##</span> контакты</p>
        <div class="contacts-list">
            <div class="contact-item">
                <span class="contact-label">Telegram</span>
                <a href="https://t.me/borodatimur" target="_blank" rel="noopener">@borodatimur</a>
            </div>
            <div class="contact-item">
                <span class="contact-label">Email</span>
                <a href="mailto:borodatimur@gmail.com">borodatimur@gmail.com</a>
            </div>
            <div class="contact-item">
                <span class="contact-label">GitHub</span>
                <a href="https://github.com/TimurTurdyev" target="_blank" rel="noopener">TimurTurdyev</a>
            </div>
        </div>
    </section>

</div>
@endsection
