@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-brand-green">Tin tức</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">{{ $post->title }}</span>
        </nav>
    </div>
</div>

<!-- Post Content -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <article class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Post Header -->
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-4 mb-6">
                            @if($post->category)
                                <span class="inline-block bg-[#e8f8ef] text-brand-green text-sm font-semibold px-4 py-2 rounded-full">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <time class="text-gray-500">{{ $post->published_at->format('d/m/Y') }}</time>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">{{ $post->title }}</h1>

                        @if($post->summary)
                            <p class="text-xl text-gray-600 mb-8 leading-relaxed">{{ $post->summary }}</p>
                        @endif

                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full rounded-2xl mb-8">
                        @endif

                        <!-- Post Content -->
                        <div class="prose prose-lg max-w-none">
                            {!! $post->content !!}
                        </div>

                        <!-- Tags or Share Buttons (Optional) -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600 font-semibold">Chia sẻ:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="w-10 h-10 bg-[#e8f8ef] rounded-lg flex items-center justify-center hover:bg-brand-green hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                </div>
                                <a href="{{ route('posts.index') }}" class="text-brand-green hover:text-[#096b39] font-semibold">
                                    ← Quay lại tin tức
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Posts -->
                @if($relatedPosts->isNotEmpty())
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Bài Viết Liên Quan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $relatedPost)
                                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    @if($relatedPost->thumbnail)
                                        <a href="{{ route('posts.show', $relatedPost->slug) }}">
                                            <img src="{{ asset('storage/' . $relatedPost->thumbnail) }}" alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                                        </a>
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200"></div>
                                    @endif
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-brand-green">
                                            <a href="{{ route('posts.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $relatedPost->summary }}</p>
                                        <span class="text-xs text-gray-500">{{ $relatedPost->published_at->format('d/m/Y') }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Danh Mục</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('posts.index', ['category' => $category->slug]) }}" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-[#f8fdf9] transition-colors {{ $post->category && $post->category->id == $category->id ? 'bg-[#e8f8ef] text-brand-green font-semibold' : 'text-gray-700' }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- CTA Box -->
                <div class="bg-gradient-to-br from-[--color-brand-green] to-[#096b39] rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-3">Đặt Vé Ngay</h3>
                    <p class="mb-4 text-gray-100">Dịch vụ xe khách chất lượng cao với giá cả hợp lý</p>
                    <a href="{{ route('booking.index') }}" class="block w-full bg-brand-gold text-[#8a6300] text-center py-3 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                        Xem Tuyến Xe
                    </a>
                </div>

                <!-- Contact Box -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Liên Hệ</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:0123456789" class="text-gray-700 hover:text-brand-green font-semibold">0123 456 789</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:info@nhatduong.com" class="text-gray-700 hover:text-brand-green">info@nhatduong.com</a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
