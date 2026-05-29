@extends('admin.layouts.app')
@section('title', 'Thêm trang')
@section('page-title', 'Thêm trang mới')
@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.pages.store') }}">
        @csrf
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('title') border-red-500 @enderror"
                    placeholder="Tiêu đề trang">
                @error('title')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Nội dung <span class="text-red-500">*</span></label>
                <textarea name="content" rows="16" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('content') border-red-500 @enderror"
                    placeholder="Nội dung trang...">{{ old('content') }}</textarea>
                @error('content')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Meta Description</label>
                <textarea name="meta_description" rows="3"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('meta_description') }}</textarea>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Hiển thị trang</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Tạo trang</button>
            <a href="{{ route('admin.pages.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
