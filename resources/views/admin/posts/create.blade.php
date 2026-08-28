@extends('admin.layouts.app')

@section('title', 'Thêm bài viết')
@section('page-title', 'Tạo bài viết')

@section('content')
<div class="post-create">
    <header class="post-create__masthead">
        <a href="{{ route('admin.posts.index') }}" class="post-create__back">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14 6-6 6 6 6"/></svg>
            Thư viện bài viết
        </a>
        <div class="post-create__heading">
            <div><p>NỘI DUNG MỚI</p><h1>Tạo một bài viết rõ ràng, hữu ích.</h1></div>
            <span class="post-create__state"><i></i>Chưa lưu</span>
        </div>
        <p class="post-create__intro">Soạn nội dung, chọn ảnh đại diện và thiết lập thời gian xuất bản trong cùng một màn hình.</p>
    </header>

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="post-create__form">
        @csrf
        <main class="post-create__canvas">
            <section class="post-create__card">
                <header class="post-create__card-head">
                    <div class="post-create__card-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5h14M5 10h9M5 15h14M5 20h10"/></svg></div>
                    <div><h2>Nội dung bài viết</h2><p>Thông tin xuất hiện trực tiếp với hành khách.</p></div>
                </header>

                <div class="post-create__field">
                    <label for="title">Tiêu đề <em>*</em></label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required maxlength="255" class="@error('title') is-error @enderror" placeholder="Nhập tiêu đề bài viết" autofocus>
                    <div class="post-create__field-meta"><span>Ngắn gọn, cụ thể và dễ hiểu.</span><output data-count-for="title">0/255</output></div>
                    @error('title')<p class="post-create__error">{{ $message }}</p>@enderror
                </div>

                <div class="post-create__field">
                    <label for="summary">Tóm tắt</label>
                    <textarea id="summary" name="summary" rows="3" maxlength="500" placeholder="Mô tả ngắn để hành khách biết bài viết nói về điều gì">{{ old('summary') }}</textarea>
                    <div class="post-create__field-meta"><span>Hiển thị tại danh sách tin tức.</span><output data-count-for="summary">0/500</output></div>
                </div>

                <div class="post-create__field">
                    <label for="content-editor">Nội dung <em>*</em></label>
                    <div class="post-create__rich-text @error('content') is-error @enderror">
                        <div class="post-create__toolbar" role="toolbar" aria-label="Công cụ định dạng nội dung">
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
                            <button type="button" data-editor-command="insertUnorderedList" aria-label="Danh sách chấm"><svg viewBox="0 0 24 24"><path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/></svg></button>
                            <button type="button" data-editor-command="insertOrderedList" aria-label="Danh sách số"><svg viewBox="0 0 24 24"><path d="M10 6h10M10 12h10M10 18h10M4 5h1v3M4 12h1v3M4 19h2l-2-3"/></svg></button>
                            <button type="button" data-editor-command="createLink" aria-label="Chèn liên kết"><svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.2 1.2M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.2-1.2"/></svg></button>
                            <button type="button" data-editor-command="removeFormat" aria-label="Xóa định dạng"><svg viewBox="0 0 24 24"><path d="m4 6 16 12M14 5h6M5 19h6"/></svg></button>
                        </div>
                        <div id="content-editor" class="post-create__editable" contenteditable="true" role="textbox" aria-multiline="true" spellcheck="true">{!! old('content') !!}</div>
                    </div>
                    <textarea id="content" name="content" class="sr-only">{{ old('content') }}</textarea>
                    <p class="post-create__hint">Dùng tiêu đề, danh sách và liên kết để nội dung dễ đọc hơn.</p>
                    @error('content')<p class="post-create__error">{{ $message }}</p>@enderror
                </div>
            </section>

            <details class="post-create__seo">
                <summary><span><svg viewBox="0 0 24 24"><path d="M10.5 18.5a8 8 0 1 1 5.7-2.4L21 21"/></svg>Thiết lập SEO</span><small>Không bắt buộc</small></summary>
                <div class="post-create__seo-content">
                    <div class="post-create__field"><label for="meta_title">Meta title</label><input id="meta_title" type="text" name="meta_title" value="{{ old('meta_title') }}" maxlength="255" placeholder="Để trống để dùng tiêu đề bài viết"></div>
                    <div class="post-create__field"><label for="meta_description">Meta description</label><textarea id="meta_description" name="meta_description" rows="3" maxlength="500" placeholder="Mô tả ngắn hiển thị trên công cụ tìm kiếm">{{ old('meta_description') }}</textarea></div>
                </div>
            </details>
        </main>

        <aside class="post-create__sidebar">
            <section class="post-create__side-card post-create__publish">
                <header><p>XUẤT BẢN</p><h2>Trạng thái bài viết</h2></header>
                <label class="post-create__switch-row" for="status">
                    <span><b>Hiển thị trên website</b><small>Tắt để lưu bài viết ở dạng bản nháp.</small></span>
                    <input id="status" type="checkbox" name="status" value="1" @checked(old('status', true))>
                    <i aria-hidden="true"></i>
                </label>
                <div class="post-create__field"><label for="published_at">Ngày và giờ xuất bản</label><input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"></div>
                <button type="submit" class="post-create__save"><svg viewBox="0 0 24 24"><path d="M5 12.5 9.5 17 19 7.5"/></svg>Đăng bài viết</button>
                <a href="{{ route('admin.posts.index') }}" class="post-create__cancel">Hủy và quay lại</a>
            </section>

            <section class="post-create__side-card">
                <header><p>PHÂN LOẠI</p><h2>Thông tin hiển thị</h2></header>
                <div class="post-create__field">
                    <label for="locale">Ngôn ngữ <em>*</em></label>
                    <select id="locale" name="locale" required class="@error('locale') is-error @enderror">
                        <option value="vi" @selected(old('locale', 'vi') === 'vi')>Tiếng Việt</option>
                        <option value="en" @selected(old('locale') === 'en')>English</option>
                        <option value="ru" @selected(old('locale') === 'ru')>Русский</option>
                    </select>
                    @error('locale')<p class="post-create__error">{{ $message }}</p>@enderror
                </div>
                <div class="post-create__field">
                    <label for="post_category_id">Danh mục <em>*</em></label>
                    <select id="post_category_id" name="post_category_id" required class="@error('post_category_id') is-error @enderror">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('post_category_id') == $category->id)>{{ $category->name }}</option>@endforeach
                    </select>
                    @error('post_category_id')<p class="post-create__error">{{ $message }}</p>@enderror
                </div>
            </section>

            <section class="post-create__side-card">
                <header><p>HÌNH ẢNH</p><h2>Ảnh đại diện</h2></header>
                <label class="post-create__image-picker" for="thumbnail">
                    <span id="thumbnail-placeholder"><svg viewBox="0 0 24 24"><path d="m4 17 5-5 4 4 3-3 4 4M8 8h.01M5 21h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"/></svg><b>Chọn ảnh đại diện</b><small>Nhấp để tải ảnh lên</small></span>
                    <span class="post-create__image-overlay">Thay đổi ảnh</span>
                </label>
                <input id="thumbnail" type="file" name="thumbnail" accept="image/png,image/jpeg,image/webp" class="sr-only">
                <p class="post-create__hint">Tỷ lệ khuyến nghị 16:9. PNG, JPG hoặc WEBP, tối đa 20 MB.</p>
                @error('thumbnail')<p class="post-create__error">{{ $message }}</p>@enderror
            </section>
        </aside>
    </form>
</div>
@endsection

@push('styles')
<style>
    .post-create{max-width:1200px;margin:0 auto;color:#2c3e36;font-family:Inter,ui-sans-serif,system-ui,sans-serif}.post-create__masthead{padding:8px 0 29px}.post-create__back{display:inline-flex;align-items:center;gap:6px;color:#0b7f42;font-size:13px;font-weight:800;text-decoration:none}.post-create__back svg{width:16px;fill:none;stroke:currentColor;stroke-width:2}.post-create__heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-top:22px}.post-create__heading p,.post-create__side-card header p{margin:0 0 8px;color:#0b7f42;font-size:10px;font-weight:800;letter-spacing:.12em}.post-create__heading h1{margin:0;color:#062d1c;font-size:clamp(28px,3.5vw,39px);line-height:1.12;letter-spacing:-.045em}.post-create__intro{max-width:720px;margin:12px 0 0;color:#718278;font-size:13px;line-height:1.6}.post-create__state{display:inline-flex;align-items:center;gap:7px;flex:none;padding:7px 10px;color:#735700;background:#fef3d7;border-radius:999px;font-size:11px;font-weight:800}.post-create__state i{width:6px;height:6px;background:#fbb116;border-radius:50%}.post-create__form{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:24px;align-items:start}.post-create__canvas{display:grid;gap:20px}.post-create__card,.post-create__side-card,.post-create__seo{background:#fff;border:1px solid #d1ddd5;border-radius:16px;box-shadow:0 4px 16px rgba(11,127,66,.07)}.post-create__card{padding:30px}.post-create__card-head{display:flex;align-items:center;gap:12px;padding-bottom:22px;margin-bottom:24px;border-bottom:1px solid #e5ede7}.post-create__card-icon{display:grid;width:38px;height:38px;place-items:center;color:#0b7f42;background:#e8f8ef;border-radius:10px}.post-create__card-icon svg{width:19px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-width:1.8}.post-create h2{margin:0;color:#062d1c;font-size:17px;font-weight:800}.post-create__card-head p{margin:4px 0 0;color:#819188;font-size:12px}.post-create__field{display:grid;gap:7px;margin-bottom:21px}.post-create__field:last-child{margin-bottom:0}.post-create__field label{color:#365145;font-size:12px;font-weight:800}.post-create__field label em{color:#c53c32;font-style:normal}.post-create__field input,.post-create__field textarea,.post-create__field select{width:100%;padding:11px 12px;color:#253b31;background:#fff;border:1px solid #d1ddd5;border-radius:8px;font:500 13px/1.5 Inter,ui-sans-serif,system-ui,sans-serif;outline:0;transition:border .16s,box-shadow .16s}.post-create__field input:focus,.post-create__field textarea:focus,.post-create__field select:focus{border-color:#0b7f42;box-shadow:0 0 0 3px rgba(11,127,66,.13)}.post-create .is-error{border-color:#c53c32!important}.post-create__field-meta{display:flex;justify-content:space-between;gap:12px;color:#8a9c92;font-size:10px}.post-create__field-meta output{font-variant-numeric:tabular-nums}.post-create__hint{margin:0;color:#8a9c92;font-size:10px;line-height:1.5}.post-create__error{margin:0;color:#b42f27;font-size:11px;font-weight:700}.post-create__rich-text{overflow:hidden;border:1px solid #d1ddd5;border-radius:9px}.post-create__rich-text:focus-within{border-color:#0b7f42;box-shadow:0 0 0 3px rgba(11,127,66,.13)}.post-create__toolbar{display:flex;align-items:center;flex-wrap:wrap;gap:3px;padding:7px 8px;background:#f8fdf9;border-bottom:1px solid #d1ddd5}.post-create__toolbar select{width:auto;min-width:112px;padding:5px 25px 5px 7px;border:0;background:transparent;font-size:11px;font-weight:700}.post-create__toolbar>span{width:1px;height:21px;margin:0 4px;background:#d1ddd5}.post-create__toolbar button{display:grid;width:29px;height:29px;place-items:center;color:#365145;background:transparent;border:0;border-radius:5px;cursor:pointer}.post-create__toolbar button:hover,.post-create__toolbar button:focus-visible{color:#0b7f42;background:#e8f8ef;outline:0}.post-create__toolbar svg{width:15px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}.post-create__editable{min-height:390px;padding:16px;color:#2c3e36;outline:0;font:500 14px/1.72 Inter,ui-sans-serif,system-ui,sans-serif}.post-create__editable:empty:before{color:#9aa9a0;content:'Bắt đầu viết nội dung bài viết...';pointer-events:none}.post-create__editable h2,.post-create__editable h3{margin:1.2em 0 .5em;color:#062d1c;line-height:1.25}.post-create__editable h2{font-size:23px}.post-create__editable h3{font-size:18px}.post-create__editable blockquote{padding:8px 14px;margin:1em 0;background:#f8fdf9;border-left:3px solid #fbb116}.post-create__editable ul,.post-create__editable ol{padding-left:24px}.post-create__seo{overflow:hidden}.post-create__seo summary{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:18px 22px;cursor:pointer;list-style:none}.post-create__seo summary::-webkit-details-marker{display:none}.post-create__seo summary span{display:flex;align-items:center;gap:9px;color:#062d1c;font-size:13px;font-weight:800}.post-create__seo summary svg{width:17px;fill:none;stroke:#0b7f42;stroke-width:2}.post-create__seo summary small{color:#8a9c92;font-size:10px}.post-create__seo-content{padding:22px;border-top:1px solid #e5ede7}.post-create__sidebar{position:sticky;top:104px;display:grid;gap:18px}.post-create__side-card{padding:22px}.post-create__side-card header{padding-bottom:17px;margin-bottom:18px;border-bottom:1px solid #e5ede7}.post-create__switch-row{position:relative;display:grid;grid-template-columns:1fr 38px;gap:13px;align-items:center;padding:12px;margin-bottom:19px;background:#f8fdf9;border-radius:10px;cursor:pointer}.post-create__switch-row span{display:grid;gap:3px}.post-create__switch-row b{color:#294437;font-size:11px}.post-create__switch-row small{color:#819188;font-size:9px;line-height:1.4}.post-create__switch-row input{position:absolute;opacity:0}.post-create__switch-row>i{position:relative;width:38px;height:22px;background:#cbd7cf;border-radius:999px;transition:.2s}.post-create__switch-row>i:after{position:absolute;top:3px;left:3px;width:16px;height:16px;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.2);content:'';transition:.2s}.post-create__switch-row input:checked+i{background:#0b7f42}.post-create__switch-row input:checked+i:after{transform:translateX(16px)}.post-create__save{display:flex;width:100%;min-height:45px;align-items:center;justify-content:center;gap:8px;color:#fff;background:#0b7f42;border:0;border-radius:9px;font-size:12px;font-weight:800;cursor:pointer}.post-create__save:hover{background:#096b39}.post-create__save svg{width:17px;fill:none;stroke:currentColor;stroke-width:2}.post-create__cancel{display:block;margin-top:12px;color:#718278;font-size:11px;font-weight:700;text-align:center;text-decoration:none}.post-create__image-picker{position:relative;display:grid;min-height:174px;overflow:hidden;place-items:center;background:#f8fdf9;border:1px dashed #a9c6b2;border-radius:11px;cursor:pointer}.post-create__image-picker>span:first-child{display:grid;justify-items:center;gap:7px;color:#0b7f42;text-align:center}.post-create__image-picker svg{width:30px;fill:none;stroke:currentColor;stroke-width:1.5}.post-create__image-picker b{font-size:11px}.post-create__image-picker small{color:#8a9c92;font-size:9px}.post-create__image-picker img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.post-create__image-overlay{position:absolute;right:0;bottom:0;left:0;padding:8px;color:#fff;background:rgba(6,45,28,.78);font-size:10px;font-weight:800;text-align:center;opacity:0;transition:.18s}.post-create__image-picker:has(img):hover .post-create__image-overlay{opacity:1}.post-create__side-card>.post-create__hint{margin-top:10px}@media(max-width:1050px){.post-create__form{grid-template-columns:minmax(0,1fr) 285px}}@media(max-width:850px){.post-create__form{grid-template-columns:1fr}.post-create__sidebar{position:static;grid-template-columns:1fr 1fr}.post-create__publish{grid-column:1/-1;grid-row:3}.post-create__heading{align-items:flex-start}.post-create__card{padding:22px}}@media(max-width:620px){.post-create__heading{display:grid}.post-create__state{justify-self:start}.post-create__sidebar{grid-template-columns:1fr}.post-create__publish{grid-column:auto;grid-row:auto}.post-create__card{padding:17px}.post-create__toolbar>span{display:none}.post-create__editable{min-height:320px}.post-create__field-meta span{display:none}}
</style>
@endpush

@push('scripts')
<script>
    (() => {
        const form = document.querySelector('.post-create__form');
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
        block.addEventListener('change', () => { document.execCommand('formatBlock', false, block.value); editor.focus(); sync(); });

        ['title', 'summary'].forEach((id) => {
            const input = document.getElementById(id);
            const output = document.querySelector(`[data-count-for="${id}"]`);
            const update = () => { output.textContent = `${input.value.length}/${input.maxLength}`; };
            input.addEventListener('input', update);
            update();
        });

        const imageInput = document.getElementById('thumbnail');
        const picker = document.querySelector('.post-create__image-picker');
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if (!file) return;
            const image = document.createElement('img');
            image.alt = 'Ảnh đại diện xem trước';
            image.src = URL.createObjectURL(file);
            picker.querySelector('img, #thumbnail-placeholder')?.remove();
            picker.prepend(image);
        });

        form.addEventListener('submit', (event) => {
            sync();
            if (!editor.textContent.trim()) {
                event.preventDefault();
                editor.focus();
                editor.closest('.post-create__rich-text').classList.add('is-error');
            }
        });
    })();
</script>
@endpush
