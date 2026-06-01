{{-- TUYẾN ĐƯỜNG CỐ ĐỊNH --}}
<section style="background:#f5faf4; padding:72px 0 80px;">
  <div style="width:min(1600px,94%); margin:0 auto; padding:0 16px;">

    {{-- Section head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-bottom:40px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <div style="width:7px; height:7px; border-radius:50%; background:#0b7f42;"></div>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Tuyến đường cố định</span>
        </div>
        <h2 style="margin:0; color:#173014; font-size:clamp(32px,4vw,52px); font-weight:900; line-height:1.05; letter-spacing:-1px;">
          Sài Gòn <span style="color:#0b7f42;">Nha Trang</span>
        </h2>
      </div>
      <a href="{{ route('booking.search', ['route_id' => $featuredRoutes->where('to_location','like','%Nha Trang%')->first()?->id ?? $featuredRoutes->first()?->id, 'departDate' => now()->format('d-m-Y')]) }}"
         style="display:inline-flex; align-items:center; gap:8px; color:#0b7f42; font-size:15px; font-weight:800; text-decoration:none; border-bottom:2px solid rgba(11,127,66,0.30); padding-bottom:3px; transition:all 0.2s; white-space:nowrap;"
         onmouseover="this.style.borderBottomColor='#0b7f42'"
         onmouseout="this.style.borderBottomColor='rgba(11,127,66,0.30)'">
        Đặt vé ngay →
      </a>
    </div>

    {{-- Main layout: card ảnh + panel --}}
    @php $route = $featuredRoutes->where('to_location','like','%Nha Trang%')->first() ?? $featuredRoutes->first(); @endphp
    @if($route)
    <div style="display:grid; grid-template-columns:1fr 380px; gap:24px; align-items:stretch;" class="route-section-grid">

      {{-- LEFT: card ảnh lớn --}}
      <article style="position:relative; border-radius:28px; overflow:hidden; min-height:480px; background:#062d1c;">
        {{-- Ảnh --}}
        <img src="{{ $route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png') }}"
             alt="{{ $route->name }}"
             style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.55; transition:transform 0.8s ease;"
             onmouseover="this.style.transform='scale(1.04)'"
             onmouseout="this.style.transform='scale(1)'">

        {{-- Overlay gradient --}}
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(4,28,17,0.97) 0%, rgba(4,28,17,0.55) 50%, rgba(4,28,17,0.10) 100%);"></div>

        {{-- Shine effect --}}
        <div style="position:absolute; inset:0; background:linear-gradient(135deg, rgba(255,255,255,0.04) 0%, transparent 50%); pointer-events:none;"></div>

        {{-- Badge --}}
        <div style="position:absolute; top:22px; left:22px; display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,0.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.20); border-radius:999px; padding:7px 14px;">
          <span style="color:#fbb116; font-size:13px;">⭐</span>
          <span style="color:#fff; font-size:12px; font-weight:800;">Tuyến duy nhất</span>
        </div>

        {{-- Arrow CTA --}}
        <a href="{{ route('routes.show', $route->slug) }}"
           style="position:absolute; top:22px; right:22px; width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,0.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.20); display:grid; place-items:center; color:#fff; font-size:18px; text-decoration:none; transition:all 0.2s;"
           onmouseover="this.style.background='rgba(251,177,22,0.85)'; this.style.color='#5a3e00'"
           onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#fff'">→</a>

        {{-- Content bottom --}}
        <div style="position:absolute; left:28px; right:28px; bottom:28px; padding:24px; border-radius:20px; background:linear-gradient(90deg, rgba(0,52,16,0.70), rgba(0,52,16,0.25)); border:1px solid rgba(255,255,255,0.14);">
          <div style="color:rgba(255,255,255,0.80); font-size:14px; font-weight:800; margin-bottom:8px;">
            TP. Hồ Chí Minh ↔ Nha Trang
          </div>
          <h3 style="margin:0 0 12px; color:#fff; font-size:clamp(28px,3.5vw,44px); font-weight:900; line-height:1.05; letter-spacing:-0.5px; text-shadow:0 6px 18px rgba(0,0,0,0.35);">
            {{ $route->name }}
          </h3>
          @if($route->description)
          <p style="color:rgba(255,255,255,0.75); font-size:14px; line-height:1.65; font-weight:600; margin:0 0 18px; max-width:560px;">
            {{ Str::limit($route->description, 120) }}
          </p>
          @endif
          <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
            @if($route->estimated_time)
            <div style="display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.90); font-size:14px; font-weight:800;">
              <span style="width:30px; height:30px; border-radius:50%; background:rgba(255,255,255,0.90); display:grid; place-items:center; font-size:14px;">⏱</span>
              {{ $route->estimated_time }}
            </div>
            @endif
            <div style="display:flex; align-items:baseline; gap:5px; color:#fbb116; font-size:32px; font-weight:900; text-shadow:0 4px 12px rgba(0,0,0,0.30);">
              <small style="color:rgba(255,255,255,0.80); font-size:13px; font-weight:800;">Từ</small>
              {{ number_format($route->price_from) }}đ
            </div>
          </div>
        </div>
      </article>

      {{-- RIGHT: info panel --}}
      <aside style="border-radius:28px; padding:32px; background:linear-gradient(180deg,rgba(255,255,255,0.97),rgba(255,255,255,0.90)); border:1px solid rgba(11,127,66,0.14); box-shadow:0 22px 60px rgba(11,127,66,0.12); display:flex; flex-direction:column; gap:0; animation:floatPanel 5s ease-in-out infinite;">

        <h3 style="margin:0 0 8px; color:#0b7f42; font-size:26px; font-weight:900; line-height:1.05;">Thông tin tuyến</h3>
        <p style="margin:0 0 24px; color:#62735e; font-size:14px; line-height:1.7; font-weight:600;">
          Tuyến xe chất lượng cao, phục vụ hành khách đi lại giữa Sài Gòn và Nha Trang với xe giường nằm VIP, đặt vé nhanh và hỗ trợ 24/7.
        </p>

        {{-- Animated route line --}}
        <div style="position:relative; margin-bottom:28px; padding-top:16px;">
          <div style="position:relative; height:6px; border-radius:999px; background:linear-gradient(90deg,#0b7f42,#fbb116,#0b7f42); box-shadow:0 6px 18px rgba(11,127,66,0.18);">
            <div style="position:absolute; top:50%; width:16px; height:16px; border-radius:50%; background:#fbb116; box-shadow:0 0 0 6px rgba(251,177,22,0.20); transform:translateY(-50%); animation:routeDot 3s linear infinite alternate;"></div>
          </div>
          <div style="display:flex; justify-content:space-between; margin-top:12px; color:#0a5d03; font-size:12px; font-weight:900;">
            <span>Sài Gòn</span>
            <span>Nha Trang</span>
          </div>
        </div>

        {{-- Info list --}}
        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:24px; flex:1;">
          @foreach([
            ['📍', 'Sài Gòn ↔ Nha Trang'],
            ['🚌', 'Xe giường nằm VIP chất lượng cao'],
            ['☎', 'Hotline hỗ trợ 24/7'],
            ['🎫', 'Đặt vé một chiều và khứ hồi'],
          ] as [$icon, $text])
          <div style="display:flex; align-items:center; gap:12px; padding:13px 15px; border-radius:14px; background:#eef9ec; border:1px solid rgba(11,127,66,0.12); font-weight:800; color:#173014; font-size:14px; transition:all 0.2s; cursor:default;"
               onmouseover="this.style.transform='translateX(5px)'; this.style.background='#e0f5e0'"
               onmouseout="this.style.transform='translateX(0)'; this.style.background='#eef9ec'">
            <span style="width:32px; height:32px; border-radius:50%; background:#0b7f42; display:grid; place-items:center; font-size:14px; flex-shrink:0;">{{ $icon }}</span>
            {{ $text }}
          </div>
          @endforeach
        </div>

        {{-- CTA --}}
        <a href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => now()->format('d-m-Y')]) }}"
           style="display:flex; align-items:center; justify-content:center; height:54px; border-radius:16px; background:linear-gradient(180deg,#ffdc47,#fbb116); color:#5a3e00; font-size:16px; font-weight:900; text-decoration:none; box-shadow:0 14px 32px rgba(251,177,22,0.26); transition:all 0.25s;"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(251,177,22,0.34)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 14px 32px rgba(251,177,22,0.26)'">
          Đặt vé tuyến này →
        </a>
      </aside>
    </div>
    @endif

  </div>
</section>

<style>
  @keyframes routeDot { from { left: 0; } to { left: calc(100% - 16px); } }
  @keyframes floatPanel { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
  @media (max-width: 900px) {
    .route-section-grid { grid-template-columns: 1fr !important; }
  }
</style>
