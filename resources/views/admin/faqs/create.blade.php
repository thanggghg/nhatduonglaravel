@extends('admin.layouts.app')
@section('title', 'Thêm câu hỏi')
@section('page-title', 'Thêm câu hỏi mới')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Câu hỏi <span class="text-red-500">*</span></label>
                <textarea name="question" rows="3" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('question') border-red-500 @enderror"
                    placeholder="Nhập câu hỏi...">{{ old('question') }}</textarea>
                @error('question')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Câu trả lời <span class="text-red-500">*</span></label>
                <textarea name="answer" rows="6" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('answer') border-red-500 @enderror"
                    placeholder="Nhập câu trả lời...">{{ old('answer') }}</textarea>
                @error('answer')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Thứ tự</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Hiển thị câu hỏi</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Tạo câu hỏi</button>
            <a href="{{ route('admin.faqs.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
