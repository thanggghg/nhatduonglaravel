@extends('layouts.app')

@section('content')

@php
  $locale = $locale ?? 'en';
  $bookingCopy = [
    'vi' => ['home' => 'Trang chủ', 'booking' => 'Đặt vé', 'round' => 'Khứ hồi', 'departures' => 'chuyến', 'passengers' => 'hành khách', 'outbound' => 'Chuyến đi', 'return' => 'Chuyến về', 'departure' => 'Khởi hành', 'arrival' => 'Đến nơi', 'vehicle' => 'Xe phòng', 'book' => 'Đặt vé', 'call' => 'Gọi đặt vé', 'empty' => 'Không có chuyến nào', 'empty_text' => 'Vui lòng chọn ngày khác hoặc liên hệ hỗ trợ.', 'support' => 'Cần hỗ trợ đặt vé?', 'support_text' => 'Liên hệ hỗ trợ để xác nhận điểm đón, hành lý và chính sách đổi vé.', 'per_person' => '/người'],
    'en' => ['home' => 'Home', 'booking' => 'Booking', 'round' => 'Round trip', 'departures' => 'departures', 'passengers' => 'passengers', 'outbound' => 'Outbound trip', 'return' => 'Return trip', 'departure' => 'Departure', 'arrival' => 'Arrival', 'vehicle' => 'Sleeper cabin', 'book' => 'Book now', 'call' => 'Contact support', 'empty' => 'No departures available', 'empty_text' => 'Please choose another date or contact support.', 'support' => 'Need booking help?', 'support_text' => 'Contact support to confirm pickup, luggage, and change policy.', 'per_person' => 'per person'],
    'ru' => ['home' => 'Главная', 'booking' => 'Бронирование', 'round' => 'Туда и обратно', 'departures' => 'рейсов', 'passengers' => 'пассажиров', 'outbound' => 'Поездка туда', 'return' => 'Поездка обратно', 'departure' => 'Отправление', 'arrival' => 'Прибытие', 'vehicle' => 'Спальный салон', 'book' => 'Забронировать', 'call' => 'Связаться с поддержкой', 'empty' => 'Нет доступных рейсов', 'empty_text' => 'Выберите другую дату или свяжитесь с поддержкой.', 'support' => 'Нужна помощь с бронированием?', 'support_text' => 'Свяжитесь с поддержкой, чтобы подтвердить посадку, багаж и условия изменения билета.', 'per_person' => 'за человека'],
  ][$locale];
  $locationLabels = [
    'TP. Hồ Chí Minh' => ['vi' => 'TP. Hồ Chí Minh', 'en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
    'Cam Ranh' => ['vi' => 'Cam Ranh', 'en' => 'Cam Ranh', 'ru' => 'Камрань'],
    'Nha Trang' => ['vi' => 'Nha Trang', 'en' => 'Nha Trang', 'ru' => 'Нячанг'],
  ];
  $location = fn ($value) => $locationLabels[$value][$locale] ?? $value;
  $duration = $route->estimated_time ?? '';
  if ($locale === 'en') $duration = str_replace('giờ', 'h', $duration);
  if ($locale === 'ru') $duration = str_replace('giờ', 'ч.', $duration);
@endphp

{{-- Header --}}
<div style="background:#0b7f42; padding:20px 0;">
  <div style="width:min(1280px,94%); margin:0 auto; padding:0 16px;">
    <nav style="font-size:13px; color:rgba(255,255,255,0.65); margin-bottom:10px;">
      <a href="{{ route('home', ['lang' => $locale]) }}" style="color:rgba(255,255,255,0.65); text-decoration:none;">{{ $bookingCopy['home'] }}</a>
      <span style="margin:0 8px;">›</span>
      <span style="color:#fff;">{{ $bookingCopy['booking'] }}</span>
    </nav>
    <h1 style="color:#fff; font-size:clamp(20px,3vw,28px); font-weight:800; margin:0;">
       {{ $location($route->from_location) }} → {{ $location($route->to_location) }}
      @if($isRoundTrip ?? false)
          <span style="opacity:0.8;"> ({{ $bookingCopy['round'] }})</span>
      @endif
    </h1>
    <p style="color:rgba(255,255,255,0.70); font-size:14px; margin:6px 0 0;">
      {{ $date->format('d/m/Y') }} · {{ $schedules->count() }} {{ $bookingCopy['departures'] }}
      @if(isset($seats) && $seats > 1)
          · {{ $seats }} {{ $bookingCopy['passengers'] }}
      @endif
    </p>
  </div>
</div>

{{-- Date picker bar --}}
<div style="background:#fff; border-bottom:1px solid #e4f0e2; position:sticky; top:68px; z-index:10;">
  <div style="width:min(1280px,94%); margin:0 auto; padding:0 16px; display:flex; align-items:center; gap:8px; overflow-x:auto; scrollbar-width:none;">
    @for($i = 0; $i < 7; $i++)
      @php $d = \Carbon\Carbon::today()->addDays($i); $active = $d->isSameDay($date); @endphp
      <a href="{{ route('booking.search', [
            'from_location' => $route->from_location,
            'to_location' => $route->to_location,
            'departDate' => $d->format('d-m-Y'),
            'is_round_trip' => $isRoundTrip ?? false,
            'returnDate' => $returnDateObj?->format('d-m-Y'),
            'seats' => $seats ?? 1,
            'lang' => $locale
          ]) }}"
         style="flex-shrink:0; padding:12px 18px; text-align:center; text-decoration:none; border-bottom:3px solid {{ $active ? '#0b7f42' : 'transparent' }}; color:{{ $active ? '#0b7f42' : '#62735e' }}; font-weight:{{ $active ? '800' : '600' }}; font-size:13px; white-space:nowrap;">
        <div>{{ $d->isoFormat('ddd') }}</div>
        <div style="font-size:15px; font-weight:900;">{{ $d->format('d/m') }}</div>
      </a>
    @endfor
  </div>
</div>

{{-- Content --}}
<div style="background:#f5faf4; min-height:60vh; padding:24px 0 48px;">
  <div style="width:min(1280px,94%); margin:0 auto; padding:0 16px;">

    {{-- CHUYẾN ĐI --}}
    <div style="margin-bottom:32px;">
      <h2 style="color:#173014; font-size:20px; font-weight:900; margin:0 0 16px; display:flex; align-items:center; gap:8px;">
        <span style="display:inline-block; width:8px; height:24px; background:#0b7f42; border-radius:4px;"></span>
        {{ $bookingCopy['outbound'] }}: {{ $location($route->from_location) }} → {{ $location($route->to_location) }}
      </h2>

      @if($schedules->isEmpty())
        <div style="background:#fff; border-radius:16px; padding:48px; text-align:center; border:1px solid #e4f0e2;">
          <div style="font-size:48px; margin-bottom:12px;">🚌</div>
          <h3 style="color:#173014; font-size:18px; font-weight:800; margin:0 0 8px;">{{ $bookingCopy['empty'] }}</h3>
          <p style="color:#62735e; margin:0 0 20px;">{{ $bookingCopy['empty_text'] }}</p>
          <a href="{{ route('contact', ['lang' => $locale]) }}" style="display:inline-flex; align-items:center; gap:8px; background:#0b7f42; color:#fff; padding:12px 24px; border-radius:10px; font-weight:700; text-decoration:none;">
            {{ $bookingCopy['call'] }}
          </a>
        </div>
      @else
        <div style="display:flex; flex-direction:column; gap:12px;">
          @foreach($schedules as $schedule)
          <div style="background:#fff; border-radius:16px; border:1px solid #e4f0e2; padding:20px 24px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; box-shadow:0 2px 8px rgba(11,127,66,0.06);">

            {{-- Giờ --}}
            <div style="min-width:90px; text-align:center;">
              <div style="font-size:26px; font-weight:900; color:#173014; line-height:1;">
                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}
              </div>
              <div style="font-size:12px; color:#62735e; margin-top:2px;">{{ $bookingCopy['departure'] }}</div>
            </div>

            {{-- Arrow + duration --}}
            <div style="display:flex; flex-direction:column; align-items:center; gap:4px; flex:1; min-width:120px;">
              <div style="font-size:11px; color:#62735e; font-weight:700;">{{ $duration }}</div>
              <div style="width:100%; height:2px; background:linear-gradient(90deg,#0b7f42,#fbb116); border-radius:2px; position:relative;">
                <div style="position:absolute; right:-4px; top:-4px; width:10px; height:10px; border-radius:50%; background:#fbb116;"></div>
              </div>
              <div style="font-size:11px; color:#0b7f42; font-weight:700;">{{ $location($route->from_location) }} → {{ $location($route->to_location) }}</div>
            </div>

            {{-- Giờ đến --}}
            <div style="min-width:90px; text-align:center;">
              <div style="font-size:26px; font-weight:900; color:#173014; line-height:1;">
                {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}
              </div>
              <div style="font-size:12px; color:#62735e; margin-top:2px;">{{ $bookingCopy['arrival'] }}</div>
            </div>

            {{-- Loại xe --}}
            <div style="flex:1; min-width:140px;">
              <div style="display:inline-block; background:#eaf8e8; color:#0b7f42; font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; margin-bottom:6px;">
                {{ $schedule->vehicle_type ?? $bookingCopy['vehicle'] }}
              </div>
              @if($schedule->note)
              <div style="font-size:12px; color:#62735e;">{{ $schedule->note }}</div>
              @endif
            </div>

            {{-- Giá + CTA --}}
            <div style="text-align:right; min-width:140px;">
              @php
                $totalPrice = $schedule->price * ($seats ?? 1);
              @endphp
              <div style="font-size:22px; font-weight:900; color:#0b7f42; line-height:1;">
                {{ number_format($totalPrice) }}đ
              </div>
              <div style="font-size:11px; color:#62735e; margin-bottom:10px;">
                @if(($seats ?? 1) > 1)
                  {{ number_format($schedule->price) }}đ × {{ $seats }} ghế
                @else
                   {{ $bookingCopy['per_person'] }}
                @endif
              </div>
              @if($route->booking_url && $route->booking_url !== 'https://example.com/book')
                <a href="{{ route('booking.redirect', ['route_id' => $route->id, 'booking_url' => $route->booking_url, 'source_page' => 'search']) }}"
                   style="display:inline-block; background:linear-gradient(180deg,#ffdc47,#fbb116); color:#5a3e00; font-weight:800; font-size:14px; padding:10px 22px; border-radius:10px; text-decoration:none; box-shadow:0 4px 12px rgba(251,177,22,0.30);">
                   {{ $bookingCopy['book'] }}
                </a>
              @else
                <a href="{{ route('contact', ['lang' => $locale]) }}"
                   style="display:inline-block; background:#0b7f42; color:#fff; font-weight:800; font-size:14px; padding:10px 22px; border-radius:10px; text-decoration:none;">
                   {{ $bookingCopy['call'] }}
                </a>
              @endif
            </div>

          </div>
          @endforeach
        </div>
      @endif
    </div>

    {{-- CHUYẾN VỀ (nếu khứ hồi) --}}
    @if(($isRoundTrip ?? false) && $returnDateObj)
      <div style="margin-bottom:32px;">
        <h2 style="color:#173014; font-size:20px; font-weight:900; margin:0 0 16px; display:flex; align-items:center; gap:8px;">
          <span style="display:inline-block; width:8px; height:24px; background:#ef5423; border-radius:4px;"></span>
          {{ $bookingCopy['return'] }}: {{ $location($route->to_location) }} → {{ $location($route->from_location) }}
          <span style="color:#62735e; font-size:14px; font-weight:700;">({{ $returnDateObj->isoFormat('DD/MM/YYYY') }})</span>
        </h2>

        @if($returnSchedules->isEmpty())
          <div style="background:#fff; border-radius:16px; padding:48px; text-align:center; border:1px solid #e4f0e2;">
            <div style="font-size:48px; margin-bottom:12px;">⚠️</div>
            <h3 style="color:#173014; font-size:18px; font-weight:800; margin:0 0 8px;">Chưa có tuyến ngược lại</h3>
            <p style="color:#62735e; margin:0 0 20px;">Chuyến về từ {{ $route->to_location }} về {{ $route->from_location }} chưa có sẵn trong hệ thống. Vui lòng liên hệ hotline để đặt vé.</p>
            <a href="tel:0123456789" style="display:inline-flex; align-items:center; gap:8px; background:#0b7f42; color:#fff; padding:12px 24px; border-radius:10px; font-weight:700; text-decoration:none;">
              Gọi 1900 2879
            </a>
          </div>
        @else
          <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($returnSchedules as $schedule)
            <div style="background:#fff; border-radius:16px; border:1px solid #e4f0e2; padding:20px 24px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; box-shadow:0 2px 8px rgba(239,84,35,0.06);">

              <div style="min-width:90px; text-align:center;">
                <div style="font-size:26px; font-weight:900; color:#173014; line-height:1;">
                  {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}
                </div>
                <div style="font-size:12px; color:#62735e; margin-top:2px;">Khởi hành</div>
              </div>

              <div style="display:flex; flex-direction:column; align-items:center; gap:4px; flex:1; min-width:120px;">
                <div style="font-size:11px; color:#62735e; font-weight:700;">{{ $schedule->route->estimated_time ?? '' }}</div>
                <div style="width:100%; height:2px; background:linear-gradient(90deg,#ef5423,#fbb116); border-radius:2px; position:relative;">
                  <div style="position:absolute; right:-4px; top:-4px; width:10px; height:10px; border-radius:50%; background:#fbb116;"></div>
                </div>
                <div style="font-size:11px; color:#ef5423; font-weight:700;">{{ $route->to_location }} → {{ $route->from_location }}</div>
              </div>

              <div style="min-width:90px; text-align:center;">
                <div style="font-size:26px; font-weight:900; color:#173014; line-height:1;">
                  {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') }}
                </div>
                <div style="font-size:12px; color:#62735e; margin-top:2px;">Đến nơi</div>
              </div>

              <div style="flex:1; min-width:140px;">
                <div style="display:inline-block; background:#fff5f2; color:#ef5423; font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; margin-bottom:6px;">
                  {{ $schedule->bus_type ?? 'Xe khách' }}
                </div>
                @if($schedule->note)
                <div style="font-size:12px; color:#62735e;">{{ $schedule->note }}</div>
                @endif
              </div>

              <div style="text-align:right; min-width:140px;">
                @php
                  $totalPriceReturn = $schedule->price * ($seats ?? 1);
                @endphp
                <div style="font-size:22px; font-weight:900; color:#ef5423; line-height:1;">
                  {{ number_format($totalPriceReturn) }}đ
                </div>
                <div style="font-size:11px; color:#62735e; margin-bottom:10px;">
                  @if(($seats ?? 1) > 1)
                    {{ number_format($schedule->price) }}đ × {{ $seats }} ghế
                  @else
                    /người
                  @endif
                </div>
                <a href="tel:0123456789"
                   style="display:inline-block; background:#ef5423; color:#fff; font-weight:800; font-size:14px; padding:10px 22px; border-radius:10px; text-decoration:none;">
                  Gọi đặt vé
                </a>
              </div>

            </div>
            @endforeach
          </div>
        @endif
      </div>
    @endif

    {{-- Info box --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #e4f0e2; padding:20px 24px; display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
      <svg width="32" height="32" fill="none" stroke="#0b7f42" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <div>
          <div style="font-weight:800; color:#173014; font-size:14px; margin-bottom:4px;">{{ $bookingCopy['support'] }}</div>
          <div style="color:#62735e; font-size:13px;">{{ $bookingCopy['support_text'] }} <a href="{{ route('contact', ['lang' => $locale]) }}" style="color:#0b7f42; font-weight:800;">{{ $bookingCopy['call'] }}</a>.</div>
      </div>
    </div>

  </div>
</div>

@endsection
