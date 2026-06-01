{{-- PROMO BANNER --}}
<section class="relative overflow-hidden py-20">
  <div class="absolute inset-0 bg-brand-gold"></div>
  <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 1px, transparent 0, transparent 50%); background-size: 12px 12px;"></div>
  <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full opacity-30" style="background: radial-gradient(circle, #fff, transparent); filter: blur(80px);"></div>
  <div class="absolute bottom-0 right-1/4 w-64 h-64 rounded-full opacity-20" style="background: radial-gradient(circle, #fff, transparent); filter: blur(60px);"></div>

  <div class="relative container mx-auto px-6">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
      <div class="text-center lg:text-left">
        <div class="inline-flex items-center gap-2 bg-gold-text/10 border border-gold-text/20 rounded-full px-4 py-1.5 mb-4">
          <span class="w-2 h-2 bg-gold-text rounded-full"></span>
          <span class="text-gold-text text-xs font-bold uppercase tracking-widest">Ưu đãi đặc biệt</span>
        </div>
        <h3 class="text-4xl md:text-5xl font-bold text-gold-text mb-3 leading-tight">
          Giảm <span class="text-forest-deep">20%</span><br>Khi Đặt Vé Online
        </h3>
        <p class="text-gold-text/70 text-base">Áp dụng cho tất cả tuyến xe — Số lượng có hạn!</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 shrink-0">
        <a href="{{ route('booking.index') }}"
           class="group inline-flex items-center justify-center gap-3 bg-forest-deep text-white font-bold px-10 py-5 rounded-2xl hover:bg-deep-green-accent transition-all duration-300 text-base shadow-2xl hover:-translate-y-1">
          Đặt Ngay Kẻo Lỡ
          <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
        <a href="{{ route('routes.index') }}"
           class="inline-flex items-center justify-center gap-2 border-2 border-gold-text/40 text-gold-text font-semibold px-8 py-5 rounded-2xl hover:bg-gold-text/10 transition-colors text-base">
          Xem Tuyến Xe
        </a>
      </div>
    </div>
  </div>
</section>
