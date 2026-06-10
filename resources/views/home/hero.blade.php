{{-- HERO: ảnh nền sáng + overlay nhẹ, promo banner, search form, benefits bar --}}
<section style="position:relative; overflow:hidden; background:#f5faf4; min-height:75vh;">

  {{-- Background ảnh xe với overlay trắng nhẹ (không xanh) --}}
  @php
    $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
    $heroImage = $heroBanner && $heroBanner->hasImage()
        ? $heroBanner->image_url
        : asset('nha-xe-binh-minh-bus-2048x867.png');
    
    // Chỉ cho phép 3 địa điểm: Sài Gòn, Cam Ranh, Nha Trang
    $allowedLocations = ['TP. Hồ Chí Minh', 'Cam Ranh', 'Nha Trang'];
    $fromLocations = collect($allowedLocations);
    $toLocations = collect($allowedLocations);
  @endphp
  <div style="position:absolute; inset:0; min-height:75vh;">
    <img src="{{ $heroImage }}"
         alt="{{ $heroBanner->title ?? '' }}" aria-hidden="true"
         style="width:100%; height:100%; object-fit:cover; object-position:center; animation:subtle-zoom 22s ease-in-out infinite alternate;">
    {{-- Overlay gradient để text dễ đọc --}}
    <div style="position:absolute; inset:0; background:linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.2) 100%);"></div>
  </div>

  <div style="position:relative; z-index:2; width:min(1280px,94%); margin:0 auto; padding:60px 16px 48px; display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:75vh;">

    {{-- TITLE & SUBTITLE --}}
    <div style="text-align:center; margin-bottom:40px;">
      {{-- Main Title with background --}}
      @if($heroBanner && $heroBanner->title)
        <h1 style="color:#062d1c; font-size:clamp(32px,5vw,56px); font-weight:700; margin:0 0 16px; line-height:1.1; letter-spacing:-1.12px; font-family:'Inter',sans-serif; display:inline-block; background:rgba(255,255,255,0.96); padding:16px 32px; border-radius:16px; box-shadow:0 8px 24px rgba(11,127,66,0.12);">
          {{ $heroBanner->title }}
        </h1>
      @else
        <h1 style="color:#062d1c; font-size:clamp(32px,5vw,56px); font-weight:700; margin:0 0 16px; line-height:1.1; letter-spacing:-1.12px; font-family:'Inter',sans-serif; display:inline-block; background:rgba(255,255,255,0.96); padding:16px 32px; border-radius:16px; box-shadow:0 8px 24px rgba(11,127,66,0.12);">
          Đặt vé xe Nhật Dương
        </h1>
      @endif

      {{-- Subtitle with background --}}
      @if($heroBanner && $heroBanner->subtitle)
        <div style="display:flex; justify-content:center;">
          <p style="color:#2c3e36; font-size:clamp(16px,2vw,20px); font-weight:500; margin:0; line-height:1.4; letter-spacing:-0.4px; font-family:'Inter',sans-serif; max-width:700px; background:rgba(255,255,255,0.92); padding:12px 24px; border-radius:12px; box-shadow:0 4px 16px rgba(11,127,66,0.1);">
            {{ $heroBanner->subtitle }}
          </p>
        </div>
      @endif
    </div>

    {{-- SEARCH CARD - Single Row with Header --}}
    <form action="{{ route('booking.search') }}" method="GET"
          style="border-radius:16px; background:rgba(255,255,255,0.98); border:1px solid rgba(11,127,66,0.12); box-shadow:0 10px 40px rgba(11,127,66,0.2); overflow:hidden; backdrop-filter:blur(12px); max-width:1200px; margin:0 auto;">

      {{-- Header with trip type --}}
      <div style="padding:14px 24px; background:#f8fdf9; border-bottom:1px solid #d1ddd5; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:10px;">
          <div style="width:8px; height:8px; border-radius:50%; background:#0b7f42;"></div>
          <span style="color:#0b7f42; font-size:14px; font-weight:700; font-family:'Inter',sans-serif;">Đặt vé trực tuyến</span>
        </div>
        <div style="display:flex; align-items:center; gap:16px;">
          <label style="display:flex; align-items:center; gap:6px; cursor:pointer; padding:6px 14px; border-radius:8px; transition:all 0.15s; font-family:'Inter',sans-serif;"
                 id="oneWayLabel"
                 onclick="setTripType('one_way')"
                 onmouseover="if(!document.getElementById('oneWayRadio').checked) this.style.background='#e8f8ef'"
                 onmouseout="if(!document.getElementById('oneWayRadio').checked) this.style.background='transparent'">
            <input type="radio" name="trip_type" id="oneWayRadio" value="one_way" checked style="width:16px; height:16px; accent-color:#0b7f42; cursor:pointer;">
            <span style="color:#2c3e36; font-size:14px; font-weight:600;">Một chiều</span>
          </label>
          <label style="display:flex; align-items:center; gap:6px; cursor:pointer; padding:6px 14px; border-radius:8px; transition:all 0.15s; font-family:'Inter',sans-serif;"
                 id="roundTripLabel"
                 onclick="setTripType('round_trip')"
                 onmouseover="if(!document.getElementById('roundTripRadio').checked) this.style.background='#e8f8ef'"
                 onmouseout="if(!document.getElementById('roundTripRadio').checked) this.style.background='transparent'">
            <input type="checkbox" name="trip_type_check" id="roundTripRadio" style="width:16px; height:16px; accent-color:#0b7f42; cursor:pointer;" onchange="toggleReturnDate(this.checked)">
            <span style="color:#2c3e36; font-size:14px; font-weight:600;">Khứ hồi</span>
          </label>
        </div>
      </div>
      <input type="hidden" name="is_round_trip" id="isRoundTripHidden" value="0">

      <div style="padding:16px 20px;">
        {{-- Single horizontal row with all fields --}}
        <div style="display:grid; grid-template-columns:1.2fr auto 1.2fr 1fr 1fr 100px 140px; gap:10px; align-items:center;">
          
          {{-- From --}}
          <div style="position:relative; cursor:pointer; padding:8px 12px; border:1px solid #d1ddd5; border-radius:8px; background:#fff; transition:all 0.15s;"
               onmouseover="this.style.borderColor='#0b7f42'; this.style.boxShadow='0 2px 8px rgba(11,127,66,0.08)'"
               onmouseout="this.style.borderColor='#d1ddd5'; this.style.boxShadow='none'">
            <label style="color:#5a6c62; font-size:11px; font-weight:600; text-transform:uppercase; margin-bottom:3px; display:block; font-family:'Inter',sans-serif; line-height:1;">Điểm đi</label>
            <select name="from_location" id="fromLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2; font-family:'Inter',sans-serif;"
                    onchange="updateLocationDisplay('from', this.value)">
              <option value="" disabled>Chọn điểm đi</option>
              @foreach($fromLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'TP. Hồ Chí Minh' ? 'selected' : '' }} data-icon="📍">{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:6px; pointer-events:none;">
              <div style="width:28px; height:28px; border-radius:6px; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/></svg>
              </div>
              <div style="flex:1; min-width:0;">
                <div id="fromDisplay" style="color:#2c3e36; font-size:14px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family:'Inter',sans-serif;">TP. Hồ Chí Minh</div>
              </div>
              <svg width="14" height="14" fill="#5a6c62" viewBox="0 0 24 24" style="flex-shrink:0;">
                <path d="M7 10l5 5 5-5z"/>
              </svg>
            </div>
          </div>

          {{-- Swap --}}
          <button type="button" onclick="swapLocations()" 
                  style="width:36px; height:36px; display:grid; place-items:center; border:1px solid #d1ddd5; background:#f8fdf9; border-radius:8px; color:#0b7f42; font-size:16px; cursor:pointer; transition:all 0.15s;"
                  onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'; this.style.borderColor='#0b7f42'"
                  onmouseout="this.style.background='#f8fdf9'; this.style.color='#0b7f42'; this.style.borderColor='#d1ddd5'">
            ⇄
          </button>

          {{-- To --}}
          <div style="position:relative; cursor:pointer; padding:8px 12px; border:1px solid #d1ddd5; border-radius:8px; background:#fff; transition:all 0.15s;"
               onmouseover="this.style.borderColor='#0b7f42'; this.style.boxShadow='0 2px 8px rgba(11,127,66,0.08)'"
               onmouseout="this.style.borderColor='#d1ddd5'; this.style.boxShadow='none'">
            <label style="color:#5a6c62; font-size:11px; font-weight:600; text-transform:uppercase; margin-bottom:3px; display:block; font-family:'Inter',sans-serif; line-height:1;">Điểm đến</label>
            <select name="to_location" id="toLocation" required
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2; font-family:'Inter',sans-serif;"
                    onchange="updateLocationDisplay('to', this.value)">
              <option value="" disabled>Chọn điểm đến</option>
              @foreach($toLocations as $loc)
                <option value="{{ $loc }}" {{ $loc === 'Nha Trang' ? 'selected' : '' }} data-icon="🎯">{{ $loc }}</option>
              @endforeach
            </select>
            <div style="display:flex; align-items:center; gap:6px; pointer-events:none;">
              <div style="width:28px; height:28px; border-radius:6px; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
              </div>
              <div style="flex:1; min-width:0;">
                <div id="toDisplay" style="color:#2c3e36; font-size:14px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family:'Inter',sans-serif;">Nha Trang</div>
              </div>
              <svg width="14" height="14" fill="#5a6c62" viewBox="0 0 24 24" style="flex-shrink:0;">
                <path d="M7 10l5 5 5-5z"/>
              </svg>
            </div>
          </div>

          {{-- Depart date --}}
          <div style="position:relative; cursor:pointer; padding:8px 12px; border:1px solid #d1ddd5; border-radius:8px; background:#fff; transition:all 0.15s;"
               onmouseover="this.style.borderColor='#0b7f42'; this.style.boxShadow='0 2px 8px rgba(11,127,66,0.08)'"
               onmouseout="this.style.borderColor='#d1ddd5'; this.style.boxShadow='none'"
               onclick="document.getElementById('departDate_raw').showPicker()">
            <label style="color:#5a6c62; font-size:11px; font-weight:600; text-transform:uppercase; margin-bottom:3px; display:block; font-family:'Inter',sans-serif; pointer-events:none; line-height:1;">Ngày đi</label>
            <input type="date" name="departDate_raw" id="departDate_raw"
                   value="{{ now()->format('Y-m-d') }}"
                   min="{{ now()->format('Y-m-d') }}"
                   style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:2;"
                   onchange="syncDate(this.value, 'depart')">
            <div style="display:flex; align-items:center; gap:6px; pointer-events:none;">
              <div style="width:28px; height:28px; border-radius:6px; background:#0b7f42; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              </div>
              <div id="departDateDisplay" style="color:#2c3e36; font-size:14px; font-weight:600; font-family:'Inter',sans-serif;">{{ now()->format('d/m/Y') }}</div>
            </div>
            <input type="hidden" name="departDate" id="departDateHidden" value="{{ now()->format('d-m-Y') }}">
          </div>

          {{-- Return date (disabled/grayed out by default) --}}
          <div id="returnDateWrapper" style="position:relative; cursor:not-allowed; padding:8px 12px; border:1px solid #d1ddd5; border-radius:8px; background:#f8fdf9; opacity:0.5; transition:all 0.2s;">
            <label style="color:#8a9c92; font-size:11px; font-weight:600; text-transform:uppercase; margin-bottom:3px; display:block; font-family:'Inter',sans-serif; pointer-events:none; line-height:1;">Ngày về</label>
            <input type="date" name="returnDate_raw" id="returnDate_raw"
                   value="{{ now()->addDays(2)->format('Y-m-d') }}"
                   min="{{ now()->addDay()->format('Y-m-d') }}"
                   disabled
                   style="position:absolute; inset:0; opacity:0; cursor:not-allowed; width:100%; height:100%; z-index:2;"
                   onchange="syncDate(this.value, 'return')">
            <div style="display:flex; align-items:center; gap:6px; pointer-events:none;">
              <div style="width:28px; height:28px; border-radius:6px; background:#d1ddd5; display:grid; place-items:center; flex-shrink:0;">
                <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              </div>
              <div id="returnDateDisplay" style="color:#8a9c92; font-size:14px; font-weight:600; font-family:'Inter',sans-serif;">{{ now()->addDays(2)->format('d/m/Y') }}</div>
            </div>
            <input type="hidden" name="returnDate" id="returnDateHidden" value="{{ now()->addDays(2)->format('d-m-Y') }}">
          </div>

          {{-- Seats --}}
          <div style="padding:8px 10px; border:1px solid #d1ddd5; border-radius:8px; background:#fff;">
            <label style="color:#5a6c62; font-size:11px; font-weight:600; text-transform:uppercase; margin-bottom:3px; display:block; font-family:'Inter',sans-serif; line-height:1;">Số ghế</label>
            <div style="display:flex; align-items:center; gap:4px; justify-content:center;">
              <button type="button" onclick="changeSeats(-1)" 
                      style="width:24px; height:24px; border:none; background:#e8f8ef; color:#0b7f42; font-size:14px; font-weight:700; cursor:pointer; display:grid; place-items:center; border-radius:6px; transition:all 0.15s; font-family:'Inter',sans-serif;"
                      onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'"
                      onmouseout="this.style.background='#e8f8ef'; this.style.color='#0b7f42'">
                −
              </button>
              <input type="number" name="seats" id="seatsInput" value="1" min="1" max="50" required
                     style="width:30px; text-align:center; border:none; background:transparent; color:#2c3e36; font-size:14px; font-weight:600; outline:none; font-family:'Inter',sans-serif;">
              <button type="button" onclick="changeSeats(1)" 
                      style="width:24px; height:24px; border:none; background:#e8f8ef; color:#0b7f42; font-size:14px; font-weight:700; cursor:pointer; display:grid; place-items:center; border-radius:6px; transition:all 0.15s; font-family:'Inter',sans-serif;"
                      onmouseover="this.style.background='#0b7f42'; this.style.color='#fff'"
                      onmouseout="this.style.background='#e8f8ef'; this.style.color='#0b7f42'">
                +
              </button>
            </div>
          </div>

          {{-- Submit button --}}
          <button type="submit"
                  style="padding:10px 20px; background:linear-gradient(135deg, #fbb116, #e19f14); color:#8a6300; font-size:15px; font-weight:600; border:none; border-radius:8px; cursor:pointer; box-shadow:0 8px 24px rgba(11,127,66,0.12); transition:all 0.15s; white-space:nowrap; font-family:'Inter',sans-serif;"
                  onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(11,127,66,0.18)'"
                  onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(11,127,66,0.12)'">
            Tìm chuyến
          </button>
        </div>
      </div>
    </form>

  </div>
</section>

@push('scripts')
<style>
/* Custom dropdown styling */
select#fromLocation,
select#toLocation {
  font-family: 'Inter', sans-serif;
  font-size: 16px;
  font-weight: 600;
}

/* Style dropdown options - following DESIGN.md with enhanced design */
select#fromLocation option,
select#toLocation option {
  padding: 14px 20px;
  font-size: 15px;
  font-weight: 500;
  color: #2c3e36;
  background: #fff;
  font-family: 'Inter', sans-serif;
  border-bottom: 1px solid #f0f4f1;
  line-height: 1.6;
  min-height: 48px;
  display: flex;
  align-items: center;
}

/* First option (placeholder) - disabled */
select#fromLocation option:disabled,
select#toLocation option:disabled {
  color: #8a9c92;
  font-weight: 400;
  font-style: italic;
  background: #f8fdf9;
}

/* Hover state - subtle green background with indent animation */
select#fromLocation option:hover:not(:disabled),
select#toLocation option:hover:not(:disabled) {
  background: linear-gradient(90deg, #f8fdf9 0%, #e8f8ef 100%);
  color: #0b7f42;
  font-weight: 600;
  padding-left: 28px;
  cursor: pointer;
  border-left: 4px solid #0b7f42;
}

/* Selected/Checked state - green background with checkmark */
select#fromLocation option:checked,
select#toLocation option:checked {
  background: linear-gradient(135deg, #e8f8ef 0%, #d4f4e2 100%) !important;
  color: #085d32 !important;
  font-weight: 700 !important;
  border-left: 4px solid #0b7f42 !important;
  position: relative;
  padding-left: 28px;
}

/* Add checkmark icon for selected option */
select#fromLocation option:checked::before,
select#toLocation option:checked::before {
  content: '✓ ';
  font-weight: 900;
  color: #0b7f42;
  margin-right: 8px;
}

/* Style the dropdown arrow area */
select#fromLocation:focus,
select#toLocation:focus {
  outline: 2px solid #0b7f42;
  outline-offset: -2px;
  border-radius: 8px;
}

/* Custom dropdown panel styling for Webkit browsers (scrollbar) */
select#fromLocation::-webkit-scrollbar,
select#toLocation::-webkit-scrollbar {
  width: 10px;
  background: #f8fdf9;
}

select#fromLocation::-webkit-scrollbar-track,
select#toLocation::-webkit-scrollbar-track {
  background: #f8fdf9;
  border-radius: 8px;
  margin: 4px 0;
}

select#fromLocation::-webkit-scrollbar-thumb,
select#toLocation::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #d1ddd5 0%, #8a9c92 100%);
  border-radius: 8px;
  border: 2px solid #f8fdf9;
}

select#fromLocation::-webkit-scrollbar-thumb:hover,
select#toLocation::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, #0b7f42 0%, #085d32 100%);
}

/* Firefox scrollbar styling */
select#fromLocation,
select#toLocation {
  scrollbar-width: thin;
  scrollbar-color: #d1ddd5 #f8fdf9;
}
</style>

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

// Toggle ngày về khi chọn khứ hồi (enable/disable thay vì hide/show)
function toggleReturnDate(checked) {
  const wrapper = document.getElementById('returnDateWrapper');
  const input = document.getElementById('returnDate_raw');
  const hiddenInput = document.getElementById('isRoundTripHidden');
  const display = document.getElementById('returnDateDisplay');
  
  if (checked) {
    // Enable return date - following DESIGN.md colors
    wrapper.style.opacity = '1';
    wrapper.style.cursor = 'pointer';
    wrapper.style.background = '#fff';
    wrapper.style.borderColor = '#d1ddd5';
    input.disabled = false;
    input.style.cursor = 'pointer';
    display.style.color = '#2c3e36';
    // Update icon color
    wrapper.querySelector('div[style*="background:#d1ddd5"]').style.background = '#0b7f42';
    wrapper.querySelector('label').style.color = '#5a6c62';
    hiddenInput.value = '1';
    
    // Add click handler to show date picker
    wrapper.onclick = function() {
      document.getElementById('returnDate_raw').showPicker();
    };
    
    // Add hover effect
    wrapper.onmouseover = function() {
      this.style.borderColor = '#0b7f42';
      this.style.boxShadow = '0 2px 8px rgba(11,127,66,0.08)';
    };
    wrapper.onmouseout = function() {
      this.style.borderColor = '#d1ddd5';
      this.style.boxShadow = 'none';
    };
  } else {
    // Disable return date - following DESIGN.md colors
    wrapper.style.opacity = '0.5';
    wrapper.style.cursor = 'not-allowed';
    wrapper.style.background = '#f8fdf9';
    wrapper.style.borderColor = '#d1ddd5';
    input.disabled = true;
    input.style.cursor = 'not-allowed';
    display.style.color = '#8a9c92';
    // Update icon color to gray
    wrapper.querySelector('div[style*="background"]').style.background = '#d1ddd5';
    wrapper.querySelector('label').style.color = '#8a9c92';
    hiddenInput.value = '0';
    
    // Remove click handler
    wrapper.onclick = null;
    
    // Remove hover effect
    wrapper.onmouseover = null;
    wrapper.onmouseout = null;
    wrapper.style.boxShadow = 'none';
  }
}

// Handle radio/checkbox interaction
function setTripType(type) {
  const oneWayRadio = document.getElementById('oneWayRadio');
  const roundTripCheckbox = document.getElementById('roundTripRadio');
  
  if (type === 'one_way') {
    oneWayRadio.checked = true;
    roundTripCheckbox.checked = false;
    toggleReturnDate(false);
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
