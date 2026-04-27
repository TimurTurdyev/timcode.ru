<?php

namespace App\Services;

use League\CommonMark\CommonMarkConverter;

class MarkdownCaseParser
{
    public function parseFrontMatter(string $content): array
    {
        if (! str_starts_with($content, '---')) {
            return [];
        }

        $parts = preg_split('/^---\s*$/m', $content, 3);
        if (count($parts) < 2) {
            return [];
        }

        return $this->parseLines(trim($parts[1]));
    }

    public function parseFull(string $content): array
    {
        $meta = [];
        $body = $content;

        if (str_starts_with($content, '---')) {
            $parts = preg_split('/^---\s*$/m', $content, 3);
            if (count($parts) >= 3) {
                $meta = $this->parseLines(trim($parts[1]));
                $body = trim($parts[2]);
            }
        }

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return ['meta' => $meta, 'html' => $converter->convert($body)->getContent()];
    }

    private function parseLines(string $block): array
    {
        $meta = [];
        foreach (explode("\n", $block) as $line) {
            if (! str_contains($line, ':')) {
                continue;
            }
            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $value = trim($value, '"\'');
            if (str_starts_with($value, '[') && str_ends_with($value, ']')) {
                $value = array_map('trim', explode(',', trim($value, '[]')));
            }
            $meta[$key] = $value;
        }

        return $meta;
    }
}
