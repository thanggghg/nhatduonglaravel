@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">Lịch Trình</span>
        </nav>
    </div>
</div>

<!-- Page Header -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Lịch Trình Tham Khảo</h1>
        <p class="text-xl text-gray-600">Xem lịch trình các chuyến xe để lựa chọn giờ khởi hành phù hợp</p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('schedules.index') }}" class="max-w-2xl">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <label for="route_id" class="block text-sm font-semibold text-gray-700 mb-2">Lọc theo tuyến xe:</label>
                <div class="flex gap-4">
                    <select name="route_id" id="route_id" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[--color-brand-green] focus:border-transparent">
                        <option value="">Tất cả tuyến</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }}>
                                {{ $route->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-brand-green text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#096b39] transition-colors">
                        Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Schedules Table -->
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        @if($schedules->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-brand-green text-white">
                            <tr>
                                <th class="px-6 py-4 text-left">Tuyến Đường</th>
                                <th class="px-6 py-4 text-left">Giờ Xuất Bến</th>
                                <th class="px-6 py-4 text-left">Giờ Đến Dự Kiến</th>
                                <th class="px-6 py-4 text-left">Loại Xe</th>
                                <th class="px-6 py-4 text-right">Giá Vé</th>
                                <th class="px-6 py-4 text-center">Ghi Chú</th>
                                <th class="px-6 py-4 text-center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($schedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $schedule->route->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $schedule->route->from_location }} → {{ $schedule->route->to_location }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900">{{ $schedule->departure_time }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $schedule->arrival_time }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block bg-[#e8f8ef] text-brand-green text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ $schedule->bus_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-bold text-brand-green">{{ number_format($schedule->price) }}đ</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-600">
                                        {{ $schedule->note ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('routes.show', $schedule->route->slug) }}" class="inline-block bg-brand-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#096b39] transition-colors">
                                            Đặt Vé
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-6 text-center">* Lịch trình có thể thay đổi tùy theo tình hình thực tế. Vui lòng liên hệ để xác nhận trước khi di chuyển.</p>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Không tìm thấy lịch trình</h3>
                <p class="text-gray-600 mb-6">Vui lòng chọn tuyến xe khác hoặc liên hệ với chúng tôi</p>
                <a href="{{ route('routes.index') }}" class="inline-block bg-brand-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#096b39] transition-colors">
                    Xem Tuyến Xe
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-[--color-brand-green] to-[#096b39] text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Cần Hỗ Trợ?</h2>
        <p class="text-xl mb-8 text-gray-100">Liên hệ ngay với chúng tôi để được tư vấn và hỗ trợ đặt vé</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:1900 2879" class="bg-brand-gold text-[#8a6300] px-8 py-4 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Gọi Ngay: 1900 2879
            </a>
            <a href="{{ route('contact') }}" class="bg-white text-brand-green px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Liên Hệ Tư Vấn
            </a>
        </div>
    </div>
</section>
@endsection
