@extends('layouts.app')

@section('content')
@php
    $copy = [
        'vi' => ['home' => 'Trang chủ', 'crumb' => 'Lịch trình', 'eyebrow' => 'NHẬT DƯƠNG · LỊCH CHẠY HẰNG NGÀY', 'title' => 'Lịch trình', 'scriptTitle' => 'Schedule', 'intro' => 'Khung giờ cố định mỗi ngày trên tuyến TP. Hồ Chí Minh ⇄ Nha Trang.', 'fixed' => 'Lịch chạy cố định', 'daily' => 'Áp dụng hằng ngày', 'departureTimes' => 'Giờ khởi hành', 'notice' => 'Vào dịp lễ, Tết và thời gian cao điểm, Nhật Dương có thể tăng cường thêm chuyến để phục vụ hành khách.', 'hotline' => 'Hotline đặt vé', 'bookNow' => 'Đặt vé ngay', 'tripCount' => 'khung giờ'],
        'en' => ['home' => 'Home', 'crumb' => 'Schedule', 'eyebrow' => 'NHAT DUONG · DAILY SCHEDULE', 'title' => 'Schedule', 'scriptTitle' => 'Departure times', 'intro' => 'Fixed daily departure times between Ho Chi Minh City and Nha Trang.', 'fixed' => 'Fixed schedule', 'daily' => 'Operates daily', 'departureTimes' => 'Departure times', 'notice' => 'Additional departures may be added during holidays and peak periods to serve passenger demand.', 'hotline' => 'Booking hotline', 'bookNow' => 'Book now', 'tripCount' => 'departure times'],
        'ru' => ['home' => 'Главная', 'crumb' => 'Расписание', 'eyebrow' => 'NHAT DUONG · ЕЖЕДНЕВНОЕ РАСПИСАНИЕ', 'title' => 'Расписание', 'scriptTitle' => 'Время отправления', 'intro' => 'Фиксированное ежедневное расписание между Хошимином и Нячангом.', 'fixed' => 'Постоянное расписание', 'daily' => 'Ежедневно', 'departureTimes' => 'Время отправления', 'notice' => 'В праздники и периоды высокого спроса могут быть добавлены дополнительные рейсы.', 'hotline' => 'Горячая линия', 'bookNow' => 'Забронировать', 'tripCount' => 'времени отправления'],
    ][$locale];
    $places = ['TP. Hồ Chí Minh' => ['en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'], 'Nha Trang' => ['en' => 'Nha Trang', 'ru' => 'Нячанг'], 'Cam Ranh' => ['en' => 'Cam Ranh', 'ru' => 'Камрань']];
    $place = fn (string $name) => $locale === 'vi' ? $name : ($places[$name][$locale] ?? $name);
    $scheduleGroups = collect([
        ['from' => 'TP. Hồ Chí Minh', 'to' => 'Nha Trang', 'times' => ['05:00', '07:30', '09:00', '12:30', '14:00', '17:00', '22:15', '22:35', '23:00', '23:10', '23:15', '23:30', '23:45', '23:50', '23:55']],
        ['from' => 'Nha Trang', 'to' => 'TP. Hồ Chí Minh', 'times' => ['08:00', '09:00', '11:30', '12:30', '14:00', '15:30', '16:00', '17:00', '21:30', '22:15', '22:30', '22:45', '23:00', '23:15']],
    ]);
    $totalTrips = $scheduleGroups->sum(fn (array $group) => count($group['times']));
    $bookingUrl = route('home', ['lang' => $locale]).'#booking';
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
<style>
    .live-schedule{--schedule-deep:#183f2c;--schedule-green:#214c35;--schedule-gold:#d9b23f;--schedule-gold-bright:#f9df12;--schedule-cream:#fbf8f1;--schedule-ink:#172d22;--schedule-muted:#647068;background:radial-gradient(circle at 8% 17%,rgba(226,187,72,.13),transparent 18%),radial-gradient(circle at 96% 56%,rgba(226,187,72,.12),transparent 21%),linear-gradient(180deg,#fbf9f4,#f6f1e6);color:var(--schedule-ink)}
    .schedule-container{width:min(1180px,calc(100% - 40px))}
    .schedule-hero{position:relative;overflow:hidden;padding:18px 0 92px;color:var(--schedule-ink);background:radial-gradient(circle at 12% 22%,rgba(230,190,64,.18),transparent 20%),linear-gradient(115deg,#fbf9f4 0 62%,#eed070 62% 100%);border-bottom:0}
    .schedule-hero:before{top:auto;right:-120px;bottom:-300px;width:720px;height:720px;border:1px solid rgba(255,255,255,.55);box-shadow:0 0 0 60px rgba(255,255,255,.23),0 0 0 120px rgba(255,255,255,.12)}
    .schedule-hero:after{right:auto;bottom:46px;left:5%;width:50%;height:3px;background:linear-gradient(90deg,transparent,var(--schedule-gold),transparent);transform:rotate(-5deg)}
    .schedule-crumb{color:#768078}.schedule-crumb a{color:var(--schedule-green)}
    .schedule-hero__content{position:relative;z-index:1;display:grid;grid-template-columns:minmax(0,1.08fr) minmax(380px,.92fr);gap:42px;align-items:center;margin-top:30px}
    .schedule-hero__copy{position:relative;z-index:2;max-width:690px}
    .schedule-hero__logo{display:block;width:190px;height:65px;margin-bottom:17px;object-fit:contain;filter:drop-shadow(0 5px 11px rgba(90,72,12,.12))}
    .schedule-eyebrow{padding:7px 11px;color:#183f2c;background:#fff5c9;border:1px solid #d9bd62;border-radius:999px;font-size:10px;letter-spacing:.1em}
    .schedule-eyebrow:before{width:7px;height:7px;background:var(--schedule-gold-bright);box-shadow:0 0 0 4px rgba(217,178,63,.16)}
    .schedule-hero h1{margin:15px 0 0;color:var(--schedule-green);font-family:Georgia,'Times New Roman',serif;font-size:clamp(62px,7vw,94px);font-weight:700;line-height:.9;letter-spacing:-.055em;text-transform:uppercase;text-shadow:0 2px 0 #fff}
    .schedule-hero__script{display:block;width:max-content;margin:-2px 0 10px 205px;color:#c9a331;font-family:Georgia,'Times New Roman',serif;font-size:clamp(31px,4vw,49px);font-style:italic;line-height:1;transform:rotate(-5deg)}
    .schedule-hero__copy>p{max-width:610px;color:#5e6963;font-size:16px;font-weight:600;line-height:1.65}
    .schedule-live-badge{display:inline-flex;align-items:center;gap:14px;min-width:0;margin-top:19px;padding:10px 13px;color:#fff;background:var(--schedule-green);border:1px solid var(--schedule-green);border-radius:999px;box-shadow:0 9px 20px rgba(24,63,44,.14)}
    .schedule-live-badge:before{display:none}
    .schedule-live-badge span{display:flex;align-items:center;gap:7px;color:#fff0a5;font-size:10px}
    .schedule-live-badge strong{font-family:Inter,Arial,sans-serif;font-size:13px;font-weight:900;letter-spacing:-.01em}
    .schedule-hero__visual{position:relative;z-index:1;min-height:330px;overflow:hidden;border:1px solid rgba(217,178,63,.58);border-radius:52% 19% 42% 22%/38% 24% 31% 27%;background:#ede8dc;box-shadow:0 24px 50px rgba(61,52,21,.16);transform:rotate(1.5deg)}
    .schedule-hero__visual:after{position:absolute;inset:0;background:linear-gradient(105deg,rgba(251,249,244,.2),transparent 42%),linear-gradient(0deg,rgba(24,63,44,.14),transparent 45%);content:''}
    .schedule-hero__visual img{width:100%;height:100%;min-height:330px;object-fit:cover;transform:scale(1.04)}
    .schedule-hero__visual>span{position:absolute;right:22px;bottom:20px;z-index:2;width:76px;height:13px;background:var(--schedule-gold-bright);border-radius:99px;box-shadow:0 0 0 7px rgba(255,255,255,.72)}
    .schedule-filter{z-index:3;margin-top:-38px}
    .schedule-filter form{grid-template-columns:minmax(190px,.65fr) minmax(260px,1fr) auto;padding:18px 20px;background:rgba(255,253,247,.97);border:1px solid #d7bb60;border-top:1px solid #d7bb60;border-radius:18px;box-shadow:0 18px 40px rgba(82,68,23,.13);backdrop-filter:blur(12px)}
    .schedule-filter form:before{height:5px;background:linear-gradient(90deg,var(--schedule-green) 0 68%,var(--schedule-gold-bright) 68%)}
    .schedule-field label{color:#536158;font-size:10px}
    .schedule-field input,.schedule-field select{height:50px;color:var(--schedule-deep);background:#fff;border-color:#d9cfb3;border-radius:10px;font-weight:800}
    .schedule-field input:focus,.schedule-field select:focus{outline:3px solid rgba(249,223,18,.19);border-color:#b99531}
    .schedule-filter button{min-height:50px;padding-inline:23px;color:#fff;background:var(--schedule-green);border-radius:10px;box-shadow:0 9px 20px rgba(24,63,44,.17);font-weight:900}
    .schedule-results{padding:48px 0 72px}
    .schedule-results__head{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:28px;padding:0 7px}
    .schedule-results__head>div>span{color:#8a6c14;font-size:10px;font-weight:900;letter-spacing:.1em;text-transform:uppercase}
    .schedule-results__head h2{margin:5px 0 0;color:var(--schedule-green);font-family:Inter,Arial,sans-serif;font-size:28px;font-weight:850;line-height:1.1;letter-spacing:-.03em}
    .schedule-results__head>strong{padding:9px 13px;color:#17362b;background:#f7e9aa;border:1px solid #dec46d;border-radius:999px;font-size:11px;font-weight:900}
    .schedule-alert{margin-bottom:20px;border-radius:11px}
    .schedule-boards{display:grid;gap:42px}
    .schedule-board{position:relative;padding-top:27px}
    .schedule-board__route{position:absolute;top:0;right:6%;left:6%;z-index:2;display:grid;grid-template-columns:35px minmax(0,1fr) 88px minmax(0,1fr);align-items:center;min-height:62px;padding:0 22px;color:#fff;background:linear-gradient(100deg,#214c35,#183f2c);border:1px solid #315f46;border-radius:999px;box-shadow:0 10px 23px rgba(24,63,44,.14)}
    .schedule-board__pin{display:grid;width:30px;height:30px;place-items:center;color:#17362b;background:linear-gradient(145deg,#fff0a0,#d9b23f);border-radius:50%}
    .schedule-board__pin svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.8}
    .schedule-board__route strong{font-family:Inter,Arial,sans-serif;font-size:clamp(21px,2.4vw,30px);font-weight:850;letter-spacing:-.025em;text-align:center;text-transform:uppercase;white-space:nowrap}
    .schedule-board__route i{display:grid;width:88px;height:54px;place-items:center;justify-self:center;color:#fff;background:linear-gradient(100deg,#ecd071,#cda43b);border-radius:999px;font-family:Arial,sans-serif;font-size:35px;font-style:normal;box-shadow:inset 0 0 0 1px rgba(255,255,255,.25)}
    .schedule-board__body{padding:57px 27px 27px;background:rgba(255,253,248,.9);border:1px solid #d5bb6d;border-radius:21px;box-shadow:0 13px 31px rgba(89,73,25,.055)}
    .schedule-board__heading{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:18px;color:var(--schedule-green)}
    .schedule-board__heading>span{display:grid;width:33px;height:33px;place-items:center;border:1px solid #b89d49;border-radius:50%}
    .schedule-board__heading svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:1.7}
    .schedule-board__heading h3{margin:0;font-size:14px;font-weight:900;letter-spacing:.045em;text-transform:uppercase}
    .schedule-board__heading small{padding-left:11px;border-left:1px solid #d4c99e;color:#7b806f;font-size:10px;font-weight:800}
    .schedule-slots{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:11px}
    .schedule-slot{display:grid;min-width:0;min-height:74px;align-content:center;padding:9px 8px;color:#20372b;background:rgba(255,255,255,.76);border:1px solid #cfb76c;border-radius:999px;text-align:center;text-decoration:none;transition:color .2s ease,background .2s ease,border-color .2s ease,box-shadow .2s ease,transform .2s ease}
    .schedule-slot:nth-child(4n+1),.schedule-slot:nth-child(4n){color:#5d491c;background:linear-gradient(100deg,#fff3bd,#ebcf70);border-color:#d0ad45}
    .schedule-slot strong{font-family:Georgia,'Times New Roman',serif;font-size:clamp(26px,2.45vw,33px);font-weight:400;line-height:1;letter-spacing:.035em}
    .schedule-slot span{display:none}
    .schedule-slot small{color:#68736c;font-size:9px;font-weight:800}
    .schedule-slot:nth-child(4n+1) small,.schedule-slot:nth-child(4n) small{color:#75591f}
    .schedule-slot.is-sold-out{opacity:.55;filter:grayscale(.35)}
    .schedule-notice{display:flex;gap:12px;align-items:flex-start;margin:26px auto 0;padding:0 14px;color:#4d6156;background:transparent;border:0;box-shadow:none;font-size:14px;font-style:italic;line-height:1.6}
    .schedule-notice>span{color:var(--schedule-green);font-size:27px;line-height:.7}
    .schedule-booking{display:grid;grid-template-columns:minmax(170px,.55fr) minmax(240px,1fr) auto;gap:22px;align-items:center;margin-top:32px;padding:20px 27px;color:#fff;background:linear-gradient(105deg,#214c35,#183f2c);border:1px solid #c5a444;border-radius:18px;box-shadow:0 14px 32px rgba(24,63,44,.14)}
    .schedule-booking>div{display:grid;gap:5px}.schedule-booking>div>span{color:#f4d86f;font-size:10px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}.schedule-booking>div>strong{font-size:12px}.schedule-booking>a:not(.schedule-booking__button){color:#fff;font-size:clamp(27px,3.4vw,39px);font-weight:750;letter-spacing:.025em;text-decoration:none}.schedule-booking__button{display:inline-flex;min-height:45px;align-items:center;justify-content:center;gap:8px;padding:0 17px;color:#17362b;background:var(--schedule-gold-bright);border-radius:9px;font-size:12px;font-weight:900;text-decoration:none;white-space:nowrap}
    .schedule-empty{border-color:#d6b955;background:rgba(255,253,248,.86)}
    @media(hover:hover) and (pointer:fine){.schedule-filter button:hover{color:#17362b;background:var(--schedule-gold-bright);box-shadow:0 12px 25px rgba(151,122,26,.23);transform:translateY(-2px)}.schedule-slot[href]:hover{color:#fff;background:var(--schedule-green);border-color:var(--schedule-green);box-shadow:0 12px 24px rgba(24,63,44,.16);transform:translateY(-4px)}.schedule-slot[href]:hover small{color:rgba(255,255,255,.72)}.schedule-booking__button:hover{background:#fff178;transform:translateY(-2px)}}
    @media(max-width:980px){.schedule-hero__content{grid-template-columns:minmax(0,1fr) 350px}.schedule-slots{grid-template-columns:repeat(5,minmax(0,1fr))}.schedule-board__route{grid-template-columns:32px minmax(0,1fr) 72px minmax(0,1fr)}.schedule-board__route i{width:72px}.schedule-board__route strong{font-size:24px}}
    @media(max-width:760px){.schedule-container{width:min(100% - 28px,1180px)}.schedule-hero{padding-bottom:62px;background:radial-gradient(circle at 8% 16%,rgba(230,190,64,.18),transparent 20%),linear-gradient(145deg,#fbf9f4 0 76%,#eed070 76%)}.schedule-hero__content{grid-template-columns:1fr;gap:25px}.schedule-hero__logo{width:145px;height:48px}.schedule-hero h1{font-size:clamp(49px,15vw,66px)}.schedule-hero__script{margin-left:100px;font-size:30px}.schedule-hero__copy>p{font-size:14px}.schedule-hero__visual{min-height:200px}.schedule-hero__visual img{min-height:200px}.schedule-results{padding:37px 0 54px}.schedule-results__head{align-items:flex-start;flex-direction:column;gap:10px}.schedule-boards{gap:34px}.schedule-board{padding-top:25px}.schedule-board__route{right:0;left:0;grid-template-columns:26px minmax(0,1fr) 43px minmax(0,1fr);min-height:56px;padding:0 11px}.schedule-board__pin{width:25px;height:25px}.schedule-board__pin svg{width:15px;height:15px}.schedule-board__route strong{font-size:clamp(13px,4vw,17px)}.schedule-board__route i{width:43px;height:40px;font-size:24px}.schedule-board__body{padding:48px 11px 17px;border-radius:17px}.schedule-board__heading{flex-wrap:wrap;gap:7px;margin-bottom:14px}.schedule-board__heading h3{font-size:12px}.schedule-board__heading small{font-size:9px}.schedule-slots{grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}.schedule-slot{min-height:68px;padding:7px 4px}.schedule-slot strong{font-size:25px}.schedule-booking{grid-template-columns:1fr;gap:10px;padding:19px}.schedule-booking__button{justify-self:start}.schedule-notice{padding-inline:3px;font-size:13px}}
    @media(max-width:360px){.schedule-board__route strong{font-size:12px}.schedule-slots{grid-template-columns:repeat(2,minmax(0,1fr))}.schedule-slot strong{font-size:26px}.schedule-hero__script{margin-left:72px}}
    @media(prefers-reduced-motion:reduce){.schedule-slot,.schedule-booking__button{transition:none}}
</style>

<div class="live-schedule">
    <header class="schedule-hero"><div class="schedule-container"><nav class="schedule-crumb" aria-label="Breadcrumb"><a href="{{ route('home', ['lang' => $locale]) }}">{{ $copy['home'] }}</a><span aria-hidden="true">/</span><span>{{ $copy['crumb'] }}</span></nav><div class="schedule-hero__content"><div class="schedule-hero__copy"><img class="schedule-hero__logo" src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}" alt="Nhật Dương"><span class="schedule-eyebrow">{{ $copy['eyebrow'] }}</span><h1>{{ $copy['title'] }}</h1><span class="schedule-hero__script">{{ $copy['scriptTitle'] }}</span><p>{{ $copy['intro'] }}</p><div class="schedule-live-badge"><span>{{ $copy['fixed'] }}</span><strong>{{ $copy['daily'] }}</strong></div></div><div class="schedule-hero__visual"><img src="{{ asset('storage/image/b6c6290cc.jpg') }}" alt="Nhật Dương"><span aria-hidden="true"></span></div></div></div></header>

    <div class="schedule-container schedule-results"><div class="schedule-results__head"><div><span>{{ $copy['fixed'] }}</span><h2>{{ $copy['daily'] }}</h2></div><strong>{{ $totalTrips }} {{ $copy['tripCount'] }}</strong></div>
        <div class="schedule-boards">
            @foreach($scheduleGroups as $group)
                <section class="schedule-board" aria-label="{{ $place($group['from']) }} - {{ $place($group['to']) }}">
                    <header class="schedule-board__route"><span class="schedule-board__pin" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg></span><strong>{{ $place($group['from']) }}</strong><i aria-hidden="true">→</i><strong>{{ $place($group['to']) }}</strong></header>
                    <div class="schedule-board__body"><div class="schedule-board__heading"><span aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><h3>{{ $copy['departureTimes'] }}</h3><small>{{ count($group['times']) }} {{ $copy['tripCount'] }}</small></div><div class="schedule-slots">
                        @foreach($group['times'] as $time)<a class="schedule-slot" href="{{ $bookingUrl }}" aria-label="{{ $copy['bookNow'] }} {{ $time }}"><strong>{{ $time }}</strong><span>{{ $copy['bookNow'] }}</span></a>@endforeach
                    </div></div>
                </section>
            @endforeach
        </div>
        <p class="schedule-notice"><span aria-hidden="true">•</span>{{ $copy['notice'] }}</p>
        <aside class="schedule-booking"><div><span>{{ $copy['bookNow'] }}</span><strong>{{ $copy['hotline'] }}</strong></div><a href="tel:19002879">1900 2879</a><a class="schedule-booking__button" href="{{ $bookingUrl }}">{{ $copy['bookNow'] }} <span aria-hidden="true">→</span></a></aside>
    </div>
</div>
<script>
    (() => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
        const items = [...document.querySelectorAll('.schedule-hero__content,.schedule-results__head,.schedule-board,.schedule-notice,.schedule-booking')];
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
