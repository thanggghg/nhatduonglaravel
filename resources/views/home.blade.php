@extends('layouts.app')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-forest-deep text-white">
    <div class="pointer-events-none absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-brand-green opacity-10 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 -left-24 w-[360px] h-[360px] rounded-full bg-brand-gold opacity-10 blur-3xl"></div>
    <div class="relative container mx-auto px-4 py-20 md:py-28">
        <div class="max-w-3xl mx-auto text-center">
            <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-brand-gold text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-brand-gold animate-pulse"></span>
                An Toàn · Tin Cậy · Tiện Nghi
            </span>
            @php $banner = $banners->first(); @endphp
            @if($banner)
                <h1 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight mb-5">{{ $banner->title }}</h1>
                @if($banner->subtitle)<p class="text-lg text-white/70 mb-8">{{ $banner->subtitle }}</p>@endif
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @if($banner->button_text && $banner->button_url)
                    <a href="{{ $banner->button_url }}" class="inline-flex items-center justify-center gap-2 bg-brand-gold text-gold-text font-semibold px-8 py-3.5 rounded-xl hover:bg-gold-hover transition-colors">
                        {{ $banner->button_text }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @endif
                    <a href="{{ route('routes.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition-colors">Xem Tuyến Xe</a>
                </div>
            @else
                <h1 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight mb-5">Nhà Xe <span class="text-brand-gold">Nhật Dương</span></h1>
                <p class="text-lg text-white/70 mb-8">Đặt vé xe khách trực tuyến — Nhanh chóng, tiện lợi</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center gap-2 bg-brand-gold text-gold-text font-semibold px-8 py-3.5 rounded-xl hover:bg-gold-hover transition-colors">
                        Đặt Vé Ngay
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('routes.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition-colors">Xem Tuyến Xe</a>
                </div>
            @endif
        </div>
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-px bg-white/10 rounded-2xl overflow-hidden max-w-3xl mx-auto">
            @foreach([['10+','Năm kinh nghiệm'],['50K+','Khách hàng'],['4','Tuyến đường'],['24/7','Hỗ trợ']] as [$n,$l])
            <div class="bg-white/5 px-6 py-5 text-center">
                <div class="text-2xl font-bold text-brand-gold">{{ $n }}</div>
                <div class="text-sm text-white/60 mt-0.5">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TUYẾN XE NỔI BẬT --}}
<section class="py-20 bg-canvas-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
            <div>
                <span class="text-brand-green text-sm font-semibold uppercase tracking-widest">Tuyến đường</span>
                <h2 class="text-3xl md:text-4xl font-bold text-forest-deep mt-1">Tuyến Xe Nổi Bật</h2>
            </div>
            <a href="{{ route('routes.index') }}" class="text-brand-green font-semibold hover:text-green-hover flex items-center gap-1 shrink-0">
                Xem tất cả <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($featuredRoutes as $route)
            <div class="group bg-canvas-white border border-input-border rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                @if($route->image)
                    <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-brand-green to-green-hover flex items-center justify-center">
                        <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center gap-1.5 text-muted-gray text-xs mb-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $route->from_location }} → {{ $route->to_location }}
                    </div>
                    <h3 class="font-bold text-forest-deep text-base mb-3 leading-snug">{{ $route->name }}</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-bold text-brand-green">{{ number_format($route->price_from) }}đ</span>
                        @if($route->estimated_time)
                            <span class="text-xs text-muted-gray bg-subtle-ash px-2 py-1 rounded-full">{{ $route->estimated_time }}</span>
                        @endif
                    </div>
                    <a href="{{ route('routes.show', $route->slug) }}" class="block w-full bg-brand-green text-white text-center py-2.5 rounded-xl text-sm font-semibold hover:bg-green-hover transition-colors">
                        Xem Chi Tiết
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-muted-gray py-12">Chưa có tuyến đường nào</div>
            @endforelse
        </div>
    </div>
</section>

{{-- LỊCH TRÌNH PHỔ BIẾN --}}
@if($popularSchedules->isNotEmpty())
<section class="py-20 bg-ghost-fog">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
            <div>
                <span class="text-brand-green text-sm font-semibold uppercase tracking-widest">Lịch trình</span>
                <h2 class="text-3xl md:text-4xl font-bold text-forest-deep mt-1">Lịch Trình Phổ Biến</h2>
            </div>
            <a href="{{ route('schedules.index') }}" class="text-brand-green font-semibold hover:text-green-hover flex items-center gap-1 shrink-0">
                Xem tất cả <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="bg-canvas-white rounded-2xl border border-input-border overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-input-border bg-subtle-ash">
                            <th class="px-6 py-4 text-left font-semibold text-forest-deep">Tuyến Đường</th>
                            <th class="px-6 py-4 text-left font-semibold text-forest-deep">Giờ Xuất Bến</th>
                            <th class="px-6 py-4 text-left font-semibold text-forest-deep hidden md:table-cell">Loại Xe</th>
                            <th class="px-6 py-4 text-right font-semibold text-forest-deep">Giá Vé</th>
                            <th class="px-6 py-4 text-center font-semibold text-forest-deep">Đặt Vé</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-input-border">
                        @foreach($popularSchedules->take(6) as $schedule)
                        <tr class="hover:bg-ghost-fog transition-colors">
                            <td class="px-6 py-4 font-medium text-forest-deep">{{ $schedule->route->name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 text-slate-text">
                                    <svg class="w-3.5 h-3.5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $schedule->departure_time }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-muted-gray hidden md:table-cell">{{ $schedule->bus_type }}</td>
                            <td class="px-6 py-4 text-right font-bold text-brand-green">{{ number_format($schedule->price) }}đ</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('routes.show', $schedule->route->slug) }}" class="inline-flex items-center gap-1 bg-brand-green text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-green-hover transition-colors">
                                    Đặt Vé
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endif

{{-- TIN TỨC MỚI NHẤT --}}
@if($latestPosts->isNotEmpty())
<section class="py-20 bg-canvas-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
            <div>
                <span class="text-brand-green text-sm font-semibold uppercase tracking-widest">Tin tức</span>
                <h2 class="text-3xl md:text-4xl font-bold text-forest-deep mt-1">Tin Tức Mới Nhất</h2>
            </div>
            <a href="{{ route('posts.index') }}" class="text-brand-green font-semibold hover:text-green-hover flex items-center gap-1 shrink-0">
                Xem tất cả <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($latestPosts as $post)
            <article class="group bg-canvas-white border border-input-border rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                @if($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-44 bg-subtle-ash flex items-center justify-center">
                        <svg class="w-10 h-10 text-input-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                @endif
                <div class="p-5">
                    @if($post->category)
                        <span class="inline-block text-xs font-semibold text-brand-green bg-soft-green-background px-2.5 py-1 rounded-full mb-3">{{ $post->category->name }}</span>
                    @endif
                    <h3 class="font-bold text-forest-deep text-sm leading-snug mb-3 line-clamp-2">{{ $post->title }}</h3>
                    @if($post->summary)
                        <p class="text-muted-gray text-xs leading-relaxed mb-4 line-clamp-2">{{ $post->summary }}</p>
                    @endif
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-brand-green text-xs font-semibold hover:text-green-hover flex items-center gap-1">
                        Đọc thêm <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VÌ SAO CHỌN CHÚNG TÔI --}}
<section class="py-20 bg-ghost-fog">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="text-brand-green text-sm font-semibold uppercase tracking-widest">Cam kết</span>
            <h2 class="text-3xl md:text-4xl font-bold text-forest-deep mt-1">Vì Sao Chọn Nhật Dương?</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'An Toàn', 'Đội ngũ tài xế giàu kinh nghiệm, xe được bảo dưỡng định kỳ'],
                ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'Đúng Giờ', 'Cam kết xuất bến đúng giờ, tiết kiệm thời gian của bạn'],
                ['M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'Tận Tâm', 'Phục vụ nhiệt tình, chu đáo, hỗ trợ 24/7'],
                ['M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'Giá Tốt', 'Giá cả hợp lý, nhiều chương trình ưu đãi hấp dẫn'],
            ] as [$icon, $title, $desc])
            <div class="bg-canvas-white rounded-2xl p-7 border border-input-border hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-center">
                <div class="w-14 h-14 bg-soft-green-background rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="font-bold text-forest-deep text-base mb-2">{{ $title }}</h3>
                <p class="text-muted-gray text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-forest-deep text-white relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-brand-green/20 to-transparent"></div>
    <div class="pointer-events-none absolute -bottom-20 -right-20 w-80 h-80 rounded-full bg-brand-gold opacity-10 blur-3xl"></div>
    <div class="relative container mx-auto px-4 text-center">
        <span class="inline-block bg-brand-gold/20 text-brand-gold text-sm font-semibold px-4 py-1.5 rounded-full mb-5">Đặt vé ngay hôm nay</span>
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Sẵn Sàng Lên Đường?</h2>
        <p class="text-white/60 text-lg mb-8 max-w-xl mx-auto">Đặt vé ngay để nhận ưu đãi tốt nhất và đảm bảo chỗ ngồi cho chuyến đi của bạn</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center gap-2 bg-brand-gold text-gold-text font-semibold px-8 py-3.5 rounded-xl hover:bg-gold-hover transition-colors">
                Đặt Vé Ngay
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 border border-white/20 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition-colors">
                Liên Hệ Tư Vấn
            </a>
        </div>
    </div>
</section>

{{-- FLOATING BUTTONS (mobile) --}}
<div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40 lg:hidden">
    <a href="tel:0123456789" class="w-13 h-13 bg-brand-green rounded-full flex items-center justify-center shadow-xl hover:bg-green-hover transition-colors">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
    </a>
    <a href="{{ route('booking.index') }}" class="w-13 h-13 bg-brand-gold rounded-full flex items-center justify-center shadow-xl hover:bg-gold-hover transition-colors">
        <svg class="w-5 h-5 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    </a>
</div>

@endsection
