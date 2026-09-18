<?php

namespace Tests\Feature;

use App\Services\MarkdownCaseParser;
use Tests\TestCase;

class CaseImagesTest extends TestCase
{
    public function test_картинка_абзаца_становится_подписанным_кадром(): void
    {
        $html = (new MarkdownCaseParser())->parseFull(
            "---\ntitle: T\n---\n\n![Подпись кадра](/img/cases/office-furniture-shop/facets.webp)\n"
        )['html'];

        $this->assertStringContainsString('<figure class="case-figure"', $html);
        $this->assertStringContainsString('<figcaption>Подпись кадра</figcaption>', $html);
        $this->assertStringContainsString('data-zoomable', $html);
        $this->assertStringContainsString('loading="lazy"', $html);
    }

    public function test_якорь_wide_помечает_широкий_кадр(): void
    {
        $html = (new MarkdownCaseParser())->parseFull(
            "---\ntitle: T\n---\n\n![Ш](/img/cases/office-furniture-shop/facets.webp#wide)\n"
        )['html'];

        $this->assertStringContainsString('case-figure is-wide', $html);
        $this->assertStringNotContainsString('#wide', $html);
    }

    public function test_рядом_лежащий_jpeg_становится_запасным_вариантом(): void
    {
        $html = (new MarkdownCaseParser())->parseFull(
            "---\ntitle: T\n---\n\n![Ф](/img/cases/office-furniture-shop/facets.webp)\n"
        )['html'];

        $this->assertStringContainsString('<source type="image/webp"', $html);
        $this->assertStringContainsString('facets.jpg', $html);
        $this->assertMatchesRegularExpression('~width="\d+" height="\d+"~', $html);
    }

    public function test_страница_кейса_отдаёт_кадры_и_обложку(): void
    {
        $response = $this->get('/cases/office-furniture-shop');

        $response->assertOk();
        $response->assertSee('case-figure', false);
        $response->assertSee('og:image" content="' . url('/img/cases/office-furniture-shop/storefront.jpg'), false);
    }
}
