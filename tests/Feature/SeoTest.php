<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'https://nhaxenhatduong.com']);
    }

    public function test_public_content_has_one_title_and_canonical_metadata(): void
    {
        $response = $this->get('/tuyen-xe?lang=vi');

        $response->assertOk();
        $html = $response->getContent();

        $this->assertSame(1, substr_count(strtolower($html), '<title>'));
        $this->assertStringContainsString('<html lang="vi">', $html);
        $this->assertStringContainsString('<link rel="canonical" href="https://nhaxenhatduong.com/tuyen-xe?lang=vi"', $html);
        $this->assertStringContainsString('hreflang="x-default"', $html);
        $this->assertStringContainsString('property="og:url"', $html);
        $this->assertStringContainsString('name="twitter:card"', $html);
    }

    public function test_transactional_and_admin_routes_are_not_indexable(): void
    {
        $this->get('/dat-ve/checkout-live')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');

        $this->get('/admin/login')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive">', false);
    }

    public function test_sitemap_contains_only_canonical_public_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('https://nhaxenhatduong.com/?lang=vi', false);
        $xml = simplexml_load_string($response->getContent());
        $locations = collect($xml->url)->map(fn ($url) => (string) $url->loc);

        $this->assertFalse($locations->contains(fn (string $url) => str_starts_with(parse_url($url, PHP_URL_PATH), '/dat-ve')));
        $this->assertFalse($locations->contains(fn (string $url) => str_starts_with(parse_url($url, PHP_URL_PATH), '/admin')));
        $this->assertFalse($locations->contains(fn (string $url) => str_starts_with(parse_url($url, PHP_URL_PATH), '/api')));
        $this->assertFalse($locations->contains(fn (string $url) => str_starts_with(parse_url($url, PHP_URL_PATH), '/payments')));
    }
}
