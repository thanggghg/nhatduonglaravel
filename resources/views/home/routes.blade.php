{{-- TUYẾN ĐƯỜNG CỐ ĐỊNH --}}
<section style="background:linear-gradient(180deg,#f6fbf5 0%,#f7fbf6 100%); padding:72px 0 120px; overflow:hidden;">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    @php
      $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
      $routeSectionImage = !empty($settings['home_routes_image'])
          ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings['home_routes_image'])
          : null;
      $reviewAvatars = [
          ['MA', 'linear-gradient(135deg,#f3c9a6,#7d4a2f)'],
          ['TH', 'linear-gradient(135deg,#b7e3c4,#0b7f42)'],
          ['LP', 'linear-gradient(135deg,#ffe09a,#d4a017)'],
          ['QN', 'linear-gradient(135deg,#c8d8ff,#4461c2)'],
          ['VH', 'linear-gradient(135deg,#ffd0d8,#bf4b74)'],
      ];
      $routeChecklistColumns = [
          ['Ghế nằm tiện nghi', 'Điều hòa mát lạnh', 'Wifi miễn phí'],
          ['Ổ sạc USB', 'Nước uống sẵn có'],
      ];
    @endphp

    {{-- Section head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:16px; margin-bottom:40px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <div style="width:7px; height:7px; border-radius:50%; background:#0b7f42;"></div>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">{{ $setting('home_routes_badge', 'Tuyến đường cố định') }}</span>
        </div>
        <h2 style="margin:0; color:#173014; font-size:clamp(32px,4vw,52px); font-weight:900; line-height:1.05; letter-spacing:-1px;">
          {{ $setting('home_routes_title_primary', 'Sài Gòn') }} <span style="color:#0b7f42;">{{ $setting('home_routes_title_highlight', 'Nha Trang') }}</span>
        </h2>
      </div>
      <a href="{{ route('booking.search', ['route_id' => $featuredRoutes->where('to_location','like','%Nha Trang%')->first()?->id ?? $featuredRoutes->first()?->id, 'departDate' => now()->format('d-m-Y')]) }}"
         style="display:inline-flex; align-items:center; gap:8px; color:#0b7f42; font-size:15px; font-weight:800; text-decoration:none; border-bottom:2px solid rgba(11,127,66,0.30); padding-bottom:3px; transition:all 0.2s; white-space:nowrap;"
         onmouseover="this.style.borderBottomColor='#0b7f42'"
         onmouseout="this.style.borderBottomColor='rgba(11,127,66,0.30)'">
         {{ $setting('home_routes_cta', 'Đặt vé ngay') }} →
      </a>
    </div>

    {{-- Main layout: stats + review + image --}}
    @php $route = $featuredRoutes->where('to_location','like','%Nha Trang%')->first() ?? $featuredRoutes->first(); @endphp
    @if($route)
    <div style="display:grid; gap:0;" class="route-section-grid">
      <div style="display:grid; grid-template-columns:1.45fr 0.65fr 1.15fr; gap:14px; align-items:stretch;" class="route-match-grid">
        <div style="display:grid; grid-template-rows:1fr 0.45fr; gap:14px;" class="route-left-box">
          <article style="display:grid; grid-template-columns:repeat(4,1fr); padding:26px 18px; text-align:center; background:#fff9ed; border-radius:14px; box-shadow:0 8px 24px rgba(0,0,0,0.06);" class="route-metric-grid">
            @foreach([
              ['passengers', '10000', '10.000+', 'Hành khách', 'mỗi tháng', 'plus'],
              ['coach', null, 'Nhiều chuyến', 'Mỗi ngày', 'liên tục', 'text'],
              ['route', '2', '2 chiều', 'Sài Gòn ⇄ Nha Trang', 'mỗi ngày', 'suffix'],
              ['shield', '100', '100%', 'Cam kết an toàn', 'trên mọi hành trình', 'percent'],
            ] as [$icon, $countValue, $displayValue, $label, $sub, $format])
            <div style="padding:0 12px; border-right:1px solid #eee2cf;" class="route-stat-item">
              <div style="width:48px; height:48px; margin:0 auto 12px; border-radius:14px; background:linear-gradient(135deg,#fff6dd,#f5e4b6); border:1px solid rgba(212,160,23,0.22); color:#0f5132; display:flex; align-items:center; justify-content:center; box-shadow:0 8px 18px rgba(212,160,23,0.12);">
                @if($icon === 'passengers')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M16.5 19.5V18a3.5 3.5 0 0 0-3.5-3.5h-2A3.5 3.5 0 0 0 7.5 18v1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                  <circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M18 10.5a3 3 0 0 1 0 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                  <path d="M6 10.5a3 3 0 0 0 0 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                @elseif($icon === 'coach')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M5 15.5V8.8C5 7.25 6.25 6 7.8 6h8.4C17.75 6 19 7.25 19 8.8v6.7" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M4 15.5h16v2a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 17.5v-2Z" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M8 10h3M13 10h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                  <circle cx="8" cy="18" r="1.2" fill="currentColor"/>
                  <circle cx="16" cy="18" r="1.2" fill="currentColor"/>
                </svg>
                @elseif($icon === 'route')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M7 7h9.5a2.5 2.5 0 1 1 0 5H9.5a2.5 2.5 0 0 0 0 5H19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                  <path d="m15.5 5.5 2 1.5-2 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="m10.5 15.5-2 1.5 2 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="6" cy="7" r="1.4" fill="currentColor"/>
                  <circle cx="20" cy="17" r="1.4" fill="currentColor"/>
                </svg>
                @else
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M12 4.5 6.8 6.7v4.8c0 3.5 2.1 6.7 5.2 8 3.1-1.3 5.2-4.5 5.2-8V6.7L12 4.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                  <path d="m9.5 11.8 1.7 1.7 3.4-3.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @endif
              </div>
              <div style="font-size:24px; font-weight:800; color:#0f5132; margin-bottom:8px;" class="route-stat-number" @if($countValue) data-count="{{ $countValue }}" data-format="{{ $format }}" @endif>{{ $displayValue }}</div>
              <div style="font-size:15px; font-weight:700; color:#144632; margin-bottom:8px;">{{ $label }}</div>
              <div style="font-size:13px; color:#415d51; line-height:1.5;">{{ $sub }}</div>
            </div>
            @endforeach
          </article>

          <article style="padding:20px 22px; display:grid; grid-template-columns:auto 1fr; gap:14px; align-items:center; background:linear-gradient(135deg,#fff9ed,#fff4d7); border:1px solid #f1dfb7; border-radius:14px; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
            <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ffe09a,#d4a017); color:#143723; display:flex; align-items:center; justify-content:center; box-shadow:0 8px 18px rgba(212,160,23,0.22); flex-shrink:0;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z" stroke="currentColor" stroke-width="1.8"/>
                <circle cx="12" cy="9.5" r="2.2" fill="currentColor"/>
              </svg>
            </div>
            <div>
              <div style="font-size:11px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:#8a6300; margin-bottom:6px;">Đón trả linh hoạt</div>
              <div style="font-size:18px; font-weight:800; line-height:1.4; color:#123c2c;">{{ $setting('home_routes_pickup_text', 'Đón trả tận nhiều điểm thuận tiện') }}</div>
            </div>
          </article>
        </div>

        <article style="background:#064021; color:#fff; border-radius:14px; padding:24px 22px; position:relative; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.12); display:flex; flex-direction:column;">
          <div style="display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:14px;">
            <h3 style="font-size:16px; margin:0; font-weight:700;">{{ $setting('home_routes_review_title', 'Đánh giá từ khách hàng') }}</h3>
            <div style="display:flex; align-items:center; padding-left:10px; flex-shrink:0;">
              @foreach($reviewAvatars as [$initials, $background])
              <div class="route-review-avatar" style="width:34px; height:34px; margin-left:-10px; border-radius:50%; background:{{ $background }}; border:2px solid rgba(255,255,255,0.9); color:#fff; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:900; letter-spacing:0.06em; box-shadow:0 8px 18px rgba(0,0,0,0.18);">{{ $initials }}</div>
              @endforeach
            </div>
          </div>
          <div style="color:#f5b642; font-size:23px; margin-bottom:6px;">★★★★★</div>
          <div style="font-size:28px; font-weight:800; margin-bottom:8px;">4.9/5</div>
          <div style="font-size:13px; opacity:0.85; margin-bottom:30px;">Từ hơn 2.500+ đánh giá</div>
          <!-- <div style="font-size:50px; color:#e5c168; line-height:1; margin-bottom:8px;">“</div> -->
          <p style="font-size:15px; line-height:1.7; margin:0 0 26px;">{{ $setting('home_routes_review_quote', 'Xe sạch sẽ, chạy êm, nhân viên nhiệt tình. Sẽ tiếp tục ủng hộ Nhật Dương!') }}</p>
          <div style="display:flex; align-items:center; gap:10px; margin-top:auto;">
            <div style="width:42px; height:42px; border-radius:50%; background:{{ $reviewAvatars[0][1] }}; border:2px solid rgba(255,255,255,0.5); color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; letter-spacing:0.06em;">{{ $reviewAvatars[0][0] }}</div>
            <div>
              <div style="font-size:14px; font-weight:700;">{{ $setting('home_routes_review_name', 'Nguyễn Minh Anh') }}</div>
              <div style="font-size:12px; opacity:0.8; margin-top:3px;">{{ $setting('home_routes_review_role', 'Khách hàng thường xuyên') }}</div>
            </div>
          </div>
        </article>

        <article style="border-radius:14px; overflow:hidden; background:#123c2c; box-shadow:0 8px 24px rgba(0,0,0,0.12); display:flex; flex-direction:column;">
          <div style="height:265px; position:relative; background:#123c2c;">
            <img src="{{ $routeSectionImage ?: ($route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png')) }}"
                 alt="{{ $route->name }}"
                 style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
            <div style="position:absolute; inset:0; background:linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1));"></div>
          </div>

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; background:#103f25; color:#fff; padding:18px 18px 20px;" class="route-checklist-grid">
            @foreach($routeChecklistColumns as $items)
            <div style="display:grid; gap:10px; align-content:start;">
              @foreach($items as $label)
              <div style="display:flex; align-items:flex-start; gap:10px;">
                <div style="width:22px; height:22px; border-radius:50%; background:linear-gradient(135deg,#ffd975,#d4a017); color:#17412d; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 6px 14px rgba(212,160,23,0.28);">
                  <svg width="12" height="12" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M3 8.4 6.1 11.5 13 4.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div style="font-size:12px; line-height:1.45; font-weight:700; color:rgba(255,255,255,0.96);">{{ $label }}</div>
              </div>
              @endforeach
            </div>
            @endforeach
          </div>
        </article>
      </div>
    </div>
    @endif

  </div>
</section>

  <style>
  @media (max-width: 1320px) {
    .route-match-grid { grid-template-columns: 1fr !important; }
  }
  .route-stat-item:last-child,
  .route-feature-item:last-child { border-right: none !important; }
  @media (max-width: 760px) {
    .route-metric-grid { grid-template-columns: 1fr 1fr !important; }
    .route-stat-item,
    .route-feature-item { border-right: none !important; }
    .route-checklist-grid { grid-template-columns: 1fr !important; }
  }
  @media (max-width: 520px) {
    section[style*="padding:72px 0 120px"] > div { padding: 0 16px !important; }
    .route-metric-grid { grid-template-columns: 1fr !important; }
  }

  .route-review-avatar {
    animation: routeAvatarFloat 3.2s ease-in-out infinite;
  }

  .route-review-avatar:nth-child(2) { animation-delay: .18s; }
  .route-review-avatar:nth-child(3) { animation-delay: .36s; }
  .route-review-avatar:nth-child(4) { animation-delay: .54s; }
  .route-review-avatar:nth-child(5) { animation-delay: .72s; }

  @keyframes routeAvatarFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
  }
</style>

@push('scripts')
<script>
  (() => {
    const numbers = document.querySelectorAll('.route-stat-number[data-count]');

    if (!numbers.length) return;

    const formatValue = (value, format) => {
      if (format === 'plus') {
        return `${new Intl.NumberFormat('vi-VN').format(value)}+`;
      }

      if (format === 'percent') {
        return `${value}%`;
      }

      if (format === 'suffix') {
        return `${value} chiều`;
      }

      return String(value);
    };

    const animateNumber = (element) => {
      const target = Number(element.dataset.count || 0);
      const format = element.dataset.format || 'text';
      const duration = 1400;
      const start = performance.now();

      const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.round(target * eased);

        element.textContent = formatValue(current, format);

        if (progress < 1) {
          requestAnimationFrame(tick);
        }
      };

      requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        animateNumber(entry.target);
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.35 });

    numbers.forEach((number) => observer.observe(number));
  })();
</script>
@endpush
