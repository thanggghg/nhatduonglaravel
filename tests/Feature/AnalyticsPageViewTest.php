<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AnalyticsPageViewTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_hashes_identifiers_and_forwards_one_exactly_signed_json_body(): void
    {
        Carbon::setTestNow('2026-10-28T10:11:12+07:00');
        config([
            'analytics.collector_url' => 'https://collector.test/page-views',
            'analytics.site' => 'nhaxenhatduong.com',
            'analytics.secret' => 'test-analytics-secret',
            'analytics.timeout' => 2,
        ]);
        Http::fake(['https://collector.test/page-views' => Http::response(status: 204)]);

        $payload = $this->validPayload() + [
            'email' => 'private@example.com',
            'booking_reference' => 'PRIVATE-BOOKING-REFERENCE',
        ];

        $this->postJson('/api/analytics/page-view', $payload)->assertStatus(202);

        $this->assertCount(1, Http::recorded());
        [$request] = Http::recorded()[0];
        $expected = [
            'event_uuid' => '11111111-1111-4111-8111-111111111111',
            'visitor_hash' => hash_hmac('sha256', '22222222-2222-4222-8222-222222222222', 'test-analytics-secret'),
            'session_hash' => hash_hmac('sha256', '33333333-3333-4333-8333-333333333333', 'test-analytics-secret'),
            'occurred_at' => now()->toISOString(),
            'route_name' => 'routes.show',
            'path' => '/tuyen-xe/{slug}',
            'referrer_host' => 'example.com',
            'locale' => 'vi',
            'device_type' => 'mobile',
        ];
        $body = json_encode($expected, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        $timestamp = $request->header('X-Analytics-Timestamp')[0] ?? '';

        $this->assertSame('https://collector.test/page-views', $request->url());
        $this->assertSame($body, $request->body());
        $this->assertSame('application/json', $request->header('Content-Type')[0] ?? '');
        $this->assertSame('nhaxenhatduong.com', $request->header('X-Analytics-Site')[0] ?? '');
        $this->assertSame(hash_hmac('sha256', $timestamp.'.'.$body, 'test-analytics-secret'), $request->header('X-Analytics-Signature')[0] ?? '');
        $this->assertStringNotContainsString('private@example.com', $request->body());
        $this->assertStringNotContainsString('PRIVATE-BOOKING-REFERENCE', $request->body());
    }

    public function test_disabled_analytics_returns_accepted_without_forwarding(): void
    {
        config(['analytics.secret' => '']);
        Http::fake();

        $this->postJson('/api/analytics/page-view', $this->validPayload())->assertStatus(202);

        Http::assertNothingSent();
    }

    public function test_invalid_browser_payload_is_rejected(): void
    {
        $this->postJson('/api/analytics/page-view', [
            'event_uuid' => 'not-a-uuid',
            'visitor_uuid' => 'not-a-uuid',
            'session_uuid' => 'not-a-uuid',
            'path' => str_repeat('x', 501),
            'device_type' => 'watch',
        ])->assertStatus(422)->assertJsonValidationErrors([
            'event_uuid',
            'visitor_uuid',
            'session_uuid',
            'path',
            'device_type',
        ]);
    }

    public function test_browser_script_uses_the_route_template_and_privacy_safe_inputs(): void
    {
        config(['analytics.secret' => 'render-script-secret']);
        Route::get('/analytics-test/{bookingReference}', fn () => view('partials.analytics'))
            ->name('analytics.template-test');

        $this->get('/analytics-test/PRIVATE-123?email=private%40example.com')
            ->assertOk()
            ->assertSee('navigator.doNotTrack', false)
            ->assertSee('localStorage', false)
            ->assertSee('sessionStorage', false)
            ->assertSee('document.referrer', false)
            ->assertSee('.hostname', false)
            ->assertSee('navigator.sendBeacon', false)
            ->assertSee('keepalive: true', false)
            ->assertSee('"analytics.template-test"', false)
            ->assertSee('"\/analytics-test\/{bookingReference}"', false)
            ->assertDontSee('window.location', false)
            ->assertDontSee('PRIVATE-123', false)
            ->assertDontSee('private@example.com', false);
    }

    private function validPayload(): array
    {
        return [
            'event_uuid' => '11111111-1111-4111-8111-111111111111',
            'visitor_uuid' => '22222222-2222-4222-8222-222222222222',
            'session_uuid' => '33333333-3333-4333-8333-333333333333',
            'route_name' => 'routes.show',
            'path' => '/tuyen-xe/{slug}',
            'referrer_host' => 'example.com',
            'locale' => 'vi',
            'device_type' => 'mobile',
        ];
    }
}
