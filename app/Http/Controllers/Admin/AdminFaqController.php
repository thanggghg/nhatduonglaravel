<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->paginate(20);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'sort_order' => 'integer|min:0',
            'status'     => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'Câu hỏi đã được tạo!');
    }

    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'sort_order' => 'integer|min:0',
            'status'     => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'Câu hỏi đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Câu hỏi đã được xóa!');
    }
}
