@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <a href="{{ route('routes.index') }}" class="text-gray-600 hover:text-brand-green">Tuyến xe</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">{{ $route->name }}</span>
        </nav>
    </div>
</div>

<!-- Route Hero -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image -->
            <div>
                @if($route->image)
                    <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="w-full h-96 object-cover rounded-2xl shadow-lg">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $route->name }}</h1>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-brand-green mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <span class="block text-sm text-gray-500">Điểm đi - Điểm đến</span>
                            <span class="block text-lg font-semibold text-gray-900">{{ $route->from_location }} → {{ $route->to_location }}</span>
                        </div>
                    </div>

                    @if($route->distance || $route->estimated_time)
                        <div class="flex items-center gap-6">
                            @if($route->distance)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                    <div>
                                        <span class="block text-sm text-gray-500">Quãng đường</span>
                                        <span class="block font-semibold text-gray-900">{{ $route->distance }} km</span>
                                    </div>
                                </div>
                            @endif
                            @if($route->estimated_time)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <span class="block text-sm text-gray-500">Thời gian</span>
                                        <span class="block font-semibold text-gray-900">{{ $route->estimated_time }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="bg-[#f8fdf9] rounded-2xl p-6 mb-6">
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-sm text-gray-600">Giá vé từ</span>
                        <span class="text-4xl font-bold text-brand-green">{{ number_format($route->price_from) }}đ</span>
                    </div>
                    <p class="text-sm text-gray-500">Giá có thể thay đổi tùy theo loại xe và thời gian</p>
                </div>

                @if($route->booking_url)
                    <a href="{{ route('booking.redirect', ['route_id' => $route->id, 'booking_url' => $route->booking_url, 'source_page' => 'route_detail']) }}" class="block w-full bg-brand-green text-white text-center py-4 rounded-lg font-bold text-lg hover:bg-[#096b39] transition-colors mb-4">
                        Đặt Vé Ngay
                    </a>
                @endif

                <a href="tel:0123456789" class="block w-full border-2 border-brand-green text-brand-green text-center py-4 rounded-lg font-semibold hover:bg-brand-green hover:text-white transition-colors">
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Gọi Tư Vấn: 0123 456 789
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Description -->
@if($route->description)
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Thông Tin Tuyến Xe</h2>
            <div class="bg-white rounded-2xl shadow-lg p-8 prose prose-lg max-w-none">
                {!! nl2br(e($route->description)) !!}
            </div>
        </div>
    </div>
</section>
@endif

<!-- Schedules -->
@if($schedules->isNotEmpty())
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Lịch Trình Khởi Hành</h2>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-brand-green text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">Giờ Xuất Bến</th>
                            <th class="px-6 py-4 text-left">Giờ Đến</th>
                            <th class="px-6 py-4 text-left">Loại Xe</th>
                            <th class="px-6 py-4 text-right">Giá Vé</th>
                            <th class="px-6 py-4 text-center">Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $schedule->departure_time }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->arrival_time }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->bus_type }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-brand-green">{{ number_format($schedule->price) }}đ</span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-600">
                                    {{ $schedule->note ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-4 text-center">* Lịch trình có thể thay đổi tùy theo tình hình thực tế</p>
    </div>
</section>
@endif

<!-- Pickup Points -->
@if($pickupPoints->isNotEmpty())
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Điểm Đón Khách</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($pickupPoints as $point)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $point->name }}</h3>
                    <div class="space-y-2">
                        @if($point->address)
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $point->address }}</span>
                            </div>
                        @endif
                        @if($point->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $point->phone }}" class="text-brand-green hover:text-[#096b39] font-semibold">{{ $point->phone }}</a>
                            </div>
                        @endif
                        @if($point->note)
                            <p class="text-sm text-gray-600 mt-2 pl-7">{{ $point->note }}</p>
                        @endif
                        @if($point->map_url)
                            <a href="{{ $point->map_url }}" target="_blank" class="inline-flex items-center gap-2 text-brand-green hover:text-[#096b39] text-sm font-semibold mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Xem bản đồ
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Dropoff Points -->
@if($dropoffPoints->isNotEmpty())
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Điểm Trả Khách</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($dropoffPoints as $point)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $point->name }}</h3>
                    <div class="space-y-2">
                        @if($point->address)
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-brand-green mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $point->address }}</span>
                            </div>
                        @endif
                        @if($point->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $point->phone }}" class="text-brand-green hover:text-[#096b39] font-semibold">{{ $point->phone }}</a>
                            </div>
                        @endif
                        @if($point->note)
                            <p class="text-sm text-gray-600 mt-2 pl-7">{{ $point->note }}</p>
                        @endif
                        @if($point->map_url)
                            <a href="{{ $point->map_url }}" target="_blank" class="inline-flex items-center gap-2 text-brand-green hover:text-[#096b39] text-sm font-semibold mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Xem bản đồ
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- FAQs -->
@if($faqs->isNotEmpty())
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Câu Hỏi Thường Gặp</h2>
            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $faq->question }}</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Sẵn Sàng Đặt Vé?</h2>
        <p class="text-xl mb-8 text-gray-100 max-w-2xl mx-auto">Đặt vé ngay hoặc liên hệ để được tư vấn chi tiết</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($route->booking_url)
                <a href="{{ route('booking.redirect', ['route_id' => $route->id, 'booking_url' => $route->booking_url, 'source_page' => 'route_detail_bottom']) }}" class="bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                    Đặt Vé Ngay
                </a>
            @endif
            <a href="tel:0123456789" class="bg-white text-brand-green px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Gọi: 0123 456 789
            </a>
        </div>
    </div>
</section>
@endsection
