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
            'discount_tab' => 'Giảm giá', 'points_tab' => 'Đón/Trả', 'reviews_tab' => 'Đánh giá', 'policies_tab' => 'Chính sách', 'images_tab' => 'Hình ảnh', 'amenities_tab' => 'Tiện ích', 'operator_policy_tab' => 'Chính sách nhà xe',
            'original_fare' => 'Giá gốc', 'sale_fare' => 'Giá khuyến mãi', 'save' => 'Tiết kiệm', 'no_discount' => 'Chuyến này hiện chưa áp dụng khuyến mãi.',
            'loading_details' => 'Đang tải thông tin chuyến...', 'details_error' => 'Không thể tải chi tiết chuyến. Vui lòng thử lại.',
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
            'discount_tab' => 'Discount', 'points_tab' => 'Pickup/Drop-off', 'reviews_tab' => 'Reviews', 'policies_tab' => 'Policies', 'images_tab' => 'Images', 'amenities_tab' => 'Amenities', 'operator_policy_tab' => 'Operator policy',
            'original_fare' => 'Original fare', 'sale_fare' => 'Promotional fare', 'save' => 'Save', 'no_discount' => 'No promotion currently applies to this departure.',
            'loading_details' => 'Loading trip details...', 'details_error' => 'Unable to load trip details. Please try again.',
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
            'discount_tab' => 'Скидка', 'points_tab' => 'Посадка/Высадка', 'reviews_tab' => 'Отзывы', 'policies_tab' => 'Правила', 'images_tab' => 'Фото', 'amenities_tab' => 'Удобства', 'operator_policy_tab' => 'Правила перевозчика',
            'original_fare' => 'Обычная цена', 'sale_fare' => 'Цена со скидкой', 'save' => 'Экономия', 'no_discount' => 'На этот рейс сейчас нет акции.',
            'loading_details' => 'Загружаем информацию о рейсе...', 'details_error' => 'Не удалось загрузить данные. Попробуйте еще раз.',
        ],
    ][$locale];
    $places = [
        'TP. Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Sài Gòn' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
        'Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Nha Trang' => ['en' => 'Nha Trang', 'ru' => 'Нячанг'], 'Cam Ranh' => ['en' => 'Cam Ranh', 'ru' => 'Камрань'],
        'Đồng Nai' => ['en' => 'Dong Nai', 'ru' => 'Донгнай'], 'Biên Hòa' => ['en' => 'Bien Hoa', 'ru' => 'Бьенхоа'],
        'Bình Thuận' => ['en' => 'Binh Thuan', 'ru' => 'Биньтхуан'], 'Phan Thiết' => ['en' => 'Phan Thiet', 'ru' => 'Фантхьет'],
        'Khánh Hòa' => ['en' => 'Khanh Hoa', 'ru' => 'Кханьхоа'],
    ];
    $place = fn (string $name) => $locale === 'vi' ? $name : ($places[$name][$locale] ?? $name);
    $from = $place($fromLabel);
    $to = $place($toLabel);
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
    $tripTabs = ['discount' => 'discount_tab', 'points' => 'points_tab', 'reviews' => 'reviews_tab', 'policies' => 'policies_tab', 'images' => 'images_tab', 'amenities' => 'amenities_tab', 'operator_policy' => 'operator_policy_tab'];
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
                <a class="booking-date {{ $day->isSameDay($date) ? 'is-active' : '' }}" href="{{ route('booking.search', ['route_id' => $route->id, 'from_id' => $fromId, 'to_id' => $toId, 'departDate' => $day->format('d-m-Y'), 'is_round_trip' => $isRoundTrip ? 1 : 0, 'returnDate' => $isRoundTrip ? $returnForDay->format('d-m-Y') : null, 'seats' => $passengerCount, 'lang' => $locale]) }}" @if($day->isSameDay($date)) aria-current="date" @endif>
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
                    @php
                        $canBook = $trip['available_seats'] >= $passengerCount;
                        $period = $tripPeriod($trip['departure']);
                        $originalFare = max($trip['fare'], (int) ($trip['original_fare'] ?? $trip['fare']));
                        $discountPercent = $originalFare > $trip['fare'] ? (int) round((1 - ($trip['fare'] / $originalFare)) * 100) : 0;
                        $tabsId = 'trip-tabs-'.$loop->index;
                    @endphp
                    <article class="departure-card {{ $canBook ? '' : 'is-unavailable' }}" data-departure-period="{{ $period }}">
                        <img class="departure-image" src="{{ $trip['image'] ?: asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="Nhat Duong {{ $trip['vehicle_type'] }}" loading="lazy">
                        <div class="departure-journey">
                            <div class="departure-time"><strong>{{ $trip['departure']->format('H:i') }}</strong><span>{{ $copy['departure'] }}</span></div>
                            <div class="departure-line"><span>{{ $duration($trip['duration']) }}</span><i aria-hidden="true"></i><small>{{ $trip['pickup'] }} <b aria-hidden="true">→</b> {{ $trip['dropoff'] }}</small></div>
                            <div class="departure-time"><strong>{{ $trip['arrival']->format('H:i') }}</strong><span>{{ $copy['arrival'] }}</span></div>
                        </div>
                        <div class="departure-meta"><strong>{{ $trip['vehicle_type'] }}</strong></div>
                        <div class="departure-action"><div class="departure-availability"><span>{{ $copy['available'] }}</span><strong>{{ $trip['available_seats'] }}</strong></div><span class="departure-action__label">{{ $copy['fare'] }}</span><strong>{{ number_format($trip['fare'] * $passengerCount) }} VND</strong><small>{{ number_format($trip['fare']) }} {{ $copy['per_person'] }}</small>
                            @if($canBook)<a href="{{ route('booking.live.checkout', ['route_id' => $route->id, 'from_id' => $fromId, 'to_id' => $toId, 'trip_code' => $trip['code'], 'travel_date' => $date->toDateString(), 'passenger_count' => $passengerCount, 'lang' => $locale]) }}">{{ $copy['continue'] }} <b aria-hidden="true">→</b></a>@else <em>{{ $copy['sold_out'] }}</em>@endif
                        </div>
                        <div class="trip-info" data-trip-info data-loaded="false" data-loading-label="{{ $copy['loading_details'] }}" data-error-label="{{ $copy['details_error'] }}" data-url="{{ route('booking.trip.info', ['from_id' => $fromId, 'to_id' => $toId, 'trip_code' => $trip['code'], 'fare' => $trip['fare'], 'original_fare' => $originalFare, 'utilities' => implode(',', $trip['utility_ids'] ?? []), 'lang' => $locale]) }}">
                            <div class="trip-tabs" id="{{ $tabsId }}" role="tablist" aria-label="{{ $trip['vehicle_type'] }}">
                                @foreach($tripTabs as $tab => $label)
                                    <button type="button" role="tab" id="{{ $tabsId.'-'.$tab }}" aria-selected="{{ $tab === 'discount' ? 'true' : 'false' }}" aria-controls="{{ $tabsId.'-panel' }}" tabindex="{{ $tab === 'discount' ? '0' : '-1' }}" data-trip-tab="{{ $tab }}" class="{{ $tab === 'discount' ? 'is-active' : '' }}">{{ $copy[$label] }}</button>
                                @endforeach
                            </div>
                            <div class="trip-panels" id="{{ $tabsId.'-panel' }}" aria-live="polite">
                                <section class="trip-panel" data-trip-panel="discount" role="tabpanel" aria-labelledby="{{ $tabsId.'-discount' }}">
                                    @if($discountPercent > 0)
                                        <div class="trip-price-grid"><div><span>{{ $copy['original_fare'] }}</span><del>{{ number_format($originalFare) }} VND</del></div><div><span>{{ $copy['sale_fare'] }}</span><strong>{{ number_format($trip['fare']) }} VND</strong></div><div class="trip-price-save"><b>-{{ $discountPercent }}%</b><span>{{ $copy['save'] }} {{ number_format($originalFare - $trip['fare']) }} VND</span></div></div>
                                    @else
                                        <p class="trip-empty">{{ $copy['no_discount'] }}</p>
                                    @endif
                                </section>
                            </div>
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
<style>
    @media (max-width: 640px) {
        .departure-image {
            height: 112px;
            min-height: 0;
            align-self: start;
        }
        .departure-journey {
            grid-template-columns: 52px minmax(0, 1fr) 52px;
            gap: 4px;
        }
        .departure-time strong { font-size: 20px; }
    }
</style>
@endpush

@push('styles')
<style>.departure-tools{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:18px 0}.departure-filters{display:flex;flex-wrap:wrap;gap:7px}.departure-filters button{min-height:34px;padding:7px 11px;color:#526b5c;background:#fff;border:1px solid #d1ddd5;border-radius:999px;font:800 12px Inter,sans-serif;cursor:pointer}.departure-filters button:hover,.departure-filters button.is-active{color:#0a3d23;background:#e8f8ef;border-color:#0b7f42}.departure-tools>span{color:#708679;font-size:12px;font-weight:700}.departure-card[hidden]{display:none}.departure-availability{display:grid;gap:3px;margin-bottom:13px;padding-bottom:12px;border-bottom:1px solid #d9e5dc}.departure-availability span{color:#708679;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.05em}.departure-availability strong{color:#0b7f42;font-size:22px;line-height:1}.departure-action{align-content:start}@media(max-width:620px){.departure-tools{align-items:flex-start;flex-direction:column}.departure-filters{flex-wrap:nowrap;overflow-x:auto;width:100%;padding-bottom:3px}.departure-filters button{white-space:nowrap}}</style>
@endpush

@push('styles')
<style>
    .trip-info{grid-column:1/-1;min-width:0;margin:2px -20px -20px;border-top:1px solid #dce7df;background:#fbfdfb;border-radius:0 0 15px 15px;overflow:hidden}.trip-tabs{display:flex;gap:2px;overflow-x:auto;padding:10px 18px 0;background:#f3f8f4;scrollbar-width:thin}.trip-tabs button{position:relative;flex:0 0 auto;min-height:42px;padding:9px 13px;color:#5d7165;background:transparent;border:0;font:800 12px Inter,sans-serif;white-space:nowrap;cursor:pointer}.trip-tabs button::after{position:absolute;right:10px;bottom:0;left:10px;height:3px;border-radius:4px 4px 0 0;background:#0b7f42;content:"";opacity:0;transform:scaleX(.4);transition:.18s ease}.trip-tabs button:hover,.trip-tabs button.is-active{color:#086d3a}.trip-tabs button.is-active::after{opacity:1;transform:scaleX(1)}.trip-tabs button:focus-visible{outline:2px solid #f9b21a;outline-offset:-2px}.trip-panels{padding:19px 20px 21px;min-height:70px}.trip-panel[hidden]{display:none}.trip-empty{margin:0;color:#718177;font-size:13px;line-height:1.55}.trip-loading{display:flex;align-items:center;gap:10px;margin:0;color:#597064;font-size:13px;font-weight:700}.trip-loading::before{width:17px;height:17px;border:2px solid #b8d2c1;border-top-color:#0b7f42;border-radius:50%;content:"";animation:trip-spin .7s linear infinite}@keyframes trip-spin{to{transform:rotate(360deg)}}
    .trip-price-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr)) auto;gap:12px;align-items:center}.trip-price-grid>div{display:grid;gap:4px}.trip-price-grid span{color:#718177;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}.trip-price-grid del{color:#7d8d84;font-size:16px}.trip-price-grid strong{color:#0b7f42;font-size:20px}.trip-price-grid .trip-price-save{display:flex;align-items:center;gap:9px;padding:10px 13px;border-radius:10px;background:#fff4d8}.trip-price-save b{color:#b76b00;font-size:18px}.trip-price-save span{color:#75551d;text-transform:none;letter-spacing:0}.trip-point-columns{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:24px}.trip-point-columns h4,.trip-policy-grid h4{margin:0 0 11px;color:#173014;font-size:13px}.trip-point{display:grid;grid-template-columns:9px minmax(0,1fr) auto;gap:9px;align-items:start;padding:9px 0;border-top:1px solid #e2ebe5}.trip-point i{width:8px;height:8px;margin-top:5px;border:2px solid #0b7f42;border-radius:50%}.trip-point div{display:grid;gap:3px}.trip-point strong{color:#294535;font-size:12px}.trip-point span{color:#718177;font-size:11px;line-height:1.4}.trip-point time{color:#087841;font-size:11px;font-weight:800}.trip-rating{display:flex;align-items:center;gap:7px;margin-bottom:12px}.trip-rating>strong{color:#173014;font-size:27px}.trip-rating>span{color:#f4aa00;font-size:20px}.trip-rating p{margin:0;color:#718177;font-size:12px}.trip-panel blockquote{margin:9px 0;padding:11px 13px;border-left:3px solid #94c9a8;background:#f1f8f3}.trip-panel blockquote p{margin:0;color:#385244;font-size:12px;line-height:1.5}.trip-panel blockquote footer{margin-top:6px;color:#718177;font-size:11px;font-weight:700}.trip-policy-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.trip-policy-grid article{display:flex;gap:10px;padding:12px;border:1px solid #dce8df;border-radius:10px;background:#fff}.trip-policy-grid article>span{display:grid;place-items:center;flex:0 0 25px;width:25px;height:25px;color:#087841;background:#e7f5eb;border-radius:50%;font-size:11px;font-weight:900}.trip-policy-grid h4{margin-bottom:5px}.trip-policy-grid p{margin:0;color:#63776b;font-size:11px;line-height:1.5;white-space:pre-line}.trip-gallery{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:9px}.trip-gallery a{display:block;overflow:hidden;border-radius:10px;background:#e7eee9;aspect-ratio:16/10}.trip-gallery img{width:100%;height:100%;object-fit:cover;transition:transform .25s ease}.trip-gallery a:hover img{transform:scale(1.04)}.trip-amenities{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:9px;margin:0;padding:0;list-style:none}.trip-amenities li{display:flex;align-items:center;gap:10px;min-width:0;padding:10px;border:1px solid #d8e7dc;border-radius:12px;background:linear-gradient(145deg,#fff,#f6faf7)}.trip-amenity-icon{display:grid;place-items:center;flex:0 0 36px;width:36px;height:36px;color:#087841;background:linear-gradient(145deg,#e9f8ee,#d8efdf);border:1px solid #c5e4cf;border-radius:11px;box-shadow:inset 0 1px 0 #fff}.trip-amenity-icon svg{width:19px;height:19px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}.trip-amenity-icon b{font-size:9px;letter-spacing:-.03em}.trip-amenity-copy{display:grid;gap:4px;min-width:0}.trip-amenities strong{overflow:hidden;color:#385244;font-size:11px;line-height:1.25;text-overflow:ellipsis}.trip-amenities small{width:max-content;padding:2px 5px;color:#087841;background:#e6f5eb;border-radius:5px;font-size:8px;font-weight:900;text-transform:uppercase}.trip-operator-policy>h3{margin:0 0 15px;color:#173014;font-size:18px}.trip-operator-policy>ol{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin:0;padding:0;list-style:none;counter-reset:policy}.trip-operator-policy>ol>li{padding:13px;border:1px solid #dce8df;border-radius:10px;background:#fff;counter-increment:policy}.trip-operator-policy h4{margin:0 0 7px;color:#173014;font-size:12px}.trip-operator-policy h4:before{margin-right:5px;color:#087841;content:counter(policy) '.'}.trip-operator-policy p{margin:5px 0 0;color:#607269;font-size:11px;line-height:1.55}.trip-operator-policy ul{display:grid;gap:5px;margin:7px 0 0;padding-left:17px}.trip-operator-policy ul li{color:#52695d;font-size:11px;line-height:1.5}.trip-policy-period{margin-top:9px;padding:9px;background:#f3f8f4;border-radius:8px}.trip-policy-period strong{color:#087841;font-size:11px}.trip-operator-policy .trip-policy-note{padding:9px 10px;color:#76551a;background:#fff4d8;border-radius:8px;font-weight:700}
    @media(max-width:760px){.trip-info{margin:4px -14px -14px}.trip-tabs{padding-right:10px;padding-left:10px}.trip-panels{padding:16px 14px 18px}.trip-price-grid{grid-template-columns:1fr 1fr}.trip-price-grid .trip-price-save{grid-column:1/-1}.trip-point-columns,.trip-policy-grid,.trip-operator-policy>ol{grid-template-columns:1fr}.trip-gallery,.trip-amenities{grid-template-columns:repeat(2,minmax(0,1fr))}.trip-amenities li{gap:8px;padding:8px}.trip-amenity-icon{flex-basis:32px;width:32px;height:32px}.trip-amenity-icon svg{width:17px;height:17px}}@media(max-width:360px){.trip-amenities{grid-template-columns:1fr}}@media(prefers-reduced-motion:reduce){.trip-loading::before{animation-duration:1.5s}.trip-gallery img,.trip-tabs button::after{transition:none}}
</style>
@endpush

@push('scripts')
<script>(() => { const filters = [...document.querySelectorAll('[data-departure-filter]')]; const cards = [...document.querySelectorAll('[data-departure-period]')]; const count = document.getElementById('departure-filter-count'); if (!filters.length || !cards.length) return; const update = (period) => { let visible = 0; cards.forEach((card) => { const show = period === 'all' || card.dataset.departurePeriod === period; card.hidden = !show; if (show) visible += 1; }); filters.forEach((filter) => filter.classList.toggle('is-active', filter.dataset.departureFilter === period)); count.textContent = `${visible}/${cards.length}`; }; filters.forEach((filter) => filter.addEventListener('click', () => update(filter.dataset.departureFilter))); update('all'); })();</script>
@endpush

@push('scripts')
<script>
(() => {
    document.querySelectorAll('[data-trip-info]').forEach((info) => {
        const tabs = [...info.querySelectorAll('[data-trip-tab]')];
        const panels = info.querySelector('.trip-panels');
        let loading = false;
        let requestedTab = 'discount';

        const activate = (name) => {
            tabs.forEach((tab) => {
                const active = tab.dataset.tripTab === name;
                tab.classList.toggle('is-active', active);
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
                tab.tabIndex = active ? 0 : -1;
            });
            panels.querySelectorAll('[data-trip-panel]').forEach((panel) => {
                panel.hidden = panel.dataset.tripPanel !== name;
                const tab = tabs.find((item) => item.dataset.tripTab === name);
                if (tab && !panel.hidden) panel.setAttribute('aria-labelledby', tab.id);
            });
        };

        const load = async (name) => {
            requestedTab = name;
            if (info.dataset.loaded === 'true') {
                activate(name);
                return;
            }
            if (name === 'discount' || loading) {
                activate(name);
                return;
            }

            loading = true;
            panels.innerHTML = `<p class="trip-loading" role="status">${info.dataset.loadingLabel}</p>`;
            activate(name);
            try {
                const response = await fetch(info.dataset.url, {headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const data = await response.json();
                panels.innerHTML = data.html;
                info.dataset.loaded = 'true';
                activate(requestedTab);
            } catch (error) {
                panels.innerHTML = `<p class="trip-empty" role="alert">${info.dataset.errorLabel}</p>`;
            } finally {
                loading = false;
            }
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => load(tab.dataset.tripTab));
            tab.addEventListener('keydown', (event) => {
                let next = null;
                if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
                if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
                if (event.key === 'Home') next = 0;
                if (event.key === 'End') next = tabs.length - 1;
                if (next === null) return;
                event.preventDefault();
                tabs[next].focus();
                load(tabs[next].dataset.tripTab);
            });
        });
    });
})();
</script>
@endpush
