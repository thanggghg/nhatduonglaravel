@php
  $locale = request('lang');
  $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
  $footerCopy = [
    'vi' => ['intro' => 'Dịch vụ vận chuyển hành khách tuyến Sài Gòn ↔ Nha Trang. An toàn, đúng giờ, phục vụ tận tâm.', 'quick' => 'Liên kết nhanh', 'services' => 'Dịch vụ', 'service_items' => ['Đặt vé một chiều','Đặt vé khứ hồi','Hỗ trợ giữ chỗ','Tư vấn điểm đón','Xe giường nằm VIP'], 'contact' => 'Thông tin liên hệ', 'route' => 'Tuyến: Sài Gòn ↔ Nha Trang', 'support' => 'Hỗ trợ 24/7', 'rights' => 'Nhà xe Nhật Dương. All rights reserved.', 'privacy' => 'Chính Sách Bảo Mật', 'terms' => 'Điều Khoản Sử Dụng'],
    'en' => ['intro' => 'Passenger service between Ho Chi Minh City and Nha Trang. Safe, punctual, and attentive.', 'quick' => 'Quick links', 'services' => 'Services', 'service_items' => ['One-way booking','Round-trip booking','Reservation support','Pickup guidance','VIP sleeper bus'], 'contact' => 'Contact details', 'route' => 'Route: Ho Chi Minh City ↔ Nha Trang', 'support' => 'Support 24/7', 'rights' => 'Nhat Duong. All rights reserved.', 'privacy' => 'Privacy policy', 'terms' => 'Terms of use'],
    'ru' => ['intro' => 'Пассажирские перевозки между Хошимином и Нячангом. Безопасно, вовремя и с заботой о пассажирах.', 'quick' => 'Быстрые ссылки', 'services' => 'Услуги', 'service_items' => ['Бронирование в одну сторону','Бронирование туда и обратно','Помощь с бронированием','Информация о посадке','VIP спальный автобус'], 'contact' => 'Контакты', 'route' => 'Маршрут: Хошимин ↔ Нячанг', 'support' => 'Поддержка 24/7', 'rights' => 'Nhat Duong. Все права защищены.', 'privacy' => 'Политика конфиденциальности', 'terms' => 'Условия использования'],
  ][$locale];
  $footerNav = [
    'vi' => [['Trang chủ','home'],['Tuyến đường','routes.index'],['Lịch trình','schedules.index'],['Tin tức','posts.index'],['Về chúng tôi','about'],['Liên hệ','contact']],
    'en' => [['Home','home'],['Routes','routes.index'],['Schedule','schedules.index'],['News','posts.index'],['About','about'],['Contact','contact']],
    'ru' => [['Главная','home'],['Маршруты','routes.index'],['Расписание','schedules.index'],['Новости','posts.index'],['О компании','about'],['Контакты','contact']],
  ][$locale];
@endphp
<footer style="color:#fff; background: radial-gradient(circle at 20% 18%,rgba(249,178,26,.16),transparent 24%), linear-gradient(180deg,#0a5d03,#043801); padding:64px 2vw 26px;">
  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">

    <div style="display:grid; grid-template-columns:1.2fr .8fr .8fr 1fr; gap:28px; padding-bottom:40px; border-bottom:1px solid rgba(255,255,255,.14);" class="footer-grid">

      {{-- Brand --}}
      <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px; font-size:22px; font-weight:900; text-transform:uppercase;">
          <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}"
               alt="Nhà Xe Nhật Dương"
               style="height:40px; width:auto; object-fit:contain; filter:brightness(0) invert(1);">
        </div>
        <p style="margin:0 0 20px; color:rgba(255,255,255,.72); line-height:1.7; font-size:14px; font-weight:650;">
          {{ $footerCopy['intro'] }}
        </p>
      </div>

      {{-- Liên kết nhanh --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">{{ $footerCopy['quick'] }}</h4>
        <div style="display:grid; gap:10px;">
          @foreach($footerNav as [$label,$route])
          <a href="{{ route($route, ['lang' => $locale]) }}"
             style="color:rgba(255,255,255,.75); font-size:14px; font-weight:750; text-decoration:none; transition:color .2s;"
             onmouseover="this.style.color='#f9b21a'"
             onmouseout="this.style.color='rgba(255,255,255,.75)'">{{ $label }}</a>
          @endforeach
        </div>
      </div>

      {{-- Dịch vụ --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">{{ $footerCopy['services'] }}</h4>
        <div style="display:grid; gap:10px;">
          @foreach($footerCopy['service_items'] as $item)
          <span style="color:rgba(255,255,255,.70); font-size:14px; font-weight:650;">{{ $item }}</span>
          @endforeach
        </div>
      </div>

      {{-- Liên hệ --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">{{ $footerCopy['contact'] }}</h4>
        <div style="display:grid; gap:12px;">
          @foreach([
            ['☎','Hotline: 1900 2879','tel:19002879'],
            ['📍',$footerCopy['route'],null],
            ['⏱',$footerCopy['support'],null],
            ['✉','info@nhatduong.com','mailto:info@nhatduong.com'],
          ] as [$icon,$text,$href])
          <div style="display:flex; align-items:center; gap:10px;">
            <span style="width:30px; height:30px; border-radius:50%; background:rgba(249,178,26,.20); display:grid; place-items:center; font-size:13px; flex-shrink:0;">{{ $icon }}</span>
            @if($href)
              <a href="{{ $href }}" style="color:rgba(255,255,255,.75); font-size:13px; font-weight:750; text-decoration:none;"
                 onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.75)'">{{ $text }}</a>
            @else
              <span style="color:rgba(255,255,255,.70); font-size:13px; font-weight:650;">{{ $text }}</span>
            @endif
          </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- Bottom --}}
    <div style="display:flex; justify-content:space-between; gap:18px; flex-wrap:wrap; padding-top:24px; color:rgba(255,255,255,.60); font-size:13px; font-weight:750;">
       <span>© {{ date('Y') }} {{ $footerCopy['rights'] }}</span>
      <div style="display:flex; gap:20px;">
        <a href="{{ route('pages.show', ['slug' => 'chinh-sach-bao-mat', 'lang' => 'vi']) }}" style="color:rgba(255,255,255,.55); text-decoration:none; transition:color .2s;"
            onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.55)'">{{ $footerCopy['privacy'] }}</a>
        <a href="{{ route('pages.show', ['slug' => 'dieu-khoan-su-dung', 'lang' => 'vi']) }}" style="color:rgba(255,255,255,.55); text-decoration:none; transition:color .2s;"
            onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.55)'">{{ $footerCopy['terms'] }}</a>
      </div>
    </div>

  </div>

  <style>
    @media(max-width:1180px){ .footer-grid{grid-template-columns:1fr 1fr!important} }
    @media(max-width:640px){ .footer-grid{grid-template-columns:1fr!important} }
  </style>
</footer>
