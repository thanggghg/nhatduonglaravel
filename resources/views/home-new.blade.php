<!doctype html>
<html lang="{{ $locale }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Nhat Duong | {{ $locale === 'ru' ? 'Автобусы Хошимин - Нячанг' : ($locale === 'vi' ? 'Xe khách Sài Gòn - Nha Trang' : 'Ho Chi Minh City to Nha Trang buses') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="home-new">
@php
  $copy = [
    'vi' => [
      'nav_routes' => 'Tuyến xe', 'nav_schedule' => 'Lịch chạy', 'nav_pickup' => 'Điểm đón trả', 'nav_help' => 'Hỗ trợ',
      'book' => 'Đặt vé', 'hero_kicker' => 'Tuyến xe chất lượng cao', 'hero_title' => 'Đi Sài Gòn - Nha Trang một cách thoải mái, rõ ràng và đúng giờ.',
      'hero_text' => 'Chọn chuyến, xem thông tin minh bạch và nhận xác nhận đặt vé trực tuyến.', 'one_way' => 'Một chiều', 'round_trip' => 'Khứ hồi',
      'from' => 'Điểm đi', 'to' => 'Điểm đến', 'date' => 'Ngày đi', 'passengers' => 'Số khách', 'search' => 'Tìm chuyến',
      'trust_1' => 'Xác nhận đặt vé', 'trust_2' => 'Xe phòng tiện nghi', 'trust_3' => 'Thông tin rõ ràng',
      'route_kicker' => 'Tuyến phổ biến', 'route_title' => 'Chuyến đi được chuẩn bị cho hành trình dài', 'from_price' => 'Giá từ', 'duration' => 'Thời gian đi',
      'view_departures' => 'Xem giờ khởi hành', 'daily' => 'Khởi hành mỗi ngày', 'luggage' => 'Hành lý theo quy định', 'support' => 'Hỗ trợ đặt vé',
      'schedule_kicker' => 'Chọn giờ phù hợp', 'schedule_title' => 'Lịch khởi hành hôm nay', 'schedule_text' => 'Giờ chạy, loại xe và giá vé được hiển thị trước khi bạn đặt.',
      'departure' => 'Khởi hành', 'vehicle' => 'Loại xe', 'price' => 'Giá vé', 'choose' => 'Chọn chuyến',
      'pickup_kicker' => 'Đón trả minh bạch', 'pickup_title' => 'Biết rõ nơi lên xe trước khi khởi hành', 'pickup_text' => 'Xác nhận điểm đón, điểm trả và thời gian có mặt với đội ngũ hỗ trợ trước ngày đi.',
      'pickup_1_title' => 'Điểm đón rõ ràng', 'pickup_1_text' => 'Nhận địa chỉ và giờ tập trung trong xác nhận đặt vé.',
      'pickup_2_title' => 'Hỗ trợ hành trình', 'pickup_2_text' => 'Liên hệ hỗ trợ nếu cần điều chỉnh thông tin trước giờ khởi hành.',
      'pickup_3_title' => 'Đến sớm', 'pickup_3_text' => 'Nên có mặt trước giờ khởi hành để hoàn tất lên xe thuận tiện.',
      'how_kicker' => 'Quy trình đơn giản', 'how_title' => 'Đặt vé trong ba bước', 'step_1' => 'Chọn chuyến', 'step_1_text' => 'Chọn chiều đi, ngày và giờ phù hợp.',
      'step_2' => 'Xác nhận thông tin', 'step_2_text' => 'Kiểm tra điểm đón, giá vé và thông tin hành khách.',
      'step_3' => 'Nhận vé', 'step_3_text' => 'Nhận xác nhận để sẵn sàng cho chuyến đi.',
      'faq_kicker' => 'Cần hỗ trợ?', 'faq_title' => 'Thông tin trước khi đặt vé', 'faq_1_q' => 'Tôi nên đến điểm đón lúc nào?', 'faq_1_a' => 'Nên có mặt sớm để kiểm tra thông tin và lên xe thuận tiện.',
      'faq_2_q' => 'Tôi có thể hỏi về hành lý hoặc điểm đón không?', 'faq_2_a' => 'Có. Vui lòng liên hệ đội ngũ hỗ trợ trước ngày khởi hành.',
      'faq_3_q' => 'Tôi nhận xác nhận đặt vé ở đâu?', 'faq_3_a' => 'Thông tin xác nhận sẽ được gửi theo phương thức đặt vé của bạn.',
      'final_title' => 'Sẵn sàng chọn chuyến đi?', 'final_text' => 'Xem giờ chạy phù hợp và hoàn tất đặt vé trực tuyến.', 'contact' => 'Liên hệ hỗ trợ',
      'footer' => 'Tuyến vận chuyển hành khách Sài Gòn - Nha Trang.',
    ],
    'en' => [
      'nav_routes' => 'Route', 'nav_schedule' => 'Departures', 'nav_pickup' => 'Pickup & drop-off', 'nav_help' => 'Help',
      'book' => 'Book now', 'hero_kicker' => 'Comfort sleeper bus service', 'hero_title' => 'Travel between Ho Chi Minh City and Nha Trang with clarity and comfort.',
      'hero_text' => 'Choose a departure, see the essential trip details, and receive your booking confirmation online.', 'one_way' => 'One way', 'round_trip' => 'Round trip',
      'from' => 'From', 'to' => 'To', 'date' => 'Departure date', 'passengers' => 'Passengers', 'search' => 'Find departures',
      'trust_1' => 'Booking confirmation', 'trust_2' => 'Comfortable sleeper cabin', 'trust_3' => 'Clear trip details',
      'route_kicker' => 'Popular route', 'route_title' => 'Prepared for a comfortable long-distance journey', 'from_price' => 'From', 'duration' => 'Travel time',
      'view_departures' => 'View departures', 'daily' => 'Daily departures', 'luggage' => 'Luggage policy available', 'support' => 'Booking support',
      'schedule_kicker' => 'Choose a suitable time', 'schedule_title' => 'Today’s departures', 'schedule_text' => 'Departure time, vehicle type, and fare are visible before you book.',
      'departure' => 'Departure', 'vehicle' => 'Vehicle', 'price' => 'Fare', 'choose' => 'Select departure',
      'pickup_kicker' => 'Clear pickup details', 'pickup_title' => 'Know where to board before you travel', 'pickup_text' => 'Confirm your pickup, drop-off, and check-in time with our support team before departure.',
      'pickup_1_title' => 'Clear boarding point', 'pickup_1_text' => 'Your confirmation includes the address and meeting time.',
      'pickup_2_title' => 'Trip assistance', 'pickup_2_text' => 'Contact support if you need to clarify your details before travel.',
      'pickup_3_title' => 'Arrive early', 'pickup_3_text' => 'Please arrive early for a smooth check-in and boarding process.',
      'how_kicker' => 'Simple process', 'how_title' => 'Book in three steps', 'step_1' => 'Choose a departure', 'step_1_text' => 'Choose your direction, date, and preferred time.',
      'step_2' => 'Confirm your details', 'step_2_text' => 'Review pickup, fare, and passenger information.',
      'step_3' => 'Receive your ticket', 'step_3_text' => 'Keep your confirmation ready for the journey.',
      'faq_kicker' => 'Need help?', 'faq_title' => 'Before you book', 'faq_1_q' => 'When should I arrive at the pickup point?', 'faq_1_a' => 'Arrive early to check your details and board comfortably.',
      'faq_2_q' => 'Can I ask about luggage or pickup?', 'faq_2_a' => 'Yes. Please contact our support team before your departure date.',
      'faq_3_q' => 'Where will I receive my confirmation?', 'faq_3_a' => 'Your confirmation is sent through the booking method you use.',
      'final_title' => 'Ready to choose your departure?', 'final_text' => 'See available times and complete your booking online.', 'contact' => 'Contact support',
      'footer' => 'Passenger service between Ho Chi Minh City and Nha Trang.',
    ],
    'ru' => [
      'nav_routes' => 'Маршрут', 'nav_schedule' => 'Расписание', 'nav_pickup' => 'Посадка и высадка', 'nav_help' => 'Помощь',
      'book' => 'Забронировать', 'hero_kicker' => 'Комфортные спальные автобусы', 'hero_title' => 'Путешествуйте между Хошимином и Нячангом комфортно и без лишних вопросов.',
      'hero_text' => 'Выберите рейс, заранее посмотрите основные детали поездки и получите подтверждение онлайн.', 'one_way' => 'В одну сторону', 'round_trip' => 'Туда и обратно',
      'from' => 'Откуда', 'to' => 'Куда', 'date' => 'Дата поездки', 'passengers' => 'Пассажиры', 'search' => 'Найти рейсы',
      'trust_1' => 'Подтверждение бронирования', 'trust_2' => 'Комфортный спальный салон', 'trust_3' => 'Понятные условия поездки',
      'route_kicker' => 'Популярный маршрут', 'route_title' => 'Всё подготовлено для комфортной дальней поездки', 'from_price' => 'Цена от', 'duration' => 'Время в пути',
      'view_departures' => 'Посмотреть рейсы', 'daily' => 'Рейсы каждый день', 'luggage' => 'Правила багажа доступны', 'support' => 'Помощь с бронированием',
      'schedule_kicker' => 'Выберите удобное время', 'schedule_title' => 'Рейсы сегодня', 'schedule_text' => 'Время отправления, тип автобуса и цена видны до бронирования.',
      'departure' => 'Отправление', 'vehicle' => 'Автобус', 'price' => 'Цена', 'choose' => 'Выбрать рейс',
      'pickup_kicker' => 'Понятная посадка', 'pickup_title' => 'Знайте место посадки до начала поездки', 'pickup_text' => 'Подтвердите место посадки, высадки и время регистрации у команды поддержки до отправления.',
      'pickup_1_title' => 'Точное место посадки', 'pickup_1_text' => 'Адрес и время встречи указаны в подтверждении.',
      'pickup_2_title' => 'Помощь в поездке', 'pickup_2_text' => 'Свяжитесь с поддержкой, если нужно уточнить детали до поездки.',
      'pickup_3_title' => 'Приезжайте заранее', 'pickup_3_text' => 'Приезжайте заранее для спокойной регистрации и посадки.',
      'how_kicker' => 'Простой процесс', 'how_title' => 'Бронирование в три шага', 'step_1' => 'Выберите рейс', 'step_1_text' => 'Выберите направление, дату и удобное время.',
      'step_2' => 'Подтвердите данные', 'step_2_text' => 'Проверьте место посадки, цену и данные пассажира.',
      'step_3' => 'Получите билет', 'step_3_text' => 'Сохраните подтверждение для поездки.',
      'faq_kicker' => 'Нужна помощь?', 'faq_title' => 'Перед бронированием', 'faq_1_q' => 'Когда нужно приехать к месту посадки?', 'faq_1_a' => 'Приезжайте заранее, чтобы спокойно проверить данные и сесть в автобус.',
      'faq_2_q' => 'Можно уточнить багаж или место посадки?', 'faq_2_a' => 'Да. Пожалуйста, свяжитесь с поддержкой до даты отправления.',
      'faq_3_q' => 'Где я получу подтверждение?', 'faq_3_a' => 'Подтверждение отправляется способом, выбранным при бронировании.',
      'final_title' => 'Готовы выбрать рейс?', 'final_text' => 'Посмотрите доступное время и завершите бронирование онлайн.', 'contact' => 'Связаться с поддержкой',
      'footer' => 'Пассажирские перевозки между Хошимином и Нячангом.',
    ],
  ][$locale];

  $route = $ntRoute ?? $featuredRoutes->first();
  $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
  $heroImage = $heroBanner && $heroBanner->hasImage() ? $heroBanner->image_url : asset('nha-xe-binh-minh-bus-2048x867.png');
  $routeImage = $route?->image ? asset('storage/'.$route->image) : $heroImage;
  $locations = [
    'TP. Hồ Chí Minh' => ['vi' => 'TP. Hồ Chí Minh', 'en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
    'Cam Ranh' => ['vi' => 'Cam Ranh', 'en' => 'Cam Ranh', 'ru' => 'Камрань'],
    'Nha Trang' => ['vi' => 'Nha Trang', 'en' => 'Nha Trang', 'ru' => 'Нячанг'],
  ];
  $faqItems = [
    [$copy['faq_1_q'], $copy['faq_1_a']],
    [$copy['faq_2_q'], $copy['faq_2_a']],
    [$copy['faq_3_q'], $copy['faq_3_a']],
  ];
@endphp

<header class="hn-header">
  <div class="hn-shell hn-nav-wrap">
    <a class="hn-brand" href="{{ route('home.new', ['lang' => $locale]) }}" aria-label="Nhat Duong home">
      <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}" alt="Nhat Duong">
      <span>Nhat Duong</span>
    </a>
    <nav class="hn-nav" aria-label="Primary navigation">
      <a href="#route">{{ $copy['nav_routes'] }}</a>
      <a href="#departures">{{ $copy['nav_schedule'] }}</a>
      <a href="#pickup">{{ $copy['nav_pickup'] }}</a>
      <a href="#help">{{ $copy['nav_help'] }}</a>
    </nav>
    <div class="hn-actions">
      <div class="hn-locale" aria-label="Language">
        @foreach(['vi' => 'VI', 'en' => 'EN', 'ru' => 'RU'] as $code => $label)
          <a href="{{ route('home.new', ['lang' => $code]) }}" aria-current="{{ $locale === $code ? 'page' : 'false' }}">{{ $label }}</a>
        @endforeach
      </div>
      <a class="hn-button hn-button--primary" href="#booking">{{ $copy['book'] }}</a>
    </div>
  </div>
</header>

<main>
  <section class="hn-hero" aria-labelledby="hero-title">
    <img class="hn-hero__image" src="{{ $heroImage }}" alt="" aria-hidden="true">
    <div class="hn-hero__overlay"></div>
    <div class="hn-shell hn-hero__content">
      <div class="hn-hero__copy">
        <p class="hn-eyebrow">{{ $copy['hero_kicker'] }}</p>
        <h1 id="hero-title">{{ $copy['hero_title'] }}</h1>
        <p>{{ $copy['hero_text'] }}</p>
      </div>
      <form id="booking" class="hn-booking" action="{{ route('booking.search') }}" method="GET">
        <fieldset>
          <legend>{{ $copy['book'] }}</legend>
          <div class="hn-trip-type" role="group" aria-label="Trip type">
            <label><input type="radio" name="trip_type" value="one_way" checked> <span>{{ $copy['one_way'] }}</span></label>
            <label><input type="radio" name="trip_type" value="round_trip"> <span>{{ $copy['round_trip'] }}</span></label>
          </div>
          <div class="hn-booking__fields">
            <label>{{ $copy['from'] }}
              <select name="from_location" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 'TP. Hồ Chí Minh')>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <label>{{ $copy['to'] }}
              <select name="to_location" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 'Nha Trang')>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <label>{{ $copy['date'] }}<input id="hn-depart-date" type="date" value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}"></label>
            <label id="hn-return-field" hidden>{{ $copy['round_trip'] }}<input id="hn-return-date" type="date" value="{{ now()->addDay()->toDateString() }}" min="{{ now()->addDay()->toDateString() }}"></label>
            <label>{{ $copy['passengers'] }}
              <select name="seats"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select>
            </label>
            <input id="hn-depart-date-value" type="hidden" name="departDate" value="{{ now()->format('d-m-Y') }}">
            <input id="hn-return-date-value" type="hidden" name="returnDate" value="{{ now()->addDay()->format('d-m-Y') }}">
            <input id="hn-round-trip-value" type="hidden" name="is_round_trip" value="0">
            <button class="hn-button hn-button--primary" type="submit">{{ $copy['search'] }}</button>
          </div>
        </fieldset>
      </form>
      <ul class="hn-trust" aria-label="Service highlights">
        @foreach([$copy['trust_1'], $copy['trust_2'], $copy['trust_3']] as $item)
        <li><svg viewBox="0 0 16 16" aria-hidden="true"><path d="m3 8 3 3 7-7"/></svg>{{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </section>

  <section id="route" class="hn-section hn-shell hn-route" aria-labelledby="route-title">
    <div class="hn-section-heading">
      <p class="hn-eyebrow hn-eyebrow--green">{{ $copy['route_kicker'] }}</p>
      <h2 id="route-title">{{ $route ? ($locations[$route->from_location][$locale] ?? $route->from_location).' - '.($locations[$route->to_location][$locale] ?? $route->to_location) : 'Ho Chi Minh City - Nha Trang' }}</h2>
      <p>{{ $copy['route_title'] }}</p>
    </div>
    <article class="hn-route-card">
      <img src="{{ $routeImage }}" alt="{{ $route?->name ?? 'Nhat Duong sleeper bus' }}">
      <div class="hn-route-card__content">
        <dl>
          <div><dt>{{ $copy['from_price'] }}</dt><dd>{{ number_format($route?->price_from ?? 220000) }} VND</dd></div>
          <div><dt>{{ $copy['duration'] }}</dt><dd>{{ $route?->estimated_time ?? '9-10 hours' }}</dd></div>
          <div><dt>{{ $copy['daily'] }}</dt><dd>{{ $copy['support'] }}</dd></div>
        </dl>
        <ul class="hn-check-list">
          <li>{{ $copy['daily'] }}</li><li>{{ $copy['luggage'] }}</li><li>{{ $copy['support'] }}</li>
        </ul>
        <a class="hn-button hn-button--primary" href="#departures">{{ $copy['view_departures'] }}</a>
      </div>
    </article>
  </section>

  <section id="departures" class="hn-section hn-section--mist" aria-labelledby="departure-title">
    <div class="hn-shell">
      <div class="hn-section-heading">
        <p class="hn-eyebrow hn-eyebrow--green">{{ $copy['schedule_kicker'] }}</p>
        <h2 id="departure-title">{{ $copy['schedule_title'] }}</h2>
        <p>{{ $copy['schedule_text'] }}</p>
      </div>
      <div class="hn-schedule" role="region" aria-label="Available departures">
        <div class="hn-schedule__head"><span>{{ $copy['departure'] }}</span><span>{{ $copy['vehicle'] }}</span><span>{{ $copy['price'] }}</span><span></span></div>
        @forelse($popularSchedules->take(6) as $schedule)
        <article class="hn-schedule__row">
          <strong>{{ $schedule->departure_time->format('H:i') }}</strong>
          <span>{{ $schedule->vehicle_type ?: 'Sleeper cabin' }}</span>
          <span>{{ number_format($schedule->price ?: $route?->price_from ?? 220000) }} VND</span>
          <a href="{{ route('booking.search', ['route_id' => $schedule->route_id, 'departDate' => now()->format('d-m-Y')]) }}">{{ $copy['choose'] }}</a>
        </article>
        @empty
        <p class="hn-empty">{{ $copy['schedule_text'] }}</p>
        @endforelse
      </div>
    </div>
  </section>

  <section id="pickup" class="hn-section hn-shell hn-pickup" aria-labelledby="pickup-title">
    <div class="hn-pickup__visual" aria-hidden="true"><img src="{{ $routeImage }}" alt=""></div>
    <div>
      <p class="hn-eyebrow hn-eyebrow--green">{{ $copy['pickup_kicker'] }}</p>
      <h2 id="pickup-title">{{ $copy['pickup_title'] }}</h2>
      <p class="hn-lead">{{ $copy['pickup_text'] }}</p>
      <ol class="hn-info-list">
        @foreach([[$copy['pickup_1_title'], $copy['pickup_1_text']], [$copy['pickup_2_title'], $copy['pickup_2_text']], [$copy['pickup_3_title'], $copy['pickup_3_text']]] as [$title, $text])
        <li><strong>{{ $title }}</strong><span>{{ $text }}</span></li>
        @endforeach
      </ol>
    </div>
  </section>

  <section class="hn-section hn-section--mist" aria-labelledby="steps-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--center"><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['how_kicker'] }}</p><h2 id="steps-title">{{ $copy['how_title'] }}</h2></div>
      <ol class="hn-steps">
        @foreach([[$copy['step_1'], $copy['step_1_text']], [$copy['step_2'], $copy['step_2_text']], [$copy['step_3'], $copy['step_3_text']]] as $index => [$title, $text])
        <li><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
        @endforeach
      </ol>
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

  <section class="hn-final" aria-labelledby="final-title">
    <div class="hn-shell hn-final__content"><div><h2 id="final-title">{{ $copy['final_title'] }}</h2><p>{{ $copy['final_text'] }}</p></div><div><a class="hn-button hn-button--gold" href="#booking">{{ $copy['book'] }}</a><a class="hn-contact" href="{{ route('contact') }}">{{ $copy['contact'] }}</a></div></div>
  </section>
</main>

<footer class="hn-footer"><div class="hn-shell"><span>© {{ now()->year }} Nhat Duong</span><span>{{ $copy['footer'] }}</span></div></footer>

<style>
  :root { --hn-green:#0b7f42; --hn-deep:#062d1c; --hn-gold:#fbb116; --hn-ink:#18332a; --hn-muted:#62766c; --hn-mist:#f5f9f5; --hn-line:#d9e5dc; }
  * { box-sizing:border-box; } html { scroll-behavior:smooth; } body.home-new { margin:0; color:var(--hn-ink); background:#fff; font-family:Inter,system-ui,sans-serif; } .hn-shell { width:min(1160px, calc(100% - 40px)); margin:auto; }
  .hn-header { position:sticky; top:0; z-index:20; background:rgba(255,255,255,.96); border-bottom:1px solid rgba(6,45,28,.1); backdrop-filter:blur(14px); } .hn-nav-wrap { min-height:70px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
  .hn-brand { display:flex; align-items:center; gap:9px; color:var(--hn-deep); text-decoration:none; font-weight:800; white-space:nowrap; } .hn-brand img { width:34px; height:34px; object-fit:contain; } .hn-nav { display:flex; gap:20px; } .hn-nav a,.hn-contact { color:var(--hn-muted); text-decoration:none; font-size:14px; font-weight:600; } .hn-nav a:hover,.hn-contact:hover { color:var(--hn-green); }
  .hn-actions,.hn-locale { display:flex; align-items:center; gap:8px; } .hn-locale { padding:3px; border:1px solid var(--hn-line); border-radius:8px; } .hn-locale a { padding:5px 7px; color:var(--hn-muted); text-decoration:none; font-size:11px; font-weight:800; border-radius:5px; } .hn-locale a[aria-current="page"] { color:#fff; background:var(--hn-deep); }
  .hn-button { display:inline-flex; justify-content:center; align-items:center; min-height:44px; padding:11px 18px; border:0; border-radius:8px; font:700 14px Inter,sans-serif; text-decoration:none; cursor:pointer; transition:transform .18s ease, background .18s ease; } .hn-button:hover { transform:translateY(-1px); } .hn-button--primary { color:#fff; background:var(--hn-green); } .hn-button--gold { color:#5d4300; background:var(--hn-gold); }
  .hn-hero { position:relative; isolation:isolate; overflow:hidden; min-height:650px; display:grid; align-items:center; color:#fff; } .hn-hero__image,.hn-hero__overlay { position:absolute; inset:0; width:100%; height:100%; } .hn-hero__image { z-index:-2; object-fit:cover; } .hn-hero__overlay { z-index:-1; background:linear-gradient(90deg,rgba(4,35,22,.88),rgba(4,35,22,.58) 58%,rgba(4,35,22,.22)); }
  .hn-hero__content { padding:80px 0 48px; } .hn-hero__copy { max-width:690px; } .hn-eyebrow { margin:0 0 14px; color:#d6f1df; font-size:12px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; } .hn-eyebrow--green { color:var(--hn-green); } h1,h2,h3,p { margin-top:0; } h1 { max-width:780px; margin-bottom:18px; font-size:clamp(38px,5vw,64px); line-height:1.05; letter-spacing:-.045em; } h2 { margin-bottom:12px; color:var(--hn-deep); font-size:clamp(30px,3.4vw,46px); line-height:1.1; letter-spacing:-.035em; } .hn-hero__copy > p:not(.hn-eyebrow),.hn-lead { max-width:610px; color:rgba(255,255,255,.88); font-size:18px; line-height:1.6; }
  .hn-booking { margin-top:34px; max-width:1120px; color:var(--hn-ink); background:#fff; border-radius:16px; box-shadow:0 18px 50px rgba(0,0,0,.18); } .hn-booking fieldset { margin:0; padding:20px; border:0; } .hn-booking legend { padding:0 0 12px; font-size:14px; font-weight:800; } .hn-trip-type { display:flex; gap:8px; margin-bottom:16px; } .hn-trip-type label { cursor:pointer; } .hn-trip-type input { position:absolute; opacity:0; } .hn-trip-type span { display:block; padding:8px 12px; border:1px solid var(--hn-line); border-radius:8px; color:var(--hn-muted); font-size:13px; font-weight:700; } .hn-trip-type input:checked + span { color:var(--hn-green); border-color:var(--hn-green); background:#e8f8ef; }
  .hn-booking__fields { display:grid; grid-template-columns:1.25fr 1.25fr 1fr .7fr auto; gap:10px; } .hn-booking label { display:grid; gap:5px; color:var(--hn-muted); font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; } .hn-booking select,.hn-booking input { width:100%; min-height:44px; padding:0 11px; color:var(--hn-ink); background:#fff; border:1px solid var(--hn-line); border-radius:8px; font:600 14px Inter,sans-serif; text-transform:none; } .hn-booking #hn-return-field:not([hidden]) { display:grid; }
  .hn-trust { display:flex; flex-wrap:wrap; gap:20px; padding:21px 0 0; margin:0; list-style:none; font-size:13px; font-weight:700; } .hn-trust li { display:flex; align-items:center; gap:8px; } .hn-trust svg { width:17px; height:17px; fill:none; stroke:#f8d478; stroke-width:2; }
  .hn-section { padding:96px 0; } .hn-section--mist { background:var(--hn-mist); } .hn-section-heading { max-width:700px; margin-bottom:34px; } .hn-section-heading > p:not(.hn-eyebrow) { color:var(--hn-muted); line-height:1.6; } .hn-section-heading--center { margin-inline:auto; text-align:center; }
  .hn-route-card { display:grid; grid-template-columns:1.05fr .95fr; overflow:hidden; background:#fff; border:1px solid var(--hn-line); border-radius:16px; box-shadow:0 12px 32px rgba(11,127,66,.09); } .hn-route-card>img { min-height:370px; width:100%; height:100%; object-fit:cover; } .hn-route-card__content { padding:38px; } .hn-route-card dl { display:grid; grid-template-columns:1fr 1fr; gap:22px 16px; margin:0 0 26px; } .hn-route-card dt { margin-bottom:5px; color:var(--hn-muted); font-size:12px; font-weight:700; } .hn-route-card dd { margin:0; color:var(--hn-deep); font-size:18px; font-weight:800; } .hn-check-list { display:grid; gap:11px; padding:0; margin:0 0 28px; list-style:none; color:#365145; font-size:14px; font-weight:600; } .hn-check-list li::before { content:'✓'; margin-right:9px; color:#9a7000; font-weight:900; }
  .hn-schedule { overflow:hidden; background:#fff; border:1px solid var(--hn-line); border-radius:16px; } .hn-schedule__head,.hn-schedule__row { display:grid; grid-template-columns:.7fr 1.4fr 1fr auto; gap:16px; align-items:center; padding:18px 24px; } .hn-schedule__head { color:var(--hn-muted); background:#eef6ef; font-size:11px; font-weight:800; letter-spacing:.07em; text-transform:uppercase; } .hn-schedule__row { border-top:1px solid var(--hn-line); } .hn-schedule__row strong { color:var(--hn-deep); font-size:20px; } .hn-schedule__row span { color:#476156; font-size:14px; font-weight:600; } .hn-schedule__row a { color:var(--hn-green); font-size:13px; font-weight:800; text-decoration:none; } .hn-empty { padding:24px; color:var(--hn-muted); }
  .hn-pickup { display:grid; grid-template-columns:.85fr 1.15fr; gap:72px; align-items:center; } .hn-pickup__visual { min-height:430px; overflow:hidden; border-radius:16px; } .hn-pickup__visual img { width:100%; height:100%; object-fit:cover; } .hn-pickup .hn-lead { color:var(--hn-muted); font-size:16px; } .hn-info-list { display:grid; gap:18px; padding:0; margin:30px 0 0; list-style:none; counter-reset:info; } .hn-info-list li { position:relative; padding-left:52px; counter-increment:info; } .hn-info-list li::before { content:'0' counter(info); position:absolute; left:0; top:0; display:grid; place-items:center; width:34px; height:34px; color:#7b5a00; background:#fef3d7; border-radius:50%; font-size:11px; font-weight:800; } .hn-info-list strong,.hn-info-list span { display:block; } .hn-info-list strong { margin-bottom:4px; color:var(--hn-deep); } .hn-info-list span { color:var(--hn-muted); font-size:14px; line-height:1.55; }
  .hn-steps { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; padding:0; margin:0; list-style:none; } .hn-steps li { padding:28px; background:#fff; border:1px solid var(--hn-line); border-radius:16px; } .hn-steps span { color:#9a7000; font-size:12px; font-weight:800; letter-spacing:.1em; } .hn-steps h3 { margin:20px 0 9px; color:var(--hn-deep); font-size:20px; } .hn-steps p { margin:0; color:var(--hn-muted); font-size:14px; line-height:1.6; }
  .hn-faq { border-top:1px solid var(--hn-line); } .hn-faq details { padding:20px 0; border-bottom:1px solid var(--hn-line); } .hn-faq summary { cursor:pointer; color:var(--hn-deep); font-size:16px; font-weight:700; } .hn-faq p { max-width:750px; margin:12px 0 0; color:var(--hn-muted); line-height:1.6; }
  .hn-final { padding:68px 0; color:#fff; background:var(--hn-deep); } .hn-final__content { display:flex; align-items:center; justify-content:space-between; gap:28px; } .hn-final h2 { margin-bottom:10px; color:#fff; } .hn-final p { margin:0; color:rgba(255,255,255,.75); } .hn-final__content>div:last-child { display:flex; align-items:center; gap:18px; } .hn-final .hn-contact { color:#fff; font-weight:700; } .hn-footer { padding:24px 0; color:#6c7f74; background:#fff; font-size:13px; } .hn-footer .hn-shell { display:flex; justify-content:space-between; gap:16px; }
  @media (max-width:900px) { .hn-nav { display:none; } .hn-booking__fields { grid-template-columns:1fr 1fr; } .hn-booking__fields .hn-button { grid-column:span 2; } .hn-route-card,.hn-pickup { grid-template-columns:1fr; } .hn-route-card>img { min-height:280px; } .hn-pickup { gap:32px; } .hn-pickup__visual { min-height:280px; } .hn-steps { grid-template-columns:1fr; } }
  @media (max-width:620px) { .hn-shell { width:min(100% - 28px, 1160px); } .hn-nav-wrap { min-height:62px; } .hn-actions .hn-button { display:none; } .hn-brand span { display:none; } .hn-hero { min-height:640px; } .hn-hero__overlay { background:rgba(4,35,22,.72); } .hn-hero__content { padding:66px 0 32px; } h1 { font-size:38px; } .hn-booking fieldset { padding:15px; } .hn-booking__fields { grid-template-columns:1fr; } .hn-booking__fields .hn-button { grid-column:auto; } .hn-trust { gap:12px; font-size:12px; } .hn-section { padding:68px 0; } .hn-route-card__content { padding:25px; } .hn-route-card dl { grid-template-columns:1fr; gap:14px; } .hn-schedule__head { display:none; } .hn-schedule__row { grid-template-columns:1fr 1fr; padding:17px; } .hn-schedule__row a { grid-column:span 2; } .hn-footer .hn-shell,.hn-final__content,.hn-final__content>div:last-child { align-items:flex-start; flex-direction:column; } }
  @media (prefers-reduced-motion:reduce) { html { scroll-behavior:auto; } *,*::before,*::after { transition-duration:.01ms!important; animation-duration:.01ms!important; animation-iteration-count:1!important; } }
</style>
<script>
  (() => {
    const form = document.querySelector('.hn-booking');
    if (!form) return;

    const depart = document.getElementById('hn-depart-date');
    const returned = document.getElementById('hn-return-date');
    const departValue = document.getElementById('hn-depart-date-value');
    const returnValue = document.getElementById('hn-return-date-value');
    const roundTrip = document.getElementById('hn-round-trip-value');
    const returnField = document.getElementById('hn-return-field');
    const formatDate = (value) => value ? value.split('-').reverse().join('-') : '';

    const syncDates = () => {
      departValue.value = formatDate(depart.value);
      returnValue.value = formatDate(returned.value);
      returned.min = depart.value;
      if (returned.value < depart.value) returned.value = depart.value;
    };

    form.querySelectorAll('input[name="trip_type"]').forEach((input) => {
      input.addEventListener('change', () => {
        const enabled = input.value === 'round_trip' && input.checked;
        roundTrip.value = enabled ? '1' : '0';
        returnField.hidden = !enabled;
      });
    });

    depart.addEventListener('change', syncDates);
    returned.addEventListener('change', syncDates);
  })();
</script>
</body>
</html>
