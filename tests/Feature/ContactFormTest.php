<?php

namespace Tests\Feature;

use App\Models\Contact;
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
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'name' => 'Nguyễn Văn An',
            'phone' => '0901234567',
            'message' => '',
        ]);
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
}
