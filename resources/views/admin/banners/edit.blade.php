@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa Banner')
@section('page-title', 'Chỉnh sửa: ' . $banner->title)
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('title') border-red-500 @enderror">
                @error('title')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Phụ đề</label>
                <textarea name="subtitle" rows="2" class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('subtitle', $banner->subtitle) }}</textarea>
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Ảnh banner</label>
                @if($banner->image)
                    <img src="{{ Storage::url($banner->image) }}" class="w-full h-32 object-cover rounded-md mb-12" alt="">
                @endif
                <input type="file" name="image" accept="image/*"
                    class="w-full text-body-sm text-muted-gray file:mr-8 file:py-8 file:px-16 file:rounded-md file:border-0 file:text-body-sm file:font-semibold file:bg-soft-green-background file:text-brand-green">
                <p class="mt-8 text-caption text-hint-gray">Để trống nếu không muốn thay đổi ảnh</p>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Text nút</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Link nút</label>
                    <input type="url" name="button_url" value="{{ old('button_url', $banner->button_url) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Vị trí</label>
                    <input type="text" name="position" value="{{ old('position', $banner->position) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Thứ tự</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Hiển thị banner</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Cập nhật</button>
            <a href="{{ route('admin.banners.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
