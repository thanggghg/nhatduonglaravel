{{-- TRẢI NGHIỆM NHẬT DƯƠNG — bám sát homepage/why-us.blade.php.html --}}
<section style="padding:92px 0 102px; background:#f7f8f4; color:#103c25;">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    @php
      $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
      $whyImage = function ($key) use ($settings) {
          if (empty($settings[$key])) {
              return asset('nha-xe-binh-minh-bus-2048x867.png');
          }

          return \Illuminate\Support\Facades\Storage::disk('public')->url($settings[$key]);
      };
    @endphp
    <div style="background:#ffffff; border-radius:22px; padding:26px 28px 34px; box-shadow:0 18px 45px rgba(0,0,0,0.08);" class="experience-section-shell">
    <div style="text-align:center; margin-bottom:26px;">
      <div style="display:inline-flex; align-items:center; gap:6px; background:#fff6d8; color:#416927; border-radius:999px; padding:7px 15px; font-size:13px; font-weight:800; margin-bottom:8px;">{{ $setting('home_why_badge', '⭐ TRẢI NGHIỆM KHÁC BIỆT CÙNG') }}</div>
      <h2 style="font-size:64px; line-height:0.95; color:#003a1d; font-weight:900; letter-spacing:1px; text-transform:uppercase; margin:0;">{{ $setting('home_why_title', 'NHẬT DƯƠNG') }}</h2>
      <p style="margin:10px 0 0; font-size:14px; color:#4b6658; font-weight:600;">{{ $setting('home_why_subtitle', 'Nâng tầm trải nghiệm di chuyển trên tuyến Sài Gòn → Nha Trang') }}</p>
    </div>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:20px;" class="experience-feature-cards">
      @foreach([
        ['01', $setting('home_why_card_1_title', 'Xe phòng chuẩn 5 sao'), 'Nhật Dương mang đến trải nghiệm dịch vụ cao cấp với dòng xe phòng Vip Limousine 22 phòng, không gian riêng tư và thoải mái cho hành trình dài.', $whyImage('home_why_card_1_image')],
        ['02', $setting('home_why_card_2_title', 'Miễn phí đưa đón'), 'Xe trung chuyển hỗ trợ trong khu vực nội thành Nha Trang và các điểm thuận tiện, giúp hành khách lên xe đúng giờ và tiết kiệm thời gian di chuyển.', $whyImage('home_why_card_2_image')],
        ['03', $setting('home_why_card_3_title', 'Đáp ứng yêu cầu khách hàng'), 'Đội ngũ hỗ trợ lắng nghe nhu cầu của từng hành khách, đồng hành xuyên suốt để mỗi chuyến đi luôn an toàn, dễ chịu và đúng kế hoạch.', $whyImage('home_why_card_3_image')],
      ] as [$num, $title, $desc, $image])
      <article style="background:#ffffff; border:1px solid #e7eee8; border-radius:16px; overflow:hidden; box-shadow:0 10px 24px rgba(0,0,0,0.06);">
        <div style="position:relative; height:205px; overflow:hidden;">
          <img src="{{ $image }}" alt="{{ $title }}" style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s ease;" class="experience-card-image">
          <div style="position:absolute; top:12px; left:12px; width:38px; height:38px; border-radius:10px; background:#00582f; color:#fff56b; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:15px; box-shadow:0 8px 18px rgba(0,0,0,0.25);">{{ $num }}</div>
        </div>

        <div style="padding:18px 18px 22px;">
          <div style="font-size:22px; color:#123c25; font-weight:900; margin-bottom:12px; line-height:1.25; text-transform:uppercase; letter-spacing:0.04em;">
            {{ $title }}
          </div>

          <p style="font-size:14px; line-height:1.65; color:#405d4d; font-weight:500; margin:0;">{{ $desc }}</p>
        </div>
      </article>
      @endforeach
    </div>

    <div style="background:#ffffff; border:1px solid #e8efe8; border-radius:18px; padding:22px; display:grid; grid-template-columns:repeat(3,1fr); gap:18px 26px; box-shadow:0 14px 34px rgba(0,0,0,0.07);" class="experience-benefit-panel">
      @foreach([
        'Giá bình ổn, minh bạch cho mọi khách hàng',
        'Đáp ứng nhu cầu đón trả tận nơi bằng xe trung chuyển',
        'Khởi hành đúng giờ, đúng lộ trình cam kết',
        'Wifi tốc độ cao, cổng sạc USB tiện lợi',
        'Cam kết không đón trả dọc đường gây bất tiện',
        'Nói là có nhân viên hỗ trợ nhanh chóng',
        'Miễn phí nước uống, khăn lạnh và tiện ích cơ bản',
        'Hỗ trợ miễn phí trong bán kính nội thành phù hợp',
        'Mền gối sạch sẽ, thơm tho và dễ chịu suốt chuyến đi',
      ] as $text)
      <div style="display:flex; align-items:center; gap:12px; min-height:48px;">
        <div style="color:#d4a017; font-size:22px; line-height:1; font-weight:900; flex-shrink:0; margin-top:1px;">✔</div>
        <div style="font-size:14px; color:#1c3f2d; font-weight:800; line-height:1.45;">{{ $text }}</div>
      </div>
      @endforeach
    </div>
    </div>
  </div>

  <style>
    .experience-feature-cards article:hover .experience-card-image {
      transform: scale(1.05);
    }
    @media (max-width: 992px) {
      .experience-section-shell h2 {
        font-size: 48px !important;
      }
      .experience-feature-cards {
        grid-template-columns: 1fr !important;
      }
      .experience-feature-cards article div[style*='height:205px'] {
        height: 260px !important;
      }
      .experience-benefit-panel {
        grid-template-columns: repeat(2, 1fr) !important;
      }
    }
    @media (max-width: 600px) {
      section[style*='padding:92px 0 102px'] > div {
        padding: 0 16px !important;
      }
      .experience-section-shell {
        padding: 22px 14px !important;
      }
      .experience-section-shell h2 {
        font-size: 38px !important;
      }
      .experience-section-shell p[style*='font-size:14px; color:#4b6658'] {
        font-size: 13px !important;
      }
      .experience-feature-cards article div[style*='height:205px'] {
        height: 210px !important;
      }
      .experience-benefit-panel {
        grid-template-columns: 1fr !important;
        padding: 18px !important;
      }
    }
  </style>
</section>
