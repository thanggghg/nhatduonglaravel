@extends('layouts.app')

@php
    $locale = request('lang');
    $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';

    $copy = [
        'vi' => [
            'home' => 'Trang chủ', 'routes' => 'Tuyến xe', 'route' => 'Chi tiết tuyến', 'to_word' => 'đến',
            'eyebrow' => 'HÀNH TRÌNH ĐƯỜNG DÀI, ĐIỀU PHỐI RÕ RÀNG', 'from_to' => 'Hành trình',
            'from_price' => 'Giá vé từ', 'duration' => 'Thời gian dự kiến', 'distance' => 'Quãng đường',
            'book' => 'Đặt vé cho tuyến này', 'call' => 'Gọi tư vấn', 'availability' => 'Đang nhận đặt vé',
            'overview' => 'Tổng quan hành trình', 'overview_text' => 'Xem giờ chạy, giá vé và thông tin điểm đón trước khi bạn chọn chuyến.',
            'departures' => 'Khung giờ khởi hành', 'departures_intro' => 'Chọn khung giờ phù hợp với kế hoạch của bạn.',
            'departure' => 'Xuất bến', 'arrival' => 'Dự kiến đến', 'vehicle' => 'Loại xe', 'fare' => 'Giá vé',
            'note' => 'Lưu ý', 'schedule_note' => 'Lịch trình có thể thay đổi theo tình hình thực tế.',
            'pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ',
            'pickup_intro' => 'Kiểm tra địa chỉ và số điện thoại điểm đón trước ngày đi.',
            'dropoff_intro' => 'Các điểm trả giúp bạn chủ động kết thúc hành trình.',
            'faq' => 'Câu hỏi thường gặp', 'ready' => 'Sẵn sàng lên đường?',
            'ready_text' => 'Giữ chỗ nhanh chóng hoặc gọi đội ngũ Nhật Dương để được hỗ trợ.',
            'book_now' => 'Đặt vé ngay', 'support' => 'Hỗ trợ qua điện thoại', 'phone_label' => 'Hotline 24/7',
            'route_label' => 'TUYẾN XE NHẬT DƯƠNG', 'route_summary' => 'Tuyến xe giường nằm dành cho hành trình giữa các thành phố ven biển phía Nam.',
        ],
        'en' => [
            'home' => 'Home', 'routes' => 'Routes', 'route' => 'Route details', 'to_word' => 'to',
            'eyebrow' => 'A LONG-DISTANCE JOURNEY, CLEARLY PLANNED', 'from_to' => 'Journey',
            'from_price' => 'From', 'duration' => 'Estimated time', 'distance' => 'Distance',
            'book' => 'Book this route', 'call' => 'Call for advice', 'availability' => 'Open for bookings',
            'overview' => 'Journey overview', 'overview_text' => 'See departures, fares, and pickup details before choosing the trip that fits your day.',
            'departures' => 'Departure times', 'departures_intro' => 'Choose a departure time that works for your plans.',
            'departure' => 'Departure', 'arrival' => 'Estimated arrival', 'vehicle' => 'Vehicle', 'fare' => 'Fare',
            'note' => 'Note', 'schedule_note' => 'Schedules may change according to operating conditions.',
            'pickup' => 'Pickup points', 'dropoff' => 'Drop-off points', 'map' => 'Open map',
            'pickup_intro' => 'Check the address and phone number before your travel date.',
            'dropoff_intro' => 'Drop-off options help you plan the end of your journey.',
            'faq' => 'Frequently asked questions', 'ready' => 'Ready to get moving?',
            'ready_text' => 'Reserve your seat online or call the Nhat Duong team for help.',
            'book_now' => 'Book now', 'support' => 'Call support', 'phone_label' => '24/7 hotline',
            'route_label' => 'NHAT DUONG BUS ROUTE', 'route_summary' => 'A sleeper-bus route for journeys between southern Vietnam’s coastal cities.',
        ],
        'ru' => [
            'home' => 'Главная', 'routes' => 'Маршруты', 'route' => 'Детали маршрута', 'to_word' => 'в',
            'eyebrow' => 'ДАЛЬНЯЯ ПОЕЗДКА С ПОНЯТНЫМ ПЛАНОМ', 'from_to' => 'Маршрут',
            'from_price' => 'От', 'duration' => 'Время в пути', 'distance' => 'Расстояние',
            'book' => 'Забронировать маршрут', 'call' => 'Позвонить для консультации', 'availability' => 'Открыто для бронирования',
            'overview' => 'О маршруте', 'overview_text' => 'Посмотрите рейсы, цены и места посадки перед выбором подходящей поездки.',
            'departures' => 'Время отправления', 'departures_intro' => 'Выберите время, которое подходит вашим планам.',
            'departure' => 'Отправление', 'arrival' => 'Прибытие', 'vehicle' => 'Автобус', 'fare' => 'Цена',
            'note' => 'Примечание', 'schedule_note' => 'Расписание может измениться из-за условий работы.',
            'pickup' => 'Места посадки', 'dropoff' => 'Места высадки', 'map' => 'Открыть карту',
            'pickup_intro' => 'Проверьте адрес и телефон до даты поездки.',
            'dropoff_intro' => 'Варианты высадки помогут спланировать конец поездки.',
            'faq' => 'Частые вопросы', 'ready' => 'Готовы отправиться?',
            'ready_text' => 'Забронируйте место онлайн или позвоните команде Nhat Duong.',
            'book_now' => 'Забронировать', 'support' => 'Позвонить в поддержку', 'phone_label' => 'Горячая линия 24/7',
            'route_label' => 'МАРШРУТ NHAT DUONG', 'route_summary' => 'Спальный автобус для поездок между прибрежными городами юга Вьетнама.',
        ],
    ][$locale];

    $locations = [
        'TP. Hồ Chí Minh' => ['vi' => 'TP. Hồ Chí Minh', 'en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
        'Cam Ranh' => ['vi' => 'Cam Ranh', 'en' => 'Cam Ranh', 'ru' => 'Камрань'],
        'Nha Trang' => ['vi' => 'Nha Trang', 'en' => 'Nha Trang', 'ru' => 'Нячанг'],
    ];
    $from = $locations[$route->from_location][$locale] ?? $route->from_location;
    $to = $locations[$route->to_location][$locale] ?? $route->to_location;
    $duration = $route->estimated_time;
    if ($locale === 'en') {
        $duration = str_replace('giờ', 'h', $duration);
    } elseif ($locale === 'ru') {
        $duration = str_replace('giờ', 'ч.', $duration);
    }
@endphp

@push('styles')
<style>
    .route-page { --route-ink:#10261c; --route-muted:#607169; --route-green:#0b7f42; --route-deep:#062d1c; --route-gold:#fbb116; --route-paper:#f5faf4; --route-line:#dbe7de; color:var(--route-ink); background:var(--route-paper); overflow:hidden; }
    .route-shell { width:min(1180px, calc(100% - 40px)); margin:0 auto; }
    .route-hero { position:relative; color:#fff; background:var(--route-deep); isolation:isolate; }
    .route-hero__image { position:absolute; inset:0; z-index:-2; width:100%; height:100%; object-fit:cover; opacity:.32; }
    .route-hero__wash { position:absolute; inset:0; z-index:-1; background:linear-gradient(90deg, rgba(6,45,28,.98) 0%, rgba(6,45,28,.82) 43%, rgba(6,45,28,.30) 100%), linear-gradient(0deg, rgba(6,45,28,.75), transparent 55%); }
    .route-breadcrumb { padding:24px 0 0; display:flex; align-items:center; gap:10px; color:rgba(255,255,255,.62); font-size:13px; }
    .route-breadcrumb a { color:rgba(255,255,255,.72); text-decoration:none; transition:color .2s ease; }
    .route-breadcrumb a:hover { color:#fff; }
    .route-hero__body { padding:66px 0 82px; display:grid; grid-template-columns:minmax(0, 1.05fr) minmax(330px, .75fr); gap:70px; align-items:end; }
    .route-kicker, .route-section-kicker { margin:0 0 18px; color:var(--route-gold); font-size:11px; font-weight:800; letter-spacing:.16em; line-height:1.4; }
    .route-hero h1 { max-width:720px; margin:0; font-size:clamp(44px, 7vw, 88px); line-height:.96; letter-spacing:-.065em; font-weight:800; }
    .route-hero__lead { max-width:560px; margin:28px 0 0; color:rgba(255,255,255,.75); font-size:18px; line-height:1.65; }
    .route-line { display:flex; align-items:center; gap:14px; margin-top:38px; color:#fff; font-size:15px; font-weight:700; }
    .route-line__dot { width:11px; height:11px; border:3px solid var(--route-gold); border-radius:50%; flex:none; }
    .route-line__track { width:74px; height:1px; background:rgba(255,255,255,.45); position:relative; }
    .route-line__track:after { content:''; position:absolute; right:0; top:-3px; width:7px; height:7px; border-top:1px solid var(--route-gold); border-right:1px solid var(--route-gold); transform:rotate(45deg); }
    .route-booking { padding:27px; color:var(--route-ink); background:#fff; border-radius:3px; box-shadow:0 24px 70px rgba(0,0,0,.2); }
    .route-booking__top { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; padding-bottom:22px; border-bottom:1px solid var(--route-line); }
    .route-booking__top p { margin:0; font-size:12px; color:var(--route-muted); }
    .route-booking__top strong { display:block; margin-top:6px; color:var(--route-green); font-size:30px; letter-spacing:-.04em; }
    .route-status { display:flex; align-items:center; gap:6px; padding:7px 9px; color:#075d2f; background:#e8f8ef; border-radius:99px; font-size:10px; font-weight:800; white-space:nowrap; }
    .route-status:before { content:''; width:6px; height:6px; background:#13a55a; border-radius:50%; }
    .route-booking__label { display:block; margin:20px 0 8px; color:var(--route-muted); font-size:12px; font-weight:700; }
    .route-booking__action { display:flex; align-items:center; justify-content:center; gap:10px; min-height:54px; padding:0 18px; color:#4f3700; background:var(--route-gold); border-radius:2px; font-size:15px; font-weight:800; text-decoration:none; transition:transform .2s ease, box-shadow .2s ease, background .2s ease; }
    .route-booking__action:hover { background:#ffca2e; box-shadow:0 9px 22px rgba(251,177,22,.24); transform:translateY(-2px); }
    .route-booking__phone { display:flex; justify-content:center; margin:16px 0 0; color:var(--route-green); font-size:13px; font-weight:700; text-decoration:none; }
    .route-overview { position:relative; margin-top:-1px; padding:78px 0 90px; background:#fff; }
    .route-overview__grid { display:grid; grid-template-columns:1fr 1.35fr; gap:70px; align-items:start; }
    .route-section-kicker { color:var(--route-green); }
    .route-section-title { margin:0; max-width:480px; font-size:clamp(30px, 4vw, 50px); line-height:1.03; letter-spacing:-.05em; }
    .route-section-text { margin:20px 0 0; max-width:440px; color:var(--route-muted); font-size:16px; line-height:1.7; }
    .route-stats { display:grid; grid-template-columns:repeat(3, 1fr); border-top:1px solid var(--route-line); border-bottom:1px solid var(--route-line); }
    .route-stat { padding:25px 18px 25px 0; }
    .route-stat + .route-stat { padding-left:18px; border-left:1px solid var(--route-line); }
    .route-stat dt { color:var(--route-muted); font-size:12px; }
    .route-stat dd { margin:7px 0 0; color:var(--route-green); font-size:25px; font-weight:800; letter-spacing:-.04em; }
    .route-summary { margin-top:28px; color:var(--route-muted); font-size:14px; line-height:1.7; }
    .route-description { margin-top:24px; color:var(--route-ink); font-size:16px; line-height:1.8; }
    .route-description p { margin:0; }
    .route-schedule { padding:88px 0; background:var(--route-paper); }
    .route-heading-row { display:flex; justify-content:space-between; gap:30px; align-items:end; margin-bottom:30px; }
    .route-heading-row .route-section-text { margin:0; max-width:360px; }
    .route-departures { display:grid; gap:10px; }
    .route-departure { display:grid; grid-template-columns:1.1fr 1fr 1.2fr .8fr auto; gap:22px; align-items:center; padding:23px 25px; background:#fff; border:1px solid var(--route-line); transition:border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
    .route-departure:hover { border-color:#9dc6aa; box-shadow:0 12px 26px rgba(6,45,28,.08); transform:translateY(-2px); }
    .route-departure__time { font-size:25px; font-weight:800; letter-spacing:-.04em; }
    .route-departure__time small { display:block; margin-top:3px; color:var(--route-muted); font-size:11px; font-weight:500; letter-spacing:0; }
    .route-departure__item span { display:block; color:var(--route-muted); font-size:11px; }
    .route-departure__item strong { display:block; margin-top:5px; font-size:14px; }
    .route-departure__price { color:var(--route-green); font-size:16px; font-weight:800; }
    .route-note { margin:17px 0 0; color:var(--route-muted); font-size:12px; }
    .route-stops { padding:88px 0; background:#fff; }
    .route-stops__grid { display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-top:32px; }
    .route-stop-card { padding:29px; border:1px solid var(--route-line); background:linear-gradient(140deg,#fff 0%,#f5faf4 100%); }
    .route-stop-card__heading { display:flex; gap:14px; align-items:flex-start; padding-bottom:20px; border-bottom:1px solid var(--route-line); }
    .route-stop-card__icon { display:grid; place-items:center; width:34px; height:34px; flex:none; color:#fff; background:var(--route-green); border-radius:50%; }
    .route-stop-card--dropoff .route-stop-card__icon { background:var(--route-deep); }
    .route-stop-card h3 { margin:0; font-size:22px; letter-spacing:-.03em; }
    .route-stop-card__intro { margin:6px 0 0; color:var(--route-muted); font-size:13px; line-height:1.5; }
    .route-stop-list { display:grid; gap:18px; margin:23px 0 0; }
    .route-stop { position:relative; padding-left:20px; }
    .route-stop:before { content:''; position:absolute; left:0; top:7px; width:7px; height:7px; border:2px solid var(--route-green); border-radius:50%; }
    .route-stop strong { display:block; font-size:15px; }
    .route-stop p { margin:5px 0 0; color:var(--route-muted); font-size:13px; line-height:1.5; }
    .route-stop a { display:inline-flex; margin-top:8px; color:var(--route-green); font-size:12px; font-weight:800; text-decoration:none; }
    .route-faq { padding:88px 0; background:var(--route-paper); }
    .route-faq__list { max-width:820px; margin:30px auto 0; border-top:1px solid var(--route-line); }
    .route-faq details { border-bottom:1px solid var(--route-line); }
    .route-faq summary { display:flex; justify-content:space-between; gap:20px; padding:22px 0; cursor:pointer; list-style:none; font-size:16px; font-weight:800; }
    .route-faq summary::-webkit-details-marker { display:none; }
    .route-faq summary:after { content:'+'; color:var(--route-green); font-size:24px; font-weight:400; line-height:1; }
    .route-faq details[open] summary:after { content:'−'; }
    .route-faq details div { max-width:720px; padding:0 40px 23px 0; color:var(--route-muted); font-size:14px; line-height:1.75; }
    .route-final { padding:82px 0; color:#fff; background:var(--route-green); }
    .route-final__inner { display:flex; justify-content:space-between; align-items:center; gap:30px; }
    .route-final h2 { margin:0; font-size:clamp(32px, 5vw, 58px); line-height:1; letter-spacing:-.06em; }
    .route-final p { max-width:430px; margin:15px 0 0; color:rgba(255,255,255,.76); line-height:1.6; }
    .route-final__actions { display:flex; flex-wrap:wrap; gap:12px; flex:none; }
    .route-final__actions a { display:inline-flex; align-items:center; justify-content:center; min-height:52px; padding:0 22px; border-radius:2px; font-size:14px; font-weight:800; text-decoration:none; transition:transform .2s ease, filter .2s ease; }
    .route-final__actions a:hover { filter:brightness(1.06); transform:translateY(-2px); }
    .route-final__actions a:first-child { color:#4f3700; background:var(--route-gold); }
    .route-final__actions a:last-child { color:#fff; border:1px solid rgba(255,255,255,.55); }
    @media (max-width: 900px) { .route-hero__body { grid-template-columns:1fr; gap:40px; padding-top:50px; } .route-hero__lead { font-size:16px; } .route-overview__grid { grid-template-columns:1fr; gap:42px; } .route-departure { grid-template-columns:1fr 1fr 1fr; gap:16px; } .route-departure__price { grid-column:3; grid-row:1; text-align:right; } .route-departure__item:last-of-type { grid-column:1 / 3; } .route-final__inner { align-items:flex-start; flex-direction:column; } }
    @media (max-width: 640px) { .route-shell { width:min(100% - 28px, 1180px); } .route-breadcrumb { padding-top:18px; font-size:11px; } .route-hero__body { padding:42px 0 52px; } .route-hero h1 { font-size:clamp(44px, 15vw, 72px); } .route-line { margin-top:28px; font-size:13px; } .route-booking { padding:21px; } .route-booking__top strong { font-size:26px; } .route-overview, .route-schedule, .route-stops, .route-faq { padding:62px 0; } .route-section-title { font-size:36px; } .route-stats { grid-template-columns:1fr; } .route-stat, .route-stat + .route-stat { padding:17px 0; border-left:0; } .route-stat + .route-stat { border-top:1px solid var(--route-line); } .route-stat dd { font-size:23px; } .route-heading-row { display:block; } .route-heading-row .route-section-text { margin-top:14px; } .route-departure { grid-template-columns:1fr 1fr; padding:20px 18px; } .route-departure__price { grid-column:2; grid-row:1; } .route-departure__item:last-of-type { grid-column:1 / 3; } .route-stops__grid { grid-template-columns:1fr; } .route-stop-card { padding:22px; } .route-final { padding:62px 0; } .route-final__actions { width:100%; } .route-final__actions a { flex:1; min-width:145px; } }
    @media (prefers-reduced-motion: reduce) { .route-booking__action, .route-departure, .route-final__actions a { transition:none; } }
</style>
@endpush

@section('content')
<div class="route-page">
    <section class="route-hero">
        @if($route->image)
            <img class="route-hero__image" src="{{ asset('storage/' . $route->image) }}" alt="" aria-hidden="true">
        @endif
        <div class="route-hero__wash"></div>
        <div class="route-shell">
            <nav class="route-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home', ['lang' => $locale]) }}">{{ $copy['home'] }}</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('routes.index', ['lang' => $locale]) }}">{{ $copy['routes'] }}</a>
                <span aria-hidden="true">/</span>
                <span>{{ $copy['route'] }}</span>
            </nav>

            <div class="route-hero__body">
                <div>
                    <p class="route-kicker">{{ $copy['eyebrow'] }}</p>
                    <h1>{{ $from }}<br><span style="color:var(--route-gold);">{{ $copy['to_word'] }} {{ $to }}</span></h1>
                    <p class="route-hero__lead">{{ $copy['route_summary'] }}</p>
                    <div class="route-line" aria-label="{{ $from }} to {{ $to }}">
                        <span class="route-line__dot"></span><span>{{ $from }}</span><span class="route-line__track"></span><span>{{ $to }}</span><span class="route-line__dot"></span>
                    </div>
                </div>

                <aside class="route-booking" aria-label="Booking information">
                    <div class="route-booking__top">
                        <div><p>{{ $copy['from_price'] }}</p><strong>{{ number_format($route->price_from) }} VND</strong></div>
                        <span class="route-status">{{ $copy['availability'] }}</span>
                    </div>
                    <span class="route-booking__label">{{ $copy['book'] }}</span>
                    <a class="route-booking__action" href="{{ route('booking.redirect', ['route_id' => $route->id, 'source_page' => 'route_detail']) }}">
                        {{ $copy['book_now'] }}
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                    <a class="route-booking__phone" href="tel:1900 2879">{{ $copy['call'] }} · 1900 2879</a>
                </aside>
            </div>
        </div>
    </section>

    <section class="route-overview" aria-labelledby="overview-title">
        <div class="route-shell route-overview__grid">
            <div>
                <p class="route-section-kicker">{{ $copy['route_label'] }}</p>
                <h2 id="overview-title" class="route-section-title">{{ $copy['overview'] }}</h2>
                <p class="route-section-text">{{ $copy['overview_text'] }}</p>
            </div>
            <div>
                <dl class="route-stats">
                    @if($route->distance)
                        <div class="route-stat"><dt>{{ $copy['distance'] }}</dt><dd>{{ $route->distance }} km</dd></div>
                    @endif
                    @if($duration)
                        <div class="route-stat"><dt>{{ $copy['duration'] }}</dt><dd>{{ $duration }}</dd></div>
                    @endif
                    <div class="route-stat"><dt>{{ $copy['from_price'] }}</dt><dd>{{ number_format($route->price_from) }} VND</dd></div>
                </dl>
                @if($route->description)
                    <div class="route-description">{!! nl2br(e($route->description)) !!}</div>
                @endif
            </div>
        </div>
    </section>

    @if($schedules->isNotEmpty())
        <section class="route-schedule" aria-labelledby="departures-title">
            <div class="route-shell">
                <div class="route-heading-row">
                    <div><p class="route-section-kicker">{{ $copy['route_label'] }}</p><h2 id="departures-title" class="route-section-title">{{ $copy['departures'] }}</h2></div>
                    <p class="route-section-text">{{ $copy['departures_intro'] }}</p>
                </div>
                <div class="route-departures">
                    @foreach($schedules as $schedule)
                        <article class="route-departure">
                            <div class="route-departure__time">{{ $schedule->departure_time?->format('H:i') ?? '—' }}<small>{{ $copy['departure'] }}</small></div>
                            <div class="route-departure__item"><span>{{ $copy['arrival'] }}</span><strong>{{ $schedule->arrival_time?->format('H:i') ?? '—' }}</strong></div>
                            <div class="route-departure__item"><span>{{ $copy['vehicle'] }}</span><strong>{{ $schedule->bus_type ?: 'Sleeper bus' }}</strong></div>
                            <div class="route-departure__price">{{ number_format($schedule->price) }} VND</div>
                            @if($schedule->note)<div class="route-departure__item"><span>{{ $copy['note'] }}</span><strong>{{ $schedule->note }}</strong></div>@endif
                        </article>
                    @endforeach
                </div>
                <p class="route-note">* {{ $copy['schedule_note'] }}</p>
            </div>
        </section>
    @endif

    @if($pickupPoints->isNotEmpty() || $dropoffPoints->isNotEmpty())
        <section class="route-stops" aria-labelledby="stops-title">
            <div class="route-shell">
                <p class="route-section-kicker">{{ $copy['route_label'] }}</p>
                <h2 id="stops-title" class="route-section-title">{{ $copy['from_to'] }}</h2>
                <div class="route-stops__grid">
                    @if($pickupPoints->isNotEmpty())
                        <article class="route-stop-card">
                            <div class="route-stop-card__heading"><span class="route-stop-card__icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 5v14m0 0 5-5m-5 5-5-5"/></svg></span><div><h3>{{ $copy['pickup'] }}</h3><p class="route-stop-card__intro">{{ $copy['pickup_intro'] }}</p></div></div>
                            <div class="route-stop-list">
                                @foreach($pickupPoints as $point)
                                    <div class="route-stop">
                                        <strong>{{ $point->name }}</strong>
                                        @if($point->address)
                                            <p>{{ $point->address }}</p>
                                        @endif
                                        @if($point->phone)
                                            <a href="tel:{{ $point->phone }}">{{ $point->phone }}</a>
                                        @endif
                                        @if($point->map_url)
                                            <a href="{{ $point->map_url }}" target="_blank" rel="noopener">{{ $copy['map'] }} <span aria-hidden="true">↗</span></a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endif
                    @if($dropoffPoints->isNotEmpty())
                        <article class="route-stop-card route-stop-card--dropoff">
                            <div class="route-stop-card__heading"><span class="route-stop-card__icon"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 19V5m0 0 5 5m-5-5-5 5"/></svg></span><div><h3>{{ $copy['dropoff'] }}</h3><p class="route-stop-card__intro">{{ $copy['dropoff_intro'] }}</p></div></div>
                            <div class="route-stop-list">
                                @foreach($dropoffPoints as $point)
                                    <div class="route-stop">
                                        <strong>{{ $point->name }}</strong>
                                        @if($point->address)
                                            <p>{{ $point->address }}</p>
                                        @endif
                                        @if($point->phone)
                                            <a href="tel:{{ $point->phone }}">{{ $point->phone }}</a>
                                        @endif
                                        @if($point->map_url)
                                            <a href="{{ $point->map_url }}" target="_blank" rel="noopener">{{ $copy['map'] }} <span aria-hidden="true">↗</span></a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if($faqs->isNotEmpty())
        <section class="route-faq" aria-labelledby="faq-title">
            <div class="route-shell">
                <p class="route-section-kicker">{{ $copy['route_label'] }}</p>
                <h2 id="faq-title" class="route-section-title">{{ $copy['faq'] }}</h2>
                <div class="route-faq__list">
                    @foreach($faqs as $faq)
                        <details><summary>{{ $faq->question }}</summary><div>{!! nl2br(e($faq->answer)) !!}</div></details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="route-final">
        <div class="route-shell route-final__inner">
            <div><h2>{{ $copy['ready'] }}</h2><p>{{ $copy['ready_text'] }}</p></div>
            <div class="route-final__actions">
                <a href="{{ route('booking.redirect', ['route_id' => $route->id, 'source_page' => 'route_detail_bottom']) }}">{{ $copy['book_now'] }}</a>
                <a href="tel:1900 2879">{{ $copy['support'] }}</a>
            </div>
        </div>
    </section>
</div>
@endsection
