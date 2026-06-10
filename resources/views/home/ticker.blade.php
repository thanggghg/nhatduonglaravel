{{-- BENEFITS BAR — Key selling points ticker --}}
<div style="background:#062d1c; overflow:hidden; padding:14px 0; border-top:1px solid rgba(255,255,255,0.08); border-bottom:1px solid rgba(255,255,255,0.08);">
  <div class="ticker-inner flex gap-12 whitespace-nowrap" style="animation: ticker 35s linear infinite; width:max-content;">
    @foreach(array_fill(0, 3, [
      ['icon' => '⏰', 'text' => 'Khung giờ linh hoạt'],
      ['icon' => '⚡', 'text' => 'Đặt vé nhanh chóng'],
      ['icon' => '💳', 'text' => 'Thanh toán dễ dàng'],
      ['icon' => '🎯', 'text' => 'Tư vấn tận tình'],
      ['icon' => '🚌', 'text' => 'Xe mới tiện nghi'],
      ['icon' => '📍', 'text' => 'Đón trả thuận tiện'],
    ]) as $group)
      @foreach($group as $item)
        <span style="color:rgba(255,255,255,0.9); font-size:14px; font-weight:600; font-family:'Inter',sans-serif; display:inline-flex; align-items:center; gap:8px; padding:8px 20px; background:rgba(255,255,255,0.05); border-radius:8px; border:1px solid rgba(255,255,255,0.08);">
          <span style="font-size:18px;">{{ $item['icon'] }}</span>
          <span>{{ $item['text'] }}</span>
        </span>
      @endforeach
    @endforeach
  </div>
</div>

<style>
@keyframes ticker {
  0% { transform: translateX(0); }
  100% { transform: translateX(-33.333%); }
}
.ticker-inner:hover {
  animation-play-state: paused;
}
</style>
