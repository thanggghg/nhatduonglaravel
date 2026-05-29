@extends('admin.layouts.app')
@section('title', 'Liên hệ')
@section('page-title', 'Liên hệ từ khách hàng')
@section('content')
<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tên</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Email</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Chủ đề</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Ngày gửi</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($contacts as $contact)
            <tr class="hover:bg-ghost-fog {{ $contact->status === 'pending' ? 'font-semibold' : '' }}">
                <td class="px-24 py-16 text-body text-slate-text">{{ $contact->name }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $contact->email }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ Str::limit($contact->subject, 40) }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-24 py-16">
                    @if($contact->status === 'pending')
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-light-gold text-gold-text">Chưa đọc</span>
                    @else
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Đã đọc</span>
                    @endif
                </td>
                <td class="px-24 py-16 text-body-sm">
                    <div class="flex items-center gap-12">
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-brand-green hover:text-green-hover">Xem</a>
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" onsubmit="return confirm('Xóa liên hệ này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-24 py-32 text-center text-body text-muted-gray">Chưa có liên hệ nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($contacts->hasPages())<div class="mt-24">{{ $contacts->links() }}</div>@endif
@endsection
