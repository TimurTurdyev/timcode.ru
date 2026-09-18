<?php

namespace App\Http\Controllers;

use App\Services\Profile;
use Illuminate\Http\Response;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View|Response
    {
        if ($this->isCurlRequest()) {
            return $this->curlResponse();
        }

        $cases     = Profile::cases();
        $portfolio = Profile::portfolio();
        $packages  = Profile::packages();
        $stack     = Profile::stack();

        return view('home', compact('cases', 'portfolio', 'packages', 'stack'));
    }

    public function json(): Response
    {
        $data = [
            'name'       => 'Тимур Турдыев',
            'role'       => 'Backend / Full-stack разработчик',
            'location'   => 'Москва, Россия',
            'since'      => 2014,
            'before_dev' => [
                'ecommerce' => 'свой интернет-магазин',
                'seo'       => 'техническая оптимизация, скорость, индексация, аналитика воронок',
            ],
            'stack'      => ['Laravel', 'Go', 'Vue', 'PostgreSQL', 'Docker'],
            'building'   => [
                'name' => 'Mercurio Platform',
                'desc' => 'собственная платформа для интернет-магазинов: админка, CMS и витрина',
                'url'  => 'https://github.com/mercurioplatform',
            ],
            'open_source' => array_map(static fn (array $p) => [
                'name'     => $p['name'],
                'desc'     => $p['short'],
                'registry' => $p['registry'],
                'url'      => $p['url'],
            ], Profile::packages()),
            'contact'    => [
                'telegram' => 'https://t.me/borodatimur',
                'email'    => 'borodatimur@gmail.com',
                'github'   => 'https://github.com/TimurTurdyev',
            ],
            'endpoints'  => [
                'curl timcode.ru'           => 'Эта страница (terminal view)',
                'curl timcode.ru/json'      => 'Данные в JSON',
                'curl timcode.ru/resume.json'   => 'Резюме по схеме JSON Resume v1.0.0',
                'curl timcode.ru/llms.txt'      => 'Профиль в markdown (конвенция llmstxt.org)',
                'curl timcode.ru/llms-full.txt' => 'То же плюс полные тексты кейсов',
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
        $out .= $line('  Пишу серверный код с 2014-го. До этого — свой магазин, потом SEO:');
        $out .= $line('  в разработку пришёл, уже понимая, где бизнес теряет деньги.');
        $out .= $line('  Сейчас - Waviot (IoT, NB-Fi) и собственная платформа Mercurio');
        $out .= $line('  для интернет-магазинов: админка, CMS и витрина (Laravel + Blade).');
        $out .= $line('  Что отработало в бою и понадобилось второй раз - выношу в пакеты.');
        $out .= $line();
        $out .= $line($gr . '  name       ' . $w . 'Тимур Турдыев');
        $out .= $line($gr . '  role       ' . $w . 'Backend / Full-stack разработчик');
        $out .= $line($gr . '  location   ' . $w . 'Москва, Россия');
        $out .= $line($gr . '  since      ' . $w . '2014');
        $out .= $line($gr . '  languages  ' . $w . 'PHP (8+) · JavaScript / TypeScript · Go · Python · Java · Bash');
        $out .= $line($gr . '  backend    ' . $w . 'Laravel · Yii2 · Laminas · OpenCart · Go · FastAPI · aiohttp');
        $out .= $line($gr . '  frontend   ' . $w . 'Vue · Alpine.js · Tailwind · Bootstrap · Blade · jQuery · Vite · Wails');
        $out .= $line($gr . '  db         ' . $w . 'MySQL · MariaDB · PostgreSQL · MongoDB · Redis · Sphinx/Manticore · Meilisearch');
        $out .= $line($gr . '  queues     ' . $w . 'RabbitMQ · AMQP');
        $out .= $line($gr . '  infra      ' . $w . 'Docker · Ansible · Deployer · Linux (debian, systemd) · Nginx · Git');
        $out .= $line($gr . '  integr     ' . $w . 'Mango Office · Megaplan · Dadata · СДЭК · ВКонтакте API · OpenCart API');
        $out .= $line($gr . '  contact    ' . $g . 't.me/borodatimur' . $w);
        $out .= $line();
        $out .= $line($boxTop);
        $out .= $boxRows;
        $out .= $line($boxBottom);
        $out .= $line();
        $out .= $line($sep('Open-source'));
        $out .= $line();
        $pkgCol = 32;
        foreach (Profile::packages() as $pkg) {
            $pad = str_repeat(' ', max(1, $pkgCol - mb_strlen($pkg['name'])));
            $out .= $line('  ' . $g . $pkg['name'] . $w . $pad . $pkg['short']);
            $out .= $line('  ' . $gr . str_repeat(' ', $pkgCol) . $pkg['registry'] . ' · ' . $pkg['require'] . $w);
        }
        $out .= $line();
        $out .= $line($sep('Контакты'));
        $out .= $line();
        $out .= $line($gr . '  Telegram  ' . $g . 't.me/borodatimur' . $w);
        $out .= $line($gr . '  Email     ' . $w . 'borodatimur@gmail.com');
        $out .= $line($gr . '  GitHub    ' . $g . 'github.com/TimurTurdyev' . $w);
        $out .= $line();
        $out .= $line($sep('Команды'));
        $out .= $line();
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru               ' . $gr . 'Эта страница' . $w);
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru/json          ' . $gr . 'Данные в JSON' . $w);
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru/resume.json   ' . $gr . 'Резюме (JSON Resume v1.0.0)' . $w);
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru/llms.txt      ' . $gr . 'Профиль в markdown для агентов' . $w);
        $out .= $line('  ' . $g . '$ curl' . $w . ' timcode.ru/llms-full.txt ' . $gr . 'То же плюс полные тексты кейсов' . $w);
        $out .= $line();

        return response($out, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
