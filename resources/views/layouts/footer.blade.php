<footer style="color:#fff; background: radial-gradient(circle at 20% 18%,rgba(249,178,26,.16),transparent 24%), linear-gradient(180deg,#0a5d03,#043801); padding:64px 2vw 26px;">
  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">

    <div style="display:grid; grid-template-columns:1.2fr .8fr .8fr 1fr; gap:28px; padding-bottom:40px; border-bottom:1px solid rgba(255,255,255,.14);" class="footer-grid">

      {{-- Brand --}}
      <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px; font-size:22px; font-weight:900; text-transform:uppercase;">
          <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}"
               alt="Nhà Xe Nhật Dương"
               style="height:40px; width:auto; object-fit:contain; filter:brightness(0) invert(1);">
        </div>
        <p style="margin:0 0 20px; color:rgba(255,255,255,.72); line-height:1.7; font-size:14px; font-weight:650;">
          Dịch vụ vận chuyển hành khách tuyến Sài Gòn ↔ Nha Trang. An toàn, đúng giờ, phục vụ tận tâm.
        </p>
        <div style="display:flex; gap:10px;">
          @foreach([
            ['M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z','#'],
            ['M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z','#'],
          ] as [$path,$href])
          <a href="{{ $href }}"
             style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,.12); display:grid; place-items:center; transition:background .2s; text-decoration:none;"
             onmouseover="this.style.background='#f9b21a'"
             onmouseout="this.style.background='rgba(255,255,255,.12)'">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
          </a>
          @endforeach
        </div>
      </div>

      {{-- Liên kết nhanh --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">Liên kết nhanh</h4>
        <div style="display:grid; gap:10px;">
          @foreach([
            ['Trang chủ','home'],
            ['Tuyến đường','routes.index'],
            ['Lịch trình','schedules.index'],
            ['Tin tức','posts.index'],
            ['Về chúng tôi','about'],
            ['Liên hệ','contact'],
          ] as [$label,$route])
          <a href="{{ route($route) }}"
             style="color:rgba(255,255,255,.75); font-size:14px; font-weight:750; text-decoration:none; transition:color .2s;"
             onmouseover="this.style.color='#f9b21a'"
             onmouseout="this.style.color='rgba(255,255,255,.75)'">{{ $label }}</a>
          @endforeach
        </div>
      </div>

      {{-- Dịch vụ --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">Dịch vụ</h4>
        <div style="display:grid; gap:10px;">
          @foreach(['Đặt vé một chiều','Đặt vé khứ hồi','Hỗ trợ giữ chỗ','Tư vấn điểm đón','Xe giường nằm VIP'] as $item)
          <span style="color:rgba(255,255,255,.70); font-size:14px; font-weight:650;">{{ $item }}</span>
          @endforeach
        </div>
      </div>

      {{-- Liên hệ --}}
      <div>
        <h4 style="margin:0 0 16px; color:#f9b21a; font-size:16px; font-weight:900;">Thông tin liên hệ</h4>
        <div style="display:grid; gap:12px;">
          @foreach([
            ['☎','Hotline: 1900 2879','tel:0123456789'],
            ['📍','Tuyến: Sài Gòn ↔ Nha Trang',null],
            ['⏱','Hỗ trợ 24/7',null],
            ['✉','info@nhatduong.com','mailto:info@nhatduong.com'],
          ] as [$icon,$text,$href])
          <div style="display:flex; align-items:center; gap:10px;">
            <span style="width:30px; height:30px; border-radius:50%; background:rgba(249,178,26,.20); display:grid; place-items:center; font-size:13px; flex-shrink:0;">{{ $icon }}</span>
            @if($href)
              <a href="{{ $href }}" style="color:rgba(255,255,255,.75); font-size:13px; font-weight:750; text-decoration:none;"
                 onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.75)'">{{ $text }}</a>
            @else
              <span style="color:rgba(255,255,255,.70); font-size:13px; font-weight:650;">{{ $text }}</span>
            @endif
          </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- Bottom --}}
    <div style="display:flex; justify-content:space-between; gap:18px; flex-wrap:wrap; padding-top:24px; color:rgba(255,255,255,.60); font-size:13px; font-weight:750;">
      <span>© {{ date('Y') }} Nhà xe Nhật Dương. All rights reserved.</span>
      <div style="display:flex; gap:20px;">
        <a href="#" style="color:rgba(255,255,255,.55); text-decoration:none; transition:color .2s;"
           onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Chính Sách Bảo Mật</a>
        <a href="#" style="color:rgba(255,255,255,.55); text-decoration:none; transition:color .2s;"
           onmouseover="this.style.color='#f9b21a'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Điều Khoản Sử Dụng</a>
      </div>
    </div>

  </div>

  <style>
    @media(max-width:1180px){ .footer-grid{grid-template-columns:1fr 1fr!important} }
    @media(max-width:640px){ .footer-grid{grid-template-columns:1fr!important} }
  </style>
</footer>
