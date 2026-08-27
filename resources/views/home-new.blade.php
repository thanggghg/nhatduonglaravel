<!doctype html>
<html lang="{{ $locale }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}">
  <title>Nhat Duong | {{ $locale === 'ru' ? 'Автобусы Хошимин - Нячанг' : ($locale === 'vi' ? 'Xe khách Sài Gòn - Nha Trang' : 'Ho Chi Minh City to Nha Trang buses') }}</title>
  <meta name="description" content="{{ $locale === 'ru' ? 'Расписание, места посадки и бронирование автобусов между Хошимином и Нячангом.' : ($locale === 'vi' ? 'Lịch chạy, điểm đón trả và đặt vé xe tuyến Sài Gòn - Nha Trang.' : 'Departures, pickup details, and online booking for buses between Ho Chi Minh City and Nha Trang.') }}">
  <link rel="canonical" href="{{ route('home', ['lang' => $locale]) }}">
  <link rel="alternate" hreflang="vi" href="{{ route('home', ['lang' => 'vi']) }}">
  <link rel="alternate" hreflang="en" href="{{ route('home', ['lang' => 'en']) }}">
  <link rel="alternate" hreflang="ru" href="{{ route('home', ['lang' => 'ru']) }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="home-new">
@php
  $copy = [
    'vi' => [
      'nav_routes' => 'Tuyến xe', 'nav_schedule' => 'Lịch chạy', 'nav_news' => 'Tin tức', 'nav_about' => 'Về chúng tôi', 'nav_contact' => 'Liên hệ',
      'book' => 'Đặt vé', 'hero_kicker' => 'Tuyến xe phòng chất lượng cao', 'hero_title' => 'Đặt vé Sài Gòn ⇔ Nha Trang',
      'hero_text' => 'Xem giờ chạy, chọn phòng và thanh toán trực tuyến.', 'one_way' => 'Một chiều', 'round_trip' => 'Khứ hồi',
      'from' => 'Điểm đi', 'to' => 'Điểm đến', 'date' => 'Ngày đi', 'passengers' => 'Số khách', 'search' => 'Tìm chuyến',
      'trust_1' => 'Xác nhận đặt vé', 'trust_2' => 'Xe phòng tiện nghi', 'trust_3' => 'Thông tin rõ ràng',
      'route_kicker' => 'Tuyến phổ biến', 'route_title' => 'Chuyến đi được chuẩn bị cho hành trình dài', 'from_price' => 'Giá từ', 'duration' => 'Thời gian đi',
       'view_departures' => 'Xem giờ khởi hành', 'route_details' => 'Xem chi tiết tuyến', 'daily' => 'Khởi hành mỗi ngày', 'luggage' => 'Hành lý theo quy định', 'support' => 'Hỗ trợ đặt vé',
      'schedule_kicker' => 'Chọn giờ phù hợp', 'schedule_title' => 'Các giờ khởi hành hằng ngày', 'schedule_text' => 'Giờ chạy, loại xe và giá vé được hiển thị trước khi bạn đặt.',
       'departure' => 'Khởi hành', 'vehicle' => 'Loại xe', 'vehicle_default' => 'Xe phòng', 'price' => 'Giá vé', 'seats' => 'chỗ còn lại', 'choose' => 'Chọn chuyến', 'choose_direction' => 'Chọn chiều đi', 'live_unavailable' => 'Lịch chạy trực tuyến đang tạm thời không khả dụng.',
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
      'news_kicker' => 'Tin tức mới', 'news_title' => 'Cập nhật cho hành trình tiếp theo', 'news_text' => 'Ưu đãi, thông tin dịch vụ và kinh nghiệm di chuyển từ Nhật Dương.', 'read_news' => 'Xem tất cả tin tức', 'read_article' => 'Đọc bài viết',
      'final_title' => 'Sẵn sàng chọn chuyến đi?', 'final_text' => 'Xem giờ chạy phù hợp và hoàn tất đặt vé trực tuyến.', 'contact' => 'Liên hệ hỗ trợ',
      'footer' => 'Tuyến vận chuyển hành khách Sài Gòn - Nha Trang.',
    ],
    'en' => [
      'nav_routes' => 'Routes', 'nav_schedule' => 'Schedule', 'nav_news' => 'News', 'nav_about' => 'About', 'nav_contact' => 'Contact',
      'book' => 'Book now', 'hero_kicker' => 'Premium sleeper bus service', 'hero_title' => 'Book Ho Chi Minh City ⇔ Nha Trang',
      'hero_text' => 'See live departures, choose your cabin, and pay online.', 'one_way' => 'One way', 'round_trip' => 'Round trip',
      'from' => 'From', 'to' => 'To', 'date' => 'Departure date', 'passengers' => 'Passengers', 'search' => 'Find departures',
      'trust_1' => 'Booking confirmation', 'trust_2' => 'Comfortable sleeper cabin', 'trust_3' => 'Clear trip details',
      'route_kicker' => 'Popular route', 'route_title' => 'Prepared for a comfortable long-distance journey', 'from_price' => 'From', 'duration' => 'Travel time',
       'view_departures' => 'View departures', 'route_details' => 'View route details', 'daily' => 'Daily departures', 'luggage' => 'Luggage policy available', 'support' => 'Booking support',
      'schedule_kicker' => 'Choose a suitable time', 'schedule_title' => 'Available daily departures', 'schedule_text' => 'Departure time, vehicle type, and fare are visible before you book.',
       'departure' => 'Departure', 'vehicle' => 'Vehicle', 'vehicle_default' => 'Sleeper cabin', 'price' => 'Fare', 'seats' => 'seats remaining', 'choose' => 'Select departure', 'choose_direction' => 'Choose direction', 'live_unavailable' => 'Live departures are temporarily unavailable.',
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
      'news_kicker' => 'Latest news', 'news_title' => 'Updates for your next journey', 'news_text' => 'Offers, service updates, and practical travel guidance from Nhat Duong.', 'read_news' => 'View all news', 'read_article' => 'Read article',
      'final_title' => 'Ready to choose your departure?', 'final_text' => 'See available times and complete your booking online.', 'contact' => 'Contact support',
      'footer' => 'Passenger service between Ho Chi Minh City and Nha Trang.',
    ],
    'ru' => [
      'nav_routes' => 'Маршруты', 'nav_schedule' => 'Расписание', 'nav_news' => 'Новости', 'nav_about' => 'О компании', 'nav_contact' => 'Контакты',
      'book' => 'Забронировать', 'hero_kicker' => 'Комфортные спальные автобусы', 'hero_title' => 'Билеты Хошимин ⇔ Нячанг',
      'hero_text' => 'Посмотрите рейсы, выберите купе и оплатите онлайн.', 'one_way' => 'В одну сторону', 'round_trip' => 'Туда и обратно',
      'from' => 'Откуда', 'to' => 'Куда', 'date' => 'Дата поездки', 'passengers' => 'Пассажиры', 'search' => 'Найти рейсы',
      'trust_1' => 'Подтверждение бронирования', 'trust_2' => 'Комфортный спальный салон', 'trust_3' => 'Понятные условия поездки',
      'route_kicker' => 'Популярный маршрут', 'route_title' => 'Всё подготовлено для комфортной дальней поездки', 'from_price' => 'Цена от', 'duration' => 'Время в пути',
       'view_departures' => 'Посмотреть рейсы', 'route_details' => 'Подробнее о маршруте', 'daily' => 'Рейсы каждый день', 'luggage' => 'Правила багажа доступны', 'support' => 'Помощь с бронированием',
      'schedule_kicker' => 'Выберите удобное время', 'schedule_title' => 'Ежедневные рейсы', 'schedule_text' => 'Время отправления, тип автобуса и цена видны до бронирования.',
       'departure' => 'Отправление', 'vehicle' => 'Автобус', 'vehicle_default' => 'Спальный салон', 'price' => 'Цена', 'seats' => 'мест осталось', 'choose' => 'Выбрать рейс', 'choose_direction' => 'Выберите направление', 'live_unavailable' => 'Актуальное расписание временно недоступно.',
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
      'news_kicker' => 'Новые материалы', 'news_title' => 'Обновления для следующей поездки', 'news_text' => 'Предложения, новости сервиса и полезные советы от Nhat Duong.', 'read_news' => 'Все новости', 'read_article' => 'Читать статью',
      'final_title' => 'Готовы выбрать рейс?', 'final_text' => 'Посмотрите доступное время и завершите бронирование онлайн.', 'contact' => 'Связаться с поддержкой',
      'footer' => 'Пассажирские перевозки между Хошимином и Нячангом.',
    ],
  ][$locale];

  $route = $ntRoute ?? $featuredRoutes->first();
  $routeDetailsUrl = $route ? route('routes.show', ['slug' => $route->slug, 'lang' => $locale]) : route('routes.index', ['lang' => $locale]);
  $heroBanner = ($banners ?? collect())->firstWhere('position', 'hero') ?? ($banners ?? collect())->first();
  $heroImage = $heroBanner && $heroBanner->hasImage() ? $heroBanner->image_url : asset('nha-xe-binh-minh-bus-2048x867.png');
  $routeImage = $route?->image ? asset('storage/'.$route->image) : $heroImage;
  $routeDuration = $route?->estimated_time ?? '9-10 hours';
  if ($locale === 'en') {
    $routeDuration = str_replace('giờ', 'h', $routeDuration);
  } elseif ($locale === 'ru') {
    $routeDuration = str_replace('giờ', 'ч.', $routeDuration);
  }
  $locations = [
    'TP. Hồ Chí Minh' => ['vi' => 'TP. Hồ Chí Minh', 'en' => 'Ho Chi Minh City', 'ru' => 'Хошимин'],
    'Cam Ranh' => ['vi' => 'Cam Ranh', 'en' => 'Cam Ranh', 'ru' => 'Камрань'],
    'Nha Trang' => ['vi' => 'Nha Trang', 'en' => 'Nha Trang', 'ru' => 'Нячанг'],
  ];
  $directionLabels = [
    'sg_nt' => ($locations['TP. Hồ Chí Minh'][$locale] ?? 'Ho Chi Minh City').' → '.($locations['Nha Trang'][$locale] ?? 'Nha Trang'),
    'nt_sg' => ($locations['Nha Trang'][$locale] ?? 'Nha Trang').' → '.($locations['TP. Hồ Chí Minh'][$locale] ?? 'Ho Chi Minh City'),
  ];
  $directionSchedules = $liveSchedulesByRoute ?? ['sg_nt' => $liveSchedules, 'nt_sg' => []];
  $selectedDirection = request('direction');
  $selectedDirection = array_key_exists($selectedDirection, $directionSchedules) ? $selectedDirection : 'sg_nt';
  $selectedSchedules = $directionSchedules[$selectedDirection] ?? [];
  $faqItems = [
    [$copy['faq_1_q'], $copy['faq_1_a']],
    [$copy['faq_2_q'], $copy['faq_2_a']],
    [$copy['faq_3_q'], $copy['faq_3_a']],
  ];
  $pickupPoints = $route?->pickupPoints ?? collect();
  $dropoffPoints = $route?->dropoffPoints ?? collect();
  $pickupLabels = [
    'vi' => ['pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ', 'support' => 'Cần xác nhận điểm đón?', 'support_text' => 'Liên hệ hỗ trợ trước ngày đi để xác nhận hành lý, điểm đón và chính sách đổi vé.'],
    'en' => ['pickup' => 'Pickup points', 'dropoff' => 'Drop-off points', 'map' => 'Open map', 'support' => 'Need to confirm a pickup point?', 'support_text' => 'Contact support before travel to confirm luggage, pickup details, and change policy.'],
    'ru' => ['pickup' => 'Места посадки', 'dropoff' => 'Места высадки', 'map' => 'Открыть карту', 'support' => 'Нужно подтвердить место посадки?', 'support_text' => 'Свяжитесь с поддержкой до поездки, чтобы уточнить багаж, посадку и условия изменения билета.'],
  ][$locale];
  $productCopy = [
    'vi' => ['live' => 'DỮ LIỆU CHUYẾN ĐI TRỰC TIẾP', 'fleet_kicker' => 'CHỌN CHUYẾN PHÙ HỢP', 'fleet_title' => 'Xem đúng loại xe trước khi đặt', 'fleet_text' => 'Giờ khởi hành, loại xe và giá vé được lấy trực tiếp cho ngày bạn chọn.', 'seat_map' => 'Sơ đồ ghế thực tế', 'seat_map_text' => 'Chọn ghế đang trống trước khi thanh toán.', 'stops' => 'Điểm đón, trả rõ ràng', 'stops_text' => 'Xem địa chỉ và thời gian theo từng chuyến.', 'payment' => 'Thanh toán có xác nhận', 'payment_text' => 'Nhận mã thanh toán và trạng thái giao dịch rõ ràng.', 'review_kicker' => 'PHẢN HỒI HÀNH KHÁCH', 'review_fallback' => 'Đội ngũ Nhật Dương luôn sẵn sàng hỗ trợ để hành trình của bạn rõ ràng và thuận tiện hơn.', 'support_call' => 'Gọi hỗ trợ', 'support_online' => 'Hỗ trợ đặt vé'],
    'en' => ['live' => 'LIVE TRIP DATA', 'fleet_kicker' => 'CHOOSE A SUITABLE TRIP', 'fleet_title' => 'See the actual vehicle before booking', 'fleet_text' => 'Departure time, vehicle type, and fare come directly from the selected travel date.', 'seat_map' => 'Live seat map', 'seat_map_text' => 'Choose an available seat before payment.', 'stops' => 'Clear pickup and drop-off points', 'stops_text' => 'See the address and time for each trip.', 'payment' => 'Confirmed payment', 'payment_text' => 'Receive a payment reference and clear transaction status.', 'review_kicker' => 'PASSENGER FEEDBACK', 'review_fallback' => 'The Nhat Duong team is ready to make your journey clearer and more comfortable.', 'support_call' => 'Call support', 'support_online' => 'Booking support'],
    'ru' => ['live' => 'АКТУАЛЬНЫЕ ДАННЫЕ О РЕЙСАХ', 'fleet_kicker' => 'ВЫБЕРИТЕ ПОДХОДЯЩИЙ РЕЙС', 'fleet_title' => 'Узнайте тип автобуса до бронирования', 'fleet_text' => 'Время отправления, тип автобуса и стоимость загружаются для выбранной даты.', 'seat_map' => 'Актуальная схема мест', 'seat_map_text' => 'Выберите свободное место до оплаты.', 'stops' => 'Понятные места посадки и высадки', 'stops_text' => 'Адрес и время указаны для каждого рейса.', 'payment' => 'Подтверждённая оплата', 'payment_text' => 'Получите код оплаты и понятный статус транзакции.', 'review_kicker' => 'ОТЗЫВЫ ПАССАЖИРОВ', 'review_fallback' => 'Команда Nhật Dương готова сделать вашу поездку понятнее и комфортнее.', 'support_call' => 'Позвонить в поддержку', 'support_online' => 'Помощь с бронированием'],
  ][$locale];
  $homeUi = [
    'vi' => ['where_go' => 'Bạn muốn đi đâu?', 'swap' => 'Đổi chiều', 'return_date' => 'Ngày về', 'optional' => 'Không bắt buộc', 'live_date' => 'Chuyến đang mở bán', 'today' => 'Hôm nay', 'frequency' => 'Nhiều chuyến mỗi ngày', 'arrival' => 'Đến', 'travel_time' => 'Thời gian', 'remaining' => 'Còn', 'view_all' => 'Xem tất cả giờ chạy', 'amenities' => ['Phòng riêng', 'WC', 'Sạc USB'], 'popular_stops' => 'Điểm đón, trả phổ biến', 'stops_text' => 'Địa chỉ chính xác và thời gian có mặt được xác nhận theo chuyến bạn chọn.', 'pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'map' => 'Mở bản đồ', 'assurance' => 'An tâm đặt vé', 'back_booking' => 'Về form đặt vé', 'call' => 'Gọi hỗ trợ', 'searching' => 'Đang tìm chuyến...'],
    'en' => ['where_go' => 'Where would you like to go?', 'swap' => 'Swap locations', 'return_date' => 'Return date', 'optional' => 'Optional', 'live_date' => 'Available departures', 'today' => 'Today', 'frequency' => 'Multiple daily departures', 'arrival' => 'Arrival', 'travel_time' => 'Duration', 'remaining' => 'Left', 'view_all' => 'View all departures', 'amenities' => ['Private cabin', 'WC', 'USB charging'], 'popular_stops' => 'Popular pickup and drop-off points', 'stops_text' => 'The exact address and check-in time are confirmed for your selected departure.', 'pickup' => 'Pickup', 'dropoff' => 'Drop-off', 'map' => 'Open map', 'assurance' => 'Book with confidence', 'back_booking' => 'Back to booking', 'call' => 'Call support', 'searching' => 'Finding departures...'],
    'ru' => ['where_go' => 'Куда вы хотите поехать?', 'swap' => 'Поменять местами', 'return_date' => 'Дата возвращения', 'optional' => 'Необязательно', 'live_date' => 'Доступные рейсы', 'today' => 'Сегодня', 'frequency' => 'Несколько рейсов ежедневно', 'arrival' => 'Прибытие', 'travel_time' => 'В пути', 'remaining' => 'Осталось', 'view_all' => 'Все рейсы', 'amenities' => ['Отдельное купе', 'WC', 'USB-зарядка'], 'popular_stops' => 'Популярные места посадки и высадки', 'stops_text' => 'Точный адрес и время регистрации подтверждаются для выбранного рейса.', 'pickup' => 'Посадка', 'dropoff' => 'Высадка', 'map' => 'Открыть карту', 'assurance' => 'Бронируйте уверенно', 'back_booking' => 'К форме бронирования', 'call' => 'Позвонить', 'searching' => 'Ищем рейсы...'],
  ][$locale];
  $fleetTrips = collect($selectedSchedules)->filter(fn ($schedule) => filled($schedule['vehicle_type'] ?? null))->unique('vehicle_type')->take(3);
  $startingFare = collect($directionSchedules)->flatten(1)->min('fare') ?: ($route?->price_from ?? 0);
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
          <div class="hn-booking__top">
            <legend>{{ $homeUi['where_go'] }}</legend>
            <span class="hn-live-proof"><i></i>{{ $productCopy['live'] }}</span>
          </div>
          <div class="hn-booking__fields">
            <label class="hn-location-field"><span>{{ $copy['from'] }}</span>
              <select id="hn-from-location" name="from_location" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 'TP. Hồ Chí Minh')>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <button id="hn-swap-locations" class="hn-swap" type="button" aria-label="{{ $homeUi['swap'] }}" title="{{ $homeUi['swap'] }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 7h12m0 0-3-3m3 3-3 3M17 17H5m0 0 3 3m-3-3 3-3"/></svg>
            </button>
            <label class="hn-location-field"><span>{{ $copy['to'] }}</span>
              <select id="hn-to-location" name="to_location" required>
                @foreach($locations as $value => $labels)<option value="{{ $value }}" @selected($value === 'Nha Trang')>{{ $labels[$locale] }}</option>@endforeach
              </select>
            </label>
            <label class="hn-depart-date-field"><span>{{ $copy['date'] }}</span><input id="hn-depart-date" type="date" value="{{ now()->toDateString() }}" min="{{ now()->toDateString() }}"></label>
            <label class="hn-return-date-field"><span>{{ $homeUi['return_date'] }} <small>{{ $homeUi['optional'] }}</small></span><input id="hn-return-date" type="date" min="{{ now()->addDay()->toDateString() }}"></label>
            <label><span>{{ $copy['passengers'] }}</span>
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
      <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['route_kicker'] }}</p><h2 id="route-title">{{ $locations['TP. Hồ Chí Minh'][$locale] }} ⇔ {{ $locations['Nha Trang'][$locale] }}</h2></div>
      <dl>
        <div><dt>{{ $copy['from_price'] }}</dt><dd>{{ number_format($startingFare) }} VND</dd></div>
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
        <span class="hn-date-badge"><small>{{ $homeUi['live_date'] }}</small><strong>{{ now()->format('d/m/Y') }}</strong></span>
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
                <div class="hn-departure-card__fare"><span>{{ $copy['price'] }}</span><strong>{{ number_format($schedule['fare']) }} VND</strong></div>
                <a class="hn-departure-card__action" href="{{ $schedule['checkout_url'] }}">{{ $copy['choose'] }} <span aria-hidden="true">→</span></a>
              </article>
            @empty
              <p class="hn-empty">{{ $copy['live_unavailable'] }}</p>
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
      <div class="hn-fleet__grid">
        @forelse($fleetTrips as $trip)
          <a class="hn-fleet-card" href="{{ $trip['checkout_url'] }}" aria-label="{{ $copy['choose'] }}: {{ $trip['vehicle_type'] }}">
            <img src="{{ $trip['image'] ?: $routeImage }}" alt="{{ $trip['vehicle_type'] }}" loading="lazy">
            <div class="hn-fleet-card__overlay"></div>
            <div class="hn-fleet-card__content">
              <p>{{ $trip['departure']->format('H:i') }} · {{ $trip['available_seats'] }} {{ $copy['seats'] }}</p>
              <h3>{{ $trip['vehicle_type'] }}</h3>
              <ul>@foreach($homeUi['amenities'] as $amenity)<li>{{ $amenity }}</li>@endforeach</ul>
              <div><strong>{{ number_format($trip['fare']) }} VND</strong><span>{{ $copy['choose'] }} →</span></div>
            </div>
          </a>
        @empty
          <a class="hn-fleet-card" href="#booking"><img src="{{ $routeImage }}" alt="{{ $copy['vehicle_default'] }}" loading="lazy"><div class="hn-fleet-card__overlay"></div><div class="hn-fleet-card__content"><p>{{ $copy['daily'] }}</p><h3>{{ $copy['vehicle_default'] }}</h3><div><strong>{{ number_format($startingFare) }} VND</strong><span>{{ $copy['search'] }} →</span></div></div></a>
        @endforelse
      </div>
    </div>
  </section>

  <section class="hn-proof" aria-labelledby="assurance-title">
    <div class="hn-shell"><p class="hn-eyebrow" id="assurance-title">{{ $homeUi['assurance'] }}</p><div class="hn-proof__grid">
      @foreach([[$productCopy['seat_map'], $productCopy['seat_map_text']], [$productCopy['stops'], $productCopy['stops_text']], [$productCopy['payment'], $productCopy['payment_text']]] as $index => [$title, $text])
        <article><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></article>
      @endforeach
    </div></div>
  </section>

  <section id="pickup" class="hn-section hn-stops" aria-labelledby="stops-title">
    <div class="hn-shell">
      <div class="hn-section-heading hn-section-heading--split">
        <div><p class="hn-eyebrow hn-eyebrow--green">{{ $copy['pickup_kicker'] }}</p><h2 id="stops-title">{{ $homeUi['popular_stops'] }}</h2></div>
        <p>{{ $homeUi['stops_text'] }}</p>
      </div>
      <div class="hn-stops__grid">
        <article class="hn-stop-card">
          <div class="hn-stop-card__head"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg><div><span>{{ $homeUi['pickup'] }}</span><h3>{{ $pickupPoints->first()?->name ?? $locations['TP. Hồ Chí Minh'][$locale] }}</h3></div></div>
          @if($pickupPoints->first()?->address)<p>{{ $pickupPoints->first()->address }}</p>@endif
          @if($pickupPoints->first()?->phone)<a href="tel:{{ $pickupPoints->first()->phone }}">{{ $pickupPoints->first()->phone }}</a>@endif
          @if($pickupPoints->first()?->map_url)<a href="{{ $pickupPoints->first()->map_url }}" target="_blank" rel="noopener">{{ $homeUi['map'] }} →</a>@endif
        </article>
        <article class="hn-stop-card">
          <div class="hn-stop-card__head"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/><circle cx="12" cy="10" r="2"/></svg><div><span>{{ $homeUi['dropoff'] }}</span><h3>{{ $dropoffPoints->first()?->name ?? $locations['Nha Trang'][$locale] }}</h3></div></div>
          @if($dropoffPoints->first()?->address)<p>{{ $dropoffPoints->first()->address }}</p>@endif
          @if($dropoffPoints->first()?->phone)<a href="tel:{{ $dropoffPoints->first()->phone }}">{{ $dropoffPoints->first()->phone }}</a>@endif
          @if($dropoffPoints->first()?->map_url)<a href="{{ $dropoffPoints->first()->map_url }}" target="_blank" rel="noopener">{{ $homeUi['map'] }} →</a>@endif
        </article>
        <aside class="hn-stop-support"><p>{{ $pickupLabels['support'] }}</p><strong>1900 2879</strong><span>{{ $pickupLabels['support_text'] }}</span><a class="hn-button hn-button--gold" href="{{ $supportHref }}">{{ $homeUi['call'] }}</a></aside>
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
  .hn-hero h1 { max-width:760px; margin-bottom:14px; font-size:clamp(42px,5.2vw,68px); }
  .hn-hero__copy>p:not(.hn-eyebrow) { max-width:560px; font-size:17px; }
  .hn-booking { margin-top:28px; border:1px solid rgba(255,255,255,.25); border-radius:18px; }
  .hn-booking fieldset { padding:18px 20px 20px; }
  .hn-booking__top { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:12px; }
  .hn-booking legend { padding:0; font-family:'Be Vietnam Pro',Inter,sans-serif; font-size:16px; font-weight:800; }
  .hn-live-proof { margin:0!important; color:#326044!important; background:#eef8f0; border-color:#d4ead9; }
  .hn-live-proof i { background:var(--hn-green); box-shadow:0 0 0 4px rgba(11,127,66,.12); }
  .hn-booking__fields { display:grid; grid-template-columns:minmax(150px,1.05fr) 44px minmax(150px,1.05fr) minmax(130px,.72fr) minmax(130px,.72fr) minmax(120px,.55fr) auto; gap:10px; align-items:end; }
  .hn-booking label { gap:6px; }
  .hn-booking label>span:first-child { min-height:16px; }
  .hn-booking label>span small { margin-left:4px; color:#8a9a91; font-size:9px; font-weight:600; letter-spacing:0; text-transform:none; }
  .hn-booking select,.hn-booking input:not([type=hidden]) { min-height:48px; border-radius:9px; }
  #hn-depart-date,#hn-return-date { width:140px; }
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
  .hn-fleet { background:#fff; }
  .hn-fleet__grid { grid-template-columns:repeat(auto-fit,minmax(280px,360px)); justify-content:center; }
  .hn-fleet-card { position:relative; display:block; min-height:390px; overflow:hidden; color:#fff; background:var(--hn-deep); border-radius:15px; text-decoration:none; isolation:isolate; }
  .hn-fleet-card img,.hn-fleet-card__overlay { position:absolute; inset:0; width:100%; height:100%; }
  .hn-fleet-card img { z-index:-2; object-fit:cover; transition:transform .3s ease; }
  .hn-fleet-card__overlay { z-index:-1; background:linear-gradient(180deg,rgba(4,35,22,.05),rgba(4,35,22,.94)); }
  .hn-fleet-card:hover img { transform:scale(1.035); }
  .hn-fleet-card__content { position:absolute; right:0; bottom:0; left:0; padding:24px; }
  .hn-fleet-card__content>p { margin:0 0 8px; color:var(--hn-gold); font-size:11px; font-weight:800; text-transform:uppercase; }
  .hn-fleet-card h3 { margin:0 0 13px; color:#fff; font-size:20px; line-height:1.3; }
  .hn-fleet-card ul { display:flex; flex-wrap:wrap; gap:6px; padding:0; margin:0 0 20px; list-style:none; }
  .hn-fleet-card li { padding:5px 8px; color:#d9efe0; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); border-radius:99px; font-size:10px; font-weight:700; }
  .hn-fleet-card__content>div { display:flex; align-items:center; justify-content:space-between; gap:16px; }
  .hn-fleet-card__content>div strong { color:#fff; font-size:16px; }
  .hn-fleet-card__content>div span { color:var(--hn-gold); font-size:12px; font-weight:800; }
  .hn-proof { padding:34px 0; }
  .hn-proof>.hn-shell>.hn-eyebrow { color:var(--hn-gold); margin-bottom:0; padding-top:22px; }
  .hn-proof__grid article { padding-top:22px; padding-bottom:22px; }
  .hn-stops { background:#fff; }
  .hn-stops__grid { display:grid; grid-template-columns:1fr 1fr .8fr; gap:16px; }
  .hn-stop-card,.hn-stop-support { min-height:230px; padding:24px; border:1px solid var(--hn-line); border-radius:14px; }
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
    #hn-depart-date,#hn-return-date { width:100%; }
    .hn-depart-date-field { grid-column:1/3; }
    .hn-return-date-field { grid-column:3; }
    .hn-booking__fields>label:last-of-type { grid-column:1; }
    .hn-search-button { grid-column:2/4; }
    .hn-route-summary__inner { grid-template-columns:1fr; gap:20px; }
    .hn-route-summary dl div:first-child { border-left:0; padding-left:0; }
    .hn-departure-card { grid-template-columns:80px 1fr 1fr; }
    .hn-departure-card__journey { display:none; }
    .hn-departure-card__fare { text-align:right; }
    .hn-departure-card__action { grid-column:2/4; }
    .hn-fleet__grid { grid-template-columns:repeat(2,1fr); }
    .hn-stops__grid { grid-template-columns:1fr 1fr; }
    .hn-stop-support { grid-column:1/-1; min-height:auto; }
    .hn-review__inner { grid-template-columns:1fr; gap:32px; }
  }
  @media(max-width:620px) {
    body.home-new { padding-bottom:72px; }
    .hn-header { position:sticky; }
    .hn-actions .hn-button { display:none; }
    .hn-hero { min-height:auto; }
    .hn-hero__content { padding:46px 0 28px; }
    .hn-hero h1 { font-size:34px; line-height:1.08; }
    .hn-hero__copy>p:not(.hn-eyebrow) { font-size:15px; }
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
    .hn-proof { padding:26px 0; }
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

    if (!form) return;

    const depart = document.getElementById('hn-depart-date');
    const returned = document.getElementById('hn-return-date');
    const departValue = document.getElementById('hn-depart-date-value');
    const returnValue = document.getElementById('hn-return-date-value');
    const roundTrip = document.getElementById('hn-round-trip-value');
    const fromLocation = document.getElementById('hn-from-location');
    const toLocation = document.getElementById('hn-to-location');
    const swapLocations = document.getElementById('hn-swap-locations');
    const passengerValue = document.getElementById('hn-passenger-value');
    const passengerCount = document.getElementById('hn-passenger-count');
    const formatDate = (value) => value ? value.split('-').reverse().join('-') : '';

    const syncDates = () => {
      returned.min = depart.value;
      if (returned.value && returned.value < depart.value) returned.value = depart.value;
      departValue.value = formatDate(depart.value);
      returnValue.value = formatDate(returned.value);
      roundTrip.value = returned.value ? '1' : '0';
    };

    depart.addEventListener('change', syncDates);
    returned.addEventListener('change', syncDates);
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
