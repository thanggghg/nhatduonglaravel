@extends('layouts.app')

@php
    $copy = [
        'vi' => [
            'home' => 'Trang chủ', 'title' => 'Chọn chuyến đi', 'outbound' => 'Chiều đi', 'return' => 'Chiều về',
            'departure' => 'Khởi hành', 'arrival' => 'Đến nơi', 'passengers' => 'hành khách', 'available' => 'chỗ còn lại',
            'confirm' => 'Nhà xe xác nhận chỗ khi bạn tiếp tục đặt vé', 'continue' => 'Chọn chuyến này', 'sold_out' => 'Không đủ chỗ',
            'empty' => 'Chưa có chuyến phù hợp', 'empty_text' => 'Vui lòng chọn ngày khác hoặc liên hệ đội ngũ hỗ trợ.',
            'pickup' => 'Điểm đón và trả sẽ được chọn ở bước tiếp theo.', 'support' => 'Cần hỗ trợ đặt vé?', 'support_link' => 'Liên hệ hỗ trợ',
            'per_person' => 'mỗi khách', 'date' => 'Ngày đi', 'live' => 'Lịch chạy trực tuyến', 'route' => 'Tuyến đường',
            'fare' => 'Tổng tiền', 'api_error' => 'Lịch chạy trực tuyến đang tạm thời không khả dụng. Vui lòng thử lại sau.',
            'estimated' => 'Dự kiến', 'minutes' => 'phút', 'hours' => 'giờ', 'to' => 'đến',
        ],
        'en' => [
            'home' => 'Home', 'title' => 'Choose a departure', 'outbound' => 'Outbound', 'return' => 'Return',
            'departure' => 'Departure', 'arrival' => 'Arrival', 'passengers' => 'passengers', 'available' => 'seats remaining',
            'confirm' => 'The operator confirms availability when you continue to booking', 'continue' => 'Choose this departure', 'sold_out' => 'Not enough seats',
            'empty' => 'No matching departures', 'empty_text' => 'Try another travel date or contact our team.',
            'pickup' => 'You will choose pickup and drop-off details in the next step.', 'support' => 'Need booking help?', 'support_link' => 'Contact support',
            'per_person' => 'per passenger', 'date' => 'Travel date', 'live' => 'Live departure times', 'route' => 'Route',
            'fare' => 'Total fare', 'api_error' => 'Live departures are temporarily unavailable. Please try again shortly.',
            'estimated' => 'Estimated', 'minutes' => 'min', 'hours' => 'hr', 'to' => 'to',
        ],
        'ru' => [
            'home' => 'Главная', 'title' => 'Выберите рейс', 'outbound' => 'Туда', 'return' => 'Обратно',
            'departure' => 'Отправление', 'arrival' => 'Прибытие', 'passengers' => 'пассажиров', 'available' => 'мест осталось',
            'confirm' => 'Перевозчик подтверждает наличие мест при переходе к бронированию', 'continue' => 'Выбрать этот рейс', 'sold_out' => 'Недостаточно мест',
            'empty' => 'Подходящих рейсов нет', 'empty_text' => 'Выберите другую дату или свяжитесь с поддержкой.',
            'pickup' => 'Место посадки и высадки выбирается на следующем шаге.', 'support' => 'Нужна помощь?', 'support_link' => 'Связаться с поддержкой',
            'per_person' => 'за пассажира', 'date' => 'Дата поездки', 'live' => 'Актуальное расписание', 'route' => 'Маршрут',
            'fare' => 'Сумма', 'api_error' => 'Актуальное расписание временно недоступно. Попробуйте позже.',
            'estimated' => 'Ориентировочно', 'minutes' => 'мин', 'hours' => 'ч', 'to' => 'в',
        ],
    ][$locale];
    $places = [
        'TP. Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Sài Gòn' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
        'Nha Trang' => ['en' => 'Nha Trang', 'ru' => 'Нячанг'], 'Cam Ranh' => ['en' => 'Cam Ranh', 'ru' => 'Камрань'],
    ];
    $place = fn (string $name) => $locale === 'vi' ? $name : ($places[$name][$locale] ?? $name);
    $from = $place($route->from_location);
    $to = $place($route->to_location);
    $startDate = $date->copy()->subDays(2)->max(today());
    $weekdays = [
        'vi' => ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        'en' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        'ru' => ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    ][$locale];
    $duration = function ($minutes) use ($copy): string {
        if (!$minutes) return $copy['estimated'];
        $minutes = (int) $minutes;
        if ($minutes < 60) return $minutes.' '.$copy['minutes'];
        $hours = intdiv($minutes, 60);
        $remaining = $minutes % 60;
        return $hours.' '.$copy['hours'].($remaining ? ' '.$remaining.' '.$copy['minutes'] : '');
    };
    $filters = [
        'vi' => ['all' => 'Tất cả', 'morning' => 'Sáng', 'afternoon' => 'Chiều', 'evening' => 'Tối', 'seat_map' => 'Xem sơ đồ ghế thực tế ở bước tiếp theo'],
        'en' => ['all' => 'All', 'morning' => 'Morning', 'afternoon' => 'Afternoon', 'evening' => 'Evening', 'seat_map' => 'View the live seat map on the next step'],
        'ru' => ['all' => 'Все', 'morning' => 'Утро', 'afternoon' => 'День', 'evening' => 'Вечер', 'seat_map' => 'Схема мест доступна на следующем шаге'],
    ][$locale];
    $tripPeriod = fn ($departure) => $departure->hour < 12 ? 'morning' : ($departure->hour < 18 ? 'afternoon' : 'evening');
@endphp

@section('content')
<section class="booking-page">
    <header class="booking-hero">
        <div class="booking-shell">
            <nav class="booking-crumb" aria-label="Breadcrumb"><a href="{{ route('home', ['lang' => $locale]) }}">{{ $copy['home'] }}</a><span aria-hidden="true">/</span><span>{{ $copy['title'] }}</span></nav>
            <div class="booking-hero__content">
                <div><span class="booking-kicker">{{ $copy['live'] }}</span><h1>{{ $from }} <span>{{ $copy['to'] }}</span> {{ $to }}</h1><p>{{ $date->format('d/m/Y') }} <i aria-hidden="true"></i> {{ $passengerCount }} {{ $copy['passengers'] }}</p></div>
                <div class="booking-hero__route"><span>{{ $copy['route'] }}</span><strong>{{ $from }} <b aria-hidden="true">→</b> {{ $to }}</strong></div>
            </div>
        </div>
    </header>

    <nav class="booking-date-nav" aria-label="{{ $copy['date'] }}">
        <div class="booking-shell booking-date-nav__inner">
            @for($i = 0; $i < 7; $i++)
                @php
                    $day = $startDate->copy()->addDays($i);
                    $returnForDay = $isRoundTrip && $returnDate && $returnDate->gte($day) ? $returnDate : $day->copy()->addDay();
                @endphp
                <a class="booking-date {{ $day->isSameDay($date) ? 'is-active' : '' }}" href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => $day->format('d-m-Y'), 'is_round_trip' => $isRoundTrip ? 1 : 0, 'returnDate' => $isRoundTrip ? $returnForDay->format('d-m-Y') : null, 'seats' => $passengerCount, 'lang' => $locale]) }}" @if($day->isSameDay($date)) aria-current="date" @endif>
                    <span>{{ $weekdays[$day->dayOfWeek] }}</span><strong>{{ $day->format('d/m') }}</strong>
                </a>
            @endfor
        </div>
    </nav>

    <div class="booking-shell booking-content">
        @if($apiError)<p class="booking-alert" role="alert">{{ $copy['api_error'] }}</p>@endif

        <section aria-labelledby="outbound-title">
            <div class="booking-section-heading"><div><p>{{ $copy['outbound'] }}</p><h2 id="outbound-title">{{ $from }} {{ $copy['to'] }} {{ $to }}</h2></div><span>{{ $date->format('d/m/Y') }}</span></div>
            <div class="booking-confirm"><span aria-hidden="true">✓</span>{{ $filters['seat_map'] }}</div>
            <div class="departure-tools"><div class="departure-filters" role="group" aria-label="{{ $copy['departure'] }}"><button type="button" class="is-active" data-departure-filter="all">{{ $filters['all'] }}</button><button type="button" data-departure-filter="morning">{{ $filters['morning'] }}</button><button type="button" data-departure-filter="afternoon">{{ $filters['afternoon'] }}</button><button type="button" data-departure-filter="evening">{{ $filters['evening'] }}</button></div><span id="departure-filter-count" aria-live="polite"></span></div>
            <div class="departure-list">
                @forelse($trips as $trip)
                    @php $canBook = $trip['available_seats'] >= $passengerCount; $period = $tripPeriod($trip['departure']); @endphp
                    <article class="departure-card {{ $canBook ? '' : 'is-unavailable' }}" data-departure-period="{{ $period }}">
                        <img class="departure-image" src="{{ $trip['image'] ?: asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="Nhat Duong {{ $trip['vehicle_type'] }}" loading="lazy">
                        <div class="departure-journey">
                            <div class="departure-time"><strong>{{ $trip['departure']->format('H:i') }}</strong><span>{{ $copy['departure'] }}</span></div>
                            <div class="departure-line"><span>{{ $duration($trip['duration']) }}</span><i aria-hidden="true"></i><small>{{ $trip['pickup'] }} <b aria-hidden="true">→</b> {{ $trip['dropoff'] }}</small></div>
                            <div class="departure-time"><strong>{{ $trip['arrival']->format('H:i') }}</strong><span>{{ $copy['arrival'] }}</span></div>
                        </div>
                        <div class="departure-meta"><strong>{{ $trip['vehicle_type'] }}</strong></div>
                        <div class="departure-action"><div class="departure-availability"><span>{{ $copy['available'] }}</span><strong>{{ $trip['available_seats'] }}</strong></div><span class="departure-action__label">{{ $copy['fare'] }}</span><strong>{{ number_format($trip['fare'] * $passengerCount) }} VND</strong><small>{{ number_format($trip['fare']) }} {{ $copy['per_person'] }}</small>
                            @if($canBook)<a href="{{ route('booking.live.checkout', ['route_id' => $route->id, 'trip_code' => $trip['code'], 'travel_date' => $date->toDateString(), 'passenger_count' => $passengerCount, 'lang' => $locale]) }}">{{ $copy['continue'] }} <b aria-hidden="true">→</b></a>@else <em>{{ $copy['sold_out'] }}</em>@endif
                        </div>
                    </article>
                @empty
                    <div class="booking-empty"><h3>{{ $copy['empty'] }}</h3><p>{{ $copy['empty_text'] }}</p></div>
                @endforelse
            </div>
        </section>

        @if($isRoundTrip)
            <section class="booking-return" aria-labelledby="return-title">
                <div class="booking-section-heading"><div><p>{{ $copy['return'] }}</p><h2 id="return-title">{{ $to }} {{ $copy['to'] }} {{ $from }}</h2></div><span>{{ $returnDate?->format('d/m/Y') }}</span></div>
                <div class="return-list">
                    @forelse($returnTrips as $trip)
                        <article class="return-preview"><strong>{{ $trip['departure']->format('H:i') }}</strong><span>{{ $trip['vehicle_type'] }}</span><span>{{ $duration($trip['duration']) }}</span><span>{{ $trip['available_seats'].' '.$copy['available'] }}</span><b>{{ number_format($trip['fare']) }} VND</b></article>
                    @empty
                        <div class="booking-empty"><h3>{{ $copy['empty'] }}</h3><p>{{ $copy['empty_text'] }}</p></div>
                    @endforelse
                </div>
            </section>
        @endif

        <aside class="booking-help"><div><strong>{{ $copy['support'] }}</strong><span>{{ $copy['pickup'] }}</span></div><a href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['support_link'] }} <b aria-hidden="true">→</b></a></aside>
    </div>
</section>
@endsection

@push('styles')
<style>
    .booking-page{min-height:70vh;background:#f4f8f5;padding-bottom:64px;color:#173014}.booking-shell{width:min(1100px,calc(100% - 32px));margin:auto}.booking-hero{padding:32px 0;background:radial-gradient(circle at 84% 20%,rgba(249,178,26,.21),transparent 25%),linear-gradient(125deg,#052b1a,#087841);color:#fff}.booking-crumb{display:flex;gap:8px;color:#c5dacb;font-size:13px}.booking-crumb a{color:inherit;font-weight:700}.booking-hero__content{display:flex;align-items:end;justify-content:space-between;gap:26px;margin-top:22px}.booking-kicker{display:inline-block;color:#f9b21a;font-size:11px;font-weight:900;letter-spacing:.11em;text-transform:uppercase}.booking-hero h1{margin:8px 0;color:#fff;font-size:clamp(27px,4vw,42px);letter-spacing:-.035em;line-height:1.08}.booking-hero h1 span{font-weight:500;opacity:.74}.booking-hero p{display:flex;align-items:center;gap:9px;margin:0;color:#d6e9db;font-size:15px}.booking-hero p i{width:4px;height:4px;border-radius:50%;background:#f9b21a}.booking-hero__route{display:grid;gap:5px;min-width:220px;padding:14px 17px;border:1px solid rgba(255,255,255,.2);border-radius:12px;background:rgba(255,255,255,.08)}.booking-hero__route span{color:#c4d9ca;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}.booking-hero__route strong{font-size:14px}.booking-hero__route b{color:#f9b21a}.booking-date-nav{position:sticky;top:68px;z-index:10;background:#fff;border-bottom:1px solid #d7e5dc;box-shadow:0 4px 14px rgba(12,54,31,.05)}.booking-date-nav__inner{display:flex;gap:6px;overflow:auto;padding:8px 0}.booking-date{display:grid;gap:3px;min-width:78px;padding:9px 12px;border:1px solid transparent;border-radius:9px;color:#62776a;font-size:12px;text-align:center;text-decoration:none;transition:.18s ease}.booking-date strong{font-size:15px}.booking-date:hover{border-color:#b9ddc5;background:#f2faf4;color:#087841}.booking-date.is-active{border-color:#0b7f42;background:#e8f6ec;color:#087841}.booking-date:focus-visible,.departure-action a:focus-visible,.booking-help a:focus-visible{outline:3px solid #f9b21a;outline-offset:2px}.booking-content{padding-top:36px}.booking-section-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:12px}.booking-section-heading p{margin:0 0 5px;color:#087841;font-size:11px;font-weight:900;letter-spacing:.1em;text-transform:uppercase}.booking-section-heading h2{margin:0;font-size:clamp(20px,3vw,25px);letter-spacing:-.025em}.booking-section-heading>span{color:#607568;font-size:14px;font-weight:800}.booking-confirm{display:flex;align-items:center;gap:8px;margin:0 0 13px;color:#406250;font-size:13px}.booking-confirm span{display:grid;place-items:center;width:18px;height:18px;border-radius:50%;background:#dff4e6;color:#087841;font-size:11px;font-weight:900}.departure-list{display:grid;gap:12px}.departure-card{display:grid;grid-template-columns:130px minmax(270px,1.35fr) minmax(130px,.7fr) minmax(180px,.8fr);gap:20px;align-items:center;padding:15px;border:1px solid #d9e6dd;border-radius:16px;background:#fff;box-shadow:0 5px 18px rgba(10,73,39,.05);transition:transform .18s,box-shadow .18s}.departure-card:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(10,73,39,.1)}.departure-card.is-unavailable{opacity:.62}.departure-image{width:130px;height:104px;object-fit:cover;border-radius:11px;background:#e7f0e9}.departure-journey{display:grid;grid-template-columns:64px minmax(110px,1fr) 64px;align-items:center;gap:9px}.departure-time{text-align:center}.departure-time strong{display:block;font-size:25px;letter-spacing:-.04em}.departure-time span,.departure-action small{color:#688071;font-size:11px;font-weight:700}.departure-line{display:grid;justify-items:center;gap:7px;min-width:0}.departure-line>span{color:#315747;font-size:12px;font-weight:800}.departure-line i{width:100%;height:2px;background:linear-gradient(90deg,#0b7f42,#0b7f42 44%,#bfd6c5 44%,#bfd6c5 56%,#0b7f42 56%);position:relative}.departure-line i:after{content:'';position:absolute;right:0;top:-3px;width:8px;height:8px;border-top:2px solid #0b7f42;border-right:2px solid #0b7f42;transform:rotate(45deg)}.departure-line small{max-width:100%;overflow:hidden;color:#668071;font-size:10px;line-height:1.3;text-align:center;text-overflow:ellipsis;white-space:nowrap}.departure-line small b{color:#0b7f42}.departure-meta{display:grid;gap:8px}.departure-meta strong{font-size:14px;line-height:1.35}.departure-meta span{width:max-content;max-width:100%;padding:5px 8px;border-radius:99px;background:#e8f6ec;color:#087841;font-size:11px;font-weight:900}.departure-action{display:grid;gap:3px;justify-items:start;padding-left:20px;border-left:1px solid #e2ebe5}.departure-action__label{color:#6a8173;font-size:10px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}.departure-action>strong{font-size:19px;letter-spacing:-.02em}.departure-action a,.departure-action em{display:inline-flex;align-items:center;gap:7px;min-height:38px;margin-top:8px;padding:0 12px;border-radius:8px;font-size:12px;font-style:normal;font-weight:900;text-decoration:none}.departure-action a{background:#0b7f42;color:#fff;transition:background .18s}.departure-action a:hover{background:#075d35}.departure-action em{color:#9a3412;background:#fff1eb}.booking-return{margin-top:38px}.return-list{display:grid;gap:8px}.return-preview{display:grid;grid-template-columns:90px 1.2fr .8fr 1fr auto;gap:14px;align-items:center;padding:15px 18px;border:1px solid #dce8df;border-radius:12px;background:#fff;color:#4c6858;font-size:13px}.return-preview strong{color:#173014;font-size:18px}.return-preview b{color:#087841;white-space:nowrap}.booking-empty{padding:45px 20px;border:1px dashed #b9d4c0;border-radius:15px;background:#fff;text-align:center}.booking-empty h3{margin:0 0 7px;font-size:18px}.booking-empty p{margin:0;color:#637969}.booking-alert{margin:0 0 20px;padding:13px 15px;border:1px solid #f1c8b5;border-radius:10px;background:#fff6f1;color:#9a3412;font-size:14px;font-weight:700}.booking-help{display:flex;align-items:center;justify-content:space-between;gap:24px;margin-top:32px;padding:20px 22px;border-radius:14px;background:#e8f5eb}.booking-help div{display:grid;gap:4px}.booking-help strong{font-size:15px}.booking-help span{color:#567262;font-size:13px}.booking-help a{display:inline-flex;align-items:center;gap:8px;min-height:42px;padding:0 14px;border:1px solid #0b7f42;border-radius:8px;color:#087841;font-size:13px;font-weight:900;text-decoration:none}.booking-help a:hover{background:#fff}@media(max-width:900px){.departure-card{grid-template-columns:115px minmax(220px,1fr) minmax(170px,.7fr)}.departure-image{width:115px;height:92px}.departure-meta{display:none}.departure-action{padding-left:16px}.return-preview{grid-template-columns:80px 1fr auto;gap:8px}.return-preview span:nth-of-type(2){display:none}}@media(max-width:640px){.booking-shell{width:min(100% - 24px,1100px)}.booking-hero{padding:24px 0}.booking-hero__content{display:block;margin-top:18px}.booking-hero__route{display:none}.booking-date-nav{top:0}.booking-date-nav__inner{gap:4px}.booking-date{min-width:66px;padding:8px 7px}.booking-content{padding-top:25px}.booking-section-heading{align-items:start}.booking-section-heading>span{padding-top:4px;font-size:12px}.departure-card{grid-template-columns:88px minmax(0,1fr);gap:14px;padding:12px}.departure-image{width:88px;height:100%;min-height:112px}.departure-journey{grid-column:2;grid-template-columns:52px minmax(70px,1fr) 52px;gap:5px}.departure-time strong{font-size:21px}.departure-line small{font-size:9px}.departure-action{grid-column:1/-1;display:grid;grid-template-columns:1fr auto;gap:2px;padding:12px 0 0;border-top:1px solid #e2ebe5;border-left:0}.departure-action__label{grid-column:1}.departure-action>strong{font-size:18px}.departure-action small{grid-column:1}.departure-action a,.departure-action em{grid-column:2;grid-row:1/4;align-self:center;justify-self:end;margin:0;text-align:center}.booking-help{display:grid;gap:14px;padding:18px}.booking-help a{justify-content:center}.return-preview{grid-template-columns:65px 1fr auto;padding:13px}.return-preview span:nth-of-type(1){font-weight:800}.return-preview span:nth-of-type(2){display:none}}@media(prefers-reduced-motion:reduce){.departure-card,.booking-date,.departure-action a{transition:none}.departure-card:hover{transform:none}}
</style>
@endpush

@push('styles')
<style>.departure-tools{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:18px 0}.departure-filters{display:flex;flex-wrap:wrap;gap:7px}.departure-filters button{min-height:34px;padding:7px 11px;color:#526b5c;background:#fff;border:1px solid #d1ddd5;border-radius:999px;font:800 12px Inter,sans-serif;cursor:pointer}.departure-filters button:hover,.departure-filters button.is-active{color:#0a3d23;background:#e8f8ef;border-color:#0b7f42}.departure-tools>span{color:#708679;font-size:12px;font-weight:700}.departure-card[hidden]{display:none}.departure-availability{display:grid;gap:3px;margin-bottom:13px;padding-bottom:12px;border-bottom:1px solid #d9e5dc}.departure-availability span{color:#708679;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.05em}.departure-availability strong{color:#0b7f42;font-size:22px;line-height:1}.departure-action{align-content:start}@media(max-width:620px){.departure-tools{align-items:flex-start;flex-direction:column}.departure-filters{flex-wrap:nowrap;overflow-x:auto;width:100%;padding-bottom:3px}.departure-filters button{white-space:nowrap}}</style>
@endpush

@push('scripts')
<script>(() => { const filters = [...document.querySelectorAll('[data-departure-filter]')]; const cards = [...document.querySelectorAll('[data-departure-period]')]; const count = document.getElementById('departure-filter-count'); if (!filters.length || !cards.length) return; const update = (period) => { let visible = 0; cards.forEach((card) => { const show = period === 'all' || card.dataset.departurePeriod === period; card.hidden = !show; if (show) visible += 1; }); filters.forEach((filter) => filter.classList.toggle('is-active', filter.dataset.departureFilter === period)); count.textContent = `${visible}/${cards.length}`; }; filters.forEach((filter) => filter.addEventListener('click', () => update(filter.dataset.departureFilter))); update('all'); })();</script>
@endpush
