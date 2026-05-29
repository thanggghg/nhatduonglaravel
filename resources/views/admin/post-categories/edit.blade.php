@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa danh mục')
@section('page-title', 'Chỉnh sửa: ' . $category->name)
@section('content')
<div class="max-w-xl">
    <form method="POST" action="{{ route('admin.post-categories.update', $category->id) }}">
        @csrf @method('PUT')
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tên danh mục <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Mô tả</label>
                <textarea name="description" rows="3"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Hiển thị danh mục</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Cập nhật</button>
            <a href="{{ route('admin.post-categories.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
