<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Единый источник данных о разработчике.
 *
 * Все представления - HTML-страница, curl-вывод, /json, /resume.json,
 * /llms.txt и JSON-LD - читают отсюда, чтобы не разъезжаться между собой.
 */
class Profile
{
    public const NAME     = 'Тимур Турдыев';
    public const NAME_EN  = 'Timur Turdyev';
    public const ROLE     = 'Backend / Full-stack разработчик';
    public const ROLE_EN  = 'Backend / Full-stack developer';
    public const LOCATION = 'Москва, Россия';
    public const SINCE    = 2014;
    public const SITE     = 'https://timcode.ru';
    public const EMAIL    = 'borodatimur@gmail.com';
    public const TELEGRAM = 'https://t.me/borodatimur';
    public const GITHUB   = 'https://github.com/TimurTurdyev';
    public const LINKEDIN = 'https://www.linkedin.com/in/timur-turdyev/';

    /**
     * Короткое описание: одно предложение для мета-тегов и агрегаторов.
     */
    public static function summary(): string
    {
        return 'Backend / full-stack разработчик из Москвы, в разработке с 2014 года. '
            . 'Laravel, Go, Vue, PostgreSQL. Продуктовая разработка в Waviot (IoT-платформа NB-Fi), '
            . 'собственная платформа Mercurio для интернет-магазинов, пять open-source пакетов.';
    }

    /**
     * Развёрнутое описание: два абзаца, из которых собирается bio на всех форматах.
     *
     * @return list<string>
     */
    public static function bio(): array
    {
        return [
            'В разработке с 2014 года, самоучка. До кода был свой интернет-магазин и несколько лет SEO - '
            . 'в разработку пришёл, уже понимая, что нужно бизнесу и где именно он теряет деньги. '
            . 'Первой платформой стал OpenCart, несколько лет фриланса - форум OpenCart, затем сарафанное радио.',

            'Сейчас основное время - продуктовая разработка в Waviot (IoT-платформа на протоколе NB-Fi): '
            . 'несколько поколений кода в одной компании, от самописного PHP-MVC и Laminas до Laravel, Go и TypeScript. '
            . 'Параллельно строю Mercurio - собственную платформу для интернет-магазинов (админка, CMS и витрина), '
            . 'а куски, полезные сами по себе, выношу в open-source.',
        ];
    }

    /**
     * Сильные стороны - то, ради чего меня обычно зовут.
     *
     * @return list<string>
     */
    public static function strengths(): array
    {
        return [
            'Жить с несколькими поколениями кода в одном проекте: legacy без фреймворка, Yii2 и Laminas, современный TypeScript и Go-сервисы.',
            'Миграции и апгрейды без downtime: PHP 5.6 → 8.x, Zend Framework → Laminas, обновления Yii, переключение поисковых движков под задачу.',
            'Интеграции: CRM, облачные АТС, службы доставки, сервисы данных, IoT-устройства, собственные шлюзы поверх RabbitMQ/AMQP.',
            'Инженерное суждение важнее стека: иногда правильный ответ - shell-скрипт или SQL-вьюха, а не новый сервис.',
            'Держу свои и клиентские серверы описанными в Ansible: роли на каждый предмет (nginx, PHP-FPM, MariaDB, Manticore, imgproxy, очереди, бэкапы), секреты в Vault, повторный прогон даёт changed=0, после выкладки - отдельный плейбук приёмки. Релизы приложений - Deployer.',
            'Код должен работать у клиента без меня: запускается, обновляется и чинится в понятных местах.',
        ];
    }

    /**
     * Навыки по категориям - плоский список для машинных форматов.
     *
     * @return array<string, list<string>>
     */
    public static function skills(): array
    {
        return [
            'Языки'           => ['PHP 8+', 'JavaScript', 'TypeScript', 'Go', 'Python', 'Java', 'Bash'],
            'Backend'         => ['Laravel', 'MoonShine', 'Yii2', 'Laminas', 'OpenCart', 'самописный PHP-MVC', 'FastAPI', 'aiohttp'],
            'Frontend'        => ['Vue', 'Alpine.js', 'Blade', 'jQuery', 'Tailwind', 'Bootstrap', 'Vite', 'Wails', 'Electron'],
            'БД и поиск'      => ['MySQL', 'MariaDB', 'PostgreSQL', 'SQLite', 'MongoDB', 'Redis', 'SphinxSearch', 'Manticore', 'Meilisearch'],
            'Очереди'         => ['RabbitMQ', 'AMQP'],
            'Инфраструктура'  => ['Docker', 'Ansible', 'Deployer', 'Linux (debian, systemd)', 'Nginx', 'Git'],
            'Интеграции'      => ['Mango Office', 'Megaplan', 'Dadata', 'СДЭК', 'ВКонтакте API', 'OpenCart marketplace API'],
        ];
    }

    /**
     * Слои боевых систем и обоснование стека для каждого.
     *
     * @return list<array{layer: string, tech: string, why: string}>
     */
    public static function stack(): array
    {
        return [
            ['layer' => 'Личный кабинет',          'tech' => 'TypeScript · Vue · Vite · Tailwind', 'why' => 'Свежий проект - можно позволить современный SPA'],
            ['layer' => 'Биллинг / лицензии',      'tech' => 'Laravel (PHP)',                      'why' => 'Экосистема, скорость разработки, проверено временем'],
            ['layer' => 'Лицензирование (legacy)', 'tech' => 'Yii2 · Codeception · RBAC',          'why' => 'Работает стабильно, переписывать без причины дорого'],
            ['layer' => 'Авторизация highload',    'tech' => 'Go',                                 'why' => 'Низкая латентность, бинарник, PHP здесь избыточен'],
            ['layer' => 'Очереди / шина',          'tech' => 'RabbitMQ · AMQP',                    'why' => 'Развязка сервисов: отказ одного не роняет остальных'],
            ['layer' => 'Телефония / callbacks',   'tech' => 'Python',                             'why' => 'Хорошие библиотеки под конкретные задачи'],
            ['layer' => 'Поиск по каталогам',      'tech' => 'SphinxSearch · Meilisearch',         'why' => 'Полнотекст с предсказуемой скоростью'],
            ['layer' => 'Desktop-утилиты',         'tech' => 'Go · Wails',                         'why' => 'Кроссплатформенный бинарник без Electron-веса'],
            ['layer' => 'Свои и клиентские серверы', 'tech' => 'Ansible · Deployer · Ubuntu LTS',  'why' => 'Сервер описан ролями, а не историей ssh-сессий: повторный прогон даёт changed=0, приёмка отдельным плейбуком'],
            ['layer' => 'Mercurio (свой проект)',  'tech' => 'Laravel 13 · Blade · Bootstrap 5 · jQuery', 'why' => 'Серверный рендер с точечным AJAX - как у Hotwire, HTMX, Livewire; новый раздел админки = один класс'],
            ['layer' => 'Витрина Mercurio',        'tech' => 'MariaDB · фасетный поиск',           'why' => 'Фасеты на самой БД: для каталога магазина хватает, отдельный поисковый движок не нужен'],
        ];
    }

    /**
     * Open-source пакеты: опубликованы в Packagist и PyPI.
     *
     * @return list<array{name: string, short: string, desc: string, require: string, registry: string, url: string}>
     */
    public static function packages(): array
    {
        return [
            [
                'name'     => 'mercurioplatform/tables',
                'short'    => 'list/table-движок для Laravel-админок',
                'desc'     => 'Декларативный Resource-класс → admin-страница одной строкой роута: поиск, сортировка, фильтры, saved views, bulk/row actions, экспорт, prefs, history + undo. Пять сознательных точек расширения - дальше vendor:publish. Страница рендерится сервером, AJAX подгружает только корень таблицы.',
                'require'  => 'PHP · Laravel 13 · Bootstrap 5 · jQuery',
                'registry' => 'packagist',
                'url'      => 'https://github.com/mercurioplatform/tables',
            ],
            [
                'name'     => 'timurturdyev/simple-settings',
                'short'    => 'key-value настройки для Laravel',
                'desc'     => 'Группы, кэш, автоприведение типов, пакетная запись одним upsert: невалиден хоть один ключ - не сохранится ни один. Фасад, Artisan-команды, обход кэша через fresh.',
                'require'  => 'PHP 8.2+ · Laravel 12/13',
                'registry' => 'packagist',
                'url'      => 'https://github.com/TimurTurdyev/Simple-Settings',
            ],
            [
                'name'     => 'simple-db-settings',
                'short'    => 'тот же менеджер настроек для Python',
                'desc'     => 'Порт на SQLAlchemy 2, совместимый с PHP-версией по таблице: сервис на Laravel и сервис на Python читают и пишут одни и те же настройки. TTL-кэш, инвалидация после коммита, аудит изменений с причинителем, работа на внешнем соединении.',
                'require'  => 'Python 3.11+ · SQLAlchemy 2 · pydantic',
                'registry' => 'pypi',
                'url'      => 'https://github.com/TimurTurdyev/simple-settings-py',
            ],
            [
                'name'     => 'timurturdyev/simple-cart',
                'short'    => 'корзина, закладки и сравнение',
                'desc'     => 'Каждый список - один примитив с политикой из конфига. Деньги считает только корзина, через конвейер классов-корректировок: без float, без магических строк, без обязательных миграций. Написан на замену darryldecode/laravelshoppingcart.',
                'require'  => 'PHP 8.3+ · Laravel 12/13',
                'registry' => 'packagist',
                'url'      => 'https://github.com/TimurTurdyev/simple-cart',
            ],
            [
                'name'     => 'timurturdyev/simple-seo',
                'short'    => 'meta, Open Graph, Twitter/X и JSON-LD',
                'desc'     => 'Ядро без зависимостей, слой Laravel в том же пакете. Замена artesaos/seotools: дефолты подставляются на рендере и не "липнут" к странице, JSON-LD собирается коллекцией в @graph вместо одного перетираемого блока.',
                'require'  => 'PHP 8.2+ · Laravel 11/12',
                'registry' => 'packagist',
                'url'      => 'https://github.com/TimurTurdyev/simple-seo',
            ],
        ];
    }

    /**
     * Проекты: свои продукты, публичные репозитории и работы под NDA.
     *
     * @return list<array{name: string, desc: string, stack: list<string>, url: string}>
     */
    public static function portfolio(): array
    {
        return [
            [
                'name'  => 'Mercurio Platform',
                'desc'  => 'Собственная платформа для интернет-магазинов: админка, CMS и витрина в одном продукте. Laravel 13 + Blade + Bootstrap 5 + jQuery - серверный рендер с точечным AJAX, та же идея, что у Hotwire, HTMX и Livewire. 10 разделов админки: каталог, продажи, CRM, склад, маркетинг, контент, аналитика, сервис, настройки, команда. Фасетный поиск по каталогу - на самой MariaDB.',
                'stack' => ['Laravel 13', 'PHP 8.4', 'Blade', 'Bootstrap 5', 'MariaDB'],
                'url'   => 'https://github.com/mercurioplatform',
            ],
            [
                'name'  => 'IoT-платформа для производства',
                'desc'  => 'Сбор телеметрии с промышленных датчиков через MQTT, хранение временных рядов в InfluxDB, Vue-дашборд с алертингом в Telegram.',
                'stack' => ['Laravel', 'MQTT', 'InfluxDB', 'Vue', 'Docker'],
                'url'   => '',
            ],
            [
                'name'  => 'CRM для логистической компании',
                'desc'  => 'Замена Excel-таблиц: управление заявками, маршрутизация водителей, интеграция с 2GIS и 1С, WebSocket-уведомления.',
                'stack' => ['Laravel', 'PostgreSQL', 'Vue 3', 'Redis', 'Docker'],
                'url'   => '',
            ],
            [
                'name'  => 'Портал самообслуживания',
                'desc'  => 'Личный кабинет абонента телеком-оператора: баланс, тарифы, история платежей, онлайн-заявки.',
                'stack' => ['Laravel', 'Vue', 'Redis', 'MySQL'],
                'url'   => '',
            ],
            [
                'name'  => 'Laravel-Mango-Office',
                'desc'  => 'Пакет для интеграции Laravel-приложений с облачной АТС Mango Office: вебхуки, история звонков, клик-ту-колл.',
                'stack' => ['PHP', 'Laravel'],
                'url'   => 'https://github.com/TimurTurdyev/Laravel-Mango-Office',
            ],
            [
                'name'  => 'SDK СДЭК 2.0 (форк)',
                'desc'  => 'Форк официального cdek-it/sdk2.0 - PHP-клиент API v2.0 службы доставки: тарифы, заказы, трекинг, накладные. Держу под свои интеграции.',
                'stack' => ['PHP'],
                'url'   => 'https://github.com/TimurTurdyev/sdk2.0',
            ],
            [
                'name'  => 'Export-Import OpenCart + Vue',
                'desc'  => 'Импорт и экспорт товаров в OpenCart через Vue-интерфейс без перезагрузки страницы - CSV и XLS форматы.',
                'stack' => ['PHP', 'Vue', 'OpenCart'],
                'url'   => 'https://github.com/TimurTurdyev/Export-Import-Opencart-Vue',
            ],
            [
                'name'  => 'opencart-dadata',
                'desc'  => 'Подсказки адресов и ФИО от Dadata при оформлении заказа в OpenCart. Ускоряет ввод и снижает ошибки.',
                'stack' => ['Vue', 'PHP', 'OpenCart'],
                'url'   => 'https://github.com/TimurTurdyev/opencart-dadata',
            ],
            [
                'name'  => 'my-tools-parse-message-waviot',
                'desc'  => 'Десктопная утилита для инженеров: разбирает ответы WAVIOT API в карточки по модемам и obis-кодам. Один бинарник без Electron-веса.',
                'stack' => ['Go', 'Wails', 'Vue 3', 'Tailwind 4'],
                'url'   => 'https://github.com/TimurTurdyev/my-tools-parse-message-waviot',
            ],
            [
                'name'  => 'Dashboard Megaplan + Mango Office',
                'desc'  => 'Сводные отчёты по менеджерам: звонки из облачной АТС сопоставляются со сделками в CRM.',
                'stack' => ['PHP'],
                'url'   => 'https://github.com/TimurTurdyev/Dashboard-Megaplan-and-Mangooffice',
            ],
            [
                'name'  => 'opencart-image-remover',
                'desc'  => 'Чистка каталога изображений OpenCart от "осиротевших" файлов - на больших магазинах освобождает десятки гигабайт.',
                'stack' => ['PHP', 'OpenCart'],
                'url'   => 'https://github.com/TimurTurdyev/opencart-image-remover',
            ],
            [
                'name'  => 'vpn-help',
                'desc'  => 'Утилиты macOS против конфликта OpenVPN и AmneziaVPN: диагностика, зачистка повисших utun-интерфейсов, сброс DNS.',
                'stack' => ['Bash', 'macOS'],
                'url'   => 'https://github.com/TimurTurdyev/vpn-help',
            ],
            [
                'name'  => 'timcode.ru',
                'desc'  => 'Этот сайт. Laravel + markdown-кейсы, терминальный дизайн, curl-режим и машиночитаемые форматы.',
                'stack' => ['Laravel', 'PHP 8.3', 'CSS'],
                'url'   => 'https://github.com/TimurTurdyev',
            ],
        ];
    }

    /**
     * Места работы - для резюме в машинных форматах.
     *
     * @return list<array{name: string, position: string, url: string, startDate: ?string, summary: string}>
     */
    public static function work(): array
    {
        return [
            [
                'name'      => 'Waviot',
                'position'  => 'Backend / Full-stack разработчик',
                'url'       => 'https://waviot.ru',
                'startDate' => null,
                'summary'   => 'Продуктовая разработка IoT-платформы на протоколе NB-Fi: личный кабинет клиентов '
                    . '(TypeScript, Vue, Vite, Tailwind), биллинг и лицензии на Laravel, сервис авторизации на Go, '
                    . 'шина на RabbitMQ/AMQP, легаси на Yii2 и Laminas, desktop-утилиты для инженеров на Go + Wails. '
                    . 'Миграции без downtime: PHP 5.6 → 8.x, Zend Framework → Laminas, обновления Yii. '
                    . 'PSR-12 внедрён в 4 проекта с рефакторингом существующего кода.',
            ],
            [
                'name'      => 'Фриланс',
                'position'  => 'Веб-разработчик',
                'url'       => '',
                'startDate' => '2014',
                'summary'   => 'Магазины, интеграции и миграции на OpenCart и Laravel: начинал с русскоязычного форума OpenCart, '
                    . 'дальше проекты шли по рекомендациям. Интеграции с Mango Office, Megaplan, Dadata, СДЭК, 1С и маркетплейсами. '
                    . 'Свои и клиентские серверы описаны в Ansible: роли на nginx, PHP-FPM, MariaDB, Manticore, imgproxy, очереди и бэкапы, '
                    . 'секреты в Vault, полигон на той же ОС, что и бой, приёмка отдельным плейбуком. Релизы - Deployer.',
            ],
        ];
    }

    /**
     * JSON-LD для главной: Person внутри ProfilePage плюс опубликованные пакеты.
     *
     * Это то, что реально парсят поисковики и агенты - разметка повторяет
     * содержимое страницы, а не добавляет к нему ничего сверх.
     *
     * @return array<string, mixed>
     */
    public static function jsonLd(): array
    {
        $person = [
            '@type'         => 'Person',
            '@id'           => self::SITE . '/#person',
            'name'          => self::NAME,
            'alternateName' => self::NAME_EN,
            'jobTitle'      => self::ROLE,
            'description'   => self::summary(),
            'url'           => self::SITE,
            'image'         => self::SITE . '/avatar.svg',
            'email'         => 'mailto:' . self::EMAIL,
            'address'       => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Москва',
                'addressCountry'  => 'RU',
            ],
            'worksFor'      => [
                '@type' => 'Organization',
                'name'  => 'Waviot',
                'url'   => 'https://waviot.ru',
            ],
            'knowsAbout'    => array_values(array_unique(array_merge(...array_values(self::skills())))),
            'knowsLanguage' => ['ru', 'en'],
            'sameAs'        => [self::GITHUB, self::TELEGRAM, self::LINKEDIN],
        ];

        $packages = array_map(static fn (array $pkg) => [
            '@type'          => 'SoftwareSourceCode',
            'name'           => $pkg['name'],
            'description'    => $pkg['desc'],
            'codeRepository' => $pkg['url'],
            'runtimePlatform' => $pkg['require'],
            'author'         => ['@id' => self::SITE . '/#person'],
        ], self::packages());

        return [
            '@context' => 'https://schema.org',
            '@graph'   => array_merge([
                [
                    '@type'      => 'ProfilePage',
                    '@id'        => self::SITE . '/#profilepage',
                    'url'        => self::SITE,
                    'name'       => self::NAME . ' - ' . self::ROLE,
                    'inLanguage' => 'ru',
                    'mainEntity' => ['@id' => self::SITE . '/#person'],
                ],
                $person,
            ], $packages),
        ];
    }

    /**
     * JSON-LD для страницы кейса: Article с автором-ссылкой на Person.
     *
     * @param  array<string, mixed>  $meta
     * @return array<string, mixed>
     */
    public static function caseJsonLd(array $meta, string $slug): array
    {
        $data = [
            '@context'         => 'https://schema.org',
            '@type'            => 'TechArticle',
            'headline'         => $meta['title'] ?? $slug,
            'description'      => $meta['summary'] ?? '',
            'url'              => self::SITE . '/cases/' . $slug,
            'inLanguage'       => 'ru',
            'author'           => ['@id' => self::SITE . '/#person'],
            'mainEntityOfPage' => self::SITE . '/cases/' . $slug,
        ];

        if (! empty($meta['stack'])) {
            $data['keywords'] = implode(', ', array_map('trim', (array) $meta['stack']));
        }

        if (! empty($meta['year'])) {
            $data['datePublished'] = (string) $meta['year'];
        }

        return $data;
    }

    /**
     * Кейсы из resources/content/cases/*.md - только метаданные, отсортированные по году.
     *
     * @return list<array<string, mixed>>
     */
    public static function cases(): array
    {
        return Cache::remember('cases_list', 3600, function () {
            $cases = [];
            $dir   = resource_path('content/cases');

            if (! is_dir($dir)) {
                return $cases;
            }

            $parser = new MarkdownCaseParser();

            foreach (glob("{$dir}/*.md") as $file) {
                $meta = $parser->parseFrontMatter(file_get_contents($file));
                if (! empty($meta['title'])) {
                    $meta['slug'] = basename($file, '.md');
                    $cases[] = $meta;
                }
            }

            usort($cases, fn ($a, $b) => ($b['year'] ?? 0) <=> ($a['year'] ?? 0));

            return $cases;
        });
    }
}
