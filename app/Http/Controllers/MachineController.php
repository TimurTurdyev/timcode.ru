<?php

namespace App\Http\Controllers;

use App\Services\MarkdownCaseParser;
use App\Services\Profile;
use Illuminate\Http\Response;

/**
 * Машиночитаемые представления профиля: для агентов, парсеров резюме и LLM.
 *
 * - /llms.txt      - карта сайта в markdown по конвенции llmstxt.org
 * - /llms-full.txt - то же плюс полные тексты кейсов, одним запросом
 * - /resume.json   - резюме по схеме JSON Resume v1.0.0
 */
class MachineController extends Controller
{
    public function llms(): Response
    {
        $out = $this->profileMarkdown();

        $out .= "## Кейсы\n\n";
        foreach (Profile::cases() as $case) {
            $url = Profile::SITE . '/cases/' . $case['slug'];
            $out .= '- [' . $case['title'] . '](' . $url . '): ' . ($case['summary'] ?? '')
                . ' Стек: ' . $this->stackLine($case) . '. Год: ' . ($case['year'] ?? '-') . ".\n";
        }
        $out .= "\n";

        $out .= "## Другие форматы\n\n";
        $out .= '- [' . Profile::SITE . "/llms-full.txt](" . Profile::SITE . "/llms-full.txt): всё то же плюс полные тексты кейсов - один запрос вместо обхода страниц.\n";
        $out .= '- [' . Profile::SITE . "/resume.json](" . Profile::SITE . "/resume.json): резюме по схеме JSON Resume v1.0.0.\n";
        $out .= '- [' . Profile::SITE . "/json](" . Profile::SITE . "/json): краткая карточка в JSON.\n";
        $out .= '- `curl ' . preg_replace('~^https?://~', '', Profile::SITE) . "`: та же страница в терминале.\n";

        return $this->text($out);
    }

    public function llmsFull(): Response
    {
        $out    = $this->profileMarkdown();
        $parser = new MarkdownCaseParser();

        $out .= "## Кейсы\n\n";
        foreach (Profile::cases() as $case) {
            $file = resource_path('content/cases/' . $case['slug'] . '.md');
            if (! is_file($file)) {
                continue;
            }

            $parsed = $parser->parseFull(file_get_contents($file));
            $body   = trim($parsed['body'] ?? '');

            $out .= '### ' . $case['title'] . "\n\n";
            $out .= 'URL: ' . Profile::SITE . '/cases/' . $case['slug'] . "  \n";
            $out .= 'Год: ' . ($case['year'] ?? '-') . '. Стек: ' . $this->stackLine($case) . ".\n\n";
            $out .= $this->demote($body) . "\n\n";
        }

        return $this->text($out);
    }

    public function resume(): Response
    {
        $resume = [
            '$schema' => 'https://raw.githubusercontent.com/jsonresume/resume-schema/v1.0.0/schema.json',
            'basics'  => [
                'name'     => Profile::NAME,
                'label'    => Profile::ROLE,
                'email'    => Profile::EMAIL,
                'url'      => Profile::SITE,
                'summary'  => implode("\n\n", Profile::bio()),
                'location' => [
                    'city'        => 'Москва',
                    'countryCode' => 'RU',
                ],
                'profiles' => [
                    ['network' => 'GitHub',   'username' => 'TimurTurdyev',  'url' => Profile::GITHUB],
                    ['network' => 'Telegram', 'username' => '@borodatimur', 'url' => Profile::TELEGRAM],
                    ['network' => 'LinkedIn', 'username' => 'timur-turdyev', 'url' => Profile::LINKEDIN],
                ],
            ],
            'work'      => array_map(static function (array $job) {
                $entry = [
                    'name'       => $job['name'],
                    'position'   => $job['position'],
                    'summary'    => $job['summary'],
                    'highlights' => [],
                ];

                if ($job['url'] !== '') {
                    $entry['url'] = $job['url'];
                }

                if ($job['startDate'] !== null) {
                    $entry['startDate'] = $job['startDate'];
                }

                return $entry;
            }, Profile::work()),
            'projects'  => array_merge(
                array_map(static fn (array $p) => [
                    'name'        => $p['name'],
                    'description' => $p['desc'],
                    'keywords'    => $p['stack'],
                    'url'         => $p['url'],
                    'type'        => 'application',
                ], Profile::portfolio()),
                array_map(static fn (array $p) => [
                    'name'        => $p['name'],
                    'description' => $p['desc'],
                    'keywords'    => explode(' · ', $p['require']),
                    'url'         => $p['url'],
                    'type'        => 'library',
                ], Profile::packages()),
            ),
            'skills'    => array_map(
                static fn (string $name, array $keywords) => ['name' => $name, 'keywords' => $keywords],
                array_keys(Profile::skills()),
                array_values(Profile::skills()),
            ),
            'languages' => [
                ['language' => 'Русский',   'fluency' => 'родной'],
                ['language' => 'English',   'fluency' => 'техническая документация, рабочая переписка'],
            ],
            'meta'      => [
                'canonical'    => Profile::SITE . '/resume.json',
                'version'      => 'v1.0.0',
                'lastModified' => now()->toIso8601String(),
            ],
        ];

        return response(
            json_encode($resume, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            200,
            ['Content-Type' => 'application/json; charset=UTF-8'],
        );
    }

    /**
     * Общая шапка обоих llms-форматов: кто, чем силён, стек, пакеты, проекты.
     */
    private function profileMarkdown(): string
    {
        $out  = '# ' . Profile::NAME . ' - ' . Profile::ROLE . "\n\n";
        $out .= '> ' . Profile::summary() . "\n\n";

        foreach (Profile::bio() as $paragraph) {
            $out .= $paragraph . "\n\n";
        }

        $out .= 'Локация: ' . Profile::LOCATION . '. В разработке с ' . Profile::SINCE . " года.\n";
        $out .= 'Контакты: ' . Profile::EMAIL . ' · ' . Profile::TELEGRAM . ' · ' . Profile::GITHUB . "\n\n";

        $out .= "## Сильные стороны\n\n";
        foreach (Profile::strengths() as $item) {
            $out .= '- ' . $item . "\n";
        }
        $out .= "\n";

        $out .= "## Навыки\n\n";
        foreach (Profile::skills() as $group => $items) {
            $out .= '- **' . $group . '**: ' . implode(', ', $items) . "\n";
        }
        $out .= "\n";

        $out .= "## Стек боевых систем\n\n";
        $out .= "| Слой | Стек | Почему так |\n| --- | --- | --- |\n";
        foreach (Profile::stack() as $row) {
            $out .= '| ' . $row['layer'] . ' | ' . $row['tech'] . ' | ' . $row['why'] . " |\n";
        }
        $out .= "\n";

        $out .= "## Open-source пакеты\n\n";
        foreach (Profile::packages() as $pkg) {
            $out .= '- [' . $pkg['name'] . '](' . $pkg['url'] . ') (' . $pkg['registry'] . ', ' . $pkg['require'] . '): '
                . $pkg['desc'] . "\n";
        }
        $out .= "\n";

        $out .= "## Проекты\n\n";
        foreach (Profile::portfolio() as $project) {
            $line = '- **' . $project['name'] . '**';
            if ($project['url'] !== '') {
                $line = '- [' . $project['name'] . '](' . $project['url'] . ')';
            }
            $out .= $line . ' (' . implode(', ', $project['stack']) . '): ' . $project['desc'] . "\n";
        }
        $out .= "\n";

        return $out;
    }

    /**
     * @param  array<string, mixed>  $case
     */
    private function stackLine(array $case): string
    {
        $stack = (array) ($case['stack'] ?? []);

        return $stack === [] ? '-' : implode(', ', array_map('trim', $stack));
    }

    /**
     * Сдвигает заголовки кейса на уровень ниже, чтобы вложиться в структуру документа.
     */
    private function demote(string $markdown): string
    {
        return preg_replace('/^(#{1,4})\s/m', '#$1 ', $markdown) ?? $markdown;
    }

    private function text(string $body): Response
    {
        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
