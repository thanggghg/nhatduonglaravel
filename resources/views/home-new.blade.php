@php
  $siteUrl = rtrim(config('app.url'), '/');
  $homeUrls = collect(['vi', 'en', 'ru'])->mapWithKeys(fn ($language) => [$language => $siteUrl.route('home', ['lang' => $language], false)]);
  $seoTitle = 'Nhat Duong | '.($locale === 'ru' ? 'Автобусы Хошимин - Нячанг' : ($locale === 'vi' ? 'Xe khách Sài Gòn - Nha Trang' : 'Ho Chi Minh City to Nha Trang buses'));
  $seoDescription = $locale === 'ru' ? 'Расписание, места посадки и бронирование автобусов между Хошимином и Нячангом.' : ($locale === 'vi' ? 'Lịch chạy, điểm đón trả và đặt vé xe tuyến Sài Gòn - Nha Trang.' : 'Departures, pickup details, and online booking for buses between Ho Chi Minh City and Nha Trang.');
  $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
  $heroImage = $heroBanner && $heroBanner->hasImage() ? $heroBanner->image_url : asset('nha-xe-binh-minh-bus-2048x867.png');
  $seoImage = \App\Support\Seo::assetUrl($heroImage);
  $homeSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
      ['@type' => 'Organization', '@id' => $siteUrl.'/#organization', 'name' => 'Nhà Xe Nhật Dương', 'url' => $siteUrl, 'logo' => \App\Support\Seo::url('/Nhat-Duong-Logo-1-768x543.png'), 'telephone' => '1900 2879'],
      ['@type' => 'WebSite', '@id' => $siteUrl.'/#website', 'url' => $siteUrl, 'name' => 'Nhà Xe Nhật Dương', 'publisher' => ['@id' => $siteUrl.'/#organization']],
      ['@type' => 'WebPage', '@id' => $homeUrls[$locale].'#webpage', 'url' => $homeUrls[$locale], 'name' => $seoTitle, 'description' => $seoDescription, 'isPartOf' => ['@id' => $siteUrl.'/#website'], 'inLanguage' => $locale],
    ],
  ];
@endphp
<!doctype html>
<html lang="{{ $locale }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=7e81f84">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=7e81f84">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=7e81f84">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=7e81f84">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=7e81f84">
  <title>{{ $seoTitle }}</title>
  <meta name="description" content="{{ $seoDescription }}">
  <link rel="canonical" href="{{ $homeUrls[$locale] }}">
  @foreach($homeUrls as $language => $url)<link rel="alternate" hreflang="{{ $language }}" href="{{ $url }}">@endforeach
  <link rel="alternate" hreflang="x-default" href="{{ $homeUrls['vi'] }}">
  <meta property="og:title" content="{{ $seoTitle }}">
  <meta property="og:description" content="{{ $seoDescription }}">
  <meta property="og:url" content="{{ $homeUrls[$locale] }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Nhà Xe Nhật Dương">
  <meta property="og:locale" content="{{ ['vi' => 'vi_VN', 'en' => 'en_US', 'ru' => 'ru_RU'][$locale] }}">
  <meta property="og:image" content="{{ $seoImage }}">
  <meta property="og:image:alt" content="{{ $seoTitle }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $seoTitle }}">
  <meta name="twitter:description" content="{{ $seoDescription }}">
  <meta name="twitter:image" content="{{ $seoImage }}">
  <script type="application/ld+json">{!! json_encode($homeSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Allura&family=Be+Vietnam+Pro:wght@600;700;800&family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  :root { --hn-green:#0b7f42; --hn-deep:#062d1c; --hn-gold:#f9df12; --hn-ink:#18332a; --hn-muted:#62766c; --hn-mist:#f5f9f5; --hn-line:#d9e5dc; }
  * { box-sizing:border-box; } html { scroll-behavior:smooth; } body.home-new { margin:0; color:var(--hn-ink); background:#fff; font-family:Inter,system-ui,sans-serif; } .hn-shell { width:min(1160px, calc(100% - 40px)); margin:auto; }
  .hn-header { position:sticky; top:0; z-index:20; background:rgba(255,255,255,.96); border-bottom:1px solid rgba(6,45,28,.1); backdrop-filter:blur(14px); } .hn-nav-wrap { min-height:70px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
  .hn-brand { display:flex; align-items:center; gap:9px; color:var(--hn-deep); text-decoration:none; font-weight:800; white-space:nowrap; } .hn-brand img { width:34px; height:34px; object-fit:contain; } .hn-nav { display:flex; gap:20px; } .hn-nav a,.hn-contact { color:var(--hn-muted); text-decoration:none; font-size:14px; font-weight:600; } .hn-nav a:hover,.hn-contact:hover { color:var(--hn-green); }
  .hn-actions,.hn-locale { display:flex; align-items:center; gap:8px; } .hn-locale { padding:3px; border:1px solid var(--hn-line); border-radius:8px; } .hn-locale a { padding:5px 7px; color:var(--hn-muted); text-decoration:none; font-size:11px; font-weight:800; border-radius:5px; } .hn-locale a[aria-current="page"] { color:#fff; background:var(--hn-deep); } .hn-menu-button { display:none; width:40px; height:40px; padding:9px; border:1px solid var(--hn-line); border-radius:8px; background:#fff; cursor:pointer; } .hn-menu-button span { display:block; height:2px; margin:4px 0; background:var(--hn-deep); } .hn-mobile-nav { border-top:1px solid var(--hn-line); background:#fff; } .hn-mobile-nav .hn-shell { display:grid; padding:10px 0 14px; } .hn-mobile-nav a { padding:12px 0; color:var(--hn-deep); border-bottom:1px solid var(--hn-line); font-size:14px; font-weight:700; text-decoration:none; }
  .hn-button { display:inline-flex; justify-content:center; align-items:center; min-height:44px; padding:11px 18px; border:0; border-radius:8px; font:700 14px Inter,sans-serif; text-decoration:none; cursor:pointer; transition:transform .18s ease, background .18s ease; } .hn-button:hover { transform:translateY(-1px); } .hn-button--primary { color:#fff; background:var(--hn-green); } .hn-button--gold { color:#5d4300; background:var(--hn-gold); }
  .hn-hero { position:relative; isolation:isolate; overflow:hidden; min-height:650px; display:grid; align-items:center; color:#fff; } .hn-hero__image,.hn-hero__overlay { position:absolute; inset:0; width:100%; height:100%; } .hn-hero__image { z-index:-2; object-fit:cover; } .hn-hero__overlay { z-index:-1; background:linear-gradient(90deg,rgba(4,35,22,.88),rgba(4,35,22,.58) 58%,rgba(4,35,22,.22)); }
  .hn-hero__content { padding:80px 0 48px; } .hn-hero__copy { max-width:690px; } .hn-eyebrow { margin:0 0 14px; color:#d6f1df; font-size:12px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; } .hn-eyebrow--green { color:var(--hn-green); } h1,h2,h3,p { margin-top:0; } h1 { max-width:780px; margin-bottom:18px; font-size:clamp(38px,5vw,64px); line-height:1.05; letter-spacing:-.045em; } h2 { margin-bottom:12px; color:var(--hn-deep); font-size:clamp(30px,3.4vw,46px); line-height:1.1; letter-spacing:-.035em; } .hn-hero__copy > p:not(.hn-eyebrow),.hn-lead { max-width:610px; color:rgba(255,255,255,.88); font-size:18px; line-height:1.6; }
  .hn-booking { margin-top:34px; max-width:1120px; color:var(--hn-ink); background:#fff; border-radius:16px; box-shadow:0 18px 50px rgba(0,0,0,.18); } .hn-booking fieldset { margin:0; padding:20px; border:0; } .hn-booking legend { padding:0 0 12px; font-size:14px; font-weight:800; }
  .hn-booking__fields { display:grid; grid-template-columns:1.25fr 1.25fr 1fr .7fr auto; gap:10px; } .hn-booking label { display:grid; gap:5px; color:var(--hn-muted); font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; } .hn-booking select,.hn-booking input { width:100%; min-height:44px; padding:0 11px; color:var(--hn-ink); background:#fff; border:1px solid var(--hn-line); border-radius:8px; font:600 14px Inter,sans-serif; text-transform:none; } .hn-form-error { margin:14px 0 0; color:#a62929; font-size:13px; font-weight:700; }
  .hn-trust { display:flex; flex-wrap:wrap; gap:20px; padding:21px 0 0; margin:0; list-style:none; font-size:13px; font-weight:700; } .hn-trust li { display:flex; align-items:center; gap:8px; } .hn-trust svg { width:17px; height:17px; fill:none; stroke:#f8d478; stroke-width:2; }
  .hn-section { padding:96px 0; } .hn-section--mist { background:var(--hn-mist); } .hn-section-heading { max-width:700px; margin-bottom:34px; } .hn-section-heading > p:not(.hn-eyebrow) { color:var(--hn-muted); line-height:1.6; } .hn-section-heading--center { margin-inline:auto; text-align:center; }
  .hn-route-card { display:grid; grid-template-columns:1.05fr .95fr; overflow:hidden; background:#fff; border:1px solid var(--hn-line); border-radius:16px; box-shadow:0 12px 32px rgba(11,127,66,.09); } .hn-route-card>img { min-height:370px; width:100%; height:100%; object-fit:cover; } .hn-route-card__content { padding:38px; } .hn-route-card dl { display:grid; grid-template-columns:1fr 1fr; gap:22px 16px; margin:0 0 26px; } .hn-route-card dt { margin-bottom:5px; color:var(--hn-muted); font-size:12px; font-weight:700; } .hn-route-card dd { margin:0; color:var(--hn-deep); font-size:18px; font-weight:800; } .hn-check-list { display:grid; gap:11px; padding:0; margin:0 0 28px; list-style:none; color:#365145; font-size:14px; font-weight:600; } .hn-check-list li::before { content:'✓'; margin-right:9px; color:#9a7000; font-weight:900; }
  .hn-schedule { overflow:hidden; background:#fff; border:1px solid var(--hn-line); border-radius:16px; } .hn-schedule__head,.hn-schedule__row { display:grid; grid-template-columns:.7fr 1.4fr 1fr auto; gap:16px; align-items:center; padding:18px 24px; } .hn-schedule__head { color:var(--hn-muted); background:#eef6ef; font-size:11px; font-weight:800; letter-spacing:.07em; text-transform:uppercase; } .hn-schedule__row { border-top:1px solid var(--hn-line); } .hn-schedule__row strong { color:var(--hn-deep); font-size:20px; } .hn-schedule__row span { color:#476156; font-size:14px; font-weight:600; } .hn-schedule__row a { color:var(--hn-green); font-size:13px; font-weight:800; text-decoration:none; } .hn-empty { padding:24px; color:var(--hn-muted); }
  .hn-pickup { display:grid; grid-template-columns:.85fr 1.15fr; gap:72px; align-items:center; } .hn-pickup__visual { min-height:430px; overflow:hidden; border-radius:16px; } .hn-pickup__visual img { width:100%; height:100%; object-fit:cover; } .hn-pickup .hn-lead { color:var(--hn-muted); font-size:16px; } .hn-info-list { display:grid; gap:18px; padding:0; margin:30px 0 0; list-style:none; counter-reset:info; } .hn-info-list li { position:relative; padding-left:52px; counter-increment:info; } .hn-info-list li::before { content:'0' counter(info); position:absolute; left:0; top:0; display:grid; place-items:center; width:34px; height:34px; color:#7b5a00; background:#fef3d7; border-radius:50%; font-size:11px; font-weight:800; } .hn-info-list strong,.hn-info-list span { display:block; } .hn-info-list strong { margin-bottom:4px; color:var(--hn-deep); } .hn-info-list span { color:var(--hn-muted); font-size:14px; line-height:1.55; }
  .hn-stop-groups { display:grid; gap:18px; margin-top:28px; } .hn-stop-group { padding:18px; border:1px solid var(--hn-line); border-radius:12px; background:#fff; } .hn-stop-group h3 { margin-bottom:12px; color:var(--hn-deep); font-size:15px; } .hn-stop-group ul { display:grid; gap:12px; padding:0; margin:0; list-style:none; } .hn-stop-group li { display:grid; gap:3px; } .hn-stop-group strong { color:var(--hn-deep); font-size:14px; } .hn-stop-group span { color:var(--hn-muted); font-size:13px; line-height:1.5; } .hn-stop-group a { color:var(--hn-green); font-size:12px; font-weight:800; text-decoration:none; }
  .hn-policy { padding:34px 0; background:#fef8e8; border-block:1px solid #f0dfb7; } .hn-policy__content { display:grid; grid-template-columns:1fr 1.3fr auto; gap:28px; align-items:center; } .hn-policy p { margin:0; color:var(--hn-muted); font-size:14px; line-height:1.6; } .hn-policy ul { display:grid; gap:8px; padding:0; margin:0; list-style:none; color:#365145; font-size:13px; line-height:1.5; } .hn-policy li::before { content:'✓'; margin-right:8px; color:#9a7000; font-weight:900; }
   .hn-steps { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; padding:0; margin:0; list-style:none; } .hn-steps li { padding:28px; background:#fff; border:1px solid var(--hn-line); border-radius:16px; } .hn-steps span { color:#9a7000; font-size:12px; font-weight:800; letter-spacing:.1em; } .hn-steps h3 { margin:20px 0 9px; color:var(--hn-deep); font-size:20px; } .hn-steps p { margin:0; color:var(--hn-muted); font-size:14px; line-height:1.6; }
   .hn-faq { border-top:1px solid var(--hn-line); } .hn-faq details { padding:20px 0; border-bottom:1px solid var(--hn-line); } .hn-faq summary { cursor:pointer; color:var(--hn-deep); font-size:16px; font-weight:700; } .hn-faq p { max-width:750px; margin:12px 0 0; color:var(--hn-muted); line-height:1.6; }
   .hn-news-heading { display:flex; align-items:end; justify-content:space-between; gap:24px; max-width:none; } .hn-news-heading>div { max-width:700px; } .hn-news-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; } .hn-news-card { overflow:hidden; background:#fff; border:1px solid var(--hn-line); border-radius:14px; box-shadow:0 8px 22px rgba(11,127,66,.06); } .hn-news-card__image { display:grid; height:170px; place-items:center; overflow:hidden; color:#7b5a00; background:linear-gradient(135deg,#e7f4e9,#fdf1ce); text-align:center; text-decoration:none; } .hn-news-card__image img { width:100%; height:100%; object-fit:cover; transition:transform .2s ease; } .hn-news-card:hover .hn-news-card__image img { transform:scale(1.04); } .hn-news-card__image span { padding:18px; font-size:12px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; } .hn-news-card__body { display:flex; min-height:224px; flex-direction:column; padding:18px; } .hn-news-card__body>p { display:flex; justify-content:space-between; gap:8px; margin:0 0 9px; color:var(--hn-muted); font-size:11px; font-weight:700; } .hn-news-card__body>p span { color:var(--hn-green); } .hn-news-card h3 { margin:0 0 9px; font-size:17px; line-height:1.3; } .hn-news-card h3 a { color:var(--hn-deep); text-decoration:none; } .hn-news-card__body>div { display:-webkit-box; overflow:hidden; margin:0 0 14px; color:var(--hn-muted); font-size:13px; line-height:1.55; -webkit-box-orient:vertical; -webkit-line-clamp:2; } .hn-news-card__link { margin-top:auto; color:var(--hn-green); font-size:13px; font-weight:800; text-decoration:none; }
   .hn-final { padding:68px 0; color:#fff; background:var(--hn-deep); } .hn-final__content { display:flex; align-items:center; justify-content:space-between; gap:28px; } .hn-final h2 { margin-bottom:10px; color:#fff; } .hn-final p { margin:0; color:rgba(255,255,255,.75); } .hn-final__content>div:last-child { display:flex; align-items:center; gap:18px; } .hn-final .hn-contact { color:#fff; font-weight:700; } .hn-footer { padding:24px 0; color:#6c7f74; background:#fff; font-size:13px; } .hn-footer .hn-shell { display:flex; justify-content:space-between; gap:16px; }
   @media (max-width:900px) { .hn-nav { display:none; } .hn-menu-button { display:block; } .hn-booking__fields { grid-template-columns:1fr 1fr; } .hn-booking__fields .hn-button { grid-column:span 2; } .hn-route-card,.hn-pickup { grid-template-columns:1fr; } .hn-route-card>img { min-height:280px; } .hn-pickup { gap:32px; } .hn-pickup__visual { min-height:280px; } .hn-steps { grid-template-columns:1fr; } .hn-policy__content { grid-template-columns:1fr; } .hn-news-grid { grid-template-columns:repeat(2,1fr); } }
   @media (max-width:620px) { .hn-shell { width:min(100% - 28px, 1160px); } .hn-nav-wrap { min-height:62px; } .hn-actions .hn-button { display:none; } .hn-brand span { display:none; } .hn-hero { min-height:640px; } .hn-hero__overlay { background:rgba(4,35,22,.72); } .hn-hero__content { padding:66px 0 32px; } h1 { font-size:38px; } .hn-booking fieldset { padding:15px; } .hn-booking__fields { grid-template-columns:1fr; } .hn-booking__fields .hn-button { grid-column:auto; } .hn-trust { gap:12px; font-size:12px; } .hn-section { padding:68px 0; } .hn-route-card__content { padding:25px; } .hn-route-card dl { grid-template-columns:1fr; gap:14px; } .hn-schedule__head { display:none; } .hn-schedule__row { grid-template-columns:1fr 1fr; padding:17px; } .hn-schedule__row a { grid-column:span 2; } .hn-news-heading { align-items:flex-start; flex-direction:column; } .hn-news-grid { grid-template-columns:1fr; } .hn-news-card__image { height:200px; } .hn-footer .hn-shell,.hn-final__content,.hn-final__content>div:last-child { align-items:flex-start; flex-direction:column; } }
   .hn-live-proof{display:inline-flex;align-items:center;gap:8px;max-width:none!important;margin:0 0 14px!important;padding:7px 10px;color:#d8f4df!important;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:999px;font-size:10px!important;font-weight:800;letter-spacing:.08em;line-height:1!important}.hn-live-proof i{width:7px;height:7px;background:#fbb116;border-radius:50%;box-shadow:0 0 0 4px rgba(251,177,22,.18)}.hn-fleet{padding-bottom:72px;background:#fff}.hn-fleet__heading{display:flex;align-items:end;justify-content:space-between;gap:30px;max-width:none}.hn-fleet__heading>div{max-width:620px}.hn-fleet__heading>p{max-width:360px;margin:0 0 4px}.hn-fleet__grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.hn-fleet-card{position:relative;min-height:385px;overflow:hidden;background:#062d1c;border-radius:16px;isolation:isolate}.hn-fleet-card:after{position:absolute;inset:0;z-index:-1;background:linear-gradient(180deg,rgba(6,45,28,.06),rgba(6,45,28,.93));content:''}.hn-fleet-card img{position:absolute;inset:0;z-index:-2;width:100%;height:100%;object-fit:cover;transition:transform .3s ease}.hn-fleet-card:hover img{transform:scale(1.04)}.hn-fleet-card>div{position:absolute;right:0;bottom:0;left:0;padding:25px;color:#fff}.hn-fleet-card p{margin:0 0 8px;color:#fbb116;font-size:12px;font-weight:800;letter-spacing:.08em}.hn-fleet-card h3{max-width:250px;margin:0 0 12px;font-size:21px;line-height:1.2}.hn-fleet-card span{display:block;color:#d4f4e2;font-size:13px;font-weight:700}.hn-fleet-card a{display:inline-flex;gap:8px;margin-top:20px;color:#fff;font-size:13px;font-weight:800;text-decoration:none}.hn-fleet-card a b{color:#fbb116;font-size:16px}.hn-proof{background:#062d1c}.hn-proof__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:0}.hn-proof article{display:flex;gap:16px;padding:28px 26px;border-right:1px solid rgba(212,244,226,.16)}.hn-proof article:first-child{padding-left:0}.hn-proof article:last-child{padding-right:0;border-right:0}.hn-proof article>span{color:#fbb116;font-size:12px;font-weight:900;letter-spacing:.1em}.hn-proof h3{margin:0 0 6px;color:#fff;font-size:15px}.hn-proof p{margin:0;color:#b9d9c2;font-size:13px;line-height:1.55}.hn-review{display:grid;grid-template-columns:1.1fr .9fr;gap:80px;align-items:center;padding:96px 0}.hn-review__quote{position:relative;padding:38px;background:#f8fdf9;border:1px solid #d9e5dc;border-radius:16px}.hn-review__quote>span{position:absolute;top:-26px;left:27px;color:#fbb116;font:900 78px/1 Georgia,serif}.hn-review blockquote{max-width:600px;margin:0;color:#173d2b;font-size:22px;font-weight:700;letter-spacing:-.025em;line-height:1.45}.hn-review footer{display:grid;gap:3px;margin-top:24px;color:#062d1c;font-size:13px}.hn-review footer small{color:#62766c;font-size:12px}.hn-review__aside>p:not(.hn-eyebrow){max-width:420px;color:#62766c;line-height:1.65}.hn-support-float{position:fixed;right:20px;bottom:20px;z-index:30;display:inline-flex;align-items:center;gap:9px;min-height:48px;padding:10px 15px;color:#fff;background:#0b7f42;border:1px solid rgba(255,255,255,.22);border-radius:999px;box-shadow:0 10px 26px rgba(6,45,28,.24);font-size:12px;font-weight:800;text-decoration:none;transition:transform .18s ease,background .18s ease}.hn-support-float:hover{background:#096b39;transform:translateY(-2px)}.hn-support-float svg{width:18px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}@media(max-width:900px){.hn-fleet__grid{grid-template-columns:repeat(2,1fr)}.hn-proof__grid{grid-template-columns:1fr}.hn-proof article,.hn-proof article:first-child,.hn-proof article:last-child{padding:22px 0;border-right:0;border-bottom:1px solid rgba(212,244,226,.16)}.hn-proof article:last-child{border-bottom:0}.hn-review{gap:36px;grid-template-columns:1fr}}@media(max-width:620px){.hn-fleet__heading{align-items:start;flex-direction:column}.hn-fleet__grid{grid-template-columns:1fr}.hn-fleet-card{min-height:310px}.hn-review{padding:68px 0}.hn-review__quote{padding:30px 22px}.hn-review blockquote{font-size:19px}.hn-support-float{right:14px;bottom:14px;padding:11px}.hn-support-float span{display:none}}
   .hn-boarding{background:#f5f9f5}.hn-boarding__grid{display:grid;grid-template-columns:.88fr 1.12fr;gap:72px;align-items:start}.hn-boarding__intro>p:not(.hn-eyebrow){max-width:520px;color:#62766c;font-size:16px;line-height:1.65}.hn-boarding__steps{display:grid;gap:0;padding:0;margin:0;list-style:none;border-top:1px solid #d9e5dc}.hn-boarding__steps li{display:grid;grid-template-columns:62px 1fr;gap:16px;padding:22px 0;border-bottom:1px solid #d9e5dc}.hn-boarding__steps li>span{display:grid;width:38px;height:38px;place-items:center;color:#7b5a00;background:#fef3d7;border-radius:50%;font-size:11px;font-weight:900;letter-spacing:.08em}.hn-boarding__steps h3{margin:1px 0 6px;color:#062d1c;font-size:18px}.hn-boarding__steps p{margin:0;color:#62766c;font-size:14px;line-height:1.55}.hn-boarding__note{display:flex;gap:11px;align-items:center;margin-top:28px;padding:14px;color:#365145;background:#fff;border:1px solid #d9e5dc;border-radius:10px}.hn-boarding__note>span{display:grid;width:28px;height:28px;place-items:center;color:#fff;background:#0b7f42;border-radius:50%;font-size:14px;font-weight:900}.hn-boarding__note div{display:grid;gap:3px}.hn-boarding__note strong{font-size:12px}.hn-boarding__note a{color:#0b7f42;font-size:12px;font-weight:800;text-decoration:none}.hn-boarding__note b{color:#fbb116;font-size:15px}.hn-boarding__action{margin-top:34px}.hn-boarding__action .hn-button{min-width:190px}@media(max-width:900px){.hn-boarding__grid{grid-template-columns:1fr;gap:30px}}@media(max-width:620px){.hn-boarding__steps li{grid-template-columns:47px 1fr}.hn-boarding__action{margin-top:26px}.hn-boarding__action .hn-button{width:100%}}
   @media (prefers-reduced-motion:reduce) { html { scroll-behavior:auto; } *,*::before,*::after { transition-duration:.01ms!important; animation-duration:.01ms!important; animation-iteration-count:1!important; } }
 </style>
<style>
  .hn-route-title-link { color:inherit; text-decoration:none; }
  .hn-route-title-link:hover { color:var(--hn-green); }
  .hn-route-card__image { display:block; min-height:370px; overflow:hidden; }
  .hn-route-card__image img { display:block; width:100%; height:100%; min-height:370px; object-fit:cover; transition:transform .3s ease; }
  .hn-route-card__image:hover img { transform:scale(1.03); }
  .hn-route-card__actions { display:flex; flex-wrap:wrap; align-items:center; gap:16px; }
  .hn-route-card__details { color:var(--hn-green); font-size:13px; font-weight:800; text-decoration:none; }
  .hn-route-card__details b { color:#9a7000; font-size:16px; }
  .hn-fleet-card--link { display:block; color:inherit; text-decoration:none; cursor:pointer; }
  .hn-fleet-card__cta { display:inline-flex; gap:8px; margin-top:20px; color:#fff; font-size:13px; font-weight:800; }
  .hn-fleet-card__cta b { color:#fbb116; font-size:16px; }
  .hn-direction-tabs { display:flex; flex-wrap:wrap; gap:9px; margin:-6px 0 18px; }
  .hn-direction-tabs button { min-height:42px; padding:10px 16px; color:var(--hn-muted); background:#fff; border:1px solid var(--hn-line); border-radius:999px; font:800 13px Inter,sans-serif; cursor:pointer; transition:color .18s ease, background .18s ease, border-color .18s ease; }
  .hn-direction-tabs button:hover, .hn-direction-tabs button.is-active { color:#fff; background:var(--hn-green); border-color:var(--hn-green); }
  .hn-schedule-panel[hidden] { display:none; }
  .hn-schedule__head, .hn-schedule__row { grid-template-columns:.65fr 1.2fr 1fr .9fr auto; }
  .hn-schedule__seats { color:var(--hn-green)!important; font-size:12px!important; font-weight:800!important; }
  @media (max-width:900px) { .hn-route-card__image, .hn-route-card__image img { min-height:280px; } }
  @media (max-width:620px) { .hn-route-card__image, .hn-route-card__image img { min-height:280px; } .hn-route-card__actions { align-items:stretch; flex-direction:column; gap:12px; } .hn-route-card__actions .hn-button { width:100%; } .hn-direction-tabs { overflow:auto; flex-wrap:nowrap; padding-bottom:3px; } .hn-direction-tabs button { white-space:nowrap; } .hn-schedule__head { display:none; } .hn-schedule__row { grid-template-columns:1fr 1fr; } .hn-schedule__row .hn-schedule__seats { grid-column:2; grid-row:2; } }
</style>
<style>
  body.home-new { --hn-green:#0b7f42; --hn-green-dark:#075d35; --hn-deep:#062d1c; --hn-gold:#f9df12; --hn-ink:#18332a; --hn-muted:#607269; --hn-mist:#f4f8f4; --hn-line:#d8e5dc; padding-bottom:0; color:var(--hn-ink); }
  .home-new h1,.home-new h2,.home-new h3 { font-family:'Be Vietnam Pro',Inter,sans-serif; }
  .home-new a,.home-new button,.home-new input,.home-new select { touch-action:manipulation; }
  .home-new a:focus-visible,.home-new button:focus-visible,.home-new input:focus-visible,.home-new select:focus-visible,.home-new summary:focus-visible { outline:3px solid var(--hn-gold); outline-offset:3px; }
  .hn-brand,.hn-locale a,.hn-menu-button { min-height:44px; }
  .hn-brand { min-width:44px; padding:5px 0; }
  .hn-locale a { display:grid; min-width:40px; place-items:center; padding:0 8px; }
  .hn-menu-button { width:44px; height:44px; }
  .hn-button { min-height:48px; padding:12px 20px; border-radius:10px; }
  .hn-button--outline { color:var(--hn-green); background:#fff; border:1px solid var(--hn-green); }
  .hn-button--outline:hover { color:#fff; background:var(--hn-green); }
  .hn-text-link { display:inline-flex; align-items:center; gap:8px; min-height:44px; color:var(--hn-green); font-size:13px; font-weight:800; text-decoration:none; white-space:nowrap; }
  .hn-hero { min-height:620px; }
  .hn-hero__overlay { background:linear-gradient(90deg,rgba(4,35,22,.91),rgba(4,35,22,.62) 58%,rgba(4,35,22,.28)); }
  .hn-hero__content { padding:64px 0 40px; }
  .hn-hero__copy { max-width:760px; }
  .hn-hero-route { display:inline-flex; width:max-content; align-items:center; gap:10px; margin:0 0 18px; padding:8px 13px; color:#e1f5e7; background:rgba(6,45,28,.34); border:1px solid rgba(225,245,231,.28); border-radius:999px; backdrop-filter:blur(8px); font-size:14px; letter-spacing:.065em; }
  .hn-hero-route:before { width:7px; height:7px; background:var(--hn-gold); border-radius:50%; box-shadow:0 0 0 4px rgba(251,177,22,.15); content:''; }
  .hn-hero h1.hn-hero-title { display:grid; gap:7px; max-width:800px; margin:0 0 18px; font-size:clamp(44px,4.7vw,66px); line-height:1; letter-spacing:-.045em; }
  .hn-hero-title__name { display:block; }
  .hn-hero-title__specs { display:block; color:#f9df12; font-size:.58em; line-height:1.2; letter-spacing:-.025em; }
  .hn-hero__copy>.hn-hero-tagline { display:flex; align-items:center; gap:11px; max-width:560px; margin:0; color:rgba(255,255,255,.88); font-size:16px; line-height:1.6; }
  .hn-hero-tagline:before { width:30px; height:2px; flex:none; background:var(--hn-gold); content:''; }
  body.home-new .hn-hero__copy>p.hn-official-site { display:inline-flex; align-items:center; gap:9px; margin:17px 0 0; padding:9px 13px; color:#16442e; background:#fff; border:1px solid rgba(255,255,255,.7); border-radius:10px; box-shadow:0 9px 24px rgba(0,0,0,.14); font-size:16px; font-weight:800; line-height:1.45; }
  .hn-official-site svg { width:19px; height:19px; flex:none; color:var(--hn-green); fill:#e2f4e7; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
  .hn-official-site strong { color:var(--hn-green); }
  .hn-booking { margin-top:28px; border:1px solid rgba(255,255,255,.25); border-radius:18px; }
  .hn-booking fieldset { min-width:0; padding:18px 20px 20px; }
  .hn-booking__top { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:12px; }
  .hn-booking legend { padding:0; font-family:'Be Vietnam Pro',Inter,sans-serif; font-size:16px; font-weight:800; }
  .hn-live-proof { margin:0!important; color:#326044!important; background:#eef8f0; border-color:#d4ead9; }
  .hn-live-proof i { background:var(--hn-green); box-shadow:0 0 0 4px rgba(11,127,66,.12); }
  .hn-booking__fields { display:grid; gap:12px; align-items:end; }
  @media(min-width:901px) {
    .hn-booking__fields { grid-template-columns:repeat(8,minmax(0,1fr)); }
    .hn-location-field--from { grid-column:1/4; }
    .hn-swap { grid-column:4; }
    .hn-location-field--to { grid-column:5/9; }
    .hn-depart-date-field { grid-column:1/3; }
    .hn-return-date-field { grid-column:3/5; }
    .hn-passenger-field { grid-column:5/7; }
    .hn-search-button { grid-column:7/9; }
  }
  @media(min-width:1180px) {
    .hn-booking { left:50%; width:min(1280px,calc(100vw - 48px)); max-width:none; translate:-50% 0; }
    .hn-booking__fields { grid-template-columns:minmax(180px,1.25fr) 48px minmax(180px,1.25fr) minmax(150px,.82fr) minmax(150px,.82fr) minmax(130px,.68fr) minmax(180px,.95fr); gap:12px; }
    .hn-location-field--from,.hn-swap,.hn-location-field--to,.hn-depart-date-field,.hn-return-date-field,.hn-passenger-field,.hn-search-button { grid-column:auto; grid-row:auto; }
    .hn-search-button { min-width:0; }
  }
  .hn-booking label { gap:6px; }
  .hn-booking label>span:first-child { min-height:16px; }
  .hn-booking label>span small { margin-left:4px; color:#8a9a91; font-size:9px; font-weight:600; letter-spacing:0; text-transform:none; }
  .hn-booking select,.hn-booking input:not([type=hidden]) { min-height:48px; border-radius:9px; }
  .hn-hero__copy>.hn-eyebrow { text-transform:none; }
  .hn-booking label>span:first-child { color:#405b4e; font-weight:800; }
  .hn-booking select,.hn-booking input:not([type=hidden]),.hn-passenger-stepper {
    background:#f5faf6;
    border-color:#afcbbb;
    box-shadow:inset 0 1px 0 rgba(6,45,28,.03);
  }
  .hn-booking select:focus,.hn-booking input:not([type=hidden]):focus {
    outline:3px solid rgba(11,127,66,.16);
    outline-offset:1px;
    border-color:var(--hn-green);
    background:#fff;
  }
  .hn-passenger-stepper output { background:#fff; }
  .hn-passenger-stepper button { background:#eaf5ed; }
  #hn-depart-date,#hn-return-date { width:100%; }
  .hn-swap { display:grid; width:44px; height:48px; place-items:center; padding:0; color:var(--hn-green); background:#eef8f0; border:1px solid #cfe4d5; border-radius:9px; cursor:pointer; }
  .hn-swap:hover { background:#dff2e4; }
  .hn-swap svg,.hn-search-button svg { width:19px; height:19px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
  .hn-passenger-stepper { display:grid; grid-template-columns:42px 1fr 42px; min-height:48px; overflow:hidden; border:1px solid var(--hn-line); border-radius:9px; }
  .hn-passenger-stepper button { min-width:42px; padding:0; color:var(--hn-green); background:#f1f7f2; border:0; font-size:20px; font-weight:800; cursor:pointer; }
  .hn-passenger-stepper output { display:grid; place-items:center; color:var(--hn-deep); background:#fff; font-size:14px; font-weight:800; }
  .hn-search-button { gap:8px; min-width:132px; }
  .hn-search-button[aria-busy=true] { opacity:.78; cursor:wait; }
  .hn-booking-tools { display:flex; flex-wrap:wrap; align-items:center; gap:10px 18px; margin-top:14px; padding-top:14px; border-top:1px solid #e7e0d0; }
  .hn-booking-tools__group { display:flex; align-items:center; gap:7px; }
  .hn-booking-tools__label { display:inline-flex; align-items:center; gap:6px; color:#65756c; font-size:10px; font-weight:900; letter-spacing:.04em; text-transform:uppercase; white-space:nowrap; }
  .hn-booking-tools__label svg { width:16px; height:16px; fill:none; stroke:#0b7f42; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-booking-tools__label img { width:22px; height:22px; object-fit:contain; }
  .hn-booking-tool { display:inline-flex; min-height:38px; align-items:center; justify-content:center; padding:7px 11px; color:#40564b; background:#fff; border:1px solid #d9ded8; border-radius:999px; font:800 10px Inter,sans-serif; cursor:pointer; white-space:nowrap; transition:border-color .18s ease,background-color .18s ease,color .18s ease,box-shadow .18s ease; }
  .hn-booking-tool:hover { color:#075338; background:#f0f8f2; border-color:#a9cdb5; }
  .hn-booking-tool.is-active,.hn-booking-tool[aria-pressed=true] { color:#fff; background:#075338; border-color:#075338; box-shadow:0 5px 12px rgba(7,83,56,.14); }
  .hn-booking-status { display:flex; min-height:38px; align-items:center; gap:8px; margin-left:auto; padding:7px 11px; color:#315347; background:#edf7f0; border:1px solid #cee5d5; border-radius:9px; font-size:10px; font-weight:800; }
  .hn-booking-status:before { width:8px; height:8px; background:#0b7f42; border-radius:50%; box-shadow:0 0 0 4px rgba(11,127,66,.1); content:''; }
  .hn-clear-return { min-height:38px; padding:7px 10px; color:#b32830; background:#fff5f5; border:1px solid #f0c9cc; border-radius:9px; font:800 10px Inter,sans-serif; cursor:pointer; }
  .hn-clear-return[hidden] { display:none; }
  .hn-section { padding:76px 0; }
  .hn-section-heading { margin-bottom:28px; }
  .hn-section-heading--split { display:flex; align-items:end; justify-content:space-between; gap:36px; max-width:none; }
  .hn-section-heading--split>div { max-width:720px; }
  .hn-section-heading--split>p { max-width:390px; margin:0 0 5px; color:var(--hn-muted); line-height:1.65; }
  .hn-route-summary { padding:18px 0; background:#fff; border-bottom:1px solid var(--hn-line); }
  .hn-route-summary__inner { display:grid; grid-template-columns:minmax(290px,1fr) minmax(0,2fr) auto; gap:0; align-items:center; }
  .hn-route-summary__route { display:flex; min-width:0; align-items:center; gap:16px; padding-right:24px; }
  .hn-route-summary__route>div { min-width:0; }
  .hn-route-summary__icon,.hn-route-stat__icon { display:grid; width:46px; height:46px; flex:none; place-items:center; overflow:hidden; color:#b98708; background:linear-gradient(145deg,#fff,#fff4c7); border:1px solid #ead58d; border-radius:13px; box-shadow:0 7px 16px rgba(117,83,0,.13),inset 0 1px 0 #fff; }
  .hn-route-summary__icon svg { width:40px; height:40px; }
  .hn-route-summary__icon img { width:42px; height:34px; object-fit:contain; filter:drop-shadow(0 3px 3px rgba(25,52,39,.18)); }
  .hn-route-summary .hn-eyebrow { margin-bottom:4px; }
  .hn-route-summary h2 { margin:0; font-size:clamp(18px,1.55vw,23px); white-space:nowrap; }
  .hn-route-summary dl { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); margin:0; }
  .hn-route-summary dl>div { display:flex; min-width:0; min-height:54px; align-items:center; gap:10px; padding:4px 14px; border-left:1px solid var(--hn-line); }
  .hn-route-summary dl>div>div { min-width:0; }
  .hn-route-stat__icon svg { width:25px; height:25px; }
  .hn-route-stat__icon img { width:36px; height:36px; object-fit:contain; filter:drop-shadow(0 3px 3px rgba(25,52,39,.16)); }
  .hn-route-summary svg { fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-route-summary dt { color:var(--hn-muted); font-size:11px; font-weight:700; }
  .hn-route-summary dd { margin:3px 0 0; color:var(--hn-deep); font-size:14px; font-weight:800; line-height:1.25; }
  .hn-usd-hint,.hn-trip-info .price-usd { display:block; margin-top:3px; color:#718177; font-size:10px; font-weight:700; line-height:1.2; letter-spacing:0; text-transform:none; }
  .hn-departure-card__fare .hn-usd-hint { color:#718177; font-size:10px; }
  .hn-vehicle-card footer .hn-usd-hint { color:#718177; font-size:10px; font-weight:700; text-transform:none; }
  .hn-date-badge { display:grid; gap:4px; min-width:150px; padding:12px 15px; color:var(--hn-green); background:#eaf6ed; border:1px solid #cde5d3; border-radius:11px; }
  .hn-date-badge small { color:var(--hn-muted); font-size:10px; font-weight:800; text-transform:uppercase; }
  .hn-date-badge strong { font-size:15px; }
  .hn-direction-tabs { margin:0 0 18px; }
  .hn-direction-tabs button { min-height:44px; padding:10px 17px; }
  .hn-schedule-list { display:grid; gap:10px; }
  .hn-departure-card { display:grid; grid-template-columns:90px minmax(150px,.7fr) minmax(230px,1.2fr) minmax(130px,.65fr) auto; gap:20px; align-items:center; padding:18px 20px; background:#fff; border:1px solid var(--hn-line); border-radius:13px; transition:border-color .18s ease,box-shadow .18s ease; }
  .hn-departure-card:hover { border-color:#9bc8a8; box-shadow:0 8px 24px rgba(6,45,28,.07); }
  .hn-departure-card__time { display:grid; gap:2px; }
  .hn-departure-card__time strong { color:var(--hn-deep); font-size:25px; letter-spacing:-.04em; }
  .hn-departure-card__time span,.hn-departure-card__fare span { color:var(--hn-muted); font-size:10px; font-weight:800; text-transform:uppercase; }
  .hn-departure-card__journey { display:grid; grid-template-columns:auto 1fr auto; gap:8px; align-items:center; color:var(--hn-muted); font-size:11px; font-weight:700; }
  .hn-departure-card__journey i { height:1px; background:var(--hn-line); position:relative; }
  .hn-departure-card__journey i:after { content:''; position:absolute; right:0; top:-3px; width:6px; height:6px; border-top:1px solid var(--hn-green); border-right:1px solid var(--hn-green); transform:rotate(45deg); }
  .hn-departure-card__vehicle { display:grid; gap:6px; }
  .hn-departure-card__vehicle strong { color:var(--hn-deep); font-size:14px; line-height:1.4; }
  .hn-departure-card__vehicle span { width:max-content; padding:5px 8px; color:var(--hn-green); background:#eaf6ed; border-radius:99px; font-size:10px; font-weight:800; }
  .hn-departure-card__fare { display:grid; gap:5px; }
  .hn-departure-card__fare strong { color:var(--hn-green); font-size:16px; white-space:nowrap; }
  .hn-departure-card__action { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:44px; padding:0 15px; color:#fff; background:var(--hn-green); border-radius:9px; font-size:12px; font-weight:800; text-decoration:none; white-space:nowrap; }
  .hn-departure-card__action:hover { background:var(--hn-green-dark); }
  .hn-departures__footer { display:flex; justify-content:center; margin-top:20px; }
  .hn-empty-state { display:flex; min-height:112px; align-items:center; justify-content:center; gap:13px; padding:22px; color:#52695d; background:#f7faf7; border:1px dashed #bfd2c4; border-radius:13px; }
  .hn-empty-state>span { display:grid; width:38px; height:38px; flex:none; place-items:center; color:var(--hn-green); background:#e7f3ea; border-radius:50%; }
  .hn-empty-state svg { width:19px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-empty-state p { margin:0; font-size:12px; font-weight:700; line-height:1.5; }
  .hn-fleet { position:relative; overflow:hidden; background:#f0f6f1; }
  .hn-fleet:before { position:absolute; top:-170px; right:-110px; width:440px; height:440px; border:1px solid rgba(11,127,66,.1); border-radius:50%; box-shadow:0 0 0 45px rgba(11,127,66,.025),0 0 0 90px rgba(11,127,66,.018); content:''; }
  .hn-fleet .hn-shell { position:relative; }
  .hn-vehicle-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:18px; }
  .hn-vehicle-card { display:grid; grid-template-rows:240px 1fr; overflow:hidden; color:inherit; background:#fff; border:1px solid #ccded1; border-radius:18px; box-shadow:0 14px 40px rgba(6,45,28,.08); text-decoration:none; transition:border-color .2s,box-shadow .2s,transform .2s; }
  .hn-vehicle-card:hover { border-color:#91bda0; box-shadow:0 20px 48px rgba(6,45,28,.13); transform:translateY(-3px); }
  .hn-vehicle-card__media { position:relative; min-width:0; overflow:hidden; background:var(--hn-deep); }
  .hn-vehicle-card__media:after { position:absolute; inset:0; background:linear-gradient(180deg,transparent 55%,rgba(6,45,28,.48)); content:''; }
  .hn-vehicle-card__media img { width:100%; height:100%; object-fit:cover; transition:transform .35s ease; }
  .hn-vehicle-card:hover .hn-vehicle-card__media img { transform:scale(1.025); }
  .hn-vehicle-card__media>span { position:absolute; bottom:16px; left:17px; z-index:1; display:inline-flex; align-items:center; gap:7px;padding:7px 10px;color:#fff;background:rgba(6,45,28,.78);border:1px solid rgba(255,255,255,.26);border-radius:99px;backdrop-filter:blur(8px);font-size:9px;font-weight:800;letter-spacing:.06em;text-transform:uppercase; }
  .hn-vehicle-card__media>span i { width:6px; height:6px; background:var(--hn-gold); border-radius:50%; box-shadow:0 0 0 3px rgba(251,177,22,.2); }
  .hn-vehicle-card__body { display:flex; min-width:0; flex-direction:column; padding:25px; }
  .hn-vehicle-card__route { margin:0 0 10px; color:var(--hn-green); font-size:15px; font-weight:850; letter-spacing:.035em; text-transform:uppercase; }
  .hn-vehicle-card h3 { width:fit-content; max-width:100%; margin:0; padding:10px 14px; color:var(--hn-deep); background:#fffbea; border:1px solid #e4d680; border-left:4px solid var(--hn-gold); border-radius:10px; box-shadow:0 6px 16px rgba(128,108,0,.08); font-size:clamp(20px,2.1vw,27px); line-height:1.25; letter-spacing:-.025em; }
  .hn-vehicle-card__comfort { margin:18px 0 9px; color:#4d665a; font-size:14px; font-weight:850; letter-spacing:.035em; text-transform:uppercase; }
  .hn-vehicle-card ul { display:flex; flex-wrap:wrap; gap:8px 18px; padding:0; margin:0 0 22px; list-style:none; }
  .hn-vehicle-card li { display:flex; align-items:center; gap:6px; color:#365145; font-size:11px; font-weight:700; }
  .hn-vehicle-card li span { display:grid; width:18px; height:18px; place-items:center; color:var(--hn-green); background:#e9f5ec; border-radius:50%; font-size:9px; }
  .hn-vehicle-card dl { display:grid; grid-template-columns:1fr 1fr; margin:0 0 22px; padding:15px 0; border-top:1px solid var(--hn-line); border-bottom:1px solid var(--hn-line); }
  .hn-vehicle-card dl div+div { padding-left:18px; border-left:1px solid var(--hn-line); }
  .hn-vehicle-card dt,.hn-vehicle-card footer small { color:var(--hn-muted); font-size:9px; font-weight:800; text-transform:uppercase; }
  .hn-vehicle-card dd { margin:5px 0 0; color:var(--hn-deep); font-size:15px; font-weight:800; }
  .hn-vehicle-card__note { margin:0 0 22px; padding:14px 15px; color:#365145; background:#f0f7f2; border-left:3px solid var(--hn-gold); border-radius:0 8px 8px 0; font-size:12px; font-weight:700; }
  .hn-vehicle-card footer { display:flex; align-items:end; justify-content:space-between; gap:18px; margin-top:auto; }
  .hn-vehicle-card footer>div { display:grid; gap:4px; }
  .hn-vehicle-card footer strong { color:var(--hn-green); font-size:18px; }
  .hn-vehicle-card__select { display:inline-flex; min-height:44px; align-items:center; gap:9px; padding:0 16px; color:#fff; background:var(--hn-green); border-radius:9px; font-size:11px; font-weight:800; text-decoration:none; white-space:nowrap; }
  .hn-vehicle-card footer b { color:var(--hn-gold); font-size:15px; }
  .hn-vehicle-grid--single .hn-vehicle-card { grid-template-columns:minmax(0,1.35fr) minmax(350px,.85fr); grid-template-rows:minmax(410px,auto); }
  .hn-proof { padding:34px 0; }
  .hn-proof>.hn-shell { display:grid; grid-template-columns:180px minmax(0,1fr); gap:30px; align-items:start; }
  .hn-proof>.hn-shell>.hn-eyebrow { margin:0; padding-top:25px; color:var(--hn-gold); line-height:1.5; }
  .hn-proof__body { min-width:0; }
  .hn-proof__grid article { min-height:128px; padding-top:22px; padding-bottom:22px; }
  .hn-proof__transfer { display:flex; align-items:center; gap:13px; margin:0; padding:15px 26px; color:#e5f6ea; background:rgba(255,255,255,.06); border-top:1px solid rgba(212,244,226,.16); font-size:13px; font-weight:700; line-height:1.55; }
  .hn-proof__transfer svg { width:22px; height:22px; flex:none; color:var(--hn-gold); fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-proof__transfer strong { color:#fff; }
  .hn-stops { background:linear-gradient(180deg,#fff 0,#f6faf7 100%); border-top:1px solid #e5eee7; }
  .hn-stops .hn-section-heading--split { display:block; max-width:790px; margin:0 auto 34px; text-align:center; }
  .hn-stops .hn-section-heading--split>div { max-width:none; }
  .hn-stops .hn-section-heading--split .hn-eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:15px; padding:7px 11px; background:#eaf6ed; border:1px solid #cfe6d5; border-radius:999px; letter-spacing:.1em; }
  .hn-stops .hn-section-heading--split .hn-eyebrow:before { width:7px; height:7px; background:var(--hn-gold); border-radius:50%; box-shadow:0 0 0 3px rgba(251,177,22,.14); content:''; }
  .hn-stops .hn-section-heading--split h2 { margin-bottom:13px; font-size:clamp(30px,4vw,44px); }
  .hn-stops .hn-section-heading--split>p { max-width:650px; margin:0 auto; color:var(--hn-muted); font-size:15px; line-height:1.7; }
  .hn-stops__grid { display:grid; grid-template-columns:1fr 1fr .8fr; gap:16px; }
  .hn-stop-card,.hn-stop-support { min-height:230px; padding:24px; border:1px solid var(--hn-line); border-radius:14px; box-shadow:0 12px 32px rgba(6,45,28,.055); }
  .hn-stop-card__head { display:flex; gap:13px; align-items:flex-start; }
  .hn-stop-card__head svg { width:36px; height:36px; flex:none; padding:8px; color:var(--hn-green); background:#eaf6ed; border-radius:50%; fill:none; stroke:currentColor; stroke-width:1.8; }
  .hn-stop-card__pin { width:46px; height:46px; flex:none; object-fit:contain; filter:drop-shadow(0 7px 10px rgba(6,45,28,.14)); transition:transform .24s ease; }
  .hn-stop-card__head span { color:var(--hn-green); font-size:10px; font-weight:800; text-transform:uppercase; }
  .hn-stop-card h3 { margin:4px 0 0; font-size:18px; }
  .hn-stop-card>p { min-height:42px; margin:22px 0 12px; color:var(--hn-muted); font-size:13px; line-height:1.6; }
  .hn-stop-card>a { display:inline-flex; min-height:44px; align-items:center; margin-right:16px; color:var(--hn-green); font-size:12px; font-weight:800; text-decoration:none; }
  .hn-stop-support { display:flex; flex-direction:column; color:#fff; background:var(--hn-deep); border-color:var(--hn-deep); }
  .hn-stop-support p { margin:0 0 7px; color:var(--hn-gold); font-size:11px; font-weight:800; text-transform:uppercase; }
  .hn-stop-support strong { font-size:24px; }
  .hn-stop-support span { margin:10px 0 20px; color:#c3ddca; font-size:12px; line-height:1.6; }
  .hn-stop-support__phones { display:flex; flex-wrap:wrap; gap:7px; margin:1px 0 12px; }
  .hn-stop-support__phones a { padding:7px 9px; color:#fff; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.16); border-radius:7px; font-size:11px; font-weight:800; text-decoration:none; }
  .hn-stop-support__phones a:hover { background:rgba(255,255,255,.14); border-color:rgba(255,255,255,.3); }
  .hn-stop-support .hn-button { margin-top:auto; align-self:flex-start; }
  .hn-why { position:relative; overflow:hidden; padding:58px 0; background:radial-gradient(circle at 26% 88%,rgba(251,206,71,.2),transparent 28%),radial-gradient(circle at 65% 8%,rgba(245,217,145,.24),transparent 30%),linear-gradient(115deg,#fffdf8,#fffaf0 50%,#fffdf9); }
  .hn-why:before { position:absolute; inset:0; background:linear-gradient(130deg,transparent 0 44%,rgba(247,225,160,.2) 44% 50%,transparent 50%); content:''; pointer-events:none; }
  .hn-why__inner { position:relative; display:grid; grid-template-columns:minmax(320px,34%) minmax(0,66%); gap:26px; }
  .hn-why__intro { position:relative; min-height:584px; padding-top:4px; }
  .hn-why__intro .hn-eyebrow { display:inline-flex; align-items:center; gap:10px; margin:0; padding:8px 14px; color:#173f39; background:#fff9dc; border:1px solid #ebd89a; border-radius:999px; font-size:12px; letter-spacing:.05em; }
  .hn-why__intro .hn-eyebrow:before { width:8px; height:8px; flex:none; background:#ffd31b; border-radius:50%; box-shadow:0 0 0 4px rgba(255,211,27,.18); content:''; }
  .hn-why__intro h2 { max-width:440px; margin:20px 0 13px; color:#083f3a; font-size:clamp(38px,3.3vw,50px); line-height:1.04; letter-spacing:-.045em; }
  .hn-why__intro h2 span,.hn-why__intro h2 em { display:block; }
  .hn-why__intro h2 em { color:#f3b814; font-style:normal; }
  .hn-why__lead { max-width:420px; margin:0; color:#78807e; font-size:15px; line-height:1.55; }
  .hn-why__signature { position:absolute; top:330px; left:2px; z-index:2; width:160px; color:#315d5a; font-family:"Brush Script MT","Segoe Script",cursive; font-size:27px; line-height:1.02; text-align:center; transform:rotate(-6deg); }
  .hn-why__signature:after { display:block; width:104px; height:4px; margin:8px 0 0 28px; background:#f2c418; content:''; transform:skewX(-24deg); }
  .hn-why__bus { position:absolute; right:-14px; bottom:-20px; left:-42px; height:278px; overflow:hidden; clip-path:polygon(0 16%,32% 1%,100% 12%,100% 100%,0 100%); }
  .hn-why__bus:after { position:absolute; inset:0; background:linear-gradient(to top,rgba(255,252,242,.18),transparent 30%); content:''; }
  .hn-why__bus img { width:100%; height:100%; object-fit:cover; object-position:center; }
  .hn-why__grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
  .hn-why__card { --why-accent:#d89f00; --why-soft:#fffdf3; position:relative; min-height:280px; overflow:hidden; background:#fff; border:1px solid #e9e2d5; border-radius:17px; box-shadow:0 6px 20px rgba(33,61,48,.045); isolation:isolate; transition:border-color .22s ease,box-shadow .22s ease,transform .22s ease; }
  .hn-why__card:nth-child(2) { --why-accent:#d95543; --why-soft:#fff8f5; }
  .hn-why__card:nth-child(3) { --why-accent:#098a7e; --why-soft:#f2fffc; }
  .hn-why__card:nth-child(4) { --why-accent:#2b79bd; --why-soft:#f5f9ff; }
  .hn-why__card:before { position:absolute; top:0; left:0; z-index:4; width:40%; height:4px; background:var(--why-accent); border-radius:0 0 8px; content:''; }
  .hn-why__photo { position:absolute; top:0; right:0; bottom:0; z-index:-2; width:53%; }
  .hn-why__photo img { width:100%; height:100%; object-fit:cover; }
  .hn-why__fade { position:absolute; inset:0; z-index:-1; background:linear-gradient(90deg,var(--why-soft) 0 50%,rgba(255,255,255,.78) 61%,transparent 80%); }
  .hn-why__content { display:flex; width:64%; min-height:280px; padding:20px 12px 18px 20px; flex-direction:column; }
  .hn-why__number { display:flex; align-items:center; gap:9px; margin-bottom:9px; color:var(--why-accent); font-size:19px; font-weight:900; }
  .hn-why__number:after { width:46px; height:2px; background:color-mix(in srgb,var(--why-accent) 70%,white); content:''; }
  .hn-why__icon { display:grid; width:44px; height:44px; flex:none; place-items:center; margin:0 0 11px; color:var(--why-accent); background:color-mix(in srgb,var(--why-accent) 12%,white); border-radius:11px; transition:color .22s ease,background .22s ease,transform .22s ease; }
  .hn-why__icon svg { width:22px; height:22px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-why__icon img { width:44px; height:44px; object-fit:contain; }
  .hn-why__card h3 { margin:0 0 7px; color:#083f3a; font-size:16px; line-height:1.3; letter-spacing:-.025em; }
  .hn-why__card p { margin:0; color:#5f6e6b; font-size:12px; line-height:1.55; }
  .hn-why__arrow { display:none; }
  .hn-why__badge { position:absolute; right:14px; bottom:14px; padding:6px 12px; color:#263f28; background:#f7d61d; border-radius:18px; box-shadow:0 2px 3px rgba(0,0,0,.1); font-size:12px; font-weight:900; }
  @media(max-width:1100px) {
    .hn-why { padding:50px 0; }
    .hn-why__inner { grid-template-columns:1fr; gap:26px; }
    .hn-why__intro { min-height:0; }
    .hn-why__intro h2 { max-width:820px; margin:18px 0 10px; font-size:40px; }
    .hn-why__intro h2 span,.hn-why__intro h2 em { display:inline; }
    .hn-why__intro h2 em { margin:0 .16em; }
    .hn-why__lead { max-width:720px; }
    .hn-why__signature,.hn-why__bus { display:none; }
    .hn-why__card,.hn-why__content { min-height:255px; }
  }
  .hn-faq details { padding:0; }
  .hn-faq summary { display:flex; align-items:center; justify-content:space-between; min-height:60px; padding:14px 0; list-style:none; }
  .hn-faq summary>span { display:flex; align-items:center; gap:14px; padding-right:20px; }
  .hn-faq summary b { display:grid; width:30px; height:30px; flex:none; place-items:center; color:#7b5a00; background:#fef3d7; border-radius:50%; font-size:10px; letter-spacing:.06em; }
  .hn-faq summary::-webkit-details-marker { display:none; }
  .hn-faq summary:after { content:'+'; color:var(--hn-green); font-size:22px; font-weight:400; }
  .hn-faq details[open] summary:after { content:'−'; }
  .hn-news-grid { grid-template-columns:repeat(3,1fr); }
  .hn-news-card__image { height:190px; }
  .hn-news-card__link,.hn-final .hn-contact { display:inline-flex; align-items:center; min-height:44px; }
  .hn-mobile-booking-bar { display:none; }
  @media(max-width:900px) {
    .hn-booking__fields { grid-template-columns:1fr 44px 1fr; }
    #hn-depart-date { width:100%; }
    .hn-booking__fields>label:last-of-type { grid-column:1; }
    .hn-search-button { grid-column:2/4; }
    .hn-route-summary__inner { grid-template-columns:1fr; gap:20px; }
    .hn-route-summary dl>div:first-child { border-left:0; padding-left:0; }
    .hn-route-summary .hn-text-link { width:max-content; margin-left:0; }
    .hn-departure-card { grid-template-columns:80px 1fr 1fr; }
    .hn-departure-card__journey { display:none; }
    .hn-departure-card__fare { text-align:right; }
    .hn-departure-card__action { grid-column:2/4; }
    .hn-fleet__grid { grid-template-columns:repeat(2,1fr); }
    .hn-vehicle-grid--single .hn-vehicle-card { grid-template-columns:1fr 1fr; grid-template-rows:minmax(390px,auto); }
    .hn-stops__grid { grid-template-columns:1fr 1fr; }
    .hn-stop-support { grid-column:1/-1; min-height:auto; }
    .hn-why__inner { grid-template-columns:1fr; }
    .hn-proof>.hn-shell { grid-template-columns:1fr; gap:6px; }
    .hn-proof>.hn-shell>.hn-eyebrow { padding-top:0; }
  }
  @media(max-width:620px) {
    body.home-new { padding-bottom:72px; }
    .hn-header { position:sticky; }
    .hn-actions .hn-button { display:none; }
    .hn-hero { min-height:auto; }
    .hn-hero__content { width:calc(100% - 28px); max-width:calc(100% - 28px); min-width:0; padding:46px 0 28px; }
    .hn-hero-route { margin-bottom:15px; padding:7px 11px; font-size:12px; }
    .hn-hero h1.hn-hero-title { gap:6px; margin-bottom:15px; font-size:36px; line-height:1.02; }
    .hn-hero-title__specs { font-size:24px; line-height:1.22; }
    .hn-hero__copy>.hn-hero-tagline { gap:9px; font-size:14px; }
    .hn-hero-tagline:before { width:22px; }
    body.home-new .hn-hero__copy>p.hn-official-site { width:100%; justify-content:center; margin-top:15px; padding:10px 12px; font-size:15px; text-align:center; }
    .hn-booking { margin-top:23px; }
    .hn-booking fieldset { padding:15px; }
    .hn-booking__top { align-items:flex-start; flex-direction:column; gap:8px; }
    .hn-live-proof { order:-1; }
    .hn-booking__fields { grid-template-columns:1fr; gap:10px; }
    .hn-swap { justify-self:center; height:44px; transform:rotate(90deg); }
    .hn-depart-date-field,.hn-return-date-field,.hn-booking__fields>label:last-of-type { grid-column:auto; }
    .hn-booking__fields>label:nth-of-type(n+3),.hn-search-button { grid-column:auto; grid-row:auto; }
    .hn-search-button { width:100%; min-height:52px; }
    .hn-booking-tools { min-width:0; align-items:stretch; flex-direction:column; gap:10px; }
    .hn-booking-tools__group { width:100%; min-width:0; max-width:100%; overflow-x:auto; padding-bottom:2px; scrollbar-width:none; }
    .hn-booking-tools__group::-webkit-scrollbar { display:none; }
    .hn-booking-tool { flex:0 0 auto; min-height:44px; }
    .hn-booking-status { width:100%; min-height:44px; margin-left:0; }
    .hn-clear-return { min-height:44px; }
    .hn-trust { gap:9px 14px; font-size:11px; }
    .hn-section { padding:54px 0; }
    .hn-section-heading--split { align-items:flex-start; flex-direction:column; gap:12px; }
    .hn-route-summary { padding:26px 0; }
    .hn-route-summary dl { grid-template-columns:1fr; }
    .hn-route-summary h2 { white-space:normal; }
    .hn-route-summary dl>div { padding:10px 0; border-top:1px solid var(--hn-line); border-left:0; }
    .hn-route-summary dl>div:first-child { border-top:0; }
    .hn-route-summary dl>div:last-child { grid-column:auto; padding-top:10px; }
    .hn-date-badge { min-width:0; }
    .hn-direction-tabs { overflow:auto; flex-wrap:nowrap; width:calc(100vw - 28px); padding-bottom:3px; }
    .hn-direction-tabs button { min-height:44px; white-space:nowrap; }
    .hn-departure-card { grid-template-columns:74px 1fr; gap:12px; padding:15px; }
    .hn-departure-card__time { grid-row:1/3; align-self:start; }
    .hn-departure-card__vehicle { grid-column:2; }
    .hn-departure-card__fare { grid-column:2; text-align:left; }
    .hn-departure-card__action { grid-column:1/-1; min-height:48px; }
    .hn-fleet__grid { grid-template-columns:1fr; }
    .hn-fleet-card { min-height:340px; }
    .hn-vehicle-grid,.hn-vehicle-grid--single .hn-vehicle-card { grid-template-columns:1fr; }
    .hn-vehicle-grid--single .hn-vehicle-card { grid-template-rows:240px auto; }
    .hn-vehicle-card__body { padding:21px; }
    .hn-vehicle-card footer { align-items:stretch; flex-direction:column; }
    .hn-vehicle-card__select { justify-content:center; }
    .hn-proof { padding:26px 0; }
    .hn-proof__grid article { min-height:0; }
    .hn-proof__transfer { align-items:flex-start; padding:16px 0 0; background:transparent; }
    .hn-stops__grid { grid-template-columns:1fr; }
    .hn-stop-card,.hn-stop-support { min-height:auto; padding:21px; }
    .hn-stop-support { grid-column:auto; }
    .hn-why { padding:42px 0; }
    .hn-why__inner { gap:22px; }
    .hn-why__intro .hn-eyebrow { padding:7px 11px; font-size:10px; }
    .hn-why__intro h2 { margin:15px 0 10px; font-size:32px; line-height:1.08; }
    .hn-why__lead { font-size:14px; }
    .hn-why__grid { grid-template-columns:1fr; }
    .hn-why__card,.hn-why__content { min-height:238px; }
    .hn-why__content { width:67%; padding:17px 11px 16px 17px; }
    .hn-why__number { margin-bottom:7px; font-size:17px; }
    .hn-why__icon { width:40px; height:40px; margin-bottom:9px; }
    .hn-why__card h3 { font-size:15px; }
    .hn-why__card p { font-size:11px; }
    .hn-news-grid { grid-template-columns:1fr; }
    .hn-final { padding:50px 0; }
    .hn-support-float { display:none; }
    .hn-mobile-booking-bar { position:fixed; right:0; bottom:0; left:0; z-index:40; display:grid; grid-template-columns:1.2fr .8fr; gap:8px; padding:9px 12px max(9px,env(safe-area-inset-bottom)); background:rgba(255,255,255,.97); border-top:1px solid var(--hn-line); box-shadow:0 -8px 24px rgba(6,45,28,.11); backdrop-filter:blur(12px); }
    .hn-mobile-booking-bar a { display:flex; align-items:center; justify-content:center; gap:7px; min-height:48px; color:#fff; background:var(--hn-green); border-radius:9px; font-size:13px; font-weight:800; text-decoration:none; }
    .hn-mobile-booking-bar a:last-child { color:var(--hn-deep); background:#f5f8f5; border:1px solid var(--hn-line); }
    .hn-mobile-booking-bar svg { width:17px; fill:none; stroke:currentColor; stroke-width:1.8; }
  }
</style>
<style>
  .hn-vehicle-card ul {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:8px;
    padding:12px;
    margin:0 0 22px;
    list-style:none;
    background:#f1f8f3;
    border:1px solid #d1e5d6;
    border-radius:13px;
  }
  .hn-amenity-tabs { display:flex; gap:7px; overflow-x:auto; margin:0 0 9px; padding:1px 1px 5px; scrollbar-width:none; }
  .hn-amenity-tabs::-webkit-scrollbar { display:none; }
  .hn-amenity-tabs button { flex:0 0 auto; min-height:36px; padding:7px 11px; color:#526c5d; background:#fff; border:1px solid #cfe0d4; border-radius:999px; font:800 10px Inter,sans-serif; white-space:nowrap; cursor:pointer; }
  .hn-amenity-tabs button.is-active { color:#fff; background:var(--hn-green); border-color:var(--hn-green); box-shadow:0 5px 12px rgba(11,127,66,.18); }
  .hn-vehicle-card li[hidden] { display:none; }
  .hn-vehicle-card li {
    display:flex;
    min-width:0;
    align-items:center;
    gap:8px;
    padding:9px;
    color:#294c3b;
    background:#fff;
    border:1px solid #dbeadf;
    border-radius:10px;
    font-size:11px;
    font-weight:800;
    line-height:1.25;
  }
  .hn-vehicle-card li .hn-amenity-icon {
    display:grid;
    width:30px;
    height:30px;
    flex:none;
    place-items:center;
    color:#fff;
    background:linear-gradient(145deg,#0b8b49,#075d35);
    border-radius:9px;
    box-shadow:0 5px 12px rgba(11,127,66,.2);
    animation:hn-amenity-float 2.8s ease-in-out infinite;
  }
  .hn-amenity-icon svg { width:17px; height:17px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-amenity-icon b { font-size:8px; letter-spacing:-.03em; }
  .hn-vehicle-card li:nth-child(2n) .hn-amenity-icon { animation-delay:-1.4s; }
  .hn-vehicle-card li:nth-child(3n) .hn-amenity-icon { color:#5a3e00; background:linear-gradient(145deg,#ffd95d,#fbb116); }
  @keyframes hn-amenity-float { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-2px); } }
  @media(max-width:620px) {
    .hn-amenity-tabs { width:100%; }
    .hn-vehicle-card ul { grid-template-columns:repeat(2,minmax(0,1fr)); padding:10px; }
    .hn-vehicle-card li:last-child:nth-child(odd) { grid-column:1/-1; }
  }
  @media(prefers-reduced-motion:reduce) {
    .hn-amenity-icon { animation:none!important; }
  }
</style>
<style>
  .hn-trip-info { min-width:0; margin:8px 0 20px; overflow:hidden; border:1px solid #d4e3d8; border-radius:13px; background:#fbfdfb; }
  .hn-trip-info .trip-tabs { display:grid; grid-template-columns:repeat(7,minmax(0,1fr)); gap:3px; padding:6px; background:#edf5ef; }
  .hn-trip-info .trip-tabs button { position:relative; min-width:0; min-height:42px; padding:7px 5px; color:#607269; background:transparent; border:0; border-radius:8px; font:800 11px/1.2 Inter,sans-serif; white-space:normal; cursor:pointer; transition:color .18s ease,background .18s ease,box-shadow .18s ease; }
  .hn-trip-info .trip-tabs button:after { position:absolute; right:10px; bottom:3px; left:10px; height:2px; border-radius:2px; background:var(--hn-green); content:''; opacity:0; transform:scaleX(.4); transition:.18s ease; }
  .hn-trip-info .trip-tabs button:hover { color:var(--hn-green); background:rgba(255,255,255,.6); }
  .hn-trip-info .trip-tabs button.is-active { color:var(--hn-green); background:#fff; box-shadow:0 3px 10px rgba(6,45,28,.08); }
  .hn-trip-info .trip-tabs button.is-active:after { opacity:1; transform:scaleX(1); }
  .hn-trip-info .trip-panels { min-height:69px; padding:15px; }
  .hn-trip-info .trip-panel[hidden] { display:none; }
  .hn-trip-info .trip-empty { margin:0; color:#718177; font-size:11px; line-height:1.55; }
  .hn-trip-info .trip-loading { display:flex; align-items:center; gap:9px; margin:0; color:#597064; font-size:11px; font-weight:700; }
  .hn-trip-info .trip-loading:before { width:16px; height:16px; border:2px solid #b8d2c1; border-top-color:var(--hn-green); border-radius:50%; content:''; animation:hn-trip-spin .7s linear infinite; }
  @keyframes hn-trip-spin { to { transform:rotate(360deg); } }
  .hn-trip-info .trip-price-grid { display:grid; grid-template-columns:1fr 1fr; gap:11px; align-items:center; }
  .hn-trip-info .trip-price-grid>div { display:grid; gap:3px; }
  .hn-trip-info .trip-price-grid span { color:#718177; font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.03em; }
  .hn-trip-info .trip-price-grid del { color:#7d8d84; font-size:13px; }
  .hn-trip-info .trip-price-grid strong { color:var(--hn-green); font-size:16px; }
  .hn-trip-info .trip-price-save { grid-column:1/-1; display:flex!important; align-items:center; gap:8px; padding:8px 10px; background:#fff0f1; border:1px solid #ffc8cc; border-radius:9px; }
  .hn-trip-info .trip-price-save b { color:#f01824; font-size:16px; }
  .hn-trip-info .trip-price-save span,.hn-trip-info .trip-price-save .price-usd { color:#d80e19; text-transform:none; }
  .hn-trip-info .trip-point-columns,.hn-trip-info .trip-policy-grid { display:grid; grid-template-columns:1fr; gap:15px; }
  .hn-trip-info .trip-point-columns h4,.hn-trip-info .trip-policy-grid h4 { margin:0 0 9px; color:var(--hn-deep); font-size:12px; }
  .hn-trip-info .trip-point { display:grid; grid-template-columns:8px minmax(0,1fr); gap:8px; padding:8px 0; border-top:1px solid #e2ebe5; }
  .hn-trip-info .trip-point i { width:7px; height:7px; margin-top:4px; border:2px solid var(--hn-green); border-radius:50%; }
  .hn-trip-info .trip-point div { display:grid; gap:3px; }
  .hn-trip-info .trip-point strong { color:#294535; font-size:11px; }
  .hn-trip-info .trip-point span { color:#718177; font-size:10px; line-height:1.4; }
  .hn-trip-info .trip-point time { grid-column:2; color:var(--hn-green); font-size:10px; font-weight:800; }
  .hn-trip-info .trip-rating { display:flex; align-items:center; gap:6px; margin-bottom:10px; }
  .hn-trip-info .trip-rating>strong { color:var(--hn-deep); font-size:24px; }
  .hn-trip-info .trip-rating>span { color:#f4aa00; font-size:18px; }
  .hn-trip-info .trip-rating p { margin:0; color:#718177; font-size:10px; }
  .hn-trip-info blockquote { margin:8px 0; padding:10px 11px; border-left:3px solid #94c9a8; background:#f1f8f3; }
  .hn-trip-info blockquote p { margin:0; color:#385244; font-size:10px; line-height:1.5; }
  .hn-trip-info blockquote footer { display:block; margin:5px 0 0; color:#718177; font-size:9px; font-weight:700; }
  .hn-trip-info .trip-policy-grid article { display:flex; gap:9px; padding:10px; border:1px solid #dce8df; border-radius:9px; background:#fff; }
  .hn-trip-info .trip-policy-grid article>span { display:grid; place-items:center; flex:0 0 23px; width:23px; height:23px; color:var(--hn-green); background:#e7f5eb; border-radius:50%; font-size:9px; font-weight:900; }
  .hn-trip-info .trip-policy-grid h4 { margin-bottom:4px; }
  .hn-trip-info .trip-policy-grid p { margin:0; color:#63776b; font-size:10px; line-height:1.5; white-space:pre-line; }
  .hn-trip-info .trip-gallery { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:7px; }
  .hn-trip-info .trip-gallery a { display:block; overflow:hidden; border-radius:9px; background:#e7eee9; aspect-ratio:16/10; }
  .hn-trip-info .trip-gallery img { width:100%; height:100%; object-fit:cover; transition:transform .25s ease; }
  .hn-trip-info .trip-gallery a:hover img { transform:scale(1.04); }
  .hn-trip-info .trip-amenities { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:7px; margin:0; padding:0; background:transparent; border:0; list-style:none; }
  .hn-trip-info .trip-amenities li { display:flex; align-items:center; gap:7px; min-width:0; padding:7px; color:inherit; background:linear-gradient(145deg,#fff,#f6faf7); border:1px solid #d8e7dc; border-radius:10px; }
  .hn-trip-info .trip-amenity-icon { display:grid; place-items:center; flex:0 0 30px; width:30px; height:30px; color:var(--hn-green); background:linear-gradient(145deg,#e9f8ee,#d8efdf); border:1px solid #c5e4cf; border-radius:9px; }
  .hn-trip-info .trip-amenity-icon svg { width:16px; height:16px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-trip-info .trip-amenity-icon b { font-size:8px; }
  .hn-trip-info .trip-amenity-copy { display:grid; width:auto; height:auto; min-width:0; place-items:initial; gap:3px; color:inherit; background:transparent; border-radius:0; }
  .hn-trip-info .trip-amenities strong { overflow:hidden; color:#385244; font-size:9px; line-height:1.25; text-overflow:ellipsis; }
  .hn-trip-info .trip-amenities small { width:max-content; padding:2px 4px; color:var(--hn-green); background:#e6f5eb; border-radius:4px; font-size:7px; font-weight:900; text-transform:uppercase; }
  .hn-trip-info .trip-operator-policy>h3 { margin:0 0 13px; color:var(--hn-deep); font-size:15px; }
  .hn-trip-info .trip-operator-policy>ol { display:grid; grid-template-columns:1fr; gap:10px; margin:0; padding:0; background:transparent; border:0; list-style:none; counter-reset:policy; }
  .hn-trip-info .trip-operator-policy>ol>li { display:block; padding:11px; color:#385244; background:#fff; border:1px solid #dce8df; border-radius:9px; counter-increment:policy; }
  .hn-trip-info .trip-operator-policy h4 { margin:0 0 6px; color:var(--hn-deep); font-size:11px; line-height:1.4; }
  .hn-trip-info .trip-operator-policy h4:before { margin-right:5px; color:var(--hn-green); content:counter(policy) '.'; }
  .hn-trip-info .trip-operator-policy p { margin:5px 0 0; color:#607269; font-size:10px; line-height:1.55; }
  .hn-trip-info .trip-operator-policy ul { display:grid; grid-template-columns:1fr; gap:5px; margin:7px 0 0; padding:0 0 0 16px; background:transparent; border:0; list-style:disc; }
  .hn-trip-info .trip-operator-policy ul li { display:list-item; padding:0; color:#52695d; background:transparent; border:0; border-radius:0; font-size:10px; line-height:1.5; }
  .hn-trip-info .trip-policy-period { margin-top:9px; padding:8px; background:#f3f8f4; border-radius:7px; }
  .hn-trip-info .trip-policy-period strong { color:var(--hn-green); font-size:10px; }
  .hn-trip-info .trip-policy-note { padding:8px 9px; color:#76551a!important; background:#fff4d8; border-radius:7px; font-weight:700; }
  @media(max-width:620px) { .hn-trip-info .trip-tabs { grid-template-columns:repeat(3,minmax(0,1fr)); padding:6px; } .hn-trip-info .trip-tabs button { min-height:44px; padding:7px 4px; } .hn-trip-info .trip-tabs button:last-child:nth-child(7) { grid-column:1/-1; } .hn-trip-info .trip-panels { padding:13px 11px; } }
</style>
<style>
  .hn-nav a,.hn-text-link span,.hn-departure-card__action span,.hn-vehicle-card__select b,.hn-news-card__link { transition:color .2s ease,transform .2s ease; }
  .hn-route-summary dl>div,.hn-stop-card,.hn-stop-support,.hn-proof__grid article,.hn-faq details,.hn-news-card { transition:transform .24s ease,border-color .24s ease,background-color .24s ease,box-shadow .24s ease; }
  .hn-stop-card__head svg { transition:color .24s ease,background-color .24s ease,transform .24s ease; }
  .hn-stop-card { position:relative; isolation:isolate; display:flex; overflow:hidden; flex-direction:column; background:linear-gradient(145deg,#fff 20%,#edf8f0 100%); }
  .hn-stop-card:nth-child(2) { background:linear-gradient(145deg,#fff 20%,#fff8e6 100%); }
  .hn-stop-card:nth-child(3) { background:linear-gradient(145deg,#fff 20%,#edf4fa 100%); }
  .hn-stop-card:before { position:absolute; top:0; right:0; left:0; height:5px; background:linear-gradient(90deg,var(--hn-green),#55aa72); content:''; }
  .hn-stop-card:nth-child(2):before { background:linear-gradient(90deg,#d49708,var(--hn-gold)); }
  .hn-stop-card:nth-child(3):before { background:linear-gradient(90deg,#315f88,#71a6d2); }
  .hn-stop-card:after { position:absolute; right:-46px; bottom:-58px; z-index:-1; width:150px; height:150px; border:24px solid rgba(11,127,66,.055); border-radius:50%; content:''; }
  .hn-stop-card:nth-child(2):after { border-color:rgba(251,177,22,.08); }
  .hn-stop-card:nth-child(3):after { border-color:rgba(49,95,136,.07); }
  .hn-stop-card__head { position:relative; z-index:1; align-items:center; }
  .hn-stop-card__head svg { width:46px; height:46px; padding:11px; background:#fff; border:1px solid #cbe4d2; border-radius:13px; box-shadow:0 8px 20px rgba(6,45,28,.1); }
  .hn-stop-card:nth-child(2) .hn-stop-card__head svg { color:#805c00; background:#fffaf0; border-color:#f0d99d; }
  .hn-stop-card:nth-child(3) .hn-stop-card__head svg { color:#315f88; background:#f3f8fc; border-color:#c7ddec; }
  .hn-stop-card__head span { display:inline-flex; margin-bottom:5px; padding:4px 8px; background:#dff1e4; border-radius:999px; letter-spacing:.08em; }
  .hn-stop-card:nth-child(2) .hn-stop-card__head span { color:#765400; background:#fff0c9; }
  .hn-stop-card:nth-child(3) .hn-stop-card__head span { color:#315f88; background:#dfedf7; }
  .hn-stop-card h3 { margin:0; color:var(--hn-deep); font-size:20px; line-height:1.35; }
  .hn-stop-card>p { position:relative; min-height:0; margin:24px 0 18px; padding:14px 15px 14px 39px; color:#355345; background:rgba(255,255,255,.76); border:1px solid rgba(179,211,188,.75); border-radius:10px; font-weight:650; }
  .hn-stop-card>p:before { position:absolute; top:19px; left:17px; width:9px; height:9px; background:var(--hn-green); border:2px solid #fff; border-radius:50%; box-shadow:0 0 0 3px #cfe8d6; content:''; }
  .hn-stop-card:nth-child(2)>p { border-color:rgba(232,207,143,.82); }
  .hn-stop-card:nth-child(3)>p { border-color:rgba(187,211,228,.9); }
  .hn-stop-card:nth-child(2)>p:before { background:#c88c00; box-shadow:0 0 0 3px #f7e4ad; }
  .hn-stop-card:nth-child(3)>p:before { background:#447aa8; box-shadow:0 0 0 3px #d7e8f4; }
  .hn-stop-card>a { position:relative; z-index:1; width:max-content; min-height:38px; margin-right:8px; padding:0 11px; background:rgba(255,255,255,.8); border:1px solid #c7dfce; border-radius:8px; transition:color .2s ease,background-color .2s ease,border-color .2s ease,transform .2s ease; }
  .hn-stop-card>a:first-of-type { margin-top:auto; }
  .hn-stop-card:nth-child(2)>a { color:#765400; border-color:#ead394; }
  .hn-stop-card:nth-child(3)>a { color:#315f88; border-color:#bfd5e5; }
  .hn-stops__grid { grid-template-columns:repeat(3,minmax(0,1fr)); }
  .hn-stop-support { grid-column:1/-1; display:grid; grid-template-columns:minmax(190px,.65fr) minmax(260px,1fr) auto; gap:24px; align-items:center; min-height:auto; }
  .hn-stop-support>div:first-child { display:grid; gap:4px; }
  .hn-stop-support>div:nth-child(2) { display:grid; gap:4px; }
  .hn-stop-support span { margin:0; }
  .hn-stop-support .hn-button { margin-top:0; white-space:nowrap; }
  .hn-header { background:linear-gradient(100deg,rgba(255,255,255,.98),rgba(255,253,238,.98)); border-bottom:1px solid rgba(249,223,18,.55); box-shadow:0 8px 28px rgba(53,48,24,.1); }
  .hn-nav-wrap { min-height:84px; gap:24px; }
  .hn-brand { position:relative; min-width:174px; min-height:64px; padding:5px 8px 5px 0; }
  .hn-brand:before { position:absolute; inset:8px 0 8px -10px; background:radial-gradient(ellipse,rgba(249,223,18,.3),rgba(249,223,18,0) 70%); filter:blur(7px); content:''; opacity:.75; transition:opacity .25s ease,transform .25s ease; }
  .hn-brand img { position:relative; z-index:1; width:166px; height:54px; object-fit:contain; filter:drop-shadow(0 3px 7px rgba(151,130,0,.2)); transition:filter .25s ease,transform .25s ease; }
  .hn-nav { gap:5px; }
  .hn-nav a { min-height:46px; display:inline-flex; align-items:center; padding:0 13px; border-radius:9px; color:#43584e; font-size:15px; font-weight:700; transition:color .2s ease,background-color .2s ease,transform .2s ease; }
  .hn-locale { gap:3px; padding:4px; background:#fff; border-color:#dcd7c8; box-shadow:0 5px 14px rgba(54,48,29,.06); }
  .hn-locale a { min-width:40px; min-height:38px; padding:0 8px; font-size:12px; }
  .hn-locale a[aria-current="page"] { color:#17362b; background:#f9df12; box-shadow:0 4px 11px rgba(164,144,0,.16); }
  .hn-actions { gap:10px; }
  .hn-actions>.hn-button { min-height:48px; padding:0 19px; color:#17362b; background:linear-gradient(135deg,#fff36a,#f9df12); box-shadow:0 8px 21px rgba(164,144,0,.22),0 0 0 1px rgba(213,190,0,.25); }
  .hn-booking { position:relative; overflow:hidden; background:linear-gradient(145deg,rgba(255,255,255,.98),rgba(255,249,237,.98)); border:1px solid rgba(249,223,18,.58); box-shadow:0 22px 58px rgba(15,40,29,.24); transition:border-color .25s ease,box-shadow .25s ease,transform .25s ease; }
  .hn-booking:before { position:absolute; top:0; right:0; left:0; height:4px; background:linear-gradient(90deg,#0b5438 0 28%,#f9df12 28% 100%); content:''; }
  .hn-booking:focus-within { border-color:#d5be00; box-shadow:0 26px 64px rgba(15,40,29,.27),0 0 0 3px rgba(249,223,18,.13); }
  .hn-booking fieldset { position:relative; }
  .hn-booking legend { color:#073a2a; }
  .hn-booking__top { padding-bottom:12px; border-bottom:1px solid #ebe4d4; }
  .hn-booking .hn-live-proof { color:#0b5438!important; background:#e7f3eb; border-color:#bfdac8; }
  .hn-booking label>span:first-child { color:#516159; transition:color .2s ease; }
  .hn-booking label:focus-within>span:first-child { color:#0b5438; }
  .hn-booking select,.hn-booking input:not([type=hidden]),.hn-passenger-stepper { background:#fff; border-color:#d8d4c7; box-shadow:inset 0 1px 0 rgba(255,255,255,.7),0 4px 12px rgba(52,48,35,.035); transition:border-color .2s ease,box-shadow .2s ease,background-color .2s ease; }
  .hn-booking select:hover,.hn-booking input:not([type=hidden]):hover,.hn-passenger-stepper:hover { border-color:#d5b75f; }
  .hn-booking select:focus,.hn-booking input:not([type=hidden]):focus { border-color:#0b5438; box-shadow:0 0 0 3px rgba(11,84,56,.11); }
  .hn-swap { color:#0b5438; background:#fff3c7; border-color:#e4ca77; box-shadow:0 5px 13px rgba(117,83,0,.08); transition:background-color .2s ease,border-color .2s ease,box-shadow .2s ease; }
  .hn-swap svg { transition:transform .28s ease; }
  .hn-passenger-stepper button { color:#0b5438; background:#f3f6f1; transition:color .2s ease,background-color .2s ease,transform .15s ease; }
  .hn-passenger-stepper output { color:#073a2a; background:#fffdf8; }
  .hn-search-button { color:#17362b; background:linear-gradient(135deg,#fff36a,#f9df12); box-shadow:0 9px 20px rgba(164,144,0,.2); }
  .hn-search-button svg { transition:transform .22s ease; }
  .hn-route-summary { position:relative; overflow:hidden; background:linear-gradient(100deg,#fffef9,#fffdf2 70%,#fff9dc); border-block:1px solid #e9e2cf; box-shadow:0 9px 24px rgba(80,65,25,.055); }
  .hn-route-summary:before { display:none; }
  .hn-route-summary .hn-eyebrow { display:block; padding:0; color:#4d5b54; background:transparent; border-radius:0; font-size:9px; letter-spacing:.08em; }
  .hn-route-summary h2 { color:#073a2a; }
  .hn-route-summary dl>div { transition:background-color .2s ease,transform .2s ease; }
  .hn-route-summary dl>div:first-child dd { color:#9a6b00; font-size:17px; white-space:nowrap; }
  .hn-route-summary .hn-text-link { min-height:48px; margin-left:18px; padding:0 24px; color:#17362b; background:#f9df12; border-radius:8px; box-shadow:0 8px 18px rgba(164,144,0,.17); }
  .hn-departures { position:relative; overflow:hidden; background:linear-gradient(180deg,#fff9ed,#f8f6ef); border-block:1px solid #ebe2ce; }
  .hn-departures:before { position:absolute; top:-190px; right:-120px; width:390px; height:390px; border:1px solid rgba(249,223,18,.2); border-radius:50%; box-shadow:0 0 0 48px rgba(249,223,18,.04),0 0 0 96px rgba(249,223,18,.022); content:''; }
  .hn-departures>.hn-shell { position:relative; }
  .hn-departures .hn-section-heading .hn-eyebrow { display:inline-flex; align-items:center; gap:8px; padding:7px 10px; color:#755700; background:#fff3c7; border:1px solid #ebd58e; border-radius:999px; }
  .hn-departures .hn-section-heading .hn-eyebrow:before { width:7px; height:7px; background:#f9df12; border-radius:50%; box-shadow:0 0 0 3px rgba(249,223,18,.18); content:''; }
  .hn-departures .hn-section-heading h2 { color:#073a2a; }
  .hn-departures .hn-section-heading p:not(.hn-eyebrow) { color:#66736c; }
  .hn-departures .hn-date-badge { color:#073a2a; background:#fff; border-color:#e7d49b; box-shadow:0 8px 22px rgba(78,58,15,.07); }
  .hn-departures .hn-date-badge small { color:#876b24; }
  .hn-departures .hn-direction-tabs button { color:#5d6b64; background:rgba(255,255,255,.78); border-color:#ddd8c9; }
  .hn-departures .hn-direction-tabs button:hover { color:#073a2a; background:#fff3c7; border-color:#dfbd58; }
  .hn-departures .hn-direction-tabs button.is-active { color:#fff; background:#0b5438; border-color:#0b5438; box-shadow:0 8px 18px rgba(11,84,56,.16); }
  .hn-departures .hn-departure-card { background:rgba(255,255,255,.94); border-color:#e3dccb; box-shadow:0 8px 22px rgba(60,51,29,.045); }
  .hn-departures .hn-departure-card__time strong { color:#073a2a; }
  .hn-departures .hn-departure-card__time span,.hn-departures .hn-departure-card__fare span { color:#7c776a; }
  .hn-departures .hn-departure-card__journey i { background:#ded7c6; }
  .hn-departures .hn-departure-card__vehicle span { color:#0b5438; background:#e7f2eb; }
  .hn-departures .hn-departure-card__fare strong { color:#9b6b00; }
  .hn-departures .hn-departure-card__action { color:#17362b; background:#f9df12; box-shadow:0 7px 16px rgba(164,144,0,.16); }
  .hn-departures .hn-departures__footer .hn-button { color:#17362b; background:#f9df12; border-color:#d9c200; box-shadow:0 8px 20px rgba(164,144,0,.2); }
  .hn-fleet { background:radial-gradient(circle at 94% 8%,rgba(249,223,18,.16),transparent 24%),linear-gradient(180deg,#f3f7f2,#fffdf5); }
  .hn-fleet .hn-section-heading .hn-eyebrow { display:inline-flex; padding:6px 9px; color:#26362f; background:#f9df12; border:1px solid #ddc700; border-radius:999px; }
  .hn-vehicle-card { position:relative; border-color:#dcd7c8; box-shadow:0 14px 40px rgba(63,54,28,.075); }
  .hn-vehicle-card:before { position:absolute; top:0; right:22px; left:22px; z-index:3; height:4px; background:#f9df12; border-radius:0 0 5px 5px; content:''; transform:scaleX(.3); transform-origin:left; transition:transform .3s ease; }
  .hn-vehicle-card__media { background:linear-gradient(145deg,#163d2d,#071f16); }
  .hn-vehicle-card__media img { background:linear-gradient(145deg,#f0f4ef,#fff7c7); }
  .hn-vehicle-card__select { color:#17362b; background:#f9df12; box-shadow:0 8px 18px rgba(164,144,0,.16); transition:background-color .2s ease,box-shadow .2s ease,transform .2s ease; }
  .hn-stops .hn-section-heading--split .hn-eyebrow { color:#26362f; background:#f9df12; border-color:#ddc700; }
  .hn-stops .hn-section-heading--split .hn-eyebrow:before { background:#0b5438; box-shadow:0 0 0 3px rgba(11,84,56,.13); }
  .hn-proof { position:relative; overflow:hidden; padding:62px 0; background:radial-gradient(circle at 88% 0,rgba(251,177,22,.16),transparent 27%),linear-gradient(135deg,#f2ede3,#fbfaf6 58%,#f5efe3); border-block:1px solid #e5dccb; }
  .hn-proof:before { position:absolute; top:-170px; left:-120px; width:360px; height:360px; border:1px solid rgba(157,119,34,.1); border-radius:50%; box-shadow:0 0 0 48px rgba(157,119,34,.025),0 0 0 96px rgba(157,119,34,.018); content:''; }
  .hn-proof>.hn-shell { position:relative; display:block; }
  .hn-proof__body { display:grid; gap:24px; }
  .hn-proof>.hn-shell>.hn-eyebrow { display:inline-flex; align-items:center; gap:9px; margin:0 0 22px; padding:7px 11px; color:#745815; background:#fff8e5; border:1px solid #ead9a8; border-radius:999px; line-height:1; }
  .hn-proof>.hn-shell>.hn-eyebrow:before { width:7px; height:7px; background:var(--hn-gold); border-radius:50%; box-shadow:0 0 0 4px rgba(251,177,22,.14); content:''; }
  .hn-proof__grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
  .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { display:grid; grid-template-columns:48px minmax(0,1fr); gap:16px; min-height:154px; align-items:start; padding:23px; background:rgba(255,255,255,.84); border:1px solid #ddd5c7; border-radius:14px; box-shadow:0 12px 30px rgba(64,48,22,.065); backdrop-filter:blur(8px); }
  .hn-proof__grid article>span { display:grid; width:48px; height:48px; place-items:center; color:#5b4300; background:linear-gradient(145deg,#ffe591,var(--hn-gold)); border-radius:13px; box-shadow:0 9px 22px rgba(0,0,0,.18); font-size:12px; font-weight:900; letter-spacing:.08em; transition:transform .24s ease; }
  .hn-proof__grid article h3 { margin:2px 0 8px; color:#26362f; font-size:17px; line-height:1.35; }
  .hn-proof__grid article p { margin:0; color:#6b706c; font-size:12px; line-height:1.65; }
  .hn-proof__transfer { position:relative; display:flex; min-height:66px; align-items:center; gap:14px; margin:0; padding:17px 20px; color:#4e554f; background:linear-gradient(105deg,#fffdf8,#f9efd5); border:1px solid #e4cf91; border-radius:13px; box-shadow:0 12px 28px rgba(105,78,24,.09); font-size:13px; font-weight:700; line-height:1.55; }
  .hn-proof__transfer:after { position:absolute; top:-1px; right:22px; width:76px; height:3px; background:var(--hn-gold); border-radius:0 0 4px 4px; content:''; }
  .hn-proof__transfer svg { width:36px; height:36px; flex:none; padding:8px; color:#684b00; background:linear-gradient(145deg,#ffe69a,var(--hn-gold)); border-radius:10px; box-shadow:0 7px 16px rgba(166,119,0,.16); }
  .hn-proof__transfer>img { width:58px; height:48px; flex:none; object-fit:contain; filter:drop-shadow(0 7px 9px rgba(26,46,36,.13)); }
  .hn-proof__transfer strong { color:#3b463f; }
  .hn-faq summary:after { transition:color .2s ease,transform .24s ease; }
  .hn-faq details[open] summary:after { transform:rotate(180deg); }
  .hn-faq p { max-width:790px; margin:2px 0 18px 44px; padding:15px 18px; color:#596960; background:linear-gradient(105deg,#fafbf8,#fffaf0); border:1px solid #e3e4da; border-left:3px solid var(--hn-gold); border-radius:0 10px 10px 0; line-height:1.7; white-space:pre-line; }
  #help { position:relative; isolation:isolate; overflow:hidden; width:min(1160px,calc(100% - 40px)); margin:68px auto; padding:48px; background:radial-gradient(circle at 94% 8%,rgba(249,223,18,.24),transparent 25%),linear-gradient(145deg,#fffdf0,#f5f7f2); border:1px solid #e4dece; border-radius:24px; box-shadow:0 22px 55px rgba(56,48,27,.08); }
  #help:before { position:absolute; top:-135px; right:-95px; z-index:-1; width:310px; height:310px; border:1px solid rgba(11,84,56,.09); border-radius:50%; box-shadow:0 0 0 38px rgba(11,84,56,.022),0 0 0 76px rgba(11,84,56,.014); content:''; }
  #help .hn-section-heading { max-width:760px; margin-bottom:28px; }
  #help .hn-section-heading .hn-eyebrow { display:inline-flex; align-items:center; gap:8px; padding:7px 10px; color:#26362f; background:#f9df12; border:1px solid #dfc600; border-radius:999px; }
  #help .hn-section-heading .hn-eyebrow:before { width:7px; height:7px; background:#0b5438; border-radius:50%; box-shadow:0 0 0 3px rgba(11,84,56,.13); content:''; }
  #help .hn-section-heading h2 { display:inline; color:#073a2a; background:linear-gradient(transparent 73%,rgba(249,223,18,.78) 73%); }
  .hn-faq { display:grid; gap:10px; border:0; }
  .hn-faq details { --faq-accent:#c58a09; --faq-soft:#fff5d8; margin:0; padding:0 17px; background:rgba(255,255,255,.86); border:1px solid #e3ddce; border-radius:12px; box-shadow:0 6px 18px rgba(58,49,26,.035); }
  .hn-faq details:nth-child(3n+2) { --faq-accent:#b65e47; --faq-soft:#fde8e1; }
  .hn-faq details:nth-child(3n) { --faq-accent:#177660; --faq-soft:#e0f3eb; }
  .hn-faq details[open] { background:#fff; border-color:var(--faq-accent); box-shadow:0 13px 30px color-mix(in srgb,var(--faq-accent) 12%,transparent); }
  .hn-faq summary { min-height:68px; padding:13px 0; }
  .hn-faq summary b { color:var(--faq-accent); background:var(--faq-soft); border:1px solid color-mix(in srgb,var(--faq-accent) 24%,transparent); transition:color .22s ease,background-color .22s ease,transform .22s ease; }
  .hn-faq summary:after { display:grid; width:34px; height:34px; flex:none; place-items:center; color:var(--faq-accent); background:var(--faq-soft); border:1px solid color-mix(in srgb,var(--faq-accent) 22%,transparent); border-radius:50%; line-height:1; }
  .hn-faq details[open] summary b,.hn-faq details[open] summary:after { color:#fff; background:var(--faq-accent); }
  .hn-faq details p { max-width:none; margin:0 0 17px 44px; background:linear-gradient(105deg,#fcfcf9,var(--faq-soft)); border-color:color-mix(in srgb,var(--faq-accent) 20%,#e3e4da); border-left-color:var(--faq-accent); }
  .hn-faq details[open] p { animation:hn-faq-answer .24s ease both; }
  .hn-news-card__link:after { margin-left:7px; content:'→'; }
  .hn-news { position:relative; overflow:hidden; background:radial-gradient(circle at 7% 12%,rgba(249,223,18,.18),transparent 23%),linear-gradient(180deg,#fffdf4,#f3f7f2); border-top:1px solid #ebe2c8; }
  .hn-news:before { position:absolute; right:-105px; bottom:-185px; width:390px; height:390px; border:1px solid rgba(11,84,56,.08); border-radius:50%; box-shadow:0 0 0 42px rgba(11,84,56,.018),0 0 0 84px rgba(11,84,56,.012); content:''; }
  .hn-news .hn-shell { position:relative; }
  .hn-news-heading .hn-eyebrow { display:inline-flex; padding:6px 9px; color:#26362f; background:#f9df12; border:1px solid #ddc700; border-radius:999px; }
  .hn-news-heading>.hn-button { color:#17362b; background:#f9df12; box-shadow:0 8px 18px rgba(164,144,0,.15); }
  .hn-news-card { position:relative; border-color:#ded8c8; box-shadow:0 10px 28px rgba(63,54,28,.065); }
  .hn-news-card:before { position:absolute; top:0; right:17px; left:17px; z-index:2; height:4px; background:#f9df12; border-radius:0 0 5px 5px; content:''; transform:scaleX(.32); transform-origin:left; transition:transform .3s ease; }
  .hn-news-card__image { background:linear-gradient(135deg,#eef4ed,#fff5ac); }
  .hn-news-card__link { color:#6d6100; }
  .hn-final { position:relative; overflow:hidden; background:radial-gradient(circle at 88% 15%,rgba(249,223,18,.18),transparent 25%),linear-gradient(120deg,#073a2a,#062d1c); border-top:4px solid #f9df12; }
  .hn-final:before { position:absolute; right:-70px; bottom:-180px; width:320px; height:320px; border:1px solid rgba(255,255,255,.09); border-radius:50%; box-shadow:0 0 0 34px rgba(255,255,255,.018),0 0 0 68px rgba(255,255,255,.012); content:''; }
  .hn-final__content { position:relative; }
  .hn-footer { background:#fffbea; border-top:1px solid #e9dfb9; }
  .hn-motion-ready .hn-reveal { opacity:0; transform:translateY(18px); transition:opacity .55s ease var(--hn-reveal-delay,0ms),transform .55s cubic-bezier(.2,.72,.25,1) var(--hn-reveal-delay,0ms); }
  .hn-motion-ready .hn-reveal.is-visible { opacity:1; transform:none; }
  @keyframes hn-faq-answer { from { opacity:0; transform:translateY(-5px); } to { opacity:1; transform:none; } }
  @keyframes hn-hero-breathe { from { transform:scale(1.01); } to { transform:scale(1.055); } }
  @keyframes hn-status-pulse { 0%,100% { box-shadow:0 0 0 4px rgba(11,127,66,.12); } 50% { box-shadow:0 0 0 8px rgba(11,127,66,0); } }
  @media (hover:hover) and (pointer:fine) {
    .hn-nav a { position:relative; }
    .hn-nav a:after { position:absolute; right:50%; bottom:-8px; left:50%; height:2px; background:var(--hn-gold); border-radius:2px; content:''; transition:right .2s ease,left .2s ease; }
    .hn-nav a:hover:after { right:0; left:0; }
    .hn-nav a:hover { color:#073a2a; background:#fff9d8; transform:translateY(-1px); }
    .hn-brand:hover:before { opacity:1; transform:scale(1.08); }
    .hn-brand:hover img { filter:drop-shadow(0 4px 10px rgba(164,144,0,.32)); transform:translateY(-1px) scale(1.015); }
    .hn-actions>.hn-button:hover { color:#102d23; background:linear-gradient(135deg,#fff67d,#e5cd00); box-shadow:0 11px 27px rgba(164,144,0,.3),0 0 18px rgba(249,223,18,.22); }
    .hn-button:hover { box-shadow:0 9px 22px rgba(6,45,28,.16); transform:translateY(-2px); }
    .hn-button--gold:hover { box-shadow:0 9px 24px rgba(251,177,22,.24); }
    .hn-booking:hover { box-shadow:0 27px 66px rgba(15,40,29,.28); transform:translateY(-2px); }
    .hn-swap:hover { background:#ffe89b; border-color:#d5ae37; box-shadow:0 7px 17px rgba(117,83,0,.13); }
    .hn-swap:hover svg { transform:rotate(180deg); }
    .hn-passenger-stepper button:hover { color:#17362b; background:#ffe9a1; }
    .hn-passenger-stepper button:active { transform:scale(.92); }
    .hn-search-button:hover { color:#102d23; background:linear-gradient(135deg,#fff67d,#e5cd00); box-shadow:0 12px 26px rgba(164,144,0,.27); }
    .hn-search-button:hover svg { transform:scale(1.1) rotate(-6deg); }
    .hn-text-link:hover span,.hn-departure-card__action:hover span,.hn-vehicle-card__select:hover b,.hn-news-card__link:hover:after { transform:translateX(4px); }
    .hn-route-summary dl>div:hover { transform:translateY(-2px); }
    .hn-route-summary dl>div:hover { background:rgba(249,223,18,.1); }
    .hn-departure-card:hover { box-shadow:0 13px 30px rgba(6,45,28,.1); transform:translateY(-3px); }
    .hn-departure-card:hover .hn-departure-card__journey i { background:var(--hn-green); }
    .hn-departures .hn-departure-card:hover { border-color:#d9bd69; box-shadow:0 15px 34px rgba(92,69,17,.11); }
    .hn-departures .hn-departure-card:hover .hn-departure-card__journey i { background:#d5a71c; }
    .hn-departures .hn-departure-card__action:hover { color:#102d23; background:#e5cd00; box-shadow:0 9px 20px rgba(164,144,0,.22); }
    .hn-departures .hn-departures__footer .hn-button:hover { color:#102d23; background:#e5cd00; border-color:#c4af00; box-shadow:0 11px 25px rgba(164,144,0,.28); }
    .hn-vehicle-card__select:hover { background:var(--hn-green-dark); }
    .hn-vehicle-card:hover:before,.hn-news-card:hover:before { transform:scaleX(1); }
    .hn-vehicle-card__select:hover { color:#17362b; background:#e5cd00; box-shadow:0 11px 23px rgba(164,144,0,.22); transform:translateY(-2px); }
    .hn-proof__grid article:hover { background:#fff; border-color:#d8b75d; box-shadow:0 18px 38px rgba(83,62,25,.12); transform:translateY(-3px); }
    .hn-proof__grid article:hover>span { transform:rotate(-3deg) scale(1.04); }
    .hn-stop-card:hover,.hn-stop-support:hover { border-color:#9fc7aa; box-shadow:0 20px 42px rgba(6,45,28,.1); transform:translateY(-5px); }
    .hn-stop-card:hover .hn-stop-card__head svg { color:#6b4d00; background:#fff1c9; transform:translateY(-2px) rotate(-4deg); }
    .hn-stop-card:hover .hn-stop-card__pin { transform:translateY(-3px) rotate(-4deg) scale(1.06); }
    .hn-stop-card>a:hover { color:#fff; background:var(--hn-green); border-color:var(--hn-green); transform:translateX(3px); }
    .hn-stop-card:nth-child(2)>a:hover { color:#5d4300; background:var(--hn-gold); border-color:var(--hn-gold); }
    .hn-stop-card:nth-child(3)>a:hover { color:#fff; background:#315f88; border-color:#315f88; }
    .hn-why__card:hover { border-color:var(--why-accent); box-shadow:0 20px 44px color-mix(in srgb,var(--why-accent) 16%,transparent); transform:translateY(-6px); }
    .hn-why__card:hover .hn-why__icon { color:#fff; background:var(--why-accent); transform:rotate(-5deg) scale(1.08); }
    .hn-faq details:hover { background:#fff; border-color:var(--faq-accent); box-shadow:0 12px 28px color-mix(in srgb,var(--faq-accent) 11%,transparent); transform:translateY(-2px); }
    .hn-faq details:hover summary b { transform:rotate(-3deg) scale(1.05); }
    .hn-faq details:hover summary:after { color:#fff; background:var(--faq-accent); transform:scale(1.1); }
    .hn-faq details[open]:hover summary:after { transform:rotate(180deg) scale(1.12); }
    .hn-news-card:hover { border-color:#a8cbb2; box-shadow:0 18px 38px rgba(6,45,28,.11); transform:translateY(-5px); }
    .hn-news-heading>.hn-button:hover { color:#17362b; background:#e5cd00; box-shadow:0 11px 23px rgba(164,144,0,.22); }
    .hn-support-float:hover { transform:translateY(-3px) scale(1.02); }
  }
  @media (prefers-reduced-motion:no-preference) {
    .hn-hero__image { animation:hn-hero-breathe 16s ease-in-out infinite alternate; }
    .hn-live-proof i { animation:hn-status-pulse 2.4s ease-out infinite; }
  }
  @media (max-width:1080px) {
    .hn-nav { display:none; }
    .hn-menu-button { display:block; }
  }
  @media (max-width:900px) {
    .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { grid-template-columns:40px minmax(0,1fr); gap:12px; padding:19px; }
    .hn-proof__grid article>span { width:40px; height:40px; }
    .hn-stops__grid { grid-template-columns:1fr 1fr; }
    .hn-stop-card:nth-child(3) { grid-column:1/-1; }
    .hn-stop-support { grid-template-columns:1fr 1fr; }
    .hn-stop-support .hn-button { grid-column:1/-1; justify-self:start; }
  }
  @media (max-width:620px) {
    .hn-nav-wrap { min-height:72px; gap:10px; }
    .hn-brand { min-width:120px; min-height:54px; padding-right:0; }
    .hn-brand img { width:120px; height:42px; }
    .hn-locale { gap:1px; padding:3px; }
    .hn-locale a { min-width:34px; min-height:36px; padding:0 5px; font-size:11px; }
    .hn-actions { gap:6px; }
    .hn-proof { padding:48px 0; }
    .hn-proof__body { gap:20px; }
    .hn-proof__grid { grid-template-columns:1fr; }
    .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { min-height:0; }
    .hn-proof__transfer { align-items:flex-start; padding:16px; background:linear-gradient(105deg,#fffdf8,#f9efd5); }
    .hn-stops__grid { grid-template-columns:1fr; }
    .hn-stop-card:nth-child(3),.hn-stop-support { grid-column:auto; }
    .hn-stop-support { display:flex; align-items:stretch; flex-direction:column; gap:10px; }
    .hn-stop-support .hn-button { align-self:flex-start; }
    #help { width:min(100% - 28px,1160px); margin:42px auto; padding:30px 16px; border-radius:18px; }
    #help .hn-section-heading { margin-bottom:22px; }
    .hn-faq details { padding:0 13px; }
    .hn-faq summary { min-height:64px; }
    .hn-faq summary>span { gap:10px; padding-right:10px; }
    .hn-faq summary b { width:28px; height:28px; }
    .hn-faq details p { margin:0 0 14px; padding:14px 15px; }
  }
  /* Vehicle showcase follows the live trip hierarchy: vehicle, amenities, fare, timing, action. */
  .hn-fleet { isolation:isolate; padding:64px 0 70px; background:radial-gradient(circle at 18% 10%,rgba(249,223,18,.2),transparent 23%),radial-gradient(circle at 82% 16%,rgba(89,183,205,.17),transparent 25%),linear-gradient(112deg,#fff9e8 0,#f8faf3 45%,#edf7f4 72%,#fff8e7 100%); }
  .hn-fleet:before,.hn-fleet:after { position:absolute; z-index:-1; top:96px; bottom:0; width:min(31vw,470px); height:auto; border:0; border-radius:0; box-shadow:none; content:''; background-repeat:no-repeat; background-size:cover; pointer-events:none; }
  .hn-fleet:before { left:0; background-image:linear-gradient(90deg,rgba(255,249,232,.05),rgba(248,250,243,.38) 56%,#f8faf3 100%),var(--hn-fleet-left); background-position:center; clip-path:polygon(0 5%,78% 0,100% 16%,91% 100%,0 100%); opacity:.58; }
  .hn-fleet:after { right:0; background-image:linear-gradient(270deg,rgba(237,247,244,.03),rgba(237,247,244,.36) 56%,#f8faf3 100%),var(--hn-fleet-right); background-position:center; clip-path:polygon(22% 5%,100% 0,100% 100%,9% 100%,0 16%); opacity:.5; }
  .hn-fleet .hn-shell { position:relative; z-index:1; }
  .hn-fleet .hn-shell:before { position:absolute; top:118px; right:5%; left:5%; z-index:-1; height:1px; background:linear-gradient(90deg,transparent,rgba(22,111,77,.14) 20% 80%,transparent); content:''; }
  .hn-fleet .hn-section-heading { display:grid; grid-template-columns:minmax(0,1fr) auto; gap:36px; align-items:end; max-width:none; margin-bottom:26px; }
  .hn-fleet .hn-section-heading>div { max-width:720px; }
  .hn-fleet .hn-section-heading h2 { margin:10px 0 8px; font-size:clamp(34px,4vw,50px); letter-spacing:-.045em; }
  .hn-fleet .hn-section-heading>div>p:last-child { margin:0; color:var(--hn-muted); font-size:14px; line-height:1.6; }
  .hn-fleet-context { display:grid; grid-template-columns:44px minmax(190px,1fr) auto; gap:12px; align-items:center; min-width:400px; padding:12px 14px; background:rgba(255,255,255,.78); border:1px solid #dce7df; border-radius:15px; box-shadow:0 10px 28px rgba(25,66,47,.07); backdrop-filter:blur(10px); }
  .hn-fleet-context>svg { width:44px; height:44px; padding:9px; color:var(--hn-green); background:#eef7f0; border-radius:11px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-fleet-context strong,.hn-fleet-context span { display:block; }
  .hn-fleet-context strong { color:var(--hn-deep); font-size:13px; }
  .hn-fleet-context span { margin-top:4px; color:#587066; font-size:11px; }
  .hn-fleet-context a { display:inline-flex; min-height:42px; align-items:center; padding:0 16px; color:var(--hn-deep); background:#fff; border:1px solid #d7e1da; border-radius:10px; font-size:11px; font-weight:800; text-decoration:none; white-space:nowrap; }
  .hn-vehicle-grid { grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; }
  .hn-vehicle-grid--single .hn-vehicle-card,.hn-vehicle-card { display:grid; grid-template-columns:1fr; grid-template-rows:230px 1fr; overflow:hidden; border-color:#d9dfd8; border-radius:17px; box-shadow:0 16px 42px rgba(57,61,38,.09); }
  .hn-vehicle-card:before { right:auto; left:20px; width:120px; transform:none; }
  .hn-vehicle-card__media { margin:8px 8px 0; border-radius:12px; }
  .hn-vehicle-card__media:after { background:linear-gradient(180deg,rgba(5,31,21,.05) 45%,rgba(5,31,21,.46)); }
  .hn-vehicle-card__media>span { top:14px; bottom:auto; color:#17362b; background:#f9df12; border-color:#dfc700; box-shadow:0 6px 14px rgba(95,80,0,.16); }
  .hn-vehicle-card__media>span i { background:#17362b; box-shadow:none; }
  .hn-vehicle-card__image-detail { position:absolute; right:14px; bottom:14px; z-index:2; padding:8px 12px; color:#fff; background:rgba(5,31,21,.68); border:1px solid rgba(255,255,255,.55); border-radius:999px; font-size:10px; font-weight:800; }
  .hn-vehicle-card__body { padding:18px 20px 20px; }
  .hn-vehicle-card__route { width:max-content; margin:0 0 7px; padding:5px 9px; color:#243a31; background:#fff2a9; border-radius:999px; font-size:9px; letter-spacing:.05em; }
  .hn-vehicle-card h3 { width:auto; padding:0; background:transparent; border:0; border-radius:0; box-shadow:none; font-size:clamp(21px,2.1vw,28px); }
  .hn-vehicle-card__comfort { margin:6px 0 14px; color:#53675e; font-size:12px; font-weight:600; letter-spacing:0; text-transform:none; }
  .hn-vehicle-card .hn-vehicle-amenities { display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); gap:0; margin:0 0 14px; padding:10px 0; background:transparent; border:0; border-block:1px solid #e5e8e2; border-radius:0; list-style:none; }
  .hn-vehicle-amenities li { display:grid; min-width:0; gap:5px; justify-items:center; padding:3px 5px; color:#345247; border:0; border-right:1px solid #e5e8e2; border-radius:0; background:transparent; font-size:9px; line-height:1.2; text-align:center; }
  .hn-vehicle-amenities li:last-child { border-right:0; }
  .hn-vehicle-card .hn-vehicle-amenities .hn-amenity-icon { display:grid; width:28px; height:28px; place-items:center; color:var(--hn-green); background:transparent; border-radius:0; box-shadow:none; animation:none; }
  .hn-vehicle-amenities .hn-amenity-icon svg { width:20px; height:20px; }
  .hn-vehicle-card .hn-trip-info { margin:0 0 13px; border-color:#e1e5df; background:#fffdf7; }
  .hn-vehicle-card .hn-trip-info .trip-tabs { display:flex; overflow-x:auto; gap:0; padding:4px; background:#f4f5f1; scrollbar-width:none; }
  .hn-vehicle-card .hn-trip-info .trip-tabs button { flex:1 0 auto; min-height:34px; padding:6px 10px; font-size:9px; white-space:nowrap; }
  .hn-vehicle-card .hn-trip-info .trip-panels { min-height:62px; padding:12px; }
  .hn-vehicle-card .hn-trip-info .trip-price-grid { grid-template-columns:.8fr 1fr 1.2fr; }
  .hn-vehicle-card .hn-trip-info .trip-price-save { grid-column:auto; min-height:48px; }
  .hn-vehicle-card dl { grid-template-columns:repeat(3,1fr); margin:0 0 14px; padding:11px 0; }
  .hn-vehicle-card dl div { padding:0 12px; }
  .hn-vehicle-card dl div:first-child { padding-left:0; }
  .hn-vehicle-card dl div+div { padding-left:12px; }
  .hn-vehicle-card dd { font-size:14px; }
  .hn-vehicle-card footer { display:grid; grid-template-columns:1fr; gap:10px; align-items:stretch; }
  .hn-vehicle-card footer>div { display:flex; align-items:baseline; gap:8px; }
  .hn-vehicle-card footer>div small:first-child { margin-right:auto; }
  .hn-vehicle-card footer strong { font-size:20px; }
  .hn-vehicle-card footer .hn-usd-hint { margin:0; }
  .hn-vehicle-card__select { min-height:48px; justify-content:center; color:#17362b; background:#f9df12; border-radius:9px; font-size:13px; }
  @media(max-width:900px) {
    .hn-fleet:before,.hn-fleet:after { display:none; }
    .hn-fleet { background:radial-gradient(circle at 90% 7%,rgba(89,183,205,.13),transparent 24%),linear-gradient(145deg,#fff9e9,#f2f8f3 58%,#fffaf0); }
    .hn-fleet .hn-section-heading { grid-template-columns:1fr; gap:18px; }
    .hn-fleet-context { min-width:0; width:100%; }
    .hn-vehicle-grid { grid-template-columns:1fr; }
  }
  @media(max-width:620px) {
    .hn-fleet { padding:46px 0; }
    .hn-fleet .hn-section-heading h2 { font-size:32px; }
    .hn-fleet-context { grid-template-columns:38px 1fr; padding:11px; }
    .hn-fleet-context>svg { width:38px; height:38px; }
    .hn-fleet-context a { grid-column:1/-1; justify-content:center; }
    .hn-vehicle-grid--single .hn-vehicle-card,.hn-vehicle-card { grid-template-rows:205px 1fr; }
    .hn-vehicle-card__body { padding:16px; }
    .hn-vehicle-card h3 { font-size:21px; }
    .hn-vehicle-card .hn-vehicle-amenities { grid-template-columns:repeat(3,1fr); }
    .hn-vehicle-amenities li:nth-child(3) { border-right:0; }
    .hn-vehicle-amenities li:nth-child(-n+3) { border-bottom:1px solid #e5e8e2; }
    .hn-vehicle-card .hn-trip-info .trip-price-grid { grid-template-columns:1fr 1fr; }
    .hn-vehicle-card .hn-trip-info .trip-price-save { grid-column:1/-1; }
    .hn-vehicle-card dl { grid-template-columns:1fr 1fr; }
    .hn-vehicle-card dl div:nth-child(2) { padding-right:0; }
    .hn-vehicle-card dl div:nth-child(3) { grid-column:1/-1; margin-top:10px; padding:10px 0 0; border-top:1px solid var(--hn-line); border-left:0; }
  }
  /* FAQ mirrors the reference: editorial story panel beside a compact accordion. */
  #help { width:min(1280px,calc(100% - 40px)); margin:70px auto; padding:42px; background-image:linear-gradient(90deg,rgba(255,250,240,.42) 0,rgba(255,250,240,.76) 36%,rgba(246,248,241,.96) 58%,rgba(241,247,242,.98) 100%),linear-gradient(180deg,rgba(255,250,240,.94) 0,rgba(255,250,240,.3) 42%,rgba(246,248,241,.12) 100%),var(--hn-faq-bg); background-color:#f5f7ef; background-position:center; background-size:cover; border-color:#e8dfc8; border-radius:28px; box-shadow:0 24px 64px rgba(65,54,26,.1); }
  #help:before { top:-90px; right:-55px; z-index:-1; width:330px; height:190px; background:linear-gradient(145deg,rgba(249,223,18,.2),rgba(16,105,67,.12)); border:0; border-radius:0 0 0 100%; box-shadow:none; transform:rotate(8deg); }
  #help:after { position:absolute; bottom:-100px; left:-85px; z-index:-1; width:300px; height:210px; background:linear-gradient(135deg,rgba(16,105,67,.1),rgba(249,223,18,.25)); border-radius:0 100% 0 0; content:''; transform:rotate(-8deg); }
  .hn-faq-layout { display:grid; grid-template-columns:minmax(330px,.8fr) minmax(0,1.2fr); gap:34px; }
  .hn-faq-intro { display:flex; min-width:0; min-height:628px; flex-direction:column; }
  #help .hn-section-heading { max-width:510px; margin:0; }
  #help .hn-section-heading .hn-eyebrow { margin-bottom:20px; padding:9px 14px; }
  #help .hn-section-heading h2 { display:block; max-width:470px; margin:0 0 18px; background:none; font-size:clamp(42px,4.5vw,62px); line-height:1.06; letter-spacing:-.055em; }
  #help .hn-section-heading h2 span { position:relative; z-index:1; }
  #help .hn-section-heading h2 span:after { position:absolute; right:0; bottom:3px; left:0; z-index:-1; height:9px; background:#f9df12; content:''; transform:skewX(-17deg) rotate(-1deg); }
  .hn-faq-intro__text { max-width:450px; margin:0; color:#68746e; font-size:15px; line-height:1.7; }
  .hn-faq-background-signature { align-self:flex-end; margin:auto 34px 4px 0; color:#173f39; font-family:"Brush Script MT","Segoe Script",cursive; font-size:29px; line-height:1.05; text-align:center; text-shadow:0 1px 12px rgba(255,255,255,.85); transform:rotate(-5deg); }
  .hn-faq-background-signature:after { display:block; width:92px; height:4px; margin:7px auto 0; background:#f2c418; content:''; transform:skewX(-22deg); }
  .hn-faq { align-content:start; gap:11px; }
  .hn-faq details { --faq-accent:#c58a09; --faq-soft:#fff3c2; padding:0 15px; border-color:#e4dece; border-radius:15px; box-shadow:0 8px 22px rgba(58,49,26,.055); }
  .hn-faq details:nth-child(3n+2) { --faq-accent:#b95543; --faq-soft:#fde5df; }
  .hn-faq details:nth-child(3n) { --faq-accent:#07806b; --faq-soft:#ddf3eb; }
  .hn-faq summary { display:grid; grid-template-columns:50px 30px minmax(0,1fr) 36px; gap:12px; min-height:78px; align-items:center; padding:10px 0; }
  .hn-faq summary:after { grid-column:4; width:36px; height:36px; content:'+'; }
  .hn-faq details[open] summary:after { content:'−'; transform:none; }
  .hn-faq summary>.hn-faq__icon { display:grid; width:50px; height:50px; place-items:center; gap:0; padding:0; color:var(--faq-accent); background:var(--faq-soft); border:1px solid color-mix(in srgb,var(--faq-accent) 18%,transparent); border-radius:13px; box-shadow:0 6px 14px color-mix(in srgb,var(--faq-accent) 12%,transparent); }
  .hn-faq__icon svg { width:25px; height:25px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-faq__icon b { font-size:15px; letter-spacing:-.04em; }
  .hn-faq summary>b { display:block; width:auto; height:auto; color:var(--faq-accent); background:transparent; border:0; border-radius:0; font-size:12px; letter-spacing:.05em; }
  .hn-faq summary>strong { color:#173f39; font-size:15px; line-height:1.4; }
  .hn-faq details[open] summary>b { color:var(--faq-accent); background:transparent; }
  .hn-faq details p { margin:0 2px 16px 104px; padding:14px 16px; font-size:12px; line-height:1.65; }
  @media(max-width:900px) {
    #help { padding:34px; background-image:linear-gradient(120deg,rgba(255,250,240,.94),rgba(242,248,243,.96)),var(--hn-faq-bg); }
    .hn-faq-layout { grid-template-columns:1fr; }
    .hn-faq-intro { min-height:0; }
    #help .hn-section-heading { max-width:720px; }
    #help .hn-section-heading h2 { max-width:650px; }
    .hn-faq-background-signature { display:none; }
  }
  @media(max-width:620px) {
    #help { width:min(100% - 28px,1280px); margin:42px auto; padding:26px 14px 18px; border-radius:20px; }
    #help .hn-section-heading .hn-eyebrow { margin-bottom:15px; }
    #help .hn-section-heading h2 { margin-bottom:12px; font-size:36px; }
    .hn-faq-intro__text { font-size:14px; }
    .hn-faq-layout { gap:24px; }
    .hn-faq details { padding:0 11px; }
    .hn-faq summary { grid-template-columns:42px 24px minmax(0,1fr) 32px; gap:8px; min-height:72px; }
    .hn-faq__icon { width:42px; height:42px; border-radius:11px; }
    .hn-faq__icon svg { width:21px; height:21px; }
    .hn-faq summary:after { width:32px; height:32px; }
    .hn-faq summary>strong { font-size:13px; }
    .hn-faq details p { margin:0 0 13px; padding:13px 14px; }
  }
  /* Live departures use a route-led hero and information-dense trip rows. */
  .hn-departures { padding:0 0 64px; background:#f7f4ec; border-block:0; }
  .hn-departures:before { display:none; }
  .hn-departures__hero { position:relative; min-height:250px; overflow:hidden; background-image:linear-gradient(90deg,rgba(4,38,27,.9),rgba(4,38,27,.54) 55%,rgba(4,38,27,.15)),var(--hn-schedule-bg); background-position:center; background-size:cover; }
  .hn-departures__hero:after { position:absolute; inset:auto 0 0; height:5px; background:linear-gradient(90deg,var(--hn-gold),#fff36a,var(--hn-gold)); content:''; }
  .hn-departures__hero .hn-shell { display:flex; min-height:250px; align-items:center; }
  .hn-departures__hero-copy { max-width:1160px; color:#fff; }
  .hn-departures__hero .hn-eyebrow { display:inline-flex; margin-bottom:13px; padding:7px 11px; color:#24362f; background:#f9df12; border:1px solid #d8c300; border-radius:999px; }
  .hn-departures__hero h2 { margin:0 0 9px; color:#fff; font-size:clamp(38px,3.8vw,52px); line-height:1.06; letter-spacing:-.05em; }
  .hn-departures__hero h2 em { color:#f9df12; font-style:normal; }
  .hn-departures__hero-copy>p:last-child { margin:0; color:#e5eee8; font-size:15px; }
  .hn-departures__body { position:relative; margin-top:-26px; }
  .hn-departures__controls { position:relative; z-index:2; display:grid; grid-template-columns:minmax(0,1fr) auto; gap:18px; align-items:center; margin-bottom:22px; padding:18px; background:rgba(255,253,247,.96); border:1px solid #e4ddcb; border-radius:20px; box-shadow:0 16px 38px rgba(55,49,29,.1); backdrop-filter:blur(12px); }
  .hn-departures .hn-direction-tabs { display:flex; gap:9px; margin:0; }
  .hn-departures .hn-direction-tabs button { display:inline-flex; min-height:48px; align-items:center; padding:10px 18px; color:#51665b; background:#fff; border:1px solid #d9ddd5; border-radius:999px; box-shadow:0 4px 12px rgba(40,54,45,.04); }
  .hn-departures .hn-direction-tabs button.is-active { color:#fff; background:#075338; border-color:#075338; }
  .hn-schedule-context { display:flex; align-items:center; gap:9px; }
  .hn-schedule-context>span { display:flex; min-height:48px; align-items:center; gap:9px; padding:0 14px; color:#29463a; background:#fff; border:1px solid #d9ddd5; border-radius:10px; font-size:11px; font-weight:800; }
  .hn-schedule-context svg { width:18px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-schedule-context a { display:inline-flex; min-height:48px; align-items:center; padding:0 17px; color:#17362b; background:#f9df12; border-radius:10px; box-shadow:0 7px 16px rgba(164,144,0,.16); font-size:11px; font-weight:800; text-decoration:none; }
  .hn-schedule-toolbar { display:flex; align-items:center; justify-content:space-between; gap:18px; margin-bottom:16px; }
  .hn-time-filters { display:flex; gap:8px; }
  .hn-time-filters button { min-height:44px; padding:0 16px; color:#51665b; background:#fff; border:1px solid #dddcd4; border-radius:999px; font:800 11px Inter,sans-serif; cursor:pointer; }
  .hn-time-filters button.is-active { color:#fff; background:#075338; border-color:#075338; box-shadow:0 7px 16px rgba(7,83,56,.16); }
  .hn-schedule-sort { display:flex; align-items:center; gap:9px; color:#617168; font-size:11px; font-weight:700; }
  .hn-schedule-sort select { min-height:44px; padding:0 34px 0 12px; color:#29463a; background:#fff; border:1px solid #dddcd4; border-radius:9px; font:700 11px Inter,sans-serif; }
  .hn-schedule-list { gap:11px; }
  .hn-departure-card { grid-template-areas:"time journey image vehicle fare action"; grid-template-columns:90px 170px 130px minmax(190px,1fr) 150px 132px; gap:14px; min-height:118px; padding:13px 15px; border-color:#e3ded2; box-shadow:0 8px 24px rgba(57,51,31,.055); }
  .hn-departure-card__time { grid-area:time; }
  .hn-departure-card__time strong { font-size:29px; }
  .hn-departure-card__time small { margin-top:5px; color:#36584a; font-size:10px; font-weight:800; }
  .hn-departure-card__journey { display:grid; grid-area:journey; }
  .hn-departure-card__journey i:before { position:absolute; top:-3px; left:0; width:6px; height:6px; background:#075338; border-radius:50%; content:''; }
  .hn-departure-card__image { grid-area:image; width:130px; height:88px; object-fit:cover; border-radius:9px; }
  .hn-departure-card__vehicle { grid-area:vehicle; align-content:center; }
  .hn-departure-card__vehicle>div { display:flex; flex-wrap:wrap; gap:6px; }
  .hn-departure-card__vehicle span { color:#29463a; background:#e2f3e8; }
  .hn-departure-card__vehicle span+span { color:#75551d; background:#fff1bd; }
  .hn-departure-card__fare { grid-area:fare; align-content:center; padding-left:14px; border-left:1px solid #e6e2d8; }
  .hn-departure-card__fare strong { color:#075338; font-size:20px; }
  .hn-departure-card__action { grid-area:action; color:#17362b; background:#f9df12; box-shadow:0 7px 16px rgba(164,144,0,.14); }
  .hn-schedule-filter-empty { margin:14px 0 0; padding:24px; color:#617168; background:#fff; border:1px dashed #ccd7cf; border-radius:12px; text-align:center; }
  @media(max-width:1080px) {
    .hn-departure-card { grid-template-areas:"time journey fare" "image vehicle action"; grid-template-columns:100px minmax(0,1fr) 150px; }
    .hn-departure-card__image { width:100%; }
    .hn-departure-card__fare { border-left:0; }
  }
  @media(max-width:760px) {
    .hn-departures__hero,.hn-departures__hero .hn-shell { min-height:220px; }
    .hn-departures__hero h2 { font-size:36px; }
    .hn-departures__controls { grid-template-columns:1fr; padding:13px; }
    .hn-departures .hn-direction-tabs,.hn-time-filters { overflow-x:auto; flex-wrap:nowrap; width:100%; max-width:100%; padding-bottom:3px; scrollbar-width:none; }
    .hn-departures .hn-direction-tabs button,.hn-time-filters button { flex:0 0 auto; white-space:nowrap; }
    .hn-schedule-context { display:grid; grid-template-columns:1fr 1fr; }
    .hn-schedule-context a { grid-column:1/-1; justify-content:center; }
    .hn-schedule-toolbar { align-items:stretch; flex-direction:column; }
    .hn-schedule-sort { justify-content:space-between; }
    .hn-departure-card { grid-template-areas:"time fare" "journey journey" "image image" "vehicle vehicle" "action action"; grid-template-columns:1fr auto; gap:12px; padding:14px; }
    .hn-departure-card__fare { text-align:right; }
    .hn-departure-card__journey { min-height:28px; }
    .hn-departure-card__image { width:100%; height:170px; }
    .hn-departure-card__action { min-height:48px; }
  }
  /* Rich departure cards keep live schedule data scannable from image to checkout. */
  .hn-schedule-list { gap:14px; }
  .hn-departure-card { position:relative; display:grid; grid-template-areas:"media details purchase"; grid-template-columns:220px minmax(0,1fr) 196px; gap:0; min-height:198px; overflow:hidden; padding:0; background:#fff; border-color:#ded9cc; border-radius:17px; box-shadow:0 10px 28px rgba(57,51,31,.07); }
  .hn-departure-card[hidden] { display:none; }
  .hn-departure-card__media { position:relative; grid-area:media; min-height:198px; overflow:hidden; background:#dfe8e2; }
  .hn-departure-card__image { width:100%; height:100%; object-fit:cover; border-radius:0; transition:transform .35s ease; }
  .hn-departure-card__badge { position:absolute; top:12px; left:12px; display:inline-flex; min-height:30px; align-items:center; gap:6px; padding:5px 9px; color:#17362b; background:#f9df12; border:1px solid rgba(106,91,0,.18); border-radius:999px; box-shadow:0 5px 15px rgba(37,33,12,.16); font-size:10px; font-weight:900; letter-spacing:.03em; text-transform:uppercase; }
  .hn-departure-card__badge:before { width:7px; height:7px; background:#087a47; border-radius:50%; box-shadow:0 0 0 3px rgba(8,122,71,.14); content:''; }
  .hn-departure-card__badge.is-discount { color:#fff; background:#f01824; border-color:#d80e19; box-shadow:0 6px 16px rgba(240,24,36,.3); }
  .hn-departure-card__badge.is-discount:before { background:#fff; box-shadow:0 0 0 3px rgba(255,255,255,.2); }
  .hn-departure-card__availability { position:absolute; right:12px; bottom:12px; left:12px; display:flex; min-height:36px; align-items:center; justify-content:center; gap:7px; padding:7px 10px; color:#fff; background:rgba(3,48,33,.88); border:1px solid rgba(255,255,255,.18); border-radius:9px; backdrop-filter:blur(7px); font-size:11px; font-weight:800; }
  .hn-departure-card__availability svg { width:16px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-departure-card__availability img { width:22px; height:22px; object-fit:contain; }
  .hn-departure-card__details { display:grid; grid-area:details; grid-template-columns:minmax(0,1fr); align-content:center; gap:17px; min-width:0; padding:22px 25px; }
  .hn-departure-card__vehicle { display:flex; grid-area:auto; min-width:0; align-items:flex-start; justify-content:space-between; gap:16px; }
  .hn-departure-card__vehicle>div:first-child { display:block; min-width:0; }
  .hn-departure-card__vehicle strong { display:block; color:#123a2e; font-family:'Be Vietnam Pro',Inter,sans-serif; font-size:17px; line-height:1.35; }
  .hn-departure-card__vehicle small { display:block; overflow:hidden; margin-top:4px; color:#6b7a72; font-size:11px; font-weight:700; text-overflow:ellipsis; white-space:nowrap; }
  .hn-departure-card__duration { flex:0 0 auto; width:auto!important; padding:6px 9px!important; color:#4d6257!important; background:#f3f6f2!important; border:1px solid #dfe5df; border-radius:999px; font-size:10px!important; font-weight:800; white-space:nowrap; }
  .hn-departure-card__timeline { display:grid; grid-template-columns:minmax(92px,.75fr) minmax(110px,1.2fr) minmax(92px,.75fr); gap:11px; min-width:0; align-items:center; }
  .hn-departure-card__time { display:grid; grid-area:auto; gap:3px; min-width:0; }
  .hn-departure-card__time:last-child { text-align:right; }
  .hn-departure-card__time strong { color:#073a2a; font-size:27px; line-height:1; letter-spacing:-.045em; }
  .hn-departure-card__time span { color:#77827c; font-size:9px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; }
  .hn-departure-card__time small { overflow:hidden; margin:0; color:#294b3e; font-size:11px; font-weight:800; text-overflow:ellipsis; white-space:nowrap; }
  .hn-departure-card__journey { display:grid; grid-area:auto; grid-template-columns:8px 1fr 22px; gap:0; align-items:center; }
  .hn-departure-card__journey i { position:relative; height:2px; background:linear-gradient(90deg,#087a47,#d8bd17); }
  .hn-departure-card__journey i:before,.hn-departure-card__journey i:after { position:absolute; top:50%; width:8px; height:8px; background:#fff; border:2px solid #087a47; border-radius:50%; content:''; transform:translateY(-50%); }
  .hn-departure-card__journey i:before { left:-7px; }
  .hn-departure-card__journey i:after { right:-7px; border-color:#d8bd17; transform:translateY(-50%); }
  .hn-departure-card__journey svg { width:16px; margin:auto; padding:2px; color:#557067; background:#fff; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-departure-card__specs { display:flex; flex-wrap:wrap; gap:7px; margin:0; padding:0; list-style:none; }
  .hn-departure-card__specs li { display:inline-flex; min-height:29px; align-items:center; gap:6px; padding:5px 8px; color:#35564a; background:#edf6f0; border:1px solid #d7e9dc; border-radius:7px; font-size:10px; font-weight:800; }
  .hn-departure-card__specs li:nth-child(2) { color:#70571e; background:#fff7d8; border-color:#eee0a4; }
  .hn-departure-card__specs svg { width:15px; height:15px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.8; }
  .hn-departure-card__specs img { width:20px; height:20px; flex:none; object-fit:contain; }
  .hn-departure-card__purchase { display:grid; grid-area:purchase; align-content:center; gap:15px; padding:22px 18px; background:linear-gradient(160deg,#f7faf7,#fffaf0); border-left:1px solid #e6e2d8; }
  .hn-departure-card__fare { display:grid; grid-area:auto; gap:4px; padding:0; border:0; text-align:right; }
  .hn-departure-card__fare>span { color:#77827c; font-size:10px; font-weight:900; letter-spacing:.06em; text-transform:uppercase; }
  .hn-departure-card__fare strong { color:#075338; font-size:21px; line-height:1.15; white-space:nowrap; }
  .hn-departure-card__fare .hn-usd-hint { color:#718177; font-size:11px; }
  .hn-departure-card__action { grid-area:auto; min-height:48px; color:#17362b; background:#f9df12; border:1px solid #e1c900; border-radius:10px; box-shadow:0 8px 18px rgba(164,144,0,.17); }
  .hn-departure-card__secure { display:flex; align-items:center; justify-content:center; gap:5px; color:#6c776f; font-size:9px; font-weight:700; text-align:center; }
  .hn-departure-card__secure svg { width:13px; fill:none; stroke:currentColor; stroke-width:1.8; }
  @media(hover:hover) and (pointer:fine) { .hn-departure-card:hover .hn-departure-card__image { transform:scale(1.04); } }
  @media(max-width:1080px) {
    .hn-departure-card { grid-template-areas:"media details" "purchase purchase"; grid-template-columns:210px minmax(0,1fr); }
    .hn-departure-card__purchase { grid-template-columns:minmax(0,1fr) 180px; align-items:center; padding:15px 18px; border-top:1px solid #e6e2d8; border-left:0; }
    .hn-departure-card__fare { text-align:left; }
    .hn-departure-card__secure { display:none; }
  }
  @media(max-width:760px) {
    .hn-departure-card { grid-template-areas:"media" "details" "purchase"; grid-template-columns:1fr; gap:0; padding:0; }
    .hn-departure-card__media { min-height:190px; }
    .hn-departure-card__image { position:absolute; inset:0; width:100%; height:100%; }
    .hn-departure-card__details { gap:16px; padding:19px 16px; }
    .hn-departure-card__vehicle { grid-column:auto; }
    .hn-departure-card__vehicle strong { font-size:15px; }
    .hn-departure-card__duration { padding:5px 7px!important; }
    .hn-departure-card__timeline { grid-template-columns:minmax(74px,.8fr) minmax(72px,1fr) minmax(74px,.8fr); gap:8px; }
    .hn-departure-card__time { grid-row:auto; align-self:auto; }
    .hn-departure-card__time strong { font-size:24px; }
    .hn-departure-card__time small { font-size:10px; }
    .hn-departure-card__specs { display:grid; grid-template-columns:1fr 1fr; }
    .hn-departure-card__specs li:last-child { grid-column:1/-1; }
    .hn-departure-card__purchase { grid-template-columns:1fr; gap:12px; padding:17px 16px; }
    .hn-departure-card__fare { grid-template-columns:1fr auto; align-items:end; text-align:left; }
    .hn-departure-card__fare strong { grid-column:2; grid-row:1/3; align-self:center; font-size:20px; }
    .hn-departure-card__fare .hn-usd-hint { grid-column:1; }
    .hn-departure-card__action { grid-column:auto; }
    .hn-departure-card__secure { display:flex; }
  }
  /* Assurance and offices read as one compact journey-support system. */
  .hn-proof { padding:44px 0 30px; background:radial-gradient(circle at 8% 12%,rgba(249,223,18,.13),transparent 23%),linear-gradient(180deg,#fffaf0,#fffdf7); border-bottom:0; }
  .hn-proof__heading { display:flex; align-items:end; justify-content:space-between; gap:32px; margin-bottom:24px; }
  .hn-proof__heading>div { max-width:620px; }
  .hn-proof__heading .hn-eyebrow { display:inline-flex; align-items:center; gap:8px; margin:0 0 10px; padding:7px 11px; color:#745815; background:#fff8e5; border:1px solid #ead9a8; border-radius:999px; line-height:1; }
  .hn-proof__heading .hn-eyebrow:before { width:7px; height:7px; background:var(--hn-gold); border-radius:50%; box-shadow:0 0 0 4px rgba(251,177,22,.14); content:''; }
  .hn-proof__heading h2 { margin:0; font-size:clamp(32px,3.5vw,44px); }
  .hn-proof__heading>p { max-width:430px; margin:0 0 4px; color:#66736c; font-size:14px; line-height:1.65; }
  .hn-proof__body { gap:12px; }
  .hn-proof__grid { gap:12px; }
  .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { grid-template-areas:"number visual" "copy copy"; grid-template-columns:auto minmax(0,1fr); grid-template-rows:auto 1fr; gap:14px; min-height:204px; align-items:start; padding:21px 22px; background:rgba(255,255,255,.92); }
  .hn-proof__grid article:nth-child(2) { background:linear-gradient(145deg,#fff,#f4fbf6); }
  .hn-proof__grid article:nth-child(3) { background:linear-gradient(145deg,#fff,#f4f9fd); }
  .hn-proof__grid article>span { width:46px; height:46px; box-shadow:0 8px 18px rgba(166,119,0,.14); }
  .hn-proof__grid article>span { grid-area:number; }
  .hn-proof__grid article>div { grid-area:copy; padding-top:2px; }
  .hn-proof__visual { grid-area:visual; justify-self:end; display:grid; width:64px; height:64px; place-items:center; color:#8b6600; background:#fff8d4; border:1px solid #ebd681; border-radius:16px; }
  .hn-proof__visual svg { width:39px; height:39px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:1.55; }
  .hn-proof__visual img { width:66px; height:66px; object-fit:contain; filter:drop-shadow(0 7px 10px rgba(26,46,36,.12)); }
  .hn-proof__visual svg .hn-proof__tone { fill:currentColor; stroke:none; opacity:.12; }
  .hn-proof__visual svg .hn-proof__accent { fill:currentColor; stroke:none; opacity:.24; }
  .hn-proof__grid article:nth-child(2) .hn-proof__visual { color:#0b7f42; background:#eaf7ee; border-color:#bee0c8; }
  .hn-proof__grid article:nth-child(3) .hn-proof__visual { color:#315f88; background:#edf6fc; border-color:#c4dceb; }
  .hn-proof__grid article h3 { margin:0 0 8px; font-size:19px; }
  .hn-proof__grid article p { max-width:300px; font-size:13px; }
  .hn-proof__transfer { display:grid; grid-template-columns:auto minmax(0,1fr) auto; gap:14px; min-height:70px; padding:14px 18px; }
  .hn-proof__transfer>a { display:inline-flex; min-height:42px; align-items:center; padding:0 15px; color:#17362b; background:#f9df12; border-radius:9px; font-size:11px; font-weight:800; text-decoration:none; white-space:nowrap; }
  .hn-stops { padding:50px 0 72px; background:radial-gradient(circle at 94% 12%,rgba(11,127,66,.08),transparent 22%),linear-gradient(180deg,#fffdf7,#f6faf7); border-top:0; }
  .hn-stops .hn-section-heading--split { margin-bottom:28px; }
  .hn-stop-card { min-height:230px; padding:22px; }
  .hn-stop-card>*:not(.hn-stop-card__photo) { position:relative; z-index:2; width:59%; }
  .hn-stop-card__photo { position:absolute; top:0; right:0; bottom:0; z-index:0; width:48%; overflow:hidden; }
  .hn-stop-card__photo:after { position:absolute; inset:0; background:linear-gradient(90deg,#f6fcf8 0,rgba(246,252,248,.75) 18%,transparent 62%); content:''; }
  .hn-stop-card:nth-child(2) .hn-stop-card__photo:after { background:linear-gradient(90deg,#fffaf0 0,rgba(255,250,240,.76) 18%,transparent 62%); }
  .hn-stop-card:nth-child(3) .hn-stop-card__photo:after { background:linear-gradient(90deg,#f5f9fd 0,rgba(245,249,253,.76) 18%,transparent 62%); }
  .hn-stop-card__photo img { width:100%; height:100%; object-fit:cover; object-position:center; filter:saturate(.92) contrast(.96); transition:transform .35s ease; }
  .hn-stop-card:after { display:none; }
  .hn-stop-card>p { min-height:72px; margin:18px 0 14px; padding:12px 12px 12px 34px; background:rgba(255,255,255,.88); backdrop-filter:blur(5px); }
  .hn-stop-card>p:before { top:17px; left:14px; }
  .hn-stop-card>a { width:max-content; min-height:44px; }
  .hn-stop-support { min-height:118px; background:radial-gradient(circle at 67% 120%,rgba(249,223,18,.12),transparent 34%),linear-gradient(110deg,#063c2a,#032d20); border-radius:16px; }
  @media(hover:hover) and (pointer:fine) {
    .hn-stop-card:hover .hn-stop-card__photo img { transform:scale(1.045); }
    .hn-proof__transfer>a:hover { background:#e5cd00; transform:translateY(-1px); }
  }
  @media(max-width:900px) {
    .hn-proof__heading { align-items:flex-start; flex-direction:column; gap:10px; }
    .hn-proof__heading>p { max-width:620px; }
    .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { padding:18px; }
    .hn-proof__visual { width:54px; height:54px; }
    .hn-proof__visual svg { width:32px; height:32px; }
    .hn-proof__visual img { width:56px; height:56px; }
    .hn-proof__transfer { grid-template-columns:auto 1fr; }
    .hn-proof__transfer>a { grid-column:1/-1; justify-self:start; }
  }
  @media(max-width:620px) {
    .hn-proof { padding:36px 0 22px; }
    .hn-proof__heading { margin-bottom:18px; }
    .hn-proof__heading .hn-eyebrow { margin-bottom:7px; }
    .hn-proof__heading h2 { font-size:32px; }
    .hn-proof__heading>p { font-size:13px; }
    .hn-proof__grid article,.hn-proof__grid article:first-child,.hn-proof__grid article:last-child { grid-template-areas:"number visual copy"; grid-template-columns:40px 48px minmax(0,1fr); grid-template-rows:auto; gap:10px; min-height:0; padding:15px 13px; }
    .hn-proof__grid article>div { padding-top:0; }
    .hn-proof__grid article>span { width:40px; height:40px; }
    .hn-proof__visual { width:48px; height:48px; border-radius:13px; }
    .hn-proof__visual svg { width:28px; height:28px; }
    .hn-proof__visual img { width:50px; height:50px; }
    .hn-proof__grid article h3 { font-size:15px; }
    .hn-proof__grid article p { font-size:11px; }
    .hn-proof__transfer { grid-template-columns:auto minmax(0,1fr); padding:14px; }
    .hn-proof__transfer>a { width:100%; justify-content:center; }
    .hn-stops { padding:42px 0 54px; }
    .hn-stop-card>*:not(.hn-stop-card__photo) { width:auto; }
    .hn-stop-card__photo { display:none; }
    .hn-stop-card>p { min-height:0; }
  }
  /* The booking form stays intact while the hero gains a vehicle-led travel scene. */
  .hn-hero { min-height:680px; background:#073b2b; }
  .hn-hero__image { z-index:-3; object-position:center 54%; }
  .hn-hero__vehicle-scene { position:absolute; inset:0 0 auto 38%; z-index:-2; width:62%; height:calc(100% + 42px); object-fit:cover; object-position:left center; clip-path:polygon(17% 0,100% 0,100% 100%,0 100%); filter:saturate(1.06) contrast(1.02); transform:translateY(-42px); }
  .hn-hero__overlay { z-index:-1; background:linear-gradient(90deg,rgba(2,37,26,.96) 0,rgba(2,42,29,.91) 33%,rgba(2,42,29,.58) 56%,rgba(2,42,29,.12) 82%),linear-gradient(180deg,rgba(3,31,23,.08) 45%,rgba(3,32,23,.67) 100%); }
  .hn-hero:before { position:absolute; top:0; right:0; left:0; z-index:0; height:5px; background:linear-gradient(90deg,#f9df12 0 18%,rgba(249,223,18,.2) 45%,transparent 72%); content:''; pointer-events:none; }
  .hn-hero:after { position:absolute; right:-120px; bottom:-285px; z-index:0; width:510px; height:510px; border:1px solid rgba(249,223,18,.2); border-radius:50%; box-shadow:0 0 0 52px rgba(249,223,18,.035),0 0 0 104px rgba(249,223,18,.018); content:''; pointer-events:none; }
  .hn-hero__content { position:relative; z-index:1; padding:52px 0 34px; }
  .hn-hero__copy { max-width:650px; }
  .hn-hero-route { margin-bottom:16px; color:#fff9c9; background:rgba(4,45,31,.66); border-color:rgba(249,223,18,.58); box-shadow:0 10px 24px rgba(0,0,0,.12); }
  .hn-hero h1.hn-hero-title { max-width:690px; margin-bottom:15px; font-size:clamp(46px,4.45vw,64px); text-shadow:0 8px 26px rgba(0,0,0,.2); }
  .hn-hero-title__name { display:flex; align-items:baseline; flex-wrap:wrap; gap:.12em; font-family:'Cormorant Garamond',Georgia,serif; font-size:1.08em; font-weight:700; letter-spacing:-.035em; }
  .hn-hero-title__name em { display:inline-block; color:#f5d94e; font-family:Allura,'Brush Script MT',cursive; font-size:1.3em; font-weight:400; line-height:.72; letter-spacing:0; text-shadow:0 5px 20px rgba(61,45,0,.25); transform:rotate(-3deg) translateY(.04em); }
  .hn-hero-title__specs { color:#fff; font-family:'Be Vietnam Pro',Inter,sans-serif; font-size:.5em; font-weight:700; line-height:1.25; letter-spacing:-.018em; text-shadow:0 5px 20px rgba(0,0,0,.22); }
  .hn-hero__copy>.hn-hero-tagline { color:rgba(255,255,255,.9); }
  body.home-new .hn-hero__copy>p.hn-official-site { color:#fff; background:rgba(3,43,29,.52); border-color:rgba(255,255,255,.48); box-shadow:0 10px 28px rgba(0,0,0,.16); backdrop-filter:blur(10px); }
  .hn-official-site strong { color:#fff; }
  .hn-official-site svg { color:#ffe315; fill:rgba(249,223,18,.12); }
  .hn-trust { gap:10px; padding-top:17px; }
  .hn-trust li { min-height:36px; padding:0 12px; color:#f5fbf7; background:rgba(3,45,31,.5); border:1px solid rgba(255,255,255,.18); border-radius:999px; backdrop-filter:blur(8px); }
  .hn-route-summary { background:linear-gradient(100deg,#fffdf6 0,#fff 44%,#fff8d8 100%); }
  .hn-mobile-booking-bar { transition:opacity .2s ease,transform .2s ease,visibility .2s; }
  .hn-mobile-booking-bar.is-form-visible { visibility:hidden; opacity:0; pointer-events:none; transform:translateY(100%); }
  @media(max-width:900px) {
    .hn-hero { min-height:auto; }
    .hn-hero__vehicle-scene { inset:0; width:100%; height:100%; clip-path:none; object-position:36% center; opacity:.58; transform:none; }
    .hn-hero__overlay { background:linear-gradient(90deg,rgba(2,37,26,.96),rgba(2,42,29,.82) 72%,rgba(2,42,29,.64)),linear-gradient(180deg,transparent 35%,rgba(3,32,23,.68)); }
    .hn-hero__content { padding-top:48px; }
  }
  @media(max-width:620px) {
    .hn-hero__vehicle-scene { object-position:30% center; opacity:.36; }
    .hn-hero__overlay { background:linear-gradient(180deg,rgba(2,37,26,.9),rgba(2,42,29,.79) 45%,rgba(2,35,25,.95)); }
    .hn-hero__content { padding:38px 0 28px; }
    .hn-hero h1.hn-hero-title { font-size:38px; }
    .hn-hero-title__name { gap:.1em; font-size:1.04em; }
    .hn-hero-title__name em { font-size:1.2em; }
    .hn-hero-title__specs { font-size:22px; }
    .hn-trust { gap:7px; }
    .hn-trust li { min-height:34px; padding:0 10px; }
  }
  /* News and closing CTA share the coastal journey art direction. */
  .hn-news { isolation:isolate; padding:64px 0 72px; background:linear-gradient(180deg,#fffaf0,#f7f8ef 58%,#fffbed); border-top:1px solid #eee2c7; }
  .hn-news:before { position:absolute; inset:0 0 auto; z-index:0; width:auto; height:330px; background-image:linear-gradient(90deg,#fffaf0 0,rgba(255,250,240,.9) 31%,rgba(255,250,240,.24) 64%,rgba(255,250,240,.08)),var(--hn-news-coast); background-position:center; background-size:cover; border:0; border-radius:0; box-shadow:none; content:''; }
  .hn-news:after { position:absolute; top:0; right:0; z-index:0; width:min(37vw,530px); height:330px; background-image:linear-gradient(90deg,rgba(255,250,240,.96),rgba(255,250,240,.08) 35%),var(--hn-news-bus); background-position:center; background-size:cover; clip-path:polygon(19% 0,100% 0,100% 100%,0 83%); content:''; opacity:.72; }
  .hn-news .hn-shell { position:relative; z-index:1; }
  .hn-news .hn-section-heading { min-height:185px; align-items:start; margin-bottom:22px; }
  .hn-news-heading>div { max-width:670px; }
  .hn-news-heading .hn-eyebrow { margin-bottom:12px; }
  .hn-news-heading h2 { margin:0 0 10px; font-size:clamp(38px,4.5vw,58px); line-height:1.02; letter-spacing:-.055em; }
  .hn-news-heading h2 span,.hn-news-heading h2 em { display:block; }
  .hn-news-heading h2 em { color:#dfaa09; font-style:normal; }
  .hn-news-heading>div>p:last-child { max-width:590px; margin:0; color:#586c62; font-size:14px; line-height:1.65; }
  .hn-news-heading>.hn-button { align-self:end; margin-bottom:18px; }
  .hn-news-grid { gap:18px; }
  .hn-news-card { border-color:#e3dccd; border-radius:16px; box-shadow:0 16px 38px rgba(66,56,30,.1); }
  .hn-news-card__image { height:215px; }
  .hn-news-card__body { min-height:244px; padding:19px 20px; }
  .hn-news-card h3 { font-size:17px; line-height:1.35; }
  .hn-final { width:min(1360px,calc(100% - 40px)); margin:0 auto 36px; padding:0; background-image:linear-gradient(90deg,rgba(3,61,42,.98) 0,rgba(3,61,42,.94) 53%,rgba(3,61,42,.34) 100%),var(--hn-final-bg); background-position:center; background-size:cover; border:0; border-radius:22px; box-shadow:0 20px 48px rgba(3,49,33,.2); }
  .hn-final:before { inset:0 auto 0 0; width:29%; height:auto; background:radial-gradient(circle at 0 50%,rgba(249,223,18,.16),transparent 68%); border:0; border-radius:0; box-shadow:none; }
  .hn-final__content { display:grid; grid-template-columns:250px minmax(0,1fr) auto; min-height:180px; gap:34px; align-items:center; }
  .hn-final__signature { color:#fff; font-family:"Brush Script MT","Segoe Script",cursive; font-size:28px; line-height:1.05; text-align:center; transform:rotate(-5deg); }
  .hn-final__signature:after { display:block; width:110px; height:4px; margin:8px auto 0; background:#f9df12; content:''; transform:skewX(-22deg); }
  .hn-final__content>div:nth-child(2) h2 { margin:0 0 8px; font-size:34px; }
  .hn-final__content>div:nth-child(2) p { font-size:14px; }
  .hn-final__content>div:last-child { display:flex; align-items:center; gap:12px; }
  .hn-final .hn-contact { min-height:46px; padding:0 18px; border:1px solid rgba(255,255,255,.5); border-radius:10px; text-decoration:none; }
  @media(max-width:900px) {
    .hn-news:after { display:none; }
    .hn-news:before { opacity:.55; }
    .hn-news .hn-section-heading { min-height:0; }
    .hn-final__content { grid-template-columns:1fr auto; padding:34px 0; }
    .hn-final__signature { display:none; }
  }
  @media(max-width:620px) {
    .hn-news { padding:48px 0; }
    .hn-news:before { height:285px; background-image:linear-gradient(180deg,rgba(255,250,240,.86),rgba(255,250,240,.96)),var(--hn-news-coast); }
    .hn-news-heading { gap:18px; }
    .hn-news-heading h2 { font-size:38px; }
    .hn-news-heading h2 span,.hn-news-heading h2 em { display:inline; }
    .hn-news-heading h2 em { margin-left:.16em; }
    .hn-news-heading>.hn-button { align-self:flex-start; margin:0; }
    .hn-news-card__image { height:200px; }
    .hn-final { width:min(100% - 28px,1360px); margin-bottom:22px; background-image:linear-gradient(120deg,rgba(3,61,42,.98),rgba(3,61,42,.82)),var(--hn-final-bg); }
    .hn-final__content { display:flex; min-height:0; align-items:flex-start; padding:30px 22px; flex-direction:column; gap:22px; }
    .hn-final__content>div:nth-child(2) h2 { font-size:29px; }
    .hn-final__content>div:last-child { width:100%; align-items:stretch; flex-direction:column; }
    .hn-final__content>div:last-child a { justify-content:center; }
  }
  @media (prefers-reduced-motion:reduce) {
    .hn-motion-ready .hn-reveal { opacity:1; transform:none; }
    .hn-faq details[open] p,.hn-hero__image,.hn-live-proof i { animation:none; }
  }
</style>
</head>
<body class="home-new">
@php
  $copy = [
    'vi' => [
      'nav_routes' => 'Tuyến xe', 'nav_schedule' => 'Lịch chạy', 'nav_news' => 'Tin tức', 'nav_about' => 'Về chúng tôi', 'nav_contact' => 'Liên hệ',
      'book' => 'Đặt vé', 'hero_kicker' => 'Sài Gòn ⇄ Nha Trang', 'hero_title' => 'Limousine Luxury • 22 phòng • WC trên xe',
      'hero_text' => 'Không gian thoải mái – dịch vụ tận tâm', 'official_site' => 'Website chính thức của Nhà xe Nhật Dương', 'one_way' => 'Một chiều', 'round_trip' => 'Khứ hồi',
      'from' => 'Điểm đi', 'to' => 'Điểm đến', 'date' => 'Ngày đi', 'return_date' => 'Ngày về (Khứ Hồi)', 'passengers' => 'Số khách', 'search' => 'Tìm chuyến',
      'trust_1' => 'Xác nhận đặt vé', 'trust_2' => 'Xe phòng tiện nghi', 'trust_3' => 'Thông tin rõ ràng',
      'route_kicker' => 'Tuyến phổ biến', 'route_title' => 'Chuyến đi được chuẩn bị cho hành trình dài', 'from_price' => 'Giá từ', 'duration' => 'Thời gian đi',
       'view_departures' => 'Xem giờ khởi hành', 'route_details' => 'Xem chi tiết tuyến', 'daily' => 'Khởi hành mỗi ngày', 'luggage' => 'Hành lý theo quy định', 'support' => 'Hỗ trợ đặt vé',
      'schedule_kicker' => 'Chọn giờ phù hợp', 'schedule_title' => 'Các giờ khởi hành hằng ngày', 'schedule_text' => 'Giờ chạy, loại xe và giá vé được hiển thị trước khi bạn đặt.',
       'departure' => 'Khởi hành', 'vehicle' => 'Loại xe', 'vehicle_default' => 'Xe phòng', 'price' => 'Giá vé', 'seats' => 'chỗ còn lại', 'choose' => 'Chọn chuyến', 'choose_direction' => 'Chọn chiều đi', 'live_unavailable' => 'Lịch chạy trực tuyến đang tạm thời không khả dụng.', 'no_departures' => 'Chưa có chuyến mở bán cho chiều này hôm nay.',
      'pickup_kicker' => 'Hệ thống văn phòng', 'pickup_title' => 'Ba điểm hỗ trợ trên hành trình', 'pickup_text' => 'Ghé văn phòng Nhật Dương tại TP. Hồ Chí Minh, Nha Trang hoặc Cam Ranh để được hỗ trợ đặt vé và xác nhận thông tin chuyến đi.',
      'pickup_1_title' => 'Điểm đón rõ ràng', 'pickup_1_text' => 'Nhận địa chỉ và giờ tập trung trong xác nhận đặt vé.',
      'pickup_2_title' => 'Hỗ trợ hành trình', 'pickup_2_text' => 'Liên hệ hỗ trợ nếu cần điều chỉnh thông tin trước giờ khởi hành.',
      'pickup_3_title' => 'Đến sớm', 'pickup_3_text' => 'Nên có mặt trước giờ khởi hành để hoàn tất lên xe thuận tiện.',
      'how_kicker' => 'Quy trình đơn giản', 'how_title' => 'Đặt vé trong ba bước', 'step_1' => 'Chọn chuyến', 'step_1_text' => 'Chọn chiều đi, ngày và giờ phù hợp.',
      'step_2' => 'Xác nhận thông tin', 'step_2_text' => 'Kiểm tra điểm đón, giá vé và thông tin hành khách.',
      'step_3' => 'Nhận vé', 'step_3_text' => 'Nhận xác nhận để sẵn sàng cho chuyến đi.',
      'faq_kicker' => 'Cần hỗ trợ?', 'faq_title' => 'Thông tin trước khi đặt vé', 'faq_1_q' => 'Tôi nên đến điểm đón lúc nào?', 'faq_1_a' => 'Nên có mặt sớm để kiểm tra thông tin và lên xe thuận tiện.',
      'faq_2_q' => 'Tôi có thể hỏi về hành lý hoặc điểm đón không?', 'faq_2_a' => 'Có. Vui lòng liên hệ đội ngũ hỗ trợ trước ngày khởi hành.',
      'faq_3_q' => 'Tôi nhận xác nhận đặt vé ở đâu?', 'faq_3_a' => 'Thông tin xác nhận sẽ được gửi theo phương thức đặt vé của bạn.',
      'news_kicker' => 'Tin tức mới', 'news_title' => 'Cập nhật cho hành trình tiếp theo', 'news_text' => 'Ưu đãi, thông tin dịch vụ và kinh nghiệm di chuyển từ Nhật Dương.', 'read_news' => 'Xem tất cả tin tức', 'read_article' => 'Đọc bài viết',
      'final_title' => 'Sẵn sàng chọn chuyến đi?', 'final_text' => 'Xem giờ chạy phù hợp và hoàn tất đặt vé trực tuyến.', 'contact' => 'Liên hệ hỗ trợ',
      'footer' => 'Tuyến vận chuyển hành khách Sài Gòn - Nha Trang.',
    ],
    'en' => [
      'nav_routes' => 'Routes', 'nav_schedule' => 'Schedule', 'nav_news' => 'News', 'nav_about' => 'About', 'nav_contact' => 'Contact',
      'book' => 'Book now', 'hero_kicker' => 'Ho Chi Minh City ⇄ Nha Trang', 'hero_title' => 'Luxury Limousine • 22 cabins • Onboard WC',
      'hero_text' => 'Comfortable space – attentive service', 'official_site' => 'Official website of Nhat Duong Bus', 'one_way' => 'One way', 'round_trip' => 'Round trip',
      'from' => 'From', 'to' => 'To', 'date' => 'Departure date', 'return_date' => 'Return date (Round trip)', 'passengers' => 'Passengers', 'search' => 'Find departures',
      'trust_1' => 'Booking confirmation', 'trust_2' => 'Comfortable sleeper cabin', 'trust_3' => 'Clear trip details',
      'route_kicker' => 'Popular route', 'route_title' => 'Prepared for a comfortable long-distance journey', 'from_price' => 'From', 'duration' => 'Travel time',
       'view_departures' => 'View departures', 'route_details' => 'View route details', 'daily' => 'Daily departures', 'luggage' => 'Luggage policy available', 'support' => 'Booking support',
      'schedule_kicker' => 'Choose a suitable time', 'schedule_title' => 'Available daily departures', 'schedule_text' => 'Departure time, vehicle type, and fare are visible before you book.',
       'departure' => 'Departure', 'vehicle' => 'Vehicle', 'vehicle_default' => 'Sleeper cabin', 'price' => 'Fare', 'seats' => 'seats remaining', 'choose' => 'Select departure', 'choose_direction' => 'Choose direction', 'live_unavailable' => 'Live departures are temporarily unavailable.', 'no_departures' => 'No departures are on sale for this direction today.',
      'pickup_kicker' => 'Office network', 'pickup_title' => 'Three offices along your journey', 'pickup_text' => 'Visit a Nhat Duong office in Ho Chi Minh City, Nha Trang, or Cam Ranh for booking assistance and trip confirmation.',
      'pickup_1_title' => 'Clear boarding point', 'pickup_1_text' => 'Your confirmation includes the address and meeting time.',
      'pickup_2_title' => 'Trip assistance', 'pickup_2_text' => 'Contact support if you need to clarify your details before travel.',
      'pickup_3_title' => 'Arrive early', 'pickup_3_text' => 'Please arrive early for a smooth check-in and boarding process.',
      'how_kicker' => 'Simple process', 'how_title' => 'Book in three steps', 'step_1' => 'Choose a departure', 'step_1_text' => 'Choose your direction, date, and preferred time.',
      'step_2' => 'Confirm your details', 'step_2_text' => 'Review pickup, fare, and passenger information.',
      'step_3' => 'Receive your ticket', 'step_3_text' => 'Keep your confirmation ready for the journey.',
      'faq_kicker' => 'Need help?', 'faq_title' => 'Before you book', 'faq_1_q' => 'When should I arrive at the pickup point?', 'faq_1_a' => 'Arrive early to check your details and board comfortably.',
      'faq_2_q' => 'Can I ask about luggage or pickup?', 'faq_2_a' => 'Yes. Please contact our support team before your departure date.',
      'faq_3_q' => 'Where will I receive my confirmation?', 'faq_3_a' => 'Your confirmation is sent through the booking method you use.',
      'news_kicker' => 'Latest news', 'news_title' => 'Updates for your next journey', 'news_text' => 'Offers, service updates, and practical travel guidance from Nhat Duong.', 'read_news' => 'View all news', 'read_article' => 'Read article',
      'final_title' => 'Ready to choose your departure?', 'final_text' => 'See available times and complete your booking online.', 'contact' => 'Contact support',
      'footer' => 'Passenger service between Ho Chi Minh City and Nha Trang.',
    ],
    'ru' => [
      'nav_routes' => 'Маршруты', 'nav_schedule' => 'Расписание', 'nav_news' => 'Новости', 'nav_about' => 'О компании', 'nav_contact' => 'Контакты',
      'book' => 'Забронировать', 'hero_kicker' => 'Хошимин ⇄ Нячанг', 'hero_title' => 'Luxury Limousine • 22 купе • туалет в автобусе',
      'hero_text' => 'Комфорт в пути – заботливый сервис', 'official_site' => 'Официальный сайт автобусной компании Nhat Duong', 'one_way' => 'В одну сторону', 'round_trip' => 'Туда и обратно',
      'from' => 'Откуда', 'to' => 'Куда', 'date' => 'Дата поездки', 'return_date' => 'Дата возвращения (туда-обратно)', 'passengers' => 'Пассажиры', 'search' => 'Найти рейсы',
      'trust_1' => 'Подтверждение бронирования', 'trust_2' => 'Комфортный спальный салон', 'trust_3' => 'Понятные условия поездки',
      'route_kicker' => 'Популярный маршрут', 'route_title' => 'Всё подготовлено для комфортной дальней поездки', 'from_price' => 'Цена от', 'duration' => 'Время в пути',
       'view_departures' => 'Посмотреть рейсы', 'route_details' => 'Подробнее о маршруте', 'daily' => 'Рейсы каждый день', 'luggage' => 'Правила багажа доступны', 'support' => 'Помощь с бронированием',
      'schedule_kicker' => 'Выберите удобное время', 'schedule_title' => 'Ежедневные рейсы', 'schedule_text' => 'Время отправления, тип автобуса и цена видны до бронирования.',
       'departure' => 'Отправление', 'vehicle' => 'Автобус', 'vehicle_default' => 'Спальный салон', 'price' => 'Цена', 'seats' => 'мест осталось', 'choose' => 'Выбрать рейс', 'choose_direction' => 'Выберите направление', 'live_unavailable' => 'Актуальное расписание временно недоступно.', 'no_departures' => 'Сегодня рейсы в этом направлении ещё не открыты для продажи.',
      'pickup_kicker' => 'Сеть офисов', 'pickup_title' => 'Три офиса по маршруту', 'pickup_text' => 'Обратитесь в офис Nhat Duong в Хошимине, Нячанге или Камрани для помощи с бронированием и подтверждения деталей поездки.',
      'pickup_1_title' => 'Точное место посадки', 'pickup_1_text' => 'Адрес и время встречи указаны в подтверждении.',
      'pickup_2_title' => 'Помощь в поездке', 'pickup_2_text' => 'Свяжитесь с поддержкой, если нужно уточнить детали до поездки.',
      'pickup_3_title' => 'Приезжайте заранее', 'pickup_3_text' => 'Приезжайте заранее для спокойной регистрации и посадки.',
      'how_kicker' => 'Простой процесс', 'how_title' => 'Бронирование в три шага', 'step_1' => 'Выберите рейс', 'step_1_text' => 'Выберите направление, дату и удобное время.',
      'step_2' => 'Подтвердите данные', 'step_2_text' => 'Проверьте место посадки, цену и данные пассажира.',
      'step_3' => 'Получите билет', 'step_3_text' => 'Сохраните подтверждение для поездки.',
      'faq_kicker' => 'Нужна помощь?', 'faq_title' => 'Перед бронированием', 'faq_1_q' => 'Когда нужно приехать к месту посадки?', 'faq_1_a' => 'Приезжайте заранее, чтобы спокойно проверить данные и сесть в автобус.',
      'faq_2_q' => 'Можно уточнить багаж или место посадки?', 'faq_2_a' => 'Да. Пожалуйста, свяжитесь с поддержкой до даты отправления.',
      'faq_3_q' => 'Где я получу подтверждение?', 'faq_3_a' => 'Подтверждение отправляется способом, выбранным при бронировании.',
      'news_kicker' => 'Новые материалы', 'news_title' => 'Обновления для следующей поездки', 'news_text' => 'Предложения, новости сервиса и полезные советы от Nhat Duong.', 'read_news' => 'Все новости', 'read_article' => 'Читать статью',
      'final_title' => 'Готовы выбрать рейс?', 'final_text' => 'Посмотрите доступное время и завершите бронирование онлайн.', 'contact' => 'Связаться с поддержкой',
      'footer' => 'Пассажирские перевозки между Хошимином и Нячангом.',
    ],
  ][$locale];

  $route = $ntRoute ?? $featuredRoutes->first();
  $routeDetailsUrl = $route ? route('routes.show', ['slug' => $route->slug, 'lang' => $locale]) : route('routes.index', ['lang' => $locale]);
  $routeImage = $route?->image ? asset('storage/'.$route->image) : $heroImage;
  $vehicleFallbackImage = asset('storage/image/b6c6290cc.jpg');
  $routeDuration = [
    'vi' => '6h30~7h30/chuyến',
    'en' => '6 hr 30 min–7 hr 30 min/trip',
    'ru' => '6 ч 30 мин–7 ч 30 мин/рейс',
  ][$locale];
  $locations = [
    29 => ['vi' => 'Hồ Chí Minh', 'en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
    19 => ['vi' => 'Đồng Nai', 'en' => 'Dong Nai', 'ru' => 'Донгнай'],
    235 => ['vi' => 'Biên Hòa', 'en' => 'Bien Hoa', 'ru' => 'Бьенхоа'],
    11 => ['vi' => 'Bình Thuận', 'en' => 'Binh Thuan', 'ru' => 'Биньтхуан'],
    159 => ['vi' => 'Phan Thiết', 'en' => 'Phan Thiet', 'ru' => 'Фантхьет'],
    32 => ['vi' => 'Khánh Hòa', 'en' => 'Khanh Hoa', 'ru' => 'Кханьхоа'],
    417 => ['vi' => 'Nha Trang', 'en' => 'Nha Trang', 'ru' => 'Нячанг'],
  ];
  $directionLabels = [
    'sg_nt' => ($locations[29][$locale] ?? 'Ho Chi Minh City').' → '.($locations[417][$locale] ?? 'Nha Trang'),
    'nt_sg' => ($locations[417][$locale] ?? 'Nha Trang').' → '.($locations[29][$locale] ?? 'Ho Chi Minh City'),
  ];
  [$heroName, $heroSpecs] = array_pad(explode(' • ', $copy['hero_title'], 2), 2, '');
  $directionSchedules = array_replace(['sg_nt' => [], 'nt_sg' => []], $liveSchedulesByRoute ?? ['sg_nt' => $liveSchedules]);
  $requestedDirection = request('direction');
  $selectedDirection = is_string($requestedDirection) && array_key_exists($requestedDirection, $directionSchedules)
    ? $requestedDirection
    : (array_key_first(array_filter($directionSchedules)) ?? 'sg_nt');
  $hasLiveSchedules = collect($directionSchedules)->contains(fn ($schedules) => !empty($schedules));
  $selectedSchedules = $directionSchedules[$selectedDirection] ?? [];
  $faqItems = [
    'vi' => [
      ['Có được nằm 3 người trên một giường không?', 'Không. Vì lý do an toàn và đảm bảo sự thoải mái trong suốt hành trình, mỗi giường được bố trí tối đa 2 hành khách. Nhà xe không áp dụng hình thức 3 người sử dụng chung một giường, kể cả khi có trẻ em đi cùng.'],
      ['Giường nằm 2 người có thoải mái không?', 'Mỗi cabin có kích thước khoảng 85 × 178 cm, được thiết kế phù hợp cho tối đa 2 hành khách. Để có trải nghiệm thoải mái nhất, tổng cân nặng của 2 hành khách nên ở mức khoảng 130 kg trở xuống.'],
      ['Nhà xe có hỗ trợ trung chuyển không?', "Có. Nhật Dương hỗ trợ đón/trả tận nơi tại một số khu vực trong nội thành Nha Trang, trong phạm vi khoảng 7 km. Phạm vi phục vụ thực tế phụ thuộc vào lộ trình, điều kiện giao thông và khả năng tiếp cận của xe trung chuyển tại từng khu vực.\n\nVui lòng cung cấp địa chỉ đón/trả khi đặt vé để nhân viên kiểm tra và xác nhận."],
      ['Nhà xe có xuất hóa đơn không?', 'Có. Nhật Dương hỗ trợ xuất hóa đơn theo thông tin khách hàng cung cấp. Quý khách vui lòng gửi đầy đủ thông tin xuất hóa đơn cho nhân viên trong ngày sử dụng dịch vụ để được tiếp nhận và xử lý theo quy định.'],
      ['Thời gian di chuyển mất khoảng bao lâu?', 'Thời gian di chuyển dự kiến giữa TP.HCM và Nha Trang khoảng 6–7 giờ khi lưu thông thuận lợi trên tuyến cao tốc hoặc Quốc lộ 1A. Thời gian thực tế có thể thay đổi tùy tình hình giao thông, thời tiết và các điều kiện phát sinh trên hành trình.'],
      ['Trên xe có WC không?', 'Có. Dòng xe Limousine Luxury 22 cabin của Nhật Dương được trang bị WC ngay trên xe, thuận tiện cho hành khách trong suốt hành trình.'],
      ['Xe có dừng nghỉ giữa hành trình không?', "Có, tùy theo khung giờ khởi hành. Đối với các chuyến khởi hành trước 17:00, xe dự kiến dừng nghỉ 01 lần tại trạm dừng chân trên tuyến cao tốc hoặc Quốc lộ 1A.\n\nLịch dừng nghỉ có thể được điều chỉnh tùy theo tình hình giao thông và lịch trình thực tế. Nhân viên sẽ thông tin cụ thể đến hành khách trước chuyến đi."],
    ],
    'en' => [
      ['Can three people share one bed?', 'No. For safety and comfort throughout the journey, each bed accommodates a maximum of 2 passengers. Three people may not share one bed, even when travelling with a child.'],
      ['Is a double bed comfortable for two people?', 'Each cabin measures approximately 85 × 178 cm and is designed for up to 2 passengers. For the most comfortable experience, the combined weight of both passengers should be approximately 130 kg or less.'],
      ['Does the operator provide shuttle service?', "Yes. Nhat Duong provides door-to-door pickup and drop-off in selected areas of central Nha Trang within an approximate 7 km radius. Actual coverage depends on the route, traffic conditions, and shuttle access to each area.\n\nPlease provide your pickup or drop-off address when booking so our staff can check and confirm availability."],
      ['Can the operator issue an invoice?', 'Yes. Nhat Duong can issue an invoice using the information provided by the customer. Please send the complete invoicing details to our staff on the day of service for processing in accordance with applicable requirements.'],
      ['How long does the journey take?', 'The estimated journey between Ho Chi Minh City and Nha Trang is approximately 6–7 hours in favorable traffic conditions via the expressway or National Highway 1A. Actual travel time may vary depending on traffic, weather, and other conditions during the journey.'],
      ['Is there a WC on the bus?', 'Yes. Nhat Duong Luxury Limousine buses with 22 cabins are equipped with an onboard WC for passenger convenience throughout the journey.'],
      ['Does the bus stop for a break during the journey?', "It depends on the departure time. Departures before 17:00 are expected to make one rest stop along the expressway or National Highway 1A.\n\nThe rest schedule may change depending on traffic and the actual itinerary. Staff will provide passengers with specific information before departure."],
    ],
    'ru' => [
      ['Можно ли разместиться втроём на одном спальном месте?', 'Нет. Для безопасности и комфорта во время поездки каждое спальное место рассчитано максимум на 2 пассажиров. Размещение втроём не допускается, даже если пассажиры путешествуют с ребёнком.'],
      ['Удобно ли двум пассажирам на одном спальном месте?', 'Размер каждой кабины составляет примерно 85 × 178 см, она рассчитана максимум на 2 пассажиров. Для наиболее комфортной поездки общий вес двух пассажиров рекомендуется не более 130 кг.'],
      ['Предоставляет ли перевозчик трансфер?', "Да. Nhat Duong выполняет адресный трансфер в отдельных районах центра Нячанга в радиусе около 7 км. Фактическая зона обслуживания зависит от маршрута, дорожной обстановки и доступности конкретного адреса для трансферного автомобиля.\n\nУкажите адрес посадки или высадки при бронировании, чтобы сотрудник мог проверить и подтвердить возможность трансфера."],
      ['Можно ли получить счёт-фактуру?', 'Да. Nhat Duong оформляет счёт-фактуру по данным, предоставленным клиентом. Передайте сотруднику полные реквизиты в день оказания услуги для оформления в соответствии с установленными требованиями.'],
      ['Сколько времени занимает поездка?', 'Ориентировочное время в пути между Хошимином и Нячангом составляет 6–7 часов при благоприятной дорожной обстановке по скоростной автомагистрали или Национальному шоссе 1A. Фактическое время зависит от дорожной ситуации, погоды и других условий в пути.'],
      ['Есть ли в автобусе туалет?', 'Да. Автобусы Nhat Duong Luxury Limousine с 22 кабинами оборудованы туалетом для удобства пассажиров на протяжении всей поездки.'],
      ['Предусмотрена ли остановка для отдыха?', "Это зависит от времени отправления. Рейсы до 17:00 обычно делают одну остановку для отдыха на скоростной автомагистрали или Национальном шоссе 1A.\n\nРасписание остановок может меняться в зависимости от дорожной обстановки и фактического маршрута. Сотрудники сообщат пассажирам подробности перед отправлением."],
    ],
  ][$locale];
  $faqUi = [
    'vi' => ['kicker' => 'CÂU HỎI THƯỜNG GẶP', 'intro' => 'Giải đáp các thắc mắc phổ biến để bạn dễ dàng chọn chuyến và có hành trình thuận tiện nhất cùng Nhật Dương.'],
    'en' => ['kicker' => 'FREQUENTLY ASKED QUESTIONS', 'intro' => 'Clear answers to common questions, helping you choose a suitable departure and travel comfortably with Nhat Duong.'],
    'ru' => ['kicker' => 'ЧАСТЫЕ ВОПРОСЫ', 'intro' => 'Ответы на частые вопросы помогут выбрать подходящий рейс и комфортно путешествовать с Nhat Duong.'],
  ][$locale];
  $faqIcons = [
    '<svg viewBox="0 0 24 24"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M2 19v-2a5 5 0 0 1 10 0v2M12 19v-2a5 5 0 0 1 10 0v2"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M3 18V7M3 14h18v4M7 14V9h5a4 4 0 0 1 4 4v1M3 18v2M21 18v2"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M3 7h11v10H3zM14 10h3l4 4v3h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M6 3h12v18H6zM9 7h6M9 11h6M9 15h4"/></svg>',
    '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v6l4 2"/></svg>',
    '<b>WC</b>',
    '<svg viewBox="0 0 24 24"><path d="M4 8h13v7a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8Z"/><path d="M17 10h2a3 3 0 0 1 0 6h-2M8 4v2M12 3v3"/></svg>',
  ];
  $pickupPoints = $route?->pickupPoints ?? collect();
  $dropoffPoints = $route?->dropoffPoints ?? collect();
  $supportPhones = ['0971.799.097', '0789.802.999', '0789.803.999'];
  $pickupLabels = [
    'vi' => ['pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ', 'support' => 'Cần xác nhận điểm đón?', 'support_text' => 'Liên hệ hỗ trợ trước ngày đi để xác nhận hành lý, điểm đón và chính sách đổi vé.'],
    'en' => ['pickup' => 'Pickup points', 'dropoff' => 'Drop-off points', 'map' => 'Open map', 'support' => 'Need to confirm a pickup point?', 'support_text' => 'Contact support before travel to confirm luggage, pickup details, and change policy.'],
    'ru' => ['pickup' => 'Места посадки', 'dropoff' => 'Места высадки', 'map' => 'Открыть карту', 'support' => 'Нужно подтвердить место посадки?', 'support_text' => 'Свяжитесь с поддержкой до поездки, чтобы уточнить багаж, посадку и условия изменения билета.'],
  ][$locale];
  $productCopy = [
    'vi' => ['live' => 'DỮ LIỆU CHUYẾN ĐI TRỰC TIẾP', 'fleet_kicker' => 'CHỌN CHUYẾN PHÙ HỢP', 'fleet_title' => 'Xem đúng loại xe trước khi đặt', 'fleet_text' => 'Giờ khởi hành, loại xe và giá vé được lấy trực tiếp cho ngày bạn chọn.', 'actual_vehicle' => 'Hình ảnh xe thực tế', 'onboard' => 'Thông tin chuyến', 'seat_map' => 'Sơ đồ ghế thực tế', 'seat_map_text' => 'Chọn ghế đang trống trước khi thanh toán.', 'stops' => 'Điểm đón, trả rõ ràng', 'stops_text' => 'Xem địa chỉ và thời gian theo từng chuyến.', 'payment' => 'Thanh toán có xác nhận', 'payment_text' => 'Nhận mã thanh toán và trạng thái giao dịch rõ ràng.', 'transfer' => 'Hỗ trợ trung chuyển tận nơi trong bán kính 7 km tại Nha Trang.', 'review_kicker' => 'PHẢN HỒI HÀNH KHÁCH', 'review_fallback' => 'Đội ngũ Nhật Dương luôn sẵn sàng hỗ trợ để hành trình của bạn rõ ràng và thuận tiện hơn.', 'support_call' => 'Gọi hỗ trợ', 'support_online' => 'Hỗ trợ đặt vé'],
    'en' => ['live' => 'LIVE TRIP DATA', 'fleet_kicker' => 'CHOOSE A SUITABLE TRIP', 'fleet_title' => 'See the actual vehicle before booking', 'fleet_text' => 'Departure time, vehicle type, and fare come directly from the selected travel date.', 'actual_vehicle' => 'Actual vehicle image', 'onboard' => 'Trip details', 'seat_map' => 'Live seat map', 'seat_map_text' => 'Choose an available seat before payment.', 'stops' => 'Clear pickup and drop-off points', 'stops_text' => 'See the address and time for each trip.', 'payment' => 'Confirmed payment', 'payment_text' => 'Receive a payment reference and clear transaction status.', 'transfer' => 'Door-to-door shuttle support within a 7 km radius in Nha Trang.', 'review_kicker' => 'PASSENGER FEEDBACK', 'review_fallback' => 'The Nhat Duong team is ready to make your journey clearer and more comfortable.', 'support_call' => 'Call support', 'support_online' => 'Booking support'],
    'ru' => ['live' => 'АКТУАЛЬНЫЕ ДАННЫЕ О РЕЙСАХ', 'fleet_kicker' => 'ВЫБЕРИТЕ ПОДХОДЯЩИЙ РЕЙС', 'fleet_title' => 'Узнайте тип автобуса до бронирования', 'fleet_text' => 'Время отправления, тип автобуса и стоимость загружаются для выбранной даты.', 'actual_vehicle' => 'Фактическое фото автобуса', 'onboard' => 'Информация о рейсе', 'seat_map' => 'Актуальная схема мест', 'seat_map_text' => 'Выберите свободное место до оплаты.', 'stops' => 'Понятные места посадки и высадки', 'stops_text' => 'Адрес и время указаны для каждого рейса.', 'payment' => 'Подтверждённая оплата', 'payment_text' => 'Получите код оплаты и понятный статус транзакции.', 'transfer' => 'Трансфер от двери до двери в радиусе 7 км в Нячанге.', 'review_kicker' => 'ОТЗЫВЫ ПАССАЖИРОВ', 'review_fallback' => 'Команда Nhật Dương готова сделать вашу поездку понятнее и комфортнее.', 'support_call' => 'Позвонить в поддержку', 'support_online' => 'Помощь с бронированием'],
  ][$locale];
  $scheduleUi = [
    'vi' => ['trips' => 'Các chuyến', 'passenger' => 'khách', 'change' => 'Đổi tìm kiếm', 'all' => 'Tất cả', 'morning' => 'Buổi sáng', 'afternoon' => 'Buổi chiều', 'evening' => 'Buổi tối', 'sort' => 'Sắp xếp', 'earliest' => 'Giờ sớm nhất', 'latest' => 'Giờ muộn nhất', 'lowest' => 'Giá thấp nhất', 'open' => 'Đang mở bán', 'room' => 'Phòng đôi', 'size' => 'Giường 85 × 178 cm', 'wc' => 'WC trên xe', 'secure' => 'Xác nhận chỗ trước khi thanh toán', 'empty' => 'Không có chuyến phù hợp với bộ lọc này.'],
    'en' => ['trips' => 'Departures', 'passenger' => 'passenger', 'change' => 'Change search', 'all' => 'All', 'morning' => 'Morning', 'afternoon' => 'Afternoon', 'evening' => 'Evening', 'sort' => 'Sort by', 'earliest' => 'Earliest', 'latest' => 'Latest', 'lowest' => 'Lowest fare', 'open' => 'Now booking', 'room' => 'Double cabin', 'size' => 'Bed 85 × 178 cm', 'wc' => 'Onboard WC', 'secure' => 'Confirm your place before payment', 'empty' => 'No departures match this filter.'],
    'ru' => ['trips' => 'Рейсы', 'passenger' => 'пассажир', 'change' => 'Изменить поиск', 'all' => 'Все', 'morning' => 'Утро', 'afternoon' => 'День', 'evening' => 'Вечер', 'sort' => 'Сортировка', 'earliest' => 'Самые ранние', 'latest' => 'Самые поздние', 'lowest' => 'Низкая цена', 'open' => 'Продажа открыта', 'room' => 'Двухместное купе', 'size' => 'Спальное место 85 × 178 см', 'wc' => 'Туалет в автобусе', 'secure' => 'Подтвердите место до оплаты', 'empty' => 'Нет рейсов, соответствующих фильтру.'],
  ][$locale];
  $bookingToolsUi = [
    'vi' => ['routes' => 'Tuyến nhanh', 'dates' => 'Chọn ngày', 'today' => 'Hôm nay', 'tomorrow' => 'Ngày mai', 'one_way' => 'Hành trình một chiều', 'round_trip' => 'Hành trình khứ hồi', 'clear_return' => 'Xóa ngày về'],
    'en' => ['routes' => 'Quick routes', 'dates' => 'Travel date', 'today' => 'Today', 'tomorrow' => 'Tomorrow', 'one_way' => 'One-way journey', 'round_trip' => 'Round trip', 'clear_return' => 'Clear return'],
    'ru' => ['routes' => 'Быстрый маршрут', 'dates' => 'Дата поездки', 'today' => 'Сегодня', 'tomorrow' => 'Завтра', 'one_way' => 'Поездка в одну сторону', 'round_trip' => 'Поездка туда и обратно', 'clear_return' => 'Удалить дату возврата'],
  ][$locale];
  $newsUi = [
    'vi' => ['title_before' => 'Cập nhật cho hành trình', 'title_accent' => 'tiếp theo', 'signature' => 'Nhật Dương<br>luôn đồng hành<br>cùng bạn!'],
    'en' => ['title_before' => 'Updates for your', 'title_accent' => 'next journey', 'signature' => 'Nhat Duong<br>travels with you'],
    'ru' => ['title_before' => 'Новости для вашей', 'title_accent' => 'следующей поездки', 'signature' => 'Nhat Duong<br>всегда рядом'],
  ][$locale];
  $fleetUi = [
    'vi' => ['comfort' => 'Không gian riêng tư · Êm ái · Đầy đủ tiện nghi', 'detail' => 'Xem ảnh chi tiết', 'change' => 'Thay đổi', 'guest' => 'khách'],
    'en' => ['comfort' => 'Private space · Smooth ride · Fully equipped', 'detail' => 'View photos', 'change' => 'Change', 'guest' => 'passenger'],
    'ru' => ['comfort' => 'Личное пространство · Комфорт · Все удобства', 'detail' => 'Смотреть фото', 'change' => 'Изменить', 'guest' => 'пассажир'],
  ][$locale];
  $whyChoose = [
    'vi' => [
      'kicker' => 'LÝ DO CHỌN NHẬT DƯƠNG',
      'title_before' => 'Tại sao nên chọn', 'title_accent' => 'Nhật Dương', 'title_after' => 'cho hành trình của bạn?',
      'text' => 'Trải nghiệm cao cấp được chăm chút từ lúc chờ xe đến khi kết thúc hành trình.',
      'signature' => ['Hành trình', 'An toàn', 'Thoải mái'],
      'items' => [
        ['Phòng chờ thoải mái, lịch sự, có đồ ăn nhẹ.', 'Không gian hiện đại, sạch sẽ, nước uống và đồ ăn nhẹ miễn phí trước giờ khởi hành.'],
        ['Giá tốt, phù hợp với phân khúc cao cấp.', 'Chất lượng dịch vụ xứng tầm với mức giá hợp lý, nhiều ưu đãi và chính sách linh hoạt.'],
        ['Hỗ trợ trung chuyển tận nơi trong bán kính 7 km tại Nha Trang.', 'Xe trung chuyển hiện đại, đưa đón thuận tiện, tiết kiệm thời gian và công sức.'],
        ['Hủy vé linh hoạt: miễn phí trước 24 giờ so với giờ khởi hành.', 'Dễ dàng thay đổi kế hoạch, an tâm đặt vé bất cứ lúc nào.'],
      ],
    ],
    'en' => [
      'kicker' => 'WHY CHOOSE NHAT DUONG',
      'title_before' => 'Why choose', 'title_accent' => 'Nhat Duong', 'title_after' => 'for your journey?',
      'text' => 'A premium experience thoughtfully prepared from the waiting lounge to your destination.',
      'signature' => ['A journey that is', 'Safe', 'Comfortable'],
      'items' => [
        ['A comfortable, welcoming lounge with light refreshments.', 'A modern, clean waiting space with complimentary drinks and light snacks before departure.'],
        ['Competitive fares suited to a premium travel experience.', 'Premium service at a sensible fare, with attractive offers and flexible policies.'],
        ['Door-to-door shuttle support within a 7 km radius in Nha Trang.', 'Modern shuttle vehicles make pickup convenient and save you time and effort.'],
        ['Flexible cancellation: free up to 24 hours before departure.', 'Change your plans more easily and book with confidence at any time.'],
      ],
    ],
    'ru' => [
      'kicker' => 'ПОЧЕМУ NHAT DUONG',
      'title_before' => 'Почему стоит выбрать', 'title_accent' => 'Nhat Duong', 'title_after' => 'для поездки?',
      'text' => 'Продуманный сервис премиум-класса от зала ожидания до пункта назначения.',
      'signature' => ['Путешествие', 'Безопасно', 'Комфортно'],
      'items' => [
        ['Комфортный зал ожидания и лёгкие закуски.', 'Современное чистое пространство, бесплатные напитки и лёгкие закуски перед отправлением.'],
        ['Выгодная цена для поездки премиум-класса.', 'Высокое качество сервиса по разумной цене, выгодные предложения и гибкие условия.'],
        ['Трансфер от двери до двери в радиусе 7 км в Нячанге.', 'Современный трансфер обеспечивает удобную посадку и помогает экономить время.'],
        ['Гибкая отмена: бесплатно не позднее чем за 24 часа до отправления.', 'Легко меняйте планы и бронируйте поездку с уверенностью.'],
      ],
    ],
  ][$locale];
  $whyImages = [$vehicleFallbackImage, $heroImage, asset('storage/image/03bf4.jpg'), $routeImage];
  $iconAsset = fn (string $name): string => asset('nhat-duong-icon-assets/clean/'.$name);
  $whyIcons = [
    '<img src="'.$iconAsset('icon-bed.png').'" alt="">',
    '<img src="'.$iconAsset('icon-tag.png').'" alt="">',
    '<img src="'.$iconAsset('icon-transfer.png').'" alt="">',
    '<img src="'.$iconAsset('icon-calendar.png').'" alt="">',
  ];
  $proofIcons = [
    '<img src="'.$iconAsset('img-seat.png').'" alt="">',
    '<img src="'.$iconAsset('img-map.png').'" alt="">',
    '<img src="'.$iconAsset('img-wallet.png').'" alt="">',
  ];
  $homeUi = [
    'vi' => ['where_go' => 'Bạn muốn đi đâu?', 'swap' => 'Đổi chiều', 'live_date' => 'Chuyến đang mở bán', 'today' => 'Hôm nay', 'frequency' => 'Đa dạng các khung giờ', 'arrival' => 'Đến', 'travel_time' => 'Thời gian', 'remaining' => 'Còn', 'view_all' => 'Xem tất cả giờ chạy', 'amenities' => ['Nhân viên sử dụng tiếng Anh', 'Bánh ngọt', 'Toilet', 'Đèn đọc sách', 'Dây đai an toàn', 'Nước uống', 'Gối nằm', 'Búa phá kính', 'Tivi LED', 'Sạc điện thoại', 'Rèm cửa', 'Dàn âm thanh', 'Wi-Fi', 'Điều hòa', 'Khăn lạnh'], 'popular_stops' => 'Điểm đón, trả phổ biến', 'stops_text' => 'Địa chỉ chính xác và thời gian có mặt được xác nhận theo chuyến bạn chọn.', 'pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ', 'assurance' => 'An tâm đặt vé', 'back_booking' => 'Về form đặt vé', 'call' => 'Gọi hỗ trợ', 'searching' => 'Đang tìm chuyến...'],
    'en' => ['where_go' => 'Where would you like to go?', 'swap' => 'Swap locations', 'live_date' => 'Available departures', 'today' => 'Today', 'frequency' => 'A variety of departure times', 'arrival' => 'Arrival', 'travel_time' => 'Duration', 'remaining' => 'Left', 'view_all' => 'View all departures', 'amenities' => ['English-speaking staff', 'Snacks', 'Toilet', 'Reading light', 'Seat belt', 'Drinking water', 'Pillow', 'Emergency hammer', 'LED TV', 'Phone charging', 'Window curtains', 'Sound system', 'Wi-Fi', 'Air conditioning', 'Cold towel'], 'popular_stops' => 'Popular pickup and drop-off points', 'stops_text' => 'The exact address and check-in time are confirmed for your selected departure.', 'pickup' => 'Pickup', 'dropoff' => 'Drop-off', 'map' => 'Open map', 'assurance' => 'Book with confidence', 'back_booking' => 'Back to booking', 'call' => 'Call support', 'searching' => 'Finding departures...'],
    'ru' => ['where_go' => 'Куда вы хотите поехать?', 'swap' => 'Поменять местами', 'live_date' => 'Доступные рейсы', 'today' => 'Сегодня', 'frequency' => 'Разнообразное время отправления', 'arrival' => 'Прибытие', 'travel_time' => 'В пути', 'remaining' => 'Осталось', 'view_all' => 'Все рейсы', 'amenities' => ['Англоговорящий персонал', 'Закуски', 'Туалет', 'Лампа для чтения', 'Ремень безопасности', 'Питьевая вода', 'Подушка', 'Аварийный молоток', 'LED-телевизор', 'Зарядка телефона', 'Шторы', 'Аудиосистема', 'Wi-Fi', 'Кондиционер', 'Холодное полотенце'], 'popular_stops' => 'Популярные места посадки и высадки', 'stops_text' => 'Точный адрес и время регистрации подтверждаются для выбранного рейса.', 'pickup' => 'Посадка', 'dropoff' => 'Высадка', 'map' => 'Открыть карту', 'assurance' => 'Бронируйте уверенно', 'back_booking' => 'К форме бронирования', 'call' => 'Позвонить', 'searching' => 'Ищем рейсы...'],
  ][$locale];
  $assuranceUi = [
    'vi' => ['kicker' => 'AN TÂM TRÊN MỖI HÀNH TRÌNH', 'intro' => 'Kiểm tra chỗ trống, điểm đón trả và trạng thái thanh toán trước khi khởi hành.'],
    'en' => ['kicker' => 'CLEAR AT EVERY STEP', 'intro' => 'Review seat availability, pickup details, and payment confirmation before departure.'],
    'ru' => ['kicker' => 'ВСЁ ПОНЯТНО ДО ПОЕЗДКИ', 'intro' => 'Проверьте свободные места, пункты посадки и подтверждение оплаты до отправления.'],
  ][$locale];
  $officeLabels = [
    'vi' => ['label' => 'Văn phòng', 'hcm' => 'VP TP. HỒ CHÍ MINH', 'nha_trang' => 'VP NHA TRANG', 'cam_ranh' => 'VP CAM RANH'],
    'en' => ['label' => 'Office', 'hcm' => 'HO CHI MINH CITY OFFICE', 'nha_trang' => 'NHA TRANG OFFICE', 'cam_ranh' => 'CAM RANH OFFICE'],
    'ru' => ['label' => 'Офис', 'hcm' => 'ОФИС В ХОШИМИНЕ', 'nha_trang' => 'ОФИС В НЯЧАНГЕ', 'cam_ranh' => 'ОФИС В КАМРАНИ'],
  ][$locale];
  $offices = [
    ['name' => $officeLabels['hcm'], 'address' => '99 Nguyễn Cư Trinh, P. Cầu Ông Lãnh, TP. HCM'],
    ['name' => $officeLabels['nha_trang'], 'address' => '45-26 Thích Quảng Đức, KĐT Hà Quang 2, P. Nam Nha Trang, Khánh Hoà'],
    ['name' => $officeLabels['cam_ranh'], 'address' => '44 Huỳnh Thúc Kháng, P. Cam Ranh, Khánh Hoà'],
  ];
  $officeImages = [$heroImage, $vehicleFallbackImage, asset('storage/image/03bf4.jpg')];
  $officePins = [$iconAsset('pin-hcm.png'), $iconAsset('pin-nhatrang.png'), $iconAsset('pin-camranh.png')];
  $homeTripTabs = [
    'vi' => ['discount' => 'Giảm giá', 'points' => 'Đón/Trả', 'reviews' => 'Đánh giá', 'images' => 'Hình ảnh', 'amenities' => 'Tiện ích', 'operator_policy' => 'Chính sách nhà xe'],
    'en' => ['discount' => 'Discount', 'points' => 'Pickup/Drop-off', 'reviews' => 'Reviews', 'images' => 'Images', 'amenities' => 'Amenities', 'operator_policy' => 'Operator policy'],
    'ru' => ['discount' => 'Скидка', 'points' => 'Посадка/Высадка', 'reviews' => 'Отзывы', 'images' => 'Фото', 'amenities' => 'Удобства', 'operator_policy' => 'Правила перевозчика'],
  ][$locale];
  $homeTripCopy = [
    'vi' => ['original' => 'Giá gốc', 'sale' => 'Giá khuyến mãi', 'save' => 'Tiết kiệm', 'no_discount' => 'Chuyến này hiện chưa áp dụng khuyến mãi.', 'loading' => 'Đang tải thông tin chuyến...', 'error' => 'Không thể tải chi tiết chuyến. Vui lòng thử lại.'],
    'en' => ['original' => 'Original fare', 'sale' => 'Promotional fare', 'save' => 'Save', 'no_discount' => 'No promotion currently applies to this departure.', 'loading' => 'Loading trip details...', 'error' => 'Unable to load trip details. Please try again.'],
    'ru' => ['original' => 'Обычная цена', 'sale' => 'Цена со скидкой', 'save' => 'Экономия', 'no_discount' => 'На этот рейс сейчас нет акции.', 'loading' => 'Загружаем информацию о рейсе...', 'error' => 'Не удалось загрузить данные. Попробуйте еще раз.'],
  ][$locale];
  $amenityIcons = [
    '<svg viewBox="0 0 24 24"><path d="M5 5h14v10H9l-4 4V5Z"/><path d="m9 9 2 2 4-4"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M4 15h16M6 15a6 6 0 0 1 12 0M12 7V5M4 19h16"/></svg>',
    '<b>WC</b>',
    '<svg viewBox="0 0 24 24"><path d="M9 18h6M10 22h4M8 14a6 6 0 1 1 8 0c-1 1-1 2-1 2H9s0-1-1-2Z"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M7 3v7l5 4 5-4V3M5 21l7-7 7 7"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M12 3s6 6.4 6 11a6 6 0 0 1-12 0c0-4.6 6-11 6-11Z"/></svg>',
    '<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="11" rx="3"/><path d="M7 11h10"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="m14 3 7 7-3 3-2-2-8 8H4v-4l8-8-2-2 4-2Z"/></svg>',
    '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M8 22h8M12 18v4"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="m13 2-7 12h6l-1 8 7-12h-6z"/></svg>',
    '<svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 3v18M16 3v18M8 8h8"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M4 9h4l5-4v14l-5-4H4V9Z"/><path d="M17 9a4 4 0 0 1 0 6M19 6a8 8 0 0 1 0 12"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M4 9a13 13 0 0 1 16 0M7 13a8 8 0 0 1 10 0M10 17a3 3 0 0 1 4 0"/><circle cx="12" cy="20" r="1" fill="currentColor" stroke="none"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M12 2v20M4.9 6l14.2 12M19.1 6 4.9 18M3 12h18"/></svg>',
    '<svg viewBox="0 0 24 24"><path d="M6 5h12v14H6zM9 5V3h6v2M9 10h6M9 14h4"/></svg>',
  ];
  $amenityGroups = ['service', 'service', 'comfort', 'comfort', 'safety', 'service', 'comfort', 'safety', 'comfort', 'comfort', 'comfort', 'comfort', 'comfort', 'comfort', 'service'];
  $featuredAmenities = [2, 5, 8, 9, 12, 13];
  $fleetAmenityIndexes = [6, 2, 13, 12, 8, 9];
  $amenityTabs = [
    'vi' => ['featured' => 'Nổi bật', 'all' => 'Tất cả (15)', 'comfort' => 'Tiện nghi', 'service' => 'Dịch vụ', 'safety' => 'An toàn'],
    'en' => ['featured' => 'Featured', 'all' => 'All (15)', 'comfort' => 'Comfort', 'service' => 'Service', 'safety' => 'Safety'],
    'ru' => ['featured' => 'Популярное', 'all' => 'Все (15)', 'comfort' => 'Комфорт', 'service' => 'Сервис', 'safety' => 'Безопасность'],
  ][$locale];
  $amenityTabsLabel = ['vi' => 'Lọc tiện ích', 'en' => 'Filter amenities', 'ru' => 'Фильтр удобств'][$locale];
  $fleetTrips = collect($selectedSchedules)->filter(fn ($schedule) => filled($schedule['vehicle_type'] ?? null))->unique('vehicle_type')->take(3);
  $fleetFromId = $selectedDirection === 'nt_sg' ? 417 : 29;
  $fleetToId = $selectedDirection === 'nt_sg' ? 29 : 417;
  $startingFare = collect($directionSchedules)->flatten(1)->min('fare') ?: ($route?->price_from ?? 0);
  $vndPerUsd = max(1, (int) config('services.currency.vnd_per_usd', 26000));
  $toUsd = fn (int|float $amount): string => number_format($amount / $vndPerUsd, 0);
  $weekdays = [
    'vi' => ['Chủ nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
    'en' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    'ru' => ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
  ];
  $liveTravelDateLabel = $weekdays[$locale][$liveTravelDate->dayOfWeek].', '.$liveTravelDate->format('d/m/Y');
  $formatDuration = function ($minutes) use ($locale): string {
    $minutes = (int) $minutes;
    if ($minutes <= 0) return '—';
    $hours = intdiv($minutes, 60);
    $remaining = $minutes % 60;
    if ($locale === 'vi') return $hours.' giờ'.($remaining ? ' '.$remaining.' phút' : '');
    if ($locale === 'ru') return $hours.' ч'.($remaining ? ' '.$remaining.' мин' : '');
    return $hours.' hr'.($remaining ? ' '.$remaining.' min' : '');
  };
  $supportPhone = preg_replace('/\D+/', '', $settings['hotline'] ?? '');
  $supportHref = $supportPhone ? 'tel:+'.$supportPhone : route('contact', ['lang' => $locale]);
@endphp

<header class="hn-header">
  <div class="hn-shell hn-nav-wrap">
    <a class="hn-brand" href="{{ route('home', ['lang' => $locale]) }}" aria-label="Nhat Duong home">
      <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}" alt="Nhat Duong">
    </a>
    <nav id="hn-desktop-nav" class="hn-nav" aria-label="Primary navigation">
      <a href="{{ route('routes.index', ['lang' => $locale]) }}">{{ $copy['nav_routes'] }}</a>
      <a href="{{ route('schedules.index', ['lang' => $locale]) }}">{{ $copy['nav_schedule'] }}</a>
      <a href="{{ route('posts.index', ['lang' => $locale]) }}">{{ $copy['nav_news'] }}</a>
      <a href="{{ route('about', ['lang' => $locale]) }}">{{ $copy['nav_about'] }}</a>
      <a href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['nav_contact'] }}</a>
    </nav>
    <div class="hn-actions">
      <div class="hn-locale" aria-label="Language">
        @foreach(['vi' => 'VI', 'en' => 'EN', 'ru' => 'RU'] as $code => $label)
          <a href="{{ route('home', ['lang' => $code]) }}" aria-current="{{ $locale === $code ? 'page' : 'false' }}">{{ $label }}</a>
        @endforeach
      </div>
      <a class="hn-button hn-button--primary" href="#booking">{{ $copy['book'] }}</a>
      <button class="hn-menu-button" type="button" aria-expanded="false" aria-controls="hn-mobile-nav"><span></span><span></span><span></span></button>
    </div>
  </div>
  <nav id="hn-mobile-nav" class="hn-mobile-nav" aria-label="Mobile navigation" hidden>
    <div class="hn-shell">
      <a href="{{ route('routes.index', ['lang' => $locale]) }}">{{ $copy['nav_routes'] }}</a><a href="{{ route('schedules.index', ['lang' => $locale]) }}">{{ $copy['nav_schedule'] }}</a><a href="{{ route('posts.index', ['lang' => $locale]) }}">{{ $copy['nav_news'] }}</a><a href="{{ route('about', ['lang' => $locale]) }}">{{ $copy['nav_about'] }}</a><a href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['nav_contact'] }}</a><a href="#booking">{{ $copy['book'] }}</a>
    </div>
  </nav>
</header>

<main>
  <section class="hn-hero" aria-labelledby="hero-title">
    <img class="hn-hero__image" src="{{ $heroImage }}" alt="" aria-hidden="true" fetchpriority="high" loading="eager" decoding="async">
    <img class="hn-hero__vehicle-scene" src="{{ $vehicleFallbackImage }}" alt="" aria-hidden="true" fetchpriority="high" loading="eager" decoding="async">
    <div class="hn-hero__overlay"></div>
    <div class="hn-shell hn-hero__content">
      <div class="hn-hero__copy">
        <p class="hn-eyebrow hn-hero-route">{{ $copy['hero_kicker'] }}</p>
        <h1 id="hero-title" class="hn-hero-title"><span class="hn-hero-title__name">{!! str_replace('Luxury', '<em>Luxury</em>', e($heroName)) !!}</span><span class="hn-hero-title__specs">{{ $heroSpecs }}</span></h1>
        <p class="hn-hero-tagline">{{ $copy['hero_text'] }}</p>
        <p class="hn-official-site"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-2.8 8.2-7 10-4.2-1.8-7-5.3-7-10V6l7-3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/></svg><strong>{{ $copy['official_site'] }}</strong></p>
      </div>
      <form id="booking" class="hn-booking" action="{{ route('booking.search') }}" method="GET">
        <fieldset>
          <div class="hn-booking__top">
            <legend>{{ $homeUi['where_go'] }}</legend>
            <span class="hn-live-proof"><i></i>{{ $productCopy['live'] }}</span>
          </div>
          <div class="hn-booking__fields">
            <label class="hn-location-field hn-location-field--from"><span>{{ $copy['from'] }}</span>
              <select id="hn-from-location" name="from_id" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 29)>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <button id="hn-swap-locations" class="hn-swap" type="button" aria-label="{{ $homeUi['swap'] }}" title="{{ $homeUi['swap'] }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 7h12m0 0-3-3m3 3-3 3M17 17H5m0 0 3 3m-3-3 3-3"/></svg>
            </button>
            <label class="hn-location-field hn-location-field--to"><span>{{ $copy['to'] }}</span>
              <select id="hn-to-location" name="to_id" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 417)>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <label class="hn-depart-date-field"><span>{{ $copy['date'] }}</span><input id="hn-depart-date" type="date" value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}"></label>
            <label class="hn-return-date-field"><span>{{ $copy['return_date'] }}</span><input id="hn-return-date" type="date" min="{{ now()->addDay()->toDateString() }}"></label>
            <label class="hn-passenger-field"><span>{{ $copy['passengers'] }}</span>
              <span class="hn-passenger-stepper">
                <button type="button" data-passenger-step="-1" aria-label="Decrease passengers">−</button>
                <output id="hn-passenger-count" for="hn-passenger-value">1</output>
                <button type="button" data-passenger-step="1" aria-label="Increase passengers">+</button>
              </span>
              <input id="hn-passenger-value" type="hidden" name="seats" value="1">
            </label>
            <input id="hn-depart-date-value" type="hidden" name="departDate" value="{{ now()->format('d-m-Y') }}">
            <input id="hn-return-date-value" type="hidden" name="returnDate" value="">
            <input id="hn-round-trip-value" type="hidden" name="is_round_trip" value="0">
            <input type="hidden" name="lang" value="{{ $locale }}">
            <button class="hn-button hn-button--primary hn-search-button" type="submit" data-loading="{{ $homeUi['searching'] }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m16 16 4 4"/></svg>
              <span>{{ $copy['search'] }}</span>
            </button>
          </div>
          <div class="hn-booking-tools" aria-label="{{ $bookingToolsUi['routes'] }}">
            <div class="hn-booking-tools__group">
              <span class="hn-booking-tools__label"><img src="{{ $iconAsset('img-map.png') }}" alt="" aria-hidden="true">{{ $bookingToolsUi['routes'] }}</span>
              <button class="hn-booking-tool" type="button" data-quick-route data-from="29" data-to="417" aria-pressed="true">{{ $locations[29][$locale] }} → {{ $locations[417][$locale] }}</button>
              <button class="hn-booking-tool" type="button" data-quick-route data-from="417" data-to="29" aria-pressed="false">{{ $locations[417][$locale] }} → {{ $locations[29][$locale] }}</button>
            </div>
            <div class="hn-booking-tools__group">
              <span class="hn-booking-tools__label"><img src="{{ $iconAsset('icon-calendar.png') }}" alt="" aria-hidden="true">{{ $bookingToolsUi['dates'] }}</span>
              <button class="hn-booking-tool" type="button" data-depart-offset="0" aria-pressed="true">{{ $bookingToolsUi['today'] }}</button>
              <button class="hn-booking-tool" type="button" data-depart-offset="1" aria-pressed="false">{{ $bookingToolsUi['tomorrow'] }}</button>
            </div>
            <output class="hn-booking-status" data-trip-status data-one-way="{{ $bookingToolsUi['one_way'] }}" data-round-trip="{{ $bookingToolsUi['round_trip'] }}" aria-live="polite">{{ $bookingToolsUi['one_way'] }}</output>
            <button class="hn-clear-return" type="button" data-clear-return hidden>{{ $bookingToolsUi['clear_return'] }}</button>
          </div>
          @error('route')<p class="hn-form-error" role="alert">{{ $message }}</p>@enderror
        </fieldset>
      </form>
      <ul class="hn-trust" aria-label="Service highlights">
        @foreach([$copy['trust_1'], $copy['trust_2'], $copy['trust_3']] as $item)
        <li><svg viewBox="0 0 16 16" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>{{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </section>

  <section id="route" class="hn-route-summary" aria-labelledby="route-title">
    <div class="hn-shell hn-route-summary__inner">
      <div class="hn-route-summary__route">
        <span class="hn-route-summary__icon" aria-hidden="true"><img src="{{ $iconAsset('summary/route.png') }}" alt=""></span>
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['route_kicker'] }}</p><h2 id="route-title">{{ $locations[29][$locale] }} ⇔ {{ $locations[417][$locale] }}</h2></div>
      </div>
      <dl>
        <div><span class="hn-route-stat__icon" aria-hidden="true"><img src="{{ $iconAsset('summary/wallet.png') }}" alt=""></span><div><dt>{{ $copy['from_price'] }}</dt><dd>{{ number_format($startingFare) }} VND<small class="hn-usd-hint">≈ ${{ $toUsd($startingFare) }}</small></dd></div></div>
        <div><span class="hn-route-stat__icon" aria-hidden="true"><img src="{{ $iconAsset('summary/time.png') }}" alt=""></span><div><dt>{{ $copy['duration'] }}</dt><dd>{{ $routeDuration }}</dd></div></div>
        <div><span class="hn-route-stat__icon" aria-hidden="true"><img src="{{ $iconAsset('summary/calendar.png') }}" alt=""></span><div><dt>{{ $copy['daily'] }}</dt><dd>{{ $homeUi['frequency'] }}</dd></div></div>
      </dl>
      <a class="hn-text-link" href="{{ $routeDetailsUrl }}">{{ $copy['route_details'] }} <span aria-hidden="true">→</span></a>
    </div>
  </section>

  <section id="departures" class="hn-section hn-section--mist hn-departures" aria-labelledby="departure-title" style="--hn-schedule-bg:url('{{ $routeImage }}')">
    <div class="hn-departures__hero"><div class="hn-shell"><div class="hn-departures__hero-copy"><p class="hn-eyebrow">{{ $copy['schedule_kicker'] }}</p><h2 id="departure-title"><span>{{ $scheduleUi['trips'] }}</span> <em data-departure-route>{{ $directionLabels[$selectedDirection] }}</em></h2><p>{{ $copy['schedule_text'] }}</p></div></div></div>
    <div class="hn-shell hn-departures__body">
      <div class="hn-departures__controls">
        <div class="hn-direction-tabs" role="tablist" aria-label="{{ $copy['choose_direction'] }}">@foreach($directionLabels as $direction => $label)<button id="direction-tab-{{ $direction }}" type="button" role="tab" aria-controls="direction-panel-{{ $direction }}" aria-selected="{{ $selectedDirection === $direction ? 'true' : 'false' }}" class="{{ $selectedDirection === $direction ? 'is-active' : '' }}" data-direction-tab="{{ $direction }}">{{ $label }}</button>@endforeach</div>
        <div class="hn-schedule-context"><span><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>{{ $liveTravelDateLabel }}</span><span><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3"/><path d="M3 19v-2a6 6 0 0 1 12 0v2M16 11a5 5 0 0 1 5 5v3"/></svg><b data-schedule-passengers>1</b> {{ $scheduleUi['passenger'] }}</span><a href="#booking">{{ $scheduleUi['change'] }}</a></div>
      </div>
      <div class="hn-schedule-toolbar"><div class="hn-time-filters" role="group" aria-label="{{ $copy['schedule_kicker'] }}"><button type="button" class="is-active" aria-pressed="true" data-time-filter="all">{{ $scheduleUi['all'] }}</button><button type="button" aria-pressed="false" data-time-filter="morning">{{ $scheduleUi['morning'] }}</button><button type="button" aria-pressed="false" data-time-filter="afternoon">{{ $scheduleUi['afternoon'] }}</button><button type="button" aria-pressed="false" data-time-filter="evening">{{ $scheduleUi['evening'] }}</button></div><label class="hn-schedule-sort">{{ $scheduleUi['sort'] }}<select data-schedule-sort><option value="earliest">{{ $scheduleUi['earliest'] }}</option><option value="latest">{{ $scheduleUi['latest'] }}</option><option value="lowest">{{ $scheduleUi['lowest'] }}</option></select></label></div>
      @foreach($directionSchedules as $direction => $directionTrips)
        <div id="direction-panel-{{ $direction }}" class="hn-schedule-panel" role="tabpanel" aria-labelledby="direction-tab-{{ $direction }}" data-direction-panel="{{ $direction }}" {{ $selectedDirection === $direction ? '' : 'hidden' }}>
          <div class="hn-schedule-list">
            @forelse($directionTrips as $schedule)
              @php
                $departurePoint = $schedule['pickup'] ?: ($direction === 'nt_sg' ? $locations[417][$locale] : $locations[29][$locale]);
                $arrivalPoint = $schedule['dropoff'] ?: ($direction === 'nt_sg' ? $locations[29][$locale] : $locations[417][$locale]);
                $discountPercent = max(0, (int) ($schedule['discount_percent'] ?? 0));
              @endphp
              <article class="hn-departure-card" data-departure-hour="{{ $schedule['departure']->format('G') }}" data-departure-time="{{ $schedule['departure']->format('Hi') }}" data-departure-fare="{{ $schedule['fare'] }}">
                <div class="hn-departure-card__media">
                  <img class="hn-departure-card__image" src="{{ $schedule['image'] ?: $vehicleFallbackImage }}" alt="{{ $schedule['vehicle_type'] ?: $copy['vehicle_default'] }}" loading="lazy">
                  <span class="hn-departure-card__badge {{ $discountPercent > 0 ? 'is-discount' : '' }}">{{ $discountPercent > 0 ? '-'.$discountPercent.'%' : $scheduleUi['open'] }}</span>
                  <span class="hn-departure-card__availability"><img src="{{ $iconAsset('icon-people.png') }}" alt="" aria-hidden="true">{{ $schedule['available_seats'] }} {{ $copy['seats'] }}</span>
                </div>
                <div class="hn-departure-card__details">
                  <div class="hn-departure-card__vehicle"><div><strong>{{ $schedule['vehicle_type'] ?: $copy['vehicle_default'] }}</strong><small>{{ $departurePoint }} → {{ $arrivalPoint }}</small></div><span class="hn-departure-card__duration">{{ $formatDuration($schedule['duration']) }}</span></div>
                  <div class="hn-departure-card__timeline">
                    <div class="hn-departure-card__time"><span>{{ $copy['departure'] }}</span><strong>{{ $schedule['departure']->format('H:i') }}</strong><small>{{ $departurePoint }}</small></div>
                    <div class="hn-departure-card__journey" aria-hidden="true"><span></span><i></i><svg viewBox="0 0 24 24"><path d="M4 12h16M15 7l5 5-5 5"/></svg></div>
                    <div class="hn-departure-card__time"><span>{{ $homeUi['arrival'] }}</span><strong>{{ $schedule['arrival']->format('H:i') }}</strong><small>{{ $arrivalPoint }}</small></div>
                  </div>
                  <ul class="hn-departure-card__specs">
                    <li><img src="{{ $iconAsset('icon-bed.png') }}" alt="" aria-hidden="true">{{ $scheduleUi['room'] }}</li>
                    <li><img src="{{ $iconAsset('icon-seat-small.png') }}" alt="" aria-hidden="true">{{ $scheduleUi['size'] }}</li>
                    <li><img src="{{ $iconAsset('icon-wc.png') }}" alt="" aria-hidden="true">{{ $scheduleUi['wc'] }}</li>
                  </ul>
                </div>
                <div class="hn-departure-card__purchase">
                  <div class="hn-departure-card__fare"><span>{{ $copy['price'] }}</span><strong>{{ number_format($schedule['fare']) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($schedule['fare']) }} USD</small></div>
                  <a class="hn-departure-card__action" href="{{ $schedule['checkout_url'] }}">{{ $copy['choose'] }} <span aria-hidden="true">→</span></a>
                  <small class="hn-departure-card__secure"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10V7a5 5 0 0 1 10 0v3M5 10h14v11H5z"/></svg>{{ $scheduleUi['secure'] }}</small>
                </div>
              </article>
            @empty
              <div class="hn-empty-state"><span aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/></svg></span><p>{{ $hasLiveSchedules ? $copy['no_departures'] : $copy['live_unavailable'] }}</p></div>
            @endforelse
          </div><p class="hn-schedule-filter-empty" hidden>{{ $scheduleUi['empty'] }}</p>
        </div>
      @endforeach
      <div class="hn-departures__footer"><a class="hn-button hn-button--outline" href="{{ route('schedules.index', ['lang' => $locale]) }}">{{ $homeUi['view_all'] }}</a></div>
    </div>
  </section>

  <section class="hn-section hn-fleet" aria-labelledby="fleet-title" style="--hn-fleet-left:url('{{ $vehicleFallbackImage }}');--hn-fleet-right:url('{{ $routeImage }}')">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--split">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $productCopy['fleet_kicker'] }}</p><h2 id="fleet-title">{{ $productCopy['fleet_title'] }}</h2><p>{{ $productCopy['fleet_text'] }}</p></div>
        <aside class="hn-fleet-context"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18M8 14h2M12 14h2M16 14h2M8 18h2M12 18h2"/></svg><div><strong>{{ $directionLabels[$selectedDirection] }}</strong><span>{{ $liveTravelDateLabel }} · <b data-fleet-passengers>1</b> {{ $fleetUi['guest'] }}</span></div><a href="#booking">{{ $fleetUi['change'] }}</a></aside>
      </div>
      <div class="hn-vehicle-grid {{ $fleetTrips->count() <= 1 ? 'hn-vehicle-grid--single' : '' }}">
        @forelse($fleetTrips as $trip)
          <article class="hn-vehicle-card">
            <div class="hn-vehicle-card__media">
              <img src="{{ $trip['image'] ?: $vehicleFallbackImage }}" alt="{{ $trip['vehicle_type'] }}" loading="lazy">
              <span><i></i>{{ $productCopy['actual_vehicle'] }}</span>
              <b class="hn-vehicle-card__image-detail">{{ $fleetUi['detail'] }} →</b>
            </div>
            <div class="hn-vehicle-card__body">
              <p class="hn-vehicle-card__route">{{ $directionLabels[$selectedDirection] }}</p>
              <h3>{{ $trip['vehicle_type'] }}</h3>
               <p class="hn-vehicle-card__comfort">{{ $fleetUi['comfort'] }}</p>
               <ul class="hn-vehicle-amenities">@foreach($fleetAmenityIndexes as $amenityIndex)<li><span class="hn-amenity-icon" aria-hidden="true">{!! $amenityIcons[$amenityIndex] !!}</span>{{ $homeUi['amenities'][$amenityIndex] }}</li>@endforeach</ul>
               @php $tabsId = 'home-trip-tabs-'.$loop->index; @endphp
               @include('home.trip-info-tabs')
              <dl>
                <div><dt>{{ $copy['departure'] }}</dt><dd>{{ $trip['departure']->format('H:i') }}</dd></div>
                <div><dt>{{ $homeUi['travel_time'] }}</dt><dd>{{ $formatDuration($trip['duration'] ?? 0) }}</dd></div>
                <div><dt>{{ $homeUi['remaining'] }}</dt><dd>{{ $trip['available_seats'] }} {{ $copy['seats'] }}</dd></div>
              </dl>
              <footer><div><small>{{ $copy['price'] }}</small><strong>{{ number_format($trip['fare']) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($trip['fare']) }}</small></div><a class="hn-vehicle-card__select" href="{{ $trip['checkout_url'] }}">{{ $copy['choose'] }} <b>→</b></a></footer>
            </div>
          </article>
        @empty
          <article class="hn-vehicle-card"><div class="hn-vehicle-card__media"><img src="{{ $vehicleFallbackImage }}" alt="{{ $copy['vehicle_default'] }}" loading="lazy"><span><i></i>{{ $productCopy['actual_vehicle'] }}</span><b class="hn-vehicle-card__image-detail">{{ $fleetUi['detail'] }} →</b></div><div class="hn-vehicle-card__body"><p class="hn-vehicle-card__route">{{ $directionLabels[$selectedDirection] }}</p><h3>{{ $copy['vehicle_default'] }}</h3><p class="hn-vehicle-card__comfort">{{ $fleetUi['comfort'] }}</p><ul class="hn-vehicle-amenities">@foreach($fleetAmenityIndexes as $amenityIndex)<li><span class="hn-amenity-icon" aria-hidden="true">{!! $amenityIcons[$amenityIndex] !!}</span>{{ $homeUi['amenities'][$amenityIndex] }}</li>@endforeach</ul><p class="hn-vehicle-card__note">{{ $copy['daily'] }}</p><footer><div><small>{{ $copy['price'] }}</small><strong>{{ number_format($startingFare) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($startingFare) }}</small></div><a class="hn-vehicle-card__select" href="#booking">{{ $copy['search'] }} <b>→</b></a></footer></div></article>
        @endforelse
      </div>
    </div>
  </section>

  <section class="hn-proof" aria-labelledby="assurance-title">
    <div class="hn-shell">
      <header class="hn-proof__heading"><div><p class="hn-eyebrow">{{ $assuranceUi['kicker'] }}</p><h2 id="assurance-title">{{ $homeUi['assurance'] }}</h2></div><p>{{ $assuranceUi['intro'] }}</p></header>
      <div class="hn-proof__body">
        <div class="hn-proof__grid">
          @foreach([[$productCopy['seat_map'], $productCopy['seat_map_text']], [$productCopy['stops'], $productCopy['stops_text']], [$productCopy['payment'], $productCopy['payment_text']]] as $index => [$title, $text])
            <article><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><i class="hn-proof__visual">{!! $proofIcons[$index] !!}</i><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></article>
          @endforeach
        </div>
        <p class="hn-proof__transfer"><img src="{{ $iconAsset('shuttle-3d.png') }}" alt="" aria-hidden="true"><strong>{{ $productCopy['transfer'] }}</strong><a href="{{ route('schedules.index', ['lang' => $locale]) }}">{{ $homeUi['view_all'] }} →</a></p>
      </div>
    </div>
  </section>

  <section id="pickup" class="hn-section hn-stops" aria-labelledby="stops-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--split">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['pickup_kicker'] }}</p><h2 id="stops-title">{{ $copy['pickup_title'] }}</h2></div>
        <p>{{ $copy['pickup_text'] }}</p>
      </div>
      <div class="hn-stops__grid">
        @foreach($offices as $office)
          <article class="hn-stop-card">
            <div class="hn-stop-card__head"><img class="hn-stop-card__pin" src="{{ $officePins[$loop->index] }}" alt="" aria-hidden="true"><div><span>{{ $officeLabels['label'] }}</span><h3>{{ $office['name'] }}</h3></div></div>
            <p>{{ $office['address'] }}</p>
            <a href="https://www.google.com/maps/search/?api=1&amp;query={{ rawurlencode($office['address']) }}" target="_blank" rel="noopener">{{ $homeUi['map'] }} →</a>
            <div class="hn-stop-card__photo" aria-hidden="true"><img src="{{ $officeImages[$loop->index] }}" alt="" loading="lazy"></div>
          </article>
        @endforeach
        <aside class="hn-stop-support"><div><p>{{ $pickupLabels['support'] }}</p><strong>1900 2879</strong></div><div><div class="hn-stop-support__phones">@foreach($supportPhones as $phone)<a href="tel:{{ str_replace('.', '', $phone) }}">{{ $phone }}</a>@endforeach</div><span>{{ $pickupLabels['support_text'] }}</span></div><a class="hn-button hn-button--gold" href="{{ $supportHref }}">{{ $homeUi['call'] }}</a></aside>
      </div>
    </div>
  </section>

  <section class="hn-why" aria-labelledby="why-title">
    <div class="hn-shell hn-why__inner">
      <div class="hn-why__intro">
        <p class="hn-eyebrow">{{ $whyChoose['kicker'] }}</p>
        <h2 id="why-title"><span>{{ $whyChoose['title_before'] }}</span><em>{{ $whyChoose['title_accent'] }}</em><span>{{ $whyChoose['title_after'] }}</span></h2>
        <p class="hn-why__lead">{{ $whyChoose['text'] }}</p>
        <div class="hn-why__signature" aria-hidden="true">{!! implode('<br>', array_map('e', $whyChoose['signature'])) !!}</div>
        <div class="hn-why__bus" aria-hidden="true"><img src="{{ $vehicleFallbackImage }}" alt=""></div>
      </div>
      <div class="hn-why__grid">
        @foreach($whyChoose['items'] as $index => [$title, $description])
          <article class="hn-why__card">
            <div class="hn-why__photo" aria-hidden="true"><img src="{{ $whyImages[$index] }}" alt="" loading="lazy"></div>
            <div class="hn-why__fade" aria-hidden="true"></div>
            <div class="hn-why__content">
              <div class="hn-why__number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
              <i class="hn-why__icon">{!! $whyIcons[$index] !!}</i>
              <h3>{{ $title }}</h3>
              <p>{{ $description }}</p>
              <span class="hn-why__arrow" aria-hidden="true">→</span>
            </div>
            @if($index === 2)<span class="hn-why__badge">7 km</span>@endif
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section id="help" class="hn-section hn-shell" aria-labelledby="faq-title" style="--hn-faq-bg:url('{{ $vehicleFallbackImage }}')">
    <div class="hn-faq-layout">
      <div class="hn-faq-intro">
        <div class="hn-section-heading"><p class="hn-eyebrow hn-eyebrow--green">{{ $faqUi['kicker'] }}</p><h2 id="faq-title"><span>{{ $copy['faq_title'] }}</span></h2><p class="hn-faq-intro__text">{{ $faqUi['intro'] }}</p></div>
        <span class="hn-faq-background-signature" aria-hidden="true">{!! implode('<br>', array_map('e', $whyChoose['signature'])) !!}</span>
      </div>
      <div class="hn-faq">
        @foreach($faqItems as $index => [$question, $answer])
        <details><summary><span class="hn-faq__icon" aria-hidden="true">{!! $faqIcons[$index] !!}</span><b>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</b><strong>{{ $question }}</strong></summary><p>{{ $answer }}</p></details>
        @endforeach
      </div>
    </div>
  </section>

  @if($latestPosts->isNotEmpty())
  <section class="hn-section hn-section--mist hn-news" aria-labelledby="news-title" style="--hn-news-coast:url('{{ $routeImage }}');--hn-news-bus:url('{{ $vehicleFallbackImage }}')">
    <div class="hn-shell">
      <div class="hn-section-heading hn-news-heading">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['news_kicker'] }}</p><h2 id="news-title"><span>{{ $newsUi['title_before'] }}</span><em>{{ $newsUi['title_accent'] }}</em></h2><p>{{ $copy['news_text'] }}</p></div>
        <a class="hn-button hn-button--primary" href="{{ route('posts.index', ['lang' => $locale]) }}">{{ $copy['read_news'] }}</a>
      </div>
      <div class="hn-news-grid">
        @foreach($latestPosts as $post)
        <article class="hn-news-card">
          <a class="hn-news-card__image" href="{{ route('posts.show', ['slug' => $post->slug, 'lang' => $locale]) }}" aria-label="{{ $post->title }}">
            @if($post->thumbnail)
            <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}" loading="lazy">
            @else
            <span>{{ $post->category?->name ?? $copy['news_kicker'] }}</span>
            @endif
          </a>
          <div class="hn-news-card__body">
            <p>{{ $post->published_at?->format('d/m/Y') }}@if($post->category) <span>{{ $post->category->name }}</span>@endif</p>
            <h3><a href="{{ route('posts.show', ['slug' => $post->slug, 'lang' => $locale]) }}">{{ $post->title }}</a></h3>
            @if($post->summary)<div>{{ $post->summary }}</div>@endif
            <a class="hn-news-card__link" href="{{ route('posts.show', ['slug' => $post->slug, 'lang' => $locale]) }}">{{ $copy['read_article'] }}</a>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <section class="hn-final" aria-labelledby="final-title" style="--hn-final-bg:url('{{ $vehicleFallbackImage }}')">
    <div class="hn-shell hn-final__content"><span class="hn-final__signature" aria-hidden="true">{!! $newsUi['signature'] !!}</span><div><h2 id="final-title">{{ $copy['final_title'] }}</h2><p>{{ $copy['final_text'] }}</p></div><div><a class="hn-button hn-button--gold" href="#booking">{{ $copy['book'] }}</a><a class="hn-contact" href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['contact'] }}</a></div></div>
  </section>
</main>

<a class="hn-support-float" href="{{ $supportHref }}" aria-label="{{ $productCopy['support_call'] }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h3l1.5 4-2.2 1.6a14 14 0 0 0 6.8 6.8L17.7 13l4 1.5v3c0 1.1-.9 2-2 2C10.5 19.5 4.5 13.5 4.5 4.3c0-.7.5-1.3 1.2-1.3H7Z"/></svg><span>{{ $productCopy['support_online'] }}</span></a>
<nav class="hn-mobile-booking-bar" aria-label="Booking actions"><a href="#booking">{{ $copy['book'] }}</a><a href="{{ $supportHref }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h3l1.5 4-2.2 1.6a14 14 0 0 0 6.8 6.8L17.7 13l4 1.5v3c0 1.1-.9 2-2 2C10.5 19.5 4.5 13.5 4.5 4.3c0-.7.5-1.3 1.2-1.3H7Z"/></svg>{{ $homeUi['call'] }}</a></nav>

<footer class="hn-footer"><div class="hn-shell"><span>© {{ now()->year }} Nhat Duong</span><span>{{ $copy['footer'] }}</span></div></footer>

<script>
  (() => {
    const form = document.querySelector('.hn-booking');
    const menuButton = document.querySelector('.hn-menu-button');
    const mobileNav = document.getElementById('hn-mobile-nav');

    if (menuButton && mobileNav) {
      menuButton.addEventListener('click', () => {
        const expanded = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', String(!expanded));
        mobileNav.hidden = expanded;
      });

      mobileNav.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
        menuButton.setAttribute('aria-expanded', 'false');
        mobileNav.hidden = true;
      }));
    }

    const directionTabs = [...document.querySelectorAll('[data-direction-tab]')];
    const directionPanels = [...document.querySelectorAll('[data-direction-panel]')];
    directionTabs.forEach((tab) => tab.addEventListener('click', () => {
      const direction = tab.dataset.directionTab;
      directionTabs.forEach((item) => {
        const active = item === tab;
        item.classList.toggle('is-active', active);
        item.setAttribute('aria-selected', String(active));
      });
      directionPanels.forEach((panel) => { panel.hidden = panel.dataset.directionPanel !== direction; });
      const routeTitle = document.querySelector('[data-departure-route]');
      if (routeTitle) routeTitle.textContent = tab.textContent.trim();
      window.applyScheduleControls?.();
    }));

    const timeFilters = [...document.querySelectorAll('[data-time-filter]')];
    const scheduleSort = document.querySelector('[data-schedule-sort]');
    window.applyScheduleControls = () => {
      const activeFilter = document.querySelector('[data-time-filter].is-active')?.dataset.timeFilter || 'all';
      const sort = scheduleSort?.value || 'earliest';
      directionPanels.forEach((panel) => {
        const list = panel.querySelector('.hn-schedule-list');
        if (!list) return;
        const cards = [...list.querySelectorAll('.hn-departure-card')];
        cards.sort((a, b) => sort === 'lowest'
          ? Number(a.dataset.departureFare) - Number(b.dataset.departureFare)
          : (sort === 'latest' ? -1 : 1) * (Number(a.dataset.departureTime) - Number(b.dataset.departureTime)));
        let matchingCards = 0;
        cards.forEach((card) => {
          list.appendChild(card);
          const hour = Number(card.dataset.departureHour);
          const matches = activeFilter === 'morning' ? hour >= 5 && hour < 12
            : activeFilter === 'afternoon' ? hour >= 12 && hour < 18
            : activeFilter === 'evening' ? hour >= 18 || hour < 5
            : true;
          card.hidden = !matches || matchingCards >= 6;
          if (matches) matchingCards += 1;
        });
        const empty = panel.querySelector('.hn-schedule-filter-empty');
        if (empty) empty.hidden = matchingCards > 0;
      });
    };
    timeFilters.forEach((button) => button.addEventListener('click', () => {
      timeFilters.forEach((item) => {
        const active = item === button;
        item.classList.toggle('is-active', active);
        item.setAttribute('aria-pressed', String(active));
      });
      window.applyScheduleControls();
    }));
    scheduleSort?.addEventListener('change', window.applyScheduleControls);
    window.applyScheduleControls();
    directionTabs.forEach((tab, index) => tab.addEventListener('keydown', (event) => {
      if (!['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
      event.preventDefault();
      const nextIndex = event.key === 'ArrowRight' ? (index + 1) % directionTabs.length : (index - 1 + directionTabs.length) % directionTabs.length;
      directionTabs[nextIndex].focus();
      directionTabs[nextIndex].click();
    }));

    document.querySelectorAll('.hn-vehicle-card').forEach((card) => {
      const tabs = [...card.querySelectorAll('[data-amenity-filter]')];
      const amenities = [...card.querySelectorAll('[data-amenity-group]')];
      tabs.forEach((tab) => tab.addEventListener('click', () => {
        const filter = tab.dataset.amenityFilter;
        tabs.forEach((item) => {
          const active = item === tab;
          item.classList.toggle('is-active', active);
          item.setAttribute('aria-pressed', String(active));
        });
        amenities.forEach((amenity) => {
          amenity.hidden = filter === 'featured'
            ? amenity.dataset.amenityFeatured !== 'true'
            : filter !== 'all' && amenity.dataset.amenityGroup !== filter;
        });
      }));
    });

    document.querySelectorAll('[data-trip-info]').forEach((info) => {
      const tabs = [...info.querySelectorAll('[data-trip-tab]')];
      const panels = info.querySelector('.trip-panels');
      let loading = false;
      let requestedTab = 'discount';
      const activate = (name) => {
        tabs.forEach((tab) => {
          const active = tab.dataset.tripTab === name;
          tab.classList.toggle('is-active', active);
          tab.setAttribute('aria-selected', String(active));
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
        if (info.dataset.loaded === 'true') return activate(name);
        if (name === 'discount' || loading) return activate(name);
        loading = true;
        panels.innerHTML = `<p class="trip-loading" role="status">${info.dataset.loadingLabel}</p>`;
        try {
          const response = await fetch(info.dataset.url, {headers:{Accept:'application/json','X-Requested-With':'XMLHttpRequest'}});
          if (!response.ok) throw new Error(`HTTP ${response.status}`);
          panels.innerHTML = (await response.json()).html;
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

    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window) {
      const revealItems = [...document.querySelectorAll('.hn-route-summary__inner,.hn-section-heading,.hn-departure-card,.hn-vehicle-card,.hn-proof__grid article,.hn-stop-card,.hn-stop-support,.hn-why__grid article,.hn-faq details,.hn-news-card,.hn-final__content')];
      document.body.classList.add('hn-motion-ready');
      revealItems.forEach((item, index) => {
        item.classList.add('hn-reveal');
        item.style.setProperty('--hn-reveal-delay', `${(index % 4) * 55}ms`);
      });
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
          window.setTimeout(() => {
            entry.target.classList.remove('hn-reveal', 'is-visible');
            entry.target.style.removeProperty('--hn-reveal-delay');
          }, 800);
        });
      }, { threshold:0.12, rootMargin:'0px 0px -28px' });
      revealItems.forEach((item) => revealObserver.observe(item));
    }

    if (!form) return;

    const mobileBookingBar = document.querySelector('.hn-mobile-booking-bar');
    if (mobileBookingBar && 'IntersectionObserver' in window) {
      const setBookingBarVisibility = (formVisible) => {
        mobileBookingBar.classList.toggle('is-form-visible', formVisible);
        mobileBookingBar.setAttribute('aria-hidden', String(formVisible));
      };
      const formRect = form.getBoundingClientRect();
      setBookingBarVisibility(formRect.bottom > 0 && formRect.top < window.innerHeight);
      new IntersectionObserver(([entry]) => setBookingBarVisibility(entry.isIntersecting), {
        threshold:0,
        rootMargin:'0px 0px -72px',
      }).observe(form);
    }

    const depart = document.getElementById('hn-depart-date');
    const departValue = document.getElementById('hn-depart-date-value');
    const returnDate = document.getElementById('hn-return-date');
    const returnDateValue = document.getElementById('hn-return-date-value');
    const roundTripValue = document.getElementById('hn-round-trip-value');
    const fromLocation = document.getElementById('hn-from-location');
    const toLocation = document.getElementById('hn-to-location');
    const swapLocations = document.getElementById('hn-swap-locations');
    const passengerValue = document.getElementById('hn-passenger-value');
    const passengerCount = document.getElementById('hn-passenger-count');
    const quickRouteButtons = [...form.querySelectorAll('[data-quick-route]')];
    const departShortcutButtons = [...form.querySelectorAll('[data-depart-offset]')];
    const tripStatus = form.querySelector('[data-trip-status]');
    const clearReturn = form.querySelector('[data-clear-return]');
    const formatDate = (value) => value ? value.split('-').reverse().join('-') : '';
    const dateInputValue = (date) => [date.getFullYear(), String(date.getMonth() + 1).padStart(2, '0'), String(date.getDate()).padStart(2, '0')].join('-');
    const dateFromToday = (offset) => {
      const date = new Date();
      date.setHours(0, 0, 0, 0);
      date.setDate(date.getDate() + offset);
      return dateInputValue(date);
    };
    const syncToolStates = () => {
      quickRouteButtons.forEach((button) => button.setAttribute('aria-pressed', String(button.dataset.from === fromLocation.value && button.dataset.to === toLocation.value)));
      departShortcutButtons.forEach((button) => button.setAttribute('aria-pressed', String(depart.value === dateFromToday(Number(button.dataset.departOffset)))));
      const isRoundTrip = Boolean(returnDate.value);
      tripStatus.textContent = isRoundTrip ? tripStatus.dataset.roundTrip : tripStatus.dataset.oneWay;
      clearReturn.hidden = !isRoundTrip;
    };

    const syncDates = () => {
      departValue.value = formatDate(depart.value);
      const minimumReturn = new Date(`${depart.value}T00:00:00`);
      minimumReturn.setDate(minimumReturn.getDate() + 1);
      returnDate.min = dateInputValue(minimumReturn);
      if (returnDate.value && returnDate.value < returnDate.min) returnDate.value = returnDate.min;
      returnDateValue.value = formatDate(returnDate.value);
      roundTripValue.value = returnDate.value ? '1' : '0';
      syncToolStates();
    };

    depart.addEventListener('change', syncDates);
    returnDate.addEventListener('change', syncDates);
    quickRouteButtons.forEach((button) => button.addEventListener('click', () => {
      fromLocation.value = button.dataset.from;
      fromLocation.dispatchEvent(new Event('change'));
      toLocation.value = button.dataset.to;
      toLocation.dispatchEvent(new Event('change'));
    }));
    departShortcutButtons.forEach((button) => button.addEventListener('click', () => {
      depart.value = dateFromToday(Number(button.dataset.departOffset));
      syncDates();
    }));
    clearReturn.addEventListener('click', () => {
      returnDate.value = '';
      syncDates();
      returnDate.focus();
    });
    swapLocations.addEventListener('click', () => {
      const previousFrom = fromLocation.value;
      fromLocation.value = toLocation.value;
      toLocation.value = previousFrom;
      fromLocation.dispatchEvent(new Event('change'));
    });
    form.querySelectorAll('[data-passenger-step]').forEach((button) => button.addEventListener('click', () => {
      const value = Math.min(6, Math.max(1, Number(passengerValue.value) + Number(button.dataset.passengerStep)));
      passengerValue.value = String(value);
      passengerCount.value = String(value);
      document.querySelectorAll('[data-fleet-passengers]').forEach((label) => label.textContent = String(value));
      document.querySelectorAll('[data-schedule-passengers]').forEach((label) => label.textContent = String(value));
    }));
    fromLocation.addEventListener('change', () => {
      [...toLocation.options].forEach((option) => option.disabled = option.value === fromLocation.value);
      if (toLocation.value === fromLocation.value) {
        toLocation.selectedIndex = [...toLocation.options].findIndex((option) => !option.disabled);
      }
      syncToolStates();
    });
    toLocation.addEventListener('change', syncToolStates);
    form.addEventListener('submit', () => {
      syncDates();
      const submit = form.querySelector('[type=submit]');
      submit.setAttribute('aria-busy', 'true');
      submit.querySelector('span').textContent = submit.dataset.loading;
    });
    syncDates();
    fromLocation.dispatchEvent(new Event('change'));
  })();
</script>
</body>
</html>
