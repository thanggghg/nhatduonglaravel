{{-- CONTACT SECTION — layout từ index-nhat-duong-complete-website.html --}}
<section style="position:relative; padding:92px 2vw 104px; background: radial-gradient(circle at 12% 12%,rgba(18,124,7,.10),transparent 24%), linear-gradient(180deg,#f6fbf4 0%,#ffffff 100%);">
  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">
    <div style="display:grid; grid-template-columns:.85fr 1.15fr; gap:28px; align-items:stretch;" class="contact-layout-grid">

      {{-- Panel xanh --}}
      <aside style="padding:34px; border-radius:36px; color:#fff; background: radial-gradient(circle at 86% 14%,rgba(249,178,26,.28),transparent 25%), linear-gradient(145deg,#0a5d03,#127c07); box-shadow:0 28px 78px rgba(8,61,15,.20);">
        <div style="display:inline-flex; align-items:center; gap:9px; margin-bottom:12px; color:#f9b21a; font-size:13px; font-weight:900; letter-spacing:1.2px; text-transform:uppercase;">
          <span style="width:8px; height:8px; border-radius:50%; background:#f9b21a; box-shadow:0 0 0 4px rgba(249,178,26,.18); display:block;"></span>
          Liên hệ đặt vé
        </div>
        <h2 style="margin:0 0 18px; color:#fff; font-size:clamp(36px,4vw,52px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Cần hỗ trợ?<br><span style="color:#f9b21a;">Nhật Dương luôn sẵn sàng</span>
        </h2>
        <p style="color:rgba(255,255,255,.80); font-size:15px; line-height:1.7; font-weight:700; margin:0 0 28px;">
          Gửi thông tin đặt vé hoặc gọi hotline để được tư vấn giờ chạy, điểm đón/trả và hỗ trợ giữ chỗ nhanh nhất.
        </p>

        <div style="display:grid; gap:14px;">
          @foreach([
            ['☎','Hotline: 1900 2879','tel:0123456789'],
            ['📍','Tuyến: Sài Gòn ↔ Nha Trang',null],
            ['⏱','Hỗ trợ khách hàng 24/7',null],
          ] as [$icon,$text,$href])
          <div style="display:flex; gap:12px; align-items:center; padding:16px; border-radius:20px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.15); font-weight:900; color:#fff; font-size:14px;">
            <span style="width:38px; height:38px; display:grid; place-items:center; border-radius:50%; background:#f9b21a; color:#043801; flex-shrink:0; font-size:16px;">{{ $icon }}</span>
            @if($href)
              <a href="{{ $href }}" style="color:#fff; text-decoration:none;">{{ $text }}</a>
            @else
              <span>{{ $text }}</span>
            @endif
          </div>
          @endforeach
        </div>
      </aside>

      {{-- Form --}}
      <div style="padding:34px; border-radius:36px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.13); box-shadow:0 22px 60px rgba(18,124,7,.10);">
        <form action="{{ route('contact.store') }}" method="POST">
          @csrf
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;" class="contact-form-grid">

            <div style="display:grid; gap:8px;">
              <label style="color:#274824; font-size:14px; font-weight:900;">Họ và tên</label>
              <input type="text" name="name" placeholder="Nhập họ tên của bạn" required
                     style="width:100%; border:1px solid rgba(18,124,7,.18); border-radius:16px; padding:15px 16px; outline:none; background:#fbfef9; color:#173014; font-size:15px; font-weight:750; box-sizing:border-box; transition:border-color .2s;"
                     onfocus="this.style.borderColor='#0b7f42'" onblur="this.style.borderColor='rgba(18,124,7,.18)'">
            </div>

            <div style="display:grid; gap:8px;">
              <label style="color:#274824; font-size:14px; font-weight:900;">Số điện thoại</label>
              <input type="tel" name="phone" placeholder="Nhập số điện thoại" required
                     style="width:100%; border:1px solid rgba(18,124,7,.18); border-radius:16px; padding:15px 16px; outline:none; background:#fbfef9; color:#173014; font-size:15px; font-weight:750; box-sizing:border-box; transition:border-color .2s;"
                     onfocus="this.style.borderColor='#0b7f42'" onblur="this.style.borderColor='rgba(18,124,7,.18)'">
            </div>

            <div style="display:grid; gap:8px;">
              <label style="color:#274824; font-size:14px; font-weight:900;">Chiều đi</label>
              <select name="direction"
                      style="width:100%; border:1px solid rgba(18,124,7,.18); border-radius:16px; padding:15px 16px; outline:none; background:#fbfef9; color:#173014; font-size:15px; font-weight:750; box-sizing:border-box; transition:border-color .2s;"
                      onfocus="this.style.borderColor='#0b7f42'" onblur="this.style.borderColor='rgba(18,124,7,.18)'">
                <option>Sài Gòn → Nha Trang</option>
                <option>Nha Trang → Sài Gòn</option>
              </select>
            </div>

            <div style="display:grid; gap:8px;">
              <label style="color:#274824; font-size:14px; font-weight:900;">Ngày đi</label>
              <input type="date" name="travel_date" min="{{ now()->format('Y-m-d') }}"
                     style="width:100%; border:1px solid rgba(18,124,7,.18); border-radius:16px; padding:15px 16px; outline:none; background:#fbfef9; color:#173014; font-size:15px; font-weight:750; box-sizing:border-box; transition:border-color .2s;"
                     onfocus="this.style.borderColor='#0b7f42'" onblur="this.style.borderColor='rgba(18,124,7,.18)'">
            </div>

            <div style="display:grid; gap:8px; grid-column:1/-1;">
              <label style="color:#274824; font-size:14px; font-weight:900;">Nội dung cần hỗ trợ</label>
              <textarea name="message" placeholder="Ví dụ: Tôi muốn đặt 2 vé chuyến tối nay..." rows="4"
                        style="width:100%; border:1px solid rgba(18,124,7,.18); border-radius:16px; padding:15px 16px; outline:none; background:#fbfef9; color:#173014; font-size:15px; font-weight:750; box-sizing:border-box; resize:vertical; min-height:120px; transition:border-color .2s;"
                        onfocus="this.style.borderColor='#0b7f42'" onblur="this.style.borderColor='rgba(18,124,7,.18)'"></textarea>
            </div>
          </div>

          <button type="submit"
                  style="width:100%; height:56px; margin-top:18px; border:0; border-radius:18px; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); font-size:17px; font-weight:900; cursor:pointer; box-shadow:0 16px 34px rgba(249,178,26,.24); transition:all .25s;"
                  onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 22px 44px rgba(249,178,26,.32)'"
                  onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 16px 34px rgba(249,178,26,.24)'">
            Gửi yêu cầu tư vấn →
          </button>
        </form>
      </div>

    </div>
  </div>

  <style>
    @media(max-width:1180px){ .contact-layout-grid{grid-template-columns:1fr!important} }
    @media(max-width:760px){ .contact-form-grid{grid-template-columns:1fr!important} }
  </style>
</section>
