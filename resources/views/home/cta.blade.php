{{-- CTA / LIÊN HỆ — bám theo homepage/cta.blade.php.html --}}
<section style="padding:92px 0 104px; background:#f5f6f2; color:#123c2c;">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    @php
      $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
      $ctaImage = !empty($settings['home_cta_image'])
          ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings['home_cta_image'])
          : asset('nha-xe-binh-minh-bus-2048x867.png');
    @endphp
    <div style="background:#fff; border-radius:18px; padding:22px; display:grid; grid-template-columns:1.35fr 0.95fr; gap:22px; box-shadow:0 18px 45px rgba(0,0,0,0.08);" class="rental-section-grid">
      <div style="position:relative; border-radius:16px; overflow:hidden; background:linear-gradient(180deg,#fffdf6,#eef4ea); padding:30px 30px 20px;">
        <div style="display:inline-flex; align-items:center; gap:7px; background:#fff6d7; color:#235c34; padding:8px 14px; border-radius:999px; font-size:13px; font-weight:900; margin-bottom:16px;">{{ $setting('home_cta_badge', '⭐ DỊCH VỤ THUÊ XE HỢP ĐỒNG') }}</div>

        <h2 style="font-size:46px; line-height:1.05; font-weight:900; color:#064021; margin:0 0 14px; letter-spacing:-1px;">{{ $setting('home_cta_title_primary', 'Cần thuê xe riêng') }} <br><span style="color:#f5a800;">{{ $setting('home_cta_title_highlight', 'cho đoàn của bạn?') }}</span></h2>

        <p style="max-width:520px; color:#607267; font-size:15px; line-height:1.65; margin:0 0 22px;">{{ $setting('home_cta_description', 'Nhật Dương cung cấp dịch vụ thuê xe trọn gói cho đoàn du lịch, công ty, trường học, sự kiện... với đội xe đời mới, tài xế chuyên nghiệp, cam kết an toàn - đúng giờ - giá tốt.') }}</p>

        <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:14px; max-width:620px;" class="cta-category-list">
          @foreach([
            ['🏖️', 'Du lịch'],
            ['🏢', 'Công ty'],
            ['🎓', 'Trường học'],
            ['💍', 'Tiệc cưới'],
            ['🎤', 'Sự kiện'],
          ] as [$icon, $label])
          <div style="background:#fff; border:1px solid #e3ece5; border-radius:14px; padding:13px 8px; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,0.04);">
            <div style="width:38px; height:38px; margin:0 auto 8px; border-radius:50%; background:#eaf5e8; color:#0a6b38; display:flex; align-items:center; justify-content:center; font-size:20px;">{{ $icon }}</div>
            <p style="font-size:12px; font-weight:800; color:#123c2c; margin:0;">{{ $label }}</p>
          </div>
          @endforeach
        </div>

        <div style="display:inline-flex; align-items:center; gap:8px; background:#064021; color:#fff; border-radius:999px; padding:9px 16px; font-size:13px; font-weight:800; margin-bottom:16px;">✅ Đội xe từ <span style="color:#ffd44d;">Limousine cao cấp</span> đến giường nằm đời mới, đáp ứng mọi nhu cầu</div>

        <div style="height:270px; border-radius:18px; overflow:hidden; background:linear-gradient(180deg, rgba(255,255,255,0), rgba(4,49,28,0.12)), url('{{ $ctaImage }}'); background-size:cover; background-position:center; margin-top:6px; box-shadow:inset 0 -40px 60px rgba(0,0,0,0.18);"></div>

        <div style="background:#fff; border-radius:16px; padding:14px; display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:-34px; position:relative; z-index:2; box-shadow:0 12px 28px rgba(0,0,0,0.12);" class="cta-benefit-bar">
          @foreach([
            ['↗', 'An toàn tuyệt đối', 'Xe được bảo dưỡng định kỳ'],
            ['👨‍✈️', 'Tài xế chuyên nghiệp', 'Kinh nghiệm, lịch sự, nhiệt tình'],
            ['⏱', 'Đúng giờ, đúng hẹn', 'Cam kết lịch trình theo thỏa thuận'],
            ['💬', 'Báo giá minh bạch', 'Báo giá rõ ràng, không phát sinh'],
          ] as [$icon, $title, $desc])
          <div style="display:flex; align-items:center; gap:9px;">
            <div style="width:32px; height:32px; border-radius:50%; background:#edf7e9; color:#0a6b38; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:15px;">{{ $icon }}</div>
            <div>
              <strong style="display:block; color:#143d2a; font-size:12px; margin-bottom:3px;">{{ $title }}</strong>
              <span style="display:block; font-size:11px; color:#6b7b70; line-height:1.35;">{{ $desc }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,0.12); border:1px solid #e6eee7;">
        <div style="background:#004323; color:#fff; padding:24px 26px; display:flex; align-items:center; gap:16px;">
          <div style="width:50px; height:50px; border:2px solid #f4ad00; color:#f4ad00; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0;">📋</div>
          <div>
            <h3 style="font-size:22px; margin:0 0 6px;">Nhận báo giá nhanh</h3>
            <p style="font-size:13px; line-height:1.45; color:#e8f2eb; margin:0;">Điền thông tin, chúng tôi sẽ liên hệ tư vấn và báo giá trong <span style="color:#ffd44d; font-weight:900;">30 phút!</span></p>
          </div>
        </div>

        <form action="{{ route('contact.store') }}" method="POST" style="padding:24px 26px;">
          @csrf

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">👤</span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Họ và tên *" required style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;" />
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">📞</span>
            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại *" required style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;" />
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">📅</span>
            <input type="text" value="{{ old('travel_date') }}" placeholder="Ngày đi *" style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;" />
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">👥</span>
            <select style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box; font-family:Arial,sans-serif;">
              <option>Số lượng khách *</option>
              <option>Dưới 10 khách</option>
              <option>10 - 20 khách</option>
              <option>20 - 40 khách</option>
              <option>Trên 40 khách</option>
            </select>
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">📍</span>
            <input type="text" value="{{ old('pickup_location') }}" placeholder="Điểm đi *" style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;" />
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#0a6b38; font-size:16px; z-index:1;">📍</span>
            <input type="text" value="{{ old('dropoff_location') }}" placeholder="Điểm đến *" style="width:100%; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;" />
          </div>

          <div style="position:relative; margin-bottom:13px;">
            <span style="position:absolute; left:15px; top:18px; color:#0a6b38; font-size:16px; z-index:1;">📝</span>
            <textarea name="message" placeholder="Yêu cầu khác nếu có" required style="width:100%; height:88px; resize:none; border:1px solid #dfe8e1; border-radius:12px; padding:15px 15px 15px 44px; font-size:14px; color:#173d2b; outline:none; background:#fff; box-sizing:border-box;">{{ old('message') }}</textarea>
          </div>

          <button type="submit" style="width:100%; border:none; border-radius:14px; background:linear-gradient(90deg,#f6a900,#ffc22d); color:#143000; padding:17px; font-size:16px; font-weight:900; cursor:pointer; margin-top:10px; display:flex; align-items:center; justify-content:center; gap:12px; box-shadow:0 10px 24px rgba(246,169,0,0.28);">
            NHẬN BÁO GIÁ NGAY
            <span style="width:28px; height:28px; border-radius:50%; background:#064021; color:#fff; display:flex; align-items:center; justify-content:center;">→</span>
          </button>

          <div style="margin-top:16px; text-align:center; color:#7d887f; font-size:12px; display:flex; align-items:center; justify-content:center; gap:6px;">🔒 Thông tin của bạn được bảo mật tuyệt đối</div>
        </form>
      </div>
    </div>
  </div>

  <style>
    @media (max-width: 1000px) {
      .rental-section-grid {
        grid-template-columns: 1fr !important;
      }
      .cta-category-list {
        grid-template-columns: repeat(3, 1fr) !important;
      }
      .cta-benefit-bar {
        grid-template-columns: repeat(2, 1fr) !important;
      }
    }
    @media (max-width: 600px) {
      section[style*='padding:92px 0 104px'] > div {
        padding: 0 16px !important;
      }
      .rental-section-grid {
        padding: 12px !important;
      }
      .rental-section-grid > div:first-child {
        padding: 24px 18px 18px !important;
      }
      .rental-section-grid h2 {
        font-size: 34px !important;
      }
      .cta-category-list {
        grid-template-columns: repeat(2, 1fr) !important;
      }
      .cta-benefit-bar {
        grid-template-columns: 1fr !important;
        margin-top: 14px !important;
      }
    }
  </style>
</section>
