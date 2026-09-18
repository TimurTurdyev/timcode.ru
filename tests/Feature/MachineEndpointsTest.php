<?php

namespace Tests\Feature;

use Tests\TestCase;

class MachineEndpointsTest extends TestCase
{
    public function test_llms_txt_отдаёт_профиль_в_markdown(): void
    {
        $response = $this->get('/llms.txt');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('# Тимур Турдыев', false);
        $response->assertSee('## Open-source пакеты', false);
    }

    public function test_llms_full_txt_содержит_тела_кейсов(): void
    {
        $response = $this->get('/llms-full.txt');

        $response->assertOk();
        $response->assertSee('## Кейсы', false);
        $response->assertSee('### ', false);
    }

    public function test_resume_json_соответствует_схеме_json_resume(): void
    {
        $response = $this->get('/resume.json');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json; charset=UTF-8');

        $resume = $response->json();

        $this->assertSame('Тимур Турдыев', $resume['basics']['name']);
        $this->assertNotEmpty($resume['work']);
        $this->assertNotEmpty($resume['projects']);
        $this->assertNotEmpty($resume['skills']);
        $this->assertStringContainsString('jsonresume', $resume['$schema']);
    }

    public function test_json_карточка_перечисляет_пакеты(): void
    {
        $response = $this->get('/json');

        $response->assertOk();
        $this->assertNotEmpty($response->json('open_source'));
    }

    public function test_главная_несёт_json_ld_разметку(): void
    {
        $response = $this->get('/', ['User-Agent' => 'Mozilla/5.0']);

        $response->assertOk();
        $response->assertSee('application/ld+json', false);
        $response->assertSee('"ProfilePage"', false);
    }

    public function test_curl_режим_отдаёт_терминальный_вывод(): void
    {
        $response = $this->get('/', ['User-Agent' => 'curl/8.0']);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('Open-source', false);
    }
}
