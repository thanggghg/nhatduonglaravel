<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <!-- Top Bar -->
        <div class="flex items-center justify-between py-3 border-b border-gray-100">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-brand-green rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">ND</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-brand-green">Nhà Xe Nhật Dương</span>
                    <span class="text-xs text-gray-500">An Toàn - Tin Cậy - Tiện Nghi</span>
                </div>
            </a>

            <!-- Contact Info (Desktop) -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="tel:0123456789" class="flex items-center gap-2 text-gray-700 hover:text-brand-green transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-semibold">Hotline: 0123 456 789</span>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="lg:hidden p-2 text-gray-700 hover:text-brand-green">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="hidden lg:block py-4">
            <ul class="flex items-center justify-center gap-8">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-green' : '' }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('routes.index') }}" class="text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('routes.*') ? 'text-brand-green' : '' }}">
                        Tuyến Đường
                    </a>
                </li>
                <li>
                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('posts.*') ? 'text-brand-green' : '' }}">
                        Tin Tức
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('about') ? 'text-brand-green' : '' }}">
                        Về Chúng Tôi
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('contact') ? 'text-brand-green' : '' }}">
                        Liên Hệ
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Mobile Navigation -->
        <nav id="mobile-menu" class="hidden lg:hidden py-4 border-t border-gray-100">
            <ul class="flex flex-col gap-3">
                <li>
                    <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-green' : '' }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('routes.index') }}" class="block py-2 text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('routes.*') ? 'text-brand-green' : '' }}">
                        Tuyến Đường
                    </a>
                </li>
                <li>
                    <a href="{{ route('posts.index') }}" class="block py-2 text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('posts.*') ? 'text-brand-green' : '' }}">
                        Tin Tức
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('about') ? 'text-brand-green' : '' }}">
                        Về Chúng Tôi
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-brand-green font-medium transition-colors {{ request()->routeIs('contact') ? 'text-brand-green' : '' }}">
                        Liên Hệ
                    </a>
                </li>
                <li class="pt-3 border-t border-gray-100">
                    <a href="tel:0123456789" class="flex items-center gap-2 py-2 text-brand-green font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>Hotline: 0123 456 789</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
