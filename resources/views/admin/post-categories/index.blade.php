@extends('admin.layouts.app')
@section('title', 'Danh mục bài viết')
@section('page-title', 'Danh mục bài viết')
@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý danh mục bài viết</p>
    <a href="{{ route('admin.post-categories.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">+ Thêm danh mục</a>
</div>
<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tên danh mục</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Slug</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Số bài viết</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($categories as $category)
            <tr class="hover:bg-ghost-fog">
                <td class="px-24 py-16 text-body font-medium text-slate-text">{{ $category->name }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray font-mono">{{ $category->slug }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $category->posts_count }}</td>
                <td class="px-24 py-16">
                    @if($category->status)
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">Hiển thị</span>
                    @else
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Ẩn</span>
                    @endif
                </td>
                <td class="px-24 py-16 text-body-sm">
                    <div class="flex items-center gap-12">
                        <a href="{{ route('admin.post-categories.edit', $category->id) }}" class="text-brand-green hover:text-green-hover">Sửa</a>
                        <form method="POST" action="{{ route('admin.post-categories.destroy', $category->id) }}" onsubmit="return confirm('Xóa danh mục này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-24 py-32 text-center text-body text-muted-gray">Chưa có danh mục nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($categories->hasPages())<div class="mt-24">{{ $categories->links() }}</div>@endif
@endsection
