@extends('layouts.app')

@php
    $copy = [
        'vi' => ['title' => 'Hoan tat yeu cau dat ve', 'details' => 'Thong tin chuyen', 'passenger' => 'Thong tin hanh khach', 'name' => 'Ho va ten', 'email' => 'Email', 'phone' => 'So dien thoai', 'pickup' => 'Diem don', 'dropoff' => 'Diem tra', 'seat' => 'Uu tien vi tri', 'any' => 'Bat ky', 'lower' => 'Tang duoi', 'upper' => 'Tang tren', 'notes' => 'Ghi chu cho nha xe', 'return' => 'Chuyen ve', 'choose_return' => 'Chon gio chuyen ve', 'terms' => 'Toi da kiem tra thong tin chuyen va dong y de nha xe lien he xac nhan.', 'submit' => 'Gui yeu cau dat ve', 'sending' => 'Dang gui yeu cau...', 'pending' => 'Yeu cau se duoc nha xe kiem tra va xac nhan. Ve chua duoc xac nhan tu dong.', 'total' => 'Tong tam tinh', 'per_person' => 'gia moi khach', 'back' => 'Quay lai danh sach chuyen'],
        'en' => ['title' => 'Complete your booking request', 'details' => 'Trip details', 'passenger' => 'Passenger details', 'name' => 'Full name', 'email' => 'Email', 'phone' => 'Phone or WhatsApp', 'pickup' => 'Pickup point', 'dropoff' => 'Drop-off point', 'seat' => 'Cabin preference', 'any' => 'No preference', 'lower' => 'Lower level', 'upper' => 'Upper level', 'notes' => 'Notes for the operator', 'return' => 'Return departure', 'choose_return' => 'Choose a return departure', 'terms' => 'I have reviewed the trip details and agree that the operator may contact me to confirm this request.', 'submit' => 'Send booking request', 'sending' => 'Sending request...', 'pending' => 'The operator checks every request before confirmation. This is not an instant ticket confirmation.', 'total' => 'Estimated total', 'per_person' => 'fare per passenger', 'back' => 'Back to departures'],
        'ru' => ['title' => 'Оформление заявки', 'details' => 'Детали поездки', 'passenger' => 'Данные пассажира', 'name' => 'Полное имя', 'email' => 'Email', 'phone' => 'Телефон или WhatsApp', 'pickup' => 'Место посадки', 'dropoff' => 'Место высадки', 'seat' => 'Предпочтение по месту', 'any' => 'Без предпочтений', 'lower' => 'Нижний уровень', 'upper' => 'Верхний уровень', 'notes' => 'Комментарий для перевозчика', 'return' => 'Обратный рейс', 'choose_return' => 'Выберите обратный рейс', 'terms' => 'Я проверил данные поездки и согласен, чтобы перевозчик связался со мной для подтверждения заявки.', 'submit' => 'Отправить заявку', 'sending' => 'Отправляем заявку...', 'pending' => 'Каждая заявка проверяется перевозчиком. Это не мгновенное подтверждение билета.', 'total' => 'Предварительная сумма', 'per_person' => 'за пассажира', 'back' => 'Назад к рейсам'],
    ][$locale];
    $vehicle = fn ($item) => $item->vehicle_type ?: ($item->bus_type ?: 'Sleeper cabin');
    $vehicleImage = $route->image ? asset('storage/'.$route->image) : asset('nha-xe-binh-minh-bus-2048x867.png');
    $outboundTotal = (int) $schedule->price * $passengerCount;
@endphp

@section('content')
<section class="checkout-page">
    <div class="checkout-shell">
        <a class="checkout-back" href="{{ route('booking.search', ['route_id' => $route->id, 'departDate' => $date->format('d-m-Y'), 'is_round_trip' => $isRoundTrip ? 1 : 0, 'returnDate' => $returnDate?->format('d-m-Y'), 'seats' => $passengerCount, 'lang' => $locale]) }}">&larr; {{ $copy['back'] }}</a>
        <div class="checkout-grid">
            <main>
                <h1>{{ $copy['title'] }}</h1>
                <p class="checkout-note">{{ $copy['pending'] }}</p>
                <form id="booking-form" method="POST" action="{{ route('booking.store') }}" class="checkout-form">
                    @csrf
                    <input type="hidden" name="route_id" value="{{ $route->id }}"><input type="hidden" name="schedule_id" value="{{ $schedule->id }}"><input type="hidden" name="travel_date" value="{{ $date->toDateString() }}"><input type="hidden" name="passenger_count" value="{{ $passengerCount }}"><input type="hidden" name="is_round_trip" value="{{ $isRoundTrip ? 1 : 0 }}"><input type="hidden" name="return_travel_date" value="{{ $returnDate?->toDateString() }}"><input type="hidden" name="lang" value="{{ $locale }}">

                    <fieldset><legend>{{ $copy['passenger'] }}</legend>
                        <label>{{ $copy['name'] }}<input name="passenger_name" value="{{ old('passenger_name') }}" autocomplete="name" required></label>
                        <div class="checkout-two"><label>{{ $copy['email'] }}<input type="email" name="passenger_email" value="{{ old('passenger_email') }}" autocomplete="email"></label><label>{{ $copy['phone'] }}<input type="tel" name="passenger_phone" value="{{ old('passenger_phone') }}" autocomplete="tel"></label></div>
                    </fieldset>

                    <fieldset><legend>{{ $copy['details'] }}</legend>
                        <div class="checkout-two"><label>{{ $copy['pickup'] }}<select name="pickup_point"><option value="">-</option>@foreach($route->pickupPoints as $point)<option value="{{ $point->name }}" @selected(old('pickup_point') === $point->name)>{{ $point->name }}@if($point->time) ({{ $point->time }})@endif</option>@endforeach</select></label><label>{{ $copy['dropoff'] }}<select name="dropoff_point"><option value="">-</option>@foreach($route->dropoffPoints as $point)<option value="{{ $point->name }}" @selected(old('dropoff_point') === $point->name)>{{ $point->name }}@if($point->time) ({{ $point->time }})@endif</option>@endforeach</select></label></div>
                        <div class="checkout-two"><label>{{ $copy['seat'] }}<select name="seat_preference"><option value="any">{{ $copy['any'] }}</option><option value="lower">{{ $copy['lower'] }}</option><option value="upper">{{ $copy['upper'] }}</option></select></label><label>{{ $copy['notes'] }}<input name="notes" value="{{ old('notes') }}" maxlength="1500"></label></div>
                    </fieldset>

                    @if($isRoundTrip)
                        <fieldset><legend>{{ $copy['return'] }}</legend>
                            <label>{{ $copy['choose_return'] }}<select id="return-schedule" name="return_schedule_id" required><option value="">-</option>@foreach($returnSchedules as $returnSchedule)<option value="{{ $returnSchedule->id }}" data-fare="{{ (int) $returnSchedule->price }}" @selected(old('return_schedule_id') == $returnSchedule->id)>{{ $returnSchedule->departure_time?->format('H:i') }} · {{ $vehicle($returnSchedule) }} · {{ number_format((int) $returnSchedule->price) }} VND</option>@endforeach</select></label>
                            @if($returnSchedules->isEmpty())<p class="checkout-error">No suitable return departure is currently available online.</p>@endif
                        </fieldset>
                    @endif

                    <label class="checkout-terms"><input type="checkbox" name="terms" value="1" required> <span>{{ $copy['terms'] }}</span></label>
                    @foreach($errors->all() as $error)<p class="checkout-error" role="alert">{{ $error }}</p>@endforeach
                    <button type="submit" data-sending="{{ $copy['sending'] }}" @disabled($isRoundTrip && $returnSchedules->isEmpty())>{{ $copy['submit'] }}</button>
                </form>
            </main>
            <aside class="checkout-summary"><img class="checkout-vehicle-image" src="{{ $vehicleImage }}" alt="Nhat Duong {{ $vehicle($schedule) }}"><p>{{ $copy['details'] }}</p><h2>{{ $route->from_location }} to {{ $route->to_location }}</h2><dl><div><dt>{{ $date->format('d/m/Y') }}</dt><dd>{{ $schedule->departure_time?->format('H:i') }} · {{ $vehicle($schedule) }}</dd></div><div><dt>{{ $passengerCount }} {{ $copy['per_person'] }}</dt><dd>{{ number_format((int) $schedule->price) }} VND</dd></div></dl><div class="checkout-total"><span>{{ $copy['total'] }}</span><strong id="checkout-total" data-outbound="{{ $outboundTotal }}">{{ number_format($outboundTotal) }} VND</strong></div></aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .checkout-page{min-height:70vh;padding:38px 0 64px;background:#f5faf4}.checkout-shell{width:min(1080px,calc(100% - 32px));margin:auto}.checkout-back{display:inline-block;margin-bottom:18px;color:#0b7f42;font-size:14px;font-weight:800;text-decoration:none}.checkout-grid{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:28px;align-items:start}.checkout-grid main{padding:28px;background:#fff;border:1px solid #d9e5dc;border-radius:16px}.checkout-grid h1{margin:0 0 8px;color:#173014;font-size:30px}.checkout-note{margin:0 0 24px;padding:12px 14px;color:#66520b;background:#fef8e8;border:1px solid #edddb1;border-radius:9px;font-size:13px;line-height:1.5}.checkout-form{display:grid;gap:20px}.checkout-form fieldset{display:grid;gap:14px;margin:0;padding:20px;border:1px solid #d9e5dc;border-radius:12px}.checkout-form legend{padding:0 6px;color:#173014;font-size:15px;font-weight:800}.checkout-form label{display:grid;gap:6px;color:#526b5c;font-size:12px;font-weight:800}.checkout-form input,.checkout-form select{width:100%;min-height:43px;padding:0 11px;color:#173014;background:#fff;border:1px solid #cddbd0;border-radius:8px;font:600 14px Inter,sans-serif}.checkout-two{display:grid;grid-template-columns:1fr 1fr;gap:14px}.checkout-terms{grid-template-columns:18px 1fr;align-items:start;font-size:13px!important;line-height:1.5}.checkout-terms input{min-height:0!important;width:16px!important;margin-top:2px}.checkout-form button{min-height:47px;border:0;border-radius:9px;background:#0b7f42;color:#fff;font:800 15px Inter,sans-serif;cursor:pointer}.checkout-form button:disabled{opacity:.5;cursor:not-allowed}.checkout-error{margin:0;color:#991b1b;font-size:13px;font-weight:700}.checkout-summary{position:sticky;top:90px;padding:23px;background:#062d1c;color:#fff;border-radius:16px}.checkout-vehicle-image{width:100%;height:155px;margin:0 0 18px;object-fit:cover;border-radius:10px;opacity:.92}.checkout-summary>p{margin:0 0 7px;color:#c6e2ce;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}.checkout-summary h2{margin:0 0 20px;color:#fff;font-size:21px}.checkout-summary dl{display:grid;gap:15px;margin:0}.checkout-summary dl div{display:grid;gap:4px;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,.16)}.checkout-summary dt{color:#b7d0bf;font-size:12px}.checkout-summary dd{margin:0;font-size:14px;font-weight:700}.checkout-total{display:flex;justify-content:space-between;gap:12px;margin-top:19px;align-items:end}.checkout-total span{color:#c6e2ce;font-size:13px}.checkout-total strong{font-size:21px}@media(max-width:800px){.checkout-grid{grid-template-columns:1fr}.checkout-summary{position:static}.checkout-grid main{padding:20px}}@media(max-width:520px){.checkout-two{grid-template-columns:1fr}.checkout-page{padding-top:24px}}
</style>
@endpush

@push('scripts')
<script>
    (() => {
        const form = document.getElementById('booking-form');
        const returnSchedule = document.getElementById('return-schedule');
        const total = document.getElementById('checkout-total');
        if (form) {
            form.addEventListener('submit', () => {
                const button = form.querySelector('button[type="submit"]');
                if (button && !button.disabled) {
                    button.disabled = true;
                    button.textContent = button.dataset.sending;
                }
            });
        }
        if (!returnSchedule || !total) return;

        const passengers = {{ $passengerCount }};
        const outbound = Number(total.dataset.outbound);
        const updateTotal = () => {
            const fare = Number(returnSchedule.selectedOptions[0]?.dataset.fare || 0);
            total.textContent = new Intl.NumberFormat('en-US').format(outbound + fare * passengers) + ' VND';
        };

        returnSchedule.addEventListener('change', updateTotal);
        updateTotal();
    })();
</script>
@endpush
