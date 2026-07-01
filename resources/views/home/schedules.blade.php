{{-- LỊCH TRÌNH HÔM NAY — bám sát homepage/schedules.blade.php.html --}}
@if($popularSchedules->isNotEmpty())
@php
  $route = $ntRoute ?? $popularSchedules->first()->route;
  $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
  $goSchedules = $popularSchedules->values();
  $returnSchedules = $popularSchedules
      ->map(function ($schedule) {
          $clone = clone $schedule;
          $clone->departure_time = \Carbon\Carbon::parse($schedule->departure_time)->subMinutes(30)->format('H:i:s');
          return $clone;
      })
      ->values();

  $splitDayNight = function ($items) {
      $day = collect();
      $night = collect();

      foreach ($items as $item) {
          $hour = \Carbon\Carbon::parse($item->departure_time)->hour;
          if ($hour < 18) {
              $day->push($item);
          } else {
              $night->push($item);
          }
      }

      return [$day->values(), $night->values()];
  };

  [$goDaySchedules, $goNightSchedules] = $splitDayNight($goSchedules);
  [$returnDaySchedules, $returnNightSchedules] = $splitDayNight($returnSchedules);

  $describeRange = function ($items, $afterLabel = 'Khởi hành từ', $emptyLabel = 'Chưa có lịch') {
      if ($items->isEmpty()) {
          return $emptyLabel;
      }

      $first = \Carbon\Carbon::parse($items->first()->departure_time)->format('H:i');
      $last = \Carbon\Carbon::parse($items->last()->departure_time)->format('H:i');

      if ($first === $last) {
          return $afterLabel . ' ' . $first . ' • ' . $items->count() . ' chuyến';
      }

      return $afterLabel . ' ' . $first . ' - ' . $last . ' • ' . $items->count() . ' chuyến';
  };

  $priceText = number_format($route->price_from) . 'đ';
  $routeName = $setting('home_schedules_route_text', trim(($route->from_location ?? 'Sài Gòn') . ' ⇄ ' . ($route->to_location ?? 'Nha Trang')));
  $scheduleImage = !empty($settings['home_schedules_image'])
      ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings['home_schedules_image'])
      : null;
@endphp

<section style="padding:86px 0 96px; background:#f4f8f1;">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:22px; flex-wrap:wrap;" class="schedule-section-header">
      <div style="min-width:0;">
        <div style="display:inline-block; background:#e4f4df; color:#0a6b39; padding:7px 14px; border-radius:20px; font-size:13px; font-weight:800; margin-bottom:12px;">{{ $setting('home_schedules_badge', '● KHỞI HÀNH TRONG NGÀY') }}</div>
        <h2 style="font-size:38px; color:#0b3d26; margin:0 0 8px; letter-spacing:-1px;">{{ $setting('home_schedules_title', 'Lịch trình hôm nay') }}</h2>
        <p style="color:#5b6d63; font-size:15px; line-height:1.6; margin:0;">{{ $setting('home_schedules_description', 'Cập nhật liên tục các chuyến xe trong ngày, dễ dàng chọn giờ phù hợp với lịch trình của bạn.') }}</p>
      </div>

      <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; min-width:460px;" class="schedule-info-box">
        <div style="background:#fff; border-radius:14px; padding:14px 16px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
          <div style="width:34px; height:34px; border-radius:50%; background:#eef8ea; display:flex; align-items:center; justify-content:center; color:#0b6b3a; font-size:17px; flex-shrink:0;">⇄</div>
          <div>
            <span style="display:block; font-size:11px; color:#718075; margin-bottom:4px; font-weight:700;">Tuyến đường</span>
            <strong style="font-size:13px; color:#143f2c;">{{ $routeName }}</strong>
          </div>
        </div>

        <div style="background:#fff; border-radius:14px; padding:14px 16px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
          <div style="width:34px; height:34px; border-radius:50%; background:#eef8ea; display:flex; align-items:center; justify-content:center; color:#0b6b3a; font-size:17px; flex-shrink:0;">⏱</div>
          <div>
            <span style="display:block; font-size:11px; color:#718075; margin-bottom:4px; font-weight:700;">Thời gian di chuyển</span>
            <strong style="font-size:13px; color:#143f2c;">{{ $route->estimated_time ?? '9 - 10 giờ' }}</strong>
          </div>
        </div>

        <div style="background:#fff; border-radius:14px; padding:14px 16px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
          <div style="width:34px; height:34px; border-radius:50%; background:#eef8ea; display:flex; align-items:center; justify-content:center; color:#0b6b3a; font-size:17px; flex-shrink:0;">🛡</div>
          <div>
            <span style="display:block; font-size:11px; color:#718075; margin-bottom:4px; font-weight:700;">Cam kết</span>
            <strong style="font-size:13px; color:#143f2c;">Đúng giờ - An toàn</strong>
          </div>
        </div>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;" class="schedule-route-grid">
      <div style="background:#fff; border-radius:18px; overflow:hidden; box-shadow:0 14px 34px rgba(7,56,34,0.12); border:1px solid #e3eee2;">
        <div style="min-height:150px; padding:18px; position:relative; color:#fff; background:linear-gradient(90deg, rgba(2, 60, 31, 0.98), rgba(2, 84, 45, 0.82), rgba(2, 60, 31, 0.35)), url('{{ $scheduleImage ?: ($route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png')) }}'); background-size:cover; background-position:center right;">
          <div style="content:''; position:absolute; right:18px; bottom:12px; width:230px; height:90px; background:linear-gradient(135deg,#062d19,#0e6b3a); border-radius:20px 20px 8px 8px; box-shadow:0 12px 30px rgba(0,0,0,0.35); opacity:0.95; clip-path:polygon(6% 18%, 84% 8%, 100% 36%, 95% 80%, 12% 86%, 0 58%);"></div>
          <div style="content:''; position:absolute; right:115px; bottom:30px; width:230px; height:78px; background:linear-gradient(135deg,#08331d,#157647); border-radius:20px 20px 8px 8px; box-shadow:0 12px 24px rgba(0,0,0,0.28); opacity:0.75; clip-path:polygon(8% 20%, 82% 6%, 100% 34%, 93% 80%, 10% 86%, 0 56%);"></div>
          <div style="position:relative; z-index:2; max-width:62%;" class="schedule-route-content">
            <div style="display:inline-block; padding:5px 11px; border-radius:18px; background:#ffd25a; color:#06391f; font-size:12px; font-weight:900; margin-bottom:12px;">CHIỀU ĐI</div>
            <h3 style="font-size:26px; margin:0 0 8px; line-height:1.2;">{{ $setting('home_schedules_go_title', 'Sài Gòn → Nha Trang') }}</h3>
            <p style="font-size:13px; opacity:0.95; line-height:1.5; margin:0;">Xuất phát từ <strong>99 Nguyễn Cư Trinh, Quận 1</strong></p>
          </div>
        </div>

        <div style="padding:14px;">
          @foreach([
            ['☀️ BAN NGÀY', $describeRange($goDaySchedules, 'Khởi hành từ', 'Ban ngày chưa có chuyến'), $goDaySchedules, '#fff6dc', '#7b5700'],
            ['🌙 BAN ĐÊM', $describeRange($goNightSchedules, 'Khởi hành sau', 'Ban đêm chưa có chuyến'), $goNightSchedules, 'linear-gradient(90deg, #052b66, #063c8f)', '#fff'],
          ] as [$groupLabel, $rangeLabel, $items, $groupBackground, $groupColor])
          @if($items->isNotEmpty())
          <div style="margin-bottom:14px; border:1px solid #e4efe2; border-radius:14px; overflow:hidden;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; font-size:13px; font-weight:900; background:{{ $groupBackground }}; color:{{ $groupColor }};">
              <span>{{ $groupLabel }}</span>
              <span style="font-size:12px; opacity:0.9;">{{ $rangeLabel }}</span>
            </div>

            @foreach($items as $schedule)
            <a href="{{ route('booking.search', ['route_id' => $schedule->route_id, 'departDate' => now()->format('d-m-Y')]) }}" style="display:grid; grid-template-columns:72px 1.1fr 1.2fr 0.9fr auto; align-items:center; gap:10px; padding:12px 14px; border-top:1px solid #edf3ec; background:#fff; text-decoration:none;" class="schedule-time-row">
              <div style="font-size:22px; font-weight:900; color:#0d3c28;">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Loại xe</small>
                <strong style="font-size:12px; color:#153f2d;">Limousine 24 phòng</strong>
              </div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Giường nằm</small>
                <strong style="font-size:12px; color:#153f2d;">Cao cấp</strong>
              </div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Giá vé từ</small>
                <strong style="font-size:13px; color:#0b7a42; font-weight:900;">{{ $priceText }}</strong>
              </div>
              <span style="border:none; background:#073c24; color:#fff; border-radius:16px; padding:8px 13px; font-size:12px; font-weight:800; cursor:pointer; white-space:nowrap; display:inline-flex; align-items:center; justify-content:center;">Chọn chuyến</span>
            </a>
            @endforeach
          </div>
          @endif
          @endforeach
        </div>
      </div>

      <div style="background:#fff; border-radius:18px; overflow:hidden; box-shadow:0 14px 34px rgba(7,56,34,0.12); border:1px solid #e3eee2;">
        <div style="min-height:150px; padding:18px; position:relative; color:#fff; background:linear-gradient(90deg, rgba(2, 60, 31, 0.98), rgba(2, 84, 45, 0.82), rgba(2, 60, 31, 0.35)), url('{{ $scheduleImage ?: ($route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png')) }}'); background-size:cover; background-position:center right;">
          <div style="content:''; position:absolute; right:18px; bottom:12px; width:230px; height:90px; background:linear-gradient(135deg,#062d19,#0e6b3a); border-radius:20px 20px 8px 8px; box-shadow:0 12px 30px rgba(0,0,0,0.35); opacity:0.95; clip-path:polygon(6% 18%, 84% 8%, 100% 36%, 95% 80%, 12% 86%, 0 58%);"></div>
          <div style="content:''; position:absolute; right:115px; bottom:30px; width:230px; height:78px; background:linear-gradient(135deg,#08331d,#157647); border-radius:20px 20px 8px 8px; box-shadow:0 12px 24px rgba(0,0,0,0.28); opacity:0.75; clip-path:polygon(8% 20%, 82% 6%, 100% 34%, 93% 80%, 10% 86%, 0 56%);"></div>
          <div style="position:relative; z-index:2; max-width:62%;" class="schedule-route-content">
            <div style="display:inline-block; padding:5px 11px; border-radius:18px; background:#ffd25a; color:#06391f; font-size:12px; font-weight:900; margin-bottom:12px;">CHIỀU VỀ</div>
            <h3 style="font-size:26px; margin:0 0 8px; line-height:1.2;">{{ $setting('home_schedules_return_title', 'Nha Trang → Sài Gòn') }}</h3>
            <p style="font-size:13px; opacity:0.95; line-height:1.5; margin:0;">Xuất phát từ <strong>VP Nha Trang</strong></p>
          </div>
        </div>

        <div style="padding:14px;">
          @foreach([
            ['☀️ BAN NGÀY', $describeRange($returnDaySchedules, 'Khởi hành từ', 'Ban ngày chưa có chuyến'), $returnDaySchedules, '#fff6dc', '#7b5700'],
            ['🌙 BAN ĐÊM', $describeRange($returnNightSchedules, 'Khởi hành sau', 'Ban đêm chưa có chuyến'), $returnNightSchedules, 'linear-gradient(90deg, #052b66, #063c8f)', '#fff'],
          ] as [$groupLabel, $rangeLabel, $items, $groupBackground, $groupColor])
          @if($items->isNotEmpty())
          <div style="margin-bottom:14px; border:1px solid #e4efe2; border-radius:14px; overflow:hidden;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; font-size:13px; font-weight:900; background:{{ $groupBackground }}; color:{{ $groupColor }};">
              <span>{{ $groupLabel }}</span>
              <span style="font-size:12px; opacity:0.9;">{{ $rangeLabel }}</span>
            </div>

            @foreach($items as $schedule)
            <a href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => now()->format('d-m-Y')]) }}" style="display:grid; grid-template-columns:72px 1.1fr 1.2fr 0.9fr auto; align-items:center; gap:10px; padding:12px 14px; border-top:1px solid #edf3ec; background:#fff; text-decoration:none;" class="schedule-time-row">
              <div style="font-size:22px; font-weight:900; color:#0d3c28;">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Loại xe</small>
                <strong style="font-size:12px; color:#153f2d;">Limousine 24 phòng</strong>
              </div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Giường nằm</small>
                <strong style="font-size:12px; color:#153f2d;">Cao cấp</strong>
              </div>
              <div>
                <small style="display:block; font-size:11px; color:#728277; margin-bottom:4px;">Giá vé từ</small>
                <strong style="font-size:13px; color:#0b7a42; font-weight:900;">{{ $priceText }}</strong>
              </div>
              <span style="border:none; background:#073c24; color:#fff; border-radius:16px; padding:8px 13px; font-size:12px; font-weight:800; cursor:pointer; white-space:nowrap; display:inline-flex; align-items:center; justify-content:center;">Chọn chuyến</span>
            </a>
            @endforeach
          </div>
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <style>
    .schedule-time-row:nth-child(even) {
      background: #fbfdf9 !important;
    }
    .schedule-time-row:hover {
      background: #f7fbf4 !important;
    }
    @media (max-width: 1000px) {
      .schedule-section-header {
        flex-direction: column !important;
      }
      .schedule-info-box {
        width: 100% !important;
        min-width: unset !important;
      }
      .schedule-route-grid {
        grid-template-columns: 1fr !important;
      }
    }
    @media (max-width: 650px) {
      section[style*='padding:86px 0 96px'] > div {
        padding: 0 16px !important;
      }
      .schedule-info-box {
        grid-template-columns: 1fr !important;
      }
      .schedule-route-content {
        max-width: 100% !important;
      }
      .schedule-time-row {
        grid-template-columns: 1fr !important;
        gap: 7px !important;
      }
      .schedule-time-row span[style*='background:#073c24'] {
        width: 100%;
      }
    }
  </style>
</section>
@endif
