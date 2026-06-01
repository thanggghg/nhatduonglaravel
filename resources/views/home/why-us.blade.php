{{-- CAM KẾT — layout từ index-nhat-duong-full-width.html --}}
<section style="position:relative; padding:92px 0 102px; overflow:hidden; background: radial-gradient(circle at 10% 18%, rgba(249,178,26,.14), transparent 24%), radial-gradient(circle at 90% 20%, rgba(18,124,7,.10), transparent 26%), linear-gradient(180deg,#ffffff 0%,#f6fbf4 100%);">
  <div style="position:absolute; right:-130px; bottom:-150px; width:430px; height:430px; border-radius:50%; background:rgba(18,124,7,.08); pointer-events:none;"></div>

  <div style="width:min(1280px,94%); margin:0 auto; padding:0 16px; position:relative; z-index:2;">
    <div style="display:grid; grid-template-columns:.86fr 1.14fr; gap:34px; align-items:stretch;" class="commitment-layout">

      {{-- Intro card xanh đậm --}}
      <aside style="position:relative; overflow:hidden; min-height:520px; padding:38px; border-radius:36px; color:#fff; background: linear-gradient(145deg,rgba(4,56,1,.96),rgba(18,124,7,.88)), radial-gradient(circle at 82% 20%,rgba(249,178,26,.28),transparent 24%); box-shadow:0 30px 80px rgba(8,61,15,.22); border:1px solid rgba(255,255,255,.18);">
        <div style="position:absolute; top:-90px; right:-100px; width:260px; height:260px; border-radius:50%; background:rgba(249,178,26,.20); pointer-events:none;"></div>
        <div style="position:absolute; left:34px; right:34px; bottom:32px; height:1px; background:linear-gradient(90deg,transparent,rgba(249,178,26,.85),transparent); pointer-events:none;"></div>

        <div style="position:relative; z-index:2; display:inline-flex; align-items:center; gap:9px; padding:10px 14px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:13px; font-weight:900; box-shadow:0 12px 24px rgba(249,178,26,.22); margin-bottom:22px;">
          Cam kết của chúng tôi
        </div>

        <h2 style="position:relative; z-index:2; margin:0 0 18px; font-size:clamp(36px,3.5vw,52px); line-height:1.05; font-weight:900; letter-spacing:-1px;">
          Vì Sao Hàng Ngàn<br>Khách Hàng<br><span style="color:#f9b21a;">Tin Tưởng?</span>
        </h2>
        <p style="position:relative; z-index:2; color:rgba(255,255,255,.78); font-size:15px; line-height:1.7; font-weight:650; margin:0 0 30px;">
          Nhật Dương đặt sự an toàn, đúng giờ và trải nghiệm thoải mái của hành khách lên hàng đầu trên tuyến Sài Gòn ↔ Nha Trang.
        </p>

        <div style="position:relative; z-index:2; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
          @foreach([
            ['24/7','Hỗ trợ khách hàng'],
            ['100%','Thông tin rõ ràng'],
            ['9-10h','Hành trình trung bình'],
            ['1','Tuyến chạy cố định'],
          ] as [$val,$lbl])
          <div style="padding:18px 16px; border-radius:22px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.16); backdrop-filter:blur(6px);">
            <div style="font-size:28px; font-weight:900; color:#f9b21a; line-height:1;">{{ $val }}</div>
            <div style="font-size:12px; color:rgba(255,255,255,.70); font-weight:800; margin-top:5px;">{{ $lbl }}</div>
          </div>
          @endforeach
        </div>
      </aside>

      {{-- Grid 2×2 + featured card --}}
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;" class="commitment-grid">
        @foreach([
          ['01','🛡️','An toàn trên từng chuyến đi','Xe được kiểm tra trước khi xuất bến, tài xế chạy đúng tuyến và ưu tiên sự an toàn của hành khách.',false],
          ['02','⏱️','Đúng giờ, đúng lộ trình','Lịch trình rõ ràng theo tuyến Sài Gòn - Nha Trang, giúp khách chủ động thời gian.',false],
          ['03','🚌','Xe sạch sẽ, thoải mái','Không gian xe được chăm chút, phù hợp cho hành trình dài, mang lại cảm giác dễ chịu khi di chuyển.',false],
          ['04','☎️','Hỗ trợ đặt vé nhanh','Đội ngũ hỗ trợ 24/7, tư vấn giờ đi, điểm đón và giữ chỗ nhanh chóng cho khách hàng.',false],
          ['05','⭐','Minh bạch giá vé, phục vụ tận tâm','Chúng tôi cam kết thông tin giá vé, lịch trình và điểm đón trả rõ ràng, giúp khách hàng yên tâm trước khi khởi hành.',true],
        ] as [$num,$icon,$title,$desc,$featured])
        <article style="position:relative; overflow:hidden; min-height:{{ $featured ? '160px' : '238px' }}; padding:26px; border-radius:30px; background:{{ $featured ? 'linear-gradient(145deg,rgba(4,56,1,.96),rgba(18,124,7,.88))' : 'rgba(255,255,255,.96)' }}; border:1px solid {{ $featured ? 'rgba(255,255,255,.18)' : 'rgba(18,124,7,.14)' }}; box-shadow:0 20px 52px rgba(18,124,7,.10); transition:transform .28s ease, box-shadow .28s ease; {{ $featured ? 'grid-column:1/-1;' : '' }}"
                 onmouseover="this.style.transform='translateY(-7px)';this.style.boxShadow='0 30px 70px rgba(18,124,7,.16)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 20px 52px rgba(18,124,7,.10)'">
          <div style="position:absolute; inset:0; background:radial-gradient(circle at 90% 8%,rgba(249,178,26,.16),transparent 25%),radial-gradient(circle at 10% 92%,rgba(18,124,7,.08),transparent 28%); pointer-events:none;"></div>

          <div style="position:absolute; top:18px; right:20px; font-size:11px; font-weight:900; color:{{ $featured ? 'rgba(249,178,26,.60)' : 'rgba(18,124,7,.18)' }}; letter-spacing:.5px;">{{ $num }}</div>

          <div style="position:relative; z-index:2; width:58px; height:58px; display:grid; place-items:center; border-radius:20px; font-size:25px; box-shadow:0 16px 32px rgba(18,124,7,.20); background:{{ $featured ? 'linear-gradient(180deg,#ffe681,#f9b21a)' : 'linear-gradient(145deg,#0b7f42,#062d1c)' }};">{{ $icon }}</div>

          <h3 style="position:relative; z-index:2; margin:22px 0 10px; color:{{ $featured ? '#fff' : '#172315' }}; font-size:{{ $featured ? '20px' : '22px' }}; line-height:1.18; font-weight:900; letter-spacing:-.4px;">{{ $title }}</h3>
          <p style="position:relative; z-index:2; margin:0; color:{{ $featured ? 'rgba(255,255,255,.78)' : '#62735e' }}; font-size:14px; line-height:1.65; font-weight:650;">{{ $desc }}</p>
        </article>
        @endforeach
      </div>

    </div>
  </div>

  <style>
    @media(max-width:992px){.commitment-layout{grid-template-columns:1fr!important}.commitment-grid{grid-template-columns:1fr!important}}
    @media(max-width:640px){.commitment-layout{padding:0 4px}}
  </style>
</section>
