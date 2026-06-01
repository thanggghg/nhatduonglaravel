{{-- TICKER — Animated route marquee --}}
<div class="bg-forest-deep overflow-hidden py-3.5 border-y border-white/5">
  <div class="ticker-inner flex gap-16 whitespace-nowrap">
    @foreach(array_fill(0,4,['Sài Gòn → Đà Lạt','Sài Gòn → Nha Trang','Sài Gòn → Vũng Tàu','Sài Gòn → Phan Thiết','Giường Nằm VIP','Limousine Cao Cấp','Đặt Vé Online','Hỗ Trợ 24/7']) as $items)
    @foreach($items as $item)
    <span class="text-white/50 text-sm font-medium inline-flex items-center gap-2">
      <span class="text-brand-gold text-xs">◆</span>{{ $item }}
    </span>
    @endforeach
    @endforeach
  </div>
</div>
