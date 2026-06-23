{{-- TUYẾN ĐƯỜNG CỐ ĐỊNH --}}
<section style="background:linear-gradient(180deg,#f6fbf5 0%,#f7fbf6 100%); padding:72px 0 120px; overflow:hidden;">
  <div style="width:min(1920px,100%); margin:0 auto; padding:0 28px;">

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

    {{-- Main layout: stats + review + image --}}
    @php $route = $featuredRoutes->where('to_location','like','%Nha Trang%')->first() ?? $featuredRoutes->first(); @endphp
    @if($route)
    <div style="display:grid; gap:0;" class="route-section-grid">
      <div style="display:grid; grid-template-columns:minmax(0,1.6fr) minmax(260px,.62fr) minmax(320px,.9fr); gap:10px; align-items:stretch;" class="route-match-grid">
        <article style="border-radius:18px; background:linear-gradient(180deg,#fffef8,#fffdf6); box-shadow:0 18px 44px rgba(11,127,66,0.08); border:1px solid rgba(227,233,224,0.9); padding:28px 26px 20px; display:flex; flex-direction:column; min-height:258px;">
          <div style="display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:10px; flex:1;" class="route-metric-grid">
          @foreach([
            ['10.000+', 'Hành khách', 'mỗi tháng', '◔'],
            ['Nhiều chuyến', 'Mỗi ngày', 'liên tục', '🚌'],
            ['2 chiều', 'Sài Gòn - Nha Trang', 'mỗi ngày', '⇄'],
            ['100%', 'Cam kết an toàn', 'trên mọi hành trình', '🛡'],
          ] as [$value, $label, $sub, $icon])
          <div style="padding:12px 10px; display:flex; flex-direction:column; align-items:center; text-align:center; justify-content:flex-start; min-height:150px;">
            <div style="width:34px; height:34px; display:grid; place-items:center; color:#2c6452; font-size:18px; margin-bottom:12px;">{{ $icon }}</div>
            <strong style="display:block; color:#13624a; font-size:16px; font-weight:900; line-height:1.2;">{{ $value }}</strong>
            <span style="display:block; margin-top:10px; color:#234f43; font-size:13px; font-weight:800; line-height:1.35;">{{ $label }}</span>
            <span style="display:block; margin-top:5px; color:#6e7d74; font-size:12px; font-weight:700; line-height:1.45;">{{ $sub }}</span>
          </div>
          @endforeach
          </div>
          <div style="margin-top:10px; padding-top:16px; border-top:1px solid rgba(11,127,66,0.08); color:#315e4f; font-size:13px; font-weight:800;">Đón trả tại nhiều điểm thuận tiện</div>
        </article>

        <article style="padding:18px 18px 16px; border-radius:18px; color:#fff; background:linear-gradient(180deg,#124c31,#0b3f28); box-shadow:0 18px 44px rgba(8,61,15,.16); min-height:258px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; color:#fff; font-size:12px; font-weight:800;">
              <span>Đánh giá từ khách hàng</span>
              <span style="display:flex; align-items:center; gap:6px; white-space:nowrap;"><span style="color:#f7bf2b; letter-spacing:1px;">★★★★★</span> <span>4.9 / 5</span></span>
            </div>
            <div style="margin-top:12px; color:rgba(255,255,255,.68); font-size:12px; font-weight:700;">Từ hơn 2500+ đánh giá</div>
            <p style="margin:20px 0 0; color:#fff; font-size:13px; line-height:1.75; font-weight:700;">❝ Xe sạch sẽ, chạy êm, nhân viên nhiệt tình. Sẽ tiếp tục ủng hộ Nhật Dương ❞</p>
          </div>
          <div style="margin-top:18px; padding-top:14px; border-top:1px solid rgba(255,255,255,.12); display:flex; align-items:center; gap:10px;">
            <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(180deg,#ffe8a6,#f7bf2b); display:grid; place-items:center; color:#0b3f28; font-size:13px; font-weight:900;">N</div>
            <div>
              <strong style="display:block; font-size:12px; font-weight:900;">Nguyễn Minh Anh</strong>
              <span style="display:block; margin-top:3px; color:rgba(255,255,255,.74); font-size:11px; font-weight:700;">Khách hàng trung thành</span>
            </div>
          </div>
        </article>

        <article style="border-radius:18px; overflow:hidden; background:#173014; box-shadow:0 18px 44px rgba(8,61,15,.16); min-height:258px; display:flex; flex-direction:column;">
          <div style="flex:1; min-height:182px; position:relative; overflow:hidden;">
            <img src="{{ $route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png') }}"
                 alt="{{ $route->name }}"
                 style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
            <div style="position:absolute; inset:0; background:linear-gradient(180deg,rgba(0,0,0,.06),rgba(0,0,0,.12));"></div>
          </div>
          <div style="padding:14px 10px 12px; background:linear-gradient(180deg,#245b38,#163d28); display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:6px;">
            @foreach([
              ['🛏','Giường rộng'],
              ['❄','Điều hoà mát'],
              ['📶','Wifi mạnh'],
              ['🔌','Cổng sạc USB'],
              ['🧴','Nước uống miễn phí'],
            ] as [$icon, $label])
            <div style="display:flex; flex-direction:column; align-items:center; text-align:center; gap:4px; color:#fff;">
              <span style="font-size:16px; line-height:1;">{{ $icon }}</span>
              <span style="font-size:9px; font-weight:700; line-height:1.3; color:rgba(255,255,255,.82);">{{ $label }}</span>
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
  @media (max-width: 760px) {
    .route-metric-grid { grid-template-columns: 1fr 1fr !important; }
  }
  @media (max-width: 520px) {
    section[style*="padding:72px 0 120px"] > div { padding: 0 16px !important; }
    .route-metric-grid { grid-template-columns: 1fr !important; }
  }
</style>
