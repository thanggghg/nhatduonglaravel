<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAdsTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_ads_tag_is_included_once_on_public_pages(): void
    {
        foreach (['/', '/lien-he?lang=vi'] as $url) {
            $content = $this->get($url)->assertOk()->getContent();

            $this->assertSame(1, substr_count($content, 'googletagmanager.com/gtag/js?id=AW-17488471590'));
            $this->assertSame(1, substr_count($content, "gtag('config', 'AW-17488471590')"));
        }
    }
}
