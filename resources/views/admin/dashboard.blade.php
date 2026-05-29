@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
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
