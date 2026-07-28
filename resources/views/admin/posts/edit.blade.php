@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết')
@section('page-title', 'Biên tập bài viết')

@section('content')
<div class="post-editor">
    <header class="post-editor__masthead">
        <a href="{{ route('admin.posts.index') }}" class="post-editor__back">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14 6-6 6 6 6"/></svg>
            Thư viện bài viết
        </a>
        <div class="post-editor__heading">
            <div>
                <p>BIÊN TẬP NỘI DUNG</p>
                <h1>{{ Str::limit($post->title, 88) }}</h1>
            </div>
            <span class="post-editor__state {{ $post->status ? 'post-editor__state--live' : '' }}"><i></i>{{ $post->status ? 'Đang hiển thị' : 'Bản nháp' }}</span>
        </div>
        <div class="post-editor__meta">
            <span>Cập nhật lần cuối {{ $post->updated_at->format('d/m/Y, H:i') }}</span>
            <span class="post-editor__dot"></span>
            <span>{{ $post->category?->name ?? 'Chưa phân loại' }}</span>
        </div>
    </header>

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="post-editor__form">
        @csrf
        @method('PUT')

        <main class="post-editor__canvas">
            <section class="post-editor__card">
                <header class="post-editor__card-head">
                    <div class="post-editor__card-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5h14M5 10h9M5 15h14M5 20h10"/></svg></div>
                    <div><h2>Nội dung bài viết</h2><p>Thông tin xuất hiện trực tiếp với hành khách.</p></div>
                </header>

                <div class="post-editor__field">
                    <label for="title">Tiêu đề <em>*</em></label>
                    <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required class="@error('title') post-editor__input--error @enderror" autofocus>
                    @error('title')<p class="post-editor__error">{{ $message }}</p>@enderror
                </div>

                <div class="post-editor__field">
                    <label for="summary">Tóm tắt</label>
                    <textarea id="summary" name="summary" rows="3" maxlength="500">{{ old('summary', $post->summary) }}</textarea>
                    <p class="post-editor__hint">Đoạn giới thiệu ngắn hiển thị ở danh sách tin tức.</p>
                </div>

                <div class="post-editor__field post-editor__field--content">
                    <label for="content">Nội dung <em>*</em></label>
                    <div class="post-editor__rich-text @error('content') post-editor__input--error @enderror">
                        <div class="post-editor__toolbar" role="toolbar" aria-label="Công cụ định dạng nội dung">
                            <select id="editor-block" aria-label="Kiểu đoạn văn">
                                <option value="p">Đoạn văn</option>
                                <option value="h2">Tiêu đề lớn</option>
                                <option value="h3">Tiêu đề vừa</option>
                                <option value="blockquote">Trích dẫn</option>
                            </select>
                            <span></span>
                            <button type="button" data-editor-command="bold" aria-label="In đậm"><b>B</b></button>
                            <button type="button" data-editor-command="italic" aria-label="In nghiêng"><i>I</i></button>
                            <button type="button" data-editor-command="underline" aria-label="Gạch chân"><u>U</u></button>
                            <span></span>
                            <button type="button" data-editor-command="insertUnorderedList" aria-label="Danh sách chấm"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/></svg></button>
                            <button type="button" data-editor-command="insertOrderedList" aria-label="Danh sách số"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 6h10M10 12h10M10 18h10M4 5h1v3M4 12h1v3M4 19h2l-2-3"/></svg></button>
                            <button type="button" data-editor-command="createLink" aria-label="Chèn liên kết"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.2 1.2M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.2-1.2"/></svg></button>
                            <button type="button" data-editor-command="removeFormat" aria-label="Xóa định dạng"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 6 16 12M14 5h6M5 19h6"/></svg></button>
                        </div>
                        <div id="content-editor" class="post-editor__editable" contenteditable="true" role="textbox" aria-multiline="true" aria-label="Nội dung bài viết" spellcheck="true">{!! old('content', $post->content) !!}</div>
                    </div>
                    <textarea id="content" name="content" class="sr-only">{{ old('content', $post->content) }}</textarea>
                    <p class="post-editor__hint">Dùng thanh công cụ để định dạng tiêu đề, đoạn văn, danh sách và liên kết.</p>
                    @error('content')<p class="post-editor__error">{{ $message }}</p>@enderror
                </div>
            </section>

            <details class="post-editor__seo" open>
                <summary><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M12 5v14"/></svg>Thiết lập SEO</span><small>Tiêu đề và mô tả tìm kiếm</small></summary>
                <div class="post-editor__seo-content">
                    <div class="post-editor__field">
                        <label for="meta_title">Meta title</label>
                        <input id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="255" placeholder="Để trống để dùng tiêu đề bài viết">
                    </div>
                    <div class="post-editor__field">
                        <label for="meta_description">Meta description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" maxlength="500" placeholder="Mô tả ngắn hiển thị trên công cụ tìm kiếm">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </details>
        </main>

        <aside class="post-editor__sidebar">
            <section class="post-editor__side-card post-editor__publish">
                <header><p>XUẤT BẢN</p><h2>Trạng thái bài viết</h2></header>
                <label class="post-editor__switch-row" for="status">
                    <span><b>Hiển thị trên website</b><small>Bài viết có thể được hành khách xem.</small></span>
                    <input id="status" type="checkbox" name="status" value="1" @checked(old('status', $post->status))>
                    <i aria-hidden="true"></i>
                </label>
                <div class="post-editor__field">
                    <label for="published_at">Ngày và giờ xuất bản</label>
                    <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <button type="submit" class="post-editor__save"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12.5 9.5 17 19 7.5"/></svg>Lưu thay đổi</button>
                <a href="{{ route('admin.posts.index') }}" class="post-editor__cancel">Hủy và quay lại</a>
            </section>

            <section class="post-editor__side-card">
                <header><p>PHÂN LOẠI</p><h2>Danh mục</h2></header>
                <div class="post-editor__field">
                    <label for="locale">Ngôn ngữ hiển thị <em>*</em></label>
                    <select id="locale" name="locale" required class="@error('locale') post-editor__input--error @enderror">
                        <option value="vi" @selected(old('locale', $post->locale) === 'vi')>Tiếng Việt</option>
                        <option value="en" @selected(old('locale', $post->locale) === 'en')>English</option>
                        <option value="ru" @selected(old('locale', $post->locale) === 'ru')>Русский</option>
                    </select>
                    @error('locale')<p class="post-editor__error">{{ $message }}</p>@enderror
                </div>
                <div class="post-editor__field">
                    <label for="post_category_id">Chọn danh mục <em>*</em></label>
                    <select id="post_category_id" name="post_category_id" required class="@error('post_category_id') post-editor__input--error @enderror">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('post_category_id')<p class="post-editor__error">{{ $message }}</p>@enderror
                </div>
            </section>

            <section class="post-editor__side-card">
                <header><p>HÌNH ẢNH</p><h2>Ảnh đại diện</h2></header>
                <label class="post-editor__image-picker" for="thumbnail">
                    @if($post->thumbnail)
                        <img id="thumbnail-preview" src="{{ Storage::url($post->thumbnail) }}" alt="Ảnh đại diện hiện tại">
                    @else
                        <span id="thumbnail-placeholder"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 17 5-5 4 4 3-3 4 4M8 8h.01M5 21h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"/></svg><b>Chọn ảnh mới</b></span>
                    @endif
                    <span class="post-editor__image-overlay">Thay đổi ảnh</span>
                </label>
                <input id="thumbnail" type="file" name="thumbnail" accept="image/png,image/jpeg,image/webp" class="sr-only">
                <p class="post-editor__hint">PNG, JPG hoặc WEBP. Tối đa 20 MB.</p>
            </section>
        </aside>
    </form>
</div>
@endsection

@push('styles')
<style>
    .post-editor{max-width:1200px;margin:0 auto;color:#2c3e36;font-family:Inter,ui-sans-serif,system-ui,sans-serif}.post-editor__masthead{padding:8px 0 29px}.post-editor__back{display:inline-flex;align-items:center;gap:6px;color:#0b7f42;font-size:13px;font-weight:800;text-decoration:none}.post-editor__back:hover{color:#096b39}.post-editor__back svg{width:16px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:2}.post-editor__heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-top:22px}.post-editor__heading p,.post-editor__side-card header p{margin:0 0 8px;color:#0b7f42;font-size:10px;font-weight:800;letter-spacing:.12em}.post-editor__heading h1{max-width:780px;margin:0;color:#062d1c;font-size:clamp(27px,3.5vw,38px);line-height:1.15;letter-spacing:-.04em}.post-editor__state{display:inline-flex;align-items:center;gap:7px;flex-shrink:0;padding:7px 10px;color:#735700;background:#fef3d7;border-radius:999px;font-size:11px;font-weight:800}.post-editor__state i{width:6px;height:6px;background:#fbb116;border-radius:50%}.post-editor__state--live{color:#0a3d23;background:#e8f8ef}.post-editor__state--live i{background:#0b7f42}.post-editor__meta{display:flex;align-items:center;gap:9px;margin-top:13px;color:#8a9c92;font-size:12px}.post-editor__dot{width:3px;height:3px;background:#b6c7bb;border-radius:50%}.post-editor__form{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:24px;align-items:start}.post-editor__canvas{display:grid;gap:20px}.post-editor__card,.post-editor__side-card,.post-editor__seo{background:#fff;border:1px solid #d1ddd5;border-radius:16px;box-shadow:0 4px 16px rgba(11,127,66,.08)}.post-editor__card{padding:30px}.post-editor__card-head{display:flex;align-items:center;gap:12px;padding-bottom:23px;margin-bottom:24px;border-bottom:1px solid #e5ede7}.post-editor__card-icon{display:grid;width:37px;height:37px;place-items:center;color:#0b7f42;background:#e8f8ef;border-radius:10px}.post-editor__card-icon svg,.post-editor__seo summary svg{width:19px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}.post-editor__card-head h2,.post-editor__side-card h2{margin:0;color:#062d1c;font-size:17px;letter-spacing:-.02em}.post-editor__card-head p{margin:3px 0 0;color:#8a9c92;font-size:12px}.post-editor__field{display:grid;gap:7px;margin-bottom:21px}.post-editor__field:last-child{margin-bottom:0}.post-editor__field>label{color:#2c3e36;font-size:12px;font-weight:800}.post-editor__field em{color:#c53c32;font-style:normal}.post-editor input:not([type=checkbox]),.post-editor textarea,.post-editor select{width:100%;padding:11px 12px;color:#2c3e36;background:#fff;border:1px solid #d1ddd5;border-radius:8px;font:500 14px/1.5 Inter,ui-sans-serif,system-ui,sans-serif;outline:none;transition:border .16s,box-shadow .16s}.post-editor textarea{resize:vertical}.post-editor input:focus,.post-editor textarea:focus,.post-editor select:focus{border-color:#0b7f42;box-shadow:0 0 0 3px rgba(11,127,66,.13)}.post-editor__field--content textarea{min-height:360px;line-height:1.7}.post-editor__hint{margin:0;color:#8a9c92;font-size:11px;line-height:1.45}.post-editor__error{margin:0;color:#b33a32;font-size:11px;font-weight:700}.post-editor .post-editor__input--error{border-color:#c53c32}.post-editor__seo{overflow:hidden}.post-editor__seo summary{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 23px;color:#062d1c;cursor:pointer;list-style:none}.post-editor__seo summary::-webkit-details-marker{display:none}.post-editor__seo summary span{display:inline-flex;align-items:center;gap:9px;font-size:14px;font-weight:800}.post-editor__seo summary small{color:#8a9c92;font-size:11px}.post-editor__seo[open] summary{border-bottom:1px solid #e5ede7}.post-editor__seo-content{display:grid;gap:1px;padding:22px 23px}.post-editor__sidebar{display:grid;gap:16px;position:sticky;top:101px}.post-editor__side-card{padding:21px}.post-editor__side-card header{margin-bottom:18px}.post-editor__side-card header p{margin-bottom:5px}.post-editor__publish{border-color:#b9d8c2}.post-editor__switch-row{display:grid;grid-template-columns:1fr 38px;gap:12px;align-items:center;padding:13px;margin-bottom:18px;background:#f8fdf9;border-radius:10px;cursor:pointer}.post-editor__switch-row span{display:grid;gap:3px}.post-editor__switch-row b{color:#062d1c;font-size:12px}.post-editor__switch-row small{color:#8a9c92;font-size:11px;line-height:1.35}.post-editor__switch-row input{position:absolute;opacity:0}.post-editor__switch-row i{position:relative;width:38px;height:22px;background:#cbd9cf;border-radius:999px;transition:background .18s}.post-editor__switch-row i::after{position:absolute;top:3px;left:3px;width:16px;height:16px;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.2);content:"";transition:transform .18s}.post-editor__switch-row input:checked+i{background:#0b7f42}.post-editor__switch-row input:checked+i::after{transform:translateX(16px)}.post-editor__save{display:flex;width:100%;align-items:center;justify-content:center;gap:8px;padding:12px;color:#fff;background:#0b7f42;border:0;border-radius:8px;font:800 13px Inter,ui-sans-serif,system-ui,sans-serif;cursor:pointer;transition:background .16s,transform .16s}.post-editor__save:hover{background:#096b39;transform:translateY(-1px)}.post-editor__save svg{width:17px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:2.2}.post-editor__cancel{display:block;margin-top:12px;color:#5a6c62;font-size:12px;font-weight:700;text-align:center;text-decoration:none}.post-editor__cancel:hover{color:#0b7f42}.post-editor__image-picker{position:relative;display:grid;min-height:164px;overflow:hidden;place-items:center;color:#0b7f42;background:#f8fdf9;border:1px dashed #abcab4;border-radius:10px;cursor:pointer}.post-editor__image-picker img{width:100%;height:164px;object-fit:cover}.post-editor__image-picker>span:not(.post-editor__image-overlay){display:grid;justify-items:center;gap:8px;color:#5a6c62;font-size:12px}.post-editor__image-picker>span svg{width:26px;color:#0b7f42;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.6}.post-editor__image-overlay{position:absolute;inset:auto 9px 9px;padding:7px;color:#fff;background:rgba(6,45,28,.82);border-radius:6px;font-size:11px;font-weight:800;text-align:center;opacity:0;transition:opacity .16s}.post-editor__image-picker:hover .post-editor__image-overlay,.post-editor__image-picker:focus-within .post-editor__image-overlay{opacity:1}@media(max-width:900px){.post-editor__form{grid-template-columns:1fr}.post-editor__sidebar{position:static;grid-template-columns:repeat(2,minmax(0,1fr));align-items:start}.post-editor__publish{grid-row:span 2}}@media(max-width:660px){.post-editor__masthead{padding-bottom:23px}.post-editor__heading{align-items:start;flex-direction:column;margin-top:18px}.post-editor__meta{flex-wrap:wrap}.post-editor__form{gap:16px}.post-editor__card{padding:20px}.post-editor__sidebar{grid-template-columns:1fr}.post-editor__publish{grid-row:auto}.post-editor__seo summary{align-items:start;flex-direction:column}.post-editor__seo-content{padding:19px}.post-editor__field--content textarea{min-height:280px}}
    .post-editor__rich-text{overflow:hidden;background:#fff;border:1px solid #d1ddd5;border-radius:8px;transition:border .16s,box-shadow .16s}.post-editor__rich-text:focus-within{border-color:#0b7f42;box-shadow:0 0 0 3px rgba(11,127,66,.13)}.post-editor__rich-text.post-editor__input--error{border-color:#c53c32}.post-editor__toolbar{display:flex;align-items:center;flex-wrap:wrap;gap:3px;padding:7px 8px;background:#f8fdf9;border-bottom:1px solid #d1ddd5}.post-editor__toolbar select{width:auto;min-width:112px;padding:5px 25px 5px 7px;border:0;border-radius:5px;background:transparent;font-size:11px;font-weight:700;box-shadow:none}.post-editor__toolbar select:focus{box-shadow:0 0 0 2px rgba(11,127,66,.18)}.post-editor__toolbar>span{width:1px;height:21px;margin:0 4px;background:#d1ddd5}.post-editor__toolbar button{display:grid;width:28px;height:28px;place-items:center;color:#365145;background:transparent;border:0;border-radius:5px;font:700 13px Inter,ui-sans-serif,system-ui,sans-serif;cursor:pointer}.post-editor__toolbar button:hover,.post-editor__toolbar button:focus-visible{color:#0b7f42;background:#e8f8ef;outline:0}.post-editor__toolbar svg{width:15px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}.post-editor__editable{min-height:360px;padding:14px 13px;color:#2c3e36;outline:none;font:500 14px/1.7 Inter,ui-sans-serif,system-ui,sans-serif}.post-editor__editable:empty:before{color:#8a9c92;content:'Bắt đầu viết nội dung bài viết...';pointer-events:none}.post-editor__editable h2,.post-editor__editable h3{margin:1.2em 0 .5em;color:#062d1c;line-height:1.25}.post-editor__editable h2{font-size:23px}.post-editor__editable h3{font-size:18px}.post-editor__editable p{margin:.6em 0}.post-editor__editable ul,.post-editor__editable ol{padding-left:24px;margin:.7em 0}.post-editor__editable blockquote{padding:8px 14px;margin:1em 0;color:#365145;background:#f8fdf9;border-left:3px solid #fbb116}.post-editor__editable a{color:#0b7f42;text-decoration:underline}
</style>
@endpush

@push('scripts')
<script>
    (() => {
        const input = document.getElementById('thumbnail');
        const picker = document.querySelector('.post-editor__image-picker');
        if (!input || !picker) return;

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            const image = document.createElement('img');
            image.id = 'thumbnail-preview';
            image.alt = 'Ảnh đại diện xem trước';
            image.src = URL.createObjectURL(file);
            picker.querySelector('#thumbnail-preview, #thumbnail-placeholder')?.remove();
            picker.prepend(image);
        });
    })();
</script>
@endpush

@push('scripts')
<script>
    (() => {
        const form = document.querySelector('.post-editor__form');
        const editor = document.getElementById('content-editor');
        const source = document.getElementById('content');
        const block = document.getElementById('editor-block');
        if (!form || !editor || !source || !block) return;

        const sync = () => { source.value = editor.innerHTML.trim(); };
        editor.addEventListener('input', sync);

        document.querySelectorAll('[data-editor-command]').forEach((button) => {
            button.addEventListener('mousedown', (event) => event.preventDefault());
            button.addEventListener('click', () => {
                const command = button.dataset.editorCommand;
                if (command === 'createLink') {
                    const url = window.prompt('Dán liên kết (https://...)');
                    if (!url) return;
                    document.execCommand(command, false, url);
                } else {
                    document.execCommand(command, false, null);
                }
                editor.focus();
                sync();
            });
        });

        block.addEventListener('change', () => {
            document.execCommand('formatBlock', false, block.value);
            editor.focus();
            sync();
        });

        form.addEventListener('submit', (event) => {
            sync();
            if (!editor.textContent.trim()) {
                event.preventDefault();
                editor.focus();
                editor.closest('.post-editor__rich-text').classList.add('post-editor__input--error');
            }
        });
    })();
</script>
@endpush
