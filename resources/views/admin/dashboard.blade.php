@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .ads-mode{margin-bottom:32px;overflow:hidden;background:#fff;border:1px solid #d1ddd5;border-radius:12px;box-shadow:0 4px 16px rgba(11,127,66,.1)}
    .ads-mode.is-active{background:#fff9e8;border-color:#e7c85d}.ads-mode__inner{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:24px}.ads-mode__copy{display:flex;align-items:flex-start;gap:16px}.ads-mode__icon{display:grid;width:48px;height:48px;flex:none;place-items:center;color:#0b7f42;background:#e8f8ef;border-radius:8px}.ads-mode.is-active .ads-mode__icon{color:#5c4500;background:#fbb116}.ads-mode__icon svg{width:24px;height:24px}.ads-mode__heading{display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:6px}.ads-mode__heading h2{margin:0;color:#062d1c;font-size:18px;font-weight:800}.ads-mode__status{padding:4px 10px;color:#0b7f42;background:#e8f8ef;border-radius:999px;font-size:11px;font-weight:800}.ads-mode.is-active .ads-mode__status{color:#5c4500;background:#fbb116}.ads-mode__copy p{max-width:720px;margin:0;color:#718278;font-size:13px;line-height:1.6}.ads-mode__form{display:flex;align-items:center;gap:12px;flex:none}.ads-mode__toggle{display:flex;align-items:center;gap:9px;color:#365145;font-size:13px;font-weight:700;cursor:pointer}.ads-mode__toggle input{width:20px;height:20px;accent-color:#e6a000}.ads-mode__form button{padding:10px 16px;color:#fff;background:#062d1c;border:0;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer}.ads-mode__form button:hover{background:#0b7f42}@media(max-width:800px){.ads-mode__inner{align-items:stretch;flex-direction:column}.ads-mode__form{justify-content:flex-end}}@media(max-width:520px){.ads-mode__copy{display:grid}.ads-mode__form{align-items:stretch;flex-direction:column}.ads-mode__form button{width:100%}}
</style>
@endpush

@section('content')
<section class="ads-mode {{ $adsBookingMode ? 'is-active' : '' }}">
    <div class="ads-mode__inner">
        <div class="ads-mode__copy">
            <span class="ads-mode__icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.99 3.99 0 01-1.564-.317z"></path></svg>
            </span>
            <div>
                <div class="ads-mode__heading">
                    <h2>Chế độ chạy quảng cáo</h2>
                    <span class="ads-mode__status">{{ $adsBookingMode ? 'ĐANG BẬT' : 'ĐANG TẮT' }}</span>
                </div>
                <p>Khi bật, yêu cầu đặt vé không tạo đơn hoặc giữ ghế trên API. Email đặt vé gửi cho khách và hai địa chỉ quảng cáo; email liên hệ chỉ gửi tới t0972199672@gmail.com và ngothien9163@gmail.com thay vì danh sách nội bộ thông thường.</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.dashboard.ads-booking-mode') }}" class="ads-mode__form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="ads_booking_mode" value="0">
            <label class="ads-mode__toggle">
                <input type="checkbox" name="ads_booking_mode" value="1" @checked($adsBookingMode)>
                Chạy quảng cáo
            </label>
            <button type="submit">Lưu trạng thái</button>
        </form>
    </div>
</section>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-24 mb-32">
    <!-- Stats Cards -->
    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Tuyến xe</p>
                <p class="text-heading-lg font-bold text-forest-deep">{{ $stats['routes'] }}</p>
            </div>
            <div class="w-48 h-48 bg-soft-green-background rounded-lg flex items-center justify-center">
                <svg class="w-24 h-24 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Lịch trình</p>
                <p class="text-heading-lg font-bold text-forest-deep">{{ $stats['schedules'] }}</p>
            </div>
            <div class="w-48 h-48 bg-light-gold rounded-lg flex items-center justify-center">
                <svg class="w-24 h-24 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Bài viết</p>
                <p class="text-heading-lg font-bold text-forest-deep">{{ $stats['posts'] }}</p>
            </div>
            <div class="w-48 h-48 bg-soft-green-background rounded-lg flex items-center justify-center">
                <svg class="w-24 h-24 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-body-sm text-muted-gray mb-4">Liên hệ mới</p>
                <p class="text-heading-lg font-bold text-forest-deep">{{ $stats['contacts'] }}</p>
            </div>
            <div class="w-48 h-48 bg-light-gold rounded-lg flex items-center justify-center">
                <svg class="w-24 h-24 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-24">
    <!-- Recent Contacts -->
    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <h3 class="text-heading font-semibold text-forest-deep mb-16">Liên hệ gần đây</h3>
        <div class="space-y-12">
            @forelse($recentContacts as $contact)
                <div class="border-b border-input-border pb-12">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-body font-medium text-slate-text">{{ $contact->name }}</p>
                            <p class="text-body-sm text-muted-gray">{{ $contact->email }}</p>
                            <p class="text-body-sm text-muted-gray mt-4">{{ Str::limit($contact->message, 50) }}</p>
                        </div>
                        <span class="text-caption text-hint-gray">{{ $contact->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <p class="text-body text-muted-gray">Chưa có liên hệ nào</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="bg-canvas-white rounded-lg shadow-md p-24">
        <h3 class="text-heading font-semibold text-forest-deep mb-16">Bài viết gần đây</h3>
        <div class="space-y-12">
            @forelse($recentPosts as $post)
                <div class="border-b border-input-border pb-12">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-body font-medium text-slate-text">{{ $post->title }}</p>
                            <p class="text-body-sm text-muted-gray">{{ $post->category->name }}</p>
                        </div>
                        <span class="text-caption text-hint-gray">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <p class="text-body text-muted-gray">Chưa có bài viết nào</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
