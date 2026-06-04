{{-- FAQ — layout từ index-nhat-duong-complete-with-testimonials-faq.html --}}
@if(isset($faqs) && $faqs->isNotEmpty())
<section style="position:relative; padding:94px 2vw 106px; overflow:hidden; background: radial-gradient(circle at 18% 18%,rgba(18,124,7,.09),transparent 25%), linear-gradient(180deg,#f6fbf4 0%,#ffffff 100%);">

  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">

    {{-- Head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:32px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="width:7px; height:7px; border-radius:50%; background:#0b7f42; display:block;"></span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Hỗ trợ nhanh</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Câu Hỏi <span style="color:#0b7f42;">Thường Gặp</span>
        </h2>
      </div>
      <p style="max-width:480px; margin:0; color:#62735e; font-size:15px; line-height:1.7; font-weight:700;">
        Tổng hợp các câu hỏi phổ biến khi đặt vé, xem lịch trình và di chuyển cùng Nhà xe Nhật Dương.
      </p>
    </div>

    {{-- Layout: support card sticky + faq list --}}
    <div style="display:grid; grid-template-columns:.82fr 1.18fr; gap:28px; align-items:start;" class="faq-layout-grid">

      {{-- Support card sticky --}}
      <aside style="position:sticky; top:90px; padding:34px; border-radius:36px; color:#fff; background: radial-gradient(circle at 84% 16%,rgba(249,178,26,.26),transparent 24%), linear-gradient(145deg,#0a5d03,#127c07); box-shadow:0 28px 78px rgba(8,61,15,.20); border:1px solid rgba(255,255,255,.18);">
        <h3 style="margin:0 0 12px; font-size:30px; line-height:1.08; font-weight:900; letter-spacing:-0.8px;">Cần tư vấn trực tiếp?</h3>
        <p style="margin:0 0 24px; color:rgba(255,255,255,.78); font-size:15px; line-height:1.7; font-weight:700;">
          Gọi hotline để được hỗ trợ giữ chỗ, kiểm tra giờ chạy, điểm đón/trả và thông tin vé nhanh nhất.
        </p>
        <a href="tel:0123456789"
           style="display:flex; align-items:center; justify-content:center; width:100%; min-height:54px; border-radius:18px; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:17px; font-weight:900; text-decoration:none; box-shadow:0 16px 34px rgba(249,178,26,.24); transition:all .25s;"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 22px 44px rgba(249,178,26,.32)'"
           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 16px 34px rgba(249,178,26,.24)'">
          ☎ Gọi 0123 456 789
        </a>

        {{-- Quick links --}}
        <div style="margin-top:20px; padding-top:20px; border-top:1px solid rgba(255,255,255,.14); display:grid; gap:10px;">
          @foreach([
            ['📅','Xem lịch trình hôm nay', route('schedules.index')],
            ['🎫','Đặt vé ngay', route('booking.search', ['route_id' => $ntRoute?->id ?? 2, 'departDate' => now()->format('d-m-Y')])],
            ['📍','Xem tuyến đường', route('routes.index')],
          ] as [$icon,$label,$href])
          <a href="{{ $href }}"
             style="display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:14px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.14); color:rgba(255,255,255,.85); font-size:14px; font-weight:800; text-decoration:none; transition:background .2s;"
             onmouseover="this.style.background='rgba(255,255,255,.18)'"
             onmouseout="this.style.background='rgba(255,255,255,.10)'">
            <span style="font-size:16px;">{{ $icon }}</span>{{ $label }}
          </a>
          @endforeach
        </div>
      </aside>

      {{-- FAQ list --}}
      <div style="display:grid; gap:16px;">
        @foreach($faqs->take(6) as $i => $faq)
        <details style="border-radius:24px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 18px 46px rgba(18,124,7,.09); overflow:hidden; transition:all .25s;"
                 onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 24px 58px rgba(18,124,7,.14)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 18px 46px rgba(18,124,7,.09)'"
                 {{ $i === 0 ? 'open' : '' }}>
          <summary style="list-style:none; cursor:pointer; padding:22px 24px; display:flex; align-items:center; justify-content:space-between; gap:18px; color:#172315; font-size:17px; line-height:1.35; font-weight:900; user-select:none;">
            <span>{{ $faq->question }}</span>
            <span class="faq-plus-icon" style="width:34px; height:34px; display:grid; place-items:center; flex-shrink:0; border-radius:50%; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:20px; font-weight:900; transition:all .25s;">+</span>
          </summary>
          <div style="padding:0 24px 22px; color:#62735e; font-size:15px; line-height:1.75; font-weight:650;">
            {{ $faq->answer }}
          </div>
        </details>
        @endforeach

        {{-- Fallback nếu không có FAQ trong DB --}}
        @if($faqs->isEmpty())
        @foreach([
          ['Nhà xe Nhật Dương chạy tuyến nào?','Tuyến chính: Sài Gòn ↔ Nha Trang và chiều ngược lại.'],
          ['Có thể đặt vé khứ hồi không?','Có. Bạn có thể chọn chiều đi và chiều về, hoặc liên hệ hotline để được hỗ trợ đặt vé khứ hồi nhanh.'],
          ['Tôi có thể xem lịch chạy hôm nay ở đâu?','Bạn xem tại mục "Lịch trình hôm nay". Lịch được chia thành 2 chiều, mỗi chiều có nhiều khung giờ.'],
          ['Giá vé hiển thị có cố định không?','Giá vé có thể thay đổi tùy thời điểm và chương trình khuyến mãi. Vui lòng gọi hotline để xác nhận giá chính xác.'],
          ['Tôi cần hỗ trợ điểm đón/trả thì làm sao?','Bạn có thể gửi form liên hệ hoặc gọi hotline 0123 456 789 để được nhân viên tư vấn điểm đón/trả phù hợp.'],
        ] as $idx => [$q,$a])
        <details style="border-radius:24px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 18px 46px rgba(18,124,7,.09); overflow:hidden; transition:all .25s;"
                 {{ $idx === 0 ? 'open' : '' }}>
          <summary style="list-style:none; cursor:pointer; padding:22px 24px; display:flex; align-items:center; justify-content:space-between; gap:18px; color:#172315; font-size:17px; line-height:1.35; font-weight:900; user-select:none;">
            <span>{{ $q }}</span>
            <span style="width:34px; height:34px; display:grid; place-items:center; flex-shrink:0; border-radius:50%; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:20px; font-weight:900; transition:all .25s;">+</span>
          </summary>
          <div style="padding:0 24px 22px; color:#62735e; font-size:15px; line-height:1.75; font-weight:650;">{{ $a }}</div>
        </details>
        @endforeach
        @endif
      </div>

    </div>
  </div>

  <style>
    @media(max-width:1180px){ .faq-layout-grid{grid-template-columns:1fr!important} .faq-layout-grid aside{position:relative!important;top:auto!important} }
    @media(max-width:760px){ .faq-layout-grid aside,.faq-layout-grid details{border-radius:22px!important} }
    details[open] summary .faq-plus-icon, details[open] summary span:last-child { transform:rotate(45deg); background:#0b7f42!important; color:#fff!important; }
  </style>
</section>
@endif
