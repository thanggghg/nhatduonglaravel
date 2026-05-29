<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->status === 'pending') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(string $id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Liên hệ đã được xóa!');
    }
}
