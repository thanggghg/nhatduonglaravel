@extends('layouts.app')

@section('content')
@php
    $locale = request()->string('lang')->lower()->value();
    $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    $copy = [
        'vi' => [
            'home' => 'Trang chủ', 'crumb' => 'Tuyến xe', 'eyebrow' => 'HÀNH TRÌNH CỦA BẠN', 'title' => 'Đi xa thật nhẹ nhàng.',
            'intro' => 'Các tuyến xe giường nằm kết nối TP. Hồ Chí Minh, Nha Trang và Cam Ranh mỗi ngày.', 'book' => 'Đặt chuyến đi',
            'browse' => 'Khám phá tuyến xe', 'activeRoutes' => 'tuyến đang phục vụ', 'support' => 'hỗ trợ mỗi ngày',
            'section' => 'Các tuyến đang phục vụ', 'sectionText' => 'Chọn chiều đi để xem lịch chạy và giá vé mới nhất.',
            'available' => 'Đang phục vụ', 'distance' => 'Quãng đường', 'duration' => 'Thời gian', 'fare' => 'Giá vé',
            'checkFare' => 'Xem lịch và giá', 'details' => 'Xem chuyến đi', 'emptyTitle' => 'Chưa có tuyến xe',
            'emptyText' => 'Vui lòng quay lại sau để xem các tuyến đang phục vụ.', 'helpTitle' => 'Chưa biết nên chọn chuyến nào?',
            'helpText' => 'Đội ngũ Nhật Dương sẽ hỗ trợ chọn tuyến, giờ chạy và điểm đón phù hợp.', 'call' => 'Gọi 1900 2879',
            'contact' => 'Liên hệ hỗ trợ', 'connector' => 'đến', 'direct' => 'Tuyến trực tiếp',
        ],
        'en' => [
            'home' => 'Home', 'crumb' => 'Routes', 'eyebrow' => 'YOUR JOURNEY', 'title' => 'Travel further, feel at ease.',
            'intro' => 'Daily sleeper-bus routes connecting Ho Chi Minh City, Nha Trang, and Cam Ranh.', 'book' => 'Book a trip',
            'browse' => 'Explore routes', 'activeRoutes' => 'routes in service', 'support' => 'daily support',
            'section' => 'Routes in service', 'sectionText' => 'Choose a direction to see current departures and fares.',
            'available' => 'In service', 'distance' => 'Distance', 'duration' => 'Travel time', 'fare' => 'Fare',
            'checkFare' => 'View schedule & fare', 'details' => 'View departures', 'emptyTitle' => 'No routes available yet',
            'emptyText' => 'Please check back soon for available routes.', 'helpTitle' => 'Not sure which trip to choose?',
            'helpText' => 'The Nhat Duong team can help you choose a route, departure time, and pickup point.', 'call' => 'Call 1900 2879',
            'contact' => 'Contact support', 'connector' => 'to', 'direct' => 'Direct route',
        ],
        'ru' => [
            'home' => 'Главная', 'crumb' => 'Маршруты', 'eyebrow' => 'ВАША ПОЕЗДКА', 'title' => 'Путешествуйте спокойно.',
            'intro' => 'Ежедневные спальные автобусы между Хошимином, Нячангом и Камранью.', 'book' => 'Забронировать поездку',
            'browse' => 'Посмотреть маршруты', 'activeRoutes' => 'маршрутов доступно', 'support' => 'поддержка каждый день',
            'section' => 'Доступные маршруты', 'sectionText' => 'Выберите направление, чтобы увидеть актуальное расписание и цены.',
            'available' => 'Маршрут доступен', 'distance' => 'Расстояние', 'duration' => 'Время в пути', 'fare' => 'Стоимость',
            'checkFare' => 'Расписание и цены', 'details' => 'Посмотреть рейсы', 'emptyTitle' => 'Маршрутов пока нет',
            'emptyText' => 'Пожалуйста, зайдите позже, чтобы увидеть доступные маршруты.', 'helpTitle' => 'Нужна помощь с выбором?',
            'helpText' => 'Команда Nhat Duong поможет выбрать маршрут, время отправления и место посадки.', 'call' => 'Позвонить: 1900 2879',
            'contact' => 'Связаться с нами', 'connector' => 'в', 'direct' => 'Прямой маршрут',
        ],
    ][$locale];
    $places = [
        'TP. Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Sài Gòn' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
        'Nha Trang' => ['en' => 'Nha Trang', 'ru' => 'Нячанг'], 'Cam Ranh' => ['en' => 'Cam Ranh', 'ru' => 'Камрань'],
    ];
    $place = fn (string $name) => $locale === 'vi' ? $name : ($places[$name][$locale] ?? $name);
    $duration = function (?string $value) use ($locale): string {
        if (!$value || $locale === 'vi') return $value ?? '---';
        return str_replace(['giờ', 'phút'], $locale === 'ru' ? ['ч', 'мин'] : ['hours', 'min'], $value);
    };
    $routeUrl = fn ($route) => route('routes.show', ['slug' => $route->slug, 'lang' => $locale]);
    $bookingUrl = route('home', ['lang' => $locale]).'#booking';
@endphp

<style>
    .route-explorer{background:#f5f8f4;color:#143b2a}.route-container{width:min(1160px,calc(100% - 40px));margin:0 auto}.route-hero{position:relative;overflow:hidden;background:radial-gradient(circle at 74% 18%,rgba(249,178,26,.24),transparent 24%),radial-gradient(circle at 92% 74%,rgba(112,213,157,.17),transparent 25%),linear-gradient(125deg,#042719,#087544);color:#fff}.route-hero:after{content:'';position:absolute;width:430px;height:430px;right:-158px;bottom:-286px;border:1px solid rgba(255,255,255,.16);border-radius:50%;box-shadow:0 0 0 36px rgba(255,255,255,.035),0 0 0 72px rgba(255,255,255,.025)}.route-crumb{position:relative;z-index:1;display:flex;gap:8px;padding:18px 0 0;color:rgba(255,255,255,.66);font-size:13px}.route-crumb a{color:#fff;font-weight:750;text-decoration:none}.route-hero__content{position:relative;z-index:1;display:grid;grid-template-columns:minmax(0,1.1fr) minmax(300px,.9fr);gap:58px;align-items:center;padding:58px 0 66px}.route-eyebrow{display:inline-flex;align-items:center;gap:8px;color:#f9b21a;font-size:11px;font-weight:900;letter-spacing:.13em;text-transform:uppercase}.route-eyebrow:before{width:30px;height:2px;background:#f9b21a;content:''}.route-hero h1{max-width:600px;margin:15px 0;color:#fff;font-size:clamp(39px,5.4vw,67px);font-weight:900;letter-spacing:-.06em;line-height:.98}.route-hero p{max-width:550px;margin:0;color:rgba(255,255,255,.78);font-size:17px;line-height:1.65}.route-hero__actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:28px}.route-btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:0 18px;border:1px solid transparent;border-radius:9px;color:#143b2a;background:#f9b21a;font-size:14px;font-weight:900;text-decoration:none;transition:transform .18s,background .18s}.route-btn:hover{transform:translateY(-1px);background:#ffca47}.route-btn--ghost{border-color:rgba(255,255,255,.38);color:#fff;background:rgba(255,255,255,.08)}.route-btn--ghost:hover{background:rgba(255,255,255,.16)}.route-map{position:relative;min-height:256px;padding:28px;border:1px solid rgba(255,255,255,.19);border-radius:24px;background:rgba(255,255,255,.09);backdrop-filter:blur(10px)}.route-map__label{margin:0 0 24px;color:rgba(255,255,255,.62);font-size:11px;font-weight:900;letter-spacing:.1em;text-transform:uppercase}.route-map__stops{position:relative;display:grid;gap:35px}.route-map__stops:before{position:absolute;top:31px;bottom:31px;left:12px;width:2px;background:repeating-linear-gradient(to bottom,rgba(255,255,255,.65) 0 5px,transparent 5px 10px);content:''}.route-map__stop{position:relative;z-index:1;display:grid;grid-template-columns:26px 1fr;gap:13px;align-items:center;font-size:18px;font-weight:850}.route-map__dot{width:26px;height:26px;border:7px solid rgba(255,255,255,.72);border-radius:50%;background:#f9b21a;box-sizing:border-box}.route-map__stop:last-child .route-map__dot{background:#fff}.route-map__foot{position:absolute;right:24px;bottom:22px;color:rgba(255,255,255,.52);font-size:12px;font-weight:700}.route-overview{position:relative;z-index:2;margin-top:-25px}.route-overview__inner{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;overflow:hidden;border:1px solid #dce9df;border-radius:14px;background:#dce9df;box-shadow:0 12px 28px rgba(6,55,33,.09)}.route-overview__item{display:flex;align-items:center;gap:12px;padding:17px 20px;background:#fff}.route-overview__bar{width:4px;height:31px;border-radius:99px;background:#f9b21a}.route-overview__item:nth-child(2) .route-overview__bar{background:#0b7f42}.route-overview__item:nth-child(3) .route-overview__bar{background:#75bb8d}.route-overview__item strong,.route-overview__item span{display:block}.route-overview__item strong{font-size:17px}.route-overview__item span{margin-top:2px;color:#668071;font-size:12px;font-weight:700}.route-listing{padding:68px 0 72px}.route-listing__head{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:25px}.route-listing__head h2{margin:0;color:#143b2a;font-size:clamp(28px,4vw,40px);font-weight:900;letter-spacing:-.045em}.route-listing__head p{max-width:390px;margin:0;color:#637b6d;font-size:15px;line-height:1.6}.route-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.route-card{position:relative;display:flex;flex-direction:column;min-height:348px;overflow:hidden;border:1px solid #d9e7dd;border-radius:17px;background:#fff;box-shadow:0 8px 22px rgba(10,71,40,.045);transition:transform .2s,box-shadow .2s}.route-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px rgba(10,71,40,.12)}.route-card__visual{position:relative;min-height:137px;padding:21px 21px 18px;color:#fff;background:linear-gradient(135deg,#056035,#0d8a4b);overflow:hidden}.route-card:nth-child(3n+2) .route-card__visual{background:linear-gradient(135deg,#0b4d35,#087960)}.route-card:nth-child(3n) .route-card__visual{background:linear-gradient(135deg,#075143,#0b7f42)}.route-card__visual:after{position:absolute;right:-52px;bottom:-81px;width:174px;height:174px;border:1px solid rgba(255,255,255,.2);border-radius:50%;box-shadow:0 0 0 24px rgba(255,255,255,.045);content:''}.route-card__status{position:relative;z-index:1;display:inline-flex;align-items:center;gap:6px;padding:5px 8px;border-radius:99px;background:rgba(255,255,255,.14);font-size:10px;font-weight:900;letter-spacing:.04em;text-transform:uppercase}.route-card__status:before{width:6px;height:6px;border-radius:50%;background:#f9b21a;content:''}.route-card__path{position:relative;z-index:1;display:grid;grid-template-columns:10px minmax(0,1fr);gap:9px;align-items:center;margin-top:19px;font-size:16px;font-weight:850;line-height:1.25}.route-card__path:before{grid-row:1 / 3;align-self:stretch;margin:5px 0;width:2px;background:repeating-linear-gradient(to bottom,rgba(255,255,255,.82) 0 4px,transparent 4px 8px);content:''}.route-card__path span{position:relative}.route-card__path span:before{position:absolute;left:-14px;top:5px;width:8px;height:8px;border:2px solid rgba(255,255,255,.86);border-radius:50%;background:#f9b21a;box-sizing:border-box;content:''}.route-card__path span:last-child:before{background:#fff}.route-card__body{display:flex;flex:1;flex-direction:column;padding:21px}.route-card h3{margin:0;color:#173d2d;font-size:20px;font-weight:900;letter-spacing:-.03em;line-height:1.2}.route-card h3 span{color:#0b7f42;font-weight:700}.route-card__facts{display:grid;grid-template-columns:1fr 1fr;gap:0;margin:19px 0 20px;border-top:1px solid #e4eee6;border-left:1px solid #e4eee6}.route-card__fact{padding:10px 10px 8px;border-right:1px solid #e4eee6;border-bottom:1px solid #e4eee6}.route-card__fact:nth-child(3){grid-column:1/-1}.route-card__fact label{display:block;margin-bottom:4px;color:#748a7e;font-size:10px;font-weight:900;letter-spacing:.07em;text-transform:uppercase}.route-card__fact span{color:#284e3d;font-size:13px;font-weight:850}.route-card__fact--fare span{color:#087841}.route-card__action{display:flex;align-items:center;justify-content:space-between;gap:10px;min-height:44px;margin-top:auto;padding:0 13px;border-radius:9px;background:#eef8f0;color:#087841;font-size:13px;font-weight:900;text-decoration:none;transition:background .18s,color .18s}.route-card__action:hover{background:#0b7f42;color:#fff}.route-card__action b{font-size:17px}.route-empty{padding:48px 24px;border:1px dashed #bcd5c4;border-radius:16px;background:#fff;text-align:center}.route-empty h2{margin:0 0 8px;font-size:22px}.route-empty p{margin:0;color:#637b6d}.route-help{padding:48px 0;background:#e5f3e8}.route-help__inner{display:flex;align-items:center;justify-content:space-between;gap:28px}.route-help h2{margin:0 0 8px;font-size:27px;font-weight:900;letter-spacing:-.035em}.route-help p{max-width:620px;margin:0;color:#5b7667;line-height:1.6}.route-help__actions{display:flex;flex-wrap:wrap;gap:9px}.route-help .route-btn{background:#0b7f42;color:#fff}.route-help .route-btn:hover{background:#075d35}.route-help .route-btn--ghost{border-color:#0b7f42;color:#087841;background:transparent}.route-help .route-btn--ghost:hover{background:#fff}.route-btn:focus-visible,.route-card__action:focus-visible{outline:3px solid #f9b21a;outline-offset:3px}@media(max-width:900px){.route-hero__content{grid-template-columns:1fr;gap:32px}.route-map{max-width:520px}.route-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.route-help__inner{align-items:start;flex-direction:column}}@media(max-width:620px){.route-container{width:min(100% - 28px,1160px)}.route-hero__content{padding:42px 0 52px}.route-hero h1{font-size:41px}.route-map{min-height:0;padding:21px;border-radius:17px}.route-map__stop{font-size:16px}.route-map__foot{display:none}.route-overview{margin-top:-16px}.route-overview__inner{grid-template-columns:1fr}.route-overview__item{padding:12px 15px}.route-overview__item strong{font-size:15px}.route-listing{padding:46px 0 52px}.route-listing__head{display:block}.route-listing__head h2{font-size:31px}.route-listing__head p{margin-top:10px}.route-grid{grid-template-columns:1fr}.route-card{min-height:0}.route-card__visual{min-height:128px}.route-help{padding:38px 0}.route-help h2{font-size:25px}}@media(prefers-reduced-motion:reduce){.route-card,.route-btn,.route-card__action{transition:none}.route-card:hover,.route-btn:hover{transform:none}}
</style>
<style>
    .route-card__visual { display:block; color:inherit; text-decoration:none; cursor:pointer; }
    .route-card__title { color:inherit; text-decoration:none; }
    .route-card__title:hover { color:#0b7f42; }
</style>

<div class="route-explorer">
    <header class="route-hero">
        <div class="route-container">
            <nav class="route-crumb" aria-label="Breadcrumb"><a href="{{ route('home', ['lang' => $locale]) }}">{{ $copy['home'] }}</a><span aria-hidden="true">/</span><span>{{ $copy['crumb'] }}</span></nav>
            <div class="route-hero__content">
                <div>
                    <span class="route-eyebrow">{{ $copy['eyebrow'] }}</span>
                    <h1>{{ $copy['title'] }}</h1>
                    <p>{{ $copy['intro'] }}</p>
                    <div class="route-hero__actions"><a class="route-btn" href="{{ $bookingUrl }}">{{ $copy['book'] }} <span aria-hidden="true">→</span></a><a class="route-btn route-btn--ghost" href="#available-routes">{{ $copy['browse'] }}</a></div>
                </div>
                <div class="route-map" aria-label="Ho Chi Minh City, Nha Trang and Cam Ranh route network">
                    <p class="route-map__label">{{ $copy['direct'] }}</p>
                    <div class="route-map__stops"><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('TP. Hồ Chí Minh') }}</span></div><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('Nha Trang') }}</span></div><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('Cam Ranh') }}</span></div></div>
                    <span class="route-map__foot">Nhat Duong</span>
                </div>
            </div>
        </div>
    </header>

    <section class="route-overview" aria-label="Service overview"><div class="route-container"><div class="route-overview__inner"><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>{{ $routes->count() }}</strong><span>{{ $copy['activeRoutes'] }}</span></div></div><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>24/7</strong><span>{{ $copy['support'] }}</span></div></div><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>{{ $place('TP. Hồ Chí Minh') }} ⇔ {{ $place('Nha Trang') }}</strong><span>{{ $copy['direct'] }}</span></div></div></div></div></section>

    <main id="available-routes" class="route-container route-listing">
        <div class="route-listing__head"><div><h2>{{ $copy['section'] }}</h2></div><p>{{ $copy['sectionText'] }}</p></div>
        @if($routes->isNotEmpty())
            <div class="route-grid">
                @foreach($routes as $route)
                    @php
                        $from = $place($route->from_location); $to = $place($route->to_location);
                        $routeDistance = trim((string) $route->distance);
                        if ($routeDistance && !preg_match('/\bkm\b/i', $routeDistance)) $routeDistance .= ' km';
                        if ($locale === 'ru') $routeDistance = str_ireplace('km', 'км', $routeDistance);
                    @endphp
                        <article class="route-card">
                            <a href="{{ $routeUrl($route) }}" class="route-card__visual" aria-label="{{ $from }} → {{ $to }}"><span class="route-card__status">{{ $copy['available'] }}</span><div class="route-card__path"><span>{{ $from }}</span><span>{{ $to }}</span></div></a>
                            <div class="route-card__body">
                            <h3><a class="route-card__title" href="{{ $routeUrl($route) }}">{{ $from }} <span>{{ $copy['connector'] }}</span> {{ $to }}</a></h3>
                            <div class="route-card__facts"><div class="route-card__fact"><label>{{ $copy['distance'] }}</label><span>{{ $routeDistance ?: '---' }}</span></div><div class="route-card__fact"><label>{{ $copy['duration'] }}</label><span>{{ $duration($route->estimated_time) }}</span></div><div class="route-card__fact route-card__fact--fare"><label>{{ $copy['fare'] }}</label><span>{{ $route->price_from > 0 ? number_format($route->price_from).' VND' : $copy['checkFare'] }}</span></div></div>
                            <a href="{{ $routeUrl($route) }}" class="route-card__action">{{ $copy['details'] }} <b aria-hidden="true">→</b></a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div style="margin-top:30px;">{{ $routes->appends(['lang' => $locale])->links() }}</div>
        @else
            <div class="route-empty"><h2>{{ $copy['emptyTitle'] }}</h2><p>{{ $copy['emptyText'] }}</p></div>
        @endif
    </main>

    <section class="route-help"><div class="route-container route-help__inner"><div><h2>{{ $copy['helpTitle'] }}</h2><p>{{ $copy['helpText'] }}</p></div><div class="route-help__actions"><a href="tel:19002879" class="route-btn">{{ $copy['call'] }}</a><a href="{{ route('contact', ['lang' => $locale]) }}" class="route-btn route-btn--ghost">{{ $copy['contact'] }}</a></div></div></section>
</div>
@endsection
