@extends('layouts.app')

@push('styles')
<style>
  /* Hero parallax & clip */
  .hero-clip { clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%); }
  @media (max-width: 768px) { .hero-clip { clip-path: polygon(0 0, 100% 0, 100% 94%, 0 100%); } }

  /* Floating card animation */
  @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
  .float-card { animation: float 4s ease-in-out infinite; }
  .float-card-delay { animation: float 4s ease-in-out 1.5s infinite; }

  /* Route card hover */
  .route-card { transition: transform 0.35s cubic-bezier(.22,.68,0,1.2), box-shadow 0.35s ease; }
  .route-card:hover { transform: translateY(-6px) scale(1.01); }

  /* Diagonal section divider */
  .diagonal-top { clip-path: polygon(0 6%, 100% 0, 100% 100%, 0 100%); margin-top: -40px; padding-top: 80px; }
  .diagonal-bottom { clip-path: polygon(0 0, 100% 0, 100% 94%, 0 100%); padding-bottom: 80px; }

  /* Ticker */
  @keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
  .ticker-inner { animation: ticker 25s linear infinite; width: max-content; }
  .ticker-inner:hover { animation-play-state: paused; }

  /* Testimonial card */
  .testimonial-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .testimonial-card:hover { transform: translateY(-4px); }

  /* Pulse ring */
  @keyframes pulse-ring { 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.6);opacity:0} }
  .pulse-ring::before {
    content:''; position:absolute; inset:0; border-radius:50%;
    border: 2px solid #fbb116;
    animation: pulse-ring 2s ease-out infinite;
  }

  /* Number counter shimmer */
  .stat-number { background: linear-gradient(90deg, #fff 0%, #fbb116 50%, #fff 100%);
    background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    animation: shimmer 3s linear infinite; }
  @keyframes shimmer { to { background-position: 200% center; } }
</style>
@endpush

@section('content')

{{-- ============================================================
     HERO — Full-bleed cinematic banner with diagonal cut
     ============================================================ --}}
<section class="relative min-h-screen hero-clip overflow-hidden">

  {{-- Background image --}}
  <div class="absolute inset-0">
    <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}"
         alt="Nhà Xe Nhật Dương"
         class="w-full h-full object-cover object-center scale-105"
         style="transform-origin: center; animation: subtle-zoom 20s ease-in-out infinite alternate;">
    {{-- Multi-layer gradient for depth --}}
    <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(6,45,28,0.95) 0%, rgba(6,45,28,0.75) 40%, rgba(6,45,28,0.3) 70%, rgba(251,177,22,0.15) 100%)"></div>
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at 20% 50%, rgba(11,127,66,0.3) 0%, transparent 60%)"></div>
  </div>

  {{-- Decorative geometric shapes --}}
  <div class="absolute top-1/4 right-1/4 w-96 h-96 rounded-full opacity-5" style="background: radial-gradient(circle, #fbb116, transparent); filter: blur(60px);"></div>
  <div class="absolute bottom-1/3 right-1/3 w-64 h-64 rounded-full opacity-10" style="background: radial-gradient(circle, #0b7f42, transparent); filter: blur(40px);"></div>

  {{-- Diagonal line accents --}}
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-0 right-0 w-px h-full opacity-10" style="background: linear-gradient(to bottom, transparent, #fbb116, transparent); transform: translateX(-200px) rotate(15deg) scaleY(1.5);"></div>
    <div class="absolute top-0 right-0 w-px h-full opacity-5" style="background: linear-gradient(to bottom, transparent, #fff, transparent); transform: translateX(-350px) rotate(15deg) scaleY(1.5);"></div>
  </div>

  {{-- Main content --}}
  <div class="relative container mx-auto px-6 pt-40 pb-32 md:pt-48 md:pb-40 flex flex-col lg:flex-row items-center gap-16">

    {{-- Left: Text content --}}
    <div class="flex-1 max-w-2xl">
      {{-- Badge --}}
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-8">
        <span class="w-2 h-2 bg-brand-gold rounded-full relative pulse-ring"></span>
        <span class="text-white/90 text-xs font-semibold tracking-widest uppercase">Nhà Xe Nhật Dương — Uy Tín Hơn 10 Năm</span>
      </div>

      @php $heroPost = $banners->first() ?? null; @endphp

      <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-[1.05] tracking-tight mb-6">
        @if($heroPost)
          {!! nl2br(e($heroPost->title)) !!}
        @else
          Hành Trình<br>
          <span class="relative inline-block">
            <span class="text-brand-gold">Trọn Vẹn</span>
            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 8" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 6 Q50 2 100 5 Q150 8 198 4" stroke="#fbb116" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.6"/>
            </svg>
          </span>
          <br>Mỗi Chuyến Đi
        @endif
      </h1>

      <p class="text-white/65 text-lg leading-relaxed mb-10 max-w-lg">
        @if($heroPost && $heroPost->subtitle)
          {{ $heroPost->subtitle }}
        @else
          Đặt vé xe khách trực tuyến — Nhanh chóng, an toàn, tiện lợi. Phục vụ hàng chục nghìn lượt khách mỗi năm.
        @endif
      </p>

      {{-- CTA buttons --}}
      <div class="flex flex-wrap gap-4 mb-12">
        <a href="{{ route('booking.index') }}"
           class="group inline-flex items-center gap-3 bg-brand-gold text-gold-text font-bold px-8 py-4 rounded-2xl hover:bg-gold-hover transition-all duration-300 text-sm shadow-2xl hover:shadow-brand-gold/30 hover:-translate-y-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          Đặt Vé Ngay
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
        <a href="{{ route('routes.index') }}"
           class="inline-flex items-center gap-2 border-2 border-white/30 text-white font-semibold px-8 py-4 rounded-2xl hover:bg-white/10 hover:border-white/50 transition-all duration-300 text-sm backdrop-blur-sm">
          Xem Tuyến Xe
        </a>
      </div>

      {{-- Trust indicators --}}
      <div class="flex items-center gap-6">
        <div class="flex -space-x-2">
          @foreach(['N','T','L','M'] as $initial)
          <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-green to-deep-green-accent border-2 border-white flex items-center justify-center text-white text-xs font-bold">{{ $initial }}</div>
          @endforeach
        </div>
        <div>
          <div class="flex gap-0.5 mb-0.5">
            @for($s=0;$s<5;$s++)
            <svg class="w-3.5 h-3.5 text-brand-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <p class="text-white/60 text-xs">50,000+ khách hàng tin tưởng</p>
        </div>
      </div>
    </div>

    {{-- Right: Floating info cards --}}
    <div class="hidden lg:flex flex-col gap-4 w-72 shrink-0">
      {{-- Card 1: Next departure --}}
      <div class="float-card bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 bg-brand-gold/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <p class="text-white/50 text-xs">Chuyến tiếp theo</p>
            <p class="text-white font-bold text-sm">Sài Gòn → Đà Lạt</p>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-brand-gold font-bold text-2xl">07:00</span>
          <span class="bg-brand-green/30 text-white text-xs font-semibold px-3 py-1 rounded-full">Còn chỗ</span>
        </div>
      </div>

      {{-- Card 2: Promo --}}
      <div class="float-card-delay bg-brand-gold rounded-2xl p-5">
        <p class="text-gold-text/70 text-xs font-semibold uppercase tracking-wider mb-1">Ưu đãi hôm nay</p>
        <p class="text-gold-text font-bold text-xl mb-2">Giảm 20%</p>
        <p class="text-gold-text/70 text-xs">Đặt vé online — Áp dụng tất cả tuyến</p>
        <div class="mt-3 h-1 bg-gold-text/20 rounded-full overflow-hidden">
          <div class="h-full bg-gold-text/60 rounded-full" style="width: 65%"></div>
        </div>
        <p class="text-gold-text/60 text-xs mt-1">65% vé đã được đặt</p>
      </div>

      {{-- Card 3: Rating --}}
      <div class="float-card bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5">
        <div class="flex items-center gap-2 mb-2">
          @for($s=0;$s<5;$s++)
          <svg class="w-4 h-4 text-brand-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          @endfor
          <span class="text-white font-bold">4.9</span>
        </div>
        <p class="text-white/60 text-xs">"Dịch vụ tuyệt vời, xe sạch sẽ và đúng giờ!"</p>
        <p class="text-white/40 text-xs mt-2">— Nguyễn Văn An, TP.HCM</p>
      </div>
    </div>
  </div>

  {{-- Stats bar at bottom --}}
  <div class="absolute bottom-0 left-0 right-0">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-white/10 rounded-t-2xl overflow-hidden backdrop-blur-sm">
        @foreach([
          ['10+', 'Năm kinh nghiệm', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['50K+', 'Lượt khách', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
          ['4', 'Tuyến đường', 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
          ['24/7', 'Hỗ trợ khách', 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'],
        ] as [$num, $label, $icon])
        <div class="bg-forest-deep/80 px-6 py-5 flex items-center gap-4">
          <svg class="w-7 h-7 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
          </svg>
          <div>
            <div class="text-2xl font-bold text-white">{{ $num }}</div>
            <div class="text-xs text-white/50">{{ $label }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
@keyframes subtle-zoom { from{transform:scale(1.05)} to{transform:scale(1.12)} }
</style>

{{-- ============================================================
     TICKER — Animated route marquee
     ============================================================ --}}
<div class="bg-forest-deep overflow-hidden py-3.5 border-y border-white/5">
  <div class="ticker-inner flex gap-16 whitespace-nowrap">
    @foreach(array_fill(0,4,['Sài Gòn → Đà Lạt','Sài Gòn → Nha Trang','Sài Gòn → Vũng Tàu','Sài Gòn → Phan Thiết','Giường Nằm VIP','Limousine Cao Cấp','Đặt Vé Online','Hỗ Trợ 24/7']) as $items)
    @foreach($items as $item)
    <span class="text-white/50 text-sm font-medium inline-flex items-center gap-2">
      <span class="text-brand-gold text-xs">◆</span>{{ $item }}
    </span>
    @endforeach
    @endforeach
  </div>
</div>

{{-- ============================================================
     ROUTES — Asymmetric masonry-style grid
     ============================================================ --}}
<section class="py-24 bg-canvas-white relative overflow-hidden">
  {{-- Background decoration --}}
  <div class="absolute top-0 right-0 w-96 h-96 opacity-5 rounded-full" style="background: radial-gradient(circle, #0b7f42, transparent); filter: blur(80px); transform: translate(30%, -30%);"></div>

  <div class="container mx-auto px-6">
    {{-- Section header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
      <div>
        <div class="flex items-center gap-3 mb-3">
          <div class="w-8 h-8 bg-brand-green rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
          </div>
          <span class="text-brand-green text-xs font-bold uppercase tracking-widest">Tuyến đường</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-forest-deep leading-tight">
          Tuyến Xe<br><span class="text-brand-green">Nổi Bật</span>
        </h2>
      </div>
      <a href="{{ route('routes.index') }}"
         class="group inline-flex items-center gap-2 text-sm text-brand-green font-semibold border-b-2 border-brand-green/30 pb-1 hover:border-brand-green transition-colors">
        Xem tất cả tuyến
        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </a>
    </div>

    {{-- Stable asymmetric grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
      @forelse($featuredRoutes as $i => $route)
        @php
          $cardClass = $i === 0
            ? 'lg:col-span-7 lg:row-span-2 h-80 lg:h-auto rounded-3xl'
            : 'lg:col-span-5 h-56 rounded-2xl';
          if ($i > 2) {
            $cardClass = 'lg:col-span-6 h-56 rounded-2xl';
          }
        @endphp

        <a href="{{ route('routes.show', $route->slug) }}"
           class="route-card {{ $cardClass }} relative overflow-hidden bg-forest-deep group block min-h-[224px]">
          @if($route->image)
            <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-65 group-hover:scale-105 transition-transform duration-700">
          @else
            <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="{{ $route->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-45 group-hover:scale-105 transition-transform duration-700">
          @endif

          <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(6,45,28,0.95) 0%, rgba(6,45,28,0.45) 55%, rgba(6,45,28,0.05) 100%)"></div>

          @if($i === 0)
          <div class="absolute top-5 left-5">
            <span class="bg-brand-gold text-gold-text text-xs font-bold px-3 py-1.5 rounded-full">Phổ biến nhất</span>
          </div>
          @endif

          <div class="absolute bottom-0 left-0 right-0 p-5 md:p-7">
            <p class="text-white/60 text-xs mb-2 flex items-center gap-2 line-clamp-1">
              <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              {{ $route->from_location }} → {{ $route->to_location }}
            </p>

            <h3 class="text-white font-bold {{ $i === 0 ? 'text-2xl md:text-3xl' : 'text-lg md:text-xl' }} mb-3 group-hover:text-brand-gold transition-colors line-clamp-2">
              {{ $route->name }}
            </h3>

            <div class="flex items-end justify-between gap-4">
              <div class="min-w-0">
                @if($route->estimated_time)
                <p class="text-white/50 text-xs flex items-center gap-1">
                  <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  {{ $route->estimated_time }}
                </p>
                @endif
              </div>

              <div class="flex items-center gap-3 shrink-0">
                <div class="text-right">
                  <p class="text-white/50 text-xs">Từ</p>
                  <p class="text-brand-gold font-bold {{ $i === 0 ? 'text-2xl' : 'text-lg' }}">{{ number_format($route->price_from) }}đ</p>
                </div>
                <span class="hidden sm:flex w-10 h-10 bg-brand-green rounded-xl items-center justify-center group-hover:bg-green-hover transition-colors">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                  </svg>
                </span>
              </div>
            </div>
          </div>
        </a>
      @empty
      <div class="lg:col-span-12 text-center text-muted-gray py-16">
        <svg class="w-12 h-12 mx-auto mb-3 text-input-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        Chưa có tuyến đường nào
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- ============================================================
     SCHEDULES — Timeline-style layout
     ============================================================ --}}
@if($popularSchedules->isNotEmpty())
<section class="py-24 relative overflow-hidden bg-ghost-fog">
  {{-- Decorative circles --}}
  <div class="absolute top-0 left-0 w-80 h-80 rounded-full opacity-30" style="background: radial-gradient(circle, #e8f8ef, transparent); filter: blur(60px); transform: translate(-30%, -30%);"></div>
  <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full opacity-40" style="background: radial-gradient(circle, #fef3d7, transparent); filter: blur(80px); transform: translate(30%, 30%);"></div>

  <div class="relative container mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">

      {{-- Left: refined schedule intro --}}
      <div class="lg:col-span-2">
        <div class="relative overflow-hidden rounded-3xl border border-input-border bg-canvas-white p-8 md:p-10 shadow-xl shadow-brand-green/5">
          <div class="absolute -top-20 -right-20 w-48 h-48 rounded-full bg-light-gold blur-3xl opacity-70"></div>
          <div class="absolute -bottom-24 -left-20 w-56 h-56 rounded-full bg-soft-green-background blur-3xl opacity-80"></div>

          <div class="relative">
            <div class="inline-flex items-center gap-2 rounded-full border border-brand-green/20 bg-soft-green-background px-4 py-2 mb-7">
              <span class="relative flex h-2.5 w-2.5">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-green opacity-30"></span>
                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-green"></span>
              </span>
              <span class="text-brand-green text-xs font-bold uppercase tracking-widest">Lịch trình hôm nay</span>
            </div>

            <h2 class="text-4xl md:text-5xl font-bold text-forest-deep leading-tight tracking-tight mb-5">
              Chọn giờ<br>
              <span class="relative inline-block text-brand-green">
                khởi hành
                <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 180 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 6 C42 1 86 8 128 4 C150 2 166 3 178 2" stroke="#0b7f42" stroke-width="2.5" stroke-linecap="round" opacity="0.35"/>
                </svg>
              </span>
              <br>phù hợp
            </h2>

            <p class="text-muted-gray text-sm leading-7 mb-8 max-w-sm">
              Các chuyến được cập nhật theo ngày, ưu tiên giờ xuất bến ổn định, thông tin rõ ràng và dễ đặt vé.
            </p>

            <div class="grid grid-cols-2 gap-3 mb-8">
              <div class="rounded-2xl border border-input-border bg-ghost-fog p-4">
                <div class="text-2xl font-bold text-forest-deep">{{ $popularSchedules->count() }}+</div>
                <div class="text-muted-gray text-xs mt-1">Chuyến đang mở</div>
              </div>
              <div class="rounded-2xl border border-input-border bg-light-gold p-4">
                <div class="text-2xl font-bold text-gold-text">24/7</div>
                <div class="text-gold-text/70 text-xs mt-1">Hỗ trợ đặt vé</div>
              </div>
            </div>

            <a href="{{ route('schedules.index') }}"
               class="group inline-flex items-center gap-3 bg-brand-green text-white font-bold px-6 py-3.5 rounded-2xl hover:bg-green-hover transition-all duration-300 text-sm shadow-lg shadow-brand-green/20">
              Xem toàn bộ lịch trình
              <span class="w-7 h-7 rounded-full bg-white/15 text-white flex items-center justify-center group-hover:bg-white/25 transition-colors">
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </a>
          </div>
        </div>
      </div>

      {{-- Right: schedule list --}}
      <div class="lg:col-span-3 space-y-3">
        @foreach($popularSchedules->take(6) as $idx => $schedule)
        <div class="group relative bg-canvas-white hover:bg-white border border-input-border hover:border-brand-green/30 rounded-2xl p-4 flex items-center gap-4 transition-all duration-300 cursor-pointer shadow-sm hover:shadow-lg hover:shadow-brand-green/5">
          {{-- Time badge --}}
          <div class="w-16 h-16 bg-soft-green-background border border-brand-green/10 rounded-xl flex flex-col items-center justify-center shrink-0 group-hover:bg-light-gold group-hover:border-brand-gold/20 transition-colors">
            <span class="text-brand-green group-hover:text-gold-text font-bold text-lg leading-none transition-colors">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</span>
            <span class="text-muted-gray text-xs mt-0.5">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('A') }}</span>
          </div>

          {{-- Route info --}}
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-forest-deep text-sm truncate">{{ $schedule->route->name }}</p>
            <div class="flex items-center gap-3 mt-1">
              <span class="text-muted-gray text-xs">{{ $schedule->bus_type ?? 'Xe khách' }}</span>
              @if($schedule->available_seats ?? null)
              <span class="text-xs text-brand-green/80">{{ $schedule->available_seats }} chỗ còn</span>
              @endif
            </div>
          </div>

          {{-- Price & CTA --}}
          <div class="text-right shrink-0">
            <p class="font-bold text-forest-deep text-lg">{{ number_format($schedule->price) }}đ</p>
            <a href="{{ route('routes.show', $schedule->route->slug) }}"
               class="text-xs text-brand-green font-semibold hover:text-green-hover transition-colors">
              Đặt vé →
            </a>
          </div>

          {{-- Hover indicator --}}
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-green rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

{{-- ============================================================
     WHY US — Split layout with visual stats
     ============================================================ --}}
<section class="py-24 bg-canvas-white overflow-hidden">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

      {{-- Left: content --}}
      <div>
        <div class="flex items-center gap-3 mb-4">
          <div class="w-8 h-8 bg-brand-green rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </div>
          <span class="text-brand-green text-xs font-bold uppercase tracking-widest">Cam kết của chúng tôi</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-forest-deep mb-5 leading-tight">
          Vì Sao Hàng Ngàn<br>Khách Hàng<br><span class="text-brand-green">Tin Tưởng?</span>
        </h2>
        <p class="text-muted-gray leading-relaxed mb-10 text-base">
          Nhà Xe Nhật Dương tự hào là đơn vị vận tải hành khách uy tín với hơn 10 năm kinh nghiệm, phục vụ hàng chục nghìn lượt khách mỗi năm trên các tuyến đường trọng điểm.
        </p>

        <div class="space-y-6">
          @foreach([
            ['An Toàn Tuyệt Đối', 'Xe được kiểm định định kỳ, tài xế có bằng lái chuyên nghiệp và kinh nghiệm nhiều năm.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', '#0b7f42'],
            ['Đúng Giờ Cam Kết', 'Xuất bến đúng lịch, không để khách hàng chờ đợi. Thông báo kịp thời khi có thay đổi.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', '#fbb116'],
            ['Tiện Nghi Cao Cấp', 'Xe giường nằm VIP, điều hòa mát lạnh, wifi miễn phí, nước uống và chăn gối sạch sẽ.', 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', '#062d1c'],
          ] as [$title, $desc, $icon, $color])
          <div class="flex gap-5 group">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110"
                 style="background-color: {{ $color }}15; border: 1px solid {{ $color }}30">
              <svg class="w-5 h-5" fill="none" stroke="{{ $color }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-forest-deep mb-1">{{ $title }}</h4>
              <p class="text-muted-gray text-sm leading-relaxed">{{ $desc }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Right: visual stats --}}
      <div class="relative">
        {{-- Background image --}}
        <div class="relative rounded-3xl overflow-hidden h-80 mb-5">
          <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt=""
               class="w-full h-full object-cover">
          <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(6,45,28,0.7) 0%, rgba(6,45,28,0.3) 100%)"></div>
          {{-- Overlay stats --}}
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="grid grid-cols-2 gap-4 p-6 w-full">
              @foreach([
                ['10+', 'Năm kinh nghiệm', 'bg-white/10'],
                ['50K+', 'Lượt khách/năm', 'bg-brand-gold/20'],
                ['99%', 'Khách hài lòng', 'bg-brand-green/20'],
                ['4', 'Tuyến đường', 'bg-white/10'],
              ] as [$num, $label, $bg])
              <div class="backdrop-blur-sm {{ $bg }} border border-white/20 rounded-2xl p-4 text-center">
                <div class="text-3xl font-bold text-white mb-1">{{ $num }}</div>
                <div class="text-white/60 text-xs">{{ $label }}</div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        {{-- Bottom CTA card --}}
        <div class="bg-forest-deep rounded-2xl p-6 flex items-center justify-between gap-4">
          <div>
            <p class="text-white/60 text-xs mb-1">Sẵn sàng trải nghiệm?</p>
            <p class="text-white font-bold">Đặt vé ngay hôm nay</p>
          </div>
          <a href="{{ route('booking.index') }}"
             class="shrink-0 inline-flex items-center gap-2 bg-brand-gold text-gold-text font-bold px-5 py-2.5 rounded-xl hover:bg-gold-hover transition-colors text-sm">
            Đặt Vé
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     PROMO BANNER — Immersive full-width with texture
     ============================================================ --}}
<section class="relative overflow-hidden py-20">
  <div class="absolute inset-0 bg-brand-gold"></div>
  {{-- Diagonal stripes texture --}}
  <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 1px, transparent 0, transparent 50%); background-size: 12px 12px;"></div>
  {{-- Glow effects --}}
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

{{-- ============================================================
     NEWS — Magazine-style editorial layout
     ============================================================ --}}
@if($latestPosts->isNotEmpty())
<section class="py-24 bg-subtle-ash">
  <div class="container mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
      <div>
        <div class="flex items-center gap-3 mb-3">
          <div class="w-8 h-8 bg-brand-green rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
          </div>
          <span class="text-brand-green text-xs font-bold uppercase tracking-widest">Blog</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-forest-deep leading-tight">
          Tin Tức &<br><span class="text-brand-green">Khuyến Mãi</span>
        </h2>
      </div>
      <a href="{{ route('posts.index') }}"
         class="group inline-flex items-center gap-2 text-sm text-brand-green font-semibold border-b-2 border-brand-green/30 pb-1 hover:border-brand-green transition-colors">
        Tất cả bài viết
        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </a>
    </div>

    @php $firstPost = $latestPosts->first(); $otherPosts = $latestPosts->skip(1); @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- Featured post --}}
      <a href="{{ route('posts.show', $firstPost->slug) }}"
         class="group lg:col-span-7 relative rounded-3xl overflow-hidden bg-forest-deep block"
         style="min-height: 420px;">
        @if($firstPost->thumbnail)
          <img src="{{ asset('storage/' . $firstPost->thumbnail) }}" alt="{{ $firstPost->title }}"
               class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
        @else
          <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt=""
               class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-700">
        @endif
        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(6,45,28,0.97) 0%, rgba(6,45,28,0.5) 50%, rgba(6,45,28,0.1) 100%)"></div>

        {{-- Top: category --}}
        <div class="absolute top-6 left-6">
          @if($firstPost->category)
          <span class="inline-block bg-brand-gold text-gold-text text-xs font-bold px-3 py-1.5 rounded-full">{{ $firstPost->category->name }}</span>
          @endif
        </div>

        {{-- Bottom: content --}}
        <div class="absolute bottom-0 left-0 right-0 p-8">
          <h3 class="text-white font-bold text-2xl md:text-3xl leading-snug line-clamp-2 group-hover:text-brand-gold transition-colors mb-3">{{ $firstPost->title }}</h3>
          @if($firstPost->excerpt)
          <p class="text-white/50 text-sm line-clamp-2 mb-4">{{ $firstPost->excerpt }}</p>
          @endif
          <div class="flex items-center justify-between">
            <p class="text-white/40 text-xs">{{ $firstPost->published_at->format('d/m/Y') }}</p>
            <span class="inline-flex items-center gap-1 text-brand-gold text-xs font-semibold group-hover:gap-2 transition-all">
              Đọc thêm
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </span>
          </div>
        </div>
      </a>

      {{-- Other posts --}}
      <div class="lg:col-span-5 flex flex-col gap-4">
        @foreach($otherPosts->take(3) as $post)
        <a href="{{ route('posts.show', $post->slug) }}"
           class="group bg-canvas-white rounded-2xl overflow-hidden flex gap-0 hover:shadow-lg transition-all duration-300 border border-input-border hover:border-brand-green/20">
          {{-- Thumbnail --}}
          <div class="w-28 h-28 shrink-0 overflow-hidden bg-subtle-ash">
            @if($post->thumbnail)
              <img src="{{ asset('storage/' . $post->thumbnail) }}" alt=""
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
              <div class="w-full h-full bg-soft-green-background flex items-center justify-center">
                <svg class="w-8 h-8 text-brand-green/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
              </div>
            @endif
          </div>
          {{-- Content --}}
          <div class="flex-1 p-4 min-w-0">
            @if($post->category)
            <span class="text-brand-green text-xs font-bold uppercase tracking-wide">{{ $post->category->name }}</span>
            @endif
            <h4 class="font-bold text-forest-deep text-sm leading-snug mt-1 line-clamp-2 group-hover:text-brand-green transition-colors">{{ $post->title }}</h4>
            <p class="text-muted-gray text-xs mt-2">{{ $post->published_at->format('d/m/Y') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

{{-- ============================================================
     TESTIMONIALS — Elegant cards
     ============================================================ --}}
<section class="py-24 bg-canvas-white relative overflow-hidden">
  <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-input-border to-transparent"></div>
  <div class="container mx-auto px-6">
    <div class="text-center mb-14">
      <div class="inline-flex items-center gap-2 bg-soft-green-background text-brand-green text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L3.077 10.1c-.783-.57-.38-1.81.588-1.81H8.58a1 1 0 00.95-.69l1.519-4.674z"/></svg>
        Đánh giá
      </div>
      <h2 class="text-4xl md:text-5xl font-bold text-forest-deep">Khách Hàng Nói Gì?</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach([
        ['Nguyễn Văn An', 'TP. Hồ Chí Minh', 'Xe sạch sẽ, tài xế thân thiện. Tôi đã đi tuyến Sài Gòn - Đà Lạt nhiều lần và luôn hài lòng với dịch vụ của Nhật Dương.', 5],
        ['Trần Thị Bình', 'Đà Lạt', 'Đặt vé online rất tiện lợi, giá cả hợp lý. Xe đúng giờ, không phải chờ đợi. Sẽ tiếp tục ủng hộ!', 5],
        ['Lê Minh Cường', 'Nha Trang', 'Giường nằm VIP rất thoải mái, ngủ ngon suốt chuyến đi. Nhân viên phục vụ chu đáo, nhiệt tình.', 5],
      ] as [$name, $location, $comment, $stars])
      <div class="testimonial-card bg-ghost-fog rounded-3xl p-7 border border-input-border hover:shadow-xl hover:shadow-brand-green/5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative">
          <div class="flex gap-0.5 mb-5">
            @for($i=0; $i<$stars; $i++)
            <svg class="w-4 h-4 text-brand-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <p class="text-slate-text text-sm leading-relaxed mb-6 italic">&ldquo;{{ $comment }}&rdquo;</p>
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br from-brand-green to-deep-green-accent rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
              {{ mb_substr($name, 0, 1) }}
            </div>
            <div>
              <p class="font-bold text-forest-deep text-sm">{{ $name }}</p>
              <p class="text-muted-gray text-xs">{{ $location }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ============================================================
     FAQ — Accordion with side visual
     ============================================================ --}}
@if(isset($faqs) && $faqs->isNotEmpty())
<section class="py-24 bg-ghost-fog">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">
      <div class="lg:sticky lg:top-28">
        <div class="inline-flex items-center gap-2 bg-soft-green-background text-brand-green text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          FAQ
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-forest-deep mb-5 leading-tight">Câu Hỏi<br>Thường Gặp</h2>
        <p class="text-muted-gray leading-relaxed mb-8">Những thắc mắc phổ biến nhất từ khách hàng. Không tìm thấy câu trả lời? Liên hệ ngay với chúng tôi.</p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 border-2 border-brand-green text-brand-green font-semibold px-6 py-3 rounded-xl hover:bg-brand-green hover:text-white transition-colors text-sm">
          Liên Hệ Hỗ Trợ
        </a>
      </div>

      <div class="space-y-3" x-data="{ open: 0 }">
        @foreach($faqs->take(5) as $i => $faq)
        <div class="bg-canvas-white rounded-2xl border border-input-border overflow-hidden hover:shadow-md transition-shadow">
          <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full flex items-center justify-between px-6 py-5 text-left">
            <span class="font-bold text-forest-deep pr-4">{{ $faq->question }}</span>
            <span class="w-8 h-8 rounded-full bg-soft-green-background flex items-center justify-center shrink-0">
              <svg class="w-4 h-4 text-brand-green transition-transform" :class="open === {{ $i }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
            </span>
          </button>
          <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-5">
            <p class="text-muted-gray text-sm leading-relaxed">{{ $faq->answer }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

{{-- ============================================================
     FINAL CTA — Cinematic split using bus image
     ============================================================ --}}
<section class="relative overflow-hidden">
  <div class="absolute inset-0">
    <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(6,45,28,0.97) 0%, rgba(6,45,28,0.85) 45%, rgba(6,45,28,0.55) 100%)"></div>
  </div>

  <div class="relative container mx-auto px-6 py-24 md:py-32">
    <div class="max-w-2xl">
      <span class="inline-flex items-center gap-2 bg-brand-gold/20 text-brand-gold text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-6">
        Đặt vé ngay hôm nay
      </span>
      <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
        Sẵn Sàng Cho<br>Chuyến Đi Tiếp Theo?
      </h2>
      <p class="text-white/60 text-lg leading-relaxed mb-10 max-w-xl">
        Đặt vé trực tuyến nhanh chóng, nhận ưu đãi tốt nhất và đảm bảo chỗ ngồi cho hành trình của bạn.
      </p>
      <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('booking.index') }}"
           class="group inline-flex items-center justify-center gap-3 bg-brand-gold text-gold-text font-bold px-8 py-4 rounded-2xl hover:bg-gold-hover transition-all duration-300 text-sm shadow-2xl hover:-translate-y-1">
          Đặt Vé Ngay
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
        <a href="tel:0123456789"
           class="inline-flex items-center justify-center gap-2 border-2 border-white/20 text-white font-semibold px-8 py-4 rounded-2xl hover:bg-white/10 transition-colors text-sm backdrop-blur-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
          </svg>
          0123 456 789
        </a>
      </div>
    </div>
  </div>
</section>

{{-- Mobile floating actions --}}
<div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40 lg:hidden">
  <a href="tel:0123456789" class="w-12 h-12 bg-brand-green rounded-full flex items-center justify-center shadow-xl hover:bg-green-hover transition-colors">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
  </a>
  <a href="{{ route('booking.index') }}" class="w-12 h-12 bg-brand-gold rounded-full flex items-center justify-center shadow-xl hover:bg-gold-hover transition-colors">
    <svg class="w-5 h-5 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
  </a>
</div>
      </div>
    </div>
    {{-- Right: CTA --}}
    <div class="bg-forest-deep flex items-center px-8 md:px-16 py-16">
      <div class="max-w-md">
        <span class="inline-block bg-brand-gold/20 text-brand-gold text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-5">Đặt vé ngay hôm nay</span>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">Sẵn Sàng Cho Chuyến Đi Tiếp Theo?</h2>
        <p class="text-white/60 text-sm leading-relaxed mb-8">Đặt vé trực tuyến nhanh chóng, nhận ưu đãi tốt nhất và đảm bảo chỗ ngồi cho hành trình của bạn.</p>
        <div class="flex flex-col sm:flex-row gap-3">
          <a href="{{ route('booking.index') }}" class="inline-flex items-center justify-center gap-2 bg-brand-gold text-gold-text font-bold px-7 py-3.5 rounded-lg hover:bg-gold-hover transition-colors text-sm">
            Đặt Vé Ngay
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
          <a href="tel:0123456789" class="inline-flex items-center justify-center gap-2 border border-white/20 text-white font-semibold px-7 py-3.5 rounded-lg hover:bg-white/10 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            0123 456 789
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40 lg:hidden">
  <a href="tel:0123456789" class="w-12 h-12 bg-brand-green rounded-full flex items-center justify-center shadow-xl hover:bg-green-hover transition-colors">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
  </a>
  <a href="{{ route('booking.index') }}" class="w-12 h-12 bg-brand-gold rounded-full flex items-center justify-center shadow-xl hover:bg-gold-hover transition-colors">
    <svg class="w-5 h-5 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
  </a>
</div>

@endsection
