<header x-data="{ scrolled: false, mobileOpen: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-2' : 'bg-transparent py-4'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}"
                     alt="Nhà Xe Nhật Dương"
                     class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden lg:flex items-center gap-1">
                @foreach([
                    ['Trang Chủ', 'home'],
                    ['Tuyến Đường', 'routes.index'],
                    ['Lịch Trình', 'schedules.index'],
                    ['Tin Tức', 'posts.index'],
                    ['Về Chúng Tôi', 'about'],
                    ['Liên Hệ', 'contact'],
                ] as [$label, $routeName])
                <a href="{{ route($routeName) }}"
                   :class="scrolled ? 'text-forest-deep hover:text-brand-green' : 'text-white/90 hover:text-white'"
                   class="relative px-4 py-2 text-sm font-medium transition-colors duration-200 group {{ request()->routeIs($routeName) || request()->routeIs(rtrim($routeName, '.index') . '.*') ? 'font-semibold' : '' }}">
                    {{ $label }}
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-brand-gold scale-x-0 group-hover:scale-x-100 transition-transform duration-200 origin-left {{ request()->routeIs($routeName) || request()->routeIs(rtrim($routeName, '.index') . '.*') ? 'scale-x-100' : '' }}"></span>
                </a>
                @endforeach
            </nav>

            {{-- Right side --}}
            <div class="hidden lg:flex items-center gap-3">
                <a href="tel:0123456789"
                   :class="scrolled ? 'text-forest-deep' : 'text-white/80'"
                   class="flex items-center gap-2 text-sm font-medium transition-colors hover:text-brand-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    0123 456 789
                </a>
                <a href="{{ route('booking.index') }}"
                   class="inline-flex items-center gap-2 bg-brand-gold text-gold-text font-bold px-5 py-2.5 rounded-full text-sm hover:bg-gold-hover transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    Đặt Vé Ngay
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Mobile toggle --}}
            <button @click="mobileOpen = !mobileOpen"
                    :class="scrolled ? 'text-forest-deep' : 'text-white'"
                    class="lg:hidden p-2 transition-colors">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-white border-t border-gray-100 shadow-xl">
        <div class="container mx-auto px-6 py-4 flex flex-col gap-1">
            @foreach([
                ['Trang Chủ', 'home'],
                ['Tuyến Đường', 'routes.index'],
                ['Lịch Trình', 'schedules.index'],
                ['Tin Tức', 'posts.index'],
                ['Về Chúng Tôi', 'about'],
                ['Liên Hệ', 'contact'],
            ] as [$label, $routeName])
            <a href="{{ route($routeName) }}"
               class="block py-3 px-4 text-forest-deep font-medium rounded-lg hover:bg-soft-green-background hover:text-brand-green transition-colors {{ request()->routeIs($routeName) ? 'bg-soft-green-background text-brand-green' : '' }}">
                {{ $label }}
            </a>
            @endforeach
            <div class="pt-3 mt-2 border-t border-gray-100 flex flex-col gap-2">
                <a href="tel:0123456789" class="flex items-center gap-2 py-2 px-4 text-brand-green font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Hotline: 0123 456 789
                </a>
                <a href="{{ route('booking.index') }}" class="flex items-center justify-center gap-2 bg-brand-gold text-gold-text font-bold py-3 rounded-xl text-sm">
                    Đặt Vé Ngay
                </a>
            </div>
        </div>
    </div>
</header>
