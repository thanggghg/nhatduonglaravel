@extends('layouts.app')

@php
    $copy = [
        'vi' => ['back' => 'Quay lại danh sách chuyến', 'title' => 'Chọn chỗ và thông tin đặt vé', 'trip' => 'Chuyến đã chọn', 'passenger' => 'Thông tin hành khách', 'name' => 'Họ và tên', 'email' => 'Email', 'phone' => 'Số điện thoại', 'pickup' => 'Chọn điểm đón', 'dropoff' => 'Chọn điểm trả', 'seat_map' => 'Sơ đồ chỗ thực tế', 'available' => 'chỗ đang trống', 'selected' => 'Đã chọn', 'refresh' => 'Tự động cập nhật mỗi 30 giây', 'seat_error' => 'Chưa thể tải sơ đồ ghế thực tế. Vui lòng thử lại sau.', 'terms' => 'Tôi đồng ý với chính sách của Nhật Dương và để Nhật Dương xử lý thông tin đặt vé của mình.', 'pay' => 'Tiếp tục thanh toán', 'paying' => 'Đang tạo thanh toán...', 'total' => 'Tổng thanh toán', 'seats' => 'số chỗ', 'notes' => 'Ghi chú'],
        'en' => ['back' => 'Back to departures', 'title' => 'Choose seats and complete booking', 'trip' => 'Selected departure', 'passenger' => 'Passenger details', 'name' => 'Full name', 'email' => 'Email', 'phone' => 'Phone or WhatsApp', 'pickup' => 'Choose pickup point', 'dropoff' => 'Choose drop-off point', 'seat_map' => 'Live seat map', 'available' => 'seats available', 'selected' => 'Selected', 'refresh' => 'Availability refreshes every 30 seconds', 'seat_error' => 'The live seat map is temporarily unavailable. Please try again shortly.', 'terms' => "I agree to Nhat Duong's policies and authorize Nhat Duong to process my booking information.", 'pay' => 'Continue to payment', 'paying' => 'Creating payment...', 'total' => 'Total payment', 'seats' => 'seats', 'notes' => 'Notes'],
        'ru' => ['back' => 'Назад к рейсам', 'title' => 'Выберите места и завершите бронирование', 'trip' => 'Выбранный рейс', 'passenger' => 'Данные пассажира', 'name' => 'Полное имя', 'email' => 'Email', 'phone' => 'Телефон или WhatsApp', 'pickup' => 'Выберите место посадки', 'dropoff' => 'Выберите место высадки', 'seat_map' => 'Актуальная схема мест', 'available' => 'мест доступно', 'selected' => 'Выбрано', 'refresh' => 'Доступность обновляется каждые 30 секунд', 'seat_error' => 'Актуальная схема мест временно недоступна. Повторите попытку позже.', 'terms' => 'Я соглашаюсь с правилами Nhat Duong и разрешаю Nhat Duong обрабатывать информацию о моем бронировании.', 'pay' => 'Перейти к оплате', 'paying' => 'Создаем оплату...', 'total' => 'Сумма к оплате', 'seats' => 'мест', 'notes' => 'Комментарий'],
    ][$locale];
    $chosenSeats = old('selected_seats', []);
    $seatRefreshUrl = route('booking.live.seats', ['route_id' => $route->id, 'from_id' => $fromId, 'to_id' => $toId, 'trip_code' => $trip['code'], 'travel_date' => $date->toDateString(), 'passenger_count' => $passengerCount, 'lang' => $locale]);
    $availableCount = collect($seatMap)->flatMap(fn ($coach) => $coach['seats'])->filter(fn ($seat) => $seat['available'] && !$seat['locked'] && !in_array($seat['key'], $reservedSeats, true))->count();
    $roomSeats = collect($seatMap)->flatMap(fn ($coach) => $coach['seats'])->mapWithKeys(fn ($seat) => [$seat['key'] => [
        'options' => $seat['room_options'] ?? [],
        'color' => $seat['room_color'] ?? null,
    ]]);
    $checkoutUi = [
        'vi' => ['reassurance' => 'Chọn ghế và điểm đón, sau đó tiếp tục đến mã QR với đúng số tiền và nội dung chuyển khoản.', 'available' => 'Còn trống', 'selected' => 'Đã chọn', 'unavailable' => 'Không còn', 'payment' => 'Ở bước tiếp theo, bạn sẽ xem mã QR và mã chuyển khoản chính xác trước khi thanh toán.'],
        'en' => ['reassurance' => 'Choose seats and pickup details, then continue to a QR code with the exact amount and transfer reference.', 'available' => 'Available', 'selected' => 'Selected', 'unavailable' => 'Unavailable', 'payment' => 'On the next step, you will review the QR code and exact transfer reference before payment.'],
        'ru' => ['reassurance' => 'Выберите места и посадку, затем перейдите к QR-коду с точной суммой и назначением перевода.', 'available' => 'Свободно', 'selected' => 'Выбрано', 'unavailable' => 'Недоступно', 'payment' => 'На следующем шаге вы увидите QR-код и точное назначение перевода до оплаты.'],
    ][$locale];
    $paymentMethods = [
        'vi' => ['title' => 'Hình thức thanh toán', 'cash' => 'Tiền mặt/Chuyển khoản', 'cash_help' => 'Nhân viên sẽ liên hệ xác nhận.', 'cash_submit' => 'Hoàn tất đặt vé'],
        'en' => ['title' => 'Payment method', 'cash' => 'Cash/Bank transfer', 'cash_help' => 'Our team will contact you to confirm.', 'cash_submit' => 'Complete booking'],
        'ru' => ['title' => 'Способ оплаты', 'cash' => 'Наличные/Банковский перевод', 'cash_help' => 'Сотрудник свяжется с вами для подтверждения.', 'cash_submit' => 'Завершить бронирование'],
    ][$locale];
    $policyUi = [
        'vi' => [
            'kicker' => 'CẦN BIẾT TRƯỚC KHI ĐẶT', 'title' => 'Chính sách nhà xe', 'intro' => 'Vui lòng đọc các quy định quan trọng để chủ động chuẩn bị cho hành trình.',
            'sections' => [
                ['title' => 'Trẻ em và hành khách vị thành niên', 'bullets' => ['Trẻ từ 5 tuổi trở xuống (tính theo năm sinh) được miễn phí.', 'Trẻ từ 6 tuổi trở lên phải mua vé như người lớn.', 'Hành khách dưới 16 tuổi phải có cha mẹ hoặc người giám hộ đi cùng.']],
                ['title' => 'Trung chuyển và thời gian đến', 'bullets' => ['Khách đón tại Quận 1 trên chuyến từ 05:30 đến 22:00 cần có mặt trước giờ hiển thị 1 tiếng để đi xe trung chuyển.', 'Chuyến ban ngày có thể đến muộn 1–2 giờ so với lịch trình dự kiến.', 'Khách nước ngoài vui lòng cung cấp WhatsApp và kiểm tra email thường xuyên.']],
                ['title' => 'Hành lý, giường và thú cưng', 'bullets' => ['Phòng đơn: hành lý dưới 30 kg. Phòng đôi: hành lý dưới 40 kg.', 'Giường đôi dài 178 cm, rộng 85 cm, tải trọng tối đa 130 kg/giường; phòng đơn nhỏ 6D dài 167 cm.', 'Nhà xe không nhận vận chuyển động vật cảnh hoặc thú cưng.']],
            ],
            'cancellation' => ['title' => 'Hủy hoặc dời vé ngày thường', 'intro' => 'Không áp dụng trước, trong và sau các kỳ nghỉ lễ.', 'periods' => [
                ['time' => 'Trên 24 giờ', 'tone' => 'good', 'text' => 'Hủy vé miễn phí và được dời vé miễn phí 1 lần.'],
                ['time' => 'Từ 6–24 giờ', 'tone' => 'warning', 'text' => 'Phí hủy 30%. Vé giá gốc được dời 1 lần; vé coupon cần thanh toán phần chênh lệch.'],
                ['time' => 'Dưới 6 giờ', 'tone' => 'danger', 'text' => 'Phí hủy 100%, không được hủy hoặc dời vé.'],
            ], 'note' => 'Vé dùng mã giảm giá, coupon hoặc thuộc chương trình khuyến mãi không áp dụng chính sách hủy vé.'],
            'thanks' => 'Cần làm rõ chính sách? Liên hệ Nhật Dương trước khi hoàn tất đặt vé.',
        ],
        'en' => [
            'kicker' => 'IMPORTANT BEFORE BOOKING', 'title' => 'Operator policy', 'intro' => 'Please review these important rules so you can prepare for your journey.',
            'sections' => [
                ['title' => 'Children and minor passengers', 'bullets' => ['Children aged 5 and under (calculated by birth year) travel free of charge.', 'Children aged 6 and over require an adult ticket.', 'Passengers under 16 must travel with a parent or legal guardian.']],
                ['title' => 'Shuttle and arrival times', 'bullets' => ['Passengers picked up in District 1 on departures from 05:30 to 22:00 must arrive one hour before the displayed time for the shuttle.', 'Daytime departures may arrive 1–2 hours later than estimated.', 'International passengers should provide WhatsApp and check email regularly.']],
                ['title' => 'Luggage, beds and pets', 'bullets' => ['Single cabin: luggage under 30 kg. Double cabin: luggage under 40 kg.', 'Double bed: 178 × 85 cm, maximum 130 kg per bed; small single cabin 6D is 167 cm long.', 'The operator does not transport pets or companion animals.']],
            ],
            'cancellation' => ['title' => 'Weekday cancellation and rescheduling', 'intro' => 'Not applicable before, during, or after public holidays.', 'periods' => [
                ['time' => 'More than 24 hours', 'tone' => 'good', 'text' => 'Free cancellation and one free reschedule.'],
                ['time' => 'From 6–24 hours', 'tone' => 'warning', 'text' => '30% cancellation fee. Full-price tickets may be rescheduled once; coupon tickets require payment of the fare difference.'],
                ['time' => 'Less than 6 hours', 'tone' => 'danger', 'text' => '100% cancellation fee; cancellation and rescheduling are not permitted.'],
            ], 'note' => 'Tickets purchased with a discount code, coupon, or promotion are not eligible for cancellation.'],
            'thanks' => 'Need clarification? Contact Nhat Duong before completing your booking.',
        ],
        'ru' => [
            'kicker' => 'ВАЖНО ПЕРЕД БРОНИРОВАНИЕМ', 'title' => 'Правила перевозчика', 'intro' => 'Ознакомьтесь с важными правилами, чтобы подготовиться к поездке.',
            'sections' => [
                ['title' => 'Дети и несовершеннолетние пассажиры', 'bullets' => ['Дети до 5 лет включительно (по году рождения) путешествуют бесплатно.', 'Для детей с 6 лет требуется взрослый билет.', 'Пассажиры младше 16 лет должны путешествовать с родителем или законным опекуном.']],
                ['title' => 'Трансфер и время прибытия', 'bullets' => ['Пассажирам с посадкой в Районе 1 на рейсы с 05:30 до 22:00 нужно прибыть за час до указанного времени для трансфера.', 'Дневные рейсы могут прибыть на 1–2 часа позже расчётного времени.', 'Иностранным пассажирам следует указать WhatsApp и регулярно проверять email.']],
                ['title' => 'Багаж, спальные места и животные', 'bullets' => ['Одноместное купе: багаж до 30 кг. Двухместное купе: до 40 кг.', 'Двуспальная кровать: 178 × 85 см, до 130 кг на кровать; малое одноместное место 6D имеет длину 167 см.', 'Перевозчик не принимает к перевозке домашних животных.']],
            ],
            'cancellation' => ['title' => 'Отмена и перенос в обычные дни', 'intro' => 'Не применяется до, во время и после праздничных дней.', 'periods' => [
                ['time' => 'Более чем за 24 часа', 'tone' => 'good', 'text' => 'Бесплатная отмена и один бесплатный перенос.'],
                ['time' => 'За 6–24 часа', 'tone' => 'warning', 'text' => 'Комиссия за отмену 30%. Билет по полной цене можно перенести один раз; для билета с купоном требуется доплата разницы.'],
                ['time' => 'Менее чем за 6 часов', 'tone' => 'danger', 'text' => 'Комиссия 100%; отмена и перенос не допускаются.'],
            ], 'note' => 'Билеты со скидочным кодом, купоном или по акции не подлежат отмене.'],
            'thanks' => 'Нужны разъяснения? Свяжитесь с Nhat Duong до завершения бронирования.',
        ],
    ][$locale];
    $loadingCopy = [
        'vi' => ['title' => 'Đang giữ chỗ...', 'text' => 'Hệ thống đang giữ ghế và tạo mã thanh toán. Vui lòng không tắt trang.'],
        'en' => ['title' => 'Reserving your seats...', 'text' => 'We are holding your seats and creating the payment code. Please keep this page open.'],
        'ru' => ['title' => 'Бронируем места...', 'text' => 'Удерживаем места и создаем код оплаты. Не закрывайте страницу.'],
    ][$locale];
    $dynamicCopy = [
        'vi' => ['cabin' => 'Phòng', 'modal_help' => 'Chọn loại phòng và số người sử dụng.', 'cancel' => 'Hủy', 'room' => 'phòng', 'passenger' => 'hành khách', 'select_rooms' => 'Chọn phòng cho từng hành khách.', 'select_one' => 'Chọn ít nhất một phòng.', 'choose_options' => 'Chọn loại phòng', 'max_passengers' => 'Một lượt đặt vé chỉ gồm tối đa 6 hành khách.', 'select_exactly' => 'Vui lòng chọn phòng cho đúng :count hành khách.', 'select_seats' => 'Vui lòng chọn đủ :count ghế.', 'seat_taken' => 'Ghế vừa chọn đã có người đặt. Vui lòng chọn ghế khác.'],
        'en' => ['cabin' => 'Cabin', 'modal_help' => 'Choose the room type and occupancy.', 'cancel' => 'Cancel', 'room' => 'room', 'passenger' => 'passenger', 'select_rooms' => 'Select rooms for each passenger.', 'select_one' => 'Select at least one room.', 'choose_options' => 'Choose room options', 'max_passengers' => 'A booking can include up to 6 passengers.', 'select_exactly' => 'Select rooms for exactly :count passengers.', 'select_seats' => 'Please select :count seats.', 'seat_taken' => 'A selected seat was just taken. Please choose another seat.'],
        'ru' => ['cabin' => 'Купе', 'modal_help' => 'Выберите тип купе и количество пассажиров.', 'cancel' => 'Отмена', 'room' => 'купе', 'passenger' => 'пасс.', 'select_rooms' => 'Выберите купе для каждого пассажира.', 'select_one' => 'Выберите хотя бы одно купе.', 'choose_options' => 'Выберите тип купе', 'max_passengers' => 'В одном бронировании может быть не более 6 пассажиров.', 'select_exactly' => 'Выберите купе ровно для :count пассажиров.', 'select_seats' => 'Выберите необходимое количество мест: :count.', 'seat_taken' => 'Выбранное место только что заняли. Выберите другое место.'],
    ][$locale];
    $vndPerUsd = max(1, (int) config('services.currency.vnd_per_usd', 26000));
    $backUrl = route('booking.search', [
        'route_id' => $route->id,
        'from_id' => $fromId,
        'to_id' => $toId,
        'departDate' => $date->format('d-m-Y'),
        'is_round_trip' => $roundTripStage ? 1 : 0,
        'returnDate' => $returnDate?->format('d-m-Y'),
        'round_trip_outbound_reference' => $roundTripOutboundReference,
        'seats' => $passengerCount,
        'lang' => $locale,
    ]);
@endphp

@section('content')
<section class="live-checkout"><div class="live-checkout__shell"><a class="live-checkout__back" href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => $date->format('d-m-Y'), 'seats' => $passengerCount, 'lang' => $locale]) }}">&larr; {{ $copy['back'] }}</a><div class="live-checkout__grid"><main><h1>{{ $copy['title'] }}</h1><form id="live-booking-form" method="POST" action="{{ route('booking.live.store') }}">@csrf<input type="hidden" name="route_id" value="{{ $route->id }}"><input type="hidden" name="trip_code" value="{{ $trip['code'] }}"><input type="hidden" name="travel_date" value="{{ $date->toDateString() }}"><input type="hidden" name="passenger_count" value="{{ $passengerCount }}"><input type="hidden" name="lang" value="{{ $locale }}"><fieldset><legend>{{ $copy['seat_map'] }}</legend><div class="live-seat-head"><div><strong id="seat-selection-count">{{ count($chosenSeats) }}/{{ $passengerCount }}</strong><span>{{ $copy['selected'] }}</span></div><p><b id="live-available-seats">{{ $availableCount }}</b> {{ $copy['available'] }}<small>{{ $copy['refresh'] }}</small></p></div>@if($seatError)<p class="live-checkout__error">{{ $copy['seat_error'] }}</p>@else<div class="live-seat-layout">@foreach($seatMap as $coach)<section class="live-seat-coach"><h2>{{ $coach['name'] ?: 'Coach '.$coach['number'] }}</h2><div class="live-seat-grid" style="grid-template-columns:repeat({{ max(1, $coach['columns']) }}, minmax(36px,1fr));">@foreach($coach['seats'] as $seat)@php $unavailable = !$seat['available'] || $seat['locked'] || in_array($seat['key'], $reservedSeats, true); @endphp<label class="live-seat {{ $unavailable ? 'is-unavailable' : '' }}" style="grid-column:{{ $seat['column'] }} / span {{ $seat['column_span'] }};grid-row:{{ $seat['row'] }} / span {{ $seat['row_span'] }};"><input type="checkbox" name="selected_seats[]" value="{{ $seat['key'] }}" @checked(in_array($seat['key'], $chosenSeats, true)) @disabled($unavailable)><span>{{ $seat['code'] }}</span></label>@endforeach</div></section>@endforeach</div>@endif<p id="seat-selection-error" class="live-checkout__error" hidden></p></fieldset><fieldset><legend>{{ $copy['passenger'] }}</legend><label>{{ $copy['name'] }}<input name="passenger_name" value="{{ old('passenger_name') }}" autocomplete="name" required></label><div class="live-checkout__two"><label>{{ $copy['email'] }}<input type="email" name="passenger_email" value="{{ old('passenger_email') }}" autocomplete="email"></label><label>{{ $copy['phone'] }}<input type="tel" name="passenger_phone" value="{{ old('passenger_phone') }}" autocomplete="tel"></label></div></fieldset><fieldset><legend>{{ $copy['trip'] }}</legend><div class="live-stop-grid"><div><h2>{{ $copy['pickup'] }}</h2>@foreach($pickupOptions as $point)<label class="live-stop-option"><input type="radio" name="pickup_point" value="{{ $point->name }}" @checked(old('pickup_point', $trip['pickup']) === $point->name) required><span><b>{{ $point->name }}</b>@if($point->time)<small>{{ $point->time }}</small>@endif</span></label>@endforeach</div><div><h2>{{ $copy['dropoff'] }}</h2>@foreach($dropoffOptions as $point)<label class="live-stop-option"><input type="radio" name="dropoff_point" value="{{ $point->name }}" @checked(old('dropoff_point', $trip['dropoff']) === $point->name) required><span><b>{{ $point->name }}</b>@if($point->time)<small>{{ $point->time }}</small>@endif</span></label>@endforeach</div></div><label>{{ $copy['notes'] }}<input name="notes" value="{{ old('notes') }}" maxlength="1500"></label></fieldset><label class="live-checkout__terms"><input type="checkbox" name="terms" value="1" required><span>{{ $copy['terms'] }}</span></label>@foreach($errors->all() as $error)<p class="live-checkout__error" role="alert">{{ $error }}</p>@endforeach<button type="submit" data-loading="{{ $copy['paying'] }}" @disabled($seatError)>{{ $copy['pay'] }}</button></form></main><aside><p>{{ $copy['trip'] }}</p><h2>{{ $trip['pickup'] }} → {{ $trip['dropoff'] }}</h2><dl><div><dt>{{ $date->format('d/m/Y') }}</dt><dd>{{ $trip['departure']->format('H:i') }} → {{ $trip['arrival']->format('H:i') }} · {{ $trip['vehicle_type'] }}</dd></div><div><dt>{{ $passengerCount }} {{ $copy['seats'] }}</dt><dd>{{ number_format($trip['fare']) }} VND</dd></div></dl><div class="live-checkout__total"><span>{{ $copy['total'] }}</span><strong>{{ number_format($trip['fare'] * $passengerCount) }} VND</strong></div></aside></div></div></section>
<input type="hidden" name="from_id" value="{{ $fromId }}" form="live-booking-form">
<input type="hidden" name="to_id" value="{{ $toId }}" form="live-booking-form">
<input type="hidden" name="round_trip_stage" value="{{ $roundTripStage }}" form="live-booking-form">
<input type="hidden" name="return_travel_date" value="{{ $returnDate?->toDateString() }}" form="live-booking-form">
<input type="hidden" name="round_trip_outbound_reference" value="{{ $roundTripOutboundReference }}" form="live-booking-form">
<div id="live-booking-loading" class="live-booking-loading" hidden><div class="live-booking-loading__card"><span class="live-booking-loading__spinner" aria-hidden="true"></span><strong>{{ $loadingCopy['title'] }}</strong><p>{{ $loadingCopy['text'] }}</p></div></div>
@endsection

@push('styles')
<style>.live-checkout{min-height:70vh;padding:38px 0 64px;background:#f5faf4}.live-checkout__shell{width:min(1080px,calc(100% - 32px));margin:auto}.live-checkout__back{display:inline-block;margin-bottom:18px;color:#0b7f42;font-size:14px;font-weight:800;text-decoration:none}.live-checkout__grid{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:28px;align-items:start}.live-checkout main{padding:28px;background:#fff;border:1px solid #d9e5dc;border-radius:16px}.live-checkout h1{margin:0 0 24px;color:#173014;font-size:30px}.live-checkout form{display:grid;gap:20px}.live-checkout fieldset{display:grid;gap:14px;margin:0;padding:20px;border:1px solid #d9e5dc;border-radius:12px}.live-checkout legend{padding:0 6px;color:#173014;font-size:15px;font-weight:800}.live-checkout label{display:grid;gap:6px;color:#526b5c;font-size:12px;font-weight:800}.live-checkout input:not([type=checkbox]):not([type=radio]){width:100%;min-height:43px;padding:0 11px;color:#173014;background:#fff;border:1px solid #cddbd0;border-radius:8px;font:600 14px Inter,sans-serif}.live-checkout__two,.live-stop-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.live-checkout__terms{grid-template-columns:18px 1fr;align-items:start;font-size:13px!important;line-height:1.5}.live-checkout__terms input{width:16px;margin-top:2px}.live-checkout button{min-height:47px;border:0;border-radius:9px;background:#0b7f42;color:#fff;font:800 15px Inter,sans-serif;cursor:pointer}.live-checkout button:disabled{opacity:.5}.live-checkout__error{margin:0;color:#991b1b;font-size:13px;font-weight:700}.live-checkout aside{position:sticky;top:90px;padding:23px;background:#062d1c;color:#fff;border-radius:16px}.live-checkout aside>p{margin:0 0 7px;color:#c6e2ce;font-size:12px;font-weight:800;text-transform:uppercase}.live-checkout aside h2{margin:0 0 19px;font-size:21px}.live-checkout aside dl{display:grid;gap:13px;margin:0}.live-checkout aside dl div{display:grid;gap:4px}.live-checkout aside dt{color:#c6e2ce;font-size:12px}.live-checkout aside dd{margin:0;font-size:14px;font-weight:800}.live-checkout__total{display:grid;gap:4px;margin-top:22px;padding-top:18px;border-top:1px solid rgba(255,255,255,.18)}.live-checkout__total span{color:#c6e2ce;font-size:12px}.live-checkout__total strong{color:#f9b21a;font-size:25px}.live-seat-head{display:flex;align-items:center;justify-content:space-between;gap:18px}.live-seat-head strong{color:#087841;font-size:24px}.live-seat-head span{display:block;color:#6b8375;font-size:11px;font-weight:800;text-transform:uppercase}.live-seat-head p{margin:0;color:#537162;text-align:right;font-size:13px;font-weight:700}.live-seat-head b{color:#087841}.live-seat-head small{display:block;margin-top:3px;color:#81958a;font-weight:600}.live-seat-layout{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.live-seat-coach{padding:10px;border:1px solid #d9e6dc;border-radius:10px;background:#f8fbf8}.live-seat-coach h2,.live-stop-grid h2{margin:0 0 8px;color:#234837;font-size:12px}.live-seat-grid{display:grid;gap:5px}.live-seat{position:relative;display:block!important;cursor:pointer}.live-seat input{position:absolute;opacity:0}.live-seat span{display:grid;min-height:30px;place-items:center;border:1px solid #bcd4c3;border-radius:5px;color:#246345;background:#fff;font-size:10px;font-weight:900}.live-seat input:checked+span{border-color:#087841;color:#fff;background:#087841}.live-seat.is-unavailable{cursor:not-allowed}.live-seat.is-unavailable span{border-color:#e2c5bb;color:#9c4b38;background:#f8ece8;text-decoration:line-through}.live-stop-grid>div{display:grid;align-content:start;gap:8px}.live-stop-option{grid-template-columns:16px 1fr;align-items:start;padding:10px;border:1px solid #d7e5da;border-radius:8px;cursor:pointer}.live-stop-option input{margin:2px 0}.live-stop-option:has(input:checked){border-color:#0b7f42;background:#eff8f1}.live-stop-option b,.live-stop-option small{display:block}.live-stop-option b{color:#234837;font-size:13px}.live-stop-option small{margin-top:3px;color:#708679;font-weight:600}@media(max-width:760px){.live-checkout__grid{grid-template-columns:1fr}.live-checkout aside{position:static}.live-checkout__two,.live-stop-grid{grid-template-columns:1fr}}@media(max-width:520px){.live-seat-layout{grid-template-columns:1fr}.live-checkout main{padding:18px}.live-seat-head{align-items:start;flex-direction:column}.live-seat-head p{text-align:left}}</style>
<style>.live-stop-grid>div{max-height:420px;overflow-y:auto;padding-right:6px;scrollbar-width:thin;scrollbar-color:#8db69a #edf5ee}.live-stop-grid>div::-webkit-scrollbar{width:7px}.live-stop-grid>div::-webkit-scrollbar-track{background:#edf5ee;border-radius:999px}.live-stop-grid>div::-webkit-scrollbar-thumb{background:#8db69a;border-radius:999px}@media(max-width:760px){.live-stop-grid>div{max-height:340px}}</style>
<style>.live-checkout__reassurance{display:flex;gap:9px;margin:-10px 0 2px;padding:11px 12px;color:#365145;background:#f2faf4;border-left:3px solid #0b7f42;border-radius:7px;font-size:12px;font-weight:650;line-height:1.55}.live-checkout__reassurance svg{width:17px;height:17px;flex:0 0 17px;margin-top:1px;fill:none;stroke:#0b7f42;stroke-linecap:round;stroke-linejoin:round;stroke-width:2}.live-seat-legend{display:flex;flex-wrap:wrap;gap:11px;margin-top:2px;color:#60776a;font-size:11px;font-weight:700}.live-seat-legend span{display:inline-flex;align-items:center;gap:5px}.live-seat-legend i{width:10px;height:10px;border:1px solid #bcd4c3;border-radius:3px;background:#fff}.live-seat-legend .is-selected{border-color:#087841;background:#087841}.live-seat-legend .is-unavailable{border-color:#e2c5bb;background:#f8ece8}.live-checkout__payment-note{display:flex;gap:8px;margin:0;color:#526b5c;font-size:12px;line-height:1.5}.live-checkout__payment-note svg{width:16px;flex:0 0 16px;fill:none;stroke:#0b7f42;stroke-linecap:round;stroke-linejoin:round;stroke-width:2}@media(max-width:520px){.live-checkout input:not([type=checkbox]):not([type=radio]){font-size:16px}.live-seat span{min-height:44px;font-size:11px}}</style>
@endpush

@push('scripts')
<script>(() => { const form = document.getElementById('live-booking-form'); const inputs = [...document.querySelectorAll('input[name="selected_seats[]"]')]; const count = {{ $passengerCount }}; const countLabel = document.getElementById('seat-selection-count'); const error = document.getElementById('seat-selection-error'); const available = document.getElementById('live-available-seats'); const refreshUrl = {!! json_encode($seatRefreshUrl) !!}; const selected = () => inputs.filter((input) => input.checked); const sync = (changed) => { if (selected().length > count && changed) changed.checked = false; countLabel.textContent = `${selected().length}/${count}`; error.hidden = selected().length === count; if (!error.hidden) error.textContent = `Please select ${count} seat${count > 1 ? 's' : ''}.`; }; inputs.forEach((input) => input.addEventListener('change', () => sync(input))); const refresh = async () => { try { const response = await fetch(refreshUrl, {headers:{Accept:'application/json'}}); if (!response.ok) return; const data = await response.json(); available.textContent = data.available_seats; const remoteSeats = data.coaches.flatMap((coach) => coach.seats); const seats = new Map(remoteSeats.map((seat) => [seat.key, seat])); inputs.forEach((input) => { const seat = seats.get(input.value); const unavailable = !seat || !seat.available || seat.locked || data.reserved_seats.includes(input.value); const card = input.closest('.live-seat'); if (unavailable && input.checked) { input.checked = false; error.hidden = false; error.textContent = 'A selected seat was just taken. Please choose another seat.'; } input.disabled = unavailable; card.classList.toggle('is-unavailable', unavailable); }); sync(); } catch (_) {} }; if (form) form.addEventListener('submit', (event) => { if (selected().length !== count) { event.preventDefault(); sync(); return; } const button = form.querySelector('button[type="submit"]'); button.disabled = true; button.textContent = button.dataset.loading; }); sync(); window.setInterval(refresh, 30000); })();</script>
@endpush

@push('scripts')
<script>(() => { const ui = @json($checkoutUi); const title = document.querySelector('.live-checkout main > h1'); const head = document.querySelector('.live-seat-head'); const form = document.getElementById('live-booking-form'); const error = document.getElementById('seat-selection-error'); if (title) title.insertAdjacentHTML('afterend', `<p class="live-checkout__reassurance"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg><span>${ui.reassurance}</span></p>`); if (head) head.insertAdjacentHTML('afterend', `<div class="live-seat-legend" aria-label="Seat availability"><span><i></i>${ui.available}</span><span><i class="is-selected"></i>${ui.selected}</span><span><i class="is-unavailable"></i>${ui.unavailable}</span></div>`); if (error) { error.setAttribute('role', 'alert'); error.setAttribute('aria-live', 'assertive'); } const submit = form?.querySelector('button[type="submit"]'); if (submit) submit.insertAdjacentHTML('beforebegin', `<p class="live-checkout__payment-note"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4.5 6v5c0 4.5 3.1 8.6 7.5 10 4.4-1.4 7.5-5.5 7.5-10V6L12 3Z"/></svg><span>${ui.payment}</span></p>`); })();</script>
@endpush

@push('scripts')
<script>(() => { const rooms = @json($roomSeats); const form = document.getElementById('live-booking-form'); const inputs = [...document.querySelectorAll('input[name="selected_seats[]"]')]; const passengerCount = {{ $passengerCount }}; const countLabel = document.getElementById('seat-selection-count'); const error = document.getElementById('seat-selection-error'); const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); const selected = () => inputs.filter((input) => input.checked); const summary = document.createElement('p'); summary.className = 'live-room-summary'; document.querySelector('.live-seat-legend')?.insertAdjacentElement('afterend', summary); inputs.forEach((input) => { const room = rooms[input.value]; const label = input.closest('.live-seat'); const code = label?.querySelector('span'); if (!room || !label || !code) return; label.dataset.roomCapacity = room.capacity; code.insertAdjacentHTML('beforeend', `<small>${room.name || 'Cabin'} · ${currency.format(room.fare)} VND</small>`); }); const syncRooms = (changed) => { const selectedRooms = selected(); const capacity = selectedRooms.reduce((total, input) => total + (rooms[input.value]?.capacity || 1), 0); if (capacity > passengerCount && changed) { changed.checked = false; return syncRooms(); } const fare = selectedRooms.reduce((total, input) => total + (rooms[input.value]?.fare || 0), 0); if (countLabel) countLabel.textContent = `${capacity}/${passengerCount}`; summary.textContent = selectedRooms.length ? `${selectedRooms.length} room${selectedRooms.length > 1 ? 's' : ''} · ${capacity} passenger${capacity > 1 ? 's' : ''} · ${currency.format(fare)} VND` : 'Select rooms for each passenger'; if (error) { error.hidden = capacity === passengerCount; if (!error.hidden) error.textContent = `Select rooms for exactly ${passengerCount} passenger${passengerCount > 1 ? 's' : ''}.`; } }; inputs.forEach((input) => input.addEventListener('change', () => syncRooms(input))); form?.addEventListener('submit', (event) => { const capacity = selected().reduce((total, input) => total + (rooms[input.value]?.capacity || 1), 0); if (capacity !== passengerCount) { event.preventDefault(); syncRooms(); return; } event.stopImmediatePropagation(); const button = form.querySelector('button[type="submit"]'); if (button) { button.disabled = true; button.textContent = button.dataset.loading; } }, true); syncRooms(); setInterval(syncRooms, 30500); })();</script>
@endpush

@push('styles')
<style>.live-seat span{position:relative;display:grid;gap:2px}.live-seat span small{color:#6a806f;font-size:9px;font-weight:700;line-height:1.25}.live-seat:has(input:checked) span small{color:#dff5e5}.live-room-summary{margin:0;color:#0a6337;font-size:12px;font-weight:800}</style>
@endpush

@push('styles')
<style>.live-room-types{display:flex;flex-wrap:wrap;gap:10px;margin:10px 0;color:#425a4a;font-size:11px;font-weight:750}.live-room-types span{display:flex;align-items:center;gap:5px}.live-room-types i{width:12px;height:12px;border:2px solid var(--room-color);border-radius:3px}.live-seat.has-room-choice span{border-color:var(--room-color)!important;color:var(--room-color)!important}.live-seat.has-room-choice input:checked+span{background:var(--room-color)!important;color:#fff!important}.live-seat.has-room-choice input:checked+span small{color:#fff!important}.live-room-modal{position:fixed;inset:0;z-index:60;display:grid;place-items:center;padding:20px;background:rgba(4,23,14,.58)}.live-room-modal__card{width:min(420px,100%);padding:24px;background:#fff;border-radius:14px;box-shadow:0 24px 60px rgba(0,0,0,.25)}.live-room-modal h2{margin:0 0 7px;font-size:21px}.live-room-modal p{margin:0 0 18px;color:#60776a;font-size:13px}.live-room-modal__options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.live-room-modal__options button{min-height:92px;padding:10px;border:1px solid #d6e2d9!important;border-top:4px solid var(--room-color)!important;background:#fff!important;color:#1c3526!important;font-size:13px!important;line-height:1.4}.live-room-modal__options button strong,.live-room-modal__options button small{display:block}.live-room-modal__cancel{width:100%;margin-top:12px;background:#f1f5f2!important;color:#476052!important}</style>
@endpush

@push('scripts')
<script>(() => { const rooms = @json($roomSeats); const form = document.getElementById('live-booking-form'); const inputs = [...document.querySelectorAll('input[name="selected_seats[]"]')]; const error = document.getElementById('seat-selection-error'); const countLabel = document.getElementById('seat-selection-count'); const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); const selections = new Map(); const selected = () => inputs.filter((input) => input.checked); const removeHidden = () => document.querySelectorAll('input[data-room-option]').forEach((input) => input.remove()); const sync = () => { removeHidden(); selected().forEach((input) => { const option = selections.get(input.value) || rooms[input.value]?.options?.[0]; if (!option) return; selections.set(input.value, option); const hidden = document.createElement('input'); hidden.type = 'hidden'; hidden.name = 'selected_room_options[]'; hidden.dataset.roomOption = 'true'; hidden.value = JSON.stringify({ seatCode: input.value, ...option }); form.append(hidden); }); const fare = selected().reduce((total, input) => total + Number(selections.get(input.value)?.fare || 0), 0); if (countLabel) countLabel.textContent = `${selected().length}`; const summaries = document.querySelectorAll('.live-room-summary'); const summary = summaries[summaries.length - 1]; if (summary) summary.textContent = selected().length ? `${selected().length} room${selected().length > 1 ? 's' : ''} · ${currency.format(fare)} VND` : 'Select at least one room'; if (error) error.hidden = selected().length > 0; }; const applyOption = (input, option) => { selections.set(input.value, option); input.checked = true; const card = input.closest('.live-seat'); if (card) { card.classList.add('has-room-choice'); card.style.setProperty('--room-color', option.color || rooms[input.value]?.color || '#0b7f42'); const small = card.querySelector('span small'); if (small) small.textContent = `${option.name} · ${currency.format(option.fare)} VND`; } sync(); }; const closeModal = (modal, input) => { modal.remove(); if (!selections.has(input.value)) input.checked = false; sync(); }; const choose = (input) => { const options = rooms[input.value]?.options || []; if (options.length <= 1) return applyOption(input, options[0]); const modal = document.createElement('div'); modal.className = 'live-room-modal'; const card = document.createElement('div'); card.className = 'live-room-modal__card'; const title = document.createElement('h2'); title.textContent = `Cabin ${input.closest('.live-seat')?.querySelector('span')?.childNodes[0]?.textContent?.trim() || ''}`; const text = document.createElement('p'); text.textContent = 'Choose the room type and occupancy.'; const choices = document.createElement('div'); choices.className = 'live-room-modal__options'; options.forEach((option) => { const button = document.createElement('button'); button.type = 'button'; button.style.setProperty('--room-color', option.color || '#0b7f42'); button.innerHTML = `<strong>${option.name}</strong><small>${currency.format(option.fare)} VND</small>`; button.addEventListener('click', () => { applyOption(input, option); modal.remove(); }); choices.append(button); }); const cancel = document.createElement('button'); cancel.type = 'button'; cancel.className = 'live-room-modal__cancel'; cancel.textContent = 'Cancel'; cancel.addEventListener('click', () => closeModal(modal, input)); card.append(title, text, choices, cancel); modal.append(card); modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(modal, input); }); document.body.append(modal); }; const roomTypes = new Map(); Object.values(rooms).forEach((room) => (room.options || []).forEach((option) => roomTypes.set(`${option.code}-${option.fare}`, option))); const legend = document.createElement('div'); legend.className = 'live-room-types'; roomTypes.forEach((option) => { const item = document.createElement('span'); item.style.setProperty('--room-color', option.color || '#0b7f42'); item.innerHTML = `<i></i>${option.name} · ${currency.format(option.fare)} VND`; legend.append(item); }); document.querySelector('.live-seat-legend')?.insertAdjacentElement('afterend', legend); const summary = document.createElement('p'); summary.className = 'live-room-summary'; legend.insertAdjacentElement('afterend', summary); inputs.forEach((input) => { const room = rooms[input.value]; const card = input.closest('.live-seat'); const label = card?.querySelector('span'); label?.querySelector('small')?.remove(); if (card && room?.color) { card.classList.add('has-room-choice'); card.style.setProperty('--room-color', room.color); } if (input.checked) applyOption(input, room?.options?.[0]); input.addEventListener('change', (event) => { event.stopImmediatePropagation(); if (!input.checked) { selections.delete(input.value); sync(); return; } choose(input); }, true); }); form?.addEventListener('submit', (event) => { event.stopImmediatePropagation(); if (!selected().length) { event.preventDefault(); if (error) { error.hidden = false; error.textContent = 'Please choose at least one room.'; } return; } sync(); const button = form.querySelector('button[type="submit"]'); if (button) { button.disabled = true; button.textContent = button.dataset.loading; } }, true); sync(); })();</script>
@endpush

@push('scripts')
<script>(() => { const form = document.getElementById('live-booking-form'); const passengerInput = form?.querySelector('input[name="passenger_count"]'); const countLabel = document.getElementById('seat-selection-count'); const error = document.getElementById('seat-selection-error'); const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); const selectedOptions = () => [...document.querySelectorAll('input[data-room-option]')].map((input) => JSON.parse(input.value)); const syncOccupancy = () => { const options = selectedOptions(); const guests = options.reduce((total, option) => total + Number(option.customer_amount || 1), 0); const fare = options.reduce((total, option) => total + Number(option.fare || 0), 0); if (passengerInput && options.length && guests <= 6) passengerInput.value = String(guests); if (countLabel) countLabel.textContent = options.length ? `${guests}/${guests}` : '0'; const summaries = document.querySelectorAll('.live-room-summary'); const summary = summaries[summaries.length - 1]; if (summary) summary.textContent = options.length ? `${options.length} room${options.length > 1 ? 's' : ''} · ${guests} passenger${guests > 1 ? 's' : ''} · ${currency.format(fare)} VND` : 'Select at least one room'; if (error) { error.hidden = options.length > 0 && guests <= 6; if (!error.hidden) error.textContent = guests > 6 ? 'A booking can include up to 6 passengers.' : 'Choose at least one room option.'; } return guests; }; new MutationObserver(syncOccupancy).observe(form, { childList: true }); document.addEventListener('change', (event) => { if (event.target.matches('input[name="selected_seats[]"]')) window.setTimeout(syncOccupancy); }); document.addEventListener('submit', (event) => { if (event.target !== form) return; event.stopImmediatePropagation(); const guests = syncOccupancy(); if (!guests || guests > 6) { event.preventDefault(); return; } if (passengerInput) passengerInput.value = String(guests); const button = form.querySelector('button[type="submit"]'); if (button) { button.disabled = true; button.textContent = button.dataset.loading; } }, true); syncOccupancy(); })();</script>
@endpush

@push('scripts')
<script>(() => { const form = document.getElementById('live-booking-form'); const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); const fareDetail = document.querySelector('.live-checkout aside dl div:nth-child(2)'); const total = document.querySelector('.live-checkout__total strong'); const selectedOptions = () => [...document.querySelectorAll('input[data-room-option]')].map((input) => JSON.parse(input.value)); const syncFare = () => { const options = selectedOptions(); const guests = options.reduce((sum, option) => sum + Number(option.customer_amount || 1), 0); const rooms = options.length; const amount = options.reduce((sum, option) => sum + Number(option.fare || 0), 0); if (fareDetail) { fareDetail.querySelector('dt').textContent = rooms ? `${rooms} room${rooms > 1 ? 's' : ''} · ${guests} passenger${guests > 1 ? 's' : ''}` : 'Choose room options'; fareDetail.querySelector('dd').textContent = rooms ? `${currency.format(amount)} VND` : '—'; } if (total) total.textContent = `${currency.format(amount)} VND`; }; new MutationObserver(syncFare).observe(form, { childList: true }); syncFare(); })();</script>
@endpush

@push('scripts')
<script>(() => { const form = document.getElementById('live-booking-form'); const passengerInput = form?.querySelector('input[name="passenger_count"]'); const countLabel = document.getElementById('seat-selection-count'); const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); const sync = () => window.setTimeout(() => { const options = [...document.querySelectorAll('input[data-room-option]')].map((input) => JSON.parse(input.value)); if (!options.length) return; const guests = options.reduce((sum, option) => sum + Number(option.customer_amount || 1), 0); const amount = options.reduce((sum, option) => sum + Number(option.fare || 0), 0); if (passengerInput) passengerInput.value = String(guests); if (countLabel) countLabel.textContent = `${guests}/${guests}`; document.querySelectorAll('.live-room-summary').forEach((summary) => { summary.textContent = `${options.length} room${options.length > 1 ? 's' : ''} · ${guests} passenger${guests > 1 ? 's' : ''} · ${currency.format(amount)} VND`; }); }, 0); new MutationObserver(sync).observe(form, { childList: true }); document.addEventListener('change', sync); sync(); })();</script>
@endpush

@push('styles')
<style>.live-room-summary+.live-room-summary{display:none}</style>
@endpush

@push('scripts')
<script>(() => { const currency = new Intl.NumberFormat({!! json_encode($locale === 'vi' ? 'vi-VN' : 'en-US') !!}); document.addEventListener('click', (event) => { if (!event.target.closest('.live-room-modal__options')) return; window.setTimeout(() => { const options = [...document.querySelectorAll('input[data-room-option]')].map((input) => JSON.parse(input.value)); const guests = options.reduce((sum, option) => sum + Number(option.customer_amount || 1), 0); const amount = options.reduce((sum, option) => sum + Number(option.fare || 0), 0); const passengerInput = document.querySelector('input[name="passenger_count"]'); const countLabel = document.getElementById('seat-selection-count'); if (passengerInput) passengerInput.value = String(guests); if (countLabel) countLabel.textContent = `${guests}/${guests}`; document.querySelectorAll('.live-room-summary').forEach((summary) => { summary.textContent = `${options.length} room${options.length > 1 ? 's' : ''} · ${guests} passenger${guests > 1 ? 's' : ''} · ${currency.format(amount)} VND`; }); }, 0); }); })();</script>
@endpush

@push('scripts')
<script>
    (() => {
        const backLink = document.querySelector('.live-checkout__back');
        if (backLink) {
            backLink.href = @json($backUrl);
        }

        const form = document.getElementById('live-booking-form');
        if (!form) return;
        const roundTripPassenger = @json($roundTripPassenger);
        [['passenger_name', 'name'], ['passenger_email', 'email'], ['passenger_phone', 'phone']].forEach(([field, key]) => {
            const input = form.elements.namedItem(field);
            if (input && !input.value && roundTripPassenger[key]) input.value = roundTripPassenger[key];
        });

        window.addEventListener('submit', (event) => {
            if (event.target !== form) return;

            const options = [...form.querySelectorAll('input[data-room-option]')]
                .map((input) => JSON.parse(input.value));
            if (!options.length) return;

            const guests = options.reduce((total, option) => total + Number(option.customer_amount || 1), 0);
            const passengerInput = form.querySelector('input[name="passenger_count"]');
            const error = document.getElementById('seat-selection-error');

            if (!guests || guests > 6) {
                event.preventDefault();
                event.stopImmediatePropagation();
                if (error) {
                    error.hidden = false;
                    error.textContent = guests > 6
                        ? 'A booking can include up to 6 passengers.'
                        : 'Choose at least one room option.';
                }
                return;
            }

            passengerInput.value = String(guests);
            event.preventDefault();
            event.stopImmediatePropagation();
            const overlay = document.getElementById('live-booking-loading');
            if (overlay) overlay.hidden = false;
            HTMLFormElement.prototype.submit.call(form);
        }, true);
    })();
</script>
@endpush

@push('styles')
<style>
    .live-payment-methods{gap:11px!important}.live-payment-methods__grid{display:grid;gap:11px}.live-payment-option{position:relative;display:block!important;padding:15px 15px 15px 43px;border:1px solid #cddbd0;border-radius:10px;cursor:pointer}.live-payment-option:has(input:checked){border-color:#0b7f42;background:#f0f9f2;box-shadow:0 0 0 1px #0b7f42}.live-payment-option input{position:absolute;top:17px;left:15px;width:17px;height:17px;accent-color:#0b7f42}.live-payment-option strong,.live-payment-option span{display:block}.live-payment-option strong{color:#173014;font-size:14px}.live-payment-option span{margin-top:4px;color:#60776a;font-size:11px;font-weight:600;line-height:1.45}.live-payment-methods__error{margin:0;color:#991b1b;font-size:12px;font-weight:700}
</style>
@endpush

@push('scripts')
<script>
    (() => {
        const form = document.getElementById('live-booking-form');
        const terms = form?.querySelector('input[name="terms"]')?.closest('label');
        const submit = form?.querySelector('button[type="submit"]');
        if (!form || !terms || !submit) return;

        const copy = @json($paymentMethods);
        const validationError = @json($errors->first('payment_method'));
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'live-payment-methods';
        fieldset.innerHTML = `
            <legend>${copy.title}</legend>
            <div class="live-payment-methods__grid">
                <label class="live-payment-option">
                    <input type="radio" name="payment_method" value="cash" checked>
                    <strong>${copy.cash}</strong><span>${copy.cash_help}</span>
                </label>
            </div>
            ${validationError ? `<p class="live-payment-methods__error">${validationError}</p>` : ''}
        `;
        terms.insertAdjacentElement('beforebegin', fieldset);

        const paymentNote = form.querySelector('.live-checkout__payment-note span');
        submit.textContent = copy.cash_submit;
        if (paymentNote) paymentNote.textContent = copy.cash_help;
    })();
</script>
<script>
    (() => {
        const copy = @json($dynamicCopy);
        const locale = @json($locale);
        const vndPerUsd = {{ $vndPerUsd }};
        const usdFormatter = new Intl.NumberFormat('en-US', { maximumFractionDigits: 0 });
        const exact = {
            'Choose the room type and occupancy.': copy.modal_help,
            'Cancel': copy.cancel,
            'Select rooms for each passenger': copy.select_rooms,
            'Select at least one room': copy.select_one,
            'Choose at least one room option.': copy.select_one,
            'Choose room options': copy.choose_options,
            'A booking can include up to 6 passengers.': copy.max_passengers,
            'A selected seat was just taken. Please choose another seat.': copy.seat_taken,
        };
        const translatedSelectors = '.live-room-summary,#seat-selection-error,.live-checkout aside dt,.live-room-modal__card > h2,.live-room-modal__card > p,.live-room-modal__card > button';
        const priceSelectors = '.live-room-types span,.live-seat span,.live-room-modal__options button,.live-room-summary,.live-checkout aside dd,.live-checkout__total strong';
        const noun = (key, count) => locale === 'en' && count !== 1 ? `${copy[key]}s` : copy[key];

        const translate = (node) => {
            const text = node.textContent.trim();
            let translated = exact[text] || text;
            let match = text.match(/^Cabin\s+(.+)$/);
            if (match) translated = `${copy.cabin} ${match[1]}`;
            match = text.match(/^(\d+) rooms? · (\d+) passengers? · (.+ VND)$/);
            if (match) translated = `${match[1]} ${noun('room', Number(match[1]))} · ${match[2]} ${noun('passenger', Number(match[2]))} · ${match[3]}`;
            if (!match) {
                match = text.match(/^(\d+) rooms? · (.+ VND)$/);
                if (match) translated = `${match[1]} ${noun('room', Number(match[1]))} · ${match[2]}`;
            }
            match = text.match(/^(\d+) rooms? · (\d+) passengers?$/);
            if (match) translated = `${match[1]} ${noun('room', Number(match[1]))} · ${match[2]} ${noun('passenger', Number(match[2]))}`;
            match = text.match(/^Select rooms for exactly (\d+) passengers?\.$/);
            if (match) translated = copy.select_exactly.replace(':count', match[1]);
            match = text.match(/^Please select (\d+) seats?\.$/);
            if (match) translated = copy.select_seats.replace(':count', match[1]);
            if (translated !== text) node.textContent = translated;
        };

        const addUsdHint = (node) => {
            if (node.querySelector(':scope > .live-usd-hint')) return;
            const match = node.textContent.match(/([\d.,]+)\s*VND/);
            if (!match) return;
            const amount = Number(match[1].replace(/\D/g, ''));
            if (!Number.isFinite(amount)) return;
            const hint = document.createElement('small');
            hint.className = 'live-usd-hint';
            hint.textContent = `≈ $${usdFormatter.format(amount / vndPerUsd)}`;
            node.append(hint);
        };

        const sync = () => {
            document.querySelectorAll(translatedSelectors).forEach(translate);
            document.querySelectorAll(priceSelectors).forEach(addUsdHint);
        };
        new MutationObserver(sync).observe(document.body, { childList: true, characterData: true, subtree: true });
        sync();
    })();
</script>
@endpush

@push('styles')
<style>
.live-booking-loading{position:fixed;inset:0;z-index:100;display:grid;place-items:center;padding:20px;background:rgba(4,23,14,.55);backdrop-filter:blur(3px)}
.live-booking-loading[hidden]{display:none}
.live-booking-loading__card{display:grid;justify-items:center;gap:10px;width:min(360px,100%);padding:32px 28px;background:#fff;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,.3);text-align:center}
.live-booking-loading__spinner{width:48px;height:48px;border:4px solid #d9e5dc;border-top-color:#0b7f42;border-radius:50%;animation:live-booking-spin .8s linear infinite}
.live-booking-loading__card strong{color:#173014;font-size:18px}
.live-booking-loading__card p{margin:0;color:#60776a;font-size:13px;line-height:1.6}
.live-usd-hint{display:block;margin-top:2px;color:#60776a;font-size:11px;font-weight:600;line-height:1.3}
.live-room-types .live-usd-hint{display:inline;margin:0 0 0 5px;color:#6f7e75}
@keyframes live-booking-spin{to{transform:rotate(360deg)}}
</style>
@endpush

@push('styles')
<style>
.live-policy{position:relative;overflow:hidden;padding:20px;border:1px solid #dfd5a9;border-radius:14px;background:linear-gradient(145deg,#fffdf5,#f4faf5);box-shadow:0 10px 26px rgba(42,73,54,.06)}
.live-policy:after{position:absolute;top:-75px;right:-68px;width:170px;height:170px;border:1px solid rgba(11,127,66,.11);border-radius:50%;box-shadow:0 0 0 24px rgba(249,223,18,.06);content:'';pointer-events:none}
.live-policy__head{position:relative;z-index:1;display:grid;grid-template-columns:44px minmax(0,1fr);gap:12px;align-items:center;margin-bottom:16px}
.live-policy__icon{display:grid;width:44px;height:44px;place-items:center;color:#075f38;background:#ffed74;border:1px solid #e0c940;border-radius:12px;box-shadow:0 6px 14px rgba(151,126,0,.14)}
.live-policy__icon svg{width:23px;height:23px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.9}
.live-policy__kicker{display:block;margin-bottom:3px;color:#856600;font-size:9px;font-weight:900;letter-spacing:.1em}
.live-policy h2{margin:0;color:#173c2b;font-size:20px;letter-spacing:-.025em}
.live-policy__intro{grid-column:1/-1;margin:0;color:#5f7467;font-size:12px;line-height:1.55}
.live-policy__list{position:relative;z-index:1;display:grid;gap:9px}
.live-policy details{overflow:hidden;border:1px solid #dce7df;border-radius:10px;background:rgba(255,255,255,.9)}
.live-policy summary{display:grid;grid-template-columns:30px minmax(0,1fr) 20px;gap:9px;align-items:center;min-height:52px;padding:9px 12px;color:#244936;font-size:13px;font-weight:850;list-style:none;cursor:pointer}
.live-policy summary::-webkit-details-marker{display:none}
.live-policy summary>i{display:grid;width:28px;height:28px;place-items:center;color:#0b7f42;background:#e9f6ed;border-radius:8px;font-style:normal;font-size:11px}
.live-policy summary:after{color:#0b7f42;font-size:20px;font-weight:500;content:'+'}
.live-policy details[open] summary{color:#073a2a;background:#f5faf6;border-bottom:1px solid #e1eae3}
.live-policy details[open] summary:after{content:'−'}
.live-policy__body{padding:12px 15px 14px 49px}
.live-policy__body>p{margin:0 0 9px;color:#667a6d;font-size:11px;line-height:1.55}
.live-policy__body ul{display:grid;gap:7px;margin:0;padding:0;list-style:none}
.live-policy__body li{position:relative;padding-left:14px;color:#496052;font-size:11px;line-height:1.55}
.live-policy__body li:before{position:absolute;top:.65em;left:0;width:5px;height:5px;background:#e1b900;border-radius:50%;content:''}
.live-policy__periods{display:grid;gap:8px}
.live-policy__period{display:grid;grid-template-columns:minmax(112px,.42fr) minmax(0,1fr);gap:10px;padding:10px;border-left:3px solid #0b7f42;border-radius:7px;background:#f2f8f4}
.live-policy__period.is-warning{border-left-color:#dda900;background:#fff8e5}
.live-policy__period.is-danger{border-left-color:#d4493f;background:#fff2f0}
.live-policy__period strong{color:#214b36;font-size:10px;line-height:1.45}
.live-policy__period span{color:#566d5f;font-size:10px;line-height:1.5}
.live-policy__note{margin:10px 0 0!important;padding:9px 10px;color:#76551a!important;background:#fff1c8;border-radius:7px;font-weight:750}
.live-policy__help{position:relative;z-index:1;display:flex;gap:7px;align-items:flex-start;margin:13px 0 0;padding-top:12px;color:#52695d;font-size:11px;font-weight:700;line-height:1.5;border-top:1px solid #e0e8e1}
.live-policy__help svg{width:15px;height:15px;flex:none;margin-top:1px;fill:none;stroke:#0b7f42;stroke-linecap:round;stroke-linejoin:round;stroke-width:2}
@media(max-width:520px){.live-policy{padding:16px 13px}.live-policy__body{padding:11px 12px 13px}.live-policy__period{grid-template-columns:1fr;gap:4px}.live-policy summary{padding:9px 10px}}
</style>
@endpush

@push('scripts')
<script>
    (() => {
        const form = document.getElementById('live-booking-form');
        const terms = form?.querySelector('input[name="terms"]')?.closest('label');
        if (!form || !terms) return;

        const copy = @json($policyUi);
        const section = document.createElement('section');
        section.id = 'operator-policy';
        section.className = 'live-policy';
        section.setAttribute('aria-labelledby', 'operator-policy-title');

        const standardSections = copy.sections.map((item, index) => `
            <details>
                <summary><i aria-hidden="true">0${index + 1}</i><span>${item.title}</span></summary>
                <div class="live-policy__body"><ul>${item.bullets.map((bullet) => `<li>${bullet}</li>`).join('')}</ul></div>
            </details>
        `).join('');
        const cancellation = copy.cancellation;
        const cancellationSection = `
            <details open>
                <summary><i aria-hidden="true">04</i><span>${cancellation.title}</span></summary>
                <div class="live-policy__body">
                    <p>${cancellation.intro}</p>
                    <div class="live-policy__periods">${cancellation.periods.map((period) => `
                        <div class="live-policy__period is-${period.tone}"><strong>${period.time}</strong><span>${period.text}</span></div>
                    `).join('')}</div>
                    <p class="live-policy__note">${cancellation.note}</p>
                </div>
            </details>
        `;

        section.innerHTML = `
            <header class="live-policy__head">
                <span class="live-policy__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 4.5 6v5c0 4.5 3.1 8.6 7.5 10 4.4-1.4 7.5-5.5 7.5-10V6L12 3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/></svg></span>
                <div><span class="live-policy__kicker">${copy.kicker}</span><h2 id="operator-policy-title">${copy.title}</h2></div>
                <p class="live-policy__intro">${copy.intro}</p>
            </header>
            <div class="live-policy__list">${standardSections}${cancellationSection}</div>
            <p class="live-policy__help"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h4l2 5-3 2a15 15 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2C9.7 21 3 14.3 3 6a2 2 0 0 1 2-2Z"/></svg><span>${copy.thanks}</span></p>
        `;
        terms.insertAdjacentElement('beforebegin', section);
    })();
</script>
@endpush
