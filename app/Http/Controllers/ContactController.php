<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class ContactController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Liên Hệ');
        SEOMeta::setDescription('Liên hệ với Nhà Xe Nhật Dương để được hỗ trợ tư vấn và đặt vé');

        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
}
