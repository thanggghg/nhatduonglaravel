{{-- HERO: ảnh nền sáng + overlay nhẹ, promo banner, search form, benefits bar --}}
<section style="position:relative; overflow:hidden; background:#f5faf4;">

  {{-- Background ảnh xe với overlay trắng nhẹ (không xanh) --}}
  @php
    $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
    $heroImage = $heroBanner && $heroBanner->image
        ? asset('storage/' . $heroBanner->image)
        : asset('nha-xe-binh-minh-bus-2048x867.png');
  @endphp
  <div style="position:absolute; inset:0;">
    <img src="{{ $heroImage }}"
         alt="{{ $heroBanner->title ?? '' }}" aria-hidden="true"
         style="width:100%; height:100%; object-fit:cover; object-position:center; animation:subtle-zoom 22s ease-in-out infinite alternate;">
    {{-- Overlay trắng nhẹ phía trên, xanh đậm phía dưới (giống file mẫu) --}}
    <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(255,255,255,0.72) 0%, rgba(255,255,255,0.32) 38%, rgba(255,255,255,0.10) 100%);"></div>
    <div style="position:absolute; inset:0; background:radial-gradient(circle at 18% 18%, rgba(18,124,7,0.08), transparent 28%), radial-gradient(circle at 80% 22%, rgba(251,177,22,0.14), transparent 26%);"></div>
  </div>

  <div style="position:relative; z-index:2; width:min(1280px,94%); margin:0 auto; padding:40px 16px 0;">

    {{-- PROMO BANNER --}}
    <div style="text-align:center; margin-bottom:28px;">
      <div style="display:inline-flex; align-items:center; justify-content:center; gap:20px; flex-wrap:wrap;">

        {{-- Tag tên --}}
        <div style="display:inline-flex; align-items:center; justify-content:center; padding:16px 28px; border-radius:20px; background:linear-gradient(180deg,#0b7f42,#062d1c); border:2px solid rgba(255,255,255,0.65); box-shadow:0 16px 32px rgba(11,127,66,0.28); color:#fff; font-size:clamp(22px,3.5vw,32px); font-weight:900; text-transform:uppercase; letter-spacing:0.5px; text-shadow:0 2px 4px rgba(0,0,0,0.18);">
          Đặt vé xe Nhật Dương
        </div>

        {{-- Discount --}}
        <div style="display:inline-flex; align-items:center; gap:12px;">
          <div style="padding:10px 14px; border-radius:16px 16px 16px 4px; background:#fff; border:3px solid #fbb116; color:#062d1c; font-size:18px; font-weight:900; text-transform:uppercase; box-shadow:0 10px 24px rgba(251,177,22,0.25);">Ưu đãi</div>
          <div style="font-size:clamp(64px,10vw,96px); line-height:0.9; font-weight:900; background:linear-gradient(180deg,#ffe768,#fbb116); -webkit-background-clip:text; background-clip:text; color:transparent; filter:drop-shadow(0 6px 8px rgba(251,177,22,0.22));">20%</div>
        </div>
      </div>

      {{-- Sub promo --}}
      <div style="display:inline-flex; align-items:center; gap:18px; margin-top:-6px; padding:14px 28px; background:rgba(255,255,255,0.95); border-radius:0 0 18px 18px; color:#173014; font-size:clamp(14px,2vw,17px); font-weight:800; box-shadow:0 14px 24px rgba(11,127,66,0.12); flex-wrap:wrap; justify-content:center;">
        <span style="color:#0b7f42;">TP. Hồ Chí Minh</span>
        <span>↔</span>
        <span style="color:#0b7f42;">Nha Trang</span>
      </div>
    </div>

    {{-- SEARCH CARD --}}
    @php $sgntRoute = \App\Models\Route::where('status', true)->where('to_location', 'like', '%Nha Trang%')->first(); @endphp
    <form action="{{ route('booking.search') }}" method="GET"
          style="border-radius:20px; background:rgba(255,255,255,0.97); border:1px solid rgba(11,127,66,0.14); box-shadow:0 18px 48px rgba(11,127,66,0.18); overflow:hidden; backdrop-filter:blur(10px);">

      @if($sgntRoute)
        <input type="hidden" name="route_id" value="{{ $sgntRoute->id }}">
      @endif

      {{-- Header card --}}
      <div style="padding:14px 20px 12px; border-bottom:1px solid #e4f0e2; display:flex; align-items:center; gap:10px;">
        <div style="width:8px; height:8px; border-radius:50%; background:#0b7f42;"></div>
        <span style="color:#0b7f42; font-size:14px; font-weight:800;">Đặt vé — Sài Gòn ↔ Nha Trang</span>
      </div>

      {{-- Form fields --}}
      <div style="padding:14px;">
        <div style="display:grid; grid-template-columns:1.1fr 48px 1.1fr 1fr 160px; border:1px solid #dcebd8; border-radius:14px; overflow:hidden; background:#fff;" class="search-field-row">

          {{-- Nơi xuất phát --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2;">
            <div style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Nơi xuất phát</div>
            <div style="display:flex; align-items:center; gap:8px;">
              <div style="width:26px; height:26px; border-radius:50%; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>
              </div>
              <div>
                <div style="color:#173014; font-size:15px; font-weight:900;">Sài Gòn</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Bến xe / văn phòng</div>
              </div>
            </div>
          </div>

          {{-- Swap --}}
          <div style="display:grid; place-items:center; border-right:1px solid #e4f0e2; color:#0b7f42; font-size:20px; font-weight:900;">⇄</div>

          {{-- Nơi đến --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2;">
            <div style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Nơi đến</div>
            <div style="display:flex; align-items:center; gap:8px;">
              <div style="width:26px; height:26px; border-radius:50%; background:#ef5423; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
              </div>
              <div>
                <div style="color:#173014; font-size:15px; font-weight:900;">Nha Trang</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Tuyến chạy cố định</div>
              </div>
            </div>
          </div>

          {{-- Ngày đi --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2; position:relative;">
            <div style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Ngày đi</div>
            <div style="display:flex; align-items:center; gap:8px;">
              <div style="width:26px; height:26px; border-radius:50%; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
              <div style="flex:1;">
                <input type="date" name="departDate_raw" id="departDate_raw"
                       value="{{ now()->format('Y-m-d') }}"
                       min="{{ now()->format('Y-m-d') }}"
                       style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;"
                       onchange="syncDate(this.value)">
                <div id="dateDisplay" style="color:#173014; font-size:15px; font-weight:900;">{{ now()->format('d/m/Y') }}</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Nhiều giờ xuất bến</div>
              </div>
            </div>
            <input type="hidden" name="departDate" id="departDateHidden" value="{{ now()->format('d-m-Y') }}">
          </div>

          {{-- Search button --}}
          <button type="submit"
             style="display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,#ffdc47,#fbb116); color:#5a3e00; font-size:17px; font-weight:900; border:none; cursor:pointer; transition:all 0.2s; min-height:80px;"
             onmouseover="this.style.filter='brightness(1.04)'"
             onmouseout="this.style.filter='none'">
            Tìm chuyến
          </button>
        </div>
      </div>
    </form>

  </div>

  {{-- BENEFITS BAR --}}
  <div style="position:relative; z-index:2; margin-top:80px; background:linear-gradient(180deg,rgba(10,93,3,0.93),rgba(6,63,2,0.97)); border-top:1px solid rgba(255,255,255,0.15);">
    <div style="width:min(1280px,94%); margin:0 auto; min-height:60px; display:flex; align-items:center; justify-content:center; gap:clamp(16px,4vw,48px); flex-wrap:wrap; padding:14px 16px;">
      @foreach([
        ['✔','Chắc chắn có chỗ'],
        ['🎧','Hỗ trợ 24/7'],
        ['%','Nhiều ưu đãi'],
        ['₫','Thanh toán đa dạng'],
        ['⏱','Đúng giờ cam kết'],
      ] as [$icon,$text])
      <div style="display:flex; align-items:center; gap:9px; font-size:14px; font-weight:800; color:#fff; white-space:nowrap;">
        <div style="width:24px; height:24px; border-radius:50%; background:#fbb116; color:#5a3e00; display:grid; place-items:center; font-size:12px; font-weight:900; flex-shrink:0;">{{ $icon }}</div>
        {{ $text }}
      </div>
      @endforeach
    </div>
  </div>

</section>

<style>
@media (max-width: 900px) {
  .search-field-row { grid-template-columns: 1fr !important; }
  .search-field-row > div, .search-field-row > button { border-right: none !important; border-bottom: 1px solid #e4f0e2; }
}
</style>
<script>
function syncDate(val) {
  if (!val) return;
  var parts = val.split('-'); // Y-m-d
  var display = parts[2] + '/' + parts[1] + '/' + parts[0];
  var hidden  = parts[2] + '-' + parts[1] + '-' + parts[0];
  document.getElementById('dateDisplay').textContent = display;
  document.getElementById('departDateHidden').value  = hidden;
}
</script>
