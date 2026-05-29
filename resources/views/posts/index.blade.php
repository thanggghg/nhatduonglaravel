@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#f8fdf9] py-6">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-green">Trang chủ</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">Tin Tức</span>
        </nav>
    </div>
</div>

<!-- Page Header -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Tin Tức & Bài Viết</h1>
        <p class="text-xl text-gray-600">Cập nhật thông tin mới nhất về dịch vụ và khuyến mãi</p>
    </div>
</section>

<!-- Posts List -->
<section class="py-12 bg-[#f8fdf9]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if($posts->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                @if($post->thumbnail)
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                                    </a>
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200"></div>
                                @endif
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        @if($post->category)
                                            <span class="inline-block bg-[#e8f8ef] text-brand-green text-xs font-semibold px-3 py-1 rounded-full">
                                                {{ $post->category->name }}
                                            </span>
                                        @endif
                                        <span class="text-sm text-gray-500">{{ $post->published_at->format('d/m/Y') }}</span>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-brand-green">
                                        <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->summary }}</p>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-brand-green hover:text-[#096b39] font-semibold">
                                        Đọc thêm
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có bài viết</h3>
                        <p class="text-gray-600">Hãy quay lại sau để xem tin tức mới nhất</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Danh Mục</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('posts.index') }}" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-[#f8fdf9] transition-colors {{ !request('category') ? 'bg-[#e8f8ef] text-brand-green font-semibold' : 'text-gray-700' }}">
                                <span>Tất cả</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('posts.index', ['category' => $category->slug]) }}" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-[#f8fdf9] transition-colors {{ request('category') == $category->slug ? 'bg-[#e8f8ef] text-brand-green font-semibold' : 'text-gray-700' }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- CTA Box -->
                <div class="bg-gradient-to-br from-[--color-brand-green] to-[#096b39] rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-3">Cần Đặt Vé?</h3>
                    <p class="mb-4 text-gray-100">Liên hệ ngay để được tư vấn và hỗ trợ đặt vé</p>
                    <a href="{{ route('booking.index') }}" class="block w-full bg-brand-gold text-[#8a6300] text-center py-3 rounded-lg font-semibold hover:bg-[#e19f14] transition-colors">
                        Đặt Vé Ngay
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
