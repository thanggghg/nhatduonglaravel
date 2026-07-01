@extends('admin.layouts.app')
@section('title', 'Cài đặt hệ thống')
@section('page-title', 'Cài đặt hệ thống')
@section('content')
<div class="max-w-2xl">
    @if (session('success'))
        <div class="mb-24 rounded-md border border-brand-green bg-soft-green-background p-16 text-body-sm text-forest-deep">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-24 rounded-md border border-red-200 bg-red-50 p-16 text-body-sm text-red-700">
            <p class="font-semibold">Lưu cài đặt chưa thành công:</p>
            <ul class="mt-8 list-disc pl-20">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $groupLabels = [
            'general' => 'Thông tin website',
            'contact' => 'Liên hệ',
            'social' => 'Mạng xã hội',
            'home' => 'Trang chủ',
        ];

        $groupDescriptions = [
            'general' => 'Các thông tin chung của website.',
            'contact' => 'Thông tin liên hệ dùng ở nhiều khu vực trên trang.',
            'social' => 'Liên kết mạng xã hội và kênh liên hệ ngoài.',
            'home' => 'Nội dung hiển thị riêng cho các block trên trang chủ.',
        ];

        $fieldLabels = [
            'site_name' => 'Tên website',
            'site_description' => 'Mô tả website',
            'hotline' => 'Hotline',
            'email' => 'Email',
            'address' => 'Địa chỉ',
            'facebook_url' => 'Facebook URL',
            'instagram_url' => 'Instagram URL',
            'zalo_url' => 'Zalo URL',
            'working_hours' => 'Giờ làm việc',
            'booking_url' => 'Booking URL',
            'home_routes_badge' => 'Trang chủ - Badge tuyến đường',
            'home_routes_title_primary' => 'Trang chủ - Tiêu đề tuyến đường 1',
            'home_routes_title_highlight' => 'Trang chủ - Tiêu đề tuyến đường 2',
            'home_routes_cta' => 'Trang chủ - Nút tuyến đường',
            'home_routes_pickup_text' => 'Trang chủ - Dòng đón trả tuyến đường',
            'home_routes_review_title' => 'Trang chủ - Tiêu đề review tuyến đường',
            'home_routes_review_quote' => 'Trang chủ - Nội dung review tuyến đường',
            'home_routes_review_name' => 'Trang chủ - Tên khách review tuyến đường',
            'home_routes_review_role' => 'Trang chủ - Vai trò khách review tuyến đường',
            'home_routes_image' => 'Trang chủ - Ảnh tuyến đường',
            'home_schedules_badge' => 'Trang chủ - Badge lịch trình',
            'home_schedules_title' => 'Trang chủ - Tiêu đề lịch trình',
            'home_schedules_description' => 'Trang chủ - Mô tả lịch trình',
            'home_schedules_route_text' => 'Trang chủ - Tên tuyến lịch trình',
            'home_schedules_go_title' => 'Trang chủ - Tiêu đề chiều đi',
            'home_schedules_return_title' => 'Trang chủ - Tiêu đề chiều về',
            'home_schedules_image' => 'Trang chủ - Ảnh lịch trình',
            'home_why_badge' => 'Trang chủ - Badge trải nghiệm',
            'home_why_title' => 'Trang chủ - Tiêu đề trải nghiệm',
            'home_why_subtitle' => 'Trang chủ - Mô tả trải nghiệm',
            'home_why_card_1_title' => 'Trang chủ - Tiêu đề thẻ trải nghiệm 1',
            'home_why_card_1_image' => 'Trang chủ - Ảnh thẻ trải nghiệm 1',
            'home_why_card_2_title' => 'Trang chủ - Tiêu đề thẻ trải nghiệm 2',
            'home_why_card_2_image' => 'Trang chủ - Ảnh thẻ trải nghiệm 2',
            'home_why_card_3_title' => 'Trang chủ - Tiêu đề thẻ trải nghiệm 3',
            'home_why_card_3_image' => 'Trang chủ - Ảnh thẻ trải nghiệm 3',
            'home_news_badge' => 'Trang chủ - Badge tin tức',
            'home_news_title_primary' => 'Trang chủ - Tiêu đề tin tức 1',
            'home_news_title_highlight' => 'Trang chủ - Tiêu đề tin tức 2',
            'home_news_description' => 'Trang chủ - Mô tả tin tức',
            'home_cta_badge' => 'Trang chủ - Badge CTA',
            'home_cta_title_primary' => 'Trang chủ - Tiêu đề CTA 1',
            'home_cta_title_highlight' => 'Trang chủ - Tiêu đề CTA 2',
            'home_cta_description' => 'Trang chủ - Mô tả CTA',
            'home_cta_image' => 'Trang chủ - Ảnh CTA',
        ];

        $settingsByGroup = $settings->groupBy(fn ($setting) => $setting->group ?: 'general');

        $homeSections = [
            'routes' => [
                'label' => 'Block Tuyến Đường',
                'keys' => [
                    'home_routes_badge',
                    'home_routes_title_primary',
                    'home_routes_title_highlight',
                    'home_routes_cta',
                    'home_routes_pickup_text',
                    'home_routes_review_title',
                    'home_routes_review_quote',
                    'home_routes_review_name',
                    'home_routes_review_role',
                    'home_routes_image',
                ],
            ],
            'schedules' => [
                'label' => 'Block Lịch Trình',
                'keys' => [
                    'home_schedules_badge',
                    'home_schedules_title',
                    'home_schedules_description',
                    'home_schedules_route_text',
                    'home_schedules_go_title',
                    'home_schedules_return_title',
                    'home_schedules_image',
                ],
            ],
            'why' => [
                'label' => 'Block Trải Nghiệm',
                'keys' => [
                    'home_why_badge',
                    'home_why_title',
                    'home_why_subtitle',
                    'home_why_card_1_title',
                    'home_why_card_1_image',
                    'home_why_card_2_title',
                    'home_why_card_2_image',
                    'home_why_card_3_title',
                    'home_why_card_3_image',
                ],
            ],
            'news' => [
                'label' => 'Block Tin Tức',
                'keys' => [
                    'home_news_badge',
                    'home_news_title_primary',
                    'home_news_title_highlight',
                    'home_news_description',
                ],
            ],
            'cta' => [
                'label' => 'Block CTA / Liên Hệ',
                'keys' => [
                    'home_cta_badge',
                    'home_cta_title_primary',
                    'home_cta_title_highlight',
                    'home_cta_description',
                    'home_cta_image',
                ],
            ],
        ];

        $renderField = function ($setting, $index) use ($fieldLabels) {
            return view('admin.settings.partials.field', compact('setting', 'index', 'fieldLabels'))->render();
        };
    @endphp
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @php $index = 0; @endphp
        @foreach($settingsByGroup as $group => $groupSettings)
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <h3 class="text-heading font-semibold text-forest-deep mb-8">{{ $groupLabels[$group] ?? ucwords(str_replace('_', ' ', $group)) }}</h3>
                <p class="text-body-sm text-slate-text">{{ $groupDescriptions[$group] ?? '' }}</p>
            </div>

            @if($group === 'home')
                @foreach($homeSections as $section)
                    @php
                        $sectionSettings = $groupSettings->filter(fn ($item) => in_array($item->key, $section['keys'], true));
                    @endphp
                    @if($sectionSettings->isNotEmpty())
                    <div class="mb-32 rounded-lg border border-input-border p-20">
                        <h4 class="text-body font-semibold text-forest-deep mb-20">{{ $section['label'] }}</h4>
                        @foreach($section['keys'] as $key)
                            @php $setting = $sectionSettings->firstWhere('key', $key); @endphp
                            @if($setting)
                                {!! $renderField($setting, $index) !!}
                                @php $index++; @endphp
                            @endif
                        @endforeach
                    </div>
                    @endif
                @endforeach
            @else
                @foreach($groupSettings as $setting)
                    {!! $renderField($setting, $index) !!}
                    @php $index++; @endphp
                @endforeach
            @endif
        </div>
        @endforeach
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Lưu cài đặt</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
function previewSettingImage(event, index) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const currentImage = document.getElementById(`settingPreview${index}`);
        const emptyState = document.getElementById(`settingPreviewEmpty${index}`);

        if (currentImage) {
            currentImage.src = e.target.result;
            return;
        }

        if (emptyState) {
            emptyState.outerHTML = `<img id="settingPreview${index}" src="${e.target.result}" alt="preview" class="h-40 w-full rounded-md border border-input-border object-cover">`;
        }
    };

    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
