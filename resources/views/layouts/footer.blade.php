<footer class="bg-[#062d1c] text-white mt-auto">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-brand-green rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">ND</span>
                    </div>
                    <span class="text-xl font-bold text-brand-gold">Nhà Xe Nhật Dương</span>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed mb-4">
                    Nhà xe chất lượng cao với hơn 10 năm kinh nghiệm phục vụ khách hàng trên các tuyến đường liên tỉnh.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center hover:bg-brand-gold transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center hover:bg-brand-gold transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0014.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center hover:bg-brand-gold transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-brand-gold mb-4">Liên Kết Nhanh</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">Trang Chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('routes.index') }}" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">Tuyến Đường</a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">Tin Tức</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">Về Chúng Tôi</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">Liên Hệ</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold text-brand-gold mb-4">Thông Tin Liên Hệ</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-brand-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-300 text-sm">123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:0123456789" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">0123 456 789</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:info@nhatduong.com" class="text-gray-300 hover:text-brand-gold transition-colors text-sm">info@nhatduong.com</a>
                    </li>
                </ul>
            </div>

            <!-- Operating Hours -->
            <div>
                <h3 class="text-lg font-semibold text-brand-gold mb-4">Giờ Làm Việc</h3>
                <ul class="space-y-2">
                    <li class="text-gray-300 text-sm flex justify-between">
                        <span>Thứ 2 - Thứ 6:</span>
                        <span class="font-semibold">24/7</span>
                    </li>
                    <li class="text-gray-300 text-sm flex justify-between">
                        <span>Thứ 7:</span>
                        <span class="font-semibold">24/7</span>
                    </li>
                    <li class="text-gray-300 text-sm flex justify-between">
                        <span>Chủ Nhật:</span>
                        <span class="font-semibold">24/7</span>
                    </li>
                </ul>
                <div class="mt-4 p-3 bg-brand-green rounded-lg">
                    <p class="text-sm font-semibold text-white">Hỗ trợ khách hàng 24/7</p>
                    <p class="text-xs text-gray-200 mt-1">Luôn sẵn sàng phục vụ quý khách</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-700">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} Nhà Xe Nhật Dương. All rights reserved.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-brand-gold text-sm transition-colors">Chính Sách Bảo Mật</a>
                    <a href="#" class="text-gray-400 hover:text-brand-gold text-sm transition-colors">Điều Khoản Sử Dụng</a>
                </div>
            </div>
        </div>
    </div>
</footer>
