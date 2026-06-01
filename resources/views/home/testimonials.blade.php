{{-- TESTIMONIALS — layout từ index-nhat-duong-complete-with-testimonials-faq.html --}}
<section style="position:relative; padding:94px 2vw 104px; overflow:hidden; background: radial-gradient(circle at 12% 16%,rgba(249,178,26,.15),transparent 24%), radial-gradient(circle at 88% 22%,rgba(18,124,7,.10),transparent 26%), linear-gradient(180deg,#ffffff 0%,#f6fbf4 100%);">

  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">

    {{-- Head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:32px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="width:7px; height:7px; border-radius:50%; background:#0b7f42; display:block;"></span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Cảm nhận khách hàng</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Khách Hàng <span style="color:#0b7f42;">Nói Gì?</span>
        </h2>
      </div>
      <p style="max-width:480px; margin:0; color:#62735e; font-size:15px; line-height:1.7; font-weight:700;">
        Những đánh giá chân thật từ khách hàng đã đồng hành cùng Nhật Dương trên tuyến Sài Gòn ↔ Nha Trang.
      </p>
    </div>

    {{-- Layout: main card + grid 2x2 --}}
    <div style="display:grid; grid-template-columns:.9fr 1.1fr; gap:26px; align-items:stretch;" class="testimonial-layout-grid">

      {{-- Main testimonial card xanh --}}
      <article style="position:relative; overflow:hidden; min-height:520px; padding:38px; border-radius:38px; color:#fff; background: radial-gradient(circle at 86% 16%,rgba(249,178,26,.25),transparent 26%), linear-gradient(145deg,#0a5d03,#127c07); box-shadow:0 30px 82px rgba(8,61,15,.22); border:1px solid rgba(255,255,255,.18); animation:floatCard 6s ease-in-out infinite;">
        {{-- Dấu ngoặc kép trang trí --}}
        <div style="position:absolute; right:32px; top:6px; color:rgba(255,255,255,.10); font-size:180px; line-height:1; font-weight:900; pointer-events:none; user-select:none;">"</div>

        <div style="position:relative; z-index:2;">
          <div style="color:#f9b21a; font-size:22px; letter-spacing:2px; text-shadow:0 6px 14px rgba(0,0,0,.18);">★★★★★</div>

          <h3 style="margin:26px 0 18px; font-size:clamp(26px,3vw,42px); line-height:1.06; letter-spacing:-1px; font-weight:900;">
            "Xe chạy êm, đúng giờ, đặt vé rất nhanh."
          </h3>

          <p style="margin:0; color:rgba(255,255,255,.80); font-size:16px; line-height:1.75; font-weight:700;">
            Tôi thường đi tuyến Sài Gòn - Nha Trang. Điều tôi thích nhất là lịch trình rõ ràng, nhân viên hỗ trợ nhanh và xe sạch sẽ, thoải mái cho chuyến đi dài.
          </p>

          <div style="display:flex; align-items:center; gap:14px; margin-top:32px; padding-top:24px; border-top:1px solid rgba(255,255,255,.16);">
            <div style="width:54px; height:54px; display:grid; place-items:center; border-radius:50%; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-weight:900; font-size:20px; box-shadow:0 12px 24px rgba(249,178,26,.24); flex-shrink:0;">A</div>
            <div>
              <strong style="display:block; color:#fff; font-size:16px; font-weight:900;">Anh Minh</strong>
              <span style="display:block; margin-top:4px; color:rgba(255,255,255,.70); font-size:13px; font-weight:800;">Khách hàng tuyến Sài Gòn → Nha Trang</span>
            </div>
          </div>
        </div>
      </article>

      {{-- Grid 2x2 --}}
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;" class="testimonial-small-grid">
        @foreach([
          ['H','Chị Hạnh','Nha Trang → Sài Gòn','Nhân viên tư vấn nhiệt tình, gọi hotline được hỗ trợ ngay. Tôi đặt vé chiều về rất nhanh.'],
          ['Q','Anh Quốc','Sài Gòn → Nha Trang','Xe sạch, chỗ nằm thoải mái, phù hợp đi ban đêm. Lịch trình rõ ràng dễ theo dõi.'],
          ['L','Chị Linh','Nha Trang → Sài Gòn','Giá vé minh bạch, đặt vé khứ hồi tiện. Tôi sẽ tiếp tục chọn Nhật Dương cho chuyến sau.'],
          ['P','Anh Phúc','Sài Gòn ↔ Nha Trang','Điểm đón được tư vấn rõ, không mất thời gian hỏi lại nhiều. Dịch vụ rất ổn.'],
        ] as [$initial,$name,$route,$comment])
        <article style="position:relative; overflow:hidden; padding:26px; border-radius:30px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10); transition:all .28s ease;"
                 onmouseover="this.style.transform='translateY(-7px)';this.style.boxShadow='0 30px 70px rgba(18,124,7,.16)';this.style.borderColor='rgba(18,124,7,.25)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 20px 52px rgba(18,124,7,.10)';this.style.borderColor='rgba(18,124,7,.14)'">
          <div style="position:absolute; inset:0; background:radial-gradient(circle at 88% 10%,rgba(249,178,26,.16),transparent 24%),radial-gradient(circle at 10% 90%,rgba(18,124,7,.08),transparent 28%); pointer-events:none;"></div>
          <div style="position:relative; z-index:2;">
            <div style="color:#f9b21a; font-size:15px; letter-spacing:1px; font-weight:900; margin-bottom:14px;">★★★★★</div>
            <p style="margin:0; color:#62735e; font-size:14px; line-height:1.7; font-weight:650;">{{ $comment }}</p>
            <h4 style="margin:18px 0 4px; color:#172315; font-size:16px; font-weight:900;">{{ $name }}</h4>
            <span style="color:#0b7f42; font-size:12px; font-weight:900;">{{ $route }}</span>
          </div>
        </article>
        @endforeach
      </div>

    </div>
  </div>

  <style>
    @media(max-width:1180px){ .testimonial-layout-grid{grid-template-columns:1fr!important} }
    @media(max-width:760px){ .testimonial-small-grid{grid-template-columns:1fr!important} }
  </style>
</section>
