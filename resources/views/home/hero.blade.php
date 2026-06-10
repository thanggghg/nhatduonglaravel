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
          style="border-radius:24px; background:rgba(255,255,255,0.98); border:2px solid rgba(11,127,66,0.12); box-shadow:0 20px 60px rgba(11,127,66,0.22); overflow:hidden; backdrop-filter:blur(12px); max-width:1100px; margin:0 auto;">

      {{-- Header --}}
      <div style="padding:20px 28px; background:linear-gradient(135deg, #f5faf4 0%, #e8f5e9 100%); border-bottom:2px solid #e4f0e2;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
          <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:10px; height:10px; border-radius:50%; background:#0b7f42; box-shadow:0 0 0 3px rgba(11,127,66,0.2);"></div>
            <span style="color:#0b7f42; font-size:16px; font-weight:900; letter-spacing:0.3px;">Tìm chuyến xe</span>
          </div>
          <div style="display:flex; align-items:center; gap:20px; background:#fff; padding:8px 16px; border-radius:12px; border:1px solid #dcebd8;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
              <input type="radio" name="trip_type" value="one_way" checked onchange="toggleReturnDate(false)" style="width:18px; height:18px; accent-color:#0b7f42;">
              <span style="color:#173014; font-size:14px; font-weight:800;">Một chiều</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
              <input type="radio" name="trip_type" value="round_trip" onchange="toggleReturnDate(true)" style="width:18px; height:18px; accent-color:#0b7f42;">
              <span style="color:#173014; font-size:14px; font-weight:800;">Khứ hồi</span>
            </label>
          </div>
        </div>
        <input type="hidden" name="is_round_trip" id="isRoundTripHidden" value="0">
      </div>

      {{-- Body --}}
      <div style="padding:28px;">
        
        {{-- Row 1: Locations --}}
        <div style="display:grid; grid-template-columns:1fr auto 1fr; gap:0; border:2px solid #dcebd8; border-radius:16px; overflow:hidden; background:#fff; margin-bottom:16px; box-shadow:0 2px 8px rgba(11,127,66,0.06);">
          
          {{-- From --}}
          <div style="padding:18px 20px; border-right:1px solid #e4f0e2; position:relative; min-height:90px; display:flex; flex-direction:column; justify-content:center; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#f5faf4'" onmouseout="this.style.background='#fff'">
            <label style="color:#62735e; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Điểm đi</label>
            <select name="from_location" id="fromLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                    onchange="updateLocationDisplay('from', this.value)">
              <option value="">Chọn điểm đi</option>
              @foreach($fromLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'TP. Hồ Chí Minh' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:12px; pointer-events:none;">
              <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg, #0b7f42, #0a6535); display:grid; place-items:center; flex-shrink:0; box-shadow:0 4px 12px rgba(11,127,66,0.25);">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/></svg>
              </div>
              <div style="flex:1; min-width:0;">
                <div id="fromDisplay" style="color:#173014; font-size:17px; font-weight:900; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">TP. Hồ Chí Minh</div>
                <div style="color:#7e927a; font-size:12px; font-weight:700;">Điểm xuất phát</div>
              </div>
            </div>
          </div>

          {{-- Swap --}}
          <button type="button" onclick="swapLocations()" 
                  style="width:50px; display:grid; place-items:center; border:none; background:#f5faf4; border-left:1px solid #e4f0e2; border-right:1px solid #e4f0e2; color:#0b7f42; font-size:24px; font-weight:900; cursor:pointer; transition:all 0.2s;"
                  onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'; this.style.transform='rotate(180deg)'"
                  onmouseout="this.style.background='#f5faf4'; this.style.color='#0b7f42'; this.style.transform='none'">
            ⇄
          </button>

          {{-- To --}}
          <div style="padding:18px 20px; position:relative; min-height:90px; display:flex; flex-direction:column; justify-content:center; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#fff5f2'" onmouseout="this.style.background='#fff'">
            <label style="color:#62735e; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Điểm đến</label>
            <select name="to_location" id="toLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                    onchange="updateLocationDisplay('to', this.value)">
              <option value="">Chọn điểm đến</option>
              @foreach($toLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'Nha Trang' ? 'selected' : '' }}>{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:12px; pointer-events:none;">
              <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg, #ef5423, #d43f14); display:grid; place-items:center; flex-shrink:0; box-shadow:0 4px 12px rgba(239,84,35,0.25);">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
              </div>
              <div style="flex:1; min-width:0;">
                <div id="toDisplay" style="color:#173014; font-size:17px; font-weight:900; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Nha Trang</div>
                <div style="color:#7e927a; font-size:12px; font-weight:700;">Điểm đích</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Row 2: Dates & Seats --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:20px;">
          
          {{-- Depart date --}}
          <div style="padding:18px 20px; border:2px solid #dcebd8; border-radius:16px; background:#fff; position:relative; min-height:90px; display:flex; flex-direction:column; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(11,127,66,0.06); transition:all 0.2s;" onmouseover="this.style.borderColor='#0b7f42'; this.style.boxShadow='0 4px 16px rgba(11,127,66,0.12)'" onmouseout="this.style.borderColor='#dcebd8'; this.style.boxShadow='0 2px 8px rgba(11,127,66,0.06)'">
            <label style="color:#62735e; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Ngày đi</label>
            <input type="date" name="departDate_raw" id="departDate_raw"
                   value="{{ now()->format('Y-m-d') }}"
                   min="{{ now()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                   onchange="syncDate(this.value, 'depart')">
            <div style="display:flex; align-items:center; gap:12px; pointer-events:none;">
              <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg, #0b7f42, #0a6535); display:grid; place-items:center; flex-shrink:0; box-shadow:0 4px 12px rgba(11,127,66,0.25);">
                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              </div>
              <div style="flex:1;">
                <div id="departDateDisplay" style="color:#173014; font-size:17px; font-weight:900;">{{ now()->format('d/m/Y') }}</div>
                <div style="color:#7e927a; font-size:12px; font-weight:700;">Khởi hành</div>
              </div>
            </div>
            <input type="hidden" name="departDate" id="departDateHidden" value="{{ now()->format('d-m-Y') }}">
          </div>

          {{-- Return date --}}
          <div id="returnDateWrapper" style="padding:18px 20px; border:2px solid #dcebd8; border-radius:16px; background:#fff; position:relative; min-height:90px; display:none; flex-direction:column; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(239,84,35,0.06); transition:all 0.2s;" onmouseover="this.style.borderColor='#ef5423'; this.style.boxShadow='0 4px 16px rgba(239,84,35,0.12)'" onmouseout="this.style.borderColor='#dcebd8'; this.style.boxShadow='0 2px 8px rgba(239,84,35,0.06)'">
            <label style="color:#62735e; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Ngày về</label>
            <input type="date" name="returnDate_raw" id="returnDate_raw"
                   value="{{ now()->addDays(2)->format('Y-m-d') }}"
                   min="{{ now()->addDay()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                   onchange="syncDate(this.value, 'return')">
            <div style="display:flex; align-items:center; gap:12px; pointer-events:none;">
              <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg, #ef5423, #d43f14); display:grid; place-items:center; flex-shrink:0; box-shadow:0 4px 12px rgba(239,84,35,0.25);">
                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              </div>
              <div style="flex:1;">
                <div id="returnDateDisplay" style="color:#173014; font-size:17px; font-weight:900;">{{ now()->addDays(2)->format('d/m/Y') }}</div>
                <div style="color:#7e927a; font-size:12px; font-weight:700;">Trở về</div>
              </div>
            </div>
            <input type="hidden" name="returnDate" id="returnDateHidden" value="{{ now()->addDays(2)->format('d-m-Y') }}">
          </div>

          {{-- Seats --}}
          <div style="padding:18px 20px; border:2px solid #dcebd8; border-radius:16px; background:#fff; min-height:90px; display:flex; flex-direction:column; justify-content:center; box-shadow:0 2px 8px rgba(11,127,66,0.06);">
            <label style="color:#62735e; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Số ghế</label>
            <div style="display:flex; align-items:center; gap:12px;">
              <button type="button" onclick="changeSeats(-1)" 
                      style="width:40px; height:40px; border-radius:12px; background:#e4f0e2; border:2px solid #dcebd8; color:#0b7f42; font-size:20px; font-weight:900; cursor:pointer; display:grid; place-items:center; transition:all 0.2s;"
                      onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'; this.style.borderColor='#0b7f42'"
                      onmouseout="this.style.background='#e4f0e2'; this.style.color='#0b7f42'; this.style.borderColor='#dcebd8'">
                −
              </button>
              <input type="number" name="seats" id="seatsInput" value="1" min="1" max="50" required
                     style="width:70px; text-align:center; border:2px solid #dcebd8; border-radius:12px; padding:10px; color:#173014; font-size:18px; font-weight:900; outline:none;"
                     onchange="validateSeats()"
                     onfocus="this.style.borderColor='#0b7f42'"
                     onblur="this.style.borderColor='#dcebd8'">
              <button type="button" onclick="changeSeats(1)" 
                      style="width:40px; height:40px; border-radius:12px; background:#e4f0e2; border:2px solid #dcebd8; color:#0b7f42; font-size:20px; font-weight:900; cursor:pointer; display:grid; place-items:center; transition:all 0.2s;"
                      onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'; this.style.borderColor='#0b7f42'"
                      onmouseout="this.style.background='#e4f0e2'; this.style.color='#0b7f42'; this.style.borderColor='#dcebd8'">
                +
              </button>
              <div style="flex:1;">
                <div style="color:#173014; font-size:17px; font-weight:900;">Hành khách</div>
                <div style="color:#7e927a; font-size:12px; font-weight:700;">Tối đa 50</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Submit button --}}
        <button type="submit"
                style="width:100%; padding:18px; background:linear-gradient(135deg, #fbb116, #f59e0b); color:#5a3e00; font-size:18px; font-weight:900; border:none; border-radius:16px; cursor:pointer; box-shadow:0 8px 24px rgba(251,177,22,0.35); transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:12px; text-transform:uppercase; letter-spacing:0.5px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(251,177,22,0.45)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(251,177,22,0.35)'">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 004.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0018 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
          Tìm chuyến xe
        </button>
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
  const parent = wrapper.parentElement;
  
  if (show) {
    wrapper.style.display = 'flex';
    hiddenInput.value = '1';
    parent.style.gridTemplateColumns = '1fr 1fr 1fr'; // 3 cột: ngày đi + ngày về + số ghế
  } else {
    wrapper.style.display = 'none';
    hiddenInput.value = '0';
    parent.style.gridTemplateColumns = '2fr 1fr'; // 2 cột: ngày đi (rộng hơn) + số ghế
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
  
  // Set initial grid layout (2 cột vì mặc định là một chiều)
  const parent = document.getElementById('returnDateWrapper').parentElement;
  parent.style.gridTemplateColumns = '2fr 1fr';
});
</script>
@endpush
