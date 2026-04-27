<?php

namespace App\Http\Controllers;

use App\Services\MarkdownCaseParser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View|Response
    {
        if ($this->isCurlRequest()) {
            return $this->curlResponse();
        }

        $cases     = $this->loadCases();
        $portfolio = $this->portfolio();
        $stack     = $this->stack();

        return view('home', compact('cases', 'portfolio', 'stack'));
    }

    public function json(): Response
    {
        $data = [
            'name'     => 'Тимур Турдыев',
            'role'     => 'Backend / Full-stack разработчик',
            'location' => 'Москва, Россия',
            'since'    => 2014,
            'stack'    => ['Laravel', 'Go', 'Vue', 'PostgreSQL', 'Docker'],
            'contact'  => [
                'telegram' => 'https://t.me/borodatimur',
                'email'    => 'd2e8ec@gmail.com',
                'github'   => 'https://github.com/TimurTurdyev',
            ],
            'endpoints' => [
                'curl timcode.ru'      => 'Эта страница (terminal view)',
                'curl timcode.ru/json' => 'Данные в JSON',
            ],
        ];

        return response(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    private function isCurlRequest(): bool
    {
        return str_starts_with(request()->userAgent() ?? '', 'curl');
    }

    private function curlResponse(): Response
    {
        $g  = "\033[32m";   // green (accent)
        $gr = "\033[90m";   // gray (muted)
        $w  = "\033[0m";    // reset / white
        $b  = "\033[1m";    // bold

        $line = fn (string $s = '') => $s . "\n";
        $sep  = fn (string $label) => $gr . '  ─── ' . $g . $label . $gr . str_repeat('─', max(0, 54 - mb_strlen($label))) . $w;

        $stack = [
            ['Личный кабинет',    'TypeScript · Vue · Vite'],
            ['Биллинг',           'Laravel (PHP)'],
            ['Auth highload',     'Go'],
            ['Очереди',           'RabbitMQ · AMQP'],
            ['Поиск',             'SphinxSearch · Meilisearch'],
            ['Телефония',         'Python'],
            ['Desktop',           'Go · Wails'],
        ];

        $boxWidth = 58;
        $col1 = 18;
        $col2 = $boxWidth - $col1 - 5;

        $boxTop    = $gr . '  ┌─ ' . $g . 'Стек' . $gr . str_repeat('─', $boxWidth - 4) . '┐' . $w;
        $boxBottom = $gr . '  └' . str_repeat('─', $boxWidth) . '┘' . $w;
        $boxRows   = '';
        foreach ($stack as [$layer, $tech]) {
            $l = mb_substr($layer, 0, $col1);
            $t = mb_substr($tech,  0, $col2);
            $padL = str_repeat(' ', max(0, $col1 - mb_strlen($l)));
            $padT = str_repeat(' ', max(0, $col2 - mb_strlen($t)));
            $boxRows .= $gr . '  │ ' . $w . $l . $padL . $gr . ' │ ' . $g . $t . $w . $padT . $gr . ' │' . $w . "\n";
        }

        $out  = '';
        $out .= $line();
        $out .= $line($g . '> timcode.ru' . $w);
        $out .= $line();
        $out .= $line('  ' . $b . 'Тимур Турдыев' . $w . ' — Backend / Full-stack разработчик');
        $out .= $line();
        $out .= $line('  Пишу серверный код с 2014-го. Всё самостоятельно:');
        $out .= $line('  по документации, чужому коду и собственным ошибкам.');
        $out .= $line('  Сейчас — Waviot (IoT, NB-Fi) и проекты по рекомендации.');
        $out .= $line();
        $out .= $line($gr . '  name      ' . $w . 'Тимур Турдыев');
        $out .= $line($gr . '  role      ' . $w . 'Backend / Full-stack разработчик');
        $out .= $line($gr . '  location  ' . $w . 'Москва, Россия');
        $out .= $line($gr . '  since     ' . $w . '2014');
        $out .= $line($gr . '  stack     ' . $w . 'Laravel · Go · Vue · PostgreSQL · Docker');
        $out .= $line($gr . '  contact   ' . $g . 't.me/borodatimur' . $w);
        $out .= $line();
        $out .= $line($boxTop);
        $out .= $boxRows;
        $out .= $line($boxBottom);
        $out .= $line();
        $out .= $line($sep('Контакты'));
        $out .= $line();
        $out .= $line($gr . '  Telegram  ' . $g . 't.me/borodatimur' . $w);
        $out .= $line($gr . '  Email     ' . $w . 'd2e8ec@gmail.com');
        $out .= $line($gr . '  GitHub    ' . $g . 'github.com/TimurTurdyev' . $w);
        $out .= $line();
        $out .= $line($sep('Команды'));
        $out .= $line();
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru        ' . $gr . 'Эта страница' . $w);
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru/json   ' . $gr . 'Данные в JSON' . $w);
        $out .= $line();

        return response($out, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    private function stack(): array
    {
        return [
            ['layer' => 'Личный кабинет',         'tech' => 'TypeScript · Vue · Vite · Tailwind', 'why' => 'Свежий проект — можно позволить современный SPA'],
            ['layer' => 'Биллинг / лицензии',     'tech' => 'Laravel (PHP)',                       'why' => 'Экосистема, скорость разработки, проверено временем'],
            ['layer' => 'Лицензирование (legacy)', 'tech' => 'Yii2 · Codeception · RBAC',          'why' => 'Работает стабильно, переписывать без причины дорого'],
            ['layer' => 'Авторизация highload',    'tech' => 'Go',                                 'why' => 'Низкая латентность, бинарник, PHP здесь избыточен'],
            ['layer' => 'Очереди / шина',          'tech' => 'RabbitMQ · AMQP',                   'why' => 'Развязка сервисов: отказ одного не роняет остальных'],
            ['layer' => 'Телефония / callbacks',   'tech' => 'Python',                             'why' => 'Хорошие библиотеки под конкретные задачи'],
            ['layer' => 'Поиск по каталогам',      'tech' => 'SphinxSearch · Meilisearch',         'why' => 'Полнотекст с предсказуемой скоростью'],
            ['layer' => 'Desktop-утилиты',         'tech' => 'Go · Wails',                         'why' => 'Кроссплатформенный бинарник без Electron-веса'],
            ['layer' => 'Программатор устройств',  'tech' => 'Qt · C++ · OpenSSL',                 'why' => 'Специфичная железная обвязка, где Wails не подходит'],
        ];
    }

    private function portfolio(): array
    {
        return [
            [
                'name'  => 'IoT-платформа для производства',
                'desc'  => 'Система сбора телеметрии с промышленных датчиков, визуализация и алертинг.',
                'stack' => ['Laravel', 'MQTT', 'InfluxDB', 'Vue'],
                'url'   => '',
            ],
            [
                'name'  => 'CRM для логистики',
                'desc'  => 'Управление заявками, маршрутизация, интеграция с картами и 1С.',
                'stack' => ['Laravel', 'PostgreSQL', 'Vue', 'Docker'],
                'url'   => '',
            ],
            [
                'name'  => 'Портал самообслуживания',
                'desc'  => 'Личный кабинет абонента телеком-оператора: баланс, тарифы, заявки.',
                'stack' => ['Laravel', 'Vue', 'Redis'],
                'url'   => '',
            ],
            [
                'name'  => 'timcode.ru',
                'desc'  => 'Этот сайт. Laravel + MD-кейсы, терминальный дизайн.',
                'stack' => ['Laravel', 'PHP 8.4', 'CSS'],
                'url'   => 'https://github.com/TimurTurdyev',
            ],
        ];
    }

    private function loadCases(): array
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
