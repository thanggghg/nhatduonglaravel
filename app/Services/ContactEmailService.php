<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ContactEmailService
{
    public function sendNotification(Contact $contact, string $sourceUrl): void
    {
        $apiKey = config('services.smtp2go.api_key');
        $recipients = config('services.smtp2go.cc', []);
        $to = array_slice($recipients, 0, 1);

        if (!$apiKey || !$to) {
            return;
        }

        if (!filter_var($sourceUrl, FILTER_VALIDATE_URL) || !in_array(parse_url($sourceUrl, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $sourceUrl = route('contact');
        }

        $message = trim((string) $contact->message) ?: 'Không cung cấp';
        $html = view('emails.contact-notification', compact('contact', 'sourceUrl', 'message'))->render();
        $text = implode("\n", [
            'Có 1 yêu cầu liên hệ mới:',
            '- Mã yêu cầu: #'.$contact->id,
            '- Thời gian: '.$contact->created_at?->format('d/m/Y H:i'),
            '- Họ và tên: '.$contact->name,
            '- Điện thoại: '.$contact->phone,
            '- Email: '.($contact->email ?: 'Không cung cấp'),
            '- Nội dung: '.$message,
            '- Nguồn: '.$sourceUrl,
        ]);
        $name = trim((string) preg_replace('/[\r\n]+/', ' ', $contact->name));

        $response = Http::asJson()
            ->timeout(15)
            ->retry(2, 300)
            ->post('https://api.smtp2go.com/v3/email/send', [
                'api_key' => $apiKey,
                'to' => $to,
                'cc' => array_slice($recipients, 1),
                'sender' => config('services.smtp2go.sender'),
                'subject' => '[Nhật Dương] Yêu cầu liên hệ mới #'.$contact->id.' - '.$name,
                'text_body' => $text,
                'html_body' => $html,
            ]);

        if (!$response->successful() || (int) data_get($response->json(), 'data.succeeded', 0) < 1) {
            throw new RuntimeException('SMTP2GO rejected contact notification: '.$response->status());
        }
    }
}
