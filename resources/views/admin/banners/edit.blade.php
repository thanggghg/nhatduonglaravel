@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa Banner')
@section('page-title', 'Chỉnh sửa: ' . $banner->title)
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('title') border-red-500 @enderror">
                @error('title')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Phụ đề</label>
                <textarea name="subtitle" rows="2" class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('subtitle', $banner->subtitle) }}</textarea>
            </div>
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Ảnh banner trang chủ</label>
                <div class="mb-12 p-16 bg-soft-green-background rounded-md">
                    <p class="text-body-sm font-semibold text-brand-green mb-4">Gợi ý ảnh banner chuẩn</p>
                    <ul class="text-caption text-slate-text space-y-2 list-disc list-inside">
                        <li>Kích thước lý tưởng: <strong>2048 × 867px</strong> (tỷ lệ 2.36:1, ảnh ngang)</li>
                        <li>Định dạng: PNG hoặc JPG, dung lượng tối đa 4MB</li>
                        <li>Ảnh sẽ hiển thị làm nền hero ở trang chủ — ưu tiên ảnh xe khách rõ nét, sáng</li>
                        <li>Tránh đặt chữ quan trọng ở chính giữa (vùng này bị form tìm chuyến che)</li>
                    </ul>
                </div>
                <img id="imagePreview"
                    src="{{ $banner->image_url ?? asset('nha-xe-binh-minh-bus-2048x867.png') }}"
                    class="w-full h-40 object-cover rounded-md mb-12 border border-input-border" alt="Xem trước">
                <input type="file" name="image" accept="image/*" id="imageInput"
                    onchange="previewBanner(event)"
                    class="w-full text-body-sm text-muted-gray file:mr-8 file:py-8 file:px-16 file:rounded-md file:border-0 file:text-body-sm file:font-semibold file:bg-soft-green-background file:text-brand-green">
                <p class="mt-8 text-caption text-hint-gray">Để trống nếu không muốn thay đổi ảnh. Chọn ảnh mới để xem trước và thay thế.</p>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Text nút</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Link nút</label>
                    <input type="url" name="button_url" value="{{ old('button_url', $banner->button_url) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Vị trí</label>
                    <select name="position"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                        <option value="hero" {{ old('position', $banner->position) === 'hero' ? 'selected' : '' }}>Hero (nền trang chủ)</option>
                        <option value="home" {{ old('position', $banner->position) === 'home' ? 'selected' : '' }}>Home (khác)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Thứ tự</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Hiển thị banner</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Cập nhật</button>
            <a href="{{ route('admin.banners.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewBanner(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => { document.getElementById('imagePreview').src = e.target.result; };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
