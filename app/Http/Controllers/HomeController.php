<?php

namespace App\Http\Controllers;

use App\Services\MarkdownCaseParser;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $cases = $this->loadCases();
        $portfolio = $this->portfolio();

        return view('home', compact('cases', 'portfolio'));
    }

    private function portfolio(): array
    {
        return [
            [
                'name' => 'IoT-платформа для производства',
                'desc' => 'Система сбора телеметрии с промышленных датчиков, визуализация и алертинг.',
                'stack' => ['Laravel', 'MQTT', 'InfluxDB', 'Vue'],
                'url' => '',
            ],
            [
                'name' => 'CRM для логистики',
                'desc' => 'Управление заявками, маршрутизация, интеграция с картами и 1С.',
                'stack' => ['Laravel', 'PostgreSQL', 'Vue', 'Docker'],
                'url' => '',
            ],
            [
                'name' => 'Портал самообслуживания',
                'desc' => 'Личный кабинет абонента телеком-оператора: баланс, тарифы, заявки.',
                'stack' => ['Laravel', 'Vue', 'Redis'],
                'url' => '',
            ],
            [
                'name' => 'timcode.ru',
                'desc' => 'Этот сайт. Laravel + MD-кейсы, терминальный дизайн.',
                'stack' => ['Laravel', 'PHP 8.4', 'CSS'],
                'url' => 'https://github.com/TimurTurdyev',
            ],
        ];
    }

    private function loadCases(): array
    {
        return Cache::remember('cases_list', 3600, function () {
            $cases = [];
            $dir = resource_path('content/cases');

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
