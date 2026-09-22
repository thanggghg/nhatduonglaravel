@extends('layouts.app')

@section('content')
@php
    $copy = [
        'vi' => ['home' => 'Trang chủ', 'crumb' => 'Lịch trình', 'eyebrow' => 'CẬP NHẬT TRỰC TUYẾN', 'title' => 'Lịch chạy hôm nay', 'intro' => 'Giờ chạy, giá vé và số ghế được lấy trực tiếp từ hệ thống đặt vé.', 'date' => 'Ngày khởi hành', 'route' => 'Tuyến xe', 'allRoutes' => 'Tất cả các tuyến', 'search' => 'Xem lịch chạy', 'live' => 'Dữ liệu trực tuyến', 'departure' => 'Khởi hành', 'arrival' => 'Đến nơi', 'duration' => 'Thời gian', 'vehicle' => 'Loại xe', 'seats' => 'chỗ còn lại', 'fare' => 'Giá vé', 'usdNote' => 'Giá USD tham khảo', 'book' => 'Đặt chuyến này', 'soldOut' => 'Hết chỗ', 'emptyTitle' => 'Chưa có chuyến phù hợp', 'emptyText' => 'Hãy đổi ngày hoặc tuyến xe để xem lịch chạy trực tuyến.', 'apiError' => 'Hiện chưa thể tải lịch chạy trực tuyến. Vui lòng thử lại sau.', 'notice' => 'Lịch chạy và giá vé được cập nhật trực tiếp. Số ghế được xác nhận khi bạn tiếp tục đặt vé.', 'to' => 'đến', 'hours' => 'giờ', 'minutes' => 'phút'],
        'en' => ['home' => 'Home', 'crumb' => 'Schedule', 'eyebrow' => 'LIVE AVAILABILITY', 'title' => 'Live departure schedule', 'intro' => 'Departure times, fares, and seat availability come directly from our booking provider.', 'date' => 'Departure date', 'route' => 'Route', 'allRoutes' => 'All routes', 'search' => 'View departures', 'live' => 'Live data', 'departure' => 'Departure', 'arrival' => 'Arrival', 'duration' => 'Duration', 'vehicle' => 'Vehicle', 'seats' => 'seats remaining', 'fare' => 'Fare', 'usdNote' => 'Approximate USD fare', 'book' => 'Book this trip', 'soldOut' => 'Sold out', 'emptyTitle' => 'No matching departures', 'emptyText' => 'Try another date or route to see live departures.', 'apiError' => 'Live departures are temporarily unavailable. Please try again shortly.', 'notice' => 'Departure times and fares are updated live. Availability is confirmed when you continue to booking.', 'to' => 'to', 'hours' => 'hr', 'minutes' => 'min'],
        'ru' => ['home' => 'Главная', 'crumb' => 'Расписание', 'eyebrow' => 'АКТУАЛЬНЫЕ ДАННЫЕ', 'title' => 'Актуальное расписание', 'intro' => 'Время отправления, стоимость и наличие мест поступают напрямую из системы бронирования.', 'date' => 'Дата отправления', 'route' => 'Маршрут', 'allRoutes' => 'Все маршруты', 'search' => 'Посмотреть рейсы', 'live' => 'Актуальные данные', 'departure' => 'Отправление', 'arrival' => 'Прибытие', 'duration' => 'В пути', 'vehicle' => 'Автобус', 'seats' => 'мест осталось', 'fare' => 'Стоимость', 'usdNote' => 'Примерная цена в USD', 'book' => 'Забронировать', 'soldOut' => 'Нет мест', 'emptyTitle' => 'Подходящих рейсов нет', 'emptyText' => 'Выберите другую дату или маршрут, чтобы увидеть актуальные рейсы.', 'apiError' => 'Актуальное расписание временно недоступно. Попробуйте позже.', 'notice' => 'Расписание и цены обновляются напрямую. Наличие мест подтверждается при переходе к бронированию.', 'to' => 'в', 'hours' => 'ч', 'minutes' => 'мин'],
    ][$locale];
    $places = ['TP. Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Nha Trang' => ['en' => 'Nha Trang', 'ru' => 'Нячанг'], 'Cam Ranh' => ['en' => 'Cam Ranh', 'ru' => 'Камрань']];
    $place = fn (string $name) => $locale === 'vi' ? $name : ($places[$name][$locale] ?? $name);
    $routeName = fn (array $route) => $place($route['from']).' '.$copy['to'].' '.$place($route['to']);
    $duration = function ($minutes) use ($copy): string {
        $minutes = (int) $minutes;
        if (!$minutes) return '---';
        if ($minutes < 60) return $minutes.' '.$copy['minutes'];
        return intdiv($minutes, 60).' '.$copy['hours'].($minutes % 60 ? ' '.($minutes % 60).' '.$copy['minutes'] : '');
    };
    $vndPerUsd = max(1, (int) config('services.currency.vnd_per_usd', 26000));
    $toUsd = fn (int|float $amount): string => number_format($amount / $vndPerUsd, 0);
@endphp

<style>
    .live-schedule{min-height:70vh;background:#f4f8f5;color:#153d2b}.schedule-container{width:min(1100px,calc(100% - 32px));margin:0 auto}.schedule-hero{padding:18px 0 44px;background:radial-gradient(circle at 83% 18%,rgba(249,178,26,.2),transparent 23%),linear-gradient(125deg,#052b1a,#087943);color:#fff}.schedule-crumb{display:flex;gap:8px;color:rgba(255,255,255,.66);font-size:13px}.schedule-crumb a{color:#fff;font-weight:750;text-decoration:none}.schedule-hero__content{display:flex;align-items:end;justify-content:space-between;gap:26px;margin-top:40px}.schedule-eyebrow{display:inline-flex;align-items:center;gap:8px;color:#f9b21a;font-size:11px;font-weight:900;letter-spacing:.12em;text-transform:uppercase}.schedule-eyebrow:before{width:24px;height:2px;background:#f9b21a;content:''}.schedule-hero h1{margin:12px 0 9px;color:#fff;font-size:clamp(34px,5vw,53px);font-weight:900;letter-spacing:-.05em;line-height:1.03}.schedule-hero p{max-width:610px;margin:0;color:rgba(255,255,255,.76);font-size:16px;line-height:1.6}.schedule-live-badge{display:grid;gap:4px;min-width:150px;padding:13px 15px;border:1px solid rgba(255,255,255,.2);border-radius:11px;background:rgba(255,255,255,.08)}.schedule-live-badge span{color:#f9b21a;font-size:11px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}.schedule-live-badge strong{font-size:13px}.schedule-filter{position:relative;margin-top:-20px}.schedule-filter form{display:grid;grid-template-columns:minmax(145px,.65fr) minmax(180px,1fr) auto;gap:12px;align-items:end;padding:17px;border:1px solid #d8e7dc;border-radius:14px;background:#fff;box-shadow:0 12px 26px rgba(5,54,31,.1)}.schedule-field{display:grid;gap:6px}.schedule-field label{color:#567162;font-size:11px;font-weight:900;letter-spacing:.06em;text-transform:uppercase}.schedule-field input,.schedule-field select{width:100%;height:44px;padding:0 11px;border:1px solid #c9d9ce;border-radius:8px;background:#fff;color:#173d2b;font:700 14px Inter,sans-serif}.schedule-filter button,.schedule-card__action{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 17px;border:0;border-radius:8px;background:#0b7f42;color:#fff;font:900 13px Inter,sans-serif;text-decoration:none;cursor:pointer;transition:background .18s,transform .18s}.schedule-filter button:hover,.schedule-card__action:hover{background:#075d35;transform:translateY(-1px)}.schedule-filter button:focus-visible,.schedule-card__action:focus-visible{outline:3px solid #f9b21a;outline-offset:3px}.schedule-results{padding:42px 0 62px}.schedule-results__head{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:14px}.schedule-results__head h2{margin:0;font-size:25px;font-weight:900;letter-spacing:-.03em}.schedule-results__head span{display:inline-flex;align-items:center;gap:7px;color:#087841;font-size:12px;font-weight:900}.schedule-results__head span:before{width:7px;height:7px;border-radius:50%;background:#0b7f42;content:''}.schedule-notice{margin:0 0 18px;padding:12px 14px;border:1px solid #cfe5d4;border-radius:10px;background:#e9f5eb;color:#486c57;font-size:13px;line-height:1.5}.schedule-alert{margin:0 0 18px;padding:13px 14px;border:1px solid #f2c8b3;border-radius:10px;background:#fff4ef;color:#9a3412;font-size:14px;font-weight:750}.schedule-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px}.schedule-card{display:grid;grid-template-columns:92px minmax(0,1fr);gap:17px;padding:18px;border:1px solid #d8e7dc;border-radius:15px;background:#fff;box-shadow:0 5px 16px rgba(10,71,40,.045)}.schedule-time{display:grid;align-content:start;justify-items:center;gap:4px;padding-right:15px;border-right:1px solid #e2ede5}.schedule-time strong{font-size:25px;letter-spacing:-.05em}.schedule-time span{color:#668073;font-size:10px;font-weight:900;letter-spacing:.06em;text-transform:uppercase}.schedule-card__main{min-width:0}.schedule-card__route{margin:0;color:#163d2b;font-size:16px;font-weight:900;line-height:1.3}.schedule-card__route span{color:#0b7f42;font-weight:700}.schedule-card__stops{overflow:hidden;margin:6px 0 13px;color:#668073;font-size:11px;text-overflow:ellipsis;white-space:nowrap}.schedule-card__stops b{color:#0b7f42}.schedule-card__facts{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:15px}.schedule-card__fact label{display:block;margin-bottom:3px;color:#768b7f;font-size:9px;font-weight:900;letter-spacing:.06em;text-transform:uppercase}.schedule-card__fact span{color:#315846;font-size:12px;font-weight:850}.schedule-card__fact--seats span{color:#087841}.schedule-card__bottom{display:flex;align-items:center;justify-content:space-between;gap:12px}.schedule-card__fare{display:grid;gap:1px}.schedule-card__fare span{color:#72877a;font-size:10px;font-weight:800;text-transform:uppercase}.schedule-card__fare strong{color:#087841;font-size:17px;letter-spacing:-.02em}.schedule-card__action{min-height:38px;padding:0 12px;font-size:12px}.schedule-card__sold{padding:9px 11px;border-radius:8px;background:#fff1eb;color:#9a3412;font-size:12px;font-weight:900}.schedule-empty{padding:52px 22px;border:1px dashed #bcd6c4;border-radius:15px;background:#fff;text-align:center}.schedule-empty h2{margin:0 0 8px;font-size:21px}.schedule-empty p{margin:0;color:#61796a}.schedule-empty__icon{display:grid;place-items:center;width:44px;height:44px;margin:0 auto 13px;border-radius:50%;background:#e6f3e9;color:#087841;font-size:20px;font-weight:900}@media(max-width:760px){.schedule-hero__content{display:block;margin-top:29px}.schedule-live-badge{display:none}.schedule-filter form{grid-template-columns:1fr;padding:14px}.schedule-filter button{width:100%}.schedule-grid{grid-template-columns:1fr}.schedule-results{padding-top:31px}}@media(max-width:440px){.schedule-container{width:min(100% - 24px,1100px)}.schedule-hero{padding-bottom:36px}.schedule-card{grid-template-columns:68px minmax(0,1fr);gap:12px;padding:14px}.schedule-time{padding-right:11px}.schedule-time strong{font-size:21px}.schedule-card__facts{grid-template-columns:1fr 1fr}.schedule-card__facts>:last-child{grid-column:1/-1}.schedule-card__bottom{align-items:end;flex-direction:column}.schedule-card__fare{align-self:stretch}.schedule-card__action,.schedule-card__sold{width:100%;box-sizing:border-box}.schedule-card__sold{text-align:center}}@media(prefers-reduced-motion:reduce){.schedule-filter button,.schedule-card__action{transition:none}.schedule-filter button:hover,.schedule-card__action:hover{transform:none}}
</style>
<style>
    .schedule-card__facts { grid-template-columns:repeat(4,minmax(0,1fr)); }
    .schedule-card__fact--seats { color:#0b7f42; }
    .schedule-card__fact--seats span { color:#0b7f42; font-weight:900; }
    .live-schedule { --schedule-deep:#062d1c; --schedule-green:#0b7f42; --schedule-gold:#fbb116; --schedule-ink:#18332a; --schedule-muted:#607269; --schedule-line:#d8e5dc; background:#f7faf7; color:var(--schedule-ink); }
    .schedule-hero { background:radial-gradient(circle at 84% 12%,rgba(251,177,22,.16),transparent 24%),radial-gradient(circle at 70% 100%,rgba(11,127,66,.3),transparent 38%),linear-gradient(125deg,#052719,var(--schedule-deep) 58%,#075b35); }
    .schedule-eyebrow,.schedule-live-badge span { color:#ffd36e; }
    .schedule-eyebrow:before { background:var(--schedule-gold); }
    .schedule-live-badge { background:rgba(255,255,255,.07); border-color:rgba(255,255,255,.24); box-shadow:inset 0 1px 0 rgba(255,255,255,.08); }
    .schedule-filter form { border-color:#cfded3; border-top:3px solid var(--schedule-gold); box-shadow:0 16px 36px rgba(6,45,28,.1); }
    .schedule-field input,.schedule-field select { background:#f8fbf8; border-color:#c7d8cc; }
    .schedule-field input:focus,.schedule-field select:focus { outline:3px solid rgba(11,127,66,.14); outline-offset:1px; border-color:var(--schedule-green); background:#fff; }
    .schedule-filter button { color:#533b00; background:var(--schedule-gold); box-shadow:0 7px 18px rgba(251,177,22,.2); }
    .schedule-filter button:hover { background:#f4a900; }
    .schedule-results__head h2 { color:var(--schedule-deep); }
    .schedule-results__head>span { color:var(--schedule-green); background:#eaf6ed; border:1px solid #cfe5d5; border-radius:999px; padding:7px 11px; }
    .schedule-notice { color:#61512d; background:#fff9e9; border-color:#efdda8; border-left:3px solid var(--schedule-gold); }
    .schedule-card { border-color:#d2e1d6; box-shadow:0 12px 30px rgba(6,45,28,.06); transition:border-color .2s ease,box-shadow .2s ease,transform .2s ease; }
    .schedule-card:hover { border-color:#9fc5aa; box-shadow:0 18px 38px rgba(6,45,28,.1); transform:translateY(-2px); }
    .schedule-time { color:var(--schedule-deep); background:#eaf6ed; border-right-color:#cfe3d4; }
    .schedule-card__route { color:var(--schedule-deep); }
    .schedule-card__stops b,.schedule-card__fare strong { color:var(--schedule-green); }
    .schedule-card__fare small { display:block; margin-top:4px; color:#7b6a3b; font-size:11px; font-weight:800; }
    .schedule-card__action { background:var(--schedule-green); box-shadow:0 7px 18px rgba(11,127,66,.16); }
    .schedule-card__action:hover { background:#075d35; }
    .schedule-empty { background:#fff; border-color:#cbded0; box-shadow:0 12px 30px rgba(6,45,28,.04); }
    .schedule-empty__icon { color:#7b5a00; background:#fff2cf; }
    @media(max-width:720px){.schedule-card__facts{grid-template-columns:repeat(2,minmax(0,1fr));}}
</style>
<style>
    .live-schedule{--schedule-deep:#073a2a;--schedule-green:#0b5438;--schedule-gold:#f7b916;--schedule-cream:#fff9ed;--schedule-ink:#26362f;--schedule-muted:#66736c;--schedule-line:#e4dece;background:linear-gradient(180deg,#fffdf8,#f5f7f2);color:var(--schedule-ink)}
    .schedule-hero{position:relative;overflow:hidden;padding:22px 0 62px;color:var(--schedule-ink);background:radial-gradient(circle at 82% 20%,rgba(247,185,22,.24),transparent 23%),radial-gradient(circle at 65% 110%,rgba(11,84,56,.12),transparent 38%),linear-gradient(125deg,#fffaf0,#eef5ef 66%,#fff3c7);border-bottom:1px solid #e5dcc9}
    .schedule-hero:before{position:absolute;top:-175px;right:-80px;width:410px;height:410px;border:1px solid rgba(11,84,56,.12);border-radius:50%;box-shadow:0 0 0 50px rgba(11,84,56,.025),0 0 0 100px rgba(11,84,56,.014);content:''}
    .schedule-hero:after{position:absolute;right:19%;bottom:34px;width:170px;height:2px;background:linear-gradient(90deg,transparent,var(--schedule-gold),transparent);content:'';transform:rotate(-8deg)}
    .schedule-hero .schedule-container{position:relative}
    .schedule-crumb{color:#728078}.schedule-crumb a{color:var(--schedule-green)}
    .schedule-hero__content{margin-top:38px}
    .schedule-eyebrow{padding:7px 11px;color:#745815;background:#fff1c0;border:1px solid #e7ce7c;border-radius:999px}
    .schedule-eyebrow:before{width:7px;height:7px;background:var(--schedule-gold);border-radius:50%;box-shadow:0 0 0 4px rgba(247,185,22,.17)}
    .schedule-hero h1{color:var(--schedule-deep);text-shadow:0 1px 0 rgba(255,255,255,.8)}
    .schedule-hero p{color:var(--schedule-muted)}
    .schedule-live-badge{position:relative;overflow:hidden;min-width:172px;padding:16px 17px;color:#fff;background:linear-gradient(145deg,#0b5438,#073a2a);border:1px solid #0b5438;box-shadow:0 14px 30px rgba(7,58,42,.18)}
    .schedule-live-badge:before{position:absolute;top:0;right:0;left:0;height:3px;background:var(--schedule-gold);content:''}
    .schedule-live-badge span{display:flex;align-items:center;gap:7px;color:#ffe191}
    .schedule-live-badge span:before{width:7px;height:7px;background:var(--schedule-gold);border-radius:50%;box-shadow:0 0 0 4px rgba(247,185,22,.16);content:''}
    .schedule-filter{margin-top:-29px}
    .schedule-filter form{position:relative;overflow:hidden;padding:20px;background:linear-gradient(145deg,rgba(255,255,255,.98),rgba(255,249,237,.98));border:1px solid #e0d6be;border-top:1px solid #e0d6be;box-shadow:0 18px 42px rgba(54,48,29,.12);transition:border-color .24s ease,box-shadow .24s ease,transform .24s ease}
    .schedule-filter form:before{position:absolute;top:0;right:0;left:0;height:4px;background:linear-gradient(90deg,var(--schedule-green) 0 30%,var(--schedule-gold) 30%);content:''}
    .schedule-filter form:focus-within{border-color:#dcb84d;box-shadow:0 22px 48px rgba(54,48,29,.15),0 0 0 3px rgba(247,185,22,.1)}
    .schedule-field label{color:#5c665f}
    .schedule-field input,.schedule-field select{height:48px;color:var(--schedule-deep);background:#fff;border-color:#d9d3c4;box-shadow:inset 0 1px 0 rgba(255,255,255,.8),0 4px 12px rgba(52,48,35,.035);transition:border-color .2s ease,box-shadow .2s ease,background-color .2s ease}
    .schedule-field input:hover,.schedule-field select:hover{border-color:#d5b75f}
    .schedule-field input:focus,.schedule-field select:focus{outline:3px solid rgba(11,84,56,.11);border-color:var(--schedule-green)}
    .schedule-filter button{min-height:48px;color:#17362b;background:linear-gradient(135deg,#ffc928,var(--schedule-gold));box-shadow:0 9px 20px rgba(178,126,0,.2);transition:transform .2s ease,box-shadow .2s ease,background .2s ease}
    .schedule-results{padding:52px 0 80px}
    .schedule-results__head h2{color:var(--schedule-deep);font-size:28px}
    .schedule-results__head>span{color:#0b5438;background:#e7f3eb;border-color:#bfdac8;box-shadow:0 5px 14px rgba(11,84,56,.07)}
    .schedule-notice{padding:15px 17px;color:#66562c;background:linear-gradient(100deg,#fff9e9,#fff3c7);border:1px solid #ead38b;border-left:4px solid var(--schedule-gold);border-radius:11px;box-shadow:0 8px 20px rgba(109,80,16,.045)}
    .schedule-grid{gap:16px}
    .schedule-card{--card-accent:#0b5438;--card-soft:#e8f3eb;position:relative;overflow:hidden;background:rgba(255,255,255,.96);border-color:#ddd8ca;box-shadow:0 11px 28px rgba(53,47,29,.055);transition:border-color .24s ease,box-shadow .24s ease,transform .24s ease}
    .schedule-card:nth-child(3n+2){--card-accent:#b17d06;--card-soft:#fff2ca}
    .schedule-card:nth-child(3n){--card-accent:#a85b46;--card-soft:#fbe6df}
    .schedule-card:before{position:absolute;top:0;right:22px;left:22px;z-index:2;height:4px;background:var(--card-accent);border-radius:0 0 5px 5px;content:'';transform:scaleX(.28);transform-origin:left;transition:transform .3s ease}
    .schedule-time{color:var(--card-accent);background:linear-gradient(155deg,#fff,var(--card-soft));border-right-color:#e1dccf}
    .schedule-time strong{font-size:27px}
    .schedule-card__main{padding-top:22px}
    .schedule-card__route{color:var(--schedule-deep)}
    .schedule-card__stops b{color:var(--card-accent)}
    .schedule-card__fact{padding:9px;border:1px solid #ebe6da;border-radius:9px;background:#fafaf7}
    .schedule-card__fact:nth-child(2){background:#fff9e9;border-color:#eee0b9}
    .schedule-card__fact:nth-child(3){background:#f8f2ef;border-color:#eadbd5}
    .schedule-card__fact--seats{background:#eaf4ed!important;border-color:#cde2d3!important}
    .schedule-card__fact label{color:#7a7c74}
    .schedule-card__fact span{color:#35463e}
    .schedule-card__fact--seats,.schedule-card__fact--seats span{color:var(--schedule-green)}
    .schedule-card__bottom{margin-top:15px;padding-top:15px;border-top:1px solid #e8e2d5}
    .schedule-card__fare strong{color:#8d6400}
    .schedule-card__fare small{color:#756b52}
    .schedule-card__action{color:#17362b;background:linear-gradient(135deg,#ffc928,var(--schedule-gold));box-shadow:0 8px 18px rgba(178,126,0,.17);transition:transform .2s ease,box-shadow .2s ease,background .2s ease}
    .schedule-card__action span{transition:transform .2s ease}
    .schedule-card__sold{color:#8b594b;background:#fae8e2;border:1px solid #ebc8bc;border-radius:8px}
    .schedule-empty{background:linear-gradient(145deg,#fff,#fff9ed);border-color:#e1d8c4;box-shadow:0 14px 34px rgba(53,47,29,.06)}
    .schedule-empty__icon{color:#765400;background:#fff0bf}
    .schedule-motion-ready .schedule-reveal{opacity:0;transform:translateY(18px);transition:opacity .52s ease var(--schedule-delay,0ms),transform .52s cubic-bezier(.2,.72,.25,1) var(--schedule-delay,0ms)}
    .schedule-motion-ready .schedule-reveal.is-visible{opacity:1;transform:none}
    @keyframes schedule-live-pulse{0%,100%{box-shadow:0 0 0 4px rgba(247,185,22,.16)}50%{box-shadow:0 0 0 8px rgba(247,185,22,0)}}
    @media(hover:hover) and (pointer:fine){
        .schedule-filter form:hover{border-color:#d8bd6c;box-shadow:0 22px 48px rgba(54,48,29,.15);transform:translateY(-2px)}
        .schedule-filter button:hover{background:linear-gradient(135deg,#ffd34d,#e9ab0f);box-shadow:0 12px 26px rgba(178,126,0,.27);transform:translateY(-2px)}
        .schedule-card:hover{border-color:var(--card-accent);box-shadow:0 19px 42px color-mix(in srgb,var(--card-accent) 13%,transparent);transform:translateY(-5px)}
        .schedule-card:hover:before{transform:scaleX(1)}
        .schedule-card__action:hover{color:#102d23;background:linear-gradient(135deg,#ffd34d,#e9ab0f);box-shadow:0 11px 24px rgba(178,126,0,.24);transform:translateY(-2px)}
        .schedule-card__action:hover span{transform:translateX(4px)}
    }
    @media(prefers-reduced-motion:no-preference){.schedule-live-badge span:before{animation:schedule-live-pulse 2.4s ease-out infinite}}
    @media(max-width:720px){
        .schedule-hero{padding-bottom:54px}.schedule-hero__content{align-items:flex-start;flex-direction:column}.schedule-live-badge{width:100%}
        .schedule-filter form{grid-template-columns:1fr;padding:18px}.schedule-filter button{width:100%}
        .schedule-results{padding:42px 0 64px}.schedule-card{grid-template-columns:1fr}.schedule-time{display:flex;align-items:center;justify-content:space-between;padding:17px 19px;border-right:0;border-bottom:1px solid #e1dccf;text-align:left}.schedule-time span{margin:0}.schedule-card__main{padding-top:18px}
    }
    @media(prefers-reduced-motion:reduce){.schedule-motion-ready .schedule-reveal{opacity:1;transform:none}.schedule-live-badge span:before{animation:none}}
</style>

<div class="live-schedule">
    <header class="schedule-hero"><div class="schedule-container"><nav class="schedule-crumb" aria-label="Breadcrumb"><a href="{{ route('home', ['lang' => $locale]) }}">{{ $copy['home'] }}</a><span aria-hidden="true">/</span><span>{{ $copy['crumb'] }}</span></nav><div class="schedule-hero__content"><div><span class="schedule-eyebrow">{{ $copy['eyebrow'] }}</span><h1>{{ $copy['title'] }}</h1><p>{{ $copy['intro'] }}</p></div><div class="schedule-live-badge"><span>{{ $copy['live'] }}</span><strong>{{ $date->format('d/m/Y') }}</strong></div></div></div></header>

    <div class="schedule-container schedule-filter"><form method="GET" action="{{ route('schedules.index') }}"><input type="hidden" name="lang" value="{{ $locale }}"><div class="schedule-field"><label for="schedule-date">{{ $copy['date'] }}</label><input id="schedule-date" type="date" name="date" min="{{ today()->toDateString() }}" value="{{ $date->toDateString() }}"></div><div class="schedule-field"><label for="schedule-route">{{ $copy['route'] }}</label><select id="schedule-route" name="route"><option value="">{{ $copy['allRoutes'] }}</option>@foreach($routes as $route)<option value="{{ $route['key'] }}" @selected(request('route') === $route['key'])>{{ $routeName($route) }}</option>@endforeach</select></div><button type="submit">{{ $copy['search'] }}</button></form></div>

    <div class="schedule-container schedule-results"><div class="schedule-results__head"><h2>{{ $date->format('d/m/Y') }}</h2><span>{{ $copy['live'] }}</span></div>
        @if($apiError)<p class="schedule-alert" role="alert">{{ $copy['apiError'] }}</p>@endif
        <p class="schedule-notice">{{ $copy['notice'] }}</p>
        @if($schedules->isNotEmpty())
            <div class="schedule-grid">
                @foreach($schedules as $schedule)
                    @php $route = $schedule['route']; $canBook = $schedule['available_seats'] > 0; @endphp
                    <article class="schedule-card"><div class="schedule-time"><strong>{{ $schedule['departure']->format('H:i') }}</strong><span>{{ $copy['departure'] }}</span></div><div class="schedule-card__main"><h3 class="schedule-card__route">{{ $routeName($route) }}</h3><p class="schedule-card__stops">{{ $schedule['pickup'] }} <b aria-hidden="true">→</b> {{ $schedule['dropoff'] }}</p><div class="schedule-card__facts"><div class="schedule-card__fact"><label>{{ $copy['arrival'] }}</label><span>{{ $schedule['arrival']->format('H:i') }}</span></div><div class="schedule-card__fact"><label>{{ $copy['duration'] }}</label><span>{{ $duration($schedule['duration']) }}</span></div><div class="schedule-card__fact"><label>{{ $copy['vehicle'] }}</label><span>{{ $schedule['vehicle_type'] }}</span></div><div class="schedule-card__fact schedule-card__fact--seats"><label>{{ $copy['seats'] }}</label><span>{{ $schedule['available_seats'] }}</span></div></div><div class="schedule-card__bottom"><div class="schedule-card__fare"><span>{{ $copy['fare'] }}</span><strong>{{ number_format($schedule['fare']) }} VND</strong><small title="{{ $copy['usdNote'] }}">≈ ${{ $toUsd($schedule['fare']) }} USD</small></div>@if($canBook)<a class="schedule-card__action" href="{{ $schedule['booking_url'] }}">{{ $copy['book'] }} <span aria-hidden="true">→</span></a>@else<span class="schedule-card__sold">{{ $copy['soldOut'] }}</span>@endif</div></div></article>
                @endforeach
            </div>
        @else
            <div class="schedule-empty"><div class="schedule-empty__icon" aria-hidden="true">×</div><h2>{{ $copy['emptyTitle'] }}</h2><p>{{ $copy['emptyText'] }}</p></div>
        @endif
    </div>
</div>
<script>
    (() => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
        const items = [...document.querySelectorAll('.schedule-hero__content,.schedule-filter form,.schedule-results__head,.schedule-notice,.schedule-card,.schedule-empty')];
        document.querySelector('.live-schedule')?.classList.add('schedule-motion-ready');
        items.forEach((item, index) => {
            item.classList.add('schedule-reveal');
            item.style.setProperty('--schedule-delay', `${(index % 4) * 55}ms`);
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
                window.setTimeout(() => {
                    entry.target.classList.remove('schedule-reveal', 'is-visible');
                    entry.target.style.removeProperty('--schedule-delay');
                }, 760);
            });
        }, { threshold:0.1, rootMargin:'0px 0px -24px' });
        items.forEach((item) => observer.observe(item));
    })();
</script>
@endsection
