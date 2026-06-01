{{-- LỊCH TRÌNH 2 CHIỀU — layout từ index-nhat-duong-complete-with-testimonials-faq.html --}}
@if($popularSchedules->isNotEmpty())
@php
  $route = $ntRoute ?? $popularSchedules->first()->route;
  $goSchedules = $popularSchedules;
  $getTimeLabel = function(int $h): string {
    if ($h < 12) return 'Buổi sáng';
    if ($h < 14) return 'Buổi trưa';
    if ($h < 18) return 'Buổi chiều';
    if ($h < 21) return 'Buổi tối';
    return 'Buổi đêm';
  };
@endphp

<section style="position:relative; padding:86px 0 96px; overflow:hidden; background: radial-gradient(circle at 12% 20%,rgba(18,124,7,.10),transparent 22%), radial-gradient(circle at 88% 18%,rgba(249,178,26,.13),transparent 22%), linear-gradient(180deg,#f7fbf5 0%,#ffffff 100%);">
  <div style="position:absolute; left:-120px; bottom:-160px; width:360px; height:360px; border-radius:50%; background:rgba(18,124,7,.08); pointer-events:none;"></div>

  <div style="width:min(1280px,94%); margin:0 auto; padding:0 16px; position:relative; z-index:2;">

    {{-- Head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:24px; margin-bottom:28px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="position:relative; display:flex; width:8px; height:8px;">
            <span class="animate-ping" style="position:absolute; inset:0; border-radius:50%; background:#0b7f42; opacity:0.4;"></span>
            <span style="position:relative; width:8px; height:8px; border-radius:50%; background:#0b7f42; display:block;"></span>
          </span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Khởi hành trong ngày</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4.5vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Lịch trình <span style="color:#0b7f42;">hôm nay</span>
        </h2>
      </div>
      <div style="display:inline-flex; align-items:center; gap:10px; padding:13px 18px; border-radius:999px; color:#0a5d03; background:#fff; border:1px solid rgba(18,124,7,.16); box-shadow:0 14px 34px rgba(18,124,7,.10); font-size:14px; font-weight:900; white-space:nowrap;">
        📅 Hôm nay · Tuyến Sài Gòn ↔ Nha Trang
      </div>
    </div>

    {{-- Layout: summary + direction grid --}}
    <div style="display:grid; grid-template-columns:.9fr 1.1fr; gap:24px; align-items:stretch;" class="sched-main-layout">

      {{-- Summary card xanh đậm --}}
      <aside style="position:relative; overflow:hidden; border-radius:34px; padding:34px; color:#fff; background: linear-gradient(135deg,rgba(4,56,1,.94),rgba(18,124,7,.86)); box-shadow:0 26px 70px rgba(8,61,15,.20); border:1px solid rgba(255,255,255,.18); animation:floatCard 5.5s ease-in-out infinite;">
        <div style="position:absolute; right:-80px; top:-80px; width:220px; height:220px; border-radius:50%; background:rgba(249,178,26,.18); filter:blur(1px); pointer-events:none;"></div>

        <div style="position:relative; z-index:2;">
          <span style="display:inline-flex; align-items:center; gap:8px; padding:9px 13px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; box-shadow:0 12px 24px rgba(249,178,26,.22); margin-bottom:22px;">🚌 Đang mở bán vé</span>

          <h3 style="position:relative; z-index:2; margin:0 0 12px; font-size:clamp(24px,2.5vw,34px); line-height:1.08; font-weight:900; letter-spacing:-0.8px;">Sài Gòn ↔ Nha Trang</h3>
          <p style="position:relative; z-index:2; margin:0; color:rgba(255,255,255,.78); font-size:15px; line-height:1.7; font-weight:700;">
            Lịch trình chia 2 chiều rõ ràng. Mỗi chiều hiển thị nhiều khung giờ, giúp khách chọn giờ đi nhanh hơn.
          </p>

          <div style="position:relative; z-index:2; display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:28px;">
            @foreach([
              ['02','Chiều tuyến'],
              [$route->estimated_time ?? '9-10h','Thời gian'],
              [number_format($route->price_from/1000).'K','Giá vé từ'],
              ['24/7','Hỗ trợ đặt vé'],
            ] as [$val,$lbl])
            <div style="padding:18px; border-radius:20px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.14);">
              <strong style="display:block; color:#f9b21a; font-size:28px; font-weight:900; line-height:1;">{{ $val }}</strong>
              <span style="display:block; margin-top:7px; color:rgba(255,255,255,.78); font-size:12px; font-weight:800;">{{ $lbl }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </aside>

      {{-- 2 direction cards --}}
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;" class="direction-cards-grid">

        {{-- CHIỀU ĐI --}}
        <article style="position:relative; overflow:hidden; border-radius:32px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 22px 60px rgba(18,124,7,.12); transition:.28s ease;"
                 onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 30px 78px rgba(18,124,7,.18)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 22px 60px rgba(18,124,7,.12)'">
          <div style="position:absolute; inset:0; background:radial-gradient(circle at 88% 12%,rgba(249,178,26,.17),transparent 22%),radial-gradient(circle at 12% 92%,rgba(18,124,7,.08),transparent 26%); pointer-events:none;"></div>

          {{-- Header --}}
          <div style="position:relative; padding:26px 26px 22px; color:#fff; background:linear-gradient(135deg,#0a5d03,#127c07); overflow:hidden;">
            <div style="position:absolute; right:-45px; top:-65px; width:170px; height:170px; border-radius:50%; background:rgba(249,178,26,.22); pointer-events:none;"></div>
            <span style="position:relative; z-index:2; display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; box-shadow:0 12px 24px rgba(249,178,26,.22);">🚀 Chiều đi</span>
            <h3 style="position:relative; z-index:2; margin:18px 0 0; font-size:clamp(18px,2vw,26px); line-height:1.12; font-weight:900; letter-spacing:-.5px;">Sài Gòn → Nha Trang</h3>
            <div style="position:relative; z-index:2; display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:14px; color:rgba(255,255,255,.82); font-size:13px; font-weight:900;">
              <span>Sài Gòn</span>
              <span style="color:#f9b21a; font-weight:900;">→</span>
              <span>Nha Trang</span>
            </div>
          </div>

          {{-- Time list --}}
          <div style="position:relative; z-index:2; padding:24px 26px 26px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:18px;">
              <strong style="color:#172315; font-size:17px; font-weight:900;">Giờ khởi hành</strong>
              <span style="color:#0b7f42; background:#eaf8e8; border:1px solid rgba(18,124,7,.12); border-radius:999px; padding:7px 10px; font-size:12px; font-weight:900; white-space:nowrap;">Còn vé hôm nay</span>
            </div>

            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
              @foreach($goSchedules as $s)
              @php
                $dep = \Carbon\Carbon::parse($s->departure_time);
                $h = $dep->hour;
                $lbl = $getTimeLabel($h);
              @endphp
              <a href="{{ route('booking.search', ['route_id' => $s->route_id, 'departDate' => now()->format('d-m-Y')]) }}"
                 style="position:relative; min-height:72px; display:flex; flex-direction:column; justify-content:center; padding:13px 14px; border-radius:18px; color:#043801; background:linear-gradient(180deg,#fffdf4,#fff4c8); border:1px solid rgba(249,178,26,.36); box-shadow:inset 0 -8px 14px rgba(249,178,26,.08); text-decoration:none; transition:.24s ease;"
                 onmouseover="this.style.transform='translateY(-3px)';this.style.background='linear-gradient(180deg,#ffffff,#ecfae9)';this.style.borderColor='rgba(18,124,7,.24)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.background='linear-gradient(180deg,#fffdf4,#fff4c8)';this.style.borderColor='rgba(249,178,26,.36)'">
                <strong style="display:block; font-size:22px; line-height:1; font-weight:900;">{{ $dep->format('H:i') }}</strong>
                <span style="display:block; margin-top:7px; color:#62735e; font-size:11px; font-weight:900;">{{ $lbl }}</span>
              </a>
              @endforeach
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; gap:14px; margin-top:22px; padding-top:18px; border-top:1px solid rgba(18,124,7,.10); flex-wrap:wrap;">
              <div style="color:#62735e; font-size:12px; line-height:1.5; font-weight:750;">Giường nằm chất lượng cao · Đặt vé một chiều / khứ hồi</div>
              <a href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => now()->format('d-m-Y')]) }}"
                 style="min-width:122px; height:42px; display:inline-flex; align-items:center; justify-content:center; border-radius:14px; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:13px; font-weight:900; text-decoration:none; box-shadow:0 12px 26px rgba(249,178,26,.22); transition:.25s ease; white-space:nowrap;"
                 onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 18px 34px rgba(249,178,26,.32)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 12px 26px rgba(249,178,26,.22)'">
                Đặt chiều đi
              </a>
            </div>
          </div>
        </article>

        {{-- CHIỀU VỀ --}}
        <article style="position:relative; overflow:hidden; border-radius:32px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 22px 60px rgba(18,124,7,.12); transition:.28s ease;"
                 onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 30px 78px rgba(18,124,7,.18)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 22px 60px rgba(18,124,7,.12)'">
          <div style="position:absolute; inset:0; background:radial-gradient(circle at 88% 12%,rgba(249,178,26,.17),transparent 22%),radial-gradient(circle at 12% 92%,rgba(18,124,7,.08),transparent 26%); pointer-events:none;"></div>

          <div style="position:relative; padding:26px 26px 22px; color:#fff; background:linear-gradient(135deg,#062d1c,#0b7f42); overflow:hidden;">
            <div style="position:absolute; right:-45px; top:-65px; width:170px; height:170px; border-radius:50%; background:rgba(249,178,26,.22); pointer-events:none;"></div>
            <span style="position:relative; z-index:2; display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; box-shadow:0 12px 24px rgba(249,178,26,.22);">🔄 Chiều về</span>
            <h3 style="position:relative; z-index:2; margin:18px 0 0; font-size:clamp(18px,2vw,26px); line-height:1.12; font-weight:900; letter-spacing:-.5px;">Nha Trang → Sài Gòn</h3>
            <div style="position:relative; z-index:2; display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:14px; color:rgba(255,255,255,.82); font-size:13px; font-weight:900;">
              <span>Nha Trang</span>
              <span style="color:#f9b21a; font-weight:900;">→</span>
              <span>Sài Gòn</span>
            </div>
          </div>

          <div style="position:relative; z-index:2; padding:24px 26px 26px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:18px;">
              <strong style="color:#172315; font-size:17px; font-weight:900;">Giờ khởi hành</strong>
              <span style="color:#0b7f42; background:#eaf8e8; border:1px solid rgba(18,124,7,.12); border-radius:999px; padding:7px 10px; font-size:12px; font-weight:900; white-space:nowrap;">Còn vé hôm nay</span>
            </div>

            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
              @foreach($goSchedules as $s)
              @php
                $dep = \Carbon\Carbon::parse($s->departure_time)->subMinutes(30);
                $h = $dep->hour;
                $lbl = $getTimeLabel($h);
              @endphp
              <div style="position:relative; min-height:72px; display:flex; flex-direction:column; justify-content:center; padding:13px 14px; border-radius:18px; color:#043801; background:linear-gradient(180deg,#fffdf4,#fff4c8); border:1px solid rgba(249,178,26,.36); box-shadow:inset 0 -8px 14px rgba(249,178,26,.08); transition:.24s ease; cursor:default;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.background='linear-gradient(180deg,#ffffff,#ecfae9)';this.style.borderColor='rgba(18,124,7,.24)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.background='linear-gradient(180deg,#fffdf4,#fff4c8)';this.style.borderColor='rgba(249,178,26,.36)'">
                <strong style="display:block; font-size:22px; line-height:1; font-weight:900;">{{ $dep->format('H:i') }}</strong>
                <span style="display:block; margin-top:7px; color:#62735e; font-size:11px; font-weight:900;">{{ $lbl }}</span>
              </div>
              @endforeach
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; gap:14px; margin-top:22px; padding-top:18px; border-top:1px solid rgba(18,124,7,.10); flex-wrap:wrap;">
              <div style="color:#62735e; font-size:12px; line-height:1.5; font-weight:750;">Chuyến về trong ngày · Có thể đặt trước qua hotline</div>
              <a href="tel:0123456789"
                 style="min-width:122px; height:42px; display:inline-flex; align-items:center; justify-content:center; border-radius:14px; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:13px; font-weight:900; text-decoration:none; box-shadow:0 12px 26px rgba(249,178,26,.22); transition:.25s ease; white-space:nowrap;"
                 onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 18px 34px rgba(249,178,26,.32)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 12px 26px rgba(249,178,26,.22)'">
                Đặt chiều về
              </a>
            </div>
          </div>
        </article>

      </div>{{-- /direction-cards-grid --}}
    </div>{{-- /sched-main-layout --}}
  </div>

  <style>
    @media(max-width:992px){
      .sched-main-layout{grid-template-columns:1fr!important}
      .sched-main-layout aside{animation:none!important}
    }
    @media(max-width:760px){
      .direction-cards-grid{grid-template-columns:1fr!important}
    }
    @media(max-width:480px){
      .direction-cards-grid article div[style*="grid-template-columns:repeat(3"]{
        grid-template-columns:repeat(2,1fr)!important
      }
    }
  </style>
</section>
@endif
