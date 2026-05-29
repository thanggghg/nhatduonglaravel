@extends('layouts.app')

@section('content')
<!-- Hero Banner Slider -->
<section class="relative bg-gradient-to-br from-[--color-brand-green] to-[#096b39] text-white">
    <div class="container mx-auto px-4 py-16 md:py-24">
        @if($banners->isNotEmpty())
            <div class="max-w-4xl mx-auto text-center">
                @foreach($banners as $banner)
                    <div class="banner-slide">
                        @if($banner->subtitle)
                            <p class="text-brand-gold font-semibold mb-4">{{ $banner->subtitle }}</p>
                        @endif
                        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">{{ $banner->title }}</h1>
                        @if($banner->button_text && $banner->button_url)
                            <a href="{{ $banner->button_url }}" class="inline-block bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                                {{ $banner->button_text }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-brand-gold font-semibold mb-4">An Toàn - Tin Cậy - Tiện Nghi</p>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Nhà Xe Nhật Dương</h1>
                <p class="text-xl mb-8 text-gray-100">Đặt vé xe khách trực tuyến - Nhanh chóng, tiện lợi</p>
                <a href="{{ route('booking.index') }}" class="inline-block bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                    Đặt Vé Ngay
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Featured Routes Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tuyến Xe Nổi Bật</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Các tuyến xe phổ biến với giá cả hợp lý và chất lượng dịch vụ tốt nhất</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredRoutes as $route)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                    @if($route->image)
                        <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-[--color-brand-green] to-[#096b39]"></div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $route->name }}</h3>
                        <div class="flex items-center text-gray-600 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm">{{ $route->from_location }} → {{ $route->to_location }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-brand-green">{{ number_format($route->price_from) }}đ</span>
                            @if($route->distance)
                                <span class="text-sm text-gray-500">{{ $route->distance }} km</span>
                            @endif
                        </div>
                        <a href="{{ route('routes.show', $route->slug) }}" class="block w-full bg-brand-green text-white text-center py-3 rounded-lg font-semibold hover:bg-[#096b39] transition-colors">
                            Xem Chi Tiết
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-8">
                    Chưa có tuyến đường nào
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('routes.index') }}" class="inline-block border-2 border-brand-green text-brand-green px-8 py-3 rounded-lg font-semibold hover:bg-brand-green hover:text-white transition-colors">
                Xem Tất Cả Tuyến Xe
            </a>
        </div>
    </div>
</section>

<!-- Popular Schedules Section -->
@if($popularSchedules->isNotEmpty())
<section class="py-16 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Lịch Trình Phổ Biến</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Các giờ khởi hành được nhiều khách hàng lựa chọn</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-brand-green text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">Tuyến Đường</th>
                            <th class="px-6 py-4 text-left">Giờ Xuất Bến</th>
                            <th class="px-6 py-4 text-left">Loại Xe</th>
                            <th class="px-6 py-4 text-right">Giá Vé</th>
                            <th class="px-6 py-4 text-center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($popularSchedules->take(6) as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $schedule->route->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->departure_time }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->bus_type }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-brand-green">{{ number_format($schedule->price) }}đ</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('routes.show', $schedule->route->slug) }}" class="text-brand-green hover:text-[#096b39] font-semibold">
                                        Đặt Vé
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('schedules.index') }}" class="text-brand-green hover:text-[#096b39] font-semibold">
                Xem Toàn Bộ Lịch Trình →
            </a>
        </div>
    </div>
</section>
@endif

<!-- Latest Posts Section -->
@if($latestPosts->isNotEmpty())
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tin Tức Mới Nhất</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Cập nhật thông tin, khuyến mãi và tin tức mới nhất</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestPosts as $post)
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200"></div>
                    @endif
                    <div class="p-6">
                        @if($post->category)
                            <span class="inline-block bg-[#e8f8ef] text-brand-green text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $post->summary }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $post->published_at->format('d/m/Y') }}</span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-brand-green hover:text-[#096b39] font-semibold text-sm">
                                Đọc thêm →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('posts.index') }}" class="inline-block border-2 border-brand-green text-brand-green px-8 py-3 rounded-lg font-semibold hover:bg-brand-green hover:text-white transition-colors">
                Xem Tất Cả Tin Tức
            </a>
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us Section -->
<section class="py-16 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Vì Sao Chọn Nhật Dương?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Những lý do hàng ngàn khách hàng tin tưởng và lựa chọn</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-brand-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">An Toàn</h3>
                <p class="text-gray-600">Đội ngũ tài xế giàu kinh nghiệm, xe được bảo dưỡng định kỳ</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-brand-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Đúng Giờ</h3>
                <p class="text-gray-600">Cam kết xuất bến đúng giờ, tiết kiệm thời gian của bạn</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-brand-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Tận Tâm</h3>
                <p class="text-gray-600">Phục vụ nhiệt tình, chu đáo, hỗ trợ 24/7</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-brand-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Giá Tốt</h3>
                <p class="text-gray-600">Giá cả hợp lý, nhiều chương trình ưu đãi</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Sẵn Sàng Đặt Vé?</h2>
        <p class="text-xl mb-8 text-gray-100">Đặt vé ngay để nhận ưu đãi tốt nhất</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking.index') }}" class="bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                Đặt Vé Ngay
            </a>
            <a href="{{ route('contact') }}" class="bg-white text-brand-green px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Liên Hệ Tư Vấn
            </a>
        </div>
    </div>
</section>

<!-- Floating Action Buttons (Mobile) -->
<div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40 lg:hidden">
    <a href="tel:0123456789" class="w-14 h-14 bg-brand-green rounded-full flex items-center justify-center shadow-lg hover:bg-[#096b39] transition-colors">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
    </a>
    <a href="{{ route('booking.index') }}" class="w-14 h-14 bg-brand-gold rounded-full flex items-center justify-center shadow-lg hover:bg-[#e19f14] transition-colors">
        <svg class="w-6 h-6 text-[#8a6300]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </a>
</div>
@endsection
