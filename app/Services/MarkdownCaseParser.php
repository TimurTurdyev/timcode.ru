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

        return [
            'meta' => $meta,
            'body' => $body,
            'html' => $this->enhanceImages($converter->convert($body)->getContent()),
        ];
    }

    /**
     * Превращает одиночную картинку абзаца в подписанный кадр.
     *
     * Текст alt становится подписью под снимком. Если рядом с .webp лежит
     * .jpg, отдаём оба через picture. Якорь #wide в адресе выносит кадр
     * за ширину колонки текста.
     */
    private function enhanceImages(string $html): string
    {
        $pattern = '~<p>\s*<img src="([^"]+)"(?:\s+alt="([^"]*)")?\s*/?>\s*</p>~u';

        return preg_replace_callback($pattern, function (array $m) {
            $src     = html_entity_decode($m[1], ENT_QUOTES);
            $caption = isset($m[2]) ? html_entity_decode($m[2], ENT_QUOTES) : '';

            $wide = str_contains($src, '#wide');
            $src  = strtok($src, '#');

            [$width, $height] = $this->imageSize($src);
            $dimensions = $width && $height ? " width=\"{$width}\" height=\"{$height}\"" : '';

            $fallback = preg_replace('~\.webp$~', '.jpg', $src);
            $hasJpeg  = $fallback !== $src && $this->publicFileExists($fallback);

            $img = '<img src="' . e($hasJpeg ? $fallback : $src) . '" alt="' . e($caption) . '"'
                . $dimensions . ' loading="lazy" decoding="async">';

            $picture = $hasJpeg
                ? '<picture><source type="image/webp" srcset="' . e($src) . '">' . $img . '</picture>'
                : $img;

            $figure  = '<figure class="case-figure' . ($wide ? ' is-wide' : '') . '">';
            $figure .= '<div class="case-shot" data-zoomable>' . $picture . '</div>';

            if ($caption !== '') {
                $figure .= '<figcaption>' . e($caption) . '</figcaption>';
            }

            return $figure . '</figure>';
        }, $html) ?? $html;
    }

    /**
     * @return array{0: int|null, 1: int|null}
     */
    private function imageSize(string $src): array
    {
        if (! str_starts_with($src, '/')) {
            return [null, null];
        }

        $path = public_path(ltrim($src, '/'));

        if (! is_file($path)) {
            return [null, null];
        }

        $size = @getimagesize($path);

        return $size ? [$size[0], $size[1]] : [null, null];
    }

    private function publicFileExists(string $src): bool
    {
        return str_starts_with($src, '/') && is_file(public_path(ltrim($src, '/')));
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
