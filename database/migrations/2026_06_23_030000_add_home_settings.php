<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $settings = [
            ['key' => 'home_routes_badge', 'value' => 'Tuyến đường cố định', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_title_primary', 'value' => 'Sài Gòn', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_title_highlight', 'value' => 'Nha Trang', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_cta', 'value' => 'Đặt vé ngay', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_pickup_text', 'value' => 'Đón trả tận nhiều điểm thuận tiện', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_review_title', 'value' => 'Đánh giá từ khách hàng', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_review_quote', 'value' => 'Xe sạch sẽ, chạy êm, nhân viên nhiệt tình. Sẽ tiếp tục ủng hộ Nhật Dương!', 'type' => 'textarea', 'group' => 'home'],
            ['key' => 'home_routes_review_name', 'value' => 'Nguyễn Minh Anh', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_review_role', 'value' => 'Khách hàng thường xuyên', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_routes_image', 'value' => '', 'type' => 'image', 'group' => 'home'],

            ['key' => 'home_schedules_badge', 'value' => '● KHỞI HÀNH TRONG NGÀY', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_schedules_title', 'value' => 'Lịch trình hôm nay', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_schedules_description', 'value' => 'Cập nhật liên tục các chuyến xe trong ngày, dễ dàng chọn giờ phù hợp với lịch trình của bạn.', 'type' => 'textarea', 'group' => 'home'],
            ['key' => 'home_schedules_route_text', 'value' => 'Sài Gòn ⇄ Nha Trang', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_schedules_go_title', 'value' => 'Sài Gòn → Nha Trang', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_schedules_return_title', 'value' => 'Nha Trang → Sài Gòn', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_schedules_image', 'value' => '', 'type' => 'image', 'group' => 'home'],

            ['key' => 'home_why_badge', 'value' => '⭐ TRẢI NGHIỆM KHÁC BIỆT CÙNG', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_why_title', 'value' => 'NHẬT DƯƠNG', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_why_subtitle', 'value' => 'Nâng tầm trải nghiệm di chuyển trên tuyến Sài Gòn → Nha Trang', 'type' => 'textarea', 'group' => 'home'],
            ['key' => 'home_why_card_1_title', 'value' => 'Xe phòng chuẩn 5 sao', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_why_card_1_image', 'value' => '', 'type' => 'image', 'group' => 'home'],
            ['key' => 'home_why_card_2_title', 'value' => 'Miễn phí đưa đón', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_why_card_2_image', 'value' => '', 'type' => 'image', 'group' => 'home'],
            ['key' => 'home_why_card_3_title', 'value' => 'Đáp ứng yêu cầu khách hàng', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_why_card_3_image', 'value' => '', 'type' => 'image', 'group' => 'home'],

            ['key' => 'home_news_badge', 'value' => 'Cập nhật mới nhất', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_news_title_primary', 'value' => 'Tin Tức &', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_news_title_highlight', 'value' => 'Khuyến Mãi', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_news_description', 'value' => 'Theo dõi ưu đãi, thông báo lịch chạy và những cập nhật quan trọng từ Nhà xe Nhật Dương theo cách trực quan và dễ đọc hơn.', 'type' => 'textarea', 'group' => 'home'],

            ['key' => 'home_cta_badge', 'value' => '⭐ DỊCH VỤ THUÊ XE HỢP ĐỒNG', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_cta_title_primary', 'value' => 'Cần thuê xe riêng', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_cta_title_highlight', 'value' => 'cho đoàn của bạn?', 'type' => 'text', 'group' => 'home'],
            ['key' => 'home_cta_description', 'value' => 'Nhật Dương cung cấp dịch vụ thuê xe trọn gói cho đoàn du lịch, công ty, trường học, sự kiện... với đội xe đời mới, tài xế chuyên nghiệp, cam kết an toàn - đúng giờ - giá tốt.', 'type' => 'textarea', 'group' => 'home'],
            ['key' => 'home_cta_image', 'value' => '', 'type' => 'image', 'group' => 'home'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
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
            'home_schedules_badge',
            'home_schedules_title',
            'home_schedules_description',
            'home_schedules_route_text',
            'home_schedules_go_title',
            'home_schedules_return_title',
            'home_schedules_image',
            'home_why_badge',
            'home_why_title',
            'home_why_subtitle',
            'home_why_card_1_title',
            'home_why_card_1_image',
            'home_why_card_2_title',
            'home_why_card_2_image',
            'home_why_card_3_title',
            'home_why_card_3_image',
            'home_news_badge',
            'home_news_title_primary',
            'home_news_title_highlight',
            'home_news_description',
            'home_cta_badge',
            'home_cta_title_primary',
            'home_cta_title_highlight',
            'home_cta_description',
            'home_cta_image',
        ])->delete();
    }
};
