@extends('admin.layouts.app')
@section('title', 'Câu hỏi thường gặp')
@section('page-title', 'Câu hỏi thường gặp (FAQ)')
@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý câu hỏi thường gặp</p>
    <a href="{{ route('admin.faqs.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">+ Thêm câu hỏi</a>
</div>
<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Câu hỏi</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thứ tự</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($faqs as $faq)
            <tr class="hover:bg-ghost-fog">
                <td class="px-24 py-16 text-body text-slate-text">{{ Str::limit($faq->question, 80) }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $faq->sort_order }}</td>
                <td class="px-24 py-16">
                    @if($faq->status)
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">Hiển thị</span>
                    @else
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Ẩn</span>
                    @endif
                </td>
                <td class="px-24 py-16 text-body-sm">
                    <div class="flex items-center gap-12">
                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="text-brand-green hover:text-green-hover">Sửa</a>
                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq->id) }}" onsubmit="return confirm('Xóa câu hỏi này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-24 py-32 text-center text-body text-muted-gray">Chưa có câu hỏi nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($faqs->hasPages())<div class="mt-24">{{ $faqs->links() }}</div>@endif
@endsection
