@extends('admin.layouts.app')
@section('title', 'Trang nội dung')
@section('page-title', 'Trang nội dung')
@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý các trang tĩnh</p>
    <a href="{{ route('admin.pages.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">+ Thêm trang</a>
</div>
<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tiêu đề</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Slug</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($pages as $page)
            <tr class="hover:bg-ghost-fog">
                <td class="px-24 py-16 text-body font-medium text-slate-text">{{ $page->title }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray font-mono">/{{ $page->slug }}</td>
                <td class="px-24 py-16">
                    @if($page->status)
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">Hiển thị</span>
                    @else
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Ẩn</span>
                    @endif
                </td>
                <td class="px-24 py-16 text-body-sm">
                    <div class="flex items-center gap-12">
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="text-brand-green hover:text-green-hover">Sửa</a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}" onsubmit="return confirm('Xóa trang này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-24 py-32 text-center text-body text-muted-gray">Chưa có trang nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($pages->hasPages())<div class="mt-24">{{ $pages->links() }}</div>@endif
@endsection
