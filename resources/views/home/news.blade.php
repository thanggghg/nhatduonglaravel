{{-- TIN TỨC & KHUYẾN MÃI — full-width, layout từ index-nhat-duong-news-promo-redesign.html --}}
<section style="position:relative; padding:92px 2vw 104px; overflow:hidden; background: radial-gradient(circle at 12% 12%, rgba(249,178,26,.16), transparent 24%), radial-gradient(circle at 88% 18%, rgba(18,124,7,.10), transparent 26%), linear-gradient(180deg,#f6fbf4 0%,#ffffff 100%);">

  <div style="width:min(1600px,98%); margin:0 auto; padding:0 16px;">

    {{-- Head --}}
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:30px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="width:7px; height:7px; border-radius:50%; background:#0b7f42; display:block;"></span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">Cập nhật mới nhất</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          Tin Tức & <span style="color:#0b7f42;">Khuyến Mãi</span>
        </h2>
      </div>
      <p style="max-width:480px; margin:0; color:#62735e; font-size:15px; line-height:1.7; font-weight:700;">
        Theo dõi ưu đãi, thông báo lịch chạy và các cập nhật mới nhất từ Nhà xe Nhật Dương trên tuyến Sài Gòn ↔ Nha Trang.
      </p>
    </div>

    {{-- Layout: featured left + side right --}}
    <div style="display:grid; grid-template-columns:1.05fr .95fr; gap:24px; align-items:stretch;" class="news-layout-grid">

      {{-- FEATURED — ảnh xe nền, promo float card, content bottom --}}
      <article style="position:relative; overflow:hidden; isolation:isolate; min-height:560px; border-radius:38px; color:#fff; background:#0a4210; box-shadow:0 30px 82px rgba(8,61,15,.22); border:1px solid rgba(255,255,255,.25); transition:transform 0.3s ease;"
               onmouseover="this.querySelector('.news-bg-img').style.transform='scale(1.045)'"
               onmouseout="this.querySelector('.news-bg-img').style.transform='scale(1)'">
        {{-- Background image --}}
        <img class="news-bg-img"
             src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}"
             alt=""
             style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:-3; transition:transform .6s ease;">
        {{-- Overlay --}}
        <div style="position:absolute; inset:0; z-index:-2; background: linear-gradient(90deg,rgba(3,42,8,.82),rgba(3,42,8,.30) 52%,rgba(3,42,8,.08)), linear-gradient(180deg,rgba(0,0,0,.02),rgba(0,38,10,.72));"></div>

        {{-- Promo float card --}}
        @php
          $featuredPost = $latestPosts->first() ?? null;
        @endphp
        <div style="position:absolute; top:34px; right:34px; z-index:4; width:172px; height:172px; display:grid; place-items:center; border-radius:34px; color:#043801; background:linear-gradient(180deg,#fff8d5,#ffe071); box-shadow:0 22px 52px rgba(249,178,26,.28); text-align:center; animation:floatCard 4.8s ease-in-out infinite;">
          <div>
            <strong style="display:block; font-size:50px; line-height:.9; font-weight:900; letter-spacing:-2px;">20%</strong>
            <span style="display:block; margin-top:8px; font-size:13px; font-weight:900; text-transform:uppercase;">Ưu đãi vé</span>
          </div>
        </div>

        {{-- Content bottom --}}
        <div style="position:absolute; left:34px; right:34px; bottom:34px; z-index:3; max-width:720px;">
          <span style="display:inline-flex; align-items:center; gap:8px; padding:9px 13px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.6px;">
            @if($featuredPost && $featuredPost->category)
              {{ $featuredPost->category->name }}
            @else
              Khuyến mãi nổi bật
            @endif
          </span>

          <h3 style="margin:22px 0 14px; color:#fff; font-size:clamp(28px,3.5vw,46px); line-height:1.05; letter-spacing:-1px; font-weight:900; text-shadow:0 8px 22px rgba(0,0,0,.34);">
            @if($featuredPost)
              {{ $featuredPost->title }}
            @else
              Đặt vé sớm, nhận ưu đãi cho tuyến Sài Gòn - Nha Trang
            @endif
          </h3>

          <p style="margin:0 0 24px; max-width:640px; color:rgba(255,255,255,.82); font-size:15px; line-height:1.75; font-weight:700;">
            @if($featuredPost && $featuredPost->excerpt)
              {{ Str::limit($featuredPost->excerpt, 140) }}
            @else
              Ưu đãi áp dụng cho khách hàng đặt vé trước. Số lượng vé khuyến mãi có hạn, hãy liên hệ hotline để được hỗ trợ giữ chỗ nhanh nhất.
            @endif
          </p>

          <div style="display:flex; gap:14px; flex-wrap:wrap;">
            @if($featuredPost)
            <a href="{{ route('posts.show', $featuredPost->slug) }}"
               style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 22px; border-radius:16px; font-size:15px; font-weight:900; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); box-shadow:0 16px 34px rgba(249,178,26,.24); text-decoration:none; transition:all .25s;"
               onmouseover="this.style.transform='translateY(-3px)'"
               onmouseout="this.style.transform='translateY(0)'">
              Xem chi tiết →
            </a>
            @else
            <a href="{{ route('posts.index') }}"
               style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 22px; border-radius:16px; font-size:15px; font-weight:900; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); box-shadow:0 16px 34px rgba(249,178,26,.24); text-decoration:none; transition:all .25s;"
               onmouseover="this.style.transform='translateY(-3px)'"
               onmouseout="this.style.transform='translateY(0)'">
              Xem ưu đãi →
            </a>
            @endif
            <a href="tel:0123456789"
               style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 20px; border-radius:16px; font-size:15px; font-weight:900; color:#fff; border:1px solid rgba(255,255,255,.34); background:rgba(255,255,255,.10); text-decoration:none; transition:all .25s;"
               onmouseover="this.style.transform='translateY(-3px)'"
               onmouseout="this.style.transform='translateY(0)'">
              Gọi hotline
            </a>
          </div>
        </div>
      </article>

      {{-- SIDE — news cards + mini banner --}}
      <div style="display:grid; gap:18px; align-content:start;">

        @php $sidePosts = $latestPosts->skip(1)->take(3); @endphp

        @if($sidePosts->isNotEmpty())
          @foreach($sidePosts as $post)
          <a href="{{ route('posts.show', $post->slug) }}"
             style="display:grid; grid-template-columns:180px 1fr; gap:18px; align-items:center; min-height:172px; padding:18px; border-radius:30px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10); text-decoration:none; transition:all .28s ease;"
             onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 30px 70px rgba(18,124,7,.16)';this.style.borderColor='rgba(18,124,7,.25)'"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 20px 52px rgba(18,124,7,.10)';this.style.borderColor='rgba(18,124,7,.14)'">
            {{-- Thumb --}}
            <div style="position:relative; overflow:hidden; min-height:136px; border-radius:24px; background:#0a4210; box-shadow:inset 0 -45px 50px rgba(0,45,8,.30);">
              @if($post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt=""
                     style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;">
              @else
                <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt=""
                     style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0; opacity:0.55;">
              @endif
              <span style="position:absolute; left:10px; bottom:10px; padding:6px 9px; border-radius:999px; color:#043801; background:#f9b21a; font-size:11px; font-weight:900;">
                @if($post->category) {{ $post->category->name }} @else Tin mới @endif
              </span>
            </div>
            {{-- Content --}}
            <div>
              <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:9px; color:#0b7f42; font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.4px;">
                <span>{{ $post->category->name ?? 'Tin tức' }}</span>
                <span>• {{ $post->published_at->format('d/m/Y') }}</span>
              </div>
              <h4 style="margin:0; color:#172315; font-size:18px; line-height:1.2; font-weight:900; letter-spacing:-.3px;">{{ Str::limit($post->title, 70) }}</h4>
              @if($post->excerpt)
              <p style="margin:8px 0 0; color:#62735e; font-size:13px; line-height:1.55; font-weight:650;">{{ Str::limit($post->excerpt, 90) }}</p>
              @endif
              <span style="display:inline-flex; align-items:center; gap:7px; margin-top:10px; color:#0b7f42; font-size:13px; font-weight:900;">Đọc thêm →</span>
            </div>
          </a>
          @endforeach
        @else
          {{-- Fallback cards khi không có bài viết --}}
          @foreach([
            ['Tin mới','Thông báo','Cập nhật lịch chạy hôm nay','Lịch trình được chia rõ 2 chiều: Sài Gòn đi Nha Trang và chiều ngược lại.','#lich-trinh'],
            ['Mẹo hay','Kinh nghiệm','Kinh nghiệm đi xe đêm thoải mái hơn','Chuẩn bị hành lý gọn nhẹ, chọn giờ phù hợp và đặt vé sớm để có vị trí ngồi tốt hơn.','#'],
            ['Ưu đãi','Khuyến mãi','Ưu đãi vé cho khách đặt sớm','Khách hàng đặt vé sớm có thể nhận thêm hỗ trợ giữ chỗ và tư vấn lịch trình nhanh chóng.','#'],
          ] as [$badge,$cat,$title,$desc,$link])
          <a href="{{ $link }}"
             style="display:grid; grid-template-columns:180px 1fr; gap:18px; align-items:center; min-height:172px; padding:18px; border-radius:30px; background:rgba(255,255,255,.96); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10); text-decoration:none; transition:all .28s ease;"
             onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 30px 70px rgba(18,124,7,.16)'"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 20px 52px rgba(18,124,7,.10)'">
            <div style="position:relative; overflow:hidden; min-height:136px; border-radius:24px; background:#0a4210; box-shadow:inset 0 -45px 50px rgba(0,45,8,.30);">
              <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt=""
                   style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0; opacity:0.55;">
              <span style="position:absolute; left:10px; bottom:10px; padding:6px 9px; border-radius:999px; color:#043801; background:#f9b21a; font-size:11px; font-weight:900;">{{ $badge }}</span>
            </div>
            <div>
              <div style="display:flex; gap:10px; margin-bottom:9px; color:#0b7f42; font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.4px;">
                <span>{{ $cat }}</span>
              </div>
              <h4 style="margin:0; color:#172315; font-size:18px; line-height:1.2; font-weight:900; letter-spacing:-.3px;">{{ $title }}</h4>
              <p style="margin:8px 0 0; color:#62735e; font-size:13px; line-height:1.55; font-weight:650;">{{ $desc }}</p>
              <span style="display:inline-flex; align-items:center; gap:7px; margin-top:10px; color:#0b7f42; font-size:13px; font-weight:900;">Đọc thêm →</span>
            </div>
          </a>
          @endforeach
        @endif

        {{-- Mini banner --}}
        <div style="min-height:150px; padding:24px; border-radius:30px; color:#fff; background: radial-gradient(circle at 88% 16%,rgba(249,178,26,.32),transparent 24%), linear-gradient(135deg,#0a5d03,#127c07); box-shadow:0 22px 58px rgba(18,124,7,.16); border:1px solid rgba(255,255,255,.18);">
          <h4 style="margin:0 0 9px; font-size:22px; line-height:1.15; font-weight:900;">Không bỏ lỡ chuyến đi của bạn</h4>
          <p style="margin:0 0 16px; color:rgba(255,255,255,.80); font-size:14px; line-height:1.6; font-weight:700;">Liên hệ Nhật Dương để được tư vấn giờ chạy, điểm đón và hỗ trợ đặt vé nhanh 24/7.</p>
          <a href="{{ route('posts.index') }}"
             style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:12px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); color:#fff; font-size:13px; font-weight:800; text-decoration:none; transition:all .2s;"
             onmouseover="this.style.background='rgba(255,255,255,0.22)'"
             onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            Xem tất cả tin tức →
          </a>
        </div>

      </div>{{-- /side --}}
    </div>{{-- /layout --}}
  </div>

  <style>
    @keyframes floatCard { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    @media(max-width:1180px){ .news-layout-grid{grid-template-columns:1fr!important} }
    @media(max-width:760px){
      .news-layout-grid article[style*="grid-template-columns:180px"]{grid-template-columns:1fr!important}
    }
  </style>
</section>
