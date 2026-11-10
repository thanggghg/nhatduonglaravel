<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Setting;
use App\Services\ContactEmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_is_optional_and_a_notification_is_requested(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true]),
        ]);
        $this->mock(ContactEmailService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('sendNotification')
                ->once()
                ->withArgs(fn (Contact $contact, string $sourceUrl) => $contact->name === 'Nguyễn Văn An'
                    && $contact->message === ''
                    && $sourceUrl === route('contact', ['lang' => 'vi']));
        });

        $response = $this->post(route('contact.store'), [
            'lang' => 'vi',
            'name' => 'Nguyễn Văn An',
            'phone' => '0901234567',
            'cf-turnstile-response' => 'valid-token',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'name' => 'Nguyễn Văn An',
            'phone' => '0901234567',
            'message' => '',
        ]);
    }

    public function test_contact_is_rejected_when_turnstile_verification_fails(): void
    {
        config(['services.turnstile.secret_key' => 'test-secret']);
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => false]),
        ]);

        $response = $this->post(route('contact.store'), [
            'lang' => 'vi',
            'name' => 'Nguyễn Văn An',
            'phone' => '0901234567',
            'cf-turnstile-response' => 'invalid-token',
        ]);

        $response->assertSessionHasErrors('cf-turnstile-response');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_is_marked_when_ads_mode_is_enabled(): void
    {
        Setting::where('key', 'ads_booking_mode')->update(['value' => '1']);
        config(['services.turnstile.secret_key' => 'test-secret']);
        Http::fake([
            'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true]),
        ]);
        $this->mock(ContactEmailService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('sendNotification')
                ->once()
                ->withArgs(fn (Contact $contact, string $sourceUrl) => $contact->ads_mode
                    && $sourceUrl === route('contact', ['lang' => 'vi']));
        });

        $this->post(route('contact.store'), [
            'lang' => 'vi',
            'name' => 'Khách quảng cáo',
            'phone' => '0901234567',
            'cf-turnstile-response' => 'valid-token',
        ])->assertRedirect();

        $this->assertTrue(Contact::sole()->ads_mode);
    }

    public function test_contact_email_uses_admin_recipients_and_its_own_template(): void
    {
        config([
            'services.smtp2go.api_key' => 'test-key',
            'services.smtp2go.sender' => 'no-reply@example.com',
            'services.smtp2go.cc' => ['primary@example.com', 'team@example.com'],
        ]);
        Http::fake([
            'api.smtp2go.com/*' => Http::response(['data' => ['succeeded' => 1]], 200),
        ]);
        $contact = Contact::create([
            'name' => 'Trần Minh',
            'phone' => '0912345678',
            'email' => 'minh@example.com',
            'message' => 'Cần hỗ trợ điểm đón.',
        ]);

        app(ContactEmailService::class)->sendNotification($contact, 'https://nhaxenhatduong.com/lien-he?lang=vi');

        Http::assertSent(function (Request $request) use ($contact): bool {
            $data = $request->data();

            return $request->url() === 'https://api.smtp2go.com/v3/email/send'
                && $data['to'] === ['primary@example.com']
                && $data['cc'] === ['team@example.com']
                && str_contains($data['subject'], '#'.$contact->id)
                && str_contains($data['html_body'], 'Yêu cầu liên hệ mới')
                && str_contains($data['html_body'], 'Cần hỗ trợ điểm đón.');
        });
    }

    public function test_ads_contact_email_only_uses_ads_recipients(): void
    {
        config([
            'services.smtp2go.api_key' => 'test-key',
            'services.smtp2go.sender' => 'no-reply@example.com',
            'services.smtp2go.ads_recipients' => ['t0972199672@gmail.com'],
            'services.smtp2go.cc' => ['primary@example.com', 'team@example.com'],
        ]);
        Http::fake([
            'api.smtp2go.com/*' => Http::response(['data' => ['succeeded' => 2]], 200),
        ]);
        $contact = Contact::create([
            'name' => 'Khách quảng cáo',
            'phone' => '0912345678',
            'email' => 'customer@example.com',
            'message' => 'Cần tư vấn.',
            'ads_mode' => true,
        ]);

        app(ContactEmailService::class)->sendNotification($contact, 'https://nhaxenhatduong.com/lien-he?lang=vi');

        Http::assertSent(function (Request $request): bool {
            $data = $request->data();

            return $data['to'] === ['t0972199672@gmail.com']
                && $data['cc'] === [];
        });
    }
}
