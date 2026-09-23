{{-- HEADER: xanh solid, logo trắng, nav ngang, CTA vàng --}}
@php
  $locale = request('lang');
  $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
  $headerCopy = [
    'vi' => ['nav' => [['Trang Chủ','home'],['Tuyến Đường','routes.index'],['Lịch Trình','schedules.index'],['Tin Tức','posts.index'],['Về Chúng Tôi','about'],['Liên Hệ','contact']], 'book' => 'Đặt Vé Ngay'],
    'en' => ['nav' => [['Home','home'],['Routes','routes.index'],['Schedule','schedules.index'],['News','posts.index'],['About','about'],['Contact','contact']], 'book' => 'Book now'],
    'ru' => ['nav' => [['Главная','home'],['Маршруты','routes.index'],['Расписание','schedules.index'],['Новости','posts.index'],['О компании','about'],['Контакты','contact']], 'book' => 'Забронировать'],
  ][$locale];
  $languageUrl = fn (string $language) => request()->fullUrlWithQuery(['lang' => $language]);
@endphp
<header class="site-header" style="position:sticky; top:0; z-index:1000; background:linear-gradient(180deg,#0b7f42,#096b39); box-shadow:0 4px 20px rgba(11,127,66,0.30);">
  <div class="site-header__inner" style="width:min(1380px,96%); margin:0 auto; min-height:82px; display:flex; align-items:center; justify-content:space-between; gap:18px; padding:0 16px;">

    {{-- Logo --}}
    <a class="site-header__brand" href="{{ route('home', ['lang' => $locale]) }}" style="display:flex; align-items:center; gap:12px; padding:5px 10px; text-decoration:none; flex-shrink:0; background:rgba(255,255,255,.96); border-radius:12px; box-shadow:0 0 22px rgba(249,223,18,.28);">
      <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}"
           alt="Nhà Xe Nhật Dương"
           style="height:52px; width:166px; object-fit:contain; filter:drop-shadow(0 3px 7px rgba(151,130,0,.2));">
    </a>

    {{-- Desktop nav --}}
    <nav style="display:flex; align-items:center; gap:4px;" class="site-header__desktop site-header__nav">
      @foreach($headerCopy['nav'] as [$label,$route])
      @php $active = request()->routeIs($route) || request()->routeIs(rtrim($route,'.index').'.*'); @endphp
      <a href="{{ route($route, ['lang' => $locale]) }}"
         style="min-height:46px; display:inline-flex; align-items:center; padding:0 13px; border-radius:9px; font-size:15px; font-weight:{{ $active?'800':'700' }}; color:{{ $active?'#f9df12':'rgba(255,255,255,0.92)' }}; text-decoration:none; transition:all 0.18s; {{ $active?'background:rgba(255,255,255,0.12);':'' }}"
         onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,0.12)'"
         onmouseout="this.style.color='{{ $active?'#f9df12':'rgba(255,255,255,0.92)' }}';this.style.background='{{ $active?'rgba(255,255,255,0.12)':'transparent' }}'">
        {{ $label }}
      </a>
      @endforeach
    </nav>

    {{-- Right actions --}}
    <div style="display:flex; align-items:center; gap:10px;" class="site-header__desktop site-header__actions">
      <div aria-label="Language" style="display:flex; align-items:center; gap:2px; padding:3px; border:1px solid rgba(255,255,255,0.30); border-radius:9px;">
        @foreach(['vi' => 'VI', 'en' => 'EN', 'ru' => 'RU'] as $code => $label)
         <a href="{{ $languageUrl($code) }}" aria-current="{{ $locale === $code ? 'page' : 'false' }}" style="min-width:38px; min-height:36px; display:grid; place-items:center; padding:0 7px; border-radius:7px; color:{{ $locale === $code ? '#062d1c' : 'rgba(255,255,255,0.88)' }}; background:{{ $locale === $code ? '#f9df12' : 'transparent' }}; font-size:11px; font-weight:900; text-decoration:none;">{{ $label }}</a>
        @endforeach
      </div>
      <a href="tel:1900 2879"
         style="min-height:46px; display:flex; align-items:center; gap:6px; padding:0 16px; border-radius:10px; background:#fff; color:#062d1c; font-size:14px; font-weight:800; text-decoration:none; white-space:nowrap; box-shadow:0 4px 12px rgba(0,0,0,0.12);">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        1900 2879
      </a>
      <a href="{{ route('home', ['lang' => $locale]) }}#booking"
         style="min-height:46px; display:flex; align-items:center; gap:6px; padding:0 20px; border-radius:10px; background:linear-gradient(135deg,#fff36a,#f9df12); color:#17362b; font-size:14px; font-weight:900; text-decoration:none; white-space:nowrap; box-shadow:0 7px 19px rgba(164,144,0,.28),0 0 15px rgba(249,223,18,.15); transition:all 0.18s;"
         onmouseover="this.style.filter='brightness(1.05)';this.style.transform='translateY(-1px)'"
         onmouseout="this.style.filter='none';this.style.transform='translateY(0)'">
        {{ $headerCopy['book'] }}
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>

    {{-- Mobile toggle --}}
    <div x-data="{ open: false }" class="site-header__mobile">
      <button @click="open=!open" :aria-expanded="open.toString()" aria-controls="site-mobile-menu" aria-label="Menu" style="background:rgba(255,255,255,0.15); border:none; border-radius:8px; padding:8px; cursor:pointer; color:#fff;">
        <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg x-show="open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
      <div id="site-mobile-menu" x-show="open" x-transition style="position:absolute; top:100%; left:0; right:0; background:#062d1c; border-top:1px solid rgba(255,255,255,0.10); padding:12px 16px; display:flex; flex-direction:column; gap:4px;">
        @foreach($headerCopy['nav'] as [$label,$route])
        <a href="{{ route($route, ['lang' => $locale]) }}" style="padding:12px 14px; border-radius:8px; color:rgba(255,255,255,0.88); font-size:15px; font-weight:700; text-decoration:none; {{ request()->routeIs($route)?'background:rgba(255,255,255,0.10);color:#f9df12;':'' }}">{{ $label }}</a>
        @endforeach
        <div style="margin-top:8px; padding-top:10px; border-top:1px solid rgba(255,255,255,0.10); display:flex; flex-direction:column; gap:8px;">
          <div aria-label="Language" style="display:flex; gap:7px;">
            @foreach(['vi' => 'VI', 'en' => 'EN', 'ru' => 'RU'] as $code => $label)
            <a href="{{ $languageUrl($code) }}" aria-current="{{ $locale === $code ? 'page' : 'false' }}" style="flex:1; padding:10px; border-radius:7px; color:{{ $locale === $code ? '#062d1c' : '#fff' }}; background:{{ $locale === $code ? '#f9df12' : 'rgba(255,255,255,0.12)' }}; font-size:12px; font-weight:900; text-align:center; text-decoration:none;">{{ $label }}</a>
            @endforeach
          </div>
          <a href="tel:1900 2879" style="padding:11px 14px; border-radius:8px; background:#fff; color:#062d1c; font-weight:800; font-size:14px; text-decoration:none; text-align:center;">☎ 1900 2879</a>
          <a href="{{ route('home', ['lang' => $locale]) }}#booking" style="padding:12px 14px; border-radius:8px; background:linear-gradient(135deg,#fff36a,#f9df12); color:#17362b; font-weight:900; font-size:14px; text-decoration:none; text-align:center; box-shadow:0 7px 18px rgba(164,144,0,.22);">{{ $headerCopy['book'] }}</a>
        </div>
      </div>
    </div>

  </div>
</header>

<style>
  .site-header__mobile { display: none; }
  .site-header__brand,.site-header__brand img { transition:transform .22s ease,box-shadow .22s ease,filter .22s ease; }
  @media (hover:hover) and (pointer:fine) {
    .site-header__brand:hover { transform:translateY(-1px); box-shadow:0 0 29px rgba(249,223,18,.42)!important; }
    .site-header__brand:hover img { filter:drop-shadow(0 4px 10px rgba(164,144,0,.32))!important; transform:scale(1.015); }
  }
  @media (max-width: 1320px) {
    .site-header__desktop { display: none !important; }
    .site-header__mobile { display: block; }
  }
  @media (max-width: 620px) {
    .site-header__inner { min-height:72px!important; padding:0 8px!important; }
    .site-header__brand { padding:4px 7px!important; }
    .site-header__brand img { width:120px!important; height:42px!important; }
  }
</style>
