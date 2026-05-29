@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">{{ $page->title }}</span>
        </nav>
    </div>
</div>

<!-- Page Content -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8">{{ $page->title }}</h1>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="prose prose-lg max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-[#f8fdf9]">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Bạn Cần Hỗ Trợ?</h2>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Liên hệ với chúng tôi để được tư vấn và hỗ trợ</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:0123456789" class="bg-brand-green text-white px-8 py-4 rounded-lg font-semibold hover:bg-[#096b39] transition-colors inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Gọi: 0123 456 789
            </a>
            <a href="{{ route('contact') }}" class="border-2 border-brand-green text-brand-green px-8 py-4 rounded-lg font-semibold hover:bg-brand-green hover:text-white transition-colors">
                Gửi Tin Nhắn
            </a>
        </div>
    </div>
</section>
@endsection
