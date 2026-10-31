<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Services\ContactEmailService;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $locale = $this->locale($request);
        $titles = [
            'vi' => ['Liên Hệ', 'Liên hệ với Nhà Xe Nhật Dương để được hỗ trợ tư vấn và đặt vé'],
            'en' => ['Contact support', 'Contact Nhat Duong for booking support and travel information'],
            'ru' => ['Связаться с поддержкой', 'Свяжитесь с Nhat Duong для помощи с бронированием и поездкой'],
        ][$locale];

        Seo::configure($titles[0], $titles[1], Seo::route('contact', ['lang' => $locale]), $locale);
        $seoAlternates = Seo::alternates('contact');

        $settings = Setting::pluck('value', 'key');
        $turnstileSiteKey = config('services.turnstile.site_key');

        return view('contact.index', compact('locale', 'settings', 'seoAlternates', 'turnstileSiteKey'));
    }

    public function store(Request $request, ContactEmailService $emailService)
    {
        $locale = $this->locale($request);
        $turnstileMessages = [
            'vi' => 'Không thể xác minh CAPTCHA. Vui lòng thử lại.',
            'en' => 'CAPTCHA verification failed. Please try again.',
            'ru' => 'Не удалось пройти проверку CAPTCHA. Попробуйте ещё раз.',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
            'cf-turnstile-response' => 'required|string|max:2048',
        ]);

        $turnstileToken = $validated['cf-turnstile-response'];
        unset($validated['cf-turnstile-response']);

        try {
            $turnstileResponse = Http::asForm()
                ->acceptJson()
                ->connectTimeout(3)
                ->timeout(8)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $turnstileToken,
                    'remoteip' => $request->ip(),
                ]);
        } catch (\Throwable $exception) {
            report($exception);
            throw ValidationException::withMessages(['cf-turnstile-response' => $turnstileMessages[$locale]]);
        }

        if (!$turnstileResponse->successful() || !$turnstileResponse->json('success')) {
            throw ValidationException::withMessages(['cf-turnstile-response' => $turnstileMessages[$locale]]);
        }

        $validated['message'] = $validated['message'] ?? '';
        $contact = Contact::create($validated);

        try {
            $emailService->sendNotification($contact, route('contact', ['lang' => $locale]));
        } catch (\Throwable $exception) {
            report($exception);
        }

        $messages = [
            'vi' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.',
            'en' => 'Thank you for contacting us. Our team will respond as soon as possible.',
            'ru' => 'Спасибо за обращение. Наша команда ответит вам как можно скорее.',
        ];

        return back()->with('success', $messages[$locale]);
    }

    private function locale(Request $request): string
    {
        $locale = $request->input('lang');

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    }
}
