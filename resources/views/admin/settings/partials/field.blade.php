<div class="mb-24">
    <label class="block text-body-sm font-medium text-slate-text mb-8">
        {{ $fieldLabels[$setting->key] ?? ucwords(str_replace('_', ' ', $setting->key)) }}
    </label>
    <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
    <input type="hidden" name="settings[{{ $index }}][type]" value="{{ $setting->type }}">
    <input type="hidden" name="settings[{{ $index }}][group]" value="{{ $setting->group }}">

    @if($setting->type === 'image')
        @php
            $hasImage = !empty($setting->value);
            $imageUrl = $hasImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($setting->value) : null;
            $usesFallback = str_starts_with($setting->key, 'home_');
        @endphp
        <div class="mb-12 rounded-md border border-input-border bg-soft-green-background p-12">
            <div class="mb-8 flex items-center justify-between gap-12">
                <span class="text-body-sm font-semibold text-forest-deep">Ảnh hiện tại</span>
                @if($hasImage)
                    <a href="{{ $imageUrl }}" target="_blank" class="text-caption font-semibold text-brand-green hover:underline">Mở ảnh</a>
                @endif
            </div>
            @if($hasImage)
                <img id="settingPreview{{ $index }}" src="{{ $imageUrl }}" alt="{{ $setting->key }}" class="h-40 w-full rounded-md border border-input-border object-cover">
                <p class="mt-8 text-caption text-slate-text break-all">{{ $setting->value }}</p>
            @else
                <div id="settingPreviewEmpty{{ $index }}" class="flex h-40 w-full items-center justify-center rounded-md border border-dashed border-input-border bg-canvas-white text-caption text-hint-gray">
                    Chưa có ảnh riêng được tải lên
                </div>
                @if($usesFallback)
                    <p class="mt-8 text-caption text-slate-text">Block này hiện sẽ dùng ảnh fallback/mặc định trên giao diện nếu chưa tải ảnh riêng.</p>
                @endif
            @endif
        </div>
        <input type="file" name="settings[{{ $index }}][value_file]" accept="image/*" onchange="previewSettingImage(event, {{ $index }})"
            class="w-full text-body-sm text-muted-gray file:mr-8 file:py-8 file:px-16 file:rounded-md file:border-0 file:text-body-sm file:font-semibold file:bg-soft-green-background file:text-brand-green">
        <input type="hidden" name="settings[{{ $index }}][value]" value="{{ $setting->value ?? '' }}">
        <p class="mt-8 text-caption text-hint-gray">Tải ảnh JPG, PNG hoặc WEBP tối đa 20MB để thay thế ảnh hiện tại.</p>
    @elseif($setting->type === 'textarea' || in_array($setting->key, ['site_description', 'address', 'home_schedules_description', 'home_news_description', 'home_cta_description', 'home_routes_review_quote', 'home_why_subtitle']))
        <textarea name="settings[{{ $index }}][value]" rows="3"
            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ $setting->value ?? '' }}</textarea>
    @else
        <input type="text" name="settings[{{ $index }}][value]" value="{{ $setting->value ?? '' }}"
            class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
    @endif
</div>
