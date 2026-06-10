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
          style="border-radius:20px; background:rgba(255,255,255,0.97); border:1px solid rgba(11,127,66,0.14); box-shadow:0 18px 48px rgba(11,127,66,0.18); overflow:hidden; backdrop-filter:blur(10px);">

      {{-- Header card --}}
      <div style="padding:14px 20px 12px; border-bottom:1px solid #e4f0e2; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:10px;">
          <div style="width:8px; height:8px; border-radius:50%; background:#0b7f42;"></div>
          <span style="color:#0b7f42; font-size:14px; font-weight:800;">Đặt vé trực tuyến</span>
        </div>
        {{-- Radio khứ hồi --}}
        <div style="display:flex; align-items:center; gap:16px;">
          <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
            <input type="radio" name="trip_type" value="one_way" checked onchange="toggleReturnDate(false)" style="width:16px; height:16px; accent-color:#0b7f42;">
            <span style="color:#173014; font-size:13px; font-weight:700;">Một chiều</span>
          </label>
          <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
            <input type="radio" name="trip_type" value="round_trip" onchange="toggleReturnDate(true)" style="width:16px; height:16px; accent-color:#0b7f42;">
            <span style="color:#173014; font-size:13px; font-weight:700;">Khứ hồi</span>
          </label>
        </div>
        <input type="hidden" name="is_round_trip" id="isRoundTripHidden" value="0">
      </div>

      {{-- Form fields --}}
      <div style="padding:14px;">
        {{-- Dòng 1: Điểm đi - Swap - Điểm đến - Ngày đi - Search button --}}
        <div style="display:grid; grid-template-columns:1.1fr 48px 1.1fr 1fr 160px; border:1px solid #dcebd8; border-radius:14px; overflow:hidden; background:#fff; margin-bottom:12px;" class="search-field-row">

          {{-- Điểm đi --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2; position:relative;">
            <label style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Điểm đi</label>
            <select name="from_location" id="fromLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;"
                    onchange="updateLocationDisplay('from', this.value)">
              <option value="">Chọn điểm đi</option>
              @foreach($fromLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'TP. Hồ Chí Minh' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:8px; pointer-events:none;">
              <div style="width:26px; height:26px; border-radius:50%; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>
              </div>
              <div>
                <div id="fromDisplay" style="color:#173014; font-size:15px; font-weight:900;">TP. Hồ Chí Minh</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Bến xe / văn phòng</div>
              </div>
            </div>
          </div>

          {{-- Swap --}}
          <button type="button" onclick="swapLocations()" style="display:grid; place-items:center; border:none; background:transparent; border-right:1px solid #e4f0e2; color:#0b7f42; font-size:20px; font-weight:900; cursor:pointer;">⇄</button>

          {{-- Điểm đến --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2; position:relative;">
            <label style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Điểm đến</label>
            <select name="to_location" id="toLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;"
                    onchange="updateLocationDisplay('to', this.value)">
              <option value="">Chọn điểm đến</option>
              @foreach($toLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'Nha Trang' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:8px; pointer-events:none;">
              <div style="width:26px; height:26px; border-radius:50%; background:#ef5423; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
              </div>
              <div>
                <div id="toDisplay" style="color:#173014; font-size:15px; font-weight:900;">Nha Trang</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Nhiều tuyến</div>
              </div>
            </div>
          </div>

          {{-- Ngày đi --}}
          <div style="min-height:80px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2; position:relative;">
            <label style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Ngày đi</label>
            <input type="date" name="departDate_raw" id="departDate_raw"
                   value="{{ now()->format('Y-m-d') }}"
                   min="{{ now()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;"
                   onchange="syncDate(this.value, 'depart')">
            <div style="display:flex; align-items:center; gap:8px; pointer-events:none;">
              <div style="width:26px; height:26px; border-radius:50%; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
              <div style="flex:1;">
                <div id="departDateDisplay" style="color:#173014; font-size:15px; font-weight:900;">{{ now()->format('d/m/Y') }}</div>
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

        {{-- Dòng 2: Ngày về (ẩn nếu một chiều) + Số ghế --}}
        <div id="additionalFields" style="display:grid; grid-template-columns:1.5fr 1fr; gap:12px; border:1px solid #dcebd8; border-radius:14px; overflow:hidden; background:#fff;">
          
          {{-- Ngày về --}}
          <div id="returnDateWrapper" style="min-height:70px; padding:12px 16px; display:none; flex-direction:column; justify-content:center; border-right:1px solid #e4f0e2; position:relative;">
            <label style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Ngày về</label>
            <input type="date" name="returnDate_raw" id="returnDate_raw"
                   value="{{ now()->addDays(2)->format('Y-m-d') }}"
                   min="{{ now()->addDay()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;"
                   onchange="syncDate(this.value, 'return')">
            <div style="display:flex; align-items:center; gap:8px; pointer-events:none;">
              <div style="width:26px; height:26px; border-radius:50%; background:#ef5423; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
              <div style="flex:1;">
                <div id="returnDateDisplay" style="color:#173014; font-size:15px; font-weight:900;">{{ now()->addDays(2)->format('d/m/Y') }}</div>
                <div style="color:#62735e; font-size:12px; font-weight:700;">Chuyến về</div>
              </div>
            </div>
            <input type="hidden" name="returnDate" id="returnDateHidden" value="{{ now()->addDays(2)->format('d-m-Y') }}">
          </div>

          {{-- Số ghế --}}
          <div style="min-height:70px; padding:12px 16px; display:flex; flex-direction:column; justify-content:center; position:relative;">
            <label style="color:#7e927a; font-size:12px; font-weight:800; margin-bottom:4px;">Số ghế</label>
            <div style="display:flex; align-items:center; gap:10px;">
              <button type="button" onclick="changeSeats(-1)" style="width:32px; height:32px; border-radius:8px; background:#e4f0e2; border:1px solid #dcebd8; color:#0b7f42; font-size:18px; font-weight:900; cursor:pointer; display:grid; place-items:center;">−</button>
              <input type="number" name="seats" id="seatsInput" value="1" min="1" max="50" required
                     style="width:60px; text-align:center; border:1px solid #dcebd8; border-radius:8px; padding:8px; color:#173014; font-size:16px; font-weight:900;"
                     onchange="validateSeats()">
              <button type="button" onclick="changeSeats(1)" style="width:32px; height:32px; border-radius:8px; background:#e4f0e2; border:1px solid #dcebd8; color:#0b7f42; font-size:18px; font-weight:900; cursor:pointer; display:grid; place-items:center;">+</button>
              <span style="color:#62735e; font-size:13px; font-weight:700; margin-left:8px;">hành khách</span>
            </div>
          </div>
        </div>
      </div>
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

// Toggle ngày về khi chọn khứ hồi
function toggleReturnDate(show) {
  const wrapper = document.getElementById('returnDateWrapper');
  const hiddenInput = document.getElementById('isRoundTripHidden');
  
  if (show) {
    wrapper.style.display = 'flex';
    hiddenInput.value = '1';
  } else {
    wrapper.style.display = 'none';
    hiddenInput.value = '0';
  }
}

// Cập nhật hiển thị location
function updateLocationDisplay(type, value) {
  const displayId = type === 'from' ? 'fromDisplay' : 'toDisplay';
  document.getElementById(displayId).textContent = value || (type === 'from' ? 'Chọn điểm đi' : 'Chọn điểm đến');
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
