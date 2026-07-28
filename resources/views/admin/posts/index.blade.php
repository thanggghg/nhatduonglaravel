@extends('admin.layouts.app')

@section('title', 'Quản lý bài viết')
@section('page-title', 'Nội dung')

@section('content')
<div class="posts-studio">
    <section class="posts-studio__hero">
        <div>
            <p class="posts-studio__eyebrow">TRUNG TÂM NỘI DUNG</p>
            <h1>Bài viết &amp; câu chuyện hành trình</h1>
            <p>Soạn, kiểm tra và quản lý nội dung hiển thị trên website Nhật Dương.</p>
        </div>
        <div class="posts-studio__hero-actions">
            <span><b>{{ $posts->total() }}</b> bài viết</span>
            <a href="{{ route('admin.posts.create') }}" class="posts-studio__create">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                Viết bài mới
            </a>
        </div>
    </section>

    <section class="posts-studio__panel" aria-labelledby="posts-list-heading">
        <header class="posts-studio__panel-head">
            <div>
                <p class="posts-studio__kicker">THƯ VIỆN BÀI VIẾT</p>
                <h2 id="posts-list-heading">Tất cả bài viết</h2>
            </div>
            <p>{{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} trong {{ $posts->total() }}</p>
        </header>

        <div class="posts-studio__table-wrap">
            <table class="posts-studio__table">
                <thead>
                    <tr>
                        <th scope="col">Bài viết</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Xuất bản</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col"><span class="sr-only">Thao tác</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td data-label="Bài viết">
                                <div class="posts-studio__story">
                                    @if($post->thumbnail)
                                        <img src="{{ Storage::url($post->thumbnail) }}" alt="" class="posts-studio__thumbnail">
                                    @else
                                        <div class="posts-studio__thumbnail posts-studio__thumbnail--empty" aria-hidden="true">
                                            <svg viewBox="0 0 24 24"><path d="M4 19 9.5 13.5l3.5 3.5 2.5-2.5L20 19M7.5 9.5h.01M5 21h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="posts-studio__title">{{ $post->title }}</a>
                                        <p>{{ $post->summary ? Str::limit($post->summary, 88) : 'Chưa có phần tóm tắt cho bài viết này.' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Danh mục"><span class="posts-studio__category">{{ $post->category->name ?? 'Chưa phân loại' }}</span></td>
                            <td data-label="Xuất bản">
                                <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('d/m/Y') ?? 'Chưa lên lịch' }}</time>
                                @if($post->published_at)<small>{{ $post->published_at->format('H:i') }}</small>@endif
                            </td>
                            <td data-label="Trạng thái">
                                @if($post->status)
                                    <span class="posts-studio__status posts-studio__status--live"><i></i>Đang hiển thị</span>
                                @else
                                    <span class="posts-studio__status posts-studio__status--draft"><i></i>Bản nháp</span>
                                @endif
                            </td>
                            <td class="posts-studio__actions" data-label="Thao tác">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="posts-studio__icon-button" title="Sửa {{ $post->title }}" aria-label="Sửa {{ $post->title }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14.5 5.5 4 4M4 20l4.2-.9L19 8.3a2.8 2.8 0 0 0-4-4L4.2 15.1 4 20Z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Xóa bài viết này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="posts-studio__icon-button posts-studio__icon-button--delete" title="Xóa {{ $post->title }}" aria-label="Xóa {{ $post->title }}">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v5m4-5v5M9 7l1-2h4l1 2m-9 0 1 13h10l1-13"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="posts-studio__empty">
                                    <span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h10l4 4v12H5V4Zm9 0v5h5M8 13h8M8 17h5"/></svg></span>
                                    <h3>Thư viện đang trống</h3>
                                    <p>Bắt đầu với bài viết đầu tiên để xây dựng nội dung cho hành khách.</p>
                                    <a href="{{ route('admin.posts.create') }}">Tạo bài viết mới</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="posts-studio__pagination">{{ $posts->links() }}</div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
    .posts-studio{max-width:1200px;margin:0 auto;color:#2c3e36;font-family:Inter,ui-sans-serif,system-ui,sans-serif}.posts-studio__hero{display:flex;align-items:end;justify-content:space-between;gap:32px;min-height:204px;margin:-32px -32px 32px;padding:42px 48px 38px;color:#fff;background:radial-gradient(circle at 86% 12%,rgba(251,177,22,.28),transparent 24%),linear-gradient(125deg,#062d1c,#0b7f42)}.posts-studio__eyebrow,.posts-studio__kicker{margin:0 0 10px;font-size:11px;font-weight:800;letter-spacing:.12em}.posts-studio__eyebrow{color:#d4f4e2}.posts-studio__hero h1{max-width:660px;margin:0;color:#fff;font-size:clamp(30px,4vw,42px);line-height:1.1;letter-spacing:-.04em}.posts-studio__hero p:not(.posts-studio__eyebrow){max-width:590px;margin:13px 0 0;color:#d4f4e2;font-size:15px;line-height:1.55}.posts-studio__hero-actions{display:flex;align-items:center;gap:16px;flex-shrink:0}.posts-studio__hero-actions>span{display:grid;gap:2px;min-width:74px;color:#d4f4e2;font-size:11px;text-align:right}.posts-studio__hero-actions b{color:#fff;font-size:24px;line-height:1}.posts-studio__create{display:inline-flex;align-items:center;gap:9px;padding:13px 17px;color:#563d00;background:#fbb116;border-radius:8px;font-size:14px;font-weight:800;text-decoration:none;box-shadow:0 8px 18px rgba(0,0,0,.15);transition:transform .18s,background .18s}.posts-studio__create:hover{background:#ffca4f;transform:translateY(-1px)}.posts-studio__create svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.3;stroke-linecap:round}.posts-studio__panel{overflow:hidden;background:#fff;border:1px solid #d1ddd5;border-radius:16px;box-shadow:0 4px 16px rgba(11,127,66,.1)}.posts-studio__panel-head{display:flex;align-items:end;justify-content:space-between;gap:20px;padding:25px 28px;border-bottom:1px solid #d1ddd5}.posts-studio__kicker{color:#0b7f42}.posts-studio__panel-head h2{margin:0;color:#062d1c;font-size:20px;letter-spacing:-.02em}.posts-studio__panel-head>p{margin:0;color:#5a6c62;font-size:13px}.posts-studio__table-wrap{overflow-x:auto}.posts-studio__table{width:100%;min-width:820px;border-collapse:collapse}.posts-studio__table th{padding:13px 20px;color:#5a6c62;background:#f8fdf9;border-bottom:1px solid #d1ddd5;font-size:11px;font-weight:800;letter-spacing:.08em;text-align:left;text-transform:uppercase}.posts-studio__table th:first-child,.posts-studio__table td:first-child{padding-left:28px}.posts-studio__table th:last-child,.posts-studio__table td:last-child{padding-right:28px}.posts-studio__table td{padding:16px 20px;border-bottom:1px solid #e6eee8;color:#5a6c62;font-size:13px;vertical-align:middle}.posts-studio__table tbody tr{transition:background .16s}.posts-studio__table tbody tr:hover{background:#f8fdf9}.posts-studio__table tbody tr:last-child td{border-bottom:0}.posts-studio__story{display:flex;align-items:center;gap:14px;min-width:320px}.posts-studio__thumbnail{width:58px;height:58px;flex:0 0 58px;object-fit:cover;border-radius:10px;background:#e8f8ef}.posts-studio__thumbnail--empty{display:grid;place-items:center;color:#0b7f42}.posts-studio__thumbnail svg{width:25px;fill:none;stroke:currentColor;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}.posts-studio__title{display:block;max-width:360px;color:#062d1c;font-size:14px;font-weight:800;line-height:1.35;text-decoration:none}.posts-studio__title:hover{color:#0b7f42}.posts-studio__story p{max-width:390px;margin:5px 0 0;overflow:hidden;color:#8a9c92;font-size:12px;line-height:1.45;text-overflow:ellipsis;white-space:nowrap}.posts-studio__category{display:inline-flex;max-width:150px;padding:5px 9px;overflow:hidden;color:#085d32;background:#e8f8ef;border-radius:999px;font-size:11px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}.posts-studio__table time,.posts-studio__table time+small{display:block}.posts-studio__table time{color:#2c3e36;font-weight:700}.posts-studio__table small{margin-top:3px;color:#8a9c92;font-size:11px}.posts-studio__status{display:inline-flex;align-items:center;gap:6px;padding:5px 9px;border-radius:999px;font-size:11px;font-weight:800;white-space:nowrap}.posts-studio__status i{width:6px;height:6px;border-radius:50%}.posts-studio__status--live{color:#0a3d23;background:#e8f8ef}.posts-studio__status--live i{background:#0b7f42}.posts-studio__status--draft{color:#735700;background:#fef3d7}.posts-studio__status--draft i{background:#fbb116}.posts-studio__actions{display:flex;align-items:center;justify-content:end;gap:6px}.posts-studio__actions form{margin:0}.posts-studio__icon-button{display:grid;width:34px;height:34px;place-items:center;color:#0b7f42;background:#fff;border:1px solid #d1ddd5;border-radius:8px;cursor:pointer;transition:all .16s}.posts-studio__icon-button:hover{color:#fff;background:#0b7f42;border-color:#0b7f42}.posts-studio__icon-button--delete{color:#b33a32}.posts-studio__icon-button--delete:hover{background:#b33a32;border-color:#b33a32}.posts-studio__icon-button svg{width:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}.posts-studio__pagination{padding:22px 28px;border-top:1px solid #d1ddd5}.posts-studio__empty{max-width:380px;padding:52px 20px;margin:auto;text-align:center}.posts-studio__empty>span{display:grid;width:50px;height:50px;place-items:center;margin:0 auto 16px;color:#0b7f42;background:#e8f8ef;border-radius:14px}.posts-studio__empty svg{width:25px;fill:none;stroke:currentColor;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}.posts-studio__empty h3{margin:0;color:#062d1c;font-size:18px}.posts-studio__empty p{margin:8px 0 17px;color:#5a6c62;font-size:13px;line-height:1.55}.posts-studio__empty a{color:#0b7f42;font-size:13px;font-weight:800;text-decoration:none}@media(max-width:900px){.posts-studio__hero{margin:-32px -32px 28px;padding:34px 32px}.posts-studio__hero-actions{align-items:end;flex-direction:column;gap:12px}.posts-studio__hero-actions>span{text-align:right}}@media(max-width:680px){.posts-studio__hero{align-items:start;flex-direction:column;margin:-32px -32px 24px;padding:30px 22px 26px}.posts-studio__hero-actions{align-items:start;flex-direction:row}.posts-studio__hero-actions>span{text-align:left}.posts-studio__panel{border-radius:12px}.posts-studio__panel-head{align-items:start;flex-direction:column;padding:20px}.posts-studio__table{min-width:0}.posts-studio__table thead{display:none}.posts-studio__table,.posts-studio__table tbody,.posts-studio__table tr,.posts-studio__table td{display:block;width:100%}.posts-studio__table tr{padding:18px 20px;border-bottom:1px solid #d1ddd5}.posts-studio__table td{display:flex;align-items:center;justify-content:space-between;padding:8px 0;border:0;text-align:right}.posts-studio__table td:first-child{display:block;padding:0 0 14px}.posts-studio__table td::before{color:#8a9c92;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;content:attr(data-label)}.posts-studio__table td:first-child::before{display:none}.posts-studio__story{min-width:0}.posts-studio__story p{white-space:normal}.posts-studio__actions{justify-content:end}.posts-studio__actions::before{margin-right:auto}.posts-studio__pagination{padding:18px 20px}}
</style>
@endpush
