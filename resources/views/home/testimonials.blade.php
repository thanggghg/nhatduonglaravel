{{-- TRẢI NGHIỆM TRÊN XE — thay cho testimonial cũ --}}
<section style="position:relative; padding:94px 0 104px; overflow:hidden; background:radial-gradient(circle at 12% 16%,rgba(249,178,26,.12),transparent 24%), radial-gradient(circle at 88% 22%,rgba(18,124,7,.09),transparent 26%), linear-gradient(180deg,#ffffff 0%,#f6fbf4 100%);">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:32px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="width:7px; height:7px; border-radius:50%; background:#0b7f42; display:block;"></span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Trải nghiệm trên xe</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Không Gian <span style="color:#0b7f42;">Êm Ái, Hiện Đại</span>
        </h2>
      </div>
      <p style="max-width:520px; margin:0; color:#62735e; font-size:15px; line-height:1.7; font-weight:700;">
        Tập trung vào sự riêng tư, đúng giờ và cảm giác thư thái trong suốt hành trình Sài Gòn ↔ Nha Trang với thiết kế xe và dịch vụ theo tiêu chuẩn hiện đại.
      </p>
    </div>

    <div style="display:grid; grid-template-columns:1.05fr .95fr; gap:24px; align-items:stretch;" class="journey-layout-grid">
      <article style="position:relative; overflow:hidden; min-height:520px; border-radius:34px; background:#0a4210; box-shadow:0 30px 82px rgba(8,61,15,.18); border:1px solid rgba(255,255,255,.22);">
        <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="Không gian xe Nhật Dương" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .6s ease;" class="journey-main-image">
        <div style="position:absolute; inset:0; background:linear-gradient(90deg,rgba(3,42,8,.82),rgba(3,42,8,.34) 54%,rgba(3,42,8,.10)), linear-gradient(180deg,rgba(0,0,0,.02),rgba(0,38,10,.72));"></div>

        <div style="position:absolute; top:30px; right:30px; width:180px; padding:18px 16px; border-radius:24px; color:#043801; background:linear-gradient(180deg,#fff8d5,#ffe071); box-shadow:0 22px 52px rgba(249,178,26,.28); text-align:center;">
          <strong style="display:block; font-size:42px; line-height:.9; font-weight:900; letter-spacing:-1px;">22</strong>
          <span style="display:block; margin-top:8px; font-size:12px; font-weight:900; text-transform:uppercase;">Phòng VIP Limousine</span>
        </div>

        <div style="position:absolute; left:30px; right:30px; bottom:30px; max-width:700px;">
          <span style="display:inline-flex; align-items:center; gap:8px; padding:9px 13px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.6px;">Thiết kế tập trung vào trải nghiệm</span>
          <h3 style="margin:20px 0 14px; color:#fff; font-size:clamp(30px,3.6vw,48px); line-height:1.04; letter-spacing:-1px; font-weight:900; text-shadow:0 8px 22px rgba(0,0,0,.34);">Không gian yên tĩnh để nghỉ ngơi, làm việc hoặc thư giãn suốt hành trình</h3>
          <p style="margin:0 0 22px; max-width:620px; color:rgba(255,255,255,.82); font-size:15px; line-height:1.75; font-weight:700;">Khoang xe được tối ưu cho hành trình dài: bố trí hợp lý, ánh sáng dịu, ghế nằm riêng tư và nhịp phục vụ vừa đủ để hành khách luôn cảm thấy thoải mái.</p>
          <div style="display:flex; gap:14px; flex-wrap:wrap;">
            <a href="{{ route('booking.index') }}" style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 22px; border-radius:16px; font-size:15px; font-weight:900; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); box-shadow:0 16px 34px rgba(249,178,26,.24); text-decoration:none; transition:all .25s;">Đặt vé ngay →</a>
            <a href="{{ route('schedules.index') }}" style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 20px; border-radius:16px; font-size:15px; font-weight:900; color:#fff; border:1px solid rgba(255,255,255,.34); background:rgba(255,255,255,.10); text-decoration:none; transition:all .25s;">Xem lịch trình</a>
          </div>
        </div>
      </article>

      <div style="display:grid; gap:18px; align-content:start;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;" class="journey-feature-grid">
          @foreach([
            ['🛏️', 'Khoang nằm riêng tư', 'Không gian được chia tách hợp lý để nghỉ ngơi thoải mái hơn trên tuyến dài.'],
            ['📶', 'Kết nối ổn định', 'Wifi và cổng sạc giúp hành khách duy trì công việc hoặc giải trí trên xe.'],
            ['🌡️', 'Nhiệt độ dễ chịu', 'Điều hoà được giữ ở mức ổn định, phù hợp cả ngày lẫn đêm.'],
            ['🧼', 'Sạch sẽ mỗi chuyến', 'Chăn gối và khu vực hành khách được chăm chút trước khi đón khách.'],
          ] as [$icon, $title, $desc])
          <article style="padding:24px; border-radius:28px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10); transition:all .28s ease;">
            <div style="width:56px; height:56px; display:grid; place-items:center; border-radius:18px; background:linear-gradient(145deg,#0b7f42,#062d1c); color:#ffe681; font-size:24px; box-shadow:0 16px 32px rgba(18,124,7,.18);">{{ $icon }}</div>
            <h4 style="margin:18px 0 10px; color:#172315; font-size:20px; line-height:1.15; font-weight:900; letter-spacing:-.3px;">{{ $title }}</h4>
            <p style="margin:0; color:#62735e; font-size:14px; line-height:1.65; font-weight:650;">{{ $desc }}</p>
          </article>
          @endforeach
        </div>

        <div style="padding:24px; border-radius:30px; color:#fff; background:radial-gradient(circle at 88% 16%,rgba(249,178,26,.28),transparent 24%), linear-gradient(135deg,#0a5d03,#127c07); box-shadow:0 22px 58px rgba(18,124,7,.16); border:1px solid rgba(255,255,255,.18); display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
          <div>
            <h4 style="margin:0 0 8px; font-size:24px; line-height:1.12; font-weight:900;">Thiết kế dịch vụ tối giản nhưng đủ đầy</h4>
            <p style="margin:0; color:rgba(255,255,255,.80); font-size:14px; line-height:1.6; font-weight:700; max-width:520px;">Ưu tiên đúng thứ hành khách cần: giờ chạy rõ ràng, chỗ nằm sạch sẽ, hỗ trợ nhanh và trải nghiệm ổn định từ lúc đặt vé đến khi xuống xe.</p>
          </div>
          <div style="display:grid; gap:10px; min-width:220px;">
            @foreach(['Đúng giờ khởi hành', 'Hỗ trợ nhanh 24/7', 'Tuyến cố định rõ ràng'] as $item)
            <div style="display:flex; align-items:center; gap:10px; color:#fff; font-size:13px; font-weight:800;">
              <span style="width:26px; height:26px; border-radius:50%; background:rgba(255,255,255,.14); display:grid; place-items:center; color:#ffe681; flex-shrink:0;">✓</span>
              {{ $item }}
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .journey-layout-grid article:hover .journey-main-image {
      transform: scale(1.04);
    }
    .journey-feature-grid article:hover {
      transform: translateY(-6px);
      box-shadow: 0 30px 70px rgba(18,124,7,.16);
      border-color: rgba(18,124,7,.25);
    }
    @media(max-width:1180px){ .journey-layout-grid{grid-template-columns:1fr!important} }
    @media(max-width:760px){ .journey-feature-grid{grid-template-columns:1fr!important} }
    @media(max-width:520px){ section[style*='padding:94px 0 104px'] > div{padding:0 16px!important} }
  </style>
</section>
