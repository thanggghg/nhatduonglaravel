<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Services\ContactEmailService;
use App\Support\Seo;
use Illuminate\Http\Request;

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

        return view('contact.index', compact('locale', 'settings', 'seoAlternates'));
    }

    public function store(Request $request, ContactEmailService $emailService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $locale = $this->locale($request);
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
