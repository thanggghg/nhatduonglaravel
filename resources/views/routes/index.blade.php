@extends('layouts.app')

@section('content')
@php
    $locale = $locale ?? request()->string('lang')->lower()->value();
    $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    $copy = [
        'vi' => [
            'home' => 'Trang chủ', 'crumb' => 'Tuyến xe', 'eyebrow' => 'HÀNH TRÌNH CỦA BẠN', 'title' => 'Đi xa thật nhẹ nhàng.',
            'intro' => 'Các tuyến xe giường nằm kết nối TP. Hồ Chí Minh, Nha Trang và Cam Ranh mỗi ngày.', 'book' => 'Đặt chuyến đi',
            'browse' => 'Khám phá tuyến xe', 'activeRoutes' => 'tuyến đang phục vụ', 'support' => 'hỗ trợ mỗi ngày',
            'section' => 'Các tuyến đang phục vụ', 'sectionText' => 'Chọn chiều đi để xem lịch chạy và giá vé mới nhất.',
            'available' => 'Đang phục vụ', 'distance' => 'Quãng đường', 'duration' => 'Thời gian', 'fare' => 'Giá từ',
            'checkFare' => 'Xem lịch và giá', 'details' => 'Xem chuyến đi', 'emptyTitle' => 'Chưa có tuyến xe',
            'emptyText' => 'Vui lòng quay lại sau để xem các tuyến đang phục vụ.', 'helpTitle' => 'Chưa biết nên chọn chuyến nào?',
            'helpText' => 'Đội ngũ Nhật Dương sẽ hỗ trợ chọn tuyến, giờ chạy và điểm đón phù hợp.', 'call' => 'Gọi 1900 2879',
            'contact' => 'Liên hệ hỗ trợ', 'connector' => 'đến', 'direct' => 'Tuyến trực tiếp', 'networkLabel' => 'Mạng lưới tuyến TP. Hồ Chí Minh, Nha Trang và Cam Ranh', 'overviewLabel' => 'Tổng quan dịch vụ',
        ],
        'en' => [
            'home' => 'Home', 'crumb' => 'Routes', 'eyebrow' => 'YOUR JOURNEY', 'title' => 'Travel further, feel at ease.',
            'intro' => 'Daily sleeper-bus routes connecting Ho Chi Minh City, Nha Trang, and Cam Ranh.', 'book' => 'Book a trip',
            'browse' => 'Explore routes', 'activeRoutes' => 'routes in service', 'support' => 'daily support',
            'section' => 'Routes in service', 'sectionText' => 'Choose a direction to see current departures and fares.',
            'available' => 'In service', 'distance' => 'Distance', 'duration' => 'Travel time', 'fare' => 'From',
            'checkFare' => 'View schedule & fare', 'details' => 'View departures', 'emptyTitle' => 'No routes available yet',
            'emptyText' => 'Please check back soon for available routes.', 'helpTitle' => 'Not sure which trip to choose?',
            'helpText' => 'The Nhat Duong team can help you choose a route, departure time, and pickup point.', 'call' => 'Call 1900 2879',
            'contact' => 'Contact support', 'connector' => 'to', 'direct' => 'Direct route', 'networkLabel' => 'Ho Chi Minh City, Nha Trang and Cam Ranh route network', 'overviewLabel' => 'Service overview',
        ],
        'ru' => [
            'home' => 'Главная', 'crumb' => 'Маршруты', 'eyebrow' => 'ВАША ПОЕЗДКА', 'title' => 'Путешествуйте спокойно.',
            'intro' => 'Ежедневные спальные автобусы между Хошимином, Нячангом и Камранью.', 'book' => 'Забронировать поездку',
            'browse' => 'Посмотреть маршруты', 'activeRoutes' => 'маршрутов доступно', 'support' => 'поддержка каждый день',
            'section' => 'Доступные маршруты', 'sectionText' => 'Выберите направление, чтобы увидеть актуальное расписание и цены.',
            'available' => 'Маршрут доступен', 'distance' => 'Расстояние', 'duration' => 'Время в пути', 'fare' => 'Цена от',
            'checkFare' => 'Расписание и цены', 'details' => 'Посмотреть рейсы', 'emptyTitle' => 'Маршрутов пока нет',
            'emptyText' => 'Пожалуйста, зайдите позже, чтобы увидеть доступные маршруты.', 'helpTitle' => 'Нужна помощь с выбором?',
            'helpText' => 'Команда Nhat Duong поможет выбрать маршрут, время отправления и место посадки.', 'call' => 'Позвонить: 1900 2879',
            'contact' => 'Связаться с нами', 'connector' => 'в', 'direct' => 'Прямой маршрут', 'networkLabel' => 'Сеть маршрутов Хошимин, Нячанг и Камрань', 'overviewLabel' => 'Обзор услуг',
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
    .route-explorer { background:#f7f4ed; color:#1c2822; }
    .route-hero { background:radial-gradient(circle at 76% 16%,rgba(249,178,26,.30),transparent 25%),radial-gradient(circle at 93% 76%,rgba(255,255,255,.09),transparent 25%),linear-gradient(125deg,#131b18,#29342e); }
    .route-map { border-color:rgba(255,255,255,.22); background:rgba(255,255,255,.09); box-shadow:0 28px 60px rgba(0,0,0,.18); }
    .route-overview { background:#fff; border-bottom:1px solid #e8e2d7; }
    .route-overview__bar { background:#f9b21a; }
    .route-listing { padding-top:76px; padding-bottom:86px; }
    .route-listing__head h2 { color:#18231e; }
    .route-card { overflow:hidden; border-color:#e5dfd3; background:#fff; box-shadow:0 16px 38px rgba(35,31,20,.07); }
    .route-card:hover { border-color:#d6c99e; box-shadow:0 22px 46px rgba(35,31,20,.12); }
    .route-card__visual { color:#302710; background:linear-gradient(135deg,#ffd466,#f7ae16) !important; }
    .route-card:nth-child(3n + 2) .route-card__visual { color:#243029; background:linear-gradient(135deg,#f4f0e8,#e9e1d2) !important; }
    .route-card:nth-child(3n) .route-card__visual { color:#fff; background:linear-gradient(135deg,#1b2722,#34443c) !important; }
    .route-card__visual:after { border-color:rgba(62,45,5,.16); box-shadow:0 0 0 24px rgba(255,255,255,.13),0 0 0 48px rgba(255,255,255,.08); }
    .route-card__status { color:#fff; background:#1a5e3b; }
    .route-card__path:before { background:rgba(75,53,4,.28); }
    .route-card__path span:before { border-color:#765607; background:#fff7d9; }
    .route-card__fact { border-color:#eee8dc; }
    .route-card__fact label { color:#766f62; }
    .route-card__fact--fare span { color:#0b7040; }
    .route-card__action { color:#245b3e; border-color:#ded7ca; }
    .route-card__action:hover { color:#fff; border-color:#245b3e; background:#245b3e; }
    .route-help { color:#fff; background:#17201c; }
    .route-help h2 { color:#fff; }
    .route-help p { color:rgba(255,255,255,.7); }
    @media (max-width:640px) { .route-listing { padding-top:54px; padding-bottom:62px; } }
</style>
<style>
    .route-explorer{--route-deep:#073a2a;--route-green:#0b5438;--route-gold:#f9df12;--route-ink:#26362f;--route-muted:#66736c;--route-cream:#fff9ed;background:linear-gradient(180deg,#fffdf8,#f5f7f2);color:var(--route-ink)}
    .route-hero{background:radial-gradient(circle at 76% 16%,rgba(249,223,18,.25),transparent 25%),radial-gradient(circle at 92% 76%,rgba(11,84,56,.1),transparent 27%),linear-gradient(125deg,#fffaf0,#eef5ef 68%,#fff6b6);color:var(--route-ink);border-bottom:1px solid #e4ddca}
    .route-hero:after{right:-145px;bottom:-285px;border-color:rgba(11,84,56,.11);box-shadow:0 0 0 38px rgba(11,84,56,.025),0 0 0 76px rgba(11,84,56,.014)}
    .route-crumb{color:#758078}.route-crumb a{color:var(--route-green)}
    .route-eyebrow{padding:7px 11px;color:#26362f;background:var(--route-gold);border:1px solid #ddc700;border-radius:999px}
    .route-eyebrow:before{width:7px;height:7px;background:var(--route-green);border-radius:50%;box-shadow:0 0 0 3px rgba(11,84,56,.13)}
    .route-hero h1{color:var(--route-deep);text-shadow:0 1px 0 rgba(255,255,255,.8)}
    .route-hero p{color:var(--route-muted)}
    .route-btn{color:#17362b;background:linear-gradient(135deg,#fff36a,var(--route-gold));box-shadow:0 9px 20px rgba(164,144,0,.18);transition:transform .2s ease,box-shadow .2s ease,background .2s ease}
    .route-hero .route-btn--ghost{color:var(--route-green);background:rgba(255,255,255,.72);border-color:#9bbda9;box-shadow:none}
    .route-map{position:relative;overflow:hidden;color:#fff;background:radial-gradient(circle at 88% 12%,rgba(249,223,18,.18),transparent 25%),linear-gradient(145deg,#0b5438,#073a2a);border-color:#1b674b;box-shadow:0 25px 55px rgba(7,58,42,.2)}
    .route-map:before{position:absolute;top:-75px;right:-58px;width:180px;height:180px;border:1px solid rgba(255,255,255,.1);border-radius:50%;box-shadow:0 0 0 24px rgba(255,255,255,.018),0 0 0 48px rgba(255,255,255,.012);content:''}
    .route-map>*{position:relative}
    .route-map__label{color:#26362f;background:var(--route-gold)}
    .route-map__stops:before{background:rgba(249,223,18,.42)}
    .route-map__dot{background:var(--route-gold);border-color:#fff8a5;box-shadow:0 0 0 5px rgba(249,223,18,.15)}
    .route-map__foot{color:#f9e979}
    .route-overview{background:linear-gradient(100deg,#fff,#fffbea 62%,#f3f7f2);border-bottom-color:#e5decb}
    .route-overview__inner{gap:12px;padding-block:18px}
    .route-overview__item{padding:13px 16px;background:rgba(255,255,255,.72);border:1px solid #e5dfd0;border-radius:11px;transition:border-color .2s ease,box-shadow .2s ease,transform .2s ease}
    .route-overview__bar{background:var(--route-gold)}
    .route-overview__item strong{color:var(--route-deep)}
    .route-listing{position:relative;padding-top:72px;background:radial-gradient(circle at 96% 8%,rgba(249,223,18,.12),transparent 22%)}
    .route-listing__head h2{display:inline;color:var(--route-deep);background:linear-gradient(transparent 74%,rgba(249,223,18,.65) 74%)}
    .route-listing__head p{color:var(--route-muted)}
    .route-grid{gap:18px}
    .route-card{--card-accent:#0b5438;--card-soft:#e7f3eb;position:relative;border-color:#ded8c9;background:#fff;box-shadow:0 14px 36px rgba(61,52,27,.07);transition:border-color .24s ease,box-shadow .24s ease,transform .24s ease}
    .route-card:nth-child(3n+2){--card-accent:#b45f47;--card-soft:#f9e4dc}
    .route-card:nth-child(3n){--card-accent:#446f98;--card-soft:#e3edf6}
    .route-card:before{position:absolute;top:0;right:20px;left:20px;z-index:4;height:4px;background:var(--route-gold);border-radius:0 0 5px 5px;content:'';transform:scaleX(.3);transform-origin:left;transition:transform .3s ease}
    .route-card__visual{color:#17362b;background:linear-gradient(135deg,#fff36a,var(--route-gold))!important}
    .route-card:nth-child(3n+2) .route-card__visual{color:#4c2e26;background:linear-gradient(135deg,#fff6f2,#f3cabc)!important}
    .route-card:nth-child(3n) .route-card__visual{color:#fff;background:linear-gradient(135deg,#0b5438,#073a2a)!important}
    .route-card__visual:after{border-color:color-mix(in srgb,var(--card-accent) 24%,transparent);box-shadow:0 0 0 24px rgba(255,255,255,.12),0 0 0 48px rgba(255,255,255,.07)}
    .route-card__status{color:#fff;background:var(--card-accent);box-shadow:0 6px 15px color-mix(in srgb,var(--card-accent) 22%,transparent)}
    .route-card:nth-child(3n) .route-card__status{color:#17362b;background:var(--route-gold)}
    .route-card__path:before{background:color-mix(in srgb,var(--card-accent) 36%,transparent)}
    .route-card__path span:before{border-color:var(--card-accent);background:#fff}
    .route-card__body{background:linear-gradient(180deg,#fff,#fffdf8)}
    .route-card__title{color:var(--route-deep)}
    .route-card__title span{color:#8b7b28}
    .route-card__facts{gap:8px}
    .route-card__fact{padding:10px;background:#fafaf7;border:1px solid #ece6da;border-radius:9px}
    .route-card__fact:nth-child(2){background:#fff9e5;border-color:#eee0ad}
    .route-card__fact--fare{background:var(--card-soft);border-color:color-mix(in srgb,var(--card-accent) 22%,#e8e2d6)}
    .route-card__fact--fare span{color:var(--card-accent)}
    .route-card__action{color:#17362b;background:var(--route-gold);border-color:var(--route-gold);box-shadow:0 8px 18px rgba(164,144,0,.15);transition:background-color .2s ease,box-shadow .2s ease,transform .2s ease}
    .route-card__action b{transition:transform .2s ease}
    .route-help{position:relative;overflow:hidden;color:#fff;background:radial-gradient(circle at 88% 15%,rgba(249,223,18,.19),transparent 25%),linear-gradient(120deg,#073a2a,#062d1c);border-top:4px solid var(--route-gold)}
    .route-help:before{position:absolute;right:-70px;bottom:-180px;width:320px;height:320px;border:1px solid rgba(255,255,255,.09);border-radius:50%;box-shadow:0 0 0 34px rgba(255,255,255,.018),0 0 0 68px rgba(255,255,255,.012);content:''}
    .route-help__inner{position:relative}
    .route-help .route-btn--ghost{color:#fff;background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.32);box-shadow:none}
    .route-motion-ready .route-reveal{opacity:0;transform:translateY(18px);transition:opacity .54s ease var(--route-delay,0ms),transform .54s cubic-bezier(.2,.72,.25,1) var(--route-delay,0ms)}
    .route-motion-ready .route-reveal.is-visible{opacity:1;transform:none}
    @keyframes route-dot-pulse{0%,100%{box-shadow:0 0 0 5px rgba(249,223,18,.15)}50%{box-shadow:0 0 0 10px rgba(249,223,18,0)}}
    @media(hover:hover) and (pointer:fine){
        .route-btn:hover{color:#17362b;background:linear-gradient(135deg,#fff67d,#e5cd00);box-shadow:0 12px 25px rgba(164,144,0,.24);transform:translateY(-2px)}
        .route-hero .route-btn--ghost:hover{color:#fff;background:var(--route-green);border-color:var(--route-green)}
        .route-map:hover{box-shadow:0 30px 64px rgba(7,58,42,.25);transform:translateY(-3px)}
        .route-overview__item:hover{border-color:#d9c555;box-shadow:0 10px 24px rgba(91,75,21,.08);transform:translateY(-3px)}
        .route-card:hover{border-color:var(--card-accent);box-shadow:0 22px 48px color-mix(in srgb,var(--card-accent) 14%,transparent);transform:translateY(-6px)}
        .route-card:hover:before{transform:scaleX(1)}
        .route-card__action:hover{color:#17362b;background:#e5cd00;border-color:#e5cd00;box-shadow:0 11px 23px rgba(164,144,0,.22);transform:translateY(-2px)}
        .route-card__action:hover b{transform:translateX(4px)}
        .route-help .route-btn--ghost:hover{color:#17362b;background:#fff;border-color:#fff}
    }
    @media(prefers-reduced-motion:no-preference){.route-map__dot{animation:route-dot-pulse 2.5s ease-out infinite}.route-map{transition:box-shadow .25s ease,transform .25s ease}}
    @media(max-width:720px){.route-hero__content{gap:34px;padding:46px 0 54px}.route-map{width:100%}.route-overview__inner{gap:9px}.route-overview__item{padding:12px}.route-listing{padding-top:54px}}
    @media(prefers-reduced-motion:reduce){.route-motion-ready .route-reveal{opacity:1;transform:none}.route-map__dot{animation:none}}
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
                <div class="route-map" aria-label="{{ $copy['networkLabel'] }}">
                    <p class="route-map__label">{{ $copy['direct'] }}</p>
                    <div class="route-map__stops"><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('TP. Hồ Chí Minh') }}</span></div><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('Nha Trang') }}</span></div><div class="route-map__stop"><span class="route-map__dot"></span><span>{{ $place('Cam Ranh') }}</span></div></div>
                    <span class="route-map__foot">Nhat Duong</span>
                </div>
            </div>
        </div>
    </header>

    <section class="route-overview" aria-label="{{ $copy['overviewLabel'] }}"><div class="route-container"><div class="route-overview__inner"><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>{{ $routes->count() }}</strong><span>{{ $copy['activeRoutes'] }}</span></div></div><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>24/7</strong><span>{{ $copy['support'] }}</span></div></div><div class="route-overview__item"><span class="route-overview__bar"></span><div><strong>{{ $place('TP. Hồ Chí Minh') }} ⇔ {{ $place('Nha Trang') }}</strong><span>{{ $copy['direct'] }}</span></div></div></div></div></section>

    <div id="available-routes" class="route-container route-listing">
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
    </div>

    <section class="route-help"><div class="route-container route-help__inner"><div><h2>{{ $copy['helpTitle'] }}</h2><p>{{ $copy['helpText'] }}</p></div><div class="route-help__actions"><a href="tel:19002879" class="route-btn">{{ $copy['call'] }}</a><a href="{{ route('contact', ['lang' => $locale]) }}" class="route-btn route-btn--ghost">{{ $copy['contact'] }}</a></div></div></section>
</div>
<script>
    (() => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
        const items = [...document.querySelectorAll('.route-hero__content,.route-overview__item,.route-listing__head,.route-card,.route-empty,.route-help__inner')];
        document.querySelector('.route-explorer')?.classList.add('route-motion-ready');
        items.forEach((item, index) => {
            item.classList.add('route-reveal');
            item.style.setProperty('--route-delay', `${(index % 4) * 60}ms`);
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
                window.setTimeout(() => {
                    entry.target.classList.remove('route-reveal', 'is-visible');
                    entry.target.style.removeProperty('--route-delay');
                }, 800);
            });
        }, { threshold:0.1, rootMargin:'0px 0px -24px' });
        items.forEach((item) => observer.observe(item));
    })();
</script>
@endsection
