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
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  :root { --hn-green:#0b7f42; --hn-deep:#062d1c; --hn-gold:#fbb116; --hn-ink:#18332a; --hn-muted:#62766c; --hn-mist:#f5f9f5; --hn-line:#d9e5dc; }
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
  body.home-new { --hn-green:#0b7f42; --hn-green-dark:#075d35; --hn-deep:#062d1c; --hn-gold:#fbb116; --hn-ink:#18332a; --hn-muted:#607269; --hn-mist:#f4f8f4; --hn-line:#d8e5dc; padding-bottom:0; color:var(--hn-ink); }
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
  .hn-hero-title__specs { display:block; color:#f8cb5c; font-size:.58em; line-height:1.2; letter-spacing:-.025em; }
  .hn-hero__copy>.hn-hero-tagline { display:flex; align-items:center; gap:11px; max-width:560px; margin:0; color:rgba(255,255,255,.88); font-size:16px; line-height:1.6; }
  .hn-hero-tagline:before { width:30px; height:2px; flex:none; background:var(--hn-gold); content:''; }
  body.home-new .hn-hero__copy>p.hn-official-site { display:inline-flex; align-items:center; gap:9px; margin:17px 0 0; padding:9px 13px; color:#16442e; background:#fff; border:1px solid rgba(255,255,255,.7); border-radius:10px; box-shadow:0 9px 24px rgba(0,0,0,.14); font-size:16px; font-weight:800; line-height:1.45; }
  .hn-official-site svg { width:19px; height:19px; flex:none; color:var(--hn-green); fill:#e2f4e7; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
  .hn-official-site strong { color:var(--hn-green); }
  .hn-booking { margin-top:28px; border:1px solid rgba(255,255,255,.25); border-radius:18px; }
  .hn-booking fieldset { padding:18px 20px 20px; }
  .hn-booking__top { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:12px; }
  .hn-booking legend { padding:0; font-family:'Be Vietnam Pro',Inter,sans-serif; font-size:16px; font-weight:800; }
  .hn-live-proof { margin:0!important; color:#326044!important; background:#eef8f0; border-color:#d4ead9; }
  .hn-live-proof i { background:var(--hn-green); box-shadow:0 0 0 4px rgba(11,127,66,.12); }
  .hn-booking__fields { display:grid; grid-template-columns:minmax(150px,1.05fr) 44px minmax(150px,1.05fr) minmax(150px,.75fr) minmax(120px,.55fr) auto; gap:10px; align-items:end; }
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
  #hn-depart-date { width:140px; }
  .hn-swap { display:grid; width:44px; height:48px; place-items:center; padding:0; color:var(--hn-green); background:#eef8f0; border:1px solid #cfe4d5; border-radius:9px; cursor:pointer; }
  .hn-swap:hover { background:#dff2e4; }
  .hn-swap svg,.hn-search-button svg { width:19px; height:19px; fill:none; stroke:currentColor; stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
  .hn-passenger-stepper { display:grid; grid-template-columns:42px 1fr 42px; min-height:48px; overflow:hidden; border:1px solid var(--hn-line); border-radius:9px; }
  .hn-passenger-stepper button { min-width:42px; padding:0; color:var(--hn-green); background:#f1f7f2; border:0; font-size:20px; font-weight:800; cursor:pointer; }
  .hn-passenger-stepper output { display:grid; place-items:center; color:var(--hn-deep); background:#fff; font-size:14px; font-weight:800; }
  .hn-search-button { gap:8px; min-width:132px; }
  .hn-search-button[aria-busy=true] { opacity:.78; cursor:wait; }
  .hn-section { padding:76px 0; }
  .hn-section-heading { margin-bottom:28px; }
  .hn-section-heading--split { display:flex; align-items:end; justify-content:space-between; gap:36px; max-width:none; }
  .hn-section-heading--split>div { max-width:720px; }
  .hn-section-heading--split>p { max-width:390px; margin:0 0 5px; color:var(--hn-muted); line-height:1.65; }
  .hn-route-summary { padding:32px 0; background:#fff; border-bottom:1px solid var(--hn-line); }
  .hn-route-summary__inner { display:grid; grid-template-columns:1.15fr 1.5fr auto; gap:30px; align-items:center; }
  .hn-route-summary .hn-eyebrow { margin-bottom:7px; }
  .hn-route-summary h2 { margin:0; font-size:clamp(24px,3vw,34px); }
  .hn-route-summary dl { display:grid; grid-template-columns:repeat(3,1fr); margin:0; }
  .hn-route-summary dl div { padding:5px 22px; border-left:1px solid var(--hn-line); }
  .hn-route-summary dt { color:var(--hn-muted); font-size:11px; font-weight:700; }
  .hn-route-summary dd { margin:5px 0 0; color:var(--hn-deep); font-size:15px; font-weight:800; }
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
  .hn-vehicle-card__route { margin:0 0 8px; color:var(--hn-green); font-size:10px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
  .hn-vehicle-card h3 { margin:0; color:var(--hn-deep); font-size:clamp(20px,2.1vw,27px); line-height:1.25; letter-spacing:-.025em; }
  .hn-vehicle-card__comfort { margin:18px 0 8px; color:var(--hn-muted); font-size:10px; font-weight:800; text-transform:uppercase; }
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
  .hn-review { display:block; padding:76px 0; }
  .hn-review__inner { display:grid; grid-template-columns:1.1fr .9fr; gap:70px; align-items:center; }
  .hn-review__quote { padding:32px; }
  .hn-review__stars { margin-bottom:16px; color:#b67d00; letter-spacing:.15em; }
  .hn-review blockquote { font-size:20px; }
  .hn-faq details { padding:0; }
  .hn-faq summary { display:flex; align-items:center; justify-content:space-between; min-height:60px; padding:14px 0; list-style:none; }
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
    .hn-route-summary dl div:first-child { border-left:0; padding-left:0; }
    .hn-departure-card { grid-template-columns:80px 1fr 1fr; }
    .hn-departure-card__journey { display:none; }
    .hn-departure-card__fare { text-align:right; }
    .hn-departure-card__action { grid-column:2/4; }
    .hn-fleet__grid { grid-template-columns:repeat(2,1fr); }
    .hn-vehicle-grid--single .hn-vehicle-card { grid-template-columns:1fr 1fr; grid-template-rows:minmax(390px,auto); }
    .hn-stops__grid { grid-template-columns:1fr 1fr; }
    .hn-stop-support { grid-column:1/-1; min-height:auto; }
    .hn-review__inner { grid-template-columns:1fr; gap:32px; }
    .hn-proof>.hn-shell { grid-template-columns:1fr; gap:6px; }
    .hn-proof>.hn-shell>.hn-eyebrow { padding-top:0; }
  }
  @media(max-width:620px) {
    body.home-new { padding-bottom:72px; }
    .hn-header { position:sticky; }
    .hn-actions .hn-button { display:none; }
    .hn-hero { min-height:auto; }
    .hn-hero__content { padding:46px 0 28px; }
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
    .hn-trust { gap:9px 14px; font-size:11px; }
    .hn-section { padding:54px 0; }
    .hn-section-heading--split { align-items:flex-start; flex-direction:column; gap:12px; }
    .hn-route-summary { padding:26px 0; }
    .hn-route-summary dl { grid-template-columns:1fr 1fr; }
    .hn-route-summary dl div { padding:8px 14px; }
    .hn-route-summary dl div:nth-child(odd) { padding-left:0; border-left:0; }
    .hn-route-summary dl div:last-child { grid-column:1/-1; padding-top:14px; border-top:1px solid var(--hn-line); }
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
    .hn-review { padding:54px 0; }
    .hn-review__quote { padding:26px 21px; }
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
  .hn-trip-info .trip-price-save { grid-column:1/-1; display:flex!important; align-items:center; gap:8px; padding:8px 10px; border-radius:9px; background:#fff4d8; }
  .hn-trip-info .trip-price-save b { color:#b76b00; font-size:16px; }
  .hn-trip-info .trip-price-save span { color:#75551d; text-transform:none; }
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
</head>
<body class="home-new">
@php
  $copy = [
    'vi' => [
      'nav_routes' => 'Tuyến xe', 'nav_schedule' => 'Lịch chạy', 'nav_news' => 'Tin tức', 'nav_about' => 'Về chúng tôi', 'nav_contact' => 'Liên hệ',
      'book' => 'Đặt vé', 'hero_kicker' => 'Sài Gòn ⇄ Nha Trang', 'hero_title' => 'Limousine Luxury • 22 phòng • WC trên xe',
      'hero_text' => 'Không gian thoải mái – dịch vụ tận tâm', 'official_site' => 'Website chính thức của Nhà xe Nhật Dương', 'one_way' => 'Một chiều', 'round_trip' => 'Khứ hồi',
      'from' => 'Điểm đi', 'to' => 'Điểm đến', 'date' => 'Ngày đi', 'passengers' => 'Số khách', 'search' => 'Tìm chuyến',
      'trust_1' => 'Xác nhận đặt vé', 'trust_2' => 'Xe phòng tiện nghi', 'trust_3' => 'Thông tin rõ ràng',
      'route_kicker' => 'Tuyến phổ biến', 'route_title' => 'Chuyến đi được chuẩn bị cho hành trình dài', 'from_price' => 'Giá từ', 'duration' => 'Thời gian đi',
       'view_departures' => 'Xem giờ khởi hành', 'route_details' => 'Xem chi tiết tuyến', 'daily' => 'Khởi hành mỗi ngày', 'luggage' => 'Hành lý theo quy định', 'support' => 'Hỗ trợ đặt vé',
      'schedule_kicker' => 'Chọn giờ phù hợp', 'schedule_title' => 'Các giờ khởi hành hằng ngày', 'schedule_text' => 'Giờ chạy, loại xe và giá vé được hiển thị trước khi bạn đặt.',
       'departure' => 'Khởi hành', 'vehicle' => 'Loại xe', 'vehicle_default' => 'Xe phòng', 'price' => 'Giá vé', 'seats' => 'chỗ còn lại', 'choose' => 'Chọn chuyến', 'choose_direction' => 'Chọn chiều đi', 'live_unavailable' => 'Lịch chạy trực tuyến đang tạm thời không khả dụng.', 'no_departures' => 'Chưa có chuyến mở bán cho chiều này hôm nay.',
      'pickup_kicker' => 'Điểm đón & trả khách', 'pickup_title' => 'Lên xe đúng điểm, đúng giờ', 'pickup_text' => 'Địa chỉ đón, trả được hiển thị rõ ràng. Vui lòng liên hệ hỗ trợ để xác nhận thời gian có mặt trước chuyến đi.',
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
      'from' => 'From', 'to' => 'To', 'date' => 'Departure date', 'passengers' => 'Passengers', 'search' => 'Find departures',
      'trust_1' => 'Booking confirmation', 'trust_2' => 'Comfortable sleeper cabin', 'trust_3' => 'Clear trip details',
      'route_kicker' => 'Popular route', 'route_title' => 'Prepared for a comfortable long-distance journey', 'from_price' => 'From', 'duration' => 'Travel time',
       'view_departures' => 'View departures', 'route_details' => 'View route details', 'daily' => 'Daily departures', 'luggage' => 'Luggage policy available', 'support' => 'Booking support',
      'schedule_kicker' => 'Choose a suitable time', 'schedule_title' => 'Available daily departures', 'schedule_text' => 'Departure time, vehicle type, and fare are visible before you book.',
       'departure' => 'Departure', 'vehicle' => 'Vehicle', 'vehicle_default' => 'Sleeper cabin', 'price' => 'Fare', 'seats' => 'seats remaining', 'choose' => 'Select departure', 'choose_direction' => 'Choose direction', 'live_unavailable' => 'Live departures are temporarily unavailable.', 'no_departures' => 'No departures are on sale for this direction today.',
      'pickup_kicker' => 'Pickup & drop-off', 'pickup_title' => 'Meet your bus at the right place', 'pickup_text' => 'Pickup and drop-off addresses are clearly listed. Contact support to confirm your check-in time before departure.',
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
      'from' => 'Откуда', 'to' => 'Куда', 'date' => 'Дата поездки', 'passengers' => 'Пассажиры', 'search' => 'Найти рейсы',
      'trust_1' => 'Подтверждение бронирования', 'trust_2' => 'Комфортный спальный салон', 'trust_3' => 'Понятные условия поездки',
      'route_kicker' => 'Популярный маршрут', 'route_title' => 'Всё подготовлено для комфортной дальней поездки', 'from_price' => 'Цена от', 'duration' => 'Время в пути',
       'view_departures' => 'Посмотреть рейсы', 'route_details' => 'Подробнее о маршруте', 'daily' => 'Рейсы каждый день', 'luggage' => 'Правила багажа доступны', 'support' => 'Помощь с бронированием',
      'schedule_kicker' => 'Выберите удобное время', 'schedule_title' => 'Ежедневные рейсы', 'schedule_text' => 'Время отправления, тип автобуса и цена видны до бронирования.',
       'departure' => 'Отправление', 'vehicle' => 'Автобус', 'vehicle_default' => 'Спальный салон', 'price' => 'Цена', 'seats' => 'мест осталось', 'choose' => 'Выбрать рейс', 'choose_direction' => 'Выберите направление', 'live_unavailable' => 'Актуальное расписание временно недоступно.', 'no_departures' => 'Сегодня рейсы в этом направлении ещё не открыты для продажи.',
      'pickup_kicker' => 'Посадка и высадка', 'pickup_title' => 'Садитесь в автобус в нужном месте', 'pickup_text' => 'Адреса посадки и высадки указаны ниже. Свяжитесь с поддержкой, чтобы уточнить время прибытия до отправления.',
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
    [$copy['faq_1_q'], $copy['faq_1_a']],
    [$copy['faq_2_q'], $copy['faq_2_a']],
    [$copy['faq_3_q'], $copy['faq_3_a']],
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
      $homeUi = [
    'vi' => ['where_go' => 'Bạn muốn đi đâu?', 'swap' => 'Đổi chiều', 'live_date' => 'Chuyến đang mở bán', 'today' => 'Hôm nay', 'frequency' => 'Đa dạng các khung giờ', 'arrival' => 'Đến', 'travel_time' => 'Thời gian', 'remaining' => 'Còn', 'view_all' => 'Xem tất cả giờ chạy', 'amenities' => ['Nhân viên sử dụng tiếng Anh', 'Bánh ngọt', 'Toilet', 'Đèn đọc sách', 'Dây đai an toàn', 'Nước uống', 'Gối nằm', 'Búa phá kính', 'Tivi LED', 'Sạc điện thoại', 'Rèm cửa', 'Dàn âm thanh', 'Wi-Fi', 'Điều hòa', 'Khăn lạnh'], 'popular_stops' => 'Điểm đón, trả phổ biến', 'stops_text' => 'Địa chỉ chính xác và thời gian có mặt được xác nhận theo chuyến bạn chọn.', 'pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ', 'assurance' => 'An tâm đặt vé', 'back_booking' => 'Về form đặt vé', 'call' => 'Gọi hỗ trợ', 'searching' => 'Đang tìm chuyến...'],
    'en' => ['where_go' => 'Where would you like to go?', 'swap' => 'Swap locations', 'live_date' => 'Available departures', 'today' => 'Today', 'frequency' => 'A variety of departure times', 'arrival' => 'Arrival', 'travel_time' => 'Duration', 'remaining' => 'Left', 'view_all' => 'View all departures', 'amenities' => ['English-speaking staff', 'Snacks', 'Toilet', 'Reading light', 'Seat belt', 'Drinking water', 'Pillow', 'Emergency hammer', 'LED TV', 'Phone charging', 'Window curtains', 'Sound system', 'Wi-Fi', 'Air conditioning', 'Cold towel'], 'popular_stops' => 'Popular pickup and drop-off points', 'stops_text' => 'The exact address and check-in time are confirmed for your selected departure.', 'pickup' => 'Pickup', 'dropoff' => 'Drop-off', 'map' => 'Open map', 'assurance' => 'Book with confidence', 'back_booking' => 'Back to booking', 'call' => 'Call support', 'searching' => 'Finding departures...'],
    'ru' => ['where_go' => 'Куда вы хотите поехать?', 'swap' => 'Поменять местами', 'live_date' => 'Доступные рейсы', 'today' => 'Сегодня', 'frequency' => 'Разнообразное время отправления', 'arrival' => 'Прибытие', 'travel_time' => 'В пути', 'remaining' => 'Осталось', 'view_all' => 'Все рейсы', 'amenities' => ['Англоговорящий персонал', 'Закуски', 'Туалет', 'Лампа для чтения', 'Ремень безопасности', 'Питьевая вода', 'Подушка', 'Аварийный молоток', 'LED-телевизор', 'Зарядка телефона', 'Шторы', 'Аудиосистема', 'Wi-Fi', 'Кондиционер', 'Холодное полотенце'], 'popular_stops' => 'Популярные места посадки и высадки', 'stops_text' => 'Точный адрес и время регистрации подтверждаются для выбранного рейса.', 'pickup' => 'Посадка', 'dropoff' => 'Высадка', 'map' => 'Открыть карту', 'assurance' => 'Бронируйте уверенно', 'back_booking' => 'К форме бронирования', 'call' => 'Позвонить', 'searching' => 'Ищем рейсы...'],
  ][$locale];
  $homeTripTabs = [
    'vi' => ['discount' => 'Giảm giá', 'points' => 'Đón/Trả', 'reviews' => 'Đánh giá', 'policies' => 'Chính sách', 'images' => 'Hình ảnh', 'amenities' => 'Tiện ích', 'operator_policy' => 'Chính sách nhà xe'],
    'en' => ['discount' => 'Discount', 'points' => 'Pickup/Drop-off', 'reviews' => 'Reviews', 'policies' => 'Policies', 'images' => 'Images', 'amenities' => 'Amenities', 'operator_policy' => 'Operator policy'],
    'ru' => ['discount' => 'Скидка', 'points' => 'Посадка/Высадка', 'reviews' => 'Отзывы', 'policies' => 'Правила', 'images' => 'Фото', 'amenities' => 'Удобства', 'operator_policy' => 'Правила перевозчика'],
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
  $reviewQuote = $settings['home_routes_review_quote'] ?? $productCopy['review_fallback'];
  $reviewName = $settings['home_routes_review_name'] ?? 'Nhat Duong passenger';
  $reviewRole = $settings['home_routes_review_role'] ?? $productCopy['support_online'];
@endphp

<header class="hn-header">
  <div class="hn-shell hn-nav-wrap">
    <a class="hn-brand" href="{{ route('home', ['lang' => $locale]) }}" aria-label="Nhat Duong home">
      <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}" alt="Nhat Duong">
      <span>Nhat Duong</span>
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
    <div class="hn-hero__overlay"></div>
    <div class="hn-shell hn-hero__content">
      <div class="hn-hero__copy">
        <p class="hn-eyebrow hn-hero-route">{{ $copy['hero_kicker'] }}</p>
        <h1 id="hero-title" class="hn-hero-title"><span class="hn-hero-title__name">{{ $heroName }}</span><span class="hn-hero-title__specs">{{ $heroSpecs }}</span></h1>
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
            <label class="hn-location-field"><span>{{ $copy['from'] }}</span>
              <select id="hn-from-location" name="from_id" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 29)>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <button id="hn-swap-locations" class="hn-swap" type="button" aria-label="{{ $homeUi['swap'] }}" title="{{ $homeUi['swap'] }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 7h12m0 0-3-3m3 3-3 3M17 17H5m0 0 3 3m-3-3 3-3"/></svg>
            </button>
            <label class="hn-location-field"><span>{{ $copy['to'] }}</span>
              <select id="hn-to-location" name="to_id" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 417)>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <label class="hn-depart-date-field"><span>{{ $copy['date'] }}</span><input id="hn-depart-date" type="date" value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}"></label>
            <label><span>{{ $copy['passengers'] }}</span>
              <span class="hn-passenger-stepper">
                <button type="button" data-passenger-step="-1" aria-label="Decrease passengers">−</button>
                <output id="hn-passenger-count" for="hn-passenger-value">1</output>
                <button type="button" data-passenger-step="1" aria-label="Increase passengers">+</button>
              </span>
              <input id="hn-passenger-value" type="hidden" name="seats" value="1">
            </label>
            <input id="hn-depart-date-value" type="hidden" name="departDate" value="{{ now()->format('d-m-Y') }}">
            <input type="hidden" name="lang" value="{{ $locale }}">
            <button class="hn-button hn-button--primary hn-search-button" type="submit" data-loading="{{ $homeUi['searching'] }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m16 16 4 4"/></svg>
              <span>{{ $copy['search'] }}</span>
            </button>
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
      <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['route_kicker'] }}</p><h2 id="route-title">{{ $locations[29][$locale] }} ⇔ {{ $locations[417][$locale] }}</h2></div>
      <dl>
        <div><dt>{{ $copy['from_price'] }}</dt><dd>{{ number_format($startingFare) }} VND<small class="hn-usd-hint">≈ ${{ $toUsd($startingFare) }}</small></dd></div>
        <div><dt>{{ $copy['duration'] }}</dt><dd>{{ $routeDuration }}</dd></div>
        <div><dt>{{ $copy['daily'] }}</dt><dd>{{ $homeUi['frequency'] }}</dd></div>
      </dl>
      <a class="hn-text-link" href="{{ $routeDetailsUrl }}">{{ $copy['route_details'] }} <span aria-hidden="true">→</span></a>
    </div>
  </section>

  <section id="departures" class="hn-section hn-section--mist hn-departures" aria-labelledby="departure-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--split">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['schedule_kicker'] }}</p><h2 id="departure-title">{{ $copy['schedule_title'] }}</h2><p>{{ $copy['schedule_text'] }}</p></div>
        <span class="hn-date-badge"><small>{{ $homeUi['live_date'] }}</small><strong>{{ $liveTravelDate->format('d/m/Y') }}</strong></span>
      </div>
      <div class="hn-direction-tabs" role="tablist" aria-label="{{ $copy['choose_direction'] }}">
        @foreach($directionLabels as $direction => $label)
          <button id="direction-tab-{{ $direction }}" type="button" role="tab" aria-controls="direction-panel-{{ $direction }}" aria-selected="{{ $selectedDirection === $direction ? 'true' : 'false' }}" class="{{ $selectedDirection === $direction ? 'is-active' : '' }}" data-direction-tab="{{ $direction }}">{{ $label }}</button>
        @endforeach
      </div>
      @foreach($directionSchedules as $direction => $directionTrips)
        <div id="direction-panel-{{ $direction }}" class="hn-schedule-panel" role="tabpanel" aria-labelledby="direction-tab-{{ $direction }}" data-direction-panel="{{ $direction }}" {{ $selectedDirection === $direction ? '' : 'hidden' }}>
          <div class="hn-schedule-list">
            @forelse(array_slice($directionTrips, 0, 6) as $schedule)
              <article class="hn-departure-card">
                <div class="hn-departure-card__time"><strong>{{ $schedule['departure']->format('H:i') }}</strong><span>{{ $copy['departure'] }}</span></div>
                <div class="hn-departure-card__journey"><span>{{ $formatDuration($schedule['duration']) }}</span><i aria-hidden="true"></i><small>{{ $schedule['arrival']->format('H:i') }} · {{ $homeUi['arrival'] }}</small></div>
                <div class="hn-departure-card__vehicle"><strong>{{ $schedule['vehicle_type'] ?: $copy['vehicle_default'] }}</strong><span>{{ $schedule['available_seats'] }} {{ $copy['seats'] }}</span></div>
                <div class="hn-departure-card__fare"><span>{{ $copy['price'] }}</span><strong>{{ number_format($schedule['fare']) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($schedule['fare']) }}</small></div>
                <a class="hn-departure-card__action" href="{{ $schedule['checkout_url'] }}">{{ $copy['choose'] }} <span aria-hidden="true">→</span></a>
              </article>
            @empty
              <div class="hn-empty-state"><span aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/></svg></span><p>{{ $hasLiveSchedules ? $copy['no_departures'] : $copy['live_unavailable'] }}</p></div>
            @endforelse
          </div>
        </div>
      @endforeach
      <div class="hn-departures__footer"><a class="hn-button hn-button--outline" href="{{ route('schedules.index', ['lang' => $locale]) }}">{{ $homeUi['view_all'] }}</a></div>
    </div>
  </section>

  <section class="hn-section hn-fleet" aria-labelledby="fleet-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--split">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $productCopy['fleet_kicker'] }}</p><h2 id="fleet-title">{{ $productCopy['fleet_title'] }}</h2></div>
        <p>{{ $productCopy['fleet_text'] }}</p>
      </div>
      <div class="hn-vehicle-grid {{ $fleetTrips->count() <= 1 ? 'hn-vehicle-grid--single' : '' }}">
        @forelse($fleetTrips as $trip)
          <article class="hn-vehicle-card">
            <div class="hn-vehicle-card__media">
              <img src="{{ $trip['image'] ?: $vehicleFallbackImage }}" alt="{{ $trip['vehicle_type'] }}" loading="lazy">
              <span><i></i>{{ $productCopy['actual_vehicle'] }}</span>
            </div>
            <div class="hn-vehicle-card__body">
              <p class="hn-vehicle-card__route">{{ $directionLabels[$selectedDirection] }}</p>
              <h3>{{ $trip['vehicle_type'] }}</h3>
               <p class="hn-vehicle-card__comfort">{{ $productCopy['onboard'] }}</p>
               @php $tabsId = 'home-trip-tabs-'.$loop->index; @endphp
               @include('home.trip-info-tabs')
              <dl>
                <div><dt>{{ $copy['departure'] }}</dt><dd>{{ $trip['departure']->format('H:i') }}</dd></div>
                <div><dt>{{ $homeUi['remaining'] }}</dt><dd>{{ $trip['available_seats'] }} {{ $copy['seats'] }}</dd></div>
              </dl>
              <footer><div><small>{{ $copy['price'] }}</small><strong>{{ number_format($trip['fare']) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($trip['fare']) }}</small></div><a class="hn-vehicle-card__select" href="{{ $trip['checkout_url'] }}">{{ $copy['choose'] }} <b>→</b></a></footer>
            </div>
          </article>
        @empty
          <article class="hn-vehicle-card"><div class="hn-vehicle-card__media"><img src="{{ $vehicleFallbackImage }}" alt="{{ $copy['vehicle_default'] }}" loading="lazy"><span><i></i>{{ $productCopy['actual_vehicle'] }}</span></div><div class="hn-vehicle-card__body"><p class="hn-vehicle-card__route">{{ $directionLabels[$selectedDirection] }}</p><h3>{{ $copy['vehicle_default'] }}</h3><p class="hn-vehicle-card__comfort">{{ $productCopy['onboard'] }}</p>@include('home.vehicle-amenities')<p class="hn-vehicle-card__note">{{ $copy['daily'] }}</p><footer><div><small>{{ $copy['price'] }}</small><strong>{{ number_format($startingFare) }} VND</strong><small class="hn-usd-hint">≈ ${{ $toUsd($startingFare) }}</small></div><a class="hn-vehicle-card__select" href="#booking">{{ $copy['search'] }} <b>→</b></a></footer></div></article>
        @endforelse
      </div>
    </div>
  </section>

  <section class="hn-proof" aria-labelledby="assurance-title">
    <div class="hn-shell">
      <p class="hn-eyebrow" id="assurance-title">{{ $homeUi['assurance'] }}</p>
      <div class="hn-proof__body">
        <div class="hn-proof__grid">
          @foreach([[$productCopy['seat_map'], $productCopy['seat_map_text']], [$productCopy['stops'], $productCopy['stops_text']], [$productCopy['payment'], $productCopy['payment_text']]] as $index => [$title, $text])
            <article><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></article>
          @endforeach
        </div>
        <p class="hn-proof__transfer"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v10H3zM14 10h3l4 4v3h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/><path d="M5 4h7M2 11h4"/></svg><strong>{{ $productCopy['transfer'] }}</strong></p>
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
        <article class="hn-stop-card">
          <div class="hn-stop-card__head"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg><div><span>{{ $homeUi['pickup'] }}</span><h3>{{ $pickupPoints->first()?->name ?? $locations[29][$locale] }}</h3></div></div>
          @if($pickupPoints->first()?->address)<p>{{ $pickupPoints->first()->address }}</p>@endif
          @if($pickupPoints->first()?->phone)<a href="tel:{{ $pickupPoints->first()->phone }}">{{ $pickupPoints->first()->phone }}</a>@endif
          @if($pickupPoints->first()?->map_url)<a href="{{ $pickupPoints->first()->map_url }}" target="_blank" rel="noopener">{{ $homeUi['map'] }} →</a>@endif
        </article>
        <article class="hn-stop-card">
          <div class="hn-stop-card__head"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg><div><span>{{ $homeUi['dropoff'] }}</span><h3>{{ $dropoffPoints->first()?->name ?? $locations[417][$locale] }}</h3></div></div>
          @if($dropoffPoints->first()?->address)<p>{{ $dropoffPoints->first()->address }}</p>@endif
          @if($dropoffPoints->first()?->phone)<a href="tel:{{ $dropoffPoints->first()->phone }}">{{ $dropoffPoints->first()->phone }}</a>@endif
          @if($dropoffPoints->first()?->map_url)<a href="{{ $dropoffPoints->first()->map_url }}" target="_blank" rel="noopener">{{ $homeUi['map'] }} →</a>@endif
        </article>
        <aside class="hn-stop-support"><p>{{ $pickupLabels['support'] }}</p><strong>1900 2879</strong><div class="hn-stop-support__phones">@foreach($supportPhones as $phone)<a href="tel:{{ str_replace('.', '', $phone) }}">{{ $phone }}</a>@endforeach</div><span>{{ $pickupLabels['support_text'] }}</span><a class="hn-button hn-button--gold" href="{{ $supportHref }}">{{ $homeUi['call'] }}</a></aside>
      </div>
    </div>
  </section>

  <section class="hn-review hn-section--mist" aria-labelledby="review-title">
    <div class="hn-shell hn-review__inner">
      <div class="hn-review__quote"><div class="hn-review__stars" aria-label="5 out of 5 stars">★★★★★</div><blockquote>“{{ $reviewQuote }}”</blockquote><footer><strong>{{ $reviewName }}</strong><small>{{ $reviewRole }}</small></footer></div>
      <div class="hn-review__aside"><p class="hn-eyebrow hn-eyebrow--green">{{ $productCopy['review_kicker'] }}</p><h2 id="review-title">{{ $copy['support'] }}</h2><p>{{ $pickupLabels['support_text'] }}</p><a class="hn-button hn-button--primary" href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['contact'] }}</a></div>
    </div>
  </section>

  <section id="help" class="hn-section hn-shell" aria-labelledby="faq-title">
    <div class="hn-section-heading"><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['faq_kicker'] }}</p><h2 id="faq-title">{{ $copy['faq_title'] }}</h2></div>
    <div class="hn-faq">
      @foreach($faqItems as [$question, $answer])
      <details><summary>{{ $question }}</summary><p>{{ $answer }}</p></details>
      @endforeach
    </div>
  </section>

  @if($latestPosts->isNotEmpty())
  <section class="hn-section hn-section--mist" aria-labelledby="news-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-news-heading">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['news_kicker'] }}</p><h2 id="news-title">{{ $copy['news_title'] }}</h2><p>{{ $copy['news_text'] }}</p></div>
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

  <section class="hn-final" aria-labelledby="final-title">
    <div class="hn-shell hn-final__content"><div><h2 id="final-title">{{ $copy['final_title'] }}</h2><p>{{ $copy['final_text'] }}</p></div><div><a class="hn-button hn-button--gold" href="#booking">{{ $copy['book'] }}</a><a class="hn-contact" href="{{ route('contact', ['lang' => $locale]) }}">{{ $copy['contact'] }}</a></div></div>
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
    }));
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

    if (!form) return;

    const depart = document.getElementById('hn-depart-date');
    const departValue = document.getElementById('hn-depart-date-value');
    const fromLocation = document.getElementById('hn-from-location');
    const toLocation = document.getElementById('hn-to-location');
    const swapLocations = document.getElementById('hn-swap-locations');
    const passengerValue = document.getElementById('hn-passenger-value');
    const passengerCount = document.getElementById('hn-passenger-count');
    const formatDate = (value) => value ? value.split('-').reverse().join('-') : '';

    const syncDates = () => {
      departValue.value = formatDate(depart.value);
    };

    depart.addEventListener('change', syncDates);
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
    }));
    fromLocation.addEventListener('change', () => {
      [...toLocation.options].forEach((option) => option.disabled = option.value === fromLocation.value);
      if (toLocation.value === fromLocation.value) {
        toLocation.selectedIndex = [...toLocation.options].findIndex((option) => !option.disabled);
      }
    });
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
