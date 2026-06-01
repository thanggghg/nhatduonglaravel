@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">Tuyến Xe</span>
        </nav>
    </div>
</div>

<!-- Page Header -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Tuyến Xe Của Chúng Tôi</h1>
        <p class="text-xl text-gray-600">Khám phá các tuyến xe phục vụ trên khắp cả nước</p>
    </div>
</section>

<!-- Routes Grid -->
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        @if($routes->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($routes as $route)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                        @if($route->image)
                            <a href="{{ route('routes.show', $route->slug) }}">
                                <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="w-full h-56 object-cover">
                            </a>
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-brand-green">
                                <a href="{{ route('routes.show', $route->slug) }}">{{ $route->name }}</a>
                            </h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-gray-700 text-sm">{{ $route->from_location }} → {{ $route->to_location }}</span>
                                </div>
                                
                                @if($route->distance || $route->estimated_time)
                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        @if($route->distance)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                                {{ $route->distance }} km
                                            </span>
                                        @endif
                                        @if($route->estimated_time)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $route->estimated_time }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between mb-4 pt-4 border-t border-gray-100">
                                <div>
                                    <span class="text-sm text-gray-500 block">Giá từ</span>
                                    <span class="text-2xl font-bold text-brand-green">{{ number_format($route->price_from) }}đ</span>
                                </div>
                                <span class="bg-[#e8f8ef] text-brand-green text-xs font-semibold px-3 py-1 rounded-full">
                                    Hoạt động
                                </span>
                            </div>

                            <a href="{{ route('routes.show', $route->slug) }}" class="block w-full bg-brand-green text-white text-center py-3 rounded-lg font-semibold hover:bg-[#096b39] transition-colors">
                                Xem Chi Tiết & Đặt Vé
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $routes->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có tuyến đường</h3>
                <p class="text-gray-600">Hãy quay lại sau để xem các tuyến xe của chúng tôi</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Cần Tư Vấn Thêm?</h2>
        <p class="text-xl mb-8 text-gray-100">Liên hệ ngay với chúng tôi để được hỗ trợ tốt nhất</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:1900 2879" class="bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Gọi Ngay: 1900 2879
            </a>
            <a href="{{ route('contact') }}" class="bg-white text-brand-green px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Gửi Yêu Cầu
            </a>
        </div>
    </div>
</section>
@endsection
