@extends('admin.layouts.app')
@section('title', 'Chi tiết liên hệ')
@section('page-title', 'Chi tiết liên hệ')
@section('content')
<div class="max-w-2xl">
    <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
        <div class="grid grid-cols-2 gap-24 mb-24">
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Họ tên</p>
                <p class="text-body font-medium text-slate-text">{{ $contact->name }}</p>
            </div>
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Email</p>
                <p class="text-body font-medium text-slate-text">{{ $contact->email }}</p>
            </div>
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Số điện thoại</p>
                <p class="text-body font-medium text-slate-text">{{ $contact->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Ngày gửi</p>
                <p class="text-body font-medium text-slate-text">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="mb-24">
            <p class="text-body-sm text-muted-gray mb-4">Chủ đề</p>
            <p class="text-body font-medium text-slate-text">{{ $contact->subject ?? '—' }}</p>
        </div>
        <div>
            <p class="text-body-sm text-muted-gray mb-8">Nội dung</p>
            <div class="bg-ghost-fog rounded-md p-16 text-body text-slate-text whitespace-pre-wrap">{{ $contact->message }}</div>
        </div>
    </div>
    <div class="flex gap-12">
        <a href="{{ route('admin.contacts.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">← Quay lại</a>
        <a href="mailto:{{ $contact->email }}" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Trả lời qua Email</a>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" onsubmit="return confirm('Xóa liên hệ này?')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-canvas-white text-red-600 border border-red-200 font-semibold py-14 px-28 rounded-md hover:bg-red-50">Xóa</button>
        </form>
    </div>
</div>
@endsection
