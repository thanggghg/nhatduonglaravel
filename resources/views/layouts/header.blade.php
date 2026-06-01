{{-- HEADER: xanh solid, logo trắng, nav ngang, CTA vàng --}}
<header style="position:sticky; top:0; z-index:1000; background:linear-gradient(180deg,#0b7f42,#096b39); box-shadow:0 4px 20px rgba(11,127,66,0.30);">
  <div style="width:min(1280px,94%); margin:0 auto; min-height:68px; display:flex; align-items:center; justify-content:space-between; gap:16px; padding:0 16px;">

    {{-- Logo --}}
    <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:12px; text-decoration:none; flex-shrink:0;">
      <img src="{{ asset('Nhat-Duong-Logo-1-768x543.png') }}"
           alt="Nhà Xe Nhật Dương"
           style="height:42px; width:auto; object-fit:contain; filter:brightness(0) invert(1);">
    </a>

    {{-- Desktop nav --}}
    <nav style="display:flex; align-items:center; gap:4px;" class="hidden lg:flex">
      @foreach([
        ['Trang Chủ','home'],
        ['Tuyến Đường','routes.index'],
        ['Lịch Trình','schedules.index'],
        ['Tin Tức','posts.index'],
        ['Về Chúng Tôi','about'],
        ['Liên Hệ','contact'],
      ] as [$label,$route])
      @php $active = request()->routeIs($route) || request()->routeIs(rtrim($route,'.index').'.*'); @endphp
      <a href="{{ route($route) }}"
         style="padding:8px 14px; border-radius:8px; font-size:14px; font-weight:{{ $active?'700':'600' }}; color:{{ $active?'#fbb116':'rgba(255,255,255,0.88)' }}; text-decoration:none; transition:all 0.15s; {{ $active?'background:rgba(255,255,255,0.12);':'' }}"
         onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,0.12)'"
         onmouseout="this.style.color='{{ $active?'#fbb116':'rgba(255,255,255,0.88)' }}';this.style.background='{{ $active?'rgba(255,255,255,0.12)':'transparent' }}'">
        {{ $label }}
      </a>
      @endforeach
    </nav>

    {{-- Right actions --}}
    <div style="display:flex; align-items:center; gap:10px;" class="hidden lg:flex">
      <a href="tel:1900 2879"
         style="display:flex; align-items:center; gap:6px; padding:9px 16px; border-radius:10px; background:#fff; color:#062d1c; font-size:14px; font-weight:800; text-decoration:none; white-space:nowrap; box-shadow:0 4px 12px rgba(0,0,0,0.12);">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        1900 2879
      </a>
      <a href="{{ route('booking.index') }}"
         style="display:flex; align-items:center; gap:6px; padding:9px 20px; border-radius:10px; background:linear-gradient(180deg,#ffdc47,#fbb116); color:#5a3e00; font-size:14px; font-weight:800; text-decoration:none; white-space:nowrap; box-shadow:0 4px 14px rgba(251,177,22,0.35); transition:all 0.15s;"
         onmouseover="this.style.filter='brightness(1.05)';this.style.transform='translateY(-1px)'"
         onmouseout="this.style.filter='none';this.style.transform='translateY(0)'">
        Đặt Vé Ngay
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>

    {{-- Mobile toggle --}}
    <div x-data="{ open: false }" class="lg:hidden">
      <button @click="open=!open" style="background:rgba(255,255,255,0.15); border:none; border-radius:8px; padding:8px; cursor:pointer; color:#fff;">
        <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg x-show="open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
      <div x-show="open" x-transition style="position:absolute; top:100%; left:0; right:0; background:#062d1c; border-top:1px solid rgba(255,255,255,0.10); padding:12px 16px; display:flex; flex-direction:column; gap:4px;">
        @foreach([['Trang Chủ','home'],['Tuyến Đường','routes.index'],['Lịch Trình','schedules.index'],['Tin Tức','posts.index'],['Về Chúng Tôi','about'],['Liên Hệ','contact']] as [$label,$route])
        <a href="{{ route($route) }}" style="padding:11px 14px; border-radius:8px; color:rgba(255,255,255,0.85); font-size:15px; font-weight:600; text-decoration:none; {{ request()->routeIs($route)?'background:rgba(255,255,255,0.10);color:#fbb116;':'' }}">{{ $label }}</a>
        @endforeach
        <div style="margin-top:8px; padding-top:10px; border-top:1px solid rgba(255,255,255,0.10); display:flex; flex-direction:column; gap:8px;">
          <a href="tel:1900 2879" style="padding:11px 14px; border-radius:8px; background:#fff; color:#062d1c; font-weight:800; font-size:14px; text-decoration:none; text-align:center;">☎ 1900 2879</a>
          <a href="{{ route('booking.index') }}" style="padding:11px 14px; border-radius:8px; background:linear-gradient(180deg,#ffdc47,#fbb116); color:#5a3e00; font-weight:800; font-size:14px; text-decoration:none; text-align:center;">Đặt Vé Ngay</a>
        </div>
      </div>
    </div>

  </div>
</header>
