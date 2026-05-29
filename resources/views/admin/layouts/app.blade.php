<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-subtle-ash">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-[256px] bg-forest-deep text-canvas-white flex flex-col fixed h-full overflow-y-auto">
            <div class="p-24 border-b border-deep-green-accent">
                <h1 class="text-heading font-bold text-brand-green">Nhật Dương</h1>
                <p class="text-caption text-soft-green mt-4">Admin Panel</p>
            </div>

            <nav class="flex-1 py-16">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.dashboard') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <!-- Divider -->
                <div class="px-24 py-8">
                    <p class="text-caption text-hint-gray uppercase tracking-wider">Nội dung</p>
                </div>

                <a href="{{ route('admin.routes.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.routes.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Tuyến xe
                </a>

                <a href="{{ route('admin.schedules.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.schedules.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lịch trình
                </a>

                <a href="{{ route('admin.banners.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.banners.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Banners
                </a>

                <a href="{{ route('admin.posts.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.posts.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Bài viết
                </a>

                <a href="{{ route('admin.post-categories.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.post-categories.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Danh mục
                </a>

                <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.faqs.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    FAQ
                </a>

                <a href="{{ route('admin.pages.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.pages.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Trang tĩnh
                </a>

                <!-- Divider -->
                <div class="px-24 py-8 mt-8">
                    <p class="text-caption text-hint-gray uppercase tracking-wider">Hệ thống</p>
                </div>

                <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.contacts.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Liên hệ
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-24 py-12 text-body-sm {{ request()->routeIs('admin.settings.*') ? 'bg-brand-green text-canvas-white' : 'text-soft-green hover:bg-deep-green-accent' }}">
                    <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Cài đặt
                </a>

                <!-- View site -->
                <div class="px-24 py-8 mt-8">
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center text-body-sm text-hint-gray hover:text-soft-green">
                        <svg class="w-18 h-18 mr-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Xem website
                    </a>
                </div>
            </nav>

            <!-- User info -->
            <div class="p-24 border-t border-deep-green-accent">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-body-sm font-medium text-canvas-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-caption text-soft-green truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="ml-8">
                        @csrf
                        <button type="submit" title="Đăng xuất" class="text-soft-green hover:text-canvas-white flex-shrink-0">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-[256px]">
            <!-- Header -->
            <header class="bg-canvas-white shadow-sm sticky top-0 z-10">
                <div class="px-32 py-20 flex items-center justify-between">
                    <h2 class="text-heading font-semibold text-forest-deep">@yield('page-title', 'Dashboard')</h2>
                    <a href="{{ url('/') }}" target="_blank" class="text-body-sm text-muted-gray hover:text-brand-green flex items-center gap-8">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Xem website
                    </a>
                </div>
            </header>

            <!-- Content -->
            <main class="p-32">
                @if (session('success'))
                    <div class="bg-soft-green-background border border-brand-green text-success-green-text px-16 py-12 rounded-md mb-24 flex items-center gap-12">
                        <svg class="w-20 h-20 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-16 py-12 rounded-md mb-24 flex items-center gap-12">
                        <svg class="w-20 h-20 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
