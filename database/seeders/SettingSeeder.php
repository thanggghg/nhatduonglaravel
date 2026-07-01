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
            ['key' => 'site_name', 'value' => 'Nhà Xe Nhật Dương', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Dịch vụ xe khách chất lượng cao, an toàn, tin cậy, tiện nghi', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'hotline', 'value' => '1900 2879', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'info@nhatduong.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'address', 'value' => '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/nhatduong', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/nhatduong', 'type' => 'text', 'group' => 'social'],
            ['key' => 'zalo_url', 'value' => 'https://zalo.me/1900 2879', 'type' => 'text', 'group' => 'social'],
            ['key' => 'working_hours', 'value' => '24/7 - Hỗ trợ khách hàng mọi lúc', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'booking_url', 'value' => 'https://example.com/book', 'type' => 'text', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
