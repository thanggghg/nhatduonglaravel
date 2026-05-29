@extends('admin.layouts.app')

@section('title', 'Quản lý Bài viết')
@section('page-title', 'Bài viết')

@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý tất cả bài viết</p>
    <a href="{{ route('admin.posts.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">
        + Thêm bài viết
    </a>
</div>

<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tiêu đề</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Danh mục</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Ngày đăng</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($posts as $post)
                <tr class="hover:bg-ghost-fog">
                    <td class="px-24 py-16">
                        <div class="flex items-center gap-12">
                            @if($post->thumbnail)
                                <img src="{{ Storage::url($post->thumbnail) }}" class="w-40 h-40 rounded-md object-cover" alt="">
                            @else
                                <div class="w-40 h-40 rounded-md bg-subtle-ash flex items-center justify-center">
                                    <svg class="w-20 h-20 text-muted-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <span class="text-body font-medium text-slate-text">{{ Str::limit($post->title, 60) }}</span>
                        </div>
                    </td>
                    <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $post->category->name ?? '—' }}</td>
                    <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $post->published_at?->format('d/m/Y') ?? '—' }}</td>
                    <td class="px-24 py-16">
                        @if($post->status)
                            <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">Hiển thị</span>
                        @else
                            <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Ẩn</span>
                        @endif
                    </td>
                    <td class="px-24 py-16 text-body-sm">
                        <div class="flex items-center gap-12">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-brand-green hover:text-green-hover">Sửa</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" onsubmit="return confirm('Xóa bài viết này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-24 py-32 text-center text-body text-muted-gray">
                        Chưa có bài viết nào. <a href="{{ route('admin.posts.create') }}" class="text-brand-green hover:underline">Tạo bài viết mới</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
    <div class="mt-24">{{ $posts->links() }}</div>
@endif
@endsection
