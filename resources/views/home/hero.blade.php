{{-- HERO: ảnh nền sáng + overlay nhẹ, promo banner, search form, benefits bar --}}
<section style="position:relative; overflow:hidden; background:#f5faf4;">

  {{-- Background ảnh xe với overlay trắng nhẹ (không xanh) --}}
  @php
    $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
    $heroImage = $heroBanner && $heroBanner->hasImage()
        ? $heroBanner->image_url
        : asset('nha-xe-binh-minh-bus-2048x867.png');
    
    // Lấy danh sách locations từ routes
    $allRoutes = \App\Models\Route::where('status', true)->get();
    $fromLocations = $allRoutes->pluck('from_location')->unique()->sort()->values();
    $toLocations = $allRoutes->pluck('to_location')->unique()->sort()->values();
  @endphp
  <div style="position:absolute; inset:0;">
    <img src="{{ $heroImage }}"
         alt="{{ $heroBanner->title ?? '' }}" aria-hidden="true"
         style="width:100%; height:100%; object-fit:cover; object-position:center; animation:subtle-zoom 22s ease-in-out infinite alternate;">
  </div>

  <div style="position:relative; z-index:2; width:min(1280px,94%); margin:0 auto; padding:40px 16px 0;">

    {{-- PROMO BANNER --}}
    <div style="text-align:center; margin-bottom:28px;">
      <div style="display:inline-flex; align-items:center; justify-content:center; gap:20px; flex-wrap:wrap;">
        <div style="display:inline-flex; align-items:center; justify-content:center; padding:16px 28px; border-radius:20px; background:linear-gradient(180deg,#0b7f42,#062d1c); border:2px solid rgba(255,255,255,0.65); box-shadow:0 16px 32px rgba(11,127,66,0.28); color:#fff; font-size:clamp(22px,3.5vw,32px); font-weight:900; text-transform:uppercase; letter-spacing:0.5px; text-shadow:0 2px 4px rgba(0,0,0,0.18);">
          Đặt vé xe Nhật Dương
        </div>
      </div>
    </div>

    {{-- SEARCH CARD --}}
    <form action="{{ route('booking.search') }}" method="GET"
          style="border-radius:20px; background:#fff; box-shadow:0 8px 32px rgba(0,0,0,0.08); overflow:hidden; max-width:1040px; margin:0 auto;">

      <div style="padding:24px 28px;">
        
        {{-- Main grid: From | Swap | To | Date | +Date button | Seats | Search --}}
        <div style="display:grid; grid-template-columns:1fr auto 1fr 200px auto 140px 140px; gap:16px; align-items:center;">
          
          {{-- From --}}
          <div style="position:relative; cursor:pointer;">
            <label style="color:#6b7280; font-size:11px; font-weight:600; margin-bottom:6px; display:block;">Nơi xuất phát</label>
            <select name="from_location" id="fromLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                    onchange="updateLocationDisplay('from', this.value)">
              <option value="">Chọn điểm đi</option>
              @foreach($fromLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'TP. Hồ Chí Minh' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:10px; pointer-events:none;">
              <svg width="20" height="20" fill="#3b82f6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
              <div id="fromDisplay" style="color:#111827; font-size:16px; font-weight:700;">Sài Gòn</div>
            </div>
          </div>

          {{-- Swap --}}
          <button type="button" onclick="swapLocations()" 
                  style="width:40px; height:40px; display:grid; place-items:center; border:1px solid #e5e7eb; background:#fff; border-radius:50%; color:#6b7280; cursor:pointer; transition:all 0.2s; margin-top:16px;"
                  onmouseover="this.style.background='#f3f4f6'; this.style.borderColor='#d1d5db'"
                  onmouseout="this.style.background='#fff'; this.style.borderColor='#e5e7eb'">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
          </button>

          {{-- To --}}
          <div style="position:relative; cursor:pointer;">
            <label style="color:#6b7280; font-size:11px; font-weight:600; margin-bottom:6px; display:block;">Nơi đến</label>
            <select name="to_location" id="toLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                    onchange="updateLocationDisplay('to', this.value)">
              <option value="">Chọn điểm đến</option>
              @foreach($toLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'Nha Trang' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:10px; pointer-events:none;">
              <svg width="20" height="20" fill="#ef4444" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
              <div id="toDisplay" style="color:#111827; font-size:16px; font-weight:700;">Đà Nẵng</div>
            </div>
          </div>

          {{-- Depart date --}}
          <div style="position:relative; cursor:pointer;">
            <label style="color:#6b7280; font-size:11px; font-weight:600; margin-bottom:6px; display:block;">Ngày đi</label>
            <input type="date" name="departDate_raw" id="departDate_raw"
                   value="{{ now()->format('Y-m-d') }}"
                   min="{{ now()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                   onchange="syncDate(this.value, 'depart')">
            <div style="display:flex; align-items:center; gap:10px; pointer-events:none;">
              <svg width="20" height="20" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              <div id="departDateDisplay" style="color:#111827; font-size:16px; font-weight:700;">{{ now()->format('d/m/Y') }}</div>
            </div>
            <input type="hidden" name="departDate" id="departDateHidden" value="{{ now()->format('d-m-Y') }}">
          </div>

          {{-- Toggle return date button --}}
          <button type="button" id="toggleReturnBtn" onclick="toggleReturnDateField()"
                  style="margin-top:16px; padding:10px; background:#eff6ff; color:#3b82f6; border:1px dashed #3b82f6; border-radius:12px; font-size:13px; font-weight:700; cursor:pointer; white-space:nowrap; transition:all 0.2s;"
                  onmouseover="this.style.background='#dbeafe'"
                  onmouseout="this.style.background='#eff6ff'">
            + Thêm ngày về
          </button>

          {{-- Seats --}}
          <div style="margin-top:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; border:1px solid #e5e7eb; border-radius:12px; padding:8px 12px; background:#f9fafb;">
              <button type="button" onclick="changeSeats(-1)" 
                      style="width:28px; height:28px; border:none; background:#fff; color:#6b7280; font-size:16px; font-weight:900; cursor:pointer; display:grid; place-items:center; border-radius:6px; transition:all 0.15s;"
                      onmouseover="this.style.background='#f3f4f6'"
                      onmouseout="this.style.background='#fff'">
                −
              </button>
              <input type="number" name="seats" id="seatsInput" value="1" min="1" max="50" required
                     style="width:40px; text-align:center; border:none; background:transparent; color:#111827; font-size:16px; font-weight:700; outline:none;">
              <button type="button" onclick="changeSeats(1)" 
                      style="width:28px; height:28px; border:none; background:#fff; color:#6b7280; font-size:16px; font-weight:900; cursor:pointer; display:grid; place-items:center; border-radius:6px; transition:all 0.15s;"
                      onmouseover="this.style.background='#f3f4f6'"
                      onmouseout="this.style.background='#fff'">
                +
              </button>
            </div>
            <div style="color:#6b7280; font-size:10px; text-align:center; margin-top:4px;">Hành khách</div>
          </div>

          {{-- Submit button --}}
          <button type="submit"
                  style="margin-top:16px; padding:14px 24px; background:#fbbf24; color:#78350f; font-size:16px; font-weight:800; border:none; border-radius:12px; cursor:pointer; transition:all 0.2s; box-shadow:0 2px 8px rgba(251,191,36,0.3);"
                  onmouseover="this.style.background='#f59e0b'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(251,191,36,0.4)'"
                  onmouseout="this.style.background='#fbbf24'; this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(251,191,36,0.3)'">
            Tìm kiếm
          </button>
        </div>

        {{-- Return date row (hidden by default) --}}
        <div id="returnDateRow" style="display:none; margin-top:16px; padding-top:16px; border-top:1px solid #e5e7eb;">
          <div style="display:grid; grid-template-columns:200px 1fr; gap:16px; align-items:center;">
            <div style="position:relative; cursor:pointer;">
              <label style="color:#6b7280; font-size:11px; font-weight:600; margin-bottom:6px; display:block;">Ngày về</label>
              <input type="date" name="returnDate_raw" id="returnDate_raw"
                     value="{{ now()->addDays(2)->format('Y-m-d') }}"
                     min="{{ now()->addDay()->format('Y-m-d') }}"
                     style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                     onchange="syncDate(this.value, 'return')">
              <div style="display:flex; align-items:center; gap:10px; pointer-events:none;">
                <svg width="20" height="20" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <div id="returnDateDisplay" style="color:#111827; font-size:16px; font-weight:700;">{{ now()->addDays(2)->format('d/m/Y') }}</div>
              </div>
              <input type="hidden" name="returnDate" id="returnDateHidden" value="{{ now()->addDays(2)->format('d-m-Y') }}">
            </div>
            <button type="button" onclick="toggleReturnDateField()"
                    style="padding:8px 16px; background:transparent; color:#6b7280; border:1px solid #e5e7eb; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; width:fit-content; transition:all 0.2s;"
                    onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#fca5a5'; this.style.color='#dc2626'"
                    onmouseout="this.style.background='transparent'; this.style.borderColor='#e5e7eb'; this.style.color='#6b7280'">
              ✕ Xóa ngày về
            </button>
          </div>
        </div>

      </div>
      
      <input type="hidden" name="is_round_trip" id="isRoundTripHidden" value="0">
    </form>

  </div>
</section>

@push('scripts')
<script>
// Đồng bộ ngày (chuyển Y-m-d -> d-m-Y và hiển thị)
function syncDate(ymd, type) {
  const parts = ymd.split('-');
  const dmy = `${parts[2]}-${parts[1]}-${parts[0]}`;
  const display = `${parts[2]}/${parts[1]}/${parts[0]}`;
  
  if (type === 'depart') {
    document.getElementById('departDateHidden').value = dmy;
    document.getElementById('departDateDisplay').textContent = display;
    
    // Đảm bảo ngày về >= ngày đi + 1
    const departDate = new Date(ymd);
    const minReturn = new Date(departDate);
    minReturn.setDate(minReturn.getDate() + 1);
    const returnInput = document.getElementById('returnDate_raw');
    returnInput.min = minReturn.toISOString().split('T')[0];
    
    if (new Date(returnInput.value) < minReturn) {
      returnInput.value = returnInput.min;
      syncDate(returnInput.value, 'return');
    }
  } else if (type === 'return') {
    document.getElementById('returnDateHidden').value = dmy;
    document.getElementById('returnDateDisplay').textContent = display;
  }
}

// Toggle ngày về khi click button
function toggleReturnDateField() {
  const row = document.getElementById('returnDateRow');
  const btn = document.getElementById('toggleReturnBtn');
  const hiddenInput = document.getElementById('isRoundTripHidden');
  
  if (row.style.display === 'none') {
    row.style.display = 'block';
    btn.style.display = 'none';
    hiddenInput.value = '1';
  } else {
    row.style.display = 'none';
    btn.style.display = 'block';
    hiddenInput.value = '0';
  }
}

// Legacy function (không dùng nữa nhưng giữ lại để tránh lỗi)
function toggleReturnDate(show) {
  toggleReturnDateField();
}

// Cập nhật hiển thị location (rút gọn tên dài)
function updateLocationDisplay(type, value) {
  const displayId = type === 'from' ? 'fromDisplay' : 'toDisplay';
  let shortName = value || (type === 'from' ? 'Chọn điểm đi' : 'Chọn điểm đến');
  
  // Rút gọn tên thành phố
  if (shortName === 'TP. Hồ Chí Minh') shortName = 'Sài Gòn';
  if (shortName === 'Thành phố Hồ Chí Minh') shortName = 'Sài Gòn';
  
  document.getElementById(displayId).textContent = shortName;
}

// Hoán đổi điểm đi/đến
function swapLocations() {
  const fromSelect = document.getElementById('fromLocation');
  const toSelect = document.getElementById('toLocation');
  
  const tempValue = fromSelect.value;
  fromSelect.value = toSelect.value;
  toSelect.value = tempValue;
  
  updateLocationDisplay('from', fromSelect.value);
  updateLocationDisplay('to', toSelect.value);
}

// Thay đổi số ghế
function changeSeats(delta) {
  const input = document.getElementById('seatsInput');
  const newValue = Math.max(1, Math.min(50, parseInt(input.value || 1) + delta));
  input.value = newValue;
}

function validateSeats() {
  const input = document.getElementById('seatsInput');
  let val = parseInt(input.value);
  if (isNaN(val) || val < 1) val = 1;
  if (val > 50) val = 50;
  input.value = val;
}

// Khởi tạo giá trị ban đầu
document.addEventListener('DOMContentLoaded', function() {
  updateLocationDisplay('from', document.getElementById('fromLocation').value);
  updateLocationDisplay('to', document.getElementById('toLocation').value);
});
</script>
@endpush
