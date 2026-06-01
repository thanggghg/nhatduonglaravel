<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Nhà Xe Nhật Dương'],
            ['key' => 'site_description', 'value' => 'Dịch vụ xe khách chất lượng cao, an toàn, tin cậy, tiện nghi'],
            ['key' => 'hotline', 'value' => '1900 2879'],
            ['key' => 'email', 'value' => 'info@nhatduong.com'],
            ['key' => 'address', 'value' => '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/nhatduong'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/nhatduong'],
            ['key' => 'zalo_url', 'value' => 'https://zalo.me/1900 2879'],
            ['key' => 'working_hours', 'value' => '24/7 - Hỗ trợ khách hàng mọi lúc'],
            ['key' => 'booking_url', 'value' => 'https://example.com/book'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
