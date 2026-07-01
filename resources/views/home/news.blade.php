{{-- TIN TỨC & KHUYẾN MÃI — editorial layout hiện đại --}}
@php
  $featuredPost = $latestPosts->first() ?? null;
  $secondaryPosts = $latestPosts->skip(1)->take(2);
  $compactPosts = $latestPosts->skip(3)->take(3);
  $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
@endphp

<section style="position:relative; padding:92px 0 104px; overflow:hidden; background:radial-gradient(circle at 12% 12%, rgba(249,178,26,.12), transparent 24%), radial-gradient(circle at 88% 18%, rgba(18,124,7,.08), transparent 26%), linear-gradient(180deg,#f6fbf4 0%,#ffffff 100%);">
  <div style="width:min(1728px,90%); margin:0 auto; padding:0 28px;">
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:30px; flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#eaf8e8; border:1px solid rgba(11,127,66,0.18); border-radius:999px; padding:6px 14px; margin-bottom:12px;">
          <span style="width:7px; height:7px; border-radius:50%; background:#0b7f42; display:block;"></span>
          <span style="color:#0b7f42; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em;">{{ $setting('home_news_badge', 'Cập nhật mới nhất') }}</span>
        </div>
        <h2 style="margin:0; color:#172315; font-size:clamp(36px,4vw,56px); line-height:.95; letter-spacing:-1.5px; font-weight:900;">
          {{ $setting('home_news_title_primary', 'Tin Tức &') }} <span style="color:#0b7f42;">{{ $setting('home_news_title_highlight', 'Khuyến Mãi') }}</span>
        </h2>
      </div>
      <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
        <p style="max-width:480px; margin:0; color:#62735e; font-size:15px; line-height:1.7; font-weight:700;">
          {{ $setting('home_news_description', 'Theo dõi ưu đãi, thông báo lịch chạy và những cập nhật quan trọng từ Nhà xe Nhật Dương theo cách trực quan và dễ đọc hơn.') }}
        </p>
        <a href="{{ route('posts.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#0b7f42; font-size:15px; font-weight:900; text-decoration:none; white-space:nowrap;">Xem tất cả →</a>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:minmax(0,1.05fr) minmax(320px,.95fr); gap:24px; align-items:stretch;" class="news-editorial-grid">
      <article style="position:relative; overflow:hidden; min-height:620px; border-radius:34px; background:#0a4210; box-shadow:0 30px 82px rgba(8,61,15,.18); border:1px solid rgba(255,255,255,.22);">
        <img src="{{ $featuredPost && $featuredPost->thumbnail ? asset('storage/'.$featuredPost->thumbnail) : asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="{{ $featuredPost->title ?? 'Tin nổi bật' }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .6s ease;" class="news-featured-image">
        <div style="position:absolute; inset:0; background:linear-gradient(180deg,rgba(3,42,8,.14),rgba(3,42,8,.44) 48%,rgba(3,42,8,.88) 100%);"></div>

        <div style="position:absolute; top:28px; left:28px; right:28px; display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; z-index:2;">
          <span style="display:inline-flex; align-items:center; gap:8px; padding:9px 13px; border-radius:999px; color:#043801; background:linear-gradient(180deg,#ffe681,#f9b21a); font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.6px;">
            {{ $featuredPost?->category?->name ?? 'Tin nổi bật' }}
          </span>
          <span style="display:inline-flex; align-items:center; gap:8px; padding:9px 13px; border-radius:999px; color:#fff; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.16); font-size:12px; font-weight:800; backdrop-filter:blur(8px);">
            {{ $featuredPost?->published_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}
          </span>
        </div>

        <div style="position:absolute; left:28px; right:28px; bottom:28px; z-index:2; max-width:760px;">
          <h3 style="margin:0 0 14px; color:#fff; font-size:clamp(32px,4vw,50px); line-height:1.02; letter-spacing:-1px; font-weight:900; text-shadow:0 8px 22px rgba(0,0,0,.34);">
            {{ $featuredPost?->title ?? 'Đặt vé sớm để chọn khung giờ phù hợp hơn cho tuyến Sài Gòn - Nha Trang' }}
          </h3>
          <p style="margin:0 0 22px; max-width:640px; color:rgba(255,255,255,.82); font-size:15px; line-height:1.75; font-weight:700;">
            {{ $featuredPost?->excerpt ? Str::limit($featuredPost->excerpt, 170) : 'Tổng hợp các thông báo vận hành, lịch chạy trong ngày và ưu đãi mới để hành khách dễ dàng lên kế hoạch di chuyển.' }}
          </p>
          <div style="display:flex; gap:14px; flex-wrap:wrap;">
            <a href="{{ $featuredPost ? route('posts.show', $featuredPost->slug) : route('posts.index') }}" style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 22px; border-radius:16px; font-size:15px; font-weight:900; color:#043801; background:linear-gradient(180deg,#ffdc47,#f9b21a); box-shadow:0 16px 34px rgba(249,178,26,.24); text-decoration:none; transition:all .25s;">Đọc bài nổi bật →</a>
            <a href="{{ route('booking.index') }}" style="min-height:48px; display:inline-flex; align-items:center; justify-content:center; padding:0 20px; border-radius:16px; font-size:15px; font-weight:900; color:#fff; border:1px solid rgba(255,255,255,.34); background:rgba(255,255,255,.10); text-decoration:none; transition:all .25s;">Đặt vé nhanh</a>
          </div>
        </div>
      </article>

      <div style="display:grid; gap:18px; align-content:start;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;" class="news-secondary-grid">
          @forelse($secondaryPosts as $post)
          <a href="{{ route('posts.show', $post->slug) }}" style="display:flex; flex-direction:column; min-height:300px; border-radius:28px; overflow:hidden; background:rgba(255,255,255,.97); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10); text-decoration:none; transition:all .28s ease;">
            <div style="height:170px; position:relative; overflow:hidden; background:#0a4210;">
              <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="{{ $post->title }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
              <span style="position:absolute; left:14px; bottom:14px; padding:6px 10px; border-radius:999px; color:#043801; background:#f9b21a; font-size:11px; font-weight:900;">{{ $post->category->name ?? 'Tin mới' }}</span>
            </div>
            <div style="padding:18px 18px 22px; display:flex; flex-direction:column; gap:10px; flex:1;">
              <div style="color:#0b7f42; font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.4px;">{{ $post->published_at?->format('d/m/Y') }}</div>
              <h4 style="margin:0; color:#172315; font-size:20px; line-height:1.18; font-weight:900; letter-spacing:-.3px;">{{ Str::limit($post->title, 62) }}</h4>
              <p style="margin:0; color:#62735e; font-size:13px; line-height:1.6; font-weight:650;">{{ Str::limit($post->excerpt ?: $post->title, 90) }}</p>
              <span style="display:inline-flex; align-items:center; gap:7px; margin-top:auto; color:#0b7f42; font-size:13px; font-weight:900;">Đọc thêm →</span>
            </div>
          </a>
          @empty
          @foreach([
            ['Thông báo lịch chạy hôm nay', 'Cập nhật các khung giờ phổ biến để khách hàng dễ sắp xếp thời gian di chuyển.'],
            ['Ưu đãi cho khách đặt sớm', 'Giữ chỗ sớm để chọn giờ đẹp và nhận hỗ trợ nhanh hơn từ đội ngũ vận hành.'],
          ] as [$title, $desc])
          <article style="display:flex; flex-direction:column; min-height:300px; border-radius:28px; overflow:hidden; background:rgba(255,255,255,.97); border:1px solid rgba(18,124,7,.14); box-shadow:0 20px 52px rgba(18,124,7,.10);">
            <div style="height:170px; position:relative; background:#0a4210;">
              <img src="{{ asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="{{ $title }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:.72;">
            </div>
            <div style="padding:18px 18px 22px; display:flex; flex-direction:column; gap:10px; flex:1;">
              <div style="color:#0b7f42; font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.4px;">Tin mới</div>
              <h4 style="margin:0; color:#172315; font-size:20px; line-height:1.18; font-weight:900; letter-spacing:-.3px;">{{ $title }}</h4>
              <p style="margin:0; color:#62735e; font-size:13px; line-height:1.6; font-weight:650;">{{ $desc }}</p>
              <span style="display:inline-flex; align-items:center; gap:7px; margin-top:auto; color:#0b7f42; font-size:13px; font-weight:900;">Xem thêm →</span>
            </div>
          </article>
          @endforeach
          @endforelse
        </div>

        <div style="display:grid; grid-template-columns:1.1fr .9fr; gap:18px;" class="news-lower-grid">
          <div style="display:grid; gap:14px;">
            @forelse($compactPosts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" style="display:grid; grid-template-columns:88px 1fr; gap:14px; align-items:center; padding:14px; border-radius:22px; background:#fff; border:1px solid rgba(18,124,7,.12); box-shadow:0 14px 32px rgba(18,124,7,.08); text-decoration:none; transition:all .24s ease;">
              <div style="height:88px; border-radius:16px; overflow:hidden; position:relative; background:#0a4210;">
                <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : asset('nha-xe-binh-minh-bus-2048x867.png') }}" alt="{{ $post->title }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
              </div>
              <div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:6px; color:#0b7f42; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:.35px;">
                  <span>{{ $post->category->name ?? 'Tin tức' }}</span>
                  <span>• {{ $post->published_at?->format('d/m/Y') }}</span>
                </div>
                <h5 style="margin:0; color:#172315; font-size:16px; line-height:1.25; font-weight:900;">{{ Str::limit($post->title, 58) }}</h5>
              </div>
            </a>
            @empty
            <div style="padding:18px; border-radius:22px; background:#fff; border:1px solid rgba(18,124,7,.12); box-shadow:0 14px 32px rgba(18,124,7,.08); color:#62735e; font-size:14px; font-weight:700;">Nội dung mới sẽ được cập nhật tại đây.</div>
            @endforelse
          </div>

          <div style="min-height:100%; padding:24px; border-radius:30px; color:#fff; background:radial-gradient(circle at 88% 16%,rgba(249,178,26,.32),transparent 24%), linear-gradient(135deg,#0a5d03,#127c07); box-shadow:0 22px 58px rgba(18,124,7,.16); border:1px solid rgba(255,255,255,.18); display:flex; flex-direction:column; justify-content:space-between; gap:18px;">
            <div>
              <div style="display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.16); color:#fff; font-size:11px; font-weight:800; text-transform:uppercase;">Cập nhật nhanh</div>
              <h4 style="margin:16px 0 10px; font-size:26px; line-height:1.1; font-weight:900;">Đừng bỏ lỡ các thay đổi về giờ chạy và ưu đãi mới</h4>
              <p style="margin:0; color:rgba(255,255,255,.82); font-size:14px; line-height:1.65; font-weight:700;">Theo dõi mục tin tức để luôn nắm được các thay đổi vận hành, chính sách hỗ trợ và chương trình dành cho khách đặt vé sớm.</p>
            </div>
            <div style="display:grid; gap:10px;">
              @foreach(['Thông báo lịch chạy', 'Cập nhật tuyến cố định', 'Ưu đãi cho khách đặt sớm'] as $item)
              <div style="display:flex; align-items:center; gap:10px; color:#fff; font-size:13px; font-weight:800;">
                <span style="width:26px; height:26px; border-radius:50%; background:rgba(255,255,255,.14); display:grid; place-items:center; color:#ffe681; flex-shrink:0;">•</span>
                {{ $item }}
              </div>
              @endforeach
            </div>
            <a href="{{ route('posts.index') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:48px; border-radius:16px; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.22); color:#fff; font-size:14px; font-weight:900; text-decoration:none;">Xem tất cả tin tức</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .news-editorial-grid article:hover .news-featured-image {
      transform: scale(1.04);
    }
    .news-secondary-grid > a:hover,
    .news-lower-grid a:hover {
      transform: translateY(-5px);
      box-shadow: 0 28px 64px rgba(18,124,7,.14);
      border-color: rgba(18,124,7,.22);
    }
    @media(max-width:1180px){ .news-editorial-grid,.news-lower-grid{grid-template-columns:1fr!important} }
    @media(max-width:760px){ .news-secondary-grid{grid-template-columns:1fr!important} }
    @media(max-width:520px){ section[style*='padding:92px 0 104px'] > div{padding:0 16px!important} }
  </style>
</section>
