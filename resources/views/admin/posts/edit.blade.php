@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết')
@section('page-title', 'Chỉnh sửa: ' . Str::limit($post->title, 50))

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-3 gap-24">
            <!-- Main content -->
            <div class="col-span-2 space-y-24">
                <div class="bg-canvas-white rounded-lg shadow-md p-32">
                    <div class="mb-24">
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Tiêu đề <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('title') border-red-500 @enderror">
                        @error('title')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-24">
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Tóm tắt</label>
                        <textarea name="summary" rows="3"
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('summary', $post->summary) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Nội dung <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="16" required
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                        @error('content')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-canvas-white rounded-lg shadow-md p-32">
                    <h3 class="text-heading font-semibold text-forest-deep mb-24">SEO</h3>
                    <div class="mb-24">
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                    </div>
                    <div>
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Meta Description</label>
                        <textarea name="meta_description" rows="3"
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-24">
                <!-- Publish -->
                <div class="bg-canvas-white rounded-lg shadow-md p-24">
                    <h3 class="text-heading font-semibold text-forest-deep mb-16">Xuất bản</h3>
                    <div class="mb-16">
                        <label class="block text-body-sm font-medium text-slate-text mb-8">Ngày đăng</label>
                        <input type="datetime-local" name="published_at"
                            value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-16 py-12 border border-input-border rounded-md text-body-sm focus:outline-none focus:ring-2 focus:ring-brand-green">
                    </div>
                    <div class="mb-16">
                        <label class="flex items-center">
                            <input type="checkbox" name="status" value="1" {{ old('status', $post->status) ? 'checked' : '' }}
                                class="w-16 h-16 text-brand-green border-input-border rounded">
                            <span class="ml-8 text-body-sm text-slate-text">Hiển thị</span>
                        </label>
                    </div>
                    <div class="flex gap-8">
                        <button type="submit" class="flex-1 bg-brand-green text-canvas-white font-semibold py-12 px-16 rounded-md hover:bg-green-hover text-body-sm">
                            Cập nhật
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="flex-1 text-center bg-canvas-white text-muted-gray border border-input-border font-semibold py-12 px-16 rounded-md hover:bg-ghost-fog text-body-sm">
                            Hủy
                        </a>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-canvas-white rounded-lg shadow-md p-24">
                    <h3 class="text-heading font-semibold text-forest-deep mb-16">Danh mục <span class="text-red-500">*</span></h3>
                    <select name="post_category_id" required
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('post_category_id', $post->post_category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thumbnail -->
                <div class="bg-canvas-white rounded-lg shadow-md p-24">
                    <h3 class="text-heading font-semibold text-forest-deep mb-16">Ảnh đại diện</h3>
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" class="w-full h-32 object-cover rounded-md mb-12" alt="">
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full text-body-sm text-muted-gray file:mr-8 file:py-8 file:px-16 file:rounded-md file:border-0 file:text-body-sm file:font-semibold file:bg-soft-green-background file:text-brand-green hover:file:bg-soft-green">
                    <p class="mt-8 text-caption text-hint-gray">Để trống nếu không muốn thay đổi ảnh</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
