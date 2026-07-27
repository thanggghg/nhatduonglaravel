@extends('layouts.app')

@php
    $locale = request('lang');
    $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : $booking->locale;
    $copy = [
        'vi' => ['kicker' => 'THANH TOÁN AN TOÀN', 'title' => 'Quét mã để thanh toán', 'intro' => 'Mã QR đã chứa đúng số tiền và nội dung chuyển khoản. Vé được xác nhận tự động sau khi SePay nhận giao dịch.', 'amount' => 'Số tiền thanh toán', 'code' => 'Nội dung chuyển khoản', 'account' => 'Tài khoản nhận', 'waiting' => 'Đang chờ thanh toán', 'check' => 'Tôi đã chuyển khoản', 'checking' => 'Đang kiểm tra...', 'secure' => 'Thanh toán được đối soát tự động qua SePay Sandbox.', 'unavailable' => 'Chưa thể tạo mã thanh toán. Vui lòng thử lại sau.', 'pending' => 'Chưa nhận được thanh toán. Vui lòng chờ ít phút rồi kiểm tra lại.', 'back' => 'Quay lại thông tin đặt vé'],
        'en' => ['kicker' => 'SECURE PAYMENT', 'title' => 'Scan to pay', 'intro' => 'The QR code contains the exact amount and transfer reference. Your ticket is confirmed automatically after SePay receives the transfer.', 'amount' => 'Payment amount', 'code' => 'Transfer reference', 'account' => 'Receiving account', 'waiting' => 'Awaiting payment', 'check' => 'I have transferred', 'checking' => 'Checking...', 'secure' => 'Payment is reconciled automatically through SePay Sandbox.', 'unavailable' => 'Unable to create the payment QR right now. Please try again.', 'pending' => 'Payment has not been received yet. Please wait a moment and check again.', 'back' => 'Back to booking details'],
        'ru' => ['kicker' => 'БЕЗОПАСНАЯ ОПЛАТА', 'title' => 'Отсканируйте QR для оплаты', 'intro' => 'QR-код уже содержит точную сумму и назначение платежа. Билет подтверждается автоматически после получения перевода SePay.', 'amount' => 'Сумма к оплате', 'code' => 'Назначение перевода', 'account' => 'Счет получателя', 'waiting' => 'Ожидание оплаты', 'check' => 'Я перевел деньги', 'checking' => 'Проверяем...', 'secure' => 'Платеж сверяется автоматически через SePay Sandbox.', 'unavailable' => 'Сейчас не удается создать QR для оплаты. Повторите попытку позже.', 'pending' => 'Платеж еще не получен. Подождите немного и проверьте снова.', 'back' => 'Назад к данным бронирования'],
    ][$locale];
@endphp

@section('content')
<section class="payment-page">
  <div class="payment-shell">
    <a class="payment-back" href="{{ url()->previous() }}">&larr; {{ $copy['back'] }}</a>
    <div class="payment-card">
      <div class="payment-copy">
        <p>{{ $copy['kicker'] }}</p><h1>{{ $copy['title'] }}</h1><span class="payment-status">{{ $copy['waiting'] }}</span><p class="payment-intro">{{ $copy['intro'] }}</p>
        <dl>
          <div><dt>{{ $copy['amount'] }}</dt><dd>{{ number_format($booking->total_amount) }} VND</dd></div>
          <div><dt>{{ $copy['code'] }}</dt><dd>{{ $booking->payment_code }}</dd></div>
          @if($payment)
          <div><dt>{{ $copy['account'] }}</dt><dd>{{ $payment['bank_name'] }} · {{ $payment['account_number'] }}<br>{{ $payment['account_name'] }}</dd></div>
          @endif
        </dl>
      </div>
      <div class="payment-qr">
        @if($payment)
        <img src="{{ $payment['qr_url'] }}" alt="SePay payment QR">
        <form id="payment-check" method="POST" action="{{ route('booking.payment.check', ['booking' => $booking, 'lang' => $locale]) }}">
          @csrf
          <button type="submit" data-checking="{{ $copy['checking'] }}">{{ $copy['check'] }}</button>
        </form>
        <p>{{ $copy['secure'] }}</p>
        @else
        <p class="payment-error">{{ $copy['unavailable'] }}</p>
        @endif
        @if(session('payment_pending'))
        <p class="payment-error">{{ $copy['pending'] }}</p>
        @endif
        @if(session('payment_error'))
        <p class="payment-error">{{ session('payment_error') }}</p>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>.payment-page{min-height:70vh;padding:40px 0 70px;background:#f3f8f4}.payment-shell{width:min(900px,calc(100% - 32px));margin:auto}.payment-back{display:inline-block;margin-bottom:18px;color:#087841;font-size:14px;font-weight:800;text-decoration:none}.payment-card{display:grid;grid-template-columns:1fr minmax(290px,.75fr);gap:28px;padding:32px;border:1px solid #d5e4d9;border-radius:18px;background:#fff;box-shadow:0 16px 36px rgba(11,127,66,.1)}.payment-copy>p:first-child{margin:0;color:#087841;font-size:11px;font-weight:900;letter-spacing:.12em}.payment-copy h1{margin:9px 0;color:#173014;font-size:34px;letter-spacing:-.04em}.payment-status{display:inline-flex;padding:6px 10px;border-radius:99px;color:#725d14;background:#fef3d7;font-size:12px;font-weight:850}.payment-intro{max-width:490px;margin:20px 0;color:#60776a;line-height:1.65}.payment-copy dl{display:grid;gap:0;margin:0;border-top:1px solid #e2ece5}.payment-copy dl div{display:flex;justify-content:space-between;gap:18px;padding:13px 0;border-bottom:1px solid #e2ece5}.payment-copy dt{color:#6d8377;font-size:12px;font-weight:700}.payment-copy dd{margin:0;color:#173014;font-size:13px;font-weight:850;text-align:right}.payment-qr{display:grid;align-content:start;justify-items:center;gap:15px;padding:18px;border-radius:14px;background:#f6faf6;text-align:center}.payment-qr img{width:min(100%,280px);border-radius:10px;background:#fff}.payment-qr form{width:100%}.payment-qr button{width:100%;min-height:46px;border:0;border-radius:9px;color:#fff;background:#0b7f42;font:800 14px Inter,sans-serif;cursor:pointer}.payment-qr button:disabled{opacity:.6}.payment-qr>p{margin:0;color:#657d6e;font-size:12px;line-height:1.5}.payment-error{padding:11px!important;color:#991b1b!important;border:1px solid #f1c5bd;border-radius:8px;background:#fff5f2}@media(max-width:650px){.payment-card{grid-template-columns:1fr;padding:22px}.payment-copy h1{font-size:29px}.payment-copy dl div{display:grid}.payment-copy dd{text-align:left}}</style>
@endpush

@push('scripts')
<script>(() => { const form = document.getElementById('payment-check'); if (!form) return; form.addEventListener('submit', () => { const button = form.querySelector('button'); button.disabled = true; button.textContent = button.dataset.checking; }); const statusUrl = @json(route('booking.payment.status', ['booking' => $booking, 'lang' => $locale])); window.setInterval(async () => { try { const response = await fetch(statusUrl, {headers:{Accept:'application/json'}}); const result = await response.json(); if (result.paid) window.location.assign(result.success_url); } catch (_) {} }, 15000); })();</script>
@endpush
